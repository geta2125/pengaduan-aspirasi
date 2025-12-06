@extends('layouts_admin.app')

@section('konten')
    <div class="container py-4">
        <div class="card shadow-lg border-0 rounded-4">
            {{-- Header --}}
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 fs-5">
                    <i class="bi bi-megaphone-fill me-2"></i>
                    Detail Pengaduan
                </h3>
                {{-- Tombol Kembali di Kanan --}}
                <a href="javascript:history.back()" class="btn btn-light btn-sm shadow-sm d-flex align-items-center">
                    <i class="fas fa-chevron-left mr-2"></i> Kembali
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body p-md-5 p-3">
                <div class="row">
                    {{-- Informasi Pengaduan --}}
                    <div class="col-lg-6 mb-4">
                        <h4 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-info-circle-fill me-2"></i>
                            Informasi Pengaduan</h4>

                        {{-- Menggunakan dl-horizontal untuk responsif (dt 4, dd 8) --}}
                        <dl class="row">
                            <dt class="col-sm-4 text-muted">Judul</dt>
                            <dd class="col-sm-8 text-dark text-break">{{ $pengaduan->judul }}</dd>

                            <dt class="col-sm-4 text-muted">Kategori</dt>
                            <dd class="col-sm-8 text-dark text-break">{{ $pengaduan->kategori->nama ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted">Deskripsi</dt>
                            <dd class="col-sm-8">
                                <p class="card-text text-dark text-break border rounded p-2 bg-light">
                                    {{ $pengaduan->deskripsi }}
                                </p>
                            </dd>

                            <dt class="col-sm-4 text-muted">Lokasi</dt>
                            <dd class="col-sm-8 text-dark text-break">
                                {{ $pengaduan->lokasi_text ?? '-' }} (RT/RW:
                                {{ $pengaduan->rt ?? '-' }}/{{ $pengaduan->rw ?? '-' }})
                            </dd>

                            <dt class="col-sm-4 text-muted">Lampiran</dt>
                            <dd class="col-sm-8">
                                @if ($pengaduan->media)
                                    <a href="{{ asset('storage/' . $pengaduan->media->file_name) }}" target="_blank"
                                        class="btn btn-sm btn-info text-white d-inline-flex align-items-center">
                                        <i class="bi bi-file-earmark-image-fill me-1"></i> Lihat Lampiran
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada lampiran</span>
                                @endif
                            </dd>
                        </dl>
                    </div> {{-- End Informasi Pengaduan --}}

                    {{-- Riwayat Tindak Lanjut --}}
                    <div class="col-lg-6 mb-4">
                        <h4 class="text-success border-bottom pb-2 mb-3"><i class="bi bi-clock-history me-2"></i> Riwayat
                            Tindak Lanjut</h4>

                        @if ($pengaduan->tindak_lanjut && $pengaduan->tindak_lanjut->count())
                            <ul class="list-group list-group-flush border rounded shadow-sm">
                                @foreach ($pengaduan->tindak_lanjut->sortByDesc('created_at') as $tl)
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-start {{ $loop->last ? '' : 'border-bottom' }}">
                                        <div class="me-2 flex-grow-1">
                                            <div class="mb-1">
                                                <span class="fw-bold me-2">Aksi:</span>
                                                {{-- Sesuaikan badge berdasarkan aksi --}}
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
                                            <p class="mb-1 text-sm text-dark">Petugas: **{{ $tl->petugas ?? 'Sistem/Admin' }}**</p>
                                            <p class="mb-0 text-break fst-italic text-secondary" style="font-size: 0.9rem;">
                                                Catatan: {{ $tl->catatan ?? 'Tidak ada catatan.' }}
                                            </p>
                                        </div>
                                        <div class="text-end flex-shrink-0 ms-2" style="font-size: 0.75rem;">
                                            <small class="d-block text-muted">{{ $tl->created_at->format('d-m-Y') }}</small>
                                            <small class="d-block text-muted">{{ $tl->created_at->format('H:i') }} WIB</small>
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
                    </div> {{-- End Riwayat Tindak Lanjut --}}
                </div> {{-- End row --}}

                <hr class="my-4">

                {{-- Form Tindak Lanjut --}}
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-primary mb-3"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Tindak Lanjut Baru
                        </h4>
                        <form action="{{ route('admin.tindaklanjut.store', $pengaduan->pengaduan_id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="aksi" class="form-label fw-bold">Aksi <span
                                            class="text-danger">*</span></label>
                                    <select name="aksi" id="aksi" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Aksi --</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Sedang Diproses">Sedang Diproses</option>
                                        <option value="Ditugaskan Petugas">Ditugaskan Petugas</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                    @error('aksi') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="catatan" class="form-label fw-bold">Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control" rows="3" maxlength="1000"
                                        placeholder="Tulis catatan tindak lanjut..." oninput="countChar(this)"></textarea>
                                    {{-- Gunakan oninput lebih modern --}}
                                    <div id="charNum" class="form-text text-end">0/1000</div>
                                    @error('catatan') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- BARIS KHUSUS TOMBOL UNTUK MEMASTIKAN PENEMPATAN DI KANAN --}}
                            <div class="col-12">
                                <hr class="mt-4 mb-3">
                                <div class="d-flex justify-content-end">

                                    <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm">
                                        <i class="fas fa-check-circle mr-2"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div> {{-- End Form Tindak Lanjut --}}

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        /**
         * Fungsi untuk menghitung dan menampilkan jumlah karakter yang ditulis
         * serta memberikan penanda visual jika batas maksimum tercapai.
         * @param {HTMLTextAreaElement} val - Elemen textarea yang diinput.
         */
        function countChar(val) {
            var len = val.value.length;
            var max = parseInt(val.getAttribute('maxlength')); // Ambil maxlength dari atribut
            var counter = document.getElementById('charNum');

            if (counter) {
                // 1. Update teks penghitung (misalnya: 50/1000)
                counter.textContent = len + '/' + max;

                // 2. Logika untuk mengubah tampilan saat mendekati/mencapai batas
                if (len >= max) {
                    // Batas tercapai: Merah & Tebal
                    counter.classList.add('text-danger', 'fw-bold');
                    counter.classList.remove('text-muted');
                } else if (len >= max * 0.9) {
                    // Mendekati batas (misal 90%): Kuning/Peringatan
                    counter.classList.add('text-warning', 'fw-bold');
                    counter.classList.remove('text-danger', 'text-muted');
                } else {
                    // Normal
                    counter.classList.add('text-muted');
                    counter.classList.remove('text-danger', 'fw-bold', 'text-warning');
                }
            }
        }

        // Jalankan saat halaman dimuat untuk inisialisasi counter jika ada data lama
        document.addEventListener('DOMContentLoaded', function () {
            var catatanField = document.getElementById('catatan');
            if (catatanField) {
                // Panggil fungsi sekali untuk inisialisasi tampilan awal
                countChar(catatanField);
            }
        });
    </script>
@endpush
