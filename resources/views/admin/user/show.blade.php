@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0 rounded-4">

                {{-- HEADER --}}
                <div
                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center p-3 rounded-top-4">
                    <div>
                        <h4 class="mb-0">
                            <i class="la la-user me-2"></i>
                            {{ $title ?? 'Detail User' }}
                        </h4>
                        <small class="opacity-75">
                            Informasi lengkap mengenai akun pengguna.
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('user.index') }}" class="btn btn-light btn-sm">
                            <i class="ri-arrow-left-line"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">

                    <div class="row g-4">
                        {{-- KOLOM KIRI: FOTO & SUMMARY --}}
                        <div class="col-lg-4">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <div class="rounded-circle border shadow-sm d-inline-flex justify-content-center align-items-center"
                                         style="width: 140px; height: 140px; overflow: hidden; background: #f8f9fa;">
                                        <img
                                            src="{{ $user->foto
                                                    ? asset('storage/' . $user->foto)
                                                    : 'https://ui-avatars.com/api/?name=' .
                                                        urlencode($user->nama ?? $user->email) .
                                                        '&background=0D8ABC&color=fff&size=140' }}"
                                            alt="Foto User"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                                <h5 class="mb-1">{{ $user->nama }}</h5>

                                {{-- BADGE ROLE --}}
                                @php
                                    $role = $user->role;
                                    $roleLabel = ucfirst($role);
                                    $badgeClass = match ($role) {
                                        'super admin' => 'bg-danger',
                                        'admin'       => 'bg-primary',
                                        'petugas'     => 'bg-info text-dark',
                                        'guest'       => 'bg-secondary',
                                        default       => 'bg-secondary',
                                    };
                                @endphp

                                <span class="badge {{ $badgeClass }} px-3 py-1 rounded-pill mb-2">
                                    {{ $roleLabel }}
                                </span>

                                <div class="text-muted small">
                                    ID User: #{{ $user->id }}
                                </div>
                            </div>

                            {{-- INFO WAKTU --}}
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body small">
                                    <h6 class="text-primary mb-3">
                                        <i class="la la-clock-o me-1"></i>
                                        Riwayat Waktu
                                    </h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Dibuat pada</span>
                                        <span class="fw-semibold">
                                            {{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Terakhir diperbarui</span>
                                        <span class="fw-semibold">
                                            {{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: DETAIL LENGKAP --}}
                        <div class="col-lg-8">
                            <h5 class="mb-3 text-primary border-bottom pb-2">
                                <i class="la la-id-card me-2"></i>
                                Informasi Detail User
                            </h5>

                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th style="width: 180px;">Nama Lengkap</th>
                                            <td>:</td>
                                            <td>{{ $user->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>:</td>
                                            <td>
                                                <a href="mailto:{{ $user->email }}">
                                                    {{ $user->email }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Role / Hak Akses</th>
                                            <td>:</td>
                                            <td>
                                                <span class="badge {{ $badgeClass }} px-3 py-1 rounded-pill">
                                                    {{ $roleLabel }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status Foto</th>
                                            <td>:</td>
                                            <td>
                                                @if ($user->foto)
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                        <i class="la la-check-circle me-1"></i> Sudah upload
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                        <i class="la la-exclamation-circle me-1"></i> Belum ada foto
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        {{-- Kalau nanti ada field lain, tinggal tambahin di sini --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 alert alert-light border small" role="alert">
                                <div class="fw-semibold mb-1">
                                    <i class="la la-info-circle me-1"></i>
                                    Catatan
                                </div>
                                <p class="mb-0">
                                    Data user ini digunakan untuk mengatur akses ke dalam sistem.
                                    Pastikan email dan role sudah sesuai dengan kebutuhan.
                                </p>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
