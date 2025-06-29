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
        <div class="row justify-content-center">

            <div class="col-12 col-md-4 text-center mb-4">
                @if ($user->foto)
                    <img src="{{ asset('storage/user/profil/' . $safe . '/' . $user->foto) }}" class="img-fluid rounded"
                        style="max-width: 100%;" alt="Foto Profil">
                @else
                    <img src="" class="img-fluid rounded" style="max-width: 80%;" alt="Foto Profil Default">
                @endif

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
            </div>

            <div class="col-12 col-md-8">
                <div class="mb-4 d-flex align-items-center gap-3">
                    <i class="btn btn-primary bi bi-person-circle h1 mb-0"></i>
                    <h2 class="profil mb-0"><strong>Data Pengguna</strong>
                    </h2>
                    <a href="{{ route('editProfil') }}" class="btn btn-sm border-primary text-primary ms-auto">Update
                        Data</a>
                </div>
                <div class="card w-100 mb-3" data-bs-target="#identitas" data-bs-toggle="collapse">
                    <div class="card-title p-3 mb-0">
                        <span class="">Identitas Pengguna</span>
                    </div>
                    <div id="identitas" class=" px-5 collapse mb-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="">Nama Lengkap</label>
                                    <div class="text-muted"><span>{{ $user->nama }}</span></div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Nomor Induk Nasional Siswa</label>
                                    <div class="text-muted"><span>{{ $user->nisn }}</span></div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Nomor Induk Siswa</label>
                                    <div class="text-muted"><span>{{ $user->nis }}</span></div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Jurusan</label>
                                    <div class="text-muted"><span>
                                            @if ($user->jurusan == 'tkj')
                                                <span>Teknik Komputer Jaringan</span>
                                            @elseif ($user->jurusan == 'tjat')
                                                <span>Teknik Jaringan Akses Telekomunikasi</span>
                                            @elseif ($user->jurusan == 'lps')
                                                <span>Layanan Perbankan Syariah</span>
                                            @elseif ($user->jurusan == '')
                                                <span>- Belum ada data Jurusan</span>
                                            @endif
                                        </span></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="">Kelas</label>
                                    <div class="text-muted"><span>
                                            @if ($user->kelas == 'xi')
                                                <span>XI</span>
                                            @elseif ($user->kelas == 'xii')
                                                <span>XII</span>
                                            @elseif ($user->kelas == '')
                                                <span>- Belum ada data kelas</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Jenis Kelamin</label>
                                    <div class="text-muted">
                                        <span>
                                            @if ($user->jk == 'l')
                                                <span>Laki-laki</span>
                                            @elseif ($user->jk == 'p')
                                                <span>Perempuan</span>
                                            @elseif ($user->jk == '')
                                                <span>- Belum ada data jenis kelamin</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Nomor Telepon</label>
                                    @if (!$user->telp)
                                        <div class="text-muted"><span>- Belum ada data nomor telepon</span></div>
                                    @else
                                        <div class="text-muted"><span>{{ $user->telp }}</span></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card w-100 mb-3" data-bs-target="#pkl" data-bs-toggle="collapse">
                    <div class="card-title p-3 mb-0">
                        <span class="">Informasi Praktek Kerja Lapangan</span>
                    </div>
                    <div id="pkl" class="collapse mb-3 px-5">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="">Nama Tempat PKL</label>
                                    <div class="text-muted"><span>{{ $user->internship->dudika }}</span></div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Alamat PKL</label>
                                    <div class="text-muted"><span>{{ $user->internship->alamat }}</span></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="">Nama Guru Pembimbing</label>
                                    <div class="text-muted"><span>{{ $admin->nama }}</span></div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Nomor Telepon Pembimbing</label>
                                    <div class="text-muted"><span>{{ $admin->telp }}</span></div>
                                </div>
                            </div>
                            <div class="map mb-3">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.066282195649!2d110.39975157499713!3d-7.0014771929997615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b14b571b8e9%3A0x45df144e649bf217!2sPDAM%20Tirta%20Moedal%20Kota%20Semarang!5e0!3m2!1sid!2sid!4v1748572177530!5m2!1sid!2sid"
                                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-100 mb-3" data-bs-target="#berkas" data-bs-toggle="collapse">
                    <div class="card-title p-3 mb-0">
                        <span class="">Berkas-berkas Pengguna</span>
                    </div>
                    <div id="berkas" class="collapse mb-3 px-5">
                        <div class="mb-3">
                            <label>Surat Pernyataan</label> <br>
                            <a href="{{ asset('storage/user/verification/' . $safe . '/' . $verification->file) }}"
                                target="_blamk">{{ $verification->file }}</a>
                        </div>
                        <div class="mb-3">
                            <label>Laporan Akhir</label> <br>
                            @if (!$report)
                                <div class="text-muted">Belum ada data Laporan Akhir</div>
                            @elseif ($report->file)
                                <a href="{{ asset('storage/user/report/' . $safe . '/' . $report->file) }}"
                                    target="_blamk">{{ $report->file }}</a>
                            @else
                                <div class="text-muted">Belum ada data Laporan Akhir</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </script>
</body>

</html>
