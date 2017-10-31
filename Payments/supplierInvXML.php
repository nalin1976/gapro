<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
$strPaymentType=$_GET["strPaymentType"];
/*10-10-2011
  use COLLATE latin1_bin use to check the case.
  remove it from all queries because to get lowercase results too	
*/
if(strcmp($RequestType,"SearchInvoiceNo")== 0)
{
	$InvNo = $_GET["InvoiceNo"];
	$ResponseXML .= "<Result>\n";
	//if(chkPaidOrNot($strPaymentType,$InvNo,$supId)){
		$result=SearchInvoiceNo($InvNo,$strPaymentType);
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<SupId><![CDATA[" . $row["SupID"]  . "]]></SupId>\n";
			$ResponseXML .= "<SupNm><![CDATA[" . $row["SupNm"]  . "]]></SupNm>\n";
			$ResponseXML .= "<InvDate><![CDATA[" . LoadInvoiceDate($InvNo,$strPaymentType,$row["SupID"]) . "]]></InvDate>\n";
			$ResponseXML .= "<VATSP><![CDATA[" . $row["VATSP"] . "]]></VATSP>\n";
			
		}
	/*}
	else{
		
	}*/
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function dateSet($dd){
	$d=split('-',$dd);
	return $d[2]."/".$d[1]."/".$d[0];
}

if(strcmp($RequestType,"getExRate")==0){
	$batch=$_GET['batchNo'];
	$result=getExchangeRate($batch);
	$ResponseXML .= "<Result>\n";

	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Currency><![CDATA[" . $row["CId"]  . "]]></Currency>\n";
		$ResponseXML .= "<Rate><![CDATA[" . $row["rate"]  . "]]></Rate>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
function getExchangeRate($batch){
global $db;
$sql="select ex.rate,b.strCurrency CId,ct.strCurrency from exchangerate ex 
	inner join batch b on b.strCurrency=ex.currencyID 
	inner join currencytypes ct on ct.intCurID= b.strCurrency
	where ex.intStatus='1' and b.intBatch='$batch'";
	
$res=$db->RunQuery($sql);
return $res;
}

if(strcmp($RequestType,"checkInvoiceNo")== 0)
{
	$supID = $_GET["supID"];
	$invoiceNo = $_GET["invoiceNo"];

	global $db;
	$strSQL="SELECT strInvoiceNo FROM invoiceheader WHERE strInvoiceNo='$invoiceNo' AND strSupplierId='$supID' AND strType='$strPaymentType'";
	
	//echo $strSQL;
	
	$result=$db->RunQuery($strSQL);
	
	$ResponseXML ="";
	$ResponseXML .= "<Result>\n";
	
	while($row = mysql_fetch_array($result))
	{
		if($row["strInvoiceNo"]!="")
		{
			$ResponseXML .= "<invNo><![CDATA[True]]></invNo>\n";
		}
		else if($row["strInvoiceNo"]=="")
		{
			$ResponseXML .= "<invNo><![CDATA[False]]></invNo>\n";
		}
	
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}


function SearchInvoiceNo($InvNo,$strPaymentType)
{
	global $db;
	if($strPaymentType=="S")
	{
		/*$sqlS="select strSupplierId from invoiceheader where  strInvoiceNo='$InvNo' order by strSupplierId;";
		$res=$db->RunQuery($sqlS);
		$sId="";
		while($row=mysql_fetch_array($res)){
			$sId.=$row['strSupplierId'].',';
		}*/
		
		$sql= "SELECT DISTINCT S.strSupplierID AS SupID, S.strTitle AS SupNm,S.intVATSuspended as VATSP FROM grnheader GH Inner Join purchaseorderheader PH ON GH.intPoNo = PH.intPONo AND GH.intYear =  PH.intYear Inner Join suppliers S ON PH.strSupplierID = S.strSupplierID WHERE GH.strInvoiceNo = '". $InvNo ."' and GH.intStatus = 1 order by S.strTitle";
			/*if($sId!=""){
			$l=strlen($sId);
			$id=substr($sId,0,$l-1);
				$sql.="and suppliers.strSupplierID not in ($id) ";
			}*/
			//$sql.="" ;
			//echo $sql;
	}
	else if($strPaymentType=="G")
	{
		$sql= "SELECT DISTINCT S.strSupplierID AS SupID, S.strTitle AS SupNm,S.intVATSuspended as VATSP FROM gengrnheader GH Inner Join generalpurchaseorderheader PH ON GH.intGenPONo=PH.intGenPONo AND GH.intGenPOYear =  PH.intYear Inner Join suppliers S ON PH.intSupplierID = S.strSupplierID WHERE GH.strInvoiceNo = '". $InvNo ."' AND GH.intStatus = 1  order by S.strTitle" ;
	}
	else if($strPaymentType=="B")
	{
		$sql= "SELECT distinct S.strSupplierID AS SupID,S.strTitle AS SupNm,S.intVATSuspended VATSP FROM bulkgrnheader GH Inner Join bulkpurchaseorderheader PH ON PH.intBulkPoNo = GH.intBulkPoNo AND PH.intYear = GH.intBulkPoYear Inner Join suppliers S ON PH.strSupplierID = S.strSupplierID WHERE GH.strInvoiceNo =  '".$InvNo."' AND GH.intStatus =  '1' order by S.strTitle;" ;
	}
	return $db->RunQuery($sql);
}
if($RequestType=="getInvoiceNoPayble")
{
	$InvNo 		 = $_GET["InvNo"];
	$paymentType = $_GET["paymentType"];
	$supplier    = $_GET["supplier"];
	
	$ResponseXML = "<Result>\n";
	
	$sql = "select IH.strInvoiceNo, 
			IH.strSupplierId, 
			IH.strBatchNo, 
			IH.intEntryNo, 
			B.strDescription,
			S.strTitle
			from 
			invoiceheader IH
			Inner Join suppliers S ON IH.strSupplierId = S.strSupplierID
			Inner Join batch B ON B.intBatch=IH.strBatchNo
			where IH.strInvoiceNo='$InvNo'
			and IH.strType='$paymentType'
			and IH.strSupplierId='$supplier'";
	$result=$db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<BatchNo><![CDATA[" . $row["strBatchNo"]  . "]]></BatchNo>\n";
			$ResponseXML .= "<Supplier><![CDATA[" . $row["strTitle"]  . "]]></Supplier>\n";
			$ResponseXML .= "<EntryNo><![CDATA[" . $row["intEntryNo"]  . "]]></EntryNo>\n";
		}
	$ResponseXML .= "</Result>\n";
	echo $ResponseXML;
	
}

if(strcmp($RequestType,"GetSupplierInvoiceDetails")== 0)
{
	$InvNo = $_GET["InvoiceNo"];
	$SupId = $_GET["SupplierId"];
	
	$ResponseXML .= "<Result>\n";

	$result=GetSupplierInvoiceDetails($InvNo,$SupId,$strPaymentType);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<CompId><![CDATA[" . $row["CompId"]  . "]]></CompId>\n";
		$ResponseXML .= "<CompNm><![CDATA[" . $row["CompNm"]  . "]]></CompNm>\n";
		$ResponseXML .= "<CompCd><![CDATA[" . $row["CompCd"]  . "]]></CompCd>\n";
		$ResponseXML .= "<AccPacID><![CDATA[" . $row["AccPacID"]  . "]]></AccPacID>\n";
		$ResponseXML .= "<POCurrency><![CDATA[" . getCurrency($row["POCurrency"])   . "]]></POCurrency>\n";
		$ResponseXML .= "<CreditDays><![CDATA[" . $row["CreditDays"]  . "]]></CreditDays>\n";
	}

	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function getCurrency($currency){
	global $db;
	$sql="select strCurrency from  currencytypes where intCurID='$currency';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['strCurrency'];
}
function GetSupplierInvoiceDetails($InvNo,$SupId,$strPaymentType)
{
	global $db;

	
	if($strPaymentType=="S")
	{
		//changed to invoice to company id by roshan advice by nishantha.2010-09-22
		$sql= "	SELECT DISTINCT companies.intCompanyID AS CompId, companies.strName AS CompNm, companies.strComCode AS CompCd,suppliers.strAccPaccID AS AccPacID, purchaseorderheader.strCurrency AS POCurrency, creditperiods.dblNoOfDays AS CreditDays FROM grnheader Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear =  purchaseorderheader.intYear Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID Inner Join companies ON purchaseorderheader.intDelToCompID = companies.intCompanyID Left Outer Join creditperiods ON suppliers.intCreditPeriod = creditperiods.intSerialNO WHERE grnheader.strInvoiceNo = '". $InvNo ."' AND grnheader.intStatus =  '1' AND suppliers.strSupplierID =  '". $SupId ."' " ;
		
	}
	else if($strPaymentType=="G")
	{
		$sql="SELECT DISTINCT companies.intCompanyID AS CompId, companies.strName AS CompNm, companies.strComCode AS CompCd,suppliers.strAccPaccID AS AccPacID,generalpurchaseorderheader.strCurrency AS POCurrency,creditperiods.dblNoOfDays AS CreditDays FROM gengrnheader INNER JOIN generalpurchaseorderheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo AND gengrnheader.intGenPOYear =generalpurchaseorderheader.intYear INNER JOIN suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID INNER JOIN companies ON gengrnheader.intCompId = companies.intCompanyID LEFT OUTER JOIN creditperiods  ON suppliers.intCreditPeriod = creditperiods.intSerialNO  WHERE gengrnheader.strInvoiceNo = '$InvNo' AND gengrnheader.intStatus =  '1' AND suppliers.strSupplierID =  '$SupId'";
	}
	else if($strPaymentType=="B")
	{
		$sql="SELECT
			suppliers.strAccPaccID AS AccPacID,
			bulkpurchaseorderheader.strCurrency AS POCurrency,
			companies.intCompanyID AS CompId,
			companies.strComCode AS CompCd,
			companies.strName AS CompNm,
			creditperiods.dblNoOfDays AS CreditDays
			FROM
			bulkgrnheader
			Inner Join bulkpurchaseorderheader ON bulkpurchaseorderheader.intBulkPoNo = bulkgrnheader.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkgrnheader.intBulkPoYear
			Inner Join suppliers ON suppliers.strSupplierID = bulkpurchaseorderheader.strSupplierID
			Inner Join companies ON bulkgrnheader.intCompanyId = companies.intCompanyID
			left Outer Join creditperiods ON creditperiods.intSerialNO = suppliers.intCreditPeriod
			WHERE
			bulkgrnheader.strInvoiceNo =  '$InvNo' AND
			bulkgrnheader.intStatus =  '1' AND
			suppliers.strSupplierID =  '$SupId'";
	}
	//echo($sql);
			 
	return $db->RunQuery($sql);
}
if(strcmp($RequestType,"saveCharges")== 0)
{
	$invNo	=	$_GET['invNo'];
	$glId	=	$_GET['glId'];
	$amount	=	$_GET['amount'];
	$tbl	=	$_GET['tbl'];
	$type	=	$_GET['strPaymentType'];
	$supId	=	$_GET['supId'];
	$sql="insert into `$tbl`(strInvoiceNo,intSupplierId,dtmDate,intAccID,dblAmount,strType) values('$invNo','$supId',now(),'$glId','$amount','$type');";
	$ResponseXML .= "<Result>\n";
	
		$ResponseXML .= "<RES><![CDATA[" . saveCharges($sql) . "]]></RES>\n";

	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
function saveCharges($sql){
	global $db;	
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadCurrency")== 0)
{

	$invNo			= $_GET['invNo'];
	$supId			= $_GET['supId'];
	$strPaymentType	= $_GET['strPaymentType'];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadCurrency($invNo,$supId,$strPaymentType);
	while($row = mysql_fetch_array($result))
	{ 
		$ResponseXML .= "<CurrCd><![CDATA[" . $row["strCurrency"]  . "]]></CurrCd>\n";
		$ResponseXML .= "<Rate><![CDATA[" . $row["dblCurrencyRate"]  . "]]></Rate>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadCurrency($invNo,$supId,$type)
{
	global $db;
	$sql="  select invoiceheader.strCurrency ,invoiceheader.dblCurrencyRate
			from invoiceheader 
			inner join currencytypes c on c.intCurID=invoiceheader.strCurrency
			where invoiceheader.strInvoiceNo =  '$invNo' and invoiceheader.strSupplierId='$supId' and invoiceheader.strType='$type';";
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadCreditPeriod")== 0)
{
	$sup         = $_GET['supId'];
	$invNo       = $_GET['invNo'];
	$PaymentType = $_GET['PaymentType'];
	$invoiceDate = $_GET['invoiceDate'];
	$ResponseXML .= "<Result>\n";
	$result=LoadCreditPeriod($invNo,$sup,$PaymentType);
	while($row = mysql_fetch_array($result))
	{
		$invDateArry = explode('/',$invoiceDate);
		$newFormatedDate = $invDateArry[2].'/'.$invDateArry[1].'/'.$invDateArry[0];
		$NoOfDays = $row["CreditPeriod"];
		$newdate = strtotime ('+'.$NoOfDays.'day', strtotime ( $newFormatedDate ) ) ;
		$newdate = date ("d/m/Y" , $newdate );
	
		$ResponseXML .= "<NoOfDays><![CDATA[" . $NoOfDays  . "]]></NoOfDays>\n";
		$ResponseXML .= "<invoiceDueDate><![CDATA[" . $newdate . "]]></invoiceDueDate>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
if(strcmp($RequestType,"LoadCreditDuePeriod")== 0)
{
	
	$invoiceDate = $_GET['invoiceDate'];
	$creditPeriod = $_GET['creditPeriod'];
	$ResponseXML .= "<Result>\n";
	
		$invDateArry = explode('/',$invoiceDate);
		$newFormatedDate = $invDateArry[2].'/'.$invDateArry[1].'/'.$invDateArry[0];
		$newdate = strtotime ('+'.$creditPeriod.'day', strtotime ( $newFormatedDate ) ) ;
		$newdate = date ("d/m/Y" , $newdate );
		
		$ResponseXML .= "<invoiceDueDate><![CDATA[" . $newdate . "]]></invoiceDueDate>\n";

	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadCreditPeriod($invNo,$sup,$PaymentType)
{
	global $db;
			
	$sql="SELECT distinct intCreditPeriod AS CreditPeriod
			FROM invoiceheader 
			WHERE strInvoiceNo = '$invNo' and strSupplierId='$sup' and strType='$PaymentType'";
	
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadBatch")== 0)
{
	$ResponseXML .= "<Result>\n";
	$result=LoadBatch();
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<BatchId><![CDATA[" . $row["BatchId"]  . "]]></BatchId>\n";
		$ResponseXML .= "<BatchDesc><![CDATA[" . $row["BatchDesc"]  . "]]></BatchDesc>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"setTaxTypes") == 0){
		$supID=$_GET["supID"];
			
		$ResponseXML = "";
		$ResponseXML .= "<supTaxType>\n";
	 	$res=getSuptax($supID);
		while($rowT = mysql_fetch_array($res)){
			$ResponseXML .= "<suptax><![CDATA[" . $rowT["strTaxTypeID"]  . "]]></suptax>\n";
		}
		$ResponseXML .= "</supTaxType>";
		echo $ResponseXML;
	}
function LoadBatch()
{
	global $db;
	$sql= "SELECT batch.intBatch AS BatchId, batch.strDescription AS BatchDesc FROM batch  WHERE batch.posted =  '0' " ;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadSupplierGL")== 0)
{
	$SupId = $_GET["SupplierId"];
	$FacCd = $_GET["FactoryCode"];
	$ResponseXML .= "<Result>";
	$result=LoadSupplierGL($SupId,$FacCd);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<accNo><![CDATA[" . $row["strAccID"]  . "]]></accNo>\n";
		$ResponseXML .= "<accName><![CDATA[" . $row["strDescription"]  . "]]></accName>\n";
		$ResponseXML .= "<facId><![CDATA[" . $row["intGLAccID"]  . "]]></facId>\n";
		$ResponseXML .= "<facAccId><![CDATA[" . $row["strCode"]  . "]]></facAccId>\n";
		$ResponseXML .= "<Selected><![CDATA[True]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadSupplierGL($SupId,$FacCd)
{
	global $db;
/*	$sql= "SELECT glaccounts.strAccID AS GLAccId, glaccounts.strDescription AS GLAccDesc, glaccounts.strFacCode AS FacCd
			,glallocationforsupplier.strFactoryId
			FROM glallocationforsupplier
			Inner Join glaccounts ON glallocationforsupplier.strAccID = glaccounts.strAccID
			WHERE (glallocationforsupplier.strSupplierId = '". $SupId ."') AND (glaccounts.strFacCode = '". $FacCd ."') order by GLAccId; " ;	
			//echo $sql;*/
			
	$sql="select gla.FactoryCode,gl.strDescription,gl.strAccID,c.strCode,gla.GLAccAllowNo as intGLAccID from glallocationforsupplier gls 
			inner join glallowcation gla on gla.GLAccAllowNo=gls.strAccId
			inner join glaccounts gl on gl.intGLAccID=gla.GLAccNo
			inner join costcenters c on c.intCostCenterId = gla.FactoryCode 
			where gls.strSupplierId='$SupId ' and gl.intStatus='1' 
			-- GROUP BY gl.strFacCode,gl.strDescription 
			order by gl.strDescription";
			//echo $sql;
	return $db->RunQuery($sql);
}

function getSuptax($supID){
	global $db;
	$strSQL="select strTaxTypeID from suppliers  where strSupplierID='$supID'";
	$res=$db->ExecuteQuery($strSQL);
	return $res;
}

if(strcmp($RequestType,"InvoicePayable")== 0)
{
	$SupId = $_GET["SupplierId"];
	$InvNo = $_GET["InvoiceNo"];
	
	$ResponseXML .= "<Result>\n";
	$result=InvoicePayable($SupId,$InvNo,$strPaymentType);
	while($row = mysql_fetch_array($result))
	{
/*		$ResponseXML .= "<GrnQty><![CDATA[" . $row["GrnQty"]  . "]]></GrnQty>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[" . $row["UnitPrice"]  . "]]></UnitPrice>\n";
		$ResponseXML .= "<PaidAmount><![CDATA[" . $row["dblPaidAmount"]  . "]]></PaidAmount>\n";
		$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";*/
		//$invAmount = 
		
		$ResponseXML .= "<grnAmount><![CDATA[" . $row["grnAmount"]  . "]]></grnAmount>\n";
		$ResponseXML .= "<invoiceAmount><![CDATA[" . (float)$row["invoiceAmount"]  . "]]></invoiceAmount>\n";
		$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function InvoicePayable($SupId,$InvNo,$strPaymentType)
{
	global $db;
	if($strPaymentType=="S")
	{			
		//$sql= "SELECT grnheader.strInvoiceNo AS InvoiceNo, grndetails.intMatDetailID AS MatDetailId, grndetails.strColor AS Color,		grndetails.strSize AS Size, grndetails.dblQty AS GrnQty, purchaseorderdetails.dblUnitPrice AS UnitPrice		FROM grnheader Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND		grnheader.intYear = purchaseorderheader.intYear 		Inner Join purchaseorderdetails ON  purchaseorderheader.intPONo = purchaseorderdetails.intPoNo 		AND purchaseorderheader.intYear = purchaseorderdetails.intYear 		Inner Join grndetails ON purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID 		AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND		grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear AND		purchaseorderdetails.intStyleId = grndetails.intStyleId AND 		purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO		WHERE grnheader.strInvoiceNo =  '". $InvNo ."' AND purchaseorderheader.strSupplierID =  '". $SupId ."' AND grnheader.intStatus =  '1' ";
		
		
/*		$sql="SELECT grnheader.strInvoiceNo AS InvoiceNo,grndetails.intMatDetailID AS MatDetailId,grndetails.strColor AS Color,grndetails.strSize AS Size,grndetails.dblQty AS GrnQty,purchaseorderdetails.dblUnitPrice AS UnitPrice ,purchaseorderheader.strCurrency,invoiceheader.dblPaidAmount FROM grnheader Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear Inner Join purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear Inner Join grndetails ON purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO  Left Outer Join invoiceheader ON grnheader.strInvoiceNo = invoiceheader.strInvoiceNo AND purchaseorderheader.strSupplierID = invoiceheader.strSupplierId  WHERE grnheader.strInvoiceNo =  '". $InvNo ."' AND purchaseorderheader.strSupplierID =  '". $SupId ."' AND grnheader.intStatus =  '1'";*/
		
		$sql = "SELECT
				grnheader.strInvoiceNo,
				purchaseorderheader.strCurrency,
				(grndetails.dblQty * purchaseorderdetails.dblUnitPrice) as grnAmount,
				(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and invoiceheader.strSupplierId =  '$SupId' and strType='S') as invoiceAmount
				FROM
				grnheader
				Inner Join grndetails ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear
				Inner Join purchaseorderdetails ON grnheader.intPoNo = purchaseorderdetails.intPoNo AND grnheader.intYear = purchaseorderdetails.intYear AND grndetails.intStyleId = purchaseorderdetails.intStyleId AND grndetails.strBuyerPONO = purchaseorderdetails.strBuyerPONO AND grndetails.intMatDetailID = purchaseorderdetails.intMatDetailID AND grndetails.strColor = purchaseorderdetails.strColor AND grndetails.strSize = purchaseorderdetails.strSize
				Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear AND purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND purchaseorderdetails.intYear = purchaseorderheader.intYear
				WHERE
				grnheader.strInvoiceNo =  '$InvNo' AND
				grnheader.intStatus =  '1' AND
				purchaseorderheader.intStatus =  '10' and 
				purchaseorderheader.strSupplierID =  '$SupId'
				";
		//echo $sql;
	}
	else if($strPaymentType=="G")
	{
		//$sql= "SELECT gengrnheader.strInvoiceNo AS InvoiceNo, gengrndetails.intMatDetailID AS MatDetailId, gengrndetails.dblQty AS GrnQty, generalpurchaseorderdetails.dblUnitPrice AS UnitPrice FROM gengrnheader INNER JOIN generalpurchaseorderheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo AND gengrnheader.intYear =generalpurchaseorderheader.intYear INNER JOIN generalpurchaseorderdetails ON  generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPONo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear INNER JOIN gengrndetails ON generalpurchaseorderdetails.intMatDetailID = gengrndetails.intMatDetailID AND gengrnheader.strGenGrnNo = gengrndetails.strGenGrnNo AND gengrnheader.intYear = gengrndetails.intYear WHERE gengrnheader.strInvoiceNo =  '$InvNo' AND  gengrnheader.intStatus =  '1'";
	
/*	$sql="SELECT gengrnheader.strInvoiceNo AS InvoiceNo,gengrndetails.intMatDetailID AS MatDetailId,gengrndetails.dblQty AS GrnQty,generalpurchaseorderdetails.dblUnitPrice AS UnitPrice,invoiceheader.dblPaidAmount,generalpurchaseorderheader.strCurrency FROM gengrnheader Inner Join generalpurchaseorderheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo AND gengrnheader.intYear = generalpurchaseorderheader.intYear Inner Join generalpurchaseorderdetails ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPoNo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear Inner Join gengrndetails ON  generalpurchaseorderdetails.intMatDetailID = gengrndetails.intMatDetailID AND gengrnheader.strGenGrnNo = gengrndetails.strGenGrnNo AND gengrnheader.intYear = gengrndetails.intYear Left Outer Join invoiceheader ON gengrnheader.strInvoiceNo = invoiceheader.strInvoiceNo AND generalpurchaseorderheader.intSupplierID = invoiceheader.strSupplierId WHERE gengrnheader.strInvoiceNo =   '$InvNo' AND  gengrnheader.intStatus =  '1'  AND
generalpurchaseorderheader.intDeliverTo =  '".$_SESSION["FactoryID"]."'";*/
		
		$sql = "SELECT
				gengrnheader.strInvoiceNo,
				generalpurchaseorderheader.strCurrency,
				sum(gengrndetails.dblRate*gengrndetails.dblQty) as grnAmount,
				(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and strType='G') as invoiceAmount
				FROM
				gengrndetails
				Inner Join gengrnheader ON gengrndetails.strGenGrnNo = gengrnheader.strGenGrnNo AND gengrnheader.intYear = gengrndetails.intYear
				Inner Join generalpurchaseorderheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo AND gengrnheader.intGenPOYear = generalpurchaseorderheader.intYear
				WHERE
				gengrnheader.strInvoiceNo =  '$InvNo'
				GROUP BY
				gengrnheader.strInvoiceNo

				";
	//generalpurchaseorderheader.intSupplierID =  '$SupId'  AND
	//echo $sql;
	}
	else if($strPaymentType=="B")
	{
		
		
		$sql = "SELECT
				bulkgrnheader.strInvoiceNo,
				bulkpurchaseorderheader.strCurrency,
				sum(bulkgrndetails.dblRate*bulkgrndetails.dblQty) as grnAmount,
				(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and strType='B') as invoiceAmount
				FROM
				bulkgrndetails
				Inner Join bulkgrnheader ON bulkgrndetails.intBulkGrnNo = bulkgrnheader.intBulkGrnNo AND bulkgrnheader.intYear = bulkgrndetails.intYear
				Inner Join bulkpurchaseorderheader ON bulkgrnheader.intBulkPONo = bulkpurchaseorderheader.intBulkPONo AND bulkgrnheader.intYear = bulkpurchaseorderheader.intYear
				WHERE
				bulkgrnheader.strInvoiceNo =  '$InvNo'
				GROUP BY
				bulkgrnheader.strInvoiceNo;";
	//generalpurchaseorderheader.intSupplierID =  '$SupId'  AND
	//echo $sql;
	}
	//echo $sql;
	
	return $db->RunQuery($sql);
	
}

if(strcmp($RequestType,"getInvoiceBalance")== 0)
{
	$SupId = $_GET["SupplierId"];
	$InvNo = $_GET["InvoiceNo"];
	
	$ResponseXML .= "<Result>\n";
	$result=getInvoiceBalance($SupId,$InvNo,$strPaymentType);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<paidAmount><![CDATA[" . $row["GrnQty"]  . "]]></paidAmount>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
function getInvoiceBalance($SupId,$InvNo,$strPaymentType)
{
global $db;
	if($strPaymentType=="S")
	{		
		$sql="SELECT grnheader.strInvoiceNo AS InvoiceNo,grndetails.intMatDetailID AS MatDetailId,grndetails.strColor AS Color,grndetails.strSize AS Size,grndetails.dblQty AS GrnQty,purchaseorderdetails.dblUnitPrice AS UnitPrice, invoiceheader.dblPaidAmount FROM grnheader Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear Inner Join purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear Inner Join grndetails ON purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO  Left Outer Join invoiceheader ON grnheader.strInvoiceNo = invoiceheader.strInvoiceNo AND purchaseorderheader.strSupplierID = invoiceheader.strSupplierId AND purchaseorderheader.intCompanyID = invoiceheader.intcompanyiD WHERE grnheader.strInvoiceNo =  '". $InvNo ."' AND purchaseorderheader.strSupplierID =  '". $SupId ."' AND grnheader.intStatus =  '1'";		
	}
	else if($strPaymentType=="G")
	{
		$sql= "SELECT gengrnheader.strInvoiceNo AS InvoiceNo, gengrndetails.intMatDetailID AS MatDetailId, gengrndetails.dblQty AS GrnQty, generalpurchaseorderdetails.dblUnitPrice AS UnitPrice FROM gengrnheader INNER JOIN generalpurchaseorderheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo AND gengrnheader.intYear =generalpurchaseorderheader.intYear INNER JOIN generalpurchaseorderdetails ON  generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPONo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear INNER JOIN gengrndetails ON generalpurchaseorderdetails.intMatDetailID = gengrndetails.intMatDetailID AND gengrnheader.strGenGrnNo = gengrndetails.strGenGrnNo AND gengrnheader.intYear = gengrndetails.intYear WHERE gengrnheader.strInvoiceNo =  '$InvNo' AND  gengrnheader.intStatus =  '1'";
	
	}
	
	return $db->RunQuery($sql);
}


if(strcmp($RequestType,"LoadPoDetails")== 0)
{
	$SupId = $_GET["SupplierId"];
	$InvNo = $_GET["InvoiceNo"];
	
	$ResponseXML .= "<Result>\n";
	
		$result=LoadPoDetails($SupId,$InvNo,$strPaymentType);
		while($row = mysql_fetch_array($result))
		{
			//$grnBalance = (float)$row["totalGrnValue"] - (float)$row["invoiceAmount"];
			$ResponseXML .= "<PO><![CDATA[" . $row["PO"]  . "]]></PO>\n";
			$ResponseXML .= "<Currency><![CDATA[" .  getCurrencyCode($row["strCurrency"]) . "]]></Currency>\n";
			$ResponseXML .= "<BTNO><![CDATA[" .  $row["strCurrency"] . "]]></BTNO>\n";
			$ResponseXML .= "<POAmount><![CDATA[" . $row["POAmount"]  . "]]></POAmount>\n";
			$ResponseXML .= "<AdvancedPOBal><![CDATA[" . $row["paidAmount"]  . "]]></AdvancedPOBal>\n";
			$ResponseXML .= "<POBalance><![CDATA[" . $row["dblPoBalance"]  . "]]></POBalance>\n";
			$ResponseXML .= "<grnBalance><![CDATA[" . $row["totalGrnValue"]  . "]]></grnBalance>\n";
			$ResponseXML .= "<invoiceAmount><![CDATA[" . $row["invoiceAmount"] . "]]></invoiceAmount>\n";
			$ResponseXML .= "<Selected><![CDATA[True]]></Selected>\n";
		}
		
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
if(strcmp($RequestType,"getBatchNo")== 0)
{
	$CurrencyId = $_GET["CurrencyId"];
	$ResponseXML = "<XMLLBatchNo>\n";
	
	$sqlBtNo="select  intBatch,strDescription,intEntryNo from batch where intBatchType='1' and strCurrency='$CurrencyId' and posted=0 ORDER BY strDescription";
	$res=$db->RunQuery($sqlBtNo);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($res))
		{
			$ResponseXML .= "<option value=\"". $row["intBatch"] ."\">".$row["strDescription"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLBatchNo>\n";
		echo $ResponseXML;
}
if($RequestType=="getEntryNoandBatchId")
{
	$pubXMLBatchNo = $_GET["pubXMLBatchNo"];
	$ResponseXML = "<getEntryNoandBatchId>\n";
	
	$sql="select  intBatch,COALESCE(intEntryNo,1) as intEntryNo  from batch where intBatchType='1' and intBatch='$pubXMLBatchNo' ORDER BY intBatch";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res))
	{
		$ResponseXML .= "<EntryNo><![CDATA[" . $row["intEntryNo"]  . "]]></EntryNo>\n";
		$ResponseXML .= "<batchId><![CDATA[" . $row["intBatch"]  . "]]></batchId>\n";	
	}
	$ResponseXML .= "</getEntryNoandBatchId>\n";
		echo $ResponseXML;
}
function chkPaidOrNot($type,$InvNo,$supId){
	global $db;
	$sql="select * from invoiceheader where strInvoiceNo='$InvNo' and strSupplierId='$supId'  and strType='$type';";
	$res=$db->RunQuery($sql);
	$cnt=mysql_num_rows($res);
	if($cnt > 0)
		return false;
	else
		return true;
}

function getCurrencyCode($cr){
	global $db;
	$sqlC="select strCurrency from currencytypes where intCurID =".$cr.";";
	$res=$db->RunQuery($sqlC);
	$row=mysql_fetch_array($res);
	return $row['strCurrency'];
}
function LoadPoDetails($SupId,$InvNo,$strPaymentType)
{
	global $db;
	if($strPaymentType=="S")
	{
/*		$sql= "SELECT DISTINCTROW concat(purchaseorderheader.intYear,'/', purchaseorderheader.intPONo) AS PO, 			purchaseorderheader.strCurrency AS strCurrency, purchaseorderheader.dblPOValue AS POAmount, purchaseorderheader.dblPOBalance AS dblPoBalance FROM purchaseorderheader Inner Join grnheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear WHERE (grnheader.strInvoiceNo =  '". $InvNo ."') AND (grnheader.intStatus = '1') AND (purchaseorderheader.strSupplierID =  '". $SupId ."') AND (purchaseorderheader.intStatus <> '11')" ;*/


		$sql = "SELECT
				concat(purchaseorderheader.intYear,'/',purchaseorderheader.intPONo) AS PO,
				purchaseorderheader.strCurrency AS strCurrency,
				purchaseorderheader.dblPOValue AS POAmount,
				APO.paidAmount,
				purchaseorderheader.dblPOBalance AS dblPoBalance,
				sum(grndetails.dblQty * purchaseorderdetails.dblUnitPrice) as totalGrnValue,
(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and invoiceheader.strSupplierId =  '$SupId' and strType='S') as invoiceAmount
				
				FROM
				purchaseorderheader
				left Join advancepaymentpos APO ON APO.POno=purchaseorderheader.intPONo and APO.POYear=purchaseorderheader.intYear
				Inner Join grnheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear
				Inner Join grndetails ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear
				left Join purchaseorderdetails ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND purchaseorderdetails.intYear = purchaseorderheader.intYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO
				WHERE (grnheader.strInvoiceNo =  '$InvNo') AND (grnheader.intStatus = '1') AND (purchaseorderheader.strSupplierID =  '$SupId') AND (purchaseorderheader.intStatus <> '11')
				GROUP BY
				purchaseorderheader.intPONo,
				purchaseorderheader.intYear
				";
		
		//echo $sql;
	}
	//========================================================
	else if ($strPaymentType=="G")
	{
		//$sql= "SELECT DISTINCTROW generalpurchaseorderheader.intYear AS POYear, generalpurchaseorderheader.intPONo AS PONo, 			generalpurchaseorderheader.strCurrency AS Currency, generalpurchaseorderheader.dblPOValue AS POValue, generalpurchaseorderheader.dblPOBalance AS POBalance FROM generalpurchaseorderheader Inner Join gengrnheader ON (generalpurchaseorderheader.intGenPONo=gengrnheader.intGenPONo) AND (generalpurchaseorderheader.intYear=gengrnheader.intGenPOYear) WHERE (gengrnheader.strInvoiceNo =  '". $InvNo ."') AND (gengrnheader.intStatus = '1') AND (generalpurchaseorderheader.intSupplierID =  '". $SupId ."') AND (generalpurchaseorderheader.intStatus <> '11')" ;
	
/*	  $sql= "SELECT DISTINCTROW  generalpurchaseorderheader.intYear AS POYear,  generalpurchaseorderheader.intGenPONo AS PONo,   generalpurchaseorderheader.dblPOBalance AS POBalance ,
generalpurchaseorderheader.strCurrency AS Currency,(SELECT SUM(dblUnitPrice * dblQty)  FROM generalpurchaseorderdetails  WHERE intGenPoNo = gengrnheader. intGenPONo AND intYear = gengrnheader.intYear) AS POValue
FROM generalpurchaseorderheader INNER JOIN gengrnheader ON (generalpurchaseorderheader.intGenPONo=gengrnheader.intGenPONo) 
AND (generalpurchaseorderheader.intYear=gengrnheader.intGenPOYear) WHERE  (gengrnheader.strInvoiceNo = '$InvNo') AND   (gengrnheader.intStatus = '1') AND   (generalpurchaseorderheader.intSupplierID = '$SupId') AND (generalpurchaseorderheader.intStatus <> '11')" ;*/
	
	
/*	$sql = "SELECT
			concat(generalpurchaseorderheader.intYear ,'/',generalpurchaseorderheader.intGenPONo) AS PO,
			generalpurchaseorderheader.strCurrency,
			sum(generalpurchaseorderdetails.dblUnitPrice*generalpurchaseorderdetails.dblQty) AS POAmount,
			generalpurchaseorderheader.dblPoBalance
			FROM
			generalpurchaseorderdetails
			Inner Join generalpurchaseorderheader ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPoNo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
			Inner Join gengrnheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo AND gengrnheader.intGenPOYear = generalpurchaseorderheader.intYear
			WHERE
			gengrnheader.strInvoiceNo =  '$InvNo' AND
			generalpurchaseorderheader.intStatus <>  '11' AND
			generalpurchaseorderheader.intSupplierID =  '$SupId'
			GROUP BY
			gengrnheader.strInvoiceNo

			";*/
			$sql = "SELECT
						concat(generalpurchaseorderheader.intYear ,'/',generalpurchaseorderheader.intGenPONo) AS PO,
						generalpurchaseorderheader.strCurrency,
						sum(generalpurchaseorderdetails.dblUnitPrice*generalpurchaseorderdetails.dblQty) AS POAmount,
						APO.paidAmount,
						generalpurchaseorderheader.dblPoBalance,
						sum(gengrndetails.dblQty * gengrndetails.dblRate ) as totalGrnValue,
			(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and invoiceheader.strSupplierId =  '$SupId' and strType='G') as invoiceAmount
			FROM
			generalpurchaseorderdetails
			Inner Join generalpurchaseorderheader ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPoNo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
			left Join advancepaymentpos APO ON APO.POno=generalpurchaseorderheader.intGenPONo and APO.POYear=generalpurchaseorderheader.intYear
			Inner Join gengrnheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo AND gengrnheader.intGenPOYear = generalpurchaseorderheader.intYear
			Inner Join gengrndetails ON gengrndetails.strGenGrnNo = gengrnheader.strGenGrnNo AND gengrndetails.intYear = gengrnheader.intYear AND gengrndetails.intMatDetailID = generalpurchaseorderdetails.intMatDetailID AND gengrndetails.strUnit = generalpurchaseorderdetails.strUnit
			WHERE
						gengrnheader.strInvoiceNo =  '$InvNo' AND
						generalpurchaseorderheader.intStatus <>  '11' AND
						generalpurchaseorderheader.intSupplierID =  '$SupId'
			GROUP BY
						gengrnheader.strInvoiceNo
			";
	}
	else if($strPaymentType=="B"){
		$sql="SELECT
						concat(bulkpurchaseorderheader.intYear ,'/',bulkpurchaseorderheader.intBulkPONo) AS PO,
						bulkpurchaseorderheader.strCurrency,
						sum( bulkpurchaseorderdetails.dblUnitPrice* bulkpurchaseorderdetails.dblQty) AS POAmount,
						APO.paidAmount,
						bulkpurchaseorderheader.dblPoBalance,
			
						sum(bulkgrndetails.dblQty * bulkgrndetails.dblRate ) as totalGrnValue,
			(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and invoiceheader.strSupplierId =  '$SupId' and strType='B') as invoiceAmount
			FROM
			bulkpurchaseorderdetails
			Inner Join bulkpurchaseorderheader ON bulkpurchaseorderheader.intBulkPONo = bulkpurchaseorderdetails.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkpurchaseorderdetails.intYear
			left Join advancepaymentpos APO ON APO.POno=bulkpurchaseorderheader.intBulkPONo and APO.POYear=bulkpurchaseorderheader.intYear
			Inner Join bulkgrnheader ON bulkgrnheader.intBulkPONo =bulkpurchaseorderheader.intBulkPONo AND bulkgrnheader.intBulkPOYear = bulkpurchaseorderheader.intYear
			
			Inner Join bulkgrndetails ON bulkgrndetails.intBulkGrnNo = bulkgrnheader.intBulkGrnNo AND bulkgrndetails.intYear = bulkgrnheader.intYear
			 AND bulkgrndetails.intMatDetailID = bulkpurchaseorderdetails.intMatDetailID AND bulkgrndetails.strUnit = bulkpurchaseorderdetails.strUnit
			WHERE
						bulkgrnheader.strInvoiceNo =  '$InvNo' AND
						bulkpurchaseorderheader.intStatus <>  '11' AND
						bulkpurchaseorderheader.strSupplierID =  '$SupId'
			GROUP BY
						bulkgrnheader.strInvoiceNo";
	}

	//echo $sql;
	return $db->RunQuery($sql);
}
if(strcmp($RequestType,"LoadCreditDebit")== 0)
{
	$SupId = $_GET["SupplierId"];
	$InvNo = $_GET["InvoiceNo"];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadCreditDebit($SupId,$InvNo);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Type><![CDATA[" . $row["Type"] . "]]></Type>\n";
		$ResponseXML .= "<DocNo><![CDATA[" . $row["DocNo"]  . "]]></DocNo>\n";
		$ResponseXML .= "<CdDate><![CDATA[" . $row["CdDate"]  . "]]></CdDate>\n";
		$ResponseXML .= "<Total><![CDATA[" . $row["Total"]  . "]]></Total>\n";
		$ResponseXML .= "<Amount><![CDATA[" . $row["Amount"]  . "]]></Amount>\n";
		$ResponseXML .= "<Tax><![CDATA[" . $row["Tax"]  . "]]></Tax>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadCreditDebit($SupId,$InvNo)
{
	global $db;
			$sql= "" ;
	return $db->RunQuery($sql);
}
if(strcmp($RequestType,"ShowAllGLAccounts")== 0)
{
	$SupId = $_GET["SupplierId"];
	$FacCd = $_GET["FactoryCode"];
	
	$ResponseXML .= "<Result>\n";
	$result=ShowAllGLAccounts($SupId,$FacCd);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<GLAccId><![CDATA[" . $row["NewGLAcc"]  . "]]></GLAccId>\n";
		$ResponseXML .= "<GLAccDesc><![CDATA[" . $row["NewGLDesc"]  . "]]></GLAccDesc>\n";
		$ResponseXML .= "<FactoryId><![CDATA[" . $row["strFactoryId"]  . "]]></FactoryId>\n";
		$ResponseXML .= "<Selected><![CDATA[False]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

/*function ShowAllGLAccounts($FacCd)
{
	global $db;
	$sql= "SELECT  glaccounts.strAccID AS GLAccId, glaccounts.strDescription AS GLAccDesc,
			glaccounts.strAccType AS GLAccType
			FROM glaccounts WHERE glaccounts.strFacCode = '". $FacCd ."' ";
	return $db->RunQuery($sql);
}*/
function ShowAllGLAccounts($SupId,$FacCd)
{
	global $db;
	$sql= "SELECT A.strAccID AS NewGLAcc,A.strDescription AS NewGLDesc,B.strAccID AS ExistGLAcc, B.strDescription AS ExistGLDesc ,B.strFactoryId 
			FROM (SELECT * FROM glaccounts WHERE glaccounts.strFacCode =  '". $FacCd ."') as A
			JOIN (SELECT glaccounts.strAccID, glaccounts.strDescription, glallocationforsupplier.strSupplierId , glallocationforsupplier.strFactoryId
			FROM glaccounts 
			Inner Join glallocationforsupplier ON glallocationforsupplier.strAccID = glaccounts.strAccID
			WHERE glallocationforsupplier.strSupplierId = '". $SupId ."' AND glaccounts.strFacCode = '". $FacCd ."') AS B
			HAVING A.strAccID NOT IN (B.strAccID) ";
			//echo $sql;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"ShowAllTax")== 0)
{
//	$InvNo = $_GET["InvoiceNo"];
//	$SupId = $_GET["SupplierId"];
//	$FacCd = $_GET["FactoryCode"];
	
	$ResponseXML .= "<Result>\n";
//	$result=ShowAllTax($InvNo,$SupId,$FacCd);
	$result=ShowAllTax();
	while($row = mysql_fetch_array($result))
	{
		$GLAccAllowNo = ($row["GLAccAllowNo"]==""?"0":$row["GLAccAllowNo"]);
		$taxCode	  = ($row["taxCode"]==""?"-":$row["taxCode"]);
		
		$ResponseXML .= "<TaxID><![CDATA[" . $row["TaxID"]  . "]]></TaxID>\n";
		$ResponseXML .= "<TaxType><![CDATA[" . $row["TaxType"]  . "]]></TaxType>\n";
		$ResponseXML .= "<TaxRate><![CDATA[" . $row["TaxRate"]  . "]]></TaxRate>\n";
		$ResponseXML .= "<TAXGL><![CDATA[" . $GLAccAllowNo  . "]]></TAXGL>\n";
		$ResponseXML .= "<TAXCode><![CDATA[" . $taxCode  . "]]></TAXCode>\n";
		
		$ResponseXML .= "<Selected><![CDATA[False]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function ShowAllTax()
{
	global $db;
	$sql= "SELECT
			taxtypes.strTaxTypeID AS TaxID,
			taxtypes.strTaxType AS TaxType,
			taxtypes.dblRate AS TaxRate,
			gla.GLAccAllowNo,
			concat(gl.strAccID,'',c.strCode) as taxCode
			FROM taxtypes
			LEFT join glallowcation gla on gla.GLAccAllowNo=taxtypes.intGLId
			LEFT join glaccounts gl on gl.intGLAccID=gla.GLAccNo
			LEFT join costcenters c on c.intCostCenterId = gla.FactoryCode
			WHERE taxtypes.intStatus = '1'";
		
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"SaveInvoice")== 0)
{
	
	$InvNo = $_GET["InvNo"];
	$SupId = $_GET["SupId"];
	$InvDt =  $_GET["InvDt"];
	$InvAmt =  $_GET["InvAmt"];
	$InvAmtwithoutNBT =  $_GET["InvAmtwithoutNBT"];
	$InvDesc =  $_GET["InvDesc"];
	$Commission =  $_GET["Commission"];
	$CompId = $_GET["CompId"];
	$Status =  $_GET["Status"];
	$PaidAmt =  $_GET["PaidAmt"];
	$BalanceAmt =  $_GET["BalanceAmt"];
	$TotalAmt =  $_GET["TotalAmt"];
	$Currency =  $_GET["Currency"];
	$Paid =  $_GET["Paid"];
	$CreditPeriod =  $_GET["CreditPeriod"];
	$CurrencyRate =  $_GET["CurrencyRate"];
	$TotalTaxAmt = $_GET["TotalTaxAmt"];
	$FreightAmt = $_GET["FreightAmt"];
	$InsuranceAmt = $_GET["Insurance"];
	$OtherAmt = $_GET["Other"];
	$VatGLAmt = $_GET["VatGl"];
	$batchno = $_GET["batchno"];
	$ArrPoNo = $_GET["ArrPoNo"];
	$accPaccId = $_GET['accPaccId'];
	//$entryNo	=$_GET['entryNo'];
	$lineNo		=$_GET['lineNo'];
	$invDescription=$_GET['invDesc'];
	$dueDate	=	$_GET['dueDate'];
	$dblAmountTemp	=	$_GET['dblAmountTemp'];
	$suspendedVat = $_GET["suspendedVat"];
	//echo $accPaccId;
	
	$ResponseXML = "<Result>\n";
	
	if(CheckExistingInvoice($InvNo,$strPaymentType,$SupId)){
		$up=1;
		poBalanceUpdate($ArrPoNo,$SupId,$strPaymentType,$BalanceAmt,$up,$dblAmountTemp);
		
		UpdateInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$InvAmtwithoutNBT,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalTaxAmt,$FreightAmt,$InsuranceAmt,$OtherAmt,$VatGLAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate,$strPaymentType,$intPONo,$intPOYear,$accPaccId,$lineNo,$suspendedVat);
		
		DeleteInvoiceDetails($InvNo,$strPaymentType,$SupId);
		DeleteInvoiceGlAccounts($InvNo,$strPaymentType,$SupId);
		DeleteInvoiceTax($InvNo,$strPaymentType,$SupId);
		//DeleteAccPaccInvoiceDetails($InvNo,$SupId);
		DeleteCharger($InvNo,$SupId);
		
		InvoiceDetails($InvNo,$SupId,$InvDt,$strPaymentType);
		InvoiceGLAccounts($InvNo,$SupId,$InvDt,$strPaymentType);	
		InvoiceTax($InvNo,$SupId,$InvDt,$strPaymentType);
	//	UpdateAccPaccInvoiceHeader($InvNo,$SupId,$InvDt,$batchno,$entryNo,$TotalAmt,$ArrPoNo,$invDescription,$dueDate,$InvDt,$VatGLAmt,$TotalTaxAmt,$CurrencyRate,$Currency);
		//SaveAccPaccInvoiceDetails();
		$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
		$ResponseXML .= "<Exist><![CDATA[True]]></Exist>\n";
		$ResponseXML .= "</Result>";
		echo $ResponseXML;
	}
	else
	{
		$up=0;
		poBalanceUpdate($ArrPoNo,$SupId,$strPaymentType,$BalanceAmt,$up);
		
		SaveInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$InvAmtwithoutNBT,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalTaxAmt,$FreightAmt,$InsuranceAmt,$OtherAmt,$VatGLAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate,$strPaymentType,$batchno,$accPaccId,$lineNo,$suspendedVat);

		$ArrPoNo = $_GET["ArrPoNo"];
		$explodePoNo = explode(',', $ArrPoNo);
		for ($i = 0;$i < count($explodePoNo)-1;$i++)
		{
			$PONo = explode('/', $explodePoNo[$i]);
			SaveInvoiceDetails($InvNo,$PONo[1],$PONo[0],$SupId,$InvDt,$strPaymentType);
		}
		//lasantha Acc Pack data
	//	SaveAccPaccInvoiceHeader($InvNo,$SupId,$InvDt,$batchno,$TotalAmt,$ArrPoNo,$invDescription,$dueDate,$InvDt,$VatGLAmt,$TotalTaxAmt,$CurrencyRate,$Currency);
	
		$ArrGlAcc = $_GET["ArrGlAcc"];
		$ArrGlAmt = $_GET["ArrGlAmt"];
		$ArrTaxGLAlocaId = $_GET["ArrTaxGLAlocaId"];
		$ArrTaxAmt = $_GET["ArrTaxAmt"];
		
		$explodeGlAcc = explode(',', $ArrGlAcc);
		$explodeGlAmt = explode(',', $ArrGlAmt);
		$explodeTaxGLAlocaId = explode(',', $ArrTaxGLAlocaId);
		$explodeTaxAmt = explode(',', $ArrTaxAmt);
		
		for ($i = 0;$i < count($explodeGlAcc)-1;$i++)
		{
			SaveInvoiceGlAccounts($InvNo,$SupId,$InvDt,$explodeGlAcc[$i],$explodeGlAmt[$i],$strPaymentType);
		}
		for ($i = 0;$i < count($explodeTaxGLAlocaId)-1;$i++)
		{
			if($explodeTaxGLAlocaId[$i]!='0')
			{
				SaveTaxGlAccounts($InvNo,$SupId,$InvDt,$explodeTaxGLAlocaId[$i],$explodeTaxAmt[$i],$strPaymentType);
			}
			//SaveAccPaccInvoiceDetails($InvNo,$SupId,$batchno,$entryNo,$lineNo,$explodeGlAcc[$i],$explodeGlAmt[$i]);
		}
	
		$ArrTaxId = $_GET["ArrTaxId"];
		$ArrTaxAmt = $_GET["ArrTaxAmt"];
		$explodeTaxId = explode(',', $ArrTaxId);
		$explodeTaxAmt = explode(',', $ArrTaxAmt);
		for ($i = 0;$i < count($explodeTaxId)-1;$i++)
		{
			SaveInvoiceTax($InvNo,$SupId,$InvDt,$explodeTaxId[$i],$explodeTaxAmt[$i],$strPaymentType);
		}
	
		$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
		$ResponseXML .= "<Exist><![CDATA[False]]></Exist>\n";
		$ResponseXML .= "</Result>";
		echo $ResponseXML;
	}
}

if (strcmp($RequestType,"getGLAccountList") == 0)
{
	 $fc=$_GET["facID"];
	 $NameLike=$_GET["NameLike"];
	 
	 $ResponseXML = "";
	 $ResponseXML .= "<GLAccs>\n";

	 $result=getGLAccList($fc,$NameLike);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<accNo><![CDATA[" . $row["strAccID"]  . "]]></accNo>\n";
		$ResponseXML .= "<GLAccID><![CDATA[" . $row["GLAccAllowNo"]  . "]]></GLAccID>\n";
		$ResponseXML .= "<accDes><![CDATA[" . $row["strDescription"]  . "]]></accDes>\n";
		$ResponseXML .= "<AccountNo><![CDATA[" . $row["strCode"]  . "]]></AccountNo>\n";
		
	 }
	 
	 $ResponseXML .= "</GLAccs>";
	 echo $ResponseXML;
}
function DeleteCharger($InvNo,$SupId){
	global $db;
	$arr = array('tblfreightgl','tblinsurancegl','tblothergl');
	for($i=0;$i<count($arr);$i++){
		$tbl=$arr[$i];
		$sql="delete from `$tbl` where strInvoiceNo='$InvNo' and intSupplierId='$SupId';";
		$db->RunQuery($sql);
	}
}
function SaveInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$InvAmtwithoutNBT,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalTaxAmt,$FreightAmt,$InsuranceAmt,$OtherAmt,$VatGLAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate,$strPaymentType,$batchno,$accPaccId,$lineNo,$suspendedVat)
{
global $db;
	$sql="select max(intEntryNo) ENTRYNO from batch where intBatch=$batchno";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$ENTRYNO	= $row["ENTRYNO"];
	 
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$sql= "INSERT INTO invoiceheader(strInvoiceNo, strSupplierId,dtmDate,dblAmount ,strDescription, dblInvoiceAmount, intcompanyiD, intStatus,dblPaidAmount,dblBalance, dblTotalTaxAmount,dblFreight,dblInsurance, dblOther,dblVatGL, dblTotalAmount, strCurrency,intPaid,intCreditPeriod,dblCurrencyRate,strType,strBatchNo,intEntryNo,intLineNo,intSuspendedVat)VALUES('$InvNo',". $SupId .",'". $InvDt ."' ,". $InvAmt .",'". $InvDesc ."',". $InvAmtwithoutNBT .", ". $CompId .",". $Status .",". $PaidAmt .", ". $BalanceAmt .", ". $TotalTaxAmt .", ". $FreightAmt .", ". $InsuranceAmt .", ". $OtherAmt .", ". $VatGLAmt .", ". $TotalAmt .", '". $Currency ."', ". $Paid .", ". $CreditPeriod .", ". $CurrencyRate .",'$strPaymentType','$batchno','$ENTRYNO',$lineNo,$suspendedVat)";
	$intSave = $db->RunQuery($sql);
	if($intSave=='1')
	{
		$sql="update batch set intEntryNo=$ENTRYNO+1 where intBatch=$batchno";
		$db->RunQuery($sql);
		$sql="UPDATE suppliers SET strAccPaccID='$accPaccId' WHERE strSupplierID='$SupId';";
		$db->RunQuery($sql);
	}
return $intSave;
}

function InvoiceDetails($InvNo,$SupId,$InvDt,$strPaymentType)
{
	$ArrPoNo = $_GET["ArrPoNo"];
	$explodePoNo = explode(',', $ArrPoNo);
	for ($i = 0;$i < count($explodePoNo)-1;$i++)
	{
		$PONo = explode('/', $explodePoNo[$i]);
		SaveInvoiceDetails($InvNo,$PONo[1],$PONo[0],$SupId,$InvDt,$strPaymentType);	
	}
}

function SaveInvoiceDetails($InvNo,$PoNo,$PoYear,$SupId,$InvDt,$strPaymentType)
{
	global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$sql= "INSERT INTO invoicedetails(strInvoiceNo,intPONO,intPOYear,strSupplierId,dtmDate,strType)VALUES('". $InvNo ."',". $PoNo .",". $PoYear .",". $SupId .",'". $InvDt ."','$strPaymentType')";
	$db->RunQuery($sql);
}

function InvoiceGLAccounts($InvNo,$SupId,$InvDt,$strPaymentType)
{
	$ArrGlAcc = $_GET["ArrGlAcc"];
	$ArrGlAmt = $_GET["ArrGlAmt"];
	$ArrTaxGLAlocaId = $_GET["ArrTaxGLAlocaId"];
	$ArrTaxAmt = $_GET["ArrTaxAmt"];
	
	$explodeGlAcc = explode(',', $ArrGlAcc);
	$explodeGlAmt = explode(',', $ArrGlAmt);
	$explodeTaxGLAlocaId = explode(',', $ArrTaxGLAlocaId);
	$explodeTaxAmt = explode(',', $ArrTaxAmt);
	
	for ($i = 0;$i < count($explodeGlAcc)-1;$i++)
	{
		SaveInvoiceGlAccounts($InvNo,$SupId,$InvDt,$explodeGlAcc[$i],$explodeGlAmt[$i],$strPaymentType);	
	}
	for ($i = 0;$i < count($explodeTaxGLAlocaId)-1;$i++)
	{
		if($explodeTaxGLAlocaId[$i]!='0')
			{
				SaveTaxGlAccounts($InvNo,$SupId,$InvDt,$explodeTaxGLAlocaId[$i],$explodeTaxAmt[$i],$strPaymentType);	
			}
	}
}

function SaveInvoiceGlAccounts($InvNo,$SupId,$InvDt,$explodeGlAcc,$explodeTaxAmt,$strPaymentType)
{
	global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$sql= "INSERT INTO invoiceglbreakdown(strInvoiceNo,strSupplierId,dtmDate,strAccId,dblAmount,strType)VALUES('". $InvNo ."',". $SupId .",'". $InvDt ."','". $explodeGlAcc ."','". $explodeTaxAmt ."','$strPaymentType');";
	//echo $sql;
	$result = $db->RunQuery($sql);
	if($result<=0)
	{
		$sql = "UPDATE invoiceglbreakdown set dblAmount=dblAmount+$explodeTaxAmt
		 where 	strInvoiceNo	= 	'$InvNo' and
		 		strSupplierId	=	'$SupId' and
				strAccId		=	'$explodeGlAcc'";
		$result = $db->RunQuery($sql);								
		
	}
	
}
function SaveTaxGlAccounts($InvNo,$SupId,$InvDt,$explodeTaxGLAlocaId,$explodeGlAmt,$strPaymentType)
{
	global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$sql= "INSERT INTO invoiceglbreakdown(strInvoiceNo,strSupplierId,dtmDate,strAccId,dblAmount,strType,intGLCategory)VALUES('". $InvNo ."',". $SupId .",'". $InvDt ."','". $explodeTaxGLAlocaId ."','". $explodeGlAmt ."','$strPaymentType','1');";
	//echo $sql;
	$result = $db->RunQuery($sql);
	if($result<=0)
	{
		$sql = "UPDATE invoiceglbreakdown set dblAmount=dblAmount+$explodeGlAmt
		 where 	strInvoiceNo	= 	'$InvNo' and
		 		strSupplierId	=	'$SupId' and
				strAccId		=	'$explodeTaxGLAlocaId'";
		$result = $db->RunQuery($sql);								
		
	}
	
}

function InvoiceTax($InvNo,$SupId,$InvDt,$strPaymentType)
{
	$ArrTaxId = $_GET["ArrTaxId"];
	$ArrTaxAmt = $_GET["ArrTaxAmt"];
	$explodeTaxId = explode(',', $ArrTaxId);
	$explodeTaxAmt = explode(',', $ArrTaxAmt);
	for ($i = 0;$i < count($explodeTaxId)-1;$i++)
	{
		SaveInvoiceTax($InvNo,$SupId,$InvDt,$explodeTaxId[$i],$explodeTaxAmt[$i],$strPaymentType);
	}
}

function SaveInvoiceTax($InvNo,$SupId,$InvDt,$explodeTaxId,$explodeTaxAmt,$strPaymentType)
{
	global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$sql= "INSERT INTO invoicetaxes(strInvoiceNo,strSupplierId,dtmDate,strtaxtypeid,dblamount,strType)VALUES('". $InvNo ."',". $SupId .",'". $InvDt ."',". $explodeTaxId .",". $explodeTaxAmt .",'$strPaymentType');";
	//echo $sql;
	$result = $db->RunQuery($sql);
	if($result<=0)
	{
		$sql = "UPDATE invoicetaxes set dblamount= dblamount+$explodeTaxAmt 
				where 	strInvoiceNo	= 	$InvNo and
		 				strSupplierId	=	$SupId and
						strtaxtypeid	=	$explodeTaxId ;";
		$result = $db->RunQuery($sql);
	}
}

function CheckExistingInvoice($InvNo,$strPaymentType,$supID)
{
	global $db;
	$sql= "SELECT strInvoiceNo FROM invoiceheader WHERE strInvoiceNo = '$InvNo' and strType='$strPaymentType' and strSupplierId = '$supID' ";

	$res= $db->RunQuery($sql);
	if(mysql_num_rows($res)>0)
		return true;
	else
		return false;
}

function CheckExistingSupInvoice($InvNo,$SupId)
{
	global $db;
	$sql= "SELECT strInvoiceNo FROM invoiceheader WHERE (strInvoiceNo = '". $InvNo ."') AND (strSupplierId = '". $SupId ."') ";
	return $db->RunQuery($sql);
}

function poBalanceUpdate($ArrPoNo,$SupId,$strPaymentType,$BalanceAmt,$up,$dblAmountTemp)
{
	global $db;
	$intPOYear=substr($ArrPoNo,0,4) ;
	$intPONo=substr($ArrPoNo,5) ;
	$intPONo = str_replace(",", "", $intPONo);
		
		if($up==1){
			if($dblAmountTemp>0){
				$BalanceAmt=$dblAmountTemp;
			}else if($dblAmountTemp<0){
				$BalanceAmt=$dblAmountTemp;
			}
			else{
				$BalanceAmt=0;
			}
		}
		else{$BalanceAmt=$BalanceAmt;}
		
	if($strPaymentType=="S")
	{	
				$strsql="update purchaseorderheader  set dblPOBalance=dblPOBalance-($BalanceAmt) where intPONo='$intPONo' and intYear='$intPOYear' and strSupplierID='$SupId'";
				//echo $strsql;
	
	}
	else if($strPaymentType=="G")
	{
		$strsql="update generalpurchaseorderheader  set dblPoBalance=dblPoBalance-$BalanceAmt where intGenPONo='$intPONo' and intYear='$intPOYear' and intSupplierID='$SupId'";
	}
	//echo $strsql;
	$db->executeQuery($strsql);
}

function UpdateInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$InvAmtwithoutNBT,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalTaxAmt,$FreightAmt,$InsuranceAmt,$OtherAmt,$VatGLAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate,$strPaymentType,$intPONo,$intPOYear,$accPaccId,$lineNo,$suspendedVat)
{
	global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	
	
	$sql= "UPDATE invoiceheader SET dtmDate = '". $InvDt ."' ,dblAmount = $InvAmt ,strDescription = '". $InvDesc ."',dblInvoiceAmount = $InvAmtwithoutNBT,intcompanyiD  = ". $CompId .",intStatus = ". $Status .",dblPaidAmount = $PaidAmt,dblBalance = $BalanceAmt,dblTotalTaxAmount = $TotalTaxAmt ,dblFreight =$FreightAmt ,dblInsurance =$InsuranceAmt ,dblOther =$OtherAmt ,dblVatGL =$VatGLAmt , dblTotalAmount =$TotalAmt ,strCurrency = '". $Currency ."',intPaid = ". $Paid .",intCreditPeriod = ". $CreditPeriod .",dblCurrencyRate = ". $CurrencyRate .",intLineNo=$lineNo,intSuspendedVat='$suspendedVat' WHERE (strInvoiceNo = '". $InvNo ."') and strType='$strPaymentType' AND ( strSupplierId = ". $SupId .") "; //,$entryNo,$lineNo
	//echo $sql;
	//	$sql= "UPDATE invoiceheader SET dtmDate = '". $InvDt ."' ,dblAmount = dblAmount + $InvAmt,strDescription = '". $InvDesc ."',dblCommission =dblCommission + $Commission ,intcompanyiD  = ". $CompId .",intStatus = ". $Status .",dblPaidAmount =dblPaidAmount + $PaidAmt,dblBalance =dblBalance + $BalanceAmt,dblTotalTaxAmount =dblTotalTaxAmount + $,dblFreight =dblFreight + $FreightAmt ,dblInsurance =dblInsurance + $InsuranceAmt ,dblOther =dblOther + $OtherAmt,dblVatGL =dblVatGL + $VatGLAmt , dblTotalAmount =dblTotalAmount + $TotalAmt,strCurrency = '". $Currency ."',intPaid = ". $Paid .",intCreditPeriod = ". $CreditPeriod .",dblCurrencyRate = ". $CurrencyRate ." WHERE (strInvoiceNo = '". $InvNo ."') and strType='$strPaymentType' AND ( strSupplierId = ". $SupId .") ";
	//}
	//echo $sql;
	/*$sql= "UPDATE invoiceheader SET dtmDate = '". $InvDt ."' ,dblAmount = dblAmount + $InvAmt ,strDescription = '". $InvDesc ."',dblCommission =dblCommission + $Commission,intcompanyiD  = ". $CompId .",intStatus = ". $Status .",dblPaidAmount = dblPaidAmount + $PaidAmt,dblBalance = dblBalance+$BalanceAmt,dblTotalTaxAmount =dblTotalTaxAmount + $TotalTaxAmt ,dblFreight =dblFreight + $FreightAmt ,dblInsurance =dblInsurance + $InsuranceAmt ,dblOther =dblOther + $OtherAmt ,dblVatGL =dblVatGL + $VatGLAmt , dblTotalAmount =dblTotalAmount + $TotalAmt ,strCurrency = '". $Currency ."',intPaid = ". $Paid .",intCreditPeriod = ". $CreditPeriod .",dblCurrencyRate = ". $CurrencyRate ." WHERE (strInvoiceNo = '". $InvNo ."') and strType='$strPaymentType' AND ( strSupplierId = ". $SupId .") ";*/
	$res=$db->executeQuery($sql);
	if($res==1)
	{
		if(!empty($accPaccId)){
		$sql="UPDATE suppliers SET strAccPaccID='$accPaccId' WHERE strSupplierID='$SupId ';";
		$db->executeQuery($sql);
		}
	}
}

function DeleteInvoiceDetails($InvNo,$strPaymentType,$SupId)
{
	global $db;
	$sql= "DELETE FROM invoicedetails WHERE (strInvoiceNo = '". $InvNo ."') and strSupplierId='$SupId' and strType='$strPaymentType';";
	$db->executeQuery($sql);
}

function DeleteInvoiceGlAccounts($InvNo,$strPaymentType,$SupId)
{
	global $db;
	$sql= "DELETE FROM invoiceglbreakdown WHERE (strInvoiceNo = '". $InvNo ."') and strSupplierId='$SupId' and strType='$strPaymentType';";
	$db->executeQuery($sql);
}
function DeleteInvoiceTax($InvNo,$strPaymentType,$SupId)
{
	global $db;
	$sql= "DELETE FROM invoicetaxes WHERE (strInvoiceNo = '". $InvNo ."') and strSupplierId='$SupId' and strtype='$strPaymentType';";
	$db->executeQuery($sql);
}

//Edit Invoice
if(strcmp($RequestType,"SearchInvoiceNoEdit")== 0)
{
	$InvNo 			= $_GET["InvoiceNo"];
	$strPaymentType	= $_GET["strPaymentType"];
	$ResponseXML .= "<Result>\n";
	
	$result=SearchInvoiceNoEdit($InvNo,$strPaymentType);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<SupId><![CDATA[" . $row["SupID"]  . "]]></SupId>\n";
		$ResponseXML .= "<SupNm><![CDATA[" . $row["SupNm"]  . "]]></SupNm>\n";		
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function SearchInvoiceNoEdit($InvNo,$strPaymentType)
{
	global $db;
	$sql= "	SELECT S.strSupplierID AS SupID, S.strTitle AS SupNm
			FROM suppliers S Inner Join invoiceheader IH ON IH.strSupplierId = S.strSupplierID
			WHERE IH.strInvoiceNo ='$InvNo' and IH.strType='$strPaymentType'" ;
	//echo $sql;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"GetSupplierInvoiceExst")== 0)
{
	$InvNo		 = $_GET["InvoiceNo"];
	$SupId 		 = $_GET["SupplierId"];
	$PaymentType = $_GET["PaymentType"];
	
	$ResponseXML .= "<Result>\n";
	$result =  GetSupplierInvoiceExst($InvNo,$SupId,$PaymentType);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<CompId><![CDATA[" . $row["CompId"]  . "]]></CompId>\n";
		$ResponseXML .= "<CompNm><![CDATA[" . $row["CompNm"]  . "]]></CompNm>\n";
		$ResponseXML .= "<CompCd><![CDATA[" . $row["CompCd"]  . "]]></CompCd>\n";
		$ResponseXML .= "<AccPacID><![CDATA[" . $row["AccPacID"]  . "]]></AccPacID>\n";
		$ResponseXML .= "<InvCurrency><![CDATA[" . $row["InvCurrency"]  . "]]></InvCurrency>\n";
		$ResponseXML .= "<CreditDays><![CDATA[" . $row["CreditDays"]  . "]]></CreditDays>\n";
		$ResponseXML .= "<InvAmt><![CDATA[" . $row["InvAmt"]  . "]]></InvAmt>\n";
		//$ResponseXML .= "<invAmountwithNBT><![CDATA[" . $row["invAmountwithNBT"]  . "]]></invAmountwithNBT>\n";
		$ResponseXML .= "<InvDes><![CDATA[" . $row["InvDes"]  . "]]></InvDes>\n";
		$ResponseXML .= "<InvTotTaxAmt><![CDATA[" . $row["InvTotTaxAmt"]  . "]]></InvTotTaxAmt>\n";
		$ResponseXML .= "<InvFreight><![CDATA[" . $row["InvFreight"]  . "]]></InvFreight>\n";
		$ResponseXML .= "<InvInsurance><![CDATA[" . $row["InvInsurance"]  . "]]></InvInsurance>\n";
		$ResponseXML .= "<InvOther><![CDATA[" . $row["InvOther"]  . "]]></InvOther>\n";
		$ResponseXML .= "<InvVatGL><![CDATA[" . $row["InvVatGL"]  . "]]></InvVatGL>\n";
		$ResponseXML .= "<InvTotAmt><![CDATA[" . $row["InvTotAmt"]  . "]]></InvTotAmt>\n";
		$ResponseXML .= "<PaidStatus><![CDATA[" . $row["PaidStatus"]  . "]]></PaidStatus>\n";
		$ResponseXML .= "<BatchNo><![CDATA[" . $row["strBatchNo"]  . "]]></BatchNo>\n";
		$ResponseXML .= "<EntryNo><![CDATA[" . $row["intEntryNo"]  . "]]></EntryNo>\n";
		$ResponseXML .= "<lineNo><![CDATA[" . $row["intLineNo"]  . "]]></lineNo>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function GetSupplierInvoiceExst($InvNo,$SupId,$PaymentType)
{
	global $db;
	$sql = "SELECT IH.strInvoiceNo,C.intCompanyID AS CompId, C.strName AS CompNm, C.strComCode AS CompCd, 		
			S.strAccPaccID AS AccPacID, IH.strCurrency As InvCurrency,CP.dblNoOfDays AS CreditDays,
			IH.dblAmount AS InvAmt,IH.dblInvoiceAmount as invAmountwithNBT,IH.strDescription AS InvDes, 
			IH.dblTotalTaxAmount AS InvTotTaxAmt, IH.dblFreight AS InvFreight, IH.dblInsurance AS InvInsurance, 
			IH.dblOther AS InvOther, IH.dblVatGL AS InvVatGL,IH.dblTotalAmount AS InvTotAmt,
		    IH.intPaid AS PaidStatus,IH.strBatchNo,IH.intEntryNo,IH.intLineNo
			FROM suppliers S
			inner Join invoiceheader IH ON IH.strSupplierId = S.strSupplierID 
			inner Join creditperiods CP ON IH.intCreditPeriod = CP.dblNoOfDays 
			inner join companies C ON IH.intcompanyiD = C.intCompanyID
			WHERE IH.strInvoiceNo = '$InvNo' AND IH.strSupplierId ='$SupId' AND IH.strType = '$PaymentType'";
			//echo $sql;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadSupplierGLEdit")== 0)
{
	$SupId = $_GET["SupplierId"];
	$InvNo = $_GET["invNo"];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadSupplierGLEdit($InvNo,$SupId,$strPaymentType);
	while($row = mysql_fetch_array($result))
	{ 
	
		$ResponseXML .= "<accNo><![CDATA[" . $row["AID"]  . "]]></accNo>\n";
		$ResponseXML .= "<accName><![CDATA[" . $row["ACC"]  . "]]></accName>\n";
		$ResponseXML .= "<accDsc><![CDATA[" . $row["strDescription"]  . "]]></accDsc>\n";
		$ResponseXML .= "<GLAccAmt><![CDATA[" . $row["GLAccAmt"]  . "]]></GLAccAmt>\n";
		$ResponseXML .= "<Selected><![CDATA[True]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
function LoadSupplierGLEdit($InvNo,$SupId,$strPaymentType)
{
	global $db;
	/*$sql = "SELECT glaccounts.strAccID AS GLAccId, glaccounts.strDescription AS GLAccDesc, invoiceglbreakdown.dblAmount AS GLAccAmt
			FROM invoiceheader
			Inner Join invoiceglbreakdown ON invoiceheader.strInvoiceNo = invoiceglbreakdown.strInvoiceNo
			Inner Join glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID
			WHERE invoiceheader.strInvoiceNo = '". $InvNo ."' AND invoiceheader.strSupplierId = '". $SupId ."' ";
			$sql="SELECT glaccounts.strAccID AS GLAccId, glaccounts.strDescription AS GLAccDesc, invoiceglbreakdown.dblAmount AS GLAccAmt,glallocationforsupplier.strFactoryId
			FROM invoiceheader
			Inner Join invoiceglbreakdown ON invoiceheader.strInvoiceNo = invoiceglbreakdown.strInvoiceNo
			Inner Join glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID
			Inner Join glallocationforsupplier ON glallocationforsupplier.strAccID = glaccounts.strAccID
			WHERE invoiceheader.strInvoiceNo = '". $InvNo ."' AND invoiceheader.strSupplierId = '". $SupId ."'
			group by glallocationforsupplier.strFactoryId,glaccounts.strAccID order by GLAccId";*/
			
			$sql = "SELECT
					invoiceglbreakdown.dblAmount AS GLAccAmt,
					invoiceglbreakdown.strAccID as AID,
					glallowcation.GLAccNo,
					glallowcation.FactoryCode,
					glaccounts.strDescription,invoiceheader.strInvoiceNo,
					concat(glaccounts.strAccID,'',costcenters.strCode) AS ACC
					FROM
					invoiceheader
					Inner Join invoiceglbreakdown ON invoiceheader.strInvoiceNo = invoiceglbreakdown.strInvoiceNo and invoiceheader.strSupplierId=invoiceglbreakdown.strSupplierId
					Inner Join glallowcation ON invoiceglbreakdown.strAccID = glallowcation.GLAccAllowNo
					Inner Join glaccounts ON glaccounts.intGLAccID = glallowcation.GLAccNo
					inner join costcenters on costcenters.intCostCenterId = glallowcation.FactoryCode 
					WHERE invoiceheader.strInvoiceNo = '$InvNo' AND invoiceheader.strSupplierId = '$SupId' and invoiceheader.strType='$strPaymentType' and invoiceglbreakdown.intGLCategory='0'";

	//echo $sql;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadPoDetailsEdit")== 0)
{
	$SupId		 = $_GET["SupplierId"];
	$InvNo 		 = $_GET["InvoiceNo"];
	$PaymentType = $_GET["PaymentType"];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadPoDetailsEdit($SupId,$InvNo,$PaymentType);
	while($row = mysql_fetch_array($result))
	{
		$advPOBal = ($row["paidAmount"]==""?0.0000:$row["paidAmount"]);
		$ResponseXML .= "<PO><![CDATA[" . $row["POYear"] . "/" . $row["PONo"] . "]]></PO>\n";
		$ResponseXML .= "<Currency><![CDATA[" . $row["POCRR"]  . "]]></Currency>\n";
		$ResponseXML .= "<POAmount><![CDATA[" . $row["POValue"]  . "]]></POAmount>\n";
		$ResponseXML .= "<AdvancedPOBal><![CDATA[" . $advPOBal . "]]></AdvancedPOBal>\n";
		$ResponseXML .= "<POBalance><![CDATA[" . $row["POBalance"]  . "]]></POBalance>\n";
		$ResponseXML .= "<Selected><![CDATA[True]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadPoDetailsEdit($SupId,$InvNo,$PaymentType)
{
	global $db;
	//print("aaa");
	if($PaymentType=="S")
	{
		$sql= "SELECT purchaseorderheader.intYear AS POYear, purchaseorderheader.intPONo AS PONo, 
				purchaseorderheader.strCurrency AS Currency, purchaseorderheader.dblPOValue AS POValue,
				purchaseorderheader.dblPOBalance AS POBalance,
				APO.paidAmount,
				currencytypes.strCurrency as POCRR
				FROM purchaseorderheader
				left Join advancepaymentpos APO ON APO.POno=purchaseorderheader.intPONo and APO.POYear=purchaseorderheader.intYear
				Inner Join invoicedetails ON invoicedetails.intPONO = purchaseorderheader.intPONo AND
				invoicedetails.intPOYear = purchaseorderheader.intYear
				Inner Join currencytypes ON purchaseorderheader.strCurrency = currencytypes.intCurID
				WHERE (invoicedetails.strInvoiceNo =  '". $InvNo ."') AND (invoicedetails.strSupplierId =  '". $SupId ."')" ;
	//echo $sql;
	}
	else if($PaymentType=="G")
	{
		$sql= "SELECT GPOH.intYear AS POYear, GPOH.intGenPONo AS PONo,
				GPOH.strCurrency AS POCRR, 
				sum(GPOD.dblUnitPrice*GPOD.dblQty) AS POValue,
				APO.paidAmount,
				GPOH.dblPoBalance AS POBalance
				FROM generalpurchaseorderheader GPOH
				Inner Join generalpurchaseorderdetails GPOD ON GPOH.intGenPONo = GPOD.intGenPoNo AND GPOH.intYear = GPOD.intYear
				left Join advancepaymentpos APO ON APO.POno=GPOH.intGenPONo and APO.POYear=GPOH.intYear
				Inner Join gengrnheader GH ON GH.intGenPONo = GPOH.intGenPONo AND GH.intGenPOYear = GPOH.intYear
				Inner Join gengrndetails GD ON GD.strGenGrnNo = GH.strGenGrnNo AND GD.intYear = GH.intYear 
				AND GD.intMatDetailID = GPOD.intMatDetailID AND GD.strUnit = GPOD.strUnit
				where GH.strInvoiceNo =  '$InvNo' AND
				GPOH.intStatus <>'11' AND
				GPOH.intSupplierID ='$SupId'
				GROUP BY GH.strInvoiceNo" ;

	}
	else if($PaymentType=="B")
	{
		$sql= "SELECT
				bulkpurchaseorderheader.intYear AS POYear,
				bulkpurchaseorderheader.intBulkPoNo AS PONo,
				bulkpurchaseorderheader.strCurrency AS Currency,
				bulkpurchaseorderheader.dblTotalValue AS POValue,
				bulkpurchaseorderheader.dblPoBalance AS POBalance,
				APO.paidAmount,
				currencytypes.strCurrency AS POCRR
				FROM bulkpurchaseorderheader
				left Join advancepaymentpos APO ON APO.POno=bulkpurchaseorderheader.intBulkPONo and APO.POYear=bulkpurchaseorderheader.intYear
				Inner Join invoicedetails ON invoicedetails.intPONO = bulkpurchaseorderheader.intBulkPoNo AND
				invoicedetails.intPOYear = bulkpurchaseorderheader.intYear
				Inner Join currencytypes ON bulkpurchaseorderheader.strCurrency = currencytypes.intCurID
				WHERE (invoicedetails.strInvoiceNo =  '". $InvNo ."') AND (invoicedetails.strSupplierId =  '". $SupId ."')" ;

	//echo $sql;
	}
	//echo($sql);
	
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"ShowAllTaxExst")== 0)
{
	$InvNo 		 = $_GET["InvoiceNo"];
	$SupId 		 = $_GET["SupplierId"];
	$PaymentType = $_GET["PaymentType"];
	
	$ResponseXML .= "<Result>\n";
	$result=ShowAllTaxExst($InvNo,$SupId,$PaymentType);
//	$result=ShowAllTaxExst();
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<TaxID><![CDATA[" . $row["TaxID"]  . "]]></TaxID>\n";
		$ResponseXML .= "<TaxAmt><![CDATA[" . $row["TaxAmt"]  . "]]></TaxAmt>\n";
		$ResponseXML .= "<Selected><![CDATA[False]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function ShowAllTaxExst($InvNo,$SupId,$PaymentType)
{
	global $db;
	$sql= "SELECT taxtypes.strTaxTypeID AS TaxID, invoicetaxes.dblamount As TaxAmt
			FROM taxtypes
			Inner Join invoicetaxes ON invoicetaxes.strtaxtypeid = taxtypes.strTaxTypeID
			WHERE invoicetaxes.strinvoiceno = '". $InvNo ."' AND invoicetaxes.strsupplierid = '". $SupId ."' ";
	return $db->RunQuery($sql);
}
if(strcmp($RequestType,"getDescription")== 0)
{
	$InvNo = $_GET["InvoiceNo"];
	$SupId = $_GET["SupplierId"];
	$type=$_GET['type'];
	
	$ResponseXML .= "<Result>\n";
	$result=getDescription($InvNo,$SupId,$type);
//	$result=ShowAllTaxExst();
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<PONo><![CDATA[" . $row["PO"]  . "]]></PONo>\n";
		$ResponseXML .= "<Selected><![CDATA[False]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function getDescription($InvNo,$SupId,$type)
{
global $db;
 if($type=='S'){
	
	$sql= "SELECT DISTINCT
				concat(purchaseorderheader.intYear,'/',purchaseorderheader.intPONo) AS PO
				
				FROM
				purchaseorderheader
				Inner Join grnheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear
				Inner Join grndetails ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear
				left Join purchaseorderdetails ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND purchaseorderdetails.intYear = purchaseorderheader.intYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO
				WHERE ";
				if(!empty($InvNo)){$sql.="(grnheader.strInvoiceNo =  '$InvNo') AND";}
				$sql.="(grnheader.intStatus = '1') AND (purchaseorderheader.strSupplierID =  '$SupId') AND (purchaseorderheader.intStatus <> '11')
				GROUP BY
				grnheader.intGrnNo,
				grnheader.intGRNYear;" ;
				//echo $sql;
	return $db->RunQuery($sql);
	}
	else if($type=='G'){
		$sql="select distinct
				concat(generalpurchaseorderheader.intYear,'/',generalpurchaseorderheader.intGenPONo) AS PO
				from 
				generalpurchaseorderheader
				Inner Join gengrnheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo 
				AND gengrnheader.intYear = generalpurchaseorderheader.intYear
				Inner Join gengrndetails ON gengrndetails.strGenGrnNo = gengrnheader.strGenGrnNo 
				AND gengrndetails.intYear = gengrnheader.intYear
				left Join generalpurchaseorderdetails ON generalpurchaseorderdetails.intGenPoNo = generalpurchaseorderheader.intGenPONo 
				AND generalpurchaseorderdetails.intYear = generalpurchaseorderheader.intYear 
				AND generalpurchaseorderdetails.intMatDetailID = gengrndetails.intMatDetailID 
				WHERE  gengrnheader.strInvoiceNo ='$InvNo' AND gengrnheader.intStatus = '1' 
				AND (generalpurchaseorderheader.intSupplierID =  '$SupId')
				AND (generalpurchaseorderheader.intStatus <> '11')
				GROUP BY  gengrnheader.strGenGrnNo,gengrnheader.intYear;";
				return $db->RunQuery($sql);
	}
	else if($type=='B'){
		$sql="select distinct
				concat(bulkpurchaseorderheader.intYear,'/',bulkpurchaseorderheader.intBulkPONo) AS PO
				from 
				bulkpurchaseorderheader
				Inner Join bulkgrnheader ON bulkgrnheader.intBulkPONo = bulkpurchaseorderheader.intBulkPONo  
				AND bulkgrnheader.intYear = bulkpurchaseorderheader.intYear
				Inner Join bulkgrndetails ON bulkgrndetails.intBulkGrnNo = bulkgrnheader.intBulkGrnNo
				AND bulkgrndetails.intYear = bulkgrnheader.intYear
				left Join bulkpurchaseorderdetails ON bulkpurchaseorderdetails.intBulkPoNo = bulkpurchaseorderheader.intBulkPONo 
				AND bulkpurchaseorderdetails.intYear = bulkpurchaseorderheader.intYear 
				AND bulkpurchaseorderdetails.intMatDetailID = bulkgrndetails.intMatDetailID 
				WHERE  bulkgrnheader.strInvoiceNo =  '$InvNo' AND bulkgrnheader.intStatus = '1' 
				AND (bulkpurchaseorderheader.strSupplierID =  '$SupId')
				AND (bulkpurchaseorderheader.intStatus <> '11');";
				//echo $sql;
				return $db->RunQuery($sql);
	}
}
//lasantha ------------ load currency rate===///////////
function SaveAccPaccInvoiceHeader($InvNo,$SupId,$InvDt,$batchno,$TotalAmt,$ArrPoNo,$invDescription,$dueDate,$InvDt,$VatGLAmt,$TotalTaxAmt,$CurrencyRate,$Currency)
{
	global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$dueDate=split('/',$dueDate);
	$dueDate=$dueDate[2].'-'.$dueDate[1].'-'.$dueDate[0];
	$PONo='';
	$explodePoNo = explode(',', $ArrPoNo);
	for ($i = 0;$i < count($explodePoNo)-1;$i++)
	{
		$PONo = explode('/', $explodePoNo[$i]);
		$PONo=$PONo[1];	
	}	
	
	$sqlVANo="select strVatRegNo from suppliers where strSupplierID='$SupId';";
	$resVANo=$db->RunQuery($sqlVANo);
	$row=mysql_fetch_array($resVANo);
	$vAccNo=$row['strVatRegNo'];
	(!empty($vAccNo))?$vAccNo=$vAccNo:$vAccNo=0;
	$sql="INSERT INTO accpacinvoiceheader(strInvoiceNo,strsupplierId,dtmDate,strBatchNo,strEntryNo,dblTotalAmount,strPoNumber,strInvDescription,dtmDateDue,dtmAccDate,dblTotalVat,strTextTRX,intStatus,strVatAcNo,dblCurrencyRate,strCurrency)
		  VALUES('$InvNo','$SupId','$InvDt','$batchno','$entryNo','$TotalAmt','$PONo','$invDescription','$dueDate','$InvDt','$VatGLAmt','$TotalTaxAmt','1','$vAccNo','$CurrencyRate','$Currency');";
	//echo $sql;
	$db->RunQuery($sql);
	$sqlUpBatch="update batch set intUsed='1' where intBatch='$batchno';";
	$db->RunQuery($sqlUpBatch);
	
	$strSQLE="UPDATE batch SET intEntryNo=intEntryNo+1 WHERE intBatch='$batchno';";
	$db->RunQuery($strSQLE);
}

function UpdateAccPaccInvoiceHeader($InvNo,$SupId,$InvDt,$batchno,$entryNo,$TotalAmt,$ArrPoNo,$invDescription,$dueDate,$InvDt,$VatGLAmt,$TotalTaxAmt,$CurrencyRate,$Currency){
global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$dueDate=split('/',$dueDate);
	$dueDate=$dueDate[2].'-'.$dueDate[1].'-'.$dueDate[0];
	$PONo='';
	$explodePoNo = explode(',', $ArrPoNo);
	for ($i = 0;$i < count($explodePoNo)-1;$i++)
	{
		$PONo = explode('/', $explodePoNo[$i]);
		$PONo=$PONo[1];	
	}	
	
	$sqlVANo="select strVatRegNo from suppliers where strSupplierID='$SupId';";
	$resVANo=$db->RunQuery($sqlVANo);
	$row=mysql_fetch_array($resVANo);
	$vAccNo=$row['strVatRegNo'];
	(!empty($vAccNo))?$vAccNo=$vAccNo:$vAccNo=0;
	$sql="UPDATE accpacinvoiceheader set
			dtmDate	='$InvDt',
			strBatchNo	='$batchno',
			strEntryNo	='$entryNo',
			dblTotalAmount	='$TotalAmt',
			strPoNumber	='$PONo',
			strInvDescription	='$invDescription',
			dtmDateDue	='$dueDate',
			dtmAccDate	='$InvDt',
			dblTotalVat	='$VatGLAmt',
			strTextTRX	='$TotalTaxAmt',
			intStatus	='1',
			strVatAcNo	='$vAccNo',
			dblCurrencyRate	='$CurrencyRate',
			strCurrency	='$Currency'
			WHERE strInvoiceNo	='$InvNo' AND strsupplierId	='$SupId';";
	//echo $sql;
	$db->RunQuery($sql);
}

function SaveAccPaccInvoiceDetails($InvNo,$SupId,$batchno,$entryNo,$lineNo,$explodeGlAcc,$explodeGlAmt){
	global $db;
	$sql="INSERT INTO accpacinvoicedetails(strInvoiceNo,strSupplierID,strBatchNo,strEntryNo,strLineNo,strGLAccountId,dblAmount)
		  VALUES('$InvNo','$SupId','$batchno','$entryNo','$lineNo','$explodeGlAcc','$explodeGlAmt');";
	$db->RunQuery($sql);
}
function DeleteAccPaccInvoiceDetails($InvNo,$SupId){
	global $db;
	$sql="DELETE FROM accpacinvoicedetails WHERE strInvoiceNo='$InvNo' AND strSupplierID='$SupId';";
	$db->RunQuery($sql);
}
if(strcmp($RequestType,"loadCurrate")== 0){
	
	$SupID   = $_GET['SupID'];
	$InvNo   = $_GET['InvNo'];
	$payType = $_GET['payType'];

	$ResponseXML .= "<Result>\n";
	
	if($payType=='S')
	{
		$sql="select avg(GH.dblExRate) as dblExRate
				from grnheader GH
				inner join purchaseorderheader PO on PO.intPONo=GH.intPoNo and PO.intYear=GH.intYear
				where GH.strInvoiceNo ='$InvNo'
				and PO.strSupplierID='$SupID'; ";
		$result=$db->RunQuery($sql);
	}
	if($payType=='B')
	{
		$sql="select avg(BGH.dblRate) as dblExRate
				from bulkgrnheader BGH
				inner join bulkpurchaseorderheader BPO on BPO.intBulkPoNo=BGH.intBulkPoNo and BPO.intYear=BGH.intBulkPoYear
				where BGH.strInvoiceNo ='$InvNo'
				and BPO.strSupplierID='$SupID' ";
		$result=$db->RunQuery($sql);
	}
	if($payType=='G')
	{
		$sql="select avg(GGH.dblExRate) as dblExRate
				from gengrnheader GGH
				inner join generalpurchaseorderheader GPO on GPO.intGenPONo=GGH.intGenPONo and GPO.intYear=GGH.intGenPOYear
				where GGH.strInvoiceNo ='$InvNo'
				and GPO.intSupplierID='$SupID' ";
		$result=$db->RunQuery($sql);
	}
	while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<Rate><![CDATA[" . $row["dblExRate"]  . "]]></Rate>\n";
		}
		
	$ResponseXML .= "</Result>\n";
	echo $ResponseXML;
}
if(strcmp($RequestType,"loadInvOther")==0){
	$InvNo=$_GET['invNo'];
	$ResponseXML .= "<Result>\n";
	$sql="SELECT invoiceheader.dblCommission,invoiceheader.dblFreight,invoiceheader.dblInsurance,invoiceheader.dblOther,invoiceheader.dblVatGL,accpacinvoiceheader.strEntryNo
			FROM
			invoiceheader
			INNER JOIN accpacinvoiceheader ON accpacinvoiceheader.strInvoiceNo=invoiceheader.strInvoiceNo
			WHERE
			invoiceheader.strInvoiceNo =  '$InvNo';";
	$res=$db->RunQuery($sql);
	while ($row=mysql_fetch_array($res)) {

	$ResponseXML .= "<Commission><![CDATA[" .  $row["dblCommission"] . "]]></Commission>\n";
	$ResponseXML .= "<Freight><![CDATA[" . $row["dblFreight"]  . "]]></Freight>\n";
	$ResponseXML .= "<Insurance><![CDATA[" . $row["dblInsurance"]  . "]]></Insurance>\n";
	$ResponseXML .= "<Other><![CDATA[" . $row["dblOther"]  . "]]></Other>\n";
	$ResponseXML .= "<VATGLAcc><![CDATA[" . $row["dblVatGL"]  . "]]></VATGLAcc>\n";
	//$ResponseXML .= "<LineNo><![CDATA[" . $row["dblVatGL"]  . "]]></LineNo>\n";
	$ResponseXML .= "<EntryNo><![CDATA[" . $row["strEntryNo"]  . "]]></EntryNo>\n";
	}
	$ResponseXML .= "</Result>\n";
	echo $ResponseXML;
}
if(strcmp($RequestType,"loadBatchNo")==0){
	$InvNo=$_GET['invNo'];
	$SupNo=$_GET['supNo'];
	
	$ResponseXML .= "<Result>\n";
	$sql="SELECT strBatchNo,intEntryNo,intLineNo FROM invoiceheader WHERE strInvoiceNo='$InvNo' AND strSupplierId='$SupNo';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	while ($row=mysql_fetch_array($res)) {

	$ResponseXML .= "<BatchNo><![CDATA[" .  $row["strBatchNo"] . "]]></BatchNo>\n";
	$ResponseXML .= "<EntryNo><![CDATA[" .  $row["intEntryNo"] . "]]></EntryNo>\n";
	$ResponseXML .= "<LineNo><![CDATA[" .  $row["intLineNo"] . "]]></LineNo>\n";
	
	}
	$ResponseXML .= "</Result>\n";
	echo $ResponseXML;
}
if(strcmp($RequestType,"loadCharges")==0){
	$InvNo=$_GET['invNo'];
	$SupNo=$_GET['supNo'];
	$tbl=$_GET['tbl'];
	$ResponseXML .= "<Result>\n";
	$res=loadCharges($InvNo,$SupNo,$strPaymentType,$tbl);
	while($row=mysql_fetch_array($res)){
		$ResponseXML .= "<AccName><![CDATA[" .  $row["AccName"] . "]]></AccName>\n";
		$ResponseXML .= "<Description><![CDATA[" .  $row["strDescription"] . "]]></Description>\n";
		$ResponseXML .= "<GLAccAllowNo><![CDATA[" .  $row["GLAccAllowNo"] . "]]></GLAccAllowNo>\n";
		$ResponseXML .= "<Amount><![CDATA[" .  $row["dblAmount"] . "]]></Amount>\n";
	}
	$ResponseXML .= "</Result>\n";
	echo $ResponseXML;
}

/*if(strcmp($RequestType,"getEntryNo")==0){
$Batch=$_GET['batchNo'];//strInvoiceNo='$InvNo'and
	//$sql="select max(strEntryNo)+1 as ENTRYNO from accpacinvoiceheader where strBatchNo='$Batch';";
	$sql="select max(intEntryNo)+1 ENTRYNO from batch where intBatch='$Batch';";
	$res=$db->RunQuery($sql);
	$entryNo=mysql_fetch_array($res);
	$ResponseXML .= "<Result>\n";
	
	if( $entryNo["ENTRYNO"] > 0 ){
		$ResponseXML .= "<EntryNo><![CDATA[" . $entryNo["ENTRYNO"] . "]]></EntryNo>\n";
	}
	else{
		$ResponseXML .= "<EntryNo><![CDATA[" . 1 . "]]></EntryNo>\n";
	}
	$ResponseXML .= "</Result>\n";
	echo $ResponseXML;
}*/

function loadCharges($InvNo,$SupNo,$strPaymentType,$tbl){
	global $db;
	$sql="SELECT
		concat(glaccounts.strAccID,'',companies.strAccountNo) AS AccName,
		glaccounts.strDescription,
		glallowcation.FactoryCode,
		companies.strName,
		glallowcation.GLAccAllowNo,
		tbl.dblAmount
		FROM
		`$tbl` as tbl
		Inner Join glallowcation ON tbl.intAccID = glallowcation.GLAccAllowNo
		Inner Join glaccounts ON glallowcation.GLAccNo = glaccounts.intGLAccID
		Inner Join companies ON companies.intCompanyID = glallowcation.FactoryCode
		WHERE
		tbl.strInvoiceNo =  '$InvNo' AND
		tbl.intSupplierId =  '$SupNo' AND
		tbl.strType =  '$strPaymentType';";
		//echo $sql;
		$res=$db->RunQuery($sql);
		return $res;
}

if(strcmp($RequestType,"getTotalGrnValue")== 0)
{
	$SupId = $_GET["SupplierId"];
	$InvNo = $_GET["InvoiceNo"];
	
	$ResponseXML .= "<Result>\n";
	$result=getGrnValue($InvNo,$SupId);
	while($row = mysql_fetch_array($result))
	{
		
		$ResponseXML .= "<grnAmount><![CDATA[" . $row["totalGrnValue"]  . "]]></grnAmount>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function getGrnValue($invNo,$supId){
	global $db;
	$sql="SELECT

				sum(grndetails.dblQty * purchaseorderdetails.dblUnitPrice) as totalGrnValue
				
				FROM
				purchaseorderheader
				Inner Join grnheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear
				Inner Join grndetails ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear
				left Join purchaseorderdetails ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND purchaseorderdetails.intYear = purchaseorderheader.intYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO
				WHERE (grnheader.strInvoiceNo =  '$invNo') AND (grnheader.intStatus = '1') AND (purchaseorderheader.strSupplierID =  '$supId') AND (purchaseorderheader.intStatus <> '11')
				GROUP BY
				purchaseorderheader.intPONo,
				purchaseorderheader.intYear;";
				return $db->RunQuery($sql);						
}
if($RequestType=="loadGLDetailstoGrid")
{
	$GLID = $_GET["GLID"];
	$ResponseXML .= "<GLData>\n";
	
		$sql_glData = "select distinct gla.FactoryCode,gl.strDescription,concat(gl.strAccID,c.strCode) as glCode,gla.GLAccAllowNo from  glallowcation gla 
					inner join glaccounts gl on gl.intGLAccID=gla.GLAccNo
					inner join costcenters c on c.intCostCenterId = gla.FactoryCode
					where concat(gl.strAccID,c.strCode)='$GLID'";
					
		$result_glData = $db->RunQuery($sql_glData);
		if(mysql_num_rows($result_glData)<1)
		{
			$ResponseXML .= "<accId><![CDATA[" . $row["GLAccAllowNo"]  . "]]></accId>\n";
			$ResponseXML .= "<accDes><![CDATA[" . $row["strDescription"]  . "]]></accDes>\n";
		}
		else
		{
			while($row = mysql_fetch_array($result_glData))
			 {
				$ResponseXML .= "<accId><![CDATA[" . $row["GLAccAllowNo"]  . "]]></accId>\n";
				$ResponseXML .= "<accDes><![CDATA[" . $row["strDescription"]  . "]]></accDes>\n";
			 }
		}
			 echo $ResponseXML .= "</GLData>\n";
				
}
function LoadInvoiceDate($invoiceNo,$paymentType,$supplierId)
{
global $db;
if($paymentType=='S')
{
	$sql="SELECT DISTINCT date(GH.dtmConfirmedDate)as invoiceDate FROM grnheader GH Inner Join purchaseorderheader PH ON GH.intPoNo = PH.intPONo AND GH.intYear = PH.intYear WHERE GH.strInvoiceNo = '$invoiceNo' and GH.intStatus = 1 and PH.strSupplierID= '$supplierId' order by GH.dtmConfirmedDate limit 1";
}
elseif($paymentType=='G')
{
	$sql="SELECT DISTINCT date(GH.dtmConfirmedDate)as invoiceDate FROM gengrnheader GH Inner Join generalpurchaseorderheader PH ON GH.intGenPONo = PH.intGenPONo AND GH.intGenPOYear = PH.intYear WHERE GH.strInvoiceNo = '$invoiceNo' and GH.intStatus = 1 and PH.intSupplierID= '$supplierId' order by GH.dtmConfirmedDate limit 1";
}
elseif($paymentType=='B')
{
	$sql="SELECT DISTINCT date(GH.dtmConfirmedDate)as invoiceDate FROM bulkgrnheader GH Inner Join bulkpurchaseorderheader PH ON GH.intBulkPoNo = PH.intBulkPoNo AND GH.intBulkPoYear = PH.intYear WHERE GH.strInvoiceNo = '$invoiceNo' and GH.intStatus = 1 and PH.strSupplierID= '$supplierId' order by GH.dtmConfirmedDate limit 1";
}
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return dateSet($row["invoiceDate"]);
	}
}

function getGLAccList($facID,$NameLike)
{
	global $db;
   // $strSQL="SELECT  * FROM glaccounts WHERE strFacCode='$facID' and strDescription like '$NameLike%'";

	//echo $strSQL;
$strSQL="SELECT glaccounts.strAccID,costcenters.strCode,glaccounts.strDescription, glallowcation.GLAccAllowNo FROM glallowcation INNER JOIN glaccounts ON glallowcation.GLAccNo = glaccounts.intGLAccID inner join costcenters on costcenters.intCostCenterId=glallowcation.FactoryCode ";
if($facID!="")
	$strSQL .= "and costcenters.intCostCenterId='$facID' ";
if($NameLike!="")
	$strSQL.= "and concat(glaccounts.strAccID,'',costcenters.strCode) like '%$NameLike%' ";

	$result=$db->RunQuery($strSQL);
	return $result;
}
?>