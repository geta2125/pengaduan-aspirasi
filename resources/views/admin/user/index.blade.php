@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title ?? 'Manajemen User' }}</h4>
                </div>
                <a class="btn btn-primary add-list" href="{{ route('admin.user.create') }}">
                    <i class="las la-plus mr-3"></i> Tambah User
                </a>
            </div>
        </div>

        {{-- FILTER & SEARCH --}}
        <div class="col-lg-12 mb-3">
            <form method="GET" action="{{ route('admin.user.index') }}" class="d-flex flex-wrap" style="gap: 10px;"
                  id="filterFormUser">

                {{-- Search --}}
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama / email..."
                       value="{{ request('search') }}" style="max-width: 250px;"
                       id="searchInputUser">

                {{-- Role Filter --}}
                <select name="role" class="form-control" style="max-width: 200px;"
                        onchange="document.getElementById('filterFormUser').submit()">
                    <option value="">Semua Role</option>
                    <option value="super admin" {{ request('role') == 'super admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="guest" {{ request('role') == 'guest' ? 'selected' : '' }}>Guest</option>
                </select>

                {{-- Buttons --}}
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive rounded mb-3">
                        <table class="table table-striped">
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
                                    <tr>
                                        {{-- kalau pakai paginate() --}}
                                        @if(method_exists($user, 'firstItem'))
                                            <td>{{ $loop->iteration + $user->firstItem() - 1 }}</td>
                                        @else
                                            {{-- kalau cuma collection biasa --}}
                                            <td>{{ $loop->iteration }}</td>
                                        @endif

                                        {{-- FOTO --}}
                                        <td class="text-center">
                                            @if ($u->foto)
                                                <img src="{{ asset('storage/' . $u->foto) }}"
                                                     class="rounded img-fluid avatar-40"
                                                     style="object-fit: cover;"
                                                     alt="Foto {{ $u->nama }}">
                                            @else
                                                <img class="rounded img-fluid avatar-40"
                                                     src="{{ asset('template/assets/images/user/default.png') }}"
                                                     alt="Default avatar">
                                            @endif
                                        </td>

                                        {{-- NAMA --}}
                                        <td>{{ $u->nama }}</td>

                                        {{-- EMAIL --}}
                                        <td>{{ $u->email }}</td>

                                        {{-- ROLE --}}
                                        <td>
                                            @php
                                                $role = strtolower($u->role);
                                            @endphp
                                            @if ($role === 'super admin')
                                                <span class="badge bg-danger text-white px-3 py-2" style="border-radius: 8px;">
                                                    Super Admin
                                                </span>
                                            @elseif ($role === 'admin')
                                                <span class="badge bg-primary text-white px-3 py-2" style="border-radius: 8px;">
                                                    Admin
                                                </span>
                                            @elseif ($role === 'petugas')
                                                <span class="badge bg-success text-white px-3 py-2" style="border-radius: 8px;">
                                                    Petugas
                                                </span>
                                            @else
                                                <span class="badge bg-secondary text-white px-3 py-2" style="border-radius: 8px;">
                                                    Guest
                                                </span>
                                            @endif
                                        </td>

                                        {{-- TANGGAL DIBUAT --}}
                                        <td>{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</td>

                                        {{-- AKSI --}}
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                                <a href="{{ route('admin.user.show', $u->id) }}" class="badge badge-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.user.edit', $u->id) }}" class="badge bg-success">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                <form action="{{ route('admin.user.destroy', $u->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-warning border-0"
                                                            style="cursor: pointer;">
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
                    @if(method_exists($user, 'links'))
                        <div class="mt-3">
                            {{ $user->links('pagination::custom') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const searchInputUser = document.getElementById('searchInputUser');
        let typingTimerUser;
        const typingDelayUser = 500; // milidetik

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
    </script>
@endpush
