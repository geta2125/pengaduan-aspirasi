@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-4">
                {{-- HEADER CARD --}}
                <div
                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center p-3 rounded-top-4">
                    <h4 class="mb-0 fw-bold">Informasi Detail Warga</h4>
                    <a href="{{ route('warga.index') }}" class="btn btn-light btn-sm">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4 p-md-5">

                    {{-- FOTO & NAMA (Profile Section) --}}
                    <div class="text-center mb-5">
                        <div class="position-relative d-inline-block">
                            {{-- LOGIC TAMPIL FOTO --}}
                            @if ($warga->foto)
                                <img src="{{ asset('storage/' . $warga->foto) }}"
                                    class="rounded-circle shadow-lg avatar-150 img-fluid profile-picture"
                                    style="object-fit: cover; width: 150px; height: 150px; border: 5px solid #fff;"
                                    alt="Foto Profil">
                            @else
                                @if ($warga->jenis_kelamin == 'Laki-laki')
                                    <img src="{{ asset('template/assets/images/user/man.png') }}"
                                        class="rounded-circle shadow-lg avatar-150 img-fluid profile-picture bg-light p-1"
                                        style="object-fit: cover; width: 150px; height: 150px; border: 5px solid #fff;"
                                        alt="Foto Default Laki-laki">
                                @else
                                    <img src="{{ asset('template/assets/images/user/woman.png') }}"
                                        class="rounded-circle shadow-lg avatar-150 img-fluid profile-picture bg-light p-1"
                                        style="object-fit: cover; width: 150px; height: 150px; border: 5px solid #fff;"
                                        alt="Foto Default Perempuan">
                                @endif
                            @endif
                        </div>

                        <h3 class="mt-3 mb-1 fw-bold text-dark">{{ $warga->nama }}</h3>

                        {{-- BADGE ROLE USER --}}
                        @if ($user)
                            <span class="badge rounded-pill px-3 py-2 fs-6 mt-1
                                                        {{ $user->role === 'admin' ? 'bg-primary' : 'bg-success' }}">
                                <i class="ri-shield-user-line me-1"></i> {{ ucfirst($user->role) }}
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-2 fs-6 mt-1 bg-secondary">
                                <i class="ri-user-unfollow-line me-1"></i> Akun Belum Dibuat
                            </span>
                        @endif
                    </div>


                    {{-- SECTION DATA WARGA --}}
                    <div class="mb-5">
                        <h5 class="mb-3 border-bottom pb-2 fw-bold text-primary">
                            <i class="ri-file-list-line me-2"></i> Data Identitas Warga
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                                <p class="form-control-static fw-bold">{{ $warga->nama }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted">No. KTP</label>
                                <p class="form-control-static fw-bold">{{ $warga->no_ktp }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted">Email</label>
                                <p class="form-control-static">{{ $warga->email ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted">Jenis Kelamin</label>
                                <p class="form-control-static">{{ $warga->jenis_kelamin }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted">Agama</label>
                                <p class="form-control-static">{{ $warga->agama }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted">Pekerjaan</label>
                                <p class="form-control-static">{{ $warga->pekerjaan }}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold text-muted">No. Telepon</label>
                                <p class="form-control-static">{{ $warga->telp ?? '-' }}</p>
                            </div>
                        </div>

                    </div>


                    {{-- SECTION DATA USER --}}
                    <div>
                        <h5 class="mb-3 border-bottom pb-2 fw-bold text-primary">
                            <i class="ri-account-circle-line me-2"></i> Detail Akun User
                        </h5>

                        @if ($user)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-muted">email</label>
                                    <p class="form-control-static fw-bold text-primary">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-muted">Role Akun</label>
                                    <p class="form-control-static">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning text-center border-0" role="alert">
                                <i class="ri-error-warning-line me-2"></i> Peringatan: Akun user untuk warga ini belum
                                terdaftar.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOM CSS (Sesuaikan dengan file CSS global Anda jika perlu) --}}
    <style>
        /* Menggunakan warna gradien untuk header agar lebih modern */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            /* Contoh gradien biru */
        }

        /* Menghilangkan latar belakang default 'form-control-static' */
        .form-control-static {
            display: block;
            padding: 0.375rem 0;
            margin-bottom: 0;
            line-height: 1.5;
            color: #495057;
        }

        /* Memberi efek hover pada card */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endsection
