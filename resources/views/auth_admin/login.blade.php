@extends('layouts_admin.auth')

@section('konten')
{{-- start css --}}
@include('auth_admin.logincss')
{{-- end css --}}
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-grid">
                <!-- Left: Form Section -->
                <div class="auth-form">
                    <div class="brand">
                        <div class="brand-logo">
                            <img src="{{ asset('template/assets/images/login/logo.png') }}" alt="Logo">
                        </div>
                        <h1 class="brand-title">Sistem Pengaduan</h1>
                        <p class="brand-subtitle">Platform Aspirasi Masyarakat</p>
                    </div>

                    <div class="form-header">
                        <h2 class="form-title">Selamat Datang Kembali</h2>
                        <p class="form-subtitle">Silakan masuk ke akun Anda untuk melanjutkan</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Username -->
                        <div class="form-field">
                            <label class="form-label">Username</label>
                            <div class="input-wrapper">
                                <i class="fa fa-user input-icon"></i>
                                <input
                                    type="text"
                                    name="username"
                                    class="form-control with-icon @error('username') is-invalid @enderror"
                                    placeholder="Masukkan username"
                                    value="{{ old('username') }}"
                                    required
                                    autofocus>
                            </div>
                            @error('username')
                                <div class="error-message">
                                    <i class="fa fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-field">
                            <label class="form-label">Password</label>
                            <div class="input-wrapper">
                                <i class="fa fa-lock input-icon"></i>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control with-icon @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password"
                                    required>
                                <span class="toggle-password" id="togglePassword">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="error-message">
                                    <i class="fa fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-options">
                            <div class="checkbox-wrapper">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="checkbox-label" for="remember">Ingat saya</label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary">
                            <i class="fa fa-sign-in-alt"></i>
                            <span>Masuk ke Dashboard</span>
                        </button>
                    </form>
                </div>

                <!-- Right: Visual Section -->
                <div class="auth-visual">
                    <div class="visual-content">
                        <img src="{{ asset('template/assets/images/login/loginpengaduan.png') }}"
                            alt="Ilustrasi" class="visual-image">
                        <div class="visual-text">
                            <h3 class="visual-title">Kelola Pengaduan dengan Mudah</h3>
                            <p class="visual-desc">
                                Sistem terintegrasi untuk mengelola<br>
                                pengaduan dan aspirasi masyarakat
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword?.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.querySelector('i').className = type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
        });

        // SweetAlert Success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#10b981',
                color: '#fff'
            });
        @endif

        // SweetAlert Error
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#ef4444',
                color: '#fff'
            });
        @endif
    </script>
@endsection
