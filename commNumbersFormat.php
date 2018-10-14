<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require 'databaseConnection.php';

$dbConn = getConnection();


$sql = "SELECT * FROM commInfo ORDER BY  firstName ASC, commId ASC";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$commSheets= $stmt->fetchAll();


$counter = 0;
$prevFirstName = "";
$prevLastName = "";
$prevTY = 0;
$prevFY = 0;
$prevBroker = 0;
$prevFinalComm = 0;

$newTY = 0;
$newFY = 0;
$newBroker = 0;
$newFinalComm = 0;

foreach($commSheets as $sheet)
{
	if($counter != 0 && $prevFirstName == $sheet['firstName'] && $prevLastName == $sheet['lastName'])
	{	
        if($sheet['leadType'] == "Zillow")
            $newBroker = $sheet['InitialGross'] * .5;
        else
            $newBroker = $sheet['brokerFee'];
            // $newBroker = commAlgo($newTY, $sheet['InitialGross']);
        $newTY = $newTY + $sheet['InitialGross'];
        $newFY = $newFY + ($sheet['InitialGross']- $newBroker - $sheet['remaxFee'] - $sheet['misc'] - $sheet['eoFee'] - $sheet['techFee'] - $sheet['procFee']);
        
        $newFinalComm = $sheet['InitialGross'] - $newBroker - $sheet['remaxFee'] - $sheet['misc'] - $sheet['eoFee'] - $sheet['techFee'] - $sheet['procFee'];
		
        $updateSql = "UPDATE commInfo SET TYGross = :TYGross, FYGross = :FYGross, brokerFee = :brokerFee, finalComm = :finalComm
                      WHERE commId = :commId";
        $updateParam = array();
        $updateParam[':TYGross'] = $newTY;
        $updateParam[':FYGross'] = $newFY;
        $updateParam[':brokerFee'] = $newBroker;
        $updateParam[':finalComm'] = $newFinalComm;
        $updateParam[':commId'] = $sheet['commId'];

        $updateStmt = $dbConn->prepare($updateSql);
        $updateStmt->execute($updateParam);
	}
	else
	{
        $newTY = 0;
        $newFY = 0;
        $newBroker = 0;
        $newFinalComm = 0;

        if($sheet['leadType'] == "Zillow")
            $newBroker = $sheet['InitialGross'] * .5;
        else
            $newBroker = $sheet['brokerFee'];
            // $newBroker = commAlgo($newTY, $sheet['InitialGross']);
        $newTY = $newTY + $sheet['InitialGross'];
        $newFY = $newFY + ($sheet['InitialGross'] - $newBroker - $sheet['remaxFee'] - $sheet['misc'] - $sheet['eoFee'] - $sheet['techFee'] - $sheet['procFee']);
        
        $newFinalComm = $sheet['InitialGross'] - $newBroker - $sheet['remaxFee'] - $sheet['misc'] - $sheet['eoFee'] - $sheet['techFee'] - $sheet['procFee'];

        $updateSql = "UPDATE commInfo SET TYGross = :TYGross, FYGross = :FYGross, brokerFee = :brokerFee, finalComm = :finalComm
                      WHERE commId = :commId";
        $updateParam = array();
        $updateParam[':TYGross'] = $newTY;
        $updateParam[':FYGross'] = $newFY;
        $updateParam[':brokerFee'] = $newBroker;
        $updateParam[':finalComm'] = $newFinalComm;
        $updateParam[':commId'] = $sheet['commId'];

        $updateStmt = $dbConn->prepare($updateSql);
		$updateStmt->execute($updateParam);


	}

	$counter++;
	$prevFirstName = $sheet['firstName'];
	$prevLastName = $sheet['lastName'];
	$prevTY = $sheet['TYGross'];
	$prevFY = $sheet['FYGross'];
	$prevBroker = $sheet['brokerFee'];
	$prevFinalComm = $sheet['finalComm'];
}


function commAlgo($TYGross, $commission)
{
    $brokerFee = 0;
	if ($TYGross <= 85000) 
	{
        $difference = 85000 - $TYGross;
        if ($commission <= $difference) 
        {
            $brokerFee += $commission * .20;
        } 
        else 
        {
            $brokerFee += $difference * .20;
            $commission = $commission - $difference;
            if ($commission > 0) 
            {
                if ($commission <= 49999) 
                {
                    $brokerFee += $commission * .15;
                } 
                else 
                {
                    $brokerFee += 49999 * .15;
                    $commission = $commission - 49999;
                    if ($commission > 0) 
                    {
                        if ($commission <= 49999) 
                        {
                            $brokerFee += $commission * .10;
                        } 
                        else 
                        {
                            $brokerFee += 49999 * .10;
                            $commission = $commission - 49999;
                            if ($commission > 0) 
                            {
                                $brokerFee += $commission * .05;
                            }
                        }
                    }
                }
            }
        }
    } else if ($TYGross <= 135000) 
    {
        $difference = 135000 - $TYGross;
        if ($commission <= $difference) 
        {
            $brokerFee += $commission * .15;
        } 
        else 
        {
            $brokerFee += $difference * .15;
            $commission = $commission - $difference;
            if ($commission > 0) 
            {
                if ($commission <= 49999) 
                {
                    $brokerFee += $commission * .10;
                } 
                else 
                {
                    $brokerFee += 49999 * .10;
                    $commission = $commission - 49999;
                    if ($commission > 0) 
                    {
                        $brokerFee += $commission * .05;
                    }
                }
            }
        }
    } 
    else if ($TYGross <= 185000) 
    {
        $difference = 185000 - $TYGross;
        if ($commission <= $difference) 
        {
            $brokerFee += $commission * .10;
        } 
        else 
        {
            $brokerFee += 49999 * .10;
            $commission = $commission - 49999;
            if ($commission > 0) 
            {
                $brokerFee += $commission * .05;
            }
        }
    } 
    else 
    {
        $brokerFee += $commission * .05;
    }
    return $brokerFee;
} 



?>