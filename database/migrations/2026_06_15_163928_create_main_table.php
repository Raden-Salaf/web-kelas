<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =====================================================================
// MIGRATION: galleries (Galeri Foto)
// ---------------------------------------------------------------------
// Dua tipe konten:
//   - 'student' = foto profil + nama siswa
//   - 'moment'  = foto kegiatan/momen kelas
// =====================================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('photo_path');               // Path file foto (storage/public)
            $table->string('caption')->nullable();      // Caption / keterangan foto
            $table->string('student_name')->nullable(); // Nama siswa (jika tipe student)
            $table->string('nim')->nullable();          // NIM siswa (jika tipe student)
            $table->enum('type', ['student', 'moment'])->default('student');
            $table->string('album')->nullable();        // Nama album (untuk tipe moment)
            $table->foreignId('uploaded_by')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamps();
        });

        // =====================================================================
        // MIGRATION: news (Berita Kegiatan Kelas)
        // ---------------------------------------------------------------------
        // Untuk menyimpan berita/laporan kegiatan yang dibuat admin.
        // Mirip blog sederhana tapi untuk internal kelas.
        // =====================================================================
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // Judul berita
            $table->string('slug')->unique();           // URL-friendly title (auto-generate)
            $table->text('body');                       // Isi berita (bisa HTML)
            $table->string('cover_image')->nullable();  // Foto sampul berita
            $table->string('category')->nullable();     // Kategori (kegiatan, prestasi, dll)
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->foreignId('author_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // =====================================================================
        // MIGRATION: services (Jasa yang Dijual)
        // ---------------------------------------------------------------------
        // Admin bisa tambah/hapus jasa dari dashboard.
        // Pengunjung (guest) bisa lihat dan order via WhatsApp.
        // =====================================================================
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // Nama jasa
            $table->text('description');                // Deskripsi jasa
            $table->string('icon')->nullable();         // Icon (bisa emoji atau nama icon)
            $table->decimal('price_from', 10, 2)->nullable(); // Harga mulai dari
            $table->string('whatsapp_number');          // No WA untuk order
            $table->string('whatsapp_message')->nullable(); // Template pesan WA otomatis
            $table->string('image')->nullable();        // Foto contoh hasil kerja
            $table->boolean('is_active')->default(true); // Tampilkan atau tidak
            $table->integer('order')->default(0);       // Urutan tampil
            $table->timestamps();
        });

        // =====================================================================
        // MIGRATION: site_settings (Pengaturan Website)
        // ---------------------------------------------------------------------
        // Key-value store untuk pengaturan global: nama kelas, gambar animasi, dll.
        // KONSEP: Daripada hardcode "TIF A 2022" di semua view, simpan di DB
        //         supaya admin bisa ganti tanpa ubah kode.
        // =====================================================================
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();            // Kunci unik (e.g. 'class_name')
            $table->text('value')->nullable();          // Nilainya
            $table->string('type')->default('text');    // text | image | json
            $table->string('label');                    // Label untuk form admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('services');
        Schema::dropIfExists('news');
        Schema::dropIfExists('galleries');
    }
};