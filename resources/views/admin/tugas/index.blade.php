<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Laporan Akhir - Jurnal Magang SMK Islamic Centre Baiturrahman" />s
</head>
<style>
    .file-drop-area {
        border: 2px dashed #6c757d;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .file-drop-area:hover {
        background-color: #f8f9fa;
    }
</style>

<body>
    @php
        $safe = Str::slug($data->user->nama);
    @endphp
    <x-loading-screen />
    <x-navbar-admin />
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
            @if ($data->verifikasi == null)
                <div class=" h-100">
                    <div class="bg-information">
                        <div class="headline-text">
                            <div class="d-flex gap-3 py-4 align-items-center">
                                <p class="h1 mb-0"><b> <i
                                            class="text-primary bi bi-file-earmark-richtext-fill text-center justify-content-center h1 mb-0">
                                        </i>Laporan Akhir {{ $data->user->nama }}</b></p>
                            </div>
                            </h2>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == 'pending')
                <div class="py-4">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="mb-3">
                                <label for="">Nama Lengkap</label>
                                <h5>{{ $data->user->nama }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Tempat PKL</label>
                                <h5>{{ $data->user->internship->dudika }}</h5>
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
                                    <p class="text-muted">{{ $data->tujuan }}</p>
                                </div>
                            </div>
                            <p class="text-muted">{{ $data->deskripsi }}</p>
                            <div class="mt-4 mb-3 d-flex align-items-center">
                                <form action="{{ route('updateTugas', $data->id) }}" method="post" class="me-2"
                                    id="confirmForm">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="verif" value="approved">
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#confirmVerificationModal" type="button"><i
                                            class="bi bi-check-circle"></i>&nbsp;&nbsp;Verifikasi</button>
                                </form>
                                <button class="btn border-danger text-danger" id="showRejectFormBtn"><i
                                        class="bi bi-x-circle"></i>&nbsp;&nbsp;Tolak
                            </div>
                            <div class="col-lg-12 mb-4 mt-2" id="rejectFormContainer" style="display: none;">
                                <form id="rejectForm" method="POST" action="{{ route('updateTugas', $data->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="verif" value="rejected">
                                    <div class="mb-3">
                                        <label for="komentar" class="form-label">Alasan Penolakan</label>
                                        <textarea name="komentar" id="alasan" class="form-control" rows="4" required></textarea>
                                    </div>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmRejectModal">Kirim Penolakan</button>
                                </form>
                            </div>
                            <div class="modal fade" id="confirmVerificationModal" tabindex="-1"
                                aria-labelledby="confirmVerificationLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Verifikasi Laporan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin verifikasi laporan ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success" form="confirmForm">Ya,
                                                Verifikasi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="confirmRejectModal" tabindex="-1"
                                aria-labelledby="confirmRejectLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Penolakan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menolak laporan ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger" form="rejectForm">Ya,
                                                Tolak</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == 'revision')
                <div class="py-4">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="mb-3">
                                <label for="">Nama Lengkap</label>
                                <h5>{{ $data->user->nama }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Tempat PKL</label>
                                <h5>{{ $data->user->internship->dudika }}</h5>
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
                                    <p class="text-muted">{{ $data->tujuan }}</p>
                                </div>
                            </div>
                            <p class="text-muted">{{ $data->deskripsi }}</p>
                            <div class="mt-4 mb-3 d-flex align-items-center">
                                <form action="{{ route('updateTugas', $data->id) }}" method="post" class="me-2"
                                    id="confirmForm">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="verif" value="approved">
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#confirmVerificationModal" type="button"><i
                                            class="bi bi-check-circle"></i>&nbsp;&nbsp;Verifikasi</button>
                                </form>
                                <button class="btn border-danger text-danger" id="showRejectFormBtn"><i
                                        class="bi bi-x-circle"></i>&nbsp;&nbsp;Tolak
                            </div>
                            <div class="col-lg-12 mb-4 mt-2" id="rejectFormContainer" style="display: none;">
                                <form id="rejectForm" method="POST" action="{{ route('updateTugas', $data->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="verif" value="rejected">
                                    <div class="mb-3">
                                        <label for="komentar" class="form-label">Alasan Penolakan</label>
                                        <textarea name="komentar" id="alasan" class="form-control" rows="4" required></textarea>
                                    </div>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmRejectModal">Kirim Penolakan</button>
                                </form>
                            </div>
                            <div class="modal fade" id="confirmVerificationModal" tabindex="-1"
                                aria-labelledby="confirmVerificationLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Verifikasi Laporan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin verifikasi laporan ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success" form="confirmForm">Ya,
                                                Verifikasi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="confirmRejectModal" tabindex="-1"
                                aria-labelledby="confirmRejectLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Penolakan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menolak laporan ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger" form="rejectForm">Ya,
                                                Tolak</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == 'rejected')
                <div class="py-4">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="mb-3">
                                <label for="">Nama Lengkap</label>
                                <h5>{{ $data->user->nama }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Tempat PKL</label>
                                <h5>{{ $data->user->internship->dudika }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Nama Intruktur PKL</label>
                                <h5>{{ $data->dudi }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Status Laporan</label>
                                <h5> <span
                                        class="bg-danger badge">{{ $data->verifikasi == 'rejected' ? 'Ditolak' : '' }}</span>
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
                                    <p class="text-muted">{{ $data->tujuan }}</p>
                                </div>
                            </div>
                            <p class="text-muted">{{ $data->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @elseif ($data->verifikasi == 'approved')
                <div class="py-4">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="mb-3">
                                <label for="">Nama Lengkap</label>
                                <h5>{{ $data->user->nama }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Tempat PKL</label>
                                <h5>{{ $data->user->internship->dudika }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Nama Intruktur PKL</label>
                                <h5>{{ $data->dudi }}</h5>
                            </div>
                            <div class="mb-3">
                                <label for="">Status Laporan</label>
                                <h5> <span
                                        class="bg-success badge">{{ $data->verifikasi == 'approved' ? 'Verifikasi' : '' }}</span>
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
                                    <p class="text-muted">{{ $data->tujuan }}</p>
                                </div>
                            </div>
                            <p class="text-muted">{{ $data->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</body>
<script>
    document.getElementById('showRejectFormBtn')?.addEventListener('click', function() {
        document.getElementById('rejectFormContainer').style.display = 'block';
        document.getElementById('rejectForm').scrollIntoView({
            behavior: 'smooth'
        });
    });
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileNameDisplay = document.getElementById('fileName');

    // Drag & Drop handlers
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
