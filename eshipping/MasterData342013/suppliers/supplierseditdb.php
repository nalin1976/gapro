<?php 
session_start();
include("../../Connector.php");	
	$request=$_GET["REQUEST"];
	$buyername=$_GET['BNAME'];
	$add1=$_GET['ADD1'];
	$add2=$_GET['ADD2'];
	
	//die($add1);	
	$country=	$_GET['COUNTRY'];
	$phone=	$_GET['PHONE'];
	$fax=	$_GET['FAX'];
	$city=$_GET['CITY'];
	$mail=	$_GET['MAIL'];
	$remarks=	$_GET['REMARKS'];
	$tino=	$_GET['TINO'];
	$buyerid=$_GET['ID'];
	$buyername=str_replace("\'","'",$buyername);
	$buyername=str_replace("'","''",$buyername);
	$add1=str_replace("\'","''",$add1);
	$add1=str_replace("'","''",$add1);
	$add2=str_replace("\'","''",$add2);
	$add2=str_replace("'","''",$add2);

if($request=="insert") 
	{		
		
	$sql = "INSERT INTO suppliers ( strName,strAddress1, strAddress2, strCountry,strCity, strPhone, strFax, strEMail, strRemarks, strTINNo )
	VALUES ('$buyername','$add1','$add2','$country','$city','$phone','$fax','$mail','$remarks','$tino')";
	
	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
}
if ($request=="update")
{	

	$sql = "UPDATE suppliers SET strName='$buyername',strAddress1='$add1', strAddress2='$add2', strCountry='$country', strCity='$city', strPhone='$phone', strFax='$fax', strEMail='$mail',
	strRemarks='$remarks', strTINNo='$tino' WHERE strSupplierId='$buyerid'";
	//die($sql);	
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{	
					echo "Successfully updated."; 		
		}

}
if ($request=="delete")
{
$sql = "DELETE FROM suppliers WHERE strSupplierId='$buyerid'";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}
	


?>