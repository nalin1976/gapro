<?php ///////////////////////////// Coding by Lahiru Ranagana 2013-04-04 /////////////////////////
session_start();
include "../../Connector.php";
$userid=$_SESSION["UserID"];
$RequestType = $_GET["RequestType"];

if(strcmp($RequestType,"loadEvents") == 0)
{
$str = "<table width='563' border='0' cellpadding='0' cellspacing='1' id='evtScheduleDetails'>";

$eventStatus = $_GET["eventStatus"];
$searchOrderNo = $_GET["searchOrderNo"];
$searchEvent = $_GET["searchEvent"];
$searchDateFrom = $_GET["searchDateFrom"];
$searchDateTo = $_GET["searchDateTo"];
$searchStyle = $_GET["searchStyle"];
$searchBuyer = $_GET["searchBuyer"];
$hdGridOrderBy = $_GET["hdGridOrderBy"];
$nowDay = date("Y-m-d");

	$SQL="	SELECT
			DATE(eventscheduledetail.dtmEstimateDate) AS EstimateDate,
			DATE(eventscheduledetail.dtChangeDate) AS ChangeDate,
			DATE(eventscheduledetail.dtCompleteDate) AS CompleteDate,
			eventscheduledetail.strChangedReason AS ChangedReason,
			`events`.strDescription AS EventName,
			DATEDIFF(CURDATE(),dtmEstimateDate) AS dtDeffWithCurntDate,
			DATEDIFF(CURDATE(),dtChangeDate) AS dtDeffWithChngeDate,
			orders.strOrderNo,
			orders.intStyleId,
			eventscheduleheader.intScheduleId,
			eventscheduledetail.intEventId
			FROM
			eventscheduleheader
			INNER JOIN eventscheduledetail ON eventscheduleheader.intScheduleId = eventscheduledetail.intScheduleId
			INNER JOIN `events` ON eventscheduledetail.intEventId = `events`.intEventID
			INNER JOIN orders ON eventscheduleheader.strStyleId = orders.intStyleId
			LEFT JOIN eventschedule_users ON eventschedule_users.intScheduleId = eventscheduledetail.intScheduleId 
			AND eventscheduledetail.intEventId = eventschedule_users.intEventId
			WHERE eventschedule_users.intUserId = $userid AND orders.intStatus NOT IN(13,14) AND eventscheduledetail.dtmEstimateDate != '' "; 	
			
			if($eventStatus=="D"){
			$rowColor="#FF8080"; $showCheckBox=""; $showCompleteDt="none";
			$SQL.="	AND eventscheduledetail.dtCompleteDate IS NULL 
					AND IF(eventscheduledetail.dtChangeDate IS NULL,(CURDATE()>eventscheduledetail.dtmEstimateDate),
																	(CURDATE()>eventscheduledetail.dtChangeDate))  ";
			}
			if($eventStatus=="P"){
			$rowColor="#FFFF59"; $showCheckBox=""; $showCompleteDt="none";
			$SQL.="	AND eventscheduledetail.dtCompleteDate IS NULL 
					AND IF(eventscheduledetail.dtChangeDate IS NULL,(CURDATE()<=eventscheduledetail.dtmEstimateDate),
																	(CURDATE()<=eventscheduledetail.dtChangeDate))  ";
			}
			if($eventStatus=="C"){
			$rowColor="#53FF53"; $showCheckBox="none"; $showCompleteDt="";	
			$SQL.="	AND eventscheduledetail.dtCompleteDate IS NOT NULL ";
			}
			
			if($searchOrderNo!=""){
			$SQL.="	AND eventscheduleheader.strStyleId = $searchOrderNo ";	
			}
			
			if($searchEvent!=""){
			$SQL.="	AND eventscheduledetail.intEventId = $searchEvent ";	
			}
			
			if($searchStyle!=""){
			$SQL.="	AND orders.strStyle = '$searchStyle' ";	
			}
			
			if($searchBuyer!=""){
			$SQL.="	AND orders.intBuyerID = $searchBuyer ";	
			}
			
			if($searchDateFrom!="" && $searchDateTo!=""){
			$SQL.="	AND IF(eventscheduledetail.dtChangeDate IS NULL,(eventscheduledetail.dtmEstimateDate BETWEEN '$searchDateFrom' AND '$searchDateTo'),
																	(eventscheduledetail.dtChangeDate BETWEEN '$searchDateFrom' AND '$searchDateTo')) ";	
			}
			
			if($hdGridOrderBy=="OrderNo"){
			$SQL.=" ORDER BY orders.strOrderNo ";	
			}else if($hdGridOrderBy=="Event"){
			$SQL.=" ORDER BY EventName ";	
			}else if($hdGridOrderBy=="EstimateDt"){
			$SQL.=" ORDER BY EstimateDate ";	
			}else if($hdGridOrderBy=="CompleteDt"){
			$SQL.=" ORDER BY CompleteDate ";	
			}else{
			$SQL.=" ORDER BY EstimateDate ";	
			}
			
			$c=1;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$eventScheduleId = $row["intScheduleId"];	
		$styleId	   = $row["intStyleId"];
		$EstimateDate  = $row["EstimateDate"];
		$ChangeDate  = $row["ChangeDate"];
		$CompleteDate  = $row["CompleteDate"];
		$EventName  = $row["EventName"];
		$strOrderNo  = $row["strOrderNo"];
		$intEventId  = $row['intEventId'];
		$dtDeffWithCurntDate  = $row['dtDeffWithCurntDate'];
		
		if($ChangeDate!=""){
		$EstimateDate="$EstimateDate<br><div style='color:red;'>$ChangeDate</div>";	
		}
		
		$str .= "<tr bgcolor='$rowColor' style='font-size:9px'>
				<input type='hidden' id='hdEventScheduleId/$c' value='$eventScheduleId'>
				<input type='hidden' id='hdEventId/$c' value='$intEventId'>
				<input type='hidden' id='hdDelayedReason/$c' value=''>
				
					 <td height='25'>$strOrderNo</td>
					 <td width='150'>$EventName</td>
					 <td width='80' align='center'>$EstimateDate </td>	
   					
					 <td width='80' style='display:$showCheckBox;' >
					 <input name='cmptDt/$c' type='text' disabled class='txtbox' id='cmptDt/$c' style='width:70px;' onclick=\"return showCalendar(this.id, '%Y-%m-%d');\" onMouseDown='DisableRightClickEvent();' onMouseOut='EnableRightClickEvent();' onKeyPress=\"return ControlableKeyAccess(event);\" /><input type='text' value='' class='txtbox' style='visibility:hidden;width:1px' onclick=\"return showCalendar(this.id, '%Y-%m-%d');\"></td>
					 
					 <td width='80' style='display:$showCompleteDt;' align='center'>$CompleteDate </td>	
					 
					 <td width='25' align='center'><input style='display:$showCheckBox;' type='checkbox' id='checkBox/$c' onclick=\"enableDt($c);setDelayedReson($c);\"/></td>
  				</tr>";
		
	$c++;
	}	
$str .= "</table>";

echo $str;
}


if(strcmp($RequestType,"completeEvent") == 0)
{
	$scheduleId = $_GET['scheduleId'];
	$eventId    = $_GET['eventId'];
	$txtComplateDate    = $_GET['txtComplateDate'];
	$hdDelayedReason    = $_GET['hdDelayedReason'];
	
	$dateToday  = date('Y-m-d'); 
	
	$sql=" 	update eventscheduledetail 
			set dtCompleteDate = '$txtComplateDate' ,
			dtCompleteDateSystem = now(),
			intCompletedBy = '$userid',
			strCompleteDelayReason = '$hdDelayedReason' 
			WHERE intScheduleId=$scheduleId and intEventId=$eventId ";
	echo $result = $db->RunQuery($sql);
}

if(strcmp($RequestType,"loadNoOfDelayedEvent") == 0)
{
	$eventStatus="D";
	
	$SQL="  SELECT COUNT(eventschedule_users.intScheduleId)AS noOfDeEvent
			FROM eventschedule_users 
			INNER JOIN eventscheduledetail ON eventschedule_users.intScheduleId = eventscheduledetail.intScheduleId 
			AND eventschedule_users.intEventId = eventscheduledetail.intEventId
			INNER JOIN eventscheduleheader ON eventscheduleheader.intScheduleId = eventscheduledetail.intScheduleId
			INNER JOIN orders ON eventscheduleheader.strStyleId = orders.intStyleId
			WHERE eventschedule_users.intUserId = $userid AND orders.intStatus NOT IN(13,14) ";
			
	if($eventStatus=="D"){
	$SQL.="	AND eventscheduledetail.dtCompleteDate IS NULL 
			AND IF(eventscheduledetail.dtChangeDate IS NULL,(CURDATE()>eventscheduledetail.dtmEstimateDate),
															(CURDATE()>eventscheduledetail.dtChangeDate))  ";
	}
	if($eventStatus=="P"){
	$SQL.="	AND eventscheduledetail.dtCompleteDate IS NULL 
			AND IF(eventscheduledetail.dtChangeDate IS NULL,(CURDATE()<=eventscheduledetail.dtmEstimateDate),
															(CURDATE()<=eventscheduledetail.dtChangeDate))  ";
	}
	if($eventStatus=="C"){
	$SQL.="	AND eventscheduledetail.dtCompleteDate IS NOT NULL ";
	}
			
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	echo $row['noOfDeEvent'];
}

if(strcmp($RequestType,"loadSearchOrderNo") == 0)
{
	$SQL = "SELECT DISTINCT
			orders.intStyleId,
			orders.strOrderNo
			FROM
			eventscheduledetail
			INNER JOIN eventscheduleheader ON eventscheduleheader.intScheduleId = eventscheduledetail.intScheduleId
			INNER JOIN eventschedule_users ON eventschedule_users.intScheduleId = eventscheduledetail.intScheduleId 
			AND eventscheduledetail.intEventId = eventschedule_users.intEventId
			INNER JOIN orders ON orders.intStyleId = eventscheduleheader.strStyleId
			WHERE eventschedule_users.intUserId = $userid
			ORDER BY
			orders.strOrderNo ASC ";

		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . " All" ."</option>" ;
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;
		}
}

if(strcmp($RequestType,"loadSearchEvent") == 0)
{
	$SQL = 	"SELECT DISTINCT
			`events`.intEventID,
			`events`.strDescription
			FROM
			eventschedule_users
			INNER JOIN `events` ON `events`.intEventID = eventschedule_users.intEventId
			WHERE eventschedule_users.intUserId = $userid
			ORDER BY
			`events`.strDescription ASC ";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . " All" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intEventID"] ."\">" . trim($row["strDescription"]) ."</option>" ;
	}
}

if(strcmp($RequestType,"loadSearchStyle") == 0)
{
	$SQL = "SELECT DISTINCT orders.strStyle
			FROM eventscheduledetail
			INNER JOIN eventscheduleheader ON eventscheduleheader.intScheduleId = eventscheduledetail.intScheduleId
			INNER JOIN eventschedule_users ON eventschedule_users.intScheduleId = eventscheduledetail.intScheduleId 
			AND eventscheduledetail.intEventId = eventschedule_users.intEventId
			INNER JOIN orders ON orders.intStyleId = eventscheduleheader.strStyleId
			WHERE eventschedule_users.intUserId = $userid
			ORDER BY orders.strStyle ASC ";

	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . " All" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyle"] ."\">" . trim($row["strStyle"]) ."</option>" ;
	}
}

if(strcmp($RequestType,"loadSearchBuyer") == 0)
{
	$SQL = "SELECT DISTINCT
			buyers.intBuyerID,
			buyers.strName
			FROM eventscheduledetail
			INNER JOIN eventscheduleheader ON eventscheduleheader.intScheduleId = eventscheduledetail.intScheduleId
			INNER JOIN eventschedule_users ON eventschedule_users.intScheduleId = eventscheduledetail.intScheduleId 
			AND eventscheduledetail.intEventId = eventschedule_users.intEventId
			INNER JOIN orders ON orders.intStyleId = eventscheduleheader.strStyleId
			INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
			WHERE eventschedule_users.intUserId = $userid
			ORDER BY buyers.strName ASC ";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . " All" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
}

if(strcmp($RequestType,"completeEventsBefore20130320") == 0)
{

			$SQL = "
		UPDATE eventscheduledetail
		SET
		dtCompleteDate = dtmEstimateDate,
		intCompletedBy = '109' ,
		strRemarks ='event estimated to complete before 2013/04/20 are completed by gapro system.',
		dtCompleteDateSystem = dtmEstimateDate
		WHERE dtmEstimateDate BETWEEN '2012-01-01' AND '2013-03-19'";
	
	echo $result = $db->RunQuery($SQL);

}
?>