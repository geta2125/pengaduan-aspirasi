@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title }}</h4>
                </div>
                <a href="{{ route('admin.kategori-pengaduan.create') }}" class="btn btn-primary add-list">
                    <i class="las la-plus mr-3"></i> Tambah Kategori Pengaduan
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
                                    <th>Nama</th>
                                    <th class="text-center">SLA (hari)</th>
                                    <th class="text-center">Prioritas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="ligth-body">
                                @foreach ($kategori as $k)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td class="text-center">{{ $k->sla_hari }}</td>
                                        <td class="text-center">
                                            @php
                                                $badgeClass = match (strtolower($k->prioritas)) {
                                                    'tinggi' => 'badge-danger',
                                                    'sedang' => 'badge-warning',
                                                    'rendah' => 'badge-success',
                                                    default => 'badge-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ ucfirst($k->prioritas) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center list-action"
                                                style="gap: 5px;">
                                                <a href="{{ route('admin.kategori-pengaduan.show', $k->id) }}"
                                                    class="badge badge-info" data-toggle="tooltip" title="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.kategori-pengaduan.edit', $k->id) }}"
                                                    class="badge bg-success" data-toggle="tooltip" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                <a href="{{ route('admin.kategori-pengaduan.destroy', $k->id) }}"
                                                    class="badge bg-warning delete-btn" data-toggle="tooltip"
                                                    data-placement="top" title="Delete" data-id="{{ $k->id }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
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