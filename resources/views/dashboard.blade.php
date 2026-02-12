@extends('layouts.dashboard')

@section('title', 'Dashboard SIKAD')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto animate-[fadeIn_0.5s_ease-out]">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Pemohon</h1>
            <p class="text-gray-500 mt-1">Kelola naskah dinas dan pantau status pengajuan.</p>
        </div>
        <a href="{{ route('pemohon.select') }}" class="w-full md:w-auto bg-[#00A651] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
            <i data-lucide="pen-tool" size="18"></i> Buat Pengajuan Baru
        </a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-blue-50 p-4 rounded-xl text-blue-600 group-hover:scale-110 transition-transform"><i data-lucide="clock" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">{{ $stats['process'] }}</div><div class="text-sm text-gray-500 font-medium">Sedang Proses</div></div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600 group-hover:scale-110 transition-transform"><i data-lucide="alert-circle" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">{{ $stats['revision'] }}</div><div class="text-sm text-gray-500 font-medium">Perlu Revisi</div></div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-red-50 p-4 rounded-xl text-red-600 group-hover:scale-110 transition-transform"><i data-lucide="x-circle" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">{{ $stats['rejected'] }}</div><div class="text-sm text-gray-500 font-medium">Ditolak</div></div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-green-50 p-4 rounded-xl text-green-600 group-hover:scale-110 transition-transform"><i data-lucide="check-circle" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">{{ $stats['signed'] }}</div><div class="text-sm text-gray-500 font-medium">Naskah Terbit</div></div>
        </div>
    </div>

    <div>
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-700 flex items-center gap-2"><i data-lucide="history" class="text-gray-400" size="20"></i> Pengajuan Terakhir</h3>
            <div class="flex gap-2">
                <button onclick="filterSubmissions('all')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'all' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="all">Semua</button>
                <button onclick="filterSubmissions('process')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'process' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="process">Proses</button>
                <button onclick="filterSubmissions('revision')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'revision' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="revision">Revisi</button>
                <button onclick="filterSubmissions('rejected')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'rejected' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="rejected">Ditolak</button>
                <button onclick="filterSubmissions('signed')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'signed' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="signed">Selesai</button>
            </div>
        </div>
        
        <div id="loading-indicator" class="hidden bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-8">
            <div class="flex justify-center items-center">
                <i data-lucide="loader-2" class="animate-spin text-[#00A651] mr-2" size="24"></i>
                <span class="text-gray-600">Memuat data...</span>
            </div>
        </div>
        
        <div id="submissions-container">
            @include('submissions-table', ['submissions' => $submissions])
        </div>
    </div>
</div>

<div id="filter-modal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Filter Pengajuan</h3>
            <button onclick="toggleFilterModal()" class="p-1 hover:bg-gray-100 rounded-full">
                <i data-lucide="x" size="20" class="text-gray-500"></i>
            </button>
        </div>
        
        <form id="filter-form" action="{{ route('pemohon.dashboard') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="filter" id="filter-select" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
                    <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="process" {{ $filter === 'process' ? 'selected' : '' }}>Sedang Proses</option>
                    <option value="revision" {{ $filter === 'revision' ? 'selected' : '' }}>Perlu Revisi</option>
                    <option value="rejected" {{ $filter === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="signed" {{ $filter === 'signed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start-date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end-date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
            </div>
            
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-[#00A651] text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-600 transition-colors">
                    Terapkan Filter
                </button>
                <button type="button" onclick="resetFilter()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

<div id="filter-modal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Filter Pengajuan</h3>
            <button onclick="toggleFilterModal()" class="p-1 hover:bg-gray-100 rounded-full">
                <i data-lucide="x" size="20" class="text-gray-500"></i>
            </button>
        </div>
        
        <form id="filter-form" action="{{ route('pemohon.dashboard') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="filter" id="filter-select" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
                    <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="process" {{ $filter === 'process' ? 'selected' : '' }}">Sedang Proses</option>
                    <option value="revision" {{ $filter === 'revision' ? 'selected' : '' }}>Perlu Revisi</option>
                    <option value="rejected" {{ $filter === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="signed" {{ $filter === 'signed' ? 'selected' : '' }}">Selesai</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start-date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end-date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
            </div>
            
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-[#00A651] text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-600 transition-colors">
                    Terapkan Filter
                </button>
                <button type="button" onclick="resetFilter()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                    Reset
                </button>
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
        
        if (!modal.classList.contains('hidden')) {
            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }
    }
    
    function filterSubmissions(filter) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if (btn.dataset.filter === filter) {
                btn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                btn.classList.add('bg-blue-100', 'text-blue-700');
            } else {
                btn.classList.remove('bg-blue-100', 'text-blue-700');
                btn.classList.add('text-gray-600', 'hover:bg-gray-100');
            }
        });
        
        const url = new URL(window.location);
        url.searchParams.set('filter', filter);
        window.history.pushState({}, '', url);
        
        document.getElementById('loading-indicator').classList.remove('hidden');
        document.getElementById('submissions-container').classList.add('hidden');
        
        fetch(`/pemohon/api/filter-submissions?filter=${filter}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('submissions-container').innerHTML = data.html;
                
                const paginationContainer = document.querySelector('.pagination-container');
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                }
                
                document.getElementById('loading-indicator').classList.add('hidden');
                document.getElementById('submissions-container').classList.remove('hidden');
                
                lucide.createIcons();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loading-indicator').classList.add('hidden');
                document.getElementById('submissions-container').classList.remove('hidden');
            });
    }
    
    function resetFilter() {
        document.getElementById('filter-select').value = 'all';
        document.getElementById('start-date').value = '';
        document.getElementById('end-date').value = '';
        
        applyFilter();
    }
    
    function applyFilter() {
        const filter = document.getElementById('filter-select').value;
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        
        const params = new URLSearchParams();
        params.set('filter', filter);
        if (startDate) params.set('start_date', startDate);
        if (endDate) params.set('end_date', endDate);
        
        const url = new URL(window.location);
        url.search = params.toString();
        window.history.pushState({}, '', url);
        
        document.getElementById('loading-indicator').classList.remove('hidden');
        document.getElementById('submissions-container').classList.add('hidden');
        
        fetch(`/pemohon/api/filter-submissions?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('submissions-container').innerHTML = data.html;
                
                const paginationContainer = document.querySelector('.pagination-container');
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                }
                
                document.getElementById('loading-indicator').classList.add('hidden');
                document.getElementById('submissions-container').classList.remove('hidden');
                
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    if (btn.dataset.filter === filter) {
                        btn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                        btn.classList.add('bg-blue-100', 'text-blue-700');
                    } else {
                        btn.classList.remove('bg-blue-100', 'text-blue-700');
                        btn.classList.add('text-gray-600', 'hover:bg-gray-100');
                    }
                });
                
                toggleFilterModal();
                
                lucide.createIcons();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loading-indicator').classList.add('hidden');
                document.getElementById('submissions-container').classList.remove('hidden');
            });
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                applyFilter();
            });
        }
        
        lucide.createIcons();
    });
</script>
@endpush