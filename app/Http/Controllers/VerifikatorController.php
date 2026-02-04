<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionDocument;
use App\Models\SubmissionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:verifikator');
    }

    public function dashboard(Request $request)
    {
        $stats = [
            'menunggu' => Submission::where('status', 'process')->count(),
            'revisi' => Submission::where('status', 'revision')->count(),
            'ditolak' => Submission::where('status', 'rejected')->count(),
            'selesai' => Submission::where('status', 'signed')->count(),
        ];
        
        $submissionsQuery = Submission::with(['user', 'service']);
        
        $filter = $request->query('filter', 'all');
        if ($filter === 'menunggu') {
            $submissionsQuery->where('status', 'process');
        } elseif ($filter === 'revisi') {
            $submissionsQuery->where('status', 'revision');
        } elseif ($filter === 'ditolak') {
            $submissionsQuery->where('status', 'rejected');
        } elseif ($filter === 'selesai') {
            $submissionsQuery->where('status', 'signed');
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $submissionsQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $submissionsQuery->whereDate('created_at', '<=', $request->end_date);
        }
        
        $submissions = $submissionsQuery->latest()->paginate(10);
        
        return view('verifikator.dashboard', compact(
            'submissions', 
            'stats', 
            'filter'
        ));
    }
    
    public function filterSubmissions(Request $request)
    {
        $filter = $request->query('filter', 'all');
        
        $submissionsQuery = Submission::with(['user', 'service']);
        
        if ($filter === 'menunggu') {
            $submissionsQuery->where('status', 'process');
        } elseif ($filter === 'revisi') {
            $submissionsQuery->where('status', 'revision');
        } elseif ($filter === 'ditolak') {
            $submissionsQuery->where('status', 'rejected');
        } elseif ($filter === 'selesai') {
            $submissionsQuery->where('status', 'signed');
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $submissionsQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $submissionsQuery->whereDate('created_at', '<=', $request->end_date);
        }
        
        $submissions = $submissionsQuery->latest()->paginate(10);
        
        $html = view('verifikator.partials.submissions-table', compact('submissions'))->render();
        
        return response()->json([
            'html' => $html,
            'pagination' => $submissions->links()->toHtml()
        ]);
    }
    
    public function getSubmission(Submission $submission)
    {
        $submission->load(['user', 'service', 'documents.requirement']);
        
        return response()->json($submission);
    }
    
    public function tracking(Submission $submission)
    {
        $submission->load(['user', 'service.requirements', 'documents.requirement', 'histories.user']);
        
        return view('tracking', compact('submission'));
    }
    
    public function verify(Submission $submission)
    {
        if (!$submission) {
            abort(404);
        }
        
        $submission->load(['user', 'service.requirements', 'documents.requirement', 'histories.user']);
        
        return view('verifikator.verify', compact('submission'));
    }
    
    public function updateStatus(Request $request, Submission $submission)
    {
        $request->validate([
            'status' => 'required|in:process,revision,rejected,signed',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $oldStatus = $submission->status;
        $submission->status = $request->status;
        
        if ($request->status === 'signed') {
            $submission->signed_at = now();
            $submission->signed_by = Auth::id();
            $submission->nomor_surat = $this->generateNomorSurat($submission);
        }
        
        if ($request->status === 'rejected') {
            $request->validate(['rejection_reason' => 'required|string|max:500']);
            $submission->rejection_reason = $request->rejection_reason;
            $submission->rejected_at = now();
            $submission->rejected_by = Auth::id();
        }
        
        $submission->save();
        
        SubmissionHistory::create([
            'submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'status_from' => $oldStatus,
            'status_to' => $request->status,
            'notes' => $request->status === 'rejected' 
                ? "Pengajuan ditolak: " . $request->rejection_reason 
                : $request->notes,
        ]);
        
        return redirect()->route('verifikator.dashboard')
            ->with('success', 'Status pengajuan berhasil diperbarui!');
    }
    
    public function updateDocumentStatus(Request $request, SubmissionDocument $document)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string|max:255',
        ]);
        
        if ($document->submission->user_id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat memverifikasi dokumen Anda sendiri.'
            ], 403);
        }
        
        $document->status = $request->status;
        $document->notes = $request->notes;
        $document->verified_by = Auth::id();
        $document->verified_at = now();
        $document->save();
        
        $submission = $document->submission;
        $allDocumentsVerified = $submission->documents()->whereNotNull('verified_at')->count() === $submission->documents()->count();
        
        if ($allDocumentsVerified) {
            $hasRejectedDocuments = $submission->documents()->where('status', 'rejected')->count() > 0;
            
            if ($hasRejectedDocuments) {
                $submission->status = 'revision';
                SubmissionHistory::create([
                    'submission_id' => $submission->id,
                    'user_id' => Auth::id(),
                    'status_from' => $submission->getOriginal('status'),
                    'status_to' => 'revision',
                    'notes' => 'Beberapa dokumen perlu diperbaiki berdasarkan verifikasi per-dokumen.',
                ]);
            } else {
                if ($submission->status === 'draft') {
                    $submission->status = 'process';
                    SubmissionHistory::create([
                        'submission_id' => $submission->id,
                        'user_id' => Auth::id(),
                        'status_from' => 'draft',
                        'status_to' => 'process',
                        'notes' => 'Semua dokumen telah diverifikasi dan disetujui.',
                    ]);
                }
            }
            
            $submission->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Status dokumen berhasil diperbarui.',
            'document_status' => $document->status,
            'submission_status' => $submission->status,
        ]);
    }
    
    public function rejectSubmission(Request $request, Submission $submission)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        $oldStatus = $submission->status;
        
        $submission->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now(),
            'rejected_by' => Auth::id(),
        ]);
        
        SubmissionHistory::create([
            'submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'status_from' => $oldStatus,
            'status_to' => 'rejected',
            'notes' => "Pengajuan ditolak: " . $request->rejection_reason,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Pengajuan berhasil ditolak.',
        ]);
    }
    
    public function submissions(Request $request)
    {
        $filter = $request->query('filter', 'all');
        
        $stats = [
            'menunggu' => Submission::where('status', 'process')->count(),
            'revisi' => Submission::where('status', 'revision')->count(),
            'ditolak' => Submission::where('status', 'rejected')->count(),
            'selesai' => Submission::where('status', 'signed')->count(),
        ];
        
        $submissionsQuery = Submission::with(['user', 'service']);
        
        if ($filter === 'menunggu') {
            $submissionsQuery->where('status', 'process');
        } elseif ($filter === 'revisi') {
            $submissionsQuery->where('status', 'revision');
        } elseif ($filter === 'ditolak') {
            $submissionsQuery->where('status', 'rejected');
        } elseif ($filter === 'selesai') {
            $submissionsQuery->where('status', 'signed');
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $submissionsQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $submissionsQuery->whereDate('created_at', '<=', $request->end_date);
        }
        
        $submissions = $submissionsQuery->latest()->paginate(20);
        
        return view('verifikator.submissions', compact('submissions', 'filter', 'stats'));
    }
    
    private function generateNomorSurat($submission)
    {
        $year = date('Y');
        $serviceCode = strtoupper(substr($submission->service->slug, 0, 3));
        $count = Submission::where('status', 'signed')
            ->whereYear('created_at', $year)
            ->count() + 1;
            
        return "800/{$serviceCode}/{$year}/{$count}";
    }
}