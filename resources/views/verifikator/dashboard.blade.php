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
            <button class="bg-[#00A651] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="filter" size="18"></i> Filter
            </button>
            <button class="bg-[#F59E0B] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-yellow-500/40 hover:bg-yellow-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="download" size="18"></i> Export
            </button>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <!-- Stats Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-blue-50 p-4 rounded-xl text-blue-600 group-hover:scale-110 transition-transform"><i data-lucide="clock" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">18</div><div class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</div></div>
        </div>
        <!-- Stats Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600 group-hover:scale-110 transition-transform"><i data-lucide="alert-circle" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">5</div><div class="text-sm text-gray-500 font-medium">Perlu Revisi</div></div>
        </div>
        <!-- Stats Card 3 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-green-50 p-4 rounded-xl text-green-600 group-hover:scale-110 transition-transform"><i data-lucide="check-circle" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">42</div><div class="text-sm text-gray-500 font-medium">Terverifikasi</div></div>
        </div>
    </div>

    <div>
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-700 flex items-center gap-2">
                <i data-lucide="file-text" class="text-gray-400" size="20"></i> Daftar Pengajuan
            </h3>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Semua</button>
                <button class="px-3 py-1 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-full">Menunggu</button>
                <button class="px-3 py-1 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-full">Proses</button>
                <button class="px-3 py-1 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-full">Selesai</button>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left p-4 font-medium text-gray-700">ID</th>
                        <th class="text-left p-4 font-medium text-gray-700">Pemohon</th>
                        <th class="text-left p-4 font-medium text-gray-700">Layanan</th>
                        <th class="text-left p-4 font-medium text-gray-700">Tanggal</th>
                        <th class="text-left p-4 font-medium text-gray-700">Status</th>
                        <th class="text-left p-4 font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-4 text-sm font-mono">REG-12345</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" size="14" class="text-gray-600"></i>
                                </div>
                                <span class="text-sm font-medium">Budi Santoso</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">Izin LN: Ibadah Agama</td>
                        <td class="p-4 text-sm">27 Nov 2023</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Menunggu</span>
                        </td>
                        <td class="p-4">
                            <button class="text-[#00A651] hover:text-emerald-600 font-medium text-sm">Verifikasi</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-4 text-sm font-mono">REG-12346</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" size="14" class="text-gray-600"></i>
                                </div>
                                <span class="text-sm font-medium">Siti Nurhaliza</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">Izin LN: Pengobatan</td>
                        <td class="p-4 text-sm">26 Nov 2023</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">Revisi</span>
                        </td>
                        <td class="p-4">
                            <button class="text-[#00A651] hover:text-emerald-600 font-medium text-sm">Verifikasi</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm font-mono">REG-12347</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" size="14" class="text-gray-600"></i>
                                </div>
                                <span class="text-sm font-medium">Ahmad Fauzi</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">Cuti Diluar Tanggungan</td>
                        <td class="p-4 text-sm">25 Nov 2023</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Selesai</span>
                        </td>
                        <td class="p-4">
                            <button class="text-gray-600 hover:text-gray-800 font-medium text-sm">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection