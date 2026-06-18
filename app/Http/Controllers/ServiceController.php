<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\News;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    // Landing page untuk guest
    public function landing()
    {
        $services = Service::active()->take(3)->get(); // hanya 3 untuk preview
        $latestNews = News::published()->latest('published_at')->take(3)->get();
        $settings = [
            'class_name'     => SiteSetting::getValue('class_name', 'Kelas TIF'),
            'class_motto'    => SiteSetting::getValue('class_motto'),
            'university_name' => SiteSetting::getValue('university_name'),
            'hero_animation' => SiteSetting::getValue('hero_animation'),
        ];
        return view('landing', compact('services', 'latestNews', 'settings'));
    }

    public function publicIndex()
    {
        $services = Service::active()->get();
        return view('services.index', compact('services'));
    }

    // Untuk siswa (sama tapi pakai layout siswa)
    public function siswaIndex()
    {
        $services = Service::active()->get();
        return view('dashboard.services', compact('services'));
    }

    // Admin: daftar jasa
    public function index()
    {
        $services = Service::orderBy('order')->get();
        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'icon'             => 'nullable|string|max:10',
            'price_from'       => 'nullable|numeric|min:0',
            'whatsapp_number'  => 'required|string|max:20',
            'whatsapp_message' => 'nullable|string',
            'image'            => 'nullable|image|max:2048',
            'is_active'        => 'boolean',
            'order'            => 'integer|min:0',
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);
        return redirect()->route('admin.service.index')->with('success', 'Jasa berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'whatsapp_number'  => 'required|string|max:20',
            'price_from'       => 'nullable|numeric|min:0',
            'image'            => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);
        return redirect()->route('admin.service.index')->with('success', 'Jasa berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        if ($service->image) Storage::disk('public')->delete($service->image);
        $service->delete();
        return back()->with('success', 'Jasa berhasil dihapus.');
    }
}
