<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT HouseInfo.address, HouseInfo.city, HouseInfo.zip, HouseInfo.bedrooms, HouseInfo.bathrooms, HouseInfo.price FROM HouseInfo
  INNER JOIN commInfo ON HouseInfo.houseId = commInfo.houseId";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Past Sales</title>

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
                        Past Sales
                    </h1>
                    <ol class="breadcrumb">
                        <li>Properties</li>
                        <li class="active"><a href="#"><i class="fa fa-archive"></i> Past Sales</a></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                    <table id="listing-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="10">
                                                    <div class="pull-right">
                                                        <div class="dropdown" style="display: inline-block">
                                                            <button class="btn dropdown-toggle btn-xs btn-warning" type="button" data-toggle="dropdown">Filter Price <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li style="display: flex">
                                                                    <div id="min-box" style="display: flex-item; padding-left: 7px; padding-right: 7px; padding-top: 6px">
                                                                        <input type="text" placeholder="min" style="padding: 3px;" size="10">
                                                                    </div>
                                                                    <p style="padding-top: 10px">-</p>
                                                                    <div id="max-box" style="display: flex-item; padding-right: 7px; padding-left: 7px; padding-top: 6px">
                                                                        <input type="text" placeholder="max" style="padding: 3px;" size="10">
                                                                    </div>
                                                                </li>
                                                                <div class="divider"></div>
                                                                <li><a href="#">$50,000+</a></li>
                                                                <li><a href="#">$75,000+</a></li>
                                                                <li><a href="#">$100,000+</a></li>
                                                                <li><a href="#">$150,000+</a></li>
                                                                <li><a href="#">$200,000+</a></li>
                                                                <li><a href="#">$250,000+</a></li>
                                                                <li><a href="#">$300,000+</a></li>
                                                                <li><a href="#">$400,000+</a></li>
                                                                <li><a href="#">$500,000+</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="dropdown" style="display: inline-block;margin-right: 10px;">
                                                            <button class="btn dropdown-toggle btn-xs btn-success" type="button" data-toggle="dropdown">Filter Bedrooms <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#">0+</a></li>
                                                                <li><a href="#">1+</a></li>
                                                                <li><a href="#">2+</a></li>
                                                                <li><a href="#">3+</a></li>
                                                                <li><a href="#">4+</a></li>
                                                                <li><a href="#">5+</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>Zip</th>
                                                <th><i class="fa fa-bed"></i></th>
                                                <th><i class="fa fa-bath"></i></th>
                                                <th>Sqft</th>
                                                <th>Lot</th>
                                                <th>Price</th>
                                                <th>DOM <a href="#" data-toggle="tooltip" data-placement="top" title="Days on the market"><i class="fa fa-question-circle"></i></a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($result as $house) {
                                                    echo "<tr>";
                                                    echo "<td>" . $house['address'] . "</td>";
                                                    echo "<td>" . $house['city'] . "</td>";
                                                    echo "<td>" . $house['zip'] . "</td>";
                                                    echo "<td>" . $house['bedrooms'] . "</td>";
                                                    echo "<td>" . $house['bathrooms'] . "</td>";
                                                    echo "<td>" . "NA" . "</td>";
                                                    echo "<td>" . "NA" . "</td>";
                                                    echo "<td>" . '$' . number_format($house['price'], 0) . "</td>";
                                                    echo "<td>" . "NA" . "</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
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
                        <h4 class="modal-title" id="editor-title">Add Row</h4>
                    </div>
                    <div class="modal-body">
                        <input type="number" id="id" name="id" class="hidden"/>
                        <div class="form-group required">
                            <label for="address" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" name="address" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="city" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zip" class="col-sm-3 control-label">Zip</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="Job Title">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="bedrooms" class="col-sm-3 control-label">Bedrooms</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="bedrooms" name="bedrooms" placeholder="Started On" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bathrooms" class="col-sm-3 control-label">Bathrooms</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sqft" class="col-sm-3 control-label">Sqft</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="sqft" name="sqft" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lot" class="col-sm-3 control-label">Lot Size</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="lot" name="lot" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="price" name="price" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dom" class="col-sm-3 control-label">DOM <a href="#" data-toggle="tooltip" data-placement="top" title="Days on the market"><i class="fa fa-question-circle"></i></a></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="dom" name="dom" placeholder="Date of Birth">
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
                ft = FooTable.init('#listing-table', {
                    editing: {
                        enabled: true,
                        alwaysShow: true,
                        addRow: function () {
                            $modal.removeData('row');
                            $editor[0].reset();
                            $editorTitle.text('Add a new row');
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
                            $editorTitle.text('Edit row #' + values.id);
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
