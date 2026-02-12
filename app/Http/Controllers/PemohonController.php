<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Service;
use App\Models\SubmissionDocument;
use App\Models\SubmissionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PemohonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:pemohon');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        $submissionsQuery = $user->submissions()->with('service');
        
        $filter = $request->query('filter', 'all');
        if ($filter === 'process') {
            $submissionsQuery->where('status', 'process');
        } elseif ($filter === 'revision') {
            $submissionsQuery->where('status', 'revision');
        } elseif ($filter === 'rejected') {
            $submissionsQuery->where('status', 'rejected');
        } elseif ($filter === 'signed') {
            $submissionsQuery->where('status', 'signed');
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $submissionsQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $submissionsQuery->whereDate('created_at', '<=', $request->end_date);
        }
        
        $submissions = $submissionsQuery->latest()->paginate(10);
        
        $allSubmissions = $user->submissions()->get();
        $stats = [
            'process'   => $allSubmissions->where('status', 'process')->count(),
            'revision'  => $allSubmissions->where('status', 'revision')->count(),
            'rejected'  => $allSubmissions->where('status', 'rejected')->count(),
            'signed'    => $allSubmissions->where('status', 'signed')->count(),
        ];

        return view('dashboard', compact('stats', 'submissions', 'filter'));
    }
    
    public function filterSubmissions(Request $request)
    {
        $user   = Auth::user();
        $filter = $request->query('filter', 'all');
        
        $submissionsQuery = $user->submissions()->with('service');
        
        if ($filter === 'process') {
            $submissionsQuery->where('status', 'process');
        } elseif ($filter === 'revision') {
            $submissionsQuery->where('status', 'revision');
        } elseif ($filter === 'rejected') {
            $submissionsQuery->where('status', 'rejected');
        } elseif ($filter === 'signed') {
            $submissionsQuery->where('status', 'signed');
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $submissionsQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $submissionsQuery->whereDate('created_at', '<=', $request->end_date);
        }
        
        $submissions = $submissionsQuery->latest()->paginate(10);
        
        $html = view('submissions-table', compact('submissions'))->render();
        
        return response()->json([
            'html'          => $html,
            'pagination'    => $submissions->links()->toHtml()
        ]);
    }

    public function select()
    {
        return view('select');
    }

    public function wizard(Request $request)
    {
        $serviceSlug    = $request->query('service');
        $service        = Service::where('slug', $serviceSlug)->where('is_active', true)->firstOrFail();
        
        return view('wizard', compact('service'));
    }

    public function tracking($tracking_id)
    {
        $submission = Submission::where('tracking_id', $tracking_id)->firstOrFail();
        
        if ($submission->user_id !== Auth::id()) {
            abort(403);
        }

        $submission->load(['user', 'service.requirements', 'documents.requirement', 'histories.user']);
        
        return view('tracking', compact('submission'));
    }

    public function store(Request $request)
    {
        $service = Service::findOrFail($request->service_id);

        $rules = [
            'service_id'    => 'required|exists:services,id',
            'perihal'       => 'required|string|max:255',
            'tujuan'        => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'isi_ringkas'   => 'nullable|string',
            'documents'     => 'required|array',
            'documents.*'   => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
        ];

        if ($service->form_fields) {
            foreach ($service->form_fields as $field) {
                $fieldName = 'form_data.' . $field['name'];
                $rule = 'nullable';
                if ($field['is_required']) {
                    $rule = 'required';
                }
                switch ($field['type']) {
                    case 'email':
                        $rule .= '|email';
                        break;
                    case 'date':
                        $rule .= '|date';
                        break;
                    case 'number':
                        $rule .= '|numeric';
                        break;
                }
                $rules[$fieldName] = $rule;
            }
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            $submission = Submission::create([
                'tracking_id'   => 'REG-' . strtoupper(Str::random(8)),
                'user_id'       => Auth::id(),
                'service_id'    => $request->service_id,
                'perihal'       => $request->perihal,
                'tujuan'        => $request->tujuan,
                'tanggal_surat' => $request->tanggal_surat,
                'isi_ringkas'   => $request->isi_ringkas,
                'form_data'     => $request->input('form_data'),
                'status'        => 'process',
            ]);

            foreach ($request->file('documents') as $requirementId => $file) {
                $path = $file->store('submissions/' . $submission->id, 'private');
                
                SubmissionDocument::create([
                    'submission_id'             => $submission->id,
                    'service_requirement_id'    => $requirementId,
                    'file_path'                 => $path,
                    'file_name'                 => $file->getClientOriginalName(),
                    'file_size'                 => $file->getSize(),
                    'status'                    => 'pending',
                ]);
            }

            SubmissionHistory::create([
                'submission_id' => $submission->id,
                'user_id'       => Auth::id(),
                'status_from'   => null,
                'status_to'     => 'process',
                'notes'         => 'Pengajuan berhasil dibuat.'
            ]);

            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Pengajuan berhasil dibuat!',
                'tracking_id'   => $submission->tracking_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function updateSubmission(Request $request, Submission $submission)
    {
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }
        
        if (!in_array($submission->status, ['revision', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya dapat mengedit pengajuan yang sedang dalam status revisi atau ditolak.'
            ], 403);
        }
        
        $service = $submission->service;

        $rules = [
            'perihal'       => 'required|string|max:255',
            'tujuan'        => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'isi_ringkas'   => 'nullable|string',
            'documents'     => 'array',
            'documents.*'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ];

        if ($service->form_fields) {
            foreach ($service->form_fields as $field) {
                $fieldName = 'form_data.' . $field['name'];
                $rule = 'nullable';
                if ($field['is_required']) {
                    $rule = 'required';
                }
                switch ($field['type']) {
                    case 'email':
                        $rule .= '|email';
                        break;
                    case 'date':
                        $rule .= '|date';
                        break;
                    case 'number':
                        $rule .= '|numeric';
                        break;
                }
                $rules[$fieldName] = $rule;
            }
        }

        $request->validate($rules);

        $requiredRequirements = $submission->service->requirements()->where('is_required', true)->get();
        foreach ($requiredRequirements as $req) {
            $requirementId  = $req->id;
            
            $hasNewFile     = $request->hasFile("documents.$requirementId");
            $existingDoc    = $submission->documents()->where('service_requirement_id', $requirementId)->first();
            
            if (!$hasNewFile && !$existingDoc) {
                throw ValidationException::withMessages([
                    "documents.$requirementId" => "Dokumen '{$req->name}' wajib diunggah."
                ]);
            }
            
            if ($existingDoc && $existingDoc->status === 'rejected' && !$hasNewFile) {
                throw ValidationException::withMessages([
                    "documents.$requirementId" => "Dokumen '{$req->name}' yang ditolak wajib diunggah ulang."
                ]);
            }
        }

        try {
            DB::beginTransaction();

            $submission->update([
                'perihal'                   => $request->perihal,
                'tujuan'                    => $request->tujuan,
                'tanggal_surat'             => $request->tanggal_surat,
                'isi_ringkas'               => $request->isi_ringkas,
                'form_data'                 => $request->input('form_data'),
                'document_status'           => 'pending',
                'document_rejection_reason' => null,
                'document_verified_by'      => null,
                'document_verified_at'      => null,
            ]);

            foreach ($submission->service->requirements->sortBy('order') as $req) {
                $requirementId = $req->id;
                
                if ($request->hasFile("documents.$requirementId")) {
                    $file = $request->file("documents.$requirementId");
                    
                    $existingDoc = $submission->documents()->where('service_requirement_id', $requirementId)->first();
                    
                    if ($existingDoc) {
                        Storage::disk('private')->delete($existingDoc->file_path);
                        
                        $path = $file->store('submissions/' . $submission->id, 'private');
                        
                        $existingDoc->update([
                            'file_path'     => $path,
                            'file_name'     => $file->getClientOriginalName(),
                            'file_size'     => $file->getSize(),
                            'status'        => 'pending',
                            'notes'         => null,
                            'verified_by'   => null,
                            'verified_at'   => null,
                        ]);
                    } else {
                        $path = $file->store('submissions/' . $submission->id, 'private');
                        
                        SubmissionDocument::create([
                            'submission_id'             => $submission->id,
                            'service_requirement_id'    => $requirementId,
                            'file_path'                 => $path,
                            'file_name'                 => $file->getClientOriginalName(),
                            'file_size'                 => $file->getSize(),
                            'status'                    => 'pending',
                        ]);
                    }
                }
            }

            $submission->update(['status' => 'process']);

            SubmissionHistory::create([
                'submission_id' => $submission->id,
                'user_id'       => Auth::id(),
                'status_from'   => $submission->getOriginal('status'),
                'status_to'     => 'process',
                'notes'         => 'Dokumen revisi telah dikirim ulang untuk diverifikasi kembali.'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Revisi berhasil dikirim! Pengajuan Anda kembali dalam proses verifikasi.'
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'   => 'Terjadi kesalahan validasi.',
                'errors'    => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Revision submission error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server. Silakan coba lagi nanti.'
            ], 500);
        }
    }
}