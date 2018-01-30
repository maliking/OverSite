<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Forgot Password</title>
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
        .login-box-body {
            text-align: center;
            padding-top: 50px;
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
        <a href="login.php"> <img  src="dist/img/remax-logo.png" class="img-responsive"></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Forgot Password?</p>

        <form action="validateLogin.php" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="RE/MAX Email" name="password">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">

            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-flat pull-right" style="margin-bottom: 5px">Send me an email
                    </button>
                </div>
                <!-- /.col -->
            </div>
        </form>
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
    <script>
    $( "form" ).submit(function( event ) {
 {
      $( "form" ).hide;
    $( ".login-box-body" ).text( "Thank you. An email has been sent! Please sign-in to your RE/MAX email, and click on the link to reset your password." ).show();
    return;
  }
 
});</script>
</body>

</html>
