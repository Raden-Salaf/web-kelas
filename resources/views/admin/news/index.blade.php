@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita & Kegiatan')
@section('page-icon', '📰')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-slate-400 text-sm">Total {{ $news->count() }} berita tercatat</p>
    <a href="{{ route('admin.news.create') }}"
       class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        + Tulis Berita
    </a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($news as $item)
        <div class="glass rounded-2xl overflow-hidden">
            @if($item->cover_image)
                <img src="{{ asset('storage/' . $item->cover_image) }}" class="w-full h-40 object-cover">
            @else
                <div class="w-full h-40 bg-gradient-to-br from-blue-600/30 to-violet-600/30 flex items-center justify-center text-4xl">📰</div>
            @endif

            <div class="p-5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $item->status === 'published' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                        {{ $item->status === 'published' ? 'Published' : 'Draft' }}
                    </span>
                    @if($item->category)
                        <span class="text-xs text-blue-400">{{ $item->category }}</span>
                    @endif
                </div>

                <h3 class="font-bold mb-2 line-clamp-2">{{ $item->title }}</h3>
                <p class="text-slate-500 text-xs mb-4">
                    {{ $item->published_at ? $item->published_at->isoFormat('D MMM Y') : 'Belum dipublish' }}
                </p>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.news.edit', $item) }}" class="text-blue-400 hover:text-blue-300 text-xs font-medium">Edit</a>

                    @if($item->status === 'draft')
                        <form method="POST" action="{{ route('admin.news.publish', $item) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-400 hover:text-green-300 text-xs font-medium">Publish</button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.news.destroy', $item) }}"
                          onsubmit="return confirm('Yakin hapus berita ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-medium">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-slate-500 text-sm col-span-full text-center py-10">Belum ada berita yang ditulis. <br>Kelas kita anyeb</p>
    @endforelse
</div>

@endsection