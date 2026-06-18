@extends('layouts.admin')

@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal Kuliah')
@section('page-icon', '📅')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.schedule.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Hari</label>
                <select name="day" required
                        class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    <option value="">-- Pilih Hari --</option>
                    @foreach($days as $day)
                        <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
                @error('day') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Mata Kuliah</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required
                       placeholder="Contoh: Algoritma & Pemrograman"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('subject') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Dosen (opsional)</label>
                <input type="text" name="lecturer" value="{{ old('lecturer') }}"
                       placeholder="Contoh: Dr. Hendra, M.Kom"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Jam Mulai</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" required
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    @error('start_time') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Jam Selesai</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" required
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    @error('end_time') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Ruangan (opsional)</label>
                <input type="text" name="room" value="{{ old('room') }}"
                       placeholder="Contoh: Lab. Komputer A"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Warna Label</label>
                <input type="color" name="color" value="{{ old('color', '#3B82F6') }}"
                       class="w-20 h-12 bg-slate-800/50 border border-blue-500/30 rounded-xl cursor-pointer">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Simpan Jadwal
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