@extends('layouts.app')

@section('title', 'Berita & Pengumuman - SIKAD KALTIM')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-r from-[#00A651] to-emerald-600 text-white">
        <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Berita & Pengumuman</h1>
                <p class="mt-6 text-lg text-emerald-100">Informasi terkini seputar kegiatan dan kebijakan Pemerintah Provinsi Kalimantan Timur</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-emerald-200 text-[#00A651] font-bold rounded-full hover:bg-emerald-50 hover:shadow-md transition-all shadow-sm group text-xs active:scale-95">
                <i data-lucide="arrow-left" size="14" class="group-hover:-translate-x-1 transition-transform"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($news as $item)
                <a href="{{ route('news.detail', $item->slug) }}" class="group w-full rounded-2xl overflow-hidden shadow-lg transition-all duration-500 border snap-center flex flex-col cursor-pointer relative h-[420px] hover:-translate-y-2 hover:shadow-2xl bg-white border-gray-100 hover:border-emerald-200">
                    <div class="relative h-48 overflow-hidden shrink-0 bg-gray-200">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />
                        @else
                            <div class="image-container w-full h-full bg-gray-300 flex items-center justify-center">
                                <i data-lucide="image" size="24" class="text-gray-400"></i>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm z-10 backdrop-blur-sm bg-[#00A651]/90">{{ $item->category ?? 'Info' }}</span>
                    </div>
                    <div class="p-5 flex flex-col flex-1 relative">
                        <div class="flex items-center gap-2 text-[10px] text-gray-500 mb-2 font-medium">
                            <span class="flex items-center gap-1"><i data-lucide="calendar" size="12" class="text-[#00A651]"></i> {{ $item->published_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-sm font-bold mb-2 leading-snug transition-colors line-clamp-2 text-gray-800 group-hover:text-[#00A651]">{{ $item->title }}</h3>
                        <p class="text-gray-600 text-[11px] leading-relaxed mb-auto line-clamp-3">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                        <div class="pt-4 mt-2 border-t flex items-center font-bold text-[10px] text-[#00A651] group/btn">
                            Selengkapnya <i data-lucide="arrow-right" size="12" class="ml-1 transition-transform group-hover/btn:translate-x-1"></i>
                        </div>
                    </div>
                </a>
            @empty
            <div class="col-span-full text-center py-12">
                <i data-lucide="inbox" size="48" class="mx-auto text-gray-400"></i>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada berita</h3>
                <p class="mt-2 text-gray-500">Belum ada berita yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>
        
        @if ($news->hasPages())
        <div class="mt-12">
            {{ $news->links() }}
        </div>
        @endif
    </div>
</div>
@endsection