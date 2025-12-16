@extends('layouts_admin.app')

@section('konten')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header Card --}}
                <div class="card-header bg-primary text-white py-4">
                    <h4 class="mb-0 fw-semibold">
                        📜 Terms of Use
                    </h4>
                    <small class="opacity-75">
                        Ketentuan Penggunaan Sistem SiPAWA
                    </small>
                </div>

                {{-- Body Card --}}
                <div class="card-body p-4 p-lg-5">
                    <p class="mb-0 text-muted" style="line-height: 1.8;">
                        Dengan menggunakan <strong>SiPAWA (Sistem Pengaduan dan Aspirasi Warga)</strong>,
                        pengguna setuju untuk memanfaatkan sistem secara bertanggung jawab,
                        tidak menyalahgunakan fitur yang tersedia, serta mematuhi ketentuan
                        dan aturan yang berlaku demi terciptanya pelayanan publik yang
                        efektif dan transparan.
                    </p>
                </div>

                {{-- Footer Card --}}
                <div class="card-footer bg-light text-muted small text-end py-3">
                    Berlaku sejak {{ now()->year }}
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
