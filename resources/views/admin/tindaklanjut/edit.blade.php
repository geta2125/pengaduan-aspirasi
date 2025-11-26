@extends('layouts_admin.app')

@section('konten')
    <div class="container py-4">
        <div class="card shadow-lg border-0 rounded-4">
            {{-- Header --}}
            <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 fs-5">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Tindak Lanjut
                </h3>
                <a href="javascript:history.back()" class="btn btn-light btn-sm shadow-sm d-flex align-items-center">
                    {{-- Ganti icon biar seragam dengan contoh detail --}}
                    <i class="fas fa-chevron-left me-1"></i> Kembali
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body p-md-5 p-3">
                <div class="row">
                    {{-- Kolom Kiri: Informasi Pengaduan --}}
                    <div class="col-lg-6 mb-4">
                        <h4 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-info-circle-fill me-2"></i>
                            Informasi Pengaduan</h4>

                        {{-- Menggunakan dl class="row" untuk layout 2 kolom --}}
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
                                    $status_terakhir = $tindaklanjut->pengaduan->tindak_lanjut->sortByDesc('created_at')->first()->aksi ?? 'Belum Ditindaklanjut';
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

                            <dt class="col-sm-4 text-muted">Lampiran</dt>
                            <dd class="col-sm-8">
                                @if ($tindaklanjut->pengaduan->media)
                                    <a href="{{ asset('storage/' . $tindaklanjut->pengaduan->media->file_url) }}"
                                        target="_blank" class="btn btn-sm btn-info text-white d-inline-flex align-items-center">
                                        <i class="bi bi-file-earmark-image-fill me-1"></i> Lihat Lampiran
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada lampiran</span>
                                @endif
                            </dd>
                        </dl>
                    </div> {{-- End Informasi Pengaduan --}}

                    {{-- Kolom Kanan: Form Edit Tindak Lanjut --}}
                    <div class="col-lg-6 mb-4">
                        <h4 class="text-success border-bottom pb-2 mb-3"><i class="bi bi-pencil-square me-2"></i>
                            Form Edit Tindak Lanjut</h4>

                        <form action="{{ route('admin.tindaklanjut.update', $tindaklanjut->tindak_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="aksi" class="form-label fw-bold">Aksi <span class="text-danger">*</span></label>
                                <select name="aksi" id="aksi" class="form-control @error('aksi') is-invalid @enderror"
                                    required>
                                    <option value="" disabled>-- Pilih Aksi --</option>
                                    <option value="Diterima" {{ old('aksi', $tindaklanjut->aksi) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Sedang Diproses" {{ old('aksi', $tindaklanjut->aksi) == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="Ditugaskan Petugas" {{ old('aksi', $tindaklanjut->aksi) == 'Ditugaskan Petugas' ? 'selected' : '' }}>Ditugaskan Petugas</option>
                                    <option value="Selesai" {{ old('aksi', $tindaklanjut->aksi) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                @error('aksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="catatan" class="form-label fw-bold">Catatan</label>
                                <textarea name="catatan" id="catatan"
                                    class="form-control @error('catatan') is-invalid @enderror" rows="5" maxlength="1000"
                                    placeholder="Tulis catatan tindak lanjut..."
                                    oninput="countChar(this)">{{ old('catatan', $tindaklanjut->catatan) }}</textarea>
                                <div id="charNum" class="form-text text-end">0/1000</div>
                                @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Button di bawah form --}}
                            <div class="col-12">
                                <div class="d-flex justify-content-end">

                                    {{-- Mengganti warna dan teks tombol untuk aksi Edit --}}
                                    <button type="submit"
                                        class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm text-white fw-bold">
                                        <i class="fas fa-save mr-2"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> {{-- End Form Edit Tindak Lanjut --}}
                </div> {{-- End row --}}

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Tambahkan script character count dari contoh Detail Pengaduan --}}
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
                    counter.classList.remove('text-muted', 'text-warning');
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
