<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the peserta dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $kategori = $user->kategori_lomba;
        
        // Get competition config based on user's kategori
        $competition = config("competitions.categories.{$kategori}");
        
        if (!$competition) {
            return redirect()->route('home')->with('error', 'Kategori lomba tidak ditemukan.');
        }

        $payment = config('competitions.payment');

        return view('peserta.dashboard', compact('user', 'competition', 'kategori', 'payment'));
    }
}
