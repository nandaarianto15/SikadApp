@extends('layouts.dashboard')

@section('title', 'Kelola Layanan')

@section('content')
<div class="p-4 lg:p-8 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="arrow-left" size="20" class="text-gray-600"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Layanan</h1>
        </div>
        <a href="{{ route('admin.services.create') }}" class="bg-[#F59E0B] text-white px-4 py-2 rounded-lg font-medium hover:bg-yellow-600 transition-colors">
            <i data-lucide="plus" size="16" class="inline mr-1"></i> Tambah Layanan
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left p-4 font-medium text-gray-700">Nama Layanan</th>
                        <th class="text-left p-4 font-medium text-gray-700">Icon</th>
                        <th class="text-left p-4 font-medium text-gray-700">Persyaratan</th>
                        <th class="text-left p-4 font-medium text-gray-700">Status</th>
                        <th class="text-left p-4 font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">
                            <div>
                                <p class="font-medium text-gray-800">{{ $service->name }}</p>
                                <p class="text-xs text-gray-500">{{ $service->slug }}</p>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                                <i data-lucide="{{ $service->icon ?? 'file-text' }}" size="16" class="text-emerald-600"></i>
                            </div>
                        </td>
                        <td class="p-4 text-sm">{{ $service->requirements->count() }} persyaratan</td>
                        <td class="p-4">
                            @if($service->is_active)
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">Non-aktif</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="text-blue-600 hover:text-blue-800">
                                    <i data-lucide="edit" size="16"></i>
                                </a>
                                {{-- <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')"> --}}
                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return">
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
            <p class="text-sm text-gray-600">Menampilkan {{ $services->firstItem() }}-{{ $services->lastItem() }} dari {{ $services->total() }} layanan</p>
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection