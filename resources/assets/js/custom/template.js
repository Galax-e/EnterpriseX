// Mainly scripts 
require('../../../../public/js/jquery-3.1.1.min.js');
require('../../../../public/js/bootstrap.min.js');
require('../../../../public/js/plugins/metisMenu/jquery.metisMenu.js');
require('../../../../public/js/plugins/slimscroll/jquery.slimscroll.min.js');

// jquery UI
require('../../../../public/js/plugins/jquery-ui/jquery-ui.min.js');
// Touch Punch - Touch Event Support for jQuery UI
require('../../../../public/js/plugins/touchpunch/jquery.ui.touch-punch.min.js');
// Custom and plugin javascript
require('../../../../public/js/inspinia.js');
require('../../../../public/js/plugins/pace/pace.min.js');

// Flot
require('../../../../public/js/plugins/flot/jquery.flot.js');
require('../../../../public/js/plugins/flot/jquery.flot.tooltip.min.js');
require('../../../../public/js/plugins/flot/jquery.flot.spline.js');
require('../../../../public/js/plugins/flot/jquery.flot.resize.js');
require('../../../../public/js/plugins/flot/jquery.flot.pie.js');

// Piety
require('../../../../public/js/plugins/peity/jquery.peity.min.js');
require('../../../../public/js/demo/peity-demo.js');

// Gritter
require('../../../../public/js/plugins/gritter/jquery.gritter.min.js');

// Sparkline
require('../../../../public/js/plugins/sparkline/jquery.sparkline.min.js');
// Sparkline demo data
require('../../../../public/js/demo/sparkline-demo.js');

// ChartJS
require('../../../../public/js/plugins/chartJs/Chart.min.js');

// Toastr
require('../../../../public/js/plugins/toastr/toastr.min.js');


$(document).ready(function() {
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

    }, 1300);


    var data1 = [
        [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
    ];
    var data2 = [
        [0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
    ];
    $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
        data1, data2
    ],
            {
                series: {
                    lines: {
                        show: false,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#d5d5d5'
                },
                colors: ["#1ab394", "#1C84C6"],
                xaxis:{
                },
                yaxis: {
                    ticks: 4
                },
                tooltip: false
            }
    );

    var doughnutData = {
        labels: ["App","Software","Laptop" ],
        datasets: [{
            data: [300,50,100],
            backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
        }]
    } ;


    var doughnutOptions = {
        responsive: false,
        legend: {
            display: false
        }
    };


    var ctx4 = document.getElementById("doughnutChart").getContext("2d");
    new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

    var doughnutData = {
        labels: ["App","Software","Laptop" ],
        datasets: [{
            data: [70,27,85],
            backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
        }]
    } ;


    var doughnutOptions = {
        responsive: false,
        legend: {
            display: false
        }
    };


    var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
    new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

});


(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-4625583-2', 'webapplayers.com');
ga('send', 'pageview');
