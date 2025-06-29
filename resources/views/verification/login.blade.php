<!DOCTYPE html>
<html lang="en">

<x-head title="Masuk - Jurnal Magang SMK Islamic Centre Baiturrahman" />

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
                        <h3 class="fw-bold">Log In</h3>
                        <p class="text-secondary">Akses Jurnal Magang</p>
                        <div class="mb-4">
                            <button id="btn-user" class="btn btn-outline-primary btn-sm"
                                onclick="showForm('user')">Siswa</button>
                            <button id="btn-admin" class="btn btn-outline-primary btn-sm"
                                onclick="showForm('admin')">Guru</button>
                        </div>
                        @error('error')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Data tidak cocok!</strong>&nbsp;Silahkan login kembali.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong>&nbsp;Password telah dirubah. Silahkan login.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div id="form-user">
                            <form action="{{ route('authLogin') }}" method="post">
                                @csrf
                                <input type="hidden" name="role" value="user">
                                <div class="form-floating mb-3">
                                    <input type="text" name="nisn" class="form-control form-control-lg fs-6"
                                        placeholder="Nomor Induk Nasional Siswa / NISN" id="floatingInput"
                                        onkeypress="return restrictAlphabets(event)" maxlength="10" required
                                        value="{{ old('nisn') }}">
                                    <label for="floatingInput">Nomor Induk Siswa Nasional / NISN</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" name="password"
                                        class="form-control form-control-lg fs-6 password-field" placeholder="Password"
                                        required autocomplete="off">
                                    <label for="floatingInput">Password</label>
                                    <i class="bi bi-eye toggle-password" style="cursor: pointer;"></i>
                                </div>

                                <div class="mt-3 mb-3">
                                    <small>Lupa password? <a href="/forgot-password">Klik disini</a></small>
                                </div>
                                <button class="btn btn-primary btn-lg w-100" name="login"
                                    type="submit">Masuk</button>
                            </form>
                            <div class="mt-4">
                                <small>Tidak mempunyai akun? <a href="signup">Sign up</a> secara
                                    manual</small>
                            </div>
                        </div>
                        <div id="form-admin" class="d-none">
                            <form action="{{ route('authLogin') }}" method="post">
                                @csrf
                                <input type="hidden" name="role" value="admin">
                                <div class="form-floating mb-3">
                                    <input type="text" name="niy" class="form-control form-control-lg fs-6"
                                        placeholder="Nomor Induk Yayasan" id="floatingInput"
                                        onkeypress="return restrictAlphabets(event)" maxlength="5" required
                                        value="{{ old('niy') }}">
                                    <label for="floatingInput">Nomor Induk Yayasan / NIY</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" name="password"
                                        class="form-control form-control-lg fs-6 password-field" placeholder="Password"
                                        required>
                                    <label for="floatingInput">Password</label>
                                    <i class="bi bi-eye toggle-password" style="cursor: pointer;"
                                        autocomplete="off"></i>
                                </div>
                                <div class="mt-3 mb-3">
                                    <small>Lupa password? <a href="/forgot-password">Klik disini</a></small>
                                </div>
                                <button class="btn btn-primary btn-lg w-100" name="login"
                                    type="submit">Masuk</button>
                            </form>
                            <div class="mt-4">
                                <small>Butuh bantuan? <a href="signup">Hubungi</a> admin secara
                                    langsung</small>
                            </div>
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
    function showForm(role) {
        localStorage.setItem('selectedRole', role);

        document.getElementById('form-user').classList.add('d-none');
        document.getElementById('form-admin').classList.add('d-none');
        document.getElementById(`form-${role}`).classList.remove('d-none');

        const btnUser = document.getElementById('btn-user');
        const btnAdmin = document.getElementById('btn-admin');

        btnUser.classList.remove('btn-primary');
        btnUser.classList.add('btn-outline-primary');

        btnAdmin.classList.remove('btn-primary');
        btnAdmin.classList.add('btn-outline-primary');

        if (role === 'user') {
            btnUser.classList.remove('btn-outline-primary');
            btnUser.classList.add('btn-primary');
        } else if (role === 'admin') {
            btnAdmin.classList.remove('btn-outline-primary');
            btnAdmin.classList.add('btn-primary');
        }
    }

    // Saat halaman dimuat ulang, jalankan kembali showForm berdasarkan localStorage
    window.onload = function() {
        const savedRole = localStorage.getItem('selectedRole') || 'user'; // default user
        showForm(savedRole);
    }

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
