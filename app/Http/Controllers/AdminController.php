<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Homework;
use App\Models\Schedule;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_siswa'    => User::where('role', 'siswa')->count(),
            'total_homework' => Homework::where('is_done', false)->count(),
            'total_news'     => News::where('status', 'published')->count(),
            'total_services' => Service::where('is_active', true)->count(),
        ];

        $homeworksUpcoming = Homework::where('is_done', false)
            ->whereDate('due_date', '>=', today())
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $latestNews = News::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'homeworksUpcoming', 'latestNews'));
    }

    // ---- Kelola Akun Siswa ----

    public function siswaList()
    {
        $siswas = User::where('role', 'siswa')->orderBy('name')->get();
        return view('admin.siswa.index', compact('siswas'));
    }

    public function siswaCreate()
    {
        return view('admin.siswa.create');
    }

    public function siswaStore(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'nim'       => 'required|string|unique:users,nim',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
            'whatsapp'  => 'nullable|string|max:20',
        ], [
            'nim.unique'   => 'NIM sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'      => $request->name,
            'nim'       => $request->nim,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'whatsapp'  => $request->whatsapp,
            'role'      => 'siswa',
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Akun siswa berhasil ditambahkan!');
    }

    public function siswaDestroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak bisa menghapus akun admin!');
        }
        $user->delete();
        return back()->with('success', 'Akun siswa berhasil dihapus.');
    }

    // ---- Pengaturan Website ----

    public function settings()
    {
        $settings = SiteSetting::all()->keyBy('key');
        return view('admin.settings', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $request->validate([
            'class_name'      => 'required|string',
            'class_year'      => 'required|string',
            'university_name' => 'required|string',
            'class_motto'     => 'nullable|string',
            'whatsapp_group'  => 'nullable|url',
            'hero_animation'  => 'nullable|image|mimes:png,jpg,gif|max:5120',
        ]);

        $fields = ['class_name', 'class_year', 'university_name', 'class_motto', 'whatsapp_group'];

        foreach ($fields as $field) {
            SiteSetting::setValue($field, $request->input($field));
        }

        // Handle upload gambar animasi
        if ($request->hasFile('hero_animation')) {
            $old = SiteSetting::getValue('hero_animation');
            if ($old) Storage::disk('public')->delete($old);

            $path = $request->file('hero_animation')->store('animations', 'public');
            SiteSetting::setValue('hero_animation', $path);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function generateWAMessage()
    {
        $hariIni = $this->getHariIndonesia();
        $tanggal = now()->isoFormat('dddd, D MMMM Y');

        // Ambil jadwal hari ini
        $schedules = \App\Models\Schedule::where('day', $hariIni)
            ->orderBy('start_time')
            ->get();

        // Ambil PR deadline hari ini
        $homeworksToday = \App\Models\Homework::where('is_done', false)
            ->whereDate('due_date', today())
            ->orderBy('due_time')
            ->get();

        // Ambil PR deadline besok
        $homeworksTomorrow = \App\Models\Homework::where('is_done', false)
            ->whereDate('due_date', today()->addDay())
            ->orderBy('due_time')
            ->get();

        // Ambil PR deadline 3 hari ke depan (upcoming)
        $homeworksUpcoming = \App\Models\Homework::where('is_done', false)
            ->whereDate('due_date', '>', today()->addDay())
            ->whereDate('due_date', '<=', today()->addDays(3))
            ->orderBy('due_date')
            ->get();

        $className = \App\Models\SiteSetting::getValue('class_name', 'Kelas TIF');

        // Build pesan
        $pesan = "📢 *PENGINGAT HARIAN - {$className}*\n";
        $pesan .= "📅 {$tanggal}\n";
        $pesan .= str_repeat("─", 30) . "\n\n";

        // Jadwal hari ini
        if ($schedules->isEmpty()) {
            $pesan .= "📚 *JADWAL KULIAH HARI INI*\n";
            $pesan .= "Tidak ada kuliah hari ini 🎉\n\n";
        } else {
            $pesan .= "📚 *JADWAL KULIAH HARI INI ({$hariIni})*\n";
            foreach ($schedules as $s) {
                $mulai = \Carbon\Carbon::parse($s->start_time)->format('H:i');
                $selesai = \Carbon\Carbon::parse($s->end_time)->format('H:i');
                $pesan .= "• {$s->subject}\n";
                $pesan .= "  ⏰ {$mulai} - {$selesai}";
                if ($s->room) $pesan .= " | 📍 {$s->room}";
                if ($s->lecturer) $pesan .= "\n  👨‍🏫 {$s->lecturer}";
                $pesan .= "\n\n";
            }
        }

        // PR deadline hari ini
        if ($homeworksToday->isNotEmpty()) {
            $pesan .= "🚨 *DEADLINE HARI INI!*\n";
            foreach ($homeworksToday as $hw) {
                $pesan .= "• [{$hw->subject}] {$hw->title}\n";
                if ($hw->due_time) {
                    $jam = \Carbon\Carbon::parse($hw->due_time)->format('H:i');
                    $pesan .= "  ⏰ Deadline: {$jam} WIB\n";
                }
                if ($hw->description) {
                    $desc = \Illuminate\Support\Str::limit($hw->description, 80);
                    $pesan .= "  📝 {$desc}\n";
                }
                $pesan .= "\n";
            }
        }

        // PR deadline besok
        if ($homeworksTomorrow->isNotEmpty()) {
            $pesan .= "⚠️ *DEADLINE BESOK*\n";
            foreach ($homeworksTomorrow as $hw) {
                $pesan .= "• [{$hw->subject}] {$hw->title}\n";
                if ($hw->due_time) {
                    $jam = \Carbon\Carbon::parse($hw->due_time)->format('H:i');
                    $pesan .= "  ⏰ {$jam} WIB\n";
                }
                $pesan .= "\n";
            }
        }

        // PR upcoming
        if ($homeworksUpcoming->isNotEmpty()) {
            $pesan .= "📋 *TUGAS MENDATANG (3 hari ke depan)*\n";
            foreach ($homeworksUpcoming as $hw) {
                $tgl = $hw->due_date->isoFormat('D MMM');
                $pesan .= "• [{$hw->subject}] {$hw->title} - {$tgl}\n";
            }
            $pesan .= "\n";
        }

        // Kalau tidak ada PR sama sekali
        if ($homeworksToday->isEmpty() && $homeworksTomorrow->isEmpty() && $homeworksUpcoming->isEmpty()) {
            $pesan .= "✅ *TUGAS / PR*\n";
            $pesan .= "Tidak ada tugas mendatang. Santai dulu! 😊\n\n";
        }

        $pesan .= str_repeat("─", 30) . "\n";
        $pesan .= "_Pesan ini dikirim melalui InfoClass_ 🎓";

        return response()->json(['pesan' => $pesan]);
    }

    private function getHariIndonesia(): string
    {
        $map = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];
        return $map[now()->dayOfWeek];
    }

    public function sendDailyEmail()
    {
        $hariIni = $this->getHariIndonesia();
        $tanggal = now()->isoFormat('dddd, D MMMM Y');
        $className = \App\Models\SiteSetting::getValue('class_name', 'Kelas TIF');

        $schedules = \App\Models\Schedule::where('day', $hariIni)->orderBy('start_time')->get();

        $homeworksToday = \App\Models\Homework::where('is_done', false)
            ->whereDate('due_date', today())->orderBy('due_time')->get();

        $homeworksTomorrow = \App\Models\Homework::where('is_done', false)
            ->whereDate('due_date', today()->addDay())->orderBy('due_time')->get();

        $homeworksUpcoming = \App\Models\Homework::where('is_done', false)
            ->whereDate('due_date', '>', today()->addDay())
            ->whereDate('due_date', '<=', today()->addDays(3))
            ->orderBy('due_date')->get();

        $siswas = \App\Models\User::where('role', 'siswa')->get();

        $sukses = 0;
        $gagal = 0;

        foreach ($siswas as $siswa) {
            try {
                \Illuminate\Support\Facades\Mail::to($siswa->email)->send(
                    new \App\Mail\DailyReminderMail([
                        'studentName'        => $siswa->name,
                        'className'          => $className,
                        'tanggal'            => $tanggal,
                        'schedules'          => $schedules,
                        'homeworksToday'     => $homeworksToday,
                        'homeworksTomorrow'  => $homeworksTomorrow,
                        'homeworksUpcoming'  => $homeworksUpcoming,
                    ])
                );
                $sukses++;
            } catch (\Exception $e) {
                $gagal++;
            }
        }

        return response()->json([
            'message' => "Email terkirim ke {$sukses} siswa" . ($gagal > 0 ? ", {$gagal} gagal" : ""),
            'sukses' => $sukses,
            'gagal' => $gagal,
        ]);
    }
}
