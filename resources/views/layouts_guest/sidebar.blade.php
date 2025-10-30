<nav class="iq-sidebar-menu">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset('template_guest/assets/images/logo.png') }}" class="img-fluid rounded-normal" alt="logo">
        </a>
        <div class="iq-menu-bt-sidebar">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <ul id="iq-sidebar-toggle" class="iq-menu d-flex">
        <!-- Dashboard -->
        <li class="active">
            <a href="{{ route('dashboard') }}">
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Pengaduan -->
        <li>
            <a href="#pengaduan" class="collapsed" data-toggle="collapse" aria-expanded="false">
                <span>Pengaduan</span>
                <i class="ri-arrow-right-s-line iq-arrow-right"></i>
            </a>
            <ul id="pengaduan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                <li>
                    <a href="{{ route('guest.pengaduan.ajukan') }}">
                        <span>Ajukan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('guest.pengaduan.riwayat') }}">
                        <span>Riwayat</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Penilaian Layanan -->
        <li>
            <a href="{{ route('guest.penilaian.pengaduan') }}">
                <span>Penilaian Layanan</span>
            </a>
        </li>
    </ul>
</nav>
