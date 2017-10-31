<?php

session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
if(strcmp($RequestType,"LoadStyles")== 0)
{
	$ResponseXML .= "<Result>\n";
	$result=LoadStyles();
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Style><![CDATA[" . $row["StyleID"]  . "]]></Style>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadStyles()
{
	global $db;
	$sql= "SELECT DISTINCT orders.intStyleId AS StyleID FROM eventscheduleheader
			INNER JOIN orders ON eventscheduleheader.intStyleId = orders.intStyleId 
			WHERE orders.intStatus NOT IN (12,13) 
			ORDER BY orders.intStyleId ASC ;" ;
	
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadDeliveryDates")== 0)
{
	$StyleID = $_GET["styleId"];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadDeliveryDates($StyleID);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<DeliveryDate><![CDATA[" . $row["DeliveryDate"]  . "]]></DeliveryDate>\n";
		$ResponseXML .= "<DisplayDate><![CDATA[" . $row["DisplayDate"]  . "]]></DisplayDate>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

if(strcmp($RequestType,"LoadBuerPO")== 0)
{
	$StyleID = $_GET["styleId"];
	$DeliveryDate = $_GET["DeliveryDate"];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadBuyerPOs($StyleID,$DeliveryDate);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<BuyerPO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPO>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadDeliveryDates($StyleID)
{
	global $db;
   $sql= "SELECT DISTINCT eventscheduleheader.dtDeliveryDate AS DeliveryDate, DATE_FORMAT(eventscheduleheader.dtDeliveryDate, '%Y %b %d')  AS DisplayDate FROM eventscheduleheader
			WHERE (eventscheduleheader.strStyleId = '". $StyleID ."') 
			ORDER BY eventscheduleheader.dtDeliveryDate ASC ";

	return $db->RunQuery($sql);
}

function LoadBuyerPOs($StyleID,$DeliveryDate)
{
	global $db;
	$sql= "SELECT strBuyerPONO FROM eventscheduleheader WHERE strStyleId = '$StyleID' AND dtDeliveryDate = '$DeliveryDate' ";
	
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadEventScheduleData")== 0)
{
	$StyleID = $_GET["StyleId"];
	$DeliveryDate = $_GET["DeliveryDate"];
	$buyerPO = $_GET["buyerPO"];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadEventScheduleData($StyleID,$DeliveryDate,$buyerPO);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<ScheduleID><![CDATA[" . $row["ScheduleID"]  . "]]></ScheduleID>\n";
		$ResponseXML .= "<EventID><![CDATA[" . $row["EventID"]  . "]]></EventID>\n";
		$ResponseXML .= "<Event><![CDATA[" . $row["Event"]  . "]]></Event>\n";
		$ResponseXML .= "<EstDate><![CDATA[" . $row["EstDate"]  . "]]></EstDate>\n";
		$ResponseXML .= "<ChngDate><![CDATA[" . $row["ChngDate"]  . "]]></ChngDate>\n";
		$ResponseXML .= "<CompDate><![CDATA[" . $row["CompDate"]  . "]]></CompDate>\n";
		$ResponseXML .= "<ChngReason><![CDATA[" . $row["ChngReason"]  . "]]></ChngReason>\n";	
		$ResponseXML .= "<DateDiff><![CDATA[" . $row["diff"]  . "]]></DateDiff>\n";
		$ResponseXML .= "<ChaneDateDiff><![CDATA[" . $row["changediff"]  . "]]></ChaneDateDiff>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";		
		if (substr($row["diff"],0,1)=='-')
			$ResponseXML .= "<ProssDiff><![CDATA[" . substr($row["diff"],1) . "]]></ProssDiff>\n";
		else
			$ResponseXML .= "<ProssDiff><![CDATA[" . ($row["diff"]*-1) . "]]></ProssDiff>\n";
			
			
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadEventScheduleData($StyleID,$DeliveryDate,$buyerPO)
{
	global $db;
	 $sql= "SELECT
			eventscheduledetail.intScheduleId AS ScheduleID,
			eventscheduledetail.intEventId AS EventID,
			DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d')  AS EstDate,
			eventscheduledetail.dtChangeDate AS ChngDate,
			eventscheduledetail.dtCompleteDate AS CompDate,
			eventscheduledetail.strChangedReason AS ChngReason,
			events.strDescription AS Event,
			DATEDIFF(CURDATE(),dtmEstimateDate) AS diff,
			DATEDIFF(CURDATE(),dtChangeDate) AS changediff,
			eventscheduleheader.intStatus
			FROM
			eventscheduleheader
			Inner Join eventscheduledetail ON eventscheduleheader.intScheduleId = eventscheduledetail.intScheduleId
			Inner Join events ON eventscheduledetail.intEventId = events.intEventID
			WHERE
			(eventscheduleheader.strStyleId =  '". $StyleID ."') 
			AND (eventscheduleheader.dtDeliveryDate =  '". $DeliveryDate ."')			
			AND (eventscheduleheader.strBuyerPONO =  '". $buyerPO ."')
			ORDER BY
			events.intEventID ASC";
			//echo $sql;
			/*
						AND
			(eventscheduleheader.dtDeliveryDate =  '". $DeliveryDate ."')
			AND (eventscheduleheader.strBuyerPONO =  '". $buyerPO ."')*/
	return $db->RunQuery($sql);
}


if (strcmp($RequestType,"SaveEventSchedule") == 0)
{
	$completedBY = $_SESSION["UserID"];
	$ArrscheduleID = $_GET["ArrscheduleID"];
	$ArreventID = $_GET["ArreventID"];
	$ArrchngDate = $_GET["ArrchngDate"];
	$ArrchngReason = $_GET["ArrchngReason"];
	$ArrcompDate = $_GET["ArrcompDate"];

	$explodeScheduleID = explode(',', $ArrscheduleID) ;
	$explodeEventID = explode(',', $ArreventID);
	$explodeChngDate = explode(',', $ArrchngDate) ;
	$explodeChngReason = explode(',', $ArrchngReason) ;
	$explodeCompDate = explode(',', $ArrcompDate) ;
	
	for ($i = 0;$i <= count($explodeEventID);$i++)
	{
		if (strlen($explodeChngDate[$i]) > 0 )
		{
			$chngDate = "";
			$chngDateD = substr($explodeChngDate[$i],0,2);
			$chngDateM = substr($explodeChngDate[$i],3,2);
			$chngDateY = substr($explodeChngDate[$i],6,4);
			$chngDate = $chngDateY . "-" . $chngDateM ."-". $chngDateD ;
		}
		else
		{
			$chngDate = "NULL" ;
		}
			
		//echo $explodeChngDate[$i];
		//echo $explodeCompDate[$i];
		
		if (strlen($explodeCompDate[$i]) > 0 )
		{
			$compDate = "";
			$compDateD = substr($explodeCompDate[$i],0,2);
			$compDateM = substr($explodeCompDate[$i],3,2);
			$compDateY = substr($explodeCompDate[$i],6,4);
			$compDate = $compDateY ."-". $compDateM ."-". $compDateD ;
		}
		else
		{
			$compDate = "NULL" ;			
		}

		SaveEventSchedule($explodeScheduleID[$i],$explodeEventID[$i],$chngDate,$explodeChngReason[$i],$compDate,$completedBY);
	}
	$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";	
	echo $ResponseXML;
}

function SaveEventSchedule($ScheduleID,$EventID,$ChngDate,$ChngReason,$CompDate,$completedBy)
{
	global $db;
	$sql = "select intCompletedBy from eventscheduledetail WHERE (intScheduleId = '". $ScheduleID ."') AND (intEventId = '". $EventID ."') ";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		if($row["intCompletedBy"] != "")
		return;
	}
	
	if($ChngDate == "NULL" AND $CompDate == "NULL")
	{
	$sql= "UPDATE eventscheduledetail SET dtChangeDate = NULL, dtCompleteDate = NULL , strChangedReason = '". $ChngReason ."' WHERE (intScheduleId = '". $ScheduleID ."') AND (intEventId = '". $EventID ."') ";
	}
	elseif($ChngDate != "NULL" AND $CompDate == "NULL")
	{
	$sql= "UPDATE eventscheduledetail SET dtChangeDate = '". $ChngDate ."', dtCompleteDate = NULL, strChangedReason = '". $ChngReason ."' WHERE (intScheduleId = '". $ScheduleID ."') AND (intEventId = '". $EventID ."') ";
	}
	elseif($ChngDate == "NULL" AND $CompDate != "NULL")
	{
	$sql= "UPDATE eventscheduledetail SET dtChangeDate = NULL, intCompletedBy='$completedBy', dtCompleteDate = '". $CompDate ."' , strChangedReason = '". $ChngReason ."' WHERE (intScheduleId = '". $ScheduleID ."') AND (intEventId = '". $EventID ."') ";
	}
	elseif($ChngDate != "NULL" AND $CompDate != "NULL")
	{
	$sql= "UPDATE eventscheduledetail SET intCompletedBy='$completedBy',dtChangeDate = '". $ChngDate ."', dtCompleteDate = '". $CompDate ."' , strChangedReason = '". $ChngReason ."' WHERE (intScheduleId = '". $ScheduleID ."') AND (intEventId = '". $EventID ."') ";
	}
	$db->executeQuery($sql);
	
}

//Start 05-05-2010
if(strcmp($RequestType,"SendToApproval") == 0)
{
	$styleId	= $_GET["StyleId"];
		$sql="update eventscheduleheader set intStatus=1 where strStyleId='$styleId';";
		$db->RunQuery($sql);
}
if(strcmp($RequestType,"ApproveSchedule") == 0)
{
		$styleId	= $_GET["StyleId"];
		$sql="update eventscheduleheader set intStatus=2 where intStyleId='$styleId';";
		$db->RunQuery($sql);
}
if(strcmp($RequestType,"ReviseSchedule") == 0)
{
		$styleId	= $_GET["StyleId"];
		$sql="update eventscheduleheader set intStatus=0 where intStyleId='$styleId';";
		$db->RunQuery($sql);
}
if(strcmp($RequestType,"GetDate") == 0)
{
	$ResponseXML .= "<Result>\n";	
	$ResponseXML .= "<CurrentDate><![CDATA[" . date("d/m/Y")  . "]]></CurrentDate>\n";	
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
if(strcmp($RequestType,"UpdateRow") == 0)
{
$strStyleID			= $_GET["styleName"];
$dtDateofDelivery	= $_GET["deliveryDate"];
$eventID			= $_GET["eventId"];
$offset				= $_GET["offSet"];

	$ResponseXML = "<Result>\n";
	
	$sql = "SELECT intScheduleId FROM eventscheduleheader WHERE strStyleId = '$strStyleID' AND dtDeliveryDate = '$dtDateofDelivery'";
	$eventresult = $db->RunQuery($sql);
	while($eventrow = mysql_fetch_array($eventresult))
	{	
		$scheduleID = $eventrow["intScheduleId"];
/*		$sql = "SELECT intEventID,reaOffset FROM eventtemplatedetails INNER JOIN eventtemplateheader ON 
eventtemplatedetails.intSerialNo = eventtemplateheader.intSerialNO 
WHERE eventtemplateheader.intBuyerID = (SELECT intBuyerID FROM orders WHERE intStyleId = '$strStyleID') 
AND eventtemplateheader.intSerialNO =  (SELECT intSerialNO FROM deliveryschedule WHERE intStyleId = '$intStyleId' AND dtDateofDelivery = '$dtDateofDelivery' )";
		
		
		$resultschedule=$db->RunQuery($sql);
		while($rowschedule=mysql_fetch_array($resultschedule))
		{*/		
		
			$available = false;
			
			$sql = "SELECT * FROM eventscheduledetail WHERE intScheduleId = '$scheduleID' AND intEventId = '$eventID'";
			$dataresult = $db->RunQuery($sql);
			
			
			while($rowresult = mysql_fetch_array($dataresult))
			{					
				$ResponseXML .= "<Available><![CDATA[TRUE]]></Available>\n";
				$available = true;
			}
			
			if(!$available)
			{
				$sql = "INSERT INTO eventscheduledetail 
							(intScheduleId, 
							intEventId, 
							dtmEstimateDate
							)
							VALUES
							('$scheduleID', 
							'$eventID', 
							DATE_ADD('$dtDateofDelivery', INTERVAL $offset DAY) 
							);";		
				$db->executeQuery($sql);
				
				$ResponseXML .= "<Available><![CDATA[False]]></Available>\n";						
			}
	
		//}
		
/*		$sql ="DELETE FROM eventscheduledetail WHERE intEventId NOT IN 
(SELECT intEventID FROM eventtemplatedetails INNER JOIN eventtemplateheader ON 
eventtemplatedetails.intSerialNo = eventtemplateheader.intSerialNO 
WHERE eventtemplateheader.intBuyerID = (SELECT intBuyerID FROM orders WHERE intStyleId = '$strStyleID') 
AND eventtemplateheader.intSerialNO =  (SELECT intSerialNO FROM deliveryschedule WHERE intStyleId = '$strStyleID' AND dtDateofDelivery = '$dtDateofDelivery' ))
AND ISNULL(dtCompleteDate) AND ISNULL(dtChangeDate)";
$db->executeQuery($sql);*/
	}
	$sql = "select *,date(dtChangeDate)AS changeDate,
	(select strDescription from events E where E.intEventID=ED.intEventId)AS eventName,
	DATE_FORMAT(ED.dtmEstimateDate, '%Y %b %d') as EstimateDate,
	date(dtCompleteDate)AS dtCompleteDate,
	DATEDIFF(CURDATE(),ED.dtmEstimateDate) AS diff,
	DATEDIFF(CURDATE(),dtChangeDate) AS changediff
	from eventscheduledetail ED 
	where intScheduleId = '$scheduleID' AND ED.intEventId = '$eventID'";
	$result = $db->RunQuery($sql);
	
	while($row1=mysql_fetch_array($result))
	{
		
		$ResponseXML .= "<EventId><![CDATA[" . $row1["intEventId"]  . "]]></EventId>\n";
		$ResponseXML .= "<EventName><![CDATA[" . $row1["eventName"]  . "]]></EventName>\n";
		$ResponseXML .= "<ScheduleId><![CDATA[" . $scheduleID  . "]]></ScheduleId>\n";
		$ResponseXML .= "<EstimateDate><![CDATA[" . $row1["EstimateDate"]  . "]]></EstimateDate>\n";
		$ResponseXML .= "<ChangeDate><![CDATA[" . $row1["changeDate"]  . "]]></ChangeDate>\n";	
		$ResponseXML .= "<ChangeReason><![CDATA[" . $row1["strChangedReason"]  . "]]></ChangeReason>\n";
		$ResponseXML .= "<CompleteDate><![CDATA[" . $row1["dtCompleteDate"]  . "]]></CompleteDate>\n";
		$ResponseXML .= "<DataDiff><![CDATA[" . $row1["diff"]  . "]]></DataDiff>\n";
		$ResponseXML .= "<Changediff><![CDATA[" . $row1["changediff"]  . "]]></Changediff>\n";
	}
	
		$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
//End 05-05-2010

?>