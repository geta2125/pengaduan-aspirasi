@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12 mb-3 d-flex justify-content-between align-items-center">
            <h4>{{ $title }}</h4>

        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive rounded mb-3">
                        <table id="datatable" class="table data-tables table-striped">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>No</th>
                                    <th>Judul Pengaduan</th>
                                    <th>Pelapor</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tindaklanjut as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->pengaduan->judul ?? '-' }}</td>
                                        <td>{{ $p->pengaduan->warga->nama ?? 'Anonim' }}</td>
                                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <span
                                                class="badge
                                            @if ($p->pengaduan->status == 'pending') badge-secondary
                                            @elseif($p->pengaduan->status == 'proses') badge-warning
                                            @elseif($p->pengaduan->status == 'selesai') badge-success
                                            @else badge-info @endif">
                                                {{ ucfirst($p->pengaduan->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.tindaklanjut.show', $p->tindak_id) }}"
                                                class="badge bg-info">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.tindaklanjut.edit', $p->tindak_id) }}"
                                                class="badge bg-success">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <a href="{{ route('admin.tindaklanjut.destroy', $p->tindak_id) }}"
                                                class="badge bg-warning delete-btn" data-toggle="tooltip"
                                                data-placement="top" title="Delete" data-id="{{ $p->tindak_id }}">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
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
