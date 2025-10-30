@extends('layouts_admin.app')

@section('konten')
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4">
            {{-- Header --}}
            <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-megaphone-fill me-2"></i>
                    Detail Pengaduan
                </h3>
                <a href="javascript:history.back()" class="btn btn-outline-light btn-sm">
    <i class="bi bi-arrow-left-circle-fill me-1"></i> Kembali
</a>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                {{-- Data Pengaduan --}}
                <h5 class="text-primary"><i class="bi bi-info-circle-fill me-2"></i> Informasi Pengaduan</h5>
                <table class="table table-borderless mb-4">
                    <tr>
                        <th>Judul</th>
                        <td>{{ $pengaduan->judul }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $pengaduan->kategori->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $pengaduan->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $pengaduan->lokasi_text ?? '-' }} (RT/RW:
                            {{ $pengaduan->rt ?? '-' }}/{{ $pengaduan->rw ?? '-' }})
                        </td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td>
                            @if($pengaduan->media)
                                @php
    $fileExt = pathinfo($pengaduan->media->file_url, PATHINFO_EXTENSION);
    $fileUrl = asset('storage/' . $pengaduan->media->file_url);
                                @endphp

                                @if(in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $fileUrl }}" alt="Lampiran" class="img-thumbnail" style="max-height:150px;">
                                @elseif(strtolower($fileExt) == 'pdf')
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-info">Lihat PDF</a>
                                @else
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-secondary">Lihat Lampiran</a>
                                @endif
                            @else
                                <span class="text-muted">Tidak ada lampiran</span>
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- Tindak Lanjut --}}
                <h5 class="text-success mt-5"><i class="bi bi-pencil-square me-2"></i> Tindak Lanjut</h5>

                @if($pengaduan->tindak_lanjut && $pengaduan->tindak_lanjut->count())
    <h5>Riwayat Tindak Lanjut</h5>
    <ul class="list-group mb-3">
        @foreach($pengaduan->tindak_lanjut as $tl)
            <li class="list-group-item">
                <strong>Aksi:</strong> {{ $tl->aksi }} <br>
                <strong>Petugas:</strong> {{ $tl->petugas ?? '-' }} <br>
                <strong>Catatan:</strong> {{ $tl->catatan ?? '-' }} <br>
                <small class="text-muted">Tanggal: {{ $tl->created_at->format('d-m-Y H:i') }}</small>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-muted">Belum ada tindak lanjut untuk pengaduan ini.</p>
@endif


                {{-- Form Tindak Lanjut --}}
                <h5 class="text-primary mt-5"><i class="bi bi-plus-circle me-2"></i> Tambah Tindak Lanjut</h5>
                <form action="{{ route('admin.pengaduan.tindaklanjut.store', $pengaduan->pengaduan_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="aksi" class="form-label">Aksi <span class="text-danger">*</span></label>
                        <select name="aksi" id="aksi" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Aksi --</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Sedang Diproses">Sedang Diproses</option>
                            <option value="Ditugaskan Petugas">Ditugaskan Petugas</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Simpan Tindak Lanjut
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection