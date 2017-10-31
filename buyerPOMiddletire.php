<?php
session_start();
include "Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"GetBuyerPOListForCompany") == 0)
{
	 $ResponseXML = "";
	 $companyID = $_GET["CompanyID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerPOListByCompanyBomList($companyID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
		 $ResponseXML .= "<QTY><![CDATA[" . $row["intQty"]  . "]]></QTY>\n";               
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;
	
}
else if (strcmp($RequestType,"GetBuyerPOListForStyle") == 0)
{
	 $ResponseXML = "";
	 $styleID = $_GET["StyleNO"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerPOListByStyleBomList($styleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
		 $ResponseXML .= "<QTY><![CDATA[" . $row["intQty"]  . "]]></QTY>\n";               
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;
	
}

else if(strcmp($RequestType,"SaveBuyerPO") == 0)
{
	$styleID=$_GET["StyleID"];
	$buyerPO=$_GET["BuyerPO"];
	$Remarks=$_GET["Remarks"];
	$qty=$_GET["qty"];
	$countryCode=$_GET["Country"];
	saveBuyerPO($styleID,$buyerPO,$Remarks,$qty,$countryCode);
}
else if(strcmp($RequestType,"GetAcknowledgment") == 0)
{
	$ResponseXML = "";
	$ResponseXML .= "<Acknowledgment>\n";
	$styleID=$_GET["styleID"];
	$count=$_GET["count"];
	if(getAcknowledgment($styleID,$count))
	{
		$ResponseXML .= "<State><![CDATA[True]]></State>\n";
	}
	else
	{
		$ResponseXML .= "<State><![CDATA[False]]></State>\n";
	}
	$ResponseXML .= "</Acknowledgment>\n";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"DeletePos") == 0)
{
	$styleID=$_GET["styleID"];
	$ResponseXML = "";
	$ResponseXML .= "<DeleteState>\n";

	global $db;
	$sql="DELETE FROM style_buyerponos where intStyleId='".$styleID."';";
	if($db->executeQuery($sql))
	{
		$ResponseXML .= "<State><![CDATA[True]]></State>\n";
	}
	else
	{
		$ResponseXML .= "<State><![CDATA[False]]></State>\n";
	}
		$ResponseXML .= "</DeleteState>\n";
		echo $ResponseXML;
}


function getAcknowledgment($styleID,$count)
{
	global $db;
    $poCount=0;
	$sql="SELECT COUNT(strBuyerPONO) AS PoCount FROM style_buyerponos s where intStyleId='".$styleID."';";
	//echo $sql;
	$result=$db->RunQuery($sql);	 
	while($row = mysql_fetch_array($result))
	{
		$poCount=$row["PoCount"];		
	}
	if($poCount==$count)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function saveBuyerPO($styleID,$buyerPO,$Remarks,$qty,$countryCode)
{
	global $db;	
	$sql="INSERT INTO style_buyerponos(intStyleId,strBuyerPONO,strRemarks,dblQty,strCountryCode)VALUES('".$styleID."','".$buyerPO."','".$Remarks."',".$qty.",'".$countryCode."');";
	$db->executeQuery($sql);
	
}
function getBuyerPOListByCompanyBomList($companyID)
{
	global $db;
	$sql="select intStyleId,intQty from orders where intCompanyID  = " .$companyID . ";";
	return $db->RunQuery($sql);
}

function getBuyerPOListByStyleBomList($styleID)
{
	global $db;
	$sql="select intStyleId,intQty from orders where intStyleId  like '%" . $styleID . "%';";
	return $db->RunQuery($sql);
}



?>