<?php
include "../../Connector.php";

$strButton			= $_GET["q"]; 
$intBranchID		= $_GET["cboBranchName"];
$strBankCode		= $_GET["cboBankName"];
$strBranchCode		= $_GET["strBranchCode"];
$strBranchName		= $_GET["strName"];
$strAddress1		= $_GET["strAddress1"];
$strStreet			= $_GET["strStreet"];
$strCity			= $_GET["strCity"];
$strCountry			= $_GET["strCountry"];
$strPhone			= $_GET["strPhone"];
$strFax				= $_GET["strFax"];
$strEMail			= $_GET["strEMail"];
$strContactPerson	= $_GET["strContactPerson"];
$strRemarks			= $_GET["strRemarks"];
$strRefNo			= $_GET["strRefNo"];
$intStatus			= $_GET["intStatus"];
$accountNo			= $_GET["AccountNo"];
$currencyId			= $_GET["CurrencyId"];

//--------Save New record------------------------------------------------
if($strButton=="New")
{		
$SQL_Insert = "INSERT INTO branch(intBankId, strBranchCode, strName, strAddress1, strStreet, strCity, strCountry, strPhone, strFax, strEMail, strContactPerson, strRemarks, strRefNo, intStatus) values ('".$strBankCode."','".$strBranchCode."','".$strBranchName."','".$strAddress1."','".$strStreet."','".$strCity."','". $strCountry."','". $strPhone."','".$strFax."','".$strEMail."','". $strContactPerson."','".$strRemarks."','".$strRefNo."','".$intStatus."')";
$result = $db->AutoIncrementExecuteQuery($SQL_Insert);
DeleteAccounts($result);
 
	if($result!="")
		echo "Saved successfully.";	
	else
		echo "Save failed.";	  	
}

//---Save Existing Record------------------------------------------------
if($strButton=="Save")
{
$SQL_Update="UPDATE branch SET intBankId='$strBankCode',strBranchCode='$strBranchCode',strName='$strBranchName',strAddress1='$strAddress1',strStreet='$strStreet',strCity='$strCity',strCountry='$strCountry',strPhone='$strPhone',strFax='$strFax',strEMail='$strEMail',strContactPerson='$strContactPerson',strRemarks='$strRemarks',strRefNo='$strRefNo',intStatus='$intStatus' WHERE intBranchId='$intBranchID'";
$result = $db->RunQuery($SQL_Update);

DeleteAccounts($intBranchID);
	if($result!="")
		echo "Updated successfully.";
	else
		echo "Update failed.";		
}

//---Delete Existing Record--------------------------------------------------------------------------------------------------
if($strButton=="delete")
{
 $branchID=$_GET["branchID"];
		
 $SQL_Delete="update branch set intStatus=10  where intBranchId='$branchID'";
 $result = $db->RunQuery($SQL_Delete);
 
	 if($result!=""){
	  echo "Deleted successfully.";
	  }
	  else{
	  echo "Delete failed.";	
	  }	
}
elseif($strButton=="SaveAccountDetails")
{
$branchId	= $_GET["BranchId"];
$accoName	= $_GET["AccoName"];
$currId	= $_GET["CurrId"];
$status = 1;
 $sql="insert into branch_accounts (intBranchId,strAccountNo,intCurrencyId,intStatus)values('$branchId','$accoName','$currId','$status');";
 $result = $db->RunQuery($sql);
}

function DeleteAccounts($branchId)
{
global $db;
$sql="delete from branch_accounts where intBranchId=$branchId";
$result = $db->RunQuery($sql);
}
?>