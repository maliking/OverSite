<?php
require("../databaseConnection.php");
session_start();
if (!isset($_SESSION['listingId'])) {
    $_SESSION['listingId'] = $_GET['id'];
}

$dbConn = getConnection();
if (!isset($_SESSION['userId'])) {
    header("Location: index.php?error=wrong username or password");
}
// $houseId = $_GET['houseId'];
if (isset($_GET['id']))
    $_SESSION['listingId'] = $_GET['id'];
if($_SESSION['listingId'][0] == 'M')
{
    $sql = "SELECT houseId, address, flyer FROM HouseInfo WHERE listingId = :listingId";
}
else
{
    $sql = "SELECT houseId, address, flyer FROM HouseInfo WHERE houseId = :listingId";
}
$namedParameters = array();
// $namedParameters[':listingId'] = $_GET['id'];

$namedParameters[':listingId'] = $_SESSION['listingId'];


$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$result = $stmt->fetch();

$_SESSION['flyer'] = $result['flyer'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
   Remove this if you use the .htaccess -->


    <title>RE/MAX Salinas | Sign In Form</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>


    <script>
        function displayError(id, message) {
            $(id + "Error").html(message);
            $(id).css("background-color", "red");
            $(id).focus();
            $(id + "Error").css("color", "red");
        }

        function checkPhone() {
            if (!/^\d{3}\s*\d{3}\d{4}$/.test($("#phone").val())) {
                displayError("#phone", "Please enter a 10-digit phone number");
                return false;
            } else {
                $("#phoneError").html("");
                $("#phone").css("background-color", "#66FF66");
            }
        }

    </script>


    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-agent/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->


    <!-- bootstrap slider -->
    <!--        <link rel="stylesheet" href="../plugins/bootstrap-slider/slider.css">-->

</head>


<body>


<section class="content">
    <center>
        <img alt="RE/MAX Logo" border="0" class="simage float_center img-responsive"
             src="../dist/img/remax-logo224x194.png" style="margin-left: 0px; margin-right: 0px;" title="Interesting Image"
            />
    </center>
    <form method="post" action="addBuyer.php">

        <input type="hidden" name="houseId" value="<?= $result['houseId']; ?>"/>

        <div class="x_title" style="margin-top: 20px;">
            <center>
                <h3><label>Welcome to <?php echo $result['address']; ?></label></h3>
            </center>


        </div>

        <div class="row" style="margin-top: 30px;">

            <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-4">
                <input type="text" name="firstName" class="form-control has-feedback-left" id="inputSuccess2"
                       placeholder="First Name">
                <span class="form-control-feedback left" aria-hidden="true"></span>

                </br>
                <input type="text" name="lastName" class="form-control" id="inputSuccess3" placeholder="Last Name">
                <span class="form-control-feedback right" aria-hidden="true"></span>

            </div>


        </div>
        <div class="row">

            <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-4">
                <input type="text" name="email" class="form-control has-feedback-left" id="inputSuccess4"
                       placeholder="Email">
                <span class="form-control-feedback left" aria-hidden="true"></span>
                </br>
                <input type="text" name="phone" class="form-control" id="inputSuccess5" placeholder="Phone">
                <span class=" form-control-feedback right" aria-hidden="true"></span>
            </div>


        </div>
       

        </div>
        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-4">
                
                <br>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>

        </div>
    </form>
</section>


<!-- Bootstrap slider -->
<script src="../plugins/bootstrap-slider/bootstrap-slider.js"></script>


<script>
    $("#phone").change(checkPhone);
    //
    //            $(function() {
    //                /* BOOTSTRAP SLIDER */
    //                $('.slider').slider();
    //            })

</script>


</body>

</html>
