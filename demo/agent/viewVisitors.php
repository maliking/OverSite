<?php
require("../databaseConnection.php");
session_start();
$dbConn = getConnection();
if (!isset($_SESSION['userId'])) {
    header("Location: ../index.html?error=wrong username or password");
}
if (isset ($_GET['deleteForm'])) {  //checking whether we have clicked on the "Delete" button
    $sql = "DELETE FROM BuyerInfo 
                 WHERE buyerID = '" . $_GET['buyerID'] . "'";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
}
?>


<!--
To change this template use Tools | Templates.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Visitors</title>

    <script>

        function confirmDelete(record) {
            // alert("hi"); // for testing
            var deleteRecord = confirm("Are you sure you want to delete " + record + "?");
            if (!deleteRecord) {
                return false
            } else {
                return true;
            }
        }

    </script>

    <meta charset="utf-8"/>
    <style type="text/css">
        /* .tableHeader {
             text-align:center;
         }*/
        .tableButtons {
            text-align: center;
        }

        .option {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: "green";
            border: 0;
            box-sizing: border-box;
            font-size: 18px;
            text-align: center;
            background-color: #c68c53
        }

        .tftable {
            font-size: 18px;
            color: #fbfbfb;
            width: 100%;
            border-width: 1px;
            border-color: #686767;
            border-collapse: collapse;
        }

        .tftable th {
            font-size: 18px;
            background-color: #c68c53;
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #686767;
            text-align: left;
        }

        .tftable tr {
            background-color: #d2a679;
        }

        .tftable td {
            font-size: 18px;
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #686767;
        }

        .tftable tr:hover {
            background-color: #c68c53;
        }
    </style>
</head>


<body>
<!-- Navigation Bar -->
<?php
//require("agentNav.php");
?>
<br/><br/>
<h2 id="header2">Visitors &#x2713</h2>

<table class="tftable" border="1">

    <tr>
        <th>Address</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Bedrooms</th>
        <th>Bathrooms</th>
        <th>Price</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php
    $dbConn = getConnection();
    // $sql = "SELECT * FROM BuyerInfo WHERE userId = :userId";
    $sql = "SELECT  address, firstName, lastName, email, phone, bedroomsMin, bedroomsMax, priceMin, priceMax 
            from BuyerInfo as BI LEFT JOIN HouseInfo as HI ON BI.houseId = HI.houseId WHERE BI.userId = :userId";
    $namedParameters = array();
    $namedParameters[':userId'] = $_SESSION['userId'];
    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
    //$stmt->execute();
    $results = $stmt->fetchAll();
    foreach ($results as $result) {
        echo "<tr>";
        echo "<td>" . $result['address'] . "</td>";
        echo "<td>" . $result['firstName'] . "</td>";
        echo "<td>" . $result['lastName'] . "</td>";
        echo "<td>" . htmlspecialchars($result['email']) . "</td>";
        echo "<td>" . htmlspecialchars($result['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($result['bedroomsMin']) . " - " . htmlspecialchars($result['bedroomsMax']) . "</td>";
        echo "<td>" . htmlspecialchars($result['bathroomsMin']) . " - " . htmlspecialchars($result['bathroomsMax']) . "</td>";
        echo "<td>$" . htmlspecialchars(number_format($result['priceMin'])) . " - $" . htmlspecialchars(number_format($result['priceMax'])) . "</td>";
        ?>

        <td>
            <form action="editBuyerInfo.php">
                <input type="hidden" name="buyerID" value="<?= $result['buyerID'] ?>"/>
                <input class="option" type="submit" value="Edit" name="editForm"/>
            </form>
        </td>
        <td>
            <form onsubmit="return confirmDelete('<?= $result['firstName'] ?>')">
                <input type="hidden" name="buyerID" value="<?= $result['buyerID'] ?>"/>
                <input class="option" type="submit" value="Delete" name="deleteForm"/>
            </form>
        </td>
        </tr>

        <?php
    } //closes foreach
    ?>
</table>
</body>
<?php include('../footer.php'); ?>
</html>
