@extends('layouts.admin')

@section('title', 'Kelola Siswa')
@section('page-title', 'Kelola Akun Siswa')
@section('page-icon', '👥')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-slate-400 text-sm">Total {{ $siswas->count() }} siswa terdaftar</p>
    <a href="{{ route('admin.siswa.create') }}"
       class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        + Tambah Siswa
    </a>
</div>

<div class="glass rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-800/50 text-slate-400 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Nama</th>
                    <th class="px-5 py-3 font-medium">NIM</th>
                    <th class="px-5 py-3 font-medium">Email</th>
                    <th class="px-5 py-3 font-medium">WhatsApp</th>
                    <th class="px-5 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($siswas as $siswa)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-5 py-4 font-medium">{{ $siswa->name }}</td>
                        <td class="px-5 py-4 text-slate-400">{{ $siswa->nim ?? '-' }}</td>
                        <td class="px-5 py-4 text-slate-400">{{ $siswa->email }}</td>
                        <td class="px-5 py-4 text-slate-400">{{ $siswa->whatsapp ?? '-' }}</td>
                        <td class="px-5 py-4 text-right">
                            <form method="POST" action="{{ route('admin.siswa.destroy', $siswa) }}"
                                  onsubmit="return confirm('Yakin hapus akun siswa ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-slate-500">Belum ada siswa terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection