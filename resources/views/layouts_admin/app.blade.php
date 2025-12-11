<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SiPAWA | {{ $title }}</title>

    {{-- start css --}}
    @include('layouts_admin.css')
    {{-- end css --}}

    <style>
        /* CSS Reset Minimal untuk memastikan posisi akurat */

        .floating-whatsapp-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        .floating-whatsapp-btn img {
            width: 35px;
            height: 35px;
        }

        .floating-whatsapp-btn:hover {
            transform: scale(1.1);
            transition: 0.2s;
        }
</style>
<style>
    /* ------------------------------------------- */
    /* START: Gaya CSS untuk Loader Bouncing Dots (Full Screen, Centered) */
    /* ------------------------------------------- */

    /* 1. Pengaturan Kontainer Utama (Menutupi Seluruh Layar & Pemusatan) */
    #custom-loader {
        background-color: #f8f8f8;
        height: 100vh;
        width: 100%;
        /* Kunci 1: Memastikan kontainer menutupi seluruh layar */
        position: fixed;
        top: 0;
        left: 0;
        /* Tambahkan top: 0 dan left: 0 untuk memastikan dimulai dari sudut kiri atas */
        z-index: 1000;

        /* Kunci 2: Teknik Pemusatan Flexbox */
        display: flex;
        justify-content: center;
        /* Pemusatan Horizontal */
        align-items: center;
        /* Pemusatan Vertikal */

        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    /* 2. Pengaturan Wrapper Titik */
    #custom-loader-center {
        display: flex;
        gap: 15px;
        /* Jarak antara titik-titik */
        /* Pastikan wrapper ini tidak memiliki lebar tetap yang dapat mengganggu pemusatan */
    }

    /* 3. Pengaturan Setiap Titik */
    .dot {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out both;
    }

    /* 4. Penundaan dan Warna Animasi untuk Setiap Titik */
    #custom-loader-center .dot:nth-child(1) {
        background-color: #f39c12;
        /* Warna Warning */
        animation-delay: -0.32s;
    }

    #custom-loader-center .dot:nth-child(2) {
        background-color: #3498db;
        /* Warna Primary */
        animation-delay: -0.16s;
    }

    #custom-loader-center .dot:nth-child(3) {
        background-color: #f39c12;
        /* Warna Warning */
        animation-delay: 0s;
    }

    /* 5. Keyframes untuk Animasi Pantulan */
    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0);
        }

        40% {
            transform: scale(1.0);
        }
    }

    /* ------------------------------------------- */
    /* END: Gaya CSS untuk Loader Bouncing Dots */
    /* ------------------------------------------- */
</style>
</head>

<body class="">
    <!-- loader Start -->
    <!-- ID Diubah dari #loading menjadi #custom-loader -->
    <div id="custom-loader">
        <!-- ID Diubah dari #loading-center menjadi #custom-loader-center -->
        <div id="custom-loader-center">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
    <!-- loader END -->

    <!-- Wrapper Start -->
    <div class="wrapper">
        {{-- start sidebar --}}
        @include('layouts_admin.sidebar')
        {{-- end sidebar --}}
        {{-- start topbar --}}
        @include('layouts_admin.topbar')
        {{-- end topbar --}}

        <div class="modal fade" id="new-order" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="popup text-left">
                            <h4 class="mb-3">New Order</h4>
                            <div class="content create-workform bg-body">
                                <div class="pb-3">
                                    <label class="mb-2">Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Name or Email">
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                                        <div class="btn btn-primary mr-4" data-dismiss="modal">Cancel</div>
                                        <div class="btn btn-outline-primary" data-dismiss="modal">Create</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-page">
            <div class="container-fluid">
                @yield('konten')
            </div>
        </div>

        <!-- Floating WhatsApp Button -->
        <a href="https://wa.me/6285979229792?text=Halo%20Admin,%20saya%20ingin%20bertanya%20tentang%20Bina%20Desa"
            target="_blank" class="floating-whatsapp-btn">
            <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" alt="WhatsApp">
            </a>
    </div>
    <!-- Wrapper End -->

    {{-- start footer --}}
    @include('layouts_admin.footer')
    {{-- end footer --}}

    {{-- start js --}}
    @include('layouts_admin.js')
    {{-- end js --}}
    @stack('scripts')

    <!-- JavaScript untuk menyembunyikan Loader setelah halaman dimuat -->
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            // ID Diubah dari 'loading' menjadi 'custom-loader'
            const loader = document.getElementById('custom-loader');
            if (loader) {
                // Gunakan event 'load' untuk memastikan semua aset (gambar, css, js) telah selesai dimuat
                window.addEventListener('load', function () {
                    // Berikan sedikit jeda waktu (misalnya 100ms) untuk memastikan transisi visual
                    setTimeout(function () {
                        // 1. Atur opacity menjadi 0 (memulai transisi fade out)
                        loader.style.opacity = '0';

                        // 2. Setelah transisi selesai (500ms, sesuai transisi CSS), sembunyikan sepenuhnya elemen tersebut
                        setTimeout(() => {
                            loader.style.visibility = 'hidden';
                            loader.style.display = 'none';
                        }, 500);

                    }, 100); // Jeda kecil sebelum fade out dimulai
                });
            }
        });
    </script>
</body>

</html>
