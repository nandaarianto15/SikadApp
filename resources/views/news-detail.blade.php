@extends('layouts.app')

@section('title', $news->title . ' - SIKAD KALTIM')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section with Image -->
    @if($news->image)
    <div class="relative h-64 sm:h-80 md:h-96">
        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
    </div>
    @else
    <div class="relative h-64 sm:h-80 md:h-96 bg-gradient-to-br from-[#00A651] to-emerald-600">
        <div class="absolute inset-0 flex items-center justify-center">
            <i data-lucide="file-text" size="64" class="text-white opacity-20"></i>
        </div>
    </div>
    @endif
    
    <!-- Content -->
    <div class="container mx-auto px-4 py-12 sm:px-6 lg:px-8 -mt-20 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 sm:p-8">
                    <!-- Top Bar: Back and Share Actions -->
                    <div class="flex items-center justify-between mb-6">
                        <!-- Back Button -->
                        <a href="javascript:history.back()" class="inline-flex items-center gap-2 text-gray-700 hover:text-[#00A651] transition-colors font-medium">
                            <i data-lucide="arrow-left" size="20"></i>
                            <span>Kembali</span>
                        </a>
                        
                        <!-- Share Button with WhatsApp Logo -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . url(route('news.detail', $news->slug))) }}" 
                        target="_blank"
                        class="inline-flex items-center gap-1.5 bg-green-500 text-white font-medium px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                            <!-- WhatsApp Logo SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            <span>Bagikan</span>
                        </a>
                    </div>
                    
                    <!-- Meta Information (Category and Date) -->
                    <div class="flex flex-wrap items-center gap-2 mb-4 text-sm">
                        <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                            {{ $news->category }}
                        </span>
                        <span class="text-gray-500">
                            {{ $news->published_at->format('d F Y') }}
                        </span>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">{{ $news->title }}</h1>
                    
                    <!-- Content -->
                    <div class="prose prose prose-gray-600 max-w-none">
                        {!! $news->content !!}
                    </div>
                    
                    <!-- Tags -->
                    @if($news->tag)
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach(explode(',', $news->tag) as $tag)
                        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                            {{ trim($tag) }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Related News -->
            @if(isset($relatedNews) && $relatedNews->count() > 0)
            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedNews as $related)
                    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-300">
                        @if($related->image)
                        <div class="h-32 bg-gray-200">
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="h-32 bg-gray-200 flex items-center justify-center">
                            <i data-lucide="image" size="24" class="text-gray-400"></i>
                        </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2">{{ $related->title }}</h3>
                            <p class="text-xs text-gray-500 mb-3">{{ $related->published_at->format('d M Y') }}</p>
                            <a href="{{ route('news.detail', $related->slug) }}" class="text-[#00A651] text-sm font-medium hover:text-emerald-600 transition-colors">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection