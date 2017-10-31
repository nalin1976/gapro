<?php 
include "../../../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];
/* Monthly shipment schedule status
0 - pending
1 - Confirm
*/
if($requestType=="getOrderDelSchedule")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<delDetails>\n";
	$dfrom	= $_GET["dfrom"];
	$dTo	= $_GET["dTo"];
	
	$sql = "SELECT DISTINCT DATE_FORMAT(dtDateofDelivery, '%Y %M %D') AS deliveryDate,date(dtDateofDelivery) AS dateFormat, dblQty as deliveryQty,o.strStyle,o.strOrderNo,o.intQty,d.intStyleId
FROM deliveryschedule d inner join orders o on 
o.intStyleId = d.intStyleId  where date(d.dtDateofDelivery) between '$dfrom' and '$dTo'  order by dateFormat desc ";
	$result = $db->RunQuery($sql);
	 
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<deliveryDate><![CDATA[" . $row["deliveryDate"]  . "]]></deliveryDate>\n";
		$ResponseXML .= "<dateDateId><![CDATA[" . $row["dateFormat"]  . "]]></dateDateId>\n";
		$ResponseXML .= "<deliveryQty><![CDATA[" . $row["deliveryQty"]  . "]]></deliveryQty>\n";
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		$ResponseXML .= "<orderQty><![CDATA[" . $row["intQty"]  . "]]></orderQty>\n";
	}
	
	$ResponseXML .= "</delDetails>";
	 echo $ResponseXML;
}
else if($requestType=="getShipSheduleNo")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<ShipScheduleNo>\n";
	
	$monthShipNo = getMonthShipScheduleNo();
	
	$ResponseXML .= "<monthShipNo><![CDATA[" . $monthShipNo  . "]]></monthShipNo>\n";
	$ResponseXML .= "</ShipScheduleNo>";
	 echo $ResponseXML;
}
else if($requestType=="SaveScheduleHeader")
{
	$s_month	= $_GET["s_month"];
	$s_year	= $_GET["s_year"];
	$pub_sheduleNo = $_GET["pub_sheduleNo"];
	$strSheduleNo = $pub_sheduleNo.'/'.$s_month.'/'.$s_year;
	SaveScheduleHeaderData($s_month,$s_year,$pub_sheduleNo,$strSheduleNo);
	
}
else if($requestType=="deleteScheduleDetails")
{
	$pub_sheduleNo = $_GET["pub_sheduleNo"];
	DeleteMonthScheduleHeaderData($pub_sheduleNo);
}
else if($requestType=="deleteScheduleDetailItems")
{
	$scheduleNo = $_GET["scheduleNo"];
	$delDate	= $_GET["delDate"];
	$hoDate		= $_GET["hoDate"];
	$styleId	= $_GET["styleId"];
	$delQty		= $_GET["delQty"];
	$arrNo 		= explode('/',$scheduleNo);
	$sno 		= $arrNo[0];
	$count=0;
	$result = getScheduleDetailId($sno,$delDate,$hoDate,$styleId,$delQty,$delQty);
	
	while($row=mysql_fetch_array($result))
	{
		$scheduleDetId = $row["intScheduleDetailId"];
		$chkRecAv = checkWkScheduleDetailsAv($scheduleDetId);
		
		if($chkRecAv==1)
			$count++;
	}
	if($count==0)
	{
		$resultD = getScheduleDetailId($sno,$delDate,$hoDate,$styleId,$delQty,$delQty);
		while($rowd=mysql_fetch_array($resultD))
		{
			deleteItemDetails($rowd["intScheduleDetailId"]);
		}
		
	}
	echo $count;
}
else if($requestType=="SaveScheduleDetails")
{
	$pub_sheduleNo = $_GET["pub_sheduleNo"];
	$styleId	= $_GET["styleId"];
	$delDate	= $_GET["delDate"];
	$HOdate		= $_GET["HOdate"];
	$delQty		= $_GET["delQty"];
	$seaQty		= $_GET["seaQty"];
	$remarks	= $_GET["remarks"];
	$id			= $_GET["id"];
	
	if($seaQty !='' && $seaQty !=0)
	{
		$chkSeaRecAv = checkMonthScheduleRecordAvailability($pub_sheduleNo,$styleId,$delDate,$HOdate,$delQty,$seaQty);
		$numrows = mysql_num_rows($chkSeaRecAv);
			if($numrows >0)
			{
				$row = mysql_fetch_array($chkSeaRecAv);
				$scheduleDetailId = $row["intScheduleDetailId"];
				updateScheduleDetails($scheduleDetailId,$seaQty,$remarks,$HOdate,$delDate);
			}	
			else	
				insertScheduleDetails($pub_sheduleNo,$styleId,$delDate,$HOdate,$delQty,$seaQty,$remarks);
	}
}
else if($requestType=="getPendingScheduleData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<pendingDetails>\n";
	
	$intScheduleNo = $_GET["intScheduleNo"];
	$result = getMonthScheduleDetails($intScheduleNo);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<dtmDeliveryDate><![CDATA[" . $row["dtmDeliveryDate"]  . "]]></dtmDeliveryDate>\n";
		$ResponseXML .= "<dtmHODate><![CDATA[" . $row["dtmHODate"]  . "]]></dtmHODate>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		$ResponseXML .= "<orderQty><![CDATA[" . $row["intQty"]  . "]]></orderQty>\n";
		$ResponseXML .= "<dblDelQty><![CDATA[" . $row["dblDelQty"]  . "]]></dblDelQty>\n";
		//$ResponseXML .= "<airQty><![CDATA[" . $row["airQty"]  . "]]></airQty>\n";
		$ResponseXML .= "<seaQty><![CDATA[" . $row["dblQty"]  . "]]></seaQty>\n";
		$ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
		//$mnthScheduleDetailId = $row["intScheduleDetailId"];
		//$wkShipScheduleAv = checkWkScheduleDetailAvailable($mnthScheduleDetailId);
	}
	
	$ResponseXML .= "</pendingDetails>";
	 echo $ResponseXML;
}
else if($requestType=="confirmMonthSchedule")
{
	$intScheduleNo = $_GET["intScheduleNo"];
	$result = updateMonthScheduleStatus($intScheduleNo,1);
	echo $result;
	
}
else if($requestType=="checkScheduleDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<pendingDetails>\n";
	
	$sMonth = $_GET["sMonth"];
	$sYear  = $_GET["sYear"];
	
	$result = getMonthShipHeaderData($sMonth,$sYear);
	$numRows = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	
	$ResponseXML .= "<numRows><![CDATA[" . $numRows  . "]]></numRows>\n";
	$ResponseXML .= "<monthSheduleNo><![CDATA[" . $row["strMonthSheduleNo"]  . "]]></monthSheduleNo>\n";
	$ResponseXML .= "</pendingDetails>";
	 echo $ResponseXML;
}

function getMonthShipScheduleNo()
{
	global $db;
	global $companyId;
	$sql = "select dblMonthShipScheduleNo from syscontrol where intCompanyID='$companyId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$shipNo = $row["dblMonthShipScheduleNo"];
	
	$sql_u = "update syscontrol set dblMonthShipScheduleNo=dblMonthShipScheduleNo+1 where intCompanyID='$companyId'";
	$result_u = $db->RunQuery($sql_u);
	
	return $shipNo;
}
function SaveScheduleHeaderData($s_month,$s_year,$pub_sheduleNo,$strSheduleNo)
{
	global $db;
	global $userId;
	$sql = "insert into finishing_month_schedule_header(intScheduleNo,strMonthSheduleNo,intMonth,intYear,intStatus, intUserId,dtmScheduleDate) values ('$pub_sheduleNo','$strSheduleNo','$s_month','$s_year','0','$userId',now())";
	$result = $db->RunQuery($sql);
}

function insertScheduleDetails($pub_sheduleNo,$styleId,$delDate,$HOdate,$delQty,$seaQty,$remarks)
{
	global $db;	
	$sql = "insert into finishing_month_schedule_details(intScheduleNo,intStyleId,dtmDeliveryDate,dtmHODate,dblDelQty, dblQty,dblBalQty, strRemarks) values ('$pub_sheduleNo','$styleId','$delDate','$HOdate','$delQty','$seaQty','$seaQty','$remarks')";
	$result = $db->RunQuery($sql);
}
function DeleteMonthScheduleHeaderData($pub_sheduleNo)
{
	global $db;
	
	$sql = "delete from finishing_month_schedule_details where 	intScheduleNo = '$pub_sheduleNo'";
	$result = $db->RunQuery($sql);
}
function getMonthScheduleDetails($intScheduleNo)
{
	global $db;
	
	$sql = "select distinct fmd.intStyleId,fmd.dtmDeliveryDate,fmd.dtmHODate,o.strOrderNo,o.strStyle,o.intQty,fmd.dblDelQty,
fmd.dblQty,fmd.strRemarks
 from finishing_month_schedule_details fmd inner join orders o on
o.intStyleId = fmd.intStyleId where fmd.intScheduleNo='$intScheduleNo'";
	//echo $sql;
	return $db->RunQuery($sql);
}
function getScheduleDetailId($sno,$delDate,$hoDate,$styleId,$delQty,$delQty)
{
	global $db;
	
	$sql = "select intScheduleDetailId from finishing_month_schedule_details where intScheduleNo=$sno and intStyleId='$styleId' and dtmDeliveryDate='$delDate' and dtmHODate='$hoDate' and dblDelQty='$delQty' ";
	return $db->RunQuery($sql);
}
function checkWkScheduleDetailsAv($scheduleDetId)
{
	global $db;
	$sql = "select * from finishing_week_schedule_details where intMonthScheduleDetId='$scheduleDetId'";
	return $db->CheckRecordAvailability($sql);
}
function deleteItemDetails($sDetailId)
{
	global $db;
	$sql = "delete from finishing_month_schedule_details where	intScheduleDetailId = '$sDetailId' ";
	$result = $db->RunQuery($sql);
	//echo $sql;
}
function updateScheduleDetails($scheduleDetailId,$seaQty,$remarks,$HOdate,$delDate)
{
	global $db;
	/*$sql = " update finishing_month_schedule_details set dblQty = '$Qty' where intScheduleNo = '$pub_sheduleNo' and 
	intStyleId = '$styleId' and dtmDeliveryDate = '$delDate' and dtmHODate = '$HOdate' and dblDelQty = '$delQty' ";*/
	$sql = "update finishing_month_schedule_details 
	set
	dblQty = '$seaQty' , 
	dblBalQty = '$seaQty' , 
	strRemarks = '$remarks',
	dtmHODate = '$HOdate',
	dtmDeliveryDate = '$delDate'
	where
	intScheduleDetailId = '$scheduleDetailId' ";
	$result = $db->RunQuery($sql);
}
function updateMonthScheduleStatus($intScheduleNo,$status)
{
	global $db;
	global $userId;
	$sql = "update finishing_month_schedule_header set intStatus='$status',intConfirmBy ='$userId', dtmConfirmDate=now() where intScheduleNo='$intScheduleNo'";
	return $db->RunQuery($sql);
}
function checkMonthScheduleRecordAvailability($pub_sheduleNo,$styleId,$delDate,$HOdate,$delQty,$seaQty)
{
	global $db;
	$sql = "select * from finishing_month_schedule_details where intScheduleNo='$pub_sheduleNo' and intStyleId='$styleId'  and  dtmDeliveryDate='$delDate' and dtmHODate='$HOdate' and dblDelQty = '$delQty' ";
	return $db->RunQuery($sql);
}
function  getMonthShipHeaderData($sMonth,$sYear)
{
	global $db;
	$sql = "select strMonthSheduleNo from finishing_month_schedule_header where intMonth='$sMonth' and intYear='$sYear' ";
	return $db->RunQuery($sql);
}
?>