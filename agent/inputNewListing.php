<?php

require("../databaseConnection.php");
session_start();
$dbConn = getConnection();

if (!isset($_SESSION['userId'])) {
    header("Location: http://www.oversite.cc/login.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | New Listing</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-agent/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="../dist/css/vendors/footable.bootstrap.min.css">
    <style>

        .gallery{
            height: 400px;
            overflow: auto; /* Or scroll, depending on your needs*/
            background-color: #D3D3D3;
        }

        img{
            height: 200px;
            width: 200px;
        }
    </style>
</head>

<body class="hold-transition skin-red-light sidebar-mini">
<!-- Site Wrapper -->
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
                Input New Listing
            </h1>
            <ol class="breadcrumb">
                <li>Properties</li>
                <li class="active"><a href="#"><i class="fa fa-upload"></i> Input New Listing</a></li>
            </ol>
        </section>
        <!-- Main content -->

        <!-- Modal -->


        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <form action="addNewListing.php" method="post" enctype="multipart/form-data">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Address</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group col-xs-12">

                                                                <div class="form-group col-xs-12">
                                                                    <label class="control-label" for="">Address</label>
                                                                    <input type="text" class="form-control" id="address"
                                                                           placeholder="" name="address">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-xs-12">

                                                                <div class="form-group col-xs-4">
                                                                    <label class="control-label" for="">City</label>
                                                                    <input type="text" class="form-control" id="city"
                                                                           placeholder="" name="city">
                                                                </div>
                                                                <div class="form-group col-xs-4">
                                                                    <label class="control-label" for="">State</label>
                                                                    <input type="text" class="form-control" id="state"
                                                                           placeholder="" name="state">
                                                                </div>
                                                                <div class="form-group col-xs-4">
                                                                    <label class="control-label" for="">Zip</label>
                                                                    <input type="text" class="form-control" id="zip"
                                                                           placeholder="" name="zip">
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Listing Information</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group col-xs-12">

                                                                <div class="form-group col-xs-3">
                                                                    <label class="control-label" for="">Bedrooms</label>
                                                                    <input type="text" class="form-control" id="bedrooms"
                                                                           placeholder="" name="bedrooms">
                                                                </div>
                                                                <div class="form-group col-xs-3">
                                                                    <label class="control-label" for="">Bathrooms</label>
                                                                    <input type="text" class="form-control" id="bathrooms"
                                                                           placeholder="" name="bathrooms">
                                                                </div>
                                                                <div class="form-group col-xs-3">
                                                                    <label class="control-label" for="">Price</label>
                                                                    <input type="text" class="form-control" id="price"
                                                                           placeholder="" name="price">
                                                                </div>
                                                                <div class="form-group col-xs-3">
                                                                    <label class="control-label" for="">SQFT</label>
                                                                    <input type="text" class="form-control" id="sqft"
                                                                           placeholder="" name="sqft">
                                                                </div>

                                                            </div>


                                                        </div>
                                                        <div class="clearfix"></div>


                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Upload Flyer (PDF)</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group col-xs-12">

                                                                <input type="file" name="housePictures" multiple id="gallery-photo-add" enctype="multipart/form-data">
                                                                <br>
                                                                <!-- <div class="gallery" id="gallery"></div>

                                                            </div>
 -->

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-11 col-xs-offset-11">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <!-- /.box-body -->

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </section>
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
<!-- Footable -->
<script src="../dist/js/vendor/footable.min.js"></script>


<script>
    jQuery(function($) {
        $('.table').footable({});
    });

</script>


<script>
    $(function() {
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#gallery-photo-add').on('change', function() {
            imagesPreview(this, 'div.gallery');
        });
    });

</script>

</body>

</html>
