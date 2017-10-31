<?php

session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
if(strcmp($RequestType,"EventScheduleMethod")== 0)
{
	$styleId = $_GET["StyleID"];
	$result=EventScheduleMethod($styleId);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML = "<ScheduleMethod><![CDATA[" . $row["strScheduleMethod"]  . "]]></ScheduleMethod>";
		echo $ResponseXML;
		die();
	}
}

function EventScheduleMethod($styleId)
{
	global $db;
	$sql= "SELECT strScheduleMethod FROM Orders WHERE (intStyleId = '$styleId') ";
	return $db->RunQuery($sql);
}

/* SE - Style, BaseDelivery DeliverySchedule wise Event Schedule */
if(strcmp($RequestType,"BaseDelivery")== 0)
{ 
	$styleId = $_GET["StyleID"];
	$EventScheduleMethod = $_GET["EventScheduleMethod"];
	$DeliveryBPO = "#MAINRATIO";
	
	$ResponseXML2 .= "<Delivery>\n";
	$result=BaseDelivery($styleId);
	
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML2 .= "<EventScheduleMethod><![CDATA[". $EventScheduleMethod ."]]></EventScheduleMethod>\n";
		$ResponseXML2 .= "<DeliveryBPO><![CDATA[" . $DeliveryBPO . "]]></DeliveryBPO>\n";
		$ResponseXML2 .= "<BaseDeliveryDate><![CDATA[" . $row["dtDateofDelivery"]  . "]]></BaseDeliveryDate>\n";
	}
	
	$ResponseXML2 .= "</Delivery>";
	echo $ResponseXML2;
}


function BaseDelivery($styleId)
{	
	global $db;
$sql= "SELECT dtDateofDelivery FROM DeliverySchedule WHERE (intStyleId = '$styleId') AND (isDeliveryBase = 'Y') ";
	return $db->RunQuery($sql);
}

/*SD - Style, DeliverySchedule wise Event schedule (without mentioning BaseDelivery)*/
if(strcmp($RequestType,"GetDeliveries")== 0)
{ 
	$styleId = $_GET["StyleID"];
	$EventScheduleMethod = $_GET["EventScheduleMethod"];
	$ResponseXML2 .= "<Delivery>\n";
	$result=GetDeliveries($styleId);
	
	$ResponseXML2 .= "<EventScheduleMethod><![CDATA[". $EventScheduleMethod ."]]></EventScheduleMethod>\n";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML2 .= "<DeliveryDate><![CDATA[" . $row["dtDateofDelivery"]  . "]]></DeliveryDate>\n";
	}
	
	$ResponseXML2 .= "</Delivery>";
	echo $ResponseXML2;
}

function GetDeliveries($styleId)
{	
	global $db;
	$sql= "SELECT dtDateofDelivery FROM DeliverySchedule WHERE (intStyleId = '$styleId') ";
	return $db->RunQuery($sql);
}

/* SB - Style, Buyer PO wise Event Schedule */
if(strcmp($RequestType,"BaseDeliveryBPO")== 0)
{ 
	$styleId = $_GET["StyleID"];
	$EventScheduleMethod = $_GET["EventScheduleMethod"];
	$ResponseXML2 .= "<Delivery>\n";
	$result=BaseDeliveryBPO($styleId);
	
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML2 .= "<EventScheduleMethod><![CDATA[". $EventScheduleMethod ."]]></EventScheduleMethod>\n";
		$ResponseXML2 .= "<BaseDeliveryBPODate><![CDATA[" . $row["dtDateofDelivery"]  . "]]></BaseDeliveryBPODate>\n";
	}
	
	$ResponseXML2 .= "</Delivery>";
	echo $ResponseXML2;
}


function BaseDeliveryBPO($styleId)
{	
	global $db;
		$sql= " SELECT bpodelschedule.dtDateofDelivery AS dtDateofDelivery 
		FROM bpodelschedule
	 	INNER JOIN deliveryschedule ON bpodelschedule.dtDateofDelivery = deliveryschedule.dtDateofDelivery
	 	WHERE (bpodelschedule.intStyleId = '$styleId') AND (deliveryschedule.isDeliveryBase = 'Y')";
	return $db->RunQuery($sql);
}

/* SBD - Style, DeliverySchedule, Buyer PO wise Event Schedule */
if(strcmp($RequestType,"DeliveriesBPO")== 0)
{ 
	$styleId = $_GET["StyleID"];
	$EventScheduleMethod = $_GET["EventScheduleMethod"];
	$ResponseXML2 .= "<Delivery>\n";
	
	$result=DeliveriesBPO($styleId);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML2 .= "<EventScheduleMethod><![CDATA[". $EventScheduleMethod ."]]></EventScheduleMethod>\n";
		$ResponseXML2 .= "<DeliveryBPODate><![CDATA[" . $row["dtDateofDelivery"]  . "]]></DeliveryBPODate>\n";
		$ResponseXML2 .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";
	}
	
	$ResponseXML2 .= "</Delivery>";
	echo $ResponseXML2;
}


function DeliveriesBPO($styleId)
{	
	global $db;	
		$sql= "SELECT bpodelschedule.dtDateofDelivery AS dtDateofDelivery ,  bpodelschedule.strBuyerPONO AS strBuyerPONO
		FROM bpodelschedule
	 	WHERE (bpodelschedule.intStyleId = '". $styleId ."')";
	return $db->RunQuery($sql);
	echo ($sql);
}

/*******************************************************************************************************************************/

if(strcmp($RequestType,"StyleBuyer")== 0)
{ 
	$styleId = $_GET["StyleID"];
	$BaseDeliveryDate = $_GET["BaseDeliveryDate"];
	$EventScheduleMethod = $_GET["EventScheduleMethod"];
	$DeliveryBPO = $_GET["DeliveryBPO"];
	
	$result=StyleBuyer($styleId);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML3 .= "<Result>\n";
		$ResponseXML3 .= "<BaseDeliveryDate><![CDATA[" . $BaseDeliveryDate  . "]]></BaseDeliveryDate>\n";
		$ResponseXML3 .= "<EventScheduleMethod><![CDATA[" . $EventScheduleMethod  . "]]></EventScheduleMethod>\n";
		$ResponseXML3 .= "<DeliveryBPO><![CDATA[" . $DeliveryBPO  . "]]></DeliveryBPO>\n";
		$ResponseXML3 .= "<BuyerID><![CDATA[" . $row["intBuyerID"]  . "]]></BuyerID>\n";
		$ResponseXML3 .= "</Result>";
		echo $ResponseXML3;
		die();
	}
}

function StyleBuyer($styleId)
{
	global $db;
	$sql= "SELECT intBuyerID FROM Orders WHERE (intStyleId = '$styleId') ";
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"StyleDeliveryLeadTime")== 0)
{
	$styleId = $_GET["StyleID"];
	$BaseDeliveryDate = $_GET["BaseDeliveryDate"];
	$EventScheduleMethod = $_GET["EventScheduleMethod"];
	$DeliveryBPO = $_GET["DeliveryBPO"];
	$BuyerID = $_GET["BuyerID"];
	
	$result=StyleDeliveryLeadTime($styleId,$BaseDeliveryDate);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Result>\n";
		$ResponseXML .= "<BaseDeliveryDate><![CDATA[" . $BaseDeliveryDate  . "]]></BaseDeliveryDate>\n";
		$ResponseXML .= "<EventScheduleMethod><![CDATA[" . $EventScheduleMethod  . "]]></EventScheduleMethod>\n";
		$ResponseXML .= "<DeliveryBPO><![CDATA[" . $DeliveryBPO  . "]]></DeliveryBPO>\n";
		$ResponseXML .= "<BuyerID><![CDATA[" . $BuyerID  . "]]></BuyerID>\n";
		$ResponseXML .= "<LeadTime><![CDATA[" . $row["reaLeadTime"]  . "]]></LeadTime>\n";
		$ResponseXML .= "</Result>";
		echo $ResponseXML;
		die();
	}
}

function StyleDeliveryLeadTime($styleId,$BaseDeliveryDate)
{
	global $db;
	 $sql= "SELECT eventtemplateheader.reaLeadTime AS reaLeadTime
	 FROM eventtemplateheader inner join deliveryschedule ON eventtemplateheader.intSerialNO = deliveryschedule.intSerialNO WHERE (intStyleId = '". $styleId ."') AND (deliveryschedule.dtDateofDelivery = '". $BaseDeliveryDate ."')  ";
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"EventTemplates")== 0)
{
	$BuyerID = $_GET["BuyerID"];
	$LeadTime = $_GET["LeadTime"];
	$BaseDeliveryDate = $_GET["BaseDeliveryDate"];
	$Max = $_GET["Max"];

	$ResponseXML .= "<Result>\n";
	$ResponseXML .= "<BaseDeliveryDate><![CDATA[" . $BaseDeliveryDate . "]]></BaseDeliveryDate>\n";
	$ResponseXML .= "<Max><![CDATA[" . $Max . "]]></Max>\n";
	
	$result=EventTemplates($BuyerID,$LeadTime);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<EventID><![CDATA[" . $row["EventID"]  . "]]></EventID>\n";
		$ResponseXML .= "<Offset><![CDATA[" . $row["Offsets"]  . "]]></Offset>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function EventTemplates($BuyerID,$LeadTime)
{
	global $db;
	$sql= "SELECT etd.intEventID As EventID,etd.reaOffset As Offsets FROM eventtemplateheader AS eth Inner Join eventtemplatedetails AS etd ON eth.intSerialNO = etd.intSerialNo WHERE (eth.intBuyerID =  ". $BuyerID .") AND (eth.reaLeadTime =  ". $LeadTime .") ORDER BY 
etd.intEventID ASC";
	return $db->RunQuery($sql);
}

if (strcmp($RequestType,"SaveEventScheduleHeader") == 0)
{
	$styleId = $_GET["styleId"];
	$BaseDeliveryDate = $_GET["BaseDeliveryDate"];
	$BuyerID = $_GET["BuyerID"];
	$LeadTime = $_GET["LeadTime"];
	
	$result = GetMAX();
	while($row = mysql_fetch_array($result))
  	{
		$Max = $row["intMax"] + 1;
	}

	SaveEventScheduleHeader($Max,$styleId,$BaseDeliveryDate);
	
	$ResponseXML .= "<Result>\n";
	$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	$ResponseXML .= "<Max><![CDATA[". $Max ."]]></Max>\n";
	$ResponseXML .= "<BuyerID><![CDATA[". $BuyerID ."]]></BuyerID>\n";
	$ResponseXML .= "<LeadTime><![CDATA[". $LeadTime ."]]></LeadTime>\n";
	$ResponseXML .= "<BaseDeliveryDate><![CDATA[". $BaseDeliveryDate ."]]></BaseDeliveryDate>\n";
	$ResponseXML .= "</Result>"; 
	 
	echo $ResponseXML;
	
}

/* SBD Headr Save */
if (strcmp($RequestType,"SaveEventScheduleHeaderSBD") == 0)
{
	$styleId = $_GET["styleId"];
	$BaseDeliveryDate = $_GET["BaseDeliveryDate"];
	$BuyerID = $_GET["BuyerID"];
	$LeadTime = $_GET["LeadTime"];
	$DeliveryBPO = $_GET["DeliveryBPO"];
	
	$result = GetMAX();
	while($row = mysql_fetch_array($result))
  	{
		$Max = $row["intMax"] + 1;
	}

	SaveEventScheduleHeaderSBD($Max,$styleId,$BaseDeliveryDate,$DeliveryBPO);
	
	$ResponseXML .= "<Result>\n";
	$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	$ResponseXML .= "<Max><![CDATA[". $Max ."]]></Max>\n";
	$ResponseXML .= "<BuyerID><![CDATA[". $BuyerID ."]]></BuyerID>\n";
	$ResponseXML .= "<LeadTime><![CDATA[". $LeadTime ."]]></LeadTime>\n";
	$ResponseXML .= "<BaseDeliveryDate><![CDATA[". $BaseDeliveryDate ."]]></BaseDeliveryDate>\n";
	$ResponseXML .= "<DeliveryBPO><![CDATA[". $DeliveryBPO ."]]></DeliveryBPO>\n";
	$ResponseXML .= "</Result>"; 
	 
	echo $ResponseXML;
	
}
/******************/

function SaveEventScheduleHeader($Max,$styleId,$BaseDeliveryDate)
{
	global $db;
	$sql = "INSERT INTO tmp_eventscheduleheader(intScheduleId,intStyleId,dtDeliveryDate) VALUES(". $Max .",'". $styleId ."','". $BaseDeliveryDate ."')";
	$db->executeQuery($sql);
}

function SaveEventScheduleHeaderSBD($Max,$styleId,$BaseDeliveryDate,$DeliveryBPO)
{
	global $db;
	$sql = "INSERT INTO tmp_eventscheduleheader(intScheduleId,intStyleId,dtDeliveryDate,strBuyerPONO) VALUES(". $Max .",'". $styleId ."','". $BaseDeliveryDate ."','". $DeliveryBPO ."')";
	$db->executeQuery($sql);
}


function GetMAX()
{
	global $db;
	$sql = "SELECT CASE WHEN ( MAX(intScheduleId) IS NULL ) THEN 0 ELSE MAX(intScheduleId) END AS intMax  FROM tmp_eventscheduleheader ";
	return $db->RunQuery($sql);
}

if (strcmp($RequestType,"SaveEventScheduleDetails") == 0)
{
	$Max = $_GET["Max"];
	$EventID = $_GET["EventID"];
	$EstDate = $_GET["EstDate"];
	
	SaveEventScheduleDetails($Max,$EventID,$EstDate);
	
	//$ResponseXML .= "<Result><![CDATA[True]]></Result>";
	$ResponseXML .= "<Result>\n";
	$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	$ResponseXML .= "</Result>";
	 
	echo $ResponseXML;
	
}

function SaveEventScheduleDetails($Max,$EventID,$EstDate)
{
	global $db;
	$sql = "INSERT INTO tmp_eventscheduledetail(intScheduleId,intEventId,dtmEstimateDate) VALUES(". $Max .",". $EventID .",'". $EstDate ."')";
	$db->executeQuery($sql);
}
?>