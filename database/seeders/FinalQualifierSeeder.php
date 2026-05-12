<?php

namespace Database\Seeders;

use App\Models\FinalQualifier;
use App\Models\Peserta;
use Illuminate\Database\Seeder;

class FinalQualifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $finalTeams = [
            ['team_name' => 'Business Innovators', 'category' => 'business_case'],
            ['team_name' => 'Geothermal Warriors', 'category' => 'geothermal'],
            ['team_name' => 'Poster Creators', 'category' => 'poster_paper'],
            ['team_name' => 'Well Experts', 'category' => 'well_stimulation'],
        ];

        foreach ($finalTeams as $team) {
            $peserta = Peserta::where('nama_tim', $team['team_name'])
                ->where('kategori', $team['category'])
                ->first();

            if (!$peserta) {
                continue;
            }

            FinalQualifier::updateOrCreate(
                [
                    'peserta_id' => $peserta->id,
                    'competition_category' => $team['category'],
                ],
                [
                    'team_name' => $team['team_name'],
                    'qualified_at' => now(),
                ]
            );
        }
    }
}
