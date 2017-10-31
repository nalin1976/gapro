<?php
 session_start();
	include "../../../Connector.php";
	
	$strButton			= $_GET["q"];
	$intCompanyID		= $_GET["intCompanyID"];
	$pub_companyId 		= $_SESSION["FactoryID"];
	 	
if($strButton=="New")
{
	 $strCompanyCode		= $_GET["strCompanyCode"];
	 $strName				= $_GET["strName"];
	 $strAddress1			= $_GET["strAddress1"];
	 $strStreet				= $_GET["strStreet"];
	 $strCity				= $_GET["strCity"];
	 $intCountry			= $_GET["intCountry"];	 
	 $strPhone				= $_GET["strPhone"];
	 $strFax				= $_GET["strFax"];
	 $strEMail				= $_GET["strEMail"];
	 $strWeb				= $_GET["strWeb"];
	 $strRemarks			= $_GET["strRemarks"];
	 $strTINNo				= $_GET["strTINNo"];
	 $strRegNo				= $_GET["strRegNo"];
	 $strVatAcNo			= $_GET["strVatAcNo"];
	// $dblVatValue			= $_GET["dblVatValue"];
	 $strBOINo				= $_GET["strBOINo"];
	 $strTqbNo				= $_GET["strTqbNo"];
	 $reaFactroyCostPerMin	= $_GET["reaFactroyCostPerMin"];
	 $defaultFactory		= $_GET["defaultFactory"];
	 $intCurID				= $_GET["intCurID"];
	// $intManufac			= $_GET["intManufac"];
	 $accountNo				= $_GET["accountNo"];
	// $sequanceStart			= $_GET["sequenceStart"];
	// $sequenceEnd 			= $_GET["sequenceEnd"];
	 
	//Start - 02-12-2010 - Auto update the syscontrol when creating a company.
	
	//SaveSyscontrol($sequanceStart,$sequenceEnd,$pub_companyId);
	//End - 02-12-2010 - Auto update the syscontrol when creating a company.
	
	
	 if($reaFactroyCostPerMin=="")
	 	$reaFactroyCostPerMin=0;
		
	 $SQL_Update="UPDATE currencytypes SET dblRate='1' where intCurID=".$intCurID." ;"; 
	
   	 $db->ExecuteQuery($SQL_Update);
		 
	 $SQL = "insert into was_outside_companies ( strComCode,strName,strAddress1,strStreet,strCity,intCountry,strPhone,strFax,strEMail,strWeb,strRemarks,strTINNo,strRegNo,strVatAcNo,strBOINo,reaFactroyCostPerMin,strTqbNo,strDefaultInvoiceTo,strAccountNo) values ('$strCompanyCode','$strName','$strAddress1','$strStreet','$strCity','$intCountry','".$strPhone."','".$strFax."','".$strEMail."','".$strWeb."','".$strRemarks."','".$strTINNo."','".$strRegNo."','".$strVatAcNo."','".$strBOINo."','".$reaFactroyCostPerMin."','".$strTqbNo."','".$defaultFactory."','".$accountNo."');";
	//$results= $db->ExecuteQuery($SQL);
	$results=$db->AutoIncrementExecuteQuery($SQL);
	SaveSyscontrol($sequanceStart,$sequenceEnd,$results);
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
	//$dblVatValue			= $_GET["dblVatValue"];
	$strBOINo				= $_GET["strBOINo"];
	$strTqbNo				= $_GET["strTqbNo"];
	$reaFactroyCostPerMin	= $_GET["reaFactroyCostPerMin"];
	$defaultFactory			= $_GET["defaultFactory"];
	$intStatus				= $_GET["intStatus"];
	$intCurID				= $_GET["intCurID"];
	//$intManufac				= $_GET["intManufac"];
	$accountNo				= $_GET["accountNo"];
	 
	
		
	if($reaFactroyCostPerMin=="")
		$reaFactroyCostPerMin=0;
		
	$SQL_Update1="UPDATE currencytypes SET dblRate='1' where intCurID=".$intCurID." ;"; 
	
   	$db->ExecuteQuery($SQL_Update1);
	
	$SQL_Update="UPDATE was_outside_companies SET strStreet='$strStreet',strAddress1='$strAddress1',strCity='$strCity',intCountry='$intCountry', strComCode='".$strCompanyCode."',strName='".$strName."',strPhone='". $strPhone."',strFax='".$strFax."',strEMail='".$strEMail."',strWeb='".$strWeb."',strRemarks='".$strRemarks."',strTINNo='". $strTINNo."',strRegNo='".$strRegNo."',strVatAcNo='".$strVatAcNo."',strBOINo='".$strBOINo."',reaFactroyCostPerMin='". $reaFactroyCostPerMin."',strTqbNo='".$strTqbNo."',intStatus='".$intStatus."' ,strDefaultInvoiceTo='$defaultFactory',strAccountNo='". $accountNo."' where intCompanyID=".$companyId." ;"; 
	//echo $SQL_Update;
   	$updt_result=$db->RunQuery($SQL_Update);
	if($updt_result)
	echo "Updated successfully.";	
	else
	echo "Error!";		
	
}
elseif($strButton=="Delete")
{		
	$SQL="delete from was_outside_companies where intCompanyID='".$intCompanyID."';";
	$result = $db->RunQuery2($SQL);
	if(gettype($result)=='string')
	{
		echo $result;
		return;
	}
	$sql1="delete from syscontrol where intCompanyID='".$intCompanyID."' ";
	$result1 = $db->RunQuery($sql1);
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

//

function GetCompanyName($companyId)
{
global $db;
	$sql= "select strName from was_outside_companies where intCompanyID='$companyId'";	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strName"];
}
function SaveSyscontrol($companyId)
{
global $db;

$sql="select * from syscontrol";
$result=$db->RunQuery($sql);
$fieldCount = mysql_num_fields($result);
	for($i = 3; $i < $fieldCount; $i++) 
	{
		$arrayFieldName[$i] =   mysql_field_name($result,$i);
		$arrayValue[$i]		= $sequanceStart;
	}  
$arrayFieldNameList = implode(",", $arrayFieldName); 
$arrayValueList = implode(",", $arrayValue); 
$sql_insert =  "insert into syscontrol(intCompanyID,$arrayFieldNameList) value ($companyId,$arrayValueList)";
//echo $sql_insert;
$db->ExecuteQuery($sql_insert);
}
//
?>

