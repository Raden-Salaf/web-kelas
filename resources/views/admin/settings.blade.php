@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Website')
@section('page-icon', '⚙️')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Kelas</label>
                <input type="text" name="class_name" value="{{ old('class_name', $settings['class_name']->value ?? '') }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Angkatan</label>
                <input type="text" name="class_year" value="{{ old('class_year', $settings['class_year']->value ?? '') }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Kampus</label>
                <input type="text" name="university_name" value="{{ old('university_name', $settings['university_name']->value ?? '') }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Motto Kelas</label>
                <input type="text" name="class_motto" value="{{ old('class_motto', $settings['class_motto']->value ?? '') }}"
                       placeholder="Contoh: Code Together, Grow Together"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Link Grup WhatsApp (opsional)</label>
                <input type="url" name="whatsapp_group" value="{{ old('whatsapp_group', $settings['whatsapp_group']->value ?? '') }}"
                       placeholder="https://chat.whatsapp.com/..."
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div class="pt-4 border-t border-slate-800">
                <label class="block text-sm font-medium text-slate-300 mb-2">🎨 Gambar Animasi Hero (Landing Page)</label>
                <p class="text-slate-500 text-xs mb-3">Upload gambar/ilustrasi custom kamu (PNG, JPG, atau GIF) yang akan muncul di halaman utama dengan efek animasi melayang.</p>

                @if($settings['hero_animation']->value ?? false)
                    <div class="mb-3">
                        <p class="text-slate-400 text-xs mb-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $settings['hero_animation']->value) }}"
                             class="w-40 h-40 object-cover rounded-xl border border-blue-500/30">
                    </div>
                @endif

                <input type="file" name="hero_animation" accept="image/png,image/jpeg,image/gif"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 focus:outline-none focus:border-blue-400 transition">
                @error('hero_animation') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection