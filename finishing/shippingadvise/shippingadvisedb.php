<?php 
include "../../Connector.php";
include "../../eshipLoginDB.php";	
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];
$boolCheck =0;
if($requestType=="getWeekScheduleData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<weekScheduleData>\n";
	
	$sheduleNo 	 = $_GET["sheduleNo"];
	$mode 		 = $_GET["mode"];
	$ArrayshNo	 = explode('/',$sheduleNo);
	//$year 		 = $_GET["year"];
	//$date 		 = $_GET["date"];
	$destination = $_GET["destination"];
	
	$sql_wkShi="Select o.strOrderNo,o.strStyle,fwsd.intWkScheduleDetailId,fwsd.intWkScheduleId,fwsd.intMonthScheduleDetId,
					fwsd.intStyleId,fwsd.intCityId,fwsd.dblQty,fwsd.strType,fmsh.intYear,date(fmsh.dtmScheduleDate) as WkSheduleDate
					from finishing_week_schedule_details fwsd 
					left join orders o on o.intStyleId = fwsd.intStyleId
					left join eshipping.city C on C.strCityCode=fwsd.intCityId
					left join finishing_month_schedule_header fmsh on fmsh.intScheduleNo=fwsd.intWkScheduleId
					where fwsd.intWkScheduleId='$ArrayshNo[0]' and fwsd.intYear='$ArrayshNo[1]'  ";
	
	if($mode!="")
	{
		$sql_wkShi.="AND fwsd.strType ='$mode'";
	}
	
	/*if($year!="")
	$sql_wkShi.="AND fmsh.intYear ='$year'";
	
	if($date!="")
	$sql_wkShi.="AND date(fmsh.dtmScheduleDate) ='$date'";*/
	
	if($destination!="")
	$sql_wkShi.="AND fwsd.intCityId ='$destination'";
	
	$sql_wkShi.="order by o.strOrderNo,o.strStyle ";
	
	$result = $db->RunQuery($sql_wkShi);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		$ResponseXML .= "<intWkScheduleDetailId><![CDATA[" . $row["intWkScheduleDetailId"]  . "]]></intWkScheduleDetailId>\n";
		$ResponseXML .= "<intWkScheduleId><![CDATA[" . $row["intWkScheduleId"]  . "]]></intWkScheduleId>\n";
		$ResponseXML .= "<intCityId><![CDATA[" . $row["intCityId"]  . "]]></intCityId>\n";
		$city = getCityName($row["intCityId"]);
		$ResponseXML .= "<city><![CDATA[" . $city  . "]]></city>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		$ResponseXML .= "<Mode><![CDATA[" . $row["strType"]  . "]]></Mode>>\n";
	}
	$ResponseXML .= "</weekScheduleData>\n";
	echo $ResponseXML;		
			
}
if($requestType=="getPlData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<PLData>\n";
	
	$plNo 		 = $_GET["plNo"];
	$poNo 		 = $_GET["poNo"];
	$styleNo 	 = $_GET["styleNo"];
	
	$eshipDB = new eshipLoginDB();
	$sql_pl="select SPH.strPLNo, 
					SPH.strSailingDate, 
					SPH.strStyle, 
					SPH.strProductCode, 
					SPH.strItem, 
					sum(dblNoofPCZ) as Qty
					from 
					shipmentplheader SPH
					inner join shipmentpldetail SPD on SPH.strPLNo=SPD.strPLNo
					where SPH.strPLNo <> 'a' ";
	if($plNo!="")
	$sql_pl .="and SPH.strPLNo='$plNo'";
	
	if($poNo!="")
	$sql_pl .="and SPH.strStyle='$poNo'";
	
	if($styleNo!="")
	$sql_pl .="and SPH.strProductCode='$styleNo'";
	
	$sql_pl .="group by SPH.strPLNo order by SPH.strPLNo";
	
	$result = $eshipDB->RunQuery($sql_pl);
	
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<poNo><![CDATA[" . $row["strStyle"]  . "]]></poNo>\n";
		$ResponseXML .= "<PlNo><![CDATA[" . $row["strPLNo"]   . "]]></PlNo>\n";	
		$ResponseXML .= "<Date><![CDATA[" . $row["strSailingDate"]   . "]]></Date>\n";	
		$ResponseXML .= "<StyleNo><![CDATA[" . $row["strProductCode"]   . "]]></StyleNo>\n";	
		$ResponseXML .= "<Item><![CDATA[" . $row["strItem"]   . "]]></Item>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["Qty"]   . "]]></Qty>\n";
	}
	$ResponseXML .= "</PLData>\n";
	echo $ResponseXML;
}
if($requestType=="getShipAdvNo")
{
	$shipAdvNo = getShipAdvNo();
	$ShippingAdviseNo = $shipAdvNo.'/'.date('Y');
	echo $ShippingAdviseNo;
}
if($requestType=="saveShipAdvHeader")
{
	$pub_ShipAdvNo  = $_GET["pub_ShipAdvNo"];
	$mode		    = ($_GET["mode"]==""?'null':$_GET["mode"]);
	$destination	= ($_GET["destination"]==""?'null':$_GET["destination"]);
	$shipAdvDate	= $_GET["shipAdvDate"];
	$arrShipAdvNo   = explode('/',$pub_ShipAdvNo);
	
	$sql_check = "select intShippingAdviseNo,intShippingAdviseYear from finishing_shipping_advise_header
					where intShippingAdviseNo='$arrShipAdvNo[0]' and intShippingAdviseYear='$arrShipAdvNo[1]'; ";
	
	$result_check = $db->RunQuery($sql_check);
	if(mysql_num_rows($result_check)==0)
	{
		insertShipAdvHeaderData($arrShipAdvNo[0],$arrShipAdvNo[1],$mode,$destination,$shipAdvDate);
		
	}
	else
	{
		updateShipAdvHeaderData($arrShipAdvNo[0],$arrShipAdvNo[1],$mode,$destination,$shipAdvDate);
	}
	
}

if($requestType=="SaveShipAdvDetails")
{
	$shipAdvNo 	 = $_GET["shipAdvNo"];
	$arrNo 		 = explode('/',$shipAdvNo);
	$wkSheduleId = $_GET["wkSheduleId"];
	$styleId	 = $_GET["styleId"];
	$plNo		 = ($_GET["plNo"]==""?'0':$_GET["plNo"]);

	$sql_in = " insert into finishing_shipping_advise_detail 
				(intShippingAdviseNo, 
				intShippingAdviseYear, 
				intWkScheduleDetailId, 
				intStyleId, 
				intPLNo
				)
				VALUES
				(
				'$arrNo[0]',
				'$arrNo[1]',
				'$wkSheduleId',
				'$styleId',
				 $plNo
				)";
				
	$result = $db->RunQuery($sql_in);
}
if($requestType=="DeleteShipAdvDetails")
{
	$shipAdvNo 	 = $_GET["shipAdvNo"];
	$arrNo 		 = explode('/',$shipAdvNo);
	
	$sql_del = " delete from finishing_shipping_advise_detail 
			 	where intShippingAdviseNo ='$arrNo[0]' AND intShippingAdviseYear = '$arrNo[1]';";
	
	$result = $db->RunQuery($sql_del);
}
if($requestType=="loadShipAdviseData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<ShipAdviseData>\n";
	
	$shipAdvId = $_GET["shipAdvId"];
	$shipAdvArray = explode('/',$shipAdvId);
	
	$sql_load = "select FSAH.intShippingAdviseNo,FSAH.intShippingAdviseYear,FWSD.intWkScheduleId,FSAH.dtmShippingAdviseDate,FSAH.intShipmentModeId,FSAH.intDestination,
FSAD.intWkScheduleDetailId,FSAD.intStyleId,FSAD.intPLNo,fWSD.intCityId,fWSD.strType,O.strOrderNo,O.strStyle,FWSD.dblQty,FSAH.intUserId,FSAD.intPLNo,FSAH.intStatus
from finishing_shipping_advise_header FSAH
INNER JOIN finishing_shipping_advise_detail FSAD ON FSAD.intShippingAdviseNo=FSAH.intShippingAdviseNo 
INNER JOIN finishing_week_schedule_details FWSD ON FWSD.intWkScheduleDetailId=FSAD.intWkScheduleDetailId
INNER JOIN orders O ON O.intStyleId=FWSD.intStyleId
and FSAD.intShippingAdviseYear=FSAH.intShippingAdviseYear
where FSAH.intShippingAdviseNo='$shipAdvArray[0]' and FSAH.intShippingAdviseYear='$shipAdvArray[1]' and FSAH.intUserId='$userId';";

	$result = $db->RunQuery($sql_load);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		$ResponseXML .= "<intWkScheduleDetailId><![CDATA[" . $row["intWkScheduleDetailId"]  . "]]></intWkScheduleDetailId>\n";
		$ResponseXML .= "<intWkScheduleId><![CDATA[" . $row["intWkScheduleId"]  . "]]></intWkScheduleId>\n";
		$ResponseXML .= "<intCityId><![CDATA[" . $row["intDestination"]  . "]]></intCityId>\n";
		$city = getCityName($row["intCityId"]);
		$ResponseXML .= "<city><![CDATA[" . $city  . "]]></city>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		$ResponseXML .= "<Mode><![CDATA[" . $row["strType"]  . "]]></Mode>>\n";
		
		$ResponseXML .= "<shipAdvDate><![CDATA[" . $row["dtmShippingAdviseDate"]  . "]]></shipAdvDate>>\n";
		$ResponseXML .= "<PLNo><![CDATA[" . $row["intPLNo"]  . "]]></PLNo>>\n";
		$ResponseXML .= "<ModeId><![CDATA[" . $row["intShipmentModeId"]  . "]]></ModeId>>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>>\n";
	}
	$ResponseXML .= "</ShipAdviseData>\n";
	echo $ResponseXML;		
	
}
if($requestType=='ConfirmShipAdv')
{
	$ShipAdvNo 	 = $_GET["ShipAdvNo"];
	$arrNo 		 = explode('/',$ShipAdvNo);
	
	$sql_confirm ="update finishing_shipping_advise_header 
					set intStatus = 1
					where intShippingAdviseNo='$arrNo[0]' and intShippingAdviseYear='$arrNo[1]';";
	
	$result_confirm	= $db->RunQuery($sql_confirm);
	if($result_confirm)
	echo "confirmed";
	
}
	
function getCityName($cityId)
{
	$eshipDB = new eshipLoginDB();
	$sql = "select strCity from city where strCityCode='$cityId' ";
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strCity"];
}
function getShipAdvNo()
{
	global $db;
	global $companyId;
	
	$sql = "select intShippingAdviseNo from syscontrol where intCompanyID='$companyId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$shipAdvNo = $row["intShippingAdviseNo"];
	
	$sql_u = "update syscontrol set intShippingAdviseNo=intShippingAdviseNo+1 where intCompanyID='$companyId'";
	$result_u = $db->RunQuery($sql_u);
	
	return $shipAdvNo;
}
function insertShipAdvHeaderData($shipAdvNo,$shipAdvYear,$mode,$destination,$shipAdvDate)
{
	global $db;
	global $userId;
	
	$sql = "insert into finishing_shipping_advise_header 
				(intShippingAdviseNo, 
				intShippingAdviseYear, 
				dtmShippingAdviseDate, 
				intShipmentModeId, 
				intDestination,  
				dtmDateSaved, 
				intUserId
				)
				VALUES
				(
				'$shipAdvNo',
				'$shipAdvYear',
				'$shipAdvDate',
				 $mode,
				 $destination,
				 now(),
				'$userId'
				)";
	
	$result = $db->RunQuery($sql);
	echo $sql;
}
function updateShipAdvHeaderData($shipAdvNo,$shipAdvYear,$mode,$destination,$shipAdvDate)
{
	global $db;
	$sql_update = "update finishing_shipping_advise_header 
					set	dtmShippingAdviseDate = '$shipAdvDate' , 
						intShipmentModeId =$mode , 
						intDestination =$destination 
						where intShippingAdviseNo='$shipAdvNo' and intShippingAdviseYear='$shipAdvYear';";
	
	$result_update = $db->RunQuery($sql_update);
	echo $sql_update;
}
function checkShipAdvAvailability($shiAdvId,$shiAdvYear,$wkSheduleId,$styleId)
{
	global $db;
	$sql = "select * from finishing_shipping_advise_detail where intShippingAdviseNo='$shiAdvId' and intShippingAdviseYear='$shiAdvYear' and intWkScheduleDetailId='$wkSheduleId' and intStyleId='$styleId' ";
	
	return $db->CheckRecordAvailability($sql);
}
function deleteShipAdvData($shiAdvId,$shiAdvYear)
{
	global $db;
	$sql = " delete from finishing_shipping_advise_detail 
			 where intShippingAdviseNo ='$shiAdvId' AND intShippingAdviseYear = '$shiAdvYear';";
	
	$result = $db->RunQuery($sql);
	echo $sql;
}
function insertShipAdvDetails($shiAdvId,$shiAdvYear,$wkSheduleId,$styleId,$plNo)
{
	global $db;
	$sql = " insert into finishing_shipping_advise_detail 
				(intShippingAdviseNo, 
				intShippingAdviseYear, 
				intWkScheduleDetailId, 
				intStyleId, 
				intPLNo
				)
				VALUES
				(
				'$shiAdvId',
				'$shiAdvYear',
				'$wkSheduleId',
				'$styleId',
				 $plNo
				)";
	$result = $db->RunQuery($sql);
}

?>