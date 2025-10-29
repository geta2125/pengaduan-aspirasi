<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bina Desa | {{ $title }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/remixicon/fonts/remixicon.css') }}">

</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        @include('layouts_admin.sidebar')
        @include('layouts_admin.topbar')

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
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
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

    <!-- Wrapper End-->
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a
                                        href="{{ asset('template/backend/privacy-policy.html') }}">Privacy
                                        Policy</a></li>
                                <li class="list-inline-item"><a
                                        href="{{ asset('template/backend/terms-of-service.html') }}">Terms of
                                        Use</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-right">
                            <span class="mr-1">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>©
                            </span> <a href="#" class="">Bina Desa</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('template/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('template/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('template/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('template/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('template/assets/js/app.js') }}"></script>
    @stack('scripts')

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.delete-btn').on('click', function (e) {
                e.preventDefault();

                var url = $(this).attr('href');
                var row = $(this).closest('tr'); // jika tombol di tabel

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data ini tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    title: 'Dihapus!',
                                    text: response.message, // ambil dari JSON
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                row.remove(); // langsung hapus row tanpa reload
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>


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