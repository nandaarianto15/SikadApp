@extends('layouts.dashboard')

@section('title', 'Pilih Jenis Naskah')

@section('content')
<div class="min-h-screen bg-[#F3F4F6] p-4 lg:p-6 font-sans">
    <div class="max-w-7xl mx-auto animate-[slideUp_0.5s_ease-out]">
        <a href="{{ route('pemohon.dashboard') }}" class="mb-8 flex items-center text-gray-500 hover:text-[#00A651] font-bold transition-colors group">
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm mr-2 group-hover:shadow-md transition-all"><i data-lucide="chevron-left" size="20"></i></div> Kembali ke Dashboard
        </a>
        <div class="text-center mb-12">
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Pilih Jenis Naskah Dinas</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Silakan pilih template naskah yang ingin Anda ajukan.</p>
        </div>
        <div id="select-type-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-12"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
</script>
@endpush