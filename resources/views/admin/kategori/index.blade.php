@extends('layouts_admin.app')

@section('konten')
    <style>
        /* ====== CARD HOVER EFFECT & CUSTOM STYLES ====== */
        .kategori-card {
            border-radius: 1rem;
            /* Lebih membulat */
            border: 1px solid rgba(0, 0, 0, 0.08);
            /* Tambahkan sedikit border */
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            /* Transisi lebih halus */
        }

        .kategori-card:hover {
            transform: translateY(-5px);
            /* Efek angkat yang lebih menonjol */
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.06);
        }

        .badge-prioritas {
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        /* Ikon Kategori */
        .kategori-icon {
            font-size: 2.5rem;
            color: var(--bs-primary);
            /* Menggunakan warna primary tema */
            margin-bottom: 0.5rem;
        }

        /* Jarak antar kolom pada grid */
        .row.g-4 {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 1.5rem;
        }
    </style>

    <div class="row">
        <div class="col-12">

            {{-- HEADER & TOMBOL TAMBAH --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <h3 class="mb-0 fw-bold">{{ $title }}</h3>
                </div>

                <a href="{{ route('admin.kategori-pengaduan.create') }}" class="btn btn-primary add-list shadow-sm">
                    <i class="las la-plus me-2"></i> Tambah Kategori
                </a>
            </div>
        </div>

        <div class="col-12 mb-4">
            {{-- FILTER & SEARCH --}}
            <form method="GET" action="{{ route('admin.kategori-pengaduan.index') }}" id="filterForm">
                <div class="row g-2 align-items-end">

                    {{-- Search --}}
                    <div class="col-lg-4 col-md-6">
                        <label for="searchInput" class="form-label text-muted mb-1">Cari Kategori</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-search-line"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama kategori..."
                                value="{{ request('search') }}" id="searchInput">
                        </div>
                    </div>

                    {{-- Filter Prioritas --}}
                    <div class="col-lg-3 col-md-6">
                        <label for="prioritasFilter" class="form-label text-muted mb-1">Filter Prioritas</label>
                        <select name="prioritas" id="prioritasFilter" class="form-control"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="">Semua Prioritas</option>
                            <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        </select>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="col-lg-3 col-md-12 ms-auto">
                        <label class="form-label text-muted mb-1 d-none d-lg-block">&nbsp;</label>
                        <div class="d-flex" style="gap:8px;">
                            <button class="btn btn-primary w-50" type="submit">
                                <i class="ri-filter-line me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.kategori-pengaduan.index') }}" class="btn btn-outline-secondary w-50">
                                <i class="ri-refresh-line me-1"></i> Reset
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <div class="col-12">
            {{-- GRID LIST KATEGORI --}}
            <div class="row g-4">
                {{-- Loop Kategori --}}
                @forelse ($kategori as $k)
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="card kategori-card h-100">
                            <div class="card-body d-flex flex-column">

                                {{-- HEADER KARTU: IKON & PRIORITAS --}}
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <i class="ri-folder-open-line kategori-icon"></i>

                                    @php
    $badgeClass = match (strtolower($k->prioritas)) {
        'tinggi' => 'bg-danger text-white',
        'sedang' => 'bg-warning text-dark',
        'rendah' => 'bg-success text-white',
        default => 'bg-secondary text-white',
    };
                                    @endphp

                                    <span class="badge badge-prioritas {{ $badgeClass }}">
                                        {{ ucfirst($k->prioritas) }}
                                    </span>
                                </div>

                                {{-- NAMA KATEGORI --}}
                                <h5 class="fw-bold mb-1 text-truncate" title="{{ $k->nama }}">
                                    {{ $k->nama }}
                                </h5>
                                <p class="text-muted small mb-3">
                                    Kategori Pengaduan
                                </p>

                                {{-- INFO SLA --}}
                                <div class="mb-3 mt-auto">
                                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                        <span class="text-muted fw-medium">Service Level Agreement (SLA):</span>
                                        <span class="fw-semibold text-primary fs-6">{{ $k->sla_hari }} Hari</span>
                                    </div>
                                </div>

                                {{-- AKSI --}}
                                <div class="row row-cols-3 g-2">
                                    <div class="col">
                                        <a href="{{ route('admin.kategori-pengaduan.show', $k->id) }}"
                                            class="btn btn-outline-info btn-sm w-100">
                                            <i class="ri-eye-line d-md-none d-lg-inline me-lg-1"></i> Detail
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('admin.kategori-pengaduan.edit', $k->id) }}"
                                            class="btn btn-outline-success btn-sm w-100">
                                            <i class="ri-pencil-line d-md-none d-lg-inline me-lg-1"></i> Edit
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('admin.kategori-pengaduan.destroy', $k->id) }}"
                                            class="btn btn-outline-danger btn-sm w-100 delete-btn" data-id="{{ $k->id }}">
                                            <i class="ri-delete-bin-line d-md-none d-lg-inline me-lg-1"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center py-4 border-0 shadow-sm" role="alert">
                            <h4 class="alert-heading"><i class="ri-information-line me-2"></i> Data Tidak Ditemukan</h4>
                            <p class="mb-0">Tidak ada kategori pengaduan yang sesuai dengan kriteria pencarian atau filter.</p>
                        </div>
                    </div>
                @endforelse

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $kategori->links('pagination::custom') }}
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const searchInput = document.getElementById('searchInput');
        let typingTimer;
        const typingDelay = 500; // milidetik, delay sebelum auto-submit

        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, typingDelay);
        });

        searchInput.addEventListener('keydown', () => {
            clearTimeout(typingTimer);
        });
    </script>
@endpush
