<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerTalkRegistration;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Career Talk Statistics
        $careerTalkStats = [
            'total' => CareerTalkRegistration::count(),
            'confirmed' => CareerTalkRegistration::where('status', 'confirmed')->count(),
            'pending' => CareerTalkRegistration::where('status', 'pending')->count(),
        ];

        // Competition Statistics
        $competitionStats = [
            'total' => Peserta::count(),
            'verified' => Peserta::where('status_verifikasi', 'verified')->count(),
            'pending' => Peserta::where('status_verifikasi', 'pending')->count(),
            'rejected' => Peserta::where('status_verifikasi', 'rejected')->count(),
        ];

        // Competition by Category
        $competitionByCategory = [
            'business_case' => Peserta::where('kategori', 'business_case')->count(),
            'geothermal' => Peserta::where('kategori', 'geothermal')->count(),
            'poster_paper' => Peserta::where('kategori', 'poster_paper')->count(),
            'well_stimulation' => Peserta::where('kategori', 'well_stimulation')->count(),
        ];

        // Registration Trend (Last 7 days)
        $registrationTrend = $this->getRegistrationTrend();

        // Recent Registrations
        $recentCareerTalk = CareerTalkRegistration::latest()->take(5)->get();
        $recentCompetition = Peserta::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'careerTalkStats',
            'competitionStats',
            'competitionByCategory',
            'registrationTrend',
            'recentCareerTalk',
            'recentCompetition'
        ));
    }

    private function getRegistrationTrend()
    {
        $days = [];
        $careerTalkData = [];
        $competitionData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $days[] = now()->subDays($i)->format('M d');
            
            $careerTalkData[] = CareerTalkRegistration::whereDate('created_at', $date)->count();
            $competitionData[] = Peserta::whereDate('created_at', $date)->count();
        }

        return [
            'labels' => $days,
            'careerTalk' => $careerTalkData,
            'competition' => $competitionData,
        ];
    }
}
