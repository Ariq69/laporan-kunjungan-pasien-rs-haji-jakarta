var ChartBar;

(function ($) {
    $(document).ready(function () {
        var ctx = document.getElementById("canvas-3");
        Bar.ChartData(ctx);
    });

    var Bar = {
        ChartData: function (ctx) {
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: [
                        "Akupuntur",
                        "Anak",
                        "Bedah",
                        "Gigi & Mulut",
                        "Kebidanan",
                        "Jantung",
                        "Kulit & Kelamin",
                        "Mata",
                        "Paru",
                        "Penyakit Dalam",
                        "Syaraf",
                        "THT",
                        "Umum",
                    ],
                    datasets: [
                        {
                            label: "Data Dokter",
                            data: [
                                65, 59, 80, 81, 56, 55, 40, 76, 56, 87, 46, 78,
                                36,
                            ],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(255, 159, 64, 0.2)",
                                "rgba(255, 205, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(201, 203, 207, 0.2)",
                            ],
                            borderColor: [
                                "rgb(255, 99, 132)",
                                "rgb(255, 159, 64)",
                                "rgb(255, 205, 86)",
                                "rgb(75, 192, 192)",
                                "rgb(54, 162, 235)",
                                "rgb(153, 102, 255)",
                                "rgb(201, 203, 207)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        },
    };
})(jQuery);
