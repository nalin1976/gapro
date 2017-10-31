<?PHP

session_start();
include("../../Connector.php");	
$request=$_GET["REQUEST"];
$bname=str_replace("'","''",$_GET["BNAME"]);
$bcode=$_GET["BCODE"];
$scode=$_GET["SCODE"];
$add1=$_GET["ADD1"];
$add2=$_GET["ADD2"];
$phone=$_GET["PHONE"];
$fax=$_GET["FAX"];


$mail=$_GET["MAIL"];
$contactperson=$_GET["CONTACTPERSON"];
$country=$_GET["COUNTRY"];
$refno=$_GET["REFNO"];
$accname=$_GET['ACCNAME'];
$remarks=$_GET["REMARKS"];
If ($request =="insert") 
{
$sql = "INSERT INTO bank (strBankCode, strName,strAddress1, strAddress2, strCountry, strPhone, strFax, strEMail, strContactPerson, strRemarks, strRefNo, strSwiftCode, strAccName)
VALUES ('$bcode','$bname','$add1','$add2','$country','$phone','$fax','$mail','$contactperson','$remarks','$refno','$scode','$accname')";

	$result = $db->RunQuery($sql);
		if ($result){
			$sql_ms = "INSERT INTO bank (strBankCode, strName,strAddress1, strAddress2, strCountry, strPhone, strFax, strEMail, strContactPerson, strRemarks, strRefNo, strSwiftCode, strAccName)
VALUES ('$bcode','$bname','$add1','$add2','$country','$phone','$fax','$mail','$contactperson','$remarks','$refno','$scode','$accname')";
$result_ms = $msdb->RunQueryMS($sql_ms);
			echo "Successfully saved."; 	
				
		}
}

If ($request=="update")

{
//die("inside updte");
	$sql="UPDATE bank SET strBankCode='$bcode', strName='$bname', strAddress1='$add1', strAddress2='$add2', strCountry='$country', strPhone='$phone'
	,strFax='$fax', strEMail='$mail', strContactPerson='$contactperson', strRemarks='$remarks', strRefNo='$refno', strSwiftCode='$scode', strAccName='$accname'  WHERE strBankCode='$bcode'";
	//echo $sql;
	
	$result = $db->RunQuery($sql);
		if ($result)
		{
			$sql_ms="UPDATE bank SET strBankCode='$bcode', strName='$bname', strAddress1='$add1', strAddress2='$add2', strCountry='$country', strPhone='$phone'
	,strFax='$fax', strEMail='$mail', strContactPerson='$contactperson', strRemarks='$remarks', strRefNo='$refno', strSwiftCode='$scode', strAccName='$accname'  WHERE strBankCode='$bcode'";
	//echo $sql;
	
	$result_ms = $msdb->RunQueryMS($sql_ms);		
			echo "Successfully updated."; 		
		}
}
if ($request=="delete")
{
//die("$bcode");
$sql = "DELETE FROM bank WHERE strBankCode='$bcode'";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			$sql_ms = "DELETE FROM bank WHERE strBankCode='$bcode'";

			$result_ms = $msdb->RunQueryMS($sql_ms);
			echo "Successfully deleted."; 	
				
		}
		

}
		
?>