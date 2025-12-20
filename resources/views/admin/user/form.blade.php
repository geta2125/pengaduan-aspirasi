@extends('layouts_admin.app')

@section('konten')
    <div class="row justify-content-center">
        {{-- Diubah menjadi col-xl-11 untuk kesan card yang lebih lebar --}}
        <div class="col-xl-11 col-lg-12">

            {{-- Card dengan shadow yang lebih elegan dan sudut membulat --}}
            <div class="card shadow-lg border-0 rounded-4">

                {{-- HEADER YANG SANGAT CLEAN --}}
                <div
                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2 py-3 rounded-top-4">
                    <h4 class="mb-0">
                        <i class="la la-user-plus me-2"></i>
                        {{ isset($user) ? 'Edit Data User' : 'Tambah Data Baru' }}
                    </h4>
                    <a href="{{ route('user.index') }}" class="btn btn-light btn-sm">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-3 p-md-4">

                    {{-- ALERT ERROR GLOBAL --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <h5 class="alert-heading fs-6 fw-bold">
                                <i class="ri-error-warning-line me-1"></i> Terjadi kesalahan pada input:
                            </h5>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST"
                        action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif

                        <div class="row g-4"> {{-- Jarak kolom lebih lega --}}
                            {{-- KOLOM KIRI: DATA UTAMA --}}
                            <div class="col-lg-7 border-end pe-lg-5"> {{-- Dibuat sedikit lebih lebar (7/12) --}}

                                <h5 class="mb-4 text-primary border-bottom border-primary pb-2 fw-bold">
                                    <i class="ri-information-line me-2"></i> Informasi Akun Login
                                </h5>

                                {{-- NAMA LENGKAP --}}
                                <div class="mb-4">
                                    <label for="nama" class="form-label fw-semibold">
                                        Nama Lengkap <span class="text-danger"></span>
                                    </label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control form-control-lg rounded-3 @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $user->nama ?? '') }}" placeholder="Masukkan Nama Lengkap">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- EMAIL --}}
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">
                                        Email <span class="text-danger"></span>
                                    </label>
                                    <input type="email" name="email" id="email"
                                        class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email ?? '') }}" placeholder="email.aktif@domain.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted mt-1 d-block">
                                        Email ini berfungsi sebagai username dan harus unik.
                                    </small>
                                </div>

                                {{-- ROLE --}}
                                <div class="mb-5">
                                    <label for="role" class="form-label fw-semibold">
                                        Role / Hak Akses <span class="text-danger"></span>
                                    </label>

                                    @php
                                        $selectedRole = old('role', $user->role ?? '');
                                    @endphp

                                    <div class="role-select">
                                        <select name="role" id="role"
                                            class="form-select form-select-lg rounded-pill px-4 @error('role') is-invalid @enderror">
                                            <option value="" disabled {{ $selectedRole == '' ? 'selected' : '' }}>
                                                Pilih Role
                                            </option>
                                            <option value="super admin"
                                                {{ $selectedRole === 'super admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="admin" {{ $selectedRole === 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="petugas" {{ $selectedRole === 'petugas' ? 'selected' : '' }}>
                                                Petugas</option>
                                            <option value="guest" {{ $selectedRole === 'guest' ? 'selected' : '' }}>Guest
                                            </option>
                                        </select>
                                    </div>

                                    @error('role')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <small class="text-muted mt-2 d-block">
                                        Tentukan level otoritas user dalam aplikasi.
                                    </small>
                                </div>

                                {{-- PASSWORD / PASSWORD BARU --}}
                                @if (!isset($user))
                                    {{-- MODE TAMBAH: PASSWORD WAJIB --}}
                                    <h5 class="mb-4 text-secondary border-bottom border-secondary pb-2 fw-bold">
                                        <i class="ri-lock-line me-2"></i> Pengaturan Password
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="password" class="form-label fw-semibold">
                                                Password <span class="text-danger"></span>
                                            </label>
                                            <div class="input-group input-group-lg rounded-3">
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Minimal 6 karakter">

                                                <button class="btn btn-outline-secondary rounded-end-3 toggle-password"
                                                    type="button" data-target="password" title="Tampilkan Password">
                                                    <i class="ri-eye-line"></i>
                                                </button>

                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="password_confirmation" class="form-label fw-semibold">
                                                Konfirmasi Password <span class="text-danger"></span>
                                            </label>
                                            <div class="input-group input-group-lg rounded-3">
                                                <input type="password" name="password_confirmation"
                                                    id="password_confirmation" class="form-control"
                                                    placeholder="Ulangi password">

                                                <button class="btn btn-outline-secondary rounded-end-3 toggle-password"
                                                    type="button" data-target="password_confirmation"
                                                    title="Tampilkan Password">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- MODE EDIT: PASSWORD OPSIONAL --}}
                                    <h5 class="mt-5 mb-4 text-secondary border-bottom border-secondary pb-2 fw-bold">
                                        <i class="ri-lock-line me-2"></i> Ubah Password (Opsional)
                                    </h5>

                                    <div class="alert alert-info py-2 small rounded-3" role="alert">
                                        <i class="ri-information-line me-1"></i>
                                        Kosongkan kolom di bawah ini jika tidak ingin mengubah password saat ini.
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_edit" class="form-label fw-semibold">
                                            Password Baru (Opsional)
                                        </label>
                                        <div class="input-group input-group-lg rounded-3">
                                            <input type="password" name="password" id="password_edit"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Isi jika ingin mengganti password">

                                            <button class="btn btn-outline-secondary rounded-end-3 toggle-password"
                                                type="button" data-target="password_edit" title="Tampilkan Password">
                                                <i class="ri-eye-line"></i>
                                            </button>

                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- KOLOM KANAN: FOTO & INFO --}}
                            <div class="col-lg-5 ps-lg-5">
                                <h5 class="mb-4 text-primary border-bottom border-primary pb-2 fw-bold">
                                    <i class="ri-user-line me-2"></i> Foto Profil & Panduan
                                </h5>

                                {{-- PREVIEW FOTO --}}
                                <div class="mb-4 text-center">
                                    <label class="form-label d-block fw-semibold mb-3">Foto Profil Saat Ini</label>

                                    <div class="avatar-preview mx-auto">
                                        <img id="preview-foto"
                                            src="{{ isset($user) && $user->foto
                                                ? asset('storage/' . $user->foto)
                                                : 'https://ui-avatars.com/api/?name=' .
                                                    urlencode($user->nama ?? 'User Baru') .
                                                    '&background=3B82F6&color=fff&size=150&font-size=0.4' }}"
                                            alt="Foto User">
                                    </div>
                                </div>

                                {{-- INPUT FOTO --}}
                                <div class="mb-5">
                                    <label for="foto" class="form-label fw-semibold">
                                        Upload Foto Profil Baru (Opsional)
                                    </label>
                                    <input type="file" name="foto" id="foto"
                                        class="form-control @error('foto') is-invalid @enderror" accept="image/">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted mt-1 d-block">
                                        Format yang diperbolehkan: `jpeg, png, jpg, gif, svg`. Maksimal 2MB.
                                    </small>
                                </div>

                                {{-- INFO KECIL: DISESUAIKAN DENGAN VALIDASI CONTROLLER --}}
                                <div class="alert alert-light border border-info rounded-3 small mt-4" role="alert">
                                    <div class="fw-bold mb-2 text-info">
                                        <i class="ri-lightbulb-line me-1"></i>
                                        Panduan Pengisian User
                                    </div>
                                    <ul class="mb-0 ps-3">
                                        <li>Nama Lengkap & Email wajib diisi. Email harus unik (belum pernah terdaftar).
                                        </li>
                                        <li>Role harus dipilih dari salah satu opsi: super admin, admin, petugas, atau
                                            guest.</li>
                                        <li>Untuk Tambah User, Password wajib diisi minimal 6 karakter.</li>
                                        <li>Untuk Edit User, Password opsional, isi hanya jika ingin menggantinya.</li>
                                        <li>Foto Profil bersifat opsional. Maksimal ukuran file adalah 2MB.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER FORM DENGAN TOMBOL --}}
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <small class="text-danger fw-semibold">
                                Kolom bertanda <span class="text-danger">*</span> wajib diisi.
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('user.index') }}"
                                    class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="ri-close-line me-1"></i>
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-success rounded-pill px-4"> {{-- Gunakan success untuk aksi simpan --}}
                                    <i class="ri-save-line me-1"></i>
                                    {{ isset($user) ? 'Simpan Perubahan' : 'Simpan User Baru' }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Mengubah icon dari la-eye ke ri-eye-line (Rixicons) jika tersedia di template Anda
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.toggle-password');
            if (!btn) return;

            const targetId = btn.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = btn.querySelector('i');

            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                if (icon) {
                    // Jika menggunakan Rixicons/Remixicons
                    icon.classList.remove('ri-eye-line');
                    icon.classList.add('ri-eye-off-line');
                    // Jika masih menggunakan Line Awesome/la
                    icon.classList.remove('la-eye');
                    icon.classList.add('la-eye-slash');
                }
            } else {
                input.type = 'password';
                if (icon) {
                    // Jika menggunakan Rixicons/Remixicons
                    icon.classList.remove('ri-eye-off-line');
                    icon.classList.add('ri-eye-line');
                    // Jika masih menggunakan Line Awesome/la
                    icon.classList.remove('la-eye-slash');
                    icon.classList.add('la-eye');
                }
            }
        });

        // PREVIEW FOTO
        (function() {
            const inputFoto = document.getElementById('foto');
            const previewFoto = document.getElementById('preview-foto');

            if (inputFoto && previewFoto) {
                inputFoto.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            previewFoto.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        })();
    </script>
@endpush
