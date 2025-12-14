@extends('layouts_admin.app')

@section('konten')
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white p-4 rounded-top-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0">
                            {{ isset($pengaduan) ? '📝 Edit Laporan Pengaduan' : '📣 Ajukan Laporan Pengaduan Baru' }}
                        </h4>
                    </div>
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('pengaduan.index') }}" class="btn btn-light btn-sm shadow-sm d-flex align-items-center">
                        <i class="fas fa-chevron-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                {{-- Form ditujukan ke tombol submit tersembunyi yang akan dipicu oleh JS setelah konfirmasi --}}
                <form
                    action="{{ isset($pengaduan) ? route('pengaduan.update', $pengaduan->pengaduan_id) : route('pengaduan.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @if (isset($pengaduan))
                        @method('PUT')
                    @endif

                    <div class="row g-4 mb-4">
                        @php
                            $isGuest = Auth::check() && (Auth::user()->role ?? null) === 'guest';

                            // Ambil warga milik user login (sesuaikan kalau relasinya beda)
                            $authWargaId = optional(Auth::user()->warga)->warga_id;
                            $authWargaNama = optional(Auth::user()->warga)->nama;
                        @endphp

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label font-weight-bold" for="nama_warga">
                                    Warga Pelapor <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <input type="text" id="nama_warga"
                                        class="form-control @error('warga_id') is-invalid @enderror"
                                        placeholder="Pilih Pelapor..."
                                        value="{{ old(
                                            'nama_warga',
                                            $isGuest ? $authWargaNama ?? '' : (isset($pengaduan) ? $pengaduan->warga->nama ?? '' : ''),
                                        ) }}"
                                        readonly required>

                                    <input type="hidden" name="warga_id" id="warga_id"
                                        value="{{ old('warga_id', $isGuest ? $authWargaId ?? '' : $pengaduan->warga_id ?? '') }}"
                                        required>

                                    {{-- Tombol pilih warga hanya untuk non-guest --}}
                                    @if (!$isGuest)
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                            data-target="#modalWarga">
                                            Pilih Warga
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary" disabled
                                            title="Guest otomatis menggunakan data akun">
                                            Otomatis
                                        </button>
                                    @endif
                                </div>

                                @if ($isGuest && empty($authWargaId))
                                    <small class="text-danger d-block mt-1">
                                        Data warga untuk akun ini belum terhubung. Hubungi admin.
                                    </small>
                                @endif

                                @error('warga_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori_id" class="form-label font-weight-bold">Kategori Pengaduan <span
                                        class="text-danger">*</span></label>
                                <select name="kategori_id" id="kategori_id"
                                    class="form-control form-select select2 @error('kategori_id') is-invalid @enderror"
                                    required>
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->kategori_id }}"
                                            {{ old('kategori_id', $pengaduan->kategori_id ?? '') == $k->kategori_id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="judul" class="form-label font-weight-bold">Judul Pengaduan <span
                                class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul"
                            class="form-control @error('judul') is-invalid @enderror"
                            placeholder="Contoh: Lampu jalan mati di Jl. Sudirman"
                            value="{{ old('judul', $pengaduan->judul ?? '') }}" required>
                        @error('judul')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="deskripsi" class="form-label font-weight-bold">Deskripsi Lengkap <span
                                class="text-danger">*</span></label>
                        <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Jelaskan detail pengaduan..." required>{{ old('deskripsi', $pengaduan->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5 class="mb-3 text-secondary border-bottom pb-2">📍 Informasi Lokasi Kejadian (Opsional)</h5>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lokasi_text" class="form-label">Nama/Detail Lokasi</label>
                                <input type="text" name="lokasi_text" id="lokasi_text"
                                    class="form-control @error('lokasi_text') is-invalid @enderror"
                                    placeholder="Contoh: Depan pos ronda"
                                    value="{{ old('lokasi_text', $pengaduan->lokasi_text ?? '') }}">
                                @error('lokasi_text')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="rt" class="form-label">RT</label>
                                <input type="text" name="rt" id="rt"
                                    class="form-control @error('rt') is-invalid @enderror" placeholder="Contoh: 005"
                                    value="{{ old('rt', $pengaduan->rt ?? '') }}">
                                @error('rt')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="rw" class="form-label">RW</label>
                                <input type="text" name="rw" id="rw"
                                    class="form-control @error('rw') is-invalid @enderror" placeholder="Contoh: 002"
                                    value="{{ old('rw', $pengaduan->rw ?? '') }}">
                                @error('rw')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="lampiran" class="form-label font-weight-bold">Lampiran Bukti (Foto/Dokumen)</label>

                        {{-- Input File Multiple --}}
                        <input type="file" name="lampiran[]" id="lampiran" class="form-control" multiple>

                        <small class="form-text text-muted">
                            Bisa upload banyak file sekaligus. Tekan <kbd>Ctrl</kbd> (Windows) atau <kbd>Cmd</kbd> (Mac)
                            saat
                            memilih file.
                        </small>
                        @error('lampiran')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('lampiran.*')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Menampilkan Lampiran yang Sudah Ada (Mode Edit) --}}
                    @if (isset($pengaduan) && $pengaduan->media->count() > 0)
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-3"><i class="fas fa-paperclip me-2"></i>Lampiran Tersimpan:</h6>
                                <div class="row g-2">
                                    @foreach ($pengaduan->media as $media)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center bg-white p-2 rounded border shadow-sm">
                                                <div class="me-3 text-primary">
                                                    {{-- Ikon berdasarkan tipe file sederhana --}}
                                                    @if (Str::startsWith($media->mime_type, 'image'))
                                                        <i class="fas fa-image fa-lg"></i>
                                                    @elseif(Str::endsWith($media->mime_type, 'pdf'))
                                                        <i class="fas fa-file-pdf fa-lg"></i>
                                                    @else
                                                        <i class="fas fa-file-alt fa-lg"></i>
                                                    @endif
                                                </div>
                                                <div class="overflow-hidden flex-grow-1">
                                                    {{-- Nama file menjadi tautan yang dapat diklik --}}
                                                    <a href="{{ asset('storage/' . $media->file_name) }}" target="_blank"
                                                        class="text-dark text-decoration-none text-truncate d-block fw-bold"
                                                        style="max-width: 100%; cursor: pointer;"
                                                        title="Klik untuk lihat file">
                                                        {{ basename($media->file_name) }}
                                                    </a>
                                                    <small class="text-muted" style="font-size: 0.75rem;">
                                                        {{ $media->mime_type ?? 'File' }}
                                                    </small>
                                                </div>
                                                <div class="ms-2">
                                                    <a href="{{ asset('storage/' . $media->file_name) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="d-block text-muted mt-2 fst-italic">
                                    * Upload file baru di atas akan <strong>menambah</strong> lampiran, tidak menghapus yang
                                    lama.
                                </small>
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <hr class="mt-4 mb-3">
                        <div class="d-flex justify-content-end">

                            <button type="button" id="btnKonfirmasi" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                {{ isset($pengaduan) ? 'SIMPAN PERUBAHAN' : 'LANJUT KE KONFIRMASI' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Pilih Warga (DataTables) --}}
    <div class="modal fade" id="modalWarga" tabindex="-1" aria-labelledby="modalWargaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-secondary text-white p-3">
                    <h5 class="modal-title" id="modalWargaLabel">Pilih Warga Pelapor</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="table-responsive rounded">
                        <table id="datatable" class="table table-hover table-striped table-bordered data-tables w-100">
                            <thead class="bg-light text-uppercase">
                                <tr>
                                    <th>No.</th>
                                    <th>email</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th width="120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warga as $w)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <th>{{ $w->user->email }}</th>
                                        <td>{{ $w->nama }}</td>
                                        <td>{{ $w->no_ktp }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success pilihWarga"
                                                data-id="{{ $w->warga_id }}" data-nama="{{ $w->nama }}"
                                                data-dismiss="modal">
                                                <i class="fas fa-check-circle me-1"></i> Pilih
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- End Modal Pilih Warga --}}

    {{-- Modal Konfirmasi Data Sebelum Submit --}}
    <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalKonfirmasiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-warning text-dark p-3">
                    <h5 class="modal-title" id="modalKonfirmasiLabel"><i class="fas fa-exclamation-triangle me-2"></i>
                        Konfirmasi Data Laporan</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <p class="lead mb-2">Pastikan data berikut sudah benar.</p>
                    <p class="mb-0">Laporan yang sudah diajukan tidak dapat diubah lagi!</p>
                    <ul class="list-group list-group-flush mb-4 border rounded">
                        <li
                            class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                            <span class="fw-bold me-md-3">Warga Pelapor</span>
                            <span id="konf_nama_warga" class="fw-bold text-primary text-md-end"></span>
                        </li>
                        <li
                            class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                            <span class="fw-bold me-md-3">Kategori</span>
                            <span id="konf_kategori" class="fw-bold text-primary text-md-end"></span>
                        </li>
                        <li class="list-group-item py-3">
                            <span class="fw-bold d-block mb-1">Judul Laporan</span>
                            <p id="konf_judul" class="mb-0 text-break"></p>
                        </li>
                        <li class="list-group-item py-3">
                            <span class="fw-bold d-block mb-1">Deskripsi</span>
                            <p id="konf_deskripsi" class="mb-0 text-break"></p>
                        </li>
                        <li
                            class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                            <span class="fw-bold me-md-3">Lokasi (RT/RW)</span>
                            <span id="konf_lokasi" class="text-muted text-md-end"></span>
                        </li>
                        <li
                            class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                            <span class="fw-bold me-md-3">Lampiran</span>
                            {{-- Diganti menjadi div/p untuk menampung HTML link --}}
                            <div id="konf_lampiran" class="text-muted text-md-end"></div>
                        </li>
                    </ul>

                    <div class="alert alert-danger d-flex align-items-start" role="alert">
                        <div>
                            <h5 class="fw-bold mb-2">PERHATIAN!</h5>
                            <p class="mb-0">
                                Dengan menekan tombol <strong>Kirim Laporan</strong>, Anda mengonfirmasi bahwa semua data di
                                atas sudah
                                benar dan setuju untuk melanjutkan.
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer p-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal / Koreksi</button>
                        <button type="button" id="btnKirimAkhir" class="btn btn-danger">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ isset($pengaduan) ? 'SIMPAN PERUBAHAN' : 'KIRIM LAPORAN SEKARANG' }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Konfirmasi --}}
@endsection

@push('scripts')
    <script>
        // Membungkus script agar variabel tidak bentrok (Scope Isolation)
        document.addEventListener("DOMContentLoaded", function() {
            // ==============================
            // Inisialisasi Select2 Kategori
            // ==============================
            $('.select2').select2({
                width: '100%',
                placeholder: "Pilih kategori...",
                allowClear: true
            });

            // ==============================
            // 1. LOGIKA MODAL PILIH WARGA
            // ==============================

            // Fungsi untuk memberi highlight pada baris warga yang sedang dipilih
            function highlightSelectedWarga() {
                const selectedWargaId = document.getElementById('warga_id').value;

                // Reset semua baris
                document.querySelectorAll('#datatable tbody tr').forEach(row => {
                    row.classList.remove('table-success', 'fw-bold');
                });

                // Reset semua tombol
                document.querySelectorAll('.pilihWarga').forEach(button => {
                    const buttonId = button.getAttribute('data-id');

                    // Set default state tombol
                    button.disabled = false;
                    button.classList.remove('btn-secondary');
                    button.classList.add('btn-success');
                    button.innerHTML = '<i class="fas fa-check-circle me-1"></i> Pilih';

                    // Jika ID cocok, ubah jadi "Terpilih"
                    if (buttonId == selectedWargaId) {
                        const row = button.closest('tr');
                        row.classList.add('table-success', 'fw-bold');

                        button.textContent = 'Terpilih';
                        button.disabled = true;
                        button.classList.remove('btn-success');
                        button.classList.add('btn-secondary');
                    }
                });
            }

            // Event Listener untuk tombol "Pilih" di dalam tabel
            const tableBody = document.querySelector('#datatable tbody');
            if (tableBody) {
                tableBody.addEventListener('click', function(e) {
                    const button = e.target.closest('.pilihWarga');
                    if (button) {
                        let id = button.getAttribute('data-id');
                        let nama = button.getAttribute('data-nama');

                        // Set nilai ke input hidden dan text
                        document.getElementById('warga_id').value = id;
                        document.getElementById('nama_warga').value = nama;

                        // Hapus state error jika ada
                        document.getElementById('nama_warga').classList.remove('is-invalid');

                        // Update tampilan tombol
                        highlightSelectedWarga();

                        // Tutup modal (menggunakan jQuery karena Bootstrap 4/5 mix sering butuh ini)
                        $('#modalWarga').modal('hide');
                    }
                });
            }

            // Jalankan highlight saat modal dibuka
            const modalWarga = document.getElementById('modalWarga');
            if (modalWarga) {
                modalWarga.addEventListener('show.bs.modal', function() {
                    highlightSelectedWarga();
                });
            }

            // ==============================
            // 2. LOGIKA MODAL KONFIRMASI (TERMASUK PERBAIKAN TAUTAN LOKAL UNTUK SEMUA FILE)
            // ==============================

            function prepareConfirmationModal() {
                // Ambil Value dari Form
                const namaWarga = document.getElementById('nama_warga').value;

                // Ambil text dari dropdown kategori (bukan value ID-nya)
                const kategoriSelect = document.getElementById('kategori_id');
                let kategoriNama = '-';
                if (kategoriSelect.selectedIndex !== -1) {
                    kategoriNama = kategoriSelect.options[kategoriSelect.selectedIndex].text;
                }

                const judul = document.getElementById('judul').value;
                const deskripsi = document.getElementById('deskripsi').value;
                const lokasiText = document.getElementById('lokasi_text').value.trim() || '-';
                const rt = document.getElementById('rt').value.trim() || '-';
                const rw = document.getElementById('rw').value.trim() || '-';

                const lampiranInput = document.getElementById('lampiran');

                // --- Logika Tampilan Lampiran ---
                let lampiranHTML = '';

                // A. Cek File Baru (Multiple)
                if (lampiranInput.files && lampiranInput.files.length > 0) {
                    lampiranHTML +=
                        '<div class="mb-2"><strong class="text-success">File Baru (Akan Diunggah):</strong><ul class="mb-0 ps-3 mt-1">';

                    // Loop semua file yang dipilih
                    for (let i = 0; i < lampiranInput.files.length; i++) {
                        const file = lampiranInput.files[i];
                        const sizeKB = Math.round(file.size / 1024);

                        // **MODIFIKASI: Terapkan Tautan Lokal untuk SEMUA file**
                        const fileURL = URL.createObjectURL(file);

                        const fileNameDisplay = `
                            <a href="${fileURL}" target="_blank" class="text-success fw-bold"
                                title="Klik untuk Pratinjau/Unduh (File lokal, akan terbuka di tab baru)">
                                ${file.name}
                            </a>
                            <small class="text-muted">(${sizeKB} KB)</small>
                        `;
                        // END MODIFIKASI

                        lampiranHTML += `<li>${fileNameDisplay}</li>`;
                    }
                    lampiranHTML += '</ul></div>';
                } else {
                    lampiranHTML +=
                        '<div class="mb-2 text-muted fst-italic"><small>- Tidak ada file baru yang dipilih -</small></div>';
                }

                // B. Cek File Lama (Deteksi elemen DOM dari view)
                const jumlahLampiranLama = document.querySelectorAll('.card.bg-light .row .col-md-6').length;

                if (jumlahLampiranLama > 0) {
                    lampiranHTML += `
                            <div class="mt-2 pt-2 border-top">
                                <strong class="text-primary">File Sebelumnya:</strong>
                                <span class="badge bg-info text-dark">${jumlahLampiranLama} file tersimpan</span>
                                <div class="small text-muted fst-italic mt-1">
                                    (File lama tidak akan dihapus)
                                </div>
                            </div>
                        `;
                }

                // --- Masukkan Data ke Elemen Modal ---
                document.getElementById('konf_nama_warga').textContent = namaWarga;
                document.getElementById('konf_kategori').textContent = kategoriNama;
                document.getElementById('konf_judul').textContent = judul;
                document.getElementById('konf_deskripsi').textContent = deskripsi;

                // Format Lokasi
                let lokasiFull = lokasiText;
                if (rt !== '-' || rw !== '-') {
                    lokasiFull += ` (RT ${rt} / RW ${rw})`;
                }
                document.getElementById('konf_lokasi').textContent = lokasiFull;

                // Set HTML lampiran
                document.getElementById('konf_lampiran').innerHTML = lampiranHTML;
            }

            // Event Listener Tombol "Lanjut ke Konfirmasi"
            const btnKonfirmasi = document.getElementById('btnKonfirmasi');
            if (btnKonfirmasi) {
                btnKonfirmasi.addEventListener('click', function() {
                    // Cek validitas form sebelum membuka modal
                    const form = document.querySelector('form');
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }

                    prepareConfirmationModal();
                    // Menggunakan jQuery untuk Bootstrap 4/5 Modal
                    $('#modalKonfirmasi').modal('show');
                });
            }

            // Event Listener Tombol "Kirim Laporan" (Final Submit)
            const btnKirimAkhir = document.getElementById('btnKirimAkhir');
            if (btnKirimAkhir) {
                btnKirimAkhir.addEventListener('click', function() {
                    // Submit form secara manual
                    const form = document.querySelector('form');
                    if (form) form.submit();
                });
            }
        });
    </script>
@endpush
