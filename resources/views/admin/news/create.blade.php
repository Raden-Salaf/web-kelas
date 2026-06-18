@extends('layouts.admin')

@section('title', 'Tulis Berita')
@section('page-title', 'Tulis Berita Baru')
@section('page-icon', '📰')

@section('content')

<div class="max-w-3xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Judul Berita</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="Contoh: Kunjungan Industri ke PT XYZ"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Kategori (opsional)</label>
                <input type="text" name="category" value="{{ old('category') }}"
                       placeholder="Contoh: Kegiatan, Prestasi, Pengumuman"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Foto Sampul (opsional)</label>
                <input type="file" name="cover_image" accept="image/*"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 focus:outline-none focus:border-blue-400 transition">
                @error('cover_image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Isi Berita</label>
                <textarea name="body" rows="8" required
                          placeholder="Tulis isi berita atau laporan kegiatan di sini..."
                          class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">{{ old('body') }}</textarea>
                @error('body') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                <select name="status" required
                        class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (belum tampil ke publik)</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Sekarang</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Simpan Berita
                </button>
                <a href="{{ route('admin.news.index') }}"
                   class="border border-slate-600 text-slate-300 hover:bg-slate-800 font-semibold px-6 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection