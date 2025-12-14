@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <h4 class="mb-3">📊 {{ $title }}</h4>
                <a class="btn btn-primary add-list" href="{{ route('pengaduan.create') }}">
                    <i class="las la-plus mr-3"></i> Tambah Pengaduan
                </a>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    {{-- Form Filter & Pencarian --}}
                    <form method="GET" action="{{ route('pengaduan.index') }}" class="mb-4">
                        <div class="row align-items-end">
                            {{-- Input Pencarian --}}
                            <div class="col-md-5 col-lg-6 mb-3 mb-md-0">
                                <label for="search_query" class="form-label">Cari Pengaduan (Judul/Pelapor)</label>
                                <div class="input-group">
                                    <input type="text" name="search" id="search_query" class="form-control"
                                        placeholder="Ketik judul atau nama pelapor..." value="{{ request('search') }}">
                                </div>
                            </div>

                            {{-- Filter Status --}}
                            <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                                <label for="status_filter" class="form-label">Filter Status</label>
                                <select name="status" id="status_filter" class="form-control">
                                    <option value="">Semua Status</option>
                                    @php
                                        $statuses = ['pending', 'proses', 'selesai'];
                                    @endphp
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ request('status') === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="col-md-3 col-lg-3">
                                <button type="submit" class="btn btn-secondary mr-2" title="Terapkan Filter">
                                    <i class="las la-filter"></i> Filter
                                </button>
                                <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary"
                                    title="Reset Filter">
                                    <i class="las la-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- Tabel Data --}}
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
                                        {{-- Nomor Urut (Memperhitungkan Pagination) --}}
                                        <td>{{ $pengaduan->firstItem() + $index }}</td>

                                        <td>
                                            <span class="font-weight-bold">{{ $p->judul }}</span>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($p->deskripsi, 50) }}</small>
                                        </td>

                                        <td>
                                            {{ $p->pelapor }}
                                            <br>
                                            <small class="text-muted">{{ $p->nama_kategori }}</small>
                                        </td>

                                        <td class="text-center">
                                            {{ $p->tgl_format_tabel }}
                                            <br>
                                            <small class="text-muted">{{ $p->jam_format }} WIB</small>
                                        </td>

                                        <td class="text-center">
                                            <span
                                                class="badge {{ $p->statusClass }} px-2 py-1">{{ ucfirst($p->status) }}</span>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                                {{-- Tombol Detail (Trigger Modal) --}}
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#detailModal{{ $p->pengaduan_id }}" title="Lihat Detail">
                                                    <i class="las la-eye"></i>
                                                </button>

                                                @if (Auth::user()->role != 'guest')
                                                @if (strtolower($p->status) === 'pending')
                                                    <a href="{{ route('tindaklanjut.create', $p->pengaduan_id) }}"
                                                        class="btn btn-sm btn-danger" title="Proses Tindak Lanjut">
                                                        <i class="las la-check-circle"></i>
                                                    </a>
                                                @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="las la-folder-open" style="font-size: 2rem;"></i>
                                                <p class="mt-2">Tidak ada data pengaduan yang ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $pengaduan->links('pagination::custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL PENGADUAN --}}
    @foreach ($pengaduan as $p)
        <div class="modal fade" id="detailModal{{ $p->pengaduan_id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title font-weight-bold">
                            <i class="fas fa-info-circle mr-2"></i>Detail Pengaduan ({{ $p->nomor_tiket ?? 'N/A' }})
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        {{-- Info Utama --}}
                        <ul class="list-group list-group-flush mb-4 shadow-sm rounded">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong class="text-muted">Nomor Tiket</strong>
                                <span class="font-weight-bold text-dark">{{ $p->nomor_tiket ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong class="text-muted">Pelapor</strong>
                                <span>{{ $p->pelapor }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong class="text-muted">Kategori</strong>
                                <span class="badge badge-info">{{ $p->nama_kategori }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong class="text-muted">Waktu Lapor</strong>
                                <span>{{ $p->tgl_format_full }} WIB</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong class="text-muted">Status</strong>
                                <span
                                    class="badge {{ $p->statusClass }} px-3 py-2 text-uppercase">{{ ucfirst($p->status) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong class="text-muted">Lokasi</strong>
                                <span class="text-right">{{ $p->lokasi_text }} <br><small>(RT: {{ $p->rt }} / RW:
                                        {{ $p->rw }})</small></span>
                            </li>
                        </ul>

                        {{-- Deskripsi --}}
                        <h6 class="font-weight-bold text-primary"><i class="fas fa-align-left mr-2"></i>Deskripsi</h6>
                        <div class="p-3 bg-light border rounded mb-4 text-justify">
                            {{ $p->deskripsi }}
                        </div>

                        {{-- TABEL LAMPIRAN --}}
                        <h6 class="font-weight-bold text-primary"><i class="fas fa-paperclip mr-2"></i>Lampiran Bukti</h6>

                        @if (isset($p->media) && count($p->media) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 5%" class="text-center">No</th>
                                            <th>Nama File</th>
                                            <th style="width: 20%">Tipe</th>
                                            <th style="width: 15%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($p->media as $idx => $m)
                                            <tr>
                                                <td class="text-center align-middle">{{ $idx + 1 }}</td>
                                                <td class="align-middle d-flex align-items-center">
                                                    @php
                                                        // Mengambil ekstensi atau tipe dari nama file
                                                        $extension = pathinfo($m->name, PATHINFO_EXTENSION);
                                                        $type = strtolower($m->mime_type ?? $extension);

                                                        // Logika deteksi ikon
                                                        $icon = 'fas fa-file-alt'; // Default
                                                        $color = 'text-secondary';

                                                        if (Str::contains($type, ['image/', 'jpg', 'jpeg', 'png', 'gif'])) {
                                                            $icon = 'fas fa-file-image';
                                                            $color = 'text-success';
                                                        } elseif (Str::contains($type, ['pdf', 'application/pdf'])) {
                                                            $icon = 'fas fa-file-pdf';
                                                            $color = 'text-danger';
                                                        } elseif (Str::contains($type, ['word', 'doc', 'docx'])) {
                                                            $icon = 'fas fa-file-word';
                                                            $color = 'text-primary';
                                                        } elseif (Str::contains($type, ['excel', 'xls', 'xlsx'])) {
                                                            $icon = 'fas fa-file-excel';
                                                            $color = 'text-success';
                                                        }
                                                    @endphp
                                                    <i class="{{ $icon }} {{ $color }} mr-2"></i>
                                                    {{-- Tampilkan nama file yang sudah diolah di Controller --}}
                                                    <a href="{{ $m->url }}" target="_blank"
                                                        class="text-dark font-weight-bold"
                                                        title="Klik untuk Lihat/Download: {{ $m->name }}">
                                                        {{ $m->name }}
                                                    </a>
                                                </td>
                                                <td class="align-middle small text-muted">
                                                    {{-- Tampilkan hanya ekstensi dalam huruf besar --}}
                                                    {{ $extension ? strtoupper($extension) : 'FILE' }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a href="{{ $m->url }}" target="_blank"
                                                        class="btn btn-sm btn-info shadow-sm" title="Lihat/Download">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-secondary py-2 border-0" role="alert">
                                <i class="fas fa-info-circle mr-1"></i> Tidak ada lampiran foto/dokumen.
                            </div>
                        @endif

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Optional: Fokus ke input search jika ada value (setelah reload)
            const searchInput = document.getElementById('search_query');
            if (searchInput && searchInput.value !== '') {
                searchInput.focus();
                // Pindahkan kursor ke akhir teks
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }
        });
    </script>
@endpush
