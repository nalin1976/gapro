<?php 
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];


if ($request=='getData')
{	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$invoiceno=$_GET["invoiceno"];

	$sql_declaration="SELECT strInvoiceNo,
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
					strSoldTo,
					intMarchantId,
					intManufacturerId,
					intShellBox,
					strIncoterms
					
					FROM shipmentdeclarationheader 
					WHERE strInvoiceNo='$invoiceno'";
	
	$result_declaration = $db->RunQuery($sql_declaration);
	
	if(mysql_num_rows($result_declaration)==0)
	{
	
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
		strIncoterms
		
		FROM invoiceheader 
		WHERE strInvoiceNo='$invoiceno'";
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
		
		}
	
	}
	else
	{
		$XMLString= "<Data>";
		$XMLString .= "<DeliveryData>";
 
		while($row = mysql_fetch_array($result_declaration))
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
		
		}
	}

	$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;

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
$nocartoons=$_GET["nocartoons"];
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

$SoldTo2=$db->setNULL($_GET["SoldTo2"]);
$marchant = $db->setNULL($_GET["marchant"]);
$manufac  = $db->setNULL($_GET["manufac"]);
$ShellBox = $db->setNULL($_GET["ShellBox"]);


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


if ($edit=='update')
{

$sqlupdate=	"UPDATE shipmentdeclarationheader 
	SET
	intMarchantId = $marchant ,
	intManufacturerId = $manufac ,
	intShellBox = $ShellBox ,
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
	intNoOfCartons = '$nocartoons' , 
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
	strIncoterms = '$SoldTo2'	
	WHERE
	strInvoiceNo = '$invoiceno' ";
	//die($sqlupdate) ;

$resultupdate=$db->RunQuery($sqlupdate);

if ($resultupdate)
	echo "Successfully updated.";
else
	echo "Sorry,Operation Failed!";

}
if($edit=='insert')
{
	/*$strPreInvNo			="select dblPreInvNo from syscontrol";
	$resultPreInvNo			=$db->RunQuery($strPreInvNo);
	$rowPreInvNo			=mysql_fetch_array($resultPreInvNo);
	$PreInvNo				="EXP/".$rowPreInvNo["dblPreInvNo"];
	$strUpdatePreInvNo		="update syscontrol set dblPreInvNo=dblPreInvNo+1";
	$resultUpdatePreInvNo	=$db->RunQuery($strUpdatePreInvNo);*/
	
	$sqlinsert="INSERT INTO shipmentdeclarationheader 
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
	strIncoterms
	)
	VALUES
	('$marchant',
	'$manufac',
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
	'$nocartoons', 
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
	'$SoldTo','$SoldTo2'
	)";
	
	$resultInsert=$db->RunQuery($sqlinsert);
	if($resultInsert)	
	{echo $PreInvNo;}
	else 
	echo "Sorry,Operation Failed!" .$sqlinsert;
}

}

if($request=='checkDB')
{

$invoiceno=$_GET["invoiceno"];

$sql="SELECT strInvoiceNo
		FROM shipmentdeclarationheader 
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
$sqldelete="DELETE FROM shipmentdeclarationheader WHERE strInvoiceNo = 'strInvoiceNo' ";
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
	$newinvoice				="PRE/OTL/".$rowPreInvNo["dblPreInvNo"]."/".date("m/y");
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
								strIncoterms
								 
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

if($request=='saveShipmentDecHeader')
{
	$invoiceno=$_GET['invoiceno'];
	$description=$_GET['description'];
	$invoicedate=$_GET['invoicedate'];
	
	$shipper=$_GET['shipper'];
	$consignee=$_GET['consignee'];
	$notify1=$_GET['notify1'];
	$notify2=$_GET['notify2'];
	$lc=$_GET['lc'];
	$lcdate=$_GET['lcdate'];
	
	$bank=$_GET['bank'];
	$loading=$_GET['loading'];
	$carrier=$_GET['carrier'];
	$destination=$_GET['destination'];
	$voyageeno=$_GET['voyageeno'];
	$marchant=$_GET['marchant'];
	
	if($marchant=='')
		$marchant='null';
	
	$manufac=$_GET['manufac'];
	
	if($manufac=='')
		$manufac='null';
		
	$SoldTo2=$_GET['SoldTo2'];
	
	$ShellBox=$_GET['ShellBox'];
	
	if($ShellBox=='')
		$ShellBox='null';
	
	$currency=$_GET['currency'];
	$edit=$_GET['edit'];
	$sailing=$_GET['sailing'];
	$MarksofPKGS=$_GET['MarksofPKGS'];
	$exchangerate=$_GET['exchangerate'];
	$nocartoons=$_GET['nocartoons'];
	$TransMode=$_GET['TransMode'];
	$SoldTo=$_GET['SoldTo'];
	
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
	
	$sql_select="SELECT strInvoiceNo FROM shipmentdeclarationheader WHERE strInvoiceNo='$invoiceno';";
	$result_select=$db->RunQuery($sql_select);
	if(mysql_num_rows($result_select)==0)
	{
		$sqlinsert="INSERT INTO shipmentdeclarationheader 
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
		strIncoterms
		)
		VALUES
		('$marchant',
		'$manufac',
		'$ShellBox',
		'$invoiceno', 
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
		'$nocartoons', 
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
		'$SoldTo2'
		)";
		
		$resultInsert=$db->RunQuery($sqlinsert);
		if($resultInsert)	
			echo "Saved Successfully";
		else 
			echo "Sorry,Operation Failed!";
	}
	else
	{
		$sqlupdate=	"UPDATE shipmentdeclarationheader 
					SET
					intMarchantId = $marchant ,
					intManufacturerId = $manufac ,
					intShellBox = $ShellBox ,
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
					intNoOfCartons = '$nocartoons' , 
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
					strIncoterms = '$SoldTo2'	
					WHERE
					strInvoiceNo = '$invoiceno' ";
		//die($sqlupdate) ;
	
	$resultupdate=$db->RunQuery($sqlupdate);
	
	if ($resultupdate)
		echo "Successfully updated.";
	else
		echo "Sorry,Operation Failed!";
	}
}

?>