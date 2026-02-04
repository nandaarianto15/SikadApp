@extends('layouts.app')

@section('title', 'SIKAD KALTIM')

@push('styles')
<style>
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f5f5f5;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #F59E0B;
    /* background: #00A651; */
    border-radius: 10px;
    transition: background 0.3s ease;
}

::-webkit-scrollbar-thumb:hover {
    background: #e89e0b;
}

.news-slider::-webkit-scrollbar {
    height: 6px;
}

.news-slider::-webkit-scrollbar-track {
    background: rgba(245, 245, 245, 0.5);
    border-radius: 10px;
}

.news-slider::-webkit-scrollbar-thumb {
    background: #F59E0B;
    border-radius: 10px;
    transition: background 0.3s ease;
}

.news-slider::-webkit-scrollbar-thumb:hover {
    background: #e89e0b;
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div id="beranda" class="relative min-h-[90vh] flex items-center pt-20 lg:pt-0 overflow-hidden bg-[#00A651]">
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 -left-10 w-96 h-96 bg-[#F59E0B] rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#D1FAE5] rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-32 left-20 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-60" style="animation-delay: 4s;"></div>
        <div class="hero-pattern absolute inset-0 opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#00A651]/90 via-[#059669]/80 to-[#065f46]/90 backdrop-blur-[1px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
        <div class="space-y-8 text-center lg:text-left pt-12 lg:pt-0 animate-slide-up">
            <div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6 drop-shadow-sm">Transformasi Digital <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FCD34D] to-yellow-200">Kearsipan Daerah</span></h1>
                <p class="text-lg text-emerald-50 leading-relaxed max-w-xl mx-auto lg:mx-0">Sistem pemerintahan berbasis elektronik Provinsi Kalimantan Timur. Efektif, transparan, dan terintegrasi nasional.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <button onclick="scrollToId('layanan')" class="px-8 py-4 bg-white text-[#00A651] font-bold rounded-xl hover:bg-gray-50 transition-all shadow-xl hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 group w-full sm:w-auto">
                    Lihat Layanan <i data-lucide="arrow-right" class="group-hover:translate-x-1 transition-transform" size="18"></i>
                </button>
                <a href="{{ route('auth') }}" class="px-8 py-4 bg-white/10 border border-white/30 text-white font-bold rounded-xl hover:bg-white/20 transition-all backdrop-blur-sm w-full sm:w-auto hover:-translate-y-1 active:scale-95">Login Pegawai</a>
            </div>
        </div>

        <!-- Floating Card Animation -->
        <div class="hidden lg:block relative animate-slide-up">
            <div class="relative glass-panel border border-white/40 rounded-3xl p-4 shadow-2xl transform rotate-[-3deg] hover:rotate-0 transition-transform duration-700 animate-float max-w-md mx-auto">
                <div class="bg-white rounded-2xl overflow-hidden shadow-inner min-h-[450px] flex flex-col p-6 space-y-4 relative">
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border">
                        <div class="h-4 w-24 bg-gray-200 rounded animate-pulse"></div>
                        <div class="h-4 w-4 rounded-full bg-green-400"></div>
                    </div>
                    <div class="h-48 bg-emerald-50 rounded-xl border border-emerald-100 flex items-center justify-center text-emerald-600 font-bold opacity-50 relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/30 animate-pulse"></div>PREVIEW DOKUMEN
                    </div>
                    <div class="space-y-3">
                        <div class="h-4 bg-gray-100 rounded w-full"></div>
                        <div class="h-4 bg-gray-100 rounded w-3/4"></div>
                    </div>
                    <div class="absolute -bottom-5 -right-5 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce border border-gray-100">
                        <div class="bg-green-100 p-2.5 rounded-full text-green-600"><i data-lucide="shield-check" size="28"></i></div>
                        <div><p class="text-xs text-gray-400 font-bold uppercase">Keamanan</p><p class="text-sm font-bold text-green-600">TTE BSrE Valid</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 translate-y-1 pointer-events-none">
        <svg viewBox="0 0 1440 120" fill="none" class="w-full h-auto"><path d="M0 60L48 68.3C96 76.7 192 93.3 288 91.7C384 90 480 70 576 56.7C672 43.3 768 36.7 864 45C960 53.3 1056 76.7 1152 83.3C1248 90 1344 80 1392 75L1440 70V120H1392C1344 120 1248 120 1152 120C1056 120 960 120 864 120C768 120 672 120 576 120C480 120 384 120 288 120C192 120 96 120 48 120H0V60Z" fill="white"/></svg>
    </div>
</div>

<!-- Articles Section -->
<div id="berita" class="py-16 bg-white relative z-20 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 animate-slide-up opacity-0" style="animation-fill-mode: forwards;">
            <div>
                <h2 class="text-[#00A651] font-bold uppercase tracking-widest text-xs mb-2">Informasi Terkini</h2>
                <h3 class="text-3xl font-bold text-gray-800">Berita & Pengumuman</h3>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 text-gray-400 text-xs italic">
                    <i data-lucide="info" size="12"></i> Geser untuk melihat lainnya
                </div>
            </div>
        </div>
        <!-- Dynamic Articles Container -->
        <div id="articles-container" class="news-slider flex gap-6 overflow-x-auto snap-x snap-mandatory px-2 pb-8"></div>
        
        <div class="mt-8 flex justify-center animate-slide-up opacity-0" style="animation-delay: 400ms; animation-fill-mode: forwards;">
            <a href="{{ route('news') }}" class="px-8 py-3 bg-white border border-emerald-200 text-[#00A651] font-bold rounded-full hover:bg-emerald-50 hover:shadow-md transition-all shadow-sm flex items-center gap-2 group text-xs active:scale-95">
                Lihat Berita Lainnya <i data-lucide="arrow-right" size="14" class="group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</div>

<!-- Panduan Section -->
<div id="panduan" class="py-16 bg-gray-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-slide-up">
            <h2 class="text-[#00A651] font-bold uppercase tracking-widest text-xs mb-2">Panduan Pengguna</h2>
            <h3 class="text-3xl font-bold text-gray-800">Alur Pengajuan Naskah</h3>
        </div>
        <div class="relative">
            <div class="hidden md:block absolute top-16 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-emerald-200 to-transparent z-0"></div>
            <div class="grid md:grid-cols-4 gap-10 relative z-10">
                <!-- Step 1 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-lg text-center group hover:-translate-y-2 hover:shadow-xl transition-all duration-500 animate-slide-up opacity-0" style="animation-delay: 0ms; animation-fill-mode: forwards;">
                    <div class="w-16 h-16 bg-[#00A651] text-white rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-6 ring-8 ring-emerald-50 group-hover:ring-emerald-100 transition-all duration-500 relative shadow-md">01</div>
                    <h4 class="font-bold text-xl text-gray-800 mb-3">Login & Pilih</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Masuk dengan NIP & pilih jenis layanan yang dibutuhkan.</p>
                </div>
                <!-- Step 2 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-lg text-center group hover:-translate-y-2 hover:shadow-xl transition-all duration-500 animate-slide-up opacity-0" style="animation-delay: 150ms; animation-fill-mode: forwards;">
                    <div class="w-16 h-16 bg-[#00A651] text-white rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-6 ring-8 ring-emerald-50 group-hover:ring-emerald-100 transition-all duration-500 relative shadow-md">02</div>
                    <h4 class="font-bold text-xl text-gray-800 mb-3">Lengkapi Data</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Isi formulir digital & upload dokumen persyaratan (PDF).</p>
                </div>
                <!-- Step 3 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-lg text-center group hover:-translate-y-2 hover:shadow-xl transition-all duration-500 animate-slide-up opacity-0" style="animation-delay: 300ms; animation-fill-mode: forwards;">
                    <div class="w-16 h-16 bg-[#00A651] text-white rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-6 ring-8 ring-emerald-50 group-hover:ring-emerald-100 transition-all duration-500 relative shadow-md">03</div>
                    <h4 class="font-bold text-xl text-gray-800 mb-3">Verifikasi</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Pemeriksaan berjenjang oleh atasan secara digital.</p>
                </div>
                <!-- Step 4 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-lg text-center group hover:-translate-y-2 hover:shadow-xl transition-all duration-500 animate-slide-up opacity-0" style="animation-delay: 450ms; animation-fill-mode: forwards;">
                    <div class="w-16 h-16 bg-[#00A651] text-white rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-6 ring-8 ring-emerald-50 group-hover:ring-emerald-100 transition-all duration-500 relative shadow-md">04</div>
                    <h4 class="font-bold text-xl text-gray-800 mb-3">TTE & Terbit</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Tanda tangan digital (BSrE) oleh Kepala Dinas & selesai.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fitur Section -->
<div id="fitur" class="bg-white py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 animate-slide-up">
            <h2 class="text-[#00A651] font-bold uppercase tracking-widest text-xs mb-2">Keunggulan</h2>
            <h3 class="text-3xl font-bold text-gray-800">Teknologi Pemerintahan</h3>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-2 hover:bg-white transition-all duration-500 text-center flex flex-col items-center group animate-slide-up opacity-0" style="animation-delay: 0ms; animation-fill-mode: forwards;">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 text-emerald-600"><i data-lucide="shield-check" size="32"></i></div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Tanda Tangan Elektronik</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Validasi hukum dengan BSrE.</p>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-2 hover:bg-white transition-all duration-500 text-center flex flex-col items-center group animate-slide-up opacity-0" style="animation-delay: 100ms; animation-fill-mode: forwards;">
                <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 text-yellow-600"><i data-lucide="zap" size="32"></i></div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Disposisi Digital</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Instruksi cepat & terlacak.</p>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-2 hover:bg-white transition-all duration-500 text-center flex flex-col items-center group animate-slide-up opacity-0" style="animation-delay: 200ms; animation-fill-mode: forwards;">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 text-blue-600"><i data-lucide="smartphone" size="32"></i></div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Akses Mobile</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Kerja dari mana saja.</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Section -->
<div id="statistik" class="bg-[#1F2937] text-white py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 animate-slide-up">
            <h2 class="text-emerald-400 font-bold uppercase tracking-widest text-xs mb-2">Transparansi Data</h2>
            <h3 class="text-3xl font-bold text-white">Statistik Kinerja Daerah</h3>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <!-- Stat Items -->
            <div class="p-6 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 group animate-slide-up opacity-0" style="animation-delay: 0ms; animation-fill-mode: forwards;">
                <i data-lucide="file-text" size="36" class="mx-auto mb-4 text-blue-400 group-hover:scale-110 transition-transform duration-300"></i>
                <h4 class="text-3xl font-bold mb-2">145.2K</h4>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Surat Masuk</p>
            </div>
            <div class="p-6 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 group animate-slide-up opacity-0" style="animation-delay: 100ms; animation-fill-mode: forwards;">
                <i data-lucide="send" size="36" class="mx-auto mb-4 text-green-400 group-hover:scale-110 transition-transform duration-300"></i>
                <h4 class="text-3xl font-bold mb-2">98.5K</h4>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Surat Keluar</p>
            </div>
            <div class="p-6 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 group animate-slide-up opacity-0" style="animation-delay: 200ms; animation-fill-mode: forwards;">
                <i data-lucide="users" size="36" class="mx-auto mb-4 text-purple-400 group-hover:scale-110 transition-transform duration-300"></i>
                <h4 class="text-3xl font-bold mb-2">12.4K</h4>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Pengguna</p>
            </div>
            <div class="p-6 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 group animate-slide-up opacity-0" style="animation-delay: 300ms; animation-fill-mode: forwards;">
                <i data-lucide="building" size="36" class="mx-auto mb-4 text-orange-400 group-hover:scale-110 transition-transform duration-300"></i>
                <h4 class="text-3xl font-bold mb-2">48</h4>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Instansi</p>
            </div>
        </div>
    </div>
</div>

<!-- Layanan Section -->
<div id="layanan" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12 animate-slide-up">
            <h2 class="text-[#00A651] font-bold uppercase tracking-widest text-xs mb-2">Katalog Layanan</h2>
            <h3 class="text-3xl font-bold text-gray-800 mb-3">Jenis Permohonan & Persyaratan</h3>
            <p class="text-gray-500 text-sm">Cari dan ketahui persyaratan dokumen sebelum mengajukan permohonan.</p>
        </div>

        <div class="relative max-w-xl mx-auto mb-12 animate-slide-up opacity-0" style="animation-delay: 200ms; animation-fill-mode: forwards;">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="search" class="text-gray-400" size="18"></i>
            </div>
            <input id="service-search-input" type="text" placeholder="Cari layanan (Contoh: Izin, Cuti, DPRD)..." class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#00A651]/20 focus:border-[#00A651] shadow-sm transition-all text-sm hover:shadow-md" oninput="renderServices(this.value)">
        </div>

        <!-- Dynamic Service List -->
        <div id="services-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
        <div id="services-empty" class="text-center text-gray-400 py-10 hidden">
            <p>Tidak ada layanan yang cocok dengan pencarian.</p>
        </div>
    </div>
</div>

<!-- Service Modal -->
<div id="service-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-fade-in hidden">
    
</div>
@endsection

{{-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    renderArticles();
    renderServices('');
});
</script>
@endpush --}}