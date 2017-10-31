<?php 
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request 		= $_GET["request"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];


if($request=="loadInvoiceData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML.= "<loadInvoiceData>\n";
	
	$invoiceNo = $_GET["invoiceNo"];
	
	$sql_loadInvData = "select IH.strCompanyID,IH.strBuyerID,IH.strCarrier,
						IH.strVoyegeNo,date(IH.dtmSailingDate) as dtmSailingDate,
						IH.strFinalDest,
						sn.strBLNo,
						sn.strCustomEntryNo,
						sn.strCtnOprCode,
						sn.strSLPANo,
						sn.strVslOprCode
						from invoiceheader IH
						LEFT JOIN shippingnote sn ON IH.strInvoiceNo=sn.strInvoiceNo
						where IH.strInvoiceNo = '$invoiceNo'";					
	
	$result = $db->RunQuery($sql_loadInvData);
	while($row = mysql_fetch_array($result))
	{
		$SailingDate     = $row["dtmSailingDate"];
		$SailingDatearry = explode('-',$SailingDate);
		$newDateArry     = $SailingDatearry[2].'/'.$SailingDatearry[1].'/'.$SailingDatearry[0];
		$ResponseXML .= "<CompanyID><![CDATA[" . $row["strCompanyID"]  . "]]></CompanyID>\n";
		$ResponseXML .= "<BuyerID><![CDATA[" . $row["strBuyerID"]  . "]]></BuyerID>\n";
		$ResponseXML .= "<Carrier><![CDATA[" . $row["strCarrier"]  . "]]></Carrier>\n";
		$ResponseXML .= "<VoyegeNo><![CDATA[" . $row["strVoyegeNo"]  . "]]></VoyegeNo>\n";
		$ResponseXML .= "<SailingDate><![CDATA[" . $newDateArry  . "]]></SailingDate>\n";
		$ResponseXML .= "<FinalDest><![CDATA[" . $row["strFinalDest"]  . "]]></FinalDest>\n";
		$ResponseXML .= "<BLNo><![CDATA[" . $row["strBLNo"]  . "]]></BLNo>\n";
		$ResponseXML .= "<CustomEntryNo><![CDATA[" . $row["strCustomEntryNo"]  . "]]></CustomEntryNo>\n";
		$ResponseXML .= "<CtnOprCode><![CDATA[" . $row["strCtnOprCode"]  . "]]></CtnOprCode>\n";
		$ResponseXML .= "<SLPANo><![CDATA[" . $row["strSLPANo"]  . "]]></SLPANo>\n";
		$ResponseXML .= "<VslOprCode><![CDATA[" . $row["strVslOprCode"]  . "]]></VslOprCode>\n";
	}

	$ResponseXML.= "</loadInvoiceData>\n";
	echo $ResponseXML;
}
if ($request=='gen_ctns_combo')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$str="SELECT 	
		intCartoonId, 
		intLength, 
		intWidth, 
		intHeight, 
		strCartoon, 
		dblWeight, 
		strDescription, 
		dtmSaveDate, 
		intUserId		 
		FROM 
		cartoon   ";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row = mysql_fetch_array($result))
	{			
		$xml_string .= "<CartonId><![CDATA[" . $row["intCartoonId"]   . "]]></CartonId>\n";	
		$xml_string .= "<Carton><![CDATA[" . $row["strCartoon"]   . "]]></Carton>\n";	
		$xml_string .= "<Weight><![CDATA[" . $row["dblWeight"]   . "]]></Weight>\n";	
	}
	$xml_string.='</data>';
	echo $xml_string;
}

if($request=="getcdnNo")
{
	$sql = "select intCDNNo from syscontrol where intCompanyID='$companyId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$CDNNo = $row["intCDNNo"];
	
	$sql_u = "update syscontrol set intCDNNo=intCDNNo+1 where intCompanyID='$companyId'";
	$result_u = $db->RunQuery($sql_u);
	
	echo $CDNNo;

}
if($request=="updateDataConfirm")
{
	$confrm 		 = $_GET["conform"];
	$cdn			 = $_GET["cdnNo"];
	
	$sql_select="SELECT intCancel FROM cdn_header WHERE intCDNNo='$cdn'";
	 $result_select = $db->RunQuery($sql_select);
	 $row_select = mysql_fetch_array($result_select);
	 if($row_select['intCancel']==0)
	 {
		$sql_updnw = "update cdn_header set intCDNConform=$confrm where intCDNNo='$cdn'";
		$result_updnw = $db->RunQuery($sql_updnw);
		if($result_updnw)
			echo "Shipment Confirmed";
		else
			echo "Confirming Error";
	 }
	 else
	 	echo "Can't confirm cancelled CDN";
}

if($request=="updateCdnCancel")
{
	 $cancel 		 = $_GET["cancel"];
	 $cdn				 = $_GET["cdnNo"];
	 //echo $cdn;
	 //echo $cancel;
	 $sql_select="SELECT intCDNConform FROM cdn_header WHERE intCDNNo='$cdn'";
	 $result_select = $db->RunQuery($sql_select);
	 $row_select = mysql_fetch_array($result_select);
	 if($row_select['intCDNConform']==0)
	 {
		$sql_upd = "update cdn_header set intCancel=$cancel where intCDNNo='$cdn'";
		$result_upd = $db->RunQuery($sql_upd);
		if($result_upd)
		{
			echo "Shipment Cancelled";
		}
		else
		{
			echo "Cancelling Error";
		}
	 }
	 else
	 	echo "Can't Cancell Shipped CDN";
}


if($request=="saveHeaderData")
{
	 $invoiceNo 		 = $_GET["invoiceNo"];
	 $cdnNo				 = $_GET["cdnNo"];
	 $consignee 		 = ($_GET["consignee"]==""?'null':$_GET["consignee"]);
	 $shipper 			 = ($_GET["shipper"]==""?'null':$_GET["shipper"]);
	 $vessel 		 	 = $_GET["vessel"];
	 $exVessel 		 	 = $_GET["exVessel"];
	 $VoyageNo 			 = $_GET["VoyageNo"];
	 $sailingDate		 = $_GET["sailingDate"];
	 $PortOfDischarge 	 = ($_GET["PortOfDischarge"]==""?'null':$_GET["PortOfDischarge"]);
	 //$LorryNo 			 = $_GET["LorryNo"];
	 $BLNo 				 = $_GET["BLNo"];
	 $TaraWt 			 = ($_GET["TaraWt"]==""?'null':$_GET["TaraWt"]);
	 $CustomesEntry 	 = $_GET["CustomesEntry"];
	 $SealNo 			 = $_GET["SealNo"];
	 $Declarent 		 = ($_GET["Declarent"]==""?'null':$_GET["Declarent"]);
	 $Driver 			 = $_GET["Driver"];
	 $Cleaner 			 = $_GET["Cleaner"];
	 $Signator 			 = ($_GET["Signator"]==""?'null':$_GET["Signator"]);
	 $Temoerature 		 = ($_GET["Temoerature"]==""?'null':$_GET["Temoerature"]);
	 $CNTCode 			 = $_GET["CNTCode"];
	 $VSLCode 			 = $_GET["VSLCode"];
	 $ContainerH 		 = ($_GET["ContainerH"]==""?'null':$_GET["ContainerH"]);
	 $ContainerL 		 = ($_GET["ContainerL"]==""?'null':$_GET["ContainerL"]);
	 $CotainerType 		 = ($_GET["CotainerType"]==""?'null':$_GET["CotainerType"]);
	 
	 $sailingDateArrry	 = explode('/',$sailingDate);
	 $newSailDateArrry   = $sailingDateArrry[2].'-'.$sailingDateArrry[1].'-'.$sailingDateArrry[0];
	 
	 $Date				 = $_GET["date"];
	 $DateArrry	 		 = explode('/',$Date);
	  $newDateArrry   	 = $DateArrry[2].'-'.$DateArrry[1].'-'.$DateArrry[0];
	 
	  $exportDate		 =$_GET["exportDate"];
	 $exportDateArrry	 = explode('/',$exportDate);
	 $newexportDateArrry  = $exportDateArrry[2].'-'.$exportDateArrry[1].'-'.$exportDateArrry[0];
	 $containerNo		 = $_GET['containerNo'];
	 $ctn_measure		 = $_GET['ctn_measure'];
	 $cdnDocNo			 = $_GET['cdnDocNo'];
	 $SLPANo			 = $_GET['SLPANo'];
	 
	 
	 $sql_deleteHeader = "delete from cdn_header where intCDNNo ='$cdnNo'";
	 $db->executeQuery($sql_deleteHeader);
	 
	 $sql_insertHeader = " insert into cdn_header 
							(intCDNNo, 
							strInvoiceNo, 
							intConsignee, 
							intShipper, 
							strVessel, 
							strVoyageNo, 
							dtmSailingDate,
							dtmDate, 
							strPortOfDischarge, 
							strExVesel, 
							strBLNo, 
							strCustomesEntry, 
							dblTareWt, 
							strSealNo, 
							strDriverName, 
							strCleanerName, 
							intDeclarentName, 
							intSignatory, 
							dblHieght, 
							dblLength, 
							intContainerType, 
							dblTemperature, 
							strUserId, 
							dtmSaveDate, 
							strVSLOPRCode, 
							strCNTOPRCode,
							strContainerNo,
							strCTNMeasure,
							intCdnDocNo,
							strSLPANo,
							dtmexportDate
							)
							values
							(
							 $cdnNo, 
							'$invoiceNo', 
							'$consignee', 
							 $shipper, 
							'$vessel', 
							'$VoyageNo', 
							'$newSailDateArrry', 
							'$newDateArrry',
							$PortOfDischarge, 
							'$exVessel',  
							'$BLNo', 
							'$CustomesEntry', 
							$TaraWt, 
							'$SealNo', 
							'$Driver', 
							'$Cleaner', 
							$Declarent, 
							$Signator, 
							 $ContainerH, 
							 $ContainerL, 
							$CotainerType, 
							$Temoerature, 
							'$userId', 
							 now(), 
							'$VSLCode', 
							'$CNTCode',
							'$CotainerType',
							 '$ctn_measure',
							 $cdnDocNo,
							 '$SLPANo',
							 '$newexportDateArrry'
							 
							);";
	$result_header=$db->RunQuery($sql_insertHeader);
	if($result_header)
		echo "HeaderSaved";
	else
		echo "ErrorSave";
}
if($request=="LoadHeaderData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML.= "<loadHeaderData>\n";
	$cdnNo = $_GET["cdnNo"];
	
	$sql_loadHeader = "select *,date(dtmDate) as dtmDate,date(dtmSailingDate) as dtmSailingDate 
					   from cdn_header where intCDNNo='$cdnNo'";
	$result_load=$db->RunQuery($sql_loadHeader);
	while($row = mysql_fetch_array($result_load))
	{
		$SailingDate     = $row["dtmSailingDate"];
		$SailingDatearry = explode('-',$SailingDate);
		$newDateArry     = $SailingDatearry[2].'/'.$SailingDatearry[1].'/'.$SailingDatearry[0];
		$Date		     = $row["dtmDate"];
		$Datearry 		 = explode('-',$Date);
		$newdateArray    = $Datearry[2].'/'.$Datearry[1].'/'.$Datearry[0];
		
		$exportDate		     = $row["dtmexportDate"];
		$exportDateArrry 		 = explode('-',$exportDate);
		$newexportDateArrry    = $exportDateArrry[2].'/'.$exportDateArrry[1].'/'.$exportDateArrry[0];
		
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$ResponseXML .= "<Consignee><![CDATA[" . $row["intConsignee"]  . "]]></Consignee>\n";
		$ResponseXML .= "<Shipper><![CDATA[" . $row["intShipper"]  . "]]></Shipper>\n";
		$ResponseXML .= "<Vessel><![CDATA[" . $row["strVessel"]  . "]]></Vessel>\n";
		$ResponseXML .= "<VoyageNo><![CDATA[" . $row["strVoyageNo"]  . "]]></VoyageNo>\n";
		$ResponseXML .= "<VoyageDate><![CDATA[" . $newDateArry  . "]]></VoyageDate>\n";
		$ResponseXML .= "<PortOfDischarge><![CDATA[" . $row["strPortOfDischarge"]  . "]]></PortOfDischarge>\n";
		$ResponseXML .= "<ExVesel><![CDATA[" . $row["strExVesel"]  . "]]></ExVesel>\n";
		//$ResponseXML .= "<LorryNo><![CDATA[" . $row["strLorryNo"]  . "]]></LorryNo>\n";
		$ResponseXML .= "<BLNo><![CDATA[" . $row["strBLNo"]  . "]]></BLNo>\n";
		$ResponseXML .= "<CustomesEntry><![CDATA[" . $row["strCustomesEntry"]  . "]]></CustomesEntry>\n";
		$ResponseXML .= "<TareWt><![CDATA[" . $row["dblTareWt"]  . "]]></TareWt>\n";
		$ResponseXML .= "<SealNo><![CDATA[" . $row["strSealNo"]  . "]]></SealNo>\n";
		$ResponseXML .= "<DriverName><![CDATA[" . $row["strDriverName"]  . "]]></DriverName>\n";
		$ResponseXML .= "<CleanerName><![CDATA[" . $row["strCleanerName"]  . "]]></CleanerName>\n";
		$ResponseXML .= "<DeclarentName><![CDATA[" . $row["intDeclarentName"]  . "]]></DeclarentName>\n";
		$ResponseXML .= "<Signatory><![CDATA[" . $row["intSignatory"]  . "]]></Signatory>\n";
		$ResponseXML .= "<Hieght><![CDATA[" . $row["dblHieght"]  . "]]></Hieght>\n";
		$ResponseXML .= "<Length><![CDATA[" . $row["dblLength"]  . "]]></Length>\n";
		$ResponseXML .= "<ContainerType><![CDATA[" . $row["intContainerType"]  . "]]></ContainerType>\n";
		$ResponseXML .= "<Temperature><![CDATA[" . $row["dblTemperature"]  . "]]></Temperature>\n";
		$ResponseXML .= "<VSLOPRCode><![CDATA[" . $row["strVSLOPRCode"]  . "]]></VSLOPRCode>\n";
		$ResponseXML .= "<CNTOPRCode><![CDATA[" . $row["strCNTOPRCode"]  . "]]></CNTOPRCode>\n";
		$ResponseXML .= "<Date><![CDATA[" . $newdateArray  . "]]></Date>\n";
		$ResponseXML .= "<exportDate><![CDATA[" . $newexportDateArrry  . "]]></exportDate>\n";
		$ResponseXML .= "<ContainerNo><![CDATA[" . $row["strContainerNo"]  . "]]></ContainerNo>";
		$ResponseXML .= "<CTNMeasure><![CDATA[" . $row["strCTNMeasure"]  . "]]></CTNMeasure>";
		$ResponseXML .= "<CDNDocNo><![CDATA[" . $row["intCdnDocNo"]  . "]]></CDNDocNo>";
		$ResponseXML .= "<SLPANo><![CDATA[" . $row["strSLPANo"]  . "]]></SLPANo>";
		
		if($row['intCancel']==1)
			$ResponseXML .= "<Status>Cancelled</Status>\n";
		else if($row['intCDNConform']==1)
			$ResponseXML .= "<Status>Shipped</Status>\n";
		else
			$ResponseXML .= "<Status>Pending</Status>\n";
		
		
	}
	$ResponseXML.= "</loadHeaderData>\n";
	echo $ResponseXML;
}
if($request=="LoadDetailData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML.= "<loadDetailData>\n";
	$invNo = $_GET["invNo"];
	
	$sql_loadDetail = "select strInvoiceNo,strBuyerPONo,strStyleID,strPLNO,intNoOfCTns,
						dblQuantity,dblUnitPrice,dblNetMass,dblGrossMass
						from invoicedetail
						where strInvoiceNo='$invNo'";
	$result = $db->RunQuery($sql_loadDetail);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONo"]  . "]]></BuyerPONo>\n";
		$ResponseXML .= "<StyleID><![CDATA[" . $row["strStyleID"]  . "]]></StyleID>\n";
		$ResponseXML .= "<PLNO><![CDATA[" . $row["strPLNO"]  . "]]></PLNO>\n";
		$ResponseXML .= "<NoOfCTns><![CDATA[" . $row["intNoOfCTns"]  . "]]></NoOfCTns>\n";
		$ResponseXML .= "<Quantity><![CDATA[" . $row["dblQuantity"]  . "]]></Quantity>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></UnitPrice>\n";
		$ResponseXML .= "<NetMass><![CDATA[" . $row["dblNetMass"]  . "]]></NetMass>\n";
		$ResponseXML .= "<GrossMass><![CDATA[" . $row["dblGrossMass"]  . "]]></GrossMass>\n";
	}
	$ResponseXML.= "</loadDetailData>\n";
	echo $ResponseXML;
}
if($request=="LoadMainDetailData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$cdnNo=$_GET["cdnNo"];
	
	$sqlDetail="SELECT 	strInvoiceNo, 
	strStyleID, 
	intItemNo, 
	strBuyerPONo, 
	strDescOfGoods, 
	dblQuantity,
	strPLNO, 
	strUnitID, 
	dblUnitPrice, 
	strPriceUnitID, 
	dblCMP, 
	dblAmount, 
	strHSCode, 
	dblGrossMass, 
	dblNetMass, 
	strProcedureCode, 
	strCatNo, 
	intNoOfCTns, 
	strKind,
	dblUMOnQty1, 
	UMOQtyUnit1, 
	dblUMOnQty2, 
	UMOQtyUnit2, 
	dblUMOnQty3, 
	UMOQtyUnit3,
	strISDno,
	strFabrication,
	strColor,
	intCBM,
	intCDNNo
	FROM 
	cdn_detail 
	WHERE intCDNNo='$cdnNo' ORDER BY strBuyerPONo";
	
	//die($sqlDetail);

	$detailResult=$db->RunQuery($sqlDetail);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow=mysql_fetch_array($detailResult))
	{		//die("pass");
			$XMLString .= "<InvoiceNo><![CDATA[" . $detailrow["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<StyleID><![CDATA[" . $detailrow["strStyleID"]  . "]]></StyleID>\n";
			$XMLString .= "<ItemNo><![CDATA[" . $detailrow["intItemNo"]  . "]]></ItemNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $detailrow["strBuyerPONo"]  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $detailrow["strDescOfGoods"]  . "]]></DescOfGoods>\n";
			$XMLString .= "<Quantity><![CDATA[" . $detailrow["dblQuantity"]  . "]]></Quantity>\n";
			$XMLString .= "<UnitID><![CDATA[" . $detailrow["strUnitID"]  . "]]></UnitID>\n";
			$XMLString .= "<UnitPrice><![CDATA[" . $detailrow["dblUnitPrice"]  . "]]></UnitPrice>\n";
			$XMLString .= "<lCMP><![CDATA[" . $detailrow["dblCMP"]  . "]]></lCMP>\n";
			$XMLString .= "<Amount><![CDATA[" . $detailrow["dblAmount"]  . "]]></Amount>\n";
			$XMLString .= "<HSCode><![CDATA[" . $detailrow["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $detailrow["dblGrossMass"]  . "]]></GrossMass>\n";
			$XMLString .= "<NetMass ><![CDATA[" . $detailrow["dblNetMass"]  . "]]></NetMass >\n";
			$XMLString .= "<PriceUnitID><![CDATA[" . $detailrow["strPriceUnitID"]  . "]]></PriceUnitID>\n";
			$XMLString .= "<NoOfCTns><![CDATA[" . $detailrow["intNoOfCTns"]  . "]]></NoOfCTns>\n";
			$XMLString .= "<Category><![CDATA[" . $detailrow["strCatNo"]  . "]]></Category>\n";
			$XMLString .= "<ProcedureCode><![CDATA[" . $detailrow["strProcedureCode"]  . "]]></ProcedureCode>\n";
			$XMLString .= "<dblUMOnQty1><![CDATA[" . $detailrow["dblUMOnQty1"]  . "]]></dblUMOnQty1>\n";
			$XMLString .= "<dblUMOnQty2><![CDATA[" . $detailrow["dblUMOnQty2"]  . "]]></dblUMOnQty2>\n";
			$XMLString .= "<dblUMOnQty3><![CDATA[" . $detailrow["dblUMOnQty3"]  . "]]></dblUMOnQty3>\n";
			$XMLString .= "<UMOQtyUnit1><![CDATA[" . $detailrow["UMOQtyUnit1"]  . "]]></UMOQtyUnit1>\n";
			$XMLString .= "<UMOQtyUnit2><![CDATA[" . $detailrow["UMOQtyUnit2"]  . "]]></UMOQtyUnit2>\n";
			$XMLString .= "<UMOQtyUnit3><![CDATA[" . $detailrow["UMOQtyUnit3"]  . "]]></UMOQtyUnit3>\n";
			$XMLString .= "<ISD><![CDATA[" . $detailrow["strISDno"]  . "]]></ISD>\n";
			$XMLString .= "<Fabrication><![CDATA[" . $detailrow["strFabrication"]  . "]]></Fabrication>\n";
			$XMLString .= "<PL><![CDATA[" . $detailrow["strPLNO"]  . "]]></PL>\n";
			$XMLString .= "<Color><![CDATA[" . $detailrow["strColor"]  . "]]></Color>\n";
			$XMLString .= "<CBM><![CDATA[" . $detailrow["intCBM"]  . "]]></CBM>\n";
			$XMLString .= "<CDN><![CDATA[" . $detailrow["intCDNNo"]  . "]]></CDN>\n";
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}
if($request=="deleteDetailData")
{
	$cdnNo = $_GET["cdnNo"];
	
	$sql_deleteDetail = "delete from cdn_detail where intCDNNo ='$cdnNo'";
	$result_del = $db->RunQuery($sql_deleteDetail);
	if($result_del)
		echo "deleted";
	else
		echo "DeleteError";
}
if($request=="saveDetailData")
{
	$cdnNo 		 = $_GET["cdnNo"];
	$invNo		 = $_GET["invNo"];
	$poNo		 = $_GET["poNo"];
	$StyleId 	 = $_GET["StyleId"];
	$PLNo 		 = $_GET["PLNo"];
	$CTNS		 = $_GET["CTNS"];
	$Qty 		 = $_GET["Qty"];
	$Price		 = $_GET["Price"];
	$Net		 = $_GET["Net"];
	$Gross 		 = $_GET["Gross"];
	$CBM		 = $_GET["CBM"];
	
	$sql_saveDetail = "insert into cdn_detail 
						(
						intCDNNo, 
						strInvoiceNo, 
						strBuyerPONo, 
						strStyle, 
						strPLNo, 
						intNoOfCartoons, 
						dblQty, 
						dblPrice, 
						dblNetMass, 
						dblGrossMass, 
						intCBM
						)
						values
						(
						'$cdnNo', 
						'$invNo', 
						'$poNo', 
						'$StyleId', 
						'$PLNo', 
						'$CTNS', 
						'$Qty', 
						'$Price', 
						'$Net', 
						'$Gross', 
						'$CBM'
						)";
	$result = $db->RunQuery($sql_saveDetail);
	if($result)
	{
		echo "detailSaved";
	}
	else
		echo "saveError";	
}


if($request=="saveLorryDetail")
{
	$cdnNo 		 = $db->setNULL($_GET["cdn"]);
	$lorryNo	 = $db->setNULL($_GET["lorryNo"]);
	$cbm		 = $db->setNULL($_GET["cbm"]);
	
	
	 $sql_saveDetail1 = "insert into cdn_lorrydetail 
						(
						strLorryNo, 
						strCDNNo, 
						dblCBM
						)
						values
						(
						'$lorryNo', 
						'$cdnNo', 
						'$cbm'
						)";
	$result = $db->RunQuery($sql_saveDetail1);
	
}

if($request=="saveCTNDetail")
{
	$cdnNo 		 = $db->setNULL($_GET["cdn"]);
	$ctnNo	 = $db->setNULL($_GET["ctnNo"]);
	$qty		 = $db->setNULL($_GET["qty"]);
	
	
	 $sql_saveDetail1 = "insert into cdn_ctndetail 
						(
						strCTN, 
						strCDNNo, 
						dblQty
						)
						values
						(
						'$ctnNo', 
						'$cdnNo', 
						'$qty'
						)";
	$result = $db->RunQuery($sql_saveDetail1);
	
}

if($request=="deleteLorryDetail")
{
	$cdnNo 		 = $db->setNULL($_GET["cdn"]);
	
	
    $sqlDEL = "Delete From cdn_lorrydetail Where strCDNNo='$cdnNo'";
	$db->RunQuery($sqlDEL);
	
}
if($request=="deleteCTNDetail")
{
	$cdnNo 		 = $db->setNULL($_GET["cdn"]);
	
	
    $sqlDEL = "Delete From cdn_ctndetail Where strCDNNo='$cdnNo'";
	$db->RunQuery($sqlDEL);
	
}

if($request=="loadLorryDetail")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML.= "<loadHeaderData>\n";
	$cdnNo = $_GET["cdnNo"];
	
	$sql_loadHeader =  "SELECT
						cdn_lorrydetail.strLorryNo,
						cdn_lorrydetail.dblCBM
						FROM
						cdn_lorrydetail
						WHERE
						cdn_lorrydetail.strCDNNo =  '$cdnNo'
						ORDER BY
						cdn_lorrydetail.strLorryNo ASC";

	$result_load=$db->RunQuery($sql_loadHeader);
	while($row = mysql_fetch_array($result_load))
	{

		$ResponseXML .= "<LorryNo><![CDATA[" . $row["strLorryNo"]  . "]]></LorryNo>\n";
		$ResponseXML .= "<CBM><![CDATA[" . $row["dblCBM"]  . "]]></CBM>\n";
		
	}
	$ResponseXML.= "</loadHeaderData>\n";
	echo $ResponseXML;
}

if($request=="LoadPLDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML.= "<loadHeaderData>\n";
	$pl = $_GET["pl"];
	
	$sql_loadHeader =  "SELECT
						Sum(shipmentpldetail.dblNoofCTNS) AS CTNS,
						Sum(shipmentpldetail.dblQtyPcs) AS QTY,
						Sum(shipmentpldetail.dblNet) AS NET,
						Sum(shipmentpldetail.dblTotGross) AS GROSS,
						shipmentplheader.strCBM
						FROM
						shipmentpldetail
						Inner Join shipmentplheader ON shipmentpldetail.strPLNo = shipmentplheader.strPLNo
						WHERE
						shipmentpldetail.strPLNo =  '$pl'
						GROUP BY
						shipmentpldetail.strPLNo";

	$result_load=$db->RunQuery($sql_loadHeader);
	while($row = mysql_fetch_array($result_load))
	{

		$ResponseXML .= "<CTNS><![CDATA[" . $row["CTNS"]  . "]]></CTNS>\n";
		$ResponseXML .= "<QTY><![CDATA[" . $row["QTY"]  . "]]></QTY>\n";
		$ResponseXML .= "<NET><![CDATA[" . $row["NET"]  . "]]></NET>\n";
		$ResponseXML .= "<GROSS><![CDATA[" . $row["GROSS"]  . "]]></GROSS>\n";
		$ResponseXML .= "<CBM><![CDATA[" . $row["strCBM"]  . "]]></CBM>\n";
		
	}
	$ResponseXML.= "</loadHeaderData>\n";
	echo $ResponseXML;
}

if($request=='loadDriverName')
{
	$sql="SELECT DISTINCT strDriverName FROM cdn_header ORDER BY strDriverName;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$driver_arr.=$row['strDriverName']."|";
				 
	}
	echo $driver_arr;
	
}

if($request=='loadCleanerName')
{
	$sql="SELECT DISTINCT strCleanerName FROM cdn_header ORDER BY strCleanerName;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$cleaner_arr.=$row['strCleanerName']."|";
				 
	}
	echo $cleaner_arr;
	
}

if($request=='loadCDNInv')
{
	$sql="SELECT DISTINCT strInvoiceNo FROM cdn_header order by strInvoiceNo";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$inv_arr.=$row['strInvoiceNo']."|";
				 
	}
	echo $inv_arr;
	
}

if($request=='loadCDNPo')
{
	$sql="SELECT DISTINCT strBuyerPONo FROM cdn_detail ORDER BY cdn_detail.strBuyerPONo";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$po_arr.=$row['strBuyerPONo']."|";
				 
	}
	echo $po_arr;
	
}

if($request=='loadCDNInvDesc')
{
	$sql="SELECT DISTINCT strDescOfGoods FROM cdn_detail WHERE intDescStatus = 1 order by strDescOfGoods";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$inv_arr.=$row['strDescOfGoods']."|";
				 
	}
	echo $inv_arr;
	
}

if($request=='loadCDNInvFab')
{	
	$sql="SELECT DISTINCT strFabrication FROM cdn_detail order by strFabrication";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$inv_arr.=$row['strFabrication']."|";
				 
	}
	echo $inv_arr;
	
}

if($request=='loadCDNToInv')
{
	$invCDN= $_GET['invCDN'];
	$sql="SELECT DISTINCT intCDNNo FROM cdn_header WHERE strInvoiceNo = '$invCDN'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	
	if(mysql_num_rows($result)>0)
		echo $row['intCDNNo'];
	else
		echo "fail";
}

if($request=='loadCDNToInvUsingPo')
{
	$invCDN= $_GET['invCDN'];
	$sql="SELECT DISTINCT intCDNNo FROM cdn_detail WHERE strBuyerPONo='$invCDN'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	
	if(mysql_num_rows($result)>0)
		echo $row['intCDNNo'];
	else
		echo "fail";
}


if($request=='loadpendingCDNToInvUsingPo')
{
	$sql="SELECT strInvoiceNo FROM invoiceheader 
		WHERE intCancelInv=0 AND strInvoiceNo not in (SELECT strInvoiceNo FROM cdn_header WHERE intCancel=0)
		ORDER BY strInvoiceNo DESC";
		
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$inv_arr.=$row['strInvoiceNo']."|";
	}
	
	echo $inv_arr;
}
if($request=='loadPreInvoiceDataToCombo')
{
	$invCDN= $_GET['invCDN'];
	$sql="SELECT DISTINCT strInvoiceNo FROM invoiceheader WHERE strInvoiceNo='$invCDN'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	
	if(mysql_num_rows($result)>0)
		echo $row['strInvoiceNo'];
	else
		echo "fail";
}

if ($request=='getDetailData')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoiceno=$_GET["invoiceno"];
	
	$sqlDetail="SELECT 	strInvoiceNo, 
	strStyleID, 
	intItemNo, 
	strBuyerPONo, 
	strDescOfGoods, 
	dblQuantity,
	strPLNO, 
	strUnitID, 
	dblUnitPrice, 
	strPriceUnitID, 
	dblCMP, 
	dblAmount, 
	strHSCode, 
	dblGrossMass, 
	dblNetMass, 
	strProcedureCode, 
	strCatNo, 
	intNoOfCTns, 
	strKind,
	dblUMOnQty1, 
	UMOQtyUnit1, 
	dblUMOnQty2, 
	UMOQtyUnit2, 
	dblUMOnQty3, 
	UMOQtyUnit3,
	strISDno,
	strFabrication,
	strColor,
	intCBM
	FROM 
	invoicedetail 
	WHERE strInvoiceNo='$invoiceno'ORDER BY intItemNo";
	
	//die($sqlDetail);

	$detailResult=$db->RunQuery($sqlDetail);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow=mysql_fetch_array($detailResult))
	{		//die("pass");
			$XMLString .= "<InvoiceNo><![CDATA[" . $detailrow["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<StyleID><![CDATA[" . $detailrow["strStyleID"]  . "]]></StyleID>\n";
			$XMLString .= "<ItemNo><![CDATA[" . $detailrow["intItemNo"]  . "]]></ItemNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $detailrow["strBuyerPONo"]  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $detailrow["strDescOfGoods"]  . "]]></DescOfGoods>\n";
			$XMLString .= "<Quantity><![CDATA[" . $detailrow["dblQuantity"]  . "]]></Quantity>\n";
			$XMLString .= "<UnitID><![CDATA[" . $detailrow["strUnitID"]  . "]]></UnitID>\n";
			$XMLString .= "<UnitPrice><![CDATA[" . $detailrow["dblUnitPrice"]  . "]]></UnitPrice>\n";
			$XMLString .= "<lCMP><![CDATA[" . $detailrow["dblCMP"]  . "]]></lCMP>\n";
			$XMLString .= "<Amount><![CDATA[" . $detailrow["dblAmount"]  . "]]></Amount>\n";
			$XMLString .= "<HSCode><![CDATA[" . $detailrow["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $detailrow["dblGrossMass"]  . "]]></GrossMass>\n";
			$XMLString .= "<NetMass ><![CDATA[" . $detailrow["dblNetMass"]  . "]]></NetMass >\n";
			$XMLString .= "<PriceUnitID><![CDATA[" . $detailrow["strPriceUnitID"]  . "]]></PriceUnitID>\n";
			$XMLString .= "<NoOfCTns><![CDATA[" . $detailrow["intNoOfCTns"]  . "]]></NoOfCTns>\n";
			$XMLString .= "<Category><![CDATA[" . $detailrow["strCatNo"]  . "]]></Category>\n";
			$XMLString .= "<ProcedureCode><![CDATA[" . $detailrow["strProcedureCode"]  . "]]></ProcedureCode>\n";
			$XMLString .= "<dblUMOnQty1><![CDATA[" . $detailrow["dblUMOnQty1"]  . "]]></dblUMOnQty1>\n";
			$XMLString .= "<dblUMOnQty2><![CDATA[" . $detailrow["dblUMOnQty2"]  . "]]></dblUMOnQty2>\n";
			$XMLString .= "<dblUMOnQty3><![CDATA[" . $detailrow["dblUMOnQty3"]  . "]]></dblUMOnQty3>\n";
			$XMLString .= "<UMOQtyUnit1><![CDATA[" . $detailrow["UMOQtyUnit1"]  . "]]></UMOQtyUnit1>\n";
			$XMLString .= "<UMOQtyUnit2><![CDATA[" . $detailrow["UMOQtyUnit2"]  . "]]></UMOQtyUnit2>\n";
			$XMLString .= "<UMOQtyUnit3><![CDATA[" . $detailrow["UMOQtyUnit3"]  . "]]></UMOQtyUnit3>\n";
			$XMLString .= "<ISD><![CDATA[" . $detailrow["strISDno"]  . "]]></ISD>\n";
			$XMLString .= "<Fabrication><![CDATA[" . $detailrow["strFabrication"]  . "]]></Fabrication>\n";
			$XMLString .= "<PL><![CDATA[" . $detailrow["strPLNO"]  . "]]></PL>\n";
			$XMLString .= "<Color><![CDATA[" . $detailrow["strColor"]  . "]]></Color>\n";
			$XMLString .= "<CBM><![CDATA[" . $detailrow["intCBM"]  . "]]></CBM>\n";
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='LoadInvDetailGrid')
{	
	$invoiceno = $_GET["inv"];
	
	$invDetail = "Select * from invoicedetail where strInvoiceNo='$invoiceno'";
	
	$invResult = $db->RunQuery($invDetail);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($invrow=mysql_fetch_array($invResult))
	{
			$XMLString .= "<InvoiceNo><![CDATA[" . $invrow["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<StyleID><![CDATA[" . $invrow["strStyleID"]  . "]]></StyleID>\n";
			$XMLString .= "<ItemNo><![CDATA[" . $invrow["intItemNo"]  . "]]></ItemNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $invrow["strBuyerPONo"]  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $invrow["strDescOfGoods"]  . "]]></DescOfGoods>\n";
			$XMLString .= "<Quantity><![CDATA[" . $invrow["dblQuantity"]  . "]]></Quantity>\n";
			$XMLString .= "<UnitID><![CDATA[" . $invrow["strUnitID"]  . "]]></UnitID>\n";
			$XMLString .= "<UnitPrice><![CDATA[" . $invrow["dblUnitPrice"]  . "]]></UnitPrice>\n";
			$XMLString .= "<lCMP><![CDATA[" . $invrow["dblCMP"]  . "]]></lCMP>\n";
			$XMLString .= "<Amount><![CDATA[" . $invrow["dblAmount"]  . "]]></Amount>\n";
			$XMLString .= "<HSCode><![CDATA[" . $invrow["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $invrow["dblGrossMass"]  . "]]></GrossMass>\n";
			$XMLString .= "<NetMass ><![CDATA[" . $invrow["dblNetMass"]  . "]]></NetMass >\n";
			$XMLString .= "<PriceUnitID><![CDATA[" . $invrow["strPriceUnitID"]  . "]]></PriceUnitID>\n";
			$XMLString .= "<NoOfCTns><![CDATA[" . $invrow["intNoOfCTns"]  . "]]></NoOfCTns>\n";
			$XMLString .= "<Category><![CDATA[" . $invrow["strCatNo"]  . "]]></Category>\n";
			$XMLString .= "<ProcedureCode><![CDATA[" . $invrow["strProcedureCode"]  . "]]></ProcedureCode>\n";
			$XMLString .= "<dblUMOnQty1><![CDATA[" . $invrow["dblUMOnQty1"]  . "]]></dblUMOnQty1>\n";
			$XMLString .= "<dblUMOnQty2><![CDATA[" . $invrow["dblUMOnQty2"]  . "]]></dblUMOnQty2>\n";
			$XMLString .= "<dblUMOnQty3><![CDATA[" . $invrow["dblUMOnQty3"]  . "]]></dblUMOnQty3>\n";
			$XMLString .= "<UMOQtyUnit1><![CDATA[" . $invrow["UMOQtyUnit1"]  . "]]></UMOQtyUnit1>\n";
			$XMLString .= "<UMOQtyUnit2><![CDATA[" . $invrow["UMOQtyUnit2"]  . "]]></UMOQtyUnit2>\n";
			$XMLString .= "<UMOQtyUnit3><![CDATA[" . $invrow["UMOQtyUnit3"]  . "]]></UMOQtyUnit3>\n";
			$XMLString .= "<ISD><![CDATA[" . $invrow["strISDno"]  . "]]></ISD>\n";
			$XMLString .= "<Fabrication><![CDATA[" . $invrow["strFabrication"]  . "]]></Fabrication>\n";
			$XMLString .= "<PL><![CDATA[" . $invrow["strPLNO"]  . "]]></PL>\n";
			$XMLString .= "<Color><![CDATA[" . $invrow["strColor"]  . "]]></Color>\n";
			$XMLString .= "<CBM><![CDATA[" . $invrow["intCBM"]  . "]]></CBM>\n";	
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}


if ($request=='LoadInvCombo')
{	
	
	
	$invDetail = "select invoiceheader.strInvoiceNo
				  from invoiceheader left join cdn_header
				  on invoiceheader.strInvoiceNo=cdn_header.strInvoiceNo
				  where invoiceheader.dtmInvoiceDate > '2013-01-01 00:00:00' AND cdn_header.strInvoiceNo is null
 				  order by invoiceheader.strInvoiceNo desc";
	
	$invResult = $db->RunQuery($invDetail);
	$html = "<option value=''></option>";
	
	while($invrow=mysql_fetch_array($invResult))
	{
		$html.="<option value=".$invrow['strInvoiceNo'].">".$invrow['strInvoiceNo']."</option>";
	}
	echo $html;
}

if ($request=='addSizePrice')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno = $_GET["plno"];
	$pono = $_GET["po"];
	
    $sqlDetail1  =  "SELECT shipmentpldetail.strColor,shipmentpldetail.strPLNo,sum(dblQtyPcs) as qty,
	 				 sum(dblNoofCTNS) as ctns,sum(dblTotGross) as dblGorss, sum(dblTotNet) as dblNet, 
					 sum(dblTotNetNet) as dblNetNet,strStyle,strProductCode,strISDno,strItem,strDO,
					 strLable,strFabric,strUnit,strMaterial,strCTNsvolume,strDc,strCBM, shipmentplheader.strProductCode
					 from shipmentpldetail 
					 left join shipmentplheader on shipmentplheader.strPLNo=shipmentpldetail.strPLNo
					 where shipmentpldetail.strPLNo='$plno' and shipmentpldetail.strColor!='' group by  shipmentpldetail.strColor";
					 
	 $detailResult1 = $db->RunQuery($sqlDetail1);
		
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow1=mysql_fetch_array($detailResult1))
	{		
		$TOTCBM = calCBM($detailrow1['strColor'],$plno);
		
		$sqlDetail2  = "SELECT orderspecdetails.strColor,orderspecdetails.dblPrice,orderspec.strUnit,
							 orderspecdetails.strDescription,orderspecdetails.dblPcs
							 FROM orderspecdetails
							 Inner Join orderspec ON orderspecdetails.intOrderId = orderspec.intOrderId
							 WHERE
							 orderspecdetails.strColor =  '".$detailrow1['strColor']."' AND
							 orderspec.strOrder_No =  '$pono' group by orderspecdetails.strColor";
						
		$detailResult2 = $db->RunQuery($sqlDetail2);
		
		while($detailrow2=mysql_fetch_array($detailResult2))
		{
			
			//$XMLString .= "<InvoiceNo><![CDATA[" . $detailrow["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<StyleID><![CDATA[" . $detailrow1["strProductCode"]  . "]]></StyleID>\n";
			$XMLString .= "<ItemNo><![CDATA[" . $detailrow1["strItem"]  . "]]></ItemNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $pono  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $detailrow2["strDescription"]  . "]]></DescOfGoods>\n";
			$XMLString .= "<Quantity><![CDATA[" . $detailrow1["qty"]  . "]]></Quantity>\n";
			$XMLString .= "<UnitID><![CDATA[" . $detailrow2["strUnit"]  . "]]></UnitID>\n";
			$XMLString .= "<UnitPrice><![CDATA[" . $detailrow2["dblPrice"]  . "]]></UnitPrice>\n";
			$XMLString .= "<lCMP><![CDATA[" . $detailrow1["dblCMP"]  . "]]></lCMP>\n";
			$XMLString .= "<Amount><![CDATA[" . $detailrow1["dblAmount"]  . "]]></Amount>\n";
			$XMLString .= "<HSCode><![CDATA[" . $detailrow1["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $detailrow1["dblGorss"]  . "]]></GrossMass>\n";
			$XMLString .= "<NetMass ><![CDATA[" . $detailrow1["dblNet"]  . "]]></NetMass >\n";
			$XMLString .= "<PriceUnitID><![CDATA[" . $detailrow1["strUnit"]  . "]]></PriceUnitID>\n";
			$XMLString .= "<NoOfCTns><![CDATA[" . $detailrow1["ctns"]  . "]]></NoOfCTns>\n";
			$XMLString .= "<Category><![CDATA[" . $detailrow1["strCatNo"]  . "]]></Category>\n";
			$XMLString .= "<ProcedureCode><![CDATA[" . $detailrow1["strProcedureCode"]  . "]]></ProcedureCode>\n";
			$XMLString .= "<dblUMOnQty1>0</dblUMOnQty1>\n";
			$XMLString .= "<dblUMOnQty2>0</dblUMOnQty2>\n";
			$XMLString .= "<dblUMOnQty3>0</dblUMOnQty3>\n";
			$XMLString .= "<UMOQtyUnit1>0</UMOQtyUnit1>\n";
			$XMLString .= "<UMOQtyUnit2>0</UMOQtyUnit2>\n";
			$XMLString .= "<UMOQtyUnit3>0</UMOQtyUnit3>\n";
			$XMLString .= "<ISD><![CDATA[" . $detailrow1["strISDno"]  . "]]></ISD>\n";
			$XMLString .= "<Fabrication><![CDATA[" . $detailrow1["strFabric"]  . "]]></Fabrication>\n";
			$XMLString .= "<PL><![CDATA[" . $plno  . "]]></PL>\n";
			$XMLString .= "<Color><![CDATA[" . $detailrow1["strColor"]  . "]]></Color>\n";
			$XMLString .= "<CBM><![CDATA[" . round($TOTCBM,2)  . "]]></CBM>\n";
		}
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

function calCBM($color,$pl)
{
	global $db;
	$CTNCBMTOT = 0;
	//echo $color; echo $pl;
	$sqlDetailCBM  =   "SELECT
						Sum(shipmentpldetail.dblNoofCTNS) AS sumCTN,
						shipmentpldetail.strCTN
						FROM
						shipmentpldetail
						WHERE
						shipmentpldetail.strPLNo =  '$pl' AND
						shipmentpldetail.strColor =  '$color'
						GROUP BY
						shipmentpldetail.strCTN";
						
	$detailResultCBM = $db->RunQuery($sqlDetailCBM);
		
	while($detailrowCBM=mysql_fetch_array($detailResultCBM))
	{
		$sqlDetailCBMCTN   =   "SELECT
								cartoon.intLength,
								cartoon.intWidth,
								cartoon.intHeight
								FROM
								cartoon
								WHERE
								cartoon.intCartoonId =  ".$detailrowCBM["strCTN"];
								
		$detailResultCBMCTN = $db->RunQuery($sqlDetailCBMCTN);
		$detailrowCBMRow    = mysql_fetch_array($detailResultCBMCTN);
		
		$Length = (float) $detailrowCBMRow["intLength"];
		$Width  = (float) $detailrowCBMRow["intWidth"];
		$Height = (float) $detailrowCBMRow["intHeight"];
		
	    $sumCTN = (float) $detailrowCBM["sumCTN"];
		$CTNCBMTOT += ($Length*$Width*$Height*$sumCTN*0.0000164);
		
		
	}
	//echo $CTNCBMTOT;
	return $CTNCBMTOT;
}


if ($request=='delData')
{	
	$cdn = $_GET["cdn"];
	$sql_plno="SELECT strPLNO FROM cdn_detail WHERE intCDNNo='$cdn'";
	$result_plno=$db->RunQuery($sql_plno);
	while($row=mysql_fetch_array($result_plno))
	{
		$plno=$row['strPLNO'];
		$sql_status= "UPDATE shipmentplheader SET intCDNStatus=0 WHERE strPLNo='$plno' ";
		$result_pl_sts=$db->RunQuery($sql_status);
	}
	
	
	
	$sqlDelete="DELETE FROM cdn_detail WHERE intCDNNo = '$cdn'";
	$resultDelete=$db->RunQuery($sqlDelete);
}

if ($request=='saveData')
{
	$invoiceno = $_GET["invoiceno"];
	$cdn       = $_GET["cdn"];
	
	$bpo=$_GET["bpo"];
	$cbm=$_GET["cbm"];
	$ctns=$_GET["ctns"];
	$dsc=$_GET["dsc"];
	$gross=$_GET["gross"];	
	$hs=$_GET["hs"];	
	$net=$_GET["net"];	
	$style=$_GET["style"];	
	$unit=$_GET["unit"];	
	$unitprice=$_GET["unitprice"];	
	$unitqty=$_GET["unitqty"];	
	$value=$_GET["value"];
	$qty=$_GET["qty"];
	$Color=$_GET["Color"];
	$category=$_GET["category"];
	$procedurecode=$_GET["procedurecode"];
	$umoqty1=$_GET["umoqty1"];
	$umoqty2=$_GET["umoqty2"];
	$umoqty3=$_GET["umoqty3"];
	$umoUnit1=$_GET["umoUnit1"];
	$umoUnit2=$_GET["umoUnit2"];
	$umoUnit3=$_GET["umoUnit3"];
	$ISDNo=$_GET["ISDNo"];
	if($ISDNo=="")
	$ISDNo="n/a";
	$fabrication=$_GET["fabrication"];
	$PL=$_GET["PL"];
	if ($gross=="")
		$gross=0;
	if ($net=="")
		$net=0;
	if ($ctns=="")
		$ctns=0;
	if ($umoqty1=="")
		$umoqty1=0;
	if ($umoqty2=="")
		$umoqty2=0;
	if ($umoqty3=="")
		$umoqty3=0;
		if ($cbm=="")
		$cbm=0;
		
	$sqlinsert="INSERT INTO cdn_detail 
	(intCDNNo,
	strInvoiceNo, 
	strStyleID, 
	intCBM,
	strPLNO,
	strBuyerPONo, 
	strDescOfGoods, 
	dblQuantity, 
	strUnitID, 
	dblUnitPrice, 
	strPriceUnitID, 
	dblAmount, 
	strHSCode, 
	dblGrossMass, 
	dblNetMass, 
	strProcedureCode, 
	strCatNo, 
	intNoOfCTns, 
	strKind,
	dblUMOnQty1, 
	UMOQtyUnit1, 
	dblUMOnQty2, 
	UMOQtyUnit2, 
	dblUMOnQty3, 
	strISDno,
	strFabrication,
	strColor
	)
	VALUES
	('$cdn',
	'$invoiceno', 
	'$style',
	'$cbm',
	'$PL', 
	'$bpo', 
	'$dsc', 
	'$qty', 
	'$unitqty', 
	'$unitprice', 
	'$unit', 
	'$value', 
	'$hs', 
	'$gross', 
	'$net', 
	'$procedurecode', 
	'$category', 
	'$ctns', 
	'1',
	'$umoqty1',
	'$umoUnit1',
	'$umoqty2',
	'$umoUnit2',
	'$umoqty3',
	'$ISDNo',
	'$fabrication',
	'$Color'
	);";
	 $insertresultsql=$db->RunQuery($sqlinsert);
	if($insertresultsql)
	{
		 $sql_CDNStat="UPDATE shipmentplheader SET intCDNStatus=1 WHERE strPLNo='$PL'";
		$result_cdn = $db->RunQuery($sql_CDNStat);
		if($result_cdn)
		{
		 	echo "saved";
		}
	}
}

if($request=='loadInvoiceCombo')
{
	$cdnNo=$_GET['cdnNo'];
	$res="<option value=''></option>";
	if($cdnNo=='')
	{
		
		$sql="SELECT strInvoiceNo FROM invoiceheader
				WHERE strInvoiceNo not in (SELECT strInvoiceNo FROM cdn_header)
				ORDER BY strInvoiceNo DESC ";
	}
	else
	{
		$sql="SELECT strInvoiceNo FROM cdn_header WHERE intCDNNo=$cdnNo";
	}
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$res.="<option value=".$row['strInvoiceNo'].">".$row['strInvoiceNo']."</option>";
	}
	echo $res;
}

if($request=='checkMultipleInv')
{
	$cdnNo=$_GET['cdnNo'];
	$sql="SELECT DISTINCT strInvoiceNo FROM cdn_detail
WHERE intCDNNo=$cdnNo";
	$result=$db->RunQuery($sql);
	
	if(mysql_num_rows($result)>1)
		echo 2;
	else
		echo 1;
}

if($request=='loadctndetail')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$XMLString = "<loadHeaderData>\n";
	$cdnNo = $_GET["cdnNo"];
	$sql_ctn =  "SELECT strCTN,dblQty
					FROM cdn_ctndetail
					WHERE strCDNNo='$cdnNo'";
	$result_ctn=$db->RunQuery($sql_ctn);
	while($row=mysql_fetch_array($result_ctn))
	{
		$XMLString .= "<CTNMeasurement><![CDATA[" . $row["strCTN"]  . "]]></CTNMeasurement>\n";
		$XMLString .= "<Quantity><![CDATA[" . $row["dblQty"]  . "]]></Quantity>\n";
	}
	$XMLString .= "</loadHeaderData>";
	echo $XMLString;
	
}



if ($request=='loaData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$XMLString = "<loadHeaderData>\n";
	$invoiceno = $_GET["invoiceno"];
	$Color=$_GET["Color"];
	$sql_Hsdsfab="SELECT strDescOfGoods, strFabrication, strHSCode FROM invoicedetail WHERE strInvoiceNo='$invoiceno' AND 			 		    				strColor='$Color'";
	$result_lodata=$db->RunQuery($sql_Hsdsfab);
	while($rowdata=mysql_fetch_array($result_lodata))
	{
			$XMLString .= "<Fabrication><![CDATA[" . $rowdata["strFabrication"]  . "]]></Fabrication>\n";
			$XMLString .= "<HSCode><![CDATA[" . $rowdata["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $rowdata["strDescOfGoods"]  . "]]></DescOfGoods>\n";
	}
	$XMLString .= "</loadHeaderData>";
	echo $XMLString;
}
?>