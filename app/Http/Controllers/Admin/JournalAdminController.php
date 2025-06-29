<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Journal;
use App\Models\Attendance;
use App\Models\Internship;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JournalAdminController extends Controller
{
    public function index(string $id, Request $request)
    {
        $admin = Auth::user();

        $user = User::where('id', $id)
            ->where('admin_id', $admin->id)
            ->firstOrFail();

        $safe = Str::slug($user->nama);

        $query = Journal::with(['user.internship'])
            ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->has('verifikasi') && in_array($request->verifikasi, ['sudah', 'belum', 'tolak', 'revisi'])) {
            $query->where('verifikasi', $request->verifikasi);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tgl', $request->bulan);
        }

        $sort = in_array($request->get('sort'), ['asc', 'desc']) ? $request->get('sort') : 'desc';
        $query->orderBy('tgl', $sort);

        $verifikasiMode = $request->query('verifikasiMode') == 'sudah';

        $journals = $verifikasiMode
            ? $query->whereIn('verifikasi', ['belum', 'revisi'])->get()
            : $query->paginate(10)->appends($request->all());

        return view('admin.laporan.user', compact('user', 'journals', 'safe', 'verifikasiMode'));
    }

    public function update(Request $request, $user, $id)
    {
        $request->validate([
            'verif' => 'required',
        ]);

        $journal = Journal::findOrFail($id);

        if ($journal->user_id != $user) {
            abort(403);
        }

        $journal->verifikasi = $request->verif;
        $journal->komentar =  $request->komentar;
        $journal->save();

        return back()->with('success', 'Berhasil update verifikasi');
    }

    public function detail($user, $id)
    {
        $admin = Auth::user();
        $user = User::where('id', $user)
            ->where('admin_id', $admin->id)
            ->firstOrFail();

        $safe = Str::slug($user->nama);
        $journal = Journal::findOrFail($id);

        return view('admin.laporan.detail', compact('journal', 'safe', 'user'));
    }

    public function bulkUpdate(Request $request, User $user)
    {
        $ids = $request->input('verifikasi', []);

        // Update hanya yang dicentang ke 'sudah'
        Journal::whereIn('id', $ids)->update(['verifikasi' => 'sudah']);

        return back()->with('success', 'Verifikasi jurnal diperbarui.');
    }
}
