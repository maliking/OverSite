<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT username FROM  UsersInfo";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Roster</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-admin/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <!-- PAGE-SPECIFIC CSS -->
        <link rel="stylesheet" href="./dist/css/vendor/footable.bootstrap.min.css">

    </head>

    <body class="hold-transition skin-blue-light sidebar-mini">
        <!-- Site Wrapper -->
        <div class="wrapper">
            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "./templates-admin/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "./templates-admin/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->
            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Agent Roster
                    </h1>
                    <ol class="breadcrumb">
                        <li>Properties</li>
                        <li class="active"><a href="#"><i class="fa fa-archive"></i> Current Inventory</a></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-body no-padding">
                                    <table id="roster-table" class="table table-striped">
                                        <tr>
                                            <th>Last</th>
                                            <th>First</th>
                                            <th>Commission</th>

                                        </tr>
                                        <?php
    foreach ($result as $agent) {
        echo '<tr>';
        echo '<td>' . ucwords($agent['username']) . '</td>';
        echo '<td>' . ucwords($agent['username']) . '</td>';
        echo '<td>' . '<span>0.2%</span>' . '</td>';
        echo '</tr>';
    }
                                        ?>

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
                <!-- /.content -->
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
<script src="./dist/js/vendor/footable.min.js"></script>

<script>
            var $modal = $('#editor-modal'),
                $editor = $('#editor'),
                $editorTitle = $('#editor-title'),
                ft = FooTable.init('#roster-table', {
                    editing: {
                        enabled: true,
                        alwaysShow: true,
                        addRow: function () {
                            $modal.removeData('row');
                            $editor[0].reset();
                            $editorTitle.text('Add a New Agent');
                            $modal.modal('show');
                        },
                        editRow: function (row) {
                            var values = row.val();
                            $editor.find('#id').val(values.id);
                            $editor.find('#address').val(values.firstName);
                            $editor.find('#city').val(values.lastName);
                            $editor.find('#zip').val(values.jobTitle);
                            $editor.find('#bedrooms').val(values.startedOn);
                            $editor.find('#bathrooms').val(values.dob);
                            $editor.find('#sqft').val(values.dob);
                            $editor.find('#lot').val(values.dob);
                            $editor.find('#price').val(values.dob);
                            $editor.find('#dom').val(values.dob);
                            $modal.data('row', row);
                            $editorTitle.text('Edit' + values.id);
                            $modal.modal('show');
                        },
                        deleteRow: function (row) {
                            if (confirm('Are you sure you want to delete the row?')) {
                                row.delete();
                            }
                        }
                    }
                }),
                uid = 10;

            $editor.on('submit', function (e) {
                if (this.checkValidity && !this.checkValidity())
                    return;
                e.preventDefault();
                var row = $modal.data('row'),
                    values = {
                        id: $editor.find('#id').val(),
                        address: $editor.find('#address').val(),
                        city: $editor.find('#city').val(),
                        zip: $editor.find('#zip').val(),
                        bedrooms: $editor.find('#bedrooms').val(),
                        bathrooms: $editor.find('#bathrooms').val(),
                        sqft: $editor.find('#sqft').val(),
                        lot: $editor.find('#lot').val(),
                        price: $editor.find('#price').val(),
                        dom: $editor.find('#dom').val(),

                    };

                if (row instanceof FooTable.Row) {
                    row.val(values);
                } else {
                    values.id = uid++;
                    ft.rows.add(values);
                }
                $modal.modal('hide');
            });
        </script>
    </body>

</html>
