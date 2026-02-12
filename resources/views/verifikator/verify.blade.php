@extends('layouts.dashboard')

@section('title', 'Verifikasi Pengajuan')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto animate-[fadeIn_0.5s_ease-out]">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Verifikasi Pengajuan</h1>
            <p class="text-gray-500 mt-1">ID: {{ $submission->tracking_id }}</p>
        </div>
        <a href="{{ route('verifikator.dashboard') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
            <i data-lucide="arrow-left" size="18"></i> Kembali ke Dashboard
        </a>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" size="20" class="text-[#00A651]"></i> Detail Pengajuan
                </h3>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Pemohon</p>
                            <p class="font-medium">{{ $submission->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Layanan</p>
                            <p class="font-medium">{{ $submission->service->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Perihal</p>
                            <p class="font-medium">{{ $submission->perihal }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Pengajuan</p>
                            <p class="font-medium">{{ $submission->created_at->format('d F Y') }}</p>
                        </div>
                        @if ($submission->tujuan)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tujuan</p>
                            <p class="font-medium">{{ $submission->tujuan }}</p>
                        </div>
                        @endif
                        @if ($submission->tanggal_surat)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Surat</p>
                            <p class="font-medium">{{ $submission->tanggal_surat->format('d F Y') }}</p>
                        </div>
                        @endif
                    </div>
                    
                    @if ($submission->isi_ringkas)
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Isi Ringkas</p>
                        <p class="font-medium">{{ $submission->isi_ringkas }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="paperclip" size="20" class="text-[#00A651]"></i> Dokumen Persyaratan
                </h3>
                
                <div class="space-y-3">
                    @foreach ($submission->documents as $document)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 shrink-0">
                                <i data-lucide="file" size="14"></i>
                            </div>
                            <div>
                                <span class="text-sm text-gray-700 font-medium">{{ $document->requirement->name }}</span>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $document->file_name }} ({{ number_format($document->file_size / 1024 / 1024, 2) }} MB)</p>
                            </div>
                        </div>
                        <a href="javascript:void(0);" onclick="openDocumentModal({{ $document->id }}, '{{ $document->file_name }}')" class="text-xs font-bold text-[#00A651] bg-[#00A651]/10 px-2 py-1 rounded border border-[#00A651]/20 hover:bg-[#00A651]/20 transition-colors">Lihat</a>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="history" size="20" class="text-[#00A651]"></i> Riwayat Proses
                </h3>
                
                <div class="relative flex flex-col gap-0">
                    @foreach ($submission->histories as $history)
                    <div class="flex gap-4 relative pb-8 {{ !$loop->last ? '' : 'pb-0' }}">
                        @if (!$loop->last)<div class="absolute left-[19px] top-8 bottom-0 w-0.5 bg-gray-200"></div>@endif
                        <div class="relative z-10 w-10 h-10 
                            @if ($history->status_to === 'signed') bg-green-100 
                            @elseif ($history->status_to === 'revision') bg-red-100 
                            @else bg-yellow-100 
                            @endif rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0">
                            <i data-lucide="{{ $history->status_to === 'signed' ? 'check-circle' : ($history->status_to === 'revision' ? 'x-circle' : 'clock') }}" size="18" class="text-{{ $history->status_to === 'signed' ? 'green' : ($history->status_to === 'revision' ? 'red' : 'yellow') }}-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-0.5">{{ $history->created_at->format('d M Y, H:i') }}</p>
                            <p class="font-bold text-gray-800 text-sm">{{ Str::title(str_replace('_', ' ', $history->status_to)) }}</p>
                            <p class="text-xs text-gray-500">Oleh: {{ $history->user->name }}</p>
                            @if ($history->notes)
                                <div class="mt-2 bg-gray-50 p-2 rounded text-xs text-gray-600 border border-gray-100">{{ $history->notes }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="check-square" size="20" class="text-[#00A651]"></i> Verifikasi
                </h3>
                
                <form action="{{ route('verifikator.updateStatus', $submission) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Verifikasi</label>
                            <div class="space-y-2">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $submission->status === 'process' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <input type="radio" name="status" value="process" {{ $submission->status === 'process' ? 'checked' : '' }} class="mr-3">
                                    <div>
                                        <p class="font-medium">Proses Verifikasi</p>
                                        <p class="text-xs text-gray-500">Masih dalam proses verifikasi</p>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $submission->status === 'revision' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200' }}">
                                    <input type="radio" name="status" value="revision" {{ $submission->status === 'revision' ? 'checked' : '' }} class="mr-3">
                                    <div>
                                        <p class="font-medium">Perlu Revisi</p>
                                        <p class="text-xs text-gray-500">Dokumen perlu diperbaiki</p>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $submission->status === 'signed' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                    <input type="radio" name="status" value="signed" {{ $submission->status === 'signed' ? 'checked' : '' }} class="mr-3">
                                    <div>
                                        <p class="font-medium">Terverifikasi</p>
                                        <p class="text-xs text-gray-500">Dokumen telah disetujui</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea id="notes" name="notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent" placeholder="Tambahkan catatan verifikasi...">{{ $submission->histories->last()->notes ?? '' }}</textarea>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-[#00A651] text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-600 transition-colors">
                                Simpan Status
                            </button>
                            <a href="{{ route('verifikator.dashboard') }}" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors text-center">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            
            @if ($submission->status === 'signed' && $submission->nomor_surat)
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="file-check" size="20" class="text-[#00A651]"></i> Informasi Penandatanganan
                </h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nomor Surat</p>
                        <p class="font-medium">{{ $submission->nomor_surat }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Tanda Tangan</p>
                        <p class="font-medium">{{ $submission->signed_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Ditandatangani oleh</p>
                        <p class="font-medium">{{ $submission->signer->name ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div id="document-viewer-modal" class="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm hidden flex items-center justify-center">
    <div class="bg-white w-[92%] max-w-5xl h-[90vh] max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="p-4 border-b flex items-center justify-between shrink-0">
            <h3 id="modal-title" class="font-bold text-lg text-gray-800">Pratinjau Dokumen</h3>
            <div class="flex items-center gap-2">
                <a id="modal-download-btn" href="#" target="_blank" class="px-4 py-2 bg-[#00A651] text-white rounded-lg text-sm font-bold hover:bg-emerald-600 transition-colors flex items-center gap-2">
                    <i data-lucide="download" size="16"></i>Unduh
                </a>

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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush