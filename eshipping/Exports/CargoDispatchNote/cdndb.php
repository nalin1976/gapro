<?php 
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];

if ($request=='getInvoice')
{	

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$invoiceno=$_GET["invoiceno"];
	
	$sql="select
	strCDNNo, 
	cdn.strCarrier as strCarrier, 
	DATE(cdn.dtmSailingDate)AS voyageDate,
	cdn.strVoyageNo AS strVoyegeNo,
	cdn.strPortOfDischarge AS FinalDest,
	cdn.strExVesel, 
	cdn.strPlaceOfDelivery, 
	cdn.strAuthorisedS, 
	cdn.strDescriptionOfGoods, 
	cdn.dblGrossWt, 
	cdn.dblNetWt, 
	cdn.dblCBM, 
	cdn.strLorryNo, 
	cdn.strBLNo, 
	cdn.dblTareWt, 
	cdn.strSealNo, 
	cdn.strDriverName, 
	cdn.strCleanerName, 
	cdn.strOthres, 
	cdn.strDeclarentName, 
	cdn.strCustomerEntry, 
	cdn.strMarks, 
	cdn.dblHieght, 
	cdn.dblLength, 
	cdn.strType, 
	cdn.dblTemperature, 
	cdn.strDelivery, 
	cdn.strReciept, 
	cdn.strRemarks, 
	cdn.strUserId, 
	DATE(cdn.dtmCreateDate) as dtmCreateDate, 
	cdn.strVSLOPRCode, 
	cdn.strCNTOPRCode,
	(SELECT strName FROM customers CU WHERE CU.strCustomerID=ih.strCompanyID)AS customername,
	(SELECT strName FROM buyers B WHERE B.strBuyerID=ih.strNotifyID1)AS notifyParty1,
	(SELECT strName FROM buyers B WHERE B.strBuyerID=ih.strBuyerID)AS buyername
	from 
	cdn cdn
	left join invoiceheader ih on cdn.strInvoiceNo=ih.strInvoiceNo
	where cdn.strInvoiceNo='$invoiceno'";
	
	
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	$result = $db->RunQuery($sql); 
if (mysql_num_rows($result)<1)
{
$sql="SELECT IH.strCompanyID,
(SELECT strName FROM customers CU WHERE CU.strCustomerID=IH.strCompanyID)AS customername,
strNotifyID1,
(SELECT strName FROM buyers B WHERE B.strBuyerID=IH.strNotifyID1)AS notifyParty1,
strBuyerID,
(SELECT strName FROM buyers B WHERE B.strBuyerID=IH.strBuyerID)AS buyername,
DATE(IH.dtmSailingDate)AS voyageDate,
strVoyegeNo AS strVoyegeNo,
shn.strMarksNo,
shn.strDescriptionOfGoods,
shn.strPortOfDischarge as FinalDest,
shn.strCarrier,
(select SUM(dblGrossMass) from invoicedetail ID where IH.strInvoiceNo=ID.strInvoiceNo)AS dblGrossWt,
(select SUM(dblNetMass) from invoicedetail ID where IH.strInvoiceNo=ID.strInvoiceNo)AS dblNetWt
FROM invoiceheader IH inner join shippingnote shn on shn.strInvoiceNo=IH.strInvoiceNo
WHERE IH.strInvoiceNo='$invoiceno'";
//die($sql);
$result=$db->RunQuery($sql);
}
	
	
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$XMLString .= "<customername><![CDATA[" . $row["customername"]  . "]]></customername>\n";
 		$XMLString .= "<buyername><![CDATA[" . $row["buyername"]  . "]]></buyername>\n";
		$XMLString .= "<LCNo><![CDATA[" . $row["strLCNo"]  . "]]></LCNo>\n";
		$XMLString .= "<LCBankID><![CDATA[" . $row["strLCBankID"]  . "]]></LCBankID>\n";
		$XMLString .= "<lcno><![CDATA[" . $row["strLCNO"]  . "]]></lcno>\n";
		$XMLString .= "<LorryNo><![CDATA[" . $row["strLorryNo"]  . "]]></LorryNo>\n";
		$XMLString .= "<PortOfLoading><![CDATA[" . $row["strPortOfLoading"]  . "]]></PortOfLoading>\n";
		$XMLString .= "<FinalDest><![CDATA[" . $row["FinalDest"]  . "]]></FinalDest>\n";
		$XMLString .= "<strExVesel><![CDATA[" . $row["strExVesel"]  . "]]></strExVesel>\n";
		$XMLString .= "<Carrier><![CDATA[" . $row["strCarrier"]  . "]]></Carrier>\n";
		$XMLString .= "<VoyegeNo><![CDATA[" . $row["strVoyegeNo"]  . "]]></VoyegeNo>\n";
		$XMLString .= "<rates><![CDATA[" . $row["dblExchange"]  . "]]></rates>\n";
		$XMLString .= "<NoOfCartons><![CDATA[" . $row["intNoOfCartons"]  . "]]></NoOfCartons>\n";
		$XMLString .= "<GenDesc><![CDATA[" . $row["strGenDesc"]  . "]]></GenDesc>\n";
		$XMLString .= "<BLNo><![CDATA[" . $row["strBLNo"]  . "]]></BLNo>\n";
		$XMLString .= "<TareWt><![CDATA[" . $row["dblTareWt"]  . "]]></TareWt>\n";
		$XMLString .= "<SealNo><![CDATA[" . $row["strSealNo"]  . "]]></SealNo>\n";
		$XMLString .= "<DriverName><![CDATA[" . $row["strDriverName"]  . "]]></DriverName>\n";
		$XMLString .= "<CustomerEntry><![CDATA[" . $row["strCustomerEntry"]  . "]]></CustomerEntry>\n";
		$XMLString .= "<CleanerName><![CDATA[" . $row["strCleanerName"]  . "]]></CleanerName>\n";
		$XMLString .= "<Othres><![CDATA[" . $row["strOthres"]  . "]]></Othres>\n";
		$XMLString .= "<GrossWt><![CDATA[" . $row["dblGrossWt"]  . "]]></GrossWt>\n";
		$XMLString .= "<DeclarentName><![CDATA[" . $row["strDeclarentName"]  . "]]></DeclarentName>\n";
		$XMLString .= "<Temperature><![CDATA[" . $row["dblTemperature"]  . "]]></Temperature>\n";
		$XMLString .= "<CBM><![CDATA[" . $row["dblCBM"]  . "]]></CBM>\n";
		$XMLString .= "<Delivery><![CDATA[" . $row["strDelivery"]  . "]]></Delivery>\n";
		$XMLString .= "<Reciept><![CDATA[" . $row["strReciept"]  . "]]></Reciept>\n";
		$XMLString .= "<Hieght><![CDATA[" . $row["dblHieght"]  . "]]></Hieght>\n";
		$XMLString .= "<Length><![CDATA[" . $row["dblLength"]  . "]]></Length>\n";
		$XMLString .= "<CNTOPRCode><![CDATA[" . $row["strCNTOPRCode"]  . "]]></CNTOPRCode>\n";
		$XMLString .= "<VSLOPRCode><![CDATA[" . $row["strVSLOPRCode"]  . "]]></VSLOPRCode>\n";
		$XMLString .= "<Type><![CDATA[" . $row["strType"]  . "]]></Type>\n";
		$XMLString .= "<Temperature><![CDATA[" . $row["dblTemperature"]  . "]]></Temperature>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<NetWt><![CDATA[" . $row["dblNetWt"]  . "]]></NetWt>\n";
		$XMLString .= "<strAuthorisedS><![CDATA[" . $row["strAuthorisedS"]  . "]]></strAuthorisedS>\n";
		
		if ($row["dtmCreateDate"]=='')
			$formatedInvoiceDate=date("d/m/Y");
		else {
		$invoicedate =substr($row["dtmCreateDate"],0,10);
				$invoicedateArray=explode('-',$invoicedate);
				$formatedInvoiceDate=$invoicedateArray[2]."/".$invoicedateArray[1]."/".$invoicedateArray[0];
				}
		$XMLString .= "<InvoiceDate><![CDATA[" . $formatedInvoiceDate  . "]]></InvoiceDate>\n";
		
		$LCDate =substr($row["dtmLCDate"],0,10);
				$LCDateArray=explode('-',$LCDate);
				$formatedLCDate=$LCDateArray[2]."/".$LCDateArray[1]."/".$LCDateArray[0];
		$XMLString .= "<dtmLCDate><![CDATA[" . $formatedLCDate  . "]]></dtmLCDate>\n";		
	
		$SailingDate =substr($row["voyageDate"],0,10);
				$SailingDateArray=explode('-',$SailingDate);
				$formatedSailingDate=$SailingDateArray[2]."/".$SailingDateArray[1]."/".$SailingDateArray[0];
		$XMLString .= "<SailingDate><![CDATA[" . $formatedSailingDate  . "]]></SailingDate>\n";
	
	}

$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

if ($request=='getCDN')
{	

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$invoiceno=$_GET["invoiceno"];
	
	$sql="select
	strCDNNo, 
	strInvoiceNo, 
	strCarrier, 
	strVoyageNo, 
	dtmSailingDate, 
	strPortOfDischarge, 
	strExVesel, 
	strPlaceOfDelivery, 
	strAuthorisedS, 
	strDescriptionOfGoods, 
	dblGrossWt, 
	dblNetWt, 
	dblCBM, 
	strLorryNo, 
	strBLNo, 
	dblTareWt, 
	strSealNo, 
	strDriverName, 
	strCleanerName, 
	strOthres, 
	strDeclarentName, 
	strCustomerEntry, 
	strMarks, 
	dblHieght, 
	dblLength, 
	strType, 
	dblTemperature, 
	strDelivery, 
	strReciept, 
	strRemarks, 
	strUserId, 
	dtmCreateDate, 
	strVSLOPRCode, 
	strCNTOPRCode
	 
	from 
	cdn 	 
	WHERE strInvoiceNo='$invoiceno';";
	//die($sql);
	$XMLString= "<Data>";
	$XMLString .= "<CDNdata>";
	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$XMLString .= "<strCarrier><![CDATA[" . $row["strCarrier"]  . "]]></strCarrier>\n";
 		$XMLString .= "<strVoyageNo><![CDATA[" . $row["strVoyageNo"]  . "]]></strVoyageNo>\n";
		$XMLString .= "<dtmSailingDate><![CDATA[" . $row["dtmSailingDate"]  . "]]></dtmSailingDate>\n";
		$XMLString .= "<strPortOfDischarge><![CDATA[" . $row["strPortOfDischarge"]  . "]]></strPortOfDischarge>\n";
		$XMLString .= "<strExVesel><![CDATA[" . $row["strExVesel"]  . "]]></strExVesel>\n";
		$XMLString .= "<strPlaceOfDelivery><![CDATA[" . $row["strPlaceOfDelivery"]  . "]]></strPlaceOfDelivery>\n";
		$XMLString .= "<strAuthorisedS><![CDATA[" . $row["strAuthorisedS"]  . "]]></strAuthorisedS>\n";
		$XMLString .= "<strDescriptionOfGoods><![CDATA[" . $row["strDescriptionOfGoods"]  . "]]></strDescriptionOfGoods>\n";
		$XMLString .= "<dblGrossWt><![CDATA[" . $row["dblGrossWt"]  . "]]></dblGrossWt>\n";
		$XMLString .= "<dblNetWt><![CDATA[" . $row["dblNetWt"]  . "]]></dblNetWt>\n";
		$XMLString .= "<strSealNo><![CDATA[" . $row["strSealNo"]  . "]]></strSealNo>\n";
		$XMLString .= "<VoyegeNo><![CDATA[" . $row["strVoyegeNo"]  . "]]></VoyegeNo>\n";
		$XMLString .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$XMLString .= "<rates><![CDATA[" . $row["dblExchange"]  . "]]></rates>\n";
		$XMLString .= "<NoOfCartons><![CDATA[" . $row["intNoOfCartons"]  . "]]></NoOfCartons>\n";
		$XMLString .= "<GenDesc><![CDATA[" . $row["strGenDesc"]  . "]]></GenDesc>\n";
		$XMLString .= "<MarksAndNos><![CDATA[" . $row["strMarksAndNos"]  . "]]></MarksAndNos>\n";
		
			
	}
//die($sql);
$XMLString .= "</CDNdata>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

if($request=='editDB') 
{
 /*		CBM	asf
REQUEST	editDB
cleaner	dsf
customerEntry	dfs
declarent	dsf
delivery	DOOR
driver	sdf
gross	0
height	0
invoiceno	001
length	0
lorry	asfd
others	sdf
placeofReceipt	DOOR
remarks	asf
seal	df
signatroy	USA
temperature	0
type	dsf*/
 
		$invoiceno=$_GET["invoiceno"];
		$lorry=$_GET["lorry"];
		$seal=$_GET["seal"];
		$customerEntry=$_GET["customerEntry"];
		$declarent=$_GET["declarent"];
		$driver=$_GET["driver"];
		$voyage=$_GET["voyage"];
		$voyagedate=$_GET["voyagedate"];
			$voyagedate_array=explode("/",$voyagedate);
			$voyagedate=$voyagedate_array[2]."-".$voyagedate_array[1]."-".$voyagedate_array[0];
		$cleaner=$_GET["cleaner"];
		$others=$_GET["others"];
		$gross=$_GET["gross"];
		$temperature=$_GET["temperature"];
		$CBM=$_GET["CBM"];
		$delivery=$_GET["delivery"];
		$placeofReceipt=$_GET["placeofReceipt"];
		$others=$_GET["others"];
		$height=$_GET["height"];
		$length=$_GET["length"];
		$type=$_GET["type"];
		$net=$_GET["type"];
		$remarks=$_GET["remarks"];
		$VSLOPR=$_GET["VSLOPR"];
		$txtCNT=$_GET["txtCNT"];
		$date=date("Y-m-d");
		$BL=$_GET["BL"];
		$TareWt=$_GET["TareWt"];
		$Vessel=$_GET["Vessel"];
		$signatroy=$_GET["signatroy"];
		$ExVessel=$_GET["ExVessel"];
		$discharge=$_GET["discharge"];
		$net=$_GET["net"];
		//$remarks=$_GET["remarks"];*/
			if ($gross=="")
			{
			$gross=0;
			}
			if ($others=="")
			{
			$others=0;
			}
			if ($temperature=="")
			{
			$temperature=0;
			}
		$CreateDate=date("Y-m-d");
		$strDbCheck="select strCDNNo
					from cdn 
					where strInvoiceNo='$invoiceno'";
		$resultCheck= $db->RunQuery($strDbCheck);
		if(mysql_fetch_array($resultCheck)>0)
		{
			$edit='update';
		}
		else
		{
			$edit='insert';
		}   
		
			//die($edit);
		if ($edit=='update')
		{
				//die("pass");		
			$strUpdsate="update  cdn 
						set
						strCarrier = '$Vessel' , 
						strVoyageNo = '$voyage' , 
						dtmSailingDate = '$voyagedate' , 
						strPortOfDischarge = '$discharge' , 
						strExVesel = '$ExVessel' , 
						strPlaceOfDelivery = '$delivery' , 
						strAuthorisedS = '$signatroy' , 
						dblGrossWt = '$gross' , 
						dblNetWt = '$net' , 
						dblCBM = '$CBM' , 
						strLorryNo = '$lorry' , 
						strBLNo = '$BL' , 
						dblTareWt = '$TareWt' , 
						strSealNo = '$seal' , 
						strDriverName = '$driver' , 
						strCleanerName = '$cleaner' , 
						strOthres = '$others' , 
						strDeclarentName = '$declarent' , 
						strCustomerEntry = '$customerEntry' , 
						dblHieght = '$height' , 
						dblLength = '$length' , 
						strType = '$type' , 
						dblTemperature = '$temperature' , 
						strDelivery = '$delivery' , 
						strReciept = '$placeofReceipt' , 
						strRemarks = '$remarks' , 
						strUserId = 'strUserId' , 
						dtmCreateDate = '$date' , 
						strVSLOPRCode = '$VSLOPR' , 
						strCNTOPRCode = '$txtCNT'
						where
						strInvoiceNo = '$invoiceno'";
						
			$resultUpdate= $db->RunQuery($strUpdsate);
			if($resultUpdate)
			{
				echo "Successfully updated.";
			}
			else echo $strUpdsate;
		}
		
		else if($edit=='insert')
		{
			$strInsert="insert into cdn 
						( 
						strInvoiceNo, 
						strCarrier, 
						strVoyageNo, 
						dtmSailingDate, 
						strPortOfDischarge, 
						strExVesel, 
						strPlaceOfDelivery, 
						strAuthorisedS, 
						strDescriptionOfGoods, 
						dblGrossWt, 
						dblNetWt, 
						dblCBM, 
						strLorryNo, 
						strBLNo, 
						dblTareWt, 
						strSealNo, 
						strDriverName, 
						strCleanerName, 
						strOthres, 
						strDeclarentName, 
						strCustomerEntry, 
						strMarks, 
						dblHieght, 
						dblLength, 
						strType, 
						dblTemperature, 
						strDelivery, 
						strReciept, 
						strRemarks, 
						strUserId, 
						dtmCreateDate, 
						strVSLOPRCode, 
						strCNTOPRCode
						)
						values
						(
						'$invoiceno', 
						'$Vessel', 
						'$voyage', 
						'$voyagedate', 
						'$discharge', 
						'$ExVessel', 
						'$delivery', 
						'$signatroy', 
						'', 
						'$gross', 
						'$net', 
						'$CBM', 
						'$lorry', 
						'$BL', 
						'$TareWt', 
						'$seal', 
						'$driver', 
						'$cleaner', 
						'$others', 
						'$declarent', 
						'$customerEntry', 
						'', 
						'$height', 
						'$length', 
						'$type', 
						'$temperature', 
						'$delivery', 
						'$placeofReceipt', 
						'$remarks', 
						'strUserId', 
						'$date', 
						'$VSLOPR', 
						'$txtCNT'	);";
			
			$resultInsert= $db->RunQuery($strInsert);
			if($resultInsert)
			{
				echo "Successfully saved.";
			}
			else 
				echo $strInsert;	

			
		}
			
}	


if ($request=='getMrksDSC')
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$invoiceno=$_GET["invoiceno"];
	
	$sql="	select
	cdn.strDescriptionOfGoods, 
	cdn.strMarks, 
	shn.strMarksNo as ihmarks,
	shn.strDescriptionOfGoods as ihdesc
	from 
	shippingnote shn
	left join cdn cdn on cdn.strInvoiceNo=shn.strInvoiceNo
	where shn.strInvoiceNo='$invoiceno'";
		
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	$result = $db->RunQuery($sql); 
	$row=mysql_fetch_array($result);
	$marks=$row["strMarks"];
	$desc=$row["strDescriptionOfGoods"];
	if($marks=="")
	$marks=$row["ihmarks"];
	if($desc=="")
	$desc=$row["ihdesc"];
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	$XMLString .= "<marksNos><![CDATA[" . $marks  . "]]></marksNos>\n";
	$XMLString .= "<genDesc><![CDATA[" . $desc  . "]]></genDesc>\n";
	$XMLString .= "</DeliveryData>";
	$XMLString.= "</Data>";
	echo $XMLString ;
}	


if ($request=='updateMrksDSC')
{

$invoiceno=$_GET["invoiceno"];
$desc=$_GET["desc"];
$marks=$_GET["marks"];
	
	$sql="update cdn 
	set
	strDescriptionOfGoods = '$desc' ,
	strMarks = '$marks'  	
	where	
	strInvoiceNo = '$invoiceno' 
	";
		
	$result = $db->RunQuery($sql); 
	if($result)
	echo "Saved sucessfully.";
	else
	echo "Please save CDN header first.";
	
	
}	

if ($request=='getMrksDSC')
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$invoiceno=$_GET["invoiceno"];
	
	$sql="	select
	cdn.strDescriptionOfGoods, 
	cdn.strMarks, 
	shn.strMarksNo as ihmarks,
	shn.strDescriptionOfGoods as ihdesc
	from 
	shippingnote shn
	left join cdn cdn on cdn.strInvoiceNo=shn.strInvoiceNo
	where shn.strInvoiceNo='$invoiceno'";
		
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	$result = $db->RunQuery($sql); 
	$row=mysql_fetch_array($result);
	$marks=$row["strMarks"];
	$desc=$row["strDescriptionOfGoods"];
	if($marks=="")
	$marks=$row["ihmarks"];
	if($desc=="")
	$desc=$row["ihdesc"];
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	$XMLString .= "<marksNos><![CDATA[" . $marks  . "]]></marksNos>\n";
	$XMLString .= "<genDesc><![CDATA[" . $desc  . "]]></genDesc>\n";
	$XMLString .= "</DeliveryData>";
	$XMLString.= "</Data>";
	echo $XMLString ;
}	

if ($request=='load_po_desc')
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$invoiceno=$_GET["invoiceno"];
	$sql="	select
			powisecdn.strInvoiceNo, 
			powisecdn.strPONO as strBuyerPONo, 
			powisecdn.strISDNo as strISDno, 
			powisecdn.strPCS as dblQuantity, 
			powisecdn.strCTNS as intNoOfCTns, 
			powisecdn.dblNetWt as dblNetMass, 
			powisecdn.dblGrossWt as dblGrossMass, 
			powisecdn.strCBM
			from 
			powisecdn			
			where 
			powisecdn.strInvoiceNo='$invoiceno'";
			
	//die($sql);
	$results_check=$db->RunQuery($sql); 
	if(mysql_num_rows($results_check)<1)
		{
	
			$sql="	select 
					strInvoiceNo,
					strBuyerPONo,
					strDescOfGoods,
					dblQuantity,
					dblNetMass,
					intNoOfCTns,
					dblGrossMass,
					strISDno
					from 
					invoicedetail
					where 
					strInvoiceNo='$invoiceno'";
		}
		
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	$result = $db->RunQuery($sql); 	
	while($row=mysql_fetch_array($result))
		{
			
			$XMLString .= "<InvoiceNo><![CDATA[" . $row['strInvoiceNo']  . "]]></InvoiceNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $row['strBuyerPONo']  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $row['strDescOfGoods']  . "]]></DescOfGoods>\n";
			$XMLString .= "<NetMass><![CDATA[" . $row['dblNetMass']  . "]]></NetMass>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $row['dblGrossMass']  . "]]></GrossMass>\n";
			$XMLString .= "<ISDno><![CDATA[" . $row['strISDno']  . "]]></ISDno>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $row['strDescOfGoods']  . "]]></DescOfGoods>\n";
			$XMLString .= "<PCS><![CDATA[" . $row['dblQuantity']  . "]]></PCS>\n";
			$XMLString .= "<ctns><![CDATA[" . $row['intNoOfCTns']  . "]]></ctns>\n";
			$XMLString .= "<CBM><![CDATA[0]]></CBM>\n";			
		}
	$XMLString .= "</DeliveryData>";
	$XMLString.= "</Data>";
	echo $XMLString ;
}	

if ($request=='delete_po_wise_cdn')
{	
	$InvoiceNo=$_GET["InvoiceNo"];
	$str="delete from powisecdn 
	where
	strInvoiceNo ='$InvoiceNo'";
	$result=$db->RunQuery($str);
	echo('deleted');
}

if ($request=='save_to_db_cdn')
{	
	$InvoiceNo	=$_GET["InvoiceNo"];
	$BuyerPONo	=$_GET["BuyerPONo"];
	$CBM		=$_GET["CBM"];
	$GrossMass	=$_GET["GrossMass"];
	$ISDno		=$_GET["ISDno"];
	$NetMass	=$_GET["NetMass"];
	$PCS		=$_GET["PCS"];
	$ctns		=$_GET["ctns"];
		
	$str="insert into powisecdn 
						(strInvoiceNo, 
						strPONO, 
						strISDNo, 
						strPCS, 
						strCTNS, 
						dblNetWt, 
						dblGrossWt, 
						strCBM
						)
						values
						('$InvoiceNo', 
						'$BuyerPONo', 
						'$ISDno', 
						'$PCS', 
						'$ctns', 
						'$NetMass', 
						'$GrossMass', 
						'$CBM'
						);";

				
	$result=$db->RunQuery($str);
	
	if ($result)
	{	
		echo "saved";
				
	}

}
?>
