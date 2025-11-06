@extends('layouts_admin.app')

@section('konten')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">{{ $title }}</h4>
            </div>
            <div>
                <!-- Tombol Tambah -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                    <i class="ri-add-line"></i> Tambah Pengaduan
                </button>
            </div>
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
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        <a href="{{ route('admin.pengaduan.tindaklanjut', $p->pengaduan_id) }}"
                                            class="btn btn-sm btn-primary" title="Tindak Lanjut">
                                            <i class="ri-checkbox-line"></i>
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

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="createModalLabel">Tambah Pengaduan Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Pengaduan *</label>
                    <input type="text" name="judul" class="form-control" placeholder="Masukkan judul pengaduan" required>
                </div>

                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tuliskan deskripsi pengaduan" required></textarea>
                </div>

                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi_text" class="form-control" placeholder="Contoh: Jl. Mawar No.5">
                </div>

                <div class="form-row">
                    <div class="col">
                        <label>RT</label>
                        <input type="text" name="rt" class="form-control" placeholder="RT">
                    </div>
                    <div class="col">
                        <label>RW</label>
                        <input type="text" name="rw" class="form-control" placeholder="RW">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Lampiran (opsional)</label>
                    <input type="file" name="file_url" class="form-control">
                    <small class="text-muted">Bisa berupa gambar atau PDF</small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="baru">Baru</option>
                        <option value="proses">Proses</option>
                        <option value="ditindaklanjuti">Ditindaklanjuti</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail -->
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
                        <strong>Lokasi:</strong> <span>{{ $p->lokasi_text ?? '-' }} (RT/RW: {{ $p->rt ?? '-' }}/{{ $p->rw ?? '-' }})</span>
                    </li>
                </ul>

                <h6 class="mt-3">Deskripsi Lengkap:</h6>
                <div class="p-3 border rounded mb-3">
                    <p class="mb-0">{{ $p->deskripsi }}</p>
                </div>

                @if ($p->media)
                    @php
                        $fileExt = pathinfo($p->media->file_url, PATHINFO_EXTENSION);
                        $fileUrl = asset('storage/' . $p->media->file_url);
                    @endphp
                    <h6 class="mt-3">Lampiran:</h6>
                    @if (in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ $fileUrl }}" class="img-fluid img-thumbnail mb-3" style="max-height:200px;">
                    @elseif (strtolower($fileExt) == 'pdf')
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-info mb-3"><i class="ri-file-pdf-line me-1"></i> Lihat PDF</a>
                    @else
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-secondary mb-3"><i class="ri-download-line me-1"></i> Lihat Lampiran</a>
                    @endif
                @else
                    <p class="text-muted">Tidak ada lampiran.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
