<?php 
session_start();
include("../../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];


if ($request=='getData')
{	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$invoiceno=$_GET["invoiceno"];
$table=$_GET["table"];
	$sql="select *
				FROM $table 
				WHERE strInvoiceNo='$invoiceno'";
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	
	//die($sql);
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		
		if($table=='commercial_invoice_header')
			$XMLString .= "<CompanyID><![CDATA[" . $row["strCompanyID"]  . "]]></CompanyID>\n";
		else
			$XMLString .= "<CompanyID><![CDATA[" . $row["intManufacturerId"]  . "]]></CompanyID>\n";
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
		
		$manufactDate =	$row["dtmManufactDate"];
		$manufactDate =($manufactDate==""? date("Y-m-d") : $manufactDate);
		//die($manufactDate);
		$manufactDate =substr($manufactDate,0,10);
				$manufactDateArray=explode('-',$manufactDate);
				$formatmanufactDate=$manufactDateArray[2]."/".$manufactDateArray[1]."/".$manufactDateArray[0];
		$XMLString .= "<ManufactDate><![CDATA[" . $formatmanufactDate  . "]]></ManufactDate>\n";
		$eta =	$row["dtmETA"];
		$eta =($eta==""? date("Y-m-d") : $eta);
				$etaDateArray=explode('-',$eta);
				$formateta=$etaDateArray[2]."/".$etaDateArray[1]."/".$etaDateArray[0];
		$XMLString .= "<eta><![CDATA[" . $formateta  . "]]></eta>\n";
		$XMLString .= "<PreInvoiceNo><![CDATA[" . $row["strPreInvoiceNo"]  . "]]></PreInvoiceNo>\n";
		$XMLString .= "<Incoterms><![CDATA[" . $row["strIncoterms"]  . "]]></Incoterms>\n";		
		$XMLString .= "<AccounteeId><![CDATA[" . $row["strAccounteeId"]  . "]]></AccounteeId>\n";
		$XMLString .= "<CSCId><![CDATA[" . $row["strCSCId"]  . "]]></CSCId>\n";
		$XMLString .= "<DeliverTo><![CDATA[" . $row["strDeliverTo"]  . "]]></DeliverTo>\n";
		
		if($table=='commercial_invoice_header')
			$XMLString .= "<ComInvFormat><![CDATA[" . $row["strComInvFormat"]  . "]]></ComInvFormat>\n";
		else
		    $XMLString .= "<ComInvFormat><![CDATA[" . $row["strInvFormat"]  . "]]></ComInvFormat>\n";
		
		$XMLString .= "<AuthorizedPerson><![CDATA[" . $row["strAuthorizedPerson"]  . "]]></AuthorizedPerson>\n";
		$XMLString .= "<PayTerm><![CDATA[" . $row["strPayTerm"]  . "]]></PayTerm>\n";
		$XMLString .= "<invoiceType><![CDATA[" . $row["strInvoiceType"]  . "]]></invoiceType>\n";
		$XMLString .= "<forwader><![CDATA[" . $row["strForwader"]  . "]]></forwader>\n";
		$XMLString .= "<intBankId><![CDATA[" . $row["intBankId"]  . "]]></intBankId>\n";
		$XMLString .= "<strProInvoiceNo><![CDATA[" . $row["strProInvoiceNo"]  . "]]></strProInvoiceNo>\n";
		$XMLString .= "<BookingNo><![CDATA[" . $row["strBookingNo"]  . "]]></BookingNo>\n";
		$XMLString .= "<NSLInvoiceNo><![CDATA[" . $row["strNslInvoiceNo"]  . "]]></NSLInvoiceNo>\n";
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
$manufactdate=$_GET["manufactdate"];
$preinvno=$_GET["preinvno"];
$incoterm=$_GET["incoterm"];
$inveta=$_GET["inveta"];
$invoiceType=$_GET["invoiceType"];
$forwader=($_GET["forwader"]==""?'null':$_GET["forwader"]);
$buyerBank=($_GET["buyerBank"]==""?'null':$_GET["buyerBank"]);
$proInvNo = $_GET["proInvNo"] ;

$csc=$_GET["csc"];
$accountee=$_GET["accountee"];
$soldto=$_GET["soldto"];

$invFormat=$_GET["invFormat"];
$autorizedPerson=$_GET["autorizedPerson"];
$payterm=$_GET["payterm"];

//...................................................................................
$discount=$_GET["discount"];
$discountType=$_GET["discountType"];
$bookingNo=$_GET["bookingNo"];
$nslInvoiceNo=$_GET["nslInvoiceNo"];



$userid=$_SESSION["UserID"];

if ($InvoiceDate=="")
	$InvoiceDate=date("d/m/Y");
if ($sailing=="")
	$sailing=date("d/m/Y");
if ($inveta=="")
	$inveta=date("d/m/Y");
$invoicedateArray 	= explode('/',$InvoiceDate);
		$FormatInvoiceDate = $invoicedateArray[2]."-".$invoicedateArray[1]."-".$invoicedateArray[0];
$sailingdateArray 	= explode('/',$sailing);
		$Formatsailingdate = $sailingdateArray[2]."-".$sailingdateArray[1]."-".$sailingdateArray[0];
$invetaArray 	= explode('/',$inveta);
		$Formatinveta = $invetaArray[2]."-".$invetaArray[1]."-".$invetaArray[0];
if ($lcdate=="")
	$lcdate=date("d/m/Y");
$lcdateArray 	= explode('/',$lcdate);
		$FormatlcdateArray = $lcdateArray[2]."-".$lcdateArray[1]."-".$lcdateArray[0];
if ($manufactdate=="")
	$manufactdate=date("d/m/Y");
$manufactdatedateArray 	= explode('/',$manufactdate);
		$FormatmanufactdateArray = $manufactdatedateArray[2]."-".$manufactdatedateArray[1]."-".$manufactdatedateArray[0];

if ($edit=='update')
{
	

 $sqlupdate=	"UPDATE commercial_invoice_header 
	SET
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
	intNoOfCartons = '0' , 
	intMode = '0' , 
	strCartonMeasurement = '0' , 
	strCBM = '0' , 
	strMarksAndNos = '$MarksofPKGS' , 
	strGenDesc = '$description' , 
	bytStatus = '0' , 
	intFINVStatus = '0' , 
	intCusdec = '0',
	strTransportMode='$TransMode',
	dtmManufactDate='$FormatmanufactdateArray',
	strPreInvoiceNo='$preinvno',
	dtmETA='$Formatinveta',
	strIncoterms='$incoterm' , 
	strAccounteeId = '$accountee' , 
	strCSCId = '$csc' , 
	strDeliverTo = '$soldto' , 
	strComInvFormat = '$invFormat' , 
	strAuthorizedPerson = '$autorizedPerson' , 
	strPayTerm = '$payterm',
	strInvoiceType = '$invoiceType',
	strForwader = '$forwader',
	intBankId = '$buyerBank',
	strProInvoiceNo = '$proInvNo',
	intUserId = '$userid',
	strBookingNo = '$bookingNo',
	strNslInvoiceNo = '$nslInvoiceNo'
	WHERE
	strInvoiceNo = '$invoiceno' ";
	
$sql_discount="UPDATE finalinvoice 
	SET
	dblDiscount = '$discount',
	strDiscountType = '$discountType'
	WHERE
	strInvoiceNo = '$invoiceno' ";


$resultdiscountupdate=$db->RunQuery($sql_discount);
$resultupdate=$db->RunQuery($sqlupdate);
if ($resultupdate && $resultdiscountupdate)
{
	echo "Successfully updated.";
	//echo $sqlupdate;
}	
	
else
	echo "Sorry,Operation Failed!";

}

if($edit=='insert')
{
	
	$sqlinsert="INSERT INTO commercial_invoice_header 
	(strInvoiceNo, 
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
	strPreInvoiceNo, 
	dtmETA, 
	strIncoterms, 
	strAccounteeId, 
	strCSCId, 
	strDeliverTo, 
	strComInvFormat, 
	strAuthorizedPerson, 
	strPayTerm,
	strInvoiceType,
	strForwader,
	intBankId,
	strProInvoiceNo,
	intUserId,
	strBookingNo,
	strNslInvoiceNo)
	VALUES
	('$invoiceno', 
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
	'0', 
	'1', 
	'1', 
	'1', 
	'$MarksofPKGS', 
	'$description', 
	'0', 
	'1', 
	'1',
	'$TransMode',
	'$FormatmanufactdateArray',
	'$preinvno',
	'$Formatinveta',
	'$incoterm', 
	'$accountee', 
	'$csc', 
	'$soldto', 
	'$invFormat', 
	'$autorizedPerson', 
	'$payterm',
	'$invoiceType',
	'$forwader',
	'$buyerBank',
	'$proInvNo',
	'$userid',
	'$bookingNo',
	'$nslInvoiceNo'
	)";
	
	//$discountinsert="INSERT INTO finalinvoice 
//	(dblDiscount,
//	strDiscountType)
//	VALUES
//	('$discount',
//	'$discountType')";
//	
	//$discountInsert=$db->RunQuery($discountinsert);
	
	
	$resultInsert=$db->RunQuery($sqlinsert);
	//if($resultInsert && $discountInsert)	
	if($resultInsert)	
	{echo "Successfully saved.";}
	else 
	echo "Sorry,Operation Failed!";
	
	
	
}

}

if($request=='checkDB')
{

$invoiceno=$_GET["invoiceno"];

$sql="SELECT strInvoiceNo
		FROM commercial_invoice_header 
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
$sqldelete="DELETE FROM commercial_invoice_header WHERE strInvoiceNo = 'strInvoiceNo' ";
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

if($request=="loadFormat")
{
	
	$format_id=$_GET['format_id'];

	$ResponseXML .= "<RequestDetails>\n";
	
	 $sql="SELECT * FROM commercialinvformat WHERE intCommercialInvId='$format_id' ;";
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
		$ResponseXML .= "<SMline1><![CDATA[".($row["strSMLine1"])  . "]]></SMline1>\n";
		$ResponseXML .= "<SMline2><![CDATA[".($row["strSMLine2"])  . "]]></SMline2>\n";
		$ResponseXML .= "<BuyerBank><![CDATA[".($row["strBuyerBank"])  . "]]></BuyerBank>\n";
		$ResponseXML .= "<Forwader><![CDATA[".($row["strForwader"])  . "]]></Forwader>\n";
			
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}

if($request=='load_invoice_auto')
{
	$sql="select strInvoiceNo from cdn_header  GROUP BY strInvoiceNo";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$inv_arr.=$row['strInvoiceNo']."|";
				 
	}
	echo $inv_arr;
		
}

if ($request=='prit_straight')
{	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$invoiceno=$_GET["invoiceno"];
	
	$sql="select strUrl from commercialinvoicedocuments dif
		left join commercial_invoice_header cif on cif.strComInvFormat=dif.intFormatId
		left join documentformats d on d.intDocumentId=dif.intDocumentId
		where cif.strInvoiceNo='$invoiceno' AND
(d.intDocumentId < 16 OR d.intDocumentId>19) ";
	
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

if ($request=='addSizePrice')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno = $_GET["plno"];
	$pono = $_GET["po"];
	
    $sqlDetail1  =  "SELECT shipmentpldetail.strColor,shipmentpldetail.strPLNo,sum(dblQtyPcs) as qty,
	 				 sum(dblNoofCTNS) as ctns,sum(dblTotGross) as dblGorss, sum(dblTotNet) as dblNet, 
					 sum(dblTotNetNet) as dblNetNet,strStyle,strProductCode,strISDno,strItem,strDO,
					 strLable,strFabric,strUnit,strMaterial,strCTNsvolume,strDc,strCBM,dblNetNet
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
			$XMLString .= "<StyleID><![CDATA[" . $detailrow1["strStyle"]  . "]]></StyleID>\n";
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
			$XMLString .= "<netnet><![CDATA[" . $detailrow1["dblNetNet"]  . "]]></netnet>\n";
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

//if($request=='addHs')
//
//$inv_num	=$_GET["inv_no"];
//$NewHs		=$_GET["NewHs"];
//
//{
//
// $sql="UPDATE commercial_invoice_detail 
//			SET
//		strHs_New = '$NewHs'
//		 WHERE
//	strInvoiceNo = '$inv_num' ";
//			
//
//$result = $db->RunQuery($sql); 
////echo  $sql;

//}


 if($request=="loadpending") 
 {                          
           $str = "select strInvoiceNo from cdn_header WHERE 
					strInvoiceNo not in (select strPreInvoiceNo 
					from commercial_invoice_header) GROUP BY strInvoiceNo DESC";
    $result=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$inv_arr.=$row['strInvoiceNo']."|";
				 
	}
	echo $inv_arr;
 }

?>