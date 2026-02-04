@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto animate-[fadeIn_0.5s_ease-out]">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1">Kelola berita, layanan, dan pantau seluruh aktivitas sistem.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.news.create') }}" class="bg-[#00A651] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="plus" size="18"></i> Tambah Berita
            </a>
            <a href="{{ route('admin.services.create') }}" class="bg-[#F59E0B] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-yellow-500/40 hover:bg-yellow-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i data-lucide="plus" size="18"></i> Tambah Layanan
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stats Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-blue-50 p-4 rounded-xl text-blue-600 group-hover:scale-110 transition-transform"><i data-lucide="users" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</div><div class="text-sm text-gray-500 font-medium">Total Pengguna</div></div>
        </div>
        <!-- Stats Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-green-50 p-4 rounded-xl text-green-600 group-hover:scale-110 transition-transform"><i data-lucide="file-text" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">{{ $totalNews }}</div><div class="text-sm text-gray-500 font-medium">Total Berita</div></div>
        </div>
        <!-- Stats Card 3 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-purple-50 p-4 rounded-xl text-purple-600 group-hover:scale-110 transition-transform"><i data-lucide="briefcase" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">{{ $totalServices }}</div><div class="text-sm text-gray-500 font-medium">Total Layanan</div></div>
        </div>
        <!-- Stats Card 4 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600 group-hover:scale-110 transition-transform"><i data-lucide="clock" size="28"></i></div>
            <div><div class="text-3xl font-bold text-gray-800">28</div><div class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</div></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-700 flex items-center gap-2">
                    <i data-lucide="file-text" class="text-gray-400" size="20"></i> Berita Terbaru
                </h3>
                <a href="{{ route('admin.news.index') }}" class="text-sm text-[#00A651] hover:text-emerald-600 font-medium">Lihat Semua</a>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-h-[300px]">
                @php
                    $recentNews = \App\Models\News::with('author')->where('is_published', true)->orderBy('published_at', 'desc')->limit(4)->get();
                @endphp
                @if($recentNews->count() > 0)
                    @foreach($recentNews as $news)
                    <div class="p-4 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-start gap-3">
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i data-lucide="image" size="16" class="text-gray-400"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 line-clamp-1">{{ $news->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">Oleh {{ $news->author->name }} • {{ is_object($news->published_at) ? $news->published_at->format('d M Y') : \Carbon\Carbon::parse($news->published_at)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="flex items-center justify-center h-[300px]">
                        <div class="text-center text-gray-400">
                            <i data-lucide="file-text" size="32" class="mx-auto mb-2"></i>
                            <p>Belum ada berita</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-700 flex items-center gap-2">
                    <i data-lucide="briefcase" class="text-gray-400" size="20"></i> Layanan Aktif
                </h3>
                <a href="{{ route('admin.services.index') }}" class="text-sm text-[#00A651] hover:text-emerald-600 font-medium">Lihat Semua</a>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-h-[300px]">
                @php
                    $activeServices = \App\Models\Service::where('is_active', true)->orderBy('name')->limit(4)->get();
                @endphp
                @if($activeServices->count() > 0)
                    @foreach($activeServices as $service)
                    <div class="p-5 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                                <i data-lucide="{{ $service->icon ?? 'file-text' }}" size="16" class="text-emerald-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">{{ $service->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $service->requirements->count() }} persyaratan</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="flex items-center justify-center h-[300px]">
                        <div class="text-center text-gray-400">
                            <i data-lucide="briefcase" size="32" class="mx-auto mb-2"></i>
                            <p>Belum ada layanan aktif</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection