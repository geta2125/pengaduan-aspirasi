@extends('layouts_guest.app')

@section('konten')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>{{ isset($pengaduan) ? 'Edit Pengaduan' : 'Ajukan Pengaduan' }}</h4>
        </div>
        <div class="card-body">
            <form
                action="{{ isset($pengaduan) ? route('guest.pengaduan.update', $pengaduan->pengaduan_id) : route('guest.pengaduan.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                @if(isset($pengaduan))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Pengaduan</label>
                    <input type="text" name="judul" id="judul" class="form-control"
                        value="{{ old('judul', $pengaduan->judul ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ (old('kategori_id', $pengaduan->kategori_id ?? '') == $k->id) ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control"
                        required>{{ old('deskripsi', $pengaduan->deskripsi ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="lokasi_text" class="form-label">Lokasi (Opsional)</label>
                    <input type="text" name="lokasi_text" id="lokasi_text" class="form-control"
                        value="{{ old('lokasi_text', $pengaduan->lokasi_text ?? '') }}">
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="rt" class="form-label">RT</label>
                        <input type="text" name="rt" id="rt" class="form-control"
                            value="{{ old('rt', $pengaduan->rt ?? '') }}">
                    </div>
                    <div class="col">
                        <label for="rw" class="form-label">RW</label>
                        <input type="text" name="rw" id="rw" class="form-control"
                            value="{{ old('rw', $pengaduan->rw ?? '') }}">
                    </div>
                </div>

                {{-- Lampiran --}}
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran</label>
                    <input type="file" name="lampiran" id="lampiran" class="form-control">
                </div>

                {{-- Tampilkan lampiran lama jika edit --}}
                @if(isset($pengaduan) && $pengaduan->media)
                    <div class="mb-3">
                        <label class="form-label">Lampiran Saat Ini:</label>
                        <br>
                        <a href="{{ asset('storage/' . $pengaduan->media->file_url) }}" target="_blank">
                            {{ basename($pengaduan->media->file_url) }}
                        </a>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">
                    {{ isset($pengaduan) ? 'Update Pengaduan' : 'Ajukan Pengaduan' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
