<?php 
session_start();
 
include "../../Connector.php";
include "../../eshipLoginDB.php";
	
$requestType 	= $_GET["requestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="getWeekScheduleData")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<weekScheduleData>\n";
	
	$sheduleNo 	 = $_GET["sheduleNo"];
	$mode 		 = $_GET["mode"];
	//$year 		 = $_GET["year"];
	//$date 		 = $_GET["date"];
	$destination = $_GET["destination"];
	
	$sql_wkShi="Select o.strOrderNo,o.strStyle,fwsd.intWkScheduleDetailId,fwsd.strType,fwsd.intWkScheduleId,fwsd.intMonthScheduleDetId,
					fwsd.intStyleId,fwsd.intCityId,fwsd.dblQty,SM.strDescription,fmsh.intYear,date(fmsh.dtmScheduleDate) as WkSheduleDate
					from finishing_week_schedule_details fwsd 
					inner join orders o on o.intStyleId = fwsd.intStyleId
					inner join eshipping.city C on C.strCityCode=fwsd.intCityId
					left join finishing_month_schedule_header fmsh on fmsh.intScheduleNo=fwsd.intWkScheduleId
					left join shipmentmode SM on SM.intShipmentModeId=fwsd.strType
					where fwsd.intWkScheduleId='$sheduleNo' "; //original query
					
					
/*	$sql_wkShi="Select  o.strOrderNo,o.strStyle,fwsd.intWkScheduleDetailId,fwsd.intWkScheduleId,fwsd.intMonthScheduleDetId,
				fwsd.intStyleId,fwsd.intCityId,fwsd.dblQty,SM.strDescription,fmsh.intYear,date(fmsh.dtmScheduleDate) as WkSheduleDate
				from finishing_week_schedule_details fwsd 
				inner join orders o on o.intStyleId = fwsd.intStyleId
				inner join eshipping.city C on C.strCityCode=fwsd.intCityId
				left join finishing_month_schedule_header fmsh on fmsh.intScheduleNo=fwsd.intWkScheduleId
				left join shipmentmode SM 
				on SM.intShipmentModeId in(Select case 
				when strType='sea' then '54' 
				when strType='air' then '53'
				else '55' end as id from finishing_week_schedule_details where intWkScheduleId='$sheduleNo' )
				#(select strType from finishing_week_schedule_details where intWkScheduleId ='$sheduleNo')
				where fwsd.intWkScheduleId='$sheduleNo'";	*/			
//echo $sql_wkShi;
	
	if($mode !="")
	{
		$sql_wkShi.="AND fwsd.strType ='$mode'";
	}
	
	/*if($year!="")
	$sql_wkShi.="AND fmsh.intYear ='$year'";
	
	if($date!="")
	$sql_wkShi.="AND date(fmsh.dtmScheduleDate) ='$date'";*/
	
	if($destination !="")
	{
		$sql_wkShi.="AND fwsd.intCityId ='$destination'";
	}
	
	$sql_wkShi.="order by o.strOrderNo,o.strStyle ;";
	
	$result = $db->RunQuery($sql_wkShi);
	//die($sql_wkShi);

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
elseif($requestType=="getPlData")
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
					eshipping.shipmentplheader SPH
					inner join shipmentpldetail SPD on SPH.strPLNo=SPD.strPLNo
					where SPH.strPLNo <> 'a' 
					";
	if($plNo!="")
	{
		$sql_pl .="and SPH.strPLNo='$plNo' and SPH.strPLNo NOT IN (select distinct gapro.finishing_gatepass_detail.intPlNo 
					from gapro.finishing_gatepass_detail) ";
	}
	else{
		$sql_pl .="and SPH.strPLNo NOT IN (select distinct gapro.finishing_gatepass_detail.intPlNo 
					from gapro.finishing_gatepass_detail)";
	}
	
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
elseif($requestType=="saveData")
{

	$currentdate		=	getdate();
	$invDate		=	$_GET["invDate"];
	$timeInDt		= 	$_GET["timeInDt"];
	$timeOutDt		=	$_GET["timeOutDt"];
	$timeOut		=	$_GET["timeOut"];
	$timein			=	$_GET["timein"];
	$vehNo			=	$_GET["vehNo"];
	$authorised		=	$_GET["auth"];
	$deliver		= 	$_GET["deliver"];
	$forwarder		=	($_GET["forwarder"]==""?'null':$_GET["forwarder"]);
	$wklySchduleNo	=	($_GET["wklySchduleNo"]==""?'null':$_GET["wklySchduleNo"]);
	$modeid			=	$_GET["modeid"];
	$cityCode		=	$_GET["cityCode"];
	$gatePassNo		=	$_GET["gatePassNo"];
	$invYear		=	$currentdate["year"];
	$driver			=	$_GET["driver"];
	
	# IF GATE PASS IS NONE_EMPTY IT'S AN UPDATE ELSE IT'S AN INSERT
	if($gatePassNo=='')
	{
		$gatePassNo = getCurrentGatepassNo($companyId);
		incGatePass($companyId);
		
		# inserting new records to the table.
		$sql_fgpheader	="INSERT INTO finishing_gatepass_header
						(finishing_gatepass_header.intGatePassNo,
						finishing_gatepass_header.intGatePassYear,
						finishing_gatepass_header.intWkScheduleNo,
						finishing_gatepass_header.intCompanyID,
						finishing_gatepass_header.intForwarderID,
						finishing_gatepass_header.intUserId,
						finishing_gatepass_header.strVehicleNo,
						finishing_gatepass_header.strAuthorisedBy,
						finishing_gatepass_header.strDeliveredBy,
						finishing_gatepass_header.dtmDate,
						finishing_gatepass_header.dtmDateIn,
						finishing_gatepass_header.dtmDateOut,
						finishing_gatepass_header.strTimeIn,
						finishing_gatepass_header.strTimeOut,
						finishing_gatepass_header.strDriver)
						VALUES(
							$gatePassNo,
							$invYear,
							$wklySchduleNo,
							$companyId,
							$forwarder,
							'$userId',
							'$vehNo',
							'$authorised',
							'$deliver',
							'$invDate',
							'$timeInDt',
							'$timeOutDt',
							'$timein',
							'$timeOut',
							'$driver');";
	}
	else{
		 $sql_fgpheader	="UPDATE  finishing_gatepass_header
							SET 
							finishing_gatepass_header.intWkScheduleNo = '$wklySchduleNo' ,
							finishing_gatepass_header.intCompanyID = '$companyId' ,
							finishing_gatepass_header.intForwarderID = $forwarder ,
							finishing_gatepass_header.intUserId = '$userId' ,
							finishing_gatepass_header.strVehicleNo = '$vehNo' ,
							finishing_gatepass_header.strAuthorisedBy = '$authorised',
							finishing_gatepass_header.strDeliveredBy ='$deliver' ,
							finishing_gatepass_header.dtmDate = '$invDate' ,
							finishing_gatepass_header.dtmDateIn = '$timeInDt' ,
							finishing_gatepass_header.dtmDateOut = '$timeOutDt' ,
							finishing_gatepass_header.strTimeIn = '$timein' ,
							finishing_gatepass_header.strTimeOut = '$timeOut',
							finishing_gatepass_header.strDriver = '$driver'
							WHERE (finishing_gatepass_header.intGatePassNo ='$gatePassNo'  AND
							finishing_gatepass_header.intGatePassYear ='$invYear' )  ;";		
	}
	
	 		
	 $header_result =$db->RunQuery($sql_fgpheader);


	echo ($header_result?$gatePassNo:$gatePassNo = "-1__".mysql_error($header_result)); 

	//echo $gatePassNo;
	
}
elseif($requestType=="saveGridData")
{
	$styleNo			= $_GET["styleNo"];
	$styleId			= $_GET["styleId"];
	$plNo				= $_GET["plNo"];
	$gatePassNo			= $_GET["gatePassNo"];
	$intWkScheduleDetailId = ($_GET["intWkScheduleDetailId"]==""?'null':$_GET["intWkScheduleDetailId"]);
	$currentdate		=	getdate();
	$invYear			=	$currentdate["year"];


	$sql_insert = "INSERT INTO finishing_gatepass_detail
				  ( intGatePassNo,intGatePassYear,intWkScheduleDetailId,intStyleId,intPlNo)
				  VALUES 
				  ('$gatePassNo','$invYear',$intWkScheduleDetailId,'$styleId','$plNo');";
	
	$result_insrt	=$db->RunQuery($sql_insert);
	
	echo($result_insrt?"Saved":"fail");

}
elseif($requestType=="deleteFgpDetailTbldata")
{
	$gatePassNo		= $_GET["gatePassNo"];
	$currentdate		=	getdate();
	$currentdate		=	getdate();
	$invYear			=	$currentdate["year"];
	
	###### Deleting all thr records of a particular primary key set before inserting #########
	
	$sql_fgpdetail ="DELETE  FROM finishing_gatepass_detail 
						WHERE intGatePassNo ='$gatePassNo' AND 
						intGatePassYear ='$invYear';";
						
	$result_del	=$db->RunQuery($sql_fgpdetail);
	
	echo($result_del?"Saved":"fail");
	
}
elseif($requestType=="loadGatePassDetails")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$gatePassNo		=	$_GET["gatePassNo"];
	$gatePassYear	=	$_GET["gatePassYear"];
	$ResponseXML = "";
	$ResponseXML .= "<LoadGPScreen>\n";
	if($gatePassNo !="")
	{
		$sql_loadgpScreen ="select intWkScheduleNo,intCompanyID,intForwarderID,
							intUserId,strVehicleNo,strAuthorisedBy,strDeliveredBy,dtmDate,
							dtmDateIn,dtmDateOut,strTimeIn,strTimeOut,strDriver
							from finishing_gatepass_header
							where intGatePassNo ='$gatePassNo' AND
							intGatePassYear='$gatePassYear';";
			//echo $sql_loadgpScreen;			
		$result	=$db->RunQuery($sql_loadgpScreen);
		while($row	=	mysql_fetch_array($result))
		{
		
			$ResponseXML .= "<gatePassYear><![CDATA[".$gatePassYear."]]></gatePassYear>\n";
			$ResponseXML .= "<intWkScheduleNo><![CDATA[" .$row["intWkScheduleNo"]. "]]></intWkScheduleNo>\n";
			$ResponseXML .= "<intCompanyID><![CDATA[" .$row["intCompanyID"]. "]]></intCompanyID>\n";
			$ResponseXML .= "<intForwarderID><![CDATA[" .$row["intForwarderID"]. "]]></intForwarderID>\n";
			$ResponseXML .= "<strVehicleNo><![CDATA[" .$row["strVehicleNo"]. "]]></strVehicleNo>\n";
			$ResponseXML .= "<strAuthorisedBy><![CDATA[" .$row["strAuthorisedBy"]. "]]></strAuthorisedBy>\n";
			$ResponseXML .= "<strDeliveredBy><![CDATA[" .$row["strDeliveredBy"]. "]]></strDeliveredBy>\n";
			$ResponseXML .= "<dtmDate><![CDATA[" .$row["dtmDate"]. "]]></dtmDate>\n";
			$ResponseXML .= "<dtmDateIn><![CDATA[" .$row["dtmDateIn"]. "]]></dtmDateIn>\n";
			$ResponseXML .= "<dtmDateOut><![CDATA[" .$row["dtmDateOut"]. "]]></dtmDateOut>\n";
			$ResponseXML .= "<strTimeIn><![CDATA[" .$row["strTimeIn"]. "]]></strTimeIn>\n";
			$ResponseXML .= "<strTimeOut><![CDATA[" .$row["strTimeOut"]. "]]></strTimeOut>\n";
			$ResponseXML .= "<strDriver><![CDATA[" .$row["strDriver"]. "]]></strDriver>\n";
		}
	}
	
	$ResponseXML .= "</LoadGPScreen>\n";
	echo $ResponseXML;

}
elseif($requestType=="loadFGPdetails")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$gatePassNo		=	$_GET["gatePassNo"];
	$gatePassYear	=	$_GET["gatePassYear"];
	$wklySchduleNo	=	$_GET["wklySchduleNo"];

	$ResponseXML .= "<loadFGPdetails>\n";
	if($gatePassNo !="")
	{
		#### create he intermideate view ##########################
		$sql_createView ="Create view tempfinalgpdetailsdata as(Select o.strOrderNo,o.strStyle,fwsd.strType,
						  fwsd.intWkScheduleDetailId,fwsd.intWkScheduleId,
						  fwsd.intMonthScheduleDetId,fwsd.intStyleId,fwsd.intCityId,
						  fwsd.dblQty,SM.strDescription,SM.intShipmentModeId as strMode,
						  fmsh.intYear,date(fmsh.dtmScheduleDate) as WkSheduleDate
						  from finishing_week_schedule_details fwsd 
						  inner join orders o on o.intStyleId = fwsd.intStyleId
						  inner join eshipping.city C on C.strCityCode=fwsd.intCityId
						  left join finishing_month_schedule_header fmsh on fmsh.intScheduleNo=fwsd.intWkScheduleId
						  left join shipmentmode SM on SM.intShipmentModeId=fwsd.strType
						  where fwsd.intWkScheduleId='$wklySchduleNo');"; 
							
		$result	=$db->RunQuery($sql_createView);
		
		
		$sql_filterFGPDtl = "SELECT
							TFGPDtl.strStyle,
							TFGPDtl.strOrderNo,
							TFGPDtl.strDescription,
							TFGPDtl.strType,
							TFGPDtl.strMode,
							TFGPDtl.intCityId,
							TFGPDtl.intWkScheduleDetailId,
							TFGPDtl.intWkScheduleId,
							TFGPDtl.dblQty,
							TFGPDtl.intStyleId,
							FGPDtl.intGatePassNo,
							FGPDtl.intGatePassYear,
							FGPDtl.intPlNo
							FROM
							tempfinalgpdetailsdata AS TFGPDtl
							inner Join finishing_gatepass_detail AS FGPDtl
							 ON TFGPDtl.intWkScheduleDetailId = FGPDtl.intWkScheduleDetailId
							AND TFGPDtl.intStyleId = FGPDtl.intStyleId
							AND TFGPDtl.intStyleId = FGPDtl.intStyleId
							WHERE
							FGPDtl.intGatePassNo = '$gatePassNo' AND
							FGPDtl.intGatePassYear = '$gatePassYear' AND
							TFGPDtl.intWkScheduleId = '$wklySchduleNo';";
							
							$result	=$db->RunQuery($sql_filterFGPDtl);
						//echo $result;
							
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<intStyleId><![CDATA[".$row["intStyleId"]."]]></intStyleId>\n";
			$ResponseXML .= "<strOrderNo><![CDATA[".$row["strOrderNo"]."]]></strOrderNo>\n";
			$ResponseXML .= "<strStyle><![CDATA[".$row["strStyle"]."]]></strStyle>\n";
			$ResponseXML .= "<intWkScheduleDetailId><![CDATA[".$row["intWkScheduleDetailId"]."]]></intWkScheduleDetailId>\n";
			$ResponseXML .= "<intWkScheduleId><![CDATA[".$row["intWkScheduleId"]."]]></intWkScheduleId>\n";
			$ResponseXML .= "<intCityId><![CDATA[".$row["intCityId"]."]]></intCityId>\n";
			$city = getCityName($row["intCityId"]);
			$ResponseXML .= "<city><![CDATA[".$city."]]></city>\n";
			$ResponseXML .= "<dblQty><![CDATA[".$row["dblQty"]."]]></dblQty>\n";
			$ResponseXML .= "<Mode><![CDATA[".$row["strType"]."]]></Mode>\n";
			$ResponseXML .= "<intPlNo><![CDATA[".$row["intPlNo"]."]]></intPlNo>\n";//intPlNo
		}
							
							
	  $sql_filterFGPDtl = "drop view tempfinalgpdetailsdata;";
	  # DROPING THE CREATED VIEW ######
	  $result	=$db->RunQuery($sql_filterFGPDtl);
	
	}
	$ResponseXML .= "</loadFGPdetails>\n";
	echo $ResponseXML;

	
}
	
function getCityName($cityId)
{
	$eshipDB = new eshipLoginDB();
	$sql = "select strCity from city where strCityCode='$cityId' ";
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strCity"];
}

######################################################
# incGatePass increments the gatepass number from    #
# syscontrol table and  increments the  value.       #
# @$companyId : compny id of the current company     #
######################################################
function incGatePass($companyId)
{
	global $db;
	
	$sql_incSystbl = "update syscontrol set dblGatePassNo=dblGatePassNo+1 where intCompanyID = '$companyId';";
	
	$result = $db->RunQuery($sql_incSystbl);
	
}

#####################################################
# getCurrentGatepassNo() access the syscontrol tbl  #
# and returns the current gatepass numbrt           #
# @$companyId : compny id of the current company    #
#####################################################
function getCurrentGatepassNo($companyId)
{
	global $db;
	$sql_getGatePass ="select dblGatePassNo from syscontrol where intCompanyID = '$companyId';";
	$result = $db->RunQuery($sql_getGatePass);
	
	$row		=	mysql_fetch_array($result);
	$crntGpNo	=	$row['dblGatePassNo'];
	return $crntGpNo;
}



?>