@extends('layouts.admin')

@section('title', 'Edit PR')
@section('page-title', 'Edit PR / Tugas')
@section('page-icon', '📝')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.homework.update', $homework) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Judul Tugas</label>
                <input type="text" name="title" value="{{ old('title', $homework->title) }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Mata Kuliah</label>
                <input type="text" name="subject" value="{{ old('subject', $homework->subject) }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">{{ old('description', $homework->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Deadline</label>
                    <input type="date" name="due_date"
                           value="{{ old('due_date', $homework->due_date->format('Y-m-d')) }}" required
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Jam Deadline</label>
                    <input type="time" name="due_time"
                           value="{{ old('due_time', $homework->due_time ? \Carbon\Carbon::parse($homework->due_time)->format('H:i') : '') }}"
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Prioritas</label>
                <select name="priority" required
                        class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    <option value="low"    {{ $homework->priority == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="medium" {{ $homework->priority == 'medium' ? 'selected' : '' }}>Sedang</option>
                    <option value="high"   {{ $homework->priority == 'high' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_done" value="1" {{ $homework->is_done ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-600 bg-slate-800 text-blue-500 focus:ring-blue-500">
                <span class="text-sm text-slate-300">Tandai sudah selesai</span>
            </label>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Update Tugas
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