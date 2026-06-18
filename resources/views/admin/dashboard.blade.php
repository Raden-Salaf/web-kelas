@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')
@section('page-icon', '⚡')

@section('content')

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="glass rounded-2xl p-5">
        <p class="text-slate-400 text-xs mb-1">Total Siswa</p>
        <p class="text-3xl font-black">{{ $stats['total_siswa'] }}</p>
    </div>
    <div class="glass rounded-2xl p-5">
        <p class="text-slate-400 text-xs mb-1">PR Aktif</p>
        <p class="text-3xl font-black">{{ $stats['total_homework'] }}</p>
    </div>
    <div class="glass rounded-2xl p-5">
        <p class="text-slate-400 text-xs mb-1">Berita Published</p>
        <p class="text-3xl font-black">{{ $stats['total_news'] }}</p>
    </div>
    <div class="glass rounded-2xl p-5">
        <p class="text-slate-400 text-xs mb-1">Jasa Aktif</p>
        <p class="text-3xl font-black">{{ $stats['total_services'] }}</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="glass rounded-2xl p-6">
        <h3 class="font-bold mb-4">📝 PR Mendatang</h3>
        @if($homeworksUpcoming->isEmpty())
            <p class="text-slate-500 text-sm">Belum ada PR.</p>
        @else
            <div class="space-y-3">
                @foreach($homeworksUpcoming as $hw)
                    <div class="bg-slate-800/40 rounded-xl p-3 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-sm">{{ $hw->title }}</p>
                            <p class="text-slate-500 text-xs">{{ $hw->subject }}</p>
                        </div>
                        <span class="text-blue-400 text-xs">{{ $hw->due_date->isoFormat('D MMM') }}</span>
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ route('admin.homework.index') }}" class="block text-center text-blue-400 text-sm mt-4 hover:text-blue-300">Kelola PR →</a>
    </div>

    <div class="glass rounded-2xl p-6">
        <h3 class="font-bold mb-4">📰 Berita Terbaru</h3>
        @if($latestNews->isEmpty())
            <p class="text-slate-500 text-sm">Belum ada berita.</p>
        @else
            <div class="space-y-3">
                @foreach($latestNews as $news)
                    <div class="bg-slate-800/40 rounded-xl p-3 flex justify-between items-center">
                        <p class="font-medium text-sm line-clamp-1">{{ $news->title }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $news->status === 'published' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                            {{ $news->status }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ route('admin.news.index') }}" class="block text-center text-blue-400 text-sm mt-4 hover:text-blue-300">Kelola Berita →</a>
    </div>
</div>

@endsection