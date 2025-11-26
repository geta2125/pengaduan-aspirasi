@extends('layouts_admin.app')

@section('konten')

    {{-- Custom CSS for a modern look (No changes from previous version) --}}
    <style>
        .filter-section {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
        }

        .filter-item label {
            font-size: 0.95rem;
            margin-bottom: 5px;
            font-weight: 600;
            color: #495057;
        }

        .form-control-sm,
        .form-select-sm {
            border-radius: 5px;
        }

        .action-cell {
            white-space: nowrap;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .table-light th {
            font-weight: 700;
            color: #343a40;
            background-color: #e9ecef !important;
        }

        .action-group {
            display: flex;
            gap: 5px;
            justify-content: center;
        }
    </style>

    <div class="row">
        <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-primary">{{ $title }} <i class="ri-history-line align-middle ms-1"></i></h4>
        </div>

        {{-- ============================= --}}
        {{-- SEARCH & FILTER BAR --}}
        {{-- ============================= --}}
        <div class="col-12">
            <div class="card shadow-sm mb-4 p-3">
                <form method="GET" action="{{ route('admin.tindaklanjut.index') }}" class="filter-section">

                    {{-- Search Input --}}
                    <div class="filter-item flex-grow-1" style="min-width: 200px;">
                        <label for="search">Cari Judul / Pelapor</label>
                        <input type="text" name="search" id="search" class="form-control form-control-sm"
                            placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                    </div>

                    {{-- Status Filter DENGAN STATUS BARU --}}
                    <div class="filter-item">
                        <label for="status">Status Pengaduan</label>
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Sedang Diproses" {{ request('status') == 'Sedang Diproses' ? 'selected' : '' }}>
                                Sedang Diproses</option>
                            <option value="Ditugaskan Petugas" {{ request('status') == 'Ditugaskan Petugas' ? 'selected' : '' }}>Ditugaskan Petugas</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- Date Filters (unchanged) --}}
                    <div class="filter-item">
                        <label for="date_from">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from" class="form-control form-control-sm"
                            value="{{ request('date_from') }}">
                    </div>

                    <div class="filter-item">
                        <label for="date_to">Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to" class="form-control form-control-sm"
                            value="{{ request('date_to') }}">
                    </div>

                    {{-- Action Buttons (unchanged) --}}
                    <div class="d-flex gap-2 align-self-end">
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                            <i class="ri-search-line mr-1"></i> Cari
                        </button>

                        @if(request('search') || request('status') || request('date_from') || request('date_to'))
                            <a href="{{ route('admin.tindaklanjut.index') }}"
                                class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                <i class="ri-refresh-line mr-1"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================= --}}
        {{-- TABEL & PAGINATION --}}
        {{-- ============================= --}}
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- Info Jumlah Data --}}
                    <div class="mb-3">
                        <span class="badge bg-secondary">Total: {{ $tindaklanjut->total() }} Data</span>
                        <span class="badge bg-info text-dark">Halaman {{ $tindaklanjut->currentPage() }} dari
                            {{ $tindaklanjut->lastPage() }}</span>
                    </div>


                    <div class="table-responsive rounded mb-3">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light text-uppercase">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Judul Pengaduan</th>
                                    <th>Pelapor</th>
                                    <th>Tanggal Tindak Lanjut</th>
                                    <th>Status Pengaduan</th>
                                    <th class="text-center" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($tindaklanjut as $p)
                                                                                                            <tr>
                                                                                                                <td>{{ $tindaklanjut->firstItem() + $loop->index }}</td>
                                                                                                                <td>
                                                                                                                    <strong>{{ $p->pengaduan->judul ?? 'Judul Tidak Ada' }}</strong>
                                                                                                                    <small
                                                                                                                        class="d-block text-muted">#{{ $p->pengaduan->pengaduan_id ?? 'ID-N/A' }}</small>
                                                                                                                </td>
                                                                                                                <td>{{ $p->pengaduan->warga->nama ?? 'Anonim' }}</td>
                                                                                                                <td>{{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y, H:i') }}</td>

                                                                                                                <td>
                                                                                                                    {{-- Logika Badge DENGAN STATUS BARU --}}
                                                                                                                    @php
                                    $status = $p->aksi ?? 'unknown';
                                    $badgeClass = match ($status) {
                                        'Diterima' => 'bg-secondary',
                                        'Sedang Diproses' => 'bg-info text-dark',
                                        'Ditugaskan Petugas' => 'bg-warning text-dark',
                                        'Selesai' => 'bg-success',
                                        default => 'bg-danger',
                                    };
                                                                                                                    @endphp
                                                                                                                    <span class="badge {{ $badgeClass }}">
                                                                                                                        {{ $status }}
                                                                                                                    </span>
                                                                                                                </td>
                                                                        <td class="text-center action-cell">
                                                                            <div class="action-group">
                                                                                <a href="{{ route('admin.tindaklanjut.show', $p->tindak_id) }}" class="btn btn-sm btn-info text-white"
                                                                                    data-bs-toggle="tooltip" title="Lihat Detail">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </a>
                                                                                <a href="{{ route('admin.tindaklanjut.edit', $p->tindak_id) }}" class="btn btn-sm btn-success"
                                                                                    data-bs-toggle="tooltip" title="Ubah Status">
                                                                                    <i class="ri-edit-line"></i>
                                                                                </a>
                                                                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-bs-toggle="modal"
                                                                                    data-bs-target="#deleteConfirmationModal" data-id="{{ $p->tindak_id }}">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                </button>
                                                                                </div>
                                                                                </td>
                                                                                </tr>
                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <i class="ri-inbox-line mr-2 text-muted"></i> Tidak ada data tindak lanjut
                                                        ditemukan.
                                                        @if(request('search') || request('status') || request('date_from') || request('date_to'))
                                                            <br><span class="text-muted">Coba ubah kriteria filter Anda.</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            </table>
                                            </div>

                                            {{-- Pagination Links --}}
                                            <div class="mt-3">
                                                {{ $tindaklanjut->links('pagination::custom') }}
                                            </div>

                                            </div>
                                            </div>
                                            </div>
                                            </div>

                                            {{-- MODAL HAPUS (unchanged) --}}
                                            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="deleteConfirmationModalLabel"><i class="ri-alert-line mr-2"></i> Konfirmasi
                                                                Hapus Data</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Anda akan **menghapus** data tindak lanjut ini. Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <form id="deleteForm" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-line mr-1"></i> Ya,
                                                                    Hapus!</button>
                                                            </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script (unchanged) --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const deleteButtons = document.querySelectorAll('.delete-btn');
                const deleteForm = document.getElementById('deleteForm');
                const baseUrl = "{{ route('admin.tindaklanjut.index') }}";

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const deleteId = this.getAttribute('data-id');
                        const deleteUrl = baseUrl.replace('/index', '') + '/' + deleteId;
                        deleteForm.setAttribute('action', deleteUrl);
                    });
                });

                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
        </script>
       
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // ====================================
                    // Logika Hapus Data (Tetap)
                    // ====================================
                    const deleteButtons = document.querySelectorAll('.delete-btn');
                    const deleteForm = document.getElementById('deleteForm');
                    const baseUrl = "{{ route('admin.tindaklanjut.index') }}";

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const deleteId = this.getAttribute('data-id');
                            // Pastikan rute tidak memiliki /index di akhir, sesuaikan jika perlu
                            const deleteUrl = baseUrl.replace(/\/$/, '') + '/' + deleteId;
                            deleteForm.setAttribute('action', deleteUrl);
                        });
                    });

                    // Logika Tooltip (Tetap)
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    });

                    // ====================================
                    // Logika Auto-Search dengan Debounce ✨
                    // ====================================
                    const searchInput = document.getElementById('search');
                    const filterForm = document.querySelector('.filter-section'); // Ambil form filter

                    // Fungsi Debounce: Menunda eksekusi fungsi
                    const debounce = (func, delay) => {
                        let timeoutId;
                        return (...args) => {
                            clearTimeout(timeoutId);
                            timeoutId = setTimeout(() => {
                                func.apply(this, args);
                            }, delay);
                        };
                    };

                    // Fungsi yang akan disubmit setelah debounce
                    const submitForm = () => {
                        // Hanya submit jika form ditemukan
                        if (filterForm) {
                            // Hapus tombol "Cari" dari data yang disubmit agar tidak muncul di URL
                            // Tapi ini tidak terlalu krusial karena kita menggunakan GET method
                            filterForm.submit();
                        }
                    };

                    // Event Listener untuk input search
                    if (searchInput) {
                        searchInput.addEventListener('keyup', debounce(submitForm, 500)); // Delay 500ms
                        searchInput.addEventListener('change', submitForm); // Langsung submit jika ada paste atau clear
                    }

                    // Opsional: Auto-submit juga untuk filter status jika berubah
                    const statusSelect = document.getElementById('status');
                    if (statusSelect) {
                        statusSelect.addEventListener('change', submitForm);
                    }

                });
            </script>
    @endpush

@endsection
