@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kategori-pengaduan.store') }}" method="POST" class="custom-form">
                        @csrf
                        <div class="row">
                            {{-- Nama Kategori --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Nama Kategori *</label>
                                <div class="position-relative">
                                    <input type="text" id="nama_kategori" name="nama" class="form-control pe-5"
                                        placeholder="Masukkan nama kategori..." maxlength="200" required>
                                    <small id="charCount"
                                        class="position-absolute end-0 top-50 translate-middle-y me-3 text-muted small">
                                        0/200
                                    </small>
                                </div>
                            </div>

                            {{-- SLA Hari --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">SLA Hari *</label>
                                <div class="input-group">
                                    <input type="number" name="sla_hari" class="form-control" placeholder="Contoh: 4"
                                        min="0" required>
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>

                            {{-- Prioritas --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Prioritas *</label>
                                <select name="prioritas" class="form-control" required>
                                    <option value="" disabled selected>Pilih Prioritas</option>
                                    <option value="Tinggi">Tinggi</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Rendah">Rendah</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kategori-pengaduan.index') }}" class="btn btn-secondary">⬅ Kembali</a>
                            <button type="submit" class="btn btn-primary">💾 Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const namaInput = document.getElementById('nama_kategori');
        const charCounter = document.getElementById('charCount');
        const maxLength = namaInput.getAttribute('maxlength');

        const updateCounter = () => {
            const currentLength = namaInput.value.length;
            charCounter.textContent = `${currentLength}/${maxLength}`;

            // warna berubah jika mendekati batas
            if (currentLength >= maxLength - 10) {
                charCounter.classList.add('text-danger');
            } else {
                charCounter.classList.remove('text-danger');
            }
        };

        namaInput.addEventListener('input', updateCounter);
        updateCounter(); // set awal
    });
</script>