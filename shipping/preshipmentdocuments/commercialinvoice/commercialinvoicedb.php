<?php
session_start();
header('Content-Type: text/xml'); 
$xml = simplexml_load_file('../../shipping_config.xml');
$preInvoiceNo = $xml->preShippingInvoice->invoiceNo;
include "../../../Connector.php";
$Request 		= $_GET["Request"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($Request=="loadComInvData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$SDPNo = $_GET["SDPNo"];
	
	$ResponseXML = "<XMLLoadSPDData>\n";
	
	$sql_loadSDP = "select intSDPID, 
					intBuyerBranchId, 
					intDestination, 
					intTransportMode, 
					intIncoterm, 
					intPaymentTerm, 
					intBank, 
					intPortOfLoading, 
					intExporter, 
					intManufacturer 
					from 
					shipping_sdp 
					where intSDPID='$SDPNo'";
	$result = $db->RunQuery($sql_loadSDP);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Consignee><![CDATA[".($row["intBuyerBranchId"])  . "]]></Consignee>\n";	
		$ResponseXML .= "<Destination><![CDATA[".($row["intDestination"])  . "]]></Destination>\n";
		$ResponseXML .= "<TransportMode><![CDATA[".($row["intTransportMode"])  . "]]></TransportMode>\n";
		$ResponseXML .= "<Incoterm><![CDATA[".($row["intIncoterm"])  . "]]></Incoterm>\n";
		$ResponseXML .= "<PaymentTerm><![CDATA[".($row["intPaymentTerm"])  . "]]></PaymentTerm>\n";
		$ResponseXML .= "<Bank><![CDATA[".($row["intBank"])  . "]]></Bank>\n";
		$ResponseXML .= "<PortOfLoading><![CDATA[".($row["intPortOfLoading"])  . "]]></PortOfLoading>\n";	
		$ResponseXML .= "<Exporter><![CDATA[".($row["intExporter"])  . "]]></Exporter>\n";	
		$ResponseXML .= "<Manufacturer><![CDATA[".($row["intManufacturer"])  . "]]></Manufacturer>\n";	
	}
	$ResponseXML .= "</XMLLoadSPDData>";
	echo $ResponseXML;
}
if($Request=="getInvNo")
{
	$InvNo = getInvNo();
	echo $InvNo;
}
function getInvNo()
{
	global $db;
	global $companyId;
	global $preInvoiceNo;
	
	$sql = "select intPreShipInvNo from syscontrol where intCompanyID='$companyId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$InvNo = $preInvoiceNo."".$row["intPreShipInvNo"]."/".date("m/y");
	
	$sql_u = "update syscontrol set intPreShipInvNo=intPreShipInvNo+1 where intCompanyID='$companyId'";
	$result_u = $db->RunQuery($sql_u);
	
	return $InvNo;
}
if($Request=="saveHeaderData")
{
	$invoiceNo		= $_GET["invoiceNo"];
	$invoiceNoArry  = explode('/',$invoiceNo);
	$invDate		= $_GET['invDate'];
	$SDPNo			= $_GET['SDPNo'];
	$Consignee		= $_GET['Consignee'];
	$Exporter		= $_GET['Exporter'];
	$Manufacturer	= $_GET['Manufacturer'];
	$PortOfLoading	= $_GET["PortOfLoading"];
	$TransportMode	= $_GET['TransportMode'];
	$Destination	= $_GET['Destination'];
	$Incoterm		= $_GET['Incoterm'];
	$PaymentTerm	= $_GET['PaymentTerm'];
	$Bank			= $_GET['Bank'];
	$Declaration	= ($_GET['Declaration']==""?null:$_GET['Declaration']);
	$OfficeEntry	= ($_GET['OfficeEntry']==""?null:$_GET['OfficeEntry']);
	$Carrier		= $_GET['Carrier'];
	$Voyage			= $_GET['Voyage'];
	$ETDDate		= $_GET['ETDDate'];
	$ETADate		= $_GET['ETADate'];
	$LocalCurrency	= $_GET['LocalCurrency'];
	$Currency		= $_GET['Currency'];
	$Insurance		= ($_GET['Insurance']==""?'null':$_GET['Insurance']);
	$Freight		= ($_GET['Freight']==""?'null':$_GET['Freight']);
	$Other			= ($_GET['Other']==""?'null':$_GET['Other']);
	$WharfClerk		= ($_GET['WharfClerk']==""?'null':$_GET['WharfClerk']);
	$invDateArrry	= explode('/',$invDate);
	$newInvDateArrry = $invDateArrry[2].'-'.$invDateArrry[1].'-'.$invDateArrry[0];
	$ETAArrry		 = explode('/',$ETADate);
	$newETAArrry 	 = $ETAArrry[2].'-'.$ETAArrry[1].'-'.$ETAArrry[0];
	$ETDArrry		 = explode('/',$ETDDate);
	$newETDArrry 	 = $ETDArrry[2].'-'.$ETDArrry[1].'-'.$ETDArrry[0];
	
	$sql_deleteHeader = "delete from shipping_pre_inv_header where intInvoiceNo ='$invoiceNoArry[2]' ;";
	$db->executeQuery($sql_deleteHeader);
	
	$sql_insertHeader = "insert into shipping_pre_inv_header 
						(intInvoiceNo, 
						strInvoice, 
						dtmInvoiceDate, 
						intSDPNo, 
						intConsignee, 
						intExporter, 
						intManufacturer, 
						intPortOfLoading, 
						intShipmentMode, 
						intDestination, 
						intIncoTerm, 
						intPayTerm, 
						intBank, 
						strDeclaration, 
						strOfficeOfEntry, 
						strCarrier, 
						strVoyage, 
						dtmETD, 
						dtmETA, 
						intCurrency, 
						intLocalCurrcy, 
						dblInsurancy, 
						dblFreight, 
						dblOther, 
						intWharfClerk, 
						dtmSavedDate, 
						intUserId
						)
						values
						(
						$invoiceNoArry[2],
						'$invoiceNo',
						'$newInvDateArrry',
						$SDPNo,
						$Consignee,
						$Exporter,
						$Manufacturer,
						$PortOfLoading,
						$TransportMode,
						$Destination,
						$Incoterm,
						$PaymentTerm,
						$Bank,
						'$Declaration',
						'$OfficeEntry',
						'$Carrier',
						'$Voyage',
						'$newETDArrry',
						'$newETAArrry',
						$Currency,
						$LocalCurrency,
						$Insurance,
						$Freight,
						$Other,
						$WharfClerk,
						now(),
						$userId
						)";
	$result_header=$db->RunQuery($sql_insertHeader);
	if($result_header)
		echo "HeaderSaved";
	else
		echo "ErrorSave";
}
if($Request=="loadData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoiceNo = $_GET["invoiceNo"];
	
	$ResponseXML = "<XMLLoadData>\n";
	$sql_load = "SELECT *,date(dtmInvoiceDate) as InvoiceDate FROM shipping_pre_inv_header WHERE intInvoiceNo='$invoiceNo' ;";
	$result = $db->RunQuery($sql_load);
	while($row = mysql_fetch_array($result))
	{
		$invoiceDate	= $row["InvoiceDate"];
		$ETDDate		= $row["dtmETD"];
		$ETADate		= $row["dtmETA"];
		$invDateArrry	= explode('-',$invoiceDate);
		$newInvDateArrry = $invDateArrry[2].'/'.$invDateArrry[1].'/'.$invDateArrry[0];
		$ETAArrry		 = explode('-',$ETADate);
		$newETAArrry 	 = $ETAArrry[2].'/'.$ETAArrry[1].'/'.$ETAArrry[0];
		$ETDArrry		 = explode('-',$ETDDate);
		$newETDArrry 	 = $ETDArrry[2].'/'.$ETDArrry[1].'/'.$ETDArrry[0];
		
		$ResponseXML .= "<InvoiceDate><![CDATA[". $newInvDateArrry  . "]]></InvoiceDate>\n";	
		$ResponseXML .= "<SDPNo><![CDATA[".($row["intSDPNo"])  . "]]></SDPNo>\n";
		$ResponseXML .= "<Consignee><![CDATA[".($row["intConsignee"])  . "]]></Consignee>\n";
		$ResponseXML .= "<Exporter><![CDATA[".($row["intExporter"])  . "]]></Exporter>\n";
		$ResponseXML .= "<Manufacturer><![CDATA[".($row["intManufacturer"])  . "]]></Manufacturer>\n";
		$ResponseXML .= "<PortOfLoading><![CDATA[".($row["intPortOfLoading"])  . "]]></PortOfLoading>\n";
		$ResponseXML .= "<ShipmentMode><![CDATA[".($row["intShipmentMode"])  . "]]></ShipmentMode>\n";	
		$ResponseXML .= "<Destination><![CDATA[".($row["intDestination"])  . "]]></Destination>\n";	
		$ResponseXML .= "<IncoTerm><![CDATA[".($row["intIncoTerm"])  . "]]></IncoTerm>\n";	
		$ResponseXML .= "<PayTerm><![CDATA[".($row["intPayTerm"])  . "]]></PayTerm>\n";	
		$ResponseXML .= "<Bank><![CDATA[".($row["intBank"])  . "]]></Bank>\n";	
		$ResponseXML .= "<Declaration><![CDATA[".($row["strDeclaration"])  . "]]></Declaration>\n";
		$ResponseXML .= "<OfficeOfEntry><![CDATA[".($row["strOfficeOfEntry"])  . "]]></OfficeOfEntry>\n";
		$ResponseXML .= "<Carrier><![CDATA[".($row["strCarrier"])  . "]]></Carrier>\n";
		$ResponseXML .= "<Voyage><![CDATA[".($row["strVoyage"])  . "]]></Voyage>\n";
		$ResponseXML .= "<ETD><![CDATA[". $newETDArrry  . "]]></ETD>\n";
		$ResponseXML .= "<ETA><![CDATA[". $newETAArrry   . "]]></ETA>\n";	
		$ResponseXML .= "<Currency><![CDATA[".($row["intCurrency"])  . "]]></Currency>\n";
		$ResponseXML .= "<LocalCurrcy><![CDATA[".($row["intLocalCurrcy"])  . "]]></LocalCurrcy>\n";
		$ResponseXML .= "<Insurancy><![CDATA[".($row["dblInsurancy"])  . "]]></Insurancy>\n";
		$ResponseXML .= "<Freight><![CDATA[".($row["dblFreight"])  . "]]></Freight>\n";
		$ResponseXML .= "<Other><![CDATA[".($row["dblOther"])  . "]]></Other>\n";	
		$ResponseXML .= "<WharfClerk><![CDATA[".($row["intWharfClerk"])  . "]]></WharfClerk>\n";	
	}
	$ResponseXML .= "</XMLLoadData>";
	echo $ResponseXML;
}
if($Request=="deleteData")
{
	$invNo = $_GET["invNo"];
	$sql_delete = "delete from shipping_pre_inv_header where intInvoiceNo ='$invNo'";
	$result = $db->RunQuery($sql_delete);
	if($result)
		echo "Deleted";
	else
		echo "Error";
}
if($Request=="loadPOData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$weeklyShedNo = $_GET["weeklyShedNo"];
	$destination  = $_GET["destination"];
	$mode 		  = $_GET["mode"];
	
	$ResponseXML = "<XMLLoadPOData>\n";
	$sql_loadPO = "select O.strOrderNo,FFD.strCityName,O.intStyleId,FWSD.intWkScheduleDetailId
					from finishing_week_schedule_header FWSH
					Inner Join finishing_week_schedule_details FWSD ON FWSH.intWkScheduleNo=FWSD.intWkScheduleId
					Inner Join orders O ON O.intStyleId=FWSD.intStyleId
					Inner Join finishing_final_destination FFD ON FFD.intCityID=FWSD.intCityId
					where FWSH.intWkScheduleNo='$weeklyShedNo'";
	if($destination!="")
		$sql_loadPO.=" AND FFD.intCityID='$destination'";
	if($mode!="")
		$sql_loadPO.=" AND FWSD.strType='$mode'";
		$sql_loadPO.= "order by O.strOrderNo";
	
	$result = $db->RunQuery($sql_loadPO);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<PONo><![CDATA[".($row["strOrderNo"])  . "]]></PONo>\n";	
		$ResponseXML .= "<cityName><![CDATA[".($row["strCityName"])  . "]]></cityName>\n";
		$ResponseXML .= "<styleId><![CDATA[".($row["intStyleId"])  . "]]></styleId>\n";
		$ResponseXML .= "<WkScheduleDetailId><![CDATA[".($row["intWkScheduleDetailId"])  . "]]></WkScheduleDetailId>\n";
	}
	$ResponseXML .= "</XMLLoadPOData>";
	echo $ResponseXML;
			
}
if($Request=="loadDataToMainGrid")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$stleNo = $_GET["stleNo"];
	
	$ResponseXML = "<XMLLoadDataToMGrid>\n";
	$SQL = "select FOS.strHSCode,IC.dblFOB,O.strStyle,O.intStyleId
			from finishing_order_spec FOS
			left join invoicecostingheader IC ON IC.intStyleId=FOS.intStyleId
			inner join orders O ON O.intStyleId=FOS.intStyleId
			where O.intStyleId='$stleNo'";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<HSCode><![CDATA[".($row["strHSCode"])  . "]]></HSCode>\n";	
		$ResponseXML .= "<FOB><![CDATA[".($row["dblFOB"])  . "]]></FOB>\n";
		$ResponseXML .= "<Style><![CDATA[".($row["strStyle"])  . "]]></Style>\n";
	}
	$ResponseXML .= "</XMLLoadDataToMGrid>";
	echo $ResponseXML;
}
if($Request=="loadPLDataToGridByPLPop")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$PLNo = $_GET["PLNo"];
	
	$ResponseXML = "<XMLLoadDataToMGridByPLPop>\n";
	$sql = "select  O.strOrderNo,
			O.strStyle,
			FOS.strHSCode,
			sum(FSPD.dblQtyPcs) as Qty,
			IC.dblFOB,
			sum(FSPD.dblTotNetNet) as TotNetNet,
			sum(FSPD.dblTotNet) as TotNet,
			sum(FSPD.dblTotGross) as TotGross,
			sum(FSPD.dblNoofCTNS) as package,
			FSPH.intPLNo,
			O.intStyleId
			from finishing_shipmentplheader FSPH
			left Join finishing_shipmentpldetail FSPD ON FSPH.intPLNo=FSPD.intPLNo
			left Join finishing_order_spec FOS ON FOS.intStyleId=FSPH.intStyleId
			left Join invoicecostingheader IC ON IC.intStyleId=FSPH.intStyleId
			left join orders O ON O.intStyleId=FSPH.intStyleId
			where FSPH.intPLNo='$PLNo'
			group by FSPH.intPLNo;";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<PONo><![CDATA[".($row["strOrderNo"])  . "]]></PONo>\n";	
		$ResponseXML .= "<Style><![CDATA[".($row["strStyle"])  . "]]></Style>\n";
		$ResponseXML .= "<HSCode><![CDATA[".($row["strHSCode"])  . "]]></HSCode>\n";
		$ResponseXML .= "<Qty><![CDATA[".($row["Qty"])  . "]]></Qty>\n";	
		$ResponseXML .= "<FOB><![CDATA[".($row["dblFOB"])  . "]]></FOB>\n";
		$ResponseXML .= "<NetNet><![CDATA[".($row["TotNetNet"])  . "]]></NetNet>\n";
		$ResponseXML .= "<Net><![CDATA[".($row["TotNet"])  . "]]></Net>\n";
		$ResponseXML .= "<Gross><![CDATA[".($row["TotGross"])  . "]]></Gross>\n";	
		$ResponseXML .= "<package><![CDATA[".($row["package"])  . "]]></package>\n";
		$ResponseXML .= "<PLNo><![CDATA[".($row["intPLNo"])  . "]]></PLNo>\n";
		$ResponseXML .= "<styleNo><![CDATA[".($row["intStyleId"])  . "]]></styleNo>\n";
	}
	$ResponseXML .= "</XMLLoadDataToMGridByPLPop>";
	echo $ResponseXML;
}
if($Request=="deleteDetailData")
{
	$invoiceNo 	  = $_GET["invoiceNo"];
	
	$sql = "select intInvoiceNo,intPLNo,intStyleId
			from shipping_pre_inv_detail
			where intInvoiceNo = '$invoiceNo'";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$PLNo    = $row["intPLNo"];
		$styleId = $row["intStyleId"];
		updatePLStatus($PLNo,$styleId,0);
	}
	
	$sql_deleteDetail = "delete from shipping_pre_inv_detail where intInvoiceNo = '$invoiceNo'";
	$result_del = $db->RunQuery($sql_deleteDetail);
	if($result_del)
		echo "deleted";
	else
		echo "DeleteError";
}
if($Request=="saveDetailData")
{
	$invoiceNo 	  = $_GET["invoiceNo"];
	$styleId 	  = $_GET["styleId"];
	$weeklyShedNo = $_GET["weeklyShedNo"];
	$HSCode 	  = $_GET["HSCode"];
	$Qty 		  = $_GET["Qty"];
	$price 		  = $_GET["price"];
	$NetNetWeight = $_GET["NetNetWeight"];
	$NetWeight 	  = $_GET["NetWeight"];
	$GrossWeight  = $_GET["GrossWeight"];
	$CBM 		  = $_GET["CBM"];
	$package 	  = $_GET["package"];
	$PLNo 		  = ($_GET["PLNo"]=="n/a"?'null':$_GET["PLNo"]);
	$Amount		  = ($Qty*$price);
	
	$sql_saveDetail = "insert into shipping_pre_inv_detail 
						(intInvoiceNo, 
						intStyleId, 
						intWkScheduleDetailId, 
						strHSCode, 
						dblQty, 
						dblPrice, 
						dblAmount,
						dblNetNetWeight, 
						dblNetWeight, 
						dblGrossWeight, 
						dblCBM, 
						dblPackages, 
						intPLNo
						)
						values
						(
						$invoiceNo,
						$styleId,
						$weeklyShedNo,
						'$HSCode',
						$Qty,
						$price,
						$Amount,
						$NetNetWeight,
						$NetWeight,
						$GrossWeight,
						$CBM,
						$package,
						$PLNo 
						)";
	$result = $db->RunQuery($sql_saveDetail);
	if($result)
	{
		echo "detailSaved";
		updatePLStatus($PLNo,$styleId,1);
	}
	else
		echo "saveError";	
}
if($Request=="loadDetailData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoiceNo = $_GET["invoiceNo"];
	
	$ResponseXML = "<XMLLoadDetailData>\n";
	$sql_loadDetail = "select intInvoiceNo, 
						SPID.intStyleId, 
						intWkScheduleDetailId, 
						strHSCode, 
						dblQty, 
						dblPrice, 
						dblNetNetWeight, 
						dblNetWeight, 
						dblGrossWeight, 
						dblCBM, 
						dblPackages, 
						intPLNo,
						O.strOrderNo,
						O.strStyle,
						intWkScheduleDetailId
						from 
						shipping_pre_inv_detail SPID
						inner join orders O ON O.intStyleId=SPID.intStyleId
						where intInvoiceNo='$invoiceNo'";
						
	$result = $db->RunQuery($sql_loadDetail);
	if(mysql_num_rows($result)>0)
		$ResponseXML .= "<recordExist><![CDATA["."TRUE"."]]></recordExist>\n";
	else
		$ResponseXML .= "<recordExist><![CDATA["."FALSE". "]]></recordExist>\n";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<PONo><![CDATA[".($row["strOrderNo"])  . "]]></PONo>\n";	
		$ResponseXML .= "<Style><![CDATA[".($row["strStyle"])  . "]]></Style>\n";
		$ResponseXML .= "<HSCode><![CDATA[".($row["strHSCode"])  . "]]></HSCode>\n";
		$ResponseXML .= "<Qty><![CDATA[".($row["dblQty"])  . "]]></Qty>\n";	
		$ResponseXML .= "<FOB><![CDATA[".($row["dblPrice"])  . "]]></FOB>\n";
		$ResponseXML .= "<NetNet><![CDATA[".($row["dblNetNetWeight"])  . "]]></NetNet>\n";
		$ResponseXML .= "<Net><![CDATA[".($row["dblNetWeight"])  . "]]></Net>\n";
		$ResponseXML .= "<Gross><![CDATA[".($row["dblGrossWeight"])  . "]]></Gross>\n";	
		$ResponseXML .= "<package><![CDATA[".($row["dblPackages"])  . "]]></package>\n";
		$ResponseXML .= "<PLNo><![CDATA[".($row["intPLNo"])  . "]]></PLNo>\n";
		$ResponseXML .= "<styleNo><![CDATA[".($row["intStyleId"])  . "]]></styleNo>\n";
		$ResponseXML .= "<weeklyShID><![CDATA[".($row["intWkScheduleDetailId"])  . "]]></weeklyShID>\n";
		$ResponseXML .= "<CBM><![CDATA[".($row["dblCBM"])  . "]]></CBM>\n";
	}
	$ResponseXML .= "</XMLLoadDetailData>";
	echo $ResponseXML;
	
}
function updatePLStatus($PLNo,$styleId,$PLStatus)
{
	global $db;
	$sql_update = "update finishing_shipmentplheader 
					set
					intPreShipStatus = '$PLStatus'
					where
					intPLNo = '$PLNo' and 
					intStyleId = '$styleId'";
	$result = $db->RunQuery($sql_update);
	if($result)
		return true;
	else
		return false;
}
?>