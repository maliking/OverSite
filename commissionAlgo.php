<?php
session_start();
require('../databaseConnection.php');
$dbConn = getConnection();
$license = $_POST['license'];
$houseId = $_POST['houseId'];
$sql = "SELECT * FROM UsersInfo WHERE license = '" . $license . "'";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$userResults = $stmt->fetch();
$message = "wrong answer";
$sqlHouse = "SELECT * FROM HouseInfo WHERE houseId = '" . $houseId . "'";
$stmtHouse = $dbConn->prepare($sqlHouse);
$stmtHouse->execute();
$houseResults = $stmtHouse->fetch();
$sqlAgent = "SELECT * FROM commInfo  WHERE license = '" . $license . "' ORDER BY date DESC LIMIT 1";
$stmtAgent = $dbConn->prepare($sqlAgent);
$stmtAgent->execute();
$commResults = $stmtAgent->fetch();

$TYGross = $commResults['TYGross'];
$FYGross = $commResults['FYGross'];


$commission = $_POST['commission'];
$brokerFee = 0;
$finalComm = 0;
$percent = $_POST['percent'];
if (empty($percent)) {
    if ($TYGross <= 80000) {
        $difference = 80000 - $TYGross;
        //$total = $TYGross + $commission;
        if ($commission <= $difference) {
            $brokerFee += $commission * .20;
        } else {
            $brokerFee += $difference * .20;
            $commission = $commission - $difference;
            if ($commission > 0) {
                //$difference = 49999 - $commission;
                if ($commission <= 49999) {
                    $brokerFee += $commission * .15;
                } else {
                    $brokerFee += 49999 * .15;
                    $commission = $commission - 49999;
                    if ($commission > 0) {
                        //$difference = 49999 - $commission;
                        if ($commission <= 49999) {
                            $brokerFee += $commission * .10;
                        } else {
                            $brokerFee += 49999 * .10;
                            $commission = $commission - 49999;
                            if ($commission > 0) {
                                $brokerFee += $commission * .5;
                            }
                        }
                    }
                }
            }
        }
    } else if ($TYGross <= 130000) {
        $difference = 130000 - $TYGross;
        if ($commission <= $difference) {
            $brokerFee += $commission * .15;
        } else {
            $brokerFee += $difference * .15;
            $commission = $commission - $difference;
            if ($commission > 0) {
                if ($commission <= 49999) {
                    $brokerFee += $commission * .10;
                } else {
                    $brokerFee += 49999 * .10;
                    $commission = $commission - 49999;
                    if ($commission > 0) {
                        $brokerFee += $commission * .5;
                    }
                }
            }
        }
    } else if ($TYGross <= 180000) {
        $difference = 180000 - $TYGross;
        if ($commission <= $difference) {
            $brokerFee += $commission * .15;
        } else {
            $brokerFee += 49999 * .10;
            $commission = $commission - 49999;
            if ($commission > 0) {
                $brokerFee += $commission * .5;
            }
        }
    } else {
        $brokerFee += $commission * .5;
    }
} else {
    $brokerFee = $commission * $percent;
    // echo $brokerFee;
}
$message = "wrong answer";
// echo $brokerFee;
$sql = "INSERT INTO commInfo
                  (houseId, license, firstName, lastName, settlementDate, checkNum, address, city, state, zip, TYGross, FYGross, InitialGross, brokerFee, finalComm)
                  VALUES (:houseId, :license, :firstName, :lastName, :settlementDate, :checkNum, :address, :city, :state, :zip, :TYGross, :FYGross, :InitialGross, :brokerFee, :finalComm)";
$namedParameters = array();
$namedParameters[":houseId"] = $houseId;
$namedParameters[":license"] = $license;
$namedParameters[":firstName"] = $userResults['firstName'];
$namedParameters[":lastName"] = $userResults['lastName'];
// $namedParameters[":date"] = $_POST['date'];
$namedParameters[":settlementDate"] = $_POST['settlementDate'];
$namedParameters[":checkNum"] = $_POST['checkNum'];
$namedParameters[":address"] = $houseResults['address'];
$namedParameters[":city"] = $houseResults['city'];
$namedParameters[":state"] = $houseResults['state'];
$namedParameters[":zip"] = $houseResults['zip'];
$namedParameters[":TYGross"] = $TYGross + $_POST['commission'];
$namedParameters[":FYGross"] = $FYGross + ($_POST['commission'] - $brokerFee - 349);
$namedParameters[":InitialGross"] = $_POST['commission'];
$namedParameters[":brokerFee"] = $brokerFee;
$namedParameters[":finalComm"] = floatval($_POST['commission']) - $brokerFee - 349;
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>



