<!doctype html>
<html lang="en">

<head>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/backend.css?v=1.0.0') }}">

    <!-- Icon Libraries -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/remixicon/fonts/remixicon.css') }}">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- start css --}}
    @include('layouts_admin.css')
    {{-- end css --}}
</head>

<body class="">
    <!-- loader Start -->
    <div id="custom-loader">
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
    </div>
    <!-- Wrapper End -->

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6285979229792?text=Halo%20Admin,%20saya%20ingin%20bertanya%20tentang%20SiPAWA"
        target="_blank" aria-label="Hubungi Admin via WhatsApp" class="floating-whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
    </a>


    {{-- start footer --}}
    @include('layouts_admin.footer')
    {{-- end footer --}}

    {{-- start js --}}
    @include('layouts_admin.js')
    {{-- end js --}}

    @stack('scripts')

</body>

</html>
