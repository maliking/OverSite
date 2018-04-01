<?php
session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | Admin Login</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-admin/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <!-- Checkbox -->
        <link rel="stylesheet" href="plugins/checkbox/style.css">

        <style>
            /* Make logo on login page smaller */
            .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
                max-width: 80%;
                margin-left: auto;
                margin-right: auto;
            }

            #login-logo {
                max-width: 200px
            }

            .login-box-body {
                padding-bottom: 40px;
                border-radius: 5px;
            }

            #code-box {
                margin-top: 20px;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition login-page">
        <!-- Modal -->
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h3 class="modal-title" id="lineModalLabel">Forgot your password?</h3>
                    </div>
                    <div class="modal-body">

                        <!-- content goes here -->
                        <!-- <form> -->
                            <div class="input-group">
                                <input type="text" class="form-control" id="license" name="license" placeholder="CalBRE License">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" onclick="submitLicense()" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </div>
                            <div class="form-group" id="code-box">
                                <label for="code">Code:</label>
                                <input type="text" class="form-control" id="code" name="code" disabled>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password:</label>
                                <input type="password" class="form-control" id="password" name="password" disabled>
                            </div>
                        <!-- </form> -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" role="button" id="resetButton" class="btn btn-danger btn-block" data-dismiss="modal" onclick="resetPassword()" >Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="login-box">
    <div class="login-logo">
        <img src="dist/img/remax-logo.png" id="login-logo" class="img-responsive">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="validateLogin.php" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username" name="username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <input type="checkbox" id="box-1">
                    <label for="box-1">Remember?</label>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary pull-right" style="margin-bottom: 5px">Sign
                        In
                    </button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <div class="pull-right" style="text-align:right">
            <a href="#" data-toggle="modal" data-target="#login-modal" >I forgot my password</a><br>
        </div>
    </div>
    <div class="row" style="margin-top: 10px">
        <div class="col-lg-5 col-lg-offset-7 col-xs-4 col-xs-offset-8">
            <img src="dist/img/oversite-logo.png" class="img-responsive">
        </div>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- REQUIRED JS SCRIPTS -->
<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-admin/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->
<script>


    function submitLicense()
    {
        var license = $('#license').val();
        // alert(license);
        $.post("resetPassword.php", {license: license, code: " ", password: ""})
                .done(function (data) {
                    alert("Code has been sent to your phone.");
                    $("#code").prop('disabled', false);
                    $("#password").prop('disabled', false);
                    $("#resetButton").prop('disabled', false);
                });


    }
    function resetPassword()
    {
        var license = $('#license').val();
        var code = $('#code').val();
        var newPassword = $('#password').val();

        $.post("resetPassword.php", {license: license, code: code, password: newPassword})
                .done(function (data) {
                    var info = JSON.parse(data);
                    // alert(info);
                    if (info == "Error")
                    {
                        alert("Password could not be reset. Wrong code.");
                    } else
                    {
                        alert("Password has been reset.");
                    }
                });
    }

</script>
</body>

</html>
