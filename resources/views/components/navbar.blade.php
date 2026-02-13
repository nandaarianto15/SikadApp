@php
 $currentPage = Request::path();
 $showLandingNav = in_array($currentPage, ['', '/']) || str_contains($currentPage, 'landing');
@endphp

@if($showLandingNav)
<nav id="landing-navbar" class="fixed w-full z-50 transition-all duration-500 py-4 lg:py-6 bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3 cursor-pointer group z-50" onclick="scrollToId('beranda')">
                <div id="nav-logo-box" class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-500 group-hover:rotate-12 overflow-hidden">
                    <img src="{{ asset('img/logo-kaltim.png') }}" alt="Logo Kaltim" class="w-full h-full object-contain">
                </div>
                <div id="nav-text-box" class="flex flex-col transition-colors duration-300 text-white">
                    <span class="font-bold text-lg leading-tight tracking-tight group-hover:text-[#F59E0B] transition-colors">SIKAD <span id="nav-subtext" class="text-white">KALTIM</span></span>
                    <span class="text-[10px] uppercase tracking-widest opacity-80">Provinsi Kalimantan Timur</span>
                </div>
            </div>
            <div class="hidden lg:flex items-center gap-8 text-sm font-medium">
                <button onclick="scrollToId('beranda')" class="nav-link text-white/90 hover:text-[#F59E0B] hover:-translate-y-0.5 transition-all">Beranda</button>
                <button onclick="scrollToId('berita')" class="nav-link text-white/90 hover:text-[#F59E0B] hover:-translate-y-0.5 transition-all">Berita</button>
                <button onclick="scrollToId('panduan')" class="nav-link text-white/90 hover:text-[#F59E0B] hover:-translate-y-0.5 transition-all">Panduan</button>
                <button onclick="scrollToId('fitur')" class="nav-link text-white/90 hover:text-[#F59E0B] hover:-translate-y-0.5 transition-all">Fitur</button>
                <button onclick="scrollToId('statistik')" class="nav-link text-white/90 hover:text-[#F59E0B] hover:-translate-y-0.5 transition-all">Statistik</button>
                <button onclick="scrollToId('layanan')" class="nav-link text-white/90 hover:text-[#F59E0B] hover:-translate-y-0.5 transition-all">Layanan</button>
            </div>
            <div class="hidden lg:block">
                <a href="{{ route('auth') }}" id="nav-login-btn" class="px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 shadow-lg hover:-translate-y-0.5 hover:shadow-xl active:scale-95 bg-white text-[#00A651] hover:bg-gray-100">Masuk Aplikasi</a>
            </div>
            <div class="lg:hidden z-50">
                <button onclick="toggleMobileMenu()" id="mobile-menu-btn" class="p-2 rounded-lg transition-colors duration-300 text-white hover:bg-white/10">
                    <i data-lucide="menu" size="28"></i>
                </button>
            </div>
        </div>
    </div>
    <div id="mobile-menu" class="hidden fixed inset-0 z-40 bg-white flex flex-col pt-24 px-6 gap-6 animate-fade-in lg:hidden">
        <button onclick="mobileNav('beranda')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Beranda</button>
        <button onclick="mobileNav('berita')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Berita</button>
        <button onclick="mobileNav('panduan')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Panduan</button>
        <button onclick="mobileNav('fitur')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Fitur</button>
        <button onclick="mobileNav('layanan')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Layanan</button>
        <a href="{{ route('auth') }}" onclick="toggleMobileMenu();" class="w-full bg-[#00A651] text-white py-4 rounded-xl font-bold text-lg mt-4 shadow-lg active:scale-95">Masuk Aplikasi</a>
    </div>
</nav>
@endif