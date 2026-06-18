<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'InfoClass') — {{ \App\Models\SiteSetting::getValue('class_name', 'Kelas TIF') }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%233b82f6'/%3E%3Cstop offset='100%25' stop-color='%238b5cf6'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='100' height='100' rx='22' fill='url(%23g)'/%3E%3Ctext x='50' y='62' font-family='Arial,sans-serif' font-size='40' font-weight='900' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-white font-sans antialiased">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50 glass-dark border-b border-blue-500/20"
         x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-violet-600 rounded-lg flex items-center justify-center glow-sm">
                        <span class="text-white font-bold text-sm">IC</span>
                    </div>
                    <span class="font-bold text-lg gradient-text">InfoClass</span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('landing') }}" class="text-slate-300 hover:text-blue-400 transition text-sm font-medium">Beranda</a>
                    <a href="{{ route('news.index') }}" class="text-slate-300 hover:text-blue-400 transition text-sm font-medium">Berita</a>
                    <a href="{{ route('gallery.index') }}" class="text-slate-300 hover:text-blue-400 transition text-sm font-medium">Galeri</a>
                    <a href="{{route("services.index")}}" class="text-slate-300 hover:text-blue-400 transition text-sm font-medium">Jasa</a>
                </div>

                {{-- Auth Button --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}"
                               class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="border border-blue-500 text-blue-400 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            Login
                        </a>
                    @endauth
                </div>

                {{-- Mobile hamburger --}}
                <button @click="open = !open" class="md:hidden text-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-transition class="md:hidden glass-dark border-t border-blue-500/20 px-4 py-4 space-y-3">
            <a href="{{ route('landing') }}"   class="block text-slate-300 hover:text-blue-400 py-2">Beranda</a>
            <a href="{{ route('news.index') }}" class="block text-slate-300 hover:text-blue-400 py-2">Berita</a>
            <a href="{{ route('gallery.index') }}" class="block text-slate-300 hover:text-blue-400 py-2">Galeri</a>
            <a href="{{route('services.index')}}" class="block text-slate-300 hover:text-blue-400 py-2">Jasa</a>
            @guest
                <a href="{{ route('login') }}" class="block bg-blue-600 text-white px-4 py-2 rounded-lg text-center">Login</a>
            @endguest
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-blue-500/20 glass-dark py-10 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-violet-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xs">IC</span>
                </div>
                <span class="font-bold gradient-text">InfoClass</span>
            </div>
            <p class="text-slate-400 text-sm">
                {{ \App\Models\SiteSetting::getValue('class_name') }} —
                {{ \App\Models\SiteSetting::getValue('university_name') }}
            </p>
            <p class="text-slate-600 text-xs mt-2">© {{ date('Y') }} InfoClass. Built with ❤️ by <a href="https://www.instagram.com/den_salafy/">Den_Salafy</a></p>
        </div>
    </footer>

</body>
</html>