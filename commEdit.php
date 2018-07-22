<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require 'databaseConnection.php';

$dbConn = getConnection();


$sql = "SELECT commId, firstName, lastName, TYGross, FYGross, InitialGross, brokerFee, finalComm, remaxFee, misc 
		FROM commInfo ORDER BY  firstName ASC, commId ASC";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$commSheets= $stmt->fetchAll();

echo "<table style=width:100%; rules='rows' >";
echo "<tr>";
echo "<th style='text-align: left'; >First Name</th>";
echo "<th style='text-align: left'>Last Name</th> ";
echo "<th style='text-align: left'>Initial Gross</th> ";
echo "<th style='text-align: left'>TYGross</th>";
echo "<th style='text-align: left'>FYNet</th>";
echo "<th style='text-align: left'>Broker Fee</th>";
echo "<th style='text-align: left'>Final Comm</th>";
echo "<th style='text-align: left'>New TYGross</th>";
echo "<th style='text-align: left'>New FYNet</th>";
echo "<th style='text-align: left'>New Broker Fee</th>";
echo "<th style='text-align: left'>New Final Comm</th>";
echo "</tr>";
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
        $newBroker = commAlgo($newTY, $sheet['InitialGross']);
        $newTY = $newTY + $sheet['InitialGross'];
        $newFY = $newFY + ($sheet['InitialGross']- $newBroker - $sheet['remaxFee'] - $sheet['misc']);
        
        $newFinalComm = $sheet['InitialGross'] - $newBroker - $sheet['remaxFee'] - $sheet['misc'];
		echo "<tr>";
		echo "<td height='50'>" . $sheet['firstName'] ."</td>";
		echo "<td>" . $sheet['lastName'] ."</td>";
        echo "<td>" . number_format($sheet['InitialGross']) ."</td>";
		echo "<td>" . number_format($sheet['TYGross']) ."</td>";
		echo "<td>" . number_format($sheet['FYGross']) ."</td>";
		echo "<td>" . number_format($sheet['brokerFee']) ."</td>";
		echo "<td>" . number_format($sheet['finalComm']) ."</td>";

        echo ($newTY != $sheet['TYGross'] ? "<td style='color: red;' >" . number_format($newTY) ."</td>" : "<td>" . number_format($newTY) ."</td>"); 
        echo ($newFY != $sheet['FYGross'] ? "<td style='color: red;' >" . number_format($newFY) ."</td>" : "<td>" . number_format($newFY) ."</td>"); 
        echo ($newBroker != $sheet['brokerFee'] ? "<td style='color: red;' >" . number_format($newBroker) ."</td>" : "<td>" . number_format($newBroker) ."</td>"); 
        echo ($newFinalComm != $sheet['finalComm'] ? "<td style='color: red;' >" . number_format($newFinalComm) ."</td>" : "<td>" . number_format($newFinalComm) ."</td>"); 
    //     if($newTY != $sheet['TYGross'])
    //         echo "<td>" . number_format($newTY) ."</td>";
    //     else
		  // echo "<td>" . number_format($newTY) ."</td>";

		// echo "<td>" . number_format($newFY) ."</td>";
		// echo "<td>" . number_format($newBroker) ."</td>";
		// echo "<td>" . number_format($newFinalComm) ."</td>";
		
		
	}
	else
	{
        $newTY = 0;
$newFY = 0;
$newBroker = 0;
$newFinalComm = 0;
        $newBroker = commAlgo($newTY, $sheet['InitialGross']);
        $newTY = $newTY + $sheet['InitialGross'];
        $newFY = $newFY + ($sheet['InitialGross']- $newBroker);
        
        $newFinalComm = $sheet['InitialGross'] - $newBroker - $sheet['remaxFee'] - $sheet['misc'];

		echo "<tr>";
		echo "<td height='50'>" . $sheet['firstName'] ."</td>";
		echo "<td>" . $sheet['lastName'] ."</td>";
        echo "<td>" . number_format($sheet['InitialGross']) ."</td>";
		echo "<td>" . number_format($sheet['TYGross']) ."</td>";
		echo "<td>" . number_format($sheet['FYGross']) ."</td>";
		echo "<td>" . number_format($sheet['brokerFee']) ."</td>";
		echo "<td>" . number_format($sheet['finalComm']) ."</td>";

        echo ($newTY != $sheet['TYGross'] ? "<td style='color: red;' >" . number_format($newTY) ."</td>" : "<td>" . number_format($newTY) ."</td>"); 
        echo ($newFY != $sheet['FYGross'] ? "<td style='color: red;' >" . number_format($newFY) ."</td>" : "<td>" . number_format($newFY) ."</td>"); 
        echo ($newBroker != $sheet['brokerFee'] ? "<td style='color: red;' >" . number_format($newBroker) ."</td>" : "<td>" . number_format($newBroker) ."</td>"); 
        echo ($newFinalComm != $sheet['finalComm'] ? "<td style='color: red;' >" . number_format($newFinalComm) ."</td>" : "<td>" . number_format($newFinalComm) ."</td>"); 
    

		// echo "<td>" . number_format($newTY) ."</td>";
  //       echo "<td>" . number_format($newFY) ."</td>";
  //       echo "<td>" . number_format($newBroker) ."</td>";
  //       echo "<td>" . number_format($newFinalComm) ."</td>";
		echo "</tr>";	

	}
	$counter++;
	$prevFirstName = $sheet['firstName'];
	$prevLastName = $sheet['lastName'];
	$prevTY = $sheet['TYGross'];
	$prevFY = $sheet['FYGross'];
	$prevBroker = $sheet['brokerFee'];
	$prevFinalComm = $sheet['finalComm'];
}


echo "</table>";


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