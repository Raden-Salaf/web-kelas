@extends('layouts.admin')

@section('title', 'Kelola Jadwal')
@section('page-title', 'Kelola Jadwal Kuliah')
@section('page-icon', '📅')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-slate-400 text-sm">Total {{ $schedules->flatten()->count() }} jadwal tercatat</p>
    <a href="{{ route('admin.schedule.create') }}"
       class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        + Tambah Jadwal
    </a>
</div>

<div class="space-y-6">
    @foreach($days as $day)
        <div class="glass rounded-2xl p-6">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                📌 {{ $day }}
                <span class="text-xs text-slate-500 font-normal">
                    ({{ isset($schedules[$day]) ? $schedules[$day]->count() : 0 }} mata kuliah)
                </span>
            </h3>

            @if(!isset($schedules[$day]) || $schedules[$day]->isEmpty())
                <p class="text-slate-500 text-sm">Belum ada jadwal di hari ini.</p>
            @else
                <div class="space-y-3">
                    @foreach($schedules[$day] as $sch)
                        <div class="rounded-xl p-4 border-l-4 flex items-center justify-between"
                             style="border-color: {{ $sch->color }}; background: {{ $sch->color }}10">
                            <div>
                                <p class="font-semibold text-sm">{{ $sch->subject }}</p>
                                <p class="text-slate-400 text-xs">
                                    {{ $sch->lecturer ?? '-' }} · {{ $sch->room ?? '-' }} ·
                                    {{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <a href="{{ route('admin.schedule.edit', $sch) }}"
                                   class="text-blue-400 hover:text-blue-300 text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.schedule.destroy', $sch) }}"
                                      onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>

@endsection