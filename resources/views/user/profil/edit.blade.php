<!DOCTYPE html>
<html lang="en">

<x-head title="Profile - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<style>
    @media (max-width: 768px) {
        .profil {
            font-size: 20px;
        }

    }
</style>

<body>
    <x-loading-screen />
    <x-navbar />
    <div class="container py-5 mt-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Berhasil Update!</strong> Profil kamu telah diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Gagal Update!</strong> Ulangi menyimpan data profil terbaru.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
        <form action="{{ route('updateProfil') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 text-center mb-4">
                    <div class="position-relative border rounded overflow-hidden">
                        <img id="previewImage" src="{{ asset('storage/user/profil/' . $safe . '/' . $user->foto) }}"
                            alt="Foto Laporan" class="w-100" style="object-fit: cover; max-height: 300px;">
                        <label for="fotoMasuk"
                            class="position-absolute bottom-0 start-0 bg-dark bg-opacity-50 text-white text-center w-100 py-2 cursor-pointer">
                            Ganti Foto
                            <input type="file" class="d-none" id="fotoMasuk" name="foto" onchange="readURL(this)">
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="mb-4 d-flex align-items-center gap-3">
                        <i class="btn btn-primary bi bi-person-circle h1 mb-0"></i>
                        <h2 class="profil mb-0"><strong>Data Pengguna</strong>
                        </h2>
                        <a href="{{ route('indexProfil') }}" class="ms-auto"><i
                                class="bi bi-arrow-left"></i>&nbsp;&nbsp;Kembali</a>

                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="nama" id="" class="form-control"
                                value="{{ $user->nama }}" readonly>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Nomor Induk Nasional Siswa</label>
                                <input type="text" name="nisn" id="" class="form-control"
                                    value="{{ $user->nisn }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Nomor Induk Siswa</label>
                                <input type="text" name="nis" id="" class="form-control"
                                    value="{{ $user->nis }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Jurusan</label>
                            <select name="jurusan" id="" class="form-control">
                                <option value="">-</option>
                                <option value="tkj" {{ $user->jurusan == 'tkj' ? 'selected' : '' }}>Teknik Komputer
                                    Jaringan</option>
                                <option value="tjat" {{ $user->jurusan == 'tjat' ? 'selected' : '' }}>Teknik Jaringan
                                    Akses Telekomunikasi</option>
                                <option value="lps" {{ $user->jurusan == 'lps' ? 'selected' : '' }}>Layanan Perbankan
                                    Syariah</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Kelas</label>
                            <select name="kelas" id="" class="form-control">
                                <option value="">-</option>
                                <option value="xi" {{ $user->kelas == 'xi' ? 'selected' : '' }}>XI</option>
                                <option value="xii" {{ $user->kelas == 'xii' ? 'selected' : '' }}>XII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Jenis Kelamin</label>
                            <select name="jk" id="" class="form-control">
                                <option value=""></option>
                                <option value="l" {{ $user->jk == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="p" {{ $user->jk == 'p' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Nomor Telepon</label>
                            <input type="text" name="telp" id="" class="form-control"
                                value="{{ $user->telp }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary text-end">Update Data</button>
                </div>
            </div>
        </form>
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

        function readURL(input) {
            const preview = document.getElementById('previewImage');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
