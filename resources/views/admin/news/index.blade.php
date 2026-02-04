@extends('layouts.dashboard')

@section('title', 'Kelola Berita')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="arrow-left" size="20" class="text-gray-600"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Berita</h1>
        </div>
        <a href="{{ route('admin.news.create') }}" class="bg-[#00A651] text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-600 transition-colors">
            <i data-lucide="plus" size="16" class="inline mr-1"></i> Tambah Berita
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left p-4 font-medium text-gray-700">Judul</th>
                        <th class="text-left p-4 font-medium text-gray-700">Kategori</th>
                        <th class="text-left p-4 font-medium text-gray-700">Penulis</th>
                        <th class="text-left p-4 font-medium text-gray-700">Status</th>
                        <th class="text-left p-4 font-medium text-gray-700">Tanggal</th>
                        <th class="text-left p-4 font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                        <i data-lucide="file-text" size="16" class="text-gray-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800 line-clamp-1">{{ $item->title }}</p>
                                    @if($item->tag)
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $item->tag }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm">{{ $item->category }}</td>
                        <td class="p-4 text-sm">{{ $item->author->name }}</td>
                        <td class="p-4">
                            @if($item->is_published)
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Diterbitkan</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">Draft</span>
                            @endif
                        </td>
                        <td class="p-4 text-sm">
                            @if($item->published_at)
                                {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800">
                                    <i data-lucide="edit" size="16"></i>
                                </a>
                                {{-- <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')"> --}}
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i data-lucide="trash-2" size="16"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t flex justify-between items-center">
            <p class="text-sm text-gray-600">Menampilkan {{ $news->firstItem() }}-{{ $news->lastItem() }} dari {{ $news->total() }} berita</p>
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection