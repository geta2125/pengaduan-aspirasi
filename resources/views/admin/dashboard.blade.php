@extends('layouts_admin.app')

@section('konten')
    {{-- Container Utama (Lebih Clean) --}}
    <div class="container-fluid">

        {{-- Row Header: Sapaan, Deskripsi, dan Global Filter --}}
        <div class="row mb-4">
            {{-- Bagian Sapaan & Deskripsi (Modernized & Compact) --}}
            <div class="col-lg-5 col-xl-4 d-flex align-items-stretch">
                <div
                    class="card card-transparent card-block card-stretch border-0 w-100 bg-light-primary rounded-4 shadow-sm p-4">
                    <div class="card-body p-0">
                        @php
                            $namaUser = Auth::user()->nama ?? 'Admin';
                            $jam = date('H');
                            if ($jam >= 5 && $jam < 12) {
                                $sapaan = 'Selamat Pagi';
                                $emoji = '☀️';
                            } elseif ($jam >= 12 && $jam < 17) {
                                $sapaan = 'Selamat Siang';
                                $emoji = '🌤️';
                            } elseif ($jam >= 17 && $jam < 20) {
                                $sapaan = 'Selamat Sore';
                                $emoji = '🌇';
                            } else {
                                $sapaan = 'Selamat Malam';
                                $emoji = '🌙';
                            }
                        @endphp

                        <p class="mb-1 font-weight-bold text-dark h5">{{ $sapaan }} {{ $emoji }}</p>
                        <h1 class="font-weight-bolder mb-3 text-primary display-6">{{ $namaUser }}!</h1>
                        <p class="text-secondary small mb-0">
                            Dashboard ringkasan data real-time dan statistik sistem pengaduan warga. Analisis data lebih
                            spesifik menggunakan Filter Periode di samping.
                        </p>
                    </div>
                </div>
            </div>
            {{-- END Bagian Sapaan & Deskripsi --}}

            {{-- Bagian Ringkasan Data & Filter Keseluruhan --}}
            <div class="col-lg-7 col-xl-8 d-flex flex-column">

                {{-- FILTER PERIODE BULAN & TAHUN (Sesuai Gaya Gambar) --}}
                <div class="row mb-3 flex-grow-0">
                    <div class="col-12 d-flex justify-content-end align-items-center bg-white p-3 rounded-4 border-0">

                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt mr-2 text-info"></i>
                            <label for="filter_month" class="mr-3 mb-0 text-dark font-weight-bold small">Periode
                                Data:</label>
                        </div>

                        {{-- Dropdown Bulan (Gaya Capsule/Pill) --}}
                        <div class="mr-2">
                            <select id="filter_month"
                                class="form-control form-control-sm custom-select-sm shadow-sm rounded-pill border-light"
                                style="width: 130px; background-color: #f8f9fa;">
                                @php
                                    $months = [
                                        'Januari',
                                        'Februari',
                                        'Maret',
                                        'April',
                                        'Mei',
                                        'Juni',
                                        'Juli',
                                        'Agustus',
                                        'September',
                                        'Oktober',
                                        'November',
                                        'Desember',
                                    ];
                                    $currentMonth = date('n');
                                @endphp
                                @foreach ($months as $key => $month)
                                    <option value="{{ $key + 1 }}" {{ $key + 1 == $currentMonth ? 'selected' : '' }}>
                                        {{ $month }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Dropdown Tahun (Gaya Capsule/Pill) --}}
                        <div class="mr-3">
                            <select id="filter_year"
                                class="form-control form-control-sm custom-select-sm shadow-sm rounded-pill border-light"
                                style="width: 100px; background-color: #f8f9fa;">
                                @php
                                    $currentYear = date('Y');
                                    $startYear = $currentYear - 3;
                                @endphp
                                @for ($y = $currentYear; $y >= $startYear; $y--)
                                    <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Tombol Aksi Terapkan (Cyan - Sesuai Gambar) --}}
                        <button id="apply_filter" class="btn btn-sm text-white shadow-sm"
                            style="background-color: #36b9cc; border-color: #36b9cc;">
                            <i class="fas fa-sync-alt mr-1"></i> Terapkan
                        </button>
                    </div>
                </div>
                {{-- END FILTER PERIODE BULAN & TAHUN --}}
                {{-- Ringkasan Data (Modernized Stat Cards) --}}
                <div class="row flex-grow-1">
                    {{-- Total Warga --}}
                    <div class="col-lg-4 col-md-4 mb-3">
                        <div class="card stat-card shadow-sm border-0 h-100 py-2 rounded-4 hover-shadow-lg">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Warga
                                            Terdaftar</div>
                                        <div class="h5 mb-0 font-weight-bolder text-gray-900" id="totalWarga">
                                            {{ $totalWarga }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-info-subtle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Kategori Pengaduan --}}
                    <div class="col-lg-4 col-md-4 mb-3">
                        <div class="card stat-card shadow-sm border-0 h-100 py-2 rounded-4 hover-shadow-lg">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Kategori
                                            Aduan</div>
                                        <div class="h5 mb-0 font-weight-bolder text-gray-900" id="totalKategoriPengaduan">
                                            {{ $totalKategoriPengaduan }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-tags fa-2x text-danger-subtle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Pengaduan (Periode) --}}
                    <div class="col-lg-4 col-md-4 mb-3">
                        <div class="card stat-card shadow-sm border-0 h-100 py-2 rounded-4 hover-shadow-lg">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                            Pengaduan
                                            (Periode)</div>
                                        <div class="h5 mb-0 font-weight-bolder text-gray-900" id="totalPengaduan">
                                            {{ $totalPengaduan }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-primary-subtle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END Bagian Ringkasan Data & Filter --}}
        </div>

        {{-- Row Grafik 1 & 2 --}}
        <div class="row">
            {{-- Grafik Tindak Lanjut (Bar Chart) --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg h-100 border-0 rounded-4">
                    <div
                        class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom-0">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-bar mr-1"></i> Tindak Lanjut
                            Pengaduan</h6>
                        {{-- Filter internal tetap ada untuk Year/Month/Week dalam periode yang dipilih --}}
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                id="dropdownTindakLanjut" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-filter"></i> Bulan Ini
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="dropdownTindakLanjut">
                                <a class="dropdown-item filter-tindak-lanjut" data-type="year" href="#"><i
                                        class="fas fa-calendar-alt mr-2"></i> Tahun Ini</a>
                                <a class="dropdown-item filter-tindak-lanjut" data-type="month" href="#"><i
                                        class="fas fa-calendar-check mr-2"></i> Bulan Ini</a>
                                <a class="dropdown-item filter-tindak-lanjut" data-type="week" href="#"><i
                                        class="fas fa-calendar-week mr-2"></i> Minggu Ini</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="tindak-lanjut-chart" style="min-height: 380px;"></div>
                    </div>
                </div>
            </div>

            {{-- Grafik Penilaian (Donut Chart) --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg h-100 border-0 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-star mr-1"></i> Statistik Penilaian
                            Warga</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center pt-0">
                        <div id="penilaian-chart" style="min-height: 380px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row Grafik 3 & Tabel --}}
        <div class="row">
            {{-- Grafik Kategori Pengaduan - OPTIMASI UNTUK BANYAK DATA (Horizontal Bar) --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg h-100 border-0 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list-alt mr-1"></i> Jumlah
                            Pengaduan Berdasarkan Kategori</h6>
                    </div>
                    {{-- Style `overflow-y: auto;` di Card-body dipertahankan untuk mengelola bar chart yang panjang --}}
                    <div class="card-body" style="overflow-y: auto;">
                        <div id="kategori-pengaduan-chart" style="min-height: 400px;"></div>
                    </div>
                </div>
            </div>

            {{-- Top 5 Warga (Tabel Modern) --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg h-100 border-0 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-trophy mr-1"></i> Warga Pelapor
                            Teratas (Top 5)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="small text-uppercase">#</th>
                                        <th class="small text-uppercase">Warga (Nama)</th>
                                        <th class="small text-uppercase text-center">Total Pengaduan</th>
                                    </tr>
                                </thead>
                                {{-- ID untuk memudahkan update via JS/AJAX --}}
                                <tbody id="wargaTeratasTable">
                                    {{-- Data akan diisi via JavaScript --}}
                                </tbody>
                            </table>
                        </div>
                        {{-- Pesan kosong lebih terintegrasi --}}
                        <div id="wargaTeratasEmpty" class="text-center text-muted py-3 small" style="display: none;">
                            <i class="fas fa-box-open mr-1"></i> Belum ada data pelapor teratas pada periode ini.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Pastikan ApexCharts sudah dimuat sebelum menjalankan skrip ini
        $(document).ready(function() {

            // ================================
            // VARIABEL KONSTANTA & INISIALISASI
            // ================================

            let dashboardData = {
                labelsKategori: @json($labelsKategori),
                dataKategori: @json($dataKategori),
                labelsRating: @json($labelsRating),
                dataRating: @json($dataRating),
                labelsStatus: @json($labelsStatus),
                dataStatus: @json($dataStatus),
                totalWarga: @json($totalWarga),
                totalKategoriPengaduan: @json($totalKategoriPengaduan),
                totalPengaduan: @json($totalPengaduan),
                wargaTeratas: @json($wargaTeratas)
            };

            const elKategori = document.querySelector('#kategori-pengaduan-chart');
            const elPenilaian = document.querySelector('#penilaian-chart');
            const elTindakLanjut = document.querySelector('#tindak-lanjut-chart');

            let tindakLanjutChart = null;
            let kategoriPengaduanChart = null;
            let penilaianChart = null;
            let currentTindakLanjutType = 'month'; // Default filter internal

            const labelFilter = {
                year: 'Tahun Ini',
                month: 'Bulan Ini',
                week: 'Minggu Ini'
            };

            // Warna yang direkomendasikan untuk chart (Menggunakan palet modern & aksesibilitas)
            const primaryColor = '#4e73df'; // Biru Utama
            const secondaryColor = '#858796'; // Abu-abu
            const successColor = '#1cc88a'; // Hijau (Selesai/Baik)
            const infoColor = '#36b9cc'; // Cyan (Diproses/Netral)
            const warningColor = '#f6c23e'; // Kuning (Menunggu/Perhatian)
            const dangerColor = '#e74a3b'; // Merah (Buruk)
            const lightPrimaryColor = '#adc8ff'; // Biru Muda

            // Warna untuk Penilaian (Rating): Konsisten & Jelas (5 Bintang sampai 1 Bintang)
            const ratingColors = [successColor, infoColor, warningColor, dangerColor, secondaryColor];
            // Warna untuk Status Tindak Lanjut: Konsisten & Jelas
            const statusColors = [warningColor, infoColor, successColor]; // Menunggu, Diproses, Selesai

            // Formatter functions
            const fmtPengaduan = val => `${Math.round(val)} pengaduan`;
            const fmtPenilaian = val => `${Math.round(val)} penilaian`;


            // ===============================================
            // FUNGSI UPDATE KOMPONEN NON-GRAFIK
            // ===============================================

            // Fungsi animasi untuk count-up
            function animateCount(elementId, targetValue) {
                $({
                    count: $(elementId).text()
                }).animate({
                    count: targetValue
                }, {
                    duration: 500,
                    step: function() {
                        $(elementId).text(Math.floor(this.count));
                    },
                    complete: function() {
                        $(elementId).text(targetValue
                    .toLocaleString()); // Tampilkan dengan format ribuan jika perlu
                    }
                });
            }

            function updateTotalCounts(data) {
                animateCount('#totalWarga', data.totalWarga);
                animateCount('#totalKategoriPengaduan', data.totalKategoriPengaduan);
                animateCount('#totalPengaduan', data.totalPengaduan);
            }

            function updateWargaTeratasTable(data) {
                const tableBody = $('#wargaTeratasTable');
                const emptyMessage = $('#wargaTeratasEmpty');
                tableBody.empty();
                emptyMessage.hide();

                if (data.wargaTeratas && data.wargaTeratas.length > 0) {
                    // Hapus pesan kosong di baris tabel jika ada
                    tableBody.find('.empty-row').remove();

                    data.wargaTeratas.forEach((warga, index) => {
                        let icon = '';
                        // Menggunakan warna yang lebih modern untuk Top 3
                        if (index === 0) icon = '<i class="fas fa-medal text-warning mr-2"></i>'; // Emas
                        else if (index === 1) icon =
                        '<i class="fas fa-medal text-secondary mr-2"></i>'; // Perak
                        else if (index === 2) icon =
                        '<i class="fas fa-medal text-danger mr-2"></i>'; // Perunggu

                        tableBody.append(`
                        <tr class="animated fadeIn">
                            <td class="small">${icon} ${index + 1}</td>
                            <td class="font-weight-bold text-gray-800">${warga.nama}</td>
                            <td class="text-center"><span class="badge badge-primary badge-pill">${warga.total_pengaduan}</span></td>
                        </tr>
                    `);
                    });
                } else {
                    // Tampilkan pesan "Tidak ada data" sebagai baris tabel agar konsisten
                    tableBody.append(
                        '<tr class="empty-row"><td colspan="3" class="text-center text-muted small"><i class="fas fa-box-open mr-1"></i> Belum ada warga yang membuat pengaduan pada periode ini.</td></tr>'
                    );
                }
            }


            // ===============================================
            // FUNGSI RENDER GRAFIK (ApexCharts)
            // ===============================================

            // 1. GRAFIK KATEGORI PENGADUAN (HORIZONTAL BAR - DINAMIS)
            function renderKategoriPengaduanChart(data) {
                const d = data.dataKategori || [];
                const l = data.labelsKategori || [];

                if (!elKategori) return;

                if (kategoriPengaduanChart) {
                    kategoriPengaduanChart.destroy();
                    kategoriPengaduanChart = null;
                }
                elKategori.innerHTML = '';

                if (!l.length) {
                    elKategori.innerHTML =
                        '<p class="text-center mt-5 text-muted small"><i class="fas fa-chart-line mr-1"></i> Belum ada data kategori pengaduan pada periode ini.</p>';
                    $(elKategori).height(400);
                    return;
                }

                // Hitungan Tinggi Dinamis: Minimal 400px. 50px per bar + 100px padding
                const minHeight = 400;
                const heightPerBar = 50; // Ditingkatkan sedikit untuk ruang
                const dynamicHeight = l.length * heightPerBar + 100;
                const finalHeight = Math.max(minHeight, dynamicHeight);

                $(elKategori).height(finalHeight);

                // --- APLIKASI WARNA DINAMIS (Hanya Top 3 yang disorot) ---
                // Cari indeks data terbesar untuk Top 3.
                // Buat array pasangan [data, index] dan urutkan
                const sortedData = d.map((value, index) => ({
                    value,
                    index
                })).sort((a, b) => b.value - a.value);
                const top3Indices = sortedData.slice(0, 3).map(item => item.index);

                const dynamicColors = d.map((value, index) => {
                    // Jika termasuk Top 3, gunakan warna primer
                    if (top3Indices.includes(index) && value > 0) {
                        return primaryColor;
                    }
                    // Jika bukan Top 3, gunakan warna sekunder yang lebih kalem
                    return secondaryColor;
                });
                // --------------------------------------------------------

                const options = {
                    series: [{
                        name: 'Jumlah Pengaduan',
                        data: d
                    }],
                    chart: {
                        type: 'bar',
                        height: finalHeight,
                        toolbar: {
                            show: false,
                            tools: {
                                download: true,
                            }
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeout',
                            speed: 700
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6, // Sedikit kurang melengkung, lebih clean
                            barHeight: '70%', // Bar lebih lebar dan menonjol
                            dataLabels: {
                                position: 'center' // Label data di tengah bar (lebih rapi)
                            },
                            distributed: true // Penting untuk warna per bar
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: val => `${Math.round(val)}`, // HANYA angka, lebih bersih
                        offsetX: 0, // Di tengah bar
                        style: {
                            colors: ['#fff'], // Warna putih untuk kontras di dalam bar
                            fontSize: '14px',
                            fontWeight: 700,
                            fontFamily: 'Nunito, sans-serif'
                        },
                        dropShadow: {
                            enabled: true, // Beri sedikit shadow agar teks terbaca di semua warna
                            top: 1,
                            left: 1,
                            blur: 1,
                            opacity: 0.5
                        }
                    },
                    xaxis: {
                        categories: l,
                        title: {
                            text: 'Jumlah Pengaduan',
                            style: {
                                fontSize: '12px',
                                fontWeight: 600,
                                color: secondaryColor
                            }
                        },
                        labels: {
                            formatter: val => Math.round(val),
                            style: {
                                fontSize: '11px'
                            }
                        },
                        tickAmount: 5,
                        min: 0 // Pastikan dimulai dari 0
                    },
                    yaxis: {
                        // DIBUAT TIDAK REVERSED: Kategori dengan data terbanyak akan berada di atas secara alami
                        // reversed: false,
                        labels: {
                            style: {
                                fontSize: '13px',
                                fontWeight: 600,
                                color: secondaryColor
                            },
                            maxWidth: 200
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: fmtPengaduan // Tooltip yang menampilkan teks "pengaduan"
                        }
                    },
                    grid: {
                        strokeDashArray: 3,
                        borderColor: '#f0f0f0', // Lebih terang
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false // Garis horizontal (Y) dimatikan
                            }
                        }
                    },
                    colors: dynamicColors, // Terapkan warna dinamis
                    legend: {
                        show: false
                    }
                };

                kategoriPengaduanChart = new ApexCharts(elKategori, options);
                kategoriPengaduanChart.render();
            }

            // 2. GRAFIK PENILAIAN (DONUT CHART)
            function renderPenilaianChart(data) {
                const d = data.dataRating || [];
                const l = data.labelsRating || [];

                if (!elPenilaian) return;

                if (penilaianChart) {
                    penilaianChart.destroy();
                    penilaianChart = null;
                }
                elPenilaian.innerHTML = '';

                const totalData = d.reduce((a, b) => a + b, 0);

                if (!d.length || totalData === 0) {
                    elPenilaian.innerHTML =
                        '<p class="text-center mt-5 text-muted small"><i class="fas fa-chart-pie mr-1"></i> Belum ada data penilaian pada periode ini.</p>';
                    return;
                }

                const seriesPercentage = d.map(value => (value / totalData) * 100);

                const options = {
                    series: seriesPercentage,
                    chart: {
                        type: 'donut',
                        height: 380, // Ditingkatkan sedikit
                        animations: {
                            enabled: true,
                            easing: 'easeout',
                            speed: 800
                        }
                    },
                    labels: l,
                    dataLabels: {
                        formatter: function(val) {
                            return `${Math.round(val)}%`
                        },
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Nunito, sans-serif'
                        },
                        dropShadow: {
                            enabled: false
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val, {
                                seriesIndex
                            }) {
                                return `${d[seriesIndex].toLocaleString()} penilaian (${Math.round(val)}%)`;
                            }
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        fontSize: '14px',
                        markers: {
                            width: 12,
                            height: 12,
                            radius: 6
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%', // Donut lebih besar
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '16px',
                                        color: secondaryColor
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '24px',
                                        fontWeight: 700,
                                        color: '#333',
                                        formatter: function(val) {
                                            return Math.round(val) + '%'
                                        }
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total Nilai',
                                        fontSize: '16px',
                                        fontWeight: 600,
                                        color: primaryColor,
                                        formatter: function(w) {
                                            return totalData.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    },
                    colors: ratingColors // Gunakan warna rating yang sudah didefinisikan
                };

                penilaianChart = new ApexCharts(elPenilaian, options);
                penilaianChart.render();
            }

            // 3. GRAFIK STATUS / TINDAK LANJUT (BAR CHART)
            function getStatusConfig(type, data) {
                const key = type || 'month';
                const defaultLabels = ['Menunggu', 'Diproses', 'Selesai']; // Fallback labels
                // Pastikan data yang diambil sesuai dengan tipe filter (year, month, week)
                const labels = (data.labelsStatus && data.labelsStatus[key]) ? data.labelsStatus[key] :
                    defaultLabels;
                const seriesData = (data.dataStatus && data.dataStatus[key]) ? data.dataStatus[key] : [];

                return {
                    labels: labels,
                    series: [{
                        name: 'Jumlah Pengaduan',
                        data: seriesData
                    }]
                };
            }

            function renderTindakLanjutChart(type, data) {
                if (!elTindakLanjut) return;

                if (tindakLanjutChart) {
                    tindakLanjutChart.destroy();
                    tindakLanjutChart = null;
                }
                elTindakLanjut.innerHTML = '';

                const cfg = getStatusConfig(type, data);

                if (!cfg.series[0].data.length || cfg.series[0].data.reduce((a, b) => a + b, 0) === 0) {
                    elTindakLanjut.innerHTML =
                        '<p class="text-center mt-5 text-muted small"><i class="fas fa-chart-bar mr-1"></i> Belum ada data tindak lanjut untuk periode ' +
                        (labelFilter[
                            type] ?? 'Bulan Ini') + '.</p>';
                    return;
                }

                // Gabungkan label dan data untuk mendapatkan warna yang sesuai
                const statusLabels = ['Menunggu', 'Diproses', 'Selesai'];
                const seriesColors = cfg.labels.map(label => {
                    const index = statusLabels.indexOf(label);
                    return index !== -1 ? statusColors[index] : primaryColor;
                });


                const options = {
                    series: cfg.series,
                    chart: {
                        type: 'bar',
                        height: 380,
                        toolbar: {
                            show: false,
                            tools: {
                                download: true,
                            }
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeout',
                            speed: 700
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '70%',
                            borderRadius: 8,
                            distributed: true, // Mengaktifkan warna per kolom
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: fmtPengaduan,
                        offsetY: -20, // Posisikan label di atas bar
                        style: {
                            fontSize: '13px',
                            colors: ['#333'],
                            fontWeight: 600
                        }
                    },
                    xaxis: {
                        categories: cfg.labels,
                        labels: {
                            style: {
                                fontSize: '13px',
                                fontWeight: 600,
                                colors: secondaryColor
                            }
                        },
                        axisBorder: {
                            show: false
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah Pengaduan',
                            style: {
                                fontSize: '12px',
                                fontWeight: 600
                            }
                        },
                        labels: {
                            formatter: val => Math.round(val)
                        },
                        min: 0,
                        forceDecimals: false
                    },
                    tooltip: {
                        y: {
                            formatter: fmtPengaduan
                        }
                    },
                    grid: {
                        strokeDashArray: 3,
                        borderColor: '#e0e0e0',
                    },
                    colors: seriesColors, // Terapkan warna status
                    legend: {
                        show: false // Karena distributed, legend tidak diperlukan
                    }
                };

                tindakLanjutChart = new ApexCharts(elTindakLanjut, options);
                tindakLanjutChart.render();
            }

            // ===============================================
            // FUNGSI UTAMA UNTUK MEMUAT DATA BERDASARKAN PERIODE (AJAX NYATA)
            // ===============================================
            function loadDashboardData(month, year) {
                // Loading State: Nonaktifkan filter
                $('#apply_filter').prop('disabled', true).html('<i class="fas fa-sync fa-spin"></i> Memuat...');
                $('.card').addClass('is-loading'); // Kelas untuk efek loading
                $('.stat-card').css('opacity', 0.6);

                // Tampilkan pesan loading di area chart
                const loadingHtml =
                    '<p class="text-center mt-5 text-muted small"><i class="fas fa-sync fa-spin mr-1"></i> Memuat Grafik...</p>';
                if (elKategori) elKategori.innerHTML = loadingHtml;
                if (elPenilaian) elPenilaian.innerHTML = loadingHtml;
                if (elTindakLanjut) elTindakLanjut.innerHTML = loadingHtml;
                $('#wargaTeratasTable').html(
                    '<tr><td colspan="3" class="text-center text-primary small"><i class="fas fa-sync fa-spin mr-1"></i> Memuat Data...</td></tr>'
                );

                // AJAX CALL
                $.ajax({
                    url: "{{ route('dashboard.data') }}", // Pastikan ini adalah route yang benar
                    method: 'GET',
                    data: {
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        dashboardData = response;

                        // 1. Update Ringkasan
                        updateTotalCounts(dashboardData);

                        // 2. Update Tabel
                        updateWargaTeratasTable(dashboardData);

                        // 3. Render Ulang Grafik
                        renderKategoriPengaduanChart(dashboardData);
                        renderPenilaianChart(dashboardData);
                        renderTindakLanjutChart(currentTindakLanjutType,
                        dashboardData); // Gunakan filter internal terakhir

                        // Update judul Tindak Lanjut dropdown
                        $('#dropdownTindakLanjut').html(
                            '<i class="fas fa-filter"></i> ' + (labelFilter[
                                currentTindakLanjutType] ?? 'Bulan Ini')
                        );
                    },
                    error: function(err) {
                        console.error("Gagal memuat data dashboard:", err);
                        const errorHtml =
                            '<p class="text-center mt-5 text-danger small"><i class="fas fa-exclamation-triangle mr-1"></i> Gagal memuat data.</p>';

                        $('#wargaTeratasTable').html(
                            '<tr><td colspan="3" class="text-center text-danger small">Gagal memuat data.</td></tr>'
                        );
                        if (elKategori) elKategori.innerHTML = errorHtml;
                        if (elPenilaian) elPenilaian.innerHTML = errorHtml;
                        if (elTindakLanjut) elTindakLanjut.innerHTML = errorHtml;
                    },
                    complete: function() {
                        // Hilangkan Loading State
                        $('#apply_filter').prop('disabled', false).html(
                            '<i class="fas fa-sync-alt"></i> Terapkan');
                        $('.card').removeClass('is-loading');
                        $('.stat-card').css('opacity', 1);
                    }
                });
            }

            // ================================
            // EVENT HANDLERS
            // ================================

            // 1. Event filter Tindak Lanjut (internal: Year/Month/Week)
            $('.filter-tindak-lanjut').on('click', function(e) {
                e.preventDefault();
                const type = $(this).data('type');
                currentTindakLanjutType = type; // Simpan tipe filter saat ini

                // Update teks tombol dropdown
                $('#dropdownTindakLanjut').html(
                    '<i class="fas fa-filter"></i> ' + $(this).text().replace(/<i[^>]*>/g, '').trim()
                );

                // Render ulang grafik status
                renderTindakLanjutChart(type, dashboardData);
            });

            // 2. EVENT FILTER KESELURUHAN (BULAN/TAHUN)
            $('#apply_filter').on('click', function(e) {
                e.preventDefault();
                const selectedMonth = $('#filter_month').val();
                const selectedYear = $('#filter_year').val();

                // Panggil fungsi utama untuk memuat data baru
                loadDashboardData(selectedMonth, selectedYear);
            });


            // ================================
            // INISIALISASI
            // ================================

            // Panggil loadDashboardData saat halaman pertama kali dimuat
            loadDashboardData(
                $('#filter_month').val(),
                $('#filter_year').val()
            );
        });
    </script>
@endpush
