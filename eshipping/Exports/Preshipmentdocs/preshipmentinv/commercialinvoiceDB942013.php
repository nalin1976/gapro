<?php 
session_start();
include("../../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];

if ($request=='getData')
{	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$invoiceno=$_GET["invoiceno"];
	$sql="SELECT strInvoiceNo,
	dblExchange ,
	dtmInvoiceDate, 
	bytType, 
	strCompanyID, 
	strBuyerID, 
	strNotifyID1, 
	strNotifyID2, 
	strLCNo, 
	strLCBankID, 
	dtmLCDate, 
	strPortOfLoading, 
	strFinalDest, 
	strCarrier, 
	strVoyegeNo, 
	dtmSailingDate, 
	invoiceheader.strCurrency, 
	dblExchange, 
	intNoOfCartons, 
	intMode, 
	strCartonMeasurement, 
	strCBM, 
	strMarksAndNos, 
	strGenDesc, 
	bytStatus, 
	intFINVStatus, 
	intCusdec,
	strTransportMode,
	strSoldTo,
	intMarchantId,
	intManufacturerId,
	intShellBox,
	strIncoterms,
	strInvFormat,
	strCollect,
	strPreDocNo,
	strVesselName,
	strVslOprCode,
	strSLPANo,
	strPortOfDischarge,
	strBLNo,
	dtmVesselDate,
	strE_No,
	intPackingMthd,
	strCtnOprCode,
	strPay_trms
	FROM invoiceheader 
	WHERE strInvoiceNo='$invoiceno'";
	
	
	//echo $sql;
	//die($sql);
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$XMLString .= "<CompanyID><![CDATA[" . $row["strCompanyID"]  . "]]></CompanyID>\n";
 		$XMLString .= "<BuyerID><![CDATA[" . $row["strBuyerID"]  . "]]></BuyerID>\n";
		$XMLString .= "<NotifyID1><![CDATA[" . $row["strNotifyID1"]  . "]]></NotifyID1>\n";
		$XMLString .= "<NotifyID2><![CDATA[" . $row["strNotifyID2"]  . "]]></NotifyID2>\n";
		$XMLString .= "<LCNo><![CDATA[" . $row["strLCNo"]  . "]]></LCNo>\n";
		$XMLString .= "<LCBankID><![CDATA[" . $row["strLCBankID"]  . "]]></LCBankID>\n";
		$XMLString .= "<lcno><![CDATA[" . $row["strLCNO"]  . "]]></lcno>\n";
		$XMLString .= "<reason><![CDATA[" . $row["strReasonDupIOU"]  . "]]></reason>\n";
		$XMLString .= "<PortOfLoading><![CDATA[" . $row["strPortOfLoading"]  . "]]></PortOfLoading>\n";
		$XMLString .= "<FinalDest><![CDATA[" . $row["strFinalDest"]  . "]]></FinalDest>\n";
		$XMLString .= "<Carrier><![CDATA[" . $row["strCarrier"]  . "]]></Carrier>\n";
		$XMLString .= "<VoyegeNo><![CDATA[" . $row["strVoyegeNo"]  . "]]></VoyegeNo>\n";
		$XMLString .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$XMLString .= "<rates><![CDATA[" . $row["dblExchange"]  . "]]></rates>\n";
		$XMLString .= "<NoOfCartons><![CDATA[" . $row["intNoOfCartons"]  . "]]></NoOfCartons>\n";
		$XMLString .= "<GenDesc><![CDATA[" . $row["strGenDesc"]  . "]]></GenDesc>\n";
		$XMLString .= "<MarksAndNos><![CDATA[" . $row["strMarksAndNos"]  . "]]></MarksAndNos>\n";
		$XMLString .= "<TransportMode><![CDATA[" . $row["strTransportMode"]  . "]]></TransportMode>\n";
		$XMLString .= "<SoldTo><![CDATA[" . $row["strSoldTo"]  . "]]></SoldTo>\n";
		$XMLString .= "<intMarchantId><![CDATA[" . $row["intMarchantId"]  . "]]></intMarchantId>\n";
		
		$XMLString .= "<intManufacturerId><![CDATA[" . $row["intManufacturerId"]  . "]]></intManufacturerId>\n";
		$XMLString .= "<intShellBox><![CDATA[" . $row["intShellBox"]  . "]]></intShellBox>\n";
		$XMLString .= "<txtDeliveryTerm><![CDATA[" . $row["strIncoterms"]  . "]]></txtDeliveryTerm>\n";
		$XMLString .= "<txtFormat><![CDATA[" . $row["strInvFormat"]  . "]]></txtFormat>\n";
		$XMLString .= "<Collect><![CDATA[" . $row["strCollect"]  . "]]></Collect>\n";
		$XMLString .= "<PredocumentNo><![CDATA[" . $row["strPreDocNo"]  . "]]></PredocumentNo>\n";
		
		$XMLString .= "<VesselName><![CDATA[" . $row["strVesselName"]  . "]]></VesselName>\n";
		$XMLString .= "<VslOprCode><![CDATA[" . $row["strVslOprCode"]  . "]]></VslOprCode>\n";
		$XMLString .= "<SLPANo><![CDATA[" . $row["strSLPANo"]  . "]]></SLPANo>\n";
		$XMLString .= "<PortOfDischarge><![CDATA[" . $row["strPortOfDischarge"]  . "]]></PortOfDischarge>\n";
		//$XMLString .= "<VesselDate><![CDATA[" . $row["dtmVesselDate"]  . "]]></VesselDate>\n";
		$XMLString .= "<BLNo><![CDATA[" . $row["strBLNo"]  . "]]></BLNo>\n";
		$XMLString .= "<E_No><![CDATA[" . $row["strE_No"]  . "]]></E_No>\n";
		$XMLString .= "<PackingMthd><![CDATA[" . $row["intPackingMthd"]  . "]]></PackingMthd>\n";
		$XMLString .= "<CtnOprCode><![CDATA[" . $row["strCtnOprCode"]  . "]]></CtnOprCode>\n";
		$XMLString .= "<cboInvoiceType><![CDATA[" . $row["strPay_trms"]  . "]]></cboInvoiceType>\n";
		
		
		
		
		
		$invoicedate =substr($row["dtmInvoiceDate"],0,10);
				$invoicedateArray=explode('-',$invoicedate);
				$formatedInvoiceDate=$invoicedateArray[2]."/".$invoicedateArray[1]."/".$invoicedateArray[0];
		$XMLString .= "<InvoiceDate><![CDATA[" . $formatedInvoiceDate  . "]]></InvoiceDate>\n";
		
		$LCDate =substr($row["dtmLCDate"],0,10);
				$LCDateArray=explode('-',$LCDate);
				$formatedLCDate=$LCDateArray[2]."/".$LCDateArray[1]."/".$LCDateArray[0];
		$XMLString .= "<dtmLCDate><![CDATA[" . $formatedLCDate  . "]]></dtmLCDate>\n";		
	
		$SailingDate =substr($row["dtmSailingDate"],0,10);
				$SailingDateArray=explode('-',$SailingDate);
				$formatedSailingDate=$SailingDateArray[2]."/".$SailingDateArray[1]."/".$SailingDateArray[0];
		$XMLString .= "<SailingDate><![CDATA[" . $formatedSailingDate  . "]]></SailingDate>\n";
		
		$VesselDate =substr($row["dtmVesselDate"],0,10);
				$VesselDateArray=explode('-',$VesselDate);
				$FormatVesselDateArray=$VesselDateArray[2]."/".$VesselDateArray[1]."/".$VesselDateArray[0];
		$XMLString .= "<VesselDate><![CDATA[" . $FormatVesselDateArray  . "]]></VesselDate>\n";
	
	
	
	
	}

$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}


if($request=='updateCancelInvo')
{
	$invoiceno=$_GET["invoicenum"];
	
	//echo $invoiceno;
	$sqlupdatecan="UPDATE invoiceheader SET intCancelInv='1' WHERE strInvoiceNo='$invoiceno'";
	
	$result = $db->RunQuery($sqlupdatecan); 
	if ($result)
	{
		echo "Cancelled";
	}
}




/*
if ($request=='update')
{
$invoiceno=$_GET["invoiceno"];
$description=$_GET["description"];
$sql="
UPDATE invoiceheader 
	SET
	
	strGenDesc = '$description' 
	
	WHERE
	strInvoiceNo = '$invoiceno'	";
	
$result = $db->RunQuery($sql); 
if ($result)
echo "updated";
}

bank	boo29df
carrier	222
consignee	10
currency	1
description	Amila Fonseka Abeykoon
destination	14
exchangerate	1
invoicedate	
invoiceno	001
lc	00
lcdate	0000-00-00 00:00:00
loading	Colombo
nocartoons	11
notify1	10
notify2	10
shipper	1
voyageeno	22
*/


if ($request=='editDB')
{
$predocno=$_GET["predocno"];                
$edit=$_GET["edit"];
$invoiceno=$_GET["invoiceno"];
$InvoiceDate=$_GET["invoicedate"];
$bank=$_GET["bank"];
$carrier=$_GET["carrier"];
$consignee=$_GET["consignee"];
$currency=$_GET["currency"];
$description=$_GET["description"];
//$description=str_replace("'","''",$description);
//die($description);
//$exchangerate=$_GET["exchangerate"];
$lc=$_GET["lc"];
$lcdate=$_GET["lcdate"];
$loading=$_GET["loading"];
$noOfCartons=$_GET["noOfCartons"];
$notify1=$_GET["notify1"];
$notify2=$_GET["notify2"];
$shipper=$_GET["shipper"];
$voyageeno=$_GET["voyageeno"];
$description=$_GET["description"];
$exchangerate=$_GET["exchangerate"];
$sailing=$_GET["sailing"];
$destination=$_GET["destination"];
$MarksofPKGS=$_GET["MarksofPKGS"];
$TransMode=$_GET["TransMode"];
$SoldTo=$_GET["SoldTo"];
$format=$db->setNULL($_GET["format"]);
$SoldTo2=$db->setNULL($_GET["SoldTo2"]);
$marchant = $db->setNULL($_GET["marchant"]);
$manufac  = $db->setNULL($_GET["manufac"]);
$ShellBox = $db->setNULL($_GET["ShellBox"]);
$collect = $db->setNULL($_GET["collect"]);
//------------ 27/03/2013 -----------------
$VesselName=$_GET["VesselName"];
$VSL_OprCode=$_GET["VSL_OprCode"];
$SLPA_No=$_GET["SLPA_No"];
$PortOfDis=$_GET["PortOfDis"];
$VesselDate=$_GET["VesselDate"];
$CTN_OprCode=$_GET["CTN_OprCode"];
$SNBL_No=$_GET["SNBL_No"];
$InvoiceType=$_GET["InvoiceType"];
$E_No=$_GET["E_No"];
$PackingMthd=$_GET["PackingMthd"];

if ($InvoiceDate=="")
	$InvoiceDate=date("d/m/Y");
if ($sailing=="")
	$sailing=date("d/m/Y");
$invoicedateArray 	= explode('/',$InvoiceDate);
		$FormatInvoiceDate = $invoicedateArray[2]."-".$invoicedateArray[1]."-".$invoicedateArray[0];
$sailingdateArray 	= explode('/',$sailing);
		$Formatsailingdate = $sailingdateArray[2]."-".$sailingdateArray[1]."-".$sailingdateArray[0];
if ($lcdate=="")
	$lcdate=date("d/m/Y");
$lcdateArray 	= explode('/',$lcdate);
		$FormatlcdateArray = $lcdateArray[2]."-".$lcdateArray[1]."-".$lcdateArray[0];

if ($VesselDate=="")
	$VesselDate=date("d/m/Y");
$VesselDateArray 	= explode('/',$VesselDate);
		$FormatVesselDateArray = $VesselDateArray[2]."-".$VesselDateArray[1]."-".$VesselDateArray[0];



if ($edit=='update')
{

$sqlupdate=	"UPDATE invoiceheader 
	SET
	intMarchantId = '$marchant' ,
	intManufacturerId = '$manufac' ,
	intShellBox = '$ShellBox' ,
	strInvoiceNo = '$invoiceno' , 
	dtmInvoiceDate = '$FormatInvoiceDate' , 
	bytType = '1' , 
	strCompanyID = '$shipper' , 
	strBuyerID = '$consignee' , 
	strNotifyID1 = '$notify1' , 
	strNotifyID2 = '$notify2' , 
	strLCNo = '$lc' , 
	strLCBankID = '$bank' , 
	dtmLCDate = '$FormatlcdateArray' , 
	strPortOfLoading = '$loading' , 
	strFinalDest = '$destination' , 
	strCarrier = '$carrier' , 
	strVoyegeNo = '$voyageeno' , 
	dtmSailingDate = '$Formatsailingdate' , 
	strCurrency = '$currency' , 
	dblExchange = '$exchangerate' , 
	intNoOfCartons = '$noOfCartons' , 
	intMode = '0' , 
	strCartonMeasurement = '0' , 
	strCBM = '0' , 
	strMarksAndNos = '$MarksofPKGS' , 
	strGenDesc = '$description' , 
	bytStatus = '0' , 
	intFINVStatus = '0' , 
	intCusdec = '0',
	strTransportMode='$TransMode',
	dtmManufactDate=now(), 
	strSoldTo = '$SoldTo' ,
	strIncoterms = '$SoldTo2' ,	
	strInvFormat = $format,
	strCollect	 = '$collect',
	strPreDocNo	 = '$predocno' ,
	
	strVesselName = '$VesselName' ,
	strVslOprCode = '$VSL_OprCode',
	strSLPANo = '$SLPA_No' ,
	strPortOfDischarge = '$PortOfDis',
	strBLNo = '$SNBL_No',
	dtmVesselDate = '$FormatVesselDateArray',
	strPay_trms = '$InvoiceType',
	strE_No = '$E_No',
	intPackingMthd = '$PackingMthd',
	strCtnOprCode = '$CTN_OprCode'
	WHERE
	strInvoiceNo = '$invoiceno' ";
	//die($sqlupdate) ;

$resultupdate=$db->RunQuery($sqlupdate);
//echo $sqlupdate;
if ($resultupdate)
	echo "Successfully updated.";
else
	echo "Sorry,Operation Failed!";

}
if($edit=='insert')
{
	$strPreInvNo			="select dblPreInvNo from syscontrol";
	$resultPreInvNo			=$db->RunQuery($strPreInvNo);
	$rowPreInvNo			=mysql_fetch_array($resultPreInvNo);
	$PreInvNo				="HELA/".$rowPreInvNo["dblPreInvNo"];
	$strUpdatePreInvNo		="update syscontrol set dblPreInvNo=dblPreInvNo+1";
	//echo $strUpdatePreInvNo;
	$resultUpdatePreInvNo	=$db->RunQuery($strUpdatePreInvNo);
	
	$sqlinsert="INSERT INTO invoiceheader 
	(intMarchantId,
	intManufacturerId,
	intShellBox,
	strInvoiceNo, 
	dtmInvoiceDate, 
	bytType, 
	strCompanyID, 
	strBuyerID, 
	strNotifyID1, 
	strNotifyID2, 
	strLCNo, 
	strLCBankID, 
	dtmLCDate, 
	strPortOfLoading, 
	strFinalDest, 
	strCarrier, 
	strVoyegeNo, 
	dtmSailingDate, 
	strCurrency, 
	dblExchange, 
	intNoOfCartons, 
	intMode, 
	strCartonMeasurement, 
	strCBM, 
	strMarksAndNos, 
	strGenDesc, 
	bytStatus, 
	intFINVStatus, 
	intCusdec,
	strTransportMode,
	dtmManufactDate, 
	strSoldTo,
	strIncoterms,
	strInvFormat,
	strCollect,
	strPreDocNo,
	strVesselName ,
	strVslOprCode ,
	strSLPANo  ,
	strPortOfDischarge,
	strBLNo,
	dtmVesselDate ,
	strPay_trms,
	strE_No,
	intPackingMthd ,
	strCtnOprCode)	
	VALUES
	($marchant,
	$manufac,
	'$ShellBox',
	'$PreInvNo', 
	'$FormatInvoiceDate', 
	'1', 
	'$shipper', 
	'$consignee', 
	'$notify1', 
	'$notify2', 
	'$lc', 
	'$bank', 
	'$FormatlcdateArray', 
	'$loading', 
	'$destination', 
	'$carrier', 
	'$voyageeno', 
	'$Formatsailingdate', 
	'$currency', 
	'$exchangerate', 
	'$noOfCartons', 
	'1', 
	'1', 
	'1', 
	'$MarksofPKGS', 
	'$description', 
	'0', 
	'1', 
	'1',
	'$TransMode',
	now(), 
	'$SoldTo',
	'$SoldTo2',
	'$format',
	'$collect',
	'$predocno',
	'$VesselName' ,
	'$VSL_OprCode',
	'$SLPA_No' ,
	 '$PortOfDis',
	'$SNBL_No',
	 '$FormatVesselDateArray',
	'$InvoiceType',
	'$E_No',
	 '$PackingMthd',
	'$CTN_OprCode'
	)";
	
	$resultInsert=$db->RunQuery($sqlinsert);
	if($resultInsert)	
	{
		echo $PreInvNo;
	}
	else 
	{
	echo "Sorry,Operation Failed!" .$sqlinsert;
	}
}

}


if($request=='checkDB')
{

$invoiceno=$_GET["invoiceno"];

$sql="SELECT strInvoiceNo
		FROM invoiceheader 
		WHERE strInvoiceNo='$invoiceno'";
	
	
	$result = $db->RunQuery($sql); 
	if( mysql_fetch_array($result)>0)
			echo "cant";
	else 
	echo "ok";
}


if($request=='deleteData')
{
$invoiceno=$_GET["invoiceno"];
$sqldelete="DELETE FROM invoiceheader WHERE strInvoiceNo = 'strInvoiceNo' ";
$deleteResult=$db->RunQuery($sqldelete);
	if($deleteResult)
		{
		echo "Successfully deleted.";
		}

}

if ($request=='getMarks')
{	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$invoiceno=$_GET["invoiceno"];
	$sql="SELECT strInvoiceNo,
	strMarksAndNos	
	FROM invoiceheader 
	WHERE strInvoiceNo='$invoiceno'";
	//die($sql);
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		
		$XMLString .= "<MarksAndNos><![CDATA[" . $row["strMarksAndNos"]  . "]]></MarksAndNos>\n";
		
	
	}

$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

if ($request=='getgenDesc')
{	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$invoiceno=$_GET["invoiceno"];
	$sql="SELECT strInvoiceNo,
	strGenDesc	
	FROM invoiceheader 
	WHERE strInvoiceNo='$invoiceno'";
	
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		
		$XMLString .= "<GenDesc><![CDATA[" . $row["strGenDesc"]  . "]]></GenDesc>\n";
		
	
	}

$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

if ($request=='copy_inv')
{	
	$previous_invoice=$_GET["previous_invoice"];
	$strPreInvNo			="select dblPreInvNo from syscontrol";
	$resultPreInvNo			=$db->RunQuery($strPreInvNo);
	$rowPreInvNo			=mysql_fetch_array($resultPreInvNo);
	$newinvoice				="HELA/".$rowPreInvNo["dblPreInvNo"];
	$strUpdatePreInvNo		="update syscontrol set dblPreInvNo=dblPreInvNo+1";
	$resultUpdatePreInvNo	=$db->RunQuery($strUpdatePreInvNo);
	$str_header		="select 	intInvoiceId, 
								strInvoiceNo, 
								dtmInvoiceDate, 
								bytType, 
								strCompanyID, 
								strBuyerID, 
								strNotifyID1, 
								strNotifyID2, 
								strLCNo, 
								strLCBankID, 
								dtmLCDate, 
								strPortOfLoading, 
								strFinalDest, 
								strCarrier, 
								strVoyegeNo, 
								dtmSailingDate, 
								strCurrency, 
								dblExchange, 
								intNoOfCartons, 
								intMode, 
								strCartonMeasurement, 
								strCBM, 
								strMarksAndNos, 
								strGenDesc, 
								bytStatus, 
								intFINVStatus, 
								intCusdec, 
								strTransportMode, 
								dtmManufactDate, 
								strIncoterms,
								
								 
								from 
								invoiceheader 
								where strInvoiceNo='$previous_invoice'
								";
	$result_header	=$db->RunQuery($str_header); 
	while($row_header=mysql_fetch_array($result_header))
	{
		$str_copy_header="	insert into invoiceheader 
								( 
								strInvoiceNo, 
								dtmInvoiceDate, 
								bytType, 
								strCompanyID, 
								strBuyerID, 
								strNotifyID1, 
								strNotifyID2, 
								strLCNo, 
								strLCBankID, 
								dtmLCDate, 
								strPortOfLoading, 
								strFinalDest, 
								strCarrier, 
								strVoyegeNo, 
								dtmSailingDate, 
								strCurrency, 
								dblExchange, 
								intNoOfCartons, 
								intMode, 
								strCartonMeasurement, 
								strCBM, 
								strMarksAndNos, 
								strGenDesc, 
								bytStatus, 
								intFINVStatus, 
								intCusdec, 
								strTransportMode, 
								dtmManufactDate, 
								strIncoterms
								)
								values
								( 
								'$newinvoice', 
								'".$row_header["dtmInvoiceDate"]."', 
								'".$row_header["bytType"]."', 
								'".$row_header["strCompanyID"]."',
								'".$row_header["strBuyerID"]."', 
								'".$row_header["strNotifyID1"]."', 
								'".$row_header["strNotifyID2"]."',
								'".$row_header["strLCNo"]."',
								'".$row_header["strLCBankID"]."', 
								'".$row_header["dtmLCDate"]."', 
								'".$row_header["strPortOfLoading"]."',
								'".$row_header["strFinalDest"]."',
								'".$row_header["strCarrier"]."',
								'".$row_header["strVoyegeNo"]."',
								'".$row_header["dtmSailingDate"]."',
								'".$row_header["strCurrency"]."',
								'".$row_header["dblExchange"]."', 
								'".$row_header["intNoOfCartons"]."',
								'".$row_header["intMode"]."', 
								'".$row_header["strCartonMeasurement"]."',
								'".$row_header["strCBM"]."',
								'".$row_header["strMarksAndNos"]."', 
								'".$row_header["'strGenDesc"]."',
								'".$row_header["bytStatus"]."',
								'".$row_header["intFINVStatus"]."',
								'".$row_header["intCusdec"]."', 
								'".$row_header["strTransportMode"]."',
								'".date("Y-m-d")."',
								'".$row_header["strIncoterms"]."'
								);";
		
		$result_copy_header	=$db->RunQuery($str_copy_header); 
		if($result_copy_header)
			echo "saved";
		else
			echo $str_copy_header;
	}
	$str_detail		="select 	strInvoiceNo, 
								strStyleID, 
								intItemNo, 
								strBuyerPONo, 
								strDescOfGoods, 
								dblQuantity, 
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
								strFabrication
								 
								from 
								invoicedetail 
								where strInvoiceNo='$previous_invoice'
								";
	$result_detail	=$db->RunQuery($str_detail); 
	while($row_detail=mysql_fetch_array($result_detail))
	{
		$str_copy_detail="	insert into invoicedetail 
							(strInvoiceNo, 
							strStyleID, 
							intItemNo, 
							strBuyerPONo, 
							strDescOfGoods, 
							dblQuantity, 
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
							strFabrication
							)
							values
							('$newinvoice', 
							'".$row_detail["strStyleID"]."',
							'".$row_detail["intItemNo"]."', 
							'".$row_detail["strBuyerPONo"]."', 
							'".$row_detail["strDescOfGoods"]."',
							'".$row_detail["dblQuantity"]."', 
							'".$row_detail["strUnitID"]."', 
							'".$row_detail["dblUnitPrice"]."', 
							'".$row_detail["strPriceUnitID"]."', 
							'".$row_detail["dblCMP"]."',
							'".$row_detail["dblAmount"]."', 
							'".$row_detail["strHSCode"]."', 
							'".$row_detail["dblGrossMass"]."', 
							'".$row_detail["dblNetMass"]."',
							'".$row_detail["strProcedureCode"]."', 
							'".$row_detail["strCatNo"]."',
							'".$row_detail["intNoOfCTns"]."',
							'".$row_detail["strKind"]."', 
							'".$row_detail["dblUMOnQty1"]."', 
							'".$row_detail["UMOQtyUnit1"]."',
							'".$row_detail["dblUMOnQty2"]."',
							'".$row_detail["UMOQtyUnit2"]."',
							'".$row_detail["dblUMOnQty3"]."',
							'".$row_detail["UMOQtyUnit3"]."', 
							'".$row_detail["strISDno"]."',
							'".$row_detail["strFabrication"]."'
							);";
		
		$result_copy_detail	=$db->RunQuery($str_copy_detail); 
		if($result_copy_detail)
			echo "saved";
		else
			echo $result_copy_detail;
	}
}

if($request=="loadFormat")
{
	
	$format_id=$_GET['format_id'];
	

	$ResponseXML .= "<RequestDetails>\n";
	//$sql="SELECT * FROM commercialinvformat WHERE intCommercialInvId='$format_id' ";
	
	$sql="SELECT
commercialinvformat.intCommercialInvId,
commercialinvformat.strCommercialInv,
commercialinvformat.intBuyer,
commercialinvformat.intDestination,
commercialinvformat.intTrnsMode,
commercialinvformat.strPtLine1,
commercialinvformat.strPtLine2,
commercialinvformat.strPtLine3,
commercialinvformat.intNotify1,
commercialinvformat.intNotify2,
commercialinvformat.intNotify3,
commercialinvformat.intAccountee,
commercialinvformat.intCsc,
commercialinvformat.intDeliveryTo,
commercialinvformat.intIncoTerm,
commercialinvformat.intAuthorisedPerson,
commercialinvformat.strMMLine1,
commercialinvformat.strMMLine2,
commercialinvformat.strMMLine3,
commercialinvformat.strMMLine4,
commercialinvformat.strMMLine5,
commercialinvformat.strMMLine6,
commercialinvformat.strMMLine7,
commercialinvformat.strSMLine1,
commercialinvformat.strSMLine2,
commercialinvformat.strSMLine3,
commercialinvformat.strSMLine4,
commercialinvformat.strSMLine5,
commercialinvformat.strSMLine6,
commercialinvformat.strSMLine7,
commercialinvformat.strBuyerTitle,
commercialinvformat.strBrokerTitle,
commercialinvformat.strAccounteeTitle,
commercialinvformat.strNotify1Title,
commercialinvformat.strNotify2Title,
commercialinvformat.strCSCTitle,
commercialinvformat.strSoldTitle,
commercialinvformat.strBuyerBank,
commercialinvformat.strIncoDesc,
commercialinvformat.strForwader,
invoiceheader.strCurrency,
invoiceheader.dblExchange
FROM
commercialinvformat
LEFT JOIN invoiceheader ON commercialinvformat.intCommercialInvId = invoiceheader.intInvoiceId
WHERE intCommercialInvId='$format_id' ";
	
	
	
	
	$result = $db->RunQuery($sql);
	
	
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Commercial><![CDATA[".($row["strCommercialInv"])  . "]]></Commercial>\n";	
		$ResponseXML .= "<Buyer><![CDATA[".($row["intBuyer"])  . "]]></Buyer>\n";
		$ResponseXML .= "<Destination><![CDATA[".($row["intDestination"])  . "]]></Destination>\n";
		$ResponseXML .= "<Transport><![CDATA[".($row["intTrnsMode"])  . "]]></Transport>\n";
		$ResponseXML .= "<PTline1><![CDATA[".($row["strPtLine1"])  . "]]></PTline1>\n";	
		$ResponseXML .= "<PTline2><![CDATA[".($row["strPtLine2"])  . "]]></PTline2>\n";
		$ResponseXML .= "<PTline3><![CDATA[".($row["strPtLine3"])  . "]]></PTline3>\n";
		$ResponseXML .= "<PTnotify1><![CDATA[".($row["intNotify1"])  . "]]></PTnotify1>\n";	
		$ResponseXML .= "<PTnotify2><![CDATA[".($row["intNotify2"])  . "]]></PTnotify2>\n";
		$ResponseXML .= "<PTnotify3><![CDATA[".($row["intNotify3"])  . "]]></PTnotify3>\n";
		$ResponseXML .= "<Accountee><![CDATA[".($row["intAccountee"])  . "]]></Accountee>\n";
		$ResponseXML .= "<CSC><![CDATA[".($row["intCsc"])  . "]]></CSC>\n";
		$ResponseXML .= "<Deliveryto><![CDATA[".($row["intDeliveryTo"])  . "]]></Deliveryto>\n";
		$ResponseXML .= "<Incoterm><![CDATA[".($row["intIncoTerm"])  . "]]></Incoterm>\n";			
		$ResponseXML .= "<Authorise><![CDATA[".($row["intAuthorisedPerson"])  . "]]></Authorise>\n";
		$ResponseXML .= "<MMline1><![CDATA[".($row["strMMLine1"])  . "]]></MMline1>\n";	
		$ResponseXML .= "<MMline2><![CDATA[".($row["strMMLine2"])  . "]]></MMline2>\n";
		$ResponseXML .= "<MMline3><![CDATA[".($row["strMMLine3"])  . "]]></MMline3>\n";
		$ResponseXML .= "<MMline4><![CDATA[".($row["strMMLine4"])  . "]]></MMline4>\n";	
		$ResponseXML .= "<MMline5><![CDATA[".($row["strMMLine5"])  . "]]></MMline5>\n";
		$ResponseXML .= "<MMline6><![CDATA[".($row["strMMLine6"])  . "]]></MMline6>\n";
		$ResponseXML .= "<MMline7><![CDATA[".($row["strMMLine7"])  . "]]></MMline7>\n";
		$ResponseXML .= "<SMline1><![CDATA[".($row["strSMLine1"])  . "]]></SMline1>\n";
		$ResponseXML .= "<SMline2><![CDATA[".($row["strSMLine2"])  . "]]></SMline2>\n";
		$ResponseXML .= "<SMline3><![CDATA[".($row["strSMLine3"])  . "]]></SMline3>\n";
		$ResponseXML .= "<SMline4><![CDATA[".($row["strSMLine4"])  . "]]></SMline4>\n";
		$ResponseXML .= "<SMline5><![CDATA[".($row["strSMLine5"])  . "]]></SMline5>\n";
		$ResponseXML .= "<SMline6><![CDATA[".($row["strSMLine6"])  . "]]></SMline6>\n";
		$ResponseXML .= "<SMline7><![CDATA[".($row["strSMLine7"])  . "]]></SMline7>\n";
		$ResponseXML .= "<BuyerBank><![CDATA[".($row["strBuyerBank"])  . "]]></BuyerBank>\n";
		$ResponseXML .= "<Forwader><![CDATA[".($row["strForwader"])  . "]]></Forwader>\n";
		$ResponseXML .= "<Currency><![CDATA[".($row["strCurrency"])  . "]]></Currency>\n";
		$ResponseXML .= "<Rates><![CDATA[".($row["dblExchange"])  . "]]></Rates>\n";
		
		
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
if($request=='load_carrier')
{
	$sql="SELECT DISTINCT strCarrier FROM invoiceheader ORDER BY strCarrier;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$carrier_arr.=$row['strCarrier']."|";
				 
	}
	echo $carrier_arr;
	
	
}

if($request=='load_invoice_auto')
{
	$sql="SELECT DISTINCT strInvoiceNo FROM invoiceheader where intCancelInv='0' ORDER BY strInvoiceNo;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$inv_arr.=$row['strInvoiceNo']."|";
				 
	}
	echo $inv_arr;
		
}

if($request=='load_po_auto')
{
	$sql="SELECT DISTINCT strBuyerPONo FROM invoicedetail ORDER BY strBuyerPONo;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$po_arr.=$row['strBuyerPONo']."|";
				 
	}
	echo $po_arr;
		
}

if($request=='loadPreToInv')
{
	$poNo = $_GET['poNo'];
	$sql="SELECT DISTINCT strInvoiceNo FROM invoicedetail WHERE strBuyerPONo = '$poNo';";
	$result=$db->RunQuery($sql);
	
	$row=mysql_fetch_array($result);
	
	if(mysql_num_rows($result)>0)
		echo $row['strInvoiceNo'];
	else
		echo "fail";
		
}

if($request=='loadpreInvDesc')
{
	$sql="SELECT DISTINCT strDescOfGoods FROM invoicedetail";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$dec_arr.=$row['strDescOfGoods']."|";
				 
	}
	echo $dec_arr;
	
}
	
if($request=='loadpreInvFab')
{	
	$sql="SELECT DISTINCT strFabrication FROM invoicedetail order by strFabrication";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$fb_arr.=$row['strFabrication']."|";
				 
	}
	echo $fb_arr;
	
}

if($request=='load_desc')
{
	$field=$_GET['field'];
	$sql="select $field  from invoicedetail group by $field";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$cleaner_arr.=$row[$field]."|";
				 
	}
	echo $cleaner_arr;
	
}

if ($request=='loadFabricDescCat')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<Response>\n";
	$hsCode=$_GET["hsCode"];
	
	$sql="SELECT strFabric,strDescription,strCatNo  FROM excommoditycodes WHERE strCommodityCode='$hsCode'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<Fabric><![CDATA[".($row["strFabric"])  . "]]></Fabric>\n";	
		$ResponseXML .= "<Description><![CDATA[".($row["strDescription"])  . "]]></Description>\n";
		$ResponseXML .= "<CatNo><![CDATA[".($row["strCatNo"])  . "]]></CatNo>\n";
	}
	$ResponseXML.="</Response>";
	echo $ResponseXML;
}

if ($request=='prit_straight')
{	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$invoiceno=$_GET["invoiceno"];
	$sql="select strUrl
			FROM
			commercialinvoicedocuments AS dif
			LEFT JOIN documentformats AS d ON d.intDocumentId = dif.intDocumentId
			INNER JOIN invoiceheader ON invoiceheader.strInvFormat = dif.intFormatId
			WHERE invoiceheader.strInvoiceNo='$invoiceno' AND
(d.intDocumentId > 15 AND d.intDocumentId<20)";
	
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<Url><![CDATA[" . $row["strUrl"]  . "]]></Url>\n";		
	
	}

	$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

if ($request=='loadStyleDescToPreInv')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<Response>\n";
	$styleNo=$_GET["style"];
	//echo "style";
	
	$sql_style="SELECT strStyleID, strDescOfGoods, strFabrication FROM invoicedetail WHERE  strStyleID='$styleNo' LIMIT 1";
	$result_style=$db->RunQuery($sql_style);
		 
	while ($row=mysql_fetch_array($result_style))
	{
		$ResponseXML .= "<Fabrication><![CDATA[".($row["strFabrication"])  . "]]></Fabrication>\n";	
		$ResponseXML .= "<DescOfGoods><![CDATA[".($row["strDescOfGoods"])  . "]]></DescOfGoods>\n";
		
	$ResponseXML.="</Response>";
	echo $ResponseXML;
	}	
	
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
		
	$sqlinsert="INSERT INTO invoicedetail 
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
	echo  $insertresultsql=$db->RunQuery($sqlinsert);
	
}

if($request=='checkPo')
{
$invoiceNo=$_GET["invoiceNo"];	
$buyerPoNo=$_GET["buyerPoNo"];
	 $sql_chackpo="SELECT
				invoicedetail.strBuyerPONo,
				invoicedetail.strInvoiceNo
				FROM
				invoicedetail
				WHERE
				invoicedetail.strBuyerPONo = '$buyerPoNo'";
	$result=$db->RunQuery($sql_chackpo);
	if( mysql_fetch_array($result)>0)
			echo "1";
	else 
			echo "0";
	

}
if($request=="loadgrid")
{

	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML.= "<GridDetails>\n";
	
     $load_id=$_GET['load_id'];   
	
	 $sql="SELECT
			shipmentforecast_detail.intSerialNo,
			shipmentforecast_detail.strSC_No,
			shipmentforecast_detail.strBuyer,
			shipmentforecast_detail.strPoNo,
			shipmentforecast_detail.strStyleNo,
			shipmentforecast_detail.strQty,
			shipmentforecast_detail.intNetWt,
			shipmentforecast_detail.intGrsWt,
			shipmentforecast_detail.intNOF_Ctns,
			shipmentforecast_detail.intUnitPrice,
			shipmentforecast_detail.strDesc,
			shipmentforecast_detail.strFabric,
			shipmentforecast_detail.strCountry,
			shipmentforecast_detail.strFactory,
			shipmentforecast_detail.dtmEX_FTY_Date,
			shipmentforecast_detail.dblCBM,
			shipmentforecast_header.strName
			FROM
			shipmentforecast_detail
			LEFT JOIN shipmentforecast_header ON shipmentforecast_detail.intSerialNo = shipmentforecast_header.intSerialNo
			WHERE `strBuyer` LIKE '%$load_id %'";
			 
	$result=$db->RunQuery($sql);
	
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
			$dateArray 	= explode('-',$row["dtmEX_FTY_Date"]);
			$foramtDateArray= $dateArray[2]."/".$dateArray[1]."/".$dateArray[0];
                        
                        $ResponseXML .= "<SCNo><![CDATA[" . $row["strSC_No"]  . "]]></SCNo>\n";
                        $ResponseXML .= "<PoNo><![CDATA[" . $row["strPoNo"]  . "]]></PoNo>\n";
                        $ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyleNo"]  . "]]></StyleNo>\n";
                        $ResponseXML .= "<Desc><![CDATA[" .$row["strDesc"]  . "]]></Desc>\n";
                        $ResponseXML .= "<Fabric><![CDATA[" .$row["strFabric"]  . "]]></Fabric>\n";
                        $ResponseXML .= "<CBM><![CDATA[" .$row["dblCBM"]  . "]]></CBM>\n";
                        $ResponseXML .= "<Season><![CDATA[" .$row["strSeason"]  . "]]></Season>\n";
                        $ResponseXML .= "<UnitPrice><![CDATA[" .$row["intUnitPrice"]  . "]]></UnitPrice>\n";
                        $ResponseXML .= "<EX_FTY_Date><![CDATA[" .$foramtDateArray  . "]]></EX_FTY_Date>\n";
                        $ResponseXML .= "<Factory><![CDATA[" .$row["strFactory"]  . "]]></Factory>\n";
                        $ResponseXML .= "<CtnMes><![CDATA[" .$row["intNOF_Ctns"]  . "]]></CtnMes>\n";
                        $ResponseXML .= "<Qty><![CDATA[" .$row["strQty"]  . "]]></Qty>\n";
                      	$ResponseXML .= "<Net><![CDATA[" .$row["intNetWt"]  . "]]></Net>\n";
						$ResponseXML .= "<Grs><![CDATA[" . $row["intGrsWt"]  . "]]></Grs>\n";
			
			
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}

if($request=='addSe')
{
	$SeNo=$_GET["SeNo"];
	
	//echo $invoiceno;
	 $sqlupdate="UPDATE shipmentforecast_detail SET intPopUpChk='1' WHERE strSC_No='$SeNo'";
	
	$result = $db->RunQuery($sqlupdate); 

}


?>