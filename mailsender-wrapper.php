<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("mailsender/src/Exception.php");
require_once("mailsender/src/PHPMailer.php");
require_once("mailsender/src/SMTP.php");

$mail = new PHPMailer(true);
$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->Host = $mailhost;
$mail->SMTPAuth = true;
$mail->Username = $mailusername;
$mail->Password = $mailpassword;
$mail->SMTPSecure = $securitymethod;
$mail->Port = $smtpport;
$mail->setFrom($mailsenderaddr, $mailsender);
$mail->addAddress($mailreceiveraddr, $mailreceiver);

$mail -> isHTML(false);
$mail -> CharSet = "UTF-8";

?>
