<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private array $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

    public function index()
    {
        $schedules = Schedule::orderBy('order')->get()->groupBy('day');
        $hariIni = $this->getHariIndonesia();

        if (auth()->user()->isAdmin()) {
            return view('admin.schedule.index', [
                'schedules' => $schedules,
                'days'      => $this->days,
            ]);
        }

        return view('dashboard.schedule', [
            'schedules' => $schedules,
            'days'      => $this->days,
            'hariIni'   => $hariIni,
        ]);
    }

    public function create()
    {
        return view('admin.schedule.create', ['days' => $this->days]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'day'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'subject'    => 'required|string|max:255',
            'lecturer'   => 'nullable|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'room'       => 'nullable|string|max:100',
            'color'      => 'nullable|string|max:7',
        ]);

        Schedule::create($request->all());

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedule.edit', [
            'schedule' => $schedule,
            'days'     => $this->days,
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'day'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'subject'    => 'required|string|max:255',
            'lecturer'   => 'nullable|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'room'       => 'nullable|string|max:100',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    private function getHariIndonesia(): string
    {
        $map = [0=>'Minggu',1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu'];
        return $map[now()->dayOfWeek];
    }
}