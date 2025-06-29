<!DOCTYPE html>
<html lang="en">

<x-head title="Admin - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-loading-screen />
    <x-navbar-admin />
    <div class="container">
        <section>
            <div class="row mt-5">
                <div class="w-auto mt-3">
                    <div class="d-flex gap-3 py-4 align-items-center">
                        <p class="h1 mb-0"><b> <i
                                    class="bi bi-file-earmark-person-fill text-center text-primary justify-content-center h1 mb-0">
                                </i>Daftar Permintaan Jadwal</b></p>
                    </div>
                </div>
                <div class="col-lg-12 mb-4">
                    @php
                        $filteredRequests = $requestSchedules;
                        $filteredInternship = $requestInternship;
                    @endphp
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal menyimpan data -</strong>&nbsp; {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil menyimpan data -</strong>&nbsp;
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($filteredInternship->count() > 0)
                        @foreach ($filteredInternship as $no => $permintaan)
                            <div class="card mb-2">
                                <div class="px-4 shadow-md w-auto mb-2" style="cursor: pointer;"
                                    data-bs-toggle="collapse" data-bs-target="#jadwal{{ $permintaan->id }}">
                                    <div class="attendances d-flex gap-3 py-4 align-items-center">
                                        <p class="tgl mb-0">
                                            <b>{{ Str::ucfirst($permintaan->internship->dudika) }}</b> &nbsp;|&nbsp;
                                            {{ \Carbon\Carbon::parse($permintaan->updated_at)->locale('id')->translatedFormat('l, d F Y') }}
                                        </p>
                                        <div class="attendance-time">
                                            <span class="time-in mb-0 btn border-success text-success">
                                                Perubahan Jadwal
                                            </span>
                                        </div>
                                        <div class="ms-auto">
                                            <form
                                                action="{{ route('verifikasiInternship', ['id' => $permintaan->internship->id]) }}"
                                                method="post" id="rejectInternship">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" value="rejected" name="verifikasi">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-target="#rejectInternshipModal" data-bs-toggle="modal"><i
                                                        class="bi bi-x-circle-fill"></i></button>
                                            </form>
                                        </div>
                                        <div class="">
                                            <form
                                                action="{{ route('verifikasiInternship', ['id' => $permintaan->internship->id]) }}"
                                                method="post" id="confirmInternship">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" value="approved" name="verifikasi">
                                                <button type="button" class="btn btn-primary"
                                                    data-bs-target="#confirmInternshipModal" data-bs-toggle="modal"><i
                                                        class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;Verifikasi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="confirmInternshipModal" tabindex="-1"
                                    aria-labelledby="confirmJadwalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Verifikasi Jadwal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin verifikasi permintaan jadwal Static
                                                {{ $permintaan->internship->dudika }}
                                                ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success"
                                                    form="confirmInternship">Ya,
                                                    Verifikasi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="rejectInternshipModal" tabindex="-1"
                                    aria-labelledby="confirmJadwalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Verifikasi Jadwal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menolak permintaan jadwal Static
                                                {{ $permintaan->internship->dudika }}
                                                ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger"
                                                    form="rejectInternship">Ya,
                                                    Tolak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse mb-4" id="jadwal{{ $permintaan->id }}">
                                    <div class="px-4 shadow-md w-auto mb-2" style="cursor: pointer;"
                                        data-bs-toggle="collapse" data-bs-target="#jadwal">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-custom mb-0 w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Jadwal</th>
                                                        <th>Jam Masuk</th>
                                                        <th>Jam Keluar</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Setiap Hari</td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->internship->jam_masuk)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->internship->jam_keluar)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if ($filteredRequests->count() > 0)
                        @foreach ($filteredRequests as $no => $permintaan)
                            <div class="card mb-2">
                                <div class="px-4 shadow-md w-auto mb-2" style="cursor: pointer;"
                                    data-bs-toggle="collapse" data-bs-target="#jadwal{{ $permintaan->id }}">
                                    <div class="attendances d-flex gap-3 py-4 align-items-center">
                                        <p class="tgl mb-0">
                                            <b>{{ Str::ucfirst($permintaan->user->nama) }}</b> &nbsp;|&nbsp;
                                            {{ \Carbon\Carbon::parse($permintaan->updated_at)->locale('id')->translatedFormat('l, d F Y') }}
                                        </p>
                                        <div class="attendance-time">
                                            <span class="time-in mb-0 btn border-success text-success">
                                                Perubahan Jadwal
                                            </span>
                                        </div>
                                        <div class="ms-auto">
                                            <form
                                                action="{{ route('verifikasiSchedule', ['id' => $permintaan->id]) }}"
                                                method="post" id="rejectJadwal">
                                                @csrf
                                                <input type="hidden" value="rejected" name="verif">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-target="#rejectJadwalModal" data-bs-toggle="modal"><i
                                                        class="bi bi-x-circle-fill"></i></button>
                                            </form>
                                        </div>
                                        <div class="">
                                            <form
                                                action="{{ route('verifikasiSchedule', ['id' => $permintaan->id]) }}"
                                                method="post" id="confirmJadwal">
                                                @csrf
                                                <input type="hidden" value="approved" name="verif">
                                                <button type="button" class="btn btn-primary"
                                                    data-bs-target="#confirmJadwalModal" data-bs-toggle="modal"><i
                                                        class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;Verifikasi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="confirmJadwalModal" tabindex="-1"
                                    aria-labelledby="confirmJadwalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Verifikasi Jadwal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin verifikasi permintaan jadwal
                                                {{ $permintaan->user->nama }}
                                                ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success"
                                                    form="confirmJadwal">Ya,
                                                    Verifikasi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="rejectJadwalModal" tabindex="-1"
                                    aria-labelledby="confirmJadwalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Verifikasi Jadwal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menolak permintaan jadwal
                                                {{ $permintaan->user->nama }}
                                                ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger" form="rejectJadwal">Ya,
                                                    Tolak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse mb-4" id="jadwal{{ $permintaan->id }}">
                                    <div class="px-4 shadow-md w-auto mb-2" style="cursor: pointer;"
                                        data-bs-toggle="collapse" data-bs-target="#jadwal">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-custom mb-0 w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Hari</th>
                                                        <th>Jam Masuk</th>
                                                        <th>Jam Keluar</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Senin</td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->senin_masuk)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->senin_keluar)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Selasa</td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->senin_masuk)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->selasa_keluar)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rabu</td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->rabu_masuk)->format('H:i') }}
                                                                WIB</span>

                                                        </td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->rabu_keluar)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kamis</td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->kamis_masuk)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->kamis_keluar)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumat</td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->jumat_masuk)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="display-value">{{ \Carbon\Carbon::parse($permintaan->jumat_keluar)->format('H:i') }}
                                                                WIB</span>
                                                        </td>
                                                    </tr>
                                                    @if ($permintaan->sabtu_masuk || $permintaan->sabtu_keluar)
                                                        <tr>
                                                            <td>Sabtu</td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($permintaan->sabtu_masuk)->format('H:i') }}
                                                                    WIB</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="display-value">{{ \Carbon\Carbon::parse($permintaan->sabtu_keluar)->format('H:i') }}
                                                                    WIB</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card text-center mb-2">
                            <div class="attendances py-4 align-items-center">
                                <p class="small text mb-0">Tidak ada permintaan jadwal hari ini</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0 w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Tanggal Permintaan</th>
                                <th>Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $no => $jadwal)
                                <tr>
                                    <td>{{ $no + 1 ?? '-' }}</td>
                                    <td>{{ $jadwal->user->nama ?? '-' }}</td>
                                    <td>{{ $jadwal->user->internship->dudika ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->updated_at)->locale('id')->translatedFormat('l, d F Y') }}
                                    </td>
                                    @if ($jadwal->status_verifikasi == 'approved')
                                        <td><span class="badge bg-success">Sudah</span></td>
                                    @elseif ($jadwal->status_verifikasi == 'pending')
                                        <td><span class="badge bg-secondary">Proses</span></td>
                                    @elseif ($jadwal->status_verifikasi == 'rejected')
                                        <td><span class="badge bg-danger">Tolak</span></td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Tidak ada data absensi.
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    </script>
</body>

</html>
