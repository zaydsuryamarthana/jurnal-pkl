<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Pengelola Laporan - Jurnal Magang SMK Islamic Centre Baiturrahman" />

</head>

<body>
    <x-loading-screen />
    <x-navbar-admin />

    <section class="container py-5 mt-3">
        <div class="mt-4">
            <div class="mb-4">
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
                        <a href="{{ route('allPkl') }}"><i class="bi bi-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
                    </div>
                    <div class="d-flex gap-3 py-4 align-items-center">
                        <p class="h1 mb-0">{{ $data->dudika }}<b></b>
                        </p>
                    </div>
                    <div class="row">
                        @foreach ($users as $siswa)
                            <div class="col-lg-6 mb-4">
                                <a href="{{ route('indexAdmin') }}" style="text-decoration: none; color:black;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=0d6efd&size=64&color=fff"
                                                class="rounded-circle me-3" width="48" height="48"
                                                alt="Foto Profil">
                                            <div>
                                                <h5 class="mb-0">{{ $siswa->nama }}</h5>
                                                <small class="text-muted">{{ $siswa->nisn ?? 'Tidak ditemukan NISN' }} /
                                                    @if ($siswa->jurusan == 'tkj')
                                                        Teknik Komputer Jaringan
                                                    @elseif ($siswa->jurusan == 'lps')
                                                        Layanan Perbankan Syariah
                                                    @elseif ($siswa->jurusan == 'tjat')
                                                        Teknik Jaringan Akses Telekomunikasi
                                                    @else
                                                        Data Tidak ditemukan
                                                    @endif

                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3 col-lg-12">
                        <iframe src="{{ $data->map }}" frameborder="0" width="100%" height="250"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <form action="{{ route('updateInternship', $data->id) }}" method="post" id="updateInternship">
                        @method('PUT')
                        @csrf
                        <div class="mb-3 form-floating">
                            <textarea name="deskripsi" id="" cols="30" rows="3" class="form-control" placeholder="Deskripsi PKL"
                                style="height: 80px">{{ $data->deskripsi }}</textarea>
                            <label for="">Deskripsi</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <textarea name="alamat" placeholder="Alamat PKL" cols="30" rows="2" class="form-control"
                                style="height: 80px">{{ $data->alamat }}</textarea>
                            <label for="">Alamat</label>
                        </div>
                        <div class="mb-3">
                            <button data-bs-target="#modalUpdate" data-bs-toggle="modal" class="btn btn-primary"
                                type="button"><i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;Perbarui Data</button>

                        </div>
                    </form>
                    <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Verifikasi Update Data</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah kamu yakin akan merubah data PKL {{ $data->dudika }}?
                                        <b>Apabila dihapus akan mempengaruhi beberapa file nantinya.</b>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" form="updateInternship"><i
                                            class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;Perbarui</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
    document.getElementById('editScheduleBtn').addEventListener('click', function() {
        document.querySelectorAll('.edit-input').forEach(el => el.classList.remove('d-none'));
        document.querySelectorAll('.display-value').forEach(el => el.classList.add('d-none'));
        document.getElementById('submitBtn').classList.remove('d-none');
    });

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
