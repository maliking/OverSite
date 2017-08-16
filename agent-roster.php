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
        <link rel="stylesheet" href="./dist/css/vendor/footable.bootstrap.css">

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
                                    <table id="roster-table" class="table" data-editing-always-show="true">
                                        <tr>
                                            <th>Last</th>
                                            <th>First</th>
                                            <th>Commission</th>
                                        </tr>
                                        <?php
                                        foreach ($result as $agent) 
                                        {
                                            echo '<tr>';
                                            echo '<td>' . ucwords($agent['username']) . '</td>';
                                            echo '<td>' . ucwords($agent['username']) . '</td>';
                                            echo '<td>' . '0.2%' . '</td>';
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
        <div class="modal fade" id="editor-modal" tabindex="-1" role="dialog" aria-labelledby="editor-title">
            <style scoped>
                /* provides a red astrix to denote required fields - this should be included in common stylesheet */
                .form-group.required .control-label:after {
                    content:"*";
                    color:red;
                    margin-left: 4px;
                }
            </style>
            <div class="modal-dialog" role="document">
                <form class="modal-content form-horizontal" id="editor">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="editor-title">Add A New Agent</h4>
                    </div>
                    <div class="modal-body">
                        <input type="number" id="id" name="id" class="hidden"/>
                        <div class="form-group required">
                            <label for="firstName" class="col-sm-3 control-label">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="lastName" class="col-sm-3 control-label">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-3 control-label">Phone Number</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="phone" name="phone" placeholder="XXX-XXX-XXXX">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


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
                        addRow: function(){
                            $modal.removeData('row');
                            $editor[0].reset();
                            $editorTitle.text('Add a New Agent');
                            $modal.modal('show');
                        },                        
                        editRow: function(row){
                            var values = row.val();
                            $editor.find('#firstName').val(values.firstName);
                            $editor.find('#lastName').val(values.lastName);
                            $editor.find('#phone').val(values.phone);

                            $modal.data('row', row);
                            $editorTitle.text('Edit agent #' + values.firstName + " " + values.lastName);
                            $modal.modal('show');
                        },
                        deleteRow: function(row){
                            if (confirm('Are you sure you want to delete the row?')){
                                row.delete();
                            }
                        }
                    }
                }),
                uid = 10;

            $editor.on('submit', function(e){
                if (this.checkValidity && !this.checkValidity()) return;
                e.preventDefault();
                var row = $modal.data('row'),
                    values = {
                        firstName: $editor.find('#firstName').val(),
                        lastName: $editor.find('#lastName').val(),
                        jobTitle: $editor.find('#phone').val(),
                    };

                if (row instanceof FooTable.Row){
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
