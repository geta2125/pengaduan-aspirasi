<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                <i class="ri-menu-line wrapper-menu"></i>

                <a href="{{ route('dashboard') }}" class="header-logo d-flex align-items-center"
                    style="gap: 6px; text-decoration: none;">
                    <img src="{{ asset('assets/logo/logo.png') }}" class="img-fluid light-logo"
                        style="
                                height: 90px;        /* BESARIN */
                                width: auto;         /* biar proporsi aman */
                                object-fit: contain;
                                flex-shrink: 0;
                                "
                        alt="logo">

                </a>
            </div>

            <div class="iq-search-bar device-search"></div>

            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">



                        {{-- PROFILE --}}
                        <li class="nav-item nav-icon dropdown caption-content">
                            <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton4"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('template/assets/images/user/1.png') }}"
                                    class="img-fluid rounded" alt="user">
                            </a>

                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="card shadow-none m-0">
                                    <div class="card-body p-0 text-center">

                                        <div class="media-body profile-detail text-center">
                                            {{-- Latar Belakang Biru Pudar --}}
                                            <div class="rounded-top mb-4"
                                                style="height:120px; background: rgba(0,123,255,.18);"></div>

                                            {{-- Foto Profil --}}
                                            <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('template/assets/images/user/1.png') }}"
                                                alt="Foto Profil Pengguna"
                                                class="profile-img img-fluid rounded-circle avatar-70"
                                                style="width:70px; height:70px; object-fit:cover; margin-top: -60px;">
                                            {{-- margin-top ditambahkan agar foto muncul di tengah latar belakang --}}
                                        </div>

                                        <div class="p-3">
                                            <h5 class="mb-1">{{ Auth::user()->nama ?? 'User' }}</h5>
                                            <p class="mb-0 text-muted">{{ Auth::user()->role }}</p>
                                            {{-- Menambahkan text-muted agar warna role lebih lembut --}}

                                            {{-- Tombol Aksi --}}
                                            <div class="d-flex align-items-center justify-content-center mt-3">
                                                <a href="{{ route('profile') }}"
                                                    class="btn border btn-outline-primary mr-2">Profile</a>

                                                {{-- Tombol Logout --}}
                                                <a href="{{ route('logout') }}" data-confirm-logout
                                                    class="btn border btn-danger">
                                                    Sign Out
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutLinks = document.querySelectorAll('[data-confirm-logout]');

        logoutLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Logout Sistem',
                    text: 'Apakah Anda yakin ingin logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('logout') }}";
                    }
                });
            });
        });
    });
</script>
