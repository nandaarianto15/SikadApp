<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAD KALTIM - Transformasi Digital Kearsipan</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Animation Keyframes from Original React Code */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-custom {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
 
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-blob { animation: blob 10s infinite; }
        .animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        
        /* Utility Classes */
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .hero-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1.5px, transparent 1.5px);
            background-size: 30px 30px;
        }
        .news-slider::-webkit-scrollbar { height: 6px; }
        .news-slider::-webkit-scrollbar-track { background: transparent; }
        .news-slider::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .news-slider::-webkit-scrollbar-thumb:hover { background: #00A651; }
        
        .double-border {
            border-bottom: 4px solid black;
            position: relative;
        }
        .double-border::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            border-bottom: 1px solid black;
        }
 
        /* View Management */
        .view-section { display: none; }
        .view-section.active { display: block; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 overflow-x-hidden w-full">
 
    <!-- ========================================== -->
    <!-- VIEW: LANDING PAGE -->
    <!-- ========================================== -->
    <div id="view-landing" class="view-section active">
        <!-- Navbar -->
        <nav id="landing-navbar" class="fixed w-full z-50 transition-all duration-500 py-4 lg:py-6 bg-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3 cursor-pointer group z-50" onclick="scrollToId('beranda')">
                        <div id="nav-logo-box" class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xl shadow-sm transition-all duration-500 group-hover:rotate-12 bg-white text-[#00A651]">KT</div>
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
                        <button onclick="navigateTo('auth')" id="nav-login-btn" class="px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 shadow-lg hover:-translate-y-0.5 hover:shadow-xl active:scale-95 bg-white text-[#00A651] hover:bg-gray-100">Masuk Aplikasi</button>
                    </div>
                    <div class="lg:hidden z-50">
                        <button onclick="toggleMobileMenu()" id="mobile-menu-btn" class="p-2 rounded-lg transition-colors duration-300 text-white hover:bg-white/10">
                            <i data-lucide="menu" size="28"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden fixed inset-0 z-40 bg-white flex flex-col pt-24 px-6 gap-6 animate-fade-in lg:hidden">
                <button onclick="mobileNav('beranda')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Beranda</button>
                <button onclick="mobileNav('berita')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Berita</button>
                <button onclick="mobileNav('panduan')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Panduan</button>
                <button onclick="mobileNav('fitur')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Fitur</button>
                <button onclick="mobileNav('layanan')" class="text-left text-2xl font-bold text-gray-800 border-b border-gray-100 pb-4 active:text-[#00A651]">Layanan</button>
                <button onclick="toggleMobileMenu(); navigateTo('auth');" class="w-full bg-[#00A651] text-white py-4 rounded-xl font-bold text-lg mt-4 shadow-lg active:scale-95">Masuk Aplikasi</button>
            </div>
        </nav>
 
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
                        <div class="inline-block px-3 py-1 bg-white/10 rounded-full backdrop-blur-md border border-white/20 text-xs font-bold text-white mb-6">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full inline-block mr-2 animate-pulse"></span>Versi 4.6.1 (Restored)
                        </div>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6 drop-shadow-sm">Transformasi Digital <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FCD34D] to-yellow-200">Kearsipan Daerah</span></h1>
                        <p class="text-lg text-emerald-50 leading-relaxed max-w-xl mx-auto lg:mx-0">Sistem pemerintahan berbasis elektronik Provinsi Kalimantan Timur. Efektif, transparan, dan terintegrasi nasional.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <button onclick="scrollToId('layanan')" class="px-8 py-4 bg-white text-[#00A651] font-bold rounded-xl hover:bg-gray-50 transition-all shadow-xl hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 group w-full sm:w-auto">
                            Lihat Layanan <i data-lucide="arrow-right" class="group-hover:translate-x-1 transition-transform" size="18"></i>
                        </button>
                        <button onclick="navigateTo('auth')" class="px-8 py-4 bg-white/10 border border-white/30 text-white font-bold rounded-xl hover:bg-white/20 transition-all backdrop-blur-sm w-full sm:w-auto hover:-translate-y-1 active:scale-95">Login Pegawai</button>
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
                    <div class="hidden md:flex items-center gap-2 text-gray-400 text-xs italic">
                        <i data-lucide="info" size="12"></i> Geser untuk melihat lainnya
                    </div>
                </div>
                <!-- Dynamic Articles Container -->
                <div id="articles-container" class="news-slider flex gap-6 overflow-x-auto snap-x snap-mandatory px-2 pb-8"></div>
                
                <div class="mt-8 flex justify-center animate-slide-up opacity-0" style="animation-delay: 400ms; animation-fill-mode: forwards;">
                    <button class="px-8 py-3 bg-white border border-emerald-200 text-[#00A651] font-bold rounded-full hover:bg-emerald-50 hover:shadow-md transition-all shadow-sm flex items-center gap-2 group text-xs active:scale-95">
                        Lihat Berita Lainnya <i data-lucide="arrow-right" size="14" class="group-hover:translate-x-1 transition-transform"></i>
                    </button>
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
                    <div class="hidden md:block absolute top-10 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-emerald-200 to-transparent z-0"></div>
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
 
        <!-- Footer -->
        <footer class="bg-[#111827] text-white pt-16 pb-8 border-t-4 border-[#F59E0B]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-12 mb-12 text-center md:text-left">
                    <div class="md:col-span-1 animate-slide-up">
                        <h3 class="text-xl font-bold mb-4 flex items-center justify-center md:justify-start gap-3">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-[#00A651] font-bold text-base">KT</div>
                            SIKAD KALTIM
                        </h3>
                        <p class="text-gray-400 text-xs leading-relaxed">
                            Sistem Informasi Kearsipan Dinamis. Mewujudkan Good Governance melalui teknologi.
                        </p>
                    </div>
                    <div class="animate-slide-up opacity-0" style="animation-delay: 100ms; animation-fill-mode: forwards;">
                        <h4 class="font-bold text-white mb-4 uppercase tracking-wider text-xs">Hubungi Kami</h4>
                        <ul class="space-y-2 text-gray-400 text-xs">
                            <li class="flex gap-2 justify-center md:justify-start hover:text-emerald-400 transition-colors cursor-pointer"><i data-lucide="home" size="14"></i> Jl. Basuki Rahmat No. 41</li>
                            <li class="flex gap-2 justify-center md:justify-start hover:text-emerald-400 transition-colors cursor-pointer"><i data-lucide="check-circle" size="14"></i> Samarinda, Kalimantan Timur</li>
                            <li class="flex gap-2 justify-center md:justify-start hover:text-emerald-400 transition-colors cursor-pointer"><i data-lucide="lock" size="14"></i> helpdesk@kaltimprov.go.id</li>
                        </ul>
                    </div>
                    <div class="animate-slide-up opacity-0" style="animation-delay: 200ms; animation-fill-mode: forwards;">
                        <h4 class="font-bold text-white mb-4 uppercase tracking-wider text-xs">Tautan</h4>
                        <ul class="space-y-2 text-gray-400 text-xs">
                            <li><a href="#" class="hover:text-[#00A651] hover:underline transition-all">Panduan Pengguna</a></li>
                            <li><a href="#" class="hover:text-[#00A651] hover:underline transition-all">Statistik Daerah</a></li>
                            <li><a href="#" class="hover:text-[#00A651] hover:underline transition-all">Website Pemprov</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-xs text-gray-600 text-center">
                    © 2024 Pemerintah Provinsi Kalimantan Timur.
                </div>
            </div>
        </footer>
        
        <!-- Service Modal -->
        <div id="service-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-fade-in hidden">
            <!-- Content injected by JS -->
        </div>
    </div>
 
    <!-- ========================================== -->
    <!-- VIEW: AUTH SCREEN -->
    <!-- ========================================== -->
    <div id="view-auth" class="view-section">
        <div class="min-h-screen w-full bg-[#F3F4F6] flex items-center justify-center p-4 relative overflow-hidden py-12">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-[#00A651] rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-[#F59E0B] rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob" style="animation-delay: 2000ms;"></div>
            </div>
            <button onclick="navigateTo('landing')" class="absolute top-6 left-6 flex items-center text-gray-500 hover:text-[#00A651] transition-colors z-50 font-medium bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm hover:shadow-md">
                <i data-lucide="chevron-left" size="20" class="mr-1"></i> Kembali
            </button>
            <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden animate-slide-up relative z-10 flex flex-col">
                <div class="bg-[#00A651] p-8 md:p-10 text-center text-white relative overflow-hidden">
                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent animate-pulse"></div>
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-6 text-2xl md:text-3xl font-bold border border-white/30 shadow-lg">KT</div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">Login SIKAD</h1>
                    <p class="text-emerald-100 text-sm">Silakan masuk menggunakan NIP Pegawai</p>
                </div>
                <div class="p-8 md:p-10 space-y-6">
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
                    <button onclick="navigateTo('app-dashboard')" class="w-full bg-[#00A651] hover:bg-emerald-600 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 mt-4 text-lg">
                        Masuk Aplikasi <i data-lucide="arrow-right" size="20"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
 
    <!-- ========================================== -->
    <!-- VIEW: APP DASHBOARD -->
    <!-- ========================================== -->
    <div id="view-app-dashboard" class="view-section">
        <div class="min-h-screen bg-[#F3F4F6] font-sans">
            <!-- App Navbar -->
            <nav class="bg-[#00A651] text-white p-4 shadow-md sticky top-0 z-40">
                <div class="max-w-7xl mx-auto flex justify-between items-center px-2 lg:px-4">
                    <div class="flex items-center gap-3 font-bold text-lg">
                        <div class="w-9 h-9 bg-white text-[#00A651] rounded-lg flex items-center justify-center shadow-sm">KT</div>
                        <span class="hidden sm:inline tracking-tight">SIKAD <span class="opacity-80 font-normal">Internal</span></span>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-3 bg-emerald-700/50 py-1.5 pl-2 pr-4 rounded-full border border-emerald-500/30">
                            <div class="w-8 h-8 bg-white text-[#00A651] rounded-full flex items-center justify-center font-bold text-xs border-2 border-emerald-200">BS</div>
                            <div class="flex flex-col leading-none hidden sm:flex"><span class="font-bold">Budi Santoso</span><span class="text-[10px] text-emerald-100 opacity-80">Staf Pelaksana</span></div>
                        </div>
                        <button onclick="logout()" class="p-2.5 hover:bg-emerald-700 rounded-full transition-colors text-emerald-100 hover:text-white active:scale-95" title="Keluar"><i data-lucide="log-out" size="20"></i></button>
                    </div>
                </div>
            </nav>
 
            <div class="p-4 lg:p-8 max-w-7xl mx-auto animate-[fadeIn_0.5s_ease-out]">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div><h1 class="text-2xl font-bold text-gray-800">Dashboard Pemohon</h1><p class="text-gray-500 mt-1">Kelola naskah dinas dan pantau status pengajuan.</p></div>
                    <button onclick="navigateTo('app-select')" class="w-full md:w-auto bg-[#00A651] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                        <i data-lucide="pen-tool" size="18"></i> Buat Pengajuan Baru
                    </button>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                    <!-- Stats Card 1 -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
                        <div class="bg-blue-50 p-4 rounded-xl text-blue-600 group-hover:scale-110 transition-transform"><i data-lucide="clock" size="28"></i></div>
                        <div><div class="text-3xl font-bold text-gray-800">3</div><div class="text-sm text-gray-500 font-medium">Sedang Proses</div></div>
                    </div>
                    <!-- Stats Card 2 -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
                        <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600 group-hover:scale-110 transition-transform"><i data-lucide="alert-circle" size="28"></i></div>
                        <div><div class="text-3xl font-bold text-gray-800">1</div><div class="text-sm text-gray-500 font-medium">Perlu Revisi</div></div>
                    </div>
                    <!-- Stats Card 3 -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
                        <div class="bg-green-50 p-4 rounded-xl text-green-600 group-hover:scale-110 transition-transform"><i data-lucide="check-circle" size="28"></i></div>
                        <div><div class="text-3xl font-bold text-gray-800">128</div><div class="text-sm text-gray-500 font-medium">Naskah Terbit</div></div>
                    </div>
                </div>
 
                <div>
                    <h3 class="font-bold text-lg mb-4 text-gray-700 flex items-center gap-2"><i data-lucide="history" class="text-gray-400" size="20"></i> Pengajuan Terakhir</h3>
                    <div id="recent-activity-container" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-h-[200px]">
                        <!-- Dynamic content here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <!-- ========================================== -->
    <!-- VIEW: APP SELECT TYPE -->
    <!-- ========================================== -->
    <div id="view-app-select" class="view-section">
        <div class="min-h-screen bg-[#F3F4F6] p-4 lg:p-6 font-sans">
            <div class="max-w-7xl mx-auto animate-[slideUp_0.5s_ease-out]">
                <button onclick="navigateTo('app-dashboard')" class="mb-8 flex items-center text-gray-500 hover:text-[#00A651] font-bold transition-colors group">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm mr-2 group-hover:shadow-md transition-all"><i data-lucide="chevron-left" size="20"></i></div> Kembali ke Dashboard
                </button>
                <div class="text-center mb-12">
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Pilih Jenis Naskah Dinas</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Silakan pilih template naskah yang ingin Anda ajukan.</p>
                </div>
                <!-- Dynamic Select Grid -->
                <div id="select-type-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-12"></div>
            </div>
        </div>
    </div>
 
    <!-- ========================================== -->
    <!-- VIEW: APP FORM WIZARD -->
    <!-- ========================================== -->
    <div id="view-app-wizard" class="view-section">
        <div class="flex flex-col h-screen bg-[#F3F4F6] font-sans">
            <div class="bg-white px-4 lg:px-6 py-4 border-b flex items-center justify-between shadow-sm sticky top-0 z-40 shrink-0">
                <div class="flex items-center gap-4">
                    <button onclick="navigateTo('app-select')" class="hover:bg-gray-100 p-2 rounded-full transition-colors"><i data-lucide="chevron-left" size="24" class="text-gray-500"></i></button>
                    <div>
                        <h2 class="font-bold text-lg text-gray-800 flex flex-col sm:flex-row sm:items-center sm:gap-2">
                            <span>Pengajuan</span><span id="wizard-title" class="text-[#00A651] truncate max-w-[200px] sm:max-w-none">...</span>
                        </h2>
                        <p class="text-xs text-gray-500 hidden sm:block">Lengkapi data dan dokumen persyaratan</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-full text-xs text-gray-500 font-medium">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div><span class="hidden sm:inline">Draft Tersimpan</span>
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto p-4 lg:p-8">
                <div class="max-w-4xl mx-auto space-y-6 lg:space-y-8 animate-[slideUp_0.5s_ease-out]">
                    <!-- Form Utama -->
                    <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-3 text-lg">
                            <i data-lucide="file-text" size="20" class="text-[#00A651]"></i> Data Utama Naskah
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 group">
                                <label class="text-sm font-bold text-gray-700 mb-1 block">Perihal / Judul</label>
                                <input type="text" id="input-perihal" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="Contoh: Permohonan Izin...">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-700 mb-1 block">Tujuan Surat</label>
                                <input type="text" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="Kepada Yth...">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-700 mb-1 block">Tanggal Surat</label>
                                <input type="date" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none">
                            </div>
                            <div class="col-span-2">
                                <label class="text-sm font-bold text-gray-700 mb-1 block">Isi Ringkas</label>
                                <textarea class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" rows="4" placeholder="Jelaskan isi surat secara singkat..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dynamic Requirements -->
                    <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-3 text-lg">
                            <i data-lucide="upload-cloud" size="20" class="text-[#00A651]"></i> Upload Persyaratan
                        </h3>
                        <div id="wizard-reqs-container" class="space-y-4"></div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 lg:p-5 border-t bg-white flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-40 shrink-0">
                <button class="px-6 py-3 border border-gray-300 rounded-xl text-gray-600 font-bold hover:bg-gray-50 transition-colors w-full sm:w-auto">Simpan Draft</button>
                <button onclick="submitForm()" class="px-8 py-3 bg-[#00A651] text-white rounded-xl font-bold hover:bg-emerald-600 shadow-lg flex items-center justify-center gap-2 w-full sm:w-auto">
                    <i data-lucide="send" size="18"></i> Ajukan Verifikasi
                </button>
            </div>
        </div>
    </div>
 
    <!-- ========================================== -->
    <!-- VIEW: APP TRACKING -->
    <!-- ========================================== -->
    <div id="view-app-tracking" class="view-section">
        <div class="flex flex-col h-screen bg-[#F3F4F6] font-sans">
            <div class="bg-white border-b px-4 lg:px-6 py-4 flex items-center gap-4 shadow-sm sticky top-0 z-40 shrink-0">
                <button onclick="navigateTo('app-dashboard')" class="hover:bg-gray-100 p-2 rounded-full transition-colors"><i data-lucide="chevron-left" size="24" class="text-gray-500"></i></button>
                <div>
                    <h1 class="font-bold text-lg text-gray-800">Status Pengajuan</h1>
                    <p id="tracking-id" class="text-xs text-gray-500 font-mono mt-0.5">ID: ...</p>
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto p-4 md:p-8">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6 animate-[slideUp_0.6s_ease-out]">
                        
                        <!-- Status Messages Rendered Here -->
                        <div id="tracking-status-message"></div>
 
                        <!-- Document Preview -->
                        <div class="bg-gray-500/5 rounded-2xl p-2 border border-black/5 overflow-x-auto">
                            <div class="bg-white rounded-xl shadow-lg min-w-[320px] min-h-[600px] flex flex-col items-center p-8 md:p-12 relative overflow-hidden mx-auto">
                                <div class="w-full max-w-[210mm] text-[12px] leading-relaxed relative font-serif text-gray-800">
                                    <div class="text-center font-bold border-b-4 double-border border-black pb-4 mb-8">
                                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-2">
                                            <div class="w-14 h-16 bg-yellow-400/20 grayscale opacity-50 flex items-center justify-center border border-black/20 text-[8px] shrink-0">LOGO</div>
                                            <div>
                                                <div class="text-lg tracking-widest">PEMERINTAH PROVINSI KALIMANTAN TIMUR</div>
                                                <div class="text-xl sm:text-2xl tracking-wide">DINAS KOMUNIKASI DAN INFORMATIKA</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-8 overflow-x-auto">
                                        <table class="w-full min-w-[300px]">
                                            <tbody>
                                                <tr><td class="w-20 align-top">Nomor</td><td id="preview-nomor" class="align-top">: ___/___/____</td><td class="text-right align-top hidden sm:table-cell">Samarinda, <span id="preview-date"></span></td></tr>
                                                <tr><td class="align-top">Perihal</td><td class="align-top">: <b id="preview-perihal">Draft</b></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-justify mb-4 indent-8 leading-loose">Sehubungan dengan kegiatan implementasi Sistem Pemerintahan Berbasis Elektronik (SPBE), dengan ini kami sampaikan permohonan sebagaimana terlampir.</p>
                                    <div class="mt-12 text-right">
                                        <p>Hormat Kami,</p>
                                        <div class="h-20"></div>
                                        <p class="font-bold">Pemohon</p>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <!-- Detail Requirements -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i data-lucide="file-text" size="20" class="text-[#00A651]"></i> Detail Dokumen Persyaratan
                            </h3>
                            <div id="tracking-reqs-list" class="grid gap-3"></div>
                        </div>
                    </div>
 
                    <!-- Sidebar Timeline -->
                    <div class="space-y-6 animate-[slideUp_0.8s_ease-out]">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-3 text-lg border-b pb-4">
                                <i data-lucide="history" size="20" class="text-[#00A651]"></i> Riwayat Proses
                            </h3>
                            <div id="tracking-timeline" class="relative flex flex-col gap-0">
                                <!-- Generated by JS -->
                            </div>
                            
                            <!-- Debug Controls -->
                            <div class="mt-8 pt-6 border-t border-gray-100">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 text-center">Simulasi Debugging</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <button onclick="updateTrackingStatus('revision')" class="bg-white border border-red-200 text-red-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-red-50 transition-colors shadow-sm">Simulasi Ditolak</button>
                                    <button onclick="updateTrackingStatus('signed')" class="bg-white border border-green-200 text-green-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-green-50 transition-colors shadow-sm">Simulasi Sukses</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <!-- ========================================== -->
    <!-- LOGIC SCRIPT -->
    <!-- ========================================== -->
    <script>
        // --- DATA ---
        const LETTER_TYPES = [
            { id: 'izin_ln_ibadah', label: 'Izin LN: Ibadah Agama', icon: 'plane', desc: 'Persyaratan Pemberian Izin Perjalanan Ke Luar Negeri Dengan Alasan Penting Untuk Melaksanakan Ibadah Agama', reqs: ['Surat Permohonan', 'Jadwal Perjalanan', 'Jaminan Travel', 'KTP'] },
            { id: 'izin_ln_obat', label: 'Izin LN: Pengobatan', icon: 'stethoscope', desc: 'Persyaratan Pemberian Izin Perjalanan ke Luar Negeri Dengan Alasan Penting Untuk Menjalani Pengobatan', reqs: ['Rujukan RS', 'Jadwal Pengobatan', 'Keterangan Dokter', 'Paspor'] },
            { id: 'pj_bupati', label: 'Penjabat Bupati/Walikota', icon: 'shield-check', desc: 'Pengusulan Penjabat Bupati/Walikota', reqs: ['Usulan Gubernur', 'Riwayat Hidup', 'SK Pangkat'] },
            { id: 'izin_ln_keluarga', label: 'Izin LN: Keluarga', icon: 'users', desc: 'Persyaratan Pemberian Izin Perjalanan ke Luar Negeri Dengan Alasan Penting Untuk Kepentingan Keluarga', reqs: ['Keterangan Kondisi', 'Bukti Kekerabatan', 'Permohonan'] },
            { id: 'cuti_kdh', label: 'Cuti Diluar Tanggungan', icon: 'file-text', desc: 'Cuti Diluar Tanggungan Negara Bagi KDH dan WKDH', reqs: ['Permohonan Cuti', 'Alasan', 'Jadwal'] },
            { id: 'izin_ln_umum', label: 'Izin Keluar Negeri', icon: 'globe', desc: 'Izin Keluar Negeri (Umum)', reqs: ['Undangan LN', 'Jadwal', 'Surat Tugas'] },
            { id: 'izin_kerjasama', label: 'Izin Kerjasama', icon: 'briefcase', desc: 'Permohonan Izin Kerjasama Daerah', reqs: ['Draft MoU', 'Kajian', 'Profil Mitra'] }
        ];
 
        const ARTICLES = [
            { id: 1, title: "Transformasi Digital: Pemprov Kaltim Luncurkan SIKAD V5", date: "28 Nov 2025", tag: "Terbaru", category: "Utama", image: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=400&auto=format&fit=crop", desc: "Peningkatan sistem kearsipan dengan fitur integrasi TTE yang lebih stabil." },
            { id: 2, title: "Sosialisasi Tanda Tangan Elektronik Wilayah Selatan", date: "27 Nov 2025", tag: "Info", category: "Kegiatan", image: "https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=400&auto=format&fit=crop", desc: "Dinas Kominfo menggelar sosialisasi penggunaan sertifikat elektronik." },
            { id: 3, title: "Bimtek Kearsipan Digital Bagi Operator", date: "25 Nov 2025", tag: "Diklat", category: "Pelatihan", image: "https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=400&auto=format&fit=crop", desc: "Meningkatkan kompetensi SDM dalam pengelolaan arsip digital." }
        ];
 
        // --- STATE ---
        let currentSubmission = null;
        let selectedType = null;
        let trackingStatus = 'process';
 
        // --- INIT ---
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            renderArticles();
            renderServices('');
            
            // Set date on preview
            const dateSpan = document.getElementById('preview-date');
            if(dateSpan) dateSpan.innerText = new Date().toLocaleDateString('id-ID');
        });
 
        // --- NAVIGATION ---
        function navigateTo(viewId) {
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.getElementById(`view-${viewId}`).classList.add('active');
            window.scrollTo(0,0);
            lucide.createIcons();
        }
 
        function scrollToId(id) {
            const el = document.getElementById(id);
            if(el) el.scrollIntoView({ behavior: 'smooth' });
        }
 
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
 
        function mobileNav(id) {
            scrollToId(id);
            toggleMobileMenu();
        }
 
        function logout() {
            currentSubmission = null;
            navigateTo('landing');
        }
 
        // --- LANDING PAGE LOGIC ---
        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('landing-navbar');
            const logoBox = document.getElementById('nav-logo-box');
            const textBox = document.getElementById('nav-text-box');
            const subText = document.getElementById('nav-subtext');
            const loginBtn = document.getElementById('nav-login-btn');
            const menuBtn = document.getElementById('mobile-menu-btn');
            const links = document.querySelectorAll('.nav-link');
 
            if (window.scrollY > 20) {
                nav.classList.add('bg-white', 'shadow-md', 'py-3');
                nav.classList.remove('bg-transparent', 'py-4', 'lg:py-6');
                
                logoBox.classList.remove('bg-white', 'text-[#00A651]');
                logoBox.classList.add('bg-[#00A651]', 'text-white');
                
                textBox.classList.remove('text-white');
                textBox.classList.add('text-[#1F2937]');
                
                subText.classList.remove('text-white');
                subText.classList.add('text-[#00A651]');
 
                loginBtn.classList.remove('bg-white', 'text-[#00A651]');
                loginBtn.classList.add('bg-[#00A651]', 'text-white', 'hover:bg-emerald-700');
 
                menuBtn.classList.remove('text-white', 'hover:bg-white/10');
                menuBtn.classList.add('text-gray-800', 'hover:bg-gray-100');
 
                links.forEach(l => {
                    l.classList.remove('text-white/90');
                    l.classList.add('text-gray-600');
                });
            } else {
                nav.classList.remove('bg-white', 'shadow-md', 'py-3');
                nav.classList.add('bg-transparent', 'py-4', 'lg:py-6');
 
                logoBox.classList.add('bg-white', 'text-[#00A651]');
                logoBox.classList.remove('bg-[#00A651]', 'text-white');
 
                textBox.classList.add('text-white');
                textBox.classList.remove('text-[#1F2937]');
 
                subText.classList.add('text-white');
                subText.classList.remove('text-[#00A651]');
 
                loginBtn.classList.add('bg-white', 'text-[#00A651]');
                loginBtn.classList.remove('bg-[#00A651]', 'text-white', 'hover:bg-emerald-700');
 
                menuBtn.classList.add('text-white', 'hover:bg-white/10');
                menuBtn.classList.remove('text-gray-800', 'hover:bg-gray-100');
 
                links.forEach(l => {
                    l.classList.add('text-white/90');
                    l.classList.remove('text-gray-600');
                });
            }
        });
 
        // Render Articles
        function renderArticles() {
            const container = document.getElementById('articles-container');
            container.innerHTML = ARTICLES.map((article, idx) => {
                const isLatest = article.tag === 'Terbaru';
                return `
                <div class="group min-w-[280px] max-w-[280px] rounded-2xl overflow-hidden shadow-lg transition-all duration-500 border snap-center flex flex-col cursor-pointer relative h-[340px] hover:-translate-y-2 hover:shadow-2xl ${isLatest ? 'bg-gradient-to-br from-yellow-50 to-orange-50 border-yellow-200 ring-1 ring-yellow-400/40' : 'bg-white border-gray-100 hover:border-emerald-200'}" style="animation: slideUp 0.5s forwards ${idx * 100}ms; opacity: 0;">
                    <div class="relative h-40 overflow-hidden shrink-0 bg-gray-200">
                        <img src="${article.image}" alt="${article.title}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />
                        <span class="absolute top-3 left-3 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm z-10 backdrop-blur-sm ${isLatest ? 'bg-[#F59E0B]/90' : 'bg-[#00A651]/90'}">${article.category}</span>
                    </div>
                    <div class="p-5 flex flex-col flex-1 relative">
                        <div class="flex items-center gap-2 text-[10px] text-gray-500 mb-2 font-medium">
                            <span class="flex items-center gap-1"><i data-lucide="calendar" size="12" class="${isLatest ? "text-orange-600" : "text-[#00A651]"}"></i> ${article.date}</span>
                            ${isLatest ? '<span class="flex items-center gap-1 text-orange-700 bg-orange-100 px-1.5 py-0.5 rounded text-[8px] font-bold animate-pulse border border-orange-200 ml-auto shadow-sm"><i data-lucide="zap" size="8"></i> TERBARU</span>' : ''}
                        </div>
                        <h3 class="text-sm font-bold mb-2 leading-snug transition-colors line-clamp-2 ${isLatest ? 'text-gray-900 group-hover:text-orange-600' : 'text-gray-800 group-hover:text-[#00A651]'}">${article.title}</h3>
                        <p class="text-gray-600 text-[11px] leading-relaxed mb-auto line-clamp-3">${article.desc}</p>
                        <div class="pt-4 mt-2 border-t flex items-center font-bold text-[10px] text-[#00A651] group/btn">
                            Selengkapnya <i data-lucide="arrow-right" size="12" class="ml-1 transition-transform group-hover/btn:translate-x-1"></i>
                        </div>
                    </div>
                </div>`;
            }).join('');
            lucide.createIcons();
        }
 
        // Render Services
        function renderServices(term) {
            const container = document.getElementById('services-container');
            const empty = document.getElementById('services-empty');
            const filtered = LETTER_TYPES.filter(t => t.label.toLowerCase().includes(term.toLowerCase()) || t.desc.toLowerCase().includes(term.toLowerCase()));
            
            if (filtered.length === 0) {
                container.innerHTML = '';
                empty.classList.remove('hidden');
            } else {
                empty.classList.add('hidden');
                container.innerHTML = filtered.map((service, idx) => `
                <button onclick="openModal('${service.id}')" class="w-full bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 hover:-translate-y-1 transition-all duration-300 text-left group flex flex-col h-full relative overflow-hidden animate-slide-up opacity-0" style="animation-delay: ${idx * 50}ms; animation-fill-mode: forwards;">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="flex items-start justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-[#00A651] group-hover:bg-[#00A651] group-hover:text-white transition-all duration-300 shadow-sm group-hover:scale-110 group-hover:rotate-3">
                            <i data-lucide="${service.icon}" size="24"></i>
                        </div>
                        <div class="p-1.5 bg-gray-50 rounded-full group-hover:bg-white group-hover:text-[#00A651] transition-colors">
                            <i data-lucide="arrow-right" size="16" class="text-gray-400 group-hover:text-[#00A651] group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                    <h4 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-[#00A651] transition-colors line-clamp-2 relative z-10 min-h-[3rem]">${service.label}</h4>
                    <p class="text-gray-500 text-xs line-clamp-3 leading-relaxed relative z-10">${service.desc}</p>
                </button>
                `).join('');
                lucide.createIcons();
            }
        }
 
        // Modal Logic
        function openModal(serviceId) {
            const service = LETTER_TYPES.find(t => t.id === serviceId);
            const modal = document.getElementById('service-modal');
            modal.innerHTML = `
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-slide-up flex flex-col max-h-[90vh] relative">
                <button onclick="closeModal()" class="absolute top-4 right-4 p-2 bg-black/10 hover:bg-black/20 rounded-full transition-colors z-30 text-white"><i data-lucide="x" size="20"></i></button>
                <div class="bg-gradient-to-r from-[#00A651] to-[#047857] p-6 text-white flex flex-col shrink-0 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none"><i data-lucide="${service.icon}" size="120"></i></div>
                    <div class="flex gap-4 relative z-10 items-center">
                        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm shadow-inner shrink-0"><i data-lucide="${service.icon}" size="32" class="text-white"></i></div>
                        <div class="pr-8"><h3 class="text-lg sm:text-xl font-bold leading-tight">${service.label}</h3><p class="text-emerald-100 text-xs mt-1 opacity-90 font-mono">${service.id.toUpperCase()}</p></div>
                    </div>
                </div>
                <div class="p-6 overflow-y-auto">
                    <div class="mb-6"><h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi</h4><p class="text-gray-700 text-sm bg-gray-50 p-4 rounded-lg border border-gray-100">${service.desc}</p></div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2"><i data-lucide="file-text" size="16"></i> Persyaratan</h4>
                        <ul class="space-y-3">
                            ${service.reqs.map(r => `<li class="flex items-start gap-3 text-gray-600 text-sm"><i data-lucide="check-circle" size="16" class="text-[#00A651] mt-0.5 shrink-0"></i><span>${r}</span></li>`).join('')}
                        </ul>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t flex justify-end shrink-0"><button onclick="closeModal()" class="w-full sm:w-auto px-6 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition-colors">Tutup</button></div>
            </div>`;
            modal.classList.remove('hidden');
            lucide.createIcons();
        }
 
        function closeModal() {
            document.getElementById('service-modal').classList.add('hidden');
        }
 
        // --- APP LOGIC ---
 
        // Render Dashboard Recent Activity
        function renderRecentActivity() {
            const container = document.getElementById('recent-activity-container');
            if (!currentSubmission) {
                container.innerHTML = `<div class="flex flex-col items-center justify-center h-48 text-gray-300"><div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3"><i data-lucide="file-text" size="32" class="opacity-50"></i></div><p>Belum ada pengajuan baru sesi ini.</p></div>`;
            } else {
                const statusColor = currentSubmission.status === 'process' ? 'blue' : currentSubmission.status === 'revision' ? 'red' : 'green';
                const statusLabel = currentSubmission.status === 'process' ? 'Verifikasi' : currentSubmission.status === 'revision' ? 'Revisi' : 'Terbit';
                
                container.innerHTML = `
                <div onclick="navigateTo('app-tracking')" class="p-6 border-b border-gray-100 hover:bg-gray-50 cursor-pointer flex flex-col sm:flex-row sm:items-center justify-between group transition-colors gap-4">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-[#00A651] group-hover:bg-[#00A651] group-hover:text-white transition-colors shadow-sm shrink-0">
                            <i data-lucide="${currentSubmission.type.icon}" size="28"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-lg group-hover:text-[#00A651] transition-colors line-clamp-1">${currentSubmission.type.label}</p>
                            <p class="text-sm text-gray-500 mt-0.5 line-clamp-1">${currentSubmission.perihal || 'Tanpa Perihal'}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded border border-gray-200 font-mono">${currentSubmission.id}</span>
                                <span class="text-xs text-gray-400 flex items-center gap-1"><i data-lucide="clock" size="10"></i> Baru Saja</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 self-end sm:self-center">
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-${statusColor}-50 text-${statusColor}-600 border border-${statusColor}-100">${statusLabel}</span>
                        <i data-lucide="chevron-right" size="20" class="text-gray-300 group-hover:text-[#00A651] group-hover:translate-x-1 transition-all"></i>
                    </div>
                </div>`;
            }
            lucide.createIcons();
        }
 
        // Render Select Grid
        function renderSelectGrid() {
            const container = document.getElementById('select-type-grid');
            container.innerHTML = LETTER_TYPES.map(type => `
            <button onclick="selectType('${type.id}')" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 text-left group flex flex-col h-full relative overflow-hidden">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-[#00A651] mb-5 group-hover:scale-110 group-hover:bg-[#00A651] group-hover:text-white transition-all duration-300 shadow-sm relative z-10 shrink-0">
                    <i data-lucide="${type.icon}" size="26"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2 leading-snug group-hover:text-[#00A651] transition-colors text-lg relative z-10">${type.label}</h3>
                <p class="text-sm text-gray-500 leading-relaxed line-clamp-3 relative z-10">${type.desc}</p>
            </button>
            `).join('');
            lucide.createIcons();
        }
 
        // Setup Wizard
        function selectType(id) {
            selectedType = LETTER_TYPES.find(t => t.id === id);
            document.getElementById('wizard-title').innerText = selectedType.label;
            const reqContainer = document.getElementById('wizard-reqs-container');
            reqContainer.innerHTML = selectedType.reqs.map(req => `
            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-emerald-50/50 hover:border-[#00A651] transition-all group gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white rounded-full border border-gray-200 flex items-center justify-center text-gray-400 group-hover:text-[#00A651] group-hover:border-[#00A651] transition-all shadow-sm shrink-0"><i data-lucide="file" size="18"></i></div>
                    <div><p class="font-bold text-gray-700 text-sm">${req}</p><p class="text-xs text-gray-400 mt-0.5">Wajib • PDF Max 5MB</p></div>
                </div>
                <label class="cursor-pointer">
                    <span class="text-xs font-bold bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm group-hover:text-[#00A651] group-hover:border-[#00A651] hover:bg-[#00A651] hover:text-white transition-all inline-block text-center w-full sm:w-auto">Pilih File</span>
                    <input type="file" class="hidden">
                </label>
            </div>`).join('');
            navigateTo('app-wizard');
        }
 
        // Submit Form
        function submitForm() {
            const perihal = document.getElementById('input-perihal').value;
            currentSubmission = {
                id: 'REG-' + Math.floor(Math.random() * 10000),
                type: selectedType,
                perihal: perihal || 'Tanpa Perihal',
                status: 'process'
            };
            trackingStatus = 'process';
            renderRecentActivity();
            updateTrackingView();
            navigateTo('app-tracking');
        }
 
        // Tracking Logic
        function updateTrackingStatus(status) {
            trackingStatus = status;
            if(currentSubmission) currentSubmission.status = status;
            renderRecentActivity(); // Update dashboard too
            updateTrackingView();
        }
 
        function updateTrackingView() {
            document.getElementById('tracking-id').innerText = `ID: ${currentSubmission.id}`;
            document.getElementById('preview-perihal').innerText = currentSubmission.perihal;
            const nomerElem = document.getElementById('preview-nomor');
            if(nomerElem) nomerElem.innerText = trackingStatus === 'signed' ? ': 800/123/KOMINFO-2024' : ': ___/___/____';
 
            // 1. Status Messages
            const msgContainer = document.getElementById('tracking-status-message');
            msgContainer.innerHTML = '';
            if (trackingStatus === 'revision') {
                msgContainer.innerHTML = `
                <div class="bg-red-50 border border-red-100 rounded-2xl p-6 flex flex-col sm:flex-row gap-4 shadow-sm animate-fade-in">
                    <div class="bg-red-100 p-3 rounded-full w-fit h-fit text-red-600"><i data-lucide="alert-circle" size="24"></i></div>
                    <div>
                        <h4 class="font-bold text-red-700 text-lg">Dokumen Perlu Revisi</h4>
                        <p class="text-sm text-red-600 mt-1 leading-relaxed">Verifikator telah memeriksa dokumen Anda dan menemukan ketidaksesuaian.</p>
                        <button onclick="updateTrackingStatus('process')" class="mt-4 bg-red-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition-all">Perbaiki Sekarang</button>
                    </div>
                </div>`;
            } else if (trackingStatus === 'signed') {
                msgContainer.innerHTML = `
                <div class="bg-green-50 border border-green-100 rounded-2xl p-6 flex flex-col sm:flex-row gap-4 shadow-sm animate-fade-in">
                    <div class="bg-green-100 p-3 rounded-full w-fit h-fit text-green-600"><i data-lucide="check-circle" size="24"></i></div>
                    <div>
                        <h4 class="font-bold text-green-700 text-lg">Dokumen Telah Terbit</h4>
                        <p class="text-sm text-green-600 mt-1">Dokumen telah ditandatangani secara elektronik (BSrE).</p>
                        <button class="mt-4 flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-green-700 transition-all"><i data-lucide="download" size="16"></i> Unduh PDF</button>
                    </div>
                </div>`;
            }
 
            // 2. Requirements List
            const reqList = document.getElementById('tracking-reqs-list');
            reqList.innerHTML = currentSubmission.type.reqs.map(req => `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 shrink-0"><i data-lucide="check" size="14"></i></div>
                    <span class="text-sm text-gray-700 font-medium">${req}</span>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100">Terupload</span>
            </div>`).join('');
 
            // 3. Timeline
            const timeline = document.getElementById('tracking-timeline');
            timeline.innerHTML = `
                <div class="flex gap-4 relative pb-8">
                    <div class="absolute left-[19px] top-8 bottom-0 w-0.5 bg-gray-200"></div>
                    <div class="relative z-10 w-10 h-10 bg-green-100 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0"><i data-lucide="check-circle" size="18" class="text-green-600"></i></div>
                    <div><p class="text-xs text-gray-400 font-medium mb-0.5">27 Nov 10:00</p><p class="font-bold text-gray-800 text-sm">Pengajuan Draf</p><p class="text-xs text-gray-500">Oleh: Anda (Konseptor)</p></div>
                </div>
                <div class="flex gap-4 relative pb-8">
                    <div class="absolute left-[19px] top-8 bottom-0 w-0.5 bg-gray-200"></div>
                    <div class="relative z-10 w-10 h-10 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0 ${trackingStatus === 'draft' ? 'bg-gray-100 text-gray-400' : trackingStatus === 'revision' ? 'bg-red-100 text-red-600' : trackingStatus === 'signed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'}">
                        <i data-lucide="${trackingStatus === 'revision' ? 'x' : trackingStatus === 'signed' ? 'check-circle' : 'clock'}" size="18"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">27 Nov 10:15</p>
                        <p class="font-bold text-gray-800 text-sm">Verifikasi Berjenjang</p>
                        <p class="text-xs text-gray-500">Posisi: Kasubag Umum</p>
                        ${trackingStatus === 'revision' ? '<div class="mt-2 bg-red-50 p-2 rounded text-xs text-red-600 border border-red-100">"Mohon perbaiki lampiran."</div>' : ''}
                    </div>
                </div>
                <div class="flex gap-4 relative">
                    <div class="relative z-10 w-10 h-10 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0 ${trackingStatus === 'signed' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-300'}">
                        <i data-lucide="pen-tool" size="18"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mt-2">TTE Kepala Dinas</p>
                        <p class="text-xs text-gray-500">${trackingStatus === 'signed' ? 'Selesai' : 'Menunggu'}</p>
                    </div>
                </div>
            `;
            lucide.createIcons();
        }
 
        // Init grid on load
        renderSelectGrid();
 
    </script>
</body>
</html>