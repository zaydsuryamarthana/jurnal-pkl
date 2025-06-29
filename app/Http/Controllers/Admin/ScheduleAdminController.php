<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Report;
use App\Models\Schedule;
use App\Models\Internship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ScheduleAdminController extends Controller
{
    public function store(Request $request, $id)
    {
        $admin = Auth::user();
        $data = Schedule::where('id', $id);

        $request->validate([
            'verif' => 'required',
        ]);

        $data->update([
            'status_verifikasi' => $request->verif,
        ]);

        return back()->with('success', 'Berhasil verifikasi permintaan jadwal Siswa');
    }
    public function internship(Request $request, $id)
    {
        $admin = Auth::user();
        $data = Internship::where('id', $id);

        $request->validate([
            'verifikasi' => 'required'
        ]);

        $data->update([
            'verifikasi' => $request->verifikasi
        ]);

        return back()->with('success', 'Berhasil verifikasi permintaan jadwal PKL');
    }
}
