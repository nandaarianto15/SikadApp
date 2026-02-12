<?php

namespace App\Http\Controllers;

use App\Models\SubmissionDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function show(SubmissionDocument $document)
    {
        if ($document->submission->user_id !== Auth::id() && Auth::user()->role !== 'verifikator') {
            abort(403, 'Anda tidak berhak mengakses dokumen ini.');
        }

        $filePath = $document->file_path;
        
        if (!Storage::disk('private')->exists($filePath)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        $file = Storage::disk('private')->get($filePath);
        $mimeType = Storage::disk('private')->mimeType($filePath);

        return response($file, 200, [
            'Content-Type'          => $mimeType,
            'Content-Disposition'   => 'attachment; filename="' . $document->file_name . '"'
        ]);
    }

    public function view(SubmissionDocument $document)
    {
        if ($document->submission->user_id !== Auth::id() && Auth::user()->role !== 'verifikator') {
            abort(403, 'Anda tidak berhak mengakses dokumen ini.');
        }

        $path = $document->file_path;

        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        return response()->stream(function () use ($path) {
            echo Storage::disk('private')->get($path);
        }, 200, [
            'Content-Type'              => 'application/pdf',
            'Content-Disposition'       => 'inline; filename="'.$document->file_name.'"',
            'X-Content-Type-Options'    => 'nosniff',
        ]);
    }
}