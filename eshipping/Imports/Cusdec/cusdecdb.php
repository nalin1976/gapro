<?PHP
session_start();
include("../../Connector.php");	
	$RequestType	= $_GET["RequestType"];
	$CompanyId  	= $_SESSION["FactoryID"];
	$UserId			= $_SESSION["UserID"];

if($RequestType=="SaveDeliveryHeader")
{
	$DeliveryNo				= $_GET["DeliveryNo"];
	$mode					= $_GET["mode"];
	$invoice				= $_GET["invoice"];
	$exporterID				= $_GET["exporter"];
	$customerID				= $_GET["consignee"];
	$consigneeRefCode		= $_GET["consigneeRefCode"];
	$originCountry			= $_GET["originCountry"];
	$exCountry				= $_GET["exCountry"];
	$lastConsiCity			= $_GET["lastConsiCity"];
	$tradingCountry			= $_GET["tradingCountry"];
	$vessel					= $_GET["vessel"];
	$deliveryTerm			= $_GET["deliveryTerm"];
	$fcl					= $_GET["fcl"];
	$cboFcl					= $_GET["cboFcl"];
	$txtFcl					= $_GET["txtFcl"];
	$voyageNo				= $_GET["VoyageNo"];
	$containerNo			= $_GET["containerNo"];
	$currency				= $_GET["currency"];
	$exRate					= $_GET["exRate"];
	$invoAmount				= $_GET["invoAmount"];
	$bank					= $_GET["bank"];
	$previousDoc			= $_GET["previousDoc"];
	$lcNo					= $_GET["lcNo"];
	$termsOfPayment			= $_GET["termsOfPayment"];
	$weight1				= $_GET["weight1"];
	$weight2				= str_replace("'","''",$_GET["weight2"]);
	$officeEntry			= $_GET["officeEntry"];
	$buyerID				= $_GET["buyerID"];
	$TQBNo					= $_GET["TQBNo"];
	$authorizedBy			= $_GET["authorizedBy"];
	$noOfPackages			= $_GET["noOfPackages"];
	$marks					= str_replace("'", "''", $_GET["marks"]);
	$packageType			= $_GET["packageType"];
	$FOB					= $_GET["FOB"];
	$Insurance				= $_GET["Insurance"];
	$Freight				= $_GET["Freight"];
	$Other					= $_GET["Other"];
	$forwaders				= $_GET["forwaders"];
	$merchandiser			= $_GET["merchandiser"];
	$walfCleark				= $_GET["walfCleark"];
	$voyageDate				= $_GET["voyageDate"];
		$voyageDateArray 	= explode('/',$voyageDate);
		$FormatVoyageDate 	= $voyageDateArray[2]."-".$voyageDateArray[1]."-".$voyageDateArray[0];
	$recType				= $_GET["recType"];
	$preferenceCode			= $_GET["preferenceCode"];
	$licenceNo				= $_GET["licenceNo"];
	$placeOfLoading			= $_GET["placeOfLoading"];
	$bankRefNo				= $_GET["bankRefNo"];
	$invoiceDate			= $_GET["invoiceDate"];
		$invoiceDateArray 	= explode('/',$invoiceDate);
		$FormatInvoiceDate 	= $invoiceDateArray[2]."-".$invoiceDateArray[1]."-".$invoiceDateArray[0];
	
	
$sqldelheader="delete from deliverynote where intDeliveryNo=$DeliveryNo and RecordType='$recType'";

	$resultdel =$db->RunQuery($sqldelheader);
	
$sqlheaderinsert="INSERT INTO deliverynote 
				(intDeliveryNo, 
				strInvoiceNo, 
				strExporterID, 
				strCustomerID, 
				strBuyerId, 
				strBankRefNo, 
				strVessel, 
				strFCL, 
				strVoyageNo, 
				dtmVoyageDate, 
				strMode, 
				strCityCode, 
				strTradingCtry, 
				strCtryOfExp, 
				strCtryOfOrigin, 
				strDeliveryTerms, 
				dblTotalInvoiceAmount,
				dblTotalAmount, 
				strCurrency, 
				dblExRate, 
				strBankCode, 
				strPrevDoc, 
				intUserID, 
				strWeight, 
				dblInsurance, 
				dblFreight, 
				dblOther, 
				dtmCreateDate, 
				strOfficeOfEntry, 
				strTermsOfPayMent, 
				strBankBranch, 
				dblPackages, 
				strPackType, 
				strMarks, 
				strLCNO, 
				strTQBNo, 
				strRemarks, 
				intStatus, 
				strEntryNo, 
				strMerchandiser, 
				RecordType, 
				strPlaceOfLoading, 
				strMarksOfPackages, 
				strStyleId, 
				intStatusEmailed, 
				strFormula, 
				strConsigneeRefCode, 
				intForwarder, 
				intWharfClerk, 
				strContainerNo, 
				intFeet, 
				intIOUPrint, 
				strReasonDupIOU, 
				dblCBM, 
				intDocRelease, 
				strAuthorizedBy, 
				strCountOfContainer,
				strPreferenceCode,
				strLicenceNo,
				dtmInvoiceDate
				)
				VALUES
				($DeliveryNo, 
				'$invoice', 
				'$exporterID', 
				'$customerID', 
				'$buyerID', 
				'$bankRefNo', 
				'$vessel', 
				'$fcl', 
				'$voyageNo', 
				'$FormatVoyageDate', 
				'$mode', 
				'$lastConsiCity', 
				'$tradingCountry', 
				'$exCountry', 
				'$originCountry', 
				'$deliveryTerm', 
				'$invoAmount',
				'$FOB', 
				'$currency', 
				'$exRate', 
				'$bank', 
				'$previousDoc', 
				'$UserId', 
				'$weight2', 
				'$Insurance', 
				'$Freight', 
				'$Other', 
				now(), 
				'$officeEntry', 
				'$termsOfPayment', 
				'', 
				'$noOfPackages', 
				'$packageType', 
				'$marks', 
				'$lcNo', 
				'$TQBNo', 
				'', 
				'0', 
				'', 
				'$merchandiser',				 
				'$recType', 
				'$placeOfLoading', 
				'strMarksOfPackages', 
				'', 
				'0', 
				'', 
				'$consigneeRefCode', 
				'$forwaders', 
				'$walfCleark', 
				'$containerNo', 
				'$cboFcl', 
				'0', 
				'0', 
				'$weight1', 
				'0', 
				'$authorizedBy', 
				'$txtFcl',
				'$preferenceCode',
				'$licenceNo',
				'$FormatInvoiceDate');";
	//echo $sqlheaderinsert;
	$result =$db->RunQuery($sqlheaderinsert);
	echo $result;
}
elseif($RequestType=="SaveDeliveryDetails")
{ 
	$totalValue		= $_GET["totalValue"];
	$deliveryNo		= $_GET["deliveryNo"];
	$description	= $_GET["description"];
	$styleID		= $_GET["styleID"];
	$matDetailID	= $_GET["matDetailID"];
	$itemNo			= $_GET["itemNo"];
	$commodityCode	= $_GET["commodityCode"];
	$qty			= $_GET["qty"];
	$noOfPkgs		= $_GET["noOfPkgs"];
	$itemPrice		= $_GET["itemPrice"];
	$grossMass		= $_GET["grossMass"];
	$netMass		= $_GET["netMass"];
	$procCode1		= $_GET["procCode1"];
	$procCode2		= $_GET["procCode2"];
	$itemValue		= $_GET["itemValue"];
	$strUnit		= $_GET["strUnit"];	
	$umoQty1		= $_GET["umoQty1"];
	$umoQty2		= $_GET["umoQty2"];
	$umoQty3		= $_GET["umoQty3"];

$sqlupdate ="update deliverynote set dblTotalAmount='$totalValue' where intDeliveryNo=$deliveryNo";
//echo $sqlupdate;
$result_update=$db->RunQuery($sqlupdate);

$sqldel="Delete from deliverydetails 
		where intDeliveryNo=$deliveryNo 
		AND strItemCode=$matDetailID";
$result_del=$db->RunQuery($sqldel);

$sqldetails="insert into deliverydetails 
	(intDeliveryNo, 
	strStyleNo, 
	strItemCode, 
	intItemNo, 
	strCommodityCode, 
	dblQty, 
	intNoOfPackages, 
	dblItemPrice, 
	dblGrossMass, 
	dblNetMass, 
	strProcCode1, 
	strProcCode2, 
	dblItmValue, 
	strUnit, 
	strUmoQty1,
	strUmoQty2,
	strUmoQty3,	
	strItemDescription)
	values
	($deliveryNo, 
	'$styleID', 
	'$matDetailID', 
	'$itemNo', 
	'$commodityCode', 
	'$qty', 
	'$noOfPkgs', 
	'$itemPrice', 
	'$grossMass', 
	'$netMass', 
	'$procCode1', 
	'$procCode2', 
	'$itemValue', 
	'$strUnit',
	'$umoQty1',
	'$umoQty2',
	'$umoQty3',	
	'$description');";

$result=$db->RunQuery($sqldetails);
echo $result;
}
elseif($RequestType=="SaveIOUHeader")
{
$iouNo				= $_GET["iouNo"];
$deliveryNo			= $_GET["deliveryNo"];
$duplicateReason	= $_GET["duplicateReason"];
$exporterID			= $_GET["exporterID"];
$forwaderID			= $_GET["forwaderID"];
$merchandiser		= $_GET["merchandiser"];
$consignee			= $_GET["consignee"];
$walfCleark			= $_GET["walfCleark"];
$noOfPackages		= $_GET["noOfPackages"];
$vessel				= $_GET["vessel"];
$previousDoc		= $_GET["previousDoc"];
$buyerID			= $_GET["buyerID"];
$invoice			= $_GET["invoice"];
$termsOfPayment		= $_GET["termsOfPayment"];
$lcNo				= $_GET["lcNo"];
$recType			= $_GET["recType"];
$sqliou="insert into tbliouheader 
	(intIOUNo, 
	intDeliveryNo, 
	intIOUPrint, 
	strReasonDupIOU, 
	intExporterID, 
	intForwarder, 
	strMerchandiser, 
	strCustomerID, 
	intWharfClerk, 
	dblPackages, 
	strCBM, 
	strVessel, 
	strPrevDoc, 
	strType, 
	intSettled, 
	strBuyerID, 
	strInvoiceNo, 
	strPaymentTerms, 
	strLCNumber)
	values
	('$iouNo', 
	'$deliveryNo', 
	'0', 
	'$duplicateReason', 
	'$exporterID', 
	'$forwaderID', 
	'$merchandiser', 
	'$consignee', 
	'$walfCleark', 
	'$noOfPackages', 
	'0', 
	'$vessel', 
	'$previousDoc', 
	'$recType', 
	'0', 
	'$buyerID', 
	'$invoice', 
	'$termsOfPayment', 
	'$lcNo');";

$result=$db->RunQuery($sqliou);
echo $result;
}
elseif($RequestType=="SaveIOUDetails")
{
$iouNo		= $_GET["iouNo"];
$expenceID	= $_GET["expenceID"];
$estimate	= $_GET["estimate"];
$actual		= $_GET["actual"];
$invoice	= $_GET["invoice"];
$rowcount	= 0;
$sqlioudetail="select * from tblioudetails
				 where intIOUNo=$iouNo
				 AND intExpensesID=$expenceID;";

$result=$db->RunQuery($sqlioudetail);
$rowcount = mysql_num_rows($result);

	if($rowcount > 0)
	{
		$sqlupdateiou="UPDATE tblioudetails  
						SET dblEstimate='$estimate',
						dblActual= '$actual', 
						dblInvoice='$invoice' 
						WHERE intIOUNo=$iouNo 
						AND intExpensesID=$expenceID;";
		
		$result_updateiou=$db->RunQuery($sqlupdateiou);
	}
	else
	{
		$sqlinsertiou="insert into  tblioudetails 
					(intIOUNo, 
					intExpensesID, 
					dblEstimate, 
					dblActual, 
					dblInvoice)
					values
					($iouNo, 
					$expenceID, 
					'$estimate', 
					'$actual', 
					'$invoice');";
		
		$result_insertiou=$db->RunQuery($sqlinsertiou);
	}
}
elseif($RequestType=="DeleteDetailRow")
{
$deliveryNo		= $_GET["deliveryNo"];
$detailID		= $_GET["detailID"];
$recType		= $_GET["recType"];

$sql_details="delete from 
	deliverydetails 
	where
	intDeliveryNo = '$deliveryNo' 
	and strItemCode = '$detailID';";
$result_details=$db->RunQuery($sql_details);

$sqldel_tax="delete from cusdectax where intDeliveryNo=$deliveryNo AND intItemCode ='$detailID' AND RecordType = '$recType' ;";
$result_tax=$db->RunQuery($sqldel_tax);
}
elseif($RequestType=="CalculateTax")
{
	$deliveryNo		= $_GET["deliveryNo"];
	$value			= round($_GET["value"],0);	
	$hsCode			= $_GET["hsCode"];
	$itemID			= $_GET["itemID"];
	$recType		= $_GET["recType"];
	$netMass		= round($_GET["netMass"],0);
	$fcl			= $_GET["fcl"];
	$noOfContainer	= $_GET["noOfContainer"];
	$umoQty2		= $_GET["umoQty2"];
	$umoQty3		= $_GET["umoQty3"];
	$noRows			= $_GET["noRows"];
	$umoQty			= ($umoQty2=='' ? $umoQty3:$umoQty2);
	$umoQtyArray 	= explode(' ',$umoQty);
	
	$pub_CIDTaxAmount	= 0;
	$pub_SURTaxAmount	= 0;
	$pub_PALTaxAmount	= 0;	
	$pub_EICTaxAmount	= 0;
	$pub_XIDTaxAmount	= 0;
	
$sqldeltax="delete from cusdectax 
			where intDeliveryNo=$deliveryNo AND intItemCode in('$itemID',-10) AND RecordType='$recType'";
$result_delTax=$db->RunQuery($sqldeltax);
	
$sqltax="select ".	 
		"strTaxCode, ".
		"intPosition, ".
		"dblPercentage, ".
		"strRemarks, ".
		"intMP, ".
		"strTaxBase, ".
		"dblOptRates ".
		"from ".
		"commoditycodes ".
		"where strCommodityCode='$hsCode' ".		
		"Order By intPosition";

$result_tax=$db->RunQuery($sqltax);
	while($row_tax=mysql_fetch_array($result_tax))
	{
		$taxCode		= $row_tax['strTaxCode'];
		$position		= $row_tax['intPosition'];
		$percentage		= $row_tax['dblPercentage'];
		$taxBase		= $row_tax['strTaxBase'];
		$MP				= $row_tax["intMP"];
		$optionalRate	= $row_tax["dblOptRates"];
		$exBase			= explode('%',$taxBase);
		$insertTaxBase	= 0;
		$insertAmount	= 0;

if($recType=='IM')
{		
//Start - Calculate CID 
		if(trim($taxCode)=="CID")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{				
					$insertTaxBase		= $value;
					$insertAmount		= 0;
				}
				else
				{	
					$insertTaxBase		= $value;
					$insertAmount		= ($value/100) * $percentage;
					$pub_CIDTaxAmount	= $insertAmount;
					$insertPercentage	= $percentage.'%';					
				}
			}		
		}
		
//End - Calculate CID
//Start - Calculate SUR 
	 elseif(trim($taxCode)=="SUR")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase 		= $value;
					$insertAmount		= 0;
					$pub_SURTaxAmount	= $insertAmount;
				}
				else
				{
					$insertTaxBase		= $value;
					$insertAmount		= ($insertTaxBase/100) * $percentage;
					$pub_SURTaxAmount	= $insertAmount;
					$insertPercentage	= $percentage.'%';
				}
			}
			else
			{
				if(trim($taxBase)=="CID")
				{
					$insertTaxBase 		= $pub_CIDTaxAmount;
					$insertAmount		= ($insertTaxBase /100) * $percentage;
					$pub_SURTaxAmount 	= $insertAmount;
					$insertPercentage	= $percentage.'%';
				}
			}
		}
//End - Calculate SUR
//Start - Calculate VAT and NBT
		elseif((trim($taxCode)=="VAT") || (trim($taxCode)=="NBT"))
		{
			if($MP==0)
			{
				if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
				{
					if(trim(substr($taxBase,0,1))=="0")
					{
						$insertTaxBase 	= ($value * $exBase[0])/100;
						$insertAmount	= 0;
					}
					else
					{
						$insertTaxBase 	= ($value * $exBase[0])/100;
						$insertAmount	= ($insertTaxBase/100) * $percentage;
						$insertPercentage	= $percentage.'%';
					}
				}
			}
			elseif($MP==1)
			{
				if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
				{
					if(trim(substr($taxBase,0,1))=="0")
					{
						$insertTaxBase 	= ($pub_PALTaxAmount + (($value * 107)/100));
						$insertAmount	= 0;
					}
					else
					{
						$insertTaxBase 	= ($pub_PALTaxAmount + (($value * 110)/100));
						$insertAmount	= ($insertTaxBase/100) * $percentage;
						$insertPercentage	= $percentage.'%';
					}
				}
			}
		}
//End - Calculate VAT and NBT
//Start - Calculate PAL
		elseif(trim($taxCode)=="PAL")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase		= $value;
					$insertAmount		= 0;
					$pub_PALTaxAmount 	= $insertAmount;
				}
				else
				{
					$insertTaxBase		= $value;
					$insertAmount		= (($value/100) * $percentage);
					$pub_PALTaxAmount 	= $insertAmount;
					$insertPercentage	= $percentage.'%';
				}
			}
		}
//End - Calculate PAL
//Start - Calculate EIC
		elseif((trim($taxCode)=="EIC") || (trim($taxCode)=="CESS"))
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase		= $value;
					$insertAmount		= 0;
					$pub_PALTaxAmount 	= $insertAmount;
				}
				else
				{
					$insertTaxBase 		= ($value * $exBase[0])/100;					
					$insertAmount		= (($insertTaxBase/100) * $percentage);
					$insertPercentage	= $percentage.'%';					
					//------------
					$totEic  			= $netMass * $optionalRate;
					if($insertAmount<$totEic)
					{
						$insertTaxBase		= $netMass;
						$percentage			= $optionalRate;
						$insertAmount		= $totEic;
						$insertPercentage	= $percentage;
					}	
					$pub_EICTaxAmount 	= $insertAmount;
					//-------------
					//-------------
				}
			}
		}
//End - Calculate EIC
//Start - Calculate - SRL
		elseif(trim($taxCode)=="SRL")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase		= 0;
					$insertAmount		= 0;					
				}
				else
				{
					$insertTaxBase		= $pub_CIDTaxAmount+$pub_SURTaxAmount;
					$insertAmount		= (($insertTaxBase * $percentage)/100);	
					$insertPercentage	= $percentage.'%';			
				}
			}
		}
//End - Calculate - SRL
//Start - Calculate   - XID		
		elseif(trim($taxCode)=="XID")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase		= 0;
					$insertAmount		= 0;					
				}
				else
				{
					$insertTaxBase		= $umoQtyArray[0];
					$insertAmount		= (($insertTaxBase * $percentage)/100);
					$insertPercentage	= $percentage.'%'; 			
				}					 
			}
		}
//End - Calculate   - XID	
}
//--------------------------------------------------------------------------------------------------
elseif($recType=='IMGEN')
{
$MP		= 1;
//Start - Calculate GEN - CID 
		if(trim($taxCode)=="CID")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{				
					$insertTaxBase		= $value;
					$insertAmount		= 0;
				}
				else
				{	
					$insertTaxBase		= $value;
					$insertAmount		= ($value/100) * $percentage;
					$pub_CIDTaxAmount	= $insertAmount;
					$insertPercentage	= $percentage.'%';						
				}
			}		
		}
//End - Calculate GEN - CID
//Start - Calculate GEN - PAL
		elseif(trim($taxCode)=="PAL")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase		= $value;
					$insertAmount		= 0;
					$pub_PALTaxAmount 	= $insertAmount;
				}
				else
				{
					$insertTaxBase		= $value;
					$insertAmount		= (($value/100) * $percentage);
					$pub_PALTaxAmount 	= $insertAmount;
					$insertPercentage	= $percentage.'%';						
				}
			}
		}
//End - Calculate GEN - PAL
//Start - Calculate GEN - SUR 
	 elseif(trim($taxCode)=="SUR")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase 		= $value;
					$insertAmount		= ($insertTaxBase/100) * $percentage;
					$pub_SURTaxAmount	= $insertAmount;
					$insertPercentage	= $percentage.'%';	
				}
				else
				{
					$insertTaxBase		= $value;					
					$insertAmount		= ($insertTaxBase/100) * $percentage;
					$pub_SURTaxAmount	= $insertAmount;
					$insertPercentage	= $percentage.'%';	
				}
			}
			else
			{
				if(trim($taxBase)=="CID")
				{
					$insertTaxBase 		= $pub_CIDTaxAmount;
					$insertAmount		= ($percentage/100) * $insertTaxBase;
					$pub_SURTaxAmount 	= $insertAmount;
					$insertPercentage	= $percentage.'%';
				}
			}
							
		}
//End - Calculate GEN - SUR
//Start - Calculate GEN - VAT and NBT
		elseif((trim($taxCode)=="VAT") || (trim($taxCode)=="NBT"))
		{
			if($MP<>"")
			{
				if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
				{					
					$insertTaxBase 		= ($pub_EICTaxAmount + $pub_CIDTaxAmount + $pub_PALTaxAmount + $pub_SURTaxAmount + $pub_XIDTaxAmount + (($value * 110)/100));
					$insertAmount		= ($insertTaxBase/100) * $percentage;
					$insertPercentage	= $percentage.'%';			
				}
			}
		}
//End - Calculate GEN - VAT and NBT
//Start - Calculate GEN - EIC
		elseif((trim($taxCode)=="EIC") || (trim($taxCode)=="CESS"))
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase		= $value;
					$insertAmount		= 0;
					$pub_EICTaxAmount 	= $insertAmount;
				}
				else
				{				
					$insertTaxBase 		= ($value * $exBase[0])/100;					
					$insertAmount		= (($insertTaxBase/100) * $percentage);
					$insertPercentage	= $percentage.'%';					
					//------------
					$totEic  			= $netMass * $optionalRate;
					if($insertAmount<$totEic)
					{
						$insertTaxBase		= $netMass;
						$percentage			= $optionalRate;
						$insertAmount		= $totEic;
						$insertPercentage	= $percentage;
					}	
					$pub_EICTaxAmount 	= $insertAmount;
					//------------
				}
			}
		}
//End - Calculate GEN - EIC
//Start - Calculate GEN - SRL
		elseif(trim($taxCode)=="SRL")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase		= 0;
					$insertAmount		= 0;					
				}
				else
				{
					$insertTaxBase		= $pub_CIDTaxAmount+$pub_SURTaxAmount+$pub_XIDTaxAmount;
					$insertAmount		= (($insertTaxBase * $percentage)/100);
					$insertPercentage	= $percentage.'%'; 			
				}
			}
		}
//End - Calculate GEN - SRL
//Start - Calculate GEN - XID		
		elseif(trim($taxCode)=="XID")
		{
			if(trim(substr($taxBase,strlen($taxBase)-1,strlen($taxBase)))=="%")
			{
				if(trim(substr($taxBase,0,1))=="0")
				{
					$insertTaxBase		= 0;
					$insertAmount		= 0;					
				}
				else
				{
					$insertTaxBase		= $umoQtyArray[0];
					$insertAmount		= (($insertTaxBase * $percentage)/100);
					$insertPercentage	= $percentage.'%'; 			
				}
					$pub_XIDTaxAmount 	= $insertAmount;
			}
		}
//End - Calculate GEN - XID	

}

$inserttax="insert into cusdectax ". 
			"(intDeliveryNo, ".
			"intItemCode, ".
			"strTaxCode, ".
			"intPosition, ".
			"dblTaxBase, ".
			"dblRate, ".
			"dblAmount, ".
			"intMP, ".
			"RecordType) ".
			"values ".
			"($deliveryNo, ".
			"'$itemID', ".
			"'$taxCode', ".
			"'$position', ".
			"'$insertTaxBase', ".
			"'$insertPercentage', ".
			"'$insertAmount', ".
			"$MP, ".
			"'$recType');";
	
$result_insertTax=$db->RunQuery($inserttax);
	}
	echo $result_insertTax;
	
	if($recType=='IMGEN')
	{
		if($noRows>2){
			$itemID = -10;//this item code assign because in report when item detail more than 1 "COM/EX/SEAL" add only in tax summary		
			}
	
	$sql_gentax="select * from importgenaralcommontax where intStatus=1";
	$result_gentax	= $db->RunQuery($sql_gentax);
		while($row_gentax=mysql_fetch_array($result_gentax))
		{
			$taxCode				= $row_gentax["strTaxCode"];
			$position				= 12;
			$insertTaxBase	 		= "0";
			$insertPercentage		= "0";
			$insertAmount	 		= $row_gentax["dblTaxAmount"];
			$containerCharge	 	= $row_gentax["dblContainerCharge"];
			$MP						= 1;				
			$fclAmount				=  $row_gentax["dblLcl"];		
			$containerAmount		= $containerCharge*$noOfContainer;
			$insertAmount			= $fclAmount+$containerAmount;
			
			$insertgentax="insert into cusdectax ". 
			"(intDeliveryNo, ".
			"intItemCode, ".
			"strTaxCode, ".
			"intPosition, ".
			"dblTaxBase, ".
			"dblRate, ".
			"dblAmount, ".
			"intMP, ".
			"RecordType) ".
			"values ".
			"($deliveryNo, ".
			"'$itemID', ".
			"'$taxCode', ".
			"'$position', ".
			"'$insertTaxBase', ".
			"'$insertPercentage', ".
			"'$insertAmount', ".
			"$MP, ".
			"'$recType');";
		$result_insertgenTax=$db->RunQuery($insertgentax);
		}
	}

}
elseif($RequestType=="DeleteIOURow")
{
$expenceID	= $_GET["expenceID"];
$iouNo		= $_GET["iouNo"];

$sqldeliou="delete from tblioudetails where intIOUNo='$iouNo' AND intExpensesID='$expenceID'";
$result_iou=$db->RunQuery($sqldeliou);
}
elseif($RequestType=="SaveTaxPoPupDetails")
{

$deliveryNo		= $_GET["deliveryNo"];
$recType		= $_GET["recType"];
$matdetaiID		= $_GET["matdetaiID"];
$taxPosition	= $_GET["taxPosition"];
$taxType		= $_GET["taxType"];
$taxBase		= $_GET["taxBase"];
$taxRate		= $_GET["taxRate"];
$taxAmount		= $_GET["taxAmount"];
$taxMP			= $_GET["taxMP"];

$sql="select strTaxCode from cusdectax where intDeliveryNo='$deliveryNo' and RecordType='$recType' and strTaxCode='$taxType' and intItemCode='$matdetaiID'";

$result=$db->RunQuery($sql);
$rowcount = mysql_num_rows($result);

	if($rowcount>0){
	
		$sql_update="update cusdectax set intPosition='$taxPosition',
					dblTaxBase ='$taxBase',
					dblRate ='$taxRate',
					dblAmount='$taxAmount',
					intMP ='$taxMP'
					where intDeliveryNo='$deliveryNo' 
					and RecordType='$recType' 
					and strTaxCode='$taxType'
					and intItemCode='$matdetaiID'";
					
		$result_update=$db->RunQuery($sql_update);
	}
	else{
		$sql_insert="insert into cusdectax 
				(intDeliveryNo, 
				intItemCode, 
				strTaxCode, 
				intPosition, 
				dblTaxBase, 
				dblRate, 
				dblAmount, 
				intMP, 
				RecordType)
				values
				('$deliveryNo', 
				'$matdetaiID', 
				'$taxType', 
				'$taxPosition', 
				'$taxBase', 
				'$taxRate', 
				'$taxAmount', 
				'$taxMP', 
				'$recType');";
		$result_insert=$db->RunQuery($sql_insert);
	}
}
elseif($RequestType=="DeleteTaxPopUpItem")
{
	$deliveryNo			= $_GET["deliveryNo"];
	$matdetaiID			= $_GET["matdetaiID"];
	$recType			= $_GET["recType"];
	$taxType			= $_GET["taxType"];
	
$sqldelpopuptax="delete from cusdectax where intDeliveryNo='$deliveryNo' 
and intItemCode='$matdetaiID'
and strTaxCode='$taxType'
and RecordType ='$recType'";
echo $sqldelpopuptax;
$result_delpopuptax=$db->RunQuery($sqldelpopuptax);
}
elseif($RequestType=="SaveMp")
{

$deliveryNo		= $_GET["deliveryNo"];
$recType		= $_GET["recType"];
$matdetaiID		= $_GET["matdetaiID"];
$taxType		= $_GET["taxType"];
$taxMP			= $_GET["taxMP"];

		$sql_update="update cusdectax 
					set intMP ='$taxMP'
					where intDeliveryNo='$deliveryNo' 
					and RecordType='$recType' 
					and strTaxCode='$taxType'
					and intItemCode='$matdetaiID'";
				
		$result_update=$db->RunQuery($sql_update);
}
?>