// Pie Chart
const data_pie = {
    labels: ["BPJS", "Jaminan", "Umum"],
    datasets: [
        {
            label: "Cara Bayar",
            data: [279, 134, 231],
            backgroundColor: [
                "rgb(255, 99, 132)",
                "rgb(54, 162, 235)",
                "rgb(255, 205, 86)",
            ],
            hoverOffset: 4,
        },
    ],
};

const Pie = {
    type: "pie",
    data: data_pie,
    option: {
        maintainAspectRatio: false,
        autoPadding: true,
    },
};

var pieChart = new Chart(document.getElementById("canvas-2"), Pie);
