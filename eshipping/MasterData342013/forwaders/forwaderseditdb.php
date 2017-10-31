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
	$charg=$_GET['CHARG'];
	$mail=	$_GET['MAIL'];
	$remarks=	$_GET['REMARKS'];
	$buyerid=$_GET['ID'];
	

if($request=="insert") 
	{		
	
	
	$sql = "INSERT INTO forwaders (strName,strAddress1, strAddress2, strCountry, strPhone, strFax,dblDOCharges,strEMail, strRemarks)
	VALUES ('$buyername','$add1','$add2','$country','$phone','$fax','$charg','$mail','$remarks')";
	

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
}
if ($request=="update")
{	

	$sql = "UPDATE forwaders SET strName='$buyername',strAddress1='$add1', strAddress2='$add2', strCountry='$country', strPhone='$phone', strFax='$fax',dblDOCharges='$charg', strEMail='$mail',
	strRemarks='$remarks'  WHERE intForwaderID='$buyerid'";
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{	
					echo "Successfully updated."; 		
		}

}
if ($request=="delete")
{
$sql = "DELETE FROM forwaders WHERE intForwaderID='$buyerid'";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}
	


?>