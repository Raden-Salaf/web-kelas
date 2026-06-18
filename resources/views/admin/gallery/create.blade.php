@extends('layouts.admin')

@section('title', 'Upload Foto')
@section('page-title', 'Upload Foto Galeri')
@section('page-icon', '🖼️')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6" x-data="{ type: 'student' }">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Tipe Foto</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 glass rounded-xl px-4 py-3 cursor-pointer"
                           :class="type === 'student' ? 'ring-2 ring-blue-500' : ''">
                        <input type="radio" name="type" value="student" x-model="type" class="text-blue-500">
                        <span class="text-sm">👤 Foto Siswa</span>
                    </label>
                    <label class="flex items-center gap-2 glass rounded-xl px-4 py-3 cursor-pointer"
                           :class="type === 'moment' ? 'ring-2 ring-blue-500' : ''">
                        <input type="radio" name="type" value="moment" x-model="type" class="text-blue-500">
                        <span class="text-sm">📸 Momen Kelas</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Pilih Foto</label>
                <input type="file" name="photo" accept="image/*" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 focus:outline-none focus:border-blue-400 transition">
                @error('photo') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Field khusus tipe student --}}
            <div x-show="type === 'student'">
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Siswa</label>
                <input type="text" name="student_name"
                       placeholder="Contoh: Budi Santoso"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">

                <label class="block text-sm font-medium text-slate-300 mb-2 mt-4">NIM</label>
                <input type="text" name="nim"
                       placeholder="Contoh: 2201001"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            {{-- Field khusus tipe moment --}}
            <div x-show="type === 'moment'">
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Album</label>
                <input type="text" name="album"
                       placeholder="Contoh: Study Tour 2025"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">

                <label class="block text-sm font-medium text-slate-300 mb-2 mt-4">Caption</label>
                <input type="text" name="caption"
                       placeholder="Contoh: Momen seru saat kunjungan industri"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Upload
                </button>
                <a href="{{ route('admin.gallery.index') }}"
                   class="border border-slate-600 text-slate-300 hover:bg-slate-800 font-semibold px-6 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection