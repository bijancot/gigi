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
                            <div class="col-lg-4">
                                <div class="card savings-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Reports<span class="card-title-helper">30 Days</span></h5>
                                        <div class="savings-stats">
                                            <h5><?= empty($thisMonthReportTotal->total) ? "0" : number_format($thisMonthReportTotal->total) ?></h5>
                                            <span>Total reports for this month</span>
                                        </div>
                                        <div id="thismonthReportChart"></div>
                                    </div>
                                </div>
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
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="visitors-stats">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="visitors-stats-info">
                                                        <p>Total reports in the <?= date('Y') ?> period:</p>
                                                        <h5>77,871</h5>
                                                        <span>6-26 Apr</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div id="chart-visitors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="visitors-stats">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="visitors-stats-info">
                                                        <p>Average reports in the <?= date('Y') ?> period:</p>
                                                        <h5>77,871</h5>
                                                        <span>6-26 Apr</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div id="chart-visitors"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<script>
    $(document).ready(function() {

    var DrawSparkline = function() {
        $('#thismonthReportChart').sparkline([0, 34, 43, 35, 44, 45, 56, 37, 58], {
            type: 'line',
            width: '100%',
            height: '100',
            chartRangeMax: 50,
            lineColor: '#f78387',
            fillColor: 'rgba(247, 131, 135,.2)',
            highlightLineColor: 'transparent',
            highlightSpotColor: 'transparent',
            maxSpotColor: 'transparent',
            spotColor: 'transparent',
            minSpotColor: 'transparent',
            lineWidth: 3
        });
    };

    DrawSparkline();

    });
</script>