 
<?php 

$dbGoal = getConnection();
$getMonthlyGrossSql = "SELECT SUM(FYGross) as gross, license, date, MONTH(date) as month FROM commInfo WHERE YEAR(date) = YEAR(CURRENT_TIMESTAMP ()) AND license = :license GROUP BY license, MONTH(date) ORDER BY MONTH(date) ASC";
$goalParameters = array();
$goalParameters[':license'] = $licenseResult['license'];

$goalStmt = $dbGoal->prepare($getMonthlyGrossSql);
$goalStmt->execute($goalParameters);
$goalResults = $goalStmt->fetchAll();

$months = array("Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec");

$counter = 0;

for($i = 0; $i < date('n'); $i++)
{
    if($counter < count($goalResults))
    {
        if($goalResults[$counter]['month'] == $i+1)
        {
          $monthGross = $goalResults[$counter]['gross'] / (120000/12);
          $percentOfGross = ($monthGross * 100);
          echo '<div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: ' . $percentOfGross . '%" aria-valuenow="' . $percentOfGross . 
              '" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . " " . $percentOfGross  .'% $' . number_format($goalResults[$counter]['gross']) . 
              "/ $" . number_format(120000/12) .'</div>
              <div class="progress-bar progress-bar-danger" role="progressbar" style="width: ' . (100 - $percentOfGross) . '%" aria-valuenow="' . $percentOfGross . 
              '" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . " " . (100 - $percentOfGross) . '% $' . number_format((120000/12)-$goalResults[$counter]['gross']) .
              "/ $" . number_format(120000/12) . '</div>

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

