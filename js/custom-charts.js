// Custom JS file for FURI Symposium
// Counter script in action here: https://codepen.io/Zu17/pen/mddWQjm

// Google Charts info is not jQuery, so no doc ready needed.
google.charts.load('current', { packages: ['corechart', 'bar'] });
// google.charts.setOnLoadCallback(drawBarChart);

// function drawBarChart() {
//     var data = google.visualization.arrayToDataTable([
//         [
//             'Research Topic',
//             'Project Count',
//             { role: 'style' },
//             { role: 'annotation' },
//         ],
//         ['Health', 53, 'color: #8c1d40', 'Health'],
//         ['Sustainability', 32, 'color: #ffc670', 'Sustainability'],
//         ['Energy', 35, 'color: #78BE20', 'Energy'],
//         ['Education', 15, 'color: #00A3E0', 'Education'],
//         ['Security', 17, 'color: #5C6670', 'Security'],
//         ['Data', 29, 'color: #222222', 'Security'],
//     ]);

//     var options = {
//         backgroundColor: '#c4c4c4',
//         chartArea: { width: '100%', height: '85%' },
//         legend: { position: 'none' },
//         vAxis: {
//             textPosition: 'none',
//         },
//         hAxis: {
//             viewWindow: {
//                 min: 0,
//                 max: 65,
//             },
//         },
//     };

//     var chart = new google.visualization.BarChart(
//         document.getElementById('subject-chart')
//     );

//     chart.draw(data, options);
// }

google.charts.setOnLoadCallback(mmmDonut);
function mmmDonut() {
    var data = google.visualization.arrayToDataTable([
        ['Response', 'Percentage'],
        ['Industry', 81],
        ['Obtaining an advanced degree', 50],
        ['Medical school / medicine', 10],
        ['Academia', 10],
        ['Government', 8],
        ['Non-profit / Other', 5],
        ['Startup Ventures', 2],
    ]);

    var options = {
        pieHole: 0.6,
        pieStartAngle: 160,
        colors: [
            '#8c1d40',
            '#ffc627',
            '#78BE20',
            '#00A3E0',
            '#ff7F32',
            '#222222',
            '#5C6670',
        ],
        chartArea: { width: '100%', height: '100%' },
        legend: {
            position: 'right',
            alignment: 'center',
            textStyle: {
                color: '#222222',
                fontSize: 24,
                fontWeight: 700,
            },
        },
    };

    var chart = new google.visualization.PieChart(
        document.getElementById('donutchart')
    );
    chart.draw(data, options);
}

jQuery(document).ready(function ($) {
    $('.counter').each(function () {
        var $this = $(this),
            countTo = $this.attr('data-count');

        $({ countNum: $this.text() }).animate(
            {
                countNum: countTo,
            },

            {
                duration: 2000,
                easing: 'linear',
                step: function () {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function () {
                    $this.text(this.countNum);
                    //alert('finished');
                },
            }
        );
    });
});
