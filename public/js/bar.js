let chart; // Gunakan 'chart' dengan huruf kecil, bukan 'Chart' dengan huruf besar.

function getData() {
    $.ajax({
        url: '/bar-chart-data',
        method: 'GET',
        dataType: 'json',
        data: {
            'from': $("#from").val(),
            'to': $("#to").val(),
        },
        success: function (data) {
            const kunjunganData = data.kunjunganData;

            const ctx = document.getElementById('canvas-1').getContext('2d');

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [""],
                    datasets: [{ // Ganti 'dataset' menjadi 'datasets' dan 'lable' menjadi 'label'
                        label: 'Total Kunjungan Pasien', // Ganti 'lable' menjadi 'label'
                        data: [kunjunganData.terdaftar],
                        backgroundColor: ['rgb(255, 99, 132)', 'rgb(75, 192, 192)', 'rgb(54, 162, 235)'], // Ganti ',' dengan tanda koma
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Ganti 'maintainAspectRation' menjadi 'maintainAspectRatio'
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
}




// let Chart;

// function getData(){
//     $.ajax({
//         url: '/bar-chart-data',
//         method: 'GET',
//         dataType: 'json',
//         data: {
//             'from': $("#from").val(),
//             'to':$("#to").val(),
//         },
//         success: function(data) {
//             const kunjunganData = data.kunjunganData;

//             const ctx = document.getElementById('canvas-1').getContext('2d');

//             if (chart) {
//                 chart.destroy();
//             }

//             chart = new Chart(ctx,{
//                 type:'bar',
//                 data:{
//                     labels:[""],
//                     dataset:[{
//                         lable:'Total Kunjungan Pasien',
//                         data:[kunjunganData.terdaftar],
//                         backgroundColor:['rgb(255,99,132)','rgb(75,192,192)','rgb(54,162.235)'],
//                         borderWidth: 1,
//                     }]
//                 },
//                 options: {
//                     responsive: true,
//                     maintainAspectRation: false,
//                     scales: {
//                         y: {
//                             beginAtZero: true
//                         }
//                     }
//                 }
//             })
//         },
//         error: function(error){
//             console.log(error);
//         }
//     })
// }
function drawBarChart(data, labels) {
    var ctx = document.getElementById("canvas-3").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Data Dokter",
                    data: data,
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
}

document.addEventListener("DOMContentLoaded", function () {
    drawBarChart(data, labels);
});

// var ChartBar;

// (function ($) {
//     $(document).ready(function () {
//         var ctx = document.getElementById("canvas-3");
//         Bar.ChartData(ctx);
//     });

//     var Bar = {
//         ChartData: function (ctx) {
//             new Chart(ctx, {
//                 type: "bar",
//                 data: {
//                     labels: [
//                         "Akupuntur",
//                         "Anak",
//                         "Bedah",
//                         "Gigi & Mulut",
//                         "Kebidanan",
//                         "Jantung",
//                         "Kulit & Kelamin",
//                         "Mata",
//                         "Paru",
//                         "Penyakit Dalam",
//                         "Syaraf",
//                         "THT",
//                         "Umum",
//                     ],
//                     datasets: [
//                         {
//                             label: "Data Dokter",
//                             data: [
//                                 65, 59, 80, 81, 56, 55, 40, 76, 56, 87, 46, 78,
//                                 36,
//                             ],
//                             backgroundColor: [
//                                 "rgba(255, 99, 132, 0.2)",
//                                 "rgba(255, 159, 64, 0.2)",
//                                 "rgba(255, 205, 86, 0.2)",
//                                 "rgba(75, 192, 192, 0.2)",
//                                 "rgba(54, 162, 235, 0.2)",
//                                 "rgba(153, 102, 255, 0.2)",
//                                 "rgba(201, 203, 207, 0.2)",
//                             ],
//                             borderColor: [
//                                 "rgb(255, 99, 132)",
//                                 "rgb(255, 159, 64)",
//                                 "rgb(255, 205, 86)",
//                                 "rgb(75, 192, 192)",
//                                 "rgb(54, 162, 235)",
//                                 "rgb(153, 102, 255)",
//                                 "rgb(201, 203, 207)",
//                             ],
//                             borderWidth: 1,
//                         },
//                     ],
//                 },
//                 options: {
//                     scales: {
//                         y: {
//                             beginAtZero: true,
//                         },
//                     },
//                 },
//             });
//         },
//     };
// })(jQuery);
