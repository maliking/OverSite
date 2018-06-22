 
<?php 

$dbGoal = getConnection();
$getMonthlyGrossSql = "SELECT SUM(finalComm) as gross, license, date, MONTH(date) as month FROM commInfo WHERE YEAR(date) = YEAR(CURRENT_TIMESTAMP ()) AND license = :license GROUP BY license, MONTH(date) ORDER BY MONTH(date) ASC";
$goalParameters = array();
$goalParameters[':license'] = $licenseResult['license'];

$goalStmt = $dbGoal->prepare($getMonthlyGrossSql);
$goalStmt->execute($goalParameters);
$goalResults = $goalStmt->fetchAll();

$months = array("Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec");

$counter = 0;
$agentGoal = $agentInfo['goal'];

for($i = 0; $i < date('n'); $i++)
{
    if($counter < count($goalResults))
    {
        if($goalResults[$counter]['month'] == $i+1)
        {
          $monthGross = $goalResults[$counter]['gross'] / ($agentGoal/12);
          $percentOfGross = ($monthGross * 100);
          if($percentOfGross >= 100)
            $percentOfGross = 100;
          echo '<div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: ' . number_format($percentOfGross,2) . '%" aria-valuenow="' . number_format($percentOfGross,2) . 
              '" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . "&nbsp&nbsp " . number_format($monthGross*100,2)  .'% &nbsp$' . number_format($goalResults[$counter]['gross']) . 
              "/ $" . number_format($agentGoal/12) .'</div>
              <div class="progress-bar progress-bar-danger" role="progressbar" style="width: ' . number_format((100 - $percentOfGross),2) . '%" aria-valuenow="' . number_format($percentOfGross,2) . 
              '" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . "&nbsp&nbsp " . number_format((100 - $percentOfGross),2) . '%&nbsp $' . number_format(($agentGoal/12)-$goalResults[$counter]['gross']) .
              "/ $" . number_format($agentGoal/12) . '</div>

              </div>';
              $counter++;
        }
        else
        {
        echo '<div class="progress">
            <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . ' 0%</div>
            </div>';
        }
    }
    else
    {
      echo '<div class="progress">
          <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . ' 0%</div>
          </div>';
    }

  
}


?>

