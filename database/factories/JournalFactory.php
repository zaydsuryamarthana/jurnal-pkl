<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journal>
 */
class JournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 4,
            'verifikasi' => $this->faker->randomElement(['sudah', 'belum', 'tolak', 'revisi']),
            'judul' => $this->faker->sentence(mt_rand(3, 7)),
            'isi' => $this->faker->paragraph(mt_rand(5, 15)),
            'tgl' => $this->faker->date(),
            'komentar' => null,
            'foto' => 'foto.jpg',
        ];
    }
}
