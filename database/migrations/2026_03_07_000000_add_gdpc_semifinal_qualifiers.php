<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Peserta;
use App\Models\SemifinalQualifier;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $gdpcTeams = [
            'Antareja',
            'Welldone Team',
            'Grafik Emas',
            'OTW SEMARANG',
            'Geo-X',
            'Aswaja 2',
            'Geothermics',
            'Raja Firngawi',
            'Bismuth',
            'Meraki',
            'Membles',
            'Tranquil',
            'Titipan Solo',
            'Caldera Queens',
            'HOT!!!',
        ];

        $qualifiedAt = Carbon::create(2026, 2, 27);

        foreach ($gdpcTeams as $teamName) {
            // Find peserta by team name and geothermal category
            $peserta = Peserta::where('nama_tim', $teamName)
                ->where('kategori', 'geothermal')
                ->where('status_verifikasi', 'verified')
                ->first();

            if ($peserta) {
                SemifinalQualifier::updateOrCreate(
                    [
                        'peserta_id' => $peserta->id,
                        'competition_category' => 'geothermal',
                    ],
                    [
                        'team_name' => $teamName,
                        'qualified_at' => $qualifiedAt,
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $gdpcTeams = [
            'Antareja',
            'Welldone Team',
            'Grafik Emas',
            'OTW SEMARANG',
            'Geo-X',
            'Aswaja 2',
            'Geothermics',
            'Raja Firngawi',
            'Bismuth',
            'Meraki',
            'Membles',
            'Tranquil',
            'Titipan Solo',
            'Caldera Queens',
            'HOT!!!',
        ];

        // Remove GDPC semifinal qualifiers
        SemifinalQualifier::where('competition_category', 'geothermal')
            ->whereIn('team_name', $gdpcTeams)
            ->delete();
    }
};
