<!DOCTYPE html>
<html lang="en">

<x-head title="Verifikasi Pendaftaran Akun - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-loading-screen />
    <div class="row vh-100 g-0">
        <div class="col-lg-8 position-relative d-none d-lg-block"
            style="background-image: url('{{ asset('images/home-page.png') }}'); background-size:cover;">
        </div>
        <div class="col-lg-4">
            <div class="row align-items-center justify-content-center h-100 g-0 px-4 px-sm-0">
                <div class="col col-sm-8 col-lg-10 col-xl-8">
                    <a href="" class="d-flex justify-content-center mb-4">
                        <img src="" alt="" width="60">
                    </a>

                    <div class="card border-0 rounded-3 p-5">
                        @if (session('status') == 'verification-link-sent')
                            <div>
                                Link verifikasi baru telah dikirim ke email kamu.
                            </div>
                        @endif
                        <div class="text-center mb-5">
                            <div class="btn btn-primary mb-3">
                                <i class="bi bi-envelope-check-fill"></i>
                            </div>
                            <h3 class="fw-bold">Verifikasi Email</h3>
                            <p class="text-secondary">Silahkan lihat pesan Email yang terdaftar untuk verifikasi
                                email.
                            </p>
                            <div class="position-relative">
                                <hr class="text-secondary">
                                <div class="divider-content-center">
                                </div>
                            </div>
                            <div class="button-group">
                                <form action="{{ route('verification.send') }}" method="post">
                                    @csrf
                                    <button class="btn btn-primary"><i
                                            class="bi bi-envelope-arrow-up-fill"></i>&nbsp;&nbsp;Kirim
                                        Verifikasi Ulang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
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
