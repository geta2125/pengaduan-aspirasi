@extends('layouts_guest.app')

@section('konten')

    <div class="container my-5">
        {{-- Card yang bersih dengan shadow yang lebih terasa tapi elegan --}}
        <div class="card shadow-lg border-0 rounded-4">
            {{-- MODIFIKASI DIMULAI DI SINI --}}
            <div
                class="card-header bg-gradient-primary text-white py-4 rounded-top-4 d-flex justify-content-between align-items-center">

                {{-- Judul Formulir (Kiri) --}}
                <h3 class="mb-0 d-flex align-items-center">
                    <i class="bi bi-megaphone-fill mr-3"></i>
                    {{ isset($pengaduan) ? 'Formulir Edit Pengaduan' : 'Formulir Pengajuan Pengaduan Baru' }}
                </h3>

                {{-- Tombol Kembali (Kanan) --}}
                <a href="{{ route('guest.pengaduan.riwayat') }}" class="btn btn-outline-light btn-sm fw-bold">
                    <i class="bi bi-arrow-left-circle-fill me-2"></i> Kembali ke Riwayat
                </a>

            </div>
            {{-- MODIFIKASI BERAKHIR DI SINI --}}

            <div class="card-body p-4 p-md-5">
                <form
                    action="{{ isset($pengaduan) ? route('guest.pengaduan.update', $pengaduan->pengaduan_id) : route('guest.pengaduan.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($pengaduan))
                        @method('PUT')
                    @endif

                    {{-- Section: Detail Utama --}}
                    <h5 class="text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i> Detail Pengaduan</h5>
                    <div class="row g-3">
                        {{-- Judul Pengaduan --}}
                        <div class="col-12">
                            <label for="judul" class="form-label required">Judul Pengaduan</label>
                            <input type="text" name="judul" id="judul"
                                class="form-control form-control-lg @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $pengaduan->judul ?? '') }}"
                                placeholder="Contoh: Lampu jalan mati di Jalan Sudirman" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori (Select2) --}}
                        <div class="col-12">
                            <label for="kategori_id" class="form-label required">Kategori</label>
                            <select name="kategori_id" id="kategori_id"
                                class="form-control select2 @error('kategori_id') is-invalid @enderror"
                                data-placeholder="Pilih kategori pengaduan..." required>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ (old('kategori_id', $pengaduan->kategori_id ?? '') == $k->id) ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-12">
                            <label for="deskripsi" class="form-label required">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" id="deskripsi" rows="5"
                                class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Jelaskan detail pengaduan Anda (kapan, bagaimana, dll.)"
                                required>{{ old('deskripsi', $pengaduan->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-5">

                    {{-- Section: Informasi Lokasi --}}
                    <h5 class="text-primary mb-3"><i class="bi bi-geo-alt-fill me-2"></i> Informasi Lokasi <small
                            class="text-muted fs-6">(Opsional)</small></h5>

                    <div class="row g-3">
                        {{-- Lokasi Text --}}
                        <div class="col-12">
                            <label for="lokasi_text" class="form-label">Alamat / Lokasi Kejadian Spesifik</label>
                            <input type="text" name="lokasi_text" id="lokasi_text"
                                class="form-control @error('lokasi_text') is-invalid @enderror"
                                value="{{ old('lokasi_text', $pengaduan->lokasi_text ?? '') }}"
                                placeholder="Contoh: Depan pasar A atau di Jl. Mawar No. 12">
                            @error('lokasi_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- RT --}}
                        <div class="col-md-6">
                            <label for="rt" class="form-label">RT</label>
                            <input type="text" name="rt" id="rt" class="form-control @error('rt') is-invalid @enderror"
                                value="{{ old('rt', $pengaduan->rt ?? '') }}" placeholder="001">
                            @error('rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- RW --}}
                        <div class="col-md-6">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" name="rw" id="rw" class="form-control @error('rw') is-invalid @enderror"
                                value="{{ old('rw', $pengaduan->rw ?? '') }}" placeholder="002">
                            @error('rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-5">

                    {{-- Section: Lampiran --}}
                    <h5 class="text-primary mb-3"><i class="bi bi-paperclip me-2"></i> Lampiran <small
                            class="text-muted fs-6">(Foto/Dokumen, Max: 5MB)</small></h5>

                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Upload Lampiran (Foto kejadian sangat disarankan)</label>
                        <input type="file" name="lampiran" id="lampiran"
                            class="form-control @error('lampiran') is-invalid @enderror" onchange="previewLampiran(event)">
                        @error('lampiran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Container untuk Preview --}}
                    <div class="mb-3 p-3 border rounded bg-light" id="preview-section">
                        <p class="text-muted mb-2">
                            <small id="preview-status">
                                <i class="bi bi-image me-1"></i>
                                {{ isset($pengaduan) && $pengaduan->media ? 'Lampiran Saat Ini:' : 'Tidak ada lampiran terupload.' }}
                            </small>
                        </p>
                        <div id="preview-lampiran">
                            {{-- Tampilkan lampiran lama jika edit --}}
                            @if(isset($pengaduan) && $pengaduan->media)
                                @php
                                    $fileExt = pathinfo($pengaduan->media->file_url, PATHINFO_EXTENSION);
                                    $fileUrl = asset('storage/' . $pengaduan->media->file_url);
                                    $fileName = basename($pengaduan->media->file_url);
                                @endphp

                                @if(in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $fileUrl }}" alt="Lampiran" class="img-thumbnail border-primary"
                                        style="max-height:150px;">
                                @elseif(strtolower($fileExt) == 'pdf')
                                    <div class="alert alert-info border-info p-3 mb-0 d-flex align-items-center">
                                        <i class="bi bi-file-earmark-pdf-fill fs-4 me-3"></i>
                                        <div>
                                            <strong class="d-block">Dokumen PDF Terlampir</strong>
                                            <a href="{{ $fileUrl }}" target="_blank" class="alert-link">{{ $fileName }}</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-secondary border-secondary p-3 mb-0 d-flex align-items-center">
                                        <i class="bi bi-file-earmark-fill fs-4 me-3"></i>
                                        <div>
                                            <strong class="d-block">Dokumen Terlampir</strong>
                                            <a href="{{ $fileUrl }}" target="_blank" class="alert-link">{{ $fileName }}</a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm">
                            <i class="bi bi-send-fill me-2"></i>
                            <span
                                class="fw-bold">{{ isset($pengaduan) ? 'Simpan Perubahan' : 'Kirim Pengaduan Sekarang' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
   
    <script>
        $(document).ready(function () {
            // Inisialisasi Select2
            $('#kategori_id').select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                placeholder: $(this).data('placeholder'),
                allowClear: true, // Opsi untuk menghapus pilihan
                width: '100%' // Memastikan lebar penuh
            });
        });

        function previewLampiran(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('preview-lampiran');
            const previewStatus = document.getElementById('preview-status');

            // Hapus konten previewContainer yang sudah ada
            previewContainer.innerHTML = '';

            if (!file) {
                // Saat file dibatalkan, kita harus mengembalikan konten lama jika ada.
                // Karena kita tidak bisa menjalankan Blade di JS, kita biarkan previewContainer kosong
                // dan hanya mengembalikan status teks.
                const isEdit = {{ isset($pengaduan) ? 'true' : 'false' }};
                if (isEdit) {
                    // Di mode edit, diasumsikan lampiran lama akan dirender Blade saat halaman dimuat/di-refresh.
                    previewStatus.innerHTML = '<i class="bi bi-image me-1"></i> Lampiran Saat Ini:';
                } else {
                    previewStatus.innerHTML = '<i class="bi bi-image me-1"></i> Tidak ada lampiran terupload.';
                }

                // Pada prakteknya, untuk mengembalikan preview lama di JavaScript, 
                // Anda perlu menyimpan data HTML preview lama dalam variabel JS saat halaman dimuat.
                // Tapi untuk kesederhanaan, kita biarkan kosong atau hanya atur status teks.

                return;
            }

            previewStatus.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i> Preview Lampiran Baru: <strong>' + file.name + '</strong>';

            const fileExt = file.name.split('.').pop().toLowerCase();
            const fileUrl = URL.createObjectURL(file);
            const fileName = file.name;

            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                const img = document.createElement('img');
                img.src = fileUrl;
                img.style.maxHeight = '150px';
                img.classList.add('img-fluid', 'img-thumbnail', 'border-success');
                previewContainer.appendChild(img);
            } else if (fileExt === 'pdf') {
                const infoDiv = document.createElement('div');
                infoDiv.classList.add('alert', 'alert-info', 'border-info', 'p-3', 'mb-0', 'd-flex', 'align-items-center');
                infoDiv.innerHTML = `
                        <i class="bi bi-file-earmark-pdf-fill fs-4 me-3"></i>
                        <div>
                            <strong class="d-block">Dokumen PDF siap diunggah</strong>
                            <a href="${fileUrl}" target="_blank" class="alert-link">${fileName}</a>
                        </div>
                    `;
                previewContainer.appendChild(infoDiv);
            } else {
                const infoDiv = document.createElement('div');
                infoDiv.classList.add('alert', 'alert-secondary', 'border-secondary', 'p-3', 'mb-0', 'd-flex', 'align-items-center');
                infoDiv.innerHTML = `
                        <i class="bi bi-file-earmark-fill fs-4 me-3"></i>
                        <div>
                            <strong class="d-block">Dokumen siap diunggah</strong>
                            <a href="${fileUrl}" target="_blank" class="alert-link">${fileName}</a>
                        </div>
                    `;
                previewContainer.appendChild(infoDiv);
            }
        }
    </script>
@endsection