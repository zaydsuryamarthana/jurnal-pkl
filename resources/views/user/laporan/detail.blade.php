<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Pengelola Laporan - Jurnal Magang SMK Islamic Centre Baiturrahman" />

</head>

<body>
    <x-loading-screen />
    <x-navbar />
    <section class="container py-5 mt-3">
        <div class="row mt-4">
            <div class="col-lg-12 mb-4">
                <a href="{{ route('indexJournal') }}"><i class="bi bi-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
                <div class="w-auto">
                    <div class="d-flex gap-3 py-4 align-items-center">
                        <p class="h1 mb-0"><b>Detail Laporan</b>
                            @if ($data->verifikasi == 'sudah')
                                <div class="mb-0 justify-content-center align-items-center text-center">
                                    <span class="badge bg-success">Verifikasi</span>
                                </div>
                            @elseif($data->verifikasi == 'tolak')
                                <div class="mb-0 justify-content-center align-items-center text-center ">
                                    <span class="badge bg-danger">Ditolak</span>
                                </div>
                            @elseif ($data->verifikasi == 'belum')
                                <div class="mb-0 justify-content-center align-items-center text-center ">
                                    <span class="badge bg-secondary">Belum diverifikasi</span>
                                </div>
                            @elseif ($data->verifikasi == 'revisi')
                                <div class="mb-0 justify-content-center align-items-center text-center ">
                                    <span class="badge bg-primary">Revisi</span>
                                </div>
                            @endif

                        </p>
                    </div>
                </div>
                <div class="position-relative border rounded overflow-hidden mb-4">
                    <img id="previewImage" src="{{ asset('storage/user/journal/' . $safe . '/' . $data->foto) }}"
                        alt="Foto Laporan" class="w-100" style="object-fit: cover; max-height: 300px;">
                </div>
                <div class="mb-1">
                    <span class="ms-auto text-muted small">
                        {{ \Carbon\Carbon::parse($data->tgl)->locale('id')->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="mb-2">
                    <h3>{{ $data->judul }}</h3>
                </div>
                <div class="mb-3">
                    <p style="font-size: 19px" class="text-muted">{{ $data->isi }}</p>
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <div class="justify-content-center mb-0">
                        @if ($data->verifikasi == 'tolak')
                            <a href="{{ route('editJournal', $data->id) }}" class="btn btn-primary">Edit Laporan</a>
                            <a href="" class="btn btn-danger" data-bs-target="#penolakan"
                                data-bs-toggle="collapse">Alasan Penolakan</a>
                        @endif
                    </div>
                </div>
                <div class="card p-3 collapse" id="penolakan">
                    <p>{{ $data->komentar }}</p>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
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
