@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <h4 class="mb-3">{{ $title }}</h4>

                <a class="btn btn-primary add-list" href="{{ route('admin.pengaduan.create') }}">
                    <i class="las la-plus mr-3"></i> Tambah Pengaduan
                </a>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="mb-4">
                        <div class="row align-items-end">
                            {{-- Input Pencarian Instan --}}
                            <div class="col-md-5 col-lg-6 mb-3 mb-md-0">
                                <label for="search_query" class="form-label">Cari Pengaduan (Judul/Pelapor)</label>
                                <input type="text" name="search" id="search_query" class="form-control"
                                    placeholder="Ketik judul atau pelapor..." value="{{ request('search') }}">
                            </div>

                            {{-- Filter Berdasarkan Status --}}
                            <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                                <label for="status_filter" class="form-label">Filter Status</label>
                                <select name="status" id="status_filter" class="form-control">
                                    <option value="">Semua Status</option>
                                    {{-- Asumsi Anda memiliki daftar status yang sudah di-hardcode atau dari database --}}
                                    @php
                                        $statuses = ['pending', 'proses', 'selesai'];
                                    @endphp
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="col-md-3 col-lg-3">
                                <button type="submit" class="btn btn-secondary mr-2">
                                    <i class="las la-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-secondary">
                                    <i class="las la-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive rounded mb-3">
                        <table class="table table-striped table-hover">
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
                                @forelse ($pengaduan as $index => $p)
                                    <tr>
                                        {{-- Menghitung nomor iterasi yang benar dengan paginasi --}}
                                        <td>{{ $pengaduan->firstItem() + $index }}</td>
                                        <td>{{ $p->judul }}</td>
                                        <td>{{ $p->pelapor }}</td>
                                        <td class="text-center">{{ $p->tanggal }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $p->statusClass }}">{{ ucfirst($p->status) }}</span>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#detailModal{{ $p->id }}" title="Lihat Detail">
                                                    <i class="ri-eye-line"></i>
                                                </button>

                                                @if (strtolower($p->status) === 'pending')
                                                    <a href="{{ route('admin.tindaklanjut.create', $p->pengaduan_id) }}"
                                                        class="btn btn-sm btn-danger" title="Tindak Lanjut">
                                                        <i class="ri-check-double-line"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pengaduan yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $pengaduan->links('pagination::custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal (Bagian ini tidak perlu diubah) --}}
    @foreach ($pengaduan as $p)
        <div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1" role="dialog">
            {{-- ... Konten Modal seperti sebelumnya ... --}}
            <div class="modal-dialog modal-lg">
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
                                <strong>Pelapor:</strong> <span>{{ $p->pelapor }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Kategori:</strong> <span>{{ $p->kategori }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Tanggal:</strong> <span>{{ $p->tanggal_full }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Status:</strong>
                                <span class="badge {{ $p->statusClass }}">{{ ucfirst($p->status) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Lokasi:</strong>
                                <span>{{ $p->lokasi_text }} (RT/RW: {{ $p->rt }}/{{ $p->rw }})</span>
                            </li>
                        </ul>

                        <h6 class="mt-3">Deskripsi Lengkap:</h6>
                        <div class="p-3 border rounded mb-3">
                            <p class="mb-0">{{ $p->deskripsi }}</p>
                        </div>

                        @if ($p->media)
                            <a href="{{ asset('storage/' . $p->media) }}" target="_blank" class="btn btn-sm btn-info">Lihat
                                Lampiran</a>
                        @else
                            <span class="text-muted">Tidak ada lampiran</span>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script>
        // Script untuk Pencarian Instan (tanpa tombol Filter)
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search_query');
            const statusFilter = document.getElementById('status_filter');
            const form = searchInput.closest('form');

            // Tambahkan event listener untuk input pencarian
            // Ini akan menjalankan pencarian segera setelah pengguna selesai mengetik
            let timeout = null;
            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    // Hanya submit jika filter status tidak kosong
                    // Jika Anda ingin pencarian instan mutlak, hapus pemeriksaan request('status') di Controller
                    // dan gunakan AJAX
                    if (!statusFilter.value && searchInput.value.length > 2 || searchInput.value.length === 0) {
                        form.submit();
                    }
                }, 800); // Tunda 800ms setelah ketikan terakhir
            });

            // Status Filter akan disubmit saat tombol "Terapkan Filter" diklik
        });
    </script>
@endpush
