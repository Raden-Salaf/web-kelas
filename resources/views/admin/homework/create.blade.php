@extends('layouts.admin')

@section('title', 'Tambah PR')
@section('page-title', 'Tambah PR Baru')
@section('page-icon', '📝')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.homework.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Judul Tugas</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="Contoh: Laporan Praktikum Basis Data"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Mata Kuliah</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required
                       placeholder="Contoh: Basis Data"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('subject') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi (opsional)</label>
                <textarea name="description" rows="4"
                          placeholder="Detail tugas, instruksi pengerjaan, dll."
                          class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Deadline</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}" required
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    @error('due_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Jam Deadline (opsional)</label>
                    <input type="time" name="due_time" value="{{ old('due_time') }}"
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Prioritas</label>
                <select name="priority" required
                        class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    <option value="low"    {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Sedang</option>
                    <option value="high"   {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Simpan Tugas
                </button>
                <a href="{{ route('admin.homework.index') }}"
                   class="border border-slate-600 text-slate-300 hover:bg-slate-800 font-semibold px-6 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection