<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
//Populate LeadTime Combo xml
if (strcmp($RequestType,"LoadLeadTime") == 0)
{
	$ResponseXML.= "<LeadTime>";
	$buyerId = $_GET["BuyerId"];
	$result=CheckLeadTime($buyerId);
	 
	 while($row = mysql_fetch_array($result))
  	 {
	 		$ResponseXML .= "<LeadTimeName><![CDATA[" . $row["reaLeadTime"]  . "]]></LeadTimeName>\n";
	 }
	 $ResponseXML .= "</LeadTime>";
	 echo $ResponseXML;	
}

//check ledtime existing ?
function CheckLeadTime($buyerId)
{
	global $db;
	$sql= "SELECT * FROM eventtemplateheader WHERE (intBuyerID = ". $buyerId .");";
	//echo $sql;
	return $db->RunQuery($sql);
}

//Populate Ev ents, Offset Table xml	
if (strcmp($RequestType,"LoadEventsforLeadTime") == 0)
{
	$ResponseXML.= "<EventsforLeadTime>";
	$buyerId = $_GET["BuyerId"];
	$leadTime = $_GET["LeadTime"];
	
	$result=LoadExistEventsOffsets($buyerId,$leadTime);
	 while($row = mysql_fetch_array($result))
  	 {
	 		$ResponseXML .= "<ID><![CDATA[" . $row["EventID"]  . "]]></ID>\n";
	 		$ResponseXML .= "<EventName><![CDATA[" . $row["Event"]  . "]]></EventName>\n";
			$ResponseXML .= "<Offset><![CDATA[" . $row["Offset"]  . "]]></Offset>\n";
			$ResponseXML .= "<Selected><![CDATA[True]]></Selected>\n";
	 }
	 
	$result2=LoadExistEventsOffsets2($buyerId,$leadTime);
	while($row2 = mysql_fetch_array($result2))
	{
	 		$ResponseXML .= "<ID><![CDATA[" . $row2["EventID"]  . "]]></ID>\n";
	 		$ResponseXML .= "<EventName><![CDATA[" . $row2["Event"]  . "]]></EventName>\n";
			$ResponseXML .= "<Offset><![CDATA[" . $row2["Offset"]  . "]]></Offset>\n";
			$ResponseXML .= "<Selected><![CDATA[False]]></Selected>\n";
	}
	 
	 $ResponseXML .= "</EventsforLeadTime>";
	 echo $ResponseXML;	
}

//check events offsets existing & populate if any
function LoadExistEventsOffsets($buyerId,$leadTime)
{
	global $db;
	$sql = "SELECT	e.strDescription As Event,etd.intEventID As EventID,etd.reaOffset As Offset	FROM
			eventtemplateheader AS eth
			Inner Join eventtemplatedetails AS etd ON eth.intSerialNO = etd.intSerialNo Inner Join 															            buyers AS b ON eth.intBuyerID = b.intBuyerID Inner Join 
			events AS e ON etd.intEventID = e.intEventID 
			WHERE (b.intBuyerID =  ". $buyerId .") AND (eth.reaLeadTime =  ". $leadTime .");";
			//echo $sql;
	return $db->RunQuery($sql);
}

function LoadExistEventsOffsets2($buyerId,$leadTime)
{
	global $db;
	$sql = "select intEventID AS EventID,strDescription As Event from events where intEventID not in (SELECT	e.intEventID
	 		FROM
			eventtemplateheader AS eth
			Inner Join eventtemplatedetails AS etd ON eth.intSerialNO = etd.intSerialNo inner Join 
			buyers AS b ON eth.intBuyerID = b.intBuyerID right Join 
			events AS e ON etd.intEventID = e.intEventID 
			WHERE (b.intBuyerID = ". $buyerId .") AND (eth.reaLeadTime =  ". $leadTime ."))";
	return $db->RunQuery($sql);
}

if (strcmp($RequestType,"LoadAllEvents") == 0)
{
	$ResponseXML.= "<Events>";
	$result=LoadAllEvents();
	 
	 while($row = mysql_fetch_array($result))
  	 {
		$ResponseXML .= "<ID><![CDATA[" . $row["EventID"]  . "]]></ID>\n";
		$ResponseXML .= "<EventName><![CDATA[" . $row["Event"]  . "]]></EventName>\n";
		$ResponseXML .= "<Offset><![CDATA[]]></Offset>\n";
	 }
	 $ResponseXML .= "</Events>";
	 echo $ResponseXML;	
}

function LoadAllEvents()
{
	global $db;
	$sql= "SELECT events.intEventID As EventID ,events.strDescription As Event FROM events ORDER BY events.intEventID";
	return $db->RunQuery($sql);
}

if (strcmp($RequestType,"SaveEventTemplateHeader") == 0)
{
	$buyerID = $_GET["BuyerID"];
	$leadTime = $_GET["LeadTime"];
	 
	 $Exist = CheckExistHeader($buyerID,$leadTime);
	 while($row = mysql_fetch_array($Exist))
     {
		$Max = $row["intSerialNo"];
		$AllreadyExist = true;
	 }
	 
	 if ($AllreadyExist == true)
	 {
	 	DeleteEventTemplateDetails($buyerID,$leadTime);
	 }
	 else
	 {
		$result = GetMAXSerial();
		while($row = mysql_fetch_array($result))
  	 	{
			$Max = $row["intMAX"] + 1;
	 	}
	 }	 

	 SaveEventTemplateHeader($Max,$buyerID,$leadTime);
	 
	 
	 //$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	 $ResponseXML .= "<Result>";
	 $ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 $ResponseXML .= "<ID><![CDATA[". $Max ."]]></ID>\n";
	 $ResponseXML .= "</Result>";	 
	 
	echo $ResponseXML;
}

function GetMAXSerial()
{
	global $db;
	$sql= "select MAX(intSerialNO) AS intMAX from eventtemplateheader ";
	return $db->RunQuery($sql);
}

function SaveEventTemplateHeader($Max,$buyerID,$leadTime)
{
	global $db;
	$sql= "INSERT INTO eventtemplateheader(intSerialNO,intBuyerID,reaLeadTime) VALUES($Max,$buyerID,$leadTime)";
	$db->executeQuery($sql);
	
}

function CheckExistHeader($buyerID,$leadTime)
{
	global $db;
	$sql= "select intSerialNo from eventtemplateheader where intBuyerID = ". $buyerID ." AND reaLeadTime= ". $leadTime ." ";
	return $db->RunQuery($sql);
}

if (strcmp($RequestType,"SaveEventTemplateDetails") == 0)
{
	$SerialNO = $_GET["SerialNo"];
	$ArrayID = $_GET["ArrayID"];
	$ArrayOffset = $_GET["ArrayOffset"];

	$explodeID = explode(',', $ArrayID);
	$explodeOffset = explode(',', $ArrayOffset) ;
	for ($i = 0;$i <= count($explodeID);$i++)
	{
		SaveEventTemplateDetails($SerialNO,$explodeID[$i],$explodeOffset[$i]);
	}
	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";	
	
//	 $ResponseXML .= "<Result>".$explodeID[0]."</Result>\n";
	 echo $ResponseXML;
}

function SaveEventTemplateDetails($Max,$eventID,$offset)
{
	global $db;
	$sql= "INSERT INTO eventtemplatedetails(intSerialNO,intEventID,reaOffset) VALUES($Max,$eventID,$offset)";
	$db->executeQuery($sql);
}

function DeleteEventTemplateDetails($buyerID,$leadTime)
{
	global $db;
	$sql= " DELETE etd FROM
			eventtemplatedetails AS etd
			Inner Join eventtemplateheader AS eth ON eth.intSerialNO = etd.intSerialNo
			WHERE eth.intBuyerID =  ". $buyerID ." AND eth.reaLeadTime =   ". $leadTime ." ";
	$db->executeQuery($sql);
}

?>