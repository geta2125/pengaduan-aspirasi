@extends('layouts_admin.app')

@section('konten')
    @php
        $dev = [
            'nama' => 'Geta Dewi Artika Sari',
            'nim' => '2457301061',
            'prodi' => 'DIV Sistem Informasi',
            'kampus' => 'Politeknik Caltex Riau',
            'foto' => asset('storage/developer/geta.jpeg'),
            'role' => 'Developer',
            'deskripsi' =>
                'SiPAWA (Sistem Pengaduan dan Aspirasi Warga) merupakan platform digital yang dikembangkan untuk memfasilitasi masyarakat dalam menyampaikan pengaduan dan aspirasi secara efektif, transparan, dan terstruktur.',
            'email' => 'geta24si@mahasiswa.pcr.ac.id',
            'wa' => '6285979229792',
            'alwaysdata' => 'https://getadas-pengaduan-aspirasi.alwaysdata.net',
            'linkedin' => 'https://www.linkedin.com/in/geta-dewi-artika-sari-a7b521390/',
            'github' => 'https://github.com/geta2125',
            'instagram' => 'https://instagram.com/getadewiartikasari_',
            'stack' => ['Laravel', 'PHP', 'MySQL', 'JavaScript', 'Bootstrap'],
        ];
        $waOnlyNumber = preg_replace('/\D/', '', $dev['wa']);
    @endphp

    <div class="developer-page-wrapper">
        <div class="developer-one-screen animate-fade">

            {{-- HEADER --}}
            <div class="dev-header d-flex justify-content-between align-items-center px-5">
                <div>
                    <h3 class="fw-bold text-white mb-0">
                        <i class="ri-user-star-line me-2"></i> Developer Profile
                    </h3>
                    <small class="text-white-50">Application Author</small>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 pressable">
                    <i class="ri-arrow-left-line"></i> Kembali
                </a>
            </div>

            {{-- CONTENT --}}
            <div class="dev-content">

                {{-- LEFT --}}
                <div class="dev-col dev-left text-center animate-slide-left hover-lift">
                    <div class="avatar-wrapper mb-4">
                        <img src="{{ $dev['foto'] }}"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($dev['nama']) }}&background=0A84FF&color=fff'">
                    </div>

                    <h4 class="fw-bold mb-1">{{ $dev['nama'] }}</h4>
                    <span class="badge role-badge px-3 py-2">{{ $dev['role'] }}</span>

                    <div class="mini-meta mt-3">
                        <span>{{ $dev['nim'] }}</span><br>
                        <span>{{ $dev['prodi'] }}</span><br>
                        <span>{{ $dev['kampus'] }}</span><br>

                        {{-- 🔹 ALWAYSDATA LINK --}}
                        <a href="{{ $dev['alwaysdata'] }}" target="_blank" class="alwaysdata-pill pressable">
                            <i class="ri-global-line"></i>
                            <span>{{ str_replace(['https://', 'http://'], '', $dev['alwaysdata']) }}</span>
                        </a>
                    </div>
                </div>

                {{-- CENTER --}}
                <div class="dev-col dev-center animate-fade-up">
                    <h5 class="section-title"><i class="ri-file-user-line"></i> About</h5>
                    <p class="about-desc">
                        {{ $dev['deskripsi'] }}
                    </p>
                </div>

                {{-- RIGHT --}}
                <div class="dev-col dev-right animate-slide-right">
                    <h5 class="section-title"><i class="ri-contacts-line"></i> Contact</h5>

                    <p>
                        <i class="ri-mail-line"></i>
                        <a href="mailto:{{ $dev['email'] }}">{{ $dev['email'] }}</a>
                    </p>

                    <p>
                        <i class="ri-whatsapp-line text-success"></i>
                        <a href="https://wa.me/{{ $waOnlyNumber }}" target="_blank">
                            {{ $dev['wa'] }}
                        </a>
                    </p>

                    <div class="social-row my-4">
                        <a href="{{ $dev['linkedin'] }}" target="_blank" class="social-btn linkedin pressable">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                        <a href="{{ $dev['github'] }}" target="_blank" class="social-btn github pressable">
                            <i class="ri-github-fill"></i>
                        </a>
                        <a href="{{ $dev['instagram'] }}" target="_blank" class="social-btn instagram pressable">
                            <i class="ri-instagram-fill"></i>
                        </a>
                    </div>

                    <h5 class="section-title"><i class="ri-code-box-line"></i> Tech Stack</h5>
                    <div class="stack-grid">
                        @foreach ($dev['stack'] as $tech)
                            <span class="tech-pill pressable">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- ================= STYLE ================= --}}
    <style>
        /* WRAPPER */
        .developer-page-wrapper {
            min-height: calc(100vh - 120px);
            padding: 20px;
        }

        /* MAIN CARD */
        .developer-one-screen {
            background: rgba(255, 255, 255, .78);
            backdrop-filter: blur(22px);
            border-radius: 28px;
            box-shadow: 0 40px 90px rgba(0, 0, 0, .18);
            overflow: hidden;
            transition: transform .4s ease, box-shadow .4s ease;
        }

        .developer-one-screen:hover {
            transform: translateY(-4px);
            box-shadow: 0 60px 130px rgba(0, 0, 0, .25);
        }

        /* HEADER */
        .dev-header {
            height: 80px;
            background: linear-gradient(135deg, #0A84FF, #5E5CE6);
        }

        /* GRID */
        .dev-content {
            display: grid;
            grid-template-columns: 1.1fr 1.5fr 1.1fr;
            align-items: stretch;
            /* bikin semua kolom sama tinggi */
        }

        .dev-center {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* COL */
        .dev-col {
            padding: 2.5rem
        }

        /* LEFT */
        .dev-left {
            background: rgba(255, 255, 255, .9)
        }

        .about-desc {
            text-align: justify;
            /* rata kanan kiri */
            text-justify: inter-word;
            line-height: 1.85;
            /* lebih nyaman dibaca */
            flex-grow: 1;
            /* penuhin ke bawah */
            letter-spacing: .2px;
            color: #4b5563;
        }

        .avatar-wrapper img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 6px solid #fff;
            box-shadow: 0 25px 55px rgba(0, 0, 0, .25);
            transition: transform .4s ease, box-shadow .4s ease;
        }

        .avatar-wrapper:hover img {
            transform: scale(1.07);
            box-shadow: 0 35px 70px rgba(10, 132, 255, .4);
        }

        /* TITLES */
        .section-title {
            font-weight: 800;
            color: #0A84FF;
            margin-bottom: 1rem;
        }

        /* SOCIAL */
        /* ================= SOCIAL MEDIA FINAL ================= */
        .social-row {
            display: flex;
            gap: 18px;
        }

        /* BASE BUTTON */
        .social-btn {
            position: relative;
            width: 50px;
            height: 50px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            overflow: hidden;
            cursor: pointer;

            transition:
                transform .35s cubic-bezier(.4, 0, .2, 1),
                box-shadow .35s ease;
        }

        /* LINKEDIN */
        .social-btn.linkedin {
            background: linear-gradient(135deg, #0A66C2, #004182);
            box-shadow: 0 12px 30px rgba(10, 102, 194, .45);
        }

        /* GITHUB */
        .social-btn.github {
            background: linear-gradient(135deg, #24292e, #000);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .45);
        }

        /* INSTAGRAM */
        .social-btn.instagram {
            background: linear-gradient(135deg,
                    #F58529,
                    #DD2A7B,
                    #8134AF,
                    #515BD4);
            box-shadow: 0 12px 30px rgba(225, 48, 108, .45);
        }

        /* HOVER */
        .social-btn:hover {
            transform: translateY(-6px) scale(1.08);
            box-shadow: 0 22px 50px rgba(0, 0, 0, .45);
        }

        /* CLICK */
        .social-btn:active {
            transform: scale(.92);
        }

        /* SOFT LIGHT GLOW */
        .social-btn::after {
            content: '';
            position: absolute;
            inset: -40%;
            background: radial-gradient(circle at top left,
                    rgba(255, 255, 255, .45),
                    transparent 60%);
            opacity: 0;
            transition: opacity .35s ease;
        }

        .social-btn:hover::after {
            opacity: 1;
        }


        .social-btn:hover {
            transform: translateY(-4px) scale(1.05)
        }

        .social-btn:active {
            transform: scale(.9)
        }

        /* STACK */
        .stack-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px
        }

        .tech-pill {
            background: #fff;
            padding: .45rem .9rem;
            border-radius: 999px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, .12);
        }

        /* MICRO INTERACTION */
        .hover-lift {
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .18);
        }

        .pressable:active {
            transform: scale(.94);
        }

        /* PAGE LOAD */
        .animate-fade {
            animation: fadeIn .9s ease
        }

        .animate-slide-left {
            animation: slideLeft 1s ease
        }

        .animate-slide-right {
            animation: slideRight 1s ease
        }

        .animate-fade-up {
            animation: fadeUp 1s ease
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes slideLeft {
            from {
                transform: translateX(-40px);
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes slideRight {
            from {
                transform: translateX(40px);
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes fadeUp {
            from {
                transform: translateY(30px);
                opacity: 0
            }

            to {
                opacity: 1
            }
        }
    </style>

    {{-- ================= RIPPLE EFFECT ================= --}}
    <script>
        document.querySelectorAll('.pressable').forEach(el => {
            el.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                ripple.className = 'ripple';
                this.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });
        });
    </script>

    <style>
        .ripple {
            position: absolute;
            inset: 0;
            background: rgba(10, 132, 255, .18);
            border-radius: inherit;
            animation: ripple .6s ease;
        }

        @keyframes ripple {
            from {
                opacity: .4
            }

            to {
                opacity: 0
            }
        }

        /* ================= ALWAYS DATA PILL (SMALL) ================= */
        .alwaysdata-pill {
            margin-top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: .32rem .75rem;
            border-radius: 999px;

            font-size: .72rem;
            font-weight: 600;
            text-decoration: none;

            color: #0A84FF;
            background: rgba(10, 132, 255, .10);
            backdrop-filter: blur(10px);

            box-shadow: 0 4px 10px rgba(10, 132, 255, .22);
            transition: all .25s ease;
        }

        .alwaysdata-pill i {
            font-size: .8rem;
        }

        .alwaysdata-pill:hover {
            transform: translateY(-2px) scale(1.02);
            background: rgba(10, 132, 255, .16);
            box-shadow: 0 8px 18px rgba(10, 132, 255, .38);
        }

        .alwaysdata-pill:active {
            transform: scale(.95);
        }
    </style>
@endsection
