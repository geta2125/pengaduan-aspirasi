@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0 rounded-4">

                {{-- HEADER --}}
                <div
                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center p-3 rounded-top-4">
                    <h4 class="mb-0">
                        <i class="la la-users me-2"></i>
                        {{ isset($user) ? 'Edit Data User' : 'Tambah User Baru' }}
                    </h4>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-light btn-sm">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4 p-md-5">

                    {{-- ALERT ERROR GLOBAL --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="fw-bold mb-1">
                                <i class="la la-exclamation-circle me-1"></i>
                                Terjadi kesalahan pada input:
                            </div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                        action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif

                        <div class="row">
                            {{-- KOLOM KIRI: DATA UTAMA --}}
                            <div class="col-lg-8">

                                <h5 class="mb-4 text-primary border-bottom pb-2">
                                    <i class="la la-id-card me-2"></i>
                                    Informasi Akun
                                </h5>

                                {{-- NAMA --}}
                                <div class="mb-3">
                                    <label for="nama" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $user->nama ?? '') }}" placeholder="Masukkan nama lengkap">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- EMAIL --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="la la-envelope"></i>
                                        </span>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email ?? '') }}" placeholder="contoh@domain.com">
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">
                                        Email ini digunakan untuk login ke sistem.
                                    </small>
                                </div>

                                {{-- ROLE --}}
                                <div class="mb-3">
                                    <label for="role" class="form-label">
                                        Role / Hak Akses <span class="text-danger">*</span>
                                    </label>

                                    @php
                                        $selectedRole = old('role', $user->role ?? '');
                                    @endphp

                                    <select name="role" id="role"
                                        class="form-select @error('role') is-invalid @enderror">
                                        <option value="" disabled {{ $selectedRole == '' ? 'selected' : '' }}
                                            style="text-align:center;">
                                            Pilih Role
                                        </option>

                                        {{-- Biar konsisten, semua role ditampilkan di kedua mode --}}
                                        <option value="super admin" {{ $selectedRole === 'super admin' ? 'selected' : '' }}>
                                            Super Admin
                                        </option>
                                        <option value="admin" {{ $selectedRole === 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="petugas" {{ $selectedRole === 'petugas' ? 'selected' : '' }}>
                                            Petugas
                                        </option>
                                        <option value="guest" {{ $selectedRole === 'guest' ? 'selected' : '' }}>
                                            Guest
                                        </option>
                                    </select>

                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <small class="text-muted">
                                        Tentukan level akses user dalam aplikasi.
                                    </small>
                                </div>

                                {{-- PASSWORD / PASSWORD BARU --}}
                                @if (!isset($user))
                                    {{-- MODE TAMBAH: PASSWORD WAJIB --}}
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">
                                                Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Minimal 6 karakter">

                                                <button class="btn btn-outline-secondary toggle-password" type="button"
                                                    data-target="password">
                                                    <i class="la la-eye"></i>
                                                </button>
                                                </button>

                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">
                                                Konfirmasi Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" name="password_confirmation"
                                                    id="password_confirmation" class="form-control"
                                                    placeholder="Ulangi password">

                                                <button class="btn btn-outline-secondary toggle-password" type="button"
                                                    data-target="password_confirmation">
                                                    <i class="la la-eye"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- MODE EDIT: PASSWORD OPSIONAL --}}
                                    <div class="alert alert-info py-2 small" role="alert">
                                        <i class="la la-info-circle me-1"></i>
                                        Kosongkan kolom password jika tidak ingin mengubah password.
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_edit" class="form-label">
                                            Password Baru (Opsional)
                                        </label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password_edit"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Isi jika ingin mengganti password">

                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="password_edit">
                                                <i class="la la-eye"></i>
                                            </button>

                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- KOLOM KANAN: FOTO & INFO --}}
                            <div class="col-lg-4">
                                <h5 class="mb-4 text-primary border-bottom pb-2">
                                    <i class="la la-user-circle me-2"></i>
                                    Foto & Info Tambahan
                                </h5>

                                {{-- PREVIEW FOTO --}}
                                <div class="mb-3 text-center">
                                    <div class="mb-2">
                                        <div class="rounded-circle border shadow-sm d-inline-flex justify-content-center align-items-center"
                                            style="width: 120px; height: 120px; overflow: hidden; background: #f8f9fa;">
                                            <img id="preview-foto"
                                                src="{{ isset($user) && $user->foto
                                                    ? asset('storage/' . $user->foto)
                                                    : 'https://ui-avatars.com/api/?name=' .
                                                        urlencode($user->nama ?? 'User Baru') .
                                                        '&background=0D8ABC&color=fff&size=128' }}"
                                                alt="Foto User" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <small class="d-block text-muted mb-2">
                                        Foto profil akan membantu mengidentifikasi user.
                                    </small>
                                </div>

                                {{-- INPUT FOTO --}}
                                <div class="mb-3">
                                    <label for="foto" class="form-label">
                                        Upload Foto Profil
                                    </label>
                                    <input type="file" name="foto" id="foto"
                                        class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        Format: jpeg, png, jpg, gif, svg. Maksimal 2MB.
                                    </small>
                                </div>

                                {{-- INFO KECIL --}}
                                <div class="alert alert-light border small mt-3" role="alert">
                                    <div class="fw-semibold mb-1">
                                        <i class="la la-lightbulb-o me-1"></i>
                                        Tips Pengisian
                                    </div>
                                    <ul class="mb-0 ps-3">
                                        <li>Gunakan email aktif & unik.</li>
                                        <li>Pilih role sesuai tanggung jawab user.</li>
                                        <li>Password minimal 6 karakter.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <small class="text-muted">
                                Kolom bertanda <span class="text-danger">*</span> wajib diisi.
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
                                    <i class="la la-times me-1"></i>
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="la la-save me-1"></i>
                                    {{ isset($user) ? 'Simpan Perubahan' : 'Simpan User' }}
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
        // Event delegation: dengerin klik di seluruh dokumen
        document.addEventListener('click', function(e) {
            // Cari element terdekat yang punya class .toggle-password
            const btn = e.target.closest('.toggle-password');
            if (!btn) return; // kalau yang diklik bukan tombol toggle-password, langsung keluar

            const targetId = btn.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = btn.querySelector('i');

            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                if (icon) {
                    icon.classList.remove('la-eye');
                    icon.classList.add('la-eye-slash');
                }
            } else {
                input.type = 'password';
                if (icon) {
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
