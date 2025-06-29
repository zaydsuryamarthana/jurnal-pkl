<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Journal;
use App\Models\Attendance;
use App\Models\Internship;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    protected function getWeekStartDate()
    {
        return Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
    }
    public function index(Request $request)
    {
        $user = Auth::user();

        // Cari jadwal minggu berjalan berdasarkan minggu Senin
        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();

        $weeklySchedule = Schedule::where('user_id', $user->id)
            ->where('week_start_date', $monday)
            ->first();

        $today = Carbon::now()->locale('id');
        $todayName = strtolower($today->isoFormat('dddd')); // senin, selasa, ...

        // Ambil jam masuk & keluar hari ini dari weeklySchedule, fallback null kalau gak ada
        $jamMasuk = $weeklySchedule ? $weeklySchedule->{"{$todayName}_masuk"} : null;
        $jamKeluar = $weeklySchedule ? $weeklySchedule->{"{$todayName}_keluar"} : null;

        $absenToday = Attendance::where('user_id', $user->id)
            ->where('tgl', $today->toDateString())
            ->first();

        $attendanceToday = Attendance::where('user_id', $user->id)
            ->whereDate('tgl', now()->toDateString())
            ->first();

        $canAbsenMasuk = !$absenToday && $jamMasuk && now()->format('H:i:s') >= $jamMasuk;
        $canAbsenKeluar = $absenToday && !$absenToday->keluar && $jamKeluar && now()->format('H:i:s') >= $jamKeluar;
        $sudahAbsen = $absenToday && $absenToday->keluar;

        $journalToday = Journal::where('user_id', $user->id)->get()->keyBy('tgl');
        $journals = Journal::where('user_id', $user->id)->where('tgl', $today->toDateString())->first();

        $query = Attendance::where('user_id', $user->id);
        if ($request->filled('tanggal')) $query->where('tgl', $request->tanggal);
        if ($request->filled('bulan')) $query->whereMonth('tgl', $request->bulan);
        $sort = in_array($request->get('sort'), ['asc', 'desc']) ? $request->get('sort') : 'desc';
        $query->orderBy('tgl', $sort);

        $attendances = $query->paginate(6)->appends($request->only(['tanggal', 'bulan', 'sort']));

        $jamMasukString = Carbon::parse($jamMasuk);
        $batasMasuk = $jamMasukString->copy()->addMinutes(30);

        $komentar = now()->gt($batasMasuk) ? 'Terlambat' : 'Tepat Waktu';

        return view('user.absen.index', [
            'user' => $user,
            'serverTime' => now()->format('H:i:s'),
            'attendances' => $attendances,
            'journals' => $journals,
            'absenToday' => $absenToday,
            'weeklySchedule' => $weeklySchedule,
            'canAbsenMasuk' => $canAbsenMasuk,
            'canAbsenKeluar' => $canAbsenKeluar,
            'sudahAbsen' => $sudahAbsen,
            'noSchedule' => !$jamMasuk || !$jamKeluar,
            'safe' => Str::slug($user->nama),
            'journalToday' => $journalToday,
            'attendanceToday' => $attendanceToday,
            'batasWaktu' => $komentar
        ]);
    }

    public function masuk(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();
        $hari = Str::lower(now()->locale('id')->dayName); // "senin", "selasa", dst.

        // Cek jika sudah absen hari ini
        if (Attendance::where('user_id', $user->id)->where('tgl', $today)->exists()) {
            return back()->with('error', 'Kamu sudah absen hari ini.');
        }

        // Jadwal Dinamis
        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $schedule = Schedule::where('user_id', $user->id)
            ->where('week_start_date', $weekStart)
            ->where('status_verifikasi', 'approved')
            ->first();

        if ($schedule && $schedule->{$hari . '_masuk'}) {
            $jamMasuk = $schedule->{$hari . '_masuk'};
        } elseif ($user->internship && $user->internship->jam_masuk) {
            // Jadwal Statis dari internship
            $jamMasuk = $user->internship->jam_masuk;
        } else {
            // Tidak ada jadwal sama sekali
            return back()->with('error', 'Tidak ada jadwal tersedia. Silakan isi jadwal mingguan terlebih dahulu.');
        }

        $request->validate(['foto_masuk' => 'required|string']);

        $safe = Str::slug($user->nama);
        $fileName = time() . '_' . $safe . '_masuk.jpg';
        $path = "user/attendance/{$safe}/{$fileName}";

        try {
            $base64 = $request->foto_masuk;
            $base64 = str_replace('data:image/jpeg;base64,', '', $base64);
            $base64 = str_replace(' ', '+', $base64);
            $foto = base64_decode($base64);

            if ($foto === false) {
                throw new \Exception('Base64 tidak valid.');
            }

            Storage::disk('public')->put($path, $foto);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses foto.');
        }

        $jamMasukString = Carbon::parse($jamMasuk);
        $batasMasuk = $jamMasukString->copy()->addMinutes(30);

        $komentar = now()->gt($batasMasuk) ? 'Terlambat' : 'Tepat Waktu';

        Attendance::create([
            'user_id' => $user->id,
            'tgl' => $today,
            'ket' => 'hadir',
            'masuk' => now(),
            'komentar' => $komentar,
            'foto_masuk' => $fileName
        ]);

        return back()->with('success', 'Absen masuk berhasil.');
    }

    public function keluar(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();
        $hari = Str::lower(now()->locale('id')->dayName);

        $absen = Attendance::where('user_id', $user->id)
            ->where('tgl', $today)
            ->whereNotNull('masuk')
            ->whereNull('keluar')
            ->first();

        if (!$absen) {
            return back()->with('error', 'Kamu belum absen masuk atau sudah absen keluar.');
        }

        // Jadwal Dinamis
        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $schedule = Schedule::where('user_id', $user->id)
            ->where('week_start_date', $weekStart)
            ->where('status_verifikasi', 'approved')
            ->first();

        if ($schedule && $schedule->{$hari . '_keluar'}) {
            $jamKeluar = $schedule->{$hari . '_keluar'};
        } elseif ($user->internship && $user->internship->jam_keluar) {
            $jamKeluar = $user->internship->jam_keluar;
        } else {
            return back()->with('error', 'Tidak ada jadwal keluar hari ini. Silakan isi jadwal terlebih dahulu.');
        }

        if (now()->format('H:i:s') < $jamKeluar) {
            return back()->with('error', 'Belum waktunya absen keluar.');
        }

        $request->validate(['foto_keluar' => 'required|string']);

        $safe = Str::slug($user->nama);
        $fileName = time() . '_' . $safe . '_keluar.jpg';
        $path = "user/attendance/{$safe}/{$fileName}";

        try {
            $base64 = $request->foto_keluar;
            $base64 = str_replace('data:image/jpeg;base64,', '', $base64);
            $base64 = str_replace(' ', '+', $base64);
            $foto = base64_decode($base64);

            if ($foto === false) {
                throw new \Exception('Base64 tidak valid.');
            }

            Storage::disk('public')->put($path, $foto);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses foto.');
        }

        $absen->update([
            'keluar' => now(),
            'foto_keluar' => $fileName,
        ]);

        return back()->with('success', 'Absen keluar berhasil.');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        if (Journal::where('user_id', $user->id)->where('tgl', $today)->exists()) {
            return back()->with('error', 'Anda sudah mengisi jurnal hari ini.');
        }

        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'foto' => 'required|file|mimes:jpg,jpeg,png'
        ]);

        $foto = $request->file('foto');
        $safe = Str::slug($user->nama);
        $fileName = $today . '_' . $safe . '.' . $foto->getClientOriginalExtension();
        $path = "user/journal/{$safe}";

        $foto->storeAs($path, $fileName, 'public');

        Journal::create([
            'user_id' => $user->id,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tgl' => $today,
            'verifikasi' => 'belum',
            'foto' => $fileName
        ]);

        return back()->with('success', 'Berhasil menambahkan jurnal hari ini.');
    }

    public function print(User $user)
    {
        $safe = Str::slug($user->nama);
        $attendances = $user->attendances()->orderBy('tgl')->get();
        return view('user.absen.print', compact('user', 'attendances', 'safe'));
    }
}
