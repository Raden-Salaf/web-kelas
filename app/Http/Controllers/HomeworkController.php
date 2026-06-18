<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    // Untuk SISWA: lihat PR yang akan datang, dikelompokkan per tanggal
    public function index()
    {
        // Cek role supaya satu method bisa dipakai 2 konteks
        if (auth()->user()->isAdmin()) {
            $homeworks = Homework::orderBy('due_date', 'desc')->get();
            return view('admin.homework.index', compact('homeworks'));
        }

        $homeworks = Homework::where('is_done', false)
            ->whereDate('due_date', '>=', today())
            ->orderBy('due_date')
            ->get()
            ->groupBy(fn($hw) => $hw->due_date->format('Y-m-d'));

        return view('dashboard.homework', compact('homeworks'));
    }

    public function create()
    {
        return view('admin.homework.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'subject'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date|after_or_equal:today',
            'due_time'    => 'nullable|date_format:H:i',
            'priority'    => 'required|in:low,medium,high',
        ]);

        Homework::create([
            ...$request->only(['title','subject','description','due_date','due_time','priority']),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.homework.index')
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function edit(Homework $homework)
    {
        return view('admin.homework.edit', compact('homework'));
    }

    public function update(Request $request, Homework $homework)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'subject'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date',
            'due_time'    => 'nullable|date_format:H:i',
            'priority'    => 'required|in:low,medium,high',
            'is_done'     => 'boolean',
        ]);

        $homework->update([
            ...$request->only(['title','subject','description','due_date','due_time','priority']),
            'is_done' => $request->boolean('is_done'),
        ]);

        return redirect()->route('admin.homework.index')
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Homework $homework)
    {
        $homework->delete();
        return back()->with('success', 'Tugas berhasil dihapus.');
    }
}