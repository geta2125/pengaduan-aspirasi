@extends('layouts_admin.app')

@section('konten')
    <div class="container py-5">
        <h3 class="mb-4">{{ $title }}</h3>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('penilaian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pengaduan_id" value="{{ $pengaduan->pengaduan_id }}">

                    <div class="mb-3">
                        <label>Judul Pengaduan</label>
                        <input type="text" class="form-control" value="{{ $pengaduan->judul }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Rating (1–5)</label>
                        <select name="rating" class="form-control @error('rating') is-invalid @enderror" required>
                            <option value="">-- Pilih Rating --</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}
                                    {{ str_repeat('⭐', $i) }}</option>
                            @endfor
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Komentar</label>
                        <textarea name="komentar" class="form-control" rows="3">{{ old('komentar') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
                    <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
