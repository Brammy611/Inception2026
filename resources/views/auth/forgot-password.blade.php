@extends('layouts.app')

@section('content')
<div class="auth-container">
  <div class="auth-box">
    <div class="auth-header">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Inception" class="auth-logo">
      <h1>Lupa Password</h1>
      <p>Masukkan email Anda untuk menerima link reset password</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-error">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
      @csrf
      
      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email" 
          name="email" 
          value="{{ old('email') }}" 
          required 
          autofocus
          placeholder="Masukkan email Anda"
          class="@error('email') error @enderror"
        >
        @error('email')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="btn-submit">Kirim Link Reset</button>
    </form>

    <div class="auth-footer">
      <p>Sudah ingat password? <a href="{{ route('login') }}">Kembali ke Login</a></p>
    </div>
  </div>
</div>
@endsection
