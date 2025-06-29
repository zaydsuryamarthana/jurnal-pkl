<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Pengelola Laporan - Jurnal Magang SMK Islamic Centre Baiturrahman" />
    <style>
        .font-form {
            font-size: 20px !important
        }

        @media (max-width:768px) {
            .font-form {
                font-size: 16px !important
            }
        }
    </style>
</head>


<body>
    <x-loading-screen />
    <x-navbar />
    <section class="container py-5">
        <div class="row" style="margin-top: 40px">
            <a href="{{ route('detailJournal', $data->id) }}"><i class="bi bi-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
            <form action="{{ url('/laporan/' . $data->id . '/edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="col-lg-12 mb-4">
                    <div class="w-auto">
                        <div class="d-flex gap-3 py-4 align-items-center">
                            <p class="h1 mb-0"><b> <i
                                        class="bi bi-check-circle-fill text-center text-primary justify-content-center h1 mb-0">
                                    </i>Edit Laporan</b>
                            </p>
                        </div>
                    </div>
                    <div class="position-relative border rounded overflow-hidden">
                        <img id="previewImage" src="{{ asset('storage/user/journal/' . $safe . '/' . $data->foto) }}"
                            alt="Foto Laporan" class="w-100" style="object-fit: cover; max-height: 300px;">
                        <label for="fotoMasuk"
                            class="position-absolute bottom-0 start-0 bg-dark bg-opacity-50 text-white text-center w-100 py-2 cursor-pointer">
                            Ganti Foto
                            <input type="file" class="d-none" id="fotoMasuk" name="foto" accept="image/*"
                                onchange="readURL(this)">
                        </label>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="judul" class="form-label text-muted">Judul&nbsp;<span
                                class="text-danger fw-bold">*</span></label>
                        <input type="text" name="judul" class="form-control font-form" value="{{ $data->judul }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label text-muted">Deskripsi&nbsp;<span
                                class="text-danger fw-bold">*</span></label>
                        <textarea name="isi" class="form-control font-form" rows="5" required>{{ $data->isi }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
        </div>
        </form>
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
