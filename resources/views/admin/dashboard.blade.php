@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto animate-[fadeIn_0.5s_ease-out]">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1">Kelola pengguna, layanan, dan pantau seluruh aktivitas sistem.</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-[#00A651] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="users" size="18"></i> Kelola Pengguna
            </button>
            <button class="bg-[#F59E0B] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-yellow-500/40 hover:bg-yellow-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="settings" size="18"></i> Pengaturan
            </button>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stats Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-blue-50 p-4 rounded-xl text-blue-600 group-hover:scale-110 transition-transform"><i data-lucide="users" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">125</div><div class="text-sm text-gray-500 font-medium">Total Pengguna</div></div>
        </div>
        <!-- Stats Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-green-50 p-4 rounded-xl text-green-600 group-hover:scale-110 transition-transform"><i data-lucide="check-circle" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">542</div><div class="text-sm text-gray-500 font-medium">Pengajuan Selesai</div></div>
        </div>
        <!-- Stats Card 3 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600 group-hover:scale-110 transition-transform"><i data-lucide="clock" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">28</div><div class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</div></div>
        </div>
        <!-- Stats Card 4 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-purple-50 p-4 rounded-xl text-purple-600 group-hover:scale-110 transition-transform"><i data-lucide="file-text" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">7</div><div class="text-sm text-gray-500 font-medium">Total Layanan</div></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
            <h3 class="font-bold text-lg mb-4 text-gray-700 flex items-center gap-2">
                <i data-lucide="activity" class="text-gray-400" size="20"></i> Aktivitas Terkini
            </h3>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-h-[300px]">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i data-lucide="user" size="18" class="text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">User baru terdaftar</p>
                            <p class="text-xs text-gray-500">2 jam yang lalu</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i data-lucide="check-circle" size="18" class="text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Pengajuan disetujui</p>
                            <p class="text-xs text-gray-500">3 jam yang lalu</p>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i data-lucide="file-text" size="18" class="text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Layanan baru ditambahkan</p>
                            <p class="text-xs text-gray-500">5 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="font-bold text-lg mb-4 text-gray-700 flex items-center gap-2">
                <i data-lucide="bar-chart-2" class="text-gray-400" size="20"></i> Statistik Pengajuan
            </h3>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 min-h-[300px] flex items-center justify-center">
                <p class="text-gray-400">Grafik statistik akan ditampilkan di sini</p>
            </div>
        </div>
    </div>
</div>
@endsection