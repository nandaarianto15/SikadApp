<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get statistics
        $totalUsers = User::count();
        $totalServices = Service::where('is_active', true)->count();
        $totalNews = News::where('is_published', true)->count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalServices', 'totalNews'));
    }
    
   // NEWS MANAGEMENT
    public function newsIndex()
    {
        $news = News::with('author')->orderBy('published_at', 'desc')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function newsCreate()
    {
        return view('admin.news.create');
    }

    public function newsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'required|string|max:100',
            'tag' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);
        
        try {
            $news = new News();
            $news->title = $request->title;
            $news->slug = Str::slug($request->title);
            $news->content = $request->content;
            $news->category = $request->category;
            $news->tag = $request->tag;
            
            if ($request->filled('published_at')) {
                $news->published_at = \Carbon\Carbon::parse($request->published_at);
            } else {
                $news->published_at = now();
            }
            
            $news->is_published = $request->has('is_published') ? true : false;
            $news->author_id = Auth::user()->id;
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('news', $imageName, 'public');
                $news->image = 'news/' . $imageName;
            }
            
            $news->save();
            
            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function newsEdit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function newsUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'required|string|max:100',
            'tag' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);
        
        try {
            $news = News::findOrFail($id);
            $news->title = $request->title;
            $news->slug = Str::slug($request->title);
            $news->content = $request->content;
            $news->category = $request->category;
            $news->tag = $request->tag;
            
            if ($request->filled('published_at')) {
                $news->published_at = \Carbon\Carbon::parse($request->published_at);
            }
            
            $news->is_published = $request->has('is_published') ? true : false;
            
            if ($request->hasFile('image')) {
                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('news', $imageName, 'public');
                $news->image = 'news/' . $imageName;
            }
            
            $news->save();
            
            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function newsDestroy($id)
    {
        $news = News::findOrFail($id);
        
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        
        $news->delete();
        
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus');
    }
    
    // SERVICE MANAGEMENT
    public function serviceIndex()
    {
        $services = Service::with('requirements')->orderBy('name')->paginate(10);
        return view('admin.services.index', compact('services'));
    }
    
    public function serviceCreate()
    {
        return view('admin.services.create');
    }
    
    public function serviceStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'icon' => 'nullable|string|max:100',
            'form_fields' => 'nullable|array',
            'form_fields.*.name' => 'required|string|max:255',
            'form_fields.*.label' => 'required|string|max:255',
            'form_fields.*.type' => 'required|string|in:text,number,email,date,textarea,select',
            'form_fields.*.is_required' => 'nullable|boolean',
            'form_fields.*.options' => 'nullable|array',
            'form_fields.*.placeholder' => 'nullable|string|max:255',
            'requirements' => 'required|array|min:1',
            'requirements.*.name' => 'required|string|max:255',
            'requirements.*.description' => 'nullable|string',
            'requirements.*.sort_order' => 'required|integer|min:1',
        ]);

        $sortOrders = collect($request->requirements)->pluck('sort_order');
        if ($sortOrders->count() !== $sortOrders->unique()->count()) {
            return back()
                ->withErrors(['requirements' => 'Nomor urutan persyaratan tidak boleh duplikat'])
                ->withInput();
        }

        $slug = Str::slug($request->name);
        $original = $slug;
        $i = 1;

        while (Service::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        $service = Service::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'icon' => $request->icon ?? 'file-text',
            'is_active' => $request->boolean('is_active'),
            'form_fields' => $request->form_fields,
        ]);

        foreach ($request->requirements as $req) {
            $service->requirements()->create([
                'name' => $req['name'],
                'description' => $req['description'] ?? null,
                'is_required' => isset($req['is_required']) ? 1 : 0,
                'sort_order' => $req['sort_order'],
            ]);
        }

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }
    
    public function serviceEdit($id)
    {
        $service = Service::with('requirements')->findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }
    
    public function serviceUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'form_fields' => 'nullable|array',
            'form_fields.*.name' => 'required|string|max:255',
            'form_fields.*.label' => 'required|string|max:255',
            'form_fields.*.type' => 'required|string|in:text,number,email,date,textarea,select',
            'form_fields.*.is_required' => 'nullable|boolean',
            'form_fields.*.options' => 'nullable|array',
            'form_fields.*.placeholder' => 'nullable|string|max:255',
            'requirements' => 'required|array|min:1',
            'requirements.*.name' => 'required|string|max:255',
            'requirements.*.description' => 'nullable|string',
            'requirements.*.is_required' => 'nullable|boolean',
            'requirements.*.sort_order' => 'required|integer|min:1',
        ]);

        try {
            $sortOrders = collect($request->requirements)->pluck('sort_order');
            if ($sortOrders->count() !== $sortOrders->unique()->count()) {
                return back()->with('error', 'Nomor urutan persyaratan tidak boleh duplikat!')->withInput();
            }
            
            $service = Service::findOrFail($id);
            $service->name = $request->name;
            
            $slug = Str::slug($request->name);
            $original = $slug;
            $i = 1;

            if ($slug !== $service->slug) {
                while (Service::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $original . '-' . $i++;
                }
                $service->slug = $slug;
            }
            
            $service->description = $request->description;
            $service->icon = $request->icon ?? 'file-text';
            $service->is_active = $request->boolean('is_active');
            $service->form_fields = $request->form_fields;
            $service->save();
            
            ServiceRequirement::where('service_id', $service->id)->delete();
            
            if ($request->has('requirements')) {
                foreach ($request->requirements as $req) {
                    $requirement = new ServiceRequirement();
                    $requirement->service_id = $service->id;
                    $requirement->name = $req['name'];
                    $requirement->description = $req['description'] ?? '';
                    $requirement->is_required = isset($req['is_required']) ? $req['is_required'] : true;
                    $requirement->sort_order = $req['sort_order'];
                    $requirement->save();
                }
            }
            
            return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function serviceDestroy($id)
    {
        $service = Service::findOrFail($id);
        
        ServiceRequirement::where('service_id', $service->id)->delete();
        
        $service->delete();
        
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus');
    }
}