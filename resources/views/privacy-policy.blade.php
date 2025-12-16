@extends('layouts_admin.app')

@section('konten')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="card-header bg-primary text-white py-4">
                    <h4 class="mb-0 fw-semibold">
                        🔐 Privacy Policy
                    </h4>
                    <small class="opacity-75">
                        Kebijakan Privasi Sistem SiPAWA
                    </small>
                </div>

                {{-- Body --}}
                <div class="card-body p-4 p-lg-5">
                    <p class="text-muted mb-0" style="line-height: 1.8;">
                        <strong>SiPAWA (Sistem Pengaduan dan Aspirasi Warga)</strong>
                        menghargai dan melindungi privasi setiap pengguna.
                        Seluruh data yang dikumpulkan digunakan semata-mata untuk
                        keperluan pengelolaan pengaduan, pemrosesan aspirasi,
                        serta peningkatan kualitas layanan publik.
                        Data pengguna tidak akan disalahgunakan dan dikelola
                        sesuai prinsip keamanan serta kerahasiaan informasi.
                    </p>
                </div>

                {{-- Footer --}}
                <div class="card-footer bg-light text-muted small text-end py-3">
                    Berlaku sejak {{ now()->year }}
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
