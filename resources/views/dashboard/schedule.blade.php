@extends('layouts.siswa')

@section('title', 'Jadwal Kuliah')
@section('page-title', 'Jadwal Kuliah Mingguan')
@section('page-icon', '📅')

@section('content')

<div class="space-y-6">
    @foreach($days as $day)
        <div class="glass rounded-2xl p-6 {{ $day == $hariIni ? 'ring-2 ring-blue-500' : '' }}">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                📌 {{ $day }}
                @if($day == $hariIni)
                    <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full">Hari Ini</span>
                @endif
            </h3>

            @if(!isset($schedules[$day]) || $schedules[$day]->isEmpty())
                <p class="text-slate-500 text-sm">Tidak ada kuliah.</p>
            @else
                <div class="space-y-3">
                    @foreach($schedules[$day] as $sch)
                        <div class="rounded-xl p-4 border-l-4"
                             style="border-color: {{ $sch->color }}; background: {{ $sch->color }}10">
                            <p class="font-semibold text-sm">{{ $sch->subject }}</p>
                            <p class="text-slate-400 text-xs">
                                {{ $sch->lecturer ?? '-' }} · {{ $sch->room ?? '-' }}
                            </p>
                            <p class="text-slate-300 text-xs mt-1">
                                {{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>

@endsection