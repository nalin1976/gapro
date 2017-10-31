<?php ///////////////////////////// Coding by Lahiru Ranagana 2013-08-01 /////////////////////////
session_start();
include "../../Connector.php";
$companyId=$_SESSION["FactoryID"];
$userid=$_SESSION["UserID"];
$RequestType = $_GET["RequestType"];

if(strcmp($RequestType,"loadOrderNoEV") == 0)
{
	$SQL = "SELECT O.strOrderNo,O.intStyleId
			FROM eventscheduleheader AS H
			INNER JOIN orders AS O ON H.strStyleId = O.intStyleId
			WHERE O.intStatus NOT IN (13,14) ORDER BY O.strOrderNo ASC";
	$result = $db->RunQuery($SQL);
	echo "<option value=''>Select one</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intStyleId"]."\">".trim($row["strOrderNo"])."</option>" ;			
	}
}
if(strcmp($RequestType,"loadDeilveryDateEV") == 0)
{
	$styleId = $_GET["styleId"];
	$SQL = "SELECT DATE(H.dtDeliveryDate) AS deliveryDate FROM eventscheduleheader AS H 
			WHERE H.strStyleId = $styleId ORDER BY H.dtDeliveryDate ASC";
	$result = $db->RunQuery($SQL);
	//echo "<option value=''>Select one</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["deliveryDate"]."\">".trim($row["deliveryDate"])."</option>" ;
	}
}
if(strcmp($RequestType,"searchDataEV") == 0)
{
	$styleId = $_GET["styleId"];
	$deliveryDate = $_GET["deliveryDate"];

echo "<table style='width:913px;' border='0' cellpadding='0' cellspacing='1' id='table2PD' bgcolor='#FFFFFF'>";
		
	
	$SQL = "SELECT
			E.strDescription AS eventDescription,
			E.intCritical,E.intEventID,H.intScheduleId,
			DATE(D.dtmEstimateDate)AS dtmEstimateDate,
			DATE(D.dtChangeDate)AS dtChangeDate,
			DATE(D.dtCompleteDate)AS dtCompleteDate,
			D.intStatus,D.intDelayEventRemark,
			DATEDIFF(CURDATE(),IF(D.dtChangeDate IS NULL,D.dtmEstimateDate,D.dtChangeDate)) AS dateDiff
			FROM eventscheduleheader AS H
			INNER JOIN eventscheduledetail AS D ON H.intScheduleId = D.intScheduleId
			INNER JOIN `events` AS E ON E.intEventID = D.intEventId
			WHERE H.strStyleId = $styleId AND H.dtDeliveryDate = '$deliveryDate'
			ORDER BY D.dtmEstimateDate ASC  ";
	$noOfDelay = 0; $noOfPending = 0; $noOfComplete = 0; $noOfSkip = 0;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$eventDescription = $row["eventDescription"];
		$dtmEstimateDate  = $row["dtmEstimateDate"];
		$dtChangeDate 	  = $row["dtChangeDate"];
		$dtCompleteDate	  = $row["dtCompleteDate"];
		$intStatus	      = $row["intStatus"];
		$dateDiff	      = $row["dateDiff"];
		$intEventID	      = $row["intEventID"];
		$intScheduleId	  = $row["intScheduleId"];
		$delayEventRemark = $row["intDelayEventRemark"];

		$resUser = getUsersOfEvent($intScheduleId,$intEventID);
	if($dtChangeDate==""){
	$eventEstimateDate = $dtmEstimateDate;
	$dtChangeDate = "-";	
	}else{
	$eventEstimateDate = $dtChangeDate;	
	}

	 if($dtCompleteDate!="" && $intStatus==1){
		$rowColor = "#6afb60"; /// completed 
		$smileImg ="<img src='images/smHappy.png' border='0' width='25' height='25' />";
		$noOfComplete++;
	 }else if($eventEstimateDate==date("Y-m-d") && $intStatus==1){
		$rowColor = "#8a8afe"; /// today pending
		$smileImg ="<img src='images/smWating.png' border='0' width='25' height='25' />";
		$noOfPending++;
	 }else if($dateDiff<0 && $dateDiff>-2 && $intStatus==1){
		$rowColor = "#7aebff"; /// To Be Completed In Next 2 Days 
		$smileImg ="<img src='images/smWating.png' border='0' width='25' height='25' />";
		$noOfPending++;
	 }else if($eventEstimateDate<date("Y-m-d") && $intStatus==1){
		$rowColor = "#ff8482"; /// delay
		$smileImg ="<img src='images/smAngry.png' border='0' width='25' height='25' />";
		$noOfDelay++;
	 }else if($eventEstimateDate>date("Y-m-d") && $intStatus==1){
		$rowColor = "#fde797"; /// pendig
		$smileImg ="<img src='images/smWating.png' border='0' width='25' height='25' />";
		$noOfPending++;
	 }else if($intStatus==2){
		$rowColor = "#fb62f6"; /// skip
		$smileImg = "";
		$noOfSkip++;
	 }
		
	 if($delayEventRemark==1){
	 $viewRemark = "onmouseout='hideRemarks();' onmouseover='viewRemarks($intScheduleId,$intEventID);'";	 
	 }else{
	 $viewRemark = ""; 
	 }
	 
		
		echo "<tr height='25' bgcolor='$rowColor'>
			<td width='28'>$smileImg</td>
			<td height='30' $viewRemark>&nbsp; $eventDescription</td>
			<td width='100' align='center'>$dtmEstimateDate</td>
			<td width='100' align='center'>$dtChangeDate</td>
			<td width='100' align='center'>$dtCompleteDate</td>
			<td width='200'>$resUser</td>
		  </tr>";	
			
		
	$c++;
	}
echo "</table>";

echo   "<input type='hidden' id='hdNoOfDelay' value='$noOfDelay'/>
		<input type='hidden' id='hdNoOfPending' value='$noOfPending'/>
		<input type='hidden' id='hdNoOfComplete' value='$noOfComplete'/>
		<input type='hidden' id='hdNoOfSkip' value='$noOfSkip'/>";
}

function getUsersOfEvent($intScheduleId,$intEventID)
{global $db;

$SQL = "SELECT UA.`Name`AS resUser FROM eventschedule_users AS EU
		INNER JOIN useraccounts AS UA ON EU.intUserId = UA.intUserID
		WHERE EU.intScheduleId = $intScheduleId AND EU.intEventId = $intEventID
		ORDER BY resUser ASC ";
	$resUser = "";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$resUser .= $row["resUser"].", ";
	}
return $resUser;
}

if(strcmp($RequestType,"loadBarChart") == 0)
{
header('Content-Type: text/xml'); 
$ResponseXML  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML .= "<loadData>\n";

	
	$srchFactory = $_GET["srchFactory"];
	$lineNo		 = $_GET["lineNo"];
	$tagetDate	 = $_GET["tagetDate"];
	
		$SQL = "SELECT
				DATE_FORMAT(D.tmStartTime,'%H.%i')AS tmStartTime24h,
				DATE_FORMAT(D.tmEndTime,'%H.%i')AS tmEndTime24h,
				DATE_FORMAT(D.tmStartTime,'%h:%i %p')AS tmStartTime12h,
				DATE_FORMAT(D.tmEndTime,'%h:%i %p')AS tmEndTime12h,
				SUM(D.intQty)AS intQty,
				D.intStyleId
				FROM
				production_hourlytarget_header AS H
				INNER JOIN production_hourlytarget_details AS D ON H.intHoTaSerial = D.intHoTaSerial
				WHERE H.dtTargetDate = '$tagetDate' AND H.intFactoryId = $srchFactory AND
				H.intTeamNo = '$lineNo' AND H.intStatus = 1 AND D.intStatus = 1
				GROUP BY D.tmStartTime,D.tmEndTime
				ORDER BY D.tmStartTime ASC ";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$tmStartTime12h = $row["tmStartTime12h"];
		$tmEndTime12h	= $row["tmEndTime12h"];
		$tmStartTime24h = $row["tmStartTime24h"];
		$tmEndTime24h	= $row["tmEndTime24h"];
		$targetQty		= $row["intQty"];
		$intStyleId		= $row["intStyleId"];		
		
		$actQty = getActualQty($srchFactory,$lineNo,$tagetDate,$tmStartTime24h,$tmEndTime24h,$intStyleId);
		
		$ResponseXML .= "<tarTime><![CDATA[".$tmEndTime12h."]]></tarTime>\n";
		$ResponseXML .= "<tarQty><![CDATA[".$targetQty."]]></tarQty>\n";
		$ResponseXML .= "<actQty><![CDATA[".$actQty."]]></actQty>\n";
	}
$ResponseXML .= "</loadData>\n";
echo $ResponseXML;	
}

function getActualQty($srchFactory,$lineNo,$tagetDate,$tmStartTime24h,$tmEndTime24h,$intStyleId)
{global $db;
$SQL = "SELECT SUM(D.dblQty) AS achQty
FROM
productionlineoutputheader AS H
INNER JOIN productionlineoutdetail AS D ON H.intLineOutputSerial = D.intLineOutputSerial AND H.intLineOutputYear = D.intLineOutputYear
WHERE
H.dtmDate = '$tagetDate' AND
H.intFactory = $srchFactory AND
H.strTeamNo = $lineNo AND
DATE_FORMAT(H.dtmTargetAchieve,'%H.%i') > '$tmStartTime24h' AND
DATE_FORMAT(H.dtmTargetAchieve,'%H.%i') <= '$tmEndTime24h' AND
H.intStyleId = $intStyleId ";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$achQty = $row["achQty"];		
	}
return $achQty;	
}
?>