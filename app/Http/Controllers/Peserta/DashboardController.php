<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\FinalPayment;
use App\Models\Peserta;
use App\Models\Notification;
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

        // Get submission config and existing submissions
        $submissionConfig = config("submissions.categories.{$kategori}");
        
        // Filter requirements by active stages
        if ($submissionConfig) {
            $activeStages = config('submissions.active_stages', ['preliminary']);
            $submissionConfig['requirements'] = array_filter(
                $submissionConfig['requirements'] ?? [],
                function ($requirement) use ($activeStages) {
                    return in_array($requirement['stage'], $activeStages);
                }
            );
        }
        
        $existingSubmissions = $peserta->submissions()
            ->get()
            ->keyBy(function ($item) {
                return $item->submission_type . '_' . $item->stage;
            });

        // Get semifinal information
        $semifinalQualifier = $peserta->semifinalQualifier;
        $semifinalPayment = $peserta->semifinalPayment;
        $finalQualifier = $peserta->finalQualifier;
        $finalPayment = $peserta->finalPayment;

        return view('peserta.dashboard', compact(
            'user', 
            'peserta', 
            'competition', 
            'kategori', 
            'payment', 
            'submissionConfig', 
            'existingSubmissions',
            'semifinalQualifier',
            'semifinalPayment',
            'finalQualifier',
            'finalPayment'
        ));
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

        // Base validation rules
        $rules = [
            'nama_tim' => ['required', 'string', 'max:255'],
            'nama_leader' => ['required', 'string', 'max:255'],
            'asal_univ' => ['required', 'string', 'max:255'],
            'jurusan_leader' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:business_case,geothermal,poster_paper,well_stimulation'],
            'ktm' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'follow_ig' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'share_poster' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'payment' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ];

        // Dynamic member validation based on category
        if ($request->kategori === 'poster_paper') {
            // Poster Paper: min 2 (leader + 1), max 3 (leader + 2)
            $rules['nama_member_1'] = ['nullable', 'string', 'max:255'];
            $rules['jurusan_member_1'] = ['nullable', 'string', 'max:255', 'required_with:nama_member_1'];
            $rules['nama_member_2'] = ['nullable', 'string', 'max:255'];
            $rules['jurusan_member_2'] = ['nullable', 'string', 'max:255', 'required_with:nama_member_2'];
            $rules['nama_member_3'] = ['nullable'];
            $rules['jurusan_member_3'] = ['nullable'];
        } else {
            // Business Case, Geothermal, Well Stimulation: min 3 (leader + 2), max 4 (leader + 3)
            $rules['nama_member_1'] = ['required', 'string', 'max:255'];
            $rules['jurusan_member_1'] = ['required', 'string', 'max:255'];
            $rules['nama_member_2'] = ['required', 'string', 'max:255'];
            $rules['jurusan_member_2'] = ['required', 'string', 'max:255'];
            $rules['nama_member_3'] = ['nullable', 'string', 'max:255'];
            $rules['jurusan_member_3'] = ['nullable', 'string', 'max:255', 'required_with:nama_member_3'];
        }

        $request->validate($rules);

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
            'nama_member_3' => $request->nama_member_3,
            'jurusan_member_3' => $request->jurusan_member_3,
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

    /**
     * Show the profile page.
     */
    public function showProfile()
    {
        $user = auth()->user();
        $peserta = $user->peserta;
        
        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        $kategori = $peserta->kategori;
        $competition = config("competitions.categories.{$kategori}");
        
        // Get semifinal information
        $semifinalQualifier = $peserta->semifinalQualifier;

        return view('peserta.profile', compact('user', 'peserta', 'competition', 'kategori', 'semifinalQualifier'));
    }

    /**
     * Update the profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $peserta = $user->peserta;
        
        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        // Base validation rules
        $rules = [
            'nama_tim' => ['required', 'string', 'max:255'],
            'asal_univ' => ['required', 'string', 'max:255'],
            'nama_leader' => ['required', 'string', 'max:255'],
            'jurusan_leader' => ['required', 'string', 'max:255'],
        ];

        // Dynamic member validation based on category
        if ($peserta->kategori === 'poster_paper') {
            // Poster Paper: min 2 (leader + 1), max 3 (leader + 2)
            $rules['nama_member_1'] = ['nullable', 'string', 'max:255'];
            $rules['jurusan_member_1'] = ['nullable', 'string', 'max:255', 'required_with:nama_member_1'];
            $rules['nama_member_2'] = ['nullable', 'string', 'max:255'];
            $rules['jurusan_member_2'] = ['nullable', 'string', 'max:255', 'required_with:nama_member_2'];
        } else {
            // Business Case, Geothermal, Well Stimulation: min 3 (leader + 2), max 4 (leader + 3)
            $rules['nama_member_1'] = ['required', 'string', 'max:255'];
            $rules['jurusan_member_1'] = ['required', 'string', 'max:255'];
            $rules['nama_member_2'] = ['required', 'string', 'max:255'];
            $rules['jurusan_member_2'] = ['required', 'string', 'max:255'];
            $rules['nama_member_3'] = ['nullable', 'string', 'max:255'];
            $rules['jurusan_member_3'] = ['nullable', 'string', 'max:255', 'required_with:nama_member_3'];
        }

        $request->validate($rules);

        $updateData = [
            'nama_tim' => $request->nama_tim,
            'asal_univ' => $request->asal_univ,
            'nama_leader' => $request->nama_leader,
            'jurusan_leader' => $request->jurusan_leader,
            'nama_member_1' => $request->nama_member_1,
            'jurusan_member_1' => $request->jurusan_member_1,
            'nama_member_2' => $request->nama_member_2,
            'jurusan_member_2' => $request->jurusan_member_2,
        ];

        // Add member_3 for non-poster_paper competitions
        if ($peserta->kategori !== 'poster_paper') {
            $updateData['nama_member_3'] = $request->nama_member_3;
            $updateData['jurusan_member_3'] = $request->jurusan_member_3;
        }

        $peserta->update($updateData);

        return redirect()->route('peserta.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * View KTM document
     */
    public function viewKtm($filename)
    {
        $path = storage_path('app/public/peserta/ktm/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path);
    }

    /**
     * View Follow IG document
     */
    public function viewFollowIg($filename)
    {
        $path = storage_path('app/public/peserta/follow_ig/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path);
    }

    /**
     * View Share Poster document
     */
    public function viewSharePoster($filename)
    {
        $path = storage_path('app/public/peserta/share_poster/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path);
    }

    /**
     * View Payment document
     */
    public function viewPayment($filename)
    {
        $path = storage_path('app/public/peserta/payment/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path);
    }

    /**
     * Show notifications page
     */
    public function notifications()
    {
        $user = auth()->user();
        $peserta = $user->peserta;
        
        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        $kategori = $peserta->kategori;
        $competition = config("competitions.categories.{$kategori}");

        // Get all notifications for the user
        $notifications = $user->notifications()->paginate(20);
        
        // Mark all as read when viewing the page
        $user->notifications()->unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return view('peserta.notifications', compact('user', 'peserta', 'competition', 'kategori', 'notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    /**
     * Upload semifinal payment proof
     */
    public function uploadSemifinalPayment(Request $request)
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        // Check if team is qualified for semifinals
        if (!$peserta->isQualifiedForSemifinal()) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Tim Anda tidak lolos ke babak semifinal.');
        }

        // Check if payment already uploaded
        if ($peserta->hasUploadedSemifinalPayment()) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Anda sudah mengupload bukti pembayaran semifinal.');
        }

        $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'], // 10MB max
        ]);

        $file = $request->file('payment_proof');
        
        // Store file with unique name
        $filename = 'semifinal_payment_' . $peserta->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('peserta/semifinal_payments', $filename, 'public');

        // Get semifinal qualifier record
        $qualifier = $peserta->semifinalQualifier;

        // Create semifinal payment record
        \App\Models\SemifinalPayment::create([
            'peserta_id' => $peserta->id,
            'semifinal_qualifier_id' => $qualifier->id,
            'payment_proof_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'status' => 'pending',
            'uploaded_at' => now(),
        ]);

        return redirect()->route('peserta.dashboard')
            ->with('success', 'Bukti pembayaran semifinal berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * Upload final payment proof
     */
    public function uploadFinalPayment(Request $request)
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        if (!$peserta->isQualifiedForFinal()) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Tim Anda tidak lolos ke babak final.');
        }

        if ($peserta->hasUploadedFinalPayment()) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Anda sudah mengupload bukti pembayaran final.');
        }

        $request->validate([
            'final_payment_proof' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $file = $request->file('final_payment_proof');

        $filename = 'final_payment_' . $peserta->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('peserta/final_payments', $filename, 'public');

        $qualifier = $peserta->finalQualifier;

        FinalPayment::create([
            'peserta_id' => $peserta->id,
            'final_qualifier_id' => $qualifier->id,
            'payment_proof_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'status' => 'pending',
            'uploaded_at' => now(),
        ]);

        return redirect()->route('peserta.dashboard')
            ->with('success', 'Bukti pembayaran final berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * View semifinal payment proof
     */
    public function viewSemifinalPayment()
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        $payment = $peserta->semifinalPayment;

        if (!$payment) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $payment->payment_proof_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($path);
        
        return response()->file($path, [
            'Content-Type' => $mimeType,
        ]);
    }

    /**
     * View final payment proof
     */
    public function viewFinalPayment()
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        $payment = $peserta->finalPayment;

        if (!$payment) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $payment->payment_proof_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
        ]);
    }

    /**
     * Download final payment rules PDF.
     */
    public function downloadFinalPaymentRules()
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        $rulesRelativePath = config("competitions.categories.{$peserta->kategori}.final_payment_rules")
            ?? config('competitions.payment.final_payment_rules_file', 'guidebooks/final-payment-rules.pdf');

        $rulesFullPath = base_path($rulesRelativePath);

        if (!file_exists($rulesFullPath)) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Final payment rules file is not available yet. Please contact admin.');
        }

        $downloadName = strtoupper($peserta->kategori) . '_Final_Payment_Rules_Inception2026.pdf';

        return response()->download($rulesFullPath, $downloadName);
    }

    /**
     * Download final guidebook based on participant category.
     */
    public function downloadFinalGuidebook()
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        $guidebookRelativePath = config("competitions.categories.{$peserta->kategori}.final_guidebook");

        if (!$guidebookRelativePath) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Final guidebook for your competition category is not configured yet.');
        }

        $guidebookFullPath = base_path($guidebookRelativePath);

        if (!file_exists($guidebookFullPath)) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Final guidebook file is not available yet. Please contact admin.');
        }

        $downloadName = strtoupper($peserta->kategori) . '_Final_Guidebook_Inception2026.pdf';

        return response()->download($guidebookFullPath, $downloadName);
    }
}
