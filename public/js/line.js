//Line Chart
const months = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];
const data_pengunjung = {
    labels: months,
    datasets: [
        {
            label: "Grafik Pengunjung Per Bulan",
            data: [65, 59, 80, 81, 56, 55, 40, 67, 56, 80, 69, 100],
            fill: false,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.3,
        },
    ],
};
const Line = {
    type: "line",
    data: data_pengunjung,
    option: {
        maintainAspectRatio: false,
        autoPadding: true,
    },
};

var lineChart = new Chart(document.getElementById("canvas-4"), Line);
