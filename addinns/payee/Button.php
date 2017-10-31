<?php
	include "../../Connector.php";

	$strButton=$_GET["q"];
	
if($strButton=="New")
{ 
$intPayeeID=$_GET["intPayeeID"];
$strTitle=$_GET["strTitle"];
//$strTitle = str_replace("'","''",$strTitle);
$strAddress1=$_GET["strAddress1"];
$strAddress2=$_GET["strAddress2"];
$strStreet=$_GET["strStreet"];
$strCity=$_GET["strCity"];
$strState=$_GET["strState"];
$strCountry=$_GET["strCountry"];
$strZipCode=$_GET["strZipCode"];
$strPhone=$_GET["strPhone"];
$strEMail=$_GET["strEMail"];
$strFax=$_GET["strFax"];
$strWeb=$_GET["strWeb"];
$strRemarks=$_GET["strRemarks"];
$intStatus=$_GET["intStatus"];
if(empty($strCountry))
	$strCountry=0;
		
	$SQL ="insert into payee(strTitle,strAddress1,strStreet,strCity,strState,strCountry,strZipCode,strPhone,strEMail,strFax,strWeb,strRemarks,intStatus) values ('".$strTitle."','".$strAddress1."','".$strStreet."','".$strCity."','".$strState."','".$strCountry."','".$strZipCode."','".$strPhone."','".$strEMail."','".$strFax."','".$strWeb."','".$strRemarks."','".$intStatus."');";
	
	$db->ExecuteQuery($SQL);
	echo "Saved successfully.";
		
}	
elseif($strButton=="Save")
{
$intPayeeID=$_GET["intPayeeID"];
$strTitle=$_GET["strTitle"];
//$strTitle = str_replace("'","''",$strTitle);
$strAddress1=$_GET["strAddress1"];
$strAddress2=$_GET["strAddress2"];
$strStreet=$_GET["strStreet"];
$strCity=$_GET["strCity"];
$strState=$_GET["strState"];
$strCountry=$_GET["strCountry"];
$strZipCode=$_GET["strZipCode"];
$strPhone=$_GET["strPhone"];
$strEMail=$_GET["strEMail"];
$strFax=$_GET["strFax"];
$strWeb=$_GET["strWeb"];
$strRemarks=$_GET["strRemarks"];
$intStatus=$_GET["intStatus"];
	
if(empty($strCountry))
	$strCountry=0;
	
	$SQL_Update="UPDATE payee SET strTitle='".trim($strTitle)."',strAddress1='".$strAddress1."',strAddress2='".$strAddress2."',strStreet='".$strStreet."',strCity='".$strCity."',strState='".$strState."',strCountry='".$strCountry."',strZipCode='".$strZipCode."',strPhone='".$strPhone."',strEMail='".$strEMail."',strFax='".$strFax."',strWeb='".$strWeb."',strRemarks='".$strRemarks."',intStatus='".$intStatus."' where intPayeeID='".$intPayeeID."';";
	$db->ExecuteQuery($SQL_Update);		
	echo "Updated successfully.";		  
}			 
elseif($strButton=="Delete")
{		
	$intPayeeID=$_GET["intPayeeID"];
	$SQL="DELETE FROM payee  where intPayeeID='".$intPayeeID."';";
		 
	$db->ExecuteQuery($SQL);		
	echo "Deleted successfully.";
}
elseif($strButton=="clearReq")
{
	$sql="SELECT intPayeeID,strTitle FROM payee where intStatus<>10 order by strTitle ASC";
	$res=$db->ExecuteQuery($sql);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($res))
	{
		echo "<option value='".$row['intPayeeID']."'>".$row['strTitle']."</option>";
	}
}
else if($strButton=="LoadPayeeZipCode")
{
$countryId = $_GET["countryId"];
	$sql ="select strZipCode from country where intConID='$countryId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		echo $row["strZipCode"];
	}
}		
?>
