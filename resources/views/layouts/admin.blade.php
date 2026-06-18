<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard') | InfoClass</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%233b82f6'/%3E%3Cstop offset='100%25' stop-color='%238b5cf6'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='100' height='100' rx='22' fill='url(%23g)'/%3E%3Ctext x='50' y='62' font-family='Arial,sans-serif' font-size='40' font-weight='900' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-white font-sans antialiased" x-data="{ sidebarOpen: false }">

    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 glass-dark border-r border-blue-500/20 transform transition-transform duration-300 md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

        <div class="flex items-center gap-3 px-6 py-5 border-b border-blue-500/20">
            <div
                class="w-9 h-9 bg-gradient-to-br from-violet-500 to-blue-600 rounded-lg flex items-center justify-center glow-sm">
                <span class="font-bold text-sm">⚡</span>
            </div>
            <div>
                <p class="font-bold gradient-text text-sm">Admin Panel</p>
                <p class="text-slate-500 text-xs">InfoClass</p>
            </div>
        </div>

        <div class="px-6 py-4 border-b border-blue-500/20">
            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
            <span
                class="mt-1 inline-block bg-violet-500/20 text-violet-400 text-xs px-2 py-0.5 rounded-full">Administrator</span>
        </div>

        <nav class="px-4 py-4 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'icon' => '🏠', 'label' => 'Dashboard'],
                    ['route' => 'admin.homework.index', 'icon' => '📝', 'label' => 'Kelola PR'],
                    ['route' => 'admin.schedule.index', 'icon' => '📅', 'label' => 'Kelola Jadwal'],
                    ['route' => 'admin.siswa.index', 'icon' => '👥', 'label' => 'Kelola Siswa'],
                    ['route' => 'admin.gallery.index', 'icon' => '🖼️', 'label' => 'Kelola Galeri'],
                    ['route' => 'admin.news.index', 'icon' => '📰', 'label' => 'Kelola Berita'],
                    ['route' => 'admin.service.index', 'icon' => '💼', 'label' => 'Kelola Jasa'],
                    ['route' => 'admin.settings', 'icon' => '⚙️', 'label' => 'Pengaturan'],
                ];
            @endphp

            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs($item['route'])
                              ? 'bg-violet-600 text-white glow-sm'
                              : 'text-slate-400 hover:bg-violet-500/10 hover:text-violet-300' }}">
                    <span>{{ $item['icon'] }}</span>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-blue-500/20">
            <a href="{{ route('landing') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs text-slate-500 hover:text-slate-300 transition mb-2">
                🌐 Lihat Website
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition">
                    🚪 Logout
                </button>
            </form>
        </div>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 md:hidden"></div>
    <div class="md:ml-64 min-h-screen flex flex-col">
        <header
            class="sticky top-0 z-30 glass-dark border-b border-blue-500/20 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="md:hidden text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h1 class="font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-400">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
            <span class="text-2xl">@yield('page-icon', '⚡')</span>
        </header>

        @if (session('success'))
            <div class="mx-6 mt-4 bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm"
                x-data x-init="setTimeout(() => $el.remove(), 4000)">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mx-6 mt-4 bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm"
                x-data x-init="setTimeout(() => $el.remove(), 4000)">
                ❌ {{ session('error') }}
            </div>
        @endif

        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>

</html>
