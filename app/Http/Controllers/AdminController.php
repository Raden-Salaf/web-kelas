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
}