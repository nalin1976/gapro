<?php


/**
 * @Prasad Rajapaksha 
 * @copyright 2008
 * Email Sending Module
 */

class EmailSender
{	

	public function SendMessage($senderEmail,$senderName,$reciever,$subject,$body)
	{
		$header .= "Reply-To: " . $senderName . " <" . $senderEmail .">\r\n"; 
		$header .= "Return-Path: " . $senderName . " <" . $senderEmail .">\r\n"; 
		$header .= "From: " . $senderName . " <" . $senderEmail .">\r\n"; 
		$header .= "Organization: E-Plan Web Version\r\n"; 
		$header .= "Content-Type: text/html;charset=ISO-8859-1\r\n";
		
		$xml = simplexml_load_file('../../config.xml');
		$Mailserver = $xml->ServerSettings->MailServer; 
		ini_set("SMTP",$Mailserver);
		ini_set("sendmail_from",$senderEmail);
		$result = mail($reciever, $subject, $body, $header);
		
	}
	public function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
		$file = $path.$filename;
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$name = basename($file);
		$header = "From: ".$from_name." <".$from_mail.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use diff. tyoes here
		$header .= "Content-Transfer-Encoding: base64\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$header .= $content."\r\n\r\n";
		$header .= "--".$uid."--";
		
		$xml = simplexml_load_file('config.xml');
		$Mailserver = $xml->ServerSettings->MailServer; 
		ini_set("SMTP",$Mailserver);
		ini_set("sendmail_from",$mailto);
    	if (mail($mailto, $subject, "", $header)) {
        echo "mail send OK"; // or use booleans here
   		 } else {
        echo "mail send ... ERROR!";
    	}
	}
	public function SendStyleForApproval($senderEmail,$senderName,$reciever,$StyleNo,$usermessage)
	{
		$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"> " .
					"<html xmlns=\"http://www.w3.org/1999/xhtml\">".
					"<head>".
					"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />".
					"<title>Untitled Document</title>".
					"<link href=\"css/erpstyle.css\" rel=\"stylesheet\" type=\"text/css\" />".
					"<style type=\"text/css\">".
					"<!--".
					".style2 {font-family: Arial, Helvetica, sans-serif}".
					".style3 {".
					"	color: #FF0000;".
					"	font-weight: bold;".
					"}".
					".style4 {".
					"	font-family: Verdana;".
					"	font-weight: bold;".
					"	font-size: 12px;".
					"	color: #206BA4;".
					"}".
					".style5 {".
					"	font-family: Verdana;".
					"	font-size: 9px;".
					"	color: #666666;".
					"}".
					"-->".
					"</style>".
					"</head>".					
					"<body>".
					"<table width=\"522\" cellpadding=\"0\" cellspacing=\"0\">".
					"  <tr>".
					"	<td height=\"27\" bgcolor=\"#C9E4F5\"><div align=\"center\"><span class=\"style4\">Pending Approval</span></div></td>".
					 " </tr>".
					 " <tr>".
						"<td height=\"166\" class=\"normalfnt\"><p class=\"normalfnt2Black style2\">Dear Sir / Madam,</p>".
						 " <p class=\"normalfnt2Black style2\">&nbsp;</p>".
						 " <p class=\"normalfnt2Black style2\">Style No: " . $StyleNo ." is Pending for your approval. </p>".
						 " <p class=\"normalfnt2Black style2\">&nbsp;</p>".
						 " <p class=\"normalfnt2Black style2\"><strong>Please Log in to the System and Refer the Report </strong>for get further details.</p>".
						 " <p class=\"normalfnt2Black style2\">&nbsp;</p>". 
						 " <p class=\"normalfnt2Black style2\"><br>&nbsp;" .$usermessage . "<br>&nbsp;</p>".
						 " <p class=\"normalfnt2Black style2\">Thank you.</p>".
						"<p class=\"normalfnt2bldBLACK style2\">" . $senderName . "</p></td>".
					  "</tr>".
					  "<tr>".
						"<td height=\"19\" bgcolor=\"#C9E4F5\"><div align=\"center\" class=\"style5\">".
						  "<div align=\"center\">ePlan - Web 2009. California Link (PVT) Ltd (c) All Rights Reserved.</div>".
						"</div></td>".
					  "</tr>".
					"</table>".
					"</body>".
					"</html>";
					
					$subject = $StyleNo . " is pending for your approval";
					$this->SendMessage($senderEmail,$senderName,$reciever,$subject,$message);
	}
	
	public function SendApprovedEmail($senderEmail,$senderName,$reciever,$StyleNo,$comments,$newSCNO)
	{
		$message = "<html>".
				"<head>".
				"<meta http-equiv=\"Content-Language\" content=\"en-us\">".
				"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">".
				"<title>Approved</title>".
				"<style type=\"text/css\">".
				"<!--".
				".border {".
				"	border: 1px solid #D6ECF8;".
				"}".
				".normal {".
				"	font-family: Verdana;".
				"	font-size: 11px;".
				"	color: #000000;".
				"}".
				"-->".
				"</style>".
				"</head>	".	
				"<body>		".		
				"<table width=\"600px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"border\" id=\"table1\">".
				"<tr>".
				"		<td bgcolor=\"#D6ECF8\" height=\"28\">".
				"		<table border=\"0\" width=\"100%\" id=\"table2\" cellspacing=\"0\" cellpadding=\"0\">".
				"			<tr>".
				"				<td width=\"11\">&nbsp;</td>".
				"				<td width=\"173\"><font size=\"4\" face=\"Arial\" color=\"#008000\">".
				"				Approved</font></td>".
				"				<td>&nbsp;</td>".
				"				<td width=\"82\"><b><font face=\"Verdana\">". $StyleNo ."</font></b></td>".
				"			</tr>".
				"		</table>		</td>".
				"	</tr>".
				"	<tr>".
				"		<td height=\"43\"><font face=\"Verdana\" size=\"2\">Your Style No. " . $StyleNo ." is ".
				"		Approved.</font></td>".
				"	</tr>".
				"	<tr>".
				"		<td height=\"43\"><font face=\"Verdana\" size=\"2\">Generated SC No is : " . $newSCNO .
				".</font></td>".
				"	</tr>".
				"	<tr>".
				"		<td bgcolor=\"#B0DBF2\"><b><i><font face=\"Verdana\" size=\"2\">Comments:</font></i></b></td>".
				"	</tr>".
				"	<tr>".
				"		<td height=\"21\"><span class=\"normal\">" . $comments ."</span></td>".
				"	</tr>".
				"</table>".
				"</body>".
				"</html>";
				
				$subject = $StyleNo . " is Approved";

				$this->SendMessage($senderEmail,$senderName,$reciever,$subject,$message);
	}
	
	public function SendRejectedEmail($senderEmail,$senderName,$reciever,$StyleNo,$comments)
	{
		$message = "<html>".
				"<head>".
				"<meta http-equiv=\"Content-Language\" content=\"en-us\">".
				"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">".
				"<title>Rejected</title>".
				"<style type=\"text/css\">".
				"<!--".
				".border {".
				"	border: 1px solid #D6ECF8;".
				"}".
				".normal {".
				"	font-family: Verdana;".
				"	font-size: 11px;".
				"	color: #000000;".
				"}".
				"-->".
				"</style>".
				"</head>	".	
				"<body>		".		
				"<table width=\"600px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"border\" id=\"table1\">".
				"<tr>".
				"		<td bgcolor=\"#D6ECF8\" height=\"28\">".
				"		<table border=\"0\" width=\"100%\" id=\"table2\" cellspacing=\"0\" cellpadding=\"0\">".
				"			<tr>".
				"				<td width=\"11\">&nbsp;</td>".
				"				<td width=\"173\"><font size=\"4\" face=\"Arial\" color=\"#FF0000\">".
				"				Rejected</font></td>".
				"				<td>&nbsp;</td>".
				"				<td width=\"82\"><b><font face=\"Verdana\">". $StyleNo ."</font></b></td>".
				"			</tr>".
				"		</table>		</td>".
				"	</tr>".
				"	<tr>".
				"		<td height=\"43\"><font face=\"Verdana\" size=\"2\">Your Style No. " . $StyleNo ." is ".
				"		Rejected by " .  $senderName . ".</font></td>".
				"	</tr>".
				"	<tr>".
				"		<td bgcolor=\"#FFB9B9\"><b><i><font face=\"Verdana\" size=\"2\">Comments:</font></i></b></td>".
				"	</tr>".
				"	<tr>".
				"		<td height=\"21\"><span class=\"normal\">" . $comments ."</span></td>".
				"	</tr>".
				"</table>".
				"</body>".
				"</html>";
				
				$subject = $StyleNo . " is Rejected";
				$this->SendMessage($senderEmail,$senderName,$reciever,$subject,$message);
	}
}


?>

