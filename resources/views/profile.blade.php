@extends('layouts_admin.app')

@section('konten')
    {{-- CONTAINER UTAMA (Start Content) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title }}</h4>
                </div>
            </div>
        </div>

        {{-- CARD 1 (Kolom Kiri: Info Ringkas Profil) --}}
        <div class="col-lg-4">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="profile-img position-relative">
                            {{-- Tampilkan foto profil pengguna saat ini --}}
                            @php
                                $profile_photo = $user->foto
                                    ? asset('storage/' . $user->foto)
                                    : asset('template/assets/images/user/1.png');
                            @endphp
                            <img src="{{ $profile_photo }}" class="img-fluid rounded avatar-110" alt="Foto Profil" />
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-1">{{ $user->nama ?? 'Nama Pengguna' }}</h4>
                            <p class="mb-2 text-muted">{{ $user->role ?? 'role' }}</p>
                            <a href="mailto:{{ $user->email ?? '#' }}" class="btn btn-primary btn-sm">
                                <i class="ri-mail-line"></i> Email Saya
                            </a>
                        </div>
                    </div>
                    <p class="text-secondary mt-3">
                        Kelola data pribadi, alamat email, dan pengaturan keamanan akun Anda di sini.
                    </p>
                    <ul class="list-inline p-0 m-0">
                        <li class="mb-2">
                            <div class="d-flex align-items-center">
                                <svg class="svg-icon mr-3" height="16" width="16" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="mb-0 text-dark font-weight-bold">
                                    {{ $user->email ?? 'email@contoh.com' }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- CARD 2 (Kolom Kanan: Navigasi Tab dan Form Edit) --}}
        <div class="col-lg-8">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    {{-- Navigasi Tab --}}
                    <ul class="d-flex nav nav-pills mb-3 text-center profile-tab" id="profile-pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#tab-personal-info" role="tab"
                                aria-selected="true">Informasi Pribadi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab-ganti-password" role="tab"
                                aria-selected="false">Ganti Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab-ganti-foto" role="tab"
                                aria-selected="false">Ganti Foto Profil</a>
                        </li>
                    </ul>

                    {{-- Konten Tab --}}
                    <div class="profile-content tab-content">

                        {{-- TAB 1: Informasi Pribadi (Nama, Email) --}}
                        <div id="tab-personal-info" class="tab-pane fade active show">
                            <div class="card card-block card-stretch">
                                <div class="card-header px-4">
                                    <div class="header-title">
                                        <h4 class="card-title">Edit Data Akun</h4>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <form action="{{ route('update.profile') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="nama">Nama Lengkap:</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="{{ old('nama', $user->nama) }}" required>
                                            @error('nama')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- TAB 2: Ganti Password (Sudah Terimplementasi Show/Hide) --}}
                        <div id="tab-ganti-password" class="tab-pane fade">
                            <div class="card card-block card-stretch">
                                <div class="card-header px-4">
                                    <div class="header-title">
                                        <h4 class="card-title">Ganti Kata Sandi</h4>
                                    </div>
                                </div>

                                <div class="card-body p-4">
                                    <form action="{{ route('update.password') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        {{-- Current Password --}}
                                        <div class="form-group">
                                            <label for="current_password">Kata Sandi Saat Ini:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="current_password"
                                                    name="current_password" required>
                                                <div class="input-group-append">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="#current_password"
                                                        aria-label="Tampilkan/Sembunyikan Password">
                                                        <i class="ri-eye-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('current_password')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- New Password --}}
                                        <div class="form-group">
                                            <label for="new_password">Kata Sandi Baru:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="new_password"
                                                    name="new_password" required>
                                                <div class="input-group-append">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="#new_password"
                                                        aria-label="Tampilkan/Sembunyikan Password">
                                                        <i class="ri-eye-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('new_password')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Confirm New Password --}}
                                        <div class="form-group">
                                            <label for="new_password_confirmation">Konfirmasi Kata Sandi Baru:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control"
                                                    id="new_password_confirmation" name="new_password_confirmation"
                                                    required>
                                                <div class="input-group-append">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="#new_password_confirmation"
                                                        aria-label="Tampilkan/Sembunyikan Password">
                                                        <i class="ri-eye-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                        {{-- TAB 3: Ganti Foto Profil --}}
                        <div id="tab-ganti-foto" class="tab-pane fade">
                            <div class="card card-block card-stretch">
                                <div class="card-header px-4">
                                    <div class="header-title">
                                        <h4 class="card-title">Ganti Foto Profil</h4>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <form action="{{ route('update.foto') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="foto">Pilih Foto (Max 2MB, Format: JPG, PNG, GIF):</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="foto"
                                                    name="foto" accept="image/*" required>
                                                <label class="custom-file-label" for="foto">Pilih file</label>
                                            </div>
                                            @error('foto')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">Upload Foto</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FUNGSI UTAMA SHOW/HIDE PASSWORD
            document.querySelectorAll('.toggle-password').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const selector = this.getAttribute('data-target');
                    const input = document.querySelector(selector);
                    const icon = this.querySelector('i');
                    if (!input) return;

                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';

                    // Mengganti ikon
                    if (icon) {
                        // Jika sebelumnya tersembunyi (isHidden = true), sekarang menjadi text/terlihat, ganti ke ikon mata tertutup (ri-eye-off-line)
                        // Jika sebelumnya terlihat (isHidden = false), sekarang menjadi password/tersembunyi, ganti ke ikon mata terbuka (ri-eye-line)
                        icon.classList.remove(isHidden ? 'ri-eye-line' : 'ri-eye-off-line');
                        icon.classList.add(isHidden ? 'ri-eye-off-line' : 'ri-eye-line');
                    }
                });
            });

            // FUNGSI UNTUK MENAMPILKAN NAMA FILE PADA CUSTOM INPUT FILE
            const fileInput = document.getElementById('foto');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    // Ambil nama file pertama
                    let fileName = this.files[0] ? this.files[0].name : 'Pilih file';
                    // Update teks pada label
                    document.querySelector('.custom-file-label').textContent = fileName;
                });
            }
        });
    </script>
@endpush
