@extends('layouts_admin.app')

@section('konten')
    <div class="container py-4">
        <div class="card shadow-lg border-0 rounded-4">
            {{-- Header --}}
            {{-- Diubah menjadi "Detail Pengaduan" sesuai tampilan target --}}
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 fs-5">
                    <i class="bi bi-megaphone-fill me-2"></i>
                    Detail Pengaduan
                </h3>
                {{-- Tombol Kembali di Kanan --}}
                <a href="javascript:history.back()" class="btn btn-light btn-sm shadow-sm d-flex align-items-center">
                    <i class="fas fa-chevron-left me-2"></i> Kembali
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body p-md-5 p-3">

                {{-- BAGIAN 1: INFORMASI UTAMA PENGADUAN --}}
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-info-circle-fill me-2"></i>
                            Informasi Pengaduan</h4>

                        {{-- Variabel disesuaikan menggunakan $tindaklanjut->pengaduan --}}
                        <dl class="row">
                            <dt class="col-sm-4 text-muted">Judul</dt>
                            <dd class="col-sm-8 text-dark text-break">{{ $tindaklanjut->pengaduan->judul }}</dd>

                            <dt class="col-sm-4 text-muted">Kategori</dt>
                            <dd class="col-sm-8 text-dark text-break">{{ $tindaklanjut->pengaduan->kategori->nama ?? '-' }}
                            </dd>

                            <dt class="col-sm-4 text-muted">Pelapor</dt>
                            <dd class="col-sm-8 text-dark text-break">
                                {{ $tindaklanjut->pengaduan->warga->nama ?? 'Anonim' }}
                            </dd>

                            <dt class="col-sm-4 text-muted">Status Pengaduan</dt>
                            <dd class="col-sm-8 text-dark text-break">
                                @php
                                    // Ambil aksi terakhir (status saat ini) dari pengaduan
                                    $status_terakhir =
                                        $tindaklanjut->pengaduan->tindak_lanjut->sortByDesc('created_at')->first()
                                            ->aksi ?? 'Belum Ditindaklanjut';
                                    $badgeClass = match ($status_terakhir) {
                                        'Diterima' => 'bg-info',
                                        'Sedang Diproses' => 'bg-warning text-dark',
                                        'Ditugaskan Petugas' => 'bg-primary',
                                        'Selesai' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $status_terakhir }}</span>
                            </dd>

                            <dt class="col-sm-4 text-muted">Deskripsi</dt>
                            <dd class="col-sm-8">
                                <p class="card-text text-dark text-break border rounded p-2 bg-light"
                                    style="max-height: 200px; overflow-y: auto;">
                                    {{ $tindaklanjut->pengaduan->deskripsi ?? '-' }}
                                </p>
                            </dd>

                            <dt class="col-sm-4 text-muted">Lokasi</dt>
                            <dd class="col-sm-8 text-dark text-break">
                                {{ $tindaklanjut->pengaduan->lokasi_text ?? '-' }} (RT/RW:
                                {{ $tindaklanjut->pengaduan->rt ?? '-' }}/{{ $tindaklanjut->pengaduan->rw ?? '-' }})
                            </dd>
                        </dl>
                    </div> {{-- End Informasi Pengaduan (col-lg-6) --}}

                    {{-- BAGIAN 2: RIWAYAT TINDAK LANJUT --}}
                    <div class="col-lg-6 mb-4">
                        <h4 class="text-success border-bottom pb-2 mb-3"><i class="bi bi-clock-history me-2"></i> Riwayat
                            Tindak Lanjut</h4>

                        @if ($tindaklanjut->pengaduan->tindak_lanjut && $tindaklanjut->pengaduan->tindak_lanjut->count())
                            <ul class="list-group list-group-flush border rounded shadow-sm"
                                style="max-height: 350px; overflow-y: auto;">
                                {{-- Menggunakan $tindaklanjut->pengaduan->tindak_lanjut --}}
                                @foreach ($tindaklanjut->pengaduan->tindak_lanjut->sortByDesc('created_at') as $tl)
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-start {{ $loop->last ? '' : 'border-bottom' }}">
                                        <div class="me-2 flex-grow-1">
                                            <div class="mb-1">
                                                <span class="fw-bold me-2">Aksi:</span>
                                                @php
                                                    $badgeClass = match ($tl->aksi) {
                                                        'Diterima' => 'bg-info',
                                                        'Sedang Diproses' => 'bg-warning text-dark',
                                                        'Ditugaskan Petugas' => 'bg-primary',
                                                        'Selesai' => 'bg-success',
                                                        default => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $tl->aksi }}</span>
                                            </div>
                                            <p class="mb-1 text-sm text-dark">Petugas:
                                                {{ $tl->petugas ?? 'Sistem/Admin' }}</p>
                                            <p class="mb-0 text-break fst-italic text-secondary" style="font-size: 0.9rem;">
                                                Catatan: {{ $tl->catatan ?? 'Tidak ada catatan.' }}
                                            </p>
                                        </div>
                                        <div class="text-end flex-shrink-0 ms-2" style="font-size: 0.75rem;">
                                            <small
                                                class="d-block text-muted">{{ $tl->created_at->format('d-m-Y') }}</small>
                                            <small class="d-block text-muted">{{ $tl->created_at->format('H:i') }}
                                                WIB</small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-light text-center fst-italic">
                                <i class="bi bi-exclamation-circle-fill me-1"></i> Belum ada riwayat tindak lanjut untuk
                                pengaduan ini.
                            </div>
                        @endif
                    </div> {{-- End Riwayat Tindak Lanjut (col-lg-6) --}}
                </div> {{-- End row (Informasi & Riwayat) --}}

                <hr class="my-4">

                {{-- BAGIAN 3: TABEL LAMPIRAN (DATATABLE) --}}
                <div class="row mb-5">
                    <div class="col-12">
                        <h4 class="text-info border-bottom pb-2 mb-3"><i class="fas fa-paperclip me-2"></i> Daftar Lampiran
                        </h4>

                        {{-- Menggunakan $tindaklanjut->pengaduan->media --}}
                        @if ($tindaklanjut->pengaduan->media && $tindaklanjut->pengaduan->media->count() > 0)
                            <div class="table-responsive">
                                <table id="datatable" class="table data-tables table-striped">
                                    <thead>
                                        <tr class="ligth">
                                            <th style="width: 5%" class="text-center">No</th>
                                            <th>Nama File</th>
                                            <th style="width: 20%">Tipe</th>
                                            <th style="width: 15%" class="text-center" data-orderable="false">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tindaklanjut->pengaduan->media as $idx => $mediaItem)
                                            <tr>
                                                <td class="text-center align-middle">{{ $idx + 1 }}</td>
                                                <td class="align-middle d-flex align-items-center">
                                                    @php
                                                        // Tentukan Nama yang akan ditampilkan (Nama Asli > Nama Unik)
                                                        $displayName =
                                                            $mediaItem->caption ??
                                                            Str::afterLast($mediaItem->file_name, '/');

                                                        // Ambil ekstensi dan tipe untuk ikon
                                                        $extension = pathinfo($displayName, PATHINFO_EXTENSION);
                                                        $type = strtolower($mediaItem->mime_type ?? $extension);

                                                        // Logika deteksi ikon Font Awesome
                                                        $icon = 'fas fa-file-alt'; // Default
                                                        $color = 'text-secondary';

                                                        if (
                                                            Str::contains($type, [
                                                                'image/',
                                                                'jpg',
                                                                'jpeg',
                                                                'png',
                                                                'gif',
                                                            ])
                                                        ) {
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
                                                    <i class="{{ $icon }} {{ $color }} me-2"></i>
                                                    <a href="{{ asset('storage/' . $mediaItem->file_name) }}"
                                                        target="_blank" class="text-dark fw-bold text-decoration-none"
                                                        title="Klik untuk Lihat/Download: {{ $displayName }}">
                                                        {{ $displayName }}
                                                    </a>
                                                </td>
                                                <td class="align-middle small text-muted">
                                                    {{-- Tampilkan hanya ekstensi dalam huruf besar --}}
                                                    {{ $extension ? strtoupper($extension) : 'FILE' }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a href="{{ asset('storage/' . $mediaItem->file_name) }}"
                                                        target="_blank" class="btn btn-sm btn-info shadow-sm"
                                                        title="Lihat/Download">
                                                        <i class="fas fa-eye me-1"></i> Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-secondary py-2 border-0" role="alert">
                                <i class="fas fa-info-circle me-1"></i> Tidak ada lampiran foto/dokumen.
                            </div>
                        @endif
                    </div>
                </div> {{-- End Tabel Lampiran --}}

                <hr class="my-4">

                {{-- BAGIAN 4: FORM EDIT TINDAK LANJUT --}}
                {{-- BAGIAN 4: FORM EDIT TINDAK LANJUT --}}
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-primary mb-3">
                            <i class="bi bi-pencil-square me-2"></i> Edit Tindak Lanjut
                        </h4>

                        <form action="{{ route('tindaklanjut.update', $tindaklanjut->tindak_id) }}" method="POST"
                            enctype="multipart/form-data"> {{-- 🔹 WAJIB untuk upload file --}}
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="aksi" class="form-label fw-bold">
                                        Aksi <span class="text-danger">*</span>
                                    </label>
                                    <select name="aksi" id="aksi" class="form-control" required>
                                        <option value="" disabled>-- Pilih Aksi --</option>

                                        @php $currentAksi = old('aksi', $tindaklanjut->aksi ?? ''); @endphp

                                        <option value="Diterima" {{ $currentAksi == 'Diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="Sedang Diproses"
                                            {{ $currentAksi == 'Sedang Diproses' ? 'selected' : '' }}>
                                            Sedang Diproses
                                        </option>
                                        <option value="Ditugaskan Petugas"
                                            {{ $currentAksi == 'Ditugaskan Petugas' ? 'selected' : '' }}>
                                            Ditugaskan Petugas
                                        </option>
                                        <option value="Selesai" {{ $currentAksi == 'Selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                    </select>
                                    @error('aksi')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label for="catatan" class="form-label fw-bold">Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control" rows="3" maxlength="1000"
                                        placeholder="Tulis catatan tindak lanjut..." oninput="countChar(this)">{{ old('catatan', $tindaklanjut->catatan ?? '') }}</textarea>
                                    <div id="charNum" class="form-text text-end">0/1000</div>
                                    @error('catatan')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- 🔹 INPUT MULTIPLE FILE LAMPIRAN UNTUK EDIT --}}
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="lampiran" class="form-label fw-bold">
                                        Tambah Lampiran (opsional)
                                    </label>
                                    <input type="file" name="lampiran[]" id="lampiran"
                                        class="form-control @error('lampiran.*') is-invalid @enderror" multiple>
                                    <small class="form-text text-muted">
                                        Anda dapat menambahkan beberapa file baru. File lama tetap tersimpan.
                                        Format: jpg, jpeg, png, pdf, docx, xlsx, pptx. Maks 10MB per file.
                                    </small>
                                    @error('lampiran.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- End Form Tindak Lanjut --}}

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Memastikan script character counter ada --}}
    <script>
        /**
         * Fungsi untuk menghitung dan menampilkan jumlah karakter yang ditulis
         */
        function countChar(val) {
            var len = val.value.length;
            var max = parseInt(val.getAttribute('maxlength'));
            var counter = document.getElementById('charNum');

            if (counter) {
                counter.textContent = len + '/' + max;

                // Logika untuk mengubah tampilan saat mendekati/mencapai batas
                if (len >= max) {
                    counter.classList.add('text-danger', 'fw-bold');
                    counter.classList.remove('text-muted', 'text-warning');
                } else if (len >= max * 0.9) {
                    counter.classList.add('text-warning', 'fw-bold');
                    counter.classList.remove('text-danger', 'text-muted');
                } else {
                    counter.classList.add('text-muted');
                    counter.classList.remove('text-danger', 'fw-bold', 'text-warning');
                }
            }
        }

        // Jalankan saat halaman dimuat untuk inisialisasi counter jika ada data lama
        document.addEventListener('DOMContentLoaded', function() {
            // Perhatikan bahwa ID 'catatan' mungkin digunakan di Bagian 4 (Form Tambah Baru).
            // Jika Anda ingin menginisialisasi Form Tambah Baru, pastikan ID-nya unik atau hanya satu elemen.
            var catatanField = document.getElementById('catatan');
            if (catatanField) {
                // Panggil fungsi sekali untuk inisialisasi tampilan awal
                countChar(catatanField);
            }
        });
    </script>
@endpush
