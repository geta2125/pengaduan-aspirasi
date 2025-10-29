<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BinaDesa | {{ $title }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('template_guest/assets/images/favicon.ico') }}" />

    <link rel="stylesheet" href="{{ asset('template_guest/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_guest/assets/css/backend.css?v=1.0.1') }}">
    <link rel="stylesheet"
        href="{{ asset('template_guest/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template_guest/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_guest/assets/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Memastikan Select2 CSS dimuat --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

</head>

<body class="fixed-top-navbar top-nav  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <div class="iq-top-navbar">
            <div class="container">
                <div class="iq-navbar-custom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                            <i class="ri-menu-line wrapper-menu"></i>
                            <a href="index.html') }}" class="header-logo">
                                <img src="{{ asset('template_guest/assets/images/logo.png') }}"
                                    class="img-fluid rounded-normal light-logo" alt="logo">
                            </a>
                        </div>
                        <div class="iq-menu-horizontal">
                            @include('layouts_guest.sidebar')
                        </div>
                        @include('layouts_guest.navbar')
                    </div>
                </div>
            </div>
        </div>
        <div class="content-page">
            @yield('konten')
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left" id="popup">
                        <h4 class="mb-3">Add Action</h4>
                        <div class="content create-workform">
                            <div class="form-group">
                                <h6 class="form-label mb-3">Copy Your Link</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2"><i
                                                class="las la-link"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6 class="form-label mb-3">Email Your Link</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon3"><i
                                                class="las la-envelope"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6 class="form-label mb-3">Add to Your Website</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon4"><i
                                                class="las la-code"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                    <button type="submit" data-dismiss="modal"
                                        class="btn btn-primary mr-4">Cancel</button>
                                    <button type="submit" data-dismiss="modal"
                                        class="btn btn-outline-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wrapper End-->
    <footer class="iq-footer">
        <div class="container-fluid container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a
                                href="{{ asset('template_guest/backend/privacy-policy.html') }}">Privacy Policy</a></li>
                        <li class="list-inline-item"><a
                                href="{{ asset('template_guest/backend/terms-of-service.html') }}">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                    Copyright 2021 <a href="#">Calendify</a> All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('template_guest/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('template_guest/assets/js/customizer.js') }}"></script>


    <!-- app JavaScript -->
    <script src="{{ asset('template_guest/assets/js/app.js') }}"></script>
    {{-- Memastikan jQuery dimuat sebelum Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    @stack('scripts')
    <script>
        // SweetAlert2 based on session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
</body>

</html>