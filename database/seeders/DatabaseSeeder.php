<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==============================================
        // 1. AKUN ADMIN
        // ==============================================
        $adminId = DB::table('users')->insertGetId([
            'name'       => 'Admin Kelas',
            'nim'        => null,
            'email'      => 'admin@infoclass.dev',
            'password'   => Hash::make('admin123'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ==============================================
        // 2. AKUN SISWA CONTOH
        // ==============================================
        $siswaList = [
            ['name' => 'Budi Santoso',  'nim' => '2201001', 'email' => 'budi@siswa.dev'],
            ['name' => 'Siti Rahayu',   'nim' => '2201002', 'email' => 'siti@siswa.dev'],
            ['name' => 'Ahmad Fauzi',   'nim' => '2201003', 'email' => 'ahmad@siswa.dev'],
            ['name' => 'Dewi Lestari',  'nim' => '2201004', 'email' => 'dewi@siswa.dev'],
            ['name' => 'Reza Pratama',  'nim' => '2201005', 'email' => 'reza@siswa.dev'],
        ];

        foreach ($siswaList as $siswa) {
            DB::table('users')->insert([
                'name'       => $siswa['name'],
                'nim'        => $siswa['nim'],
                'email'      => $siswa['email'],
                'password'   => Hash::make('siswa123'),
                'role'       => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ==============================================
        // 3. JADWAL MATA KULIAH
        // ==============================================
        $schedules = [
            ['Senin',   'Algoritma & Pemrograman', 'Dr. Hendra, M.Kom', '08:00', '10:00', 'Lab. Komputer A', '#3B82F6', 1],
            ['Senin',   'Basis Data',              'Ir. Sari, M.T',     '13:00', '15:00', 'Ruang 301',       '#8B5CF6', 2],
            ['Selasa',  'Pemrograman Web',         'M. Rizky, S.Kom',   '08:00', '10:00', 'Lab. Komputer B', '#10B981', 1],
            ['Selasa',  'Jaringan Komputer',       'Dr. Agus, M.T',     '10:30', '12:30', 'Ruang 201',       '#F59E0B', 2],
            ['Rabu',    'Kalkulus',                'Prof. Dewi, M.Si',  '08:00', '10:00', 'Aula Gedung C',   '#EF4444', 1],
            ['Rabu',    'Sistem Operasi',          'Dr. Budi, M.Kom',   '13:00', '15:00', 'Lab. Komputer A', '#06B6D4', 2],
            ['Kamis',   'Rekayasa Perangkat Lunak','Ir. Tono, M.T',     '08:00', '10:00', 'Ruang 102',       '#84CC16', 1],
            ['Kamis',   'Struktur Data',           'M. Fajar, S.Kom',   '10:30', '12:30', 'Lab. Komputer B', '#F97316', 2],
            ['Jumat',   'Pemrograman Mobile',      'Dr. Rina, M.Kom',   '08:00', '11:00', 'Lab. Komputer A', '#EC4899', 1],
        ];

        foreach ($schedules as $s) {
            DB::table('schedules')->insert([
                'day'        => $s[0],
                'subject'    => $s[1],
                'lecturer'   => $s[2],
                'start_time' => $s[3],
                'end_time'   => $s[4],
                'room'       => $s[5],
                'color'      => $s[6],
                'order'      => $s[7],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ==============================================
        // 4. PR / TUGAS
        // ==============================================
        $homeworks = [
            [
                'title'       => 'Laporan Praktikum Basis Data',
                'subject'     => 'Basis Data',
                'description' => 'Buat laporan praktikum pertemuan 5 tentang JOIN query. Format PDF, minimal 10 halaman.',
                'due_date'    => Carbon::now()->addDays(2)->format('Y-m-d'),
                'due_time'    => '23:59:00',
                'priority'    => 'high',
            ],
            [
                'title'       => 'Implementasi Algoritma Sorting',
                'subject'     => 'Algoritma & Pemrograman',
                'description' => 'Implementasikan bubble sort, quick sort, dan merge sort dalam C. Upload ke GitHub.',
                'due_date'    => Carbon::now()->addDays(5)->format('Y-m-d'),
                'due_time'    => '23:59:00',
                'priority'    => 'medium',
            ],
            [
                'title'       => 'Quiz Online Jaringan Komputer',
                'subject'     => 'Jaringan Komputer',
                'description' => 'Quiz di eLearning kampus, materi OSI Layer dan TCP/IP. Durasi 30 menit.',
                'due_date'    => Carbon::now()->addDay()->format('Y-m-d'),
                'due_time'    => '10:00:00',
                'priority'    => 'high',
            ],
            [
                'title'       => 'UAS Kalkulus',
                'subject'     => 'Kalkulus',
                'description' => 'Ujian Akhir Semester. Materi integral dan diferensial. Bawa kalkulator scientific.',
                'due_date'    => Carbon::now()->addDays(10)->format('Y-m-d'),
                'due_time'    => '08:00:00',
                'priority'    => 'high',
            ],
            [
                'title'       => 'Desain UI Aplikasi Mobile',
                'subject'     => 'Pemrograman Mobile',
                'description' => 'Buat desain UI untuk aplikasi to-do list menggunakan Figma. Minimal 5 screen.',
                'due_date'    => Carbon::now()->addDays(7)->format('Y-m-d'),
                'due_time'    => '23:59:00',
                'priority'    => 'low',
            ],
        ];

        foreach ($homeworks as $hw) {
            DB::table('homeworks')->insert([
                'title'       => $hw['title'],
                'subject'     => $hw['subject'],
                'description' => $hw['description'],
                'due_date'    => $hw['due_date'],
                'due_time'    => $hw['due_time'],
                'priority'    => $hw['priority'],
                'is_done'     => false,
                'created_by'  => $adminId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // ==============================================
        // 5. JASA
        // ==============================================
        $services = [
            [
                'title'            => 'Pembuatan Website',
                'description'      => 'Kami membuat website profesional untuk bisnis, portofolio, atau UMKM. Teknologi: Laravel, React, atau WordPress sesuai kebutuhan.',
                'icon'             => '🌐',
                'price_from'       => 500000,
                'whatsapp_number'  => '6281234567890',
                'whatsapp_message' => 'Halo, saya tertarik dengan jasa pembuatan website. Boleh minta info lebih lanjut?',
                'is_active'        => true,
                'order'            => 1,
            ],
            [
                'title'            => 'Desain UI/UX',
                'description'      => 'Desain tampilan aplikasi mobile dan web yang menarik menggunakan Figma.',
                'icon'             => '🎨',
                'price_from'       => 200000,
                'whatsapp_number'  => '6281234567890',
                'whatsapp_message' => 'Halo, saya ingin memesan jasa desain UI/UX. Boleh minta portofolio dulu?',
                'is_active'        => true,
                'order'            => 2,
            ],
            [
                'title'            => 'Pembuatan Aplikasi Mobile',
                'description'      => 'Bangun aplikasi Android/iOS dengan Flutter. Cocok untuk startup dan sistem informasi.',
                'icon'             => '📱',
                'price_from'       => 1500000,
                'whatsapp_number'  => '6281234567890',
                'whatsapp_message' => 'Halo, saya ingin membuat aplikasi mobile. Bisa jelaskan prosesnya?',
                'is_active'        => true,
                'order'            => 3,
            ],
            [
                'title'            => 'Jasa Pengetikan & Laporan',
                'description'      => 'Ketik laporan, skripsi, makalah, atau dokumen lainnya dengan rapi dan cepat.',
                'icon'             => '📄',
                'price_from'       => 50000,
                'whatsapp_number'  => '6281234567890',
                'whatsapp_message' => 'Halo, saya butuh bantuan pengetikan dokumen. Bisa minta info harga?',
                'is_active'        => true,
                'order'            => 4,
            ],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert([
                ...$service,
                'image'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ==============================================
        // 6. SITE SETTINGS
        // ==============================================
        $settings = [
            ['key' => 'class_name',      'value' => 'Teknik Informatika A',        'type' => 'text',  'label' => 'TI A - 2024'],
            ['key' => 'class_year',      'value' => '2022',                        'type' => 'text',  'label' => 'Angkatan'],
            ['key' => 'university_name', 'value' => 'Unusia',       'type' => 'text',  'label' => 'Nama Kampus'],
            ['key' => 'class_motto',     'value' => 'Code Together, Grow Together','type' => 'text',  'label' => 'Motto Kelas'],
            ['key' => 'whatsapp_group',  'value' => 'https://chat.whatsapp.com/',  'type' => 'text',  'label' => 'Link Grup WA'],
            ['key' => 'hero_animation',  'value' => null,                          'type' => 'image', 'label' => 'Gambar Animasi Hero (PNG/GIF)'],
            ['key' => 'primary_color',   'value' => '#1D4ED8',                     'type' => 'text',  'label' => 'Warna Utama Website'],
        ];

        foreach ($settings as $s) {
            DB::table('site_settings')->insert([
                ...$s,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}