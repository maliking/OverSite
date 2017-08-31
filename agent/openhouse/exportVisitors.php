<?php

header("Content-Type: application/vnd.ms-excel");


require '../../databaseConnection.php';
$dbConn = getConnection();
$dbConnTwo = getConnection();
$sql = "SELECT houseId, address FROM HouseInfo WHERE listingId = :listingId";

$namedParameters = array();
$namedParameters[':listingId'] = $_GET['id'];


$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$result = $stmt->fetch();

header("Content-disposition: attachment; filename=" . $result['houseId'] . $result['address'] . ".xls");
$sqlVisitors = "SELECT firstName, lastName, email, phone FROM BuyerInfo WHERE houseId = :houseId";

$namedVisitors = array();
$namedVisitors[':houseId'] = $result['houseId'];

$stmtVisitors = $dbConnTwo->prepare($sqlVisitors);
$stmtVisitors->execute($namedVisitors);
$visitors = $stmtVisitors->fetchAll();


$today = date("m/d/Y");



echo  'FirstName' . "\t" . 'LastName' . "\t" . 'Title'. "\t"  . 'Company'. "\t"  . 'Address1'. "\t"  .
		'Address2'. "\t"  . 'City'. "\t"  . 'State'. "\t"  . 'Zip'. "\t"  . 'Country'. "\t"  . 'County'. "\t"  . 'BizPhone'. "\t"  .
		'HomePhone'. "\t"  . 'CellPhone'. "\t"  . 'Fax'. "\t"  . 'Email'. "\t"  . 'WebURL'. "\t"  . 'Active'. "\t"  . 
		'LeadPriority'. "\t"  . 'AssignedTo'. "\t"  . 'LeadSource'. "\t"  . 'AdCode'. "\t"  . 'AddedOn'. "\t"  . 'ModifiedOn'. "\t"  . 'Office'. "\t"  . 'ContactTypes'. "\t"  . 
		'Anniversary'. "\t"  . 'Birthday'. "\t"  . 'BizPhone2'. "\t"  . 'BizPhone2Ext'. "\t"  . 'CellPhone2'. "\t"  . 'ClosingDate'. "\t"  . 'CommissionEstimate'. 
		"\t"  . 'Email2'. "\t"  . 'ReferredBy'. "\t"  . 'SpouseBizPhone'. "\t"  . 'SpouseBizPhoneExt'. "\t"  . 'SpouseCellPhone'. "\t"  . 'SpouseEmail'. "\t"  . 'SpouseFirstName'. 
		"\t"  . 'SpouseLastName'. "\t"  . 'WorkAddress'. "\t"  . 'WorkCity'. "\t"  . 'WorkCountry'. "\t"  . 'WorkCounty'. "\t"  . 'WorkState'. "\t"  . 'WorkZip'. "\n";

foreach ($visitors as $visit) 
{
	# code...

echo $visit['firstName'] . "\t" . $visit['lastName'] . "\t" . ' ' . "\t" . ' ' . "\t" . ' ' . "\t" . ' ' . "\t" . '' . 
	 "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . $visit['phone'] . "\t" . '' . "\t" . '' . "\t" . 
	 '' . "\t" . $visit['email'] . "\t" . '' . "\t" . 'TRUE' . "\t" . '' . "\t" . 'Jorge Edeza' . "\t" . 'Manually Entered' . "\t" . '' . "\t" .
	 $today . "\t" . $today . "\t" . 'RE/MAX Property Experts' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' .
	  "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' . "\t" . '' .
	   "\t" . '' . "\t" . '' . "\t" . '' . "\n";

}



?>