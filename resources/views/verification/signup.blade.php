<!DOCTYPE html>
<html lang="en">

<x-head title="Pendaftaran Akun - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-loading-screen />
    <div class="row vh-100 g-0">
        <div class="col-lg-8 position-relative d-none d-lg-block"
            style="background-image: url('{{ asset('images/home-page.png') }}'); background-size:cover;">
        </div>
        <div class="col-lg-4">
            <div class="row align-items-center justify-content-center h-100 g-0 px-4 px-sm-0">
                <div class="col col-sm-8 col-lg-180 col-xl-">
                    <a href="" class="d-flex justify-content-center mb-4">
                        <img src="" alt="" width="60">
                    </a>
                    <div class="mb-4">
                        <h3 class="fw-bold">Sign Up</h3>
                        <p class="text-secondary">Daftar Akun Jurnal Magang</p>
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('signup') }}" method="POST" id="multiStepForm">
                            @csrf
                            <input type="hidden" name="role" value="user">
                            <div id="step-1">
                                <div class="form-floating mb-3">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap"
                                        required id="nama">
                                    <label>Nama Lengkap</label>
                                    <div class="error-message" id="error-nama"></div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        required id="email">
                                    <label>Email</label>
                                    <div class="error-message" id="error-nama"></div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="nisn" maxlength="10" class="form-control"
                                                placeholder="NISN" required onkeypress="return restrictAlphabets(event)"
                                                id="nisn">
                                            <label>NISN</label>
                                            <div class="error-message" id="error-nama"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="nis" maxlength="4" class="form-control"
                                                placeholder="NIS" required onkeypress="return restrictAlphabets(event)"
                                                id="nis">
                                            <label>NIS</label>
                                            <div class="error-message" id="error-nama"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating">
                                    <input type="password" name="password"
                                        class="form-control form-control-lg fs-6 password-field" placeholder="Password"
                                        required>
                                    <label for="floatingInput">Password</label>
                                    <i class="bi bi-eye toggle-password" style="cursor: pointer;"></i>
                                </div>
                                <div class="justify-content mt-3">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Daftar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="text-start">
                        <small>Sudah mempunyai akun? <a href="{{ route('login') }}">Log in</a> sekarang</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // Toggle Password
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".toggle-password").forEach(function(icon) {
            icon.addEventListener("click", function() {
                const passwordField = this.parentElement.querySelector(".password-field");

                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    this.classList.remove("bi-eye");
                    this.classList.add("bi-eye-slash");
                } else {
                    passwordField.type = "password";
                    this.classList.remove("bi-eye-slash");
                    this.classList.add("bi-eye");
                }
            });
        });
    });

    function restrictAlphabets(e) {
        var input = e.which || e.keycode;
        if ((input >= 48 && input <= 57))
            return true;
        else
            return false;
    }

    function nextStep() {
        document.getElementById('step-1').style.display = 'none';
        document.getElementById('step-2').style.display = 'block';
    }

    function prevStep() {
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-1').style.display = 'block';
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
