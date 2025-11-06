@extends('layouts_admin.app')

@section('konten')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah Pengaduan Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label>Judul Pengaduan</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label>Lokasi</label>
                <input type="text" name="lokasi_text" class="form-control">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>RT</label>
                    <input type="text" name="rt" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>RW</label>
                    <input type="text" name="rw" class="form-control">
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Lampiran (Opsional)<
