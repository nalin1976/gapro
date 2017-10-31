<?php	
	session_start();
	header('Content-Type: text/xml'); 
	include "../../Connector.php";
	$RequestType	= $_GET["RequestType"];
	$CompanyId  	= $_SESSION["FactoryID"];
	$userId			= $_SESSION["UserID"];

if($RequestType=="load_shippingLine")
{
	$sql="SELECT DISTINCT strShippingLineName FROM shippingnote";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$shippingLine_arr.=$row['strShippingLineName']."|";
				 
	}
	echo $shippingLine_arr;
}
if($RequestType=="load_carrier")
{
	$sql="SELECT DISTINCT strCarrierName FROM carrier ORDER BY strCarrierName";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$carrier_arr.=$row['strCarrierName']."|";
				 
	}
	echo $carrier_arr;
}		
if($RequestType=="LoadDetails")
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$invoiceNo	= $_GET["invoiceNo"];
$ResponseXML ="";
$ResponseXML .="<LoadDetails>\n";
$sql="select
	sn.strEntryNo,
	sn.dblCBM,
	sn.strEntryReceive,
	sn.strContainerType,
	sn.strAscycuda,
	sn.strShippingNoteNo, 
	ih.strCarrier as strCarrier, 
	ih.strVoyegeNo as strVoyegeNo, 
	DATE(ih.dtmSailingDate) as voyageDate, 
	sn.strPortOfDischarge as strFinalDest, 
	sn.strWarehouseNo,  
	sn.strCustomEntryNo, 
	sn.strShippingLineName,  
	DATE(sn.dtmShNoteDate) as dtmShNoteDate , 
	sn.strExporterRegNo, 
	sn.strSLPANo, 
	sn.strBLNo, 
	sn.strVslOprCode, 
	sn.strCtnOprCode, 
	sn.strNameOfDeclarent, 
	sn.strUserId,
	(SELECT strName FROM customers CU WHERE CU.strCustomerID=ih.strCompanyID)AS customerName,
	(SELECT strName FROM buyers B WHERE B.strBuyerID=ih.strNotifyID1)AS notifyParty1,
	(SELECT strName FROM buyers B WHERE B.strBuyerID=ih.strBuyerID)AS buyerName
	
	from 
	shippingnote sn
	left join invoiceheader ih on sn.strInvoiceNo=ih.strInvoiceNo
	where sn.strInvoiceNo='$invoiceNo'";
$result=$db->RunQuery($sql);
	
if (mysql_num_rows($result)<1)
{
$sql="SELECT strCompanyID,
(SELECT strName FROM customers CU WHERE CU.strCustomerID=IH.strCompanyID)AS customerName,
strNotifyID1,
(SELECT strName FROM buyers B WHERE B.strBuyerID=IH.strNotifyID1)AS notifyParty1,
strBuyerID,
(SELECT strName FROM buyers B WHERE B.strBuyerID=IH.strBuyerID)AS buyerName,
DATE(dtmSailingDate)AS voyageDate,
strVoyegeNo,
strCarrier,
strFinalDest,
ech.strBL as strBLNo,
(SELECT strCity FROM city C WHERE C.strCityCode=IH.strFinalDest)AS cityName,
(select SUM(dblGrossMass) from invoicedetail ID where IH.strInvoiceNo=ID.strInvoiceNo)AS grossMass,
(select SUM(dblNetMass) from invoicedetail ID where IH.strInvoiceNo=ID.strInvoiceNo)AS netMass,
(select SUM(intCBM) from invoicedetail ID where IH.strInvoiceNo=ID.strInvoiceNo) AS dblCBM,
strMarksAndNos,
strGenDesc
FROM invoiceheader IH left join exportcusdechead ech on IH.strInvoiceNo=ech.strInvoiceNo
WHERE IH.strInvoiceNo='$invoiceNo'";
$result=$db->RunQuery($sql);
}
while($row=mysql_fetch_array($result))
{	

	
	$ResponseXML .="<CompanyID><![CDATA[".$row["strCompanyID"]."]]></CompanyID>\n";
	$ResponseXML .="<CustomerName><![CDATA[".$row["customerName"]."]]></CustomerName>\n";
	$ResponseXML .="<NotifyIDParty><![CDATA[".$row["strNotifyID1"]."]]></NotifyIDParty>\n";
	$ResponseXML .="<NotifyIDPartyName><![CDATA[".$row["notifyParty1"]."]]></NotifyIDPartyName>\n";
	$ResponseXML .="<BuyerID><![CDATA[".$row["strBuyerID"]."]]></BuyerID>\n";
	$ResponseXML .="<BuyerName><![CDATA[".$row["buyerName"]."]]></BuyerName>\n";
		$voyageDate	= $row["voyageDate"];
			$voyageArray	= explode('-',$voyageDate);
				$formatedVoyageDate = $voyageArray[2].'/'.$voyageArray[1].'/'.$voyageArray[0];
		if($row["dtmShNoteDate"]=='')
					$formatedShippingNoteDate=date("d/m/Y");	
		else
		{
		$ShippingNoteDate	= $row["dtmShNoteDate"];
			$ShdateArray1	= explode('-',$ShippingNoteDate);
				$formatedShippingNoteDate = $ShdateArray1[2].'/'.$ShdateArray1[1].'/'.$ShdateArray1[0];
		}
	$ResponseXML .="<formatedShippingNoteDate><![CDATA[".$formatedShippingNoteDate."]]></formatedShippingNoteDate>\n";
	$ResponseXML .="<FormatedVoyageDate><![CDATA[".$formatedVoyageDate."]]></FormatedVoyageDate>\n";
	$ResponseXML .="<VoyegeNo><![CDATA[".$row["strVoyegeNo"]."]]></VoyegeNo>\n";
	$ResponseXML .="<Carrier><![CDATA[".$row["strCarrier"]."]]></Carrier>\n";
	$ResponseXML .="<FinalDest><![CDATA[".$row["strFinalDest"]."]]></FinalDest>\n";	
	$ResponseXML .="<NetMass><![CDATA[".$row["netMass"]."]]></NetMass>\n";
	$ResponseXML .="<strWarehouseNo><![CDATA[".$row["strWarehouseNo"]."]]></strWarehouseNo>\n";
	$ResponseXML .="<strVslOprCode><![CDATA[".$row["strVslOprCode"]."]]></strVslOprCode>\n";
	$ResponseXML .="<strCtnOprCode><![CDATA[".$row["strCtnOprCode"]."]]></strCtnOprCode>\n";
	$ResponseXML .="<strShippingLineName><![CDATA[".$row["strShippingLineName"]."]]></strShippingLineName>\n";
	$ResponseXML .="<strCustomEntryNo><![CDATA[".$row["strCustomEntryNo"]."]]></strCustomEntryNo>\n";
	$ResponseXML .="<NameOfDeclarent><![CDATA[".$row["strNameOfDeclarent"]."]]></NameOfDeclarent>\n";
	$ResponseXML .="<BLNo><![CDATA[".$row["strBLNo"]."]]></BLNo>\n";
	$ResponseXML .="<SLPANo><![CDATA[".$row["strSLPANo"]."]]></SLPANo>\n";
	$ResponseXML .="<strEntryNo><![CDATA[".$row["strEntryNo"]."]]></strEntryNo>\n";
	$ResponseXML .="<strEntryReceive><![CDATA[".$row["strEntryReceive"]."]]></strEntryReceive>\n";	
	$ResponseXML .="<strContainerType><![CDATA[".$row["strContainerType"]."]]></strContainerType>\n";
	$ResponseXML .="<strAscycuda><![CDATA[".$row["strAscycuda"]."]]></strAscycuda>\n";
	$ResponseXML .="<dblCBM><![CDATA[".$row["dblCBM"]."]]></dblCBM>\n";
}


$ResponseXML .="</LoadDetails>";

echo $ResponseXML;
}

if($RequestType=="editDB")
{
	
	$invoiceNo	= $_GET["invoiceNo"];
	$sqlcheck="select 	strShippingNoteNo 
			   from 
			   shippingnote 
			   WHERE strInvoiceNo='$invoiceNo'";
				
	$resultcheck=$db->RunQuery($sqlcheck); 
	if (mysql_num_rows($resultcheck)>0)
	{
		$edit='update';
	}
	else
		$edit='insert';
    
/*CBM	33
CTNOprCode	55
CustomerEntry	33
Declrent	55
Description	55
MarksNo	33
PlaceAcceptance	33
RequestType	editDB
SLPANo	slpa
SNBNNO	BLno
ShippingLine	33
VSLOprCode	33
VoyageNo	215
gross	11
invoiceNo	001
net	113
portdischaarge	11
snbno	BLno
vessel	11
voyagedate	11/11/2009
warehouse	11
*/
$invoiceNo	= $_GET["invoiceNo"];
//$CBM	= $_GET["CBM"];
$CustomerEntry	= $_GET["CustomerEntry"];
$Declrent	= $_GET["Declrent"];
//$Description	= $_GET["Description"];
//$MarksNo	= $_GET["MarksNo"];
//$PlaceAcceptance	= $_GET["PlaceAcceptance"];
$SLPANo	= $_GET["SLPANo"];
$SNBNNO	= $_GET["SNBNNO"];
$ShippingLine	= $_GET["ShippingLine"];
$VSLOprCode	= $_GET["VSLOprCode"];
$VoyageNo	= $_GET["VoyageNo"];
//$gross	= $_GET["gross"];
$invoiceNo	= $_GET["invoiceNo"];
//$net	= $_GET["net"];
$portdischaarge	= $_GET["portdischaarge"];
$snbno	= $_GET["snbno"];
$vessel	= $_GET["vessel"];
$voyagedate	= $_GET["voyagedate"];
$warehouse	= $_GET["warehouse"];
$SnDate	= $_GET["SnDate"];
//$PlaceOfDelivery	= $_GET["PlaceOfDelivery"];
$CTNOprCode	= $_GET["CTNOprCode"];

$EntryNo = $_GET["EntryNo"];
$EntryReceive = $_GET["EntryReceive"];
$ContainerType = $_GET["ContainerType"];
$Ascycuda = $_GET["Ascycuda"];
$cbm = $_GET["cbm"];
//if($net=="")
	//$net=0;
if($cbm=="")
	$cbm=0;


$voyageArray	= explode('/',$voyagedate);
$formatedVoyageDate = $voyageArray[2].'-'.$voyageArray[1].'-'.$voyageArray[0];

$ShippingArray	= explode('/',$SnDate);
$formatedShippingDate = $ShippingArray[2].'-'.$ShippingArray[1].'-'.$ShippingArray[0];

if($edit=='update') 
		{
			$editdb="update shippingnote 
	set
	strEntryNo = '$EntryNo' ,
	strEntryReceive = '$EntryReceive' ,
	strContainerType = '$ContainerType' ,
	strAscycuda = '$Ascycuda' ,
	strInvoiceNo = '$invoiceNo' , 
	strPortOfDischarge = '$portdischaarge' , 
	strWarehouseNo = '$warehouse' , 
	strCustomEntryNo = '$CustomerEntry' , 
	strShippingLineName = '$ShippingLine' , 
	dtmShNoteDate = '$formatedShippingDate' , 
	strExporterRegNo = '001' , 
	strSLPANo = '$SLPANo' , 
	strBLNo = '$snbno' , 
	strVslOprCode = '$VSLOprCode' , 
	strCtnOprCode = '$CTNOprCode' , 
	strNameOfDeclarent = '$Declrent' , 
	strUserId = '4',
	dblCBM = $cbm
	where
	strInvoiceNo = '$invoiceNo' ;";
		
		
		}
else if($edit=='insert')
		{
			$editdb="insert into shippingnote 
	(
	strEntryNo,
	strEntryReceive,
	strContainerType,
	strAscycuda,
	strInvoiceNo, 
	strCompanyId, 
	strPortOfDischarge, 
	strWarehouseNo, 
	strCustomEntryNo, 
	strShippingLineName,  
	dtmShNoteDate, 
	strExporterRegNo, 
	strSLPANo, 
	strBLNo, 
	strVslOprCode, 
	strCtnOprCode, 
	strNameOfDeclarent, 
	strUserId,
	dblCBM
	)
	values
	(
	'$EntryNo',
	'$EntryReceive',
	'$ContainerType',
	'$Ascycuda',
	'$invoiceNo', 
	'0', 
	'$portdischaarge', 
	'$warehouse', 
	'$CustomerEntry', 
	'$ShippingLine',  
	'$formatedShippingDate', 
	'001', 
	'$SLPANo', 
	'$snbno', 
	'$VSLOprCode', 
	'$CTNOprCode', 
	'$Declrent', 
	'4',
	$cbm
	);
";
		}
		
$editResult=$db->RunQuery($editdb);
if($editResult)
{
	$update_invoiceheader="UPDATE invoiceheader
							SET
							strCarrier='$vessel',
							strVoyegeNo='$VoyageNo',
							dtmSailingDate='$formatedVoyageDate'
							WHERE
							strInvoiceNo='$invoiceNo'";
	$update_result=$db->RunQuery($update_invoiceheader);
	echo "Successfully saved.";	
}
else
	echo $editdb;
}

?>