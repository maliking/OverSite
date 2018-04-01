<?php
require("databaseConnection.php");
session_start();
$dbConn = getConnection();
if (!isset($_SESSION['userId'])) {
    header("Location: index.php?error=wrong username or password");
}
//$houseId = $_GET['houseId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
         Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Sign-Up Form</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!--<meta name="viewport" content="width=device-width; initial-scale=1.0">-->

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
            }
            else {
                $("#phoneError").html("");
                $("#phone").css("background-color", "#66FF66");
            }
        }

    </script>

</head>

<body>
<header>
</header>

<form method="post" action="addBuyer.php">
    <table style="margin: 0 auto;">
        <tr>
            <td colspan="2"><img align="bottom" alt="Interesting Image" border="0" class="simage float_center"
                                 height="151"
                                 src="https://d1yoaun8syyxxt.cloudfront.net/dh307-4c1ce6ae-ef18-4d63-ae22-952804c98fc4-v2"
                                 style="margin-left: 0px; margin-right: 0px;" title="Interesting Image" width="385"/>
            </td>
        </tr>
        <tr>
            <td>First Name *</td>
            <td><input type="text" name="firstName"/> <br/></td>
        </tr>
        <tr>
            <td>Last Name *</td>
            <td><input type="text" name="lastName"/> <br/></td>
        </tr>
        <tr>
            <td>Email *</td>
            <td><input type="email" name="email"/> <br/></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><input type="text" name="phone" id="phone" required=""/> <span id="phoneError"></span></td>
            <br/>
        </tr>
        <tr>
            <td>Bedrooms Range</td>
            <td>
                <input type="number" name="bedroomsMin" min="0" placeholder="min."/>
                -
                <input type="number" name="bedroomsMax" min="0" placeholder="max"/>
            </td>
            <br/>
        </tr>
        <tr>
            <td>Bathrooms Range</td>
            <td>
                <input type="number" name="bathroomsMin" min="0" placeholder="min." step="0.5"/>
                -
                <input type="number" name="bathroomsMax" min="0" placeholder="max" step="0.5"/>
            </td>
            <br/>
        </tr>
        <tr>
            <td>Price Range</td>
            <td>
                <input type="number" name="priceMin" min="0" placeholder="min." step="1000"/>
                -
                <input type="number" name="priceMax" min="0" placeholder="max" step="1000"/>
            </td>
            <br/>
        </tr>
        <input type="hidden" name="houseId" value="253">

        <tr>
            <td>
                <input type="submit" value="Submit"/>
            </td>
        </tr>
    </table>
</form>

<script>
    $("#phone").change(checkPhone);

</script>

</body>
</html>