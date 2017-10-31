<?php 
session_start();
include("../../Connector.php");	
	$request=$_GET["REQUEST"];
	$buyername=	$_GET['BNAME'];
	$add1=	$_GET['ADD1'];
	$add2=$_GET['ADD2'];
	$add3=$_GET['ADD3'];
	$country=	$_GET['COUNTRY'];
	$phone=	$_GET['PHONE'];
	$fax=	$_GET['FAX'];
	$mail=	$_GET['MAIL'];
	$remarks=	$_GET['REMARKS'];
	$tino=	$_GET['TINO'];
	$buyerid=$_GET['ID'];
	$intId=$_GET['intId'];
	$cp=$_GET['CP1'];
	$regionId = $_GET['regionId'];

if($request=="insert") 
	{		
		
	$sql = "INSERT INTO buyers ( strBuyerCode,strName,strAddress1, strAddress2,strAddress3, strCountry, strPhone, strFax, strEMail, strRemarks, strTINNo,strContactPerson,intBuyerRegionId)
	VALUES ('$buyerid','$buyername','$add1','$add2','$add3','$country','$phone','$fax','$mail','$remarks','$tino','$cp','$regionId')";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}
		
		
	
}
if ($request=="update")
{	

	$sql = "UPDATE buyers SET strBuyerCode='$buyerid', strName='$buyername',strAddress1='$add1', strAddress2='$add2', strAddress3='$add3', strCountry='$country', strPhone='$phone', strFax='$fax', strEMail='$mail',
	strRemarks='$remarks', strTINNo='$tino',strContactPerson='$cp', intBuyerRegionId = '$regionId' WHERE strBuyerId='$intId'";
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{		
			echo "Successfully updated."; 		
		}
		

}

if ($request=="delete")
{
$sql = "update buyers 
	set
	intDel = '1'
	where
	strBuyerID = '$buyerid'";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}
	


?>