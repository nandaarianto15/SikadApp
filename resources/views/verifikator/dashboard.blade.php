@extends('layouts.dashboard')

@section('title', 'Dashboard Verifikator')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto animate-[fadeIn_0.5s_ease-out]">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Verifikator</h1>
            <p class="text-gray-500 mt-1">Verifikasi dan proses pengajuan naskah dinas.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="toggleFilterModal()" class="bg-[#00A651] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="filter" size="18"></i> Filter
            </button>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stats Card 1 - Clickable -->
        {{-- <a href="{{ route('verifikator.submissions', ['filter' => 'menunggu']) }}" class="group block"> --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5">
                <div class="bg-blue-50 p-4 rounded-xl text-blue-600 group-hover:scale-110 transition-transform"><i data-lucide="clock" size="28"></i></div>
                <div><div class="text-3xl font-bold text-gray-800">{{ $stats['menunggu'] }}</div><div class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</div></div>
            </div>
        {{-- </a> --}}
        <!-- Stats Card 2 - Clickable -->
        {{-- <a href="{{ route('verifikator.submissions', ['filter' => 'revisi']) }}" class="group block"> --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5">
                <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600 group-hover:scale-110 transition-transform"><i data-lucide="alert-circle" size="28"></i></div>
                <div><div class="text-3xl font-bold text-gray-800">{{ $stats['revisi'] }}</div><div class="text-sm text-gray-500 font-medium">Perlu Revisi</div></div>
            </div>
        {{-- </a> --}}
        <!-- Stats Card 3 - Clickable (DITOLAK) -->
        {{-- <a href="{{ route('verifikator.submissions', ['filter' => 'ditolak']) }}" class="group block"> --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5">
                <div class="bg-red-50 p-4 rounded-xl text-red-600 group-hover:scale-110 transition-transform"><i data-lucide="x-circle" size="28"></i></div>
                <div><div class="text-3xl font-bold text-gray-800">{{ $stats['ditolak'] }}</div><div class="text-sm text-gray-500 font-medium">Ditolak</div></div>
            </div>
        {{-- </a> --}}
        <!-- Stats Card 4 - Clickable -->
        {{-- <a href="{{ route('verifikator.submissions', ['filter' => 'selesai']) }}" class="group block"> --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5">
                <div class="bg-green-50 p-4 rounded-xl text-green-600 group-hover:scale-110 transition-transform"><i data-lucide="check-circle" size="28"></i></div>
                <div><div class="text-3xl font-bold text-gray-800">{{ $stats['selesai'] }}</div><div class="text-sm text-gray-500 font-medium">Terverifikasi</div></div>
            </div>
        {{-- </a> --}}
    </div>

    <!-- All Submissions Table -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-700 flex items-center gap-2">
                <i data-lucide="file-text" class="text-gray-400" size="20"></i> Daftar Pengajuan
            </h3>
            <div class="flex gap-2">
                <button onclick="filterSubmissions('all')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'all' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="all">Semua</button>
                <button onclick="filterSubmissions('menunggu')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'menunggu' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="menunggu">Menunggu</button>
                <button onclick="filterSubmissions('revisi')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'revisi' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="revisi">Revisi</button>
                <button onclick="filterSubmissions('ditolak')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'ditolak' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="ditolak">Ditolak</button>
                <button onclick="filterSubmissions('selesai')" class="filter-btn px-3 py-1 text-xs font-medium {{ $filter === 'selesai' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }} rounded-full" data-filter="selesai">Selesai</button>
            </div>
        </div>
        
        <!-- Loading indicator -->
        <div id="loading-indicator" class="hidden bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-8">
            <div class="flex justify-center items-center">
                <i data-lucide="loader-2" class="animate-spin text-[#00A651] mr-2" size="24"></i>
                <span class="text-gray-600">Memuat data...</span>
            </div>
        </div>
        
        <!-- Submissions Table Container -->
        <div id="submissions-container">
            @include('verifikator.partials.submissions-table', ['submissions' => $submissions])
        </div>
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
        
        <form id="filter-form" action="{{ route('verifikator.dashboard') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="filter" id="filter-select" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent">
                    <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="menunggu" {{ $filter === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="revisi" {{ $filter === 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                    <option value="ditolak" {{ $filter === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai" {{ $filter === 'selesai' ? 'selected' : '' }}>Terverifikasi</option>
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
    // Function to toggle filter modal
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
    
    // Function to filter submissions without page refresh
    function filterSubmissions(filter) {
        // Update active filter button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if (btn.dataset.filter === filter) {
                btn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                btn.classList.add('bg-blue-100', 'text-blue-700');
            } else {
                btn.classList.remove('bg-blue-100', 'text-blue-700');
                btn.classList.add('text-gray-600', 'hover:bg-gray-100');
            }
        });
        
        // Update URL without refresh
        const url = new URL(window.location);
        url.searchParams.set('filter', filter);
        window.history.pushState({}, '', url);
        
        // Show loading indicator
        document.getElementById('loading-indicator').classList.remove('hidden');
        document.getElementById('submissions-container').classList.add('hidden');
        
        // Fetch filtered submissions
        fetch(`/verifikator/api/filter-submissions?filter=${filter}`)
            .then(response => response.json())
            .then(data => {
                // Update submissions table
                document.getElementById('submissions-container').innerHTML = data.html;
                
                // Update pagination
                const paginationContainer = document.querySelector('.pagination-container');
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                }
                
                // Hide loading indicator and show table
                document.getElementById('loading-indicator').classList.add('hidden');
                document.getElementById('submissions-container').classList.remove('hidden');
                
                // Reinitialize Lucide icons
                lucide.createIcons();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loading-indicator').classList.add('hidden');
                document.getElementById('submissions-container').classList.remove('hidden');
            });
    }
    
    // Function to reset filter
    function resetFilter() {
        document.getElementById('filter-select').value = 'all';
        document.getElementById('start-date').value = '';
        document.getElementById('end-date').value = '';
        
        // Apply reset filter
        applyFilter();
    }
    
    // Function to apply filter from modal
    function applyFilter() {
        const filter = document.getElementById('filter-select').value;
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        
        // Build query string
        const params = new URLSearchParams();
        params.set('filter', filter);
        if (startDate) params.set('start_date', startDate);
        if (endDate) params.set('end_date', endDate);
        
        // Update URL without refresh
        const url = new URL(window.location);
        url.search = params.toString();
        window.history.pushState({}, '', url);
        
        // Show loading indicator
        document.getElementById('loading-indicator').classList.remove('hidden');
        document.getElementById('submissions-container').classList.add('hidden');
        
        // Fetch filtered submissions
        fetch(`/verifikator/api/filter-submissions?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                // Update submissions table
                document.getElementById('submissions-container').innerHTML = data.html;
                
                // Update pagination
                const paginationContainer = document.querySelector('.pagination-container');
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                }
                
                // Hide loading indicator and show table
                document.getElementById('loading-indicator').classList.add('hidden');
                document.getElementById('submissions-container').classList.remove('hidden');
                
                // Update filter buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    if (btn.dataset.filter === filter) {
                        btn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                        btn.classList.add('bg-blue-100', 'text-blue-700');
                    } else {
                        btn.classList.remove('bg-blue-100', 'text-blue-700');
                        btn.classList.add('text-gray-600', 'hover:bg-gray-100');
                    }
                });
                
                // Close modal
                toggleFilterModal();
                
                // Reinitialize Lucide icons
                lucide.createIcons();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loading-indicator').classList.add('hidden');
                document.getElementById('submissions-container').classList.remove('hidden');
            });
    }
    
    // Handle filter form submission
    document.addEventListener('DOMContentLoaded', () => {
        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                applyFilter();
            });
        }
        
        // Initialize Lucide icons
        lucide.createIcons();
    });
</script>
@endpush