@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    {{-- HERO SECTION --}}
    <section class="relative min-h-screen flex items-center pt-16 overflow-hidden">

        {{-- Background decorations --}}
        <div class="absolute inset-0 bg-dots opacity-30"></div>
        <div class="absolute top-32 right-10 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-violet-600/20 rounded-full blur-3xl animate-pulse-slow"
            style="animation-delay:1.5s"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid md:grid-cols-2 gap-12 items-center">

            {{-- Left: Text content --}}
            <div class="animate-slide-up">
                <span
                    class="inline-block bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
                    💻 {{ $settings['class_name'] ?? 'Kelas Teknik Informatika' }}
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
                    Selamat Datang di
                    <span class="gradient-text">InfoClass</span>
                </h1>

                <p class="text-slate-400 text-lg mb-8 max-w-lg">
                    {{ $settings['class_motto'] ?? 'Platform digital untuk kelas kami — informasi tugas, jadwal kuliah, galeri momen, dan jasa kreatif dari anak IT.' }}
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('services.index') }}"
                        class="bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                        Lihat Jasa Kami →
                    </a>
                    <a href="{{ route('news.index') }}"
                        class="border border-blue-500/40 text-blue-300 hover:bg-blue-500/10 font-semibold px-6 py-3 rounded-xl transition">
                        Lihat Berita Kelas
                    </a>
                </div>
            </div>

            {{-- Right: Animated illustration --}}
            <div class="relative flex justify-center items-center animate-float">
                @if ($settings['hero_animation'] ?? false)
                    {{-- Gambar custom yang diupload admin --}}
                    <img src="{{ asset('storage/' . $settings['hero_animation']) }}" alt="Hero Animation"
                        class="relative z-10 w-full max-w-md drop-shadow-2xl">
                @else
                    {{-- Placeholder SVG kalau belum ada gambar custom --}}
                    <div
                        class="relative z-10 w-full max-w-md aspect-square glass rounded-3xl flex items-center justify-center">
                        <div class="text-center p-8">
                            <div class="text-6xl mb-4 animate-bounce-slow">👨‍💻</div>
                            <p class="text-slate-400 text-sm">Upload gambar animasi kamu<br>lewat Admin → Pengaturan</p>
                        </div>
                    </div>
                @endif

                {{-- Floating decoration badges --}}
                <div class="absolute -top-4 -left-4 glass rounded-2xl px-4 py-3 animate-float-slow">
                    <p class="text-2xl">⚡</p>
                </div>
                <div class="absolute -bottom-6 -right-6 glass rounded-2xl px-4 py-3 animate-float"
                    style="animation-delay:1s">
                    <p class="text-2xl">🚀</p>
                </div>
                <div class="absolute top-1/2 -right-10 glass rounded-2xl px-3 py-2 animate-float-slow"
                    style="animation-delay:2s">
                    <p class="text-xl">💡</p>
                </div>
            </div>

        </div>
    </section>

    {{-- JASA SECTION --}}
    <section id="jasa" class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-10">
                <div>
                    <span class="text-blue-400 text-sm font-semibold uppercase tracking-wider">Jasa Kami</span>
                    <h2 class="text-3xl sm:text-4xl font-black mt-2">Butuh Jasa IT? <span class="gradient-text">Kami Siap
                            Bantu!</span></h2>
                </div>
                <a href="{{ route('services.index') }}"
                    class="hidden sm:inline-block text-blue-400 hover:text-blue-300 text-sm font-medium transition">
                    Lihat Semua →
                </a>
            </div>

            @if ($services->isEmpty())
                <div class="text-center text-slate-500 py-10">Belum ada jasa yang ditambahkan.</div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <div class="glass rounded-2xl p-6 card-hover">
                            <div class="text-4xl mb-4">{{ $service->icon ?? '💼' }}</div>
                            <h3 class="font-bold text-lg mb-2">{{ $service->title }}</h3>
                            <p class="text-slate-400 text-sm mb-4 line-clamp-3">{{ $service->description }}</p>

                            @if ($service->price_from)
                                <p class="text-blue-400 font-semibold text-sm mb-4">
                                    Mulai Rp {{ number_format($service->price_from, 0, ',', '.') }}
                                </p>
                            @endif

                            <a href="{{ $service->whatsapp_link }}" target="_blank"
                                class="block text-center bg-green-600 hover:bg-green-500 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                                💬 Order via WhatsApp
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8 sm:hidden">
                    <a href="{{ route('services.index') }}"
                        class="inline-block border border-blue-500/40 text-blue-300 hover:bg-blue-500/10 font-semibold px-6 py-3 rounded-xl transition">
                        Lihat Semua Jasa →
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- BERITA SECTION --}}
    @if ($latestNews->isNotEmpty())
        <section class="py-20 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex items-center justify-between mb-10">
                    <div>
                        <span class="text-blue-400 text-sm font-semibold uppercase tracking-wider">Update Terbaru</span>
                        <h2 class="text-3xl font-black mt-2">Berita & Kegiatan Kelas</h2>
                    </div>
                    <a href="{{ route('news.index') }}"
                        class="text-blue-400 hover:text-blue-300 text-sm font-medium transition">
                        Lihat Semua →
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ($latestNews as $news)
                        <a href="{{ route('news.show', $news->slug) }}"
                            class="glass rounded-2xl overflow-hidden card-hover block">
                            @if ($news->cover_image)
                                <img src="{{ asset('storage/' . $news->cover_image) }}" class="w-full h-44 object-cover">
                            @else
                                <div
                                    class="w-full h-44 bg-gradient-to-br from-blue-600/30 to-violet-600/30 flex items-center justify-center text-4xl">
                                    📰</div>
                            @endif
                            <div class="p-5">
                                @if ($news->category)
                                    <span class="text-xs text-blue-400 font-semibold">{{ $news->category }}</span>
                                @endif
                                <h3 class="font-bold mt-1 mb-2 line-clamp-2">{{ $news->title }}</h3>
                                <p class="text-slate-500 text-xs">{{ $news->published_at?->isoFormat('D MMM Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
