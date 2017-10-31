<?php 
session_start();
include("../../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];


if ($request=='getData')
{	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$invoiceno=$_GET["invoiceno"];
	$sql="select 	IH.strInvoiceNo, 
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
	strCusdecNo, 
	strFCL, 
	strOfficeOfEntry, 
	strDeclarant, 
	strDeliveryTerms, 
	strCage50, 
	intPaymentTerms, 
	strCity, 
	strDestCountry, 
	dblOthers, 
	dblInsurance, 
	dblFreight, 
	strMeasurement, 
	strUserID, 
	strCountryCode, 
	intStatus, 
	strAuthorizedBy, 
	strWharfClerk,
	strBL
	 
	from 
	invoiceheader  IH
	left join exportcusdechead EC on IH.strInvoiceNo=EC.strInvoiceNo
	where IH.strInvoiceNo='$invoiceno'";
	
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$XMLString .= "<CompanyID><![CDATA[" . $row["strCompanyID"]  . "]]></CompanyID>\n";
 		$XMLString .= "<BuyerID><![CDATA[" . $row["strBuyerID"]  . "]]></BuyerID>\n";
		$XMLString .= "<LCNo><![CDATA[" . $row["strLCNo"]  . "]]></LCNo>\n";
		$XMLString .= "<LCBankID><![CDATA[" . $row["strLCBankID"]  . "]]></LCBankID>\n";
		$XMLString .= "<lcno><![CDATA[" . $row["strLCNO"]  . "]]></lcno>\n";
		$XMLString .= "<reason><![CDATA[" . $row["strReasonDupIOU"]  . "]]></reason>\n";
		$XMLString .= "<PortOfLoading><![CDATA[" . $row["strPortOfLoading"]  . "]]></PortOfLoading>\n";
		$XMLString .= "<FinalDest><![CDATA[" . $row["strFinalDest"]  . "]]></FinalDest>\n";
		$XMLString .= "<Payterm><![CDATA[" . $row["intPaymentTerms"]  . "]]></Payterm>\n";
		$XMLString .= "<Carrier><![CDATA[" . $row["strCarrier"]  . "]]></Carrier>\n";
		$XMLString .= "<VoyegeNo><![CDATA[" . $row["strVoyegeNo"]  . "]]></VoyegeNo>\n";
		$XMLString .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$XMLString .= "<rates><![CDATA[" . $row["dblExchange"]  . "]]></rates>\n";
		$XMLString .= "<NoOfCartons><![CDATA[" . $row["intNoOfCartons"]  . "]]></NoOfCartons>\n";
		$XMLString .= "<GenDesc><![CDATA[" . $row["strGenDesc"]  . "]]></GenDesc>\n";
		$XMLString .= "<MarksAndNos><![CDATA[" . $row["strMarksAndNos"]  . "]]></MarksAndNos>\n";
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$XMLString .= "<strFCL><![CDATA[" . $row["strFCL"]  . "]]></strFCL>\n";
 		$XMLString .= "<strOfficeOfEntry><![CDATA[" . $row["strOfficeOfEntry"]  . "]]></strOfficeOfEntry>\n";
		$XMLString .= "<strCage50><![CDATA[" . $row["strCage50"]  . "]]></strCage50>\n";
		$XMLString .= "<strCity><![CDATA[" . $row["strCity"]  . "]]></strCity>\n";
		$XMLString .= "<dblOthers><![CDATA[" . $row["dblOthers"]  . "]]></dblOthers>\n";
		$XMLString .= "<dblInsurance><![CDATA[" . $row["dblInsurance"]  . "]]></dblInsurance>\n";
		$XMLString .= "<dblFreight><![CDATA[" . $row["dblFreight"]  . "]]></dblFreight>\n";
		$XMLString .= "<strMeasurement><![CDATA[" . $row["strMeasurement"]  . "]]></strMeasurement>\n";
		$XMLString .= "<strDestCountry><![CDATA[" . $row["strDestCountry"]  . "]]></strDestCountry>\n";
		$XMLString .= "<strAuthorizedBy><![CDATA[" . $row["strAuthorizedBy"]  . "]]></strAuthorizedBy>\n";
		$XMLString .= "<strWharfClerk><![CDATA[" . $row["strWharfClerk"]  . "]]></strWharfClerk>\n";
		$XMLString .= "<DeliveryTerms><![CDATA[" . $row["strDeliveryTerms"]  . "]]></DeliveryTerms>\n";
		$XMLString .= "<Declarant><![CDATA[" . $row["strDeclarant"]  . "]]></Declarant>\n";
		$XMLString .= "<BL><![CDATA[" . $row["strBL"]  . "]]></BL>\n";
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

$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}


/*if ($request=='getusdecData')
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$invoiceno=$_GET["invoiceno"];
	$sql="SELECT 
	strInvoiceNo, 
	strCusdecNo, 
	strFCL, 
	strOfficeOfEntry, 
	strDeclarant, 
	strDeliveryTerms, 
	strCage50, 
	intPaymentTerms, 
	strCity, 
	strDestCountry, 
	dblOthers, 
	dblInsurance, 
	dblFreight, 
	strMeasurement, 
	strUserID, 
	strCountryCode, 
	intStatus, 
	strAuthorizedBy, 
	strWharfClerk,
	strBL
	 
	FROM 
	exportcusdechead 
	WHERE strInvoiceNo='$invoiceno'";
	//die($sql);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$XMLString .= "<strFCL><![CDATA[" . $row["strFCL"]  . "]]></strFCL>\n";
 		$XMLString .= "<strOfficeOfEntry><![CDATA[" . $row["strOfficeOfEntry"]  . "]]></strOfficeOfEntry>\n";
		$XMLString .= "<strCage50><![CDATA[" . $row["strCage50"]  . "]]></strCage50>\n";
		$XMLString .= "<strCity><![CDATA[" . $row["strCity"]  . "]]></strCity>\n";
		$XMLString .= "<dblOthers><![CDATA[" . $row["dblOthers"]  . "]]></dblOthers>\n";
		$XMLString .= "<dblInsurance><![CDATA[" . $row["dblInsurance"]  . "]]></dblInsurance>\n";
		$XMLString .= "<dblFreight><![CDATA[" . $row["dblFreight"]  . "]]></dblFreight>\n";
		$XMLString .= "<strMeasurement><![CDATA[" . $row["strMeasurement"]  . "]]></strMeasurement>\n";
		$XMLString .= "<strDestCountry><![CDATA[" . $row["strDestCountry"]  . "]]></strDestCountry>\n";
		$XMLString .= "<strAuthorizedBy><![CDATA[" . $row["strAuthorizedBy"]  . "]]></strAuthorizedBy>\n";
		$XMLString .= "<strWharfClerk><![CDATA[" . $row["strWharfClerk"]  . "]]></strWharfClerk>\n";
		$XMLString .= "<DeliveryTerms><![CDATA[" . $row["strDeliveryTerms"]  . "]]></DeliveryTerms>\n";
		$XMLString .= "<Declarant><![CDATA[" . $row["strDeclarant"]  . "]]></Declarant>\n";
		$XMLString .= "<BL><![CDATA[" . $row["strBL"]  . "]]></BL>\n";
	
	}
	
$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}*/


if ($request=='editData')
{
$invoiceno=$_GET["invoiceno"];
$srtCheck="SELECT 	strInvoiceNo FROM exportcusdechead WHERE strInvoiceNo='$invoiceno'";
$sqlResult=$db->RunQuery($srtCheck); 

if (mysql_fetch_array($sqlResult)>0)
{
	$edit='update';
}
else
	$edit='insert';


	$Authorizeby=$_GET["Authorizeby"];
	$Cage50=$_GET["Cage50"];
	$Frreight=$_GET["Frreight"];
	$Insurence=$_GET["Insurence"];
	$Measure=$_GET["Measure"];
	$fcl=$_GET["fcl"];
	$countruy=$_GET["countruy"];
	$officeEntry=$_GET["officeEntry"];
	$Other=$_GET["Other"];
	$wharfclerk=$_GET["wharfclerk"];
	$Delivery=$_GET["Delivery"];
	$Decleration=$_GET["Decleration"];
	$BL=$_GET["BL"];
	$payterm=$_GET["payterm"];
if($edit=='insert'){

$str="INSERT INTO exportcusdechead 
	(strInvoiceNo,	
	strFCL, 
	strOfficeOfEntry, 
	strDeclarant, 
	strDeliveryTerms, 
	strCage50, 
	intPaymentTerms, 
	strCity, 
	strDestCountry, 
	dblOthers, 
	dblInsurance, 
	dblFreight, 
	strMeasurement, 
	strUserID, 
	strCountryCode, 
	intStatus, 
	strAuthorizedBy, 
	strWharfClerk,
	strBL
	)
	VALUES
	('$invoiceno', 
	'$fcl', 
	'$officeEntry', 
	'$Decleration', 
	'$Delivery', 
	'$Cage50', 
	'$payterm', 
	'City', 
	'$countruy', 
	'$Other', 
	'$Insurence', 
	'$Frreight', 
	'$Measure', 
	'u01', 
	'CountryCode', 
	'1', 
	'$Authorizeby', 
	'$wharfclerk',
	'$BL'
	);
";
//echo $str;
$result=$db->RunQuery($str); 

	if($result)
	echo "Succesfully saved. ";	
}

else if	($edit=='update')
{
$str="UPDATE 
	exportcusdechead 
	SET	
	strFCL = '$fcl' , 
	strOfficeOfEntry = '$officeEntry' ,	
	strDeliveryTerms='$Delivery',
	strDeclarant='$Decleration',
	strCage50 = '$Cage50' , 
	intPaymentTerms='$payterm',
	strCity = 'City' , 
	strDestCountry = '$countruy' , 
	dblOthers = '$Other' , 
	dblInsurance = '$Insurence' , 
	dblFreight = '$Frreight' , 
	strMeasurement = '$Measure' , 
	strCountryCode = 'CountryCode' , 
	intStatus = '1' , 
	strAuthorizedBy = '$Authorizeby' , 
	strWharfClerk = '$wharfclerk',
	strBL='$BL'	
	WHERE
	strInvoiceNo = '$invoiceno'  ;";
	
//die($str);
$result=$db->RunQuery($str); 

if($result)
	echo "Successfully updated.";	
								
	
}	
}

?>
