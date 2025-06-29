<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Daftar Kehadiran Jurnal Magang</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header .school-name {
            font-size: 12px;
            font-weight: bold;
        }

        .header .ornament {
            font-style: italic;
            color: gray;
        }

        .headline {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .name-card {
            margin-bottom: 10px;
        }

        .name-card label {
            font-weight: bold;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            text-align: center;
            padding: 5px;
            font-size: 11px;
        }

        .footer {
            text-align: right;
            font-size: 10px;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="school-name">SMK Islamic Centre Baiturrahman</div>
        <div class="ornament"> <button onclick="window.print()">🖨️ Cetak Halaman</button></div>
    </div>

    <div class="headline">
        PRESENSI KEHADIRAN SISWA PKL DI {{ Str::upper($user->internship->dudika ?? 'Belum Terdaftar') }}
    </div>

    <div class="name-card">
        <label>Nama Siswa:</label> <span>{{ $user->nama }}</span>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Nomor</th>
                    <th rowspan="2">Hari Tanggal</th>
                    <th colspan="2">Jam Kerja</th>
                    <th rowspan="2">Ket Tidak Hadir</th>
                    <th rowspan="2">Dokumentasi</th>
                </tr>
                <tr>
                    <th>Datang</th>
                    <th>Pulang</th>
                </tr>
            </thead>
            <tbody>
                <!-- Baris data absensi akan digenerate oleh backend -->
                @forelse ($attendances as $no => $data)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->tgl)->locale('id')->translatedFormat('l, d F Y') }}</td>
                        <td>
                            @if ($data->masuk)
                                {{ \Carbon\Carbon::parse($data->masuk)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($data->keluar)
                                {{ \Carbon\Carbon::parse($data->keluar)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($attendances)
                                -
                            @else
                                Tidak Berangkat
                            @endif
                        </td>
                        <td><img src="{{ asset('storage/user/attendance/' . $safe . '/' . $data->foto_masuk) }}"
                                alt="" style="max-width: 60px; height: auto; object-fit: contain;">
                        </td>
                    @empty
                        <td>- Tidak ada data -</td>
                    </tr>
                @endforelse

                <!-- Tambahkan baris lainnya sesuai kebutuhan -->
            </tbody>
        </table>
    </div>
    <div class="footer">
        Halaman:
    </div>
</body>

</html>
