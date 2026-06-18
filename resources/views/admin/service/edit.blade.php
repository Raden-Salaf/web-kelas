@extends('layouts.admin')

@section('title', 'Edit Jasa')
@section('page-title', 'Edit Jasa')
@section('page-icon', '💼')

@section('content')

<div class="max-w-2xl">
    <div class="glass rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.service.update', $service) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Jasa</label>
                <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Icon / Emoji</label>
                <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" maxlength="10"
                       class="w-32 bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white text-center text-2xl focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" required
                          class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">{{ old('description', $service->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Harga Mulai Dari</label>
                <input type="number" name="price_from" value="{{ old('price_from', $service->price_from) }}" min="0"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">No. WhatsApp</label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $service->whatsapp_number) }}" required
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Template Pesan WhatsApp</label>
                <input type="text" name="whatsapp_message" value="{{ old('whatsapp_message', $service->whatsapp_message) }}"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-400 transition">
            </div>

            @if($service->image)
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Foto Saat Ini</label>
                    <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-32 object-cover rounded-xl mb-3">
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Ganti Foto (opsional)</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 focus:outline-none focus:border-blue-400 transition">
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ $service->is_active ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-600 bg-slate-800 text-blue-500 focus:ring-blue-500">
                <span class="text-sm text-slate-300">Tampilkan jasa ini di halaman publik</span>
            </label>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition glow-sm">
                    Update Jasa
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