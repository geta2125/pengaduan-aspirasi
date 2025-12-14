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
        .floating-whatsapp-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #25D366;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            z-index: 1050;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
            opacity: 0.9;
        }

        .floating-whatsapp-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
            opacity: 1;
        }

        .floating-whatsapp-btn img {
            width: 60%;
            height: 60%;
            object-fit: contain;
        }

        @media (max-width: 576px) {
            .floating-whatsapp-btn {
                bottom: 15px;
                right: 15px;
                width: 55px;
                height: 55px;
            }
        }
    </style>
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
       target="_blank"
       aria-label="Hubungi Admin via WhatsApp"
       class="floating-whatsapp-btn">
        <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" alt="WhatsApp">
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
