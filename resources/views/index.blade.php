<!DOCTYPE html>
<html lang="en">
<x-head title="Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-navbar />
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12 left-side mb-4 mb-lg-0">
                    <div class="headline-body">
                        <h1 class="text-primary display-1">Aplikasi Jurnal</h1>
                        <h1 class="text-primary display-1">Magang</h1>
                    </div>
                    <div class="text-body mt-3">
                        <p>Jurnal Magang SMK Islamic Centre Baiturrahman</p>
                        <a href="{{ route('login') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-box-arrow-in-right"></i>&nbsp;&nbsp;Get Started
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 right-side">
                    <img src="{{ asset('images/model3.png') }}" class="img-fluid w-100" style="max-width: 400px;"
                        alt="Model Pelajar">
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="container mb-5">
            <div class="row gx-4 gy-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow border-0 rounded h-100">
                        <div class="card-body text-center p-4">
                            <div
                                class="feature bg-primary text-white rounded-3 d-inline-flex justify-content-center align-items-center py-2 px-3 mb-3">
                                <i class="bi bi-folder-symlink-fill"></i>
                            </div>
                            <h2 class="fs-4 fw-bold">Pengelolaan Laporan</h2>
                            <p class="mb-0">Mengelola serta menyimpan seluruh rekap laporan selama Magang</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card shadow border-0 rounded h-100">
                        <div class="card-body text-center p-4">
                            <div
                                class="feature bg-primary text-white rounded-3 d-inline-flex justify-content-center align-items-center py-2 px-3 mb-3">
                                <i class="bi bi-send-check-fill"></i>
                            </div>
                            <h2 class="fs-4 fw-bold">Efisien dan Cepat</h2>
                            <p class="mb-0">Efisien waktu dan memiliki lingkup luas dalam pengelolaan laporan</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mx-md-auto">
                    <div class="card shadow border-0 rounded h-100">
                        <div class="card-body text-center p-4">
                            <div
                                class="feature bg-primary text-white rounded-3 d-inline-flex justify-content-center align-items-center py-2 px-3 mb-3">
                                <i class="bi bi-database-fill-lock"></i>
                            </div>
                            <h2 class="fs-4 fw-bold">Terjamin Aman</h2>
                            <p class="mb-0">Data terlindungi dari akses yang tidak sah </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="faq" style="margin-top: 85px">
                <div class="headline text-center">
                    <h1 class="text-primary fw-bold display-3">FAQ</h1>
                    <p class="text-secondary">Pertanyaan yang sering dijumpai.</p>
                </div>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                Bagaimana cara menggunakan Aplikasi Jurnal Magang?
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Kalian bisa melakukan <b>login</b> terlebih dahulu sebelum bisa masuk ke dalam sistem
                                Jurnal Magang. Apabila kalian belum memiliki akun, kalian bisa melakukan
                                <b>registrasi</b> atau <b>signup</b> yang disediakan. Isikan data-data yang diperlukan,
                                setelah itu kalian bisa mengakses sistem Jurnal Magang.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                aria-controls="flush-collapseTwo">
                                Apa saja yang bisa dilakukan di Jurnal Magang?
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">Kalian bisa melakukan beberapa hal loh. Kalian bisa melakukan
                                <b>presensi</b> kehadiran selama PKL, menyimpan data <b>laporan harian</b>
                                hingga menyimpan <b>laporan akhir</b>. Semua ini sudah dikembangkan sedemikian rupa
                                untuk
                                memenuhi kebutuhan kalian dalam mengisi Jurnal Magang.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                Bagaimana aplikasi yang aku gunakan ada masalah?
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body"> Kalian bisa langsung menghubungi saja pihak <b>customer
                                    service</b>
                                kami, siap membantu kalian apabila terjadi kesalahan sistem Jurnal Magang kami atau
                                keperluan ketidaklengkapan data dari kami. Hubungi <a href="">customer service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <footer class="text-center py-3">
        <div class="container">
            <small class="text-muted">&copy; Jurnal Magang 2025. All Rights Reserved.</small>
        </div>
    </footer>
</body>

</html>
