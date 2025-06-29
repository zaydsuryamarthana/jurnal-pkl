<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Journal;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceAdminController extends Controller
{
    public function index(string $id, Request $request)
    {
        $admin = Auth::user();
        $user = User::where('id', $id)
            ->where('admin_id', $admin->id)
            ->firstOrFail();

        $safe = Str::slug($user->nama);
        $journalToday = Journal::where('user_id', $user->id)->get()->keyBy('tgl');

        $query = Attendance::with(['user.internship'])
            ->where('user_id', $user->id);

        if ($request->filled('tanggal')) {
            $query->whereDate('tgl', $request->tgl);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tgl', $request->bulan);
        }

        $sort = in_array($request->get('sort'), ['asc', 'desc']) ? $request->get('sort') : 'desc';
        $query->orderBy('tgl', $sort);

        $attendances = $query->paginate(6)->appends($request->all());
        return view('admin.absen.user', compact('user', 'attendances', 'safe', 'journalToday'));
    }
}
