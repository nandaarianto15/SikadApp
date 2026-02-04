@extends('layouts.dashboard')

@section('title', 'Status Pengajuan')

@push('styles')
<style>
    #document-frame {
        background-color: #525659;
    }
    
    .doc-status-pending {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
    
    .doc-status-approved {
        background-color: #d1fae5;
        border-color: #10b981;
    }
    
    .doc-status-rejected {
        background-color: #fee2e2;
        border-color: #ef4444;
    }
    
    .revision-doc-approved {
        border-color: #10b981 !important;
        background-color: #f0fdf4 !important;
    }
    
    .revision-doc-rejected {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }
    
    /* Style tambahan untuk form revisi */
    .revision-form-container {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .revision-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    
    .revision-section:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .revision-section-header {
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .revision-section-body {
        padding: 20px;
    }
    
    .file-upload-item {
        border: 1px dashed #d1d5db;
        border-radius: 12px;
        padding: 16px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .file-upload-item:hover {
        border-color: #00A651;
        background-color: #f0fdf4;
    }
    
    .file-upload-item.approved {
        border-color: #10b981;
        background-color: #f0fdf4;
    }
    
    .file-upload-item.rejected {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    
    .file-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 500;
        margin-top: 4px; /* Dikurangi dari 8px menjadi 4px */
    }
    
    .file-status-badge.approved {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .file-status-badge.rejected {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .file-status-badge.pending {
        background-color: #f3f4f6;
        color: #4b5563;
    }
    
    .file-upload-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .file-upload-button.primary {
        background-color: #00A651;
        color: white;
    }
    
    .file-upload-button.primary:hover {
        background-color: #047857;
    }
    
    .file-upload-button.secondary {
        background-color: white;
        color: #4b5563;
        border: 1px solid #d1d5db;
    }
    
    .file-upload-button.secondary:hover {
        background-color: #f9fafb;
        border-color: #9ca3af;
    }
    
    .file-upload-button.danger {
        background-color: #ef4444;
        color: white;
    }
    
    .file-upload-button.danger:hover {
        background-color: #dc2626;
    }
    
    .file-upload-button.info {
        background-color: #3b82f6;
        color: white;
    }
    
    .file-upload-button.info:hover {
        background-color: #2563eb;
    }
    
    .file-upload-button.warning {
        background-color: #f59e0b;
        color: white;
    }
    
    .file-upload-button.warning:hover {
        background-color: #d97706;
    }
    
    .form-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #00A651;
        box-shadow: 0 0 0 3px rgba(0, 166, 81, 0.1);
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .file-info {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
    
    .file-preview {
        margin-top: 8px;
        padding: 8px;
        border-radius: 6px;
        font-size: 12px;
        color: #374151;
        display: none;
    }
    
    .file-preview.active {
        display: block;
        background-color: #f9fafb;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }
    
    .btn {
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-primary {
        background-color: #00A651;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #047857;
    }
    
    .btn-primary:disabled {
        background-color: #9ca3af;
        cursor: not-allowed;
    }
    
    .btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }
    
    .btn-secondary:hover {
        background-color: #d1d5db;
    }
    
    .required-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 6px;
        background-color: #fee2e2;
        color: #991b1b;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        margin-left: 6px;
    }
    
    .optional-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 6px;
        background-color: #f3f4f6;
        color: #4b5563;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        margin-left: 6px;
    }
    
    .alert-box {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .alert-warning {
        background-color: #fef3c7;
        border: 1px solid #f59e0b;
        color: #92400e;
    }
    
    .alert-info {
        background-color: #dbeafe;
        border: 1px solid #3b82f6;
        color: #1e40af;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        border: 1px solid #ef4444;
        color: #991b1b;
    }
    
    /* Style tambahan untuk validasi */
    .disabled-option {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .submit-disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    /* Style untuk tombol edit */
    .verification-actions {
        display: flex;
        gap: 2px;
        flex-direction: column;
    }
    
    .verification-buttons {
        display: flex;
        gap: 2px;
        justify-content: flex-end; /* PERUBAHAN: Menambahkan justify-content untuk memindahkan tombol ke kanan */
        margin-top: 8px; /* PERUBAHAN: Menambahkan margin atas */
    }
    
    .edit-verification-btn {
        margin-top: 2px;
    }
    
    /* Style untuk form reject yang diperlukan */
    .reject-required {
        border-color: #ef4444 !important;
    }
    
    .reject-required-error {
        color: #ef4444;
        font-size: 11px;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 2px;
    }
    
    /* Style untuk menyelaraskan grid */
    .grid-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    @media (min-width: 1024px) {
        .grid-container {
            grid-template-columns: 2fr 1fr;
        }
    }
    
    .grid-item {
        display: flex;
        flex-direction: column;
    }
    
    /* PERUBAHAN: Style untuk tombol verifikasi yang lebih kecil */
    .verify-btn {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        min-width: 50px;
    }
    
    .verify-btn.approve {
        background-color: #00A651; /* PERUBAHAN: Mengubah warna menjadi #00A651 */
        color: white;
    }
    
    .verify-btn.approve:hover {
        background-color: #047857; /* PERUBAHAN: Mengubah warna hover menjadi #047857 */
    }
    
    .verify-btn.reject {
        background-color: #ef4444;
        color: white;
    }
    
    .verify-btn.reject:hover {
        background-color: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="flex flex-col h-screen bg-[#F3F4F6] font-sans">
    <div class="bg-white border-b px-4 lg:px-6 py-4 flex items-center gap-4 shadow-sm sticky top-0 z-40 shrink-0">
        @if(Auth::user()->role === 'pemohon')
            <a href="{{ route('pemohon.dashboard') }}" class="hover:bg-gray-100 p-2 rounded-full transition-colors"><i data-lucide="chevron-left" size="24" class="text-gray-500"></i></a>
        @else
            <a href="{{ route('verifikator.dashboard') }}" class="hover:bg-gray-100 p-2 rounded-full transition-colors"><i data-lucide="chevron-left" size="24" class="text-gray-500"></i></a>
        @endif
        <div>
            <h1 class="font-bold text-lg text-gray-800">Status Pengajuan</h1>
            <p id="tracking-id" class="text-xs text-gray-500 font-mono mt-0.5">ID: {{ $submission->tracking_id }}</p>
        </div>
    </div>
    
    <div class="flex-1 overflow-y-auto p-4 md:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Status Messages - Full Width -->
            <div id="tracking-status-message" class="mb-6 animate-[slideUp_0.6s_ease-out]">
                @if($submission->status === 'revision')
                    <div class="bg-red-50 border border-red-100 rounded-2xl p-6 flex flex-col sm:flex-row gap-4 shadow-sm animate-fade-in">
                        <div class="bg-red-100 p-3 rounded-full w-fit h-fit text-red-600"><i data-lucide="alert-circle" size="24"></i></div>
                        <div>
                            <h4 class="font-bold text-red-700 text-lg">Dokumen Perlu Revisi</h4>
                            <p class="text-sm text-red-600 mt-1 leading-relaxed">Verifikator telah memeriksa dokumen dan menemukan ketidaksesuaian.</p>
                            @if($submission->histories->where('status_to', 'revision')->last()->notes)
                                <p class="text-sm text-red-600 mt-2 p-2 bg-white rounded border border-red-200">Catatan: {{ $submission->histories->where('status_to', 'revision')->last()->notes }}</p>
                            @endif
                            @if(Auth::user()->role === 'pemohon')
                                <button onclick="toggleRevisionForm()" class="mt-4 bg-red-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition-all">Perbaiki Dokumen</button>
                            @endif
                        </div>
                    </div>
                @elseif($submission->status === 'rejected')
                    <div class="bg-red-50 border border-red-100 rounded-2xl p-6 flex flex-col sm:flex-row gap-4 shadow-sm animate-fade-in">
                        <div class="bg-red-100 p-3 rounded-full w-fit h-fit text-red-600"><i data-lucide="x-circle" size="24"></i></div>
                        <div>
                            <h4 class="font-bold text-red-700 text-lg">Pengajuan Ditolak</h4>
                            <p class="text-sm text-red-600 mt-1 leading-relaxed">Verifikator telah menolak pengajuan ini.</p>
                            @if($submission->rejection_reason)
                                <div class="mt-3 p-3 bg-white rounded border border-red-200">
                                    <p class="text-sm font-medium text-red-700">Alasan Penolakan:</p>
                                    <p class="text-sm text-red-600 mt-1">{{ $submission->rejection_reason }}</p>
                                    <p class="text-xs text-red-500 mt-2">Ditolak pada: {{ $submission->rejected_at->format('d M Y, H:i') }} oleh {{ $submission->rejector->name }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif($submission->status === 'signed')
                    <div class="bg-green-50 border border-green-100 rounded-2xl p-6 flex flex-col sm:flex-row gap-4 shadow-sm animate-fade-in">
                        <div class="bg-green-100 p-3 rounded-full w-fit h-fit text-green-600"><i data-lucide="check-circle" size="24"></i></div>
                        <div>
                            <h4 class="font-bold text-green-700 text-lg">Dokumen Telah Terbit</h4>
                            <p class="text-sm text-green-600 mt-1">Dokumen telah ditandatangani secara elektronik (BSrE).</p>
                            <button onclick="downloadDocumentAsPDF()" class="mt-4 flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-green-700 transition-all"><i data-lucide="download" size="16"></i> Unduh PDF</button>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Grid for Document Preview and Sidebar -->
            <div class="grid-container">
                <div class="grid-item space-y-6 animate-[slideUp_0.6s_ease-out]">
                    <!-- Document Revision Form (Hanya muncul saat status revisi dan role pemohon) -->
                    @if($submission->status === 'revision' && Auth::user()->role === 'pemohon')
                    <div id="revision-form" class="revision-form-container p-6 hidden">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-xl text-gray-800 flex items-center gap-3">
                                <i data-lucide="file-edit" size="24" class="text-[#00A651]"></i> 
                                Perbaiki Data Naskah
                            </h3>
                            <button onclick="toggleRevisionForm()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                <i data-lucide="x" size="20" class="text-gray-500"></i>
                            </button>
                        </div>
                        
                        <form id="revision-form-submit" action="{{ route('pemohon.updateSubmission', $submission) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-6">
                                <div class="alert-box alert-info">
                                    <div class="flex items-start gap-3">
                                        <i data-lucide="info" size="20" class="text-blue-600 mt-0.5"></i>
                                        <div>
                                            <p class="font-medium text-blue-900">Informasi Revisi</p>
                                            <p class="text-sm text-blue-800 mt-1">Hanya dokumen yang ditandai "Perlu Revisi" yang perlu Anda unggah kembali. Dokumen yang sudah disetujui tidak perlu diubah.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Form Utama -->
                                <div class="revision-section">
                                    <div class="revision-section-header">
                                        <i data-lucide="file-text" size="20" class="text-[#00A651]"></i>
                                        <h4 class="font-medium text-gray-800">Data Utama Naskah</h4>
                                    </div>
                                    <div class="revision-section-body">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="col-span-2">
                                                <label class="form-label" for="revision-perihal">Perihal / Judul <span class="text-red-500">*</span></label>
                                                <input type="text" name="perihal" id="revision-perihal" class="form-input" placeholder="Contoh: Permohonan Izin..." value="{{ $submission->perihal }}" required>
                                            </div>
                                            <div>
                                                <label class="form-label" for="revision-tujuan">Tujuan Surat</label>
                                                <input type="text" name="tujuan" id="revision-tujuan" class="form-input" placeholder="Kepada Yth..." value="{{ $submission->tujuan }}">
                                            </div>
                                            <div>
                                                <label class="form-label" for="revision-tanggal_surat">Tanggal Surat</label>
                                                <input type="text" name="tanggal_surat" id="revision-tanggal_surat" class="form-input" placeholder="dd/mm/yyyy" value="{{ $submission->tanggal_surat ? $submission->tanggal_surat->format('d/m/Y') : '' }}">
                                            </div>
                                            <div class="col-span-2">
                                                <label class="form-label" for="revision-isi_ringkas">Isi Ringkas</label>
                                                <textarea name="isi_ringkas" id="revision-isi_ringkas" class="form-input form-textarea" placeholder="Jelaskan isi surat secara singkat...">{{ $submission->isi_ringkas }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PERUBAHAN: Tambahkan Form Fields Dinamis untuk Revisi -->
                                @if($submission->service->form_fields)
                                <div class="revision-section">
                                    <div class="revision-section-header">
                                        <i data-lucide="edit-3" size="20" class="text-[#00A651]"></i>
                                        <h4 class="font-medium text-gray-800">Data Formulir</h4>
                                    </div>
                                    <div class="revision-section-body">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            @foreach($submission->service->form_fields as $field)
                                                <div class="@if($field['type'] === 'textarea') col-span-2 @endif group">
                                                    <label for="revision-form-{{ $field['name'] }}" class="form-label">
                                                        {{ $field['label'] }}
                                                        @if($field['is_required']) <span class="text-red-500">*</span> @endif
                                                    </label>
                                                    @switch($field['type'])
                                                        @case('text')
                                                            <input type="text" id="revision-form-{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="form-input" placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ $submission->form_data[$field['name']] ?? '' }}" @if($field['is_required']) required @endif>
                                                            @break
                                                        @case('number')
                                                            <input type="number" id="revision-form-{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="form-input" placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ $submission->form_data[$field['name']] ?? '' }}" @if($field['is_required']) required @endif>
                                                            @break
                                                        @case('email')
                                                            <input type="email" id="revision-form-{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="form-input" placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ $submission->form_data[$field['name']] ?? '' }}" @if($field['is_required']) required @endif>
                                                            @break
                                                        @case('date')
                                                            <input type="date" id="revision-form-{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="form-input" value="{{ $submission->form_data[$field['name']] ?? '' }}" @if($field['is_required']) required @endif>
                                                            @break
                                                        @case('textarea')
                                                            <textarea id="revision-form-{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="form-input form-textarea" placeholder="{{ $field['placeholder'] ?? '' }}" @if($field['is_required']) required @endif>{{ $submission->form_data[$field['name']] ?? '' }}</textarea>
                                                            @break
                                                        @case('select')
                                                            <select id="revision-form-{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="form-input" @if($field['is_required']) required @endif>
                                                                <option value="" disabled>-- Pilih {{ $field['label'] }} --</option>
                                                                @if(isset($field['options']) && is_array($field['options']))
                                                                    @foreach($field['options'] as $option)
                                                                        <option value="{{ $option }}" {{ ($submission->form_data[$field['name']] ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @break
                                                    @endswitch
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Dynamic Requirements -->
                                <div class="revision-section">
                                    <div class="revision-section-header">
                                        <i data-lucide="upload-cloud" size="20" class="text-[#00A651]"></i>
                                        <h4 class="font-medium text-gray-800">Upload Persyaratan</h4>
                                    </div>
                                    <div class="revision-section-body">
                                        <div id="revision-reqs-container" class="space-y-4">
                                            @foreach($submission->service->requirements->sortBy('order') as $req)
                                            @php
                                                $existingDoc = $submission->documents->where('service_requirement_id', $req->id)->first();
                                            @endphp
                                            <div class="file-upload-item 
                                                @if($existingDoc && $existingDoc->status === 'approved') approved
                                                @elseif($existingDoc && $existingDoc->status === 'rejected') rejected
                                                @endif" data-req-id="{{ $req->id }}" data-doc-status="{{ $existingDoc ? $existingDoc->status : 'none' }}">
                                                <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                                                    <div class="flex-shrink-0 w-10 h-10 bg-white rounded-full border border-gray-200 flex items-center justify-center text-gray-400">
                                                        <i data-lucide="file" size="18"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2">
                                                            <p class="font-medium text-gray-800">{{ $req->name }}</p>
                                                            @if($req->is_required)
                                                                <span class="required-badge">Wajib</span>
                                                            @else
                                                                <span class="optional-badge">Opsional</span>
                                                            @endif
                                                        </div>
                                                        <p class="file-info">{{ $req->description ?? 'PDF Max 5MB' }}</p>
                                                        
                                                        @if($existingDoc)
                                                            <div class="mt-3">
                                                                @if($existingDoc->status === 'approved')
                                                                    <div class="file-status-badge approved">
                                                                        <i data-lucide="check-circle" size="12"></i>
                                                                        Disetujui
                                                                    </div>
                                                                    <p class="file-info mt-1">File: {{ $existingDoc->file_name }}</p>
                                                                @elseif($existingDoc->status === 'rejected')
                                                                    <div class="file-status-badge rejected">
                                                                        <i data-lucide="x-circle" size="12"></i>
                                                                        Perlu Revisi
                                                                    </div>
                                                                    <p class="file-info mt-1">File: {{ $existingDoc->file_name }}</p>
                                                                    @if($existingDoc->notes)
                                                                        <div class="mt-2 p-2 bg-red-50 rounded text-xs text-red-700 border border-red-100">
                                                                            <strong>Catatan:</strong> {{ $existingDoc->notes }}
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    <div class="file-status-badge pending">
                                                                        <i data-lucide="clock" size="12"></i>
                                                                        Menunggu Verifikasi
                                                                    </div>
                                                                    <p class="file-info mt-1">File: {{ $existingDoc->file_name }}</p>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        
                                                        <div id="revision-preview-{{ $req->id }}" class="file-preview"></div>
                                                    </div>
                                                    
                                                    <div class="flex-shrink-0 mt-2 sm:mt-0">
                                                        @if(!$existingDoc || $existingDoc->status === 'rejected')
                                                            <label class="file-upload-button @if($existingDoc && $existingDoc->status === 'rejected') danger @else primary @endif">
                                                                @if($existingDoc && $existingDoc->status === 'rejected')
                                                                    <i data-lucide="refresh-cw" size="16"></i>
                                                                    Ganti File
                                                                @else
                                                                    <i data-lucide="upload" size="16"></i>
                                                                    Pilih File
                                                                @endif
                                                                <input type="file" name="documents[{{ $req->id }}]" class="hidden" accept=".pdf" data-required="{{ $req->is_required ? 'true' : 'false' }}" @if($existingDoc && $existingDoc->status === 'rejected') required @endif onchange="handleRevisionFileUpload(event, {{ $req->id }})">
                                                            </label>
                                                        @else
                                                            <a href="javascript:void(0);" onclick="openDocumentModal({{ $existingDoc->id }}, '{{ $existingDoc->file_name }}')" class="file-upload-button info">
                                                                <i data-lucide="eye" size="16"></i>
                                                                Lihat
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" id="submit-revision-btn" class="btn btn-primary flex-1" disabled>
                                        <i data-lucide="send" size="16"></i>
                                        Kirim Revisi
                                    </button>
                                    <button type="button" onclick="toggleRevisionForm()" class="btn btn-secondary flex-1">
                                        <i data-lucide="x" size="16"></i>
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                    
                    <!-- Document Preview -->
                    <div class="bg-gray-500/5 rounded-2xl p-2 border border-black/5 overflow-x-auto">
                        <div id="document-preview" class="bg-white rounded-xl shadow-lg w-full flex flex-col items-center p-8 md:p-12 relative overflow-hidden">
                            <div class="w-full text-[12px] leading-relaxed relative font-serif text-gray-800">
                                <div class="text-center font-bold border-b-4 double-border border-black pb-4 mb-8">
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-2">
                                        <div class="w-14 h-16 bg-yellow-400/20 grayscale opacity-50 flex items-center justify-center border border-black/20 text-[8px] shrink-0">LOGO</div>
                                        <div>
                                            <div class="text-lg tracking-widest">PEMERINTAH PROVINSI KALIMANTAN TIMUR</div>
                                            <div class="text-xl sm:text-2xl tracking-wide">DINAS KOMUNIKASI DAN INFORMATIKA</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-8 overflow-x-auto">
                                    <table class="w-full min-w-[300px]">
                                        <tbody>
                                            <tr><td class="w-20 align-top">Nomor</td><td id="preview-nomor" class="align-top">: {{ $submission->nomor_surat ?: '___/___/____' }}</td><td class="text-right align-top hidden sm:table-cell">Samarinda, {{ $submission->created_at->format('d F Y') }}</td></tr>
                                            <tr><td class="align-top">Perihal</td><td class="align-top">: <b id="preview-perihal">{{ $submission->perihal }}</b></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-justify mb-4 indent-8 leading-loose">{{ $submission->isi_ringkas }}</p>

                                <!-- PERUBAHAN: Tampilkan Data Form Dinamis di Preview -->
                                @if($submission->form_data && $submission->service->form_fields)
                                <div class="mb-4 space-y-2">
                                    @foreach($submission->service->form_fields as $field)
                                        @if(isset($submission->form_data[$field['name']]))
                                            <p class="flex">
                                                <span class="font-semibold mr-2">{{ $field['label'] }}:</span>
                                                <span>{{ $submission->form_data[$field['name']] }}</span>
                                            </p>
                                        @endif
                                    @endforeach
                                </div>
                                @endif

                                <div class="mt-12 text-right">
                                    <p>Hormat Kami,</p>
                                    <div class="h-20"></div>
                                    <p class="font-bold">{{ $submission->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Requirements dengan Tombol Verifikasi (hanya untuk verifikator) -->
                    @if(Auth::user()->role === 'verifikator')
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="file-text" size="20" class="text-[#00A651]"></i> Verifikasi Dokumen Persyaratan
                        </h3>
                        <div id="tracking-reqs-list" class="grid gap-3">
                            @foreach($submission->documents as $doc)
                            <div class="p-4 border rounded-lg doc-status-{{ $doc->status ?? 'pending' }}" data-doc-id="{{ $doc->id }}" data-doc-status="{{ $doc->status ?? 'pending' }}">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 
                                            @if($doc->status === 'approved') bg-green-100 text-green-600
                                            @elseif($doc->status === 'rejected') bg-red-100 text-red-600
                                            @else bg-gray-100 text-gray-600
                                            @endif rounded-full flex items-center justify-center shrink-0">
                                            @if($doc->status === 'approved')
                                                <i data-lucide="check" size="14"></i>
                                            @elseif($doc->status === 'rejected')
                                                <i data-lucide="x" size="14"></i>
                                            @else
                                                <i data-lucide="clock" size="14"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-700 font-medium">{{ $doc->requirement->name }}</span>
                                            <p class="text-xs text-gray-500">{{ $doc->file_name }} ({{ number_format($doc->file_size / 1024 / 1024, 2) }} MB)</p>
                                        </div>
                                    </div>
                                    <div class="verification-actions">
                                        <a href="javascript:void(0);" onclick="openDocumentModal({{ $doc->id }}, '{{ $doc->file_name }}')" class="text-xs font-bold text-[#00A651] bg-[#00A651]/10 px-2 py-1 rounded border border-[#00A651]/20 hover:bg-[#00A651]/20 transition-colors">Lihat</a>
                                        
                                        <!-- Tombol Edit (muncul setelah verifikasi) -->
                                        @if($doc->status === 'approved' || $doc->status === 'rejected')
                                        <button onclick="toggleEditVerification({{ $doc->id }})" class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-200 hover:bg-amber-100 transition-colors edit-verification-btn">
                                            {{-- <i data-lucide="edit-2" size="12"></i> --}}
                                            Edit
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($doc->notes)
                                    <div class="mb-3 p-2 bg-gray-50 rounded text-xs text-gray-600">
                                        <strong>Catatan:</strong> {{ $doc->notes }}
                                    </div>
                                @endif
                                
                                <!-- PERUBAHAN: Tombol Verifikasi yang lebih kecil dan di sebelah kanan -->
                                <div id="verification-buttons-{{ $doc->id }}" class="verification-buttons" style="@if($doc->status === 'approved' || $doc->status === 'rejected') display: none; @endif">
                                    <button onclick="updateDocumentStatus({{ $doc->id }}, 'approved')" class="verify-btn approve">
                                        <i data-lucide="check" size="12"></i> Acc
                                    </button>
                                    <button onclick="showRejectForm({{ $doc->id }})" class="verify-btn reject">
                                        <i data-lucide="x" size="12"></i> Salah
                                    </button>
                                </div>
                                
                                <div id="reject-form-{{ $doc->id }}" class="hidden mt-3 p-3 bg-red-50 rounded">
                                    <textarea id="reject-notes-{{ $doc->id }}" class="w-full p-2 border border-red-200 rounded text-xs" rows="2" placeholder="Alasan penolakan..."></textarea>
                                    <div id="reject-error-{{ $doc->id }}" class="reject-required-error hidden">
                                        <i data-lucide="alert-circle" size="12"></i> Alasan penolakan wajib diisi
                                    </div>
                                    <div class="flex gap-2 mt-2">
                                        <button onclick="updateDocumentStatus({{ $doc->id }}, 'rejected')" class="flex-1 px-3 py-1.5 bg-red-600 text-white rounded text-xs font-medium hover:bg-red-700 transition-colors">
                                            Simpan
                                        </button>
                                        <button onclick="hideRejectForm({{ $doc->id }})" class="flex-1 px-3 py-1.5 bg-gray-200 text-gray-700 rounded text-xs font-medium hover:bg-gray-300 transition-colors">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <!-- Detail Requirements untuk Pemohon -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="file-text" size="20" class="text-[#00A651]"></i> Detail Dokumen Persyaratan
                        </h3>
                        <div id="tracking-reqs-list" class="grid gap-3">
                            @foreach($submission->documents as $doc)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 
                                        @if($doc->status === 'approved') bg-green-100 text-green-600
                                        @elseif($doc->status === 'rejected') bg-red-100 text-red-600
                                        @else bg-gray-100 text-gray-600
                                        @endif rounded-full flex items-center justify-center shrink-0">
                                        @if($doc->status === 'approved')
                                            <i data-lucide="check" size="14"></i>
                                        @elseif($doc->status === 'rejected')
                                            <i data-lucide="x" size="14"></i>
                                        @else
                                            <i data-lucide="clock" size="14"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-700 font-medium">{{ $doc->requirement->name }}</span>
                                        <p class="text-xs text-gray-500">{{ $doc->file_name }} ({{ number_format($doc->file_size / 1024 / 1024, 2) }} MB)</p>
                                        @if($doc->status === 'approved')
                                            <p class="text-xs text-green-600 mt-1">Status: Disetujui</p>
                                        @elseif($doc->status === 'rejected')
                                            <p class="text-xs text-red-600 mt-1">Status: Perlu Revisi</p>
                                            @if($doc->notes)
                                                <p class="text-xs text-gray-500">Catatan: {{ $doc->notes }}</p>
                                            @endif
                                        @else
                                            <p class="text-xs text-gray-500 mt-1">Status: Menunggu Verifikasi</p>
                                        @endif
                                    </div>
                                </div>
                                <!-- PERBAIKAN: Mengganti $existingDoc dengan $doc -->
                                <a href="javascript:void(0);" onclick="openDocumentModal({{ $doc->id }}, '{{ $doc->file_name }}')" class="text-xs font-bold text-[#00A651] bg-[#00A651]/10 px-2 py-1 rounded border border-[#00A651]/20 hover:bg-[#00A651]/20 transition-colors">Lihat</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Verifikator Actions (hanya untuk verifikator) -->
                    @if(Auth::user()->role === 'verifikator' && $submission->status !== 'signed')
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="check-square" size="20" class="text-[#00A651]"></i> Aksi Verifikasi
                        </h3>
                        
                        <form id="verification-form" action="{{ route('verifikator.updateStatus', $submission) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Verifikasi</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $submission->status === 'process' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                            <input type="radio" name="status" value="process" {{ $submission->status === 'process' ? 'checked' : '' }} class="mr-3" onchange="handleStatusChange(this.value)">
                                            <div>
                                                <p class="font-medium">Proses Verifikasi</p>
                                                <p class="text-xs text-gray-500">Masih dalam proses verifikasi</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $submission->status === 'revision' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200' }}">
                                            <input type="radio" name="status" value="revision" {{ $submission->status === 'revision' ? 'checked' : '' }} class="mr-3" onchange="handleStatusChange(this.value)">
                                            <div>
                                                <p class="font-medium">Perlu Revisi</p>
                                                <p class="text-xs text-gray-500">Dokumen perlu diperbaiki</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $submission->status === 'rejected' ? 'border-red-500 bg-red-50' : 'border-gray-200' }}">
                                            <input type="radio" name="status" value="rejected" {{ $submission->status === 'rejected' ? 'checked' : '' }} class="mr-3" onchange="handleStatusChange(this.value)">
                                            <div>
                                                <p class="font-medium">Tolak Pengajuan</p>
                                                <p class="text-xs text-gray-500">Menolak seluruh pengajuan</p>
                                            </div>
                                        </label>
                                        
                                        <label id="verified-option" class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $submission->status === 'signed' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                            <input type="radio" name="status" value="signed" {{ $submission->status === 'signed' ? 'checked' : '' }} class="mr-3" onchange="handleStatusChange(this.value)">
                                            <div>
                                                <p class="font-medium">Terverifikasi</p>
                                                <p class="text-xs text-gray-500">Dokumen telah disetujui</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="rejection-reason-container" class="hidden">
                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                                    <textarea id="rejection_reason" name="rejection_reason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Jelaskan alasan penolakan pengajuan ini...">{{ $submission->rejection_reason ?? '' }}</textarea>
                                </div>
                                
                                <div id="notes-container">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                                    <textarea id="notes" name="notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent" placeholder="Tambahkan catatan verifikasi...">{{ $submission->histories->last()->notes ?? '' }}</textarea>
                                </div>
                                
                                <div id="verification-warning" class="hidden alert-box alert-warning">
                                    <div class="flex items-start gap-3">
                                        <i data-lucide="alert-triangle" size="20" class="text-yellow-600 mt-0.5"></i>
                                        <div>
                                            <p class="text-sm text-yellow-800 mt-1">Anda harus memverifikasi semua dokumen persyaratan sebelum dapat menyimpan status.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2">
                                    <button type="submit" id="submit-status-btn" class="flex-1 bg-[#00A651] text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-600 transition-colors">
                                        Simpan Status
                                    </button>
                                    <a href="{{ route('verifikator.dashboard') }}" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors text-center">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Sidebar Timeline -->
                <div class="grid-item space-y-6 animate-[slideUp_0.8s_ease-out]">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-3 text-lg border-b pb-4">
                            <i data-lucide="history" size="20" class="text-[#00A651]"></i> Riwayat Proses
                        </h3>
                        <div id="tracking-timeline" class="relative flex flex-col gap-0">
                            <!-- Pengajuan Draf -->
                            <div class="flex gap-4 relative pb-8">
                                <div class="absolute left-[19px] top-8 bottom-0 w-0.5 bg-gray-200"></div>
                                <div class="relative z-10 w-10 h-10 bg-green-100 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0">
                                    <i data-lucide="check-circle" size="18" class="text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium mb-0.5">{{ $submission->created_at->format('d M H:i') }}</p>
                                    <p class="font-bold text-gray-800 text-sm">Pengajuan Draf</p>
                                    <p class="text-xs text-gray-500">Oleh: {{ $submission->user->name }} (Konseptor)</p>
                                </div>
                            </div>
                            
                            <!-- Verifikasi Berjenjang -->
                            @php
                                $verificationHistory = $submission->histories->where('status_to', '!=', 'draft')->first();
                                $isRevision = $submission->status === 'revision';
                                $isRejected = $submission->status === 'rejected';
                                $isSigned = $submission->status === 'signed';
                                $verificationIcon = $isRevision ? 'x' : ($isRejected ? 'x-circle' : ($isSigned ? 'check-circle' : 'clock'));
                                $verificationClass = $verificationHistory ? 
                                    ($isRevision ? 'bg-red-100 text-red-600' : ($isRejected ? 'bg-red-100 text-red-600' : ($isSigned ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'))) 
                                    : 'bg-gray-100 text-gray-400';
                            @endphp
                            <div class="flex gap-4 relative pb-8">
                                <div class="absolute left-[19px] top-8 bottom-0 w-0.5 bg-gray-200"></div>
                                <div class="relative z-10 w-10 h-10 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0 {{ $verificationClass }}">
                                    <i data-lucide="{{ $verificationIcon }}" size="18"></i>
                                </div>
                                <div>
                                    @if($verificationHistory)
                                        <p class="text-xs text-gray-400 font-medium mb-0.5">{{ $verificationHistory->created_at->format('d M H:i') }}</p>
                                    @else
                                        <p class="text-xs text-gray-400 font-medium mb-0.5">-</p>
                                    @endif
                                    <p class="font-bold text-gray-800 text-sm">
                                        @if($isRevision) Perlu Revisi
                                        @elseif($isRejected) Ditolak
                                        @elseif($isSigned) Terverifikasi
                                        @else Verifikasi Berjenjang
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500">Posisi: @if($verificationHistory) {{ $verificationHistory->user->name }} @else - @endif</p>
                                    @if(($isRevision || $isRejected) && $submission->histories->where('status_to', $submission->status)->last()->notes)
                                        <div class="mt-2 bg-red-50 p-2 rounded text-xs text-red-600 border border-red-100">
                                            "{{ $submission->histories->where('status_to', $submission->status)->last()->notes }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- TTE Kepala Dinas -->
                            <div class="flex gap-4 relative">
                                <div class="relative z-10 w-10 h-10 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0 
                                    @if($isSigned) bg-green-100 text-green-600 @else bg-gray-100 text-gray-300 @endif">
                                    <i data-lucide="pen-tool" size="18"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm mt-2">TTE Kepala Dinas</p>
                                    <p class="text-xs text-gray-500">@if($isSigned) Selesai @else Menunggu @endif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Tambahan untuk Verifikator -->
                    @if(Auth::user()->role === 'verifikator')
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="info" size="20" class="text-[#00A651]"></i> Informasi Pengajuan
                        </h3>
                        
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Pemohon</p>
                                <p class="font-medium">{{ $submission->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Layanan</p>
                                <p class="font-medium">{{ $submission->service->name }}</p>
                            </div>
                            @if ($submission->tujuan)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tujuan</p>
                                <p class="font-medium">{{ $submission->tujuan }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tanggal Pengajuan</p>
                                <p class="font-medium">{{ $submission->created_at->format('d F Y') }}</p>
                            </div>
                            @if ($submission->signed_at)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tanggal Tanda Tangan</p>
                                <p class="font-medium">{{ $submission->signed_at->format('d F Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Document Viewer Modal -->
<div id="document-viewer-modal" class="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm hidden flex items-center justify-center">
    <div class="bg-white w-[92%] max-w-5xl h-[90vh] max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">
        <div class="p-4 border-b flex items-center justify-between shrink-0">
            <h3 id="modal-title" class="font-bold text-lg text-gray-800">Pratinjau Dokumen</h3>
            <div class="flex items-center gap-2">
                <button id="modal-download-btn" onclick="downloadDocumentAsPDF()" class="px-4 py-2 bg-[#00A651] text-white rounded-lg text-sm font-bold hover:bg-emerald-600 transition-colors flex items-center gap-2">
                    <i data-lucide="download" size="16"></i>Unduh PDF
                </button>

                <button onclick="closeDocumentModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <i data-lucide="x" size="22" class="text-gray-500"></i>
                </button>
            </div>
        </div>

        <div class="flex-1 relative overflow-hidden p-4">
            <div id="pdf-loading" class="absolute inset-0 flex items-center justify-center bg-white z-10">
                <div class="text-center">
                    <i data-lucide="loader-2" class="animate-spin text-[#00A651]" size="32"></i>
                    <p class="text-sm text-gray-500 mt-2">
                        Memuat dokumen...
                    </p>
                </div>
            </div>

            <div id="pdf-error" class="absolute inset-0 flex items-center justify-center bg-white z-10 hidden">
                <div class="text-center text-red-600">
                    <i data-lucide="alert-circle" size="32"></i>
                    <p class="text-sm mt-2">Gagal memuat dokumen.</p>
                    <button onclick="closeDocumentModal()"
                            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>

            <iframe id="document-frame" class="w-full h-full border-0 rounded-xl" style="display: none;"></iframe>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="check-circle" size="32" class="text-green-600"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 mb-2">Revisi Berhasil Dikirim</h3>
            <p class="text-sm text-gray-600 mb-4">Dokumen revisi Anda telah berhasil dikirim dan akan segera diverifikasi kembali.</p>
            <button onclick="closeSuccessModal()" class="px-6 py-2 bg-[#00A651] text-white rounded-lg font-medium hover:bg-emerald-600 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="error-modal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-circle" size="32" class="text-red-600"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 mb-2">Terjadi Kesalahan</h3>
            <p id="error-message" class="text-sm text-gray-600 mb-4">Silakan periksa kembali formulir Anda.</p>
            <button onclick="closeErrorModal()" class="px-6 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Document Status Update Modal -->
<div id="doc-status-modal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="text-center">
            <div id="doc-status-icon" class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            </div>
            <h3 id="doc-status-title" class="font-bold text-lg text-gray-800 mb-2">Status Dokumen Diperbarui</h3>
            <p id="doc-status-message" class="text-sm text-gray-600 mb-4">Status dokumen berhasil diperbarui.</p>
            <button onclick="closeDocStatusModal()" class="px-6 py-2 bg-[#00A651] text-white rounded-lg font-medium hover:bg-emerald-600 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

<div id="reject-modal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="x-circle" size="32" class="text-red-600"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 mb-2">Konfirmasi Penolakan</h3>
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menolak pengajuan ini? Tindakan ini akan memerlukan pemohon untuk mengajukan ulang pengajuan.</p>
            <div class="flex gap-3">
                <button onclick="confirmRejection()" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">
                    Ya, Tolak
                </button>
                <button onclick="closeRejectModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            lucide.createIcons();
        }, 100);
        
        // Check if there are any rejected documents and disable verified option
        checkDocumentStatuses();
        
        // Initialize status change handlers
        const statusRadios = document.querySelectorAll('input[name="status"]');
        statusRadios.forEach(radio => {
            if (radio.checked) {
                handleStatusChange(radio.value);
            }
        });
        
        // Check if revision form is open and validate button state
        if (document.getElementById('revision-form') && !document.getElementById('revision-form').classList.contains('hidden')) {
            checkRevisionFormState();
        }
    });

    function checkDocumentStatuses() {
        const documents = document.querySelectorAll('#tracking-reqs-list > div[data-doc-status]');
        let hasRejected = false;
        let allVerified = true;
        let hasPending = false;
        
        documents.forEach(doc => {
            const status = doc.getAttribute('data-doc-status');
            if (status === 'rejected') {
                hasRejected = true;
            }
            // PERUBAHAN: Memperbaiki logika verifikasi - dokumen dianggap sudah diverifikasi jika statusnya approved atau rejected
            if (status === 'pending') {
                allVerified = false;
                hasPending = true;
            }
        });
        
        // Disable verified option if there are rejected documents
        const verifiedOption = document.getElementById('verified-option');
        if (hasRejected && verifiedOption) {
            verifiedOption.classList.add('disabled-option');
            verifiedOption.querySelector('input').disabled = true;
        } else if (verifiedOption) {
            verifiedOption.classList.remove('disabled-option');
            verifiedOption.querySelector('input').disabled = false;
        }
        
        // Show/hide verification warning based on document verification status
        const verificationWarning = document.getElementById('verification-warning');
        const submitBtn = document.getElementById('submit-status-btn');
        
        // PERUBAHAN: Hanya tampilkan peringatan jika ada dokumen yang belum diverifikasi (pending)
        if (hasPending && verificationWarning && submitBtn) {
            verificationWarning.classList.remove('hidden');
            submitBtn.classList.add('submit-disabled');
            submitBtn.disabled = true;
        } else if (verificationWarning && submitBtn) {
            verificationWarning.classList.add('hidden');
            submitBtn.classList.remove('submit-disabled');
            submitBtn.disabled = false;
        }
    }

    function handleStatusChange(status) {
        const rejectionReasonContainer = document.getElementById('rejection-reason-container');
        const notesContainer = document.getElementById('notes-container');
        const notesTextarea = document.getElementById('notes');
        
        if (status === 'rejected') {
            // Show rejection reason and hide notes
            rejectionReasonContainer.classList.remove('hidden');
            notesContainer.classList.add('hidden');
        } else {
            // Hide rejection reason and show notes
            rejectionReasonContainer.classList.add('hidden');
            notesContainer.classList.remove('hidden');
            
            // Update notes template based on status
            if (status === 'revision') {
                notesTextarea.value = 'perlu revisi';
            } else if (status === 'signed') {
                notesTextarea.value = 'Terverifikasi';
            } else {
                notesTextarea.value = '';
            }
        }
    }

    function toggleRevisionForm() {
        const form = document.getElementById('revision-form');
        form.classList.toggle('hidden');
        
        if (!form.classList.contains('hidden')) {
            setTimeout(() => {
                lucide.createIcons();
                
                flatpickr("#revision-tanggal_surat", {
                    dateFormat: "d/m/Y",
                    altInput: true,
                    altFormat: "j F Y",
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: { shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'], longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], },
                        months: { shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'], },
                    },
                    disableMobile: "true",
                    onChange: function(selectedDates, dateStr, instance) {
                        const date = selectedDates[0];
                        if (date) {
                            const day = date.getDate().toString().padStart(2, '0');
                            const month = (date.getMonth() + 1).toString().padStart(2, '0');
                            const year = date.getFullYear();
                            instance.setDate(`${day}/${month}/${year}`, true);
                        }
                    }
                });
                
                // Check revision form state after opening
                checkRevisionFormState();
            }, 100);
        }
    }

    function handleRevisionFileUpload(event, reqId) {
        const file = event.target.files[0];
        const previewDiv = document.getElementById(`revision-preview-${reqId}`);
        const container = event.target.closest('.file-upload-item');
        const button = event.target.previousElementSibling;
        
        previewDiv.innerHTML = '';
        previewDiv.classList.remove('active');
        
        if (file) {
            if (file.type !== 'application/pdf') {
                previewDiv.innerHTML = `<div class="flex items-center gap-2 text-red-500">
                    <i data-lucide="alert-circle" size="14"></i>
                    <span>File harus berformat PDF.</span>
                </div>`;
                previewDiv.classList.add('active');
                event.target.value = '';
                lucide.createIcons();
                return;
            }

            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                previewDiv.innerHTML = `<div class="flex items-center gap-2 text-red-500">
                    <i data-lucide="alert-circle" size="14"></i>
                    <span>Ukuran file maksimal 5MB.</span>
                </div>`;
                previewDiv.classList.add('active');
                event.target.value = '';
                lucide.createIcons();
                return;
            }
            
            const fileSizeKB = (file.size / 1024).toFixed(2);
            previewDiv.innerHTML = `<div class="flex items-center gap-2 text-green-600">
                <i data-lucide="check-circle" size="14"></i>
                <span>File baru akan diunggah: ${file.name} (${fileSizeKB} KB)</span>
            </div>`;
            previewDiv.classList.add('active');
            
            if (button.classList.contains('primary')) {
                button.innerHTML = `<i data-lucide="check" size="16"></i> File Dipilih`;
            } else if (button.classList.contains('danger')) {
                button.innerHTML = `<i data-lucide="check" size="16"></i> File Diganti`;
            }
            
            container.classList.add('border-green-500', 'bg-green-50');
            
            // Update data attribute to mark as uploaded
            container.setAttribute('data-file-uploaded', 'true');
            
            lucide.createIcons();
            
            // Check revision form state after file upload
            checkRevisionFormState();
        }
    }

    // PERUBAHAN: Fungsi untuk memeriksa status form revisi
    function checkRevisionFormState() {
        const submitBtn = document.getElementById('submit-revision-btn');
        if (!submitBtn) return;
        
        const fileUploadItems = document.querySelectorAll('#revision-reqs-container .file-upload-item');
        let allRejectedFilesUploaded = true;
        
        fileUploadItems.forEach(item => {
            const docStatus = item.getAttribute('data-doc-status');
            const fileUploaded = item.getAttribute('data-file-uploaded') === 'true';
            
            // If document status is rejected and no new file is uploaded, disable button
            if (docStatus === 'rejected' && !fileUploaded) {
                allRejectedFilesUploaded = false;
            }
        });
        
        // Enable/disable submit button based on file upload status
        if (allRejectedFilesUploaded) {
            submitBtn.disabled = false;
            // PERUBAHAN: Mengubah warna tombol menjadi hijau saat semua file yang perlu direvisi sudah diganti
            submitBtn.classList.remove('bg-gray-400');
            submitBtn.classList.add('bg-[#00A651]');
        } else {
            submitBtn.disabled = true;
            // PERUBAHAN: Mengubah warna tombol menjadi abu-abu saat ada file yang belum diganti
            submitBtn.classList.remove('bg-[#00A651]');
            submitBtn.classList.add('bg-gray-400');
        }
    }

    function closeSuccessModal() {
        document.getElementById('success-modal').classList.add('hidden');
        window.location.reload();
    }
    function closeErrorModal() {
        document.getElementById('error-modal').classList.add('hidden');
    }
    function closeDocStatusModal() {
        document.getElementById('doc-status-modal').classList.add('hidden');
    }
    function showErrorModal(message) {
        document.getElementById('error-message').textContent = message;
        document.getElementById('error-modal').classList.remove('hidden');
        lucide.createIcons();
    }

    // PERUBAHAN: Perbarui fungsi validasi untuk form dinamis
    function validateRevisionForm() {
        const form = document.getElementById('revision-form-submit');
        const fileInputs = form.querySelectorAll('input[type="file"]');
        let hasError = false;
        
        document.querySelectorAll('.revision-error').forEach(el => el.remove());
        
        const perihalInput = document.getElementById('revision-perihal');
        if (!perihalInput.value.trim()) {
            showError(perihalInput.parentElement, 'Perihal / Judul wajib diisi');
            hasError = true;
        }
        
        fileInputs.forEach(input => {
            const reqId = input.name.match(/\d+/)[0];
            const isRequired = input.getAttribute('data-required') === 'true';
            const container = input.closest('.file-upload-item');
            
            const hasNewFile = input.files.length > 0;
            const hasExistingFile = container.textContent.includes('File:');
            const isRejected = container.textContent.includes('Perlu Revisi');
            
            if (isRejected && !hasNewFile) {
                showError(container, 'Dokumen yang ditolak wajib diunggah ulang.');
                hasError = true;
            } else if (isRequired && !hasExistingFile && !hasNewFile) {
                showError(container, 'Dokumen ini wajib diunggah.');
                hasError = true;
            }
        });

        // PERUBAHAN: Tambahkan validasi untuk field dinamis
        const dynamicFields = @json($submission->service->form_fields ?? []);
        dynamicFields.forEach(field => {
            const input = form.querySelector(`[name="form_data[${field.name}]"]`);
            if (field.is_required && input && !input.value.trim()) {
                showError(input.closest('.group') || input.parentElement, `${field.label} wajib diisi.`);
                hasError = true;
            }
        });
        
        if (hasError) {
            const firstError = document.querySelector('.revision-error');
            if(firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
        }
        
        return true;
    }
    
    function showError(element, message) {
        const oldError = element.querySelector('.revision-error');
        if(oldError) { oldError.remove(); }
        const errorDiv = document.createElement('div');
        errorDiv.className = 'revision-error text-red-500 text-xs mt-1 font-medium flex items-center gap-1';
        errorDiv.innerHTML = `<i data-lucide="alert-circle" size="12"></i> ${message}`;
        element.appendChild(errorDiv);
        lucide.createIcons();
    }

    function downloadDocumentAsPDF() {
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
        loadingIndicator.innerHTML = `
            <div class="bg-white rounded-lg p-6 flex flex-col items-center">
                <i data-lucide="loader-2" class="animate-spin text-[#00A651] mb-2" size="32"></i>
                <p class="text-gray-600">Menghasilkan PDF...</p>
            </div>
        `;
        document.body.appendChild(loadingIndicator);
        lucide.createIcons();

        const element = document.getElementById('document-preview');
        
        html2canvas(element, {
            scale: 2,
            useCORS: true,
            logging: false,
            backgroundColor: '#ffffff'
        }).then(canvas => {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');
            
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 210;
            const pageHeight = 295;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            let heightLeft = imgHeight;
            let position = 0;
            
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
            
            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }
            
            const trackingId = document.getElementById('tracking-id').textContent.replace('ID: ', '');
            const perihal = document.getElementById('preview-perihal').textContent;
            
            pdf.save(`${trackingId}_${perihal.replace(/[^a-z0-9]/gi, '_').toLowerCase()}.pdf`);
            
            document.body.removeChild(loadingIndicator);
        }).catch(error => {
            console.error('Error generating PDF:', error);
            document.body.removeChild(loadingIndicator);
            alert('Gagal menghasilkan PDF. Silakan coba lagi.');
        });
    }

    function updateDocumentStatus(docId, status) {
        // PERUBAHAN: Validasi alasan penolakan wajib diisi
        if (status === 'rejected') {
            const notesTextarea = document.getElementById(`reject-notes-${docId}`);
            const errorElement = document.getElementById(`reject-error-${docId}`);
            
            if (!notesTextarea.value.trim()) {
                notesTextarea.classList.add('reject-required');
                errorElement.classList.remove('hidden');
                lucide.createIcons();
                return;
            } else {
                notesTextarea.classList.remove('reject-required');
                errorElement.classList.add('hidden');
            }
        }
        
        const notes = status === 'rejected' ? document.getElementById(`reject-notes-${docId}`).value : null;
        
        fetch(`/verifikator/documents/${docId}/verify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: status,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update document status in UI without page refresh
                const docElement = document.querySelector(`[data-doc-id="${docId}"]`);
                if (docElement) {
                    docElement.setAttribute('data-doc-status', status);
                    
                    // Update visual status
                    const statusIcon = docElement.querySelector('.w-8.h-8');
                    const statusBadge = docElement.querySelector('.flex.items-center.justify-between');
                    
                    // Hide verification buttons
                    const verificationButtons = document.getElementById(`verification-buttons-${docId}`);
                    if (verificationButtons) {
                        verificationButtons.style.display = 'none';
                    }
                    
                    // Hide reject form if visible
                    const rejectForm = document.getElementById(`reject-form-${docId}`);
                    if (rejectForm) {
                        rejectForm.classList.add('hidden');
                    }
                    
                    // Show edit button
                    const verificationActions = docElement.querySelector('.verification-actions');
                    if (verificationActions) {
                        // Check if edit button already exists
                        let editButton = verificationActions.querySelector('.edit-verification-btn');
                        
                        if (!editButton) {
                            // Create edit button
                            editButton = document.createElement('button');
                            editButton.className = 'text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-200 hover:bg-amber-100 transition-colors edit-verification-btn';
                            editButton.setAttribute('onclick', `toggleEditVerification(${docId})`);
                            editButton.innerHTML = 'Edit';
                            
                            // Add edit button after the "Lihat" button
                            const viewButton = verificationActions.querySelector('a');
                            if (viewButton) {
                                viewButton.insertAdjacentElement('afterend', editButton);
                            }
                        } else {
                            // Reset edit button to default state
                            resetEditButton(editButton);
                        }
                    }
                    
                    if (status === 'approved') {
                        docElement.classList.remove('doc-status-pending', 'doc-status-rejected');
                        docElement.classList.add('doc-status-approved');
                        
                        statusIcon.classList.remove('bg-gray-100', 'text-gray-600', 'bg-red-100', 'text-red-600');
                        statusIcon.classList.add('bg-green-100', 'text-green-600');
                        statusIcon.innerHTML = '<i data-lucide="check" size="14"></i>';
                        
                        // Remove notes section for approved documents
                        const notesElement = docElement.querySelector('.mb-3.p-2.bg-gray-50');
                        if (notesElement) {
                            notesElement.remove();
                        }
                    } else if (status === 'rejected') {
                        docElement.classList.remove('doc-status-pending', 'doc-status-approved');
                        docElement.classList.add('doc-status-rejected');
                        
                        statusIcon.classList.remove('bg-gray-100', 'text-gray-600', 'bg-green-100', 'text-green-600');
                        statusIcon.classList.add('bg-red-100', 'text-red-600');
                        statusIcon.innerHTML = '<i data-lucide="x" size="14"></i>';
                        
                        // Add notes if provided
                        if (notes) {
                            let notesElement = docElement.querySelector('.mb-3.p-2.bg-gray-50');
                            if (!notesElement) {
                                notesElement = document.createElement('div');
                                notesElement.className = 'mb-3 p-2 bg-gray-50 rounded text-xs text-gray-600';
                                statusBadge.after(notesElement);
                            }
                            notesElement.innerHTML = `<strong>Catatan:</strong> ${notes}`;
                        }
                    }
                    
                    // Re-initialize Lucide icons
                    lucide.createIcons();
                    
                    // Check document statuses again to update UI
                    checkDocumentStatuses();
                }
                
                // Show success modal
                const modal = document.getElementById('doc-status-modal');
                const iconContainer = document.getElementById('doc-status-icon');
                const titleElement = document.getElementById('doc-status-title');
                const messageElement = document.getElementById('doc-status-message');
                
                if (status === 'approved') {
                    iconContainer.innerHTML = '<i data-lucide="check-circle" size="32" class="text-green-600"></i>';
                    titleElement.textContent = 'Dokumen Disetujui';
                    messageElement.textContent = 'Dokumen telah disetujui.';
                } else {
                    iconContainer.innerHTML = '<i data-lucide="x-circle" size="32" class="text-red-600"></i>';
                    titleElement.textContent = 'Dokumen Ditolak';
                    messageElement.textContent = 'Dokumen perlu direvisi sesuai catatan yang diberikan.';
                }
                
                modal.classList.remove('hidden');
                lucide.createIcons();
            } else {
                alert('Gagal memperbarui status dokumen: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui status dokumen.');
        });
    }
    
    // PERUBAHAN: Fungsi untuk mereset tombol edit ke keadaan semula
    function resetEditButton(editButton) {
        editButton.innerHTML = 'Edit';
        editButton.classList.remove('text-gray-600', 'bg-gray-50', 'border-gray-200', 'hover:bg-gray-100');
        editButton.classList.add('text-amber-600', 'bg-amber-50', 'border-amber-200', 'hover:bg-amber-100');
        lucide.createIcons();
    }
    
    // PERUBAHAN: Fungsi toggle edit verification yang diperbaiki
    function toggleEditVerification(docId) {
        const verificationButtons = document.getElementById(`verification-buttons-${docId}`);
        const editButton = document.querySelector(`button[onclick="toggleEditVerification(${docId})"]`);
        
        // Check current state by checking if verification buttons are visible
        const isEditMode = verificationButtons.style.display === 'flex';
        
        if (!isEditMode) {
            // Show verification buttons (enter edit mode)
            verificationButtons.style.display = 'flex';
            editButton.textContent = 'Batal';
            editButton.classList.remove('text-amber-600', 'bg-amber-50', 'border-amber-200', 'hover:bg-amber-100');
            editButton.classList.add('text-gray-600', 'bg-gray-50', 'border-gray-200', 'hover:bg-gray-100');
        } else {
            // Hide verification buttons (exit edit mode)
            verificationButtons.style.display = 'none';
            resetEditButton(editButton);
            
            // Hide reject form if visible
            const rejectForm = document.getElementById(`reject-form-${docId}`);
            if (rejectForm) {
                rejectForm.classList.add('hidden');
            }
        }
        
        lucide.createIcons();
    }
    
    function showRejectForm(docId) {
        document.getElementById(`reject-form-${docId}`).classList.remove('hidden');
        // Reset error state
        const notesTextarea = document.getElementById(`reject-notes-${docId}`);
        const errorElement = document.getElementById(`reject-error-${docId}`);
        notesTextarea.classList.remove('reject-required');
        errorElement.classList.add('hidden');
    }
    
    function hideRejectForm(docId) {
        document.getElementById(`reject-form-${docId}`).classList.add('hidden');
        // Reset error state
        const notesTextarea = document.getElementById(`reject-notes-${docId}`);
        const errorElement = document.getElementById(`reject-error-${docId}`);
        notesTextarea.classList.remove('reject-required');
        errorElement.classList.add('hidden');
    }

    function showRejectModal() {
        document.getElementById('reject-modal').classList.remove('hidden');
        lucide.createIcons();
    }

    function closeRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
    }

    function confirmRejection() {
        const rejectionReason = document.getElementById('rejection_reason').value;
        
        if (!rejectionReason.trim()) {
            showErrorModal('Alasan penolakan wajib diisi.');
            return;
        }
        
        closeRejectModal();
        
        const form = document.querySelector('form[action*="verifikator/updateStatus"]');
        form.submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const revisionForm = document.getElementById('revision-form-submit');
        
        if (revisionForm) {
            revisionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!validateRevisionForm()) {
                    showErrorModal('Silakan periksa kembali formulir Anda. Pastikan semua field yang wajib diisi dengan benar.');
                    return;
                }
                
                const submitBtn = revisionForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i data-lucide="loader-2" class="animate-spin mr-2" size="16"></i> Mengirim...';
                submitBtn.disabled = true;
                lucide.createIcons();
                
                const formData = new FormData(revisionForm);
                
                const dateInput = document.getElementById('revision-tanggal_surat');
                const dateValue = dateInput.value;
                
                if (dateValue) {
                    const parts = dateValue.split('/');
                    if (parts.length === 3) {
                        const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                        formData.set('tanggal_surat', formattedDate);
                    }
                }
                
                fetch(revisionForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('revision-form').classList.add('hidden');
                        document.getElementById('success-modal').classList.remove('hidden');
                        lucide.createIcons();
                    } else {
                        let errorMessage = data.message || 'Terjadi kesalahan saat mengirim revisi. Silakan coba lagi.';
                        if (data.errors) {
                             const firstErrorKey = Object.keys(data.errors)[0];
                             errorMessage = data.errors[firstErrorKey][0];
                        }
                        showErrorModal(errorMessage);
                        
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        lucide.createIcons();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorModal('Terjadi kesalahan jaringan. Silakan coba lagi.');
                    
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    lucide.createIcons();
                });
            });
        }
        
        const verificationForm = document.getElementById('verification-form');
        if (verificationForm) {
            verificationForm.addEventListener('submit', function(e) {
                const statusValue = document.querySelector('input[name="status"]:checked').value;
                
                if (statusValue === 'rejected') {
                    e.preventDefault();
                    showRejectModal();
                }
            });
        }
    });
</script>
@endpush