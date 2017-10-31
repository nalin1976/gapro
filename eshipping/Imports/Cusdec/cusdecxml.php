<?php	
	session_start();
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	include "../../Connector.php";
	$RequestType	= $_GET["RequestType"];
	$CompanyId  	= $_SESSION["FactoryID"];
	$userId			= $_SESSION["UserID"];
if($RequestType=="LoadDeliveryNo")
{		
    $No=0;
	$ResponseXML .="<LoadNo>\n";
	
		$Sql="select intCompanyID,dblImportDeliveryNo from syscontrol where intCompanyID='$CompanyId'";
		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblImportDeliveryNo"];
					$NextNo=$No+1;
					$sqlUpdate="UPDATE syscontrol SET dblImportDeliveryNo='$NextNo' WHERE intCompanyID='$CompanyId';";				
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
elseif($RequestType=="GetNewIOUNo")
{		
    $No=0;
	$ResponseXML .="<GetNewIOUNo>\n";
	
		$Sql="select intCompanyID,dblImportIOUNo from syscontrol where intCompanyID='$CompanyId'";
		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblImportIOUNo"];
					$NextNo=$No+1;
					$sqlUpdate="UPDATE syscontrol SET dblImportIOUNo='$NextNo' WHERE intCompanyID='$CompanyId';";				
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</GetNewIOUNo>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadExpenceType")
{
	$deliveryNo	= $_GET["deliveryNo"];
	$ResponseXML .="<LoadExpenceType>\n";
	
$booiou = true;	
$sqliou="select ID.intIOUNo,
		intExpensesID,
		(select strDescription from expensestype ET where ET.intExpensesID=ID.intExpensesID)AS expenceType,
		dblEstimate,
		dblActual,
		dblInvoice 
		from tblioudetails ID
		Inner Join tbliouheader IH ON IH.intIOUNo=ID.intIOUNo
		where IH.intDeliveryNo=$deliveryNo";
		//echo $sqliou;
$result_iou=$db->RunQuery($sqliou);
	while($row_iou=mysql_fetch_array($result_iou))
	{
		$booiou = false;
			$ResponseXML .= "<IOUNo><![CDATA[" . $row_iou["intIOUNo"]  . "]]></IOUNo>\n";
			$ResponseXML .= "<ExpensesID><![CDATA[" . $row_iou["intExpensesID"]  . "]]></ExpensesID>\n";
			$ResponseXML .= "<ExpenceType><![CDATA[" . $row_iou["expenceType"]  . "]]></ExpenceType>\n";
			$ResponseXML .= "<Estimate><![CDATA[" . $row_iou["dblEstimate"]  . "]]></Estimate>\n";
			$ResponseXML .= "<Actual><![CDATA[" . $row_iou["dblActual"]  . "]]></Actual>\n";
			$ResponseXML .= "<Invoice><![CDATA[" . $row_iou["dblInvoice"]  . "]]></Invoice>\n";
	}
	if($booiou)
	{
	$sql="select * from expensestype where booDeleted=0 Order BY strExpencesType";
	//echo $sql;
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<IOUNo><![CDATA[0]]></IOUNo>\n";
			$ResponseXML .= "<ExpensesID><![CDATA[" . $row["intExpensesID"]  . "]]></ExpensesID>\n";
			$ResponseXML .= "<ExpenceType><![CDATA[" . $row["strDescription"]  . "]]></ExpenceType>\n";
			$ResponseXML .= "<Estimate><![CDATA[]]></Estimate>\n";
			$ResponseXML .= "<Actual><![CDATA[]]></Actual>\n";
			$ResponseXML .= "<Invoice><![CDATA[]]></Invoice>\n";
		}
	}
	$ResponseXML .="</LoadExpenceType>";
	echo $ResponseXML;
}
elseif($RequestType=="SearchDelivery")
{
	$deliveryNo		= $_GET["deliveryNo"];
	$invoiceNo		= $_GET["invoiceNo"];
	$preDocs		= $_GET["preDocs"];
	$entryNo		= $_GET["entryNo"];
	$exporter		= $_GET["exporter"];
	$consignee		= $_GET["consignee"];
	$invoiceValue	= $_GET["invoiceValue"];
	$containerNo	= $_GET["containerNo"];
	
	$ResponseXML="";
	$ResponseXML .="<SearchDelivery>\n";
$sql="";
$sql="select DH.intDeliveryNo,
		DH.strInvoiceNo,
		date(DH.dtmCreateDate)AS dtmCreateDate,
		(select strName from suppliers SU where DH.strExporterID=SU.strSupplierId)AS Exporter,
		(select strName from customers CU where DH.strCustomerID=CU.strCustomerID)AS Customer,
		DH.dblTotalAmount,
		DH.strPrevDoc 
		from deliverynote DH
		where DH.intDeliveryNo<>0";
	if($deliveryNo!="")
		$sql .=" AND DH.intDeliveryNo = $deliveryNo";
	if($invoiceNo!="")
		$sql .=" AND DH.strInvoiceNo = '$invoiceNo'";
	if($preDocs!="")
		$sql .=" AND DH.strPrevDoc ='$preDocs'";
	if($entryNo!="")
		$sql .=" AND DH.strOfficeOfEntry ='$entryNo'";
	if($exporter!="")
		$sql .=" AND DH.strExporterID='$exporter'";
	if($consignee!="")
		$sql .=" AND DH.strCustomerID='$consignee'";	
	if($invoiceValue!="")
		$sql .=" AND DH.dblTotalAmount='$invoiceValue'";
	if($containerNo!="")
		$sql .=" AND DH.strContainerNo='$containerNo'";
	//echo $sql;
$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<DeliveryNo><![CDATA[" . $row["intDeliveryNo"] ."]]></DeliveryNo>\n";
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"] ."]]></InvoiceNo>\n";
		$ResponseXML .= "<CreateDate><![CDATA[" . $row["dtmCreateDate"] ."]]></CreateDate>\n";
		$ResponseXML .= "<Exporter><![CDATA[" . $row["Exporter"] ."]]></Exporter>\n";
		$ResponseXML .= "<Customer><![CDATA[" . $row["Customer"] ."]]></Customer>\n";
		$ResponseXML .= "<TotalAmount><![CDATA[" . $row["dblTotalAmount"] ."]]></TotalAmount>\n";
		$ResponseXML .= "<PrevDoc><![CDATA[" . $row["strPrevDoc"] ."]]></PrevDoc>\n";
	}
	$ResponseXML .="</SearchDelivery>";
	echo $ResponseXML;
}
elseif($RequestType=="loadPopUpDeliveryNoToPage")
{
$recType		= $_GET["recType"];
$deliveryNo		= $_GET["deliveryNo"];

	$ResponseXML="";
	$ResponseXML .="<loadPopUpDeliveryNoToPage>\n";
$sql="";
$sql="select * from deliverynote where intDeliveryNo=$deliveryNo";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<DeliveryNo><![CDATA[" . $row["intDeliveryNo"] ."]]></DeliveryNo>\n";
	$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"] ."]]></InvoiceNo>\n";
	$ResponseXML .= "<Mode><![CDATA[" . $row["strMode"] ."]]></Mode>\n";
	$ResponseXML .= "<ExporterID><![CDATA[" . $row["strExporterID"] ."]]></ExporterID>\n";
	$ResponseXML .= "<CustomerID><![CDATA[" . $row["strCustomerID"] ."]]></CustomerID>\n";
	$ResponseXML .= "<CtryOfOrigin><![CDATA[" . $row["strCtryOfOrigin"] ."]]></CtryOfOrigin>\n";
	$ResponseXML .= "<ConsigneeRefCode><![CDATA[" . $row["strConsigneeRefCode"] ."]]></ConsigneeRefCode>\n";
	$ResponseXML .= "<CtryOfExp><![CDATA[" . $row["strCtryOfExp"] ."]]></CtryOfExp>\n";
	$ResponseXML .= "<CityCode><![CDATA[" . $row["strCityCode"] ."]]></CityCode>\n";
	$ResponseXML .= "<TradingCtry><![CDATA[" . $row["strTradingCtry"] ."]]></TradingCtry>\n";
	$ResponseXML .= "<Vessel><![CDATA[" . $row["strVessel"] ."]]></Vessel>\n";
	$ResponseXML .= "<DeliveryTerms><![CDATA[" . $row["strDeliveryTerms"] ."]]></DeliveryTerms>\n";
	$ResponseXML .= "<VoyageNo><![CDATA[" . $row["strVoyageNo"] ."]]></VoyageNo>\n";
	$ResponseXML .= "<ContainerNo><![CDATA[" . $row["strContainerNo"] ."]]></ContainerNo>\n";
	$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"] ."]]></Currency>\n";
	$ResponseXML .= "<ExRate><![CDATA[" . $row["dblExRate"] ."]]></ExRate>\n";
	$ResponseXML .= "<TotalInvoiceAmount><![CDATA[" . round($row["dblTotalInvoiceAmount"],2) ."]]></TotalInvoiceAmount>\n";
	$ResponseXML .= "<TotalAmount><![CDATA[" . round($row["dblTotalAmount"],2) ."]]></TotalAmount>\n";
	$ResponseXML .= "<BankCode><![CDATA[" . $row["strBankCode"] ."]]></BankCode>\n";
	$ResponseXML .= "<PrevDoc><![CDATA[" . $row["strPrevDoc"] ."]]></PrevDoc>\n";
	$ResponseXML .= "<LCNO><![CDATA[" . $row["strLCNO"] ."]]></LCNO>\n";
	$ResponseXML .= "<BankRefNo><![CDATA[" . $row["strBankRefNo"] ."]]></BankRefNo>\n";
	$ResponseXML .= "<TermsOfPayMent><![CDATA[" . $row["strTermsOfPayMent"] ."]]></TermsOfPayMent>\n";
	$ResponseXML .= "<Weight1><![CDATA[" . $row["dblCBM"] ."]]></Weight1>\n";
	$ResponseXML .= "<Weight2><![CDATA[" . $row["strWeight"] ."]]></Weight2>\n";
	$ResponseXML .= "<OfficeOfEntry><![CDATA[" . $row["strOfficeOfEntry"] ."]]></OfficeOfEntry>\n";
	$ResponseXML .= "<BuyerId><![CDATA[" . $row["strBuyerId"] ."]]></BuyerId>\n";
	$ResponseXML .= "<TQBNo><![CDATA[" . $row["strTQBNo"] ."]]></TQBNo>\n";
	$ResponseXML .= "<AuthorizedBy><![CDATA[" . $row["strAuthorizedBy"] ."]]></AuthorizedBy>\n";
	$ResponseXML .= "<Packages><![CDATA[" . $row["dblPackages"] ."]]></Packages>\n";
	$ResponseXML .= "<Marks><![CDATA[" . $row["strMarks"] ."]]></Marks>\n";
	$ResponseXML .= "<Formula><![CDATA[" . $row["strFormula"] ."]]></Formula>\n";
	$ResponseXML .= "<PackType><![CDATA[" . $row["strPackType"] ."]]></PackType>\n";
	$ResponseXML .= "<Insurance><![CDATA[" . round($row["dblInsurance"],2) ."]]></Insurance>\n";
	$ResponseXML .= "<Freight><![CDATA[" . round($row["dblFreight"],2) ."]]></Freight>\n";
	$ResponseXML .= "<Other><![CDATA[" . round($row["dblOther"],2) ."]]></Other>\n";
	$ResponseXML .= "<Forwarder><![CDATA[" . $row["intForwarder"] ."]]></Forwarder>\n";
	$ResponseXML .= "<Merchandiser><![CDATA[" . $row["strMerchandiser"] ."]]></Merchandiser>\n";
	$ResponseXML .= "<WharfClerk><![CDATA[" . $row["intWharfClerk"] ."]]></WharfClerk>\n";
		$VoyageDate =substr($row["dtmVoyageDate"],0,10);
						$VoyageNoArray=explode('-',$VoyageDate);
						$formatedVoyageDate=$VoyageNoArray[2]."/".$VoyageNoArray[1]."/".$VoyageNoArray[0];
					$ResponseXML .= "<formatedVoyageDate><![CDATA[" . $formatedVoyageDate . "]]></formatedVoyageDate>\n";
	$ResponseXML .= "<Fcl><![CDATA[" . $row["strFCL"] ."]]></Fcl>\n";
	$ResponseXML .= "<Feet><![CDATA[" . $row["intFeet"] ."]]></Feet>\n";
	$ResponseXML .= "<CountOfContainer><![CDATA[" . $row["strCountOfContainer"] ."]]></CountOfContainer>\n";
	$ResponseXML .= "<PreferenceCode><![CDATA[" . $row["strPreferenceCode"] ."]]></PreferenceCode>\n";
	$ResponseXML .= "<LicenceNo><![CDATA[" . $row["strLicenceNo"] ."]]></LicenceNo>\n";
	$ResponseXML .= "<PlaceOfLoading><![CDATA[" . $row["strPlaceOfLoading"] ."]]></PlaceOfLoading>\n";
			$invoiceDate =substr($row["dtmInvoiceDate"],0,10);
				if($invoiceDate==""){
					$formatedInvoiceDate = date("d/m/Y");
				}else{
						$invoiceNoArray=explode('-',$invoiceDate);
						$formatedInvoiceDate=$invoiceNoArray[2]."/".$invoiceNoArray[1]."/".$invoiceNoArray[0];
						}
					$ResponseXML .= "<formatedInvoiceDate><![CDATA[" . $formatedInvoiceDate . "]]></formatedInvoiceDate>\n";
}
	$ResponseXML .="</loadPopUpDeliveryNoToPage>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadCusdecDetails")
{
$deliveryNo		= $_GET["deliveryNo"];
//$ResponseXML = "";
$ResponseXML .= "<LoadCusdecDetails>\n";

$sql="";
$sql="select * from deliverydetails DD where intDeliveryNo=$deliveryNo 
 Order By intItemNo";
 
$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyleNo"] ."]]></StyleNo>\n";
		$ResponseXML .= "<ItemCode><![CDATA[" . $row["strItemCode"] ."]]></ItemCode>\n";
		$ResponseXML .= "<IntItemNo><![CDATA[" . $row["intItemNo"] ."]]></IntItemNo>\n";
		$ResponseXML .= "<CommodityCode><![CDATA[" . $row["strCommodityCode"] ."]]></CommodityCode>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"] ."]]></dblQty>\n";
		$ResponseXML .= "<NoOfPackages><![CDATA[" . $row["intNoOfPackages"] ."]]></NoOfPackages>\n";
		$ResponseXML .= "<ItemPrice><![CDATA[" . $row["dblItemPrice"] ."]]></ItemPrice>\n";
		$ResponseXML .= "<GrossMass><![CDATA[" . $row["dblGrossMass"] ."]]></GrossMass>\n";
		$ResponseXML .= "<NetMass><![CDATA[" . $row["dblNetMass"] ."]]></NetMass>\n";
		$ResponseXML .= "<ProcCode1><![CDATA[" . $row["strProcCode1"] ."]]></ProcCode1>\n";
		$ResponseXML .= "<ProcCode2><![CDATA[" . $row["strProcCode2"] ."]]></ProcCode2>\n";
		$ResponseXML .= "<ItmValue><![CDATA[" . $row["dblItmValue"] ."]]></ItmValue>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] ."]]></Unit>\n";
		$ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"] ."]]></ItemName>\n";
		$ResponseXML .= "<UmoQty1><![CDATA[" . $row["strUmoQty1"] ."]]></UmoQty1>\n";
		$ResponseXML .= "<UmoQty2><![CDATA[" . $row["strUmoQty2"] ."]]></UmoQty2>\n";
		$ResponseXML .= "<UmoQty3><![CDATA[" . $row["strUmoQty3"] ."]]></UmoQty3>\n";
	}

$ResponseXML .= "</LoadCusdecDetails>";
echo $ResponseXML;
}
elseif($RequestType=="LoadPopUpDeliveryNo")
{
$recType		= $_GET["recType"];
$ResponseXML = "";
$ResponseXML .= "<LoadPopUpDeliveryNo>\n";
$sqlpopup="select distinct intDeliveryNo from deliverynote where intStatus=0  and RecordType='$recType'order By intDeliveryNo DESC";
$result=$db->RunQuery($sqlpopup);
	$ResponseXML .= "<option value=\"".""."\">"."select one"."</option>\n";
while($row=mysql_fetch_array($result))
{	
	$ResponseXML .= "<option value=\"".$row["intDeliveryNo"]."\">".$row["intDeliveryNo"]."</option>\n";
}
$ResponseXML .= "</LoadPopUpDeliveryNo>";
echo $ResponseXML;
}
elseif($RequestType=="SaveCusdecDetailsValidate")
{
$deliveryNo		= $_GET["deliveryNo"];
$validateCount	= $_GET["validateCount"];

$ResponseXML ="";
$ResponseXML .="<SaveCusdecDetailsValidate>\n";

$SQLDetail="SELECT COUNT(intDeliveryNo) AS DetailsRecCount FROM deliverydetails where intDeliveryNo=$deliveryNo";

$resultDetail=$db->RunQuery($SQLDetail);
	
		while($row =mysql_fetch_array($resultDetail))
		{
			$recCountDetails=$row["DetailsRecCount"];
			
				if($recCountDetails==$validateCount)
				{
					$ResponseXML .= "<recCountDetails><![CDATA[TRUE]]></recCountDetails>\n";
				}
				else
				{
					$ResponseXML .= "<recCountDetails><![CDATA[FALSE]]></recCountDetails>\n";
				}
		}
$ResponseXML .="</SaveCusdecDetailsValidate>";
echo $ResponseXML;
}
elseif($RequestType=="SaveIOUValidate")
{
$iouNo					= $_GET["iouNo"];
$validateDetailCount	= $_GET["validateIOUCount"];
$recType				= $_GET["recType"];

$ResponseXML ="";
$ResponseXML .="<SaveIOUValidate>\n";

$sqlheader="SELECT COUNT(intIOUNo) AS HeaderRecCount FROM tbliouheader where intIOUNo=$iouNo  AND strType='$recType'";

$result_header=$db->RunQuery($sqlheader);
	
		while($row_header =mysql_fetch_array($result_header))
		{
			$recCountIouHeader=$row_header["HeaderRecCount"];
			
				if($recCountIouHeader>0)
				{
					$ResponseXML .= "<recCountIouHeader><![CDATA[TRUE]]></recCountIouHeader>\n";
				}
				else
				{
					$ResponseXML .= "<recCountIouHeader><![CDATA[FALSE]]></recCountIouHeader>\n";
				}
		}
		
$sqldetails="SELECT COUNT(intIOUNo) AS DetailsRecCount FROM tblioudetails where intIOUNo=$iouNo";

$result_details=$db->RunQuery($sqldetails);
	
		while($row_details =mysql_fetch_array($result_details))
		{
			$recCountIouDetails=$row_details["DetailsRecCount"];
			
				if($validateDetailCount==$recCountIouDetails)
				{
					$ResponseXML .= "<recCountIouDetails><![CDATA[TRUE]]></recCountIouDetails>\n";
				}
				else
				{
					$ResponseXML .= "<recCountIouDetails><![CDATA[FALSE]]></recCountIouDetails>\n";
				}
		}
$ResponseXML .="</SaveIOUValidate>";
echo $ResponseXML;
}
elseif($RequestType=="CancelCusdec")
{
$deliveryNo	= $_GET["deliveryNo"];
$sql="update deliverynote set intStatus=10 where intDeliveryNo=$deliveryNo;";
$result=$db->RunQuery($sql);

	echo $result;
}
elseif($RequestType=="SaveCalculateTaxValidate")
{
$deliveryNo			= $_GET["deliveryNo"];
$taxValidateCount	= $_GET["taxValidateCount"];
$recType			= $_GET["recType"]; 

$ResponseXML ="";
$ResponseXML .="<SaveCalculateTaxValidate>\n";
$sql="";
$sql="SELECT COUNT(intDeliveryNo) AS taxRecCount FROM cusdectax ".
	"where intDeliveryNo=$deliveryNo AND RecordType='$recType'";

$result=$db->RunQuery($sql);
	
		while($row =mysql_fetch_array($result))
		{
			$recTaxCount=$row["taxRecCount"];
			
				if($recTaxCount<>0)
				{
					$ResponseXML .= "<recTaxCount><![CDATA[TRUE]]></recTaxCount>\n";
				}
				else
				{
					$ResponseXML .= "<recTaxCount><![CDATA[FALSE]]></recTaxCount>\n";
				}
		}
$ResponseXML .="</SaveCalculateTaxValidate>";
echo $ResponseXML;
}
elseif($RequestType=="FilterItemDescription")
{
$popUpItemlike	= $_GET["popUpItemlike"];
$popUpHslike	= $_GET["popUpHslike"];

$ResponseXML ="";
$ResponseXML .= "<FilterItemDescription>\n";
$sql="";
$sql="select strItemCode, ".
	"strDescription, ".
	"strCommodityCode, ".
	"strUnit ".
	"from item ".
	"where strCommodityCode <>'' ";
if($popUpItemlike!="")
	$sql .= "and strDescription like trim('%$popUpItemlike%') ";
if($popUpHslike!="")
	$sql .= " and strCommodityCode like trim('$popUpHslike%')";
	
	$sql .= "Order By strDescription";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<ItemCode><![CDATA[" . $row["strItemCode"] ."]]></ItemCode>\n";
	$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"] ."]]></Description>\n";
	$ResponseXML .= "<CommodityCode><![CDATA[" . $row["strCommodityCode"] ."]]></CommodityCode>\n";
	$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] ."]]></Unit>\n";
}
$ResponseXML .= "</FilterItemDescription>";
echo $ResponseXML; 
}
elseif($RequestType=="GetTQBNo")
{
$CustomerID	= $_GET["CustomerID"];
$ResponseXML ="";
$ResponseXML .= "<GetTQBNo>\n";
$sql="";
$sql="select distinct strTQBNo from customers where strCustomerID='$CustomerID'";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<TQBNo><![CDATA[" . $row["strTQBNo"] ."]]></TQBNo>\n";	
}
$ResponseXML .= "</GetTQBNo>";
echo $ResponseXML;
}
elseif($RequestType=="GetCurrencyRate")
{
$CurrencyCode	= $_GET["CurrencyCode"];
$ResponseXML ="";
$ResponseXML .= "<GetCurrencyRate>\n";
$sql="";
$sql="select distinct dblRate  from currencytypes where strCurrency='$CurrencyCode' and intStatus=1";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<CurrencyRate><![CDATA[" . $row["dblRate"] ."]]></CurrencyRate>\n";	
}
$ResponseXML .= "</GetCurrencyRate>";
echo $ResponseXML;
}
elseif($RequestType=="GetAuthorizeName")
{
$InputLatter	= $_GET["InputLatter"];

$ResponseXML="";
$ResponseXML.="<GetAuthorizeName>\n";

$sql="select  strAuthorizedBy from deliverynote where strAuthorizedBy like '$InputLatter%'";

$result=$db->RunQuery($sql);

while($row=mysql_fetch_array($result))
{
	$ResponseXML.="<AuthorizeName><![CDATA[" .$row["strAuthorizedBy"]. "]]></AuthorizeName>\n";
}
$ResponseXML.="</GetAuthorizeName>";
echo $ResponseXML;	
}
elseif($RequestType=="CheckPreviousDocsAvailable")
{
$previousDocs	= $_GET["previousDocs"];
$ResponseXML="";
$ResponseXML.="<CheckPreviousDocsAvailable>\n";
$sql="";
$sql="select intDeliveryNo from deliverynote where strPrevDoc='$previousDocs'";
$result = $db->RunQuery($sql);
$rowcount = mysql_num_rows($result);
		
	if ($rowcount > 0)
	{	
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<check><![CDATA[TRUE]]></check>\n";
			$ResponseXML .= "<DeliveryNo><![CDATA[" .$row["intDeliveryNo"]. "]]></DeliveryNo>\n";
		}
		
	}
	else
	{
			$ResponseXML .= "<check><![CDATA[FALSE]]></check>\n";
	}

$ResponseXML.="</CheckPreviousDocsAvailable>";
echo $ResponseXML;
}
?>