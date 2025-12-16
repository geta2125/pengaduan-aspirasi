@extends('layouts_admin.app')

@section('konten')
    <div class="row page-animate">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title ?? 'Manajemen User' }}</h4>
                </div>
                <a class="btn btn-primary add-list btn-fx click-ripple" href="{{ route('user.create') }}">
                    <i class="las la-plus mr-3 icon-tilt"></i> Tambah User
                </a>
            </div>
        </div>

        {{-- FILTER & SEARCH --}}
        <div class="col-lg-12 mb-3">
            <form method="GET" action="{{ route('user.index') }}" class="d-flex flex-wrap" style="gap: 10px;"
                id="filterFormUser">

                {{-- Search --}}
                <input type="text" name="search" class="form-control input-fx" placeholder="Cari nama / email..."
                    value="{{ request('search') }}" style="max-width: 250px;" id="searchInputUser">

                {{-- Role Filter --}}
                <select name="role" class="form-control input-fx" style="max-width: 200px;"
                    onchange="document.getElementById('filterFormUser').submit()">
                    <option value="">Semua Role</option>
                    <option value="super admin" {{ request('role') == 'super admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="guest" {{ request('role') == 'guest' ? 'selected' : '' }}>Guest</option>
                </select>

                {{-- Buttons --}}
                <button type="submit" class="btn btn-primary btn-fx click-ripple">
                    <i class="las la-filter icon-tilt"></i> Filter
                </button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary btn-fx click-ripple">
                    <i class="las la-redo icon-tilt"></i> Reset
                </a>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="card card-hover shadow-sm" id="userCard">
                <div class="card-body">
                    <div class="table-responsive rounded mb-3">
                        <table class="table table-striped table-hover">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Dibuat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="ligth-body">
                                @forelse ($user as $u)
                                    <tr class="row-anim"
                                        style="animation-delay: {{ $loop->index * 0.03 }}s;">
                                        {{-- kalau pakai paginate() --}}
                                        @if (method_exists($user, 'firstItem'))
                                            <td>{{ $loop->iteration + $user->firstItem() - 1 }}</td>
                                        @else
                                            {{-- kalau cuma collection biasa --}}
                                            <td>{{ $loop->iteration }}</td>
                                        @endif

                                        {{-- FOTO --}}
                                        <td class="text-center">
                                            @php
                                                $role = strtolower($u->role ?? '');
                                                $jk = strtolower($u->jenis_kelamin ?? '');
                                                $isLaki = str_contains($jk, 'laki');

                                                $guestAvatar = $isLaki
                                                    ? asset('template/assets/images/user/man.png')
                                                    : asset('template/assets/images/user/woman.png');

                                                $defaultAvatar = asset('template/assets/images/user/default.png');
                                            @endphp

                                            @if ($u->foto)
                                                <img src="{{ asset('storage/' . $u->foto) }}"
                                                    class="rounded-circle img-fluid avatar-40 avatar-fx"
                                                    style="object-fit: cover;"
                                                    alt="Foto {{ $u->nama }}">
                                            @else
                                                @if ($role === 'guest')
                                                    <img src="{{ $guestAvatar }}"
                                                        class="rounded-circle img-fluid avatar-40 avatar-fx"
                                                        style="object-fit: cover;"
                                                        alt="Guest avatar {{ $u->nama }}">
                                                @else
                                                    <img src="{{ $defaultAvatar }}"
                                                        class="rounded-circle img-fluid avatar-40 avatar-fx"
                                                        style="object-fit: cover;"
                                                        alt="Default avatar">
                                                @endif
                                            @endif
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="font-weight-bold">{{ $u->nama }}</td>

                                        {{-- EMAIL --}}
                                        <td>{{ $u->email }}</td>

                                        {{-- ROLE --}}
                                        <td>
                                            @php $role = strtolower($u->role ?? ''); @endphp

                                            @if ($role === 'super admin')
                                                <span class="badge bg-danger text-white px-3 py-2 badge-fx" style="border-radius: 8px;">
                                                    Super Admin
                                                </span>
                                            @elseif ($role === 'admin')
                                                <span class="badge bg-primary text-white px-3 py-2 badge-fx" style="border-radius: 8px;">
                                                    Admin
                                                </span>
                                            @elseif ($role === 'petugas')
                                                <span class="badge bg-success text-white px-3 py-2 badge-fx" style="border-radius: 8px;">
                                                    Petugas
                                                </span>
                                            @else
                                                <span class="badge bg-secondary text-white px-3 py-2 badge-fx" style="border-radius: 8px;">
                                                    Guest
                                                </span>
                                            @endif
                                        </td>

                                        {{-- TANGGAL DIBUAT --}}
                                        <td>{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</td>

                                        {{-- AKSI --}}
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                                <a href="{{ route('user.show', $u->id) }}"
                                                    class="badge badge-info action-fx click-ripple" title="Detail">
                                                    <i class="ri-eye-line"></i>
                                                </a>

                                                <a href="{{ route('user.edit', $u->id) }}"
                                                    class="badge bg-success action-fx click-ripple" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </a>

                                                <form action="{{ route('user.destroy', $u->id) }}" method="POST"
                                                    class="d-inline deleteForm"
                                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="badge bg-warning border-0 action-fx click-ripple"
                                                        style="cursor: pointer;" title="Hapus">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data user.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    @if (method_exists($user, 'links'))
                        <div class="mt-3">
                            {{ $user->links('pagination::custom') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* ========= Page animate ========= */
    .page-animate {
        animation: pageFadeIn .6s ease both;
    }
    @keyframes pageFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ========= Card hover ========= */
    .card-hover {
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(0,0,0,.10) !important;
    }

    /* ========= Table row hover + stagger ========= */
    .table-hover tbody tr {
        transition: transform .2s ease, background .2s ease;
    }
    .table-hover tbody tr:hover {
        background: rgba(0,123,255,.06) !important;
        transform: scale(1.004);
    }
    .row-anim {
        opacity: 0;
        animation: rowIn .45s ease both;
    }
    @keyframes rowIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ========= Input focus ========= */
    .input-fx:focus {
        box-shadow: 0 0 0 .2rem rgba(0,123,255,.15);
        border-color: rgba(0,123,255,.35);
    }

    /* ========= Buttons fancy ========= */
    .btn-fx {
        position: relative;
        overflow: hidden;
        transform: translateZ(0);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .btn-fx:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 18px rgba(0,0,0,.12);
    }
    .btn-fx:active {
        transform: translateY(0) scale(.98);
        box-shadow: none;
    }

    /* ========= Icon tilt ========= */
    .icon-tilt {
        display: inline-block;
        transition: transform .25s ease;
    }
    .btn:hover .icon-tilt {
        transform: rotate(-8deg) scale(1.05);
    }

    /* ========= Action badges animation ========= */
    .action-fx {
        transition: transform .2s ease, filter .2s ease;
        border-radius: 10px;
        padding: 8px 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
    }
    .action-fx:hover {
        transform: translateY(-1px) scale(1.03);
        filter: brightness(1.05);
    }
    .action-fx:active {
        transform: scale(.96);
    }

    /* ========= Avatar hover ========= */
    .avatar-fx {
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .avatar-fx:hover {
        transform: scale(1.07);
        box-shadow: 0 10px 20px rgba(0,0,0,.12);
    }

    /* ========= Badge hover ========= */
    .badge-fx {
        transition: transform .2s ease;
    }
    .badge-fx:hover {
        transform: scale(1.03);
    }

    /* ========= Click ripple effect ========= */
    .click-ripple {
        position: relative;
        overflow: hidden;
    }
    .click-ripple .ripple {
        position: absolute;
        border-radius: 50%;
        transform: scale(0);
        animation: rippleAnim .55s ease-out;
        background: rgba(255,255,255,.45);
        pointer-events: none;
    }
    @keyframes rippleAnim {
        to { transform: scale(3.2); opacity: 0; }
    }

    /* ========= Click bounce (small pop) ========= */
    .click-pop {
        animation: clickPop .22s ease;
    }
    @keyframes clickPop {
        0%   { transform: scale(1); }
        50%  { transform: scale(.95); }
        100% { transform: scale(1); }
    }

    /* ========= Shimmer while submitting ========= */
    .shimmer {
        position: relative;
    }
    .shimmer::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,.55) 50%, rgba(255,255,255,0) 100%);
        background-size: 200% 100%;
        animation: shimmer 1.1s linear infinite;
        pointer-events: none;
        border-radius: 12px;
    }
    @keyframes shimmer {
        from { background-position: 200% 0; }
        to   { background-position: -200% 0; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto submit search (punyamu) + animasi ripple & click pop
    document.addEventListener('DOMContentLoaded', function () {

        // ====== Search auto submit ======
        const searchInputUser = document.getElementById('searchInputUser');
        let typingTimerUser;
        const typingDelayUser = 500;

        if (searchInputUser) {
            searchInputUser.addEventListener('keyup', () => {
                clearTimeout(typingTimerUser);
                typingTimerUser = setTimeout(() => {
                    document.getElementById('filterFormUser').submit();
                }, typingDelayUser);
            });

            searchInputUser.addEventListener('keydown', () => {
                clearTimeout(typingTimerUser);
            });
        }

        // ====== Shimmer saat submit filter/search ======
        const form = document.getElementById('filterFormUser');
        const card = document.getElementById('userCard');

        if (form) {
            form.addEventListener('submit', function () {
                if (card) card.classList.add('shimmer');
            });
        }

        // ====== Ripple effect untuk semua elemen .click-ripple ======
        document.querySelectorAll('.click-ripple').forEach(el => {
            el.addEventListener('click', function (e) {
                // click pop kecil
                el.classList.remove('click-pop');
                void el.offsetWidth;
                el.classList.add('click-pop');

                // bikin ripple
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');

                const rect = el.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                ripple.style.width = ripple.style.height = size + 'px';

                const x = (e.clientX - rect.left) - size / 2;
                const y = (e.clientY - rect.top) - size / 2;
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';

                // bersihkan ripple lama
                const old = el.querySelector('.ripple');
                if (old) old.remove();

                el.appendChild(ripple);

                // auto hapus ripple setelah animasi
                setTimeout(() => ripple.remove(), 600);
            });
        });
    });
</script>
@endpush
