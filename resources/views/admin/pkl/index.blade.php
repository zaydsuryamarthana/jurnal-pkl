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
                                </i>Daftar Tempat PKL</b></p>
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
                <form class="align-items-end mb-3 search-form-laporan" role="search" action="{{ route('allPkl') }}"
                    method="GET">
                    <div class="row">
                        <div class="col-lg-11 position-relative">
                            <div class="form-floating">
                                <input type="search" class="form-control pe-5" name="search"
                                    placeholder="Cari data laporan" value="{{ request('search') }}"
                                    autocomplete="off" />
                                <label for="searchInput">Cari Dudika / Alamat</label>
                            </div>
                            <button class="position-absolute top-50 end-0 translate-middle-y text-muted"
                                style="margin-right: 40px">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="col-lg-1">
                            <span data-bs-target="#tambahInternship" data-bs-toggle="modal"
                                class="btn border-primary w-100 h-100 d-flex justify-content-center align-items-center"><i
                                    class="bi bi-plus-lg text-primary"></i></span>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0 w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Dudika</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($internships as $no => $pkl)
                                <tr data-bs-target="#pkl{{ $pkl->id }}" data-bs-toggle = "modal"
                                    style="cursor: pointer">
                                    <td>{{ $no + 1 }}</td>
                                    <td style=""><span>{{ $pkl->dudika ?? '-' }}</span>
                                    </td>
                                    <td>{{ $pkl->jam_masuk ?? '-' }}</td>
                                    <td>{{ $pkl->jam_keluar ?? '-' }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('indexInternship', $pkl->id) }}"><span
                                                class="btn btn-primary"><i class="bi bi-pencil-square"></i></span></a>
                                        <form action="{{ route('dropInternship', $pkl->id) }}" method="post"
                                            id="dropInternship">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button"
                                                class="btn btn-danger justify-content-center align-items-center text-center"
                                                data-bs-target="#modalInternship" data-bs-toggle="modal"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modalInternship" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Verifikasi
                                                    Penghapusan Data</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah kamu yakin akan menghapus data PKL {{ $pkl->dudika }}?
                                                    <b>Apabila dihapus akan mempengaruhi beberapa file nantinya.</b>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger" form="dropInternship"><i
                                                        class="bi bi-trash"></i>&nbsp;Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    {{ $internships->links() }}
                </div>
            </div>
            <div class="modal fade" id="tambahInternship" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Tempat PKL</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" id="eksekusiTambah">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="mb-2 text-muted">Dudika&nbsp;<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required
                                        placeholder="Tuliskan nama tempat PKL ..." name="dudika">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 text-muted">Alamat&nbsp;<span
                                            class="text-danger">*</span></label>
                                    <textarea name="alamat" id="" cols="30" rows="3" class="form-control"
                                        placeholder="Tuliskan alamat tempat PKL ..." required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 text-muted">Deskripsi</label>
                                    <textarea name="deskripsi" id="" cols="30" rows="3" class="form-control"
                                        placeholder="Tuliskan alamat tempat PKL ..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 text-muted">Google Maps&nbsp;<b
                                            class="text-danger">*</b>&nbsp;&nbsp;<button type="button"
                                            class="text-primary" data-bs-toggle="modal" data-bs-target="#helpMap"><i
                                                class="bi bi-question-circle"></i></button>
                                    </label>
                                    <input type="text" class="form-control" required
                                        placeholder="Link iframe Google Maps sesuai dengan Tempat PKL ..."
                                        name="map">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success" data-bs-target="#confirmTambahInternship"
                                data-bs-toggle="modal"><i class="bi bi-plus-circle-fill"></i>&nbsp;Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="confirmTambahInternship" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data PKL</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah kamu yakin akan menambah data PKL baru?
                                Apabila menambahkan data PKL nantinya dapat digunakan oleh siswa.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-target="#tambahInternship"
                                data-bs-toggle="modal">Kembali</button>
                            <button type="submit" class="btn btn-success" form="eksekusiTambah"><i
                                    class="bi bi-check-circle-fill"></i>&nbsp; &nbsp;Iya, Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="helpMap" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Bagaimana mendapatkan Link Google
                                Maps?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="mb-2">Buka aplikasi atau website <b>Google
                                        Maps</b>.</label>
                                <img src="{{ asset('storage/map/step-1.png') }}" alt="">
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Klik <b>Bagikan</b> lalu masuk ke dalam
                                    <b>Sematkan peta</b>. </label>
                                <img src="{{ asset('storage/map/step-2.png') }}" alt="">
                            </div>
                            <div class="mb-3">
                                <label for="">Salin link <b>iFrame</b> seperti foto dibawah
                                    ini.</label>
                                <p class="mb-2 small text-muted text-truncate" style="width:70%;">
                                    Contoh-nya :
                                    https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.066327390456!2d110.39975157574035!3d-7.001471868576647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b14b571b8e9%3A0x45df144e649bf217!2sPDAM%20Tirta%20Moedal%20Kota%20Semarang!5e0!3m2!1sid!2sid!4v1750503947468!5m2!1sid!2sid
                                </p>
                                <img src="{{ asset('storage/map/step-3.png') }}" class="mb-2" alt="">
                                <p class="mb-2 small text-muted">
                                    Salin dari petik awal <b>"https::// . . .</b> hingga petik akhir <b>"</b>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-target="#tambahInternship"
                                data-bs-toggle="modal">Kembali</button>
                        </div>
                    </div>
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

        document.getElementById('editScheduleBtn').addEventListener('click', function() {
            document.querySelectorAll('.edit-input').forEach(el => el.classList.remove('d-none'));
            document.querySelectorAll('.display-value').forEach(el => el.classList.add('d-none'));
            document.getElementById('submitBtn').classList.remove('d-none');
        });

        $(function() {
            $('[data-toggle="popover"]').popover()
        });
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
</body>

</html>
