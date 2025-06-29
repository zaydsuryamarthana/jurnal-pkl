<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Verification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfilController extends Controller
{
    use HasFactory;
    public function index()
    {
        $user = Auth::user();
        $safe = Str::slug($user->nama);
        $admin = User::where('id', $user->admin_id)->first();
        $verification =  Verification::where('user_id', $user->id)->first();
        $report = Report::where('user_id', $user->id)->first();
        return view('user.profil.index', compact('user', 'verification', 'safe', 'admin', 'report'));
    }

    public function edit()
    {
        $user = Auth::user();
        $safe = Str::slug($user->nama);
        $admin = User::where('id', $user->admin_id)->first();
        $verification =  Verification::where('user_id', $user->id)->first();
        $report = Report::where('user_id', $user->id)->first();
        return view('user.profil.edit', compact('user', 'verification', 'safe', 'admin', 'report'));
    }
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        $validated = $request->validate(
            [
                'jurusan' => 'nullable|string',
                'kelas' => 'nullable|string',
                'jk' => 'nullable|string',
                'telp' => 'nullable|string',
                'foto' => 'nullable|mimes:jpg,png,jpeg'
            ],
            [
                'foto.mimes' => 'Format foto yang diupload bukan jpg/png/jpeg.',
                'foto.max' => 'File terlalu besar, silahkan upload kembali.'
            ]
        );

        if ($request->hasFile('foto')) {
            $user = Auth::user();
            $safe = Str::slug($user->nama);
            $extension = $validated['foto']->getClientOriginalExtension();
            $fileName = time() . '_' . $safe . '.' . $extension;
            $path = "user/profil/{$safe}/";
            $validated['foto']->storeAs($path, $fileName, 'public');
            $validated['foto'] = $fileName;
        } else {
            unset($validated['foto']);
        }

        $user->update($validated);

        if (!$user) {
            return back()->with('error', 'Gagal Update');
        } else {
            return back()->with('success', 'berhasil update');
        }
    }
}
