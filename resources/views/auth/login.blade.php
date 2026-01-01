@extends('layouts.app')

@section('content')
<div class="auth-container">
  <div class="auth-box">
    <div class="auth-header">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Inception" class="auth-logo">
      <h1>Login</h1>
      <p>Sign in to your Inception account</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="auth-form">
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
          placeholder="Enter your email"
          class="@error('email') error @enderror"
        >
        @error('email')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          required
          placeholder="Enter your password"
          class="@error('password') error @enderror"
        >
        @error('password')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group remember-group">
        <label class="checkbox-label">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <span>Remember me</span>
        </label>
      </div>

      <button type="submit" class="btn-submit">Login</button>
    </form>

    <div class="auth-footer">
      <p>Don't have an account? <a href="{{ route('register') }}">Register now</a></p>
    </div>
  </div>
</div>
@endsection
