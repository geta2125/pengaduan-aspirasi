<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bina Desa | {{ $title }}</title>

    {{-- start css --}}
    @include('layouts_admin.css')
    {{-- end css --}}

    <style>
        /* Floating WhatsApp Button CSS */
        .floating-whatsapp-wrapper {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .floating-whatsapp-btn {
            display: flex;
            align-items: center;
            background-color: #25d366;
            color: #fff;
            padding: 10px 15px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 2px 2px 5px #999;
            transition: all 0.3s;
        }

        .floating-whatsapp-btn img {
            width: 35px;
            height: 35px;
            margin-right: 10px;
        }

        .floating-whatsapp-btn:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center"></div>
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

        <!-- Floating WhatsApp Button (1 admin) -->
        <div class="floating-whatsapp-wrapper">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20bertanya%20tentang%20Bina%20Desa"
                target="_blank" class="floating-whatsapp-btn">
                <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" alt="WhatsApp" />
                <span>Chat Admin</span>
            </a>
        </div>
    </div>
    <!-- Wrapper End -->

    {{-- start footer --}}
    @include('layouts_admin.footer')
    {{-- end footer --}}

    {{-- start js --}}
    @include('layouts_admin.js')
    {{-- end js --}}
</body>

</html>
