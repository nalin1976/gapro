<?php 
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if ($RequestType=="getDateRange")
{
	$CurrencyID  = $_GET["currID"];
	$rate        = $_GET["rate"];
	$ResponseXML .="<LoadDateRange>\n";
	$SQL="select * from exchangerate where currencyID='$CurrencyID'";
	
	$ckAVofDateRange = $db->CheckRecordAvailability($SQL);
	
	if($ckAVofDateRange == '1')
	{
		$result=$db->RunQuery($SQL);
		while ($row=mysql_fetch_array($result))
		{		
			 $ResponseXML .= "<DateFrom><![CDATA[" . $row["dateFrom"]  . "]]></DateFrom>\n";
			 $ResponseXML .= "<DateTo><![CDATA[" . $row["dateTo"]  . "]]></DateTo>\n";
			 $ResponseXML .= "<CurrID><![CDATA[" . $CurrencyID  . "]]></CurrID>\n";
			  $ResponseXML .= "<rate><![CDATA[" . $rate  . "]]></rate>\n";
		}
	}
	else
	{
		$dfrom = 'NA';
		$dto   = 'NA';
		$ResponseXML .= "<DateFrom><![CDATA[" . $dfrom  . "]]></DateFrom>\n";
		$ResponseXML .= "<DateTo><![CDATA[" . $dto  . "]]></DateTo>\n";
		$ResponseXML .= "<CurrID><![CDATA[" . $CurrencyID  . "]]></CurrID>\n";
		 $ResponseXML .= "<rate><![CDATA[" . $rate  . "]]></rate>\n";
	}
	$ResponseXML .="</LoadDateRange>";
	echo $ResponseXML;
}

if ($RequestType=="SaveExRate")
{
	$CurrencyID  = $_GET["currID"];
	$Dfrom       = $_GET["Dfrom"];
	//$Dto         = $_GET["Dto"];
	$rate        = $_GET["rate"];
	
	updateStatus($CurrencyID,$Dfrom);
	DeleteSameExRate($CurrencyID,$Dfrom);
	$SQL = "insert into exchangerate 
	(currencyID, 
	dateFrom, 
	rate,
	intStatus
	)
	values
	('$CurrencyID', 
	'$Dfrom', 
	'$rate',
	'1'
	)";
	//echo $SQL;
	$result=$db->RunQuery($SQL);
	
}
if ($RequestType=="deleteExRate")
{
	$CurrencyID  = $_GET["currID"];
	$Dfrom       = $_GET["dfrom"];
	$rate        = $_GET["exRate"];
	
	$SQL = "delete from exchangerate where currencyID='$CurrencyID' and dateFrom='$Dfrom' and rate='$rate' ";
	$result=$db->RunQuery($SQL);
	$ResponseXML .="<DelResponse>\n";
	if($result == 1)
	{
		$ResponseXML .= "<Result><![CDATA[".'True'."]]></Result>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[".'False'."]]></Result>\n";
	}
	$ResponseXML .="</DelResponse>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadCurrencyToGrid")
{
$ResponseXML ="<DelResponse>\n";
	$sql = "Select e.currencyID, c.strTitle, e.dateFrom, e.rate
		from currencytypes c inner join exchangerate e on
		c.intCurID = e.currencyID where e.intStatus=1 
		group by e.currencyID,e.dateFrom order by c.strTitle,e.dateFrom";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<CurrencyId><![CDATA[".$row["currencyID"]."]]></CurrencyId>\n";
		$ResponseXML .= "<Title><![CDATA[".$row["strTitle"]."]]></Title>\n";
		$ResponseXML .= "<DateFrom><![CDATA[".$row["dateFrom"]."]]></DateFrom>\n";
		$ResponseXML .= "<Rate><![CDATA[".$row["rate"]."]]></Rate>\n";
		$A = CheckBaseCurrency($row["currencyID"]);
		$ResponseXML .= "<DefaultCurrency><![CDATA[".$A."]]></DefaultCurrency>\n";
	}
$ResponseXML .="</DelResponse>";
echo $ResponseXML ;
}

function updateStatus($CurrencyID,$Dfrom)
{
global $db;
	$SQL = "update exchangerate 
	set
	intStatus = '0'	
	where
	currencyID = '$CurrencyID';";
	
	
	$db->RunQuery($SQL);
	
}
function DeleteSameExRate($CurrencyID,$Dfrom)
{
global $db;
	$sql="delete from exchangerate where currencyID='$CurrencyID' and dateFrom='$Dfrom'";
	$db->RunQuery($sql);
}
function CheckBaseCurrency($currencyId)
{
global $db;	
	$sql="select intBaseCurrency from systemconfiguration where intBaseCurrency='$currencyId'";	
	$result=$db->RunQuery($sql);
	$boo = false;
	while($row=mysql_fetch_array($result))
	{
		$boo = true;
	}
	return $boo;	
}
?>