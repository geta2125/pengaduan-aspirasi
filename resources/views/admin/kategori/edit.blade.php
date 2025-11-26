@extends('layouts_admin.app')

@section('konten')
    {{-- Card Utama untuk Form Edit Kategori --}}
    <div class="row">
        <div class="col-sm-12"> {{-- Menggunakan lebar penuh 12 kolom --}}
            <div class="card shadow-lg border-0 rounded-4">

                {{-- CARD HEADER: Konsisten, tema Primary (Menggunakan icon Edit) --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-edit mr-3 fs-4 text-warning"></i> {{-- Mengganti icon dari plus menjadi edit --}}
                            <h3 class="card-title mb-0 fw-bold">{{ $title }}</h3>
                        </div>
                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.kategori-pengaduan.index') }}"
                            class="btn btn-light btn-sm shadow-sm d-flex align-items-center">
                            <i class="fas fa-chevron-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- CARD BODY: FORM --}}
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.kategori-pengaduan.update', $kategori->id) }}" method="POST"
                        class="custom-form needs-validation" novalidate>
                        @csrf
                        @method('PUT') {{-- PENTING: Menggunakan method PUT untuk update --}}

                        {{-- Layout Form dengan Spacing yang Konsisten (g-4) --}}
                        <div class="row g-4">

                            {{-- Input: Nama Kategori --}}
                            <div class="col-md-12">
                                <label for="nama_kategori" class="form-label text-dark fw-semibold mb-2">
                                    Nama Kategori <span class="text-danger ms-1">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    {{-- Icon Prefix --}}
                                    <span class="input-group-text bg-light text-primary border-primary"><i class="fas fa-tag"></i></span>
                                    <input type="text" id="nama_kategori" name="nama"
                                        class="form-control border-start-0 border-primary @error('nama') is-invalid @enderror"
                                        placeholder="Contoh: Pelayanan Publik / Infrastruktur" maxlength="200" required
                                        value="{{ old('nama', $kategori->nama) }}"> {{-- Menggunakan nilai lama atau data kategori --}}

                                    {{-- Char Counter (Suffix) --}}
                                    <span id="charCount" class="input-group-text bg-light text-secondary small"
                                        style="min-width: 60px;">0/200</span>

                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @else
                                        <div class="invalid-feedback">
                                            Nama kategori wajib diisi dan maksimal 200 karakter.
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Input: SLA Hari (Service Level Agreement) --}}
                            <div class="col-md-12">
                                <label for="sla_hari" class="form-label text-dark fw-semibold mb-2">
                                    SLA Hari (Waktu Penyelesaian) <span class="text-danger ms-1">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    {{-- Icon Prefix --}}
                                    <span class="input-group-text bg-light text-success border-success"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="number" id="sla_hari" name="sla_hari"
                                        class="form-control border-start-0 border-success @error('sla_hari') is-invalid @enderror"
                                        placeholder="Minimal 1 hari" min="1" required
                                        value="{{ old('sla_hari', $kategori->sla_hari) }}"> {{-- Menggunakan nilai lama atau data kategori --}}
                                    {{-- Text Suffix --}}
                                    <span class="input-group-text bg-success text-white fw-bold">Hari</span>

                                    @error('sla_hari')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @else
                                        <div class="invalid-feedback">
                                            SLA Hari wajib diisi dan minimal 1.
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Input: Prioritas --}}
                            <div class="col-md-12 mb-4">
                                <label for="prioritas" class="form-label text-dark fw-semibold mb-2">
                                    Prioritas Kategori <span class="text-danger ms-1">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    {{-- Icon Prefix --}}
                                    <span class="input-group-text bg-light text-danger border-danger"><i class="fas fa-exclamation-triangle"></i></span>
                                    <select id="prioritas" name="prioritas"
                                        class="form-control border-start-0 border-danger @error('prioritas') is-invalid @enderror"
                                        required>
                                        <option value="" disabled>Pilih Tingkat Prioritas</option>
                                        {{-- Menggunakan operator null coalescing untuk old() dan data kategori --}}
                                        <option value="Tinggi" {{ old('prioritas', $kategori->prioritas) == 'Tinggi' ? 'selected' : '' }}>🔴 Tinggi (High)</option>
                                        <option value="Sedang" {{ old('prioritas', $kategori->prioritas) == 'Sedang' ? 'selected' : '' }}>🟠 Sedang (Medium)</option>
                                        <option value="Rendah" {{ old('prioritas', $kategori->prioritas) == 'Rendah' ? 'selected' : '' }}>🟢 Rendah (Low)</option>
                                    </select>
                                </div>

                                @error('prioritas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div class="invalid-feedback">
                                        Prioritas wajib dipilih.
                                    </div>
                                @enderror
                            </div>

                            {{-- Action Buttons --}}
                            <div class="col-12">
                                <hr class="mt-4 mb-3">
                                <div class="d-flex justify-content-end">

                                    {{-- Mengganti warna dan teks tombol untuk aksi Edit --}}
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm text-white fw-bold">
                                        <i class="fas fa-save mr-2"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // =======================================================
            // 1. Inisialisasi dan Logika Character Counter
            // =======================================================
            const namaInput = document.getElementById('nama_kategori');
            const charCounter = document.getElementById('charCount');
            const maxLength = namaInput ? namaInput.getAttribute('maxlength') || 200 : 200;

            /**
             * Memperbarui tampilan penghitung karakter.
             */
            const updateCounter = () => {
                if (!namaInput || !charCounter) return;

                const currentLength = namaInput.value.length;
                charCounter.textContent = `${currentLength}/${maxLength}`;

                // Indikasi visual (merah) jika sisa karakter <= 20
                if (currentLength >= maxLength - 20) {
                    charCounter.classList.remove('text-secondary');
                    charCounter.classList.add('text-danger', 'fw-bold');
                } else {
                    charCounter.classList.add('text-secondary');
                    charCounter.classList.remove('text-danger', 'fw-bold');
                }
            };

            // Tambahkan event listener dan panggil saat inisialisasi
            if (namaInput && charCounter) {
                namaInput.addEventListener('input', updateCounter);
                updateCounter(); // Set nilai awal (dari data lama/old() atau $kategori)
            }

            // =======================================================
            // 2. Logika Validasi Formulir Bootstrap 5
            // =======================================================
            const form = document.querySelector('.needs-validation');
            if (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            }
        });
    </script>
@endpush
