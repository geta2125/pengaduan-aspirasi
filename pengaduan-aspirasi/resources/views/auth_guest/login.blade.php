@extends('layouts_guest.auth')

@section('konten')
    <div class="container h-100">
        <div class="row justify-content-center align-items-center height-self-center">
            <div class="col-md-5 col-sm-12 col-12 align-self-center">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body text-center p-4">
                        <h2 class="mb-3">{{ $title }}</h2>
                        <p class="text-muted mb-4">Silakan login untuk melanjutkan.</p>

                        <form method="POST" action="{{ route('guest.login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="floating-input form-group">
                                        <input class="form-control" type="text" name="username" id="username" required />
                                        <label class="form-label" for="username">Username</label>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="floating-input form-group position-relative">
                                        <input class="form-control" type="password" name="password" id="password" required />
                                        <label class="form-label" for="password">Kata Sandi</label>
                                        <span class="position-absolute end-0 top-50 translate-middle-y pe-3"
                                            style="cursor: pointer;" id="togglePassword">
                                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                            <p class="mt-3 mb-0">
                                Belum punya akun?
                                <a href="{{ route('guest.register') }}" class="text-primary fw-semibold">Daftar Sekarang</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script toggle password --}}
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    </script>
@endsection
