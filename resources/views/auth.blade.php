@extends('layouts.auth')

@section('title', 'Login SIKAD')

@section('content')
<div class="min-h-screen w-full bg-[#F3F4F6] flex items-center justify-center p-4 relative overflow-hidden py-12">
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-[#00A651] rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-[#F59E0B] rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob" style="animation-delay: 2000ms;"></div>
    </div>
    <a href="{{ route('landing') }}" class="absolute top-6 left-6 flex items-center text-gray-500 hover:text-[#00A651] transition-colors z-50 font-medium bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm hover:shadow-md">
        <i data-lucide="chevron-left" size="20" class="mr-1"></i> Kembali
    </a>
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden animate-slide-up relative z-10 flex flex-col">
        <div class="bg-[#00A651] p-8 md:p-10 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent animate-pulse"></div>
            <div class="w-16 h-16 md:w-20 md:h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-6 text-2xl md:text-3xl font-bold border border-white/30 shadow-lg">KT</div>
            <h1 class="text-2xl md:text-3xl font-bold mb-2">Login SIKAD</h1>
            <p class="text-emerald-100 text-sm">Silakan masuk menggunakan NIP Pegawai</p>
        </div>
        <div class="p-8 md:p-10 space-y-6">
            <form action="{{ route('dashboard') }}" method="GET">
                <div class="space-y-1">
                    <label class="block text-sm font-bold text-gray-700 ml-1">NIP / Username</label>
                    <div class="relative group">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#00A651] transition-colors" size="20"></i>
                        <input type="text" value="19900101 202001 1 001" class="w-full pl-12 p-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-[#00A651]/20 focus:border-[#00A651] outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Password</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#00A651] transition-colors" size="20"></i>
                        <input type="password" value="password" class="w-full pl-12 p-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-[#00A651]/20 focus:border-[#00A651] outline-none transition-all">
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#00A651] hover:bg-emerald-600 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 mt-4 text-lg">
                    Masuk Aplikasi <i data-lucide="arrow-right" size="20"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection