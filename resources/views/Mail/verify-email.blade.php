<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Verifikasi Email</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/smk.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <style>
        /* Reset default */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        .container {
            max-width: 960px;
            margin: 50px auto;
            padding: 0 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
            justify-content: center;
        }

        .col-lg-7 {
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
            padding: 30px 50px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .mt-5 {
            margin-top: 3rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        table th,
        table td {
            padding: 10px 12px;
            text-align: left;
            vertical-align: top;
        }

        table th {
            width: 30%;
            font-weight: 600;
        }

        a {
            color: #0d6efd;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn {
            background-color: #0d6efd;
            color: white;
            padding: 10px;
            border-radius: 5px;
            width: auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <img src="{{ asset('images/smkicb.png') }}" class="img-fluid" style="width: 10%;" alt="Logo SMK">
            </div>
            <div class="col-lg-7 mt-5 text-start">
                <h4 class="mb-4 fw-bold">Pendaftaran akun Jurnal Magang SMK Islamic Centre Baiturrahman</h4>
                <p>
                    Anda telah melakukan pendaftaran akun Jurnal Magang. Detail akun Anda akan terlampir di bawah ini,
                    dan segera lakukan verifikasi email.
                </p>


                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 150px;">NISN</th>
                            <td>{{ $user->nisn }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nama Lengkap</th>
                            <td>{{ $user->nama }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Link Aktivasi</th>
                            <td><a href="{{ $verificationUrl }}">Aktifkan akun Jurnal Magang</a></td>
                        </tr>
                    </tbody>
                </table>

                <p class="mt-3">Jika Anda tidak merasa membuat akun Jurnal Magang, abaikan saja email ini.</p>
            </div>
        </div>
    </div>
</body>

</html>
