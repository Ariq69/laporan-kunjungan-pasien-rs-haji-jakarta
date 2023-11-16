@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
<div class="container-fluid">
    <div class="mb-3 mt-3">
        <div class="row">
            <section class="haji-breadcrumbs">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('pasien') }}">Pasien</a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            Pasien Per Dokter
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <div class="container-fluid">
            <div class="row align-items-start">
                <!--Jumlah Pasien Per Poli-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Pasien Per Dokter</h5>
                            <form method="post" action="{{ url('/tech/pasien-perdokter') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <label for="year">Tahun</label>
                                            <select class="form-control" id="year" name="year">
                                                @foreach ($years as $year)
                                                    <option value="{{ $year->year }}">{{ $year->year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkboxBulan" data-bulan-checked="false" value="0">
                                                <label class="form-check-label">
                                                    Bulan
                                                </label>
                                        </div>
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
                                                <!-- Tambahkan pilihan bulan lainnya -->
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="poliklinik">Poliklinik</label>
                                            <select class="form-control" id="poliklinik" name="poliklinik">
                                                @foreach ($poliklinik as $poli)
                                                    <option value="{{ $poli->nm_poli }}">{{ $poli->nm_poli }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="dokter">Dokter</label>
                                            <select class="form-control" id="dokter" name="dokter">
                                                @foreach ($d as $dok)
                                                    <option value="{{ $dok->nm_dokter }}">{{ $dok->nm_dokter }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="checkboxTriwulan" data-group="periode" name="triwulan">
                                            <label class="form-check-label">
                                                Triwulan
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="checkboxSemester" data-group="periode" name="semester">
                                            <label class="form-check-label">
                                                Semester
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="checkboxTahunan" data-group="periode" name="tahunan">
                                            <label class="form-check-label">
                                                Tahunan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary mt-3">Tampilkan Grafik</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="divider"></div>
                            <div class="chart-container">
                                <canvas id="BarChartSumPasien" width="100px" height="45px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        var yearSelect = document.getElementById('year');
        var monthSelect = document.getElementById('month');
        var poliSelect = document.getElementById('poliklinik');
        var dokSelect = document.getElementById('dokter');

        var storedYear = localStorage.getItem('selectedYear');
        var storedMonth = localStorage.getItem('selectedMonth');
        var storedPoli = localStorage.getItem('selectedPoli');
        var storedDok = localStorage.getItem('selectedDok');

        if (storedYear) {
            yearSelect.value = storedYear;
        }

        if (storedMonth) {
            monthSelect.value = storedMonth;
        }

        if (storedPoli) {
            poliSelect.value = storedPoli;
        }

        if (storedDok) {
            dokSelect.value = storedDok;
        }

        yearSelect.addEventListener('change', function() {
            localStorage.setItem('selectedYear', yearSelect.value);
        });

        monthSelect.addEventListener('change', function() {
            localStorage.setItem('selectedMonth', monthSelect.value);
        });

        poliSelect.addEventListener('change', function() {
            localStorage.setItem('selectedPoli', poliSelect.value);
        });

        dokSelect.addEventListener('change', function() {
            localStorage.setItem('selectedDok', dokSelect.value);
        });
    });
</script>

<script>
        // Dapatkan elemen checkbox
        var checkboxBulan = document.getElementById("checkboxBulan");
        var checkboxTriwulan = document.getElementById("checkboxTriwulan");
        var checkboxSemester = document.getElementById("checkboxSemester");
        var checkboxTahunan = document.getElementById("checkboxTahunan");
        
        // Dapatkan elemen daftar bulan
        var selectMonth = document.getElementById("month");
        // Dapatkan semua elemen checkbox periode
        var checkboxesPeriode = document.querySelectorAll('[data-group="periode"]');

        // Membuat sebuah objek yang menyimpan referensi ke checkbox dan kunci localStorage
        const checkboxes = {
            checkboxTahunan: "selectedCheckTahun",
            checkboxSemester: "selectedCheckSemester",
            checkboxTriwulan: "selectedCheckTriwulan",
            checkboxBulan: "selectedCheckBulan"
        };

        // Fungsi untuk mengatur status checkbox berdasarkan input dari pengguna
        function setCheckboxStatus(checkbox, localStorageKey) {
            const storedValue = localStorage.getItem(localStorageKey);
            checkbox.checked = storedValue === "true";
            checkbox.addEventListener('change', function() {
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
        checkboxesPeriode.forEach(function(checkbox) {
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

<script>
    var queryDokter = @json($queryDokter);
</script>

<script>
(function($) {
    $(document).ready(function() {
        var labels = Object.keys(queryDokter);
        var data = Object.values(queryDokter);
        //console.log(labels);
        var ctx = document.getElementById("BarChartSumPasien").getContext("2d");
        BarChartSumPasien.ChartData(ctx, 'bar', labels, data);
    });

    var BarChartSumPasien = {
        ChartData: function(ctx, type, labels, data) {
            new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Data Pasien",
                            data: data,
                            backgroundColor: [
                                '#FF8080',
                                '#F9B572',
                                '#F6FDC3',
                                '#C8E4B2',
                                '#FFD966',
                                '#94AF9F',
                                '#C8FFD4',
                                '#B8E8FC',
                                '#B1AFFF',
                                '#7895B2',
                                '#554994',
                                '#6E85B7',
                                '#C9BBCF',
                                '#73A9AD',
                                '#525E75',
                                '#655D8A',
                                '#BB6464',
                                '#A267AC',
                                '#867070',
                                '#6096B4',
                                '#DEBACE',
                                '#B3A492',
                                '#219C90',
                                '#9EB384',
                                '#FFC95F',
                                '#0E21A0',
                                '#9D44C0',
                                '#FF7676',
                                '#3085C3',
                                '#5CD2E6',
                                '#5C4B99',
                                '#D71313',
                                '#45CFDD',
                                '#22A699',
                                '#245953',
                                '#913175',
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        labels: {
                            render: 'value',
                        },
                    },
                },
            });
        },
    };
})(jQuery);
</script>
@endsection

