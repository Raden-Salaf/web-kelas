@extends('layouts.admin')

@section('title', 'Kelola PR')
@section('page-title', 'Kelola PR / Tugas')
@section('page-icon', '📝')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-slate-400 text-sm">Total {{ $homeworks->count() ?? 0 }} tugas tercatat</p>
    <a href="{{ route('admin.homework.create') }}"
       class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        + Tambah PR
    </a>
</div>

<div class="glass rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-800/50 text-slate-400 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Judul</th>
                    <th class="px-5 py-3 font-medium">Mata Kuliah</th>
                    <th class="px-5 py-3 font-medium">Deadline</th>
                    <th class="px-5 py-3 font-medium">Prioritas</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($homeworks as $hw)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-5 py-4 font-medium">{{ $hw->title }}</td>
                        <td class="px-5 py-4 text-slate-400">{{ $hw->subject }}</td>
                        <td class="px-5 py-4 text-slate-400">
                            {{ $hw->due_date->isoFormat('D MMM Y') }}
                            @if($hw->due_time)
                                <span class="text-slate-500">· {{ \Carbon\Carbon::parse($hw->due_time)->format('H:i') }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $priorityColor = [
                                    'high'   => 'bg-red-500/20 text-red-400',
                                    'medium' => 'bg-yellow-500/20 text-yellow-400',
                                    'low'    => 'bg-green-500/20 text-green-400',
                                ];
                            @endphp
                            <span class="text-xs px-2 py-1 rounded-full {{ $priorityColor[$hw->priority] }}">
                                {{ ucfirst($hw->priority) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($hw->is_done)
                                <span class="text-xs px-2 py-1 rounded-full bg-green-500/20 text-green-400">Selesai</span>
                            @elseif($hw->due_date->isPast())
                                <span class="text-xs px-2 py-1 rounded-full bg-red-500/20 text-red-400">Terlambat</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-blue-500/20 text-blue-400">Berjalan</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.homework.edit', $hw) }}"
                                   class="text-blue-400 hover:text-blue-300 text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.homework.destroy', $hw) }}"
                                      onsubmit="return confirm('Yakin hapus tugas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-500">Belum ada PR yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection