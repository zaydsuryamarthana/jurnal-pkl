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
                                </i>Daftar Kehadiran</b></p>
                    </div>
                </div>
                <form class="align-items-end mb-3 search-form" role="search" action="{{ route('allAbsen') }}"
                    method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-floating">
                                <select name="user" id="" class="form-control">
                                    <option value="">-</option>
                                    @foreach ($userList as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                    @endforeach
                                </select>
                                <label for="">Cari berdasarkan nama</label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-floating">
                                <select name="internship" id="" class="form-control">
                                    <option value="">-</option>
                                    @foreach ($pklList as $pkl)
                                        <option value="{{ $pkl->id }}">{{ $pkl->dudika }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="">Cari berdasarkan Tempat PKL</label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-floating">
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
                        <div class="col-lg-2">
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
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0 w-100">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>PKL</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->user->nama ?? '-' }}</td>
                                    <td>{{ $attendance->user->internship->dudika ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->masuk)->format('H:i') }}</td>
                                    @if (!$attendance->keluar)
                                        <td>-</td>
                                    @else
                                        <td>{{ \Carbon\Carbon::parse($attendance->keluar)->format('H:i') ?? '-' }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Tidak ada data absensi.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
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
