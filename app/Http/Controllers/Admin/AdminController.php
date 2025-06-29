<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Report;
use App\Models\Journal;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Internship;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index()
    {
        $admin = Auth::user();

        $users = User::where('role', 'user')
            ->where('admin_id', $admin->id)
            ->with(['reports', 'journal'])
            ->orderBy('nama', 'asc')
            ->get();

        $users = $users->map(function ($user) {
            $journals = $user->journal ?? collect();
            $semuaApproved = $journals->isNotEmpty() && $journals->every(fn($j) => $j->verifikasi === 'sudah');
            $user->boleh_aktifkan_laporan = !$user->reports && $semuaApproved;

            return $user;
        });

        return view('admin.index', compact('users'));
    }

    public function absen(Request $request)
    {
        $admin = Auth::user();

        $userList = User::whereHas('internship', function ($query) use ($admin) {
            $query->where('admin_id', $admin->id);
        })->get();

        $pklList = Internship::whereHas('users', function ($query) use ($admin) {
            $query->where('admin_id', $admin->id);
        })->get();


        $userIds = $userList->pluck('id');

        $query = Attendance::with(['user.internship'])
            ->whereIn('user_id', $userIds);

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('internship')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('internship_id', $request->internship);
            });
        }

        if ($request->filled('tgl')) {
            $query->whereDate('tgl', $request->tgl);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tgl', $request->bulan);
        }

        $sort = in_array($request->get('sort'), ['asc', 'desc']) ? $request->get('sort') : 'desc';
        $query->orderBy('tgl', $sort);

        $attendances = $query->paginate(10)->appends($request->all());

        return view('admin.absen.index', compact('attendances', 'userList', 'pklList'));
    }

    public function laporan(Request $request)
    {
        $admin = Auth::user();
        $userList = User::whereHas('internship', function ($query) use ($admin) {
            $query->where('admin_id', $admin->id);
        })->get();

        $pklList = Internship::whereHas('users', function ($query) use ($admin) {
            $query->where('admin_id', $admin->id);
        })->get();

        $userIds = $userList->pluck('id');

        $query = Journal::with(['user.internship'])
            ->whereIn('user_id', $userIds);

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('internship')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('internship_id', $request->internship);
            });
        }

        if ($request->filled('tgl')) {
            $query->whereDate('tgl', $request->tgl);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tgl', $request->bulan);
        }

        if ($request->filled('verifikasi')) {
            $query->where('verifikasi', $request->verifikasi);
        }

        $sort = in_array($request->get('sort'), ['asc', 'desc']) ? $request->get('sort') : 'desc';
        $query->orderBy('tgl', $sort);

        $journals = $query->paginate(10)->appends($request->all());

        return view('admin.laporan.index', compact('journals', 'userList', 'pklList'));
    }

    public function schedule()
    {
        $admin = Auth::user();
        $users = User::where('role', 'user')
            ->where('admin_id', $admin->id)
            ->pluck('id');

        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $schedules = Schedule::with(['user.internship'])->whereIn('user_id', $users)
            ->where('week_start_date', $monday)
            ->get();

        $requestSchedules = Schedule::with(['user.internship'])->whereIn('user_id', $users)
            ->where('week_start_date', $monday)->where('status_verifikasi', 'pending')->limit(2)->get();

        $requestInternship = User::with(['internship'])->whereIn('id', $users)->whereHas('internship', function ($query) {
            $query->where('verifikasi', 'pending');
        })->limit(1)->get();

        return view('admin.jadwal.index', compact('schedules', 'requestSchedules', 'requestInternship'));
    }

    public function pkl(Request $request)
    {
        $query = Internship::query()->orderBy('dudika', 'asc');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('dudika', 'like', '%' . $request->search . '%')
                    ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }
        $internships = $query->paginate(10)->appends($request->all());
        return view('admin.pkl.index', compact('internships'));
    }
}
