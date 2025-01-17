@extends('layouts.dashboard')

@section('content')
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3">
            <div class="row">
                <div class="col-12 col-md-6 d-flex">
                    <div class="flex-fill border-0 illustration">
                        <div class="card-body p-1 d-flex flex-fill">
                            <div class="row g-0 w-100">
                                <div class="p-3 m-2">
                                    <h4>Welcome back, {{ Auth::user()->name }}!</h4>
                                    <p class="mb-0">Apa yang akan kamu lakukan?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mx-3">
                <!--Bar Chart-->
                <div class="card">
                    <div class="card-body">
                        <h4>Data Kunjungan Pasien</h4>
                        <form method="post" action="{{ url('/tech/dashboard')}}" id="filter-form">
                            @csrf
                            <div class="row">
                                <!-- <div class="col">
                            <label class="form-check-label mb-1">
                                Filter Berdasarkan:
                            </label>
                            <select class="form-control" id="year" name="year">
                                <option value="">Poli</option>
                                <option value="">Kabupaten</option>
                                <option value="">Percara-Bayar</option>
                                <option value="">2018</option>
                            </select>
                        </div> -->
                                <div class="col">
                                    <label for="year">Tahun</label>
                                    <select class="form-control" id="year" name="year">
                                        @foreach ($years as $year)
                                            <option value="{{ $year->year }}">{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <!-- Bulan -->
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkboxBulan"
                                                    data-bulan-checked="false" value="0">
                                                <label class="form-check-label">
                                                    Bulan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <select class="form-control" id="month" name="month" disabled>
                                                <option value="01">Januari</option>
                                                <option value="02">Februari</option>
                                                <option value="03">Maret</option>
                                                <option value="04">April</option>
                                                <option value="05">Mei</option>
                                                <option value="06">Juni</option>
                                                <option value="07">Juli</option>
                                                <option value="08">Agustus</option>
                                                <option value="09">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Triwulan -->
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="checkboxTriwulan"
                                            data-group="periode" name="triwulan">
                                        <label class="form-check-label">
                                            Triwulan
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="checkboxSemester"
                                            data-group="periode" name="semester">
                                        <label class="form-check-label">
                                            Semester
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="checkboxTahunan"
                                            data-group="periode" name="tahunan">
                                        <label class="form-check-label">
                                            Tahunan
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="checkboxSemua"
                                            data-group="periode" name="semua">
                                        <label class="form-check-label">
                                            Bulan Tertinggi
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary mt-4" id="submit">Tampilkan
                                        Grafik</button>
                                </div>
                                <!-- <div class="col">
                        <button type="button" onclick="downloadPDF()" class="btn btn-success mt-4 px-4 text-white" id="submit" name="print">
                            <img src="{{ asset('../images/icon-print.png') }}" alt="" width="20px" height="20px" style="margin-right: 10px;">
                            Print
                        </button>
                        </div> -->
                            </div>
                        </form>
                        <div class="divider"></div>
                    </div>
                    <div class="chart-container">
                        <canvas id="BarKunjungan" width="100px" height="45px"></canvas>
                    </div>
                </div>
            </div>

            <!--Section Card-->
            <div class="container-fluid">
                <div class="row w-100">
                    <div class="p-3 mt-4 mb-0">
                        <h4>Data Pengguna</h4>
                    </div>
                </div>
                <div class="row row-cols-lg-3 mt-4">
                    <!--Card Pasien-->
                    <a href="{{ route('pasien') }}">
                        <div class="col-12 d-flex">
                            <div class="card flex-fill border-0 kotak">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grown-1">
                                            <h5 class="mb-2">Jumlah Pasien</h5>
                                            <h4 class="mb-2">{{ $jumlah_pasien }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--Card Dokter-->
                    <a href="{{ route('data-dokter') }}">
                        <div class="col-12 d-flex">
                            <div class="card flex-fill border-0 kotak">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grown-1">
                                            <h5 class="mb-2">Jumlah Dokter</h5>
                                            <h4 class="mb-2">{{ $jumlah_dokter }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- Card Pegawai-->
                    <a href="{{ route('data-pegawai') }}">
                        <div class="col-12 d-flex">
                            <div class="card flex-fill border-0 kotak">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grown-1">
                                            <h5 class="mb-2">Jumlah Pegawai</h5>
                                            <h4 class="mb-2">{{ $jumlah_pegawai }}</h4>
                                            <div class="mb-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="row row-cols-lg-4 mt-4">
                    <div class="row w-100">
                        <div class="p-3 mt-0">
                            <h4>Data Pelayanan</h4>
                        </div>
                    </div>
                    <!--Card Poliklinik-->
                    <a href="{{ route('informasi-kamar') }}">
                        <div class="col-12 d-flex">
                            <div class="card flex-fill border-0 kotak">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grown-1">
                                            <h5 class="mb-2">Informasi Kamar</h5>
                                            <h4 class="mb-2">{{ $jumlah_kamar }}</h4>
                                            <div class="mb-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--Card IGD-->
                    <a href="{{ route('igd') }}">
                        <div class="col-12 d-flex">
                            <div class="card flex-fill border-0 kotak">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grown-1">
                                            <h5 class="mb-2">Jumlah IGD</h5>
                                            <h4 class="mb-2">{{ $jumlah_igd }}</h4>
                                            <div class="mb-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--Card Rawat Inap-->
                    <a href="{{ route('rawat-inap') }}">
                        <div class="col-12 d-flex">
                            <div class="card flex-fill border-0 kotak">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grown-1">
                                            <h5 class="mb-2">Jumlah Rawat Inap</h5>
                                            <h4 class="mb-2">{{ $jumlah_ranap }}</h4>
                                            <div class="mb-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--Card Kunjungan-->
                    <a href="{{ route('rawat-jalan') }}">
                        <div class="col-12 d-flex">
                            <div class="card flex-fill border-0 kotak">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grown-1">
                                            <h5 class="mb-2">Jumlah Rawat Jalan</h5>
                                            <h4 class="mb-2">{{ $jumlah_ralan }}</h4>
                                            <div class="mb-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script>
    // Simpan nilai-nilai filter saat halaman dimuat
    var yearSelect = document.getElementById('year');
    var monthSelect = document.getElementById('month');

    // Mengecek apakah ada nilai yang tersimpan di local storage
    var storedYear = localStorage.getItem('selectedYear');
    var storedMonth = localStorage.getItem('selectedMonth');

    // Jika ada nilai yang tersimpan, set nilai-nilai filter sesuai dengan nilai yang tersimpan
    if (storedYear) {
        yearSelect.value = storedYear;
    }

    if (storedMonth) {
        monthSelect.value = storedMonth;
    }

    // Menyimpan nilai-nilai filter saat berubah
    yearSelect.addEventListener('change', function () {
        localStorage.setItem('selectedYear', yearSelect.value);
    });

    monthSelect.addEventListener('change', function () {
        localStorage.setItem('selectedMonth', monthSelect.value);
    });
</script>

<script>
    // Dapatkan elemen checkbox
    var checkboxBulan = document.getElementById("checkboxBulan");
    var checkboxTriwulan = document.getElementById("checkboxTriwulan");
    var checkboxSemester = document.getElementById("checkboxSemester");
    var checkboxTahunan = document.getElementById("checkboxTahunan");
    var checkboxSemua = document.getElementById("checkboxSemua");

    // Dapatkan elemen daftar bulan
    var selectMonth = document.getElementById("month");
    // Dapatkan semua elemen checkbox periode
    var checkboxesPeriode = document.querySelectorAll('[data-group="periode"]');

    // Membuat sebuah objek yang menyimpan referensi ke checkbox dan kunci localStorage
    const checkboxes = {
        checkboxTahunan: "selectedCheckTahun",
        checkboxSemester: "selectedCheckSemester",
        checkboxTriwulan: "selectedCheckTriwulan",
        checkboxBulan: "selectedCheckBulan",
        checkboxSemua: "selectedCheckSemua"
    };

    // Fungsi untuk mengatur status checkbox berdasarkan input dari pengguna
    function setCheckboxStatus(checkbox, localStorageKey) {
        const storedValue = localStorage.getItem(localStorageKey);
        checkbox.checked = storedValue === "true";
        checkbox.addEventListener('change', function () {
            localStorage.setItem(localStorageKey, checkbox.checked);
            updateCheckboxStatus(checkbox);
        });
    }

    // Fungsi untuk memastikan hanya satu checkbox yang dapat dicentang
    function updateCheckboxStatus(changedCheckbox) {
        for (const key in checkboxes) {
            if (key !== changedCheckbox.id) {
                const checkbox = document.getElementById(key);
                checkbox.checked = false;
                localStorage.setItem(checkboxes[key], false);
            }
        }
    }

    // Inisialisasi checkbox
    for (const key in checkboxes) {
        setCheckboxStatus(document.getElementById(key), checkboxes[key]);
    }


    // Tambahkan pendengar perubahan ke semua checkbox periode
    checkboxesPeriode.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            // Jika checkbox periode ini dicentang, maka nonaktifkan kotak centang Bulan
            if (checkbox.checked) {
                checkboxesPeriode.forEach(function (otherCheckbox) {
                    if (otherCheckbox !== checkbox) {
                        otherCheckbox.checked = false;
                    }
                });
                // Nonaktifkan bulan
                checkboxBulan.checked = false;
                selectMonth.disabled = true;
            } else {
                // Aktifkan bulan jika tidak ada checkbox periode lain yang dicentang
                if (![...checkboxesPeriode].some(cb => cb.checked)) {
                    selectMonth.removeAttribute("disabled");
                }
            }
        });
    });

    // Tambahkan pendengar perubahan ke kotak centang Bulan
    checkboxBulan.addEventListener('change', function () {
        // Aktifkan atau nonaktifkan kotak centang periode sesuai dengan status checkbox Bulan
        checkboxesPeriode.forEach(function (otherCheckbox) {
            otherCheckbox.checked = false;
        });
        selectMonth.disabled = !checkboxBulan.checked;
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"
    integrity="sha512-q+4liFwdPC/bNdhUpZx6aXDx/h77yEQtn4I1slHydcbZK34nLaR3cAeYSJshoxIOq3mjEf7xJE8YWIUHMn+oCQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>

<script>
    var query = @json($query);
</script>

<script>
    (function ($) {
        $(document).ready(function () {
            var labels = Object.keys(query);
            var data = Object.values(query);
            var bulan = [
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

            var ctx = document.getElementById("BarKunjungan").getContext("2d");
            var ctx = document.getElementById("BarKunjungan").getContext("2d");
            BarKunjungan.ChartData(ctx, 'bar', labels, data, bulan);
        });

        const bgColor = {
            id: 'bgColor',
            beforeDraw: (chart, options) => {
                const { ctx, width, height } = chart;
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, width, height);
                ctx.restore();
            }
        };

        var BarKunjungan = {
            ChartData: function (ctx, type, labels, data, bulan) {
                new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: "Data Kunjungan Pasien",
                                data: data,
                                backgroundColor: '#96bfff',
                                borderWidth: 1,
                            },
                        ],
                    },
                    plugins: [bgColor],
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        maintainFontRatio: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            labels: {
                                render: 'value',
                            }
                        }
                    }
                });
            }
        };
    })(jQuery);
</script>

<script src="{{ asset('js/print.js') }}"></script>
@endsection