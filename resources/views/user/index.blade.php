<!DOCTYPE html>
<html lang="en">

<x-head title="Beranda - Jurnal Magang SMK Islamic Centre Baiturrahman" />

<body>
    <x-loading-screen />
    <x-navbar />
    <div class="container">
        <section>

            <div class="container">
                @if (auth()->user()->verification);
                    <div class="col-lg-12 mt-5 mb-4 message">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Verifikasi Data Berhasil</strong>&nbsp;Silahkan gunakan akun Jurnal Magang.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="row vh-100">
                        <div class="col-lg-8 left-data-side">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="headline-body-data">
                                <div class="text-primary display-1">Selesaikan Tahap</div>
                                <div class="text-primary display-1">Verifikasi</div>
                            </div>
                            <div class="text-body-data">
                                <p>Lengkapi data verifikasi untuk mengakses Jurnal Magang
                                </p>
                            </div>
                            <div class="form-body">
                                <form action="/beranda/verify" method="post" enctype="multipart/form-data"
                                    class="text-secondary">
                                    @csrf
                                    <div class="mb-3 ">
                                        <label for="">Masukkan NISN</label>
                                        <input type="text" class="form-control" placeholder="Masukkan NISN" readonly
                                            name="nisn" value="{{ $user->nisn }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Nama Lengkap</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap"
                                            readonly name="nama" value="{{ $user->nama }}">
                                    </div>
                                    <div class="mb-3 select-option">
                                        <label for="">Pilih Guru Pembimbing</label>
                                        <select name="admin_id" id="" class="form-control" required>
                                            <option value="" selected disabled> - </option>
                                            @foreach ($admins as $pembimbing)
                                                <option value="{{ $pembimbing->id }}">{{ $pembimbing->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 select-option">
                                        <label for="">Pilih Tempat PKL</label>
                                        <select name="internship_id" id="" class="form-control" required>
                                            <option value="" selected disabled> - </option>
                                            @foreach ($internships as $internship)
                                                <option value="{{ $internship->id }}">{{ $internship->dudika }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="file-drop-area border-primary mb-5 select-option" id="drop-area">
                                        <p class="mb-3 text-secondary">Surat Pernyataan Siswa PKL</p>
                                        <input type="file" id="fileInput" class="form-control d-none" name="file"
                                            required accept=".pdf,.docx,.jpg,.png">
                                        <button type="button" class="btn btn-outline-primary w-100 mb-2"
                                            onclick="document.getElementById('fileInput').click()">Pilih File</button>
                                        <div id="filePreview" class="mb-0" style="display: none;">
                                            <div
                                                class="alert alert-primary d-flex justify-content-between align-items-center">
                                                <span id="fileName"></span>
                                                <button class="btn btn-sm btn-danger" onclick="removeFile()"><i
                                                        class="bi bi-trash-fill"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-5">Simpan Data</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 right-data-side">
                            <div class="container bg-primary h-100">
                                <div class="px-4 text-white bg-information" style="padding-top:180px;">
                                    <div class="headline-text">
                                        <h2><b><i class="bi bi-check2-circle"></i>&nbsp;&nbsp;Verifikasi Data</b>
                                        </h2>
                                    </div>
                                    <div class="body-text">
                                        <p class="subtitle">Ikuti langkah-langkah verifikasi data untuk mengakses
                                            Jurnal
                                            Magang</p>
                                        <ol class="list-group-numbered" style=" margin-left:-30px;">
                                            <li class="list-group-item mb-3">Setelah <b>login</b>, Anda akan
                                                memasuki
                                                halaman
                                                verfikasi data untuk menjelaskan Syarat & Ketentuan yang berlaku.
                                            </li>
                                            <li class="list-group-item mb-3">Siswa diharapkan mengisikan beberapa
                                                formulir
                                                yaitu
                                                verifikasi <b>Surat Pernyataan Siswa PKL</b> yang sudah disediakan
                                                oleh
                                                Jurnal Magang.</li>
                                            <li class="list-group-item mb-3">Download file Surat Pernyataan Siswa
                                                PKL
                                            </li>
                                            <div class="download gap-5 mb-4">
                                                <a href="{{ asset('storage/surat_pernyataan_tkj.pdf') }}"
                                                    target="_blank" class="btn text-primary me-2"
                                                    style="background: white !important;"><i
                                                        class="bi bi-arrow-down-circle-fill"></i>&nbsp;&nbsp;Surat
                                                    TJKT</a>
                                                <a href="{{ asset('storage/surat_pernyataan_ps.pdf') }}" target="_blank"
                                                    class="btn text-primary" style="background: white !important;"><i
                                                        class="bi bi-arrow-down-circle-fill"></i>&nbsp;&nbsp;Surat
                                                    PS</a>
                                            </div>
                                            <li class="list-group-item mb-3">Setelah terisikan semuanya, silahkan
                                                <b>
                                                    scan</b>
                                                surat tersebut dan upload ke dalam sistem.
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
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
    // Ambil waktu awal dari server, parsing ke Date object
    let timeParts = "{{ $serverTime }}".split(':');
    let date = new Date();
    date.setHours(parseInt(timeParts[0]));
    date.setMinutes(parseInt(timeParts[1]));
    date.setSeconds(parseInt(timeParts[2]));

    function updateClock() {
        date.setSeconds(date.getSeconds() + 1);

        let h = String(date.getHours()).padStart(2, '0');
        let m = String(date.getMinutes()).padStart(2, '0');
        let s = String(date.getSeconds()).padStart(2, '0');

        document.getElementById('clock').textContent = `${h}:${m}:${s}`;
    }

    setInterval(updateClock, 1000);


    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileNameDisplay = document.getElementById('fileName');

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('bg-light');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('bg-light');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('bg-light');
        fileInput.files = e.dataTransfer.files;
        showFile();
    });

    fileInput.addEventListener('change', showFile);

    function showFile() {
        const file = fileInput.files[0];
        if (file) {
            fileNameDisplay.textContent = file.name;
            filePreview.style.display = 'block';
        }
    }

    function removeFile() {
        fileInput.value = '';
        filePreview.style.display = 'none';
    }
</script>

</html>
