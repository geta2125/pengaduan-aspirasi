@extends('layouts_admin.app')

@section('konten')
<div class="card">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">Edit Pengaduan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pengaduan.update', $pengaduan->pengaduan_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Judul Pengaduan</label>
                <input type="text" name="judul" class="form-control" value="{{ $pengaduan->judul }}" required>
            </div>

            <div class="form-group mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" {{ $pengaduan->kategori_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required>{{ $pengaduan->deskripsi }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="baru" {{ $pengaduan->status == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="proses" {{ $pengaduan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="ditindaklanjuti" {{ $pengaduan->status == 'ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                    <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Lampiran Baru (Opsional)</label>
                <input type="file" name="lampiran" class="form-control">
                @if ($pengaduan->media)
                    <p class="mt-2 text-muted">Lampiran sekarang: <a href="{{ asset('storage/' . $pengaduan->media->file_url) }}" target="_blank">Lihat File</a></p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i> Update</button>
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
