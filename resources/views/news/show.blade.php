@extends('layouts.app')

@section('title', $article->title)

@section('content')

<section class="relative pt-32 pb-20 overflow-hidden">

    <div class="absolute inset-0 bg-dots opacity-30"></div>

    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('news.index') }}" class="text-blue-400 hover:text-blue-300 text-sm mb-6 inline-block">
            ← Kembali ke Berita
        </a>

        @if($article->category)
            <span class="inline-block bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                {{ $article->category }}
            </span>
        @endif

        <h1 class="text-3xl sm:text-4xl font-black mb-4">{{ $article->title }}</h1>

        <div class="flex items-center gap-3 text-slate-500 text-sm mb-8">
            <span>✍️ {{ $article->author->name }}</span>
            <span>·</span>
            <span>{{ $article->published_at->isoFormat('D MMMM Y') }}</span>
        </div>

        @if($article->cover_image)
            <img src="{{ asset('storage/' . $article->cover_image) }}" class="w-full h-72 object-cover rounded-2xl mb-8">
        @endif

        <div class="glass rounded-2xl p-8 prose prose-invert max-w-none">
            <p class="text-slate-300 leading-relaxed whitespace-pre-line">{{ $article->body }}</p>
        </div>

        @if($related->isNotEmpty())
            <div class="mt-16">
                <h3 class="font-bold text-lg mb-6">Berita Lainnya</h3>
                <div class="grid sm:grid-cols-3 gap-5">
                    @foreach($related as $item)
                        <a href="{{ route('news.show', $item->slug) }}" class="glass rounded-2xl overflow-hidden card-hover block">
                            @if($item->cover_image)
                                <img src="{{ asset('storage/' . $item->cover_image) }}" class="w-full h-32 object-cover">
                            @else
                                <div class="w-full h-32 bg-gradient-to-br from-blue-600/30 to-violet-600/30 flex items-center justify-center text-2xl">📰</div>
                            @endif
                            <div class="p-4">
                                <h4 class="font-semibold text-sm line-clamp-2">{{ $item->title }}</h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection