<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Analytics</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->
</head>

<body class="hold-transition skin-black sidebar-mini">
<!-- Site Wrapper -->
<div class="wrapper">
    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-admin/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-admin/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Analytics
            </h1>
            <ol class="breadcrumb">
                <li>Statistics</li>
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Analytics</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">YTD Monthly Net Earnings</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                    <!-- BAR CHART -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Buyer's Listing vs. Seller's Listing</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->
        </section>
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /.wrapper -->

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-admin/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->


<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-admin/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<!-- PAGE-SPECIFIC JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>

<script>
    /*
     * CHART JS CONTROLS
     * -----------------------
     */

    // Line Chart - YTD Monthly Net Earnings
    var lineChartCanvas = document.getElementById("lineChart");

    var lineChartData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: '2017',
            data: [103940, 123023, 123023, 102934, 121234, 112039, 103942, 120393, 109234, 102384, 122402, 122012],
            backgroundColor: 'rgba(1, 195, 32, 0.72)'
        }, {
            label: '2016',
            data: [124343, 102934, 129482, 103824, 129271, 103982, 102934, 110232, 112902, 102412, 113304, 129023],
            backgroundColor: 'rgba(81, 89, 73, 0.4)'
        }]
    }

    var lineChartOptions = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: false,
                    max: 150000,
                    callback: function (value, index, values) {
                        if (parseInt(value) >= 1000) {
                            return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } else {
                            return '$' + value;
                        }
                    }

                }
            }]
        }
    }

    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    });
</script>

<script>
    var barChartCanvas = document.getElementById("barChart");
    var myChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Buyer\'s',
                data: [504923, 340242, 402492, 604923, 400232, 360234, 504934, 604394, 540942, 604343, 405923, 503239],
                backgroundColor: "rgba(220,220,220,0.5)",
            }, {
                label: 'Seller\'s',
                data: [604032, 402392, 503924, 590423, 429321, 498243, 552843, 623203, 502934, 598493, 450294, 559823],
                backgroundColor: "rgba(82,154,190,0.5)",
            }]
        },
        options: {
            tooltips: {
                mode: 'label',
                callbacks: {
                    afterTitle: function () {
                        window.total = 0;
                    },
                    label: function (tooltipItem, data) {
                        var corporation = data.datasets[tooltipItem.datasetIndex].label;
                        var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        window.total += valor;
                        return corporation + ": $" + valor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    },
                    footer: function () {
                        return "Total: $" + window.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            },
            scales: {
                yAxes: [{
                    beginAtZero: false,
                    stacked: true,
                    ticks: {
                        beginAtZero: false,
                        callback: function (value, index, values) {
                            if (parseInt(value) >= 1000) {
                                return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } else {
                                return '$' + value;
                            }
                        }
                    },
                }],
                xAxes: [{
                    stacked: true
                }],
            }
        }
    });
</script>
</body>

</html>
