<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Internship;
use Illuminate\Support\Str;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $admins = User::where('role', 'admin')->get();
        $internships = Internship::orderBy('dudika', 'asc')->get();
        $serverTime = now()->format('H:i;:s');
        return view('user.index', compact('internships', 'serverTime', 'user', 'admins'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nisn' => 'required|numeric|unique:users,nisn,' . Auth::id(),
            'internship_id' => 'required|exists:internships,id',
            'file' => 'required|file|mimes:pdf,docx,jpg,png',
        ]);


        $foto = $request->file('file');
        $extension = $foto->getClientOriginalExtension();

        $safe = Str::slug($user->nama);
        $path = "user/verification/{$safe}";

        $fileName = time() . '_' . $safe . '.' . $extension;
        $foto->storeAs($path, $fileName, 'public');

        $verifikasi = Verification::create([
            'user_id'      => Auth::id(),
            'file'         => $fileName,
            'submitted_at' => now(),
        ]);



        $user = User::find(Auth::id());

        $user->update([
            'nisn'          => $request->nisn,
            'internship_id' => $request->internship_id,
            'admin_id' => $request->admin_id,
            'verified_id'   => $verifikasi->id,
        ]);

        return redirect('/beranda')->with('success', 'Berhasil');
    }
}
