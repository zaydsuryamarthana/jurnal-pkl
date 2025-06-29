<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Pengelola Laporan - Jurnal Magang SMK Islamic Centre Baiturrahman" />

</head>

<body>
    <x-loading-screen />
    <x-navbar-admin />

    <section class="container py-5 mt-3">
        <div class="row mt-4">
            <div class="col-lg-12 mb-4">
                <div class="w-auto">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <div class="button-back">
                        <a href="{{ route('userLaporan', $user->id) }}"><i
                                class="bi bi-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
                    </div>
                    <div class="d-flex gap-3 py-4 align-items-center">

                        <p class="h1 mb-0"><b>Detail Laporan</b>
                            @if ($journal->verifikasi == 'belum')
                                <div class="mb-0 justify-content-center align-items-center text-center">
                                    <span class="badge bg-secondary">Belum Verifikasi</span>
                                </div>
                            @elseif ($journal->verifikasi == 'sudah')
                                <div class="mb-0 justify-content-center align-items-center text-center ">
                                    <span class="badge bg-success">Terverifikasi</span>
                                </div>
                            @elseif ($journal->verifikasi == 'tolak')
                                <div class="mb-0 justify-content-center align-items-center text-center ">
                                    <span class="badge bg-danger">Tolak</span>
                                </div>
                            @elseif ($journal->verifikasi == 'revisi')
                                <div class="mb-0 justify-content-center align-items-center text-center ">
                                    <span class="badge bg-primary">Revisi</span>
                                </div>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="position-relative border rounded overflow-hidden mb-4">
                    <img id="previewImage" src="{{ asset('storage/user/journal/' . $safe . '/' . $journal->foto) }}"
                        alt="Foto Laporan" class="w-100" style="object-fit: cover; max-height: 300px;">
                </div>
                <div class="mb-1">
                    <span class="ms-auto text-muted small">
                        {{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="mb-2">
                    <h3>{{ $journal->judul }}</h3>
                </div>
                <div class="mb-3">
                    <p style="font-size: 19px">{{ $journal->isi }}</p>
                </div>
                <div class="mt-4 mb-3 d-flex align-items-center">
                    @if ($journal->verifikasi == 'belum' || $journal->verifikasi == 'revisi')
                        <form action="{{ route('verifLaporanUser', ['id' => $journal->id, 'user' => $user->id]) }}"
                            method="post" class="me-2" id="confirmForm">
                            @csrf
                            <input type="hidden" name="verif" value="sudah">
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#confirmVerificationModal" type="button"><i
                                    class="bi bi-check-circle"></i>&nbsp;&nbsp;Verifikasi</button>
                        </form>
                        <button class="btn border-danger text-danger" value="tolak" name="verif"
                            id="showRejectFormBtn"><i class="bi bi-x-circle"></i>&nbsp;&nbsp;Tolak
                            Laporan</button>
                    @endif
                </div>
            </div>
            <div class="col-lg-12 mb-4 mt-2" id="rejectFormContainer" style="display: none;">
                <form id="rejectForm" method="POST"
                    action="{{ route('verifLaporanUser', ['id' => $journal->id, 'user' => $user->id]) }}">
                    @csrf
                    <input type="hidden" name="verif" value="tolak">
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Penolakan</label>
                        <textarea name="komentar" id="alasan" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#confirmRejectModal">Kirim Penolakan</button>
                </form>
            </div>
        </div>
    </section>
    <div class="modal fade" id="confirmVerificationModal" tabindex="-1" aria-labelledby="confirmVerificationLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Verifikasi Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin verifikasi laporan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" form="confirmForm">Ya, Verifikasi</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmRejectModal" tabindex="-1" aria-labelledby="confirmRejectLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menolak laporan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" form="rejectForm">Ya, Tolak</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById('showRejectFormBtn')?.addEventListener('click', function() {
        document.getElementById('rejectFormContainer').style.display = 'block';
        document.getElementById('rejectForm').scrollIntoView({
            behavior: 'smooth'
        });
    });

    function readURL(input) {
        const preview = document.getElementById('previewImage');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
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
</script>

</html>
