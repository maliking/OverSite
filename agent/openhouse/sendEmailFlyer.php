<?php

// 'mediaUrl' => "http://52.11.24.75/uploadFlyers/" . rawurlencode($_POST['flyer']) . 'jpg',

require '../../PHPMailer/src/PHPMailer.php'; 

$mail = new PHPMailer;
$mail->setFrom('jodiaz@csumb.edu', 'Your Name');
$mail->addAddress($_POST['email'], 'My Friend');
$mail->Subject  =  "Flyer from house";
$mail->Body     = $_POST['flyerMessage'] ;
// $mail->addAttachment("../../uploadFlyers/" . $_POST['flyer'] . 'jpg')
if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}

?>