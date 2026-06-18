@extends('layouts.admin')

@section('title', 'Tambah Jasa')
@section('page-title', 'Tambah Jasa Baru')
@section('page-icon', '💼')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.service.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Jasa</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="Contoh: Pembuatan Website"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Icon / Emoji</label>
                <input type="text" name="icon" value="{{ old('icon') }}" maxlength="10"
                       placeholder="Contoh: 🌐"
                       class="w-32 bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white text-center text-2xl placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                <p class="text-slate-500 text-xs mt-1">Copy-paste emoji dari keyboard kamu, atau dari emojipedia.org</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" required
                          placeholder="Jelaskan jasa ini secara singkat..."
                          class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Harga Mulai Dari (opsional)</label>
                <input type="number" name="price_from" value="{{ old('price_from') }}" min="0"
                       placeholder="Contoh: 500000"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">No. WhatsApp untuk Order</label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required
                       placeholder="Contoh: 6281234567890 (format internasional, tanpa +)"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('whatsapp_number') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Template Pesan WhatsApp (opsional)</label>
                <input type="text" name="whatsapp_message" value="{{ old('whatsapp_message') }}"
                       placeholder="Contoh: Halo, saya tertarik dengan jasa ini..."
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Foto Contoh Hasil Kerja (opsional)</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 focus:outline-none focus:border-blue-400 transition">
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked
                       class="w-5 h-5 rounded border-slate-600 bg-slate-800 text-blue-500 focus:ring-blue-500">
                <span class="text-sm text-slate-300">Tampilkan jasa ini di halaman publik</span>
            </label>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Simpan Jasa
                </button>
                <a href="{{ route('admin.service.index') }}"
                   class="border border-slate-600 text-slate-300 hover:bg-slate-800 font-semibold px-6 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection