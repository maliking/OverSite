<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Re/Max Salinas | Admin Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Checkbox -->
    <link rel="stylesheet" href="plugins/checkbox/style.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue-light.css">
    <style>
        /* Make logo on login page smaller */
        .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img src="dist/img/remax-logo.png" class="img-responsive">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="validateLogin.php" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username" name="username">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
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
                    <button type="submit" class="btn btn-primary btn-flat pull-right" style="margin-bottom: 5px">Sign
                        In
                    </button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <div class="pull-right" style="text-align:right">
            <a href="#">I forgot my password</a><br>
            <a href="register.html" class="text-center">Not an admin?</a>
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
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
