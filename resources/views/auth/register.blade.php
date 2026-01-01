@extends('layouts.app')

@section('content')
<div class="auth-container">
  <div class="auth-box">
    <div class="auth-header">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Inception" class="auth-logo">
      <h1>Register</h1>
      <p>Create your new Inception account</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
      @csrf
      
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
              <li style="color: #B22A2A;">{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- User Information Section -->
      <div class="form-section">
        <h3 class="section-title">User Information</h3>
        
        <div class="form-group">
          <label for="nama">Full Name</label>
          <input 
            type="text" 
            id="nama" 
            name="nama" 
            value="{{ old('nama') }}" 
            required 
            autofocus
            placeholder="Enter your full name"
            class="@error('nama') error @enderror"
          >
          @error('nama')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            value="{{ old('email') }}" 
            required
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
            placeholder="Minimum 8 characters"
            class="@error('password') error @enderror"
          >
          @error('password')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirm Password</label>
          <input 
            type="password" 
            id="password_confirmation" 
            name="password_confirmation" 
            required
            placeholder="Re-enter your password"
          >
        </div>
      </div>

      <!-- Team Information Section -->
      <div class="form-section">
        <h3 class="section-title">Team Information</h3>
        
        <div class="form-group">
          <label for="nama_tim">Team Name</label>
          <input 
            type="text" 
            id="nama_tim" 
            name="nama_tim" 
            value="{{ old('nama_tim') }}" 
            required
            placeholder="Enter your team name"
            class="@error('nama_tim') error @enderror"
          >
          @error('nama_tim')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="kategori">Competition Category</label>
          <select 
            id="kategori" 
            name="kategori" 
            required
            class="@error('kategori') error @enderror"
          >
            <option value="">Select Competition Category</option>
            @foreach(\App\Models\Peserta::getKategoriOptions() as $value => $label)
              <option value="{{ $value }}" {{ old('kategori') == $value ? 'selected' : '' }}>
                {{ $label }}
              </option>
            @endforeach
          </select>
          @error('kategori')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="asal_univ">University</label>
          <input 
            type="text" 
            id="asal_univ" 
            name="asal_univ" 
            value="{{ old('asal_univ') }}" 
            required
            placeholder="Enter your university"
            class="@error('asal_univ') error @enderror"
          >
          @error('asal_univ')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="jurusan_leader">Major</label>
          <input 
            type="text" 
            id="jurusan_leader" 
            name="jurusan_leader" 
            value="{{ old('jurusan_leader') }}" 
            required
            placeholder="Enter your major"
            class="@error('jurusan_leader') error @enderror"
          >
          @error('jurusan_leader')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <button type="submit" class="btn-submit">Register</button>
    </form>

    <div class="auth-footer">
      <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>
  </div>
</div>
@endsection
