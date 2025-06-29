<!DOCTYPE html>
<html lang="en">
<x-head title="Daftar Kehadiran - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-loading-screen />
    <x-navbar />
    <div class="container">
        <section>
            <div class="row mt-5">
                <div class="w-auto mt-4">
                    <div class="d-flex gap-3 py-4 align-items-center">
                        <p class="h1 mb-0"><b> <i
                                    class="bi bi-file-earmark-person-fill text-center text-primary justify-content-center h1 mb-0">
                                </i>Daftar Kehadiran</b></p>
                    </div>
                </div>
                <div class="container">
                    <x-error-alert />
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
                    <div class="row">
                        <form class="align-items-end mb-3 mt-2 search-form" role="search"
                            action="{{ route('indexAbsen') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-floating">
                                        <input type="date" name="tanggal" id="" class="form-control">
                                        <label for="">Urutkan Berdasarkan Tanggal</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-floating">
                                        <select name="bulan" id="" class="form-select">
                                            <option value="">-</option>
                                            @foreach (range(1, 12) as $bulan)
                                                <option value="{{ $bulan }}"
                                                    {{ request('tanggal') == $bulan ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::createFromFormat('!m', $bulan)->locale('id')->translatedFormat('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="">Urutkan Berdasarkan Bulan</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-floating">
                                        <select name="sort" id="" class="form-select">
                                            <option value="">-</option>
                                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>
                                                Terbaru
                                            </option>
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                                                Lama
                                            </option>
                                        </select>
                                        <label for="">Urutkan Pembuatan</label>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <button
                                        class="btn border-primary text-primary w-100 h-100 d-flex justify-content-center align-items-center"><i
                                            class="bi bi-search"></i></button>
                                </div>
                                <div class="col-lg-1">
                                    <a href="{{ route('printAbsen', $user->id) }}"
                                        class="btn btn-primary w-100 h-100 d-flex justify-content-center align-items-center"><i
                                            class="bi bi-printer-fill"></i></a>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-3 mb-4">
                            <div class="card px-4 py-4 text-center">
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
                                    $isVerified = $schedule && $schedule->status_verifikasi;

                                    $canAbsenMasuk =
                                        !$attendanceToday && $jamMasuk && now()->format('H:i:s') >= $jamMasuk;

                                    $canAbsenKeluar =
                                        $attendanceToday &&
                                        !$attendanceToday->keluar &&
                                        $jamKeluar &&
                                        now()->format('H:i:s') >= $jamKeluar;

                                    $sudahAbsen = $attendanceToday && $attendanceToday->keluar;
                                @endphp
                                @if ($fromSchedule)
                                    @if ($schedule && $schedule->status_verifikasi == 'pending')
                                        <div class="alert alert-info text-start">
                                            Jadwal minggu ini sedang menunggu <strong>verifikasi</strong> dari Guru.
                                        </div>
                                    @elseif ($schedule && $schedule->status_verifikasi == 'rejected')
                                        <div class="alert alert-danger text-start">
                                            Permintaan jadwal kamu <strong>ditolak</strong> silahkan melakukan
                                            penjadwalan ulang.
                                        </div>
                                    @else
                                        <form
                                            action="{{ $canAbsenKeluar ? route('absenKeluar') : route('absenMasuk') }}"
                                            method="POST">
                                            @csrf

                                            @if ($canAbsenMasuk)
                                                <x-upload-image nameInput="foto_masuk" />
                                                <button type="submit" class="btn btn-primary w-100 mt-2"
                                                    id="absenButton" disabled>Presensi
                                                    Masuk</button>
                                            @elseif ($canAbsenKeluar)
                                                <x-upload-image nameInput="foto_keluar" />
                                                <button type="submit" class="btn btn-danger w-100 mt-2"
                                                    id="absenButton" disabled>Presensi
                                                    Keluar</button>

                                                @if (!$journals)
                                                    <span class="btn border-success mt-2 w-100 text-success"
                                                        data-bs-target="#tambahLaporan" data-bs-toggle="modal">
                                                        Tambah Laporan Hari Ini
                                                    </span>
                                                @endif
                                            @elseif ($sudahAbsen)
                                                <p class="text-secondary mb-4">Anda sudah presensi hari ini.</p>
                                            @else
                                                <p class="text-secondary mb-4">Belum waktunya presensi.</p>
                                            @endif
                                        </form>
                                    @endif
                                @elseif ($internship && $internship->jam_masuk && $internship->jam_keluar && $internship->verifikasi == 'approved')
                                    <form action="{{ $canAbsenKeluar ? route('absenKeluar') : route('absenMasuk') }}"
                                        method="POST">
                                        @csrf
                                        @if ($canAbsenMasuk)
                                            <x-upload-image nameInput="foto_masuk" />
                                            <button type="submit" class="btn btn-primary w-100 mt-2" id="absenButton"
                                                disabled>Presensi
                                                Masuk</button>
                                        @elseif ($canAbsenKeluar)
                                            <x-upload-image nameInput="foto_keluar" />
                                            <button type="submit" class="btn btn-danger w-100 mt-2" id="absenButton"
                                                disabled>Presensi
                                                Keluar</button>

                                            @if (!$journals)
                                                <span class="btn border-success mt-2 w-100 text-success"
                                                    data-bs-target="#tambahLaporan" data-bs-toggle="modal">
                                                    Tambah Laporan Hari Ini
                                                </span>
                                            @endif
                                        @elseif ($sudahAbsen)
                                            <p class="text-secondary mb-4">Anda sudah presensi hari ini.</p>
                                        @else
                                            <p class="text-secondary mb-4"> Belum waktunya presensi.</p>
                                        @endif
                                    </form>
                                @elseif ($internship && $internship->jam_masuk && $internship->jam_keluar && $internship->verifikasi == 'pending')
                                    <div class="alert alert-info text-start">
                                        Jadwal minggu ini sedang menunggu <strong>verifikasi</strong> dari Guru.
                                    </div>
                                @elseif ($internship && $internship->jam_masuk && $internship->jam_keluar && $internship->verifikasi == 'rejected')
                                    <div class="alert alert-danger text-start">
                                        Permintaan jadwal kamu <strong>ditolak</strong> silahkan melakukan
                                        penjadwalan ulang.
                                    </div>
                                @else
                                    <div class="alert alert-warning text-start">
                                        <strong>Perhatian!</strong> Anda belum mengisi jadwal PKL. Silahkan
                                        lengkapi terlebih dahulu melalui halaman ini. <br><strong><a
                                                href="{{ route('indexSchedule') }}"
                                                style="text-decoration:none;">Tambah
                                                Jadwal</a></strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-9 mt-0">
                            <div class="card">
                                @forelse ($attendances as $absen)
                                    <div class="px-4 shadow-md w-auto mb-2" style="cursor: pointer;">
                                        <div class="attendances d-flex gap-3 py-4 align-items-center"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $absen->id }}">
                                            @if ($absen->ket == 'hadir')
                                                <i
                                                    class="bi bi-check-circle btn btn-primary text-center justify-content-center h1 mb-0">
                                                </i>
                                            @endif
                                            <p class="tgl mb-0"><b>{{ Str::ucfirst($absen->ket) }}</b>&nbsp;|
                                                {{ \Carbon\Carbon::parse($absen->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                            </p>
                                            <div class="attendance-time">
                                                <span class="time-in mb-0 btn border-success text-success">
                                                    Masuk
                                                    {{ \Carbon\Carbon::parse($absen->masuk)->format('H:i') }}</span>
                                                @if ($absen->keluar)
                                                    <span class="time-out mb-0 btn border-danger text-danger">
                                                        Keluar
                                                        {{ \Carbon\Carbon::parse($absen->keluar)->format('H:i') }}
                                                    </span>
                                                @else
                                                    <span class="time-out mb-0 btn border-danger text-danger">Belum
                                                        Pulang
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="ms-auto">
                                                <i id="arrow-{{ $absen->id }}" class="bi bi-chevron-down"
                                                    type="button"></i>
                                            </div>
                                        </div>
                                        <div class="collapse" id="collapse{{ $absen->id }}">
                                            <div class="p-3 border-top">
                                                <div class="row g-2">
                                                    <div class="col-lg-4">
                                                        <p class="mb-1"><b>Identitas</b></p>
                                                        <p class="card-text mb-0 small">{{ $user->nama }}</p>
                                                        <p class="card-text mb-0 small">{{ $user->nisn }}</p>
                                                        <p class="card-text mb-0 small">
                                                            {{ $user->internship->dudika }}</p>
                                                        @php
                                                            $laporan = $journalToday[$absen->tgl] ?? null;
                                                        @endphp
                                                        @if (!$laporan)
                                                            <span class="small text-muted mb-5">Belum ada
                                                                laporan</span>
                                                        @else
                                                            <a href="{{ route('detailJournal', $laporan->id) }}"
                                                                class="small ms-auto link-primary link-offset-2 link-underline-opacity-1 link-underline-opacity-100-hover mb-5">Lihat
                                                                Laporan</a>
                                                        @endif

                                                        <div class="mt-3">
                                                            <p class="badge bg-primary">
                                                                {{ \Carbon\Carbon::parse($absen->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                                            </p>
                                                            @if ($absen->komentar == 'Tepat Waktu')
                                                                <p class="mb-0 badge bg-success">
                                                                    {{ $absen->komentar }}</p>
                                                            @elseif ($absen->komentar == 'Terlambat')
                                                                <p class="mb-0 mt-3 badge bg-danger">
                                                                    {{ $absen->komentar }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><b>Foto Masuk</b></p>
                                                        <img src="{{ asset('storage/user/attendance/' . $safe . '/' . $absen->foto_masuk) }}"
                                                            class="img-fluid rounded border" width="100%"
                                                            alt="{{ $absen->foto_masuk }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><b>Foto Keluar</b></p>
                                                        @if ($absen->foto_keluar)
                                                            <img src="{{ asset('storage/user/attendance/' . $safe . '/' . $absen->foto_keluar) }}"
                                                                class="img-fluid rounded border" alt="Foto Keluar"
                                                                width="100%">
                                                        @else
                                                            <p class="text-muted">Belum Ada Foto Keluar</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="image{{ $absen->foto_masuk }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset('storage/attendance/' . $safe . '/' . $absen->foto_masuk) }}"
                                                        alt="">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted text-center justify-content-center mt-3">Tidak ada daftar
                                        kehadiran
                                    </p>
                                @endforelse
                            </div>
                            <div class="fab-container">
                                <div class="fab-options" id="fabOptions">
                                    <a href="{{ route('printAbsen', $user->id) }}" class="fab-option"
                                        style="text-decoration: none">🖨️</a>
                                    <button class="fab-option" data-bs-target="#search-form"
                                        data-bs-toggle="modal">🔍</button>
                                </div>
                                <button class="fab-main" onclick="toggleFab()"><i
                                        class="bi bi-calendar2-plus-fill"></i></button>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $attendances->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="search-form" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cari Daftar Kehadiran
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="align-items-end mb-3 " role="search" action="{{ route('indexAbsen') }}"
                                method="GET">
                                <div class="row">
                                    <div class="col-lg-3 mb-3">
                                        <div class="form-floating">
                                            <input type="date" name="tanggal" id=""
                                                class="form-control">
                                            <label for="">Urutkan Berdasarkan Tanggal</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select name="bulan" id="" class="form-select">
                                                <option value="">-</option>
                                                @foreach (range(1, 12) as $bulan)
                                                    <option value="{{ $bulan }}"
                                                        {{ request('tanggal') == $bulan ? 'selected' : '' }}>
                                                        {{ \Carbon\Carbon::createFromFormat('!m', $bulan)->locale('id')->translatedFormat('F') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="">Urutkan Berdasarkan Bulan</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mb-3">
                                        <div class="form-floating">
                                            <select name="sort" id="" class="form-select">
                                                <option value="">-</option>
                                                <option value="desc"
                                                    {{ request('sort') == 'desc' ? 'selected' : '' }}>
                                                    Terbaru
                                                </option>
                                                <option value="asc"
                                                    {{ request('sort') == 'asc' ? 'selected' : '' }}>
                                                    Lama
                                                </option>
                                            </select>
                                            <label for="">Urutkan Pembuatan</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button
                                            class="btn btn-primary w-100 h-100 d-flex justify-content-center align-items-center">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="tambahLaporan" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Laporan
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('addJournal') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="">Judul Laporan</label>
                                    <input type="text" class="form-control" name="judul">
                                </div>
                                <div class="mb-3">
                                    <label for="">Deskripsi</label>
                                    <textarea id="" cols="30" rows="10" class="form-control" name="isi"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="">Foto Dokumentasi</label>
                                    <input type="file" class="form-control" name="foto">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<script>
    function initializeClock() {
        let serverTime = "{{ $serverTime }}";
        if (!/^\d{2}:\d{2}:\d{2}$/.test(serverTime)) {
            console.error("Format waktu server tidak valid. Menggunakan waktu lokal.");
            serverTime = new Date().toLocaleTimeString('en-US', {
                hour12: false
            });
        }
        let [h, m, s] = serverTime.split(':').map(Number);

        let serverDate = new Date();
        serverDate.setHours(h, m, s);

        const serverTimestamp = serverDate.getTime();
        const clientTimestamp = Date.now();
        const timeOffset = serverTimestamp - clientTimestamp;

        function updateClock() {
            const now = new Date(Date.now() + timeOffset);

            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');

            document.getElementById('clock').textContent = `${h}:${m}:${s}`;
        }

        updateClock();

        setInterval(updateClock, 1000);
    }
    document.addEventListener('DOMContentLoaded', initializeClock);

    let stream = null;

    function openCamera() {
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(s => {
                stream = s;
                document.getElementById('video').style.display = 'block';
                document.getElementById('uploadText').innerText = 'Mengarahkan kamera...';

                const video = document.getElementById('video');
                video.srcObject = stream;

                setTimeout(takeSnapshot, 2500);
            })
            .catch(err => {
                alert("Tidak dapat mengakses kamera: " + err.message);
            });
    }

    function takeSnapshot() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const previewImage = document.getElementById('previewImage');
        const fotoInput = document.getElementById('fotoInput');
        const absenButton = document.getElementById('absenButton');

        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataURL = canvas.toDataURL('image/jpeg');

        previewImage.src = dataURL;
        previewImage.style.display = 'block';
        fotoInput.value = dataURL;

        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        video.style.display = 'none';
        document.getElementById('uploadText').innerText = 'Foto berhasil diambil';

        absenButton.disabled = false;
    }

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

    document.addEventListener('DOMContentLoaded', function() {
        const collapses = document.querySelectorAll('.collapse');

        collapses.forEach(collapse => {
            const arrowId = 'arrow-' + collapse.id.replace('collapse', '');
            const arrowIcon = document.getElementById(arrowId);

            collapse.addEventListener('show.bs.collapse', function() {
                if (arrowIcon) {
                    arrowIcon.classList.remove('bi-chevron-down');
                    arrowIcon.classList.add('bi-chevron-up');
                }
            });

            collapse.addEventListener('hide.bs.collapse', function() {
                if (arrowIcon) {
                    arrowIcon.classList.remove('bi-chevron-up');
                    arrowIcon.classList.add('bi-chevron-down');
                }
            });
        });
    });

    function toggleFab() {
        const fabOptions = document.getElementById('fabOptions');
        fabOptions.classList.toggle('show');
    }
</script>

</html>
