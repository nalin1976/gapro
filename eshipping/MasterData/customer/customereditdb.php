<?php 
session_start();
include("../../Connector.php");	
$request=$_GET["REQUEST"];


$id=$_GET["ID"];
$company=$_GET["COMPANY"];
$Mlocation=$_GET["mlocation"];
$address1=$_GET["address1"];
$adddress2=$_GET["address2"];
$country=$_GET["COUNTRY"];
$phone=$_GET["PHONE"];
$fax=$_GET["FAX"];
$mails=$_GET["MAIL"];
$remarks=$_GET["REMARKS"];
$tino=$_GET["TINO"];
$tbq=$_GET["TBQ"];
$authorize=$_GET["AUTHORIZE"];
$ppc=$_GET["PPC"];
$location=$_GET["LOCATION"];
$mid=$_GET["MID"];
$vender=$_GET["VENDER"];
$reg=$_GET["REG"];
$authorize=$_GET["AUTHORIZE"];
$sequence=$_GET["SEQENCE"];
$refno=$_GET["REFNO"];
$licence=$_GET["licence"];
$facCode=$_GET["facCode"];
	
if($request=="insert") 
	{
			
	$sql = "INSERT INTO customers(intSequenceNo,strName,strMLocation,strAddress1, strAddress2, strCountry,strPhone, 
	strFax, strEMail, strRemarks, strTIN, strLocation, strTQBNo, strExportRegNo, strRefNo,   strPPCCode,
	strAuthorizedPerson,strVendorCode, strMIDCode,strCode,strLicenceNo,strFacCode) VALUES	('0','$company','$Mlocation','$address1','$adddress2', 	'$country', '$phone',
	 '$fax', '$mails', '$remarks', '$tino',  '$location', '$tbq', '$reg', '$refno',  '$ppc',  '$authorize', '$vender',	'$mid','$sequence','$licence','$facCode')";
	 
	//die($sql);

	$result = $db->RunQuery($sql) or die("error");
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
}
if ($request=="update")
{	

	$sqlup = "UPDATE customers SET intSequenceNo = '0' ,  strName = '$company' , strMLocation='$Mlocation', strAddress1 = '$address1' , strAddress2 = '$adddress2' , 
	strCountry = '$country' , strPhone = '$phone' , strFax = '$fax' , strEMail = '$mails' , strRemarks = '$remarks' , strTIN = '$tino'  , strLocation = '$location' , 
	strTQBNo = '$tbq' , strExportRegNo = '$reg' , strRefNo = '$refno' ,  RecordType = '1' , 
	strPPCCode = '$ppc' ,  strAuthorizedPerson = '$authorize' , strVendorCode = '$vender' , strMIDCode = '$mid',strCode='$sequence',strLicenceNo='$licence', strFacCode='$facCode' 
	 WHERE strCustomerID = '$id' ";
	//die($sqlup);
	 
	$resultup = $db->RunQuery($sqlup);
	
	
		if ($resultup)
		{		
			echo "Successfully updated."; 		
		}

}


if ($request=="delete")
{
/*$sql = "DELETE FROM customers 
	WHERE	strCustomerID = '$id' ";*/
	
$sql = "update customers set intDelStatus ='10' where strCustomerID = '$id'";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}
	


?>