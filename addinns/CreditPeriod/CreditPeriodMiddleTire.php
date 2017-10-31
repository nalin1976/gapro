<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"DeleteCredit") == 0)
{
	$creditID = $_GET["creditID"];
	$ResponseXML .= "<RequestDetails>\n";	
	DeleteCreditPeriodDetails($creditID);
	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"NewCreditPedid")==0)
{
	$creditId			= $_GET["creditId"];
	$strCreditPeriod 	= $_GET["creditPeriod"];
	$dblNoOfDays		= $_GET["noOfDays"];
	$intStatus			= $_GET["intStatus"];
	$ResponseXML .= "<RequestDetails>\n";
	$ResponseXML .= "<Result><![CDATA[". AddCreditTypeDetails($strCreditPeriod, $dblNoOfDays,$creditId,$intStatus) ."]]></Result>\n";
	$ResponseXML .= "<intStatus><![CDATA[". $intStatus ."]]></intStatus>\n";
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}

function DeleteCreditPeriodDetails($CreditID)
{
	global $db;
	$sql="delete from creditperiods WHERE intSerialNO=$CreditID;";
	$db->executeQuery($sql);
	return true;
}

function AddCreditTypeDetails($strCreditType, $dblNoOfDays,$creditId,$intStatus)
{
	global $db;
	$sql = "SELECT strDescription FROM creditperiods WHERE intSerialNO = '$creditId';";
	//echo $sql ;
	$result = $db->RunQuery($sql);
	$rows = mysql_num_rows($result);
	if ($rows > 0)
	{
		if(checkCreditDays($dblNoOfDays,$strCreditType) > 0){
			return -1;
		}
		else {
			$sql = "UPDATE creditperiods SET dblNoOfDays =$dblNoOfDays ,strDescription = '$strCreditType',
			intStatus=$intStatus WHERE intSerialNO = '$creditId';";
			$affrows = $db->AffectedExecuteQuery($sql);
			if ( $affrows != 0 ) return -2;
		}
	}
	else
	{	if(checkCreditDays($dblNoOfDays,$strCreditType) > 0){
			return -1;
		}
		else {
			$sql = "INSERT INTO creditperiods (strDescription,dblNoOfDays,intStatus) VALUES ('$strCreditType',$dblNoOfDays,$intStatus);";
			$newID = $db->AutoIncrementExecuteQuery($sql);
			return $newID;
		}
	}
	return -2;
}

function checkCreditDays($dblNoOfDays,$strCreditType){
	global $db;
	$sql="select * from creditperiods where dblNoOfDays ='$dblNoOfDays' and strDescription <> '$strCreditType';";
	$res=$db->RunQuery($sql);
	return mysql_num_rows($res);
}
?>