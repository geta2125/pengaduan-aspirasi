@extends('layouts_guest.app')

@section('konten')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Riwayat Pengaduan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="pengaduanTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Tiket</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nomor_tiket }}</td>
                            <td>{{ $p->judul }}</td>
                            <td>{{ $p->kategori->nama ?? '-' }}</td>
                            <td>
                                @switch($p->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('proses')
                                        <span class="badge bg-primary">Proses</span>
                                        @break
                                    @case('selesai')
                                        <span class="badge bg-success">Selesai</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">Unknown</span>
                                @endswitch
                            </td>
                            <td>{{ $p->lokasi_text ?? '-' }}</td>
                            <td>{{ $p->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('guest.penilaian.create', $p->pengaduan_id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-plus"></i> Penilaian
                                </a>
                                <a href="{{ route('guest.pengaduan.show', $p->pengaduan_id) }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada pengaduan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#pengaduanTable').DataTable({
        order: [[6, "desc"]], // urutkan berdasarkan tanggal desc
        columnDefs: [
            { orderable: false, targets: [7] } // kolom Aksi tidak bisa di-sort
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            zeroRecords: "Tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
            infoFiltered: "(disaring dari _MAX_ total entri)",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    });
});
</script>
@endpush
