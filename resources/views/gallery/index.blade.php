@extends('layouts.app')

@section('title', 'Galeri')

@section('content')

    <section class="relative pt-32 pb-20 overflow-hidden" x-data="{ tab: 'all' }">

        <div class="absolute inset-0 bg-dots opacity-30"></div>
        <div class="absolute top-20 right-0 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-0 w-80 h-80 bg-violet-600/15 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12">
                <span
                    class="inline-block bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                    🖼️ Galeri Kelas
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-3">
                    <marquee behavior="" direction="">Momen & <span class="gradient-text">Wajah-Wajah Unyu Kami</span>
                    </marquee>
                </h1>
                <p class="text-slate-400 max-w-xl mx-auto">
                    Kenali anggota kelas kami dan lihat keseruan momen-momen yang sudah kami lewati bersama.
                </p>
            </div>

            {{-- KARTU KATEGORI --}}
            <div class="grid grid-cols-3 gap-4 mb-12 max-w-2xl mx-auto">
                <button @click="tab = 'all'"
                    :class="tab === 'all' ? 'ring-2 ring-blue-500 bg-blue-500/10' : 'glass hover:bg-blue-500/5'"
                    class="rounded-2xl p-5 text-center transition cursor-pointer">
                    <div class="text-2xl mb-2">🗂️</div>
                    <p class="font-semibold text-sm" :class="tab === 'all' ? 'text-blue-400' : 'text-white'">Semua</p>
                    <p class="text-slate-500 text-xs mt-0.5">{{ $students->count() + $moments->flatten()->count() }} foto
                    </p>
                </button>

                <button @click="tab = 'student'"
                    :class="tab === 'student' ? 'ring-2 ring-blue-500 bg-blue-500/10' : 'glass hover:bg-blue-500/5'"
                    class="rounded-2xl p-5 text-center transition cursor-pointer">
                    <div class="text-2xl mb-2">👤</div>
                    <p class="font-semibold text-sm" :class="tab === 'student' ? 'text-blue-400' : 'text-white'">Siswa</p>
                    <p class="text-slate-500 text-xs mt-0.5">{{ $students->count() }} orang</p>
                </button>

                <button @click="tab = 'moment'"
                    :class="tab === 'moment' ? 'ring-2 ring-blue-500 bg-blue-500/10' : 'glass hover:bg-blue-500/5'"
                    class="rounded-2xl p-5 text-center transition cursor-pointer">
                    <div class="text-2xl mb-2">📸</div>
                    <p class="font-semibold text-sm" :class="tab === 'moment' ? 'text-blue-400' : 'text-white'">Momen</p>
                    <p class="text-slate-500 text-xs mt-0.5">{{ $moments->flatten()->count() }} foto</p>
                </button>
            </div>

            {{-- FOTO SISWA --}}
            <div x-show="tab === 'all' || tab === 'student'" class="mb-20">
                <div class="flex items-center gap-3 mb-8">
                    <span class="text-2xl">👤</span>
                    <h2 class="text-xl font-bold">Anggota Kelas</h2>
                    <span class="text-slate-500 text-sm">({{ $students->count() }} orang)</span>
                </div>

                @if ($students->isEmpty())
                    <div class="glass rounded-2xl p-10 text-center">
                        <p class="text-slate-500 text-sm">Belum ada foto siswa yang diupload.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
                        @foreach ($students as $student)
                            <div>
                                <div
                                    class="aspect-square rounded-2xl overflow-hidden border border-blue-500/20 bg-slate-800 group">
                                    <img src="{{ $student->photo_url }}"
                                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110">
                                </div>
                                <div class="mt-2 px-1 text-center">
                                    <p class="font-semibold text-xs truncate">{{ $student->student_name }}</p>
                                    @if ($student->nim)
                                        <p class="text-slate-500 text-[11px]">{{ $student->nim }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- MOMEN KELAS --}}
            <div x-show="tab === 'all' || tab === 'moment'">
                <div class="flex items-center gap-3 mb-8">
                    <span class="text-2xl">📸</span>
                    <h2 class="text-xl font-bold">Momen Kelas</h2>
                </div>

                @if ($moments->isEmpty())
                    <div class="glass rounded-2xl p-10 text-center">
                        <p class="text-slate-500 text-sm">Belum ada momen yang diupload.</p>
                    </div>
                @else
                    <div class="space-y-12">
                        @foreach ($moments as $album => $photos)
                            <div>
                                <div class="flex items-center gap-2 mb-5">
                                    <span class="w-1.5 h-5 bg-blue-500 rounded-full"></span>
                                    <h3 class="font-semibold text-blue-400">{{ $album ?? 'Tanpa Album' }}</h3>
                                    <span class="text-slate-500 text-xs">({{ $photos->count() }} foto)</span>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                                    @foreach ($photos as $photo)
                                        <div>
                                            <div
                                                class="aspect-square rounded-2xl overflow-hidden border border-blue-500/20 bg-slate-800 group">
                                                <img src="{{ $photo->photo_url }}"
                                                    class="w-full h-full object-cover transition duration-300 group-hover:scale-110">
                                            </div>
                                            @if ($photo->caption)
                                                <p class="text-slate-400 text-xs mt-2 px-1 line-clamp-2">
                                                    {{ $photo->caption }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </section>

@endsection
