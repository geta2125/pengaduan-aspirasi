@extends('layouts_guest.app')

@section('konten')
    {{-- Memastikan Bootstrap Icons dimuat --}}

    <style>
        /* Modernized Status Badges */
        .badge-status-new { background-color: #e3f2fd; color: #0d6efd; font-weight: 600; border: 1px solid #0d6efd;} /* Light Blue/Primary */
        .badge-status-pending { background-color: #fff3cd; color: #ffc107; font-weight: 600; border: 1px solid #ffc107;} /* Light Yellow/Warning */
        .badge-status-processed { background-color: #d1e7dd; color: #198754; font-weight: 600; border: 1px solid #198754;} /* Light Green/Success */
        .badge-status-completed { background-color: #d2f4ea; color: #20c997; font-weight: 600; border: 1px solid #20c997;} /* Teal/Completed */
        .badge-status-default { background-color: #f8f9fa; color: #6c757d; font-weight: 600; border: 1px solid #6c757d;} /* Light Grey/Secondary */

        /* Card Customization */
        .card-detail {
            border-left: 5px solid #0d6efd; /* Accent border on the left */
            border-radius: .75rem !important; /* Slightly larger border radius */
        }
        
        /* Timeline for Responses */
        .timeline {
            border-left: 2px solid #e9ecef;
            padding-left: 20px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 20px; /* Space for the line */
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -28px; /* Position next to the line */
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: #0d6efd;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #0d6efd;
            z-index: 1;
        }

        /* Specific dot colors for timeline status */
        .timeline-item.status-new::before { background-color: #0d6efd; box-shadow: 0 0 0 2px #0d6efd; }
        .timeline-item.status-pending::before { background-color: #ffc107; box-shadow: 0 0 0 2px #ffc107; }
        .timeline-item.status-processed::before { background-color: #198754; box-shadow: 0 0 0 2px #198754; }
        .timeline-item.status-completed::before { background-color: #20c997; box-shadow: 0 0 0 2px #20c997; }

        .timeline-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .timeline-item:last-child::after {
            display: none; /* Remove line after the last item */
        }
    </style>

    <div class="container my-5">
        <div class="card shadow-lg border-0 card-detail">
            {{-- Header dengan Judul dan Tombol Kembali --}}
            <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary d-flex align-items-center fw-bold">
                    <i class="bi bi-file-earmark-check-fill me-2 fs-4"></i> Detail Pengaduan
                </h4>
                <a href="{{ route('guest.pengaduan.riwayat') }}" class="btn btn-outline-secondary btn-sm fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                </a>
            </div>
            
            <div class="card-body p-4 p-md-5">

                {{-- Bagian Judul dan Status --}}
                <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
                    <div>
                        <h2 class="text-dark mb-1 fw-bolder">{{ $pengaduan->judul }}</h2>
                        <span class="text-muted fst-italic">Tiket: #{{ $pengaduan->nomor_tiket }}</span>
                    </div>
                    <div class="text-end">
                        <h5 class="mb-2 text-muted small text-uppercase">Status Saat Ini:</h5>
                        <span class="badge rounded-pill text-uppercase fs-6 py-2 px-3 
                            @switch($pengaduan->status)
                                @case('new') badge-status-new @break
                                @case('pending') badge-status-pending @break
                                @case('processed') badge-status-processed @break
                                @case('completed') badge-status-completed @break
                                @default badge-status-default
                            @endswitch
                        ">
                            <i class="bi bi-{{ $pengaduan->status == 'completed' ? 'check-circle-fill' : ($pengaduan->status == 'processed' ? 'arrow-repeat' : 'info-circle-fill') }} me-1"></i>
                            {{ ucfirst($pengaduan->status) }}
                        </span>
                    </div>
                </div>

                {{-- Detail Informasi --}}
                <div class="row g-4 mb-5">
                    {{-- Kolom Kiri: Detail Data --}}
                    <div class="col-lg-6">
                        <h5 class="text-primary mb-3 pb-2 border-bottom"><i class="bi bi-info-circle me-2"></i> Detail Data Pengaduan</h5>
                        <dl class="row mb-0">
                            <dt class="col-sm-5 text-muted"><i class="bi bi-tag-fill me-2"></i> Kategori:</dt>
                            <dd class="col-sm-7 fw-medium">{{ $pengaduan->kategori->nama ?? '-' }}</dd>

                            <dt class="col-sm-5 text-muted"><i class="bi bi-calendar-event me-2"></i> Tanggal:</dt>
                            <dd class="col-sm-7 fw-medium">{{ $pengaduan->created_at->format('d M Y') }}</dd>
                            
                            <dt class="col-sm-5 text-muted"><i class="bi bi-clock me-2"></i> Waktu:</dt>
                            <dd class="col-sm-7 fw-medium">{{ $pengaduan->created_at->format('H:i') }} WIB</dd>

                            <dt class="col-sm-5 text-muted"><i class="bi bi-geo-alt-fill me-2"></i> Lokasi Spesifik:</dt>
                            <dd class="col-sm-7 fw-medium text-break">{{ $pengaduan->lokasi_text ?? 'Tidak Dilampirkan' }}</dd>

                            @if ($pengaduan->rt && $pengaduan->rw)
                            <dt class="col-sm-5 text-muted"><i class="bi bi-house-door-fill me-2"></i> RT/RW:</dt>
                            <dd class="col-sm-7 fw-medium">{{ $pengaduan->rt ?? '-' }}/{{ $pengaduan->rw ?? '-' }}</dd>
                            @endif
                        </dl>
                    </div>

                    {{-- Kolom Kanan: Aksi --}}
                    <div class="col-lg-6 border-start ps-lg-4">
                        <h5 class="text-primary mb-3 pb-2 border-bottom"><i class="bi bi-lightning-charge-fill me-2"></i> Aksi Cepat</h5>
                        
                        {{-- Opsi Edit hanya jika status 'new' --}}
                        @if ($pengaduan->status == 'new') 
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi bi-pencil-square flex-shrink-0 me-2"></i>
                                <div>
                                    Pengaduan masih dalam status **Baru**. Anda masih dapat mengubah detail.
                                </div>
                            </div>
                            <a href="{{ route('guest.pengaduan.edit', $pengaduan->pengaduan_id) }}" class="btn btn-warning w-100 fw-bold mt-2">
                                <i class="bi bi-pencil-square me-1"></i> Edit Pengaduan
                            </a>
                        @else
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="bi bi-lock-fill flex-shrink-0 me-2"></i>
                                <div>
                                    Pengaduan telah **diproses** atau **ditanggapi**. Edit tidak diperbolehkan.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{---
                | DESKRIPSI
                ---}}

                <div class="mb-5">
                    <h5 class="text-primary mb-3"><i class="bi bi-chat-left-text-fill me-2"></i> Deskripsi Lengkap</h5>
                    <div class="p-3 border rounded bg-light">
                        <p class="text-break mb-0 text-dark">{{ $pengaduan->deskripsi }}</p>
                    </div>
                </div>
                
                {{---
                | LAMPIRAN
                ---}}

                <div class="mb-5">
                    <h5 class="text-primary mb-3"><i class="bi bi-paperclip me-2"></i> Lampiran</h5>
                    
                    @if(isset($pengaduan->media) && $pengaduan->media->file_url)
                        @php
                            $fileExt = pathinfo($pengaduan->media->file_url, PATHINFO_EXTENSION);
                            $fileUrl = asset('storage/' . $pengaduan->media->file_url);
                            $fileName = basename($pengaduan->media->file_url);
                            $isImage = in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp

                        <div class="p-3 border rounded d-flex flex-column flex-md-row align-items-start align-items-md-center bg-white">
                            @if($isImage)
                                <img src="{{ $fileUrl }}" alt="Lampiran Foto" class="img-fluid rounded me-md-4 mb-3 mb-md-0" style="max-height: 150px; width: auto; object-fit: cover;">
                            @else
                                <i class="bi bi-file-earmark-arrow-down-fill fs-1 text-secondary me-md-4 mb-3 mb-md-0"></i>
                            @endif
                            
                            <div>
                                <strong class="d-block">{{ $isImage ? 'Foto Terlampir' : "Dokumen Terlampir: {$fileName}" }}</strong>
                                <small class="text-muted">{{ $isImage ? "Format: ." . strtoupper($fileExt) : "Tipe: Dokumen" }}</small>
                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 d-block d-md-inline-block">
                                    <i class="bi bi-eye me-1"></i> {{ $isImage ? 'Lihat Foto' : 'Unduh Dokumen' }}
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-secondary mb-0" role="alert">
                            <i class="bi bi-info-circle me-2"></i> Tidak ada lampiran foto/dokumen untuk pengaduan ini.
                        </div>
                    @endif
                </div>

                {{---
                | RIWAYAT tindak_lanjut (TIMELINE)
                ---}}

                <div class="mt-5">
                    <h5 class="text-primary mb-4"><i class="bi bi-arrow-return-right me-2"></i> Riwayat Tindak Lanjut (Timeline)</h5>
                    
                    @if ($pengaduan->tindak_lanjut->isNotEmpty() ?? false)
                        <div class="timeline">
                            {{-- Tambahkan item untuk status awal 'NEW' --}}
                            <div class="timeline-item status-new">
                                <div class="card p-3 bg-light border-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-primary fw-bold">
                                            <i class="bi bi-send-fill me-1"></i> Pengaduan Dibuat
                                        </h6>
                                        <small class="text-muted">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-0 small text-dark">Sistem menerima pengaduan dengan nomor tiket **#{{ $pengaduan->nomor_tiket }}**.</p>
                                    <small class="text-muted mt-1">Status: **BARU**</small>
                                </div>
                            </div>

                            @foreach ($pengaduan->tindak_lanjut as $tindak_lanjut)
                                <div class="timeline-item status-{{ $tindak_lanjut->aksi }}">
                                    <div class="card p-3 border-0 shadow-sm {{ $tindak_lanjut->aksi == 'Selesai' ? 'bg-success-subtle' : 'bg-white' }}">
                                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 text-success fw-bold">
                                                <i class="bi bi-person-workspace me-1"></i> Tindak Lanjut Petugas
                                            </h6>
                                            <small class="text-muted">{{ $tindak_lanjut->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        
                                        <p class="mb-2 text-break">{{ $tindak_lanjut->catatan }}</p>
                                        <small class="text-muted">
                                            Ditanggapi oleh: **{{ $tindak_lanjut->petugas ?? 'Admin/Petugas' }}**
                                            <span class="d-block mt-1">Status diperbarui menjadi: 
                                                <strong class="text-uppercase text-{{ $tindak_lanjut->aksi == 'Selesai' ? 'success' : 'primary' }}">{{ ucfirst($tindak_lanjut->aksi) }}</strong>
                                            </span>
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Tampilkan status awal NEW jika belum ada tindak_lanjut --}}
                        <div class="timeline">
                            <div class="timeline-item status-new">
                                <div class="card p-3 bg-light border-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-primary fw-bold">
                                            <i class="bi bi-send-fill me-1"></i> Pengaduan Dibuat
                                        </h6>
                                        <small class="text-muted">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-0 small text-dark">Sistem menerima pengaduan dengan nomor tiket **#{{ $pengaduan->nomor_tiket }}**.</p>
                                    <small class="text-muted mt-1">Status: **BARU**</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mb-0 mt-4" role="alert">
                            <i class="bi bi-clock-history mr-2"></i> Belum ada tindak lanjut resmi dari petugas.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection