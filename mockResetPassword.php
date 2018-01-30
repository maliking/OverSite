<<<<<<< HEAD
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Reset Password</title>
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
           
        }

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
        <p class="login-box-msg">Reset Password</p>

        <form action="validateLogin.php" method="post">
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="New password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Confirm Password" name="Confirmpassword">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" id="reset" class="btn btn-primary btn-flat pull-right" style="margin-bottom: 5px">Reset Password
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
    $( "#reset" ).click(function( event ) {
 {
      $( "form" ).hide;
    $( ".login-box-body" ).text( "Your password has been reset!" ).show();
    return;
  }
 
});</script>
</body>

</html>
=======
<?php
session_start();

require 'keys/cred.php';
require 'twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;
require 'databaseConnection.php';

$dbConn = getConnection();

$sql = "SELECT phone FROM  UsersInfo WHERE license = :license";
$namedParameters = array();
$namedParameters[':license'] = $_POST['license'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$result = $stmt->fetch();


if($_POST['code'] == " ")
{
	$_SESSION['tempCode'] = rand(1, 999);
	$twilio_phone_number = "+18315851661";
	$client = new Client($sid, $token);
	$client->messages->create(
    $result['phone'],
    array(
        "From" => $twilio_phone_number,
        "Body" => $_SESSION['tempCode'],
        
    )
);

}
else
{
	if($_POST['code'] == $_SESSION['tempCode'])
	{
		$sql = "UPDATE UsersInfo SET password = :password WHERE license = :license";

	    $namedParameters = array();
	    $namedParameters[":password"] = sha1($_POST['password']);
	    $namedParameters[":license"] = $_POST['license'];
	    $stmt = $dbConn->prepare($sql);
		$stmt->execute($namedParameters);
		echo json_encode("Success");	
		session_destroy(); 
	}
	else
	{
		echo json_encode("Error");	
		
	}
	// echo json_encode($_SESSION['tempCode']);
}

?>
>>>>>>> b97cbe80fa1e0dee6b06fa69939661a92e200769
