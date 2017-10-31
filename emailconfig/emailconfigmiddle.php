<?php
$backwardseperator = "../";
	include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="LoadDetails")
{
$userId = $_GET["UserId"];
$permissionId = $_GET["permissionId"];

$ResponseXML = "<XMLLoadDetails>\n";

	$sql="select strUserEmails from emails where intUserId=$userId and intPermissionId=$permissionId";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	
	$privilageList = $row["strUserEmails"];
		$privil=explode(",",$privilageList);
		$arrayCount=sizeof($privil);
		$PrivilageLength=strlen($privilageList);
		foreach($privil AS $values)
		{
			$emailAccount = GetEmailAccount($values);
			if($emailAccount!=""){
				$ResponseXML .= "<UserId><![CDATA[" . $values  . "]]></UserId>\n";
				$ResponseXML .= "<EmailAccount><![CDATA[" . $emailAccount  . "]]></EmailAccount>\n";
			}
		}		

$ResponseXML .= "</XMLLoadDetails>";
echo $ResponseXML;
}
function GetEmailAccount($userId)
{
	global $db;
	$sql="select UserName from useraccounts where intUserID='$userId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$emalAccount = $row["UserName"];
	}
	return $emalAccount;
}
?>