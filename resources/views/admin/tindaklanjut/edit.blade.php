@extends('layouts_admin.app')

@section('konten')
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4">
            {{-- Header --}}
            <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Tindak Lanjut
                </h3>
                <a href="javascript:history.back()" class="btn btn-light btn-sm shadow-sm">
                    <i class="bi bi-arrow-left-circle-fill me-1"></i> Kembali
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                {{-- Informasi Pengaduan --}}
                <h5 class="text-primary"><i class="bi bi-info-circle-fill me-2"></i> Informasi Pengaduan</h5>
                <table class="table table-borderless mb-4">
                    <tr>
                        <th>Judul</th>
                        <td>{{ $tindaklanjut->pengaduan->judul }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $tindaklanjut->pengaduan->kategori->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pelapor</th>
                        <td>{{ $tindaklanjut->pengaduan->warga->nama ?? 'Anonim' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $tindaklanjut->pengaduan->deskripsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td>
                            @if ($tindaklanjut->pengaduan->media)
                                <a href="{{ asset('storage/' . $tindaklanjut->pengaduan->media->file_url) }}" target="_blank"
                                   class="btn btn-sm btn-info">
                                    Lihat Lampiran
                                </a>
                            @else
                                <span class="text-muted">Tidak ada lampiran</span>
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- Form Edit --}}
                <h5 class="text-success mt-5"><i class="bi bi-pencil-square me-2"></i> Edit Tindak Lanjut</h5>
                <form action="{{ route('admin.tindaklanjut.update', $tindaklanjut->tindak_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="aksi" class="form-label">Aksi <span class="text-danger">*</span></label>
                        <select name="aksi" id="aksi" class="form-control" required>
                            <option value="" disabled>-- Pilih Aksi --</option>
                            <option value="Diterima" {{ $tindaklanjut->aksi == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Sedang Diproses" {{ $tindaklanjut->aksi == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="Ditugaskan Petugas" {{ $tindaklanjut->aksi == 'Ditugaskan Petugas' ? 'selected' : '' }}>Ditugaskan Petugas</option>
                            <option value="Selesai" {{ $tindaklanjut->aksi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="petugas" class="form-label">Petugas</label>
                        <input type="text" name="petugas" id="petugas" class="form-control"
                               value="{{ old('petugas', $tindaklanjut->petugas) }}">
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $tindaklanjut->catatan) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
