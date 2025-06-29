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
                                </i>Absen</b><span class="small"> - {{ $user->nama }}</span></p>
                        </p>
                    </div>
                </div>
                <form class="align-items-end mb-3 search-form-laporan" role="search"
                    action="{{ route('userAbsen', $user->id) }}" method="GET">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class=" form-floating">
                                <input type="date" name="tanggal" class="form-control">
                                <label for="">Urutkan berdasarkan tanggal</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class=" form-floating">
                                <select name="bulan" id="" class="form-select">
                                    <option value="">-</option>
                                    @foreach (range(1, 12) as $bulan)
                                        <option value="{{ $bulan }}"
                                            {{ request('tgl') == $bulan ? 'selected' : '' }}>
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
                    </div>
                </form>
                <div class="card">
                    @forelse ($attendances as $absen)
                        <div class="px-4 shadow-md w-auto mb-2" style="cursor: pointer;">
                            <div class="attendances d-flex gap-3 py-4 align-items-center" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $absen->id }}">
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
                                    <i id="arrow-{{ $absen->id }}" class="bi bi-chevron-down" type="button"></i>
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
                                                <a href="{{ route('detailLaporanUser', ['id' => $laporan->id, 'user' => $user->id]) }}"
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
                                                    class="img-fluid rounded border" alt="Foto Keluar" width="100%">
                                            @else
                                                <p class="text-muted">Belum Ada Foto Keluar</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="image{{ $absen->foto_masuk }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $attendances->links() }}
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
