@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0 rounded-4">

                <div
                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center p-3 rounded-top-4">
                    <h4 class="mb-0">
                        <i class="la la-user-plus me-2"></i>
                        {{ isset($warga) ? 'Edit Data Warga' : 'Tambah Data Warga Baru' }}
                    </h4>
                    <a href="{{ route('warga.index') }}" class="btn btn-light btn-sm">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4 p-md-5">

                    <div class="mb-4">
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" id="progressBar" role="progressbar" style="width: 50%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2 small text-muted">
                            <span id="stepIndicator1" class="fw-bold text-primary">Data Akun</span>
                            <span id="stepIndicator2">Data Warga</span>
                        </div>
                    </div>
                    <form method="POST"
                        action="{{ isset($warga) ? route('warga.update', $warga->warga_id) : route('warga.store') }}"
                        id="wizardForm">

                        @csrf
                        @if (isset($warga))
                            @method('PUT')
                        @endif

                        <div class="step step-1">
                            <h5 class="mb-4 text-primary border-bottom pb-2">
                                <i class="la la-id-card me-2"></i>
                                1. Informasi Akun Pengguna
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        value="{{ old('nama', $warga->nama ?? '') }}" required
                                        placeholder="Masukkan Nama Lengkap">
                                    @error('nama')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="Nama Panggilan" class="form-label">Nama Panggilan <span
                                            class="text-danger">*</span></label>
                                    <input type="Nama Panggilan" name="Nama Panggilan" id="Nama Panggilan" class="form-control"
                                        value="{{ old('Nama_Panggilan', $warga->Nama_Panggilan ?? '') }}" required
                                        placeholder="Nama Panggilan">
                                    @error('Nama Panggilan')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" class="form-control"
                                    value="{{ old('email', $warga->user->email ?? '') }}" required
                                    placeholder="contoh@domain.com">
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            @if (!isset($warga))
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control"
                                                required placeholder="Masukkan Password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="password">
                                                <i class="la la-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control" required placeholder="Ulangi Password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="password_confirmation">
                                                <i class="la la-eye"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info small" role="alert">
                                    <i class="la la-info-circle me-1"></i>
                                    *Catatan:* Kosongkan kolom password jika tidak ingin menggantinya.
                                </div>

                                <div class="mb-3">
                                    <label for="password_edit" class="form-label">Password Baru (Opsional)</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password_edit" class="form-control"
                                            placeholder="Password Baru">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            data-target="password_edit">
                                            <i class="la la-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-btn">
                                    Lanjut ke Data Warga <i class="la la-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                        <div class="step step-2" style="display:none;">
                            <h5 class="mb-4 text-primary border-bottom pb-2">
                                <i class="la la-address-card me-2"></i>
                                2. Detail Data Pribadi Warga
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_ktp" class="form-label">No. KTP <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="no_ktp" id="no_ktp" class="form-control"
                                        maxlength="16" minlength="16" value="{{ old('no_ktp', $warga->no_ktp ?? '') }}"
                                        required placeholder="16 Digit Nomor KTP">
                                    @error('no_ktp')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telp" class="form-label">No. Telepon (WA) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="telp" id="telp" class="form-control"
                                        minlength="10" maxlength="13" value="{{ old('telp', $warga->telp ?? '') }}"
                                        required placeholder="Contoh: 081234567890">
                                    @error('telp')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                            class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="agama" class="form-label">Agama <span
                                            class="text-danger">*</span></label>
                                    <select name="agama" id="agama" class="form-control" required>
                                        <option value="">-- Pilih Agama --</option>
                                        @foreach (['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                            <option value="{{ $agama }}"
                                                {{ old('agama', $warga->agama ?? '') == $agama ? 'selected' : '' }}>
                                                {{ $agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('agama')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan <span
                                        class="text-danger">*</span></label>
                                <input list="daftarPekerjaan" type="text" name="pekerjaan" id="pekerjaan"
                                    class="form-control" value="{{ old('pekerjaan', $warga->pekerjaan ?? '') }}" required
                                    placeholder="Ketik atau Pilih Pekerjaan">
                                <datalist id="daftarPekerjaan">
                                    <option value="Pelajar/Mahasiswa">
                                    <option value="PNS">
                                    <option value="TNI/Polri">
                                    <option value="Karyawan Swasta">
                                    <option value="Wiraswasta">
                                    <option value="Petani/Nelayan">
                                    <option value="Ibu Rumah Tangga">
                                    <option value="Belum/Tidak Bekerja">
                                </datalist>
                                @error('pekerjaan')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <button type="button" class="btn btn-secondary prev-btn">
                                    <i class="la la-arrow-left me-2"></i> Sebelumnya
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="la la-save me-2"></i>
                                    {{ isset($warga) ? 'Update Data' : 'Simpan Data' }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('wizardForm');
            const step1 = document.querySelector('.step-1');
            const step2 = document.querySelector('.step-2');
            const nextBtn = document.querySelector('.next-btn');
            const prevBtn = document.querySelector('.prev-btn');
            const progressBar = document.getElementById('progressBar');
            const stepIndicator1 = document.getElementById('stepIndicator1');
            const stepIndicator2 = document.getElementById('stepIndicator2');

            // --- FUNGSI PERSISTENCE (LOCAL STORAGE) ---
            const storageKey = 'wargaFormData';

            // 1. Muat data dari Local Storage saat halaman dimuat
            function loadFormData() {
                // Hanya muat jika ini mode "Tambah Data" (karena mode Edit sudah diisi Blade)
                @if (!isset($warga))
                    const savedData = localStorage.getItem(storageKey);
                    if (savedData) {
                        const data = JSON.parse(savedData);
                        for (const key in data) {
                            const element = form.elements[key];
                            if (element) {
                                if (element.type === 'checkbox' || element.type === 'radio') {
                                    element.checked = element.value === data[key];
                                } else {
                                    element.value = data[key];
                                }
                            }
                        }
                        // Muat status step (jika disimpan)
                        const savedStep = localStorage.getItem('currentStep') || 'step-1';
                        if (savedStep === 'step-2') {
                            showStep(2);
                        } else {
                            showStep(1);
                        }
                    }
                @endif
            }

            // 2. Simpan data ke Local Storage saat ada perubahan input
            function saveFormData() {
                @if (!isset($warga))
                    const data = {};
                    const fields = form.querySelectorAll('input, select, textarea');
                    fields.forEach(field => {
                        // Jangan simpan password
                        if (field.name !== 'password' && field.name !== 'password_confirmation') {
                            data[field.name] = field.value;
                        }
                    });
                    localStorage.setItem(storageKey, JSON.stringify(data));
                @endif
            }

            // 3. Hapus data setelah berhasil submit
            form.addEventListener('submit', function() {
                localStorage.removeItem(storageKey);
                localStorage.removeItem('currentStep');
            });

            // 4. Attach event listener ke semua input untuk menyimpan data
            form.addEventListener('input', saveFormData);

            // --- FUNGSI WIZARD & VALIDASI ---
            function showStep(stepNumber) {
                if (stepNumber === 1) {
                    step2.style.display = 'none';
                    step1.style.display = 'block';
                    progressBar.style.width = '50%';
                    progressBar.setAttribute('aria-valuenow', '50');
                    stepIndicator2.classList.remove('fw-bold', 'text-primary');
                    stepIndicator1.classList.add('fw-bold', 'text-primary');
                    localStorage.setItem('currentStep', 'step-1');
                } else if (stepNumber === 2) {
                    step1.style.display = 'none';
                    step2.style.display = 'block';
                    progressBar.style.width = '100%';
                    progressBar.setAttribute('aria-valuenow', '100');
                    stepIndicator1.classList.remove('fw-bold', 'text-primary');
                    stepIndicator2.classList.add('fw-bold', 'text-primary');
                    localStorage.setItem('currentStep', 'step-2');
                }
            }


            // Fungsi untuk memvalidasi Step 1
            function validateStep1() {
                let isValid = true;
                const requiredInputs = step1.querySelectorAll('input[required], select[required]');

                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                // Khusus untuk buat baru, cek konfirmasi password
                @if (!isset($warga))
                    const password = document.getElementById('password');
                    const passwordConfirmation = document.getElementById('password_confirmation');
                    if (password.value !== passwordConfirmation.value) {
                        passwordConfirmation.classList.add('is-invalid');
                        isValid = false;
                        alert('Konfirmasi password tidak cocok!'); // Feedback
                    } else {
                        passwordConfirmation.classList.remove('is-invalid');
                    }
                @endif

                return isValid;
            }

            nextBtn.addEventListener('click', function() {
                if (validateStep1()) {
                    showStep(2);
                } else {
                    alert('Harap isi semua kolom wajib di "Data Akun" dengan benar.');
                }
            });

            prevBtn.addEventListener('click', function() {
                showStep(1);
            });


            // --- FUNGSI SHOW PASSWORD ---
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.classList.remove('la-eye');
                        icon.classList.add('la-eye-slash');
                    } else {
                        targetInput.type = 'password';
                        icon.classList.remove('la-eye-slash');
                        icon.classList.add('la-eye');
                    }
                });
            });


            // Inisialisasi: Muat data dan tampilkan step yang benar
            loadFormData();
        });
    </script>
@endpush
