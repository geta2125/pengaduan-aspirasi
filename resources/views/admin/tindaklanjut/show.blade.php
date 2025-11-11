@extends('layouts_admin.app')

@section('konten')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        {{-- Header --}}
        <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">
                <i class="bi bi-info-circle-fill me-2"></i>
                Detail Tindak Lanjut
            </h3>
            <a href="{{ route('admin.tindaklanjut.index') }}" class="btn btn-light btn-sm shadow-sm">
                <i class="bi bi-arrow-left-circle-fill me-1"></i> Kembali
            </a>
        </div>

        {{-- Body --}}
        <div class="card-body p-4">
            {{-- Informasi Pengaduan --}}
            <h5 class="text-primary"><i class="bi bi-megaphone-fill me-2"></i> Informasi Pengaduan</h5>
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
                    <th>Deskripsi</th>
                    <td>{{ $tindaklanjut->pengaduan->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $tindaklanjut->pengaduan->lokasi_text ?? '-' }} (RT/RW:
                        {{ $tindaklanjut->pengaduan->rt ?? '-' }}/{{ $tindaklanjut->pengaduan->rw ?? '-' }})
                    </td>
                </tr>
                <tr>
                    <th>Lampiran</th>
                    <td>
                        @if ($tindaklanjut->pengaduan->media)
                            <a href="{{ asset('storage/'. $tindaklanjut->pengaduan->media->file_url) }}" target="_blank" class="btn btn-sm btn-info">
                                Lihat Lampiran
                            </a>
                        @else
                            <span class="text-muted">Tidak ada lampiran</span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Detail Tindak Lanjut --}}
            <h5 class="text-success mt-5"><i class="bi bi-pencil-square me-2"></i> Detail Tindak Lanjut</h5>
            <table class="table table-borderless">
                <tr>
                    <th>Aksi</th>
                    <td>{{ $tindaklanjut->aksi }}</td>
                </tr>
                <tr>
                    <th>Petugas</th>
                    <td>{{ $tindaklanjut->petugas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $tindaklanjut->catatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $tindaklanjut->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
