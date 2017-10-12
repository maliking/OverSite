<?php
session_start();
//
//if (!isset($_SESSION['userId'])) {
//    header("Location: http://jjp17.org/login.php");
//}
?>
<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Re/Max Salinas | My Calendar</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="../dist/css/vendor/fullcalendar.min.css">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-agent/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->
</head>

<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">
    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-agent/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-agent/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Calendar
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Calendar</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-body no-padding">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /.wrapper -->

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-agent/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-agent/default-js.php" ?>
<!-- END TEMPLATE default-css.php INCLUDE -->

<!-- PAGE-SPECIFIC JS -->
<script src="../dist/js/vendor/moment-with-locales.min.js"></script>
<script src="../dist/js/vendor/fullcalendar/gcal.min.js"></script>
<script src="../dist/js/vendor/fullcalendar/fullcalendar.min.js"></script>

<script type='text/javascript'>

    $(document).ready(function () {
        $('#calendar').fullCalendar({
            googleCalendarApiKey: 'AIzaSyA9u-pNzVjk1MRKnIiryZku88WL_1eyF4Y',
            events: {
                googleCalendarId: 'markiepeanut111@gmail.com',
                color: 'yellow',   // an option!
                textColor: 'black' // an option!
            },
            editable: true,
            defaultView: 'agenda',
            duration: {days: 7}
            // can also specify:
            // - visibleRange
            // - dayCount
        });
    });

</script>
</body>
</html>
