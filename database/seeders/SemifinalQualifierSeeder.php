<?php

namespace Database\Seeders;

use App\Models\Peserta;
use App\Models\SemifinalQualifier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SemifinalQualifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $qualifiedTeams = [
            'poster_paper' => [
                'RESUR-B',
                'TryHard',
                'The Yogis',
                'PRIA SOLO',
                'Kantas',
                'Antah Berantah',
                'CirebonRangers',
                'Pulopet (Pulse Of Petroleum)',
                'Arafah',
                'Carstenz',
                'ArcTherm',
                'Disuapin Ayah',
                'Triofaction',
                'Tuhan Menyertai',
                'BismillahAza',
                'Abbadbidbod',
                'SiSeSa',
                'Geosmart',
                'Lovely Team',
                'KunFayaKun',
            ],
            
            'business_case' => [
                'Intercods',
                'RAM',
                'Yurike',
                'Evermore',
                'DOA IBU',
                'Fantastic Four',
                'Exordium',
                'pengolah gang',
                'Nexuscore',
                'Doa Bapak',
                'QuatroNgaco',
                'Deadliners',
                'Lupa Tutup Pintu',
                'blindbox',
                'KAMADAKASTRAT',
                'Demokrasi',
                'Lentera Energy',
                'Bye Bang',
                'Halo BCC',
                'Kelompok Belajar',
                'Un Poco Loco',
                'Kelompok delapan',
                'Artwork',
                'Slytherin',
                'kt affan masuk podium',
                'Vandhi Teknik',
                'Ello Jangan Lupa Cuci Sepatu',
                'DoltGirls',
                'Laprakin Aja',
                'Viva La Industria',
                'SPR',
                '#200juta',
                'Andik Cantik',
                'PBP TEAM',
                'SherLup',
                'MINIONS',
                'BC-2',
                'Gaptastic',
                'Tim sar',
                'X team',
                'Mafia Migrasi',
                'SOLAR',
                'Sate Fapet',
                'RockBurger',
                'Tormonitor ketua',
                'Eloquent Minds',
            ],
            
            'well_stimulation' => [
                'Biro Jodoh',
                '2-3 Years Dagestan and Forget',
                'Bitter Scar',
                'Gamud',
                'Monster Inc',
                'Sampling Drilling',
                'Ketoprak Cirebon',
                'TENZI',
                'tabolabale',
                'Well, I Guess We Win?',
                'arjaWINangun',
                'Petro Dynamics',
                'mindset singa',
                'basden',
                'Ikan Tenggelam',
                'Kasihpahambos',
                'PetroPros',
                'La Vida 212',
                'Wedhus Boy',
                'Boombayah',
            ],
        ];

        $qualifiedAt = Carbon::create(2026, 2, 27);

        foreach ($qualifiedTeams as $category => $teams) {
            foreach ($teams as $teamName) {
                // Find peserta by team name and category
                $peserta = Peserta::where('nama_tim', $teamName)
                    ->where('kategori', $category)
                    ->where('status_verifikasi', 'verified')
                    ->first();

                if ($peserta) {
                    SemifinalQualifier::create([
                        'peserta_id' => $peserta->id,
                        'competition_category' => $category,
                        'team_name' => $teamName,
                        'qualified_at' => $qualifiedAt,
                    ]);
                    
                    echo "✓ Added {$teamName} to {$category} semifinals\n";
                } else {
                    echo "✗ Team not found: {$teamName} ({$category})\n";
                }
            }
        }

        echo "\n" . SemifinalQualifier::count() . " teams qualified for semifinals\n";
    }
}
