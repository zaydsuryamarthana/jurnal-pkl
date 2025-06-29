<!DOCTYPE html>
<html lang="en">

<x-head title="Admin - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-loading-screen />
    <x-navbar-admin />
    <div class="container">
        <section>
            <div style="margin-top:63px">
                <div class="w-auto">
                    <div class="d-flex mt-5 gap-3 py-4 align-items-center">
                        <p class="h1 mb-0"><b> <i
                                    class="bi bi-file-earmark-person-fill text-center text-primary justify-content-center h1 mb-0">
                                </i>Laporan</b><span class="small"> - {{ $user->nama }}</span></p>
                        </p>
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
                <form class="align-items-end mb-3 search-form-laporan" role="search"
                    action="{{ route('userLaporan', $user->id) }}" method="GET">
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
                                <div class="col-lg-4">
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
                                <div class="col-lg-4">
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
                                <div class="col-lg-3">
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
                                            <option value="revisi"
                                                {{ request('verifikasi') == 'revisi' ? 'selected' : '' }}>
                                                Revisi</option>
                                        </select>
                                        <label for="">Data Verifikasi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    @if ($verifikasiMode)
                        <a href="{{ route('userLaporan', ['id' => $user->id]) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-short"></i>&nbsp;&nbsp;Kembali
                        </a>
                    @else
                        <a href="{{ route('userLaporan', ['id' => $user->id] + request()->except('page') + ['verifikasiMode' => 'sudah']) }}"
                            class="btn btn-primary">
                            <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;Verifikasi Semua Laporan
                        </a>
                    @endif
                </div>

                @if ($journals->count())
                    @if ($verifikasiMode)
                        <form action="{{ route('bulkUpdateVerification', ['user' => $user->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                @foreach ($journals as $journal)
                                    <div class="col-lg-4 mt-4">
                                        <div class="card shadow-sm p-2 mb-4 h-100">
                                            <div class="card-body">
                                                <div class="sub-card d-flex align-items-center small mb-3">
                                                    <input type="checkbox" name="verifikasi[]"
                                                        value="{{ $journal->id }}"
                                                        {{ $journal->verifikasi == 'sudah' ? 'checked' : '' }}
                                                        class="me-2">
                                                    @if ($journal->verifikasi == 'belum')
                                                        <span class="small badge bg-secondary">Belum Verifikasi</span>
                                                    @elseif ($journal->verifikasi == 'sudah')
                                                        <span class="small badge bg-success">Terverifikasi</span>
                                                    @elseif ($journal->verifikasi == 'revisi')
                                                        <span class="small badge bg-primary">Revisi</span>
                                                    @elseif ($journal->verifikasi == 'tolak')
                                                        <span class="small badge bg-danger">Tolak</span>
                                                    @endif
                                                    <span class="ms-auto">
                                                        {{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                                    </span>
                                                </div>
                                                <div class="head-card mb-2">
                                                    <h5><b>{{ $journal->judul }}</b></h5>
                                                </div>
                                                <div class="text-card mb-4">
                                                    <p class="small text-muted text-justify text-truncate">
                                                        {{ $journal->isi }}
                                                    </p>
                                                </div>
                                                <div class="footer-card d-flex align-items-center">
                                                    <span
                                                        class="profile mb-0 small text-muted">{{ $user->nama }}</span>
                                                    <a href="{{ route('detailLaporanUser', ['user' => $user->id, 'id' => $journal->id]) }}"
                                                        class="small ms-auto link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover">
                                                        Lihat Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-end my-3">
                                <button type="submit" class="btn btn-success"><i
                                        class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;Update Verifikasi</button>
                            </div>
                        </form>
                    @else
                        <div class="row">
                            @foreach ($journals as $journal)
                                <div class="col-lg-4 mt-4">
                                    <div class="card shadow-sm p-2 mb-4 h-100">
                                        <div class="card-body">
                                            <div class="sub-card d-flex align-items-center small mb-3">
                                                @if ($journal->verifikasi == 'sudah')
                                                    <span class="small badge bg-success">Terverifikasi</span>
                                                @elseif ($journal->verifikasi == 'belum')
                                                    <span class="small badge bg-secondary">Belum Verifikasi</span>
                                                @elseif ($journal->verifikasi == 'tolak')
                                                    <span class="small badge bg-danger">Ditolak</span>
                                                @elseif ($journal->verifikasi == 'revisi')
                                                    <span class="small badge bg-primary">Revisi</span>
                                                @endif
                                                <span class="ms-auto">
                                                    {{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                                </span>
                                            </div>
                                            <div class="head-card mb-2">
                                                <h5><b>{{ $journal->judul }}</b></h5>
                                            </div>
                                            <div class="text-card mb-4">
                                                <p class="small text-muted text-justify text-truncate">
                                                    {{ $journal->isi }}
                                                </p>
                                            </div>
                                            <div class="footer-card d-flex align-items-center">
                                                <span class="profile mb-0 small text-muted">{{ $user->nama }}</span>
                                                <a href="{{ route('detailLaporanUser', ['user' => $user->id, 'id' => $journal->id]) }}"
                                                    class="small ms-auto link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Paginasi tampil hanya pada mode biasa --}}
                        <div class="d-flex justify-content-center mt-4">
                            {{ $journals->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center align-items-center justify-content-center p-3 mt-5">
                        <span class="text-muted"> - Tidak ada laporan - </span>
                    </div>
                @endif
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
