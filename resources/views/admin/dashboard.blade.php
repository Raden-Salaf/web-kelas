@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')
@section('page-icon', '⚡')

@section('content')

    @php
        $waMessageUrl = route('admin.wa.message');
        $waGrupUrl = \App\Models\SiteSetting::getValue('whatsapp_group', '#');
        $sendEmailUrl = route('admin.send.email');
    @endphp

    {{-- WIDGET KIRIM WA --}}
    <div class="glass rounded-2xl p-6 mb-8" x-data="waWidget()">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-lg flex items-center gap-2">
                    💬 Kirim Pengingat ke Grup WhatsApp
                </h3>
                <p class="text-slate-400 text-xs mt-1">
                    Pesan otomatis berisi jadwal kuliah + PR hari ini
                </p>
            </div>
            <button @click="generate()" :disabled="loading"
                class="bg-green-600 hover:bg-green-500 disabled:opacity-50 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm flex items-center gap-2 cursor-pointer">
                <span x-show="!loading">🔄 Generate Pesan</span>
                <span x-show="loading">Memproses...</span>
            </button>
        </div>

        <div x-show="pesan" x-transition class="space-y-4">
            <div class="bg-slate-900/60 rounded-xl p-4 border border-slate-700">
                <p class="text-xs text-slate-500 mb-2 font-medium">Preview Pesan:</p>
                <pre x-text="pesan" class="text-sm text-slate-200 whitespace-pre-wrap font-mono leading-relaxed"></pre>
            </div>

            <div class="flex flex-wrap gap-3">
                <button @click="copyPesan()"
                    class="flex items-center gap-2 bg-slate-700 hover:bg-slate-600 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition cursor-pointer">
                    <span x-text="copied ? '✅ Tersalin!' : '📋 Copy Pesan'"></span>
                </button>

                @if (\App\Models\SiteSetting::getValue('whatsapp_group'))
                    <a :href="grupUrl" target="_blank"
                        class="flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                        📲 Buka Grup WA & Kirim
                    </a>
                @else
                    <a href="{{ route('admin.settings') }}"
                        class="flex items-center gap-2 bg-yellow-600 hover:bg-yellow-500 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
                        ⚠️ Set Link Grup WA di Pengaturan
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- WIDGET KIRIM EMAIL --}}
    <div class="glass rounded-2xl p-6 mb-8" x-data="emailWidget()">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-lg flex items-center gap-2">
                    📧 Kirim Email Pengingat ke Semua Siswa
                </h3>
                <p class="text-slate-400 text-xs mt-1">
                    Email otomatis terkirim ke semua siswa terdaftar
                </p>
            </div>
            <button @click="kirim()" :disabled="loading"
                class="bg-blue-600 hover:bg-blue-500 disabled:opacity-50 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm flex items-center gap-2 cursor-pointer">
                <span x-show="!loading">📨 Kirim Email Sekarang</span>
                <span x-show="loading">Mengirim...</span>
            </button>
        </div>

        <div x-show="result" x-transition
            :class="success ? 'bg-green-500/20 border-green-500/30 text-green-400' :
                'bg-red-500/20 border-red-500/30 text-red-400'"
            class="border px-4 py-3 rounded-xl text-sm">
            <span x-text="result"></span>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="glass rounded-2xl p-5">
            <p class="text-slate-400 text-xs mb-1">Total Siswa</p>
            <p class="text-3xl font-black">{{ $stats['total_siswa'] }}</p>
        </div>
        <div class="glass rounded-2xl p-5">
            <p class="text-slate-400 text-xs mb-1">PR Aktif</p>
            <p class="text-3xl font-black">{{ $stats['total_homework'] }}</p>
        </div>
        <div class="glass rounded-2xl p-5">
            <p class="text-slate-400 text-xs mb-1">Berita Published</p>
            <p class="text-3xl font-black">{{ $stats['total_news'] }}</p>
        </div>
        <div class="glass rounded-2xl p-5">
            <p class="text-slate-400 text-xs mb-1">Jasa Aktif</p>
            <p class="text-3xl font-black">{{ $stats['total_services'] }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="glass rounded-2xl p-6">
            <h3 class="font-bold mb-4">📝 PR Mendatang</h3>
            @if ($homeworksUpcoming->isEmpty())
                <p class="text-slate-500 text-sm">Belum ada PR.</p>
            @else
                <div class="space-y-3">
                    @foreach ($homeworksUpcoming as $hw)
                        <div class="bg-slate-800/40 rounded-xl p-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-sm">{{ $hw->title }}</p>
                                <p class="text-slate-500 text-xs">{{ $hw->subject }}</p>
                            </div>
                            <span class="text-blue-400 text-xs">{{ $hw->due_date->isoFormat('D MMM') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
            <a href="{{ route('admin.homework.index') }}"
                class="block text-center text-blue-400 text-sm mt-4 hover:text-blue-300">Kelola PR →</a>
        </div>

        <div class="glass rounded-2xl p-6">
            <h3 class="font-bold mb-4">📰 Berita Terbaru</h3>
            @if ($latestNews->isEmpty())
                <p class="text-slate-500 text-sm">Belum ada berita.</p>
            @else
                <div class="space-y-3">
                    @foreach ($latestNews as $news)
                        <div class="bg-slate-800/40 rounded-xl p-3 flex justify-between items-center">
                            <p class="font-medium text-sm line-clamp-1">{{ $news->title }}</p>
                            <span
                                class="text-xs px-2 py-0.5 rounded-full {{ $news->status === 'published' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                {{ $news->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
            <a href="{{ route('admin.news.index') }}"
                class="block text-center text-blue-400 text-sm mt-4 hover:text-blue-300">Kelola Berita →</a>
        </div>
    </div>

    <script>
        function waWidget() {
            return {
                pesan: '',
                loading: false,
                copied: false,
                waUrl: '{{ $waMessageUrl }}',
                grupUrl: '{{ $waGrupUrl }}',

                async generate() {
                    this.loading = true;
                    this.pesan = '';
                    try {
                        const res = await fetch(this.waUrl);
                        const data = await res.json();
                        this.pesan = data.pesan;
                    } catch (e) {
                        this.pesan = 'Gagal generate pesan. Coba lagi.';
                    }
                    this.loading = false;
                },

                copyPesan() {
                    navigator.clipboard.writeText(this.pesan);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                },

                waGrupLink() {
                    return this.grupUrl;
                }
            }
        }

        function emailWidget() {
            return {
                loading: false,
                result: '',
                success: false,
                url: '{{ $sendEmailUrl }}',

                async kirim() {
                    if (!confirm('Kirim email pengingat ke semua siswa sekarang?')) return;

                    this.loading = true;
                    this.result = '';
                    try {
                        const res = await fetch(this.url);
                        const data = await res.json();
                        this.result = data.message;
                        this.success = data.gagal === 0;
                    } catch (e) {
                        this.result = 'Gagal mengirim email. Coba lagi.';
                        this.success = false;
                    }
                    this.loading = false;
                }
            }
        }
    </script>

@endsection
