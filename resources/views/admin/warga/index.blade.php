@extends('layouts_admin.app')

@section('konten')
    <div class="row page-animate">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title }}</h4>
                </div>
                <a class="btn btn-primary add-list btn-fx click-ripple" href="{{ route('warga.create') }}">
                    <i class="las la-plus mr-3 icon-tilt"></i> Tambah Warga
                </a>
            </div>
        </div>

        {{-- FILTER & SEARCH --}}
        <div class="col-lg-12 mb-3">
            <form method="GET" action="{{ route('warga.index') }}" class="d-flex flex-wrap" style="gap: 10px;"
                id="filterFormWarga">

                {{-- Search --}}
                <input type="text" name="search" class="form-control input-fx" placeholder="Cari nama / email..."
                    value="{{ request('search') }}" style="max-width: 250px;" id="searchInputWarga">

                {{-- Gender Filter --}}
                <select name="gender" class="form-control input-fx" style="max-width: 160px;"
                    onchange="document.getElementById('filterFormWarga').submit()">
                    <option value="">Semua Gender</option>
                    <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>

                {{-- Buttons --}}
                <button type="submit" class="btn btn-primary btn-fx click-ripple">
                    <i class="las la-filter icon-tilt"></i> Filter
                </button>
                <a href="{{ route('warga.index') }}" class="btn btn-secondary btn-fx click-ripple">
                    <i class="las la-redo icon-tilt"></i> Reset
                </a>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="card card-hover shadow-sm" id="wargaCard">
                <div class="card-body">

                    <div class="table-responsive rounded mb-3">
                        <table class="table table-striped table-hover">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>email</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="ligth-body">
                                @forelse ($warga as $w)
                                    <tr class="row-anim" style="animation-delay: {{ $loop->index * 0.03 }}s;">
                                        <td>{{ $loop->iteration + $warga->firstItem() - 1 }}</td>

                                        <td class="text-center">
                                            @if ($w->user && $w->user->foto)
                                                <img src="{{ asset('storage/' . $w->user->foto) }}"
                                                    class="rounded img-fluid avatar-40 avatar-fx"
                                                    style="object-fit:cover;" alt="profile">
                                            @else
                                                @if ($w->jenis_kelamin == 'Laki-laki')
                                                    <img class="rounded img-fluid avatar-40 avatar-fx"
                                                        style="object-fit:cover;"
                                                        src="{{ asset('template/assets/images/user/man.png') }}"
                                                        alt="profile">
                                                @else
                                                    <img class="rounded img-fluid avatar-40 avatar-fx"
                                                        style="object-fit:cover;"
                                                        src="{{ asset('template/assets/images/user/woman.png') }}"
                                                        alt="profile">
                                                @endif
                                            @endif
                                        </td>

                                        <td>{{ $w->user->email ?? '-' }}</td>
                                        <td class="font-weight-bold">{{ $w->nama }}</td>

                                        {{-- Jenis Kelamin --}}
                                        <td class="text-center">
                                            @if ($w->jenis_kelamin == 'Laki-laki')
                                                <span class="badge bg-primary-light text-primary px-3 py-2 badge-fx"
                                                    style="border-radius: 8px;">
                                                    Laki-laki
                                                </span>
                                            @else
                                                <span class="badge bg-pink-light text-danger px-3 py-2 badge-fx"
                                                    style="border-radius: 8px;">
                                                    Perempuan
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Role --}}
                                        <td>
                                            <span
                                                class="badge {{ $w->user && $w->user->role == 'admin' ? 'bg-primary' : 'bg-secondary' }} badge-fx px-3 py-2"
                                                style="border-radius: 8px;">
                                                {{ $w->user->role ?? 'guest' }}
                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                                <a href="{{ route('warga.show', $w->warga_id) }}"
                                                    class="badge badge-info action-fx click-ripple" title="Detail">
                                                    <i class="ri-eye-line"></i>
                                                </a>

                                                <a href="{{ route('warga.edit', $w->warga_id) }}"
                                                    class="badge bg-success action-fx click-ripple" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </a>

                                                {{-- ✅ PERBAIKAN: Hapus pakai FORM DELETE --}}
                                                <form action="{{ route('warga.destroy', $w->warga_id) }}" method="POST"
                                                    class="d-inline deleteForm">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="badge bg-warning border-0 action-fx click-ripple"
                                                        style="cursor:pointer;" title="Hapus">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-3">
                        {{ $warga->links('pagination::custom') }}
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
<style>
    .page-animate { animation: pageFadeIn .6s ease both; }
    @keyframes pageFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .card-hover { transition: transform .25s ease, box-shadow .25s ease; }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(0,0,0,.10) !important;
    }

    .table-hover tbody tr { transition: transform .2s ease, background .2s ease; }
    .table-hover tbody tr:hover {
        background: rgba(0,123,255,.06) !important;
        transform: scale(1.004);
    }

    .row-anim { opacity: 0; animation: rowIn .45s ease both; }
    @keyframes rowIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .input-fx:focus {
        box-shadow: 0 0 0 .2rem rgba(0,123,255,.15);
        border-color: rgba(0,123,255,.35);
    }

    .btn-fx {
        position: relative;
        overflow: hidden;
        transform: translateZ(0);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .btn-fx:hover { transform: translateY(-1px); box-shadow: 0 10px 18px rgba(0,0,0,.12); }
    .btn-fx:active { transform: translateY(0) scale(.98); box-shadow: none; }

    .icon-tilt { display: inline-block; transition: transform .25s ease; }
    .btn:hover .icon-tilt { transform: rotate(-8deg) scale(1.05); }

    .action-fx {
        transition: transform .2s ease, filter .2s ease;
        border-radius: 10px;
        padding: 8px 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
    }
    .action-fx:hover { transform: translateY(-1px) scale(1.03); filter: brightness(1.05); }
    .action-fx:active { transform: scale(.96); }

    .badge-fx { transition: transform .2s ease; }
    .badge-fx:hover { transform: scale(1.03); }

    .avatar-fx { transition: transform .25s ease, box-shadow .25s ease; }
    .avatar-fx:hover { transform: scale(1.07); box-shadow: 0 10px 20px rgba(0,0,0,.12); }

    .click-ripple { position: relative; overflow: hidden; }
    .click-ripple .ripple {
        position: absolute;
        border-radius: 50%;
        transform: scale(0);
        animation: rippleAnim .55s ease-out;
        background: rgba(255,255,255,.45);
        pointer-events: none;
    }
    @keyframes rippleAnim { to { transform: scale(3.2); opacity: 0; } }

    .click-pop { animation: clickPop .22s ease; }
    @keyframes clickPop {
        0% { transform: scale(1); }
        50% { transform: scale(.95); }
        100% { transform: scale(1); }
    }

    .shimmer { position: relative; }
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
    document.addEventListener('DOMContentLoaded', function () {

        // Auto submit search
        const searchInputWarga = document.getElementById('searchInputWarga');
        let typingTimerWarga;
        const typingDelayWarga = 500;

        if (searchInputWarga) {
            searchInputWarga.addEventListener('keyup', () => {
                clearTimeout(typingTimerWarga);
                typingTimerWarga = setTimeout(() => {
                    document.getElementById('filterFormWarga').submit();
                }, typingDelayWarga);
            });

            searchInputWarga.addEventListener('keydown', () => {
                clearTimeout(typingTimerWarga);
            });
        }

        // Shimmer saat submit
        const form = document.getElementById('filterFormWarga');
        const card = document.getElementById('wargaCard');
        if (form) {
            form.addEventListener('submit', function () {
                if (card) card.classList.add('shimmer');
            });
        }

        // Confirm delete (biar user yakin, tapi tetap animasi jalan)
        document.querySelectorAll('.deleteForm').forEach(f => {
            f.addEventListener('submit', function (e) {
                if (!confirm('Yakin ingin menghapus data warga ini?')) {
                    e.preventDefault();
                }
            });
        });

        // Ripple + Pop on click
        document.querySelectorAll('.click-ripple').forEach(el => {
            el.addEventListener('click', function (e) {
                el.classList.remove('click-pop');
                void el.offsetWidth;
                el.classList.add('click-pop');

                const ripple = document.createElement('span');
                ripple.classList.add('ripple');

                const rect = el.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                ripple.style.width = ripple.style.height = size + 'px';

                const x = (e.clientX - rect.left) - size / 2;
                const y = (e.clientY - rect.top) - size / 2;
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';

                const old = el.querySelector('.ripple');
                if (old) old.remove();

                el.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });
        });
    });
</script>
@endpush
