@extends('layouts.app')

@section('title', 'Jasa')

@section('content')

<section class="relative pt-32 pb-20 overflow-hidden">

    <div class="absolute inset-0 bg-dots opacity-30"></div>
    <div class="absolute top-20 right-0 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-0 w-80 h-80 bg-violet-600/15 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <span class="inline-block bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                💼 Jasa Kami
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-4">
                Butuh Jasa IT? <span class="gradient-text">Kami Siap Bantu!</span>
            </h1>
            <p class="text-slate-400 max-w-xl mx-auto">
                Dikerjakan langsung oleh mahasiswa IT yang kompeten dan berpengalaman di bidangnya. Pesan langsung lewat WhatsApp, tanpa ribet.
            </p>
        </div>

        @if($services->isEmpty())
            <div class="glass rounded-2xl p-10 text-center max-w-md mx-auto">
                <p class="text-slate-500 text-sm">Belum ada jasa yang ditambahkan.</p>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <div class="glass rounded-2xl overflow-hidden card-hover flex flex-col">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-44 object-cover">
                        @endif

                        <div class="p-6 flex flex-col flex-1">
                            <div class="text-4xl mb-4">{{ $service->icon ?? '💼' }}</div>
                            <h3 class="font-bold text-lg mb-2">{{ $service->title }}</h3>
                            <p class="text-slate-400 text-sm mb-4 flex-1">{{ $service->description }}</p>

                            @if($service->price_from)
                                <p class="text-blue-400 font-semibold text-sm mb-4">
                                    Mulai Rp {{ number_format($service->price_from, 0, ',', '.') }}
                                </p>
                            @endif

                            <a href="{{ $service->whatsapp_link }}" target="_blank"
                               class="block text-center bg-green-600 hover:bg-green-500 text-white text-sm font-semibold py-3 rounded-xl transition">
                                💬 Order via WhatsApp
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

@endsection