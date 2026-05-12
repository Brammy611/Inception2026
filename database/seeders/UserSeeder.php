<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FinalQualifier;
use App\Models\Peserta;
use App\Models\SemifinalQualifier;
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
        echo "\n";
        echo "==============================================\n";
        echo "    CREATING 4 TEST USERS FOR EACH CATEGORY  \n";
        echo "==============================================\n\n";

        $testUsers = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.bcc@test.com',
                'tim' => 'Business Innovators',
                'kategori' => Peserta::KATEGORI_BUSINESS_CASE,
                'kategori_display' => 'Business Case Competition',
                'status' => 'verified',
            ],
            [
                'nama' => 'Siti Rahayu',
                'email' => 'siti.gdpc@test.com',
                'tim' => 'Geothermal Warriors',
                'kategori' => Peserta::KATEGORI_GEOTHERMAL,
                'kategori_display' => 'Geothermal Development Plan',
                'status' => 'verified',
            ],
            [
                'nama' => 'Ahmad Wijaya',
                'email' => 'ahmad.ppc@test.com',
                'tim' => 'Poster Creators',
                'kategori' => Peserta::KATEGORI_POSTER_PAPER,
                'kategori_display' => 'Poster and Paper Competition',
                'status' => 'verified',
            ],
            [
                'nama' => 'Dewi Kartika',
                'email' => 'dewi.wsc@test.com',
                'tim' => 'Well Experts',
                'kategori' => Peserta::KATEGORI_WELL_STIMULATION,
                'kategori_display' => 'Well Stimulation Competition',
                'status' => 'verified',
            ],
        ];

        foreach ($testUsers as $index => $testUser) {
            $user = User::create([
                'nama' => $testUser['nama'],
                'email' => $testUser['email'],
                'password' => Hash::make('password123'),
                'role' => 'peserta',
            ]);

            $peserta = Peserta::create([
                'user_id' => $user->id,
                'nama_tim' => $testUser['tim'],
                'nama_leader' => $testUser['nama'],
                'asal_univ' => 'Institut Teknologi Bandung',
                'jurusan_leader' => 'Teknik Perminyakan',
                'nama_member_1' => 'Anggota Pertama',
                'jurusan_member_1' => 'Teknik Geologi',
                'nama_member_2' => 'Anggota Kedua',
                'jurusan_member_2' => 'Teknik Kimia',
                'nama_member_3' => $testUser['kategori'] !== Peserta::KATEGORI_POSTER_PAPER ? 'Anggota Ketiga' : null,
                'jurusan_member_3' => $testUser['kategori'] !== Peserta::KATEGORI_POSTER_PAPER ? 'Teknik Mesin' : null,
                'kategori' => $testUser['kategori'],
                'status_verifikasi' => $testUser['status'],
            ]);

            SemifinalQualifier::updateOrCreate(
                [
                    'peserta_id' => $peserta->id,
                    'competition_category' => $testUser['kategori'],
                ],
                [
                    'team_name' => $testUser['tim'],
                    'qualified_at' => now(),
                ]
            );

            FinalQualifier::updateOrCreate(
                [
                    'peserta_id' => $peserta->id,
                    'competition_category' => $testUser['kategori'],
                ],
                [
                    'team_name' => $testUser['tim'],
                    'qualified_at' => now(),
                ]
            );

            // Display user information
            echo "✓ User #" . ($index + 1) . " Created:\n";
            echo "  ├─ Nama       : " . $testUser['nama'] . "\n";
            echo "  ├─ Email      : " . $testUser['email'] . "\n";
            echo "  ├─ Password   : password123\n";
            echo "  ├─ Tim        : " . $testUser['tim'] . "\n";
            echo "  ├─ Kategori   : " . $testUser['kategori_display'] . "\n";
            echo "  ├─ Universitas: Institut Teknologi Bandung\n";
            echo "  ├─ Status     : " . ucfirst($testUser['status']) . "\n";
            echo "  ├─ Semifinal  : Qualified\n";
            echo "  ├─ Final      : Qualified\n";
            
            if ($testUser['kategori'] === Peserta::KATEGORI_POSTER_PAPER) {
                echo "  └─ Anggota    : 3 orang (Leader + 2 members)\n";
            } else {
                echo "  └─ Anggota    : 4 orang (Leader + 3 members)\n";
            }
            echo "\n";
        }

        echo "==============================================\n";
        echo "  ✓ Successfully created 4 test users!       \n";
        echo "  ✓ Total Users: " . User::count() . " (2 Admin + 24 Random Peserta)      \n";
        echo "==============================================\n\n";
    }
}
