@extends('layouts_guest.auth')
@section('konten')
    <div class="container h-100">
        <div class="row justify-content-center align-items-center height-self-center">
            <div class="col-md-5 col-sm-12 col-12 align-self-center">
                <div class="card">
                    <div class="card-body text-center">
                        <h2>{{ $title }}</h2>
                        <p>Buat akun Anda.</p>
                        <form method="POST" action="{{ route('guest.register.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="floating-input form-group">
                                        <input class="form-control" type="text" name="nama" id="nama"
                                            value="{{ old('nama') }}" required />
                                        <label class="form-label" for="nama">Nama Lengkap</label>
                                    </div>
                                </div>

                                {{-- Tambahan Email --}}
                                <div class="col-lg-12">
                                    <div class="floating-input form-group">
                                        <input class="form-control" type="email" name="email" id="email"
                                            value="{{ old('email') }}" required />
                                        <label class="form-label" for="email">Email</label>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="floating-input form-group">
                                        <input class="form-control" type="text" name="username" id="username"
                                            value="{{ old('username') }}" required />
                                        <label class="form-label" for="username">Username</label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="floating-input form-group position-relative">
                                        <input class="form-control" type="password" name="password" id="password" required />
                                        <label class="form-label" for="password">Password</label>
                                        <span class="position-absolute top-50 end-0 translate-middle-y pe-3 toggle-password"
                                            style="cursor:pointer;">
                                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="floating-input form-group">
                                        <input class="form-control" type="password" name="password_confirmation"
                                            id="password_confirmation" required />
                                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="custom-control custom-checkbox mb-3 text-left">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required
                                            {{ old('customCheck1') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customCheck1">
                                            Saya setuju dengan syarat dan ketentuan
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                            <p class="mt-3">
                                Sudah punya akun?
                                <a href="{{ route('guest.login') }}" class="text-primary">Masuk di sini</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
