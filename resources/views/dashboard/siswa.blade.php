@extends('layouts.siswa')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Siswa')
@section('page-icon', '🏠')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold">Halo, {{ auth()->user()->name }}! 👋</h2>
    <p class="text-slate-400 text-sm">Berikut info kelas untuk hari {{ $hariIni }}</p>
</div>

{{-- PR HARI INI --}}
<div class="glass rounded-2xl p-6 mb-6">
    <h3 class="font-bold mb-4 flex items-center gap-2">🔔 PR Deadline Hari Ini</h3>

    @if($homeworksToday->isEmpty())
        <p class="text-slate-500 text-sm">Tidak ada PR yang deadline hari ini. Santai! 🎉</p>
    @else
        <div class="space-y-3">
            @foreach($homeworksToday as $hw)
                <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-sm">{{ $hw->title }}</p>
                        <p class="text-slate-400 text-xs">{{ $hw->subject }}</p>
                    </div>
                    <span class="text-red-400 text-xs font-semibold">
                        {{ $hw->due_time ? \Carbon\Carbon::parse($hw->due_time)->format('H:i') : '' }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- JADWAL HARI INI --}}
<div class="glass rounded-2xl p-6 mb-6">
    <h3 class="font-bold mb-4 flex items-center gap-2">📅 Jadwal Kuliah Hari Ini</h3>

    @if($scheduleToday->isEmpty())
        <p class="text-slate-500 text-sm">Tidak ada kuliah hari ini.</p>
    @else
        <div class="space-y-3">
            @foreach($scheduleToday as $sch)
                <div class="rounded-xl p-4 border-l-4" style="border-color: {{ $sch->color }}; background: {{ $sch->color }}15">
                    <p class="font-semibold text-sm">{{ $sch->subject }}</p>
                    <p class="text-slate-400 text-xs">{{ $sch->lecturer }} · {{ $sch->room }}</p>
                    <p class="text-slate-300 text-xs mt-1">
                        {{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- PR UPCOMING --}}
<div class="glass rounded-2xl p-6">
    <h3 class="font-bold mb-4 flex items-center gap-2">📝 PR Mendatang (5 Hari)</h3>

    @if($homeworksUpcoming->isEmpty())
        <p class="text-slate-500 text-sm">Tidak ada PR mendatang.</p>
    @else
        <div class="space-y-3">
            @foreach($homeworksUpcoming as $hw)
                <div class="bg-slate-800/40 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-sm">{{ $hw->title }}</p>
                        <p class="text-slate-400 text-xs">{{ $hw->subject }}</p>
                    </div>
                    <span class="text-blue-400 text-xs font-semibold">
                        {{ $hw->due_date->isoFormat('D MMM') }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection