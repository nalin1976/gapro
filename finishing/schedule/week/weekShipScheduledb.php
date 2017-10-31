<?php 
include "../../../Connector.php";
include "../../../eshipLoginDB.php";	
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="getMonthScheduleData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<monthScheduleData>\n";
	$scheduleNo = $_GET["scheduleNo"];
	
	$result = getMonthScheduleDetails($scheduleNo);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<deliveryDate><![CDATA[" . $row["deliveryDate"]  . "]]></deliveryDate>\n";
		$ResponseXML .= "<HOdate><![CDATA[" . $row["HOdate"]  . "]]></HOdate>\n";
		/*$strType = $row["strType"];
		$mode = '';
		switch($strType)
		{
			case 'Sea':
			{
				$mode = "<select name='cboMode' id='cboMode' style='width:70px;' onChange='setComboVal(this);'><option value='$strType' selected=\"selected\">$strType</option>
        <option value='Air'>Air</option></select>";
				break;
			}
			case 'Air':
			{
				$mode = "<select name='cboMode' id='cboMode' style='width:70px;' onChange='setComboVal(this);'><option value='$strType' selected=\"selected\">$strType</option>
        <option value='Sea'>Sea</option></select>";
				break;
			}
		}*/
		$strType='null';
		$shipMode = getShipModeDetails();
		$str = '';
		$str .= "<select name='cboMode' id='cboMode' style='width:70px;' onChange='setComboVal(this);'>";
			$str .=  "<option value="."null".">".""."</option>";
			while($rw = mysql_fetch_array($shipMode))
			{
					$str .= "<option value=\"". $rw["intShipmentModeId"] ."\">" . $rw["strCode"] ."</option>";
			}
			$str .= "</select> ";
		$ResponseXML .= "<strType><![CDATA[" . $strType  . "]]></strType>\n";
		$ResponseXML .= "<mode><![CDATA[" . $str  . "]]></mode>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		$ResponseXML .= "<ScheduleDetailId><![CDATA[" . $row["intScheduleDetailId"]  . "]]></ScheduleDetailId>\n";
	}
	
	$ResponseXML .= "</monthScheduleData>";
	 echo $ResponseXML;
}
else if($requestType=="getWkScheduleNo")
{
	$dfrom = $_GET["dfrom"];
	$wkNo = intval((date("z", strtotime($dfrom))+1)/7);
	$scheduleNo = getScheduleNo();
	
	$wkScheduleNo = $scheduleNo.'/'.$wkNo.'/'.date('Y');
	echo $wkScheduleNo;
}
else if($requestType=="saveScheduleHeader")
{
	$pub_WksheduleNo = $_GET["pub_WksheduleNo"];
	$dfrom		     = $_GET["dfrom"];
	$dTo			 = $_GET["dTo"];
	$arrScheduleNo   = explode('/',$pub_WksheduleNo);
	
	insertWkScheduleHeaderData($arrScheduleNo[0],$arrScheduleNo[1],$arrScheduleNo[2],$pub_WksheduleNo,$dfrom,$dTo);
}
else if($requestType=="SaveScheduleDetails")
{
	$scheduleNo = $_GET["scheduleNo"];
	$arrNo = explode('/',$scheduleNo);
	$intScheduleNo = $arrNo[0];
	$intYear = $arrNo[2];
	$styleId = $_GET["styleId"];
	$city	 = $_GET["city"];
	$Qty	 = $_GET["Qty"];
	$mode 	 = $_GET["mode"];
	$Qty_ctn = $_GET["Qty_ctn"];
	$Qty_pcs = $_GET["Qty_pcs"];
	$mnthScheduleDetailId = $_GET["mnthScheduleDetailId"];
	$wkScheduleId = $_GET["wkScheduleId"];
	$isdNo 	= $_GET["isdNo"];
	$dcNo 	= $_GET["dcNo"];
	$doNo   = $_GET["doNo"];
	
	$recAv = checkWkScheduleAvailability($intScheduleNo,$styleId,$city,$mode);
	$numRows = mysql_num_rows($recAv);
	$row = mysql_fetch_array($recAv);
	$preQty_pcs = $row["dblPcsQty"];
	if($numRows > 0)
	{
		
		updateMonthScheduleBalQty($mnthScheduleDetailId,$preQty_pcs);
		updateWkScheduleData($wkScheduleId,$Qty_ctn,$Qty_pcs,$isdNo,$dcNo,$doNo);	
	}
	else	
		insertWkScheduleDetails($intScheduleNo,$styleId,$city,$Qty,$mode,$Qty_ctn,$Qty_pcs,$mnthScheduleDetailId,$isdNo,$dcNo,$doNo,$intYear);
	$balQty = $Qty_pcs*-1;	
	updateMonthScheduleBalQty($mnthScheduleDetailId,$balQty);
}
else if($requestType=="getwkSheduleHeaderData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<wkSheduleHeaderData>\n";
	
	$scheduleNo = $_GET["scheduleNo"];
	$result = getWkScheduleHeaderDetails($scheduleNo);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<DateFrom><![CDATA[" . $row["DateFrom"]  . "]]></DateFrom>\n";
		$ResponseXML .= "<DateTo><![CDATA[" . $row["DateTo"]  . "]]></DateTo>\n";
	}
	$ResponseXML .= "</wkSheduleHeaderData>";
	 echo $ResponseXML;
}
else if($requestType=="getwkSheduleItemDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<wkSheduleData>\n";
	
	$scheduleNo = $_GET["scheduleNo"];
	$intYear 	= $_GET["intYear"];
	
	$result = getWkScheduleItemDetails($scheduleNo,$intYear);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		$ResponseXML .= "<intWkScheduleDetailId><![CDATA[" . $row["intWkScheduleDetailId"]  . "]]></intWkScheduleDetailId>\n";
		$ResponseXML .= "<intWkScheduleId><![CDATA[" . $row["intWkScheduleId"]  . "]]></intWkScheduleId>\n";
		$ResponseXML .= "<intMonthScheduleDetId><![CDATA[" . $row["intMonthScheduleDetId"]  . "]]></intMonthScheduleDetId>\n";
		$ResponseXML .= "<intCityId><![CDATA[" . $row["intCityId"]  . "]]></intCityId>\n";
		$city = getCityName($row["intCityId"]);
		$ResponseXML .= "<city><![CDATA[" . $city  . "]]></city>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		$ResponseXML .= "<strType><![CDATA[" . $row["strType"]  . "]]></strType>\n";
		$ResponseXML .= "<shipMode><![CDATA[" . $row["strDescription"]  . "]]></shipMode>\n";
		$ResponseXML .= "<dblCtnQty><![CDATA[" . $row["dblCtnQty"]  . "]]></dblCtnQty>\n";
		$ResponseXML .= "<dblPcsQty><![CDATA[" . $row["dblPcsQty"]  . "]]></dblPcsQty>\n";
		$ResponseXML .= "<strISDNo><![CDATA[" . $row["strISDNo"]  . "]]></strISDNo>\n";
		$ResponseXML .= "<strDCNo><![CDATA[" . $row["strDCNo"]  . "]]></strDCNo>\n";
		$ResponseXML .= "<strDONo><![CDATA[" . $row["strDONo"]  . "]]></strDONo>\n";
	}
	
	$ResponseXML .= "</wkSheduleData>";
	 echo $ResponseXML;
}
else if($requestType=="deleteWkScheduleDetails")
{
	$Sno = $_GET["Sno"];
	deleteScheduleDetails($Sno);
}
else if($requestType=="checkScheduleDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<wkSheduleData>\n";
	
	$dfrom = $_GET["dfrom"];
	$arrDate = explode('-',$dfrom);
	$intYear = $arrDate[0];
	$wkNo = intval((date("z", strtotime($dfrom))+1)/7);
	//echo $wkNo;
	$result = getAvailableWkScheduleHeaderData($wkNo,$intYear);
	$numRows = mysql_num_rows($result);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<intWkScheduleNo><![CDATA[" . $row["intWkScheduleNo"]  . "]]></intWkScheduleNo>\n";
		$ResponseXML .= "<strWkScheduleNo><![CDATA[" . $row["strWkScheduleNo"]  . "]]></strWkScheduleNo>\n";
		$ResponseXML .= "<DateFrom><![CDATA[" . $row["DateFrom"]  . "]]></DateFrom>\n";
		$ResponseXML .= "<DateTo><![CDATA[" . $row["DateTo"]  . "]]></DateTo>\n";
	}
	$ResponseXML .= "<numRows><![CDATA[" . $numRows  . "]]></numRows>\n";
	$ResponseXML .= "</wkSheduleData>";
	echo $ResponseXML;
}
else if($requestType=="getDestinationList")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<wkSheduleDestination>\n";
	$sno = $_GET["sno"];
	
	$result = getDestinationDetails($sno);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<intCityId><![CDATA[" . $row["intCityId"]  . "]]></intCityId>\n";
		$ResponseXML .= "<strType><![CDATA[" . $row["strType"]  . "]]></strType>\n";
		$city = getCityName($row["intCityId"]);
		$ResponseXML .= "<city><![CDATA[" . $city  . "]]></city>\n";
		$ResponseXML .= "<shipMode><![CDATA[" . $row["strDescription"]  . "]]></shipMode>\n";
	}
	
	$ResponseXML .= "</wkSheduleDestination>";
	echo $ResponseXML;
	
}
function getMonthScheduleDetails($scheduleNo)
{
	global $db;
	$sql = "select fmd.intStyleId,date(fmd.dtmDeliveryDate) as deliveryDate,date(fmd.dtmHODate) as HOdate,  fmd.dblQty,o.strOrderNo,o.strStyle,fmd.intScheduleDetailId
from finishing_month_schedule_details fmd inner join orders o on
o.intStyleId = fmd.intStyleId
where fmd.intScheduleNo='$scheduleNo' and fmd.dblBalQty>0
order by o.strOrderNo";

	return $db->RunQuery($sql);
}
function getScheduleNo()
{
	global $db;
	global $companyId;
	
	$sql = "select dblWeekShipScheduleNo from syscontrol where intCompanyID='$companyId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$shipNo = $row["dblWeekShipScheduleNo"];
	
	$sql_u = "update syscontrol set dblWeekShipScheduleNo=dblWeekShipScheduleNo+1 where intCompanyID='$companyId'";
	$result_u = $db->RunQuery($sql_u);
	
	return $shipNo;
}
function insertWkScheduleHeaderData($intScheduleNo,$wkNo,$intYear,$pub_WksheduleNo,$dfrom,$dTo)
{
	global $db;
	global $userId;
	
	$sql = "insert into finishing_week_schedule_header (intWkScheduleNo,strWkScheduleNo,intYear,intWeekNo,dtmDateFrom, 
	dtmDateTo,intUserId,dtmDate)
	values ('$intScheduleNo','$pub_WksheduleNo','$intYear','$wkNo','$dfrom','$dTo','$userId',now())";
	
	$result = $db->RunQuery($sql);
}
function insertWkScheduleDetails($intScheduleNo,$styleId,$city,$Qty,$mode,$Qty_ctn,$Qty_pcs,$mnthScheduleDetailId,$isdNo,$dcNo,$doNo,$intYear)
{
	global $db;
	$sql = " insert into finishing_week_schedule_details (intWkScheduleId,intMonthScheduleDetId,intYear,
	intStyleId,intCityId,dblQty,strType,dblCtnQty,dblPcsQty,strISDNo,strDCNo,strDONo)
	values	('$intScheduleNo','$mnthScheduleDetailId','$intYear','$styleId','$city','$Qty', '$mode','$Qty_ctn', '$Qty_pcs','$isdNo', '$dcNo','$doNo')";
	$result = $db->RunQuery($sql);
}
function getWkScheduleHeaderDetails($scheduleNo)
{
	global $db;
	$sql = "Select date(dtmDateFrom) as DateFrom,date(dtmDateTo) as DateTo from finishing_week_schedule_header where intWkScheduleNo='$scheduleNo'";
	return  $db->RunQuery($sql);
}
function getWkScheduleItemDetails($scheduleNo,$intYear)
{
	global $db;
	$sql = "Select o.strOrderNo,o.strStyle,fwsd.intWkScheduleDetailId,fwsd.intWkScheduleId,fwsd.intMonthScheduleDetId,
fwsd.intStyleId,fwsd.intCityId,fwsd.dblQty,fwsd.strType,fwsd.dblCtnQty,fwsd.dblPcsQty,fwsd.strISDNo,
fwsd.strDCNo,fwsd.strDONo,sh.strDescription
from finishing_week_schedule_details fwsd inner join orders o on
o.intStyleId = fwsd.intStyleId
inner join shipmentmode sh on sh.intShipmentModeId = fwsd.strType
where fwsd.intWkScheduleId='$scheduleNo' and fwsd.intYear = '$intYear' ";
	return  $db->RunQuery($sql);
}
function getCityName($cityId)
{
	$eshipDB = new eshipLoginDB();
	$sql = "select strCity from city where strCityCode='$cityId' ";
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strCity"];
}
function deleteScheduleDetails($Sno)
{
	global $db;
	$sql = "delete from finishing_week_schedule_details where 	intWkScheduleDetailId = '$Sno' ";
	$result = $db->RunQuery($sql);
}
function updateWkScheduleData($wkScheduleId,$Qty_ctn,$Qty_pcs,$isdNo,$dcNo,$doNo)
{
	global $db;
	$sql = " update finishing_week_schedule_details 
	set dblCtnQty = '$Qty_ctn' ,dblPcsQty = '$Qty_pcs',
	strISDNo='$isdNo', strDCNo='$dcNo',strDONo='$doNo'
	where
	intWkScheduleDetailId = '$wkScheduleId' ";
	$result = $db->RunQuery($sql);
}
function getAvailableWkScheduleHeaderData($wkNo,$intYear)
{
	global $db;
	$SQL = " select intWkScheduleNo,strWkScheduleNo,date(dtmDateFrom) as DateFrom,date(dtmDateTo) as DateTo from finishing_week_schedule_header where intWeekNo='$wkNo' and intYear='$intYear' ";
	$result = $db->RunQuery($SQL);
	return $result;
}
function checkWkScheduleAvailability($wkScheduleId,$styleId,$city,$mode)
{
	global $db;
	$sql = "select * from finishing_week_schedule_details where intWkScheduleId='$wkScheduleId' and intStyleId='$styleId' and intCityId='$city' and strType='$mode' ";
	
	//return $db->CheckRecordAvailability($sql);
	return $db->RunQuery($sql);
}
function getDestinationDetails($sno)
{
	global $db;
	$sql = "select distinct intCityId,strType,sh.strDescription 
from finishing_week_schedule_details fws inner join shipmentmode sh on
fws.strType = sh.intShipmentModeId where intWkScheduleId='$sno'";
	return $db->RunQuery($sql);
}
function getShipModeDetails()
{
	global $db;
	$sql = "select intShipmentModeId,strCode from shipmentmode where intStatus=1 ";
	return $db->RunQuery($sql);
}

function updateMonthScheduleBalQty($monthScheduleId,$preQty_pcs)
{
	global $db;
	
	$sql = "update finishing_month_schedule_details 
	set
	dblBalQty =dblBalQty + '$preQty_pcs' 
	where
	intScheduleDetailId = '$monthScheduleId' ";
	$result = $db->RunQuery($sql);
}
?>
