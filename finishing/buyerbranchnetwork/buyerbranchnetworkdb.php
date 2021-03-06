<?php
session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 
$Request = $_GET["Request"];
$userId	 = $_SESSION["UserID"];

if($Request=="SaveData")
{
	$branchID  = $_GET["branchID"];
	$BName 	   = $_GET["BName"];
	$Buyer 	   = $_GET["Buyer"];
	$Country   = $_GET["Country"];
	$CAddress1 = $_GET["CAddress1"];
	$CAddress2 = $_GET["CAddress2"];
	$CAddress3 = $_GET["CAddress3"];
	$telNo 	   = $_GET["telNo"];
	$FaxNo     = $_GET["FaxNo"];
	$Email     = $_GET["Email"];
	$CPerson   = $_GET["CPerson"];
	$Remarks   = $_GET["Remarks"];	
	$booCheck  = checkDataAvailable($branchID);
	if($booCheck!="true")
	{
		$sql_insert = "insert into finishing_buyer_branch_network 
						(
						 strBranchName, 
						 intMotherCompany, 
						 intCountryId, 
						 strCorrespondenceAddress1, 
						 strCorrespondenceAddress2, 
						 strCorrespondenceAddress3, 
						 strTel, 
						 strFax, 
						 strEmail, 
						 strAgentName, 
						 strRemarks, 
						 intUserId
						)
					   values
					   (
					     '$BName',
						  $Buyer,
						  $Country,
						 '$CAddress1',
						 '$CAddress2',
						 '$CAddress3',
						 '$telNo',
						 '$FaxNo',
						 '$Email',
						 '$CPerson',
						 '$Remarks',
						  $userId
					   )";
		 $result_insert = $db->RunQuery($sql_insert);
		 if($result_insert)
		   echo "Saved";
		 else
		   echo "Error";
	}
	else
	{
		$sql_check="select intBuyerBranchId,strBranchName from finishing_buyer_branch_network where intBuyerBranchId!='$branchID' and strBranchName='$BName'";
		$result_check = $db->RunQuery($sql_check);
		if(mysql_num_rows($result_check)>0)
		{
			echo "cant";
		}
		else
		{
		$sql_update = "update finishing_buyer_branch_network 
						set 
						strBranchName = '$BName' , 
						intMotherCompany = '$Buyer' , 
						intCountryId = '$Country' , 
						strCorrespondenceAddress1 = '$CAddress1' , 
						strCorrespondenceAddress2 = '$CAddress2' , 
						strCorrespondenceAddress3 = '$CAddress3' , 
						strTel = '$telNo' , 
						strFax = '$FaxNo' , 
						strEmail = '$Email' , 
						strAgentName = '$CPerson' , 
						strRemarks = '$Remarks' , 
						intUserId = '$userId'
						where
						intBuyerBranchId = '$branchID' ;";
		$result_update = $db->RunQuery($sql_update);
		 if($result_update)
		   echo "Updated";
		 else
		   echo "Error";
		 }
	}
	
}
if($Request=="GetData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$branchID = $_GET["branchID"];
	
	$ResponseXML = "<XMLLoadData>\n";
	
	$sql_load = "SELECT * from finishing_buyer_branch_network where intBuyerBranchId='$branchID';";
	$result_load =$db->RunQuery($sql_load);
	while($row=mysql_fetch_array($result_load))
	{
		$ResponseXML .= "<strBranchName><![CDATA[" . $row["strBranchName"]  . "]]></strBranchName>\n";
		$ResponseXML .= "<intMotherCompany><![CDATA[" . $row["intMotherCompany"]  . "]]></intMotherCompany>\n";
		$ResponseXML .= "<intCountryId><![CDATA[" . $row["intCountryId"]  . "]]></intCountryId>\n";
		$ResponseXML .= "<Address1><![CDATA[" . $row["strCorrespondenceAddress1"]  . "]]></Address1>\n";
		$ResponseXML .= "<Address2><![CDATA[" . $row["strCorrespondenceAddress2"]  . "]]></Address2>\n";
		$ResponseXML .= "<Address3><![CDATA[" . $row["strCorrespondenceAddress3"]  . "]]></Address3>\n";
		$ResponseXML .= "<strTel><![CDATA[" . $row["strTel"]  . "]]></strTel>\n";
		$ResponseXML .= "<strFax><![CDATA[" . $row["strFax"]  . "]]></strFax>\n";
		$ResponseXML .= "<strEmail><![CDATA[" . $row["strEmail"]  . "]]></strEmail>\n";
		$ResponseXML .= "<strAgentName><![CDATA[" . $row["strAgentName"]  . "]]></strAgentName>\n";
		$ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
	}
	$ResponseXML .="</XMLLoadData>"; 
	echo $ResponseXML;
	
}
if($Request=="deleteData")
{
	$branchID = $_GET["branchID"];
	
	$sql_delete ="delete from finishing_buyer_branch_network where intBuyerBranchId = '$branchID' ; ";
	$result_delete = $db->RunQuery($sql_delete);
	if($result_delete)
		echo "Deleted";
	else
		echo "Error";
}
function checkDataAvailable($branchID)
{
	global $db;
	$sql = "select intBuyerBranchId,strBranchName from finishing_buyer_branch_network where intBuyerBranchId='$branchID';";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
	 return true;
	else
	 return false;
} 
?>