<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Laporan Akhir - Jurnal Magang SMK Islamic Centre Baiturrahman" />s
</head>

<body>
    <x-loading-screen />
    <x-navbar />
    <section class="container py-5">
        <div class="row">
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
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (!$data)
                <div class=" h-100">
                    <div class="py-5 bg-information">
                        <div class="alert alert-danger text-start">
                            <span>Kamu belum bisa membuat <strong>laporan akhir.</strong> Silahkan meminta persetujuan
                                kepada guru pembimbing
                                untuk membuka akses laporan akhir PKL kamu.</span>
                        </div>
                        <div class="headline-text">
                            <div class="d-flex gap-3 py-4 align-items-center">
                                <p class="h1 mb-0"><b> <i
                                            class="text-primary bi bi-file-earmark-richtext-fill text-center justify-content-center h1 mb-0">
                                        </i>Panduan Laporan Akhir</b></p>
                            </div>
                            </h2>
                        </div>
                        <div class="body-text">
                            <p class="subtitle">Apa saja yang perlu dipersiapkan untuk pembuatan Laporan Akhir? Lihat
                                panduan berikut di bawah ini.
                            </p>
                            <ol class="list-group-numbered" style=" margin-left:-30px;">
                                <li class="list-group-item mb-3">
                                    Diharapkan siswa sudah mengisikan seluruh jurnal ataupun presensi yang ada.
                                </li>
                                <li class="list-group-item mb-3">Laporan Akhir, hanya bisa diakses apabila Guru
                                    pembimbing
                                    sudah memeriksa seluruh kegiatan PKL setidaknya 1 (satu) bulan
                                    sebelum Penarikan PKL.</li>
                                <li class="list-group-item mb-3">Siswa membuat laporan akhir digunakan untuk meringkas
                                    apa
                                    yang mereka laksanakan selama kegiatan PKL ataupun membuat pembahasan baru mengenai
                                    kegiatan PKL .
                                </li>
                                <li class="list-group-item mb-3">Siswa melakukan
                                    input data seperti Judul Laporan,
                                    Tujuan Laporan, Ringkasan dan file laporan yang akan digunakan.
                                </li>
                                <li class="list-group-item mb-3">Berikut, Anda bisa melihat tata cara dalam pembuatan
                                    laporan.
                                </li>
                                <div class="download gap-5 mb-4 mt-4">
                                    <a href="{{ asset('storage/format-penulisan-laporan-pkl.pdf') }}" target="_blank"
                                        class="btn btn-primary  me-2"><i
                                            class="bi bi-arrow-down-circle"></i>&nbsp;&nbsp;Format Laporan</a>
                                    <a href="{{ asset('storage/format-penulisan-laporan-pkl.pdf') }}" target="_blank"
                                        class="btn btn-primary"><i
                                            class="bi bi-arrow-down-circle"></i>&nbsp;&nbsp;Contoh
                                        Laporan</a>
                                </div>
                            </ol>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == null)
                <div class="d-flex gap-3 py-4 align-items-center">
                    <p class="h1 mb-0"><b> <i
                                class="bi bi-file-earmark-richtext-fill text-center text-primary justify-content-center h1 mb-0">
                            </i>Laporan Akhir</b></p>
                </div>
                <form action="{{ route('pengajuanReport') }}" method="post" class="mb-5"
                    enctype="multipart/form-data" id="confirmLaporan">
                    @csrf
                    <div class="file-drop-area border-primary mb-3" id="drop-area">
                        <p class="mb-1 text-secondary">Upload dokumen Laporan Akhir disini</p>
                        <input type="file" id="fileInput" class="form-control d-none" name="file" required>
                        <button type="button" class="btn btn-outline-primary mt-2"
                            onclick="document.getElementById('fileInput').click()">Pilih File</button>
                    </div>
                    <div id="filePreview" class="mb-3" style="display: none;">
                        <div class="alert alert-primary d-flex justify-content-between align-items-center">
                            <span id="fileName"></span>
                            <button class="btn btn-sm btn-danger" onclick="removeFile()">Hapus</button>
                        </div>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="judul" name="judul" required>
                        <label for="">Judul Laporan</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="tujuan" name="tujuan" required>
                        <label for="">Tujuan Laporan</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="dudi" name="dudi" required>
                        <label for="">Nama Instruktur Dudi</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <textarea name="deskripsi" id="" style="height: 110px" placeholder="komentar" class="form-control" required></textarea>
                        <label for="">Tulisakan ringkasan atau gambaran laporan Anda.</label>
                    </div>
                    <div class="mb-2">
                        <button type="button" class="btn btn-primary text-end align-items-end" data-bs-toggle="modal"
                            data-bs-target="#confirmLaporanModal">Kirim Pengajuan</button>
                    </div>
                </form>
                <div class="modal fade" id="confirmLaporanModal" tabindex="-1"
                    aria-labelledby="confirmLaporanLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi Pengajuan Laporan Akhir
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="" class="text-muted fw-bold">Tanggal Pengajuan Laporan</label>
                                    <p> {{ \Carbon\Carbon::parse(today())->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="text-muted fw-bold">Nama Lengkap</label>
                                    <p>{{ $user->nama }}</p>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="text-muted fw-bold">Tempat PKL</label>
                                    <p>{{ $user->internship->dudika }}</p>
                                </div>
                                <div class="mb-2">
                                    <p>Apakah kamu sudah yakin dengan pengajuan Laporan Akhir kamu? Sebelum dikirim
                                        kepada
                                        Guru pembimbing?</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" form="confirmLaporan">Ya,
                                    Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == 'pending')
                <div class="d-flex gap-3 mt-4 mb-1 align-items-center">
                    <p class="h1 mb-0"><b> <i
                                class="bi bi-file-earmark-richtext-fill text-center text-primary justify-content-center h1 mb-0">
                            </i>Laporan Akhir</b></p>
                </div>
                <div class="py-4">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="mb-3">
                                <label for="">Nama Lengkap</label>
                                <h5>{{ $user->nama }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Tempat PKL</label>
                                <h5>{{ $user->internship->dudika }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Nama Intruktur PKL</label>
                                <h5>{{ $data->dudi }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Status Laporan</label>
                                <h5> <span
                                        class="bg-secondary badge">{{ $data->verifikasi == 'pending' ? 'Proses' : '' }}</span>
                                </h5>
                            </div>
                            <div class="mb-3">
                                <label for="">File Laporan Akhir</label>
                                <h5><a href="{{ asset('storage/user/report/' . $safe . '/' . $data->file) }}"
                                        target="_blank">Download Laporan</a>
                                </h5>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="headline">
                                <div class="date text-muted small mb-2">
                                    {{ \Carbon\Carbon::parse($data->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                </div>
                                <h3>{{ $data->judul }}</h3>
                            </div>
                            <div class="body-text">
                                <div class="d-flex gap-2 align-items-center">
                                    <p class="badge bg-primary w-auto custom-badge">Tujuan</p>
                                    <p class="text-muted" style="font-size: 18px">{{ $data->tujuan }}</p>
                                </div>
                            </div>
                            <p class="text-muted" style="font-size: 18px">{{ $data->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == 'rejected')
                <div class="d-flex gap-3 py-4 align-items-center">
                    <p class="h1 mb-0"><b> <i
                                class="bi bi-file-earmark-richtext-fill text-center text-primary justify-content-center h1 mb-0">
                            </i>Revisi Laporan Akhir</b></p>
                </div>
                <form action="{{ route('revisiReport') }}" method="post" class="mb-5"
                    enctype="multipart/form-data" id="confirmRevisi">
                    @method('PUT')
                    @csrf
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"
                        style="cursor: pointer;" data-bs-target="#revisi" data-bs-toggle="collapse">
                        <strong>Informasi mengenai revisi laporan akhir</strong>
                        <div class="collapse" id="revisi">{{ $data->komentar }}</div>
                    </div>
                    <div class="file-drop-area border-primary mb-3" id="drop-area">
                        <p class="mb-1 text-secondary">Upload revisi Laporan Akhir disini</p>
                        <input type="file" id="fileInput" class="form-control d-none" name="file" required>
                        <button type="button" class="btn btn-outline-primary mt-2"
                            onclick="document.getElementById('fileInput').click()">Pilih File</button>
                    </div>
                    <div id="filePreview" class="mb-3" style="display: none;">
                        <div class="alert alert-primary d-flex justify-content-between align-items-center">
                            <span id="fileName"></span>
                            <button class="btn btn-sm btn-danger" onclick="removeFile()">Hapus</button>
                        </div>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="judul" name="judul" required
                            value="{{ $data->judul }}">
                        <label for="">Judul Laporan</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="tujuan" name="tujuan" required
                            value="{{ $data->tujuan }}">
                        <label for="">Tujuan Laporan</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="dudi" name="dudi" required
                            value="{{ $data->dudi }}">
                        <label for="">Nama Instruktur Dudi</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <textarea name="deskripsi" id="" style="height: 110px" placeholder="komentar" class="form-control"
                            required>{{ $data->deskripsi }}</textarea>
                        <label for="">Tulisakan ringkasan atau gambaran laporan Anda.</label>
                    </div>
                    <div class="mb-2">
                        <button type="button" class="btn btn-primary text-end align-items-end"
                            data-bs-toggle="modal" data-bs-target="#confirmRevisiModal">Kirim Revisi</button>
                    </div>
                </form>
                <div class="modal fade" id="confirmRevisiModal" tabindex="-1" aria-labelledby="confirmRevisiLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi Revisi Laporan Akhir
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="" class="text-muted fw-bold">Tanggal Pengajuan Laporan</label>
                                    <p> {{ \Carbon\Carbon::parse(today())->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="text-muted fw-bold">Nama Lengkap</label>
                                    <p>{{ $user->nama }}</p>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="text-muted fw-bold">Tempat PKL</label>
                                    <p>{{ $user->internship->dudika }}</p>
                                </div>
                                <div class="mb-2">
                                    <p>Apakah kamu sudah yakin dengan pengajuan Laporan Akhir kamu? Sebelum dikirim
                                        kepada
                                        Guru pembimbing?</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" form="confirmRevisi">Ya,
                                    Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == 'approved')
                <div class="d-flex gap-3 mt-4 mb-1 align-items-center">
                    <p class="h1 mb-0"><b> <i
                                class="bi bi-file-earmark-richtext-fill text-center text-primary justify-content-center h1 mb-0">
                            </i>Laporan Akhir</b></p>
                </div>
                <div class="py-4">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="mb-3">
                                <label for="">Nama Lengkap</label>
                                <h5>{{ $user->nama }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Tempat PKL</label>
                                <h5>{{ $user->internship->dudika }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Nama Intruktur PKL</label>
                                <h5>{{ $data->dudi }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Status Laporan</label>
                                <h5> <span
                                        class="bg-success badge">{{ $data->verifikasi == 'approved' ? 'Diterima' : '' }}</span>
                                </h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Print Laporan Akhir</label>
                                <h5><a href="{{ asset('storage/user/report/' . $safe . '/' . $data->file) }}"
                                        target="_blank">Download Laporan</a>
                                </h5>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="headline">
                                <div class="date text-muted small mb-2">
                                    {{ \Carbon\Carbon::parse($data->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                </div>
                                <h3>{{ $data->judul }}</h3>
                            </div>
                            <div class="body-text">
                                <div class="d-flex gap-2 align-items-center">
                                    <p class="badge bg-primary w-auto custom-badge">Tujuan</p>
                                    <p class="text-muted" style="font-size: 18px">{{ $data->tujuan }}</p>
                                </div>
                            </div>
                            <p class="text-muted" style="font-size: 18px">{{ $data->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == 'revision')
                <div class="d-flex gap-3 mt-4 mb-1 align-items-center">
                    <p class="h1 mb-0"><b> <i
                                class="bi bi-file-earmark-richtext-fill text-center text-primary justify-content-center h1 mb-0">
                            </i>Laporan Akhir</b></p>
                </div>
                <div class="py-4">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="mb-3">
                                <label for="">Nama Lengkap</label>
                                <h5>{{ $user->nama }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Tempat PKL</label>
                                <h5>{{ $user->internship->dudika }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Nama Intruktur PKL</label>
                                <h5>{{ $data->dudi }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Status Laporan</label>
                                <h5> <span
                                        class="bg-primary badge">{{ $data->verifikasi == 'revision' ? 'Revisi' : '' }}</span>
                                </h5>
                            </div>
                            <div class="mb-3">
                                <label for="">File Laporan Akhir</label>
                                <h5><a href="{{ asset('storage/user/report/' . $safe . '/' . $data->file) }}"
                                        target="_blank">Download Laporan</a>
                                </h5>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="headline">
                                <div class="date text-muted small mb-2">
                                    {{ \Carbon\Carbon::parse($data->tgl)->locale('id')->translatedFormat('l, d F Y') }}
                                </div>
                                <h3>{{ $data->judul }}</h3>
                            </div>
                            <div class="body-text">
                                <div class="d-flex gap-2 align-items-center">
                                    <p class="badge bg-primary w-auto custom-badge">Tujuan</p>
                                    <p class="text-muted" style="font-size: 18px">{{ $data->tujuan }}</p>
                                </div>
                            </div>
                            <p class="text-muted" style="font-size: 18px">{{ $data->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @endif
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
