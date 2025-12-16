<link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}" />
<link rel="stylesheet" href="{{ asset('template/assets/css/backend-plugin.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/css/backend.css?v=1.0.0') }}">
<link rel="stylesheet" href="{{ asset('template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('template/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/vendor/remixicon/fonts/remixicon.css') }}">
<style>
    <style>

    /* =================================================
   ROOT & UTILITIES
================================================= */
    :root {
        --primary: #4e73df;
        --secondary: #36b9cc;
        --success: #22c55e;
        --light: #f8f9fc;
        --dark: #1f2937;
    }

    :root {
        --topbar-h: 110px;
    }

    .content-page,
    #content-page,
    .main-content,
    .wrapper {
        padding-top: var(--topbar-h);
    }


    .bg-primary-light {
        background-color: rgba(0, 123, 255, 0.15);
    }

    .bg-pink-light {
        background-color: #ffd6e8;
    }

    /* =================================================
   SELECT2 FIX (HEIGHT & ALIGNMENT)
================================================= */
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        border: 1px solid #ced4da !important;
        border-radius: .375rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 10px;
    }


    /* =================================================
   SIDEBAR – DEVELOPER SECTION (PREMIUM)
================================================= */
    .sidebar-dev-wrapper {
        padding: 0 14px;
    }

    .sidebar-dev-item {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 12px 14px;
        border-radius: 14px;

        background: var(--light);
        color: var(--dark);
        text-decoration: none;

        transition: all .25s ease;
    }

    .sidebar-dev-item:hover {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: #fff;
        transform: translateY(-2px);
    }

    /* Avatar */
    .dev-avatar {
        position: relative;
        flex-shrink: 0;
    }

    .dev-avatar img {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    /* Online Status */
    .dev-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 9px;
        height: 9px;
        background: var(--success);
        border-radius: 50%;
        border: 2px solid #fff;
    }

    /* Text */
    .dev-info {
        flex-grow: 1;
        line-height: 1.2;
    }

    .dev-title {
        font-size: .8rem;
        font-weight: 700;
    }

    .dev-subtitle {
        font-size: .72rem;
        opacity: .85;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Arrow */
    .dev-arrow {
        font-size: 1.2rem;
        opacity: .6;
        transition: transform .25s ease;
    }

    .sidebar-dev-item:hover .dev-arrow {
        transform: translateX(4px);
    }


    /* =================================================
   FOOTER
================================================= */
    .colorful-footer {
        background: linear-gradient(135deg, #77bffd, #f2f2f2);
        border-top: none;
        color: #fff;
    }

    .footer-links a {
        color: #fff;
        font-weight: 500;
        transition: .3s;
    }

    .footer-links a:hover {
        color: #f3eede;
        text-shadow: 0 0 8px rgba(255, 255, 255, .8);
    }

    .social-icons a {
        color: #fff;
        font-size: 20px;
        margin-right: 12px;
        transition: .3s ease;
    }

    .social-icons a:hover {
        color: #faf0d3;
        text-shadow: 0 0 10px #fff;
        transform: translateY(-3px);
    }


    /* =================================================
   FLOATING WHATSAPP BUTTON
================================================= */
    .floating-whatsapp-btn {
        position: fixed;
        bottom: 28px;
        right: 28px;
        width: 64px;
        height: 64px;

        background: linear-gradient(135deg, #25D366, #1ebe5d);
        border-radius: 50%;

        display: flex;
        justify-content: center;
        align-items: center;

        box-shadow: 0 10px 25px rgba(37, 211, 102, .35);
        z-index: 99999;

        transition: all .3s ease;
    }

    .floating-whatsapp-btn i {
        font-size: 34px;
        color: #fff;
    }

    .floating-whatsapp-btn:hover {
        transform: translateY(-4px) scale(1.08);
        box-shadow: 0 16px 35px rgba(37, 211, 102, .5);
    }

    .floating-whatsapp-btn::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: rgba(37, 211, 102, .4);
        animation: wa-pulse 2s infinite;
        z-index: -1;
    }

    @keyframes wa-pulse {
        from {
            transform: scale(1);
            opacity: .7;
        }

        to {
            transform: scale(1.6);
            opacity: 0;
        }
    }


    /* =================================================
   AVATAR PREVIEW
================================================= */
    .avatar-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;

        border: 2px solid var(--primary);
        background: #e9ecef;

        box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    /* =================================================
   FULLSCREEN LOADER
================================================= */
    #custom-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: #f8f8f8;
        z-index: 9999;

        display: flex;
        justify-content: center;
        align-items: center;

        transition: opacity .5s ease, visibility .5s ease;
    }

    #custom-loader-center {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
    }

    .dot {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out both;
    }

    .dot:nth-child(1) {
        background: #00065a;
        animation-delay: -.32s;
    }

    .dot:nth-child(2) {
        background: #3498db;
        animation-delay: -.16s;
    }

    .dot:nth-child(3) {
        background: #2c3aff;
    }

    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0);
        }

        40% {
            transform: scale(1);
        }
    }



    /* =================================================
   SIDEBAR HAMBURGER BUTTON (POLISHED)
================================================= */
    body.sidebar-main .iq-menu-bt-sidebar {
        margin: 20px 0 16px;

        background: #fff;
        border-radius: 14px;

        box-shadow:
            0 10px 24px rgba(78, 115, 223, .35),
            inset 0 1px 0 rgba(255, 255, 255, .25);

        transition: transform .25s ease, box-shadow .25s ease;
    }

    body.sidebar-main .iq-menu-bt-sidebar i {
        font-size: 21px;
    }

    body.sidebar-main .iq-menu-bt-sidebar:hover {
        transform: translateY(-1px) scale(1.06);
        box-shadow:
            0 14px 32px rgba(78, 115, 223, .45),
            inset 0 1px 0 rgba(255, 255, 255, .35);
    }

    body.sidebar-main .iq-menu-bt-sidebar:active {
        transform: scale(.96);
    }

    /* ------------------------------------------- */
    /* END: Gaya CSS untuk Loader Bouncing Dots */
    /* ------------------------------------------- */
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
