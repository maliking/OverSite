<?php
//session_start();
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
        <title>Re/Max Salinas | My Visitors</title>

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
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3>My Visitors</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th data-breakpoints="all">Phone</th>
                                                <th data-breakpoints="all">Email</th>
                                                <th data-breakpoints="xs sm">Property Viewed</th>
                                                <th data-breakpoints="xs sm">Contact</th>
                                                <th colspan="2" data-breakpoints="all">Notes</th>
                                                <th data-breakpoints="xs sm">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>Patty Hershang</td>
                                            <td>831-382-4833</td>
                                            <td>phershang@gmail.com</td>
                                            <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                            <td>
                                                <button>Call</button>
                                                <button>Text</button>
                                                <button>Forward Listing Flyer</button>
                                            </td>
                                            <td><button>View</button></td>
                                            <td>
                                                <button>Add</button>
                                                <button>Edit</button>
                                            </td>
                                            <td>
                                                <button class="fa fa-trash-o">  </button>
                                        </tbody>
                                        <tbody>
                                            <td>Peter Harris</td>
                                            <td>831-239-6289</td>
                                            <td>pharris23@gmail.com</td>



                                            <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                            <td>
                                                <button>Call</button>
                                                <button>Text</button>
                                                <button>Forward Listing Flyer</button>
                                            </td>
                                            <td> <button>View</button></td>
                                            <td>
                                                <button>Add</button>
                                                <button>Edit</button>
                                            </td>
                                            <td>
                                                <button class="fa fa-trash-o">  </button>
                                        </tbody>
                                        <tbody>
                                            <td>Tony Craver</td>
                                            <td>831-588-0444</td>
                                            <td>tcraver@yahoo.com</td>
                                            <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                            <td>
                                                <button>Call</button>
                                                <button>Text</button>
                                                <button>Forward Listing Flyer</button>
                                            </td>
                                            <td><button>View</button></td>
                                            <td>
                                                <button>Add</button>
                                                <button>Edit</button>

                                            </td>
                                            <td>
                                                <button class="fa fa-trash-o">  </button>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
            </div>

            <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
            <?php include "./templates-oh/default-footer.php" ?>
            <!-- END TEMPLATE default-footer.php INCLUDE -->

            <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
            <?php include "./templates-oh/default-js.php" ?>
            <!-- END TEMPLATE default-js.php INCLUDE -->
            </body>

        </html>
