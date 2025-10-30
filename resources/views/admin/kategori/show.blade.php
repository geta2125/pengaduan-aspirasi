@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-block card-stretch card-height rounded">
                <div class="card-header d-flex justify-content-between bg-primary text-white">
                    <div class="iq-header-title">
                        <h4 class="card-title mb-0">Detail Kategori Pengaduan</h4>
                    </div>
                    <div class="invoice-btn">
                        <a href="{{ route('admin.kategori-pengaduan.index') }}" class="btn btn-light">
                            <i class="las la-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-12 text-center">
                            <img src="{{ asset('template/assets/images/logo.png') }}" class="logo-invoice img-fluid mb-3"
                                alt="Logo">

                            <h5 class="mb-3 text-primary">Informasi Kategori Pengaduan</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th style="width: 30%;">Nama</th>
                                            <td>: {{ $kategori->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>SLA Hari</th>
                                            <td>: {{ $kategori->sla_hari }}</td>
                                        </tr>
                                        <tr>
                                            <th>Prioritas</th>
                                            <td>
                                                : <span class="badge
                                                    @if ($kategori->prioritas == 'Tinggi') bg-danger
                                                    @elseif($kategori->prioritas == 'Sedang') bg-warning
                                                    @else bg-success @endif">
                                                    {{ $kategori->prioritas }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <b class="text-danger">Catatan:</b>
                                <p class="mb-0">
                                    Pastikan data kategori ini sesuai dengan tingkat prioritas dan SLA yang telah
                                    ditentukan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col text-center">
                            <a href="{{ route('admin.kategori-pengaduan.edit', $kategori->id) }}" class="btn btn-primary">
                                <i class="las la-edit"></i> Edit Kategori
                            </a>
                            <a href="{{ route('admin.kategori-pengaduan.destroy', $kategori->id) }}"
                                class="btn btn-danger delete-btn" data-id="{{ $kategori->id }}">
                                <i class="las la-trash"></i> Hapus
                            </a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection