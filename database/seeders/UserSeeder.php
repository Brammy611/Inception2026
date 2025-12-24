<?php

namespace Database\Seeders;

use App\Models\User;
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
            'status_verifikasi' => 'verified',
        ]);

        User::create([
            'nama' => 'Admin Inception 2',
            'email' => 'admin2@inception.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status_verifikasi' => 'verified',
        ]);

        // Create 5 peserta for each kategori lomba (20 total)
        $kategoris = [
            User::KATEGORI_BUSINESS_CASE,
            User::KATEGORI_GEOTHERMAL,
            User::KATEGORI_POSTER_PAPER,
            User::KATEGORI_WELL_STIMULATION,
        ];

        foreach ($kategoris as $kategori) {
            User::factory(5)->kategori($kategori)->create();
        }

        // Create specific test users for each category
        User::create([
            'nama' => 'Peter Suherman',
            'email' => 'peter.bcc@inception.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
            'nama_tim' => 'Inception Team',
            'kategori_lomba' => User::KATEGORI_BUSINESS_CASE,
            'status_verifikasi' => 'pending',
        ]);

        User::create([
            'nama' => 'Peter Suherman',
            'email' => 'peter.gdpc@inception.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
            'nama_tim' => 'Inception Team',
            'kategori_lomba' => User::KATEGORI_GEOTHERMAL,
            'status_verifikasi' => 'verified',
        ]);

        User::create([
            'nama' => 'Peter Suherman',
            'email' => 'peter.ppc@inception.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
            'nama_tim' => 'Inception Team',
            'kategori_lomba' => User::KATEGORI_POSTER_PAPER,
            'status_verifikasi' => 'verified',
        ]);

        User::create([
            'nama' => 'Peter Suherman',
            'email' => 'peter.wsc@inception.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
            'nama_tim' => 'Inception Team',
            'kategori_lomba' => User::KATEGORI_WELL_STIMULATION,
            'status_verifikasi' => 'verified',
        ]);
    }
}
