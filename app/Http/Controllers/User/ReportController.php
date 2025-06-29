<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = Report::where('user_id', $user->id)->first();
        $safe = Str::slug($user->nama);
        return view('user.tugas.index', compact('user', 'data', 'safe'));
    }

    public function pengajuan(Request $request)
    {
        $user = Auth::user();
        $report = Report::where('user_id', $user->id)->first();
        $request->validate([
            'judul' => 'required|string',
            'tujuan' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,docx',
            'dudi' => 'required|string',
        ]);

        $today = now()->toDateString();
        $foto = $request->file('file');
        $extension = $foto->getClientOriginalExtension();

        $safe = Str::slug($user->nama);
        $path = "user/report/{$safe}";

        $filename = time() . '_' . $safe . '.' . $extension;
        $foto->storeAs($path, $filename, 'public');

        if ($report) {
            $report->update([
                'judul' => $request->judul,
                'tujuan' => $request->tujuan,
                'deskripsi' => $request->deskripsi,
                'verifikasi' => 'pending',
                'file' => $filename,
                'tgl' => $today,
                'dudi' => $request->dudi
            ]);


            return back()->with('success', 'Berhasil mengirimkan pengajuan Laporan Akhir');
        } else {
            return back()->with('error', 'Gagal mengirimkan pengajuan Laporan Akhir');
        }
    }
    public function revisi(Request $request)
    {
        $user = Auth::user();
        $report = Report::where('user_id', $user->id)->first();
        $request->validate([
            'judul' => 'required|string',
            'tujuan' => 'required|string',
            'dudi' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'required|mimes:pdf,docx'
        ]);

        $today = now()->toDateString();

        if ($report->file) {
            $safe = Str::slug($user->nama);
            $pathLama = "user/report/{$safe}/" . $report->file;

            if (Storage::disk('public')->exists($pathLama)) {
                (Storage::disk('public')->delete($pathLama));
            }
        }


        $foto = $request->file('file');
        $extension = $foto->getClientOriginalExtension();

        $safe = Str::slug($user->nama);
        $path = "user/report/{$safe}";

        $filename = time() . '_' . 'revisi' . '_' . $safe . '.' . $extension;
        $foto->storeAs($path, $filename, 'public');

        $report->update([
            'judul' => $request->judul,
            'tujuan' => $request->tujuan,
            'dudi' => $request->dudi,
            'file' => $filename,
            'deskripsi' => $request->deskripsi,
            'verifikasi' => 'revision',
            'tgl' => $today
        ]);

        return back()->with('success', 'berhasil revisi data');
    }
}
