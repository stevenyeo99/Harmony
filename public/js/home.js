$(document).ready(function() {
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallBack(drawChart);
});

$(window).resize(function() {
    drawChart();
});

function drawChart() {
    $.ajax({
        url: "",
        method: "GET",
        success: function(analytic) {
            var data = google.visualization.arrayToDataTable(analytic);
            var options = {
                title: 'Buy Sell Status',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('linechart'));
            chart.draw(data, options);
        }, fail: function(data) {
            console.log('need to be maintanance!');
        }
    });
}