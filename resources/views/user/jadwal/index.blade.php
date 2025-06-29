<!DOCTYPE html>
<html lang="en">

<x-head title="Jadwal PKL - Jurnal Magang SMK Islamic Centre Baiturrahman" />
<style>
    table td {
        font-size: 18px !important
    }
</style>

<body>
    <x-loading-screen />
    <x-navbar />
    <div class="container">
        <section>
            @php
                use Carbon\Carbon;
                $today = Carbon::now()->locale('id')->isoFormat('dddd');
                $today = strtolower($today);
                $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();

                $schedule = $weeklySchedule ?? null;
                $internship = auth()->user()->internship ?? null;

                $jamMasuk = null;
                $jamKeluar = null;

                $fromSchedule = false;

                if ($schedule && $schedule->{"{$today}_masuk"} && $schedule->{"{$today}_keluar"}) {
                    $jamMasuk = $schedule->{"{$today}_masuk"};
                    $jamKeluar = $schedule->{"{$today}_keluar"};
                    $fromSchedule = true;
                } elseif ($internship && $internship->jam_masuk && $internship->jam_keluar) {
                    $jamMasuk = $internship->jam_masuk;
                    $jamKeluar = $internship->jam_keluar;
                }

                $hasSchedule = $jamMasuk && $jamKeluar;

            @endphp
            <div class="row mt-5">
                <div class="w-auto mt-4">
                    <div class="d-flex gap-3 py-4 align-items-center">
                        <p class="h1 mb-0"><b> <i
                                    class="bi bi-calendar2-check-fill text-center text-primary justify-content-center h1 mb-0">
                                </i>Jadwal {{ $user->internship->dudika }}</b></p>
                    </div>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal menyimpan data -</strong>&nbsp; {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil menyimpan data -</strong>&nbsp;
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="mb-4">
                    <div class="row">
                        @if ($fromSchedule)
                            <div class="col-lg-12">
                                <div class="card p-4 text-start mb-3">
                                    @if ($schedule && $schedule->status_verifikasi === 'pending')
                                        <div class="alert alert-info text-start">
                                            Jadwal minggu ini sedang menunggu <strong>verifikasi</strong> dari Guru.
                                        </div>
                                    @elseif ($schedule && $schedule->status_verifikasi === 'rejected')
                                        <div class="alert alert-danger text-start">
                                            <span>Permintaan jadwal kamu ditolak. Segera ubah jadwal kamu!</span>
                                        </div>
                                    @else
                                        <div class="text-center mb-4">
                                            <span>Tidak ada perubahan jadwal hari ini.</span>
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-hover table-custom mb-0 w-100">
                                            <thead>
                                                <tr>
                                                    <th>Hari</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Verifikasi</th>
                                                </tr>
                                            </thead>
                                            <form action="{{ route('updateSchedule') }}" method="post">
                                                @if ($weeklySchedule)
                                                    @csrf
                                                    @method('PUT')
                                                    <tbody>
                                                        <tr>
                                                            <td>Senin</td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->senin_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="senin_masuk"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->senin_masuk)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->senin_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="senin_keluar"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->senin_keluar)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                @if ($weeklySchedule->status_verifikasi == 'approved')
                                                                    <span class="badge bg-success">Sudah</span>
                                                                @elseif ($weeklySchedule->status_verifikasi == 'pending')
                                                                    <span class="badge bg-secondary">Proses</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tolak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Selasa</td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->selasa_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="selasa_masuk"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->selasa_masuk)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->selasa_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="selasa_keluar"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->selasa_keluar)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                @if ($weeklySchedule->status_verifikasi == 'approved')
                                                                    <span class="badge bg-success">Sudah</span>
                                                                @elseif ($weeklySchedule->status_verifikasi == 'pending')
                                                                    <span class="badge bg-secondary">Proses</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tolak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rabu</td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->rabu_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="rabu_masuk"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->rabu_masuk)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->rabu_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="rabu_keluar"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->rabu_keluar)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                @if ($weeklySchedule->status_verifikasi == 'approved')
                                                                    <span class="badge bg-success">Sudah</span>
                                                                @elseif ($weeklySchedule->status_verifikasi == 'pending')
                                                                    <span class="badge bg-secondary">Proses</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tolak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kamis</td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->kamis_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="kamis_masuk"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->kamis_masuk)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->kamis_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="kamis_keluar"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->kamis_keluar)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                @if ($weeklySchedule->status_verifikasi == 'approved')
                                                                    <span class="badge bg-success">Sudah</span>
                                                                @elseif ($weeklySchedule->status_verifikasi == 'pending')
                                                                    <span class="badge bg-secondary">Proses</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tolak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumat</td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->jumat_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="jumat_masuk"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->jumat_masuk)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->jumat_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="jumat_keluar"
                                                                    class="form-control d-none edit-input"
                                                                    value="{{ \Carbon\Carbon::parse($weeklySchedule->jumat_keluar)->format('H:i') }}">
                                                            </td>
                                                            <td>
                                                                @if ($weeklySchedule->status_verifikasi == 'approved')
                                                                    <span class="badge bg-success">Sudah</span>
                                                                @elseif ($weeklySchedule->status_verifikasi == 'pending')
                                                                    <span class="badge bg-secondary">Proses</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tolak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @if ($weeklySchedule->sabtu_masuk || $weeklySchedule->sabtu_keluar)
                                                            <tr>
                                                                <td>Sabtu</td>
                                                                <td>
                                                                    <span
                                                                        class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->sabtu_masuk)->format('H:i') }}
                                                                        WIB</span>
                                                                    <input type="time" name="sabtu_masuk"
                                                                        class="form-control d-none edit-input"
                                                                        value="{{ \Carbon\Carbon::parse($weeklySchedule->sabtu_masuk)->format('H:i') }}">
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="display-value">{{ \Carbon\Carbon::parse($weeklySchedule->sabtu_keluar)->format('H:i') }}
                                                                        WIB</span>
                                                                    <input type="time" name="sabtu_keluar"
                                                                        class="form-control d-none edit-input"
                                                                        value="{{ \Carbon\Carbon::parse($weeklySchedule->sabtu_keluar)->format('H:i') }}">
                                                                </td>
                                                                <td>
                                                                    @if ($weeklySchedule->status_verifikasi == 'approved')
                                                                        <span class="badge bg-success">Sudah</span>
                                                                    @elseif ($weeklySchedule->status_verifikasi == 'pending')
                                                                        <span class="badge bg-secondary">Proses</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Tolak</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td>Sabtu</td>
                                                                <td>
                                                                    <span class="display-value">Tidak ada data</span>
                                                                    <input type="time" name="sabtu_masuk"
                                                                        class="form-control d-none edit-input"
                                                                        value="{{ \Carbon\Carbon::parse($weeklySchedule->sabtu_masuk)->format('H:i') }}">
                                                                </td>
                                                                <td>
                                                                    <span class="display-value">Tidak ada data</span>
                                                                    <input type="time" name="sabtu_keluar"
                                                                        class="form-control d-none edit-input"
                                                                        value="{{ \Carbon\Carbon::parse($weeklySchedule->sabtu_keluar)->format('H:i') }}">
                                                                </td>
                                                                <td>
                                                                    @if ($weeklySchedule->status_verifikasi == 'approved')
                                                                        <span class="badge bg-success">Sudah</span>
                                                                    @elseif ($weeklySchedule->status_verifikasi == 'pending')
                                                                        <span class="badge bg-secondary">Proses</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Tolak</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-start">
                                                                <div
                                                                    class="footer-table mt-3 d-flex align-items-center justify-content-end gap-2">
                                                                    <span class="text-muted small me-auto">
                                                                        Last update
                                                                        {{ \Carbon\Carbon::parse($weeklySchedule->updated_at)->diffForHumans() }}
                                                                    </span>
                                                                    <button type="submit"
                                                                        class="btn btn-success d-none" id="submitBtn">
                                                                        <i
                                                                            class="bi bi-check-circle"></i>&nbsp;&nbsp;Perbarui
                                                                    </button>
                                                                    <span class="btn btn-primary"
                                                                        id="editScheduleBtn">
                                                                        <i
                                                                            class="bi bi-calendar-week"></i>&nbsp;&nbsp;Ubah
                                                                        Jadwal
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                @endif
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            @elseif ($internship && $internship->jam_masuk && $internship->jam_keluar && $internship->verifikasi == 'pending')
                                <div class="col-lg-12">
                                    <div class="card p-4 text-start mb-3 h-100">
                                        <div class="alert alert-info text-start">
                                            Jadwal {{ $user->internship->dudika }} sedang dilakukan verifikasi
                                            oleh Guru Pembimbing
                                        </div>
                                        <form action="{{ route('updateStatic') }}" method="post">
                                            @method('PUT')
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-hover table-custom mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Jam Masuk</th>
                                                            <th>Jam Keluar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($user->internship->jam_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="jam_masuk"
                                                                    class="form-control d-none edit-input" required
                                                                    value="{{ $user->internship->jam_masuk }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($user->internship->jam_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="jam_keluar"
                                                                    class="form-control d-none edit-input" required
                                                                    value="{{ $user->internship->jam_keluar }}">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif ($internship && $internship->jam_masuk && $internship->jam_keluar && $internship->verifikasi == 'approved')
                                <div class="col-lg-12">
                                    <div class="card p-4 text-start mb-3 h-100">
                                        <div class="alert alert-primary text-start">
                                            Anda menggunakan jadwal menetap untuk {{ $user->internship->dudika }}
                                        </div>
                                        <form action="{{ route('updateStatic') }}" method="post">
                                            @method('PUT')
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-hover table-custom mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Jam Masuk</th>
                                                            <th>Jam Keluar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($user->internship->jam_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="jam_masuk"
                                                                    class="form-control d-none edit-input" required
                                                                    value="{{ $user->internship->jam_masuk }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($user->internship->jam_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="jam_keluar"
                                                                    class="form-control d-none edit-input" required
                                                                    value="{{ $user->internship->jam_keluar }}">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="submitBtm text-end gap-3 mt-3">
                                                <span class="btn btn-primary" id="editScheduleBtn">
                                                    <i class="bi bi-calendar-week"></i>&nbsp;&nbsp;Ubah
                                                    Jadwal
                                                </span>
                                                <button type="submit" class="btn btn-success d-none" id="submitBtn">
                                                    <i class="bi bi-check-circle"></i>&nbsp;&nbsp;Perbarui
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif ($internship && $internship->jam_masuk && $internship->jam_keluar && $internship->verifikasi == 'rejected')
                                <div class="col-lg-12">
                                    <div class="card p-4 text-start mb-3 h-100">
                                        <div class="alert alert-danger text-start">
                                            Jadwal {{ $user->internship->dudika }} Anda ditolak oleh Guru Pembimbing,
                                            silahkan lakukan penjadwalan ulang.
                                        </div>
                                        <form action="{{ route('updateStatic') }}" method="post">
                                            @method('PUT')
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-hover table-custom mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Jam Masuk</th>
                                                            <th>Jam Keluar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($user->internship->jam_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="jam_masuk"
                                                                    class="form-control d-none edit-input" required
                                                                    value="{{ $user->internship->jam_masuk }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($user->internship->jam_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                                <input type="time" name="jam_keluar"
                                                                    class="form-control d-none edit-input" required
                                                                    value="{{ $user->internship->jam_keluar }}">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="submitBtm text-end gap-3 mt-3">
                                                <span class="btn btn-primary" id="editScheduleBtn">
                                                    <i class="bi bi-calendar-week"></i>&nbsp;&nbsp;Ubah
                                                    Jadwal
                                                </span>
                                                <button type="submit" class="btn btn-success d-none" id="submitBtn">
                                                    <i class="bi bi-check-circle"></i>&nbsp;&nbsp;Perbarui
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-4">
                                    <div class="card p-4 text-start mb-3 h-100">
                                        <div class="alert alert-warning text-start">
                                            <strong>Perhatian!</strong> Silahkan gunakan form di bawah ini untuk
                                            memiliki
                                            <strong>Jadwal menetap</strong>
                                        </div>
                                        <form action="{{ route('createStatic') }}" method="post">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-hover table-custom mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Jam Masuk</th>
                                                            <th>Jam Keluar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="time" name="jam_masuk"
                                                                    class="form-control" required>
                                                            </td>
                                                            <td>
                                                                <input type="time" name="jam_keluar"
                                                                    class="form-control" required>
                                                            </td>
                                                        </tr>
                                                        <input type="text" hidden name="verifikasi"
                                                            value="pending">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="submitBtm text-end">
                                                <button type="submit" class="btn btn-primary mt-3">Simpan
                                                    Jadwal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="card px-4 py-4 text-start">

                                        <div class="alert alert-warning text-start">
                                            <strong>Perhatian!</strong> Silahkan gunakan form di bawah ini untuk
                                            <strong>Jadwal
                                                yang berubah-ubah.</strong>
                                        </div>
                                        <form action="{{ route('createJadwal') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="week_start_date"
                                                value="{{ $weekStart }}">

                                            @php
                                                $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                                            @endphp
                                            <div class="table-responsive">

                                                <table class="table table-hover table-custom mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Hari</th>
                                                            <th>Jam Masuk</th>
                                                            <th>Jam Keluar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hari as $list)
                                                            <tr>
                                                                <td>{{ ucfirst($list) }}</td>
                                                                <td>
                                                                    <input type="time"
                                                                        name="{{ $list }}_masuk"
                                                                        class="form-control"
                                                                        @if (in_array($list, ['senin', 'selasa', 'rabu', 'kamis', 'jumat']) ? 'required' : '')  @endif>
                                                                </td>
                                                                <td>
                                                                    <input type="time"
                                                                        name="{{ $list }}_keluar"
                                                                        class="form-control"
                                                                        @if (in_array($list, ['senin', 'selasa', 'rabu', 'kamis', 'jumat']) ? 'required' : '')  @endif>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="submitBtm text-end">
                                                <button type="submit" class="btn btn-primary mt-3">Simpan
                                                    Jadwal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        @endif
                    </div>


                </div>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            const loadingOverlay = document.getElementById('loadingOverlay');

            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'flex';
                    }
                });
            });
        });
        document.getElementById('editScheduleBtn').addEventListener('click', function() {
            document.querySelectorAll('.edit-input').forEach(el => el.classList.remove('d-none'));
            document.querySelectorAll('.display-value').forEach(el => el.classList.add('d-none'));
            document.getElementById('submitBtn').classList.remove('d-none');
        });
    </script>
</body>

</html>
