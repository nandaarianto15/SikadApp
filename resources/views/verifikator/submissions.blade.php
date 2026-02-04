@extends('layouts.dashboard')

@section('title', 'Daftar Pengajuan')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto animate-[fadeIn_0.5s_ease-out]">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Pengajuan</h1>
            <p class="text-gray-500 mt-1">Kelola semua pengajuan naskah dinas.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="toggleFilterModal()" class="bg-[#00A651] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="filter" size="18"></i> Filter
            </button>
            <a href="{{ route('verifikator.dashboard') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-gray-500/40 hover:bg-gray-700 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="arrow-left" size="18"></i> Kembali
            </a>
        </div>
    </div>

    <!-- All Submissions Table -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-700 flex items-center gap-2">
                <i data-lucide="file-text" class="text-gray-400" size="20"></i> Daftar Pengajuan
            </h3>
            <div class="flex gap-2">
                <a href="{{ route('verifikator.submissions', ['filter' => 'all']) }}" class="px-3 py-1 text-xs font-medium {{ $filter === 'all' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full">Semua</a>
                <a href="{{ route('verifikator.submissions', ['filter' => 'menunggu']) }}" class="px-3 py-1 text-xs font-medium {{ $filter === 'menunggu' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full">Menunggu</a>
                <a href="{{ route('verifikator.submissions', ['filter' => 'revisi']) }}" class="px-3 py-1 text-xs font-medium {{ $filter === 'revisi' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full">Revisi</a>
                <a href="{{ route('verifikator.submissions', ['filter' => 'selesai']) }}" class="px-3 py-1 text-xs font-medium {{ $filter === 'selesai' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full">Selesai</a>
            </div>
        </div>
        
        @include('verifikator.partials.submissions-table', ['submissions' => $submissions])
    </div>
</div>

<!-- Filter Modal -->
<div id="filter-modal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Filter Pengajuan</h3>
            <button onclick="toggleFilterModal()" class="p-1 hover:bg-gray-100 rounded-full">
                <i data-lucide="x" size="20" class="text-gray-500"></i>
            </button>
        </div>
        
        <form action="{{ route('verifikator.submissions') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
                    <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="menunggu" {{ $filter === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="revisi" {{ $filter === 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                    <option value="selesai" {{ $filter === 'selesai' ? 'selected' : '' }}>Terverifikasi</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
            </div>
            
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-[#00A651] text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-600 transition-colors">
                    Terapkan Filter
                </button>
                <a href="{{ route('verifikator.submissions') }}" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleFilterModal() {
        const modal = document.getElementById('filter-modal');
        modal.classList.toggle('hidden');
        
        // Reinitialize Lucide icons when modal is shown
        if (!modal.classList.contains('hidden')) {
            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Lucide icons
        lucide.createIcons();
    });
</script>
@endpush