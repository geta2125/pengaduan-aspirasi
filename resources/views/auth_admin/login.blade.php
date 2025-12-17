@extends('layouts_admin.auth')

@section('konten')
    @include('auth_admin.logincss')

    <div class="auth-page">
        <div class="login-container">

            {{-- Bagian Kiri: Form --}}
            <div class="left-section">

                {{-- LOGO AREA: Penting agar terlihat resmi seperti dashboard --}}
                <div class="brand-logo-container">
                    <img src="{{ asset('storage/logo/logologin1.png') }}" class="brand-logo" alt="Logo">
                </div>

                <div class="header">
                    <h1>Selamat Datang!</h1>
                    <p>Masuk untuk mengelola data warga.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group">
                        {{-- Tambahkan autocomplete username --}}
                        <input type="text" id="email" name="email"
                            class="input-field @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder=" " required autofocus autocomplete="username">

                        {{-- Label kapital agar rapi --}}
                        <label for="email">Email</label>

                        @error('email')
                            <span class="text-danger">
                                <i class="fa fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        {{-- Tambahkan autocomplete current-password --}}
                        <input type="password" id="password" name="password"
                            class="input-field @error('password') is-invalid @enderror" placeholder=" " required
                            autocomplete="current-password">
                        <label for="password">Password</label>

                        @error('password')
                            <span class="text-danger">
                                <i class="fa fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="options">
                        <label for="remember" class="remember-me">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-pass">Lupa Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit">
                        Masuk Dashboard
                    </button>
                </form>
            </div>

            {{-- Bagian Kanan: Gambar --}}
            <div class="right-section">
                {{-- Gambar background desa yang asri/modern --}}
                <div class="bg-image"
                    style="background-image: url('{{ asset('storage/pengaduanaspirasi/pengaduanaspirasi.jpg') }}');">
                </div>
                <div class="overlay-gradient"></div>

                <div class="caption">

                    <h2>Ubah Masalah Jadi Solusi</h2>

                    <p>Jangan biarkan aspirasi hanya tersimpan. Mari berkolaborasi membangun lingkungan yang lebih baik.
                        Karena setiap suara Anda sangat berarti.</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Script SweetAlert --}}
    <script>
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
                color: '#fff',
                iconColor: '#fff'
            });
        @endif

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
                color: '#fff',
                iconColor: '#fff'
            });
        @endif
    </script>
@endsection
