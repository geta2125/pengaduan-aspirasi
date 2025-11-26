@extends('layouts_admin.app')

@section('konten')
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white p-4 rounded-top-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0">{{ isset($pengaduan) ? '📝 Edit Laporan Pengaduan' : '📣 Ajukan Laporan Pengaduan Baru' }}
                        </h4>
                    </div>
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('admin.pengaduan.index') }}"
                        class="btn btn-light btn-sm shadow-sm d-flex align-items-center">
                        <i class="fas fa-chevron-left mr-2"></i> Kembali
                    </a>
                    </div>
                    </div>

            <div class="card-body p-4 p-md-5">
                {{-- Form ditujukan ke tombol submit tersembunyi yang akan dipicu oleh JS setelah konfirmasi --}}
                <form
                    action="{{ isset($pengaduan) ? route('guest.pengaduan.update', $pengaduan->pengaduan_id) : route('guest.pengaduan.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @if (isset($pengaduan))
                        @method('PUT')
                    @endif

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label font-weight-bold" for="nama_warga">Warga Pelapor <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    {{-- Tambahkan is-invalid jika ada error untuk visual feedback --}}
                                    <input type="text" id="nama_warga" class="form-control @error('warga_id') is-invalid @enderror"
                                        placeholder="Pilih Pelapor..." value="{{ isset($pengaduan) ? $pengaduan->warga->nama : '' }}" readonly required>
                                    <input type="hidden" name="warga_id" id="warga_id" value="{{ old('warga_id', $pengaduan->warga_id ?? '') }}" required>
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalWarga">
                                        Pilih Warga
                                    </button>
                                    </div>
                                    @error('warga_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kategori_id" class="form-label font-weight-bold">Kategori Pengaduan <span
                                                    class="text-danger">*</span></label>
                                            <select name="kategori_id" id="kategori_id" class="form-control form-select @error('kategori_id') is-invalid @enderror"
                                                required>
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach ($kategori as $k)
                                                    <option value="{{ $k->id }}" {{ old('kategori_id', $pengaduan->kategori_id ?? '') == $k->id ? 'selected' : '' }}>
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
                                        <label for="judul" class="form-label font-weight-bold">Judul Pengaduan <span class="text-danger">*</span></label>
                                        <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror"
                                            placeholder="Contoh: Lampu jalan mati di Jl. Sudirman" value="{{ old('judul', $pengaduan->judul ?? '') }}" required>
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
                                                <input type="text" name="lokasi_text" id="lokasi_text" class="form-control @error('lokasi_text') is-invalid @enderror"
                                                    placeholder="Contoh: Depan pos ronda" value="{{ old('lokasi_text', $pengaduan->lokasi_text ?? '') }}">
                                                @error('lokasi_text')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                                </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="rt" class="form-label">RT</label>
                                                <input type="text" name="rt" id="rt" class="form-control @error('rt') is-invalid @enderror" placeholder="Contoh: 005"
                                                    value="{{ old('rt', $pengaduan->rt ?? '') }}">
                                                @error('rt')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                                </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="rw" class="form-label">RW</label>
                                                <input type="text" name="rw" id="rw" class="form-control @error('rw') is-invalid @enderror" placeholder="Contoh: 002"
                                                    value="{{ old('rw', $pengaduan->rw ?? '') }}">
                                                @error('rw')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                                </div>
                                                </div>
                                                </div>

                                    <div class="form-group mb-4">
                                        <label for="lampiran" class="form-label font-weight-bold">Lampiran Bukti (Foto/Dokumen)</label>
                                        <input type="file" name="lampiran" id="lampiran" class="form-control @error('lampiran') is-invalid @enderror">
                                        <small class="form-text text-muted">Maksimal ukuran file: 2MB (hanya terima format
                                            gambar/pdf).</small>
                                        @error('lampiran')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                        </div>

                                    @if (isset($pengaduan) && $pengaduan->media)
                                        <div class="alert alert-info d-flex align-items-center mb-4 p-3">
                                            <i class="fas fa-paperclip me-3"></i>
                                            <div>
                                                **Lampiran Saat Ini:**
                                                <a href="{{ asset('storage/' . $pengaduan->media->file_url) }}" target="_blank" class="alert-link fw-bold ms-2">
                                                    {{ basename($pengaduan->media->file_url) }}
                                                </a>
                                                <small class="d-block text-muted">Abaikan jika ingin menggunakan lampiran ini. Pilih file baru
                                                    untuk mengganti.</small>
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
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th width="120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warga as $w)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <th>{{ $w->user->username }}</th>
                                        <td>{{ $w->nama }}</td>
                                        <td>{{ $w->no_ktp }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success pilihWarga"
                                                data-id="{{ $w->warga_id }}" data-nama="{{ $w->nama }}" data-dismiss="modal">
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
    <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
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
                    <p class="lead">Pastikan data berikut sudah benar. **Laporan yang sudah diajukan tidak dapat diubah
                        lagi!**</p>

                    <ul class="list-group list-group-flush mb-4 border rounded">
                        <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                            <span class="fw-bold me-md-3">Warga Pelapor</span>
                            <span id="konf_nama_warga" class="fw-bold text-primary text-md-end"></span>
                        </li>
                        <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
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
                        <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                            <span class="fw-bold me-md-3">Lokasi (RT/RW)</span>
                            <span id="konf_lokasi" class="text-muted text-md-end"></span>
                        </li>
                        <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                            <span class="fw-bold me-md-3">Lampiran</span>
                            {{-- Diganti menjadi div/p untuk menampung HTML link --}}
                            <div id="konf_lampiran" class="text-muted text-md-end"></div>
                        </li>
                    </ul>

                    <div class="alert alert-danger" role="alert">
                        ⚠️ **PERHATIAN!** Dengan menekan tombol **Kirim Laporan**, Anda mengonfirmasi bahwa semua data di
                        atas sudah benar dan setuju untuk melanjutkan.
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
    {{-- End Modal Konfirmasi --}}
@endsection

@push('scripts')
    <script>
                            // --- Fungsi untuk Modal Pilih Warga (Tidak Berubah) ---
        function highlightSelectedWarga() {
            const selectedWargaId = document.getElementById('warga_id').value;

            document.querySelectorAll('#datatable tbody tr').forEach(row => {
                row.classList.remove('table-success', 'fw-bold');
            });

            document.querySelectorAll('.pilihWarga').forEach(button => {
                const buttonId = button.getAttribute('data-id');
                // Reset button default state
                button.disabled = false;
                button.classList.remove('btn-secondary');
                button.classList.add('btn-success');
                button.innerHTML = '<i class="fas fa-check-circle me-1"></i> Pilih';


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

        // Event listener untuk tombol 'Pilih' di dalam Modal Warga
        document.querySelectorAll('.pilihWarga').forEach(button => {
            button.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                let nama = this.getAttribute('data-nama');

                // 1. Isi data warga ke dalam form utama
                document.getElementById('warga_id').value = id;
                document.getElementById('nama_warga').value = nama;

                // Hapus indikator error visual jika ada
                document.getElementById('nama_warga').classList.remove('is-invalid');
                document.getElementById('warga_id').dispatchEvent(new Event('change')); // Trigger change event untuk validasi jika perlu

                // 2. Panggil fungsi highlight untuk memperbarui status
                highlightSelectedWarga();

                // 3. TUTUP MODAL SECARA EKSPLISIT
                if (typeof jQuery !== 'undefined' && $.fn.modal) {
                    $('#modalWarga').modal('hide');
                }
            });
        });

        // Panggil fungsi highlight saat modal Warga dibuka
        const modalWarga = document.getElementById('modalWarga');
        if (modalWarga) {
            modalWarga.addEventListener('show.bs.modal', function () {
                highlightSelectedWarga();
            });
        }

        // --- LOGIKA KONFIRMASI SEBELUM SUBMIT ---

        // Fungsi untuk mengisi data ke Modal Konfirmasi
        function prepareConfirmationModal() {
            // Ambil data dari form
            const namaWarga = document.getElementById('nama_warga').value;
            const kategoriSelect = document.getElementById('kategori_id');
            const kategoriNama = kategoriSelect.options[kategoriSelect.selectedIndex].text;
            const judul = document.getElementById('judul').value;
            const deskripsi = document.getElementById('deskripsi').value;
            const lokasiText = document.getElementById('lokasi_text').value.trim() || 'Tidak Diisi';
            const rt = document.getElementById('rt').value.trim() || 'Tidak Diisi';
            const rw = document.getElementById('rw').value.trim() || 'Tidak Diisi';
            const lampiranInput = document.getElementById('lampiran');

            let lampiranStatus = 'Tidak Ada Lampiran';

            // 1. Cek jika ada file baru yang diunggah
            if (lampiranInput.files.length > 0) {
                const newFile = lampiranInput.files[0];
                const fileName = newFile.name;

                // Membuat URL sementara untuk file yang baru diunggah
                const fileUrl = URL.createObjectURL(newFile);

                // Tampilkan nama file baru sebagai link yang bisa diklik
                lampiranStatus = `
                        <span class="d-block">File Baru Akan Diunggah:</span>
                        <a href="${fileUrl}" target="_blank" class="text-danger fw-bold">
                            <i class="fas fa-eye me-1"></i> ${fileName}
                        </a>
                        <small class="d-block text-muted">(Klik untuk pratinjau/buka)</small>
                    `;
            }
                // 2. Cek jika ini mode Edit dan ada lampiran lama
            else if ('{{ isset($pengaduan) && $pengaduan->media ? "ada" : "" }}') {
                const fileUrl = '{{ isset($pengaduan) && $pengaduan->media ? asset('storage/' . $pengaduan->media->file_url) : '' }}';
                const fileName = '{{ isset($pengaduan) && $pengaduan->media ? basename($pengaduan->media->file_url) : '' }}';

                // Buat link yang bisa diklik untuk melihat/mengunduh lampiran lama
                lampiranStatus = `
                        <span class="d-block">Menggunakan Lampiran Lama:</span>
                        <a href="${fileUrl}" target="_blank" class="text-info fw-bold">
                            <i class="fas fa-download me-1"></i> ${fileName}
                        </a>
                    `;
            }

            // Isi data ke modal
            document.getElementById('konf_nama_warga').textContent = namaWarga;
            document.getElementById('konf_kategori').textContent = kategoriNama;
            document.getElementById('konf_judul').textContent = judul;
            document.getElementById('konf_deskripsi').textContent = deskripsi;
            document.getElementById('konf_lokasi').textContent = `${lokasiText} (RT: ${rt}/RW: ${rw})`;
            // Gunakan innerHTML karena lampiranStatus kini berisi tag <a>
            document.getElementById('konf_lampiran').innerHTML = lampiranStatus;
        }

        // Event Listener untuk tombol Konfirmasi (Trigger Modal)
        document.getElementById('btnKonfirmasi').addEventListener('click', function (e) {
            e.preventDefault();

            // 1. Validasi form HTML5 dasar (required fields)
            const form = document.querySelector('form');
            if (!form.reportValidity()) {
                // Browser akan menampilkan pesan error bawaan untuk field yang required yang belum terisi
                return; // Batalkan buka modal
            }

            // 2. Validasi Warga ID (karena input textnya readonly, validasi HTML5 tidak berjalan di situ)
            if (document.getElementById('warga_id').value === '') {
                // Tampilkan alert yang lebih halus jika Anda memiliki library alert seperti SweetAlert atau Toastr.
                // Jika tidak, gunakan alert bawaan browser:
                alert('⚠️ Mohon pilih Warga Pelapor terlebih dahulu sebelum melanjutkan.');
                document.getElementById('nama_warga').classList.add('is-invalid');
                return; // Batalkan buka modal
            }
            document.getElementById('nama_warga').classList.remove('is-invalid');


            // 3. Isi data ke modal
            prepareConfirmationModal();

            // 4. Tampilkan modal
            $('#modalKonfirmasi').modal('show');
        });

        // Event Listener untuk tombol Kirim Akhir di dalam modal
        document.getElementById('btnKirimAkhir').addEventListener('click', function () {
            // Sembunyikan modal konfirmasi
            $('#modalKonfirmasi').modal('hide');

            // Nonaktifkan tombol submit utama untuk mencegah double submit
            const btnKonf = document.getElementById('btnKonfirmasi');
            btnKonf.disabled = true;
            btnKonf.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';

            // Lakukan SUBMIT form yang sebenarnya
            document.getElementById('submitForm').click();
        });

        // Panggil highlight dan set up validasi saat halaman selesai dimuat (untuk kasus Edit)
        window.addEventListener('load', function () {
            highlightSelectedWarga();

            // Logika ini sudah tidak terlalu dibutuhkan karena submit utama dipicu oleh JS,
            // namun dipertahankan untuk jaga-jaga.
            $('form').on('submit', function (e) {
                // Mencegah submit jika Warga ID kosong
                if (document.getElementById('warga_id').value === '') {
                    alert('Mohon pilih Warga Pelapor terlebih dahulu.');
                    document.getElementById('nama_warga').classList.add('is-invalid');
                    e.preventDefault();
                } else {
                    document.getElementById('nama_warga').classList.remove('is-invalid');
                }
            });
        });
    </script>
@endpush
