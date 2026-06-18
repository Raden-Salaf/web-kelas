<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\Schedule;
use App\Models\News;
use App\Models\SiteSetting;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function dashboard()
    {
        // PR hari ini
        $homeworksToday = Homework::whereDate('due_date', today())
            ->where('is_done', false)
            ->orderBy('due_time')
            ->get();

        // PR upcoming (5 hari ke depan, belum selesai)
        $homeworksUpcoming = Homework::where('is_done', false)
            ->whereDate('due_date', '>', today())
            ->whereDate('due_date', '<=', Carbon::now()->addDays(5))
            ->orderBy('due_date')
            ->get();

        // Jadwal hari ini
        $hariIni = $this->getHariIndonesia();
        $scheduleToday = Schedule::where('day', $hariIni)
            ->orderBy('start_time')
            ->get();

        // Berita terbaru (3 saja untuk preview)
        $latestNews = News::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Setting website
        $settings = [
            'class_name'      => SiteSetting::getValue('class_name', 'Kelas TIF'),
            'class_motto'     => SiteSetting::getValue('class_motto'),
            'hero_animation'  => SiteSetting::getValue('hero_animation'),
        ];

        return view('dashboard.siswa', compact(
            'homeworksToday',
            'homeworksUpcoming',
            'scheduleToday',
            'latestNews',
            'settings',
            'hariIni'
        ));
    }

    // Helper: ambil nama hari dalam Bahasa Indonesia
    private function getHariIndonesia(): string
    {
        $map = [
            0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa',
            3 => 'Rabu',   4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'
        ];
        return $map[now()->dayOfWeek];
    }
}