@extends('layouts.admin')

@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Akun Siswa')
@section('page-icon', '👥')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.siswa.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Budi Santoso"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">NIM</label>
                <input type="text" name="nim" value="{{ old('nim') }}" required
                       placeholder="Contoh: 2201006"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('nim') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="email@siswa.dev"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">No. WhatsApp (opsional)</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                       placeholder="Contoh: 081234567890"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <input type="password" name="password" required minlength="6"
                           placeholder="Minimal 6 karakter"
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                    @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required minlength="6"
                           placeholder="Ulangi password"
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 transition">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Simpan Akun
                </button>
                <a href="{{ route('admin.siswa.index') }}"
                   class="border border-slate-600 text-slate-300 hover:bg-slate-800 font-semibold px-6 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection