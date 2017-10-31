<?php 
session_start();
include("../../Connector.php");	
	$request=$_GET["REQUEST"];
	$buyername=	$_GET['BNAME'];
	$add1=	$_GET['ADD1'];
	$add2=$_GET['ADD2'];
	$country=	$_GET['COUNTRY'];
	$phone=	$_GET['PHONE'];
	$fax=	$_GET['FAX'];
	$tin=$_GET['TIN'];
	$mail=	$_GET['MAIL'];
	$remarks=	$_GET['REMARKS'];
	$clerkid=$_GET['ID'];
	$widno=$_GET['widno'];
	

if($request=="insert") 
	{		
	
	
	$sql = "INSERT INTO wharfclerks  (strName,strAddress1, strAddress2, strCountry, strPhone, strFax,strTINNo,strEMail, strRemarks,strIdNo)
	VALUES ('$buyername','$add1','$add2','$country','$phone','$fax','$tin','$mail','$remarks','$widno')";
	

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
}
if ($request=="update")
{	

	$sql = "UPDATE wharfclerks SET strName='$buyername',strAddress1='$add1', strAddress2='$add2', strCountry='$country', strPhone='$phone', strFax='$fax',strTINNo='$tin', strEMail='$mail',
	strRemarks='$remarks',strIdNo='$widno'  WHERE intWharfClerkID='$clerkid'";
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{	
					echo "Successfully updated."; 		
		}

}
if ($request=="delete")
{
$sql = "DELETE FROM wharfclerks 
	WHERE intWharfClerkID='$clerkid'";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}
	


?>