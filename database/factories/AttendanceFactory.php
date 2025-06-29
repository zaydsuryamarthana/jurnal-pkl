<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $masuk = Carbon::parse('08:00:00')->addMinutes(rand(0, 30));
        $keluar = Carbon::parse('16:00:00')->subMinutes(rand(0, 30));

        return [
            'user_id' => 4,
            'tgl' => $this->faker->date(),
            'ket' => 'hadir',
            'komentar' => $this->faker->randomElement(['Tepat Waktu', 'Terlambat']),
            'masuk' => $masuk,
            'keluar' => $keluar,
            'foto_masuk' => '1747964075_zayd-surya-marthana_masuk.jpg',
            'foto_keluar' => 'keluar.jpg',
        ];
    }
}
