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

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive rounded mb-3">
                        <table id="datatable" class="table data-tables table-striped">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="ligth-body">
                                @foreach ($warga as $w)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        {{-- FOTO --}}
                                        <td class="text-center">
                                            @if ($w->user && $w->user->foto)
                                                <img src="{{ asset('storage/' . $w->user->foto) }}"
                                                    class="rounded img-fluid avatar-40" alt="profile">
                                            @else
                                                @if($w->jenis_kelamin == 'Laki-laki')
                                                    <img class="rounded img-fluid avatar-40"
                                                        src="{{ asset('template/assets/images/user/man.png') }}" alt="profile">
                                                @else
                                                    <img class="rounded img-fluid avatar-40"
                                                        src="{{ asset('template/assets/images/user/woman.png') }}" alt="profile">
                                                @endif

                                            @endif
                                        </td>

                                        {{-- USERNAME --}}
                                        <td>{{ $w->user->username ?? '-' }}</td>

                                        {{-- NAMA WARGA --}}
                                        <td>{{ $w->nama }}</td>

                                        {{-- ROLE USER --}}
                                        <td>
                                            <span
                                                class="badge {{ ($w->user && $w->user->role == 'admin') ? 'bg-primary' : 'bg-secondary' }}">
                                                {{ $w->user->role ?? 'guest' }}
                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center list-action"
                                                style="gap: 5px;">

                                                <!-- Detail -->
                                                <a href="{{ route('admin.warga.show', $w->warga_id) }}" class="badge badge-info"
                                                    data-toggle="tooltip" title="Detail">
                                                    <i class="ri-eye-line"></i>
                                                </a>

                                                <!-- Edit -->
                                                <a href="{{ route('admin.warga.edit', $w->warga_id) }}" class="badge bg-success"
                                                    data-toggle="tooltip" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </a>

                                                <!-- Delete -->
                                                <a href="{{ route('admin.warga.destroy', $w->warga_id) }}"
                                                    class="badge bg-warning delete-btn" data-toggle="tooltip" title="Delete"
                                                    data-id="{{ $w->warga_id }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>

                                                <form id="delete-form-{{ $w->warga_id }}" method="POST"
                                                    action="{{ route('admin.warga.destroy', $w->warga_id) }}"
                                                    style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
