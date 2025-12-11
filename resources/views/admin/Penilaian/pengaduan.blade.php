 <div class="col-lg-12">
     <div class="card">
         <div class="card-body">

             {{-- Form Filter & Pencarian --}}
             <form method="GET" action="{{ route('admin.penilaian.index') }}" class="mb-4">
                 <div class="row align-items-end">
                     <div class="col-md-7 col-lg-9 mb-3 mb-md-0">
                         <label for="search_query" class="form-label">Cari Pengaduan (Judul/Pelapor)</label>
                         <div class="input-group">
                             <input type="text" name="search" id="search_query" class="form-control"
                                 placeholder="Ketik judul atau nama pelapor..." value="{{ request('search') }}">
                         </div>
                     </div>
                     <div class="col-md-5 col-lg-3">
                         <button type="submit" class="btn btn-secondary mr-2" title="Terapkan Filter">
                             <i class="las la-filter"></i> Filter
                         </button>
                         <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-secondary"
                             title="Reset Filter">
                             <i class="las la-redo"></i> Reset
                         </a>
                     </div>
                 </div>
             </form>

             {{-- Pesan Sukses/Error --}}
             @if (session('success'))
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ session('success') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
             @endif
             @if (session('error'))
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     {{ session('error') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
             @endif

             {{-- Tabel Data --}}
             <div class="table-responsive rounded mb-3">
                 <table class="table table-striped table-hover">
                     <thead class="bg-white text-uppercase">
                         <tr>
                             <th>No</th>
                             <th>Judul Pengaduan</th>
                             <th>Pelapor</th>
                             <th class="text-center">Tanggal Selesai</th>
                             <th class="text-center">Status</th>
                             <th class="text-center">Penilaian</th>
                             <th class="text-center">Aksi</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse ($pengaduan as $index => $p)
                             <tr>
                                 {{-- Nomor Urut (Memperhitungkan Pagination) --}}
                                 <td>{{ $pengaduan->firstItem() + $index }}</td>

                                 <td>
                                     <span class="font-weight-bold">{{ $p->judul }}</span>
                                     <br>
                                     <small class="text-muted">{{ Str::limit($p->deskripsi, 50) }}</small>
                                 </td>

                                 <td>
                                     {{ $p->pelapor }}
                                     <br>
                                     <small class="text-muted">{{ $p->nama }}</small>
                                 </td>

                                 <td class="text-center">
                                     {{ $p->tgl_format_tabel }}
                                     <br>
                                     <small class="text-muted">{{ $p->jam_format }} WIB</small>
                                 </td>

                                 <td class="text-center">
                                     <span
                                         class="badge {{ $p->statusClass }} px-2 py-1">{{ ucfirst($p->status) }}</span>
                                 </td>

                                 {{-- Kolom Penilaian --}}
                                 <td class="text-center">
                                     @if ($p->penilaian)
                                         <span class="badge badge-success px-2 py-1">
                                             <i class="las la-check-circle"></i> Sudah Dinilai
                                         </span>
                                         <br>
                                         {{-- Tampilkan bintang rating --}}
                                         <span class="text-muted">
                                             @for ($i = 1; $i <= 5; $i++)
                                                 <i class="las la-star"
                                                     style="font-size: 0.8rem; color: {{ $i <= $p->penilaian->rating ? '#ffc107' : '#ccc' }};"></i>
                                             @endfor
                                         </span>
                                     @else
                                         <span class="badge badge-secondary px-2 py-1">Belum Dinilai</span>
                                     @endif
                                 </td>

                                 <td class="text-center">
                                     <div class="d-flex justify-content-center" style="gap: 5px;">
                                         {{-- Tombol Detail (Menggunakan modal yang dibuat di bawah) --}}
                                         <button type="button" class="btn btn-sm btn-info detail-btn"
                                             data-toggle="modal" data-target="#detailModal" title="Lihat Detail"
                                             data-p="{{ json_encode($p) }}">
                                             <i class="las la-eye"></i> Detail
                                         </button>

                                         {{-- Tombol BERI/EDIT PENILAIAN (Trigger Modal Dinamis) --}}
                                         @if ($p->penilaian)
                                             {{-- Jika sudah dinilai, tampilkan tombol EDIT --}}
                                             <button type="button" class="btn btn-sm btn-primary penilaian-btn"
                                                 data-toggle="modal" data-target="#penilaianModal"
                                                 data-pengaduan-id="{{ $p->pengaduan_id }}"
                                                 data-penilaian-id="{{ $p->penilaian->penilaian_id }}"
                                                 data-rating="{{ $p->penilaian->rating }}"
                                                 data-komentar="{{ $p->penilaian->komentar ?? '' }}"
                                                 data-judul-pengaduan="{{ $p->judul }}"
                                                 data-nomor-tiket="{{ $p->nomor_tiket }}"
                                                 data-action="{{ route('admin.penilaian.update', $p->penilaian->penilaian_id) }}"
                                                 data-method="PUT" data-modal-title="Edit Penilaian Layanan">
                                                 <i class="las la-edit"></i> Edit Nilai
                                             </button>
                                         @else
                                             {{-- Jika belum dinilai, tampilkan tombol NILAI --}}
                                             <button type="button" class="btn btn-sm btn-warning penilaian-btn"
                                                 data-toggle="modal" data-target="#penilaianModal"
                                                 data-pengaduan-id="{{ $p->pengaduan_id }}" data-penilaian-id=""
                                                 data-rating="0" {{-- Ganti ke 0 agar saat tambah nilai, bintang kosong --}} data-komentar=""
                                                 data-judul-pengaduan="{{ $p->judul }}"
                                                 data-nomor-tiket="{{ $p->nomor_tiket }}"
                                                 data-action="{{ route('admin.penilaian.store') }}" data-method="POST"
                                                 data-modal-title="Beri Penilaian Layanan">
                                                 <i class="las la-star"></i> Nilai
                                             </button>
                                         @endif

                                     </div>
                                 </td>
                             </tr>
                         @empty
                             <tr>
                                 <td colspan="7" class="text-center py-4">
                                     <div class="text-muted">
                                         <i class="las la-folder-open" style="font-size: 2rem;"></i>
                                         <p class="mt-2">Tidak ada pengaduan 'Selesai' yang menunggu penilaian.
                                         </p>
                                     </div>
                                 </td>
                             </tr>
                         @endforelse
                     </tbody>
                 </table>
             </div>

             {{-- Pagination --}}
             <div class="mt-3">
                 {{ $pengaduan->links('pagination::custom') }}
             </div>
         </div>
     </div>
 </div>

 ubah agar bisa crud
 {{-- MODAL DETAIL (Di luar perulangan) --}}
 <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content border-0 shadow-lg">
             <div class="modal-header bg-info text-white"> {{-- Ganti warna header menjadi Info agar berbeda dengan Penilaian --}}
                 <h5 class="modal-title font-weight-bold" id="detailModalTitle">
                     <i class="fas fa-info-circle mr-2"></i>Detail Pengaduan
                 </h5>
                 <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" id="detailModalBody">
                 {{-- Konten akan diisi oleh JavaScript --}}
             </div>
             <div class="modal-footer bg-light">
                 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
             </div>
         </div>
     </div>
 </div>

 {{-- MODAL FORM PENILAIAN (SATU MODAL DINAMIS) --}}
 <div class="modal fade" id="penilaianModal" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content border-0 shadow-lg">
             <div class="modal-header bg-warning text-dark">
                 <h5 class="modal-title font-weight-bold" id="penilaianModalTitle">
                     <i class="las la-star mr-2"></i>Form Penilaian Layanan
                 </h5>
                 <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form id="penilaianForm" action="" method="POST">
                 @csrf
                 {{-- @method('PUT') akan diinjeksikan oleh JS jika edit --}}
                 <div class="modal-body">
                     <p class="text-center mb-4 text-muted" id="penilaianModalDesc">
                         Bagaimana Anda menilai penanganan pengaduan [Judul Pengaduan] (Tiket: [Tiket])?
                     </p>

                     <input type="hidden" name="pengaduan_id" id="modal_pengaduan_id">

                     <div class="form-group text-center">
                         <label for="modal_rating" class="font-weight-bold mb-3 d-block">Pilih Bintang:</label>
                         <div class="rating-stars" style="font-size: 2.5rem; color: #ffc107;">
                             {{-- Bintang statis, radio input akan diklik/diatur via JS/CSS --}}
                             @for ($i = 5; $i >= 1; $i--)
                                 <input type="radio" id="star{{ $i }}" name="rating"
                                     value="{{ $i }}" class="d-none" required {{-- Tambahkan checked jika old rating cocok --}}
                                     @if (old('rating') == $i) checked @endif>
                                 <label for="star{{ $i }}" title="{{ $i }} Bintang">
                                     <i class="las la-star" style="cursor: pointer;"></i>
                                 </label>
                             @endfor
                         </div>
                         {{-- Tampilkan error validasi di bawah rating --}}
                         @error('rating')
                             <small class="text-danger d-block">{{ $message }}</small>
                         @enderror
                     </div>

                     <div class="form-group mt-4">
                         <label for="modal_komentar">Komentar (Opsional):</label>
                         <textarea name="komentar" id="modal_komentar" class="form-control" rows="3"
                             placeholder="Berikan masukan atau komentar Anda...">{{ old('komentar') }}</textarea> {{-- Gunakan old('komentar') --}}
                         @error('komentar')
                             <small class="text-danger d-block">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                 <div class="modal-footer bg-light">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-warning" id="penilaianSubmitButton">Kirim
                         Penilaian</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

@push('scripts')
    {{-- Script untuk Fungsionalitas Bintang (Rating) & Dinamisasi Modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const penilaianModal = document.getElementById('penilaianModal');
            const penilaianForm = document.getElementById('penilaianForm');

            // Fungsi untuk mengatur rating bintang di modal
            function setRatingStars(ratingValue) {
                // Konversi nilai ke integer
                const rating = parseInt(ratingValue);

                // Reset semua bintang
                for (let i = 1; i <= 5; i++) {
                    const radio = document.getElementById('star' + i);
                    if (radio) {
                        radio.checked = false;
                    }
                }
                // Centang rating yang sesuai
                if (rating > 0 && rating <= 5) {
                    const selectedRadio = document.getElementById('star' + rating);
                    if (selectedRadio) {
                        selectedRadio.checked = true;
                    }
                }
            }


            // 1. Logika untuk Modal Penilaian Dinamis (Tambah/Edit)
            if (penilaianModal) {
                penilaianModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget; // Tombol yang memicu modal

                    // Ambil data dari data-* attributes tombol
                    const pengaduanId = button.getAttribute('data-pengaduan-id');
                    const currentRating = button.getAttribute('data-rating');
                    const currentKomentar = button.getAttribute('data-komentar');
                    const actionUrl = button.getAttribute('data-action');
                    const method = button.getAttribute('data-method');
                    const modalTitle = button.getAttribute('data-modal-title');
                    const judulPengaduan = button.getAttribute('data-judul-pengaduan');
                    const nomorTiket = button.getAttribute('data-nomor-tiket');

                    // Update Judul & Deskripsi Modal
                    document.getElementById('penilaianModalTitle').textContent = modalTitle;
                    document.getElementById('penilaianModalDesc').innerHTML = (method === 'PUT' ?
                            'Perbarui penilaian Anda untuk pengaduan ' :
                            'Bagaimana Anda menilai penanganan pengaduan ') +
                        `<strong>${judulPengaduan.substring(0, 40) + (judulPengaduan.length > 40 ? '...' : '')}</strong> (Tiket: ${nomorTiket})?`;

                    // Update Action Form
                    penilaianForm.setAttribute('action', actionUrl);

                    // Update Input Fields DENGAN DATA DARI TOMBOL
                    document.getElementById('modal_pengaduan_id').value = pengaduanId;
                    document.getElementById('modal_komentar').value = currentKomentar || ''; // Isi dengan komentar yang ada atau string kosong
                    document.getElementById('penilaianSubmitButton').textContent = method === 'PUT' ?
                        'Simpan Perubahan' : 'Kirim Penilaian';

                    // Atur Bintang
                    setRatingStars(currentRating); // Diatur oleh JS jika buka dari tombol

                    // --- LOGIKA METHOD SPOOFING (POST vs PUT) ---
                    let methodInput = penilaianForm.querySelector('input[name="_method"]');

                    if (method === 'PUT') {
                        if (!methodInput) {
                            methodInput = document.createElement('input');
                            methodInput.setAttribute('type', 'hidden');
                            methodInput.setAttribute('name', '_method');
                            penilaianForm.prepend(methodInput); // Tambahkan di awal form
                        }
                        methodInput.value = 'PUT';
                    } else if (method === 'POST') {
                        // Jika method POST (store), pastikan hidden field PUT dihapus jika ada
                        if (methodInput) {
                            methodInput.remove();
                        }
                    }
                });
            }


            // 2. Logika untuk Modal Detail Pengaduan Dinamis
            document.querySelectorAll('.detail-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // Cek apakah data-p ada dan tidak null/undefined
                    const dataP = this.getAttribute('data-p');
                    if (dataP) {
                         try {
                            const pengaduanData = JSON.parse(dataP);
                            renderDetailModal(pengaduanData);
                        } catch (e) {
                            console.error("Gagal mem-parsing data-p:", e);
                        }
                    } else {
                        console.warn("Tombol detail tidak memiliki atribut data-p.");
                    }
                });
            });

            function renderDetailModal(p) {
                const modalTitle = document.getElementById('detailModalTitle');
                const modalBody = document.getElementById('detailModalBody');

                if (!modalTitle || !modalBody) return; // Keluar jika modal tidak ada

                modalTitle.innerHTML =
                    `<i class="fas fa-info-circle mr-2"></i>Detail Pengaduan (${p.nomor_tiket ?? 'N/A'})`;

                // Logika untuk menampilkan rating bintang
                let penilaianSection = `<div class="alert alert-warning py-2 border-0 mb-4" role="alert">
                                     <i class="fas fa-exclamation-triangle mr-1"></i> Pengaduan ini <strong>belum dinilai</strong>.
                                 </div>`;

                if (p.penilaian && p.penilaian.rating) {
                    let starHtml = '';
                    // Loop untuk menampilkan 5 bintang
                    for (let i = 1; i <= 5; i++) {
                        starHtml +=
                            `<i class="las la-star" style="color: ${i <= p.penilaian.rating ? '#ffc107' : '#ccc'};"></i>`;
                    }
                    // Perbaiki logika loop bintang yang lama (dihapus dan diganti di atas)

                    penilaianSection = `
                        <ul class="list-group list-group-flush mb-4 shadow-sm rounded">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong class="text-muted">Rating Diberikan</strong>
                                <span>
                                    ${starHtml}
                                    <span class="font-weight-bold ml-2 text-primary">${p.penilaian.rating} / 5</span>
                                </span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-muted d-block mb-1">Komentar:</strong>
                                <div class="p-2 bg-light border rounded">
                                    ${p.penilaian.komentar || '<em class="text-secondary">Tidak ada komentar.</em>'}
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-light small">
                                <strong class="text-muted">Dinilai pada</strong>
                                <span>${new Date(p.penilaian.created_at).toLocaleString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' })} WIB</span>
                            </li>
                        </ul>`;
                }

                // Render detail content
                let html = `
                    <h6 class="font-weight-bold text-info border-bottom pb-2 mb-3"><i class="fas fa-user-tag mr-2"></i>Data Pelapor & Status</h6>
                    <ul class="list-group list-group-flush mb-4 shadow-sm rounded">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong class="text-muted">Nomor Tiket</strong>
                            <span class="font-weight-bold text-dark">${p.nomor_tiket ?? 'N/A'}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong class="text-muted">Pelapor (Nama Akun)</strong>
                            <span>${p.pelapor}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong class="text-muted">Kategori</strong>
                            <span class="badge badge-info">${p.nama}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong class="text-muted">Status Pengaduan</strong>
                            <span class="badge ${p.statusClass} px-3 py-2 text-uppercase">${p.status}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong class="text-muted">Waktu Selesai</strong>
                            <span>${p.tgl_format_full} WIB</span>
                        </li>
                    </ul>

                    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-align-left mr-2"></i>Deskripsi Pengaduan & Lokasi</h6>
                    <ul class="list-group list-group-flush mb-4 shadow-sm rounded">
                        <li class="list-group-item">
                            <strong class="text-muted d-block mb-1">Judul:</strong>
                            <span class="font-weight-bold">${p.judul}</span>
                        </li>
                        <li class="list-group-item">
                            <strong class="text-muted d-block mb-1">Deskripsi Lengkap:</strong>
                            <div class="p-2 bg-light border rounded text-justify">
                                ${p.deskripsi}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <strong class="text-muted">Lokasi Kejadian</strong>
                            <span class="text-right">${p.lokasi_text} <br><small>(RT: ${p.rt} / RW: ${p.rw})</small></span>
                        </li>
                    </ul>


                    <h6 class="font-weight-bold text-success border-bottom pb-2 mb-3"><i class="las la-star-half-alt mr-2"></i>Hasil Penilaian Layanan</h6>
                    ${penilaianSection}
                    `;

                // TABEL LAMPIRAN
                html += `
                    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-paperclip mr-2"></i>Lampiran Bukti</h6>
                    ${p.media && p.media.length > 0 ? `
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm table-hover mb-0">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th style="width: 5%" class="text-center">No</th>
                                                            <th>Nama File</th>
                                                            <th style="width: 20%">Tipe</th>
                                                            <th style="width: 15%" class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        ${p.media.map((m, idx) => {
                                                            let extension = m.mime_type ? m.mime_type.split('/').pop() : m.name.split('.').pop();
                                                            let type = extension.toLowerCase();
                                                            let icon = 'fas fa-file-alt';
                                                            let color = 'text-secondary';

                                                            if (type.includes('image') || ['jpg', 'jpeg', 'png', 'gif'].includes(type)) {
                                                                icon = 'fas fa-file-image';
                                                                color = 'text-success'; // Ubah ke warna yang lebih sesuai untuk gambar
                                                            } else if (type.includes('pdf')) {
                                                                icon = 'fas fa-file-pdf';
                                                                color = 'text-danger';
                                                            } else if (type.includes('word') || ['doc', 'docx'].includes(type)) {
                                                                icon = 'fas fa-file-word';
                                                                color = 'text-primary';
                                                            } else if (type.includes('excel') || ['xls', 'xlsx'].includes(type)) {
                                                                icon = 'fas fa-file-excel';
                                                                color = 'text-success'; // Ubah ke warna yang sesuai untuk excel
                                                            } else if (type.includes('video') || ['mp4', 'mov', 'avi'].includes(type)) {
                                                                icon = 'fas fa-file-video';
                                                                color = 'text-info';
                                                            }

                                                            return `
                                                                <tr>
                                                                    <td class="text-center align-middle">${idx + 1}</td>
                                                                    <td class="align-middle d-flex align-items-center">
                                                                        <i class="${icon} ${color} mr-2"></i>
                                                                        <a href="${m.url}" target="_blank" class="text-dark font-weight-bold" title="Klik untuk Lihat/Download: ${m.name}">
                                                                            ${m.name}
                                                                        </a>
                                                                    </td>
                                                                    <td class="align-middle small text-muted">${extension.toUpperCase()}</td>
                                                                    <td class="text-center align-middle">
                                                                        <a href="${m.url}" target="_blank" class="btn btn-sm btn-info shadow-sm" title="Lihat/Download">
                                                                            <i class="fas fa-eye"></i> Lihat
                                                                        </a>
                                                                    </td>
                                                                </tr>`;
                                                        }).join('')
                                                }
                                            </tbody>
                                        </table>
                                    </div>` :
                        `<div class="alert alert-secondary py-2 border-0" role="alert">
                                     <i class="fas fa-info-circle mr-1"></i> Tidak ada lampiran foto/dokumen.
                                 </div>`
                    }
                    `;

                modalBody.innerHTML = html;
            }


            // 3. Logika untuk Menampilkan Modal Error/Validasi Saat Gagal
            @if ($errors->any())
                // Ambil nilai pengaduan_id dari old input/flash session
                const errorPengaduanId = "{{ old('pengaduan_id') }}";

                if (errorPengaduanId) {
                    // Perbaikan: Hapus spasi di selector class dan id
                    const errorButton = document.querySelector(`.penilaian-btn[data-pengaduan-id="${errorPengaduanId}"]`);

                    if (errorButton) {
                        // Isi data dari tombol ke modal (seperti yang dilakukan event listener show.bs.modal)
                        const currentRating = "{{ old('rating') ?? '' }}"; // Ambil rating dari old input
                        const oldKomentar = "{{ old('komentar') ?? '' }}";

                        // Set nilai pada form modal dengan data lama
                        document.getElementById('modal_pengaduan_id').value = errorPengaduanId;
                        document.getElementById('modal_komentar').value = oldKomentar;
                        setRatingStars(currentRating); // Atur bintang berdasarkan old rating

                        // Set Judul, Action, dan Method berdasarkan data-attribute dari tombol
                        const actionUrl = errorButton.getAttribute('data-action');
                        const method = errorButton.getAttribute('data-method');
                        const modalTitle = errorButton.getAttribute('data-modal-title');
                        const judulPengaduan = errorButton.getAttribute('data-judul-pengaduan');
                        const nomorTiket = errorButton.getAttribute('data-nomor-tiket');

                        document.getElementById('penilaianModalTitle').textContent = modalTitle;
                        document.getElementById('penilaianModalDesc').innerHTML = (method === 'PUT' ?
                                'Perbarui penilaian Anda untuk pengaduan ' :
                                'Bagaimana Anda menilai penanganan pengaduan ') +
                            `<strong>${judulPengaduan.substring(0, 40) + (judulPengaduan.length > 40 ? '...' : '')}</strong> (Tiket: ${nomorTiket})?`;
                        penilaianForm.setAttribute('action', actionUrl);
                        document.getElementById('penilaianSubmitButton').textContent = method === 'PUT' ?
                            'Simpan Perubahan' : 'Kirim Penilaian';

                        // Atur hidden field _method
                        let methodInput = penilaianForm.querySelector('input[name="_method"]');
                        if (method === 'PUT') {
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.setAttribute('type', 'hidden');
                                methodInput.setAttribute('name', '_method');
                                penilaianForm.prepend(methodInput);
                            }
                            methodInput.value = 'PUT';
                        } else if (method === 'POST') {
                            if (methodInput) {
                                methodInput.remove();
                            }
                        }

                        // Tampilkan modal (asumsi Bootstrap 4/5 dengan jQuery)
                        // Pastikan jQuery/Bootstrap JS sudah dimuat sebelum kode ini
                        $('#penilaianModal').modal('show');
                    }
                }
            @endif
        });
    </script>
@endpush
