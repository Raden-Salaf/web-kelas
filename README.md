# 🎓 InfoClass — Website Kelas Teknik Informatika

InfoClass adalah platform digital untuk kelas — menyediakan pengingat tugas (PR), jadwal kuliah, galeri momen kelas, berita kegiatan, serta katalog jasa yang bisa dipesan langsung melalui WhatsApp. Dibangun dengan **Laravel 13**, **Tailwind CSS**, dan **Alpine.js**, dengan tampilan modern bernuansa biru dan animasi interaktif.

---

## ✨ Fitur Utama

- **Autentikasi Berbasis Role** — Login terpisah untuk Admin dan Siswa dengan middleware proteksi akses.
- **Pengingat PR** — Siswa melihat tugas yang dikelompokkan per tanggal, lengkap dengan prioritas dan status.
- **Jadwal Kuliah** — Ditampilkan per hari (Senin–Sabtu) dengan highlight otomatis untuk hari ini.
- **Kelola Akun Siswa** — Admin dapat menambah dan menghapus akun anggota kelas.
- **Galeri Foto** — Dua kategori: foto profil siswa dan momen kegiatan kelas (dikelompokkan per album).
- **Berita & Kegiatan** — Sistem publikasi berita dengan status draft/published.
- **Katalog Jasa** — Halaman publik untuk menampilkan jasa yang ditawarkan kelas, dengan tombol order langsung ke WhatsApp (nomor & template pesan dapat diatur per jasa).
- **Pengaturan Website** — Admin dapat mengubah identitas kelas dan gambar animasi hero tanpa menyentuh kode.
- **Desain Modern** — Tema biru dengan efek glassmorphism, glow, dan animasi melayang menggunakan Tailwind CSS + Alpine.js.

---

## 🧰 Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 13 (PHP 8.2+) |
| Frontend | Blade Templates, Tailwind CSS v4, Alpine.js |
| Database | MySQL |
| Build Tool | Vite |
| Auth | Laravel built-in Auth + Custom Role Middleware |

---

## 📁 Struktur Project

```
infoclass/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php        # Login & logout
│   │   │   ├── SiswaController.php       # Dashboard siswa
│   │   │   ├── AdminController.php       # Dashboard admin, kelola siswa & settings
│   │   │   ├── HomeworkController.php    # CRUD PR/tugas
│   │   │   ├── ScheduleController.php    # CRUD jadwal kuliah
│   │   │   ├── GalleryController.php     # Upload & kelola galeri foto
│   │   │   ├── NewsController.php        # CRUD & publikasi berita
│   │   │   └── ServiceController.php     # Landing page, kelola & tampilan jasa
│   │   └── Middleware/
│   │       └── RoleMiddleware.php        # Guard akses berdasarkan role (admin/siswa)
│   └── Models/
│       ├── User.php
│       ├── Homework.php
│       ├── Schedule.php
│       ├── Gallery.php
│       ├── News.php
│       ├── Service.php
│       └── SiteSetting.php               # Key-value settings (nama kelas, hero image, dll)
│
├── database/
│   ├── migrations/                       # Skema 7 tabel utama
│   └── seeders/
│       └── DatabaseSeeder.php            # Data dummy: admin, siswa, jadwal, PR, jasa, settings
│
├── resources/
│   ├── css/app.css                       # Tailwind v4 config + custom utility (glass, glow, dll)
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php             # Layout publik (navbar atas)
│       │   ├── siswa.blade.php           # Layout dashboard siswa (sidebar)
│       │   └── admin.blade.php           # Layout dashboard admin (sidebar)
│       ├── auth/login.blade.php
│       ├── landing.blade.php             # Halaman utama (hero, preview jasa, berita)
│       ├── dashboard/                    # Views untuk siswa: homework, schedule, services
│       ├── admin/                        # Views CRUD untuk semua modul admin
│       ├── gallery/, news/, services/    # Views publik
│       └── ...
│
└── routes/
    └── web.php                           # Semua route: publik, siswa, dan admin
```

---

## 🗄️ Struktur Database

| Tabel | Keterangan |
|---|---|
| `users` | Akun admin & siswa (kolom `role` membedakan akses) |
| `homeworks` | Data tugas/PR dengan deadline, prioritas, dan status selesai |
| `schedules` | Jadwal kuliah per hari, dosen, jam, dan ruangan |
| `galleries` | Foto siswa & momen kelas (dibedakan lewat kolom `type`) |
| `news` | Berita/kegiatan kelas dengan status draft/published |
| `services` | Katalog jasa beserta nomor WhatsApp tujuan order |
| `site_settings` | Pengaturan global website (key-value pairs) |

---

## 🚀 Instalasi & Setup (Setelah Clone)

### 1. Clone Repository

```bash
git clone https://github.com/username/infoclass.git
cd infoclass
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Environment

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buka file `.env`, sesuaikan kredensial database kamu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=infoclass_db
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
```

> Pastikan database `infoclass_db` (atau nama lain sesuai `.env` kamu) sudah dibuat di MySQL sebelum lanjut ke step berikutnya.

### 5. Jalankan Migration & Seeder

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan membuat seluruh tabel dan mengisi data awal (akun admin, akun siswa contoh, jadwal, PR, dan jasa).

### 6. Buat Symbolic Link untuk Storage

Wajib dijalankan supaya file yang diupload (foto galeri, berita, gambar hero) bisa diakses publik:

```bash
php artisan storage:link
```

### 7. Build Frontend Assets

Untuk development (dengan hot-reload):

```bash
npm run dev
```

Untuk production:

```bash
npm run build
```

### 8. Jalankan Development Server

Di terminal baru (biarkan `npm run dev` tetap berjalan):

```bash
php artisan serve
```

Buka browser ke `http://localhost:8000`.

---

## 🔑 Akun Default (Hasil Seeder)

| Role | Email | Password |
|---|---|---|
| Admin | admin@infoclass.dev | admin123 |
| Siswa | budi@siswa.dev | siswa123 |

> **Penting:** Ganti password akun-akun ini segera setelah deploy ke production.

---

## 🧭 Alur Penggunaan

- **Pengunjung umum** (tanpa login) dapat mengakses: Beranda, Berita, Galeri, dan Jasa.
- **Siswa** login untuk melihat: Dashboard (ringkasan PR & jadwal hari ini), Tugas/PR, Jadwal Kuliah, Galeri, Berita, dan Jasa Kelas.
- **Admin** login untuk mengelola seluruh konten: PR, Jadwal, Akun Siswa, Galeri, Berita, Jasa, dan Pengaturan Website.

Panduan penggunaan lengkap untuk admin tersedia di file `Panduan_Admin_InfoClass.docx` (lihat dokumentasi terpisah).

---

## ⚙️ Kustomisasi

### Mengubah Identitas Website
Login sebagai admin → menu **Pengaturan** → ubah Nama Kelas, Angkatan, Nama Kampus, Motto, dan upload Gambar Animasi Hero.

### Mengatur Nomor WhatsApp Tujuan Jasa
Format nomor **harus** internasional tanpa tanda `+` dan tanpa `0` di depan:

```
081234567890   →   6281234567890
```

Diatur per jasa di menu **Kelola Jasa** (field "No. WhatsApp untuk Order").

---

## 🛠️ Perintah Artisan yang Sering Dipakai

```bash
# Reset total database + isi ulang data dummy
php artisan migrate:fresh --seed

# Bersihkan semua cache (config, route, view)
php artisan optimize:clear

# Buat ulang symbolic link storage
php artisan storage:link

# Cek semua route yang terdaftar
php artisan route:list
```

---

## 📄 Lisensi

Project ini dibuat untuk keperluan internal kelas dan pembelajaran. Bebas dimodifikasi sesuai kebutuhan.

---

## 🙌 Kontributor

Dikembangkan oleh mahasiswa Teknik Informatika sebagai sarana belajar pengembangan web full-stack menggunakan Laravel.
instagram : den_salafy

