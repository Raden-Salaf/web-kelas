@extends('layouts.admin')

@section('title', 'Kelola Jasa')
@section('page-title', 'Kelola Jasa Kelas')
@section('page-icon', '💼')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-slate-400 text-sm">Total {{ $services->count() }} jasa terdaftar</p>
    <a href="{{ route('admin.service.create') }}"
       class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        + Tambah Jasa
    </a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($services as $service)
        <div class="glass rounded-2xl p-6">
            <div class="flex items-start justify-between mb-3">
                <div class="text-3xl">{{ $service->icon ?? '💼' }}</div>
                <span class="text-xs px-2 py-1 rounded-full {{ $service->is_active ? 'bg-green-500/20 text-green-400' : 'bg-slate-700 text-slate-400' }}">
                    {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <h3 class="font-bold mb-1">{{ $service->title }}</h3>
            <p class="text-slate-400 text-sm mb-3 line-clamp-2">{{ $service->description }}</p>

            @if($service->price_from)
                <p class="text-blue-400 font-semibold text-sm mb-4">
                    Mulai Rp {{ number_format($service->price_from, 0, ',', '.') }}
                </p>
            @endif

            <div class="flex items-center gap-3 pt-3 border-t border-slate-800">
                <a href="{{ route('admin.service.edit', $service) }}" class="text-blue-400 hover:text-blue-300 text-xs font-medium">Edit</a>
                <form method="POST" action="{{ route('admin.service.destroy', $service) }}"
                      onsubmit="return confirm('Yakin hapus jasa ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-medium">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-slate-500 text-sm col-span-full text-center py-10">Belum ada jasa yang ditambahkan.</p>
    @endforelse
</div>

@endsection