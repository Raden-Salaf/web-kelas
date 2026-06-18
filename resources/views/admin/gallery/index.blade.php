@extends('layouts.admin')

@section('title', 'Kelola Galeri')
@section('page-title', 'Kelola Galeri Foto')
@section('page-icon', '🖼️')

@section('content')

@php
    $totalAll     = $galleries->count();
    $totalStudent = $galleries->where('type', 'student')->count();
    $totalMoment  = $galleries->where('type', 'moment')->count();
@endphp

<div class="flex items-center justify-between mb-6">
    <p class="text-slate-400 text-sm">Total {{ $totalAll }} foto tersimpan</p>
    <a href="{{ route('admin.gallery.create') }}"
       class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        + Upload Foto
    </a>
</div>

<div x-data="{ tab: 'all' }">

    {{-- KARTU KATEGORI --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <button @click="tab = 'all'"
                :class="tab === 'all' ? 'ring-2 ring-blue-500 bg-blue-500/10' : 'bg-slate-800/40 hover:bg-slate-800/60'"
                class="rounded-2xl p-5 text-center transition border border-blue-500/10 cursor-pointer">
            <div class="text-2xl mb-2">🗂️</div>
            <p class="font-semibold text-sm" :class="tab === 'all' ? 'text-blue-400' : 'text-slate-200'">Semua Foto</p>
            <p class="text-slate-500 text-xs mt-0.5">{{ $totalAll }} foto</p>
        </button>

        <button @click="tab = 'student'"
                :class="tab === 'student' ? 'ring-2 ring-blue-500 bg-blue-500/10' : 'bg-slate-800/40 hover:bg-slate-800/60'"
                class="rounded-2xl p-5 text-center transition border border-blue-500/10 cursor-pointer">
            <div class="text-2xl mb-2">👤</div>
            <p class="font-semibold text-sm" :class="tab === 'student' ? 'text-blue-400' : 'text-slate-200'">Foto Siswa</p>
            <p class="text-slate-500 text-xs mt-0.5">{{ $totalStudent }} foto</p>
        </button>

        <button @click="tab = 'moment'"
                :class="tab === 'moment' ? 'ring-2 ring-blue-500 bg-blue-500/10' : 'bg-slate-800/40 hover:bg-slate-800/60'"
                class="rounded-2xl p-5 text-center transition border border-blue-500/10 cursor-pointer">
            <div class="text-2xl mb-2">📸</div>
            <p class="font-semibold text-sm" :class="tab === 'moment' ? 'text-blue-400' : 'text-slate-200'">Momen Kelas</p>
            <p class="text-slate-500 text-xs mt-0.5">{{ $totalMoment }} foto</p>
        </button>
    </div>

    {{-- GRID FOTO --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @forelse($galleries as $item)
            <div x-show="tab === 'all' || tab === '{{ $item->type }}'" class="group">
                <div class="relative aspect-square rounded-2xl overflow-hidden border border-blue-500/20 bg-slate-800">
                    <img src="{{ $item->photo_url }}"
                         class="w-full h-full object-cover transition duration-300 group-hover:scale-105">

                    <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}"
                          onsubmit="return confirm('Yakin hapus foto ini?')"
                          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-500 text-white text-xs px-3 py-1.5 rounded-lg shadow-lg">
                            Hapus
                        </button>
                    </form>

                    <span class="absolute top-2 left-2 text-[10px] font-semibold px-2 py-1 rounded-full
                                 {{ $item->type === 'student' ? 'bg-blue-500/80 text-white' : 'bg-violet-500/80 text-white' }}">
                        {{ $item->type === 'student' ? 'Siswa' : 'Momen' }}
                    </span>
                </div>

                <div class="mt-2 px-1">
                    @if($item->type === 'student')
                        <p class="font-semibold text-sm truncate">{{ $item->student_name }}</p>
                        <p class="text-slate-500 text-xs">{{ $item->nim ?? '-' }}</p>
                    @else
                        <p class="font-semibold text-sm truncate">{{ $item->album ?? 'Tanpa Album' }}</p>
                        <p class="text-slate-500 text-xs truncate">{{ $item->caption ?? '-' }}</p>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-slate-500 text-sm col-span-full text-center py-10">Belum ada foto yang diupload.</p>
        @endforelse
    </div>
</div>

@endsection