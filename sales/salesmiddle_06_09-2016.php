<?php

session_start();

include "../Connector.php";	
include "../d2dConnector.php";


$companyId=$_SESSION["FactoryID"];
$backwardseperator = "../";

$RequestType = $_GET["RequestType"];
$userId		 = $_SESSION["UserID"];

require_once('../classes/class_buyer.php');
require_once('../classes/class_sales.php');

header('Content-Type: text/xml'); 

$class_buyer = new Buyer();
$class_sales = new salesmonitoring();

$d2dConnectClass = new ClassConnectD2D();

if(strcmp($RequestType,"LoadBuyers") == 0){

	$ResponseXML = "";
	$ResponseXML = "<Buyers>\n";

	$class_buyer->SetConnection($db);
	$resBuyersList = $class_buyer->GetBuyerList();

	while($row = mysql_fetch_array($resBuyersList)){

		$ResponseXML .= "<BuyerID><![CDATA[" . $row["intBuyerID"]  . "]]></BuyerID>\n";
		$ResponseXML .= "<BuyerName><![CDATA[" . $row["strName"]  . "]]></BuyerName>\n";

	}

	$ResponseXML .= "</Buyers>";

	echo $ResponseXML;
}

if(strcmp($RequestType,"LoadDeliveries") == 0){

	$buyerid 	= $_GET["BuyerID"];
	$fromdate 	= $_GET["FromDate"];
	$todate 	= $_GET["ToDate"];

	$ResponseXML = "";
	$ResponseXML = "<DeliveryListing>\n";

	$class_sales->SetConnection($db);
	//Get user permission for approve and confirmation 
	$isCanApprove = $class_sales->GetApproveUser($userId);
	$isCanConfirm = $class_sales->GetConfirmUser($userId);

	
	$resDeliList = $class_sales->getDeliveries($buyerid, $fromdate, $todate);



	while($row = mysql_fetch_array($resDeliList)){

		//$weekno = getMonthWeekNo($row["dtmHandOverDate"]);
		$weekno = $class_sales->getMonthWeekNo($row["dtmHandOverDate"]);

		$FGStock = $class_sales->GetShippedStatusFromD2D($row["intSRNO"],  $row["intBPO"], $d2dConnectClass);

		$ResponseXML .= "<StyleID><![CDATA[" . $row["strStyle"]  . "]]></StyleID>\n";
		$ResponseXML .= "<SCNO><![CDATA[" . $row["intSRNO"]  . "]]></SCNO>\n";
		$ResponseXML .= "<HOD><![CDATA[" . $row["dtmHandOverDate"]  . "]]></HOD>\n";
		$ResponseXML .= "<BPONo><![CDATA[" . $row["intBPO"]  . "]]></BPONo>\n";
		$ResponseXML .= "<DelQty><![CDATA[" . $row["dblQty"]  . "]]></DelQty>\n";
		$ResponseXML .= "<FOB><![CDATA[" . $row["reaFOB"]  . "]]></FOB>\n";
		$ResponseXML .= "<WEEK><![CDATA[" . $weekno  . "]]></WEEK>\n";
		$ResponseXML .= "<STYLE_CODE><![CDATA[" . $row["intStyleId"]  . "]]></STYLE_CODE>\n";
		$ResponseXML .= "<FG_STOCK><![CDATA[" . $FGStock  . "]]></FG_STOCK>\n";
		$ResponseXML .= "<APPROVE><![CDATA[" . $isCanApprove  . "]]></APPROVE>\n";
		$ResponseXML .= "<CONFIRM><![CDATA[" . $isCanConfirm  . "]]></CONFIRM>\n";
	}

	$ResponseXML .= "</DeliveryListing>";

	echo $ResponseXML;
}

if(strcmp($RequestType,"SalesExist") == 0){

	$styleId 	= $_GET["styleid"];
	$buyerPONo 	= $_GET["bpono"];

	$class_sales->SetConnection($db);
	$resSalesExist = $class_sales->GetSalesExist($styleId, $buyerPONo);	
	

	$ResponseXML = "";
	$ResponseXML = "<SalesExist>\n";	

	$arrStyleExist = mysql_fetch_row($resSalesExist);

	if(is_null($arrStyleExist[0])){
		$Accmgrconfirm = 0;
	}else{
		$Accmgrconfirm 	= $arrStyleExist[0];
	}

	if(is_null($arrStyleExist[1])){
		$Shipconfirm 	= 0;
	}else{
		$Shipconfirm 	= $arrStyleExist[1];
	}
	
	

	$ResponseXML .= "<AccConfirm><![CDATA[" . $Accmgrconfirm . "]]></AccConfirm>\n";
	$ResponseXML .= "<ShipConfirm><![CDATA[" . $Shipconfirm . "]]></ShipConfirm>\n";


	$ResponseXML .= "</SalesExist>";	

	echo $ResponseXML;
}


if(strcmp($RequestType,"AccConfirm") == 0){

	$styleId 	= $_GET["styleId"];
	$buyerPONo 	= $_GET["bpono"];

	UpdateAccMgrUpdate($styleId, $buyerPONo, $userId);

}

if(strcmp($RequestType,"ShipStatusConfirm") == 0){

	$styleId 	= $_GET["styleId"];
	$buyerPONo 	= $_GET["bpono"];

	UpdateShipStatus($styleId, $buyerPONo, $userId);

}

#============================================================================

// Function section 
//============================================================================

function UpdateAccMgrUpdate($prmStyleId, $prmBuyerPO, $prmUserID){



	global $db;

	$sql = " INSERT INTO salesconfirmation(styleId, bpoNo, accmgrconfirm, accuserid, accmgrconfirmon) 
	         VALUES('$prmStyleId', '$prmBuyerPO', 1, '$prmUserID', NOW())";
	         
	$db->executeQuery($sql);         

}

function UpdateShipStatus($prmStyleId, $prmBuyerPO, $prmUserID){


	global $db;

	$sql = " UPDATE salesconfirmation SET shipconfirm = 1, shipuserid = '$prmUserID', shipconfirmon = NOW() 
	         WHERE styleId = '$prmStyleId' AND bpoNo = '$prmBuyerPO'";
        
	$db->executeQuery($sql);         

}



?>