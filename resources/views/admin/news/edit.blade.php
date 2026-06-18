@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')
@section('page-icon', '📰')

@section('content')

<div class="max-w-3xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Judul Berita</label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $news->category) }}"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            @if($news->cover_image)
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Foto Sampul Saat Ini</label>
                    <img src="{{ asset('storage/' . $news->cover_image) }}" class="w-full h-40 object-cover rounded-xl mb-3">
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Ganti Foto Sampul (opsional)</label>
                <input type="file" name="cover_image" accept="image/*"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Isi Berita</label>
                <textarea name="body" rows="8" required
                          class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">{{ old('body', $news->body) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                <select name="status" required
                        class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
                    <option value="draft" {{ $news->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $news->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Update Berita
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