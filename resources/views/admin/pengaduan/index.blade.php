@extends('layouts_admin.app')

@section('konten')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">{{ $title }}</h4>
            </div>
            <a href="{{ route('admin.pengaduan.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i> Tambah Pengaduan
            </a>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive rounded mb-3">
                    <table id="datatable" class="table table-striped">
                        <thead class="bg-white text-uppercase">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Pelapor</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengaduan as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->judul }}</td>
                                    <td>{{ $p->warga->nama ?? 'Anonim' }}</td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge
                                            @if($p->status == 'baru') badge-secondary
                                            @elseif($p->status == 'proses') badge-warning
                                            @elseif($p->status == 'ditindaklanjuti') badge-info
                                            @else badge-success @endif">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.pengaduan.show', $p->pengaduan_id) }}" class="btn btn-info btn-sm" title="Detail"><i class="ri-eye-line"></i></a>
                                        <a href="{{ route('admin.pengaduan.edit', $p->pengaduan_id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="ri-edit-line"></i></a>
                                        <form action="{{ route('admin.pengaduan.destroy', $p->pengaduan_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                                        </form>
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
