<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Publik & siswa: foto dikelompokkan
    public function index()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            $galleries = Gallery::latest()->get();
            return view('admin.gallery.index', compact('galleries'));
        }

        $students = Gallery::where('type', 'student')->orderBy('student_name')->get();
        $moments  = Gallery::where('type', 'moment')->latest()->get()->groupBy('album');

        return view('gallery.index', compact('students', 'moments'));
    }

    public function siswaIndex()
    {
        $students = Gallery::where('type', 'student')->orderBy('student_name')->get();
        $moments  = Gallery::where('type', 'moment')->latest()->get()->groupBy('album');
        return view('gallery.index', compact('students', 'moments'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo'        => 'required|image|max:3072',
            'type'         => 'required|in:student,moment',
            'student_name' => 'required_if:type,student|nullable|string',
            'nim'          => 'nullable|string',
            'caption'      => 'nullable|string',
            'album'        => 'required_if:type,moment|nullable|string',
        ]);

        $path = $request->file('photo')->store('gallery', 'public');

        Gallery::create([
            'photo_path'   => $path,
            'type'         => $request->type,
            'student_name' => $request->student_name,
            'nim'          => $request->nim,
            'caption'      => $request->caption,
            'album'        => $request->album,
            'uploaded_by'  => auth()->id(),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil diupload!');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->photo_path);
        $gallery->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}