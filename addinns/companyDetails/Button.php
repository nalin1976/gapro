<?php
 session_start();
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
	$intCompanyID=$_GET["intCompanyID"];
	 	
if($strButton=="New")
{
	 $strCompanyCode=	$_GET["strCompanyCode"];
	 $strName		=	$_GET["strName"];
	 $strAddress1	=	$_GET["strAddress1"];
	 $strStreet		=	$_GET["strStreet"];
	 $strCity		=	$_GET["strCity"];
	 $intCountry	=	$_GET["intCountry"];
	 
	 $strPhone=$_GET["strPhone"];
	 $strFax=$_GET["strFax"];
	 $strEMail=$_GET["strEMail"];
	 $strWeb=$_GET["strWeb"];
	 $strRemarks=$_GET["strRemarks"];
	 $strTINNo=$_GET["strTINNo"];
	 $strRegNo=$_GET["strRegNo"];
	 $strVatAcNo=$_GET["strVatAcNo"];
	 $dblVatValue=$_GET["dblVatValue"];
	 $strBOINo=$_GET["strBOINo"];
	 $strTqbNo=$_GET["strTqbNo"];
	 $reaFactroyCostPerMin=$_GET["reaFactroyCostPerMin"];
	 $defaultFactory=$_GET["defaultFactory"];
	 $intCurID	= $_GET["intCurID"];
	 $intManufac= $_GET["intManufac"];
	 $accountNo= $_GET["accountNo"];
		 
	 if($dblVatValue=="")
	 	$dblVatValue=0;
	 if($reaFactroyCostPerMin=="")
	 	$reaFactroyCostPerMin=0;
		
	 $SQL_Update="UPDATE currencytypes SET dblRate='1' where intCurID=".$intCurID." ;"; 
	
   	 $db->ExecuteQuery($SQL_Update);
		 
	 $SQL = "insert into companies ( strComCode,strName,strAddress1,strStreet,strCity,intCountry,strPhone,strFax,strEMail,strWeb,strRemarks,strTINNo,strRegNo,strVatAcNo,dblVatValue,strBOINo,reaFactroyCostPerMin,strTqbNo,strDefaultInvoiceTo,intManufacturing,strAccountNo) values ('$strCompanyCode','$strName','$strAddress1','$strStreet','$strCity','$intCountry','".$strPhone."','".$strFax."','".$strEMail."','".$strWeb."','".$strRemarks."','".$strTINNo."','".$strRegNo."','".$strVatAcNo."','".$dblVatValue."','".$strBOINo."','".$reaFactroyCostPerMin."','".$strTqbNo."','".$defaultFactory."','".$intManufac."','".$accountNo."');";
	//echo $SQL;
	$results= $db->ExecuteQuery($SQL);
	 if($results)
	 echo "Saved successfully.";
	 else
	 echo "Error";
	 
}

elseif($strButton=="Save")
{   
	$companyId				= $_GET["intCompanyID"];
	$strCompanyCode			= $_GET["strCompanyCode"];
	$strName				= $_GET["strName"];
	$strAddress1			= $_GET["strAddress1"];
	$strStreet				= $_GET["strStreet"];
	$strCity				= $_GET["strCity"];
	$intCountry				= $_GET["intCountry"];
	
	$strPhone				= $_GET["strPhone"];
	$strFax					= $_GET["strFax"];
	$strEMail				= $_GET["strEMail"];
	$strWeb					= $_GET["strWeb"];
	$strRemarks				= $_GET["strRemarks"];
	$strTINNo				= $_GET["strTINNo"];
	$strRegNo				= $_GET["strRegNo"];
	$strVatAcNo				= $_GET["strVatAcNo"];
	$dblVatValue			= $_GET["dblVatValue"];
	$strBOINo				= $_GET["strBOINo"];
	$strTqbNo				= $_GET["strTqbNo"];
	$reaFactroyCostPerMin	= $_GET["reaFactroyCostPerMin"];
	$defaultFactory			= $_GET["defaultFactory"];
	$intStatus				= $_GET["intStatus"];
	$intCurID				= $_GET["intCurID"];
	$intManufac				= $_GET["intManufac"];
	 $accountNo= $_GET["accountNo"];
	 
	if($dblVatValue=="")
		$dblVatValue=0;
		
	if($reaFactroyCostPerMin=="")
		$reaFactroyCostPerMin=0;
		
	$SQL_Update1="UPDATE currencytypes SET dblRate='1' where intCurID=".$intCurID." ;"; 
	
   	$db->ExecuteQuery($SQL_Update1);
	
	$SQL_Update="UPDATE companies SET strStreet='$strStreet',strCity='$strCity',intCountry='$intCountry', intManufacturing='$intManufac', strComCode='".$strCompanyCode."',strName='".$strName."',strAddress1='". $strAddress1."',strPhone='". $strPhone."',strFax='".$strFax."',strEMail='".$strEMail."',strWeb='".$strWeb."',strRemarks='".$strRemarks."',strTINNo='". $strTINNo."',strRegNo='".$strRegNo."',strVatAcNo='".$strVatAcNo."',dblVatValue=". $dblVatValue.",strBOINo='".$strBOINo."',reaFactroyCostPerMin='". $reaFactroyCostPerMin."',strTqbNo='".$strTqbNo."',intStatus='".$intStatus."' ,strDefaultInvoiceTo='$defaultFactory',strAccountNo='". $accountNo."' where intCompanyID=".$companyId." ;"; 
	//echo $SQL_Update;
   	$updt_result=$db->RunQuery($SQL_Update);
	if($updt_result)
	echo "Updated successfully.";	
	else
	echo "Error!";		
	
}
elseif($strButton=="Delete")
{		
	$SQL="delete from companies where intCompanyID='".$intCompanyID."';";
	 $result = $db->RunQuery2($SQL);
	 if(gettype($result)=='string')
	 {
		echo $result;
		return;
	 }
	
	 echo "Deleted successfully.";
}
else if($strButton=="loadCurrency")
{
			$SQL="SELECT currencytypes.strCurrency,currencytypes.strTitle,currencytypes.dblRate FROM currencytypes WHERE currencytypes.intStatus<>10 order by currencytypes.strTitle;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCurrency"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
}
?>

