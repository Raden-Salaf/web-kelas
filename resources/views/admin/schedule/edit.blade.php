@extends('layouts.admin')

@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal Kuliah')
@section('page-icon', '📅')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.schedule.update', $schedule) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Hari</label>
                <select name="day" required
                        class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    @foreach($days as $day)
                        <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Mata Kuliah</label>
                <input type="text" name="subject" value="{{ old('subject', $schedule->subject) }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Dosen</label>
                <input type="text" name="lecturer" value="{{ old('lecturer', $schedule->lecturer) }}"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Jam Mulai</label>
                    <input type="time" name="start_time"
                           value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Jam Selesai</label>
                    <input type="time" name="end_time"
                           value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Ruangan</label>
                <input type="text" name="room" value="{{ old('room', $schedule->room) }}"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Warna Label</label>
                <input type="color" name="color" value="{{ old('color', $schedule->color) }}"
                       class="w-20 h-12 bg-slate-800/50 border border-blue-500/30 rounded-xl cursor-pointer">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Update Jadwal
                </button>
                <a href="{{ route('admin.schedule.index') }}"
                   class="border border-slate-600 text-slate-300 hover:bg-slate-800 font-semibold px-6 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection