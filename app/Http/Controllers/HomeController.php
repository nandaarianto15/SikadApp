<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function landing()
    {
        return view('landingpage');
    }

    public function landingNews()
    {
        $news = News::where('is_published', true)->orderByDesc('published_at')->limit(10)->get()->map(function ($item) {
                return [
                    'id'       => $item->id,
                    'title'    => $item->title,
                    'category' => $item->category,
                    'tag'      => $item->tag,
                    'date'     => optional($item->published_at)->format('d M Y'),
                    'image'    => $item->image
                        ? asset('storage/' . $item->image)
                        : 'https://via.placeholder.com/400x300',
                    'desc'     => str()->limit(strip_tags($item->content), 120),
                    'slug'     => $item->slug,
                ];
            });

        return response()->json($news);
    }

    public function landingServices()
    {
        $services = Service::where('is_active', true)->with(['requirements' => function ($q) {
                $q->orderBy('order');
            }])->orderBy('name')->get()->map(function ($service) {
                return [
                    'id'    => $service->id,
                    'name'  => $service->name,
                    'slug'  => $service->slug,
                    'desc'  => $service->description,
                    'icon'  => $service->icon ?? 'file-text',
                    'reqs'  => $service->requirements->map(fn ($r) => [
                        'name'        => $r->name,
                        'description' => $r->description,
                        'required'    => $r->is_required,
                    ]),
                ];
            });

        return response()->json($services);
    }

    public function auth()
    {
        return view('auth');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function select()
    {
        return view('select');
    }

    public function wizard()
    {
        return view('wizard');
    }

    public function tracking()
    {
        return view('tracking');
    }
}
