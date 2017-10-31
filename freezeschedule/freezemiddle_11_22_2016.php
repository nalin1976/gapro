<?php

session_start();

include "../Connector.php";	
include "../d2dConnector.php";


$companyId=$_SESSION["FactoryID"];
$backwardseperator = "../";

$RequestType = $_GET["RequestType"];
$userId		 = $_SESSION["UserID"];

header('Content-Type: text/xml'); 


if(strcmp($RequestType,"SaveFreeze") == 0){

	$freezemonth  	= $_GET["m"];
	$freezeyear 	= $_GET["y"];
	$dtHoFrom 		= $_GET["dtfrom"];
	$dtHoTo			= $_GET["dtto"];

	
	
	$ressult = SetFreezeSchedule($freezemonth, $freezeyear, $dtHoFrom, $dtHoTo);

	$ResponseXML = "";
	$ResponseXML = "<SaveSchedule>\n";
	$ResponseXML .= "<SaveMsg><![CDATA[" . $ressult . "]]></SaveMsg>\n";
	$ResponseXML .= "</SaveSchedule>\n";

	echo $ResponseXML;
}


if(strcmp($RequestType,"IsExist") == 0){

	$freezemonth  	= $_GET["m"];
	$freezeyear 	= $_GET["y"];
	
	$ResponseXML = "";
	$ResponseXML = "<IsExist>\n";
	
	$res = IsFreezeExist($freezemonth, $freezeyear);


	$ResponseXML .= "<FreezeIn><![CDATA[" . $res . "]]></FreezeIn>\n";
	$ResponseXML .= "</IsExist>\n";

	echo $ResponseXML;
}


#============================================================================

// Function section 
//============================================================================

function SetFreezeSchedule($prmFreezeMonth, $prmFreezeYear, $prmHoDateFrom, $prmHoDateTo){

	global $db;

	$sql = "INSERT INTO freeze_schedule (intStyleId, dtDateofDelivery, dblQty, strRemarks, strShippingMode, intUserId, estimatedDate, dtmHandOverDate,  intBPO, intManufacturingLocation, intFreezeMonth, intFreezeYear, dblFOB, dtFreeze ) 
 (SELECT
deliveryschedule.intStyleId,
deliveryschedule.dtDateofDelivery,
deliveryschedule.dblQty,
deliveryschedule.strRemarks,
deliveryschedule.strShippingMode,
deliveryschedule.intUserId,
deliveryschedule.estimatedDate,
deliveryschedule.dtmHandOverDate,
deliveryschedule.intBPO,
deliveryschedule.intManufacturingLocation,
$prmFreezeMonth,
$prmFreezeYear,
orders.reaFOB,
now()
FROM
deliveryschedule
Inner Join orders ON deliveryschedule.intStyleId = orders.intStyleId
where (deliveryschedule.dtmHandOverDate between '$prmHoDateFrom' and '$prmHoDateTo') AND deliveryschedule.strShippingMode <> '7')";


$res = $db->executeQuery($sql);

if(!$res){
	return "Error.... in saving freeze schedule";
}else{
	return 1;
}


}

function IsFreezeExist($prmFreezeMonth, $prmFreezeYear){

	global $db;

	$sql = "SELECT * FROM freeze_schedule WHERE intFreezeMonth = $prmFreezeMonth AND intFreezeYear = $prmFreezeYear ";

	$result = $db->RunQuery($sql);

	if(mysql_num_rows($result)> 0){

		return 1;

	}else{
		return 0;
	}



}



?>