<link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}" />
<link rel="stylesheet" href="{{ asset('template/assets/css/backend-plugin.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/css/backend.css?v=1.0.0') }}">
<link rel="stylesheet" href="{{ asset('template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('template/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/vendor/remixicon/fonts/remixicon.css') }}">
<style>
    .bg-primary-light {
        background-color: rgba(0, 123, 255, 0.15);
    }

    .bg-pink-light {
        background-color: #ffd6e8;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        border: 1px solid #ced4da !important;
        border-radius: 0.375rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 10px;
    }

    /* Background gradient colorful */
    .colorful-footer {
        background: linear-gradient(135deg, #77bffd 0%, #f2f2f2 100%);
        border-top: none;
        color: #fff;
    }

    /* Footer links */
    .footer-links a {
        color: #fff;
        font-weight: 500;
        transition: 0.3s;
    }

    .footer-links a:hover {
        color: #f3eede;
        /* kuning soft */
        text-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
    }

    /* Social icons */
    .social-icons a {
        color: white;
        font-size: 20px;
        margin-right: 12px;
        transition: 0.3s ease;
    }

    .social-icons a:hover {
        color: #faf0d3;
        text-shadow: 0 0 10px #fff;
        transform: translateY(-3px);
    }

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
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
