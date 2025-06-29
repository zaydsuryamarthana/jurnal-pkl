<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Laporan Harian - Jurnal Magang SMK Islamic Centre Baiturrahman" />

</head>

<body>
    <x-loading-screen />
    <x-navbar />
    <section class="container py-5">
        <div class="w-auto mt-4">
            <div class="d-flex gap-3 py-4 align-items-center">
                <p class="h1 mb-0"><b> <i
                            class="bi bi-clipboard2-check-fill text-center text-primary justify-content-center h1 mb-0">
                        </i>Daftar Laporan</b></p>
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
        </div>
        <div class="row">
            <form class="align-items-end mt-2 search-form-laporan" role="search" action="{{ route('indexJournal') }}"
                method="GET">
                <div class="row">
                    <div class="col-lg-9 position-relative">
                        <div class="form-floating">
                            <input type="search" class="form-control pe-5" name="search"
                                placeholder="Cari data laporan" value="{{ request('search') }}" autocomplete="off" />
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
                    <div class="col-lg-1">
                        @if ($internship->verifikasi == null && $schedule == null)
                            <span class="btn w-100 h-100 d-flex justify-content-center align-items-center"
                                data-bs-toggle="popover" data-bs-title="Hak Akses Laporan"
                                data-bs-content="Akses laporan belum terbuka! Lakukan penjadwalan terlebih dahulu."
                                style="border:1px solid rgb(219, 219, 219); color: rgb(150, 150, 150);"><i
                                    class="bi
                                bi-file-earmark-plus"></i></span>
                        @elseif (
                            ($schedule
                                    ? $schedule->status_verifikasi == 'pending'
                                    : null || $internship)
                                ? $internship->verifikasi == 'pending'
                                : null)
                            <span class="btn w-100 h-100 d-flex justify-content-center align-items-center"
                                style="border:1px solid rgb(219, 219, 219); color: rgb(150, 150, 150);"
                                data-bs-toggle="popover" data-bs-title="Hak Akses Laporan"
                                data-bs-content="Akses laporan belum terbuka! Menunggu persetujuan jadwal terlebih dahulu."><i
                                    class="bi
                                bi-file-earmark-plus"></i></span>
                        @elseif (
                            ($schedule
                                    ? $schedule->status_verifikasi == 'approved'
                                    : null || $internship)
                                ? $internship->verifikasi == 'approved'
                                : null)
                            <span
                                class="btn border-primary text-primary w-100 h-100 d-flex justify-content-center align-items-center"
                                data-bs-target="#laporan" data-bs-toggle="collapse"><i
                                    class="bi bi-file-earmark-plus"></i></span>
                        @endif
                    </div>
                    <div class="col-lg-1">
                        <a href="{{ route('printJournal', $user->id) }}"
                            class="btn btn-primary w-100 h-100 d-flex justify-content-center align-items-center"><i
                                class="bi bi-printer-fill"></i></a>
                    </div>
                    <div id="filter" class="collapse mt-3 mb-0">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-4 form-floating">
                                    <select name="verifikasi" id="" class="form-select">
                                        <option value="">-</option>
                                        <option value="sudah" {{ request('verifikasi') == 'sudah' ? 'selected' : '' }}>
                                            Sudah
                                        </option>
                                        <option value="belum" {{ request('verifikasi') == 'belum' ? 'selected' : '' }}>
                                            Belum</option>
                                        <option value="tolak" {{ request('verifikasi') == 'tolak' ? 'selected' : '' }}>
                                            Tolak</option>
                                        <option value="revisi"
                                            {{ request('verifikasi') == 'revisi' ? 'selected' : '' }}>
                                            Revisi</option>
                                    </select>
                                    <label for="">Data Verifikasi</label>
                                </div>
                            </div>
                            <div class="col-lg-3">
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
                            <div class="col-lg-3">
                                <div class="mb-0 form-floating">
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
                        </div>
                    </div>
                    <div id="laporan" class="collapse mt-3">
                        <div class="row">
                            <div class="col-lg-5">
                                <span
                                    class="btn btn-primary w-100 h-100 d-flex justify-content-center align-items-center py-3"
                                    data-bs-target="#tambahLaporan" data-bs-toggle="modal"><i
                                        class="bi bi-plus-circle-fill"></i>&nbsp;&nbsp;Tambah Laporan Harian</span>
                            </div>
                            <div class="col-lg-4">
                                <div class="col-lg-5">
                                    <a href="{{ route('indexReport') }}"
                                        class="btn btn-success w-100 h-100 d-flex justify-content-center align-items-center py-3"><i
                                            class="bi bi-file-earmark-richtext-fill"></i>&nbsp;&nbsp;Laporan
                                        Akhir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            @forelse ($data as $journal)
                <div class="col-lg-4 mt-4">
                    <div class="card shadow-sm p-2 mb-4 h-100">
                        <div class="card-body">
                            <div class="sub-card d-flex align-item-center small mb-3">
                                @if ($journal->verifikasi == 'sudah')
                                    <span class="small badge bg-success">Teriverifikasi</span>
                                @elseif($journal->verifikasi == 'tolak')
                                    <span class="small badge bg-danger">Ditolak</span>
                                @elseif ($journal->verifikasi == 'belum')
                                    <span class="small badge bg-secondary">Belum Verifikasi</span>
                                @elseif ($journal->verifikasi == 'revisi')
                                    <span class="small badge bg-primary">Revisi</span>
                                @endif
                                <span class="ms-auto">
                                    {{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <div class="head-card mb-2">
                                <h5><b>{{ $journal->judul }}</b></h5>
                            </div>
                            <div class="text-card mb-4">
                                <p class="small text-muted text-justify text-truncate">
                                    {{ $journal->isi }}
                                </p>
                            </div>
                            <div class="footer-card d-flex align-item-center">
                                <span class="profile mb-0 small text-muted">
                                    {{ $user->nama }}
                                </span>
                                <a href="laporan/{{ $journal->id }}"
                                    class="small ms-auto link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center align-item-center justfiy-center p-3 mt-5">
                    <span class="text-muted"> - Tidak ada data laporan - </span>
                </div>
            @endforelse
            <div class="fab-container">
                <div class="fab-options" id="fabOptions">
                    <button class="fab-option" data-bs-target="#print" data-bs-toggle="modal">🖨️</button>
                    <button class="fab-option" data-bs-target="#tambahLaporan" data-bs-toggle="modal">📄</button>
                    <button class="fab-option" data-bs-target="#searchLaporan" data-bs-toggle="modal">🔍</button>
                </div>
                <button class="fab-main" onclick="toggleFab()">＋</button>
            </div>
            <div class="modal fade" id="searchLaporan" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cari Laporan
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="align-items-end mt-2" role="search" action="{{ route('indexJournal') }}"
                                method="GET">
                                <div class="row">
                                    <div class="col-lg-11 position-relative mb-4">
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

                                    <div class="col-lg-4">
                                        <div class="mb-4 form-floating">
                                            <select name="verifikasi" id="" class="form-select">
                                                <option value="">-</option>
                                                <option value="1"
                                                    {{ request('verifikasi') == '1' ? 'selected' : '' }}>
                                                    Sudah
                                                </option>
                                                <option value="0"
                                                    {{ request('verifikasi') == '0' ? 'selected' : '' }}>
                                                    Belum</option>
                                            </select>
                                            <label for="">Data Verifikasi</label>
                                        </div>
                                    </div>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Laporan -
                                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('indexJournal') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="mb-2 text-muted">Judul Laporan&nbsp;<span
                                            class="text-danger fw-bold">*</span></b></label>
                                    <input type="text" placeholder="Tuliskan judul laporan hari ini ..."
                                        class="form-control" name="judul">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 text-muted">Deskripsi&nbsp;<span
                                            class="text-danger fw-bold">*</span></label>
                                    <textarea id="" cols="30" rows="5" class="form-control"
                                        placeholder="Tuliskan deskripsi laporan har ini ..." name="isi"></textarea>
                                </div>
                                <div class="file-drop-area border-primary mb-3" id="drop-area">
                                    <p class="mb-1 text-secondary">Foto Dokumentasi <span
                                            class="text-danger fw-bold">*</span></p>
                                    <input type="file" id="fileInput" class="form-control d-none" name="foto"
                                        required>
                                    <button type="button" class="btn btn-outline-primary mt-2"
                                        onclick="document.getElementById('fileInput').click()">Pilih File</button>
                                </div>
                                <div id="filePreview" class="mb-3" style="display: none;">
                                    <div class="alert alert-primary d-flex justify-content-between align-items-center">
                                        <span id="fileName"></span>
                                        <button class="btn btn-sm btn-danger" onclick="removeFile()">Hapus</button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $data->links() }}
            </div>
        </div>
    </section>
</body>
<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileNameDisplay = document.getElementById('fileName');

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('bg-light');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('bg-light');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('bg-light');
        fileInput.files = e.dataTransfer.files;
        showFile();
    });

    fileInput.addEventListener('change', showFile);

    function showFile() {
        const file = fileInput.files[0];
        if (file) {
            fileNameDisplay.textContent = file.name;
            filePreview.style.display = 'block';
        }
    }

    function removeFile() {
        fileInput.value = '';
        filePreview.style.display = 'none';
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

    function toggleFab() {
        const fabOptions = document.getElementById('fabOptions');
        fabOptions.classList.toggle('show');
    }
</script>

</html>
