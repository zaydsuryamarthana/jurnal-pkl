<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportAdminController extends Controller
{
    public function index($id)
    {
        $data = Report::with('user')->find($id);
        return view('admin.tugas.index', compact('data'));
    }
    public function active(Request $request, $id)
    {
        $admin = Auth::user();
        $user = User::where('id', $id)->where('admin_id', $admin->id)->firstOrFail();
        $request->validate([
            'izin' => 'required',
        ]);

        Report::create([
            'user_id' => $user->id,
            'izin' => $request->izin,
        ]);

        return back()->with('success', 'Berhasil mengaktifkan Laporan Akhir' . $user->nama);
    }
    public function update(Request $request, $id)
    {
        $data = Report::find($id);
        $request->validate([
            'verif' => 'required',
        ]);
        if ($data) {
            $data->update([
                'komentar' => $request->komentar,
                'verifikasi' => $request->verif
            ]);
            return back()->with('success', 'Berhasil verifikasi data Laporan Akhir');
        } else {
            return back()->with('error', 'Gagal melakukan verifikasi data Laporan Akhir');
        }
    }
}
