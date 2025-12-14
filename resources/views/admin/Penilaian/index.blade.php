@extends('layouts_admin.app')

@section('konten')
    <style>
        .rating-stars {
            direction: rtl;
            unicode-bidi: bidi-override;
            display: inline-block;
        }

        .rating-stars>input {
            display: none;
        }

        .rating-stars>label {
            text-shadow: 0 0 3px #aaa;
            color: #ccc;
            transition: color 0.2s, text-shadow 0.2s;
            float: right;
            cursor: pointer;
        }

        .rating-stars:not(:checked)>label:hover,
        .rating-stars:not(:checked)>label:hover~label {
            color: #ffc107;
        }

        .rating-stars>input:checked~label {
            color: #ffc107;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <h4 class="mb-3">⭐ {{ $title }}</h4>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    {{-- FILTER --}}
                    <form method="GET" action="{{ route('penilaian.index') }}" class="mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-7 col-lg-9 mb-3 mb-md-0">
                                <label class="form-label">Cari Pengaduan (Judul/Pelapor)</label>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Ketik judul atau nama pelapor..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-5 col-lg-3">
                                <button class="btn btn-secondary mr-2"><i class="las la-filter"></i> Filter</button>
                                <a href="{{ route('penilaian.index') }}" class="btn btn-outline-secondary">
                                    <i class="las la-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- TABEL --}}
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
                                    <th class="text-center">Tindak Lanjut</th> {{-- BARU --}}
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($pengaduan as $index => $p)
                                    <tr>
                                        <td>{{ $pengaduan->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $p->judul }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($p->deskripsi, 50) }}</small>
                                        </td>
                                        <td>{{ $p->pelapor }}<br>
                                            <small class="text-muted">{{ $p->nama }}</small>
                                        </td>
                                        <td class="text-center">
                                            {{ $p->tgl_format_tabel }}<br>
                                            <small class="text-muted">{{ $p->jam_format }} WIB</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $p->statusClass }}">{{ ucfirst($p->status) }}</span>
                                        </td>

                                        {{-- PENILAIAN --}}
                                        <td class="text-center">
                                            @if ($p->penilaian)
                                                <span class="badge badge-success"><i class="las la-check-circle"></i> Sudah
                                                    Dinilai</span><br>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="las la-star"
                                                        style="color:{{ $i <= $p->penilaian->rating ? '#ffc107' : '#ccc' }};"></i>
                                                @endfor
                                            @else
                                                <span class="badge badge-secondary">Belum Dinilai</span>
                                            @endif
                                        </td>

                                        {{-- TINDAK LANJUT --}}
                                        <td class="text-center">
                                            @if ($p->jumlah_tindak_lanjut > 0)
                                                <span class="badge badge-info">
                                                    {{ $p->jumlah_tindak_lanjut }} catatan
                                                </span><br>
                                                <small class="text-muted">"{{ $p->last_catatan_snippet }}"</small>
                                            @else
                                                <span class="badge badge-secondary">Belum Ada</span>
                                            @endif
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center" style="gap:6px;">

                                                {{-- DETAIL --}}
                                                <button class="btn btn-sm btn-info detail-btn" data-toggle="modal"
                                                    data-target="#detailModal" data-p='@json($p)'>
                                                    <i class="las la-eye"></i> Detail
                                                </button>

                                                {{-- EDIT / HAPUS --}}
                                                @if ($p->penilaian)
                                                    <button class="btn btn-sm btn-primary edit-nilai-btn"
                                                        data-toggle="modal" data-target="#penilaianModal"
                                                        data-penilaian-id="{{ $p->penilaian->penilaian_id }}"
                                                        data-rating="{{ $p->penilaian->rating }}"
                                                        data-komentar="{{ $p->penilaian->komentar }}">
                                                        <i class="las la-edit"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-danger delete-nilai-btn"
                                                        data-toggle="modal" data-target="#confirmDeleteModal"
                                                        data-penilaian-id="{{ $p->penilaian->penilaian_id }}"
                                                        data-nomor-tiket="{{ $p->nomor_tiket }}">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                @else
                                                    {{-- BERi NILAI --}}
                                                    <button class="btn btn-sm btn-warning beri-nilai-btn"
                                                        data-toggle="modal" data-target="#penilaianModal"
                                                        data-pengaduan-id="{{ $p->pengaduan_id }}">
                                                        <i class="las la-star"></i> Nilai
                                                    </button>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="las la-folder-open" style="font-size:2rem;"></i><br>
                                            Tidak ada data.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    {{ $pengaduan->links('pagination::custom') }}

                </div>
            </div>
        </div>
    </div>
    {{-- MODAL PENILAIAN --}}
    <div class="modal fade" id="penilaianModal">
        <div class="modal-dialog">
            <div class="modal-content shadow">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="penilaianModalTitle">
                        <i class="las la-star mr-2"></i> Penilaian
                    </h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <form id="penilaianForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="_method_input" value="POST">
                    <input type="hidden" name="pengaduan_id" id="pengaduan_id_create" value="{{ old('pengaduan_id') }}">
                    <input type="hidden" name="penilaian_id" id="penilaian_id_update"
                        value="{{ old('penilaian_id', 0) }}">

                    <div class="modal-body">

                        <div class="form-group text-center">
                            <label class="font-weight-bold mb-3">Seberapa puas Anda?</label>
                            <div class="rating-stars">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="rating-{{ $i }}" name="rating"
                                        value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <label for="rating-{{ $i }}" class="la la-star"></label>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Komentar (opsional)</label>
                            <textarea class="form-control" name="komentar" id="komentar" rows="3">{{ old('komentar') }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-warning" id="submitPenilaianBtn">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div class="modal fade" id="confirmDeleteModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content shadow">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')

                    <div class="modal-body text-center">
                        <i class="las la-exclamation-circle text-danger" style="font-size:3rem;"></i>
                        <p>Yakin ingin menghapus penilaian tiket:</p>
                        <strong id="deleteTiketInfo"></strong>?
                        <input type="hidden" id="delete_penilaian_id">
                    </div>

                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="detailModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="detailModalTitle">Detail Pengaduan</h5>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" id="detailModalBody"></div>

                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const baseUrl = "{{ url('admin/penilaian') }}";
            const form = document.getElementById("penilaianForm");
            const methodInput = document.getElementById("_method_input");
            const pengaduanIdCreate = document.getElementById("pengaduan_id_create");
            const penilaianIdUpdate = document.getElementById("penilaian_id_update");
            const komentarInput = document.getElementById("komentar");
            const submitBtn = document.getElementById("submitPenilaianBtn");
            const modalTitle = document.getElementById("penilaianModalTitle");

            /* =============================
               CREATE (Beri Nilai)
            ============================== */
            document.querySelectorAll('.beri-nilai-btn').forEach(btn => {
                btn.addEventListener('click', function() {

                    form.action = "{{ route('penilaian.store') }}";
                    methodInput.value = "POST";

                    modalTitle.innerHTML = "<i class='las la-star mr-2'></i>Beri Penilaian";
                    submitBtn.textContent = "Simpan";

                    pengaduanIdCreate.value = this.dataset.pengaduanId;
                    penilaianIdUpdate.value = 0;

                    document.querySelectorAll('input[name=rating]').forEach(i => i.checked = false);
                    komentarInput.value = "";

                });
            });

            /* =============================
               UPDATE (Edit Nilai)
            ============================== */
            document.querySelectorAll('.edit-nilai-btn').forEach(btn => {
                btn.addEventListener('click', function() {

                    form.action = `${baseUrl}/${this.dataset.penilaianId}`;
                    methodInput.value = "PUT";

                    modalTitle.innerHTML = "<i class='las la-edit mr-2'></i>Edit Penilaian";
                    submitBtn.textContent = "Update";

                    pengaduanIdCreate.value = 0;
                    penilaianIdUpdate.value = this.dataset.penilaianId;

                    document.querySelectorAll("input[name=rating]").forEach(r => {
                        r.checked = (r.value == this.dataset.rating);
                    });

                    komentarInput.value = this.dataset.komentar || "";
                });
            });

            /* =============================
               DELETE
            ============================== */
            document.querySelectorAll(".delete-nilai-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    const id = this.dataset.penilaianId;
                    document.getElementById("deleteTiketInfo").textContent = this.dataset
                        .nomorTiket;
                    document.getElementById("delete_penilaian_id").value = id;

                    const deleteForm = document.getElementById("deleteForm");
                    deleteForm.action = `${baseUrl}/${id}`;
                });
            });

            /* =============================
               MODAL ERROR REOPEN
            ============================== */
            @if ($errors->any())
                $('#penilaianModal').modal('show');
            @endif

            /* =============================
               DETAIL MODAL
            ============================== */
            document.querySelectorAll('.detail-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const p = JSON.parse(this.dataset.p);

                    let html = "";

                    /* ============================
                       1. DATA PENGADUAN
                    ============================= */
                    html += `
            <h5 class="font-weight-bold mb-2 text-info">Data Pengaduan</h5>
            <ul class="list-group mb-4">
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Nomor Tiket</strong><span>${p.nomor_tiket}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Pelapor</strong><span>${p.pelapor}</span>
                </li>
                <li class="list-group-item">
                    <strong>Judul:</strong><br>${p.judul}
                </li>
                <li class="list-group-item">
                    <strong>Deskripsi:</strong>
                    <div class="p-2 mt-1 bg-light border rounded">${p.deskripsi}</div>
                </li>
            </ul>
        `;

                    /* ============================
                       2. LAMPIRAN PENGADUAN
                    ============================= */
                    html += `
            <h5 class="font-weight-bold mb-2 text-primary">Lampiran Pengaduan</h5>
        `;

                    if (!p.media || p.media.length === 0) {
                        html += `
                <div class="alert alert-secondary mb-4">
                    Tidak ada lampiran pada pengaduan.
                </div>
            `;
                    } else {
                        html += `
                <table class="table table-bordered table-sm mb-4">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 8%">No</th>
                            <th>Nama File</th>
                            <th style="width: 15%">Lihat</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
                        p.media.forEach((m, i) => {
                            html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${m.name}</td>
                        <td>
                            <a href="${m.url}" target="_blank" class="btn btn-info btn-sm">
                                Lihat
                            </a>
                        </td>
                    </tr>
                `;
                        });
                        html += `</tbody></table>`;
                    }

                    /* ============================
                       3. TINDAK LANJUT + LAMPIRAN TIAP CATATAN
                    ============================= */
                    html += `
            <h5 class="font-weight-bold mb-2 text-warning">Tindak Lanjut / Catatan</h5>
        `;

                    if (!p.tindak_lanjut || p.tindak_lanjut.length === 0) {
                        html += `
                <div class="alert alert-secondary mb-4">
                    Belum ada tindak lanjut.
                </div>
            `;
                    } else {
                        p.tindak_lanjut.forEach((tl, i) => {

                            const waktuTL = tl.created_at ?
                                new Date(tl.created_at).toLocaleString('id-ID', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                }) :
                                '-';

                            html += `
                    <div class="card mb-3">
                        <div class="card-header py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Catatan #${i + 1}</strong>
                                <span class="badge badge-info ml-2">${tl.petugas ?? '-'}</span>
                            </div>
                            <small class="text-muted">${waktuTL} WIB</small>
                        </div>
                        <div class="card-body py-2">
                            <p class="mb-2">
                                <strong>Isi Catatan:</strong>
                            </p>
                            <div class="p-2 bg-light border rounded mb-2">
                                ${tl.catatan ?? '-'}
                            </div>
                `;

                            // Lampiran untuk catatan ini
                            if (tl.media && tl.media.length > 0) {
                                html += `
                        <p class="mb-1"><strong>Lampiran Catatan Ini:</strong></p>
                        <table class="table table-bordered table-sm mb-2">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 8%">No</th>
                                    <th>Nama File</th>
                                    <th style="width: 15%">Lihat</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                                tl.media.forEach((m, j) => {
                                    html += `
                            <tr>
                                <td>${j + 1}</td>
                                <td>${m.name}</td>
                                <td>
                                    <a href="${m.url}" target="_blank" class="btn btn-info btn-sm">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        `;
                                });
                                html += `
                            </tbody>
                        </table>
                    `;
                            } else {
                                html += `
                        <p class="text-muted mb-0">
                            <em>Tidak ada lampiran untuk catatan ini.</em>
                        </p>
                    `;
                            }

                            html += `
                        </div>
                    </div>
                `;
                        });
                    }

                    /* ============================
                       4. PENILAIAN LAYANAN
                    ============================= */
                    html += `
            <h5 class="font-weight-bold mb-2 text-success">Penilaian Layanan</h5>
        `;

                    if (!p.penilaian) {
                        html += `
                <div class="alert alert-warning">
                    Belum dinilai.
                </div>
            `;
                    } else {
                        let stars = "";
                        for (let i = 1; i <= 5; i++) {
                            stars +=
                                `<i class="las la-star" style="color:${i <= p.penilaian.rating ? '#ffc107' : '#ccc'}"></i>`;
                        }
                        const waktuNilai = p.penilaian.created_at ?
                            new Date(p.penilaian.created_at).toLocaleString('id-ID') :
                            '-';

                        html += `
                <ul class="list-group mb-2">
                    <li class="list-group-item">
                        <strong>Rating:</strong> ${stars}
                    </li>
                    <li class="list-group-item">
                        <strong>Komentar:</strong>
                        <div class="p-2 bg-light border rounded">${p.penilaian.komentar ?? '-'}</div>
                    </li>
                    <li class="list-group-item">
                        <strong>Dinilai pada:</strong> ${waktuNilai}
                    </li>
                </ul>
            `;
                    }

                    document.getElementById("detailModalBody").innerHTML = html;
                });
            });

        });
    </script>
@endpush
