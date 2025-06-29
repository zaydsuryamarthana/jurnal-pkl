<!DOCTYPE html>
<html lang="en">
<x-head title="Reset Password - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-loading-screen />
    <div class="row vh-100 g-0">
        <div class="col-lg-8 position-relative d-none d-lg-block"
            style="background-image: url('{{ asset('images/home-page.png') }}'); background-size:cover;">
        </div>
        <div class="col-lg-4">
            <div class="row align-items-center justify-content-center h-100 g-0 px-4 px-sm-0">
                <div class="col col-sm-6 col-lg-10 col-xl-8">
                    <a href="" class="d-flex justify-content-center mb-4">
                        <img src="" alt="" width="60">
                    </a>
                    <div class="mb-5">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <h3 class="fw-bold">Reset Password Account</h3>
                        <p class="text-secondary">Reset password akun Jurnal Magang</p>
                        <form action="/reset-password" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control form-control-lg fs-6"
                                    placeholder="Masukkan Email" id="floatingInput" value="{{ request('email') }}"
                                    required>
                                <label for="floatingInput">Email Address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control form-control-lg fs-6"
                                    placeholder="Masukkan Password" id="floatingInput" required>
                                <label for="floatingInput">Password Baru</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password_confirmation"
                                    class="form-control form-control-lg fs-6" placeholder="Masukkan Konfirmasi Password"
                                    id="floatingInput" required>
                                <label for="floatingInput">Konfirmasi Password</label>
                            </div>
                            <input type="hidden" name="token" required class="form-control" id="token"
                                value="{{ $token }}">
                            <button class="btn btn-primary btn-lg w-100" name="verifikasi" type="submit">Kirim
                                Verifikasi</button>
                        </form>
                        <div class="mt-4">
                            <small>Sudah reset akun?&nbsp;<a href="verification/login">Login</a> sekarang juga.</small>
                        </div>
                        <!---- <button class="btn btn-outline-secondary w-100 mb-3">
                            <i class="bi bi-telephone-inbound-fill"></i>&nbsp;&nbsp;Hubungi Admin
                        </button> -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
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

    function myFunction() {
        let pwicon = document.getElementById("togglePassword");
        if (pwicon.type === "password") {
            pwicon.type = "text";
        } else {
            pwicon.type = "password";
        }
    }

    function restrictAlphabets(e) {
        var input = e.which || e.keycode;
        if ((input >= 48 && input <= 57))
            return true;
        else
            return false;
    }
</script>

</html>
