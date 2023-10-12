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
