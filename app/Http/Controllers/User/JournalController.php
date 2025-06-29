<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Journal;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    protected function getWeekStartDate()
    {
        return Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
    }
    public function index(Request $request)
    {
        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();

        $user = Auth::user();
        $safe = Str::slug($user->nama);
        $query = Journal::where('user_id', $user->id);
        $internship = $user->internship ?? null;
        $schedule = Schedule::where('user_id', $user->id)->where('week_start_date', $monday)->first();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('verifikasi')) {
            $query->where('verifikasi', $request->verifikasi);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tgl', $request->bulan);
        }

        $sort = in_array($request->get('sort'), ['asc', 'desc']) ? $request->get('sort') : 'desc';
        $query->orderBy('tgl', $sort);

        $data = $query->paginate(9)->appends($request->only(['search', 'bulan', 'verifikasi', 'sort']));

        $dataJournal = Journal::where('user_id', $user->id)->first();
        return view('user.laporan.index', compact('user', 'data', 'dataJournal', 'safe', 'internship', 'schedule'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $timpa = Journal::where('user_id', $user->id)->where('tgl', $today)->first();

        if ($timpa) {
            return back()->with('error', 'Anda sudah mengisi jurnal kali ini');
        }

        $validated = $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            'foto' => 'required|file|mimes:png,jpg,jpeg'
        ]);

        $file = $request->file('foto');
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '_' . $user->nama . '_laporan.' . $extension;
        $file->storeAs('user/laporan', $fileName, 'public');

        $data = Journal::create([
            'user_id' => $user->id,
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'tgl' => $today,
            'verifikasi' => 'revisi',
            'foto' => $fileName
        ]);

        if ($data) {
            return back()->with('success', 'Berhasil menambahkan data Laporan hari ini.');
        } else {
            return back()->with('error', 'Gagal menyimpan data Laporan hari ini');
        }
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $safe = Str::slug($user->nama);
        $data = Journal::findOrFail($id);
        return view('user.laporan.detail', compact('data', 'user', 'safe'));
    }

    public function detail(string $id)
    {
        $user = Auth::user();
        $safe = Str::slug($user->nama);
        $data = Journal::findOrFail($id);
        return view('user.laporan.edit', compact('data', 'user', 'safe'));
    }

    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $safe = Str::slug($user->nama);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'nullable|image',
        ]);

        $data = Journal::findOrFail($id);
        $namaFileBaru = $data->foto;

        if ($request->hasFile('foto')) {
            $fotoBaru = $request->file('foto');
            $extension = $fotoBaru->getClientOriginalExtension();
            $fileName = now()->format('YmdHis') . '_' . $safe . '.' . $extension;
            $path = "user/journal/{$safe}";
            $stored = $fotoBaru->storeAs($path, $fileName, 'public');

            if ($stored) {
                if (Storage::disk('public')->exists("$path/{$data->foto}")) {
                    Storage::disk('public')->delete("$path/{$data->foto}");
                }

                $namaFileBaru = $fileName;
            } else {
                return back()->with('error', 'Gagal menyimpan foto baru.');
            }
        }

        $data->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'foto' => $namaFileBaru,
            'verifikasi' => 'revisi'
        ]);

        return redirect()->route('indexJournal')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function drop($id)
    {
        $user = Auth::user();
        $safe = Str::slug($user->nama);
        $data = Journal::findOrFail($id);

        if ($data->foto && Storage::disk('public')->exists("user/journal/{$safe}/{$data->foto}")) {
            Storage::disk('public')->delete("user/journal/{$safe}/{$data->foto}");
        }

        $data->delete();

        return redirect()->route('indexJournal')->with('success', 'Data laporan berhasil dihapus.');
    }

    public function print(User $user)
    {
        $safe = Str::slug($user->nama);
        $journal = $user->journal()->orderBy('tgl')->get();
        return view('user.laporan.print', compact('user', 'journal', 'safe'));
    }
}
