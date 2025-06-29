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
                                </i>Daftar Laporan</b></p>
                    </div>
                </div>
                <form class="align-items-end mb-3 search-form-laporan" role="search" action="{{ route('allLaporan') }}"
                    method="GET">
                    <div class="row">
                        <div class="col-lg-11 position-relative">
                            <div class="form-floating">
                                <input type="search" class="form-control pe-5" name="search"
                                    placeholder="Cari data laporan" value="{{ request('search') }}"
                                    autocomplete="off" />
                                <label for="searchInput">Cari Laporan</label>
                            </div>
                            <button class="position-absolute top-50 end-0 translate-middle-y text-muted"
                                style="margin-right: 40px">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="col-lg-1 collapseFilter">
                            <span class="btn w-100 h-100 d-flex justify-content-center align-items-center"
                                style="border:1px solid rgb(219, 219, 219); color: rgb(150, 150, 150);"
                                data-bs-toggle="collapse" data-bs-target="#filter">Filter</span>
                        </div>
                        <div id="filter" class="collapse mt-3">
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
                                <div class="col-lg-2">
                                    <div class="mb-3 form-floating">
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
                                    <div class="mb-3 form-floating">
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
                                <div class="col-lg-2">
                                    <div class="mb-4 form-floating">
                                        <select name="verifikasi" id="" class="form-select">
                                            <option value="">-</option>
                                            <option value="sudah"
                                                {{ request('verifikasi') == 'sudah' ? 'selected' : '' }}>
                                                Sudah
                                            </option>
                                            <option value="belum"
                                                {{ request('verifikasi') == 'belum' ? 'selected' : '' }}>
                                                Belum</option>
                                            <option value="tolak"
                                                {{ request('verifikasi') == 'tolak' ? 'selected' : '' }}>
                                                Tolak</option>
                                        </select>
                                        <label for="">Data Verifikasi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0 w-100">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Nama</th>
                                <th>PKL</th>
                                <th>Tanggal</th>
                                <th>Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($journals as $journal)
                                <tr>
                                    <td style=""><span class="d-inline-block text-truncate"
                                            style="max-width: 250px">{{ $journal->judul ?? '-' }}</span>
                                    </td>
                                    <td>{{ $journal->user->nama ?? '-' }}</td>
                                    <td>{{ $journal->user->internship->dudika ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                    </td>
                                    @if ($journal->verifikasi == 'sudah')
                                        <td>
                                            <span class="badge bg-success">Sudah</span>
                                        </td>
                                    @elseif ($journal->verifikasi == 'belum')
                                        <td>
                                            <span class="badge bg-secondary">Belum</span>
                                        </td>
                                    @elseif ($journal->verifikasi == 'tolak')
                                        <td>
                                            <span class="badge bg-danger">Tolak</span>
                                        </td>
                                    @elseif ($journal->verifikasi == 'revisi')
                                        <td>
                                            <span class="badge bg-primary">Revisi</span>
                                        </td>
                                    @endif

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Tidak ada data laporan.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $journals->links() }}
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
