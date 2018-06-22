<?php
session_start();


// 'mediaUrl' => "http://52.11.24.75/uploadFlyers/" . rawurlencode($_POST['flyer']) . 'jpg',
require '../../databaseConnection.php';
require '../../PHPMailer/src/PHPMailer.php'; 
require '../../PHPMailer/src/Exception.php'; 
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
$mail->Subject  =  "Flyer from " . substr($_POST['flyer'], 0, -1);
$mail->Body     = $_POST['flyerMessage'] ;
// $mail->addAttachment("../../uploadFlyers/" . rawurlencode($_POST['flyer']) . 'jpg')
$mail->addStringAttachment(file_get_contents("http://52.11.24.75/uploadFlyers/" . rawurlencode($_POST['flyer']) . 'jpg'), $_POST['flyer']. 'jpg');
if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}

?>