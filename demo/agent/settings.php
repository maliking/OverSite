<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();

$sqlLicense = "SELECT * FROM UsersInfo WHERE userId = :userId";

$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];


$licenseStmt = $dbConn->prepare($sqlLicense);
$licenseStmt->execute($namedParameters);
$licenseResult = $licenseStmt->fetch();

$_SESSION['license'] = $licenseResult['license'];
//
//
//$sql = "";
//$parameters = array();
//$parameters[':license'] = $licenseResult['license'];
//
//$stmt = $dbConn->prepare($sql);
//$stmt->execute($parameters);
//$result = $stmt->fetch();


?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | Settings</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-agent/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <style>


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
                <!-- Main content -->
                <section class="content" style="min-height:initial;">
                    <!-- Content Wrapper. Contains page content -->
                 
        
  
        <div class="row">
             <div class="col-md-3">
<div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="../dist/img/user2-160x160.jpg" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo $licenseResult['firstName'] . " " . $licenseResult['lastName']; ?></h3>
           
                <ul class="nav nav-pills nav-stacked admin-menu" >
                    <li class="active"><a href="" data-target-id="profile"><i class="glyphicon glyphicon-user"></i> Profile</a></li>
                    <li><a href="" data-target-id="change-password"><i class="glyphicon glyphicon-lock"></i> Change Password</a></li>
            
                </ul>
            </div>
    </div>
            </div>
            

            <div class="col-md-9  admin-content" id="profile">
                <div class="panel panel-primary" style="margin: 1em;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Name</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo $licenseResult['firstName'] . " " . $licenseResult['lastName']; ?>
                    </div>
                </div>
                <div class="panel panel-primary" style="margin: 1em;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Email</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo $licenseResult['email']; ?>
                    </div>
                </div>
                <div class="panel panel-primary" style="margin: 1em;">
                    <div class="panel-heading">
                        <h3 class="panel-title">License number</h3>

                    </div>
                    <div class="panel-body">
                        <?php echo $licenseResult['license']; ?>
                    </div>
                </div>

            </div>


            <div class="col-md-9  admin-content" id="change-password">
                <!-- <form action="/password" method="post"> -->

           
                    <div class="panel panel-primary" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title"><label for="new_password" class="control-label panel-title">New Password</label></h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" id="new_password" >
                                </div>
                            </div>

                        </div>
                    </div>

             
                    <div class="panel panel-primary" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title"><label for="confirm_password" class="control-label panel-title">Confirm password</label></h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password_confirmation" id="confirm_password" >
                                </div>
                            </div>
                        </div>
                    </div>

           
                    <div class="panel panel-primary border" style="margin: 1em;">
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="pull-left">
                                    <button type="button" class="form-control btn btn-primary" name="reset" id="reset" onclick="resetPassword()">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>

               <!--  </form> -->
            </div>
    
        </div>

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






        <!-- Custom Theme Scripts -->
        <script src="build/js/custom.min.js"></script>


        <script>
        $(document).ready(function()
        {
            var navItems = $('.admin-menu li > a');
            var navListItems = $('.admin-menu li');
            var allWells = $('.admin-content');
            var allWellsExceptFirst = $('.admin-content:not(:first)');
            allWellsExceptFirst.hide();
            navItems.click(function(e)
            {
                e.preventDefault();
                navListItems.removeClass('active');
                $(this).closest('li').addClass('active');
                allWells.hide();
                var target = $(this).attr('data-target-id');
                $('#' + target).show();
            });
        });

        function resetPassword()
        {
            var newPassword = $('#new_password').val();
            var confirmPassword = $('#confirm_password').val();
            
            if(newPassword == confirmPassword)
            {
                $.post( "resetPassword.php", { newPassword: newPassword} )
                .done(function( data ) {
                alert( "Password has been reset.");
              });
            }
            else
            {
                alert("Passwords do not match.");
            }
        }
        </script>
       

    </body>

    </html>
