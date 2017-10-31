<?php 
	
	$senderEmail = 'BulkGRN_errors@jinadasa.com';
	$senderName  = 'BulkGRN_errors';
	$reciever    = 'roshanb@jinadasa.com';
	$body		 = $_GET["body"];
	
	include "../../EmailSender.php";
	$eml =  new EmailSender();
	$eml->SendMessage($senderEmail,$senderName,$reciever,$subject,$body);
	
?>