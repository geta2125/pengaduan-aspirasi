@extends('layouts_admin.auth')
@section('konten')
    <div class="container">
        <div class="row align-items-center justify-content-center height-self-center">
            <div class="col-lg-8">
                <div class="card auth-card">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                            <div class="col-lg-7 align-self-center">
                                <div class="p-3">
                                    <h2 class="mb-2">Sign In</h2>
                                    <p>Login to stay connected.</p>

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    {{-- 4. REPOPULATE FORM: 'value' diisi dengan old('username') --}}
                                                    <input
                                                        class="floating-input form-control @error('username') is-invalid @enderror"
                                                        type="text" placeholder=" " name="username"
                                                        value="{{ old('username') }}" required>
                                                    <label>Username</label>

                                                    {{-- 2. VALIDATION ERROR: Menampilkan error untuk 'username' --}}
                                                    @error('username')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="floating-label form-group position-relative">
                                                    <input id="password"
                                                        class="floating-input form-control @error('password') is-invalid @enderror"
                                                        name="password" type="password" placeholder=" " required>
                                                    <label>Password</label>
                                                    <span id="togglePassword"
                                                        style="position:absolute; right:12px; top:7px; cursor:pointer;">
                                                        <i class="fa fa-eye"></i>
                                                    </span>

                                                    {{-- 2. VALIDATION ERROR: Menampilkan error untuk 'password' --}}
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Sign In</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-5 content-right">
                                <img src="{{ asset('template/assets/images/login/01.png') }}" class="img-fluid image-right"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
    Penting: Pastikan SweetAlert2 JS sudah di-load di layout 'layouts.auth' Anda
    agar script di bawah ini berfungsi.
    --}}
    <script>
        // Show/Hide Password
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML = type === 'password' ?
                    '<i class="fa fa-eye"></i>' :
                    '<i class="fa fa-eye-slash"></i>';
            });
        }

        // 3. FLASH DATA (SUCCESS): Menampilkan pesan dari session 'success'
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        // 3. FLASH DATA (ERROR): Menampilkan pesan dari session 'error'
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection