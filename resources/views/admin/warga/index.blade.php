@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title }}</h4>
                </div>
                <a class="btn btn-primary add-list" href="{{ route('admin.warga.create') }}">
                    <i class="las la-plus mr-3"></i> Tambah Warga
                </a>
            </div>
        </div>

        {{-- FILTER & SEARCH --}}
        <div class="col-lg-12 mb-3">
            <form method="GET" action="{{ route('admin.warga.index') }}" class="d-flex flex-wrap" style="gap: 10px;"
                id="filterFormWarga">

                {{-- Search --}}
                <input type="text" name="search" class="form-control" placeholder="Cari nama / email..."
                    value="{{ request('search') }}" style="max-width: 250px;" id="searchInputWarga">

                {{-- Gender Filter --}}
                <select name="gender" class="form-control" style="max-width: 160px;"
                    onchange="document.getElementById('filterFormWarga').submit()">
                    <option value="">Semua Gender</option>
                    <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>

                {{-- Buttons --}}
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.warga.index') }}" class="btn btn-secondary">Reset</a>
            </form>

        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive rounded mb-3">
                        <table class="table table-striped">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>email</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th> {{-- Tambahan baru --}}
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="ligth-body">
                                @forelse ($warga as $w)
                                    <tr>
                                        <td>{{ $loop->iteration + $warga->firstItem() - 1 }}</td>

                                        <td class="text-center">
                                            @if ($w->user && $w->user->foto)
                                                <img src="{{ asset('storage/' . $w->user->foto) }}" class="rounded img-fluid avatar-40" alt="profile">
                                            @else
                                                @if($w->jenis_kelamin == 'Laki-laki')
                                                    <img class="rounded img-fluid avatar-40" src="{{ asset('template/assets/images/user/man.png') }}" alt="profile">
                                                @else
                                                        <img class="rounded img-fluid avatar-40" src="{{ asset('template/assets/images/user/woman.png') }}" alt="profile">
                                                    @endif
                                            @endif
                                                    </td>

                                                    <td>{{ $w->user->email ?? '-' }}</td>
                                                    <td>{{ $w->nama }}</td>

                                                    {{-- ===========================
                                                    Kolom Jenis Kelamin baru
                                                    =========================== --}}
                                                    <td class="text-center">
                                                        @if ($w->jenis_kelamin == 'Laki-laki')
                                                            <span class="badge bg-primary-light text-primary px-3 py-2" style="border-radius: 8px;">
                                                                Laki-laki
                                                            </span>
                                                        @else
                                                            <span class="badge bg-pink-light text-danger px-3 py-2" style="border-radius: 8px;">
                                                                Perempuan
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <span class="badge {{ ($w->user && $w->user->role == 'admin') ? 'bg-primary' : 'bg-secondary' }}">
                                                            {{ $w->user->role ?? 'guest' }}
                                                        </span>
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                                            <a href="{{ route('admin.warga.show', $w->warga_id) }}" class="badge badge-info">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                            <a href="{{ route('admin.warga.edit', $w->warga_id) }}" class="badge bg-success">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                            <a href="{{ route('admin.warga.destroy', $w->warga_id) }}" class="badge bg-warning delete-btn"
                                                                data-id="{{ $w->warga_id }}">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </a>
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

@push('scripts')
    <script>
        const searchInputWarga = document.getElementById('searchInputWarga');
        let typingTimerWarga;
        const typingDelayWarga = 500; // milidetik

        searchInputWarga.addEventListener('keyup', () => {
            clearTimeout(typingTimerWarga);
            typingTimerWarga = setTimeout(() => {
                document.getElementById('filterFormWarga').submit();
            }, typingDelayWarga);
        });

        searchInputWarga.addEventListener('keydown', () => {
            clearTimeout(typingTimerWarga);
        });
    </script>
@endpush
