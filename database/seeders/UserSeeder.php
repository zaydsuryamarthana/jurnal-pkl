<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nisn' => null,
                'niy' => '08008',
                'nip' => null,
                'role' => 'admin',
                'password' => Hash::make('missgaluh'),
                'nis' => null,
                'nama' => 'Galuh Utami, S.Pd',
                'jk' => 'p',
                'kelas' => null,
                'jurusan' => null,
                'email' => 'admin@example.com',
                'telp' => '08123456789',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nisn' => null,
                'niy' => '08016',
                'nip' => null,
                'role' => 'admin',
                'password' => Hash::make('pakvulat'),
                'nis' => null,
                'nama' => 'Vulat Ariyanto, S.Pd',
                'jk' => 'p',
                'kelas' => null,
                'jurusan' => null,
                'email' => 'admin2@example.com',
                'telp' => '08123456789',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nisn' => null,
                'niy' => '08011',
                'nip' => null,
                'role' => 'admin',
                'password' => Hash::make('pakriyanto'),
                'nis' => null,
                'nama' => 'Riyanto, S.Kom',
                'jk' => 'p',
                'kelas' => null,
                'jurusan' => null,
                'email' => 'admin3@example.com',
                'telp' => '08123456789',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nisn' => '1234567890',
                'niy' => null,
                'nip' => null,
                'role' => 'user',
                'password' => Hash::make('zaydsurya'),
                'nis' => '1111',
                'nama' => 'Zayd Surya Marthana',
                'jk' => 'l',
                'kelas' => 'xii',
                'jurusan' => 'tkj',
                'email' => 'example@gmail.com',
                'telp' => '08123456789',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
