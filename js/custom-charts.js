// Custom JS file for FURI Symposium
// Counter script in action here: https://codepen.io/Zu17/pen/mddWQjm

// Google Charts info is not jQuery, so no doc ready needed.
google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawBarChart);

function drawBarChart() {
    var data = google.visualization.arrayToDataTable([
        [
            'Research Topic',
            'Project Count',
            { role: 'style' },
            { role: 'annotation' },
        ],
        ['Health', 52, 'color: #8c1d40', 'Health'],
        ['Sustainability', 40, 'color: #78be20', 'Sustainability'],
        ['Energy', 22, 'color: #ff7f32', 'Energy'],
        ['Education', 8, 'color: #7c55a3', 'Education'],
        ['Security', 15, 'color: #00a3e0', 'Security'],
        ['Data', 32, 'color: #484848', 'Data'],
    ]);

    var options = {
        backgroundColor: '#fffff',
        height: 350,
        chartArea: { width: '90%', height: '90%' },
        legend: { position: 'none' },
        bar: { groupWidth: '75%' },
        vAxis: {
            fomat: 'short',
        },
    };

    var chart = new google.visualization.ColumnChart(
        document.getElementById('subject-chart')
    );

    chart.draw(data, options);
}

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
