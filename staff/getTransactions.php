<?php

// SELECT * FROM `BuyerInfo` WHERE `meeting` = "0000-00-00 00:00:00"   Select all that dont have meeting time or date

// SELECT * FROM `BuyerInfo` WHERE MONTH(`registeredDate`) = 9     Select all from current month

// date("d-M-Y", strtotime("next monday")); gets next monday

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$namedParameters = array();
// Add WHERE clause to get specific agents - WHERE userId = :userId  $_SESSION['userId'];
if(isset($_GET['all']) && $_GET['all'] == "true")
{
	$monthMeetings = "SELECT UsersInfo.firstName, UsersInfo.lastName, DATE_FORMAT(accDay, '%Y-%m-%dT%H:%i:%s') as start, transactions.* 
	FROM transactions LEFT JOIN UsersInfo ON transactions.userId = UsersInfo.userId";

	$meetingStmt = $dbConn->prepare($monthMeetings);
	$meetingStmt->execute();
	$meetingResults = $meetingStmt->fetchAll();
}
else
{

	$agentFilters = "";

	foreach($_GET as $key=>$value)
	{
		$agentFilters .= "UsersInfo.userId = " . $value . " OR ";
    	// echo $key, ' => ', $value, "<br/>n";
    	
	}

	$monthMeetings = "SELECT UsersInfo.firstName, UsersInfo.lastName, DATE_FORMAT(accDay, '%Y-%m-%dT%H:%i:%s') as start, transactions.* 
	FROM `transactions` LEFT JOIN UsersInfo ON transactions.userId = UsersInfo.userId WHERE " . substr($agentFilters, 0, -3);




	$meetingStmt = $dbConn->prepare($monthMeetings);
	$meetingStmt->execute($namedParameters);
	$meetingResults = $meetingStmt->fetchAll();

}

$meetingsArray = array();
foreach($meetingResults as $meeting)
{
	
	$date=date_create(substr($meeting['accDay'], 0,11));
	date_add($date,date_interval_create_from_date_string($meeting['emdDays'] . " days"));
	// date_format($date,"Y-m-d");

	// $endDate = new DateTime($meeting['start']);
	// $endDate->add(new DateInterval('P'.$meeting['emdDays'].'D'));

	// echo $endDate->format('Y-m-d H:i:s') . "\n";

	$meetingObj = new stdClass();
	$meetingObj->title = "EMD " . $meeting['firstName'] . " " . $meeting['lastName'] . " " . $meeting['transType'] . " " . $meeting['address'];
	$meetingObj->allday = True;
	$meetingObj->color = "#52BE80  ";
	$meetingObj->textColor = "#000000";
	$meetingObj->start = date_format($date,"Y-m-d") . "T00:00:00";;
	$meetingObj->end = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->id = $meeting['transId'];

	array_push($meetingsArray,$meetingObj);

	$date=date_create(substr($meeting['accDay'], 0,11));
	date_add($date,date_interval_create_from_date_string($meeting['sellerDiscDays'] . " days"));
	$meetingObj = new stdClass();
	$meetingObj->title = "Seller Disc Days " . $meeting['firstName'] . " " . $meeting['lastName'] . " " . $meeting['transType'] . " " . $meeting['address'];
	$meetingObj->allday = True;
	$meetingObj->color = "#85C1E9  ";
	$meetingObj->textColor = "#000000";
	$meetingObj->start = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->end = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->id = $meeting['transId'];

	array_push($meetingsArray,$meetingObj);

	$date=date_create(substr($meeting['accDay'], 0,11));
	date_add($date,date_interval_create_from_date_string($meeting['buyerDiscDays'] . " days"));
	$meetingObj = new stdClass();
	$meetingObj->title = "Buyer Disc Days " . $meeting['firstName'] . " " . $meeting['lastName'] . " " . $meeting['transType'] . " " . $meeting['address'];
	$meetingObj->allday = True;
	$meetingObj->color = "#FF6600";
	$meetingObj->textColor = "#000000";
	$meetingObj->start = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->end = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->id = $meeting['transId'];

	array_push($meetingsArray,$meetingObj);

	$date=date_create(substr($meeting['accDay'], 0,11));
	date_add($date,date_interval_create_from_date_string($meeting['signedDiscDays'] . " days"));
	$meetingObj = new stdClass();
	$meetingObj->title = "Signed Disc Days " . $meeting['firstName'] . " " . $meeting['lastName'] . " " . $meeting['transType'] . " " . $meeting['address'];
	$meetingObj->allday = True;
	$meetingObj->color = "#4ff6ff";
	$meetingObj->textColor = "#000000";
	$meetingObj->start = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->end = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->id = $meeting['transId'];

	array_push($meetingsArray,$meetingObj);

	$date=date_create(substr($meeting['accDay'], 0,11));
	date_add($date,date_interval_create_from_date_string($meeting['genInspecDays'] . " days"));
	$meetingObj = new stdClass();
	$meetingObj->title = "Gen Inspec Days " . $meeting['firstName'] . " " . $meeting['lastName'] . " " . $meeting['transType'] . " " . $meeting['address'];
	$meetingObj->allday = True;
	$meetingObj->color = "#FF4FFF";
	$meetingObj->textColor = "#000000";
	$meetingObj->start = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->end = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->id = $meeting['transId'];

	array_push($meetingsArray,$meetingObj);

	$date=date_create(substr($meeting['accDay'], 0,11));
	date_add($date,date_interval_create_from_date_string($meeting['appraisalDays'] . " days"));
	$meetingObj = new stdClass();
	$meetingObj->title = "Appraisal Days " . $meeting['firstName'] . " " . $meeting['lastName'] . " " . $meeting['transType'] . " " . $meeting['address'];
	$meetingObj->allday = True;
	$meetingObj->color = "#FF530D";
	$meetingObj->textColor = "#000000";
	$meetingObj->start = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->end = date_format($date,"Y-m-d") . "T00:00:00";
	$meetingObj->id = $meeting['transId'];

	array_push($meetingsArray,$meetingObj);

}

// $namedParameters[':userId'] = $_SESSION['userId'];
// echo $agentFilters;

echo json_encode($meetingsArray);

?>