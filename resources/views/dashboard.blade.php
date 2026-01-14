@extends('layouts.dashboard')

@section('title', 'Dashboard SIKAD')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto animate-[fadeIn_0.5s_ease-out]">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Pemohon</h1>
            <p class="text-gray-500 mt-1">Kelola naskah dinas dan pantau status pengajuan.</p>
        </div>
        <a href="{{ route('select') }}" class="w-full md:w-auto bg-[#00A651] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
            <i data-lucide="pen-tool" size="18"></i> Buat Pengajuan Baru
        </a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <!-- Stats Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-blue-50 p-4 rounded-xl text-blue-600 group-hover:scale-110 transition-transform"><i data-lucide="clock" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">3</div><div class="text-sm text-gray-500 font-medium">Sedang Proses</div></div>
        </div>
        <!-- Stats Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600 group-hover:scale-110 transition-transform"><i data-lucide="alert-circle" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">1</div><div class="text-sm text-gray-500 font-medium">Perlu Revisi</div></div>
        </div>
        <!-- Stats Card 3 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-green-50 p-4 rounded-xl text-green-600 group-hover:scale-110 transition-transform"><i data-lucide="check-circle" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">128</div><div class="text-sm text-gray-500 font-medium">Naskah Terbit</div></div>
        </div>
    </div>

    <div>
        <h3 class="font-bold text-lg mb-4 text-gray-700 flex items-center gap-2"><i data-lucide="history" class="text-gray-400" size="20"></i> Pengajuan Terakhir</h3>
        <div id="recent-activity-container" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-h-[200px]">
            <!-- Dynamic content here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    renderRecentActivity();
});
</script>
@endpush