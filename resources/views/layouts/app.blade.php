<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIKAD KALTIM') - Transformasi Digital Kearsipan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 
    <style>
        body { font-family: 'Inter', sans-serif; }
        
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
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 overflow-x-hidden w-full">
    @include('components.navbar')
    
    @yield('content')
    
    @include('components.footer')
    
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>