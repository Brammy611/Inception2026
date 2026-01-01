<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'nama_tim' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:' . implode(',', array_keys(Peserta::getKategoriOptions()))],
            'asal_univ' => ['required', 'string', 'max:255'],
            'jurusan_leader' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            // Store data to users table
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'peserta', // Default role is peserta
            ]);

            // Store data to peserta table
            Peserta::create([
                'user_id' => $user->id,
                'nama_leader' => $request->nama, // nama lengkap as nama_leader
                'nama_tim' => $request->nama_tim,
                'kategori' => $request->kategori,
                'asal_univ' => $request->asal_univ,
                'jurusan_leader' => $request->jurusan_leader,
                'nama_member_1' => '-', // Default value for required field
                'jurusan_member_1' => '-', // Default value for required field
                'status_verifikasi' => 'pending', // Default status
            ]);

            DB::commit();

            Auth::login($user);

            return redirect()->route('peserta.dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred during registration: ' . $e->getMessage()])->withInput();
        }
    }
}
