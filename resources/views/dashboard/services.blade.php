@extends('layouts.siswa')

@section('title', 'Jasa Kelas')
@section('page-title', 'Jasa yang Ditawarkan')
@section('page-icon', '💼')

@section('content')

<div class="grid sm:grid-cols-2 gap-5">
    @forelse($services as $service)
        <div class="glass rounded-2xl p-6">
            <div class="text-3xl mb-3">{{ $service->icon ?? '💼' }}</div>
            <h3 class="font-bold mb-2">{{ $service->title }}</h3>
            <p class="text-slate-400 text-sm mb-4">{{ $service->description }}</p>

            @if($service->price_from)
                <p class="text-blue-400 font-semibold text-sm mb-4">
                    Mulai Rp {{ number_format($service->price_from, 0, ',', '.') }}
                </p>
            @endif

            <a href="{{ $service->whatsapp_link }}" target="_blank"
               class="block text-center bg-green-600 hover:bg-green-500 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                💬 Order via WhatsApp
            </a>
        </div>
    @empty
        <p class="text-slate-500 text-sm col-span-full text-center py-10">Belum ada jasa yang ditambahkan.</p>
    @endforelse
</div>

@endsection