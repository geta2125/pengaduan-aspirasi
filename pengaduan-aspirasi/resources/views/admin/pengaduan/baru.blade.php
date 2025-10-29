@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title }}</h4>
                </div>
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
                                    <th>Judul Pengaduan</th>
                                    <th>Pelapor</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="ligth-body">
                                @foreach ($pengaduan as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->judul }}</td>
                                        <td>{{ $p->warga->nama ?? 'Anonim' }}</td>
                                        <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            @php
                                                $statusClass = match (strtolower($p->status)) {
                                                    'baru' => 'badge-secondary',
                                                    'proses' => 'badge-warning',
                                                    'ditindaklanjuti' => 'badge-info',
                                                    'selesai' => 'badge-success',
                                                    default => 'badge-dark',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($p->status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#detailModal{{ $p->id }}" title="Detail">
                                                    <i class="ri-eye-line mr-0"></i>
                                                </button>

                                                <a href="{{ route('admin.pengaduan.tindaklanjut', $p->pengaduan_id) }}"
                                                    class="btn btn-sm btn-primary" data-toggle="tooltip" title="Tindak Lanjut">
                                                    <i class="ri-checkbox-line mr-0"></i>
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

    @foreach ($pengaduan as $p)
    @php
        $statusClass = match (strtolower($p->status)) {
            'baru' => 'badge-secondary',
            'proses' => 'badge-warning',
            'ditindaklanjuti' => 'badge-info',
            'selesai' => 'badge-success',
            default => 'badge-dark',
        };
    @endphp
    <div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1" role="dialog"
        aria-labelledby="detailModalLabel{{ $p->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="detailModalLabel{{ $p->id }}">
                        Detail Pengaduan: {{ $p->judul }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Info Pengaduan --}}
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
                            <strong>Lokasi:</strong> <span>{{ $p->lokasi_text ?? '-' }} (RT/RW: {{ $p->rt ?? '-' }}/{{ $p->rw ?? '-' }})</span>
                        </li>
                    </ul>

                    {{-- Deskripsi --}}
                    <h6 class="mt-3">Deskripsi Lengkap:</h6>
                    <div class="p-3 border rounded mb-3">
                        <p class="mb-0">{{ $p->deskripsi }}</p>
                    </div>

                    {{-- Lampiran --}}
                    @if ($p->media)
                        @php
                            $fileExt = pathinfo($p->media->file_url, PATHINFO_EXTENSION);
                            $fileUrl = asset('storage/' . $p->media->file_url);
                        @endphp
                        <h6 class="mt-3">Lampiran:</h6>
                        @if(in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ $fileUrl }}" alt="Lampiran" class="img-fluid img-thumbnail mb-3" style="max-height:200px;">
                        @elseif(strtolower($fileExt) == 'pdf')
                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-info mb-3"><i class="ri-file-pdf-line me-1"></i> Lihat PDF</a>
                        @else
                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-secondary mb-3"><i class="ri-download-line me-1"></i> Lihat Lampiran</a>
                        @endif
                    @else
                        <p class="text-muted">Tidak ada lampiran.</p>
                    @endif

                    {{-- Tindak Lanjut --}}
                    <h6 class="mt-3">Riwayat Tindak Lanjut:</h6>
                    @if($p->tindak_lanjut && $p->tindak_lanjut->count())
                        <ul class="list-group mb-3">
                            @foreach($p->tindak_lanjut as $tl)
                                <li class="list-group-item">
                                    <strong>Aksi:</strong> {{ $tl->aksi }} <br>
                                    <strong>Petugas:</strong> {{ $tl->petugas ?? '-' }} <br>
                                    <strong>Catatan:</strong> {{ $tl->catatan ?? '-' }} <br>
                                    <small class="text-muted">Tanggal: {{ $tl->created_at->format('d-m-Y H:i') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada tindak lanjut.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection