@extends('layouts.app')

@section('title', 'Berita')

@section('content')

<section class="relative pt-32 pb-20 overflow-hidden">

    <div class="absolute inset-0 bg-dots opacity-30"></div>
    <div class="absolute top-20 right-0 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="inline-block bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                📰 Update Kelas
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-3">
                Berita & <span class="gradient-text">Kegiatan Kelas</span>
            </h1>
        </div>

        @if($news->isEmpty())
            <div class="glass rounded-2xl p-10 text-center">
                <p class="text-slate-500 text-sm">Belum ada berita yang dipublikasikan.</p>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @foreach($news as $item)
                    <a href="{{ route('news.show', $item->slug) }}" class="glass rounded-2xl overflow-hidden card-hover block">
                        @if($item->cover_image)
                            <img src="{{ asset('storage/' . $item->cover_image) }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-600/30 to-violet-600/30 flex items-center justify-center text-4xl">📰</div>
                        @endif
                        <div class="p-5">
                            @if($item->category)
                                <span class="text-xs text-blue-400 font-semibold">{{ $item->category }}</span>
                            @endif
                            <h3 class="font-bold mt-1 mb-2 line-clamp-2">{{ $item->title }}</h3>
                            <p class="text-slate-500 text-xs">{{ $item->published_at?->isoFormat('D MMM Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $news->links() }}
            </div>
        @endif

    </div>
</section>

@endsection