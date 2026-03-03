@extends('layouts.app')

@section('content')
<div class="auth-container">
  <div class="auth-box">
    <div class="auth-header">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Inception" class="auth-logo">
      <h1>Reset Password</h1>
      <p>Masukkan password baru Anda</p>
    </div>

    @if($errors->any())
      <div class="alert alert-error">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="auth-form">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

      <div class="form-group">
        <label for="email_display">Email</label>
        <input 
          type="email" 
          id="email_display" 
          value="{{ $email }}" 
          disabled
          class="disabled-input"
        >
      </div>

      <div class="form-group">
        <label for="password">Password Baru</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          required
          placeholder="Minimal 8 karakter"
          class="@error('password') error @enderror"
        >
        @error('password')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input 
          type="password" 
          id="password_confirmation" 
          name="password_confirmation" 
          required
          placeholder="Ulangi password baru"
        >
      </div>

      <button type="submit" class="btn-submit">Reset Password</button>
    </form>

    <div class="auth-footer">
      <p>Sudah ingat password? <a href="{{ route('login') }}">Kembali ke Login</a></p>
    </div>
  </div>
</div>
@endsection
