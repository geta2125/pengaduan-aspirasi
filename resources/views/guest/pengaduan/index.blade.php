@extends('layouts_guest.app') {{-- Sesuaikan dengan layout --}}

@section('konten')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Riwayat Pengaduan</h4>
                <a href="{{ route('guest.pengaduan.ajukan') }}" class="btn btn-primary">Ajukan Pengaduan</a>
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
                            @foreach($pengaduan as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->nomor_tiket }}</td>
                                    <td>{{ $p->judul }}</td>
                                    <td>{{ $p->kategori->nama ?? '-' }}</td>
                                    <td>
                                        @if($p->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($p->status == 'proses')
                                            <span class="badge bg-primary">Proses</span>
                                        @elseif($p->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ $p->lokasi_text ?? '-' }}</td>
                                    <td>{{ $p->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('guest.pengaduan.edit', $p->pengaduan_id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="{{ route('guest.pengaduan.show', $p->pengaduan_id) }}"
                                            class="btn btn-sm btn-success">
                                            <i class="bi bi-eye"></i> Detail
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
@endsection

@push('scripts')
    {{-- DataTables CSS & JS --}}

    <script>
        $(document).ready(function () {
            $('#pengaduanTable').DataTable({
                "order": [[5, "desc"]], // Urutkan berdasarkan tanggal desc
                "columnDefs": [
                    { "orderable": false, "targets": 6 } // Kolom aksi tidak bisa di-sort
                ],
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "zeroRecords": "Tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(disaring dari _MAX_ total entri)",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Berikutnya"
                    }
                }
            });
        });
    </script>
@endpush