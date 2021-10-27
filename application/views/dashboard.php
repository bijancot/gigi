<?php 
    $day = "";
    $total = "";
    foreach ($thisMonthReportChart as $item) {
        $temp_day = $item->day;
        $day .= "'Day $temp_day'" . ", ";
        $temp_total = $item->total;
        $total .= "$temp_total" . ", ";
    }
    $month = "";
    $year_total = "";
    foreach ($thisYearReportChart as $item) {
        $temp_month = $item->month;
        $month .= "'$temp_month'" . ", ";
        $temp_total = $item->total;
        $year_total .= "$temp_total" . ", ";
    }
    $cancelDay = "";
    $cancel_total = "";
    foreach ($avgCanceledReportsChart as $item) {
        $temp_cancelDay = $item->day;
        $cancelDay .= "'Day $temp_cancelDay'" . ", ";
        $temp_cancel = $item->total;
        $cancel_total .= "$temp_cancel" . ", ";
    }
?>
                    <div class="main-wrapper">
                        <div class="row stats-row">
                            <div class="col-lg-3 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title"><?= empty($users->total) ? "0" : number_format($users->total) ?></h5>
                                            <p class="stats-text">Total of Users</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">people</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title"><?= empty($ongoingReports->total) ? "0" : number_format($ongoingReports->total) ?></h5>
                                            <p class="stats-text">Total of Ongoing Reports</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">description</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title"><?= empty($finishedReports->total) ? "0" : number_format($finishedReports->total) ?></h5>
                                            <p class="stats-text">Total of Finished Reports</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">task_alt</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title"><?= empty($canceledReports->total) ? "0" : number_format($canceledReports->total) ?></h5>
                                            <p class="stats-text">Total of Canceled Reports</p>
                                        </div>
                                        <div class="stats-icon change-danger">
                                            <i class="material-icons">cancel</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card top-products">
                                    <div class="card-body">
                                        <h5 class="card-title">Latest Reports<span class="card-title-helper">Today</span></h5>
                                        <div class="top-products-list">
                                            <?php 
                                                foreach ($todayReports as $item) {
                                                    if ($item->category == 'day') {
                                                        $icon = 'light_mode';
                                                    } else {
                                                        $icon = 'dark_mode';
                                                    }
                                                    echo '
                                                        <div class="product-item">
                                                            <h5>'.$item->name.'</h5>
                                                            <span>Day '.$item->day.'</span>
                                                            <i class="material-icons product-item-status">'.$icon.'</i>
                                                        </div>
                                                    ';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Canceled Reports</h5>
                                        <div class="savings-stats">
                                            <h5>Day <?= empty($avgCanceledReports->avg) ? "0" : number_format($avgCanceledReports->avg) ?></h5>
                                            <p>Average Users Canceled Reports.</p>
                                        </div>
                                        <div id="canceledReportChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card savings-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Monthly Reports<span class="card-title-helper"><?= date('t') ?> Days</span></h5>
                                        <div class="savings-stats">
                                            <h5><?= empty($thisMonthReportTotal->total) ? "0" : number_format($thisMonthReportTotal->total) ?></h5>
                                            <span>Total Reports for <?= date('F') ?>:</span>
                                        </div>
                                        <div id="thisMonthReportChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card savings-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Yearly Reports</h5>
                                        <div class="savings-stats">
                                            <h5><?= empty($thisYearReportTotal->total) ? "0" : number_format($thisYearReportTotal->total) ?></h5>
                                            <p>Total Reports in the <?= date('Y') ?> period:</p>
                                        </div>
                                        <div id="thisYearReportChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<script>
    $(document).ready(function() {
        // Canceled Report
        var options = {
             series: [{
                 name: "Total",
                 data: [<?= $cancel_total ?>]
             }],
             chart: {
                 type: 'area',
                 height: 270,
                 zoom: {
                    autoScaleYaxis: true
                    },
                 toolbar: {
                     show: false
                 }
             },
             dataLabels: {
                 enabled: false
             },
             markers: {
                size: 0,
                style: 'hollow'
            },
             xaxis: {
                 categories: [<?= $cancelDay ?>],
                 tickAmount: 6,
                 axisBorder: {
                    show: true,
                    color: 'transparent'
                    },
                    labels: {
                    style: {
                        colors: 'rgba(94, 96, 110, .5)'
                    }
                }
             },
             stroke: {
                curve: 'smooth',
                width: 3,
                color: '#000'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0,
                    opacityFrom: .6,
                    opacityTo: .2,
                    colors: ['#5FD0A5'],
                    stops: [0, 100]
                }
            },
            grid: {
                borderColor: 'rgba(94, 96, 110, .5)',
                strokeDashArray: 4
            },
             colors:['#5FD0A5'],
             yaxis: {
                 labels: {
                     formatter: function(val) {
                         return val.toFixed(0)
                     }
                 }
             }
         };
         var chart = new ApexCharts(document.querySelector("#canceledReportChart"), options);
         chart.render();

        // Monthly Report
        var options = {
             series: [{
                 name: "Total",
                 data: [<?= $total ?>]
             }],
             chart: {
                 type: 'area',
                 height: 300,
                 zoom: {
                    autoScaleYaxis: true
                    },
                 toolbar: {
                     show: false
                 }
             },
             dataLabels: {
                 enabled: false
             },
             markers: {
                size: 0,
                style: 'hollow'
            },
             xaxis: {
                 categories: [<?= $day ?>],
                 tickAmount: 6,
                 axisBorder: {
                    show: true,
                    color: 'transparent'
                    },
                    labels: {
                    style: {
                        colors: 'rgba(94, 96, 110, .5)'
                    }
                },
             },
             stroke: {
                curve: 'smooth',
                width: 3,
                color: '#000'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0,
                    opacityFrom: .6,
                    opacityTo: .2,
                    colors: ['#5FD0A5'],
                    stops: [0, 100]
                }
            },
            grid: {
                borderColor: 'rgba(94, 96, 110, .5)',
                strokeDashArray: 4
            },
             colors:['#5FD0A5'],
             yaxis: {
                 labels: {
                     formatter: function(val) {
                         return val.toFixed(0)
                     }
                 }
             }
         };
         var chart = new ApexCharts(document.querySelector("#thisMonthReportChart"), options);
         chart.render();

         // This Year Report
         var options = {
             series: [{
                 name: "Total",
                 data: [<?= $year_total ?>]
             }],
             chart: {
                 type: 'area',
                 height: 300,
                 zoom: {
                    autoScaleYaxis: true
                    },
                 toolbar: {
                     show: false
                 }
             },
             dataLabels: {
                 enabled: false
             },
             markers: {
                size: 0,
                style: 'hollow'
            },
             xaxis: {
                 categories: [<?= $month ?>],
                 tickAmount: 6,
                 axisBorder: {
                    show: true,
                    color: 'transparent'
                    },
                    labels: {
                    style: {
                        colors: 'rgba(94, 96, 110, .5)'
                    }
                }
             },
             stroke: {
                curve: 'smooth',
                width: 3,
                color: '#000'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0,
                    opacityFrom: .6,
                    opacityTo: .2,
                    colors: ['#5FD0A5'],
                    stops: [0, 100]
                }
            },
            grid: {
                borderColor: 'rgba(94, 96, 110, .5)',
                strokeDashArray: 4
            },
             colors:['#5FD0A5'],
             yaxis: {
                 labels: {
                     formatter: function(val) {
                         return val.toFixed(0)
                     }
                 }
             }
         };
         var chart = new ApexCharts(document.querySelector("#thisYearReportChart"), options);
         chart.render();

    });
</script>