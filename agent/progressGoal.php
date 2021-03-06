 
<?php 

$dbGoal = getConnection();
$getMonthlyGrossSql = "SELECT SUM(InitialGross) as gross, license, date, MONTH(date) as month FROM commInfo WHERE YEAR(date) = YEAR(CURRENT_TIMESTAMP ()) AND license = :license GROUP BY license, MONTH(date) ORDER BY MONTH(date) ASC";
$goalParameters = array();
$goalParameters[':license'] = $licenseResult['license'];

$goalStmt = $dbGoal->prepare($getMonthlyGrossSql);
$goalStmt->execute($goalParameters);
$goalResults = $goalStmt->fetchAll();

// print_r($goalResults);

$months = array("Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec");

$counter = 0;
$agentGoal = $agentInfo['goal'];

$ytdGross = 0;

echo '
<div class="box">
<div class="box-body no-padding" style="overflow: auto;">
<div class="box-header">
  <h4>Progress Goal <button type="button" data-toggle="collapse" data-target="#goalBar" aria-expanded="true" aria-controls="goalBar">
    <span class="fa fa-compress" aria-hidden="true"></span>
  </button></h4>
</div>
<div class="collapse" id="goalBar">
<table id="modal-table" class="table footable table-striped">
  <tr>
    <th>Month</th>';
for($i = 0; $i < 12; $i++)
{
  echo "<th>" . $months[$i] . "</th>";
}
// <td><span class="top">$GCI$</span> <span class="bottom">$GOAL$</span></td>
echo'<th>YTD GOAL</th>
  </tr>
  <tr>
    <th>$ MY GROSS COMISSION $</th>';

    for($i = 0; $i < 12; $i++)
    {
      if($counter < count($goalResults))
      {
        if($goalResults[$counter]['month'] == $i+1)
        {
          echo "<td>$" . number_format($goalResults[$counter]['gross']) . "</td>";
          $ytdGross += $goalResults[$counter]['gross'];
          $counter++;
          
        }
        else
          echo "<td>$0</td>";
      }
      else
          echo "<td>$0</td>";
    }
    echo '<td>$' . number_format($ytdGross) . '</td>';
  echo '
  </tr>
  <tr>
    <th>$ MY GOAL $</th>';
  for($i = 0; $i < 12; $i++)
  {
    echo "<th class=agentGoal>$" . number_format($agentGoal/12) . "</th>";
  }
  echo "<th id=agentGoal onClick=updateGoal()>$" . number_format($agentGoal) . "</th>";
   echo ' 
  </tr>
</table>
</div>
</div>
</div>';

// for($i = 0; $i < date('n'); $i++)
// {
//     if($counter < count($goalResults))
//     {
//         if($goalResults[$counter]['month'] == $i+1)
//         {
//           $monthGross = $goalResults[$counter]['gross'] / ($agentGoal/12);
//           $percentOfGross = ($monthGross * 100);
//           echo '<div class="progress">
//               <div class="progress-bar bg-success" role="progressbar" style="width: ' . number_format($percentOfGross,2) . '%" aria-valuenow="' . number_format($percentOfGross,2) . 
//               '" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . "&nbsp&nbsp " . number_format($percentOfGross,2)  .'% &nbsp$' . number_format($goalResults[$counter]['gross']) . 
//               "/ $" . number_format($agentGoal/12) .'</div>
//               <div class="progress-bar progress-bar-danger" role="progressbar" style="width: ' . number_format((100 - $percentOfGross),2) . '%" aria-valuenow="' . number_format($percentOfGross,2) . 
//               '" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . "&nbsp&nbsp " . number_format((100 - $percentOfGross),2) . '%&nbsp $' . number_format(($agentGoal/12)-$goalResults[$counter]['gross']) .
//               "/ $" . number_format($agentGoal/12) . '</div>

//               </div>';
//               $counter++;
//         }
//         else
//         {
//         echo '<div class="progress">
//             <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . ' 0%</div>
//             </div>';
//         }
//     }
//     else
//     {
//       echo '<div class="progress">
//           <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">' . $months[$i] . ' 0%</div>
//           </div>';
//     }

  
// }


?>

