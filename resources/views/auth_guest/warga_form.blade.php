@extends('layouts_guest.auth')

@section('konten')
        <div class="container h-100">
            <div class="row justify-content-center align-items-center height-self-center">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-4 text-center">{{ $title }}</h4>

                            {{-- Ganti: route tanpa $warga->id --}}
                            <form action="{{ route('guest.warga.update') }}" method="POST">
    @csrf
    @method('PUT')

                                {{-- No KTP --}}
                                <div class="mb-3">
                                    <label>No. KTP</label>
                                    <input type="text" name="no_ktp" class="form-control" inputmode="numeric" maxlength="16"
                                        minlength="16" pattern="[0-9]{16}" title="No. KTP harus 16 digit angka" required
                                        placeholder="Masukkan 16 digit angka KTP"
                                        value="{{ old('no_ktp', $warga->no_ktp ?? '') }}">
                                    <small class="text-muted">Biasanya terdiri dari 16 digit angka.</small>
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div class="mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                {{-- Agama --}}
                                <div class="mb-3">
                                    <label>Agama</label>
                                    <select name="agama" class="form-control" required>
                                        <option value="">-- Pilih Agama --</option>
                                        @foreach (['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                            <option value="{{ $agama }}" {{ old('agama', $warga->agama ?? '') == $agama ? 'selected' : '' }}>
                                                {{ $agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Pekerjaan --}}
                                <div class="mb-3">
                                    <label>Pekerjaan</label>
                                    <input list="daftarPekerjaan" type="text" name="pekerjaan" class="form-control" required
                                        placeholder="Masukkan atau pilih pekerjaan"
                                        value="{{ old('pekerjaan', $warga->pekerjaan ?? '') }}">
                                    <datalist id="daftarPekerjaan">
                                        <option value="Pelajar">
                                        <option value="Mahasiswa">
                                        <option value="PNS">
                                        <option value="TNI">
                                        <option value="Polri">
                                        <option value="Karyawan Swasta">
                                        <option value="Wiraswasta">
                                        <option value="Petani">
                                        <option value="Nelayan">
                                        <option value="Buruh">
                                        <option value="Ibu Rumah Tangga">
                                        <option value="Lainnya">
                                    </datalist>
                                    <small class="text-muted">Kamu juga bisa mengetik pekerjaan lain yang belum ada di daftar.</small>
                                </div>

                                {{-- Nomor Telepon --}}
                                <div class="mb-3">
                                    <label>No. Telepon</label>
                                    <input type="text" name="telp" class="form-control" inputmode="numeric" maxlength="13"
                                        minlength="10" pattern="08[0-9]{8,11}"
                                        title="Gunakan format nomor Indonesia yang dimulai dengan 08, contoh: 081234567890"
                                        placeholder="Contoh: 081234567890"
                                        value="{{ old('telp', $warga->telp ?? '') }}" required>
                                    <small class="text-muted">Nomor harus dimulai dengan 08 dan terdiri dari 10–13 digit (contoh: 081234567890).</small>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- JS Validasi tambahan --}}
        <script>
            document.querySelectorAll('input[inputmode="numeric"]').forEach(function (input) {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });

            document.querySelector('form').addEventListener('submit', function (e) {
                const telp = document.querySelector('input[name="telp"]').value;
                const regex = /^08[0-9]{8,11}$/;
                if (!regex.test(telp)) {
                    e.preventDefault();
                    alert('Nomor telepon harus diawali 08 dan terdiri dari 10–13 digit, contoh: 081234567890');
                }
            });
        </script>
@endsection
