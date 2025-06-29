<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Internship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InternshipAdminController extends Controller
{
    public function index($id)
    {
        $admin = Auth::user();
        $users = User::whereHas('internship')->where('internship_id', $id)->get();
        $data = Internship::findOrFail($id);
        return view('admin.pkl.detail', compact('data', 'users'));
    }

    public function delete(Request $request, $id)
    {
        $data = Internship::where('id', $id);

        if ($request) {
            $data->delete();
        } else {
            return back()->with('error', 'data tidak ditemukan');
        }
        return back()->with('success', 'data berhasil dihapus');
    }

    public function update(Request $request, $id)
    {
        $data = Internship::where('id', $id);

        $data->update([
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
        ]);
        if ($data) {
            return back()->with('success', 'data berhasil dirubah');
        } else {
            return back()->with('error', 'data gagal dirubah');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'dudika' => 'required|string',
            'alamat' => 'required|string',
            'deskripsi' => 'string|nullable',
            'map' => 'required|string',
        ]);

        if ($request) {
            Internship::create([
                'dudika' => $request->dudika,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'map' => $request->map,
            ]);
            return back()->with('success', 'Anda berhasil menambahkan data PKL');
        } else {
            return back()->with('error', 'Permintaan tidak ditemukan');
        }
        return back()->withInput()->with('error', 'Data gagal ditambahkan');
    }
}
