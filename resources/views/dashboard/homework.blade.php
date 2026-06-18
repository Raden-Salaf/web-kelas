@extends('layouts.siswa')

@section('title', 'Tugas / PR')
@section('page-title', 'Daftar Tugas / PR')
@section('page-icon', '📝')

@section('content')

@if($homeworks->isEmpty())
    <div class="glass rounded-2xl p-10 text-center">
        <div class="text-5xl mb-4">🎉</div>
        <p class="text-slate-400">Tidak ada tugas yang mendatang. Santai dulu sambil nyebat!</p>
    </div>
@else
    <div class="space-y-6">
        @foreach($homeworks as $date => $items)
            @php
                $parsedDate = \Carbon\Carbon::parse($date);
                $isToday = $parsedDate->isToday();
                $isTomorrow = $parsedDate->isTomorrow();
            @endphp

            <div class="glass rounded-2xl p-6 {{ $isToday ? 'ring-2 ring-red-500' : '' }}">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    📅 {{ $parsedDate->isoFormat('dddd, D MMMM Y') }}

                    @if($isToday)
                        <span class="text-xs bg-red-500/20 text-red-400 px-2 py-0.5 rounded-full">Hari Ini</span>
                    @elseif($isTomorrow)
                        <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded-full">Besok</span>
                    @endif
                </h3>

                <div class="space-y-3">
                    @foreach($items as $hw)
                        @php
                            $priorityColor = [
                                'high'   => 'border-red-500 bg-red-500/5',
                                'medium' => 'border-yellow-500 bg-yellow-500/5',
                                'low'    => 'border-green-500 bg-green-500/5',
                            ];
                            $priorityBadge = [
                                'high'   => 'bg-red-500/20 text-red-400',
                                'medium' => 'bg-yellow-500/20 text-yellow-400',
                                'low'    => 'bg-green-500/20 text-green-400',
                            ];
                        @endphp
                        <div class="rounded-xl p-4 border-l-4 {{ $priorityColor[$hw->priority] }}">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-sm">{{ $hw->title }}</p>
                                    <p class="text-blue-400 text-xs mt-0.5">{{ $hw->subject }}</p>
                                    @if($hw->description)
                                        <p class="text-slate-400 text-xs mt-2">{{ $hw->description }}</p>
                                    @endif
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="text-xs px-2 py-1 rounded-full {{ $priorityBadge[$hw->priority] }}">
                                        {{ ucfirst($hw->priority) }}
                                    </span>
                                    @if($hw->due_time)
                                        <p class="text-slate-500 text-xs mt-1">
                                            ⏰ {{ \Carbon\Carbon::parse($hw->due_time)->format('H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection