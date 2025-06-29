<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InternshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('internships')->insert([
            [
                'id' => 1,
                'dudika' => 'Inova Computer',
                'alamat' => 'Jl. Kelud Raya No.1, Bendan, Kec. Gajahmungkur, Kota Semarang, Jawa Tengah 50244',
                'deskripsi' => '',
                'foto' => 'inova-computer.jpg',
                'map' => 'https://maps.app.goo.gl/gvfFA8pdBbpD2g5PA',
            ],
            [
                'id' => 2,
                'dudika' => 'Etalase Komputer',
                'alamat' => 'Jl. Menoreh Tim. No.32b, RT.01/RW.04, Sampangan, Kec. Gajahmungkur, Kota Semarang, Jawa Tengah 50236',
                'deskripsi' => null,
                'foto' => 'etalase-komputer.jpg',
                'map' => 'https://maps.app.goo.gl/N9Q9qpvVQxooN9AX9',
            ],
            [
                'id' => 3,
                'dudika' => 'Semarang Mackbook',
                'alamat' => 'Jl. Ngesrep Tim. V No.21, Sumurboto, Kec. Banyumanik, Kota Semarang, Jawa Tengah 50269',
                'deskripsi' => null,
                'foto' => 'semarang-mackbook.jpg',
                'map' => 'https://maps.app.goo.gl/ZPtD6Rm2M4xfka9B7',
            ],
            [
                'id' => 4,
                'dudika' => 'Jujung Net',
                'alamat' => 'Jl. Badak V, Pandean Lamper, Kec. Gayamsari, Kota Semarang, Jawa Tengah 50249',
                'deskripsi' => null,
                'foto' => 'jujung-net.jpg',
                'map' => 'https://maps.app.goo.gl/yxkriHRgUwACWYem8',
            ],
            [
                'id' => 5,
                'dudika' => 'Top Computer',
                'alamat' => 'Jl. Erlangga Timur No.11, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50241',
                'deskripsi' => null,
                'foto' => 'top-computer.jpg',
                'map' => 'https://maps.app.goo.gl/YiEaLnxq3eX7xPkMA',
            ],
            [
                'id' => 6,
                'dudika' => 'Icon Plus',
                'alamat' => 'Jl. Setia Budi No.96, Srondol Kulon, Kec. Banyumanik, Kota Semarang, Jawa Tengah 50263',
                'deskripsi' => null,
                'foto' => 'icon-plus.jpg',
                'map' => 'https://maps.app.goo.gl/J1G4a2CCjKGjDqBY6',
            ],
            [
                'id' => 7,
                'dudika' => 'AHT Komputer',
                'alamat' => 'W9WV+FXR, Jl. Taman Siswa, Sekaran, Kec. Gn. Pati, Kota Semarang, Jawa Tengah 50229',
                'deskripsi' => null,
                'foto' => 'aht-computer.jpg',
                'map' => 'https://maps.app.goo.gl/bPdWXbETcbfpVKY8A',
            ],
            [
                'id' => 8,
                'dudika' => 'PDAM Tirta Moedal Kota Semarang',
                'alamat' => 'Jl. Kelud Raya No.60, Petompon, Kec. Gajahmungkur, Kota Semarang, Jawa Tengah 50237',
                'deskripsi' => null,
                'foto' => 'pdam.jpg',
                'map' => 'https://maps.app.goo.gl/3QGtuhg5Zd3DWvVh6',
            ],
            [
                'id' => 9,
                'dudika' => 'RRI Semarang',
                'alamat' => 'Jl. Ahmad Yani No.144-146, Karangkidul, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50136',
                'deskripsi' => null,
                'foto' => 'rri-semarang.jpg',
                'map' => 'https://maps.app.goo.gl/GUZ9ZpWBFNk12JS47',
            ],
            [
                'id' => 10,
                'dudika' => 'BPTIK',
                'alamat' => 'Jl. Tarupolo Tengah No.7, Gisikdrono, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50149',
                'deskripsi' => null,
                'foto' => 'bptik.jpg',
                'map' => 'https://maps.app.goo.gl/SNUxW1Rc1j2iqEji6',
            ],
            [
                'id' => 11,
                'dudika' => 'Nexa',
                'alamat' => 'Jl. Jangli Dalam No.29J, Jatingaleh, Kec. Candisari, Kota Semarang, Jawa Tengah 50254',
                'deskripsi' => null,
                'foto' => 'nexa.jpg',
                'map' => 'https://maps.app.goo.gl/Y5oc6LT33LLf6wTcA',
            ],
            [
                'id' => 12,
                'dudika' => 'WAB Komputer',
                'alamat' => 'Jl. Purwoyoso 1C No.19, Purwoyoso, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50184',
                'deskripsi' => null,
                'foto' => 'wab-komputer.jpg',
                'map' => 'https://maps.app.goo.gl/AaGm73DLFdrrzkev8',
            ],
            [
                'id' => 13,
                'dudika' => 'Joglosemar CCTV',
                'alamat' => 'Ruko Sam Poo Kong Ngemplak, Jl. Simongan Raya No.68A, Semarang Barat, Ngemplak Simongan, Semarang, Ngemplak Simongan, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50148',
                'deskripsi' => null,
                'foto' => 'joglosemar.jpg',
                'map' => 'https://maps.app.goo.gl/rLBcMXh1GhBoHTS36',
            ],
            [
                'id' => 14,
                'dudika' => 'PT Mitra Kencana',
                'alamat' => 'Tlogosari',
                'deskripsi' => null,
                'foto' => 'mitra-kencana.jpg',
                'map' => null,
            ],
        ]);
    }
}
