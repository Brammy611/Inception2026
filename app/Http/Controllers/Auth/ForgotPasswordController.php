<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form lupa password
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim email reset password
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem.'
        ]);

        // Generate token
        $token = Str::random(64);

        // Hapus token lama jika ada
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Simpan token baru
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        // Kirim email
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);
        
        try {
            Mail::send('emails.reset-password', ['resetLink' => $resetLink], function($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password - Inception 2026');
            });

            return back()->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi nanti.']);
        }
    }

    /**
     * Tampilkan form reset password
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.exists' => 'Email tidak terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Cek token
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Token tidak valid atau sudah expired.']);
        }

        // Cek apakah token expired (1 jam)
        if (Carbon::parse($record->created_at)->addHour()->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token sudah expired. Silakan request ulang.']);
        }

        // Verifikasi token
        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token tidak valid.']);
        }

        // Update password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}
