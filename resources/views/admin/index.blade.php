<!DOCTYPE html>
<html lang="en">
<x-head title="Admin - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-loading-screen />
    <x-navbar-admin />
    <section>
        <div style="margin-top: 85px;">
            <div class="container mt-5">
                <h2 class="mb-4"><i class="bi bi-people-fill text-primary"></i> Daftar Profil Siswa</h2>
                <div class="row g-4">
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @forelse ($users as $siswa)
                        <div class="col-md-8 col-lg-6">
                            <div class="card shadow-sm border-0 p-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=0d6efd&size=64&color=fff"
                                            class="rounded-circle me-3" width="64" height="64" alt="Foto Profil">
                                        <div>
                                            <h5 class="mb-0">{{ $siswa->nama }}</h5>
                                            <small
                                                class="text-muted">{{ $siswa->internship->dudika ?? 'Belum ditempatkan' }}</small>
                                        </div>
                                    </div>

                                    <p class="mb-1"><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                                    <p class="mb-2"><strong>Alamat Email:</strong>
                                        {{ $siswa->email ?? '-' }}</p>

                                    <div class="d-grid mt-4">
                                        <button class="btn btn-outline-primary btn-sm" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#detailSiswa{{ $siswa->id }}"
                                            aria-expanded="false">
                                            Lihat Detail
                                        </button>
                                    </div>

                                    <div class="collapse mt-3" id="detailSiswa{{ $siswa->id }}">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Jurusan:</strong>
                                                {{ $siswa->jurusan == 'tkj' ? 'Teknik Komputer Jaringan' : '' }}
                                                {{ $siswa->jurusan == 'tjat' ? 'Teknik Jaringan Akses Telekomunikasi' : '' }}
                                                {{ $siswa->jurusan == 'lps' ? 'Layanan Perbankan Syariah' : '' }}
                                            </li>
                                            <li class="list-group-item"><strong>Tempat PKL:</strong>
                                                {{ $siswa->internship->dudika ?? '-' }}</li>
                                            <li class="list-group-item"><strong>No. Telp:</strong> {{ $siswa->telp }}
                                            </li>
                                        </ul>
                                        <div class="d-flex justify-content-center">
                                            <div class="text-end mt-4 me-2">
                                                @if (!$siswa->reports && !$siswa->boleh_aktifkan_laporan)
                                                    <button class="btn btn-sm border-secondary text-secondary"
                                                        type="button" data-bs-container="body" data-bs-toggle="popover"
                                                        data-bs-placement="top" data-bs-content="Top popover"><i
                                                            class="bi bi-file-earmark-richtext-fill"></i>&nbsp;&nbsp;Aktifkan
                                                        Laporan</button>
                                                @elseif (!$siswa->reports && $siswa->boleh_aktifkan_laporan)
                                                    <form action="{{ route('activeTugas', $siswa->id) }}"
                                                        method="post" id="confirmLaporan{{ $siswa->id }}">
                                                        @csrf
                                                        <input type="hidden" name="izin" value="1">
                                                        <button class="btn btn-sm btn-secondary" type="button"
                                                            data-bs-target="#confirmLaporanModal{{ $siswa->id }}"
                                                            data-bs-toggle="modal"><i
                                                                class="bi bi-file-earmark-richtext-fill"></i>&nbsp;&nbsp;Aktifkan
                                                            Laporan</button>
                                                    </form>
                                                @elseif ($siswa->reports)
                                                    <a href="{{ route('indexTugas', $siswa->reports->id) }}"
                                                        class="btn btn-sm btn-primary" type="button"><i
                                                            class="bi bi-file-earmark-richtext-fill"></i>&nbsp;&nbsp;Laporan
                                                        Akhir.</a>
                                                @endif
                                            </div>
                                            <div class="text-end mt-4 ms-auto me-2">
                                                <a href="{{ route('userAbsen', $siswa->id) }}"
                                                    class="btn btn-sm btn-secondary"><i
                                                        class="bi bi-person-badge"></i>&nbsp;&nbsp;Presensi</a>
                                            </div>
                                            <div class="text-end mt-4">
                                                <a href="{{ route('userLaporan', ['id' => $siswa->id]) }}"
                                                    class="btn btn-sm btn-success"><i
                                                        class="bi bi-journal-check"></i>&nbsp;&nbsp;Laporan</a>
                                            </div>
                                            <div class="modal fade" id="confirmLaporanModal{{ $siswa->id }}"
                                                tabindex="-1" aria-labelledby="confirmLaporanLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Aktifkan Laporan Akhir
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin membuka akses Laporan Akhir kepada
                                                            {{ $siswa->nama }}? Apabila diaktifkan, maka siswa dapat
                                                            mengirimkan Laporan Akhir.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success"
                                                                form="confirmLaporan{{ $siswa->id }}">Ya,
                                                                Aktifkan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada siswa yang terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
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
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
</body>

</html>
