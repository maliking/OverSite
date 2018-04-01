<?php

header("Content-Type: application/vnd.ms-excel");

session_start();


require '../../databaseConnection.php';
$startDate = date('Y-m-d', strtotime($_GET['startDate']));
$endDate = date('Y-m-d', strtotime($_GET['endDate']));
$dbConn = getConnection();
$dbConnTwo = getConnection();
if($_GET['id'] != "all")
{
    $sql = "SELECT houseId, address FROM HouseInfo WHERE listingId = :listingId";

    $namedParameters = array();
    $namedParameters[':listingId'] = $_GET['id'];


    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
    $result = $stmt->fetch();

    header("Content-disposition: attachment; filename=" . $result['houseId'] . $result['address'] . ".xls");
    // $sqlVisitors = "SELECT firstName, lastName, email, phone FROM BuyerInfo WHERE houseId = :houseId AND registeredDate BETWEEN :startDate AND :endDate";

    $sqlVisitors = "SELECT BuyerInfo.*, HouseInfo.address as address, HouseInfo.city as city, HouseInfo.state as state, HouseInfo.zip as zip
                                FROM BuyerInfo LEFT JOIN HouseInfo ON BuyerInfo.houseId = HouseInfo.houseId 
                                where BuyerInfo.houseId = :houseId AND BuyerInfo.registeredDate BETWEEN :startDate AND :endDate";
    $namedVisitors = array();
    $namedVisitors[':houseId'] = $result['houseId'];
    $namedVisitors[':startDate'] = $_GET['startDate'];
    $namedVisitors[':endDate'] = $_GET['endDate'];

    $stmtVisitors = $dbConnTwo->prepare($sqlVisitors);
    $stmtVisitors->execute($namedVisitors);
}
else
{
    header("Content-disposition: attachment; filename='allVisitors.xls'");
    // $sqlVisitors = "SELECT firstName, lastName, email, phone FROM BuyerInfo WHERE registeredDate BETWEEN :startDate AND :endDate";
    $sqlVisitors = "SELECT BuyerInfo.*, HouseInfo.address as address, HouseInfo.city as city, HouseInfo.state as state, HouseInfo.zip as zip
                                FROM BuyerInfo LEFT JOIN HouseInfo ON BuyerInfo.houseId = HouseInfo.houseId 
                                where BuyerInfo.userId = :userId AND BuyerInfo.registeredDate BETWEEN :startDate AND :endDate ORDER BY address";
    $namedVisitors = array();
    $namedVisitors[':startDate'] = $_GET['startDate'];
    $namedVisitors[':endDate'] = $_GET['endDate'];
    $namedVisitors[':userId'] = $_SESSION['userId'];
    $stmtVisitors = $dbConnTwo->prepare($sqlVisitors);
    $stmtVisitors->execute($namedVisitors);
}
$visitors = $stmtVisitors->fetchAll();


$today = date("m/d/Y");


echo 'FirstName' . "\t" . 'LastName' . "\t" . 'Title' . "\t" . 'Company' . "\t" . 'Address1' . "\t" .
    'Address2' . "\t" . 'City' . "\t" . 'State' . "\t" . 'Zip' . "\t" . 'Country' . "\t" . 'County' . "\t" . 'BizPhone' . "\t" .
    'HomePhone' . "\t" . 'CellPhone' . "\t" . 'Fax' . "\t" . 'Email' . "\t" . 'WebURL' . "\t" . 'Active' . "\t" .
    'LeadPriority' . "\t" . 'AssignedTo' . "\t" . 'LeadSource' . "\t" . 'AdCode' . "\t" . 'AddedOn' . "\t" . 'ModifiedOn' . "\t" . 'Office' . "\t" . 'ContactTypes' . "\t" .
    'Anniversary' . "\t" . 'Birthday' . "\t" . 'BizPhone2' . "\t" . 'BizPhone2Ext' . "\t" . 'CellPhone2' . "\t" . 'ClosingDate' . "\t" . 'CommissionEstimate' .
    "\t" . 'Email2' . "\t" . 'ReferredBy' . "\t" . 'SpouseBizPhone' . "\t" . 'SpouseBizPhoneExt' . "\t" . 'SpouseCellPhone' . "\t" . 'SpouseEmail' . "\t" . 'SpouseFirstName' .
    "\t" . 'SpouseLastName' . "\t" . 'WorkAddress' . "\t" . 'WorkCity' . "\t" . 'WorkCountry' . "\t" . 'WorkCounty' . "\t" . 'WorkState' . "\t" . 'WorkZip' . "\n";

foreach ($visitors as $visit) {
    # code...

    echo $visit['firstName'] . "\t" . $visit['lastName'] . "\t" . ' ' . "\t" . ' ' . "\t" . $visit['address'] . ", " . $visit['city'] . " " . $visit['state'] . 
        " " . $visit['zip']  . "\t" . ' ' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . $visit['phone'] . "\t" . '' . "\t" . '' . "\t" .
        '' . "\t" . $visit['email'] . "\t" . '' . "\t" . 'TRUE' . "\t" . '' . "\t" . 'Jorge Edeza' . "\t" . 'Manually Entered' . "\t" . '' . "\t" .
        $today . "\t" . $today . "\t" . 'RE/MAX Property Experts' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' .
        "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' .
        "\t" . '' . "\t" . '' . "\t" . '' . "\n";

}


?>