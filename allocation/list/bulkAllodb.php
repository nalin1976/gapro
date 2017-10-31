<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="viewAlloData")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$dfrom = $_GET["dfrom"];
$dTo = $_GET["dTo"];
//$noArray = explode('/',$no);

$arrDfrom  = explode('/',$dfrom);
$arrDto    = explode('/',$dTo);

$DateFrom = $arrDfrom[2].'-'.$arrDfrom[1].'-'.$arrDfrom[0];
$DateTo   = $arrDto[2].'-'.$arrDto[1].'-'.$arrDto[0];

$ResponseXML = "<XMLLoadDetails>\n";

$SQL = "SELECT Distinct CBH.intTransferNo,CBH.intTransferYear,DATE_FORMAT(CBH.dtmDate, '%d/%m/%Y') as dtmDate,
		O.strStyle, U.Name
		FROM commonstock_bulkheader CBH INNER JOIN  commonstock_bulkdetails CBD ON
		CBH.intTransferNo = CBD.intTransferNo AND 
		CBH.intTransferYear = CBD.intTransferYear
		INNER JOIN orders O ON O.intStyleId = CBH.intToStyleId 
		INNER JOIN useraccounts U ON U.intUserID = CBH.intUserId
		INNER JOIN bulkgrnheader BGH ON BGH.intBulkGrnNo = CBD.intBulkGrnNo AND 
		BGH.intYear = CBD.intBulkGRNYear
		WHERE CBH.intStatus=1 AND BGH.dtRecdDate BETWEEN '$DateFrom' AND '$DateTo'
		and CBH.intCompanyId='$companyId'";
		
		$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
			$AlloNo = $row["intTransferYear"].'/'.$row["intTransferNo"];
			$ResponseXML .= "<AlloNo><![CDATA[".$AlloNo."]]></AlloNo>\n";
			$ResponseXML .= "<StyleNo><![CDATA[".$row["strStyle"]."]]></StyleNo>\n";
			$ResponseXML .= "<Uname><![CDATA[".$row["Name"]."]]></Uname>\n";
			$ResponseXML .= "<AlloDate><![CDATA[".$row["dtmDate"]."]]></AlloDate>\n";
		}
		
		$ResponseXML .= "</XMLLoadDetails>\n";
echo $ResponseXML;
}
?>