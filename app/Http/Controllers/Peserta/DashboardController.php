<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Show the peserta dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $peserta = $user->peserta;
        
        // If user hasn't completed registration, redirect to registration form
        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        $kategori = $peserta->kategori;
        
        // Get competition config based on peserta's kategori
        $competition = config("competitions.categories.{$kategori}");
        
        if (!$competition) {
            return redirect()->route('home')->with('error', 'Kategori lomba tidak ditemukan.');
        }

        $payment = config('competitions.payment');

        return view('peserta.dashboard', compact('user', 'peserta', 'competition', 'kategori', 'payment'));
    }

    /**
     * Show the registration form for peserta.
     */
    public function showRegisterForm()
    {
        $user = auth()->user();
        
        // If user already has peserta record, redirect to dashboard
        if ($user->peserta) {
            return redirect()->route('peserta.dashboard');
        }

        $kategoriOptions = Peserta::getKategoriOptions();

        return view('peserta.register', compact('user', 'kategoriOptions'));
    }

    /**
     * Store a new peserta registration.
     */
    public function register(Request $request)
    {
        $user = auth()->user();
        
        // If user already has peserta record, redirect to dashboard
        if ($user->peserta) {
            return redirect()->route('peserta.dashboard');
        }

        $request->validate([
            'nama_tim' => ['required', 'string', 'max:255'],
            'nama_leader' => ['required', 'string', 'max:255'],
            'asal_univ' => ['required', 'string', 'max:255'],
            'jurusan_leader' => ['required', 'string', 'max:255'],
            'nama_member_1' => ['required', 'string', 'max:255'],
            'jurusan_member_1' => ['required', 'string', 'max:255'],
            'nama_member_2' => ['nullable', 'string', 'max:255'],
            'jurusan_member_2' => ['nullable', 'string', 'max:255', 'required_with:nama_member_2'],
            'kategori' => ['required', 'in:business_case,geothermal,poster_paper,well_stimulation'],
            'ktm' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'follow_ig' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'share_poster' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'payment' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        // Store files
        $ktmPath = $request->file('ktm')->store('peserta/ktm', 'public');
        $followIgPath = $request->file('follow_ig')->store('peserta/follow_ig', 'public');
        $sharePosterPath = $request->file('share_poster')->store('peserta/share_poster', 'public');
        $paymentPath = $request->file('payment')->store('peserta/payment', 'public');

        Peserta::create([
            'user_id' => $user->id,
            'nama_tim' => $request->nama_tim,
            'nama_leader' => $request->nama_leader,
            'asal_univ' => $request->asal_univ,
            'jurusan_leader' => $request->jurusan_leader,
            'nama_member_1' => $request->nama_member_1,
            'jurusan_member_1' => $request->jurusan_member_1,
            'nama_member_2' => $request->nama_member_2,
            'jurusan_member_2' => $request->jurusan_member_2,
            'kategori' => $request->kategori,
            'ktm' => $ktmPath,
            'follow_ig' => $followIgPath,
            'share_poster' => $sharePosterPath,
            'payment' => $paymentPath,
            'status_verifikasi' => 'pending',
        ]);

        return redirect()->route('peserta.dashboard')->with('success', 'Pendaftaran berhasil! Menunggu verifikasi admin.');
    }

    /**
     * Update peserta documents.
     */
    public function updateDocuments(Request $request)
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        $request->validate([
            'ktm' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'follow_ig' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'share_poster' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'payment' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $updateData = [];

        if ($request->hasFile('ktm')) {
            // Delete old file
            if ($peserta->ktm) {
                Storage::disk('public')->delete($peserta->ktm);
            }
            $updateData['ktm'] = $request->file('ktm')->store('peserta/ktm', 'public');
        }

        if ($request->hasFile('follow_ig')) {
            if ($peserta->follow_ig) {
                Storage::disk('public')->delete($peserta->follow_ig);
            }
            $updateData['follow_ig'] = $request->file('follow_ig')->store('peserta/follow_ig', 'public');
        }

        if ($request->hasFile('share_poster')) {
            if ($peserta->share_poster) {
                Storage::disk('public')->delete($peserta->share_poster);
            }
            $updateData['share_poster'] = $request->file('share_poster')->store('peserta/share_poster', 'public');
        }

        if ($request->hasFile('payment')) {
            if ($peserta->payment) {
                Storage::disk('public')->delete($peserta->payment);
            }
            $updateData['payment'] = $request->file('payment')->store('peserta/payment', 'public');
        }

        if (!empty($updateData)) {
            $peserta->update($updateData);
        }

        return redirect()->route('peserta.dashboard')->with('success', 'Dokumen berhasil diperbarui!');
    }
}
