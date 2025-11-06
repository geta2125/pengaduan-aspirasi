@extends('layouts_admin.app')

@section('konten')
<div class="card">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Detail Pengaduan</h5>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item"><strong>Judul:</strong> {{ $pengaduan->judul }}</li>
            <li class="list-group-item"><strong>Pelapor:</strong> {{ $pengaduan->warga->nama ?? 'Anonim' }}</li>
            <li class="list-group-item"><strong>Kategori:</strong> {{ $pengaduan->kategori->nama ?? '-' }}</li>
            <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($pengaduan->status) }}</li>
            <li class="list-group-item"><strong>Lokasi:</strong> {{ $pengaduan->lokasi_text ?? '-' }}</li>
            <li class="list-group-item"><strong>Deskripsi:</strong> {{ $pengaduan->deskripsi }}</li>
        </ul>

        @if ($pengaduan->media)
            <h6 class="mt-3">Lampiran:</h6>
            <a href="{{ asset('storage/' . $pengaduan->media->file_url) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="ri-file-line me-1"></i> Lihat Lampiran
            </a>
        @endif

        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary mt-4">Kembali</a>
    </div>
</div>
@endsection
