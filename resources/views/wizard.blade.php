@extends('layouts.dashboard')

@section('title', 'Form Pengajuan')

@section('content')
<div class="flex flex-col h-screen bg-[#F3F4F6] font-sans">
    <div class="bg-white px-4 lg:px-6 py-4 border-b flex items-center justify-between shadow-sm sticky top-0 z-40 shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('select') }}" class="hover:bg-gray-100 p-2 rounded-full transition-colors"><i data-lucide="chevron-left" size="24" class="text-gray-500"></i></a>
            <div>
                <h2 class="font-bold text-lg text-gray-800 flex flex-col sm:flex-row sm:items-center sm:gap-2">
                    <span>Pengajuan</span><span id="wizard-title" class="text-[#00A651] truncate max-w-[200px] sm:max-w-none">...</span>
                </h2>
                <p class="text-xs text-gray-500 hidden sm:block">Lengkapi data dan dokumen persyaratan</p>
            </div>
        </div>
        <div class="flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-full text-xs text-gray-500 font-medium">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div><span class="hidden sm:inline">Draft Tersimpan</span>
        </div>
    </div>
    
    <div class="flex-1 overflow-y-auto p-4 lg:p-8">
        <div class="max-w-4xl mx-auto space-y-6 lg:space-y-8 animate-[slideUp_0.5s_ease-out]">
            <!-- Form Utama -->
            <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-3 text-lg">
                    <i data-lucide="file-text" size="20" class="text-[#00A651]"></i> Data Utama Naskah
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2 group">
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Perihal / Judul</label>
                        <input type="text" id="input-perihal" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="Contoh: Permohonan Izin...">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Tujuan Surat</label>
                        <input type="text" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="Kepada Yth...">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Tanggal Surat</label>
                        <input type="date" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Isi Ringkas</label>
                        <textarea class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" rows="4" placeholder="Jelaskan isi surat secara singkat..."></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Dynamic Requirements -->
            <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-3 text-lg">
                    <i data-lucide="upload-cloud" size="20" class="text-[#00A651]"></i> Upload Persyaratan
                </h3>
                <div id="wizard-reqs-container" class="space-y-4"></div>
            </div>
        </div>
    </div>
    
    <div class="p-4 lg:p-5 border-t bg-white flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-40 shrink-0">
        <button class="px-6 py-3 border border-gray-300 rounded-xl text-gray-600 font-bold hover:bg-gray-50 transition-colors w-full sm:w-auto">Simpan Draft</button>
        <button onclick="submitForm()" class="px-8 py-3 bg-[#00A651] text-white rounded-xl font-bold hover:bg-emerald-600 shadow-lg flex items-center justify-center gap-2 w-full sm:w-auto">
            <i data-lucide="send" size="18"></i> Ajukan Verifikasi
        </button>
    </div>
</div>
@endsection