<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ScheduleController extends Controller
{
    protected function getWeekStartDate()
    {
        return Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
    }
    public function index()
    {
        $user = Auth::user();
        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();

        $weeklySchedule = Schedule::where('user_id', $user->id)
            ->where('week_start_date', $monday)
            ->first();

        $today = Carbon::now()->locale('id');
        $todayName = strtolower($today->isoFormat('dddd')); // senin, selasa, ...

        $jamMasuk = $weeklySchedule ? $weeklySchedule->{"{$todayName}_masuk"} : null;
        $jamKeluar = $weeklySchedule ? $weeklySchedule->{"{$todayName}_keluar"} : null;

        return view('user.jadwal.index', compact('weeklySchedule', 'user', 'todayName', 'jamMasuk', 'jamKeluar'));
    }

    public function jadwalStatic(Request $request)
    {
        $user = Auth::user();
        $data = Internship::where('id', $user->internship_id);
        $request->validate([
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'verifikasi' => 'required'
        ]);

        $data->update([
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'verifikasi' => $request->verifikasi
        ]);

        if ($data) {
            return back()->with('success', 'Berhasil');
        } else {
            return back()->with('success', 'gagal');
        }
    }

    public function jadwal(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'week_start_date' => 'required|date',
            'senin_masuk' => 'nullable|date_format:H:i',
            'senin_keluar' => 'nullable|date_format:H:i|after:senin_masuk',
            'selasa_masuk' => 'nullable|date_format:H:i',
            'selasa_keluar' => 'nullable|date_format:H:i|after:selasa_masuk',
            'rabu_masuk' => 'nullable|date_format:H:i',
            'rabu_keluar' => 'nullable|date_format:H:i|after:rabu_masuk',
            'kamis_masuk' => 'nullable|date_format:H:i',
            'kamis_keluar' => 'nullable|date_format:H:i|after:kamis_masuk',
            'jumat_masuk' => 'nullable|date_format:H:i',
            'jumat_keluar' => 'nullable|date_format:H:i|after:jumat_masuk',
            'sabtu_masuk' => 'nullable|date_format:H:i',
            'sabtu_keluar' => 'nullable|date_format:H:i|after:sabtu_masuk',
        ];

        $validated = $request->validate($rules);
        Schedule::updateOrCreate(
            [
                'user_id' => $user->id,
                'week_start_date' => $validated['week_start_date'],
            ],
            [
                'senin_masuk' => $validated['senin_masuk'],
                'senin_keluar' => $validated['senin_keluar'],
                'selasa_masuk' => $validated['selasa_masuk'],
                'selasa_keluar' => $validated['selasa_keluar'],
                'rabu_masuk' => $validated['rabu_masuk'],
                'rabu_keluar' => $validated['rabu_keluar'],
                'kamis_masuk' => $validated['kamis_masuk'],
                'kamis_keluar' => $validated['kamis_keluar'],
                'jumat_masuk' => $validated['jumat_masuk'],
                'jumat_keluar' => $validated['jumat_keluar'],
                'sabtu_masuk' => $validated['sabtu_masuk'],
                'sabtu_keluar' => $validated['sabtu_keluar'],
                'status_verifikasi' => 'pending',
            ]
        );

        return redirect()->back()->with('success', 'Jadwal mingguan berhasil disimpan dan menunggu verifikasi admin.');
    }

    public function updateJadwalStatic(Request $request)
    {
        $user = Auth::user();
        $internship = Internship::where('id', $user->internship_id);

        $request->validate([
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
        ]);

        if ($internship) {
            $internship->update([
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
                'verifikasi' => 'pending'
            ]);

            return back()->with('success', 'Berhasil mengupdate Jadwal PKL kamu.');
        } else {
            return back()->with('error', 'Gagal menyimpan perubahan jadwal kamu.');
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $data = Schedule::where('user_id', $user->id)
            ->where('week_start_date', $monday)
            ->firstOrFail();

        $request->validate([
            'senin_masuk' => 'required|date_format:H:i',
            'senin_keluar' => 'required|date_format:H:i',
            'selasa_masuk' => 'required|date_format:H:i',
            'selasa_keluar' => 'required|date_format:H:i',
            'rabu_masuk' => 'required|date_format:H:i',
            'rabu_keluar' => 'required|date_format:H:i',
            'kamis_masuk' => 'required|date_format:H:i',
            'kamis_keluar' => 'required|date_format:H:i',
            'jumat_masuk' => 'required|date_format:H:i',
            'jumat_keluar' => 'required|date_format:H:i',
        ]);
        $data->update([
            'senin_masuk' => $request->senin_masuk,
            'senin_keluar' => $request->senin_keluar,
            'selasa_masuk' => $request->selasa_masuk,
            'selasa_keluar' => $request->selasa_keluar,
            'rabu_masuk' => $request->rabu_masuk,
            'rabu_keluar' => $request->rabu_keluar,
            'kamis_masuk' => $request->kamis_masuk,
            'kamis_keluar' => $request->kamis_keluar,
            'jumat_masuk' => $request->jumat_masuk,
            'jumat_keluar' => $request->jumat_keluar,
            'status_verifikasi' => 'pending'
        ]);

        if ($data) {
            return back()->with('success', 'Jadwal berhasil disimpan. Menunggu verifikasi.');
        } else {
            return back()->with('error', 'Gagal.');
        }
    }


    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        if ($schedule->user_id === Auth::id()) {
            $schedule->delete();
        }
        return back();
    }
}
