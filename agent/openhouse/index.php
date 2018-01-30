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
    <title>RE/MAX Salinas | Open Houses</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-oh/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->
</head>

<body class="hold-transition skin-black sidebar-mini">
<!-- Site Wrapper -->
<div class="wrapper">
    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-oh/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-oh/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section>
        </section>
    </div>
</div>
<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-oh/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-oh/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

</body>

</html>
