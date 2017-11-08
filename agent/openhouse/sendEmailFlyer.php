<?php

// 'mediaUrl' => "http://52.11.24.75/uploadFlyers/" . rawurlencode($_POST['flyer']) . 'jpg',

require '../../PHPMailer/src/PHPMailer.php'; 
require '../../PHPMailer/src/Exception.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer;
$mail->setFrom('jodiaz@csumb.edu', 'Your Name');
$mail->addAddress($_POST['email'], 'My Friend');
$mail->Subject  =  "Flyer from house";
$mail->Body     = $_POST['flyerMessage'] ;
// $mail->addAttachment("../../uploadFlyers/" . rawurlencode($_POST['flyer']) . 'jpg')
$mail->addStringAttachment(file_get_contents("../../uploadFlyers/" . rawurlencode($_POST['flyer']) . 'jpg'), $_POST['flyer']. '.jpg');
if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}

?>