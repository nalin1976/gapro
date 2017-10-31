<?php
include "Connector.php";
include "EmailSender.php";
$serverIp = $_SERVER["SERVER_ADDR"];
$eml =  new EmailSender();
$fieldName = 'intFirstAppUserId';
$body = 'test';
$eml->SendMail($fieldName,$body,$sender,$reciever,$subject);
echo "Email Sent";
?>

