<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require '../databaseConnection.php';
require '../PHPMailer/src/PHPMailer.php'; 
require '../PHPMailer/src/Exception.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dbConn = getConnection();
$agentEmailSql = "SELECT firstName, lastName, email FROM UsersInfo WHERE userId = :userId";
$stmt = $dbConn->prepare($agentEmailSql);
$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];
$stmt->execute($namedParameters);
$result = $stmt->fetch();

$mail = new PHPMailer;
$mail->setFrom($result['email'], $result['firstName'] . " " . $result['lastName']);
$mail->addAddress($_POST['email']);
$mail->Subject  =  "Follow up from openHouse";
$mail->Body     = $_POST['emailText'];
if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}

?>