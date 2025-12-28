<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Peserta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 2 admin users
        User::create([
            'nama' => 'Admin Inception',
            'email' => 'admin@inception.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Admin Inception 2',
            'email' => 'admin2@inception.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create peserta users with their peserta data
        $kategoris = [
            Peserta::KATEGORI_BUSINESS_CASE,
            Peserta::KATEGORI_GEOTHERMAL,
            Peserta::KATEGORI_POSTER_PAPER,
            Peserta::KATEGORI_WELL_STIMULATION,
        ];

        // Create 5 peserta for each kategori lomba (20 total)
        foreach ($kategoris as $kategori) {
            for ($i = 0; $i < 5; $i++) {
                $user = User::create([
                    'nama' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'password' => Hash::make('password'),
                    'role' => 'peserta',
                ]);

                Peserta::create([
                    'user_id' => $user->id,
                    'nama_tim' => fake()->company(),
                    'nama_leader' => $user->nama,
                    'asal_univ' => fake()->randomElement(['Universitas Indonesia', 'ITB', 'UGM', 'ITS', 'Undip']),
                    'jurusan_leader' => fake()->randomElement(['Teknik Perminyakan', 'Teknik Geologi', 'Teknik Kimia', 'Teknik Mesin']),
                    'nama_member_1' => fake()->name(),
                    'jurusan_member_1' => fake()->randomElement(['Teknik Perminyakan', 'Teknik Geologi', 'Teknik Kimia', 'Teknik Mesin']),
                    'nama_member_2' => fake()->optional(0.7)->name(),
                    'jurusan_member_2' => fake()->optional(0.7)->randomElement(['Teknik Perminyakan', 'Teknik Geologi', 'Teknik Kimia', 'Teknik Mesin']),
                    'kategori' => $kategori,
                    'status_verifikasi' => fake()->randomElement(['pending', 'verified']),
                ]);
            }
        }

        // Create specific test users for each category
        $testUsers = [
            [
                'nama' => 'Peter Suherman',
                'email' => 'peter.bcc@inception.com',
                'kategori' => Peserta::KATEGORI_BUSINESS_CASE,
                'status' => 'pending',
            ],
            [
                'nama' => 'Peter Suherman',
                'email' => 'peter.gdpc@inception.com',
                'kategori' => Peserta::KATEGORI_GEOTHERMAL,
                'status' => 'verified',
            ],
            [
                'nama' => 'Peter Suherman',
                'email' => 'peter.ppc@inception.com',
                'kategori' => Peserta::KATEGORI_POSTER_PAPER,
                'status' => 'verified',
            ],
            [
                'nama' => 'Peter Suherman',
                'email' => 'peter.wsc@inception.com',
                'kategori' => Peserta::KATEGORI_WELL_STIMULATION,
                'status' => 'verified',
            ],
        ];

        foreach ($testUsers as $testUser) {
            $user = User::create([
                'nama' => $testUser['nama'],
                'email' => $testUser['email'],
                'password' => Hash::make('password'),
                'role' => 'peserta',
            ]);

            Peserta::create([
                'user_id' => $user->id,
                'nama_tim' => 'Inception Team',
                'nama_leader' => $testUser['nama'],
                'asal_univ' => 'Universitas Indonesia',
                'jurusan_leader' => 'Teknik Perminyakan',
                'nama_member_1' => 'Member One',
                'jurusan_member_1' => 'Teknik Geologi',
                'nama_member_2' => 'Member Two',
                'jurusan_member_2' => 'Teknik Kimia',
                'kategori' => $testUser['kategori'],
                'status_verifikasi' => $testUser['status'],
            ]);
        }
    }
}
