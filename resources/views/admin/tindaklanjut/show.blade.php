@extends('layouts_admin.app')

@section('konten')
    <div class="container py-4">
        <div class="card shadow-lg border-0 rounded-4">
            {{-- Header --}}
            <div
                class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center rounded-top-4">
                <h3 class="mb-0 fs-5">
                    <i class="bi bi-info-circle-fill mr-2"></i>
                    Detail Tindak Lanjut
                </h3>
                {{-- Tombol Kembali di Kanan --}}
                <a href="{{ route('admin.tindaklanjut.index') }}"
                   class="btn btn-light btn-sm shadow-sm d-flex align-items-center">
                    <i class="fas fa-chevron-left mr-2"></i> Kembali
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body p-md-5 p-3">

                {{-- ===========================
                     BAGIAN 1: INFORMASI PENGADUAN
                ============================ --}}
                <div class="mb-4">
                    <h4 class="text-primary border-bottom pb-2 mb-3">
                        <i class="bi bi-megaphone-fill mr-2"></i> Informasi Pengaduan
                    </h4>

                    <dl class="row">
                        <dt class="col-sm-3 text-muted">Judul</dt>
                        <dd class="col-sm-9 text-dark text-break">
                            {{ $tindaklanjut->pengaduan->judul ?? '-' }}
                        </dd>

                        <dt class="col-sm-3 text-muted">Kategori</dt>
                        <dd class="col-sm-9 text-dark text-break">
                            {{ $tindaklanjut->pengaduan->kategori->nama_kategori ?? '-' }}
                        </dd>

                        <dt class="col-sm-3 text-muted">Pelapor</dt>
                        <dd class="col-sm-9 text-dark text-break">
                            {{ $tindaklanjut->pengaduan->warga->nama ?? 'Anonim' }}
                        </dd>

                        <dt class="col-sm-3 text-muted">Status Pengaduan</dt>
                        <dd class="col-sm-9 text-dark text-break">
                            @php
                                $status_terakhir =
                                    $tindaklanjut->pengaduan->tindak_lanjut
                                        ->sortByDesc('created_at')
                                        ->first()->aksi
                                        ?? 'Belum Ditindaklanjut';

                                $badgeClass = match ($status_terakhir) {
                                    'Diterima'           => 'bg-info',
                                    'Sedang Diproses'    => 'bg-warning text-dark',
                                    'Ditugaskan Petugas' => 'bg-primary',
                                    'Selesai'            => 'bg-success',
                                    default              => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $status_terakhir }}</span>
                        </dd>

                        <dt class="col-sm-3 text-muted">Deskripsi</dt>
                        <dd class="col-sm-9">
                            <p class="card-text text-dark text-break border rounded p-2 bg-light"
                               style="max-height: 200px; overflow-y: auto;">
                                {{ $tindaklanjut->pengaduan->deskripsi ?? '-' }}
                            </p>
                        </dd>

                        <dt class="col-sm-3 text-muted">Lokasi</dt>
                        <dd class="col-sm-9 text-dark text-break">
                            {{ $tindaklanjut->pengaduan->lokasi_text ?? '-' }}
                            (RT/RW: {{ $tindaklanjut->pengaduan->rt ?? '-' }}/{{ $tindaklanjut->pengaduan->rw ?? '-' }})
                        </dd>
                    </dl>
                </div>

                <hr class="my-4">

                {{-- ===========================
                     BAGIAN 2: LAMPIRAN PENGADUAN
                ============================ --}}
                <div class="mb-4">
                    <h4 class="text-info border-bottom pb-2 mb-3">
                        <i class="fas fa-paperclip mr-2"></i> Lampiran Pengaduan
                    </h4>

                    @if ($tindaklanjut->pengaduan->media && $tindaklanjut->pengaduan->media->count() > 0)
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%" class="text-center">No</th>
                                        <th>Nama File</th>
                                        <th style="width: 18%">Tipe</th>
                                        <th style="width: 15%" class="text-center" data-orderable="false">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tindaklanjut->pengaduan->media as $idx => $mediaItem)
                                        <tr>
                                            <td class="text-center align-middle">{{ $idx + 1 }}</td>
                                            <td class="align-middle d-flex align-items-center">
                                                @php
                                                    $displayName =
                                                        $mediaItem->caption
                                                            ?? Str::afterLast($mediaItem->file_name, '/');
                                                    $extension = pathinfo($displayName, PATHINFO_EXTENSION);
                                                    $type = strtolower($mediaItem->mime_type ?? $extension);

                                                    $icon  = 'fas fa-file-alt';
                                                    $color = 'text-secondary';

                                                    if (Str::contains($type, ['image/', 'jpg', 'jpeg', 'png', 'gif'])) {
                                                        $icon  = 'fas fa-file-image';
                                                        $color = 'text-success';
                                                    } elseif (Str::contains($type, ['pdf', 'application/pdf'])) {
                                                        $icon  = 'fas fa-file-pdf';
                                                        $color = 'text-danger';
                                                    } elseif (Str::contains($type, ['word', 'doc', 'docx'])) {
                                                        $icon  = 'fas fa-file-word';
                                                        $color = 'text-primary';
                                                    } elseif (Str::contains($type, ['excel', 'xls', 'xlsx'])) {
                                                        $icon  = 'fas fa-file-excel';
                                                        $color = 'text-success';
                                                    }
                                                @endphp
                                                <i class="{{ $icon }} {{ $color }} mr-2 fs-5"></i>
                                                <a href="{{ asset('storage/' . $mediaItem->file_name) }}"
                                                   target="_blank"
                                                   class="text-dark fw-bold text-decoration-none"
                                                   title="Klik untuk Lihat/Download: {{ $displayName }}">
                                                    {{ $displayName }}
                                                </a>
                                            </td>
                                            <td class="align-middle small text-muted">
                                                <span class="badge bg-light text-dark border">
                                                    {{ $extension ? strtoupper($extension) : 'FILE' }}
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ asset('storage/' . $mediaItem->file_name) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-info shadow-sm"
                                                   title="Lihat/Download">
                                                    <i class="fas fa-eye mr-1"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-secondary py-2 border-0" role="alert">
                            <i class="fas fa-info-circle mr-1"></i>
                            Tidak ada lampiran pada pengaduan ini.
                        </div>
                    @endif
                </div>

                <hr class="my-4">

                {{-- ===========================
                     BAGIAN 3: DETAIL TINDAK LANJUT (AKSI INI)
                ============================ --}}
                <div class="mb-4">
                    <h4 class="text-success border-bottom pb-2 mb-3">
                        <i class="bi bi-check2-square mr-2"></i> Detail Tindak Lanjut (Aksi Ini)
                    </h4>

                    <dl class="row border rounded p-3 shadow-sm bg-light">
                        <dt class="col-sm-3 fw-bold">Aksi</dt>
                        <dd class="col-sm-9">
                            @php
                                $badgeClass = match ($tindaklanjut->aksi) {
                                    'Diterima'           => 'bg-info',
                                    'Sedang Diproses'    => 'bg-warning text-dark',
                                    'Ditugaskan Petugas' => 'bg-primary',
                                    'Selesai'            => 'bg-success',
                                    default              => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $tindaklanjut->aksi }}</span>
                        </dd>

                        <dt class="col-sm-3 fw-bold">Petugas</dt>
                        <dd class="col-sm-9 text-dark text-break">
                            {{ $tindaklanjut->petugas ?? '-' }}
                        </dd>

                        <dt class="col-sm-3 fw-bold">Tanggal Aksi</dt>
                        <dd class="col-sm-9 text-dark">
                            {{ $tindaklanjut->created_at->format('d F Y, H:i') }} WIB
                        </dd>

                        <dt class="col-sm-3 fw-bold">Catatan</dt>
                        <dd class="col-sm-9 text-dark text-break fst-italic">
                            {{ $tindaklanjut->catatan ?? 'Tidak ada catatan.' }}
                        </dd>
                    </dl>
                </div>

                <hr class="my-4">

                {{-- ===========================
                     BAGIAN 4: LAMPIRAN TINDAK LANJUT (AKSI INI)
                ============================ --}}
                <div>
                    <h4 class="text-info border-bottom pb-2 mb-3">
                        <i class="fas fa-paperclip mr-2"></i> Lampiran Tindak Lanjut (Aksi Ini)
                    </h4>

                    @if ($tindaklanjut->media && $tindaklanjut->media->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%" class="text-center">No</th>
                                        <th>Nama File</th>
                                        <th style="width: 20%">Tipe</th>
                                        <th style="width: 15%" class="text-center" data-orderable="false">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tindaklanjut->media as $idx => $mediaItem)
                                        <tr>
                                            <td class="text-center align-middle">{{ $idx + 1 }}</td>
                                            <td class="align-middle d-flex align-items-center">
                                                @php
                                                    $displayName =
                                                        $mediaItem->caption
                                                            ?? Str::afterLast($mediaItem->file_name, '/');
                                                    $extension = pathinfo($displayName, PATHINFO_EXTENSION);
                                                    $type      = strtolower($mediaItem->mime_type ?? $extension);

                                                    $icon  = 'fas fa-file-alt';
                                                    $color = 'text-secondary';

                                                    if (Str::contains($type, ['image/', 'jpg', 'jpeg', 'png', 'gif'])) {
                                                        $icon  = 'fas fa-file-image';
                                                        $color = 'text-success';
                                                    } elseif (Str::contains($type, ['pdf', 'application/pdf'])) {
                                                        $icon  = 'fas fa-file-pdf';
                                                        $color = 'text-danger';
                                                    } elseif (Str::contains($type, ['word', 'doc', 'docx'])) {
                                                        $icon  = 'fas fa-file-word';
                                                        $color = 'text-primary';
                                                    } elseif (Str::contains($type, ['excel', 'xls', 'xlsx'])) {
                                                        $icon  = 'fas fa-file-excel';
                                                        $color = 'text-success';
                                                    }
                                                @endphp
                                                <i class="{{ $icon }} {{ $color }} mr-2 fs-5"></i>
                                                <a href="{{ asset('storage/' . $mediaItem->file_name) }}"
                                                   target="_blank"
                                                   class="text-dark fw-bold text-decoration-none"
                                                   title="Klik untuk Lihat/Download: {{ $displayName }}">
                                                    {{ $displayName }}
                                                </a>
                                            </td>
                                            <td class="align-middle small text-muted">
                                                <span class="badge bg-light text-dark border">
                                                    {{ $extension ? strtoupper($extension) : 'FILE' }}
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ asset('storage/' . $mediaItem->file_name) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-info shadow-sm"
                                                   title="Lihat/Download">
                                                    <i class="fas fa-eye mr-1"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-secondary py-2 border-0" role="alert">
                            <i class="fas fa-info-circle mr-1"></i>
                            Tidak ada lampiran untuk tindak lanjut ini.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
