<?php
session_start();
$license = $_GET['license'];
$script = shell_exec('python pyScriptAgentScraper.py 2>&1 ' . $license);
$result = json_decode($script, true);
// echo $result['name'];
// echo $result['lic'];
// echo $result['expirationDate'];
echo json_encode($result);
?>