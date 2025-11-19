@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title }}</h4>
                </div>
                <a class="btn btn-primary add-list" href="{{ route('admin.pengaduan.create') }}">
                    <i class="las la-plus mr-3"></i> Tambah Pengaduan
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive rounded mb-3">
                        <table id="datatable" class="table data-tables table-striped">
                            <thead class="bg-white text-uppercase">
                                <tr>
                                    <th>No</th>
                                    <th>Judul Pengaduan</th>
                                    <th>Pelapor</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengaduan as $p)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $p->judul }}</td>
                                                                        <td>{{ $p->warga->nama ?? 'Anonim' }}</td>
                                                                        <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                                                                        <td class="text-center">
                                                                            @php
    $statusClass = match (strtolower($p->status)) {
        'pending' => 'badge-light',
        'proses' => 'badge-warning',
        'selesai' => 'badge-success',
    };
                                                                            @endphp
                                                                            <span class="badge {{ $statusClass }}">{{ ucfirst($p->status) }}</span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="d-flex align-items-center justify-content-center list-action" style="gap: 5px;">
                                                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal{{ $p->id }}"
                                                                                    title="Detail">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </button>

                                                                                @if (strtolower($p->status) === 'pending')
                                                                                    <a href="{{ route('admin.tindaklanjut.create', $p->pengaduan_id) }}" class="btn btn-sm btn-danger"
                                                                                        title="Tindak Lanjut">
                                                                                        <i class="ri-check-double-line"></i>
                                                                                    </a>
                                                                                @endif
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

    <!-- Modal Detail -->
    @foreach ($pengaduan as $p)

        <div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title">Detail Pengaduan: {{ $p->judul }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Judul:</strong> <span>{{ $p->judul }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Pelapor:</strong> <span>{{ $p->warga->nama ?? 'Anonim' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Kategori:</strong> <span>{{ $p->kategori->nama ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Tanggal:</strong> <span>{{ $p->created_at->format('d F Y, H:i') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Status:</strong> <span class="badge {{ $statusClass }}">{{ ucfirst($p->status) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Lokasi:</strong> <span>{{ $p->lokasi_text ?? '-' }} (RT/RW:
                                    {{ $p->rt ?? '-' }}/{{ $p->rw ?? '-' }})</span>
                            </li>
                        </ul>

                        <h6 class="mt-3">Deskripsi Lengkap:</h6>
                        <div class="p-3 border rounded mb-3">
                            <p class="mb-0">{{ $p->deskripsi }}</p>
                        </div>

                        @if ($p->media)
                            <a href="{{ asset('storage/' . $p->media->file_url) }}" target="_blank" class="btn btn-sm btn-info">
                                Lihat Lampiran
                            </a>
                        @else
                            <span class="text-muted">Tidak ada lampiran</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
