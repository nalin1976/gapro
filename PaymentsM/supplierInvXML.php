<?php
session_start();
include "../Connector.php";

$FactoryID = $_SESSION["FactoryID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
$strPaymentType=$_GET["strPaymentType"];

if($RequestType == "saveSupWiseGlAllocation"){
 $supID   = $_GET["supID"];
 $rwGLAcc = $_GET["rwGLAcc"];
 
 $sql1 = "SELECT
			glallocationforsupplier.strSupplierId,
			glallocationforsupplier.strAccID,
			glallocationforsupplier.strFactoryId
			FROM
			glallocationforsupplier WHERE glallocationforsupplier.strSupplierId='$supID' AND glallocationforsupplier.strAccID='$rwGLAcc' AND 
			glallocationforsupplier.strFactoryId = '$FactoryID'";
$result1=$db->RunQuery($sql1);
 if(!mysql_num_rows($result1)){
  $sql2 = "insert into glallocationforsupplier(strSupplierId,strAccID,strFactoryId)values('$supID','$rwGLAcc','$FactoryID')";
  $result2=$db->RunQuery($sql2);
 }
}

if(strcmp($RequestType,"SearchInvoiceNo")== 0)
{
	$InvNo = $_GET["InvoiceNo"];

	$ResponseXML .= "<Result>\n";
	$result=SearchInvoiceNo($InvNo,$strPaymentType);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<SupId><![CDATA[" . $row["SupID"]  . "]]></SupId>\n";
		$ResponseXML .= "<SupNm><![CDATA[" . $row["SupNm"]  . "]]></SupNm>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
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
		$sql= "SELECT DISTINCT suppliers.strSupplierID AS SupID, suppliers.strTitle AS SupNm FROM grnheader Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear =  purchaseorderheader.intYear Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID WHERE grnheader.strInvoiceNo = '". $InvNo ."' AND grnheader.intStatus = 1 " ;
	}
	else if($strPaymentType=="G")
	{
		$sql= "SELECT DISTINCT suppliers.strSupplierID AS SupID, suppliers.strTitle AS SupNm FROM gengrnheader Inner Join generalpurchaseorderheader ON gengrnheader.intGenPONo=generalpurchaseorderheader.intGenPONo AND gengrnheader.intGenPOYear =  generalpurchaseorderheader.intYear Inner Join suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID WHERE gengrnheader.strInvoiceNo = '". $InvNo ."' AND gengrnheader.intStatus = 1 " ;

	}
   else if($strPaymentType=="B")
	{
		$sql= "SELECT
				suppliers.strTitle AS SupNm,
				suppliers.strSupplierID AS SupID
				FROM
				bulkgrnheader
				Inner Join bulkpurchaseorderheader ON bulkpurchaseorderheader.intBulkPoNo = bulkgrnheader.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkgrnheader.intBulkPoYear
				Inner Join suppliers ON bulkpurchaseorderheader.strSupplierID = suppliers.strSupplierID
				WHERE
				bulkgrnheader.strInvoiceNo  =  '".$InvNo."' AND
				bulkgrnheader.intStatus =  '1' order by   suppliers.strTitle;" ;//COLLATE latin1_bin

	}
	//echo($sql);

	return $db->RunQuery($sql);
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
		$ResponseXML .= "<POCurrency><![CDATA[" . $row["POCurrency"]  . "]]></POCurrency>\n";
		$ResponseXML .= "<CreditDays><![CDATA[" . $row["CreditDays"]  . "]]></CreditDays>\n";
	}

	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function GetSupplierInvoiceDetails($InvNo,$SupId,$strPaymentType)
{
	global $db;

	
	if($strPaymentType=="S")
	{
		//changed to invoice to company id by roshan advice by nishantha.2010-09-22
/*		 $sql= "	SELECT DISTINCT companies.intCompanyID AS CompId, companies.strName AS CompNm, companies.strComCode AS CompCd,suppliers.strAccPaccID AS AccPacID, purchaseorderheader.strCurrency AS POCurrency, creditperiods.dblNoOfDays AS CreditDays FROM grnheader Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear =  purchaseorderheader.intYear Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID Inner Join companies ON purchaseorderheader.intDelToCompID = companies.intCompanyID Left Outer Join creditperiods ON suppliers.intCreditPeriod = creditperiods.intSerialNO WHERE grnheader.strInvoiceNo = '". $InvNo ."' AND grnheader.intStatus =  '1' AND suppliers.strSupplierID =  '". $SupId ."' " ;*/
		 
		 $sql = "SELECT DISTINCT
					companies.intCompanyID AS CompId,
					companies.strName AS CompNm,
					companies.strComCode AS CompCd,
					suppliers.strAccPaccID AS AccPacID,
					creditperiods.dblNoOfDays AS CreditDays,
					currencytypes.strCurrency AS POCurrency
					FROM
					grnheader
					Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear
					Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
					Inner Join companies ON purchaseorderheader.intDelToCompID = companies.intCompanyID
					Left Outer Join creditperiods ON suppliers.intCreditPeriod = creditperiods.intSerialNO
					Inner Join currencytypes ON purchaseorderheader.strCurrency = currencytypes.intCurID
					WHERE grnheader.strInvoiceNo = '". $InvNo ."' AND grnheader.intStatus =  '1' AND suppliers.strSupplierID =  '". $SupId ."' " ;
		
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
			left Join creditperiods ON creditperiods.intSerialNO = suppliers.intCreditPeriod
			WHERE
			bulkgrnheader.strInvoiceNo =  '$InvNo' AND
			bulkgrnheader.intStatus =  '1' AND
			suppliers.strSupplierID =  '$SupId'";
	}
	//echo($sql);
			 
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadCurrency")== 0)
{
	$invNo=$_GET['invNo'];
	$ResponseXML .= "<Result>\n";
	$result=LoadCurrency($invNo);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<CurrCd><![CDATA[" . $row["strCurrency"]  . "]]></CurrCd>\n";
		$ResponseXML .= "<CurrDesc><![CDATA[" . $row["CurrencyDesc"]  . "]]></CurrDesc>\n";
		$ResponseXML .= "<Rate><![CDATA[" . $row["Rate"]  . "]]></Rate>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}




function LoadCurrency($invNo)
{
/*SELECT currencytypes.strCurrency AS CurrencyCode, currencytypes.strTitle AS CurrencyDesc, exchangerate.rate AS Rate
			FROM currencytypes 
			JOIN exchangerate
	       ON exchangerate.currencyID=currencytypes.intCurID
			WHERE currencytypes.intStatus =  '1' AND  exchangerate.intStatus =  '1' "*/
	global $db;
	$sql= "SELECT currencytypes.strTitle AS CurrencyDesc,exchangerate.rate AS Rate,currencytypes.strCurrency
			FROM
			currencytypes
			Inner Join exchangerate ON exchangerate.currencyID = currencytypes.intCurID
			Inner Join invoiceheader ON invoiceheader.strCurrency = currencytypes.strCurrency
			WHERE
			currencytypes.intStatus =  '1' AND
			exchangerate.intStatus =  '1' AND
			invoiceheader.strInvoiceNo =  '$invNo';";
	//echo $sql;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadCreditPeriod")== 0)
{
	$ResponseXML .= "<Result>\n";
	$result=LoadCreditPeriod();
	while($row = mysql_fetch_array($result))
	{
	    $CreditPeriod = $row["CreditPeriod"];
		$NoOfDays     = $row["NoOfDays"];
		
		$ResponseXML .= "<option value='$NoOfDays'>$CreditPeriod</option>\n";
		
/*		$ResponseXML .= "<CreditPrd><![CDATA[" . $row["CreditPeriod"]  . "]]></CreditPrd>\n";
		$ResponseXML .= "<NoOfDays><![CDATA[" . $row["NoOfDays"]  . "]]></NoOfDays>\n";*/
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadCreditPeriod()
{
	global $db;
	$sql= "	SELECT creditperiods.strDescription AS CreditPeriod, creditperiods.dblNoOfDays AS NoOfDays 
			FROM creditperiods WHERE creditperiods.intStatus = '1'  " ;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadBatch")== 0)
{
	$ResponseXML .= "<Result>\n";
	$result=LoadBatch();
	$ResponseXML .= "<option></option>\n";
	while($row = mysql_fetch_array($result))
	{
/*		$ResponseXML .= "<BatchId><![CDATA[" . $row["BatchId"]  . "]]></BatchId>\n";
		$ResponseXML .= "<BatchDesc><![CDATA[" . $row["BatchDesc"]  . "]]></BatchDesc>\n";*/
		$BatchId = $row["BatchId"];
		$BatchDesc = $row["BatchDesc"];
		$ResponseXML .= "<option value='$BatchId'>$BatchDesc</option>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadBatch()
{
    $intCompany = $_SESSION["FactoryID"];
	global $db;
	$sql= "SELECT batch.intBatch AS BatchId, batch.strDescription AS BatchDesc FROM batch  WHERE batch.posted =  '0' AND batch.intBatchType =  '1'
	       AND intCompID = '$intCompany'" ;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadSupplierGL")== 0)
{
	$SupId = $_GET["SupplierId"];
	$FacCd = $_GET["FactoryCode"];
	
	$ResponseXML .= "<Result>\n";
	$sqlBtNo="SELECT strBatchNo FROM invoiceheader  WHERE strSupplierId='$SupId';";
	$res=$db->RunQuery($sqlBtNo);
	
	while ($row=mysql_fetch_array($res)) {
		$ResponseXML .= "<BTNO><![CDATA[" . $row["strBatchNo"]  . "]]></BTNO>\n";
	}
	
	$result=LoadSupplierGL($SupId,$FacCd);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<GLAccId><![CDATA[" . $row["GLAccId"]  . "]]></GLAccId>\n";
		$ResponseXML .= "<GLAccDesc><![CDATA[" . $row["GLAccDesc"]  . "]]></GLAccDesc>\n";
		$ResponseXML .= "<Selected><![CDATA[False]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadSupplierGL($SupId,$FacCd)
{
	global $db;
	$intCompany = $_SESSION["FactoryID"];
/*	$sql= "SELECT glaccounts.strAccID AS GLAccId, glaccounts.strDescription AS GLAccDesc, glaccounts.strFacCode AS FacCd
			FROM glallocationforsupplier
			Inner Join glaccounts ON glallocationforsupplier.strAccID = glaccounts.strAccID
			WHERE (glallocationforsupplier.strSupplierId = '". $SupId ."') AND (glaccounts.strFacCode = '". $FacCd ."') " ;	*/
			//echo $sql;
	$sql = "SELECT
				glaccounts.strDescription AS GLAccDesc,
				glaccounts.strAccID AS GLAccId
				FROM
				glallocationforsupplier
				Inner Join glaccounts ON (glallocationforsupplier.strAccID = glaccounts.strAccID)
				WHERE
				glallocationforsupplier.strSupplierId =  '$SupId' AND
				glaccounts.intCompany =  '$intCompany'";		
	return $db->RunQuery($sql);
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
		$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$ResponseXML .= "<POAmount><![CDATA[" . $row["POAmount"]  . "]]></POAmount>\n";
		$ResponseXML .= "<POBalance><![CDATA[" . $row["dblPoBalance"]  . "]]></POBalance>\n";
		$ResponseXML .= "<grnBalance><![CDATA[" . $row["totalGrnValue"]  . "]]></grnBalance>\n";
		$ResponseXML .= "<invoiceAmount><![CDATA[" . $row["invoiceAmount"] . "]]></invoiceAmount>\n";
		$ResponseXML .= "<Selected><![CDATA[True]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadPoDetails($SupId,$InvNo,$strPaymentType)
{
	global $db;
	
	if($strPaymentType=="S")
	{
/*		$sql= "SELECT DISTINCTROW concat(purchaseorderheader.intYear,'/', purchaseorderheader.intPONo) AS PO, 			purchaseorderheader.strCurrency AS strCurrency, purchaseorderheader.dblPOValue AS POAmount, purchaseorderheader.dblPOBalance AS dblPoBalance FROM purchaseorderheader Inner Join grnheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear WHERE (grnheader.strInvoiceNo =  '". $InvNo ."') AND (grnheader.intStatus = '1') AND (purchaseorderheader.strSupplierID =  '". $SupId ."') AND (purchaseorderheader.intStatus <> '11')" ;*/


		$sql = "SELECT
				concat(purchaseorderheader.intYear,'/',purchaseorderheader.intPONo) AS PO,
				currencytypes.strCurrency AS strCurrency,
				(purchaseorderheader.dblPOValue + if(ISNULL(purchaseorderheader_excess.dblPOValue),0,purchaseorderheader_excess.dblPOValue)) AS POAmount,
				(purchaseorderheader.dblPOBalance +if( ISNULL(purchaseorderheader_excess.dblPOBalance),0,purchaseorderheader_excess.dblPOBalance)) AS dblPoBalance,
				sum(grndetails.dblValueBalance) as totalGrnValue,
(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and invoiceheader.strSupplierId =  '$SupId' and strType='S') as invoiceAmount
				
				FROM
				purchaseorderheader
				Inner Join grnheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear
				Inner Join grndetails ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear
				left Join purchaseorderdetails ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND purchaseorderdetails.intYear = purchaseorderheader.intYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO
				left join purchaseorderheader_excess  ON purchaseorderheader. intPONo = purchaseorderheader_excess.intPONo
				inner Join currencytypes on purchaseorderheader.strCurrency = currencytypes.intCurID
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

			$sql = "SELECT
						concat(generalpurchaseorderheader.intYear ,'/',generalpurchaseorderheader.intGenPONo) AS PO,
						generalpurchaseorderheader.strCurrency,
						sum(generalpurchaseorderdetails.dblUnitPrice*generalpurchaseorderdetails.dblQty) AS POAmount,
						generalpurchaseorderheader.dblPoBalance,
						
						(SELECT
							sum(gengrndetails.dblQty * gengrndetails.dblRate)as totalGrnValue
							FROM
							gengrnheader
							Inner Join gengrndetails ON gengrnheader.strGenGrnNo = gengrndetails.strGenGrnNo AND gengrnheader.intYear = gengrndetails.intYear
							WHERE
							gengrnheader.strInvoiceNo =  '$InvNo')as totalGrnValue,
			(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and invoiceheader.strSupplierId =  '$SupId' and strType='G') as invoiceAmount
			
			FROM
			generalpurchaseorderdetails
			Inner Join generalpurchaseorderheader ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPoNo 
			AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
			Inner Join gengrnheader ON gengrnheader.intGenPONo = generalpurchaseorderheader.intGenPONo 
			AND gengrnheader.intGenPOYear = generalpurchaseorderheader.intYear
			Inner Join gengrndetails ON gengrndetails.strGenGrnNo = gengrnheader.strGenGrnNo AND gengrndetails.intYear = gengrnheader.intYear
			AND gengrndetails.intMatDetailID = generalpurchaseorderdetails.intMatDetailID AND gengrndetails.strUnit = generalpurchaseorderdetails.strUnit
			WHERE
			gengrnheader.strInvoiceNo =  '$InvNo' AND
			generalpurchaseorderheader.intStatus <>  '11' AND
			generalpurchaseorderheader.intSupplierID =  '$SupId'
			GROUP BY
			generalpurchaseorderheader.intGenPoNo,
			concat(generalpurchaseorderheader.intYear)";
	}
	
	else if($strPaymentType=="B"){
		 $sql="SELECT
			concat(bulkpurchaseorderheader.intYear ,'/',bulkpurchaseorderheader.intBulkPONo) AS PO,
			bulkpurchaseorderheader.strCurrency,
			bulkpurchaseorderheader.dblTotalValue  AS POAmount,
			(select sum(bulkgrndetails.dblQty * bulkgrndetails.dblRate)  from bulkgrnheader 
			inner join bulkgrndetails on  bulkgrnheader.intBulkGrnNo = bulkgrndetails.intBulkGrnNo where bulkgrnheader.strInvoiceNo =  '$InvNo' )as dblPoBalance,			
			(select sum(bulkgrndetails.dblQty * bulkgrndetails.dblRate) as totalGrnValue 
			from bulkgrnheader inner join bulkgrndetails on 
			bulkgrnheader.intBulkGrnNo = bulkgrndetails.intBulkGrnNo and 
			bulkgrnheader.intYear = bulkgrndetails.intYear where bulkgrnheader.strInvoiceNo =  '$InvNo')as totalGrnValue,				
			(select dblAmount from invoiceheader where strInvoiceNo='$InvNo' and invoiceheader.strSupplierId =  '$SupId' and strType='B') as invoiceAmount
			FROM
			bulkpurchaseorderdetails
			Inner Join bulkpurchaseorderheader ON bulkpurchaseorderheader.intBulkPONo = bulkpurchaseorderdetails.intBulkPoNo 
			AND bulkpurchaseorderheader.intYear = bulkpurchaseorderdetails.intYear			
			Inner Join bulkgrnheader ON bulkgrnheader.intBulkPONo =bulkpurchaseorderheader.intBulkPONo 
			AND bulkgrnheader.intBulkPOYear = bulkpurchaseorderheader.intYear	
			Inner Join bulkgrndetails ON bulkgrndetails.intBulkGrnNo = bulkgrnheader.intBulkGrnNo AND bulkgrndetails.intYear = bulkgrnheader.intYear
			AND bulkgrndetails.intMatDetailID = bulkpurchaseorderdetails.intMatDetailID AND bulkgrndetails.strUnit = bulkpurchaseorderdetails.strUnit
			WHERE
						bulkgrnheader.strInvoiceNo =  '$InvNo' AND
						bulkpurchaseorderheader.intStatus <>  '11' AND
						bulkpurchaseorderheader.strSupplierID =  '$SupId'
			GROUP BY
			bulkpurchaseorderheader.intBulkPONo,bulkpurchaseorderheader.intYear";
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
	$sql= "SELECT A.strAccID AS NewGLAcc,A.strDescription AS NewGLDesc,B.strAccID AS ExistGLAcc, B.strDescription AS ExistGLDesc 
			FROM (SELECT * FROM glaccounts WHERE glaccounts.strFacCode =  '". $FacCd ."') as A
			JOIN (SELECT glaccounts.strAccID, glaccounts.strDescription, glallocationforsupplier.strSupplierId 
			FROM glaccounts 
			Inner Join glallocationforsupplier ON glallocationforsupplier.strAccID = glaccounts.strAccID
			WHERE glallocationforsupplier.strSupplierId = '". $SupId ."' AND glaccounts.strFacCode = '". $FacCd ."') AS B
			HAVING A.strAccID NOT IN (B.strAccID) ";
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
		$ResponseXML .= "<TaxID><![CDATA[" . $row["TaxID"]  . "]]></TaxID>\n";
		$ResponseXML .= "<TaxType><![CDATA[" . $row["TaxType"]  . "]]></TaxType>\n";
		$ResponseXML .= "<TaxRate><![CDATA[" . $row["TaxRate"]  . "]]></TaxRate>\n";
		$ResponseXML .= "<Selected><![CDATA[False]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function ShowAllTax()
{
	global $db;
	$sql= "SELECT taxtypes.strTaxTypeID AS TaxID, taxtypes.strTaxType AS TaxType, taxtypes.dblRate AS TaxRate
			FROM taxtypes WHERE taxtypes.intStatus = '1' ";
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"SaveInvoice")== 0)
{
	
	$InvNo = $_GET["InvNo"];
	$SupId = $_GET["SupId"];
	$InvDt =  $_GET["InvDt"];
	$InvAmt =  $_GET["InvAmt"];
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
	$entryNo	=$_GET['entryNo'];
	$lineNo		=$_GET['lineNo'];
	$invDescription=$_GET['invDesc'];
	$dueDate	=	$_GET['dueDate'];
	//echo $accPaccId;
	
	$ResponseXML = "<Result>\n";
	
	$chkExist =  CheckExistingInvoice($InvNo,$strPaymentType,$SupId);
	
	//echo $chkExist;
	poBalanceUpdate($ArrPoNo,$SupId,$strPaymentType,$BalanceAmt);
	
	while($rw = mysql_fetch_array($chkExist))
	{
	//echo 'pass';
		/*UpdateInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$Commission,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate);*/
		
		UpdateInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$Commission,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalTaxAmt,$FreightAmt,$InsuranceAmt,$OtherAmt,$VatGLAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate,$strPaymentType,$intPONo,$intPOYear,$accPaccId,$batchno);
		
		DeleteInvoiceDetails($InvNo,$strPaymentType);
		DeleteInvoiceGlAccounts($InvNo,$strPaymentType);
		DeleteInvoiceTax($InvNo,$strPaymentType);
		DeleteAccPaccInvoiceDetails($InvNo,$SupId);
		
		InvoiceDetails($InvNo,$SupId,$InvDt,$strPaymentType);
		InvoiceGLAccounts($InvNo,$SupId,$InvDt,$strPaymentType);	
		InvoiceTax($InvNo,$SupId,$InvDt,$strPaymentType);
		UpdateAccPaccInvoiceHeader($InvNo,$SupId,$InvDt,$batchno,$entryNo,$TotalAmt,$ArrPoNo,$invDescription,$dueDate,$InvDt,$VatGLAmt,$TotalTaxAmt,$CurrencyRate,$Currency);
		//SaveAccPaccInvoiceDetails();
		$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
		$ResponseXML .= "<Exist><![CDATA[True]]></Exist>\n";
		$ResponseXML .= "</Result>";
		echo $ResponseXML;
		die();
	}

	/*$strQ =SaveInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$Commission,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate);
	echo $strQ;*/
	
/*	SaveInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$Commission,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate);*/
	
	SaveInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$Commission,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalTaxAmt,$FreightAmt,$InsuranceAmt,$OtherAmt,$VatGLAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate,$strPaymentType,$batchno,$accPaccId);

	$ArrPoNo = $_GET["ArrPoNo"];
	$explodePoNo = explode(',', $ArrPoNo);
	for ($i = 0;$i < count($explodePoNo)-1;$i++)
	{
		$PONo = explode('/', $explodePoNo[$i]);
		SaveInvoiceDetails($InvNo,$PONo[1],$PONo[0],$SupId,$InvDt,$strPaymentType);
	}
		//lasantha Acc Pack data
	SaveAccPaccInvoiceHeader($InvNo,$SupId,$InvDt,$batchno,$entryNo,$TotalAmt,$ArrPoNo,$invDescription,$dueDate,$InvDt,$VatGLAmt,$TotalTaxAmt,$CurrencyRate,$Currency);
	
	$ArrGlAcc = $_GET["ArrGlAcc"];
	$ArrGlAmt = $_GET["ArrGlAmt"];
	$explodeGlAcc = explode(',', $ArrGlAcc);
	$explodeGlAmt = explode(',', $ArrGlAmt);
	for ($i = 0;$i < count($explodeGlAcc)-1;$i++)
	{
		SaveInvoiceGlAccounts($InvNo,$SupId,$InvDt,$explodeGlAcc[$i],$explodeGlAmt[$i],$strPaymentType);
		SaveAccPaccInvoiceDetails($InvNo,$SupId,$batchno,$entryNo,$lineNo,$explodeGlAcc[$i],$explodeGlAmt[$i]);
	}
	
	$ArrTaxId = $_GET["ArrTaxId"];
	$ArrTaxAmt = $_GET["ArrTaxAmt"];
	$explodeTaxId = explode(',', $ArrTaxId);
	$explodeTaxAmt = explode(',', $ArrTaxAmt);
	for ($i = 0;$i < count($explodeTaxId)-1;$i++)
	{
		SaveInvoiceTax($InvNo,$SupId,$InvDt,$explodeTaxId[$i],$explodeTaxAmt[$i],$strPaymentType);
	}
	

	///SaveAccPaccInvoiceHeader($InvNo,$SupId,$InvDt,$batchno,$entryNo,$TotalAmt,$ArrPoNo,$invDescription,$dueDate,$InvDt,$VatGLAmt,$TotalTaxAmt,$CurrencyRate,$Currency);
	
	$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	$ResponseXML .= "<Exist><![CDATA[False]]></Exist>\n";
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function SaveInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$Commission,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalTaxAmt,$FreightAmt,$InsuranceAmt,$OtherAmt,$VatGLAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate,$strPaymentType,$batchno,$accPaccId)
{
	global $db;//,'$accPaccId' 
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$sql= "INSERT INTO invoiceheader(strInvoiceNo, strSupplierId,dtmDate,dblAmount ,strDescription, dblCommission, intcompanyiD, intStatus,dblPaidAmount,dblBalance, dblTotalTaxAmount,dblFreight,dblInsurance, dblOther,dblVatGL, dblTotalAmount, strCurrency,intPaid,intCreditPeriod,dblCurrencyRate,strType,strBatchNo)VALUES('$InvNo',". $SupId .",'". $InvDt ."' ,". $InvAmt .",'". $InvDesc ."',". $Commission .", ". $CompId .",". $Status .",'0', ". $TotalAmt .", ". $TotalTaxAmt .", ". $FreightAmt .", ". $InsuranceAmt .", ". $OtherAmt .", ". $VatGLAmt .", ". $TotalAmt .", '". $Currency ."', ". $Paid .", ". $CreditPeriod .", ". $CurrencyRate .",'$strPaymentType','$batchno')";
	
	//echo $sql;
	$intSave = $db->RunQuery($sql);
	//
	if($intSave=='1')
	{
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
	$explodeGlAcc = explode(',', $ArrGlAcc);
	$explodeGlAmt = explode(',', $ArrGlAmt);
	for ($i = 0;$i < count($explodeGlAcc)-1;$i++)
	{
		SaveInvoiceGlAccounts($InvNo,$SupId,$InvDt,$explodeGlAcc[$i],$explodeGlAmt[$i],$strPaymentType);		
	}
}

function SaveInvoiceGlAccounts($InvNo,$SupId,$InvDt,$explodeGlAcc,$explodeGlAmt,$strPaymentType)
{
	global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	$sql= "INSERT INTO invoiceglbreakdown(strInvoiceNo,strSupplierId,dtmDate,strAccId,dblAmount,strType)VALUES('". $InvNo ."',". $SupId .",'". $InvDt ."','". $explodeGlAcc ."','". $explodeGlAmt ."','$strPaymentType');";
	//echo $sql;
	$result = $db->RunQuery($sql);
	if($result<=0)
	{
		$sql = "UPDATE invoiceglbreakdown set dblAmount=dblAmount+$explodeGlAmt
		 where 	strInvoiceNo	= 	'$InvNo' and
		 		strSupplierId	=	'$SupId' and
				strAccId		=	'$explodeGlAcc' and 
				strType         =   '$strPaymentType'";
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
	//echo $InvNo;
	//if($strPaymentType=="S")
	//{
		$sql= "SELECT strInvoiceNo FROM invoiceheader WHERE (strInvoiceNo = '$InvNo') and strType='$strPaymentType' and strSupplierId = '$supID' ";
	//}
	//else if($strPaymentType=="G")
	//{
	//	$sql= "SELECT strInvoiceNo FROM generalinvoiceheader WHERE (strInvoiceNo = '". $InvNo ."') ";
	//}
	//echo $sql;
	return $db->RunQuery($sql);
}

function CheckExistingSupInvoice($InvNo,$SupId)
{
	global $db;
	$sql= "SELECT strInvoiceNo FROM invoiceheader WHERE (strInvoiceNo = '". $InvNo ."') AND (strSupplierId = '". $SupId ."') ";
	return $db->RunQuery($sql);
}

function poBalanceUpdate($ArrPoNo,$SupId,$strPaymentType,$BalanceAmt)
{
	global $db;
	$intPOYear=substr($ArrPoNo,0,4) ;
	$intPONo=substr($ArrPoNo,5) ;
	$intPONo = str_replace(",", "", $intPONo);
	
	//echo $BalanceAmt;
	
	if($strPaymentType=="S")
	{	
		$strsql="update purchaseorderheader  set dblPOBalance=dblPOBalance-$BalanceAmt where intPONo='$intPONo' and intYear='$intPOYear' and strSupplierID='$SupId'";

	}
	else if($strPaymentType=="G")
	{
		$strsql="update generalpurchaseorderheader  set dblPoBalance=dblPoBalance-$BalanceAmt where intGenPONo='$intPONo' and intYear='$intPOYear' and intSupplierID='$SupId'";
	}
	
	else if($strPaymentType=="B"){
		$strsql="update bulkpurchaseorderheader  set dblpobalance=dblPOBalance-$BalanceAmt where intBulkPoNo='$intPONo' and intYear='$intPOYear' and strSupplierID='$SupId'";
	}
	
	//echo $strsql;
	$db->executeQuery($strsql);
	
	

}

function UpdateInvoice($InvNo,$SupId,$InvDt,$InvAmt,$InvDesc,$Commission,$CompId,$Status,$PaidAmt,$BalanceAmt,$TotalTaxAmt,$FreightAmt,$InsuranceAmt,$OtherAmt,$VatGLAmt,$TotalAmt,$Currency,$Paid,$CreditPeriod,$CurrencyRate,$strPaymentType,$intPONo,$intPOYear,$accPaccId,$batchno)
{
	global $db;
	$InvDt=split('/',$InvDt);
	$InvDt=$InvDt[2]."-".$InvDt[1]."-".$InvDt[0];
	
	$sql1 = "delete from invoiceheader where strInvoiceNo='$InvNo' and strType='$strPaymentType' and strSupplierId='$SupId'";
	$db->executeQuery($sql1);
	
/*	$sql= "UPDATE invoiceheader SET dtmDate = '". $InvDt ."' ,dblAmount = dblAmount + $InvAmt ,strDescription = '". $InvDesc ."',dblCommission =dblCommission + $Commission,intcompanyiD  = ". $CompId .",intStatus = ". $Status .",dblPaidAmount = dblPaidAmount + $PaidAmt,dblBalance = dblBalance+$BalanceAmt,dblTotalTaxAmount =dblTotalTaxAmount + $TotalTaxAmt ,dblFreight =dblFreight + $FreightAmt ,dblInsurance =dblInsurance + $InsuranceAmt ,dblOther =dblOther + $OtherAmt ,dblVatGL =dblVatGL + $VatGLAmt , dblTotalAmount =dblTotalAmount + $TotalAmt ,strCurrency = '". $Currency ."',intPaid = ". $Paid .",intCreditPeriod = ". $CreditPeriod .",dblCurrencyRate = ". $CurrencyRate ." WHERE (strInvoiceNo = '". $InvNo ."') and strType='$strPaymentType' AND ( strSupplierId = ". $SupId .") ";*/
	//	$sql= "UPDATE invoiceheader SET dtmDate = '". $InvDt ."' ,dblAmount = dblAmount + $InvAmt,strDescription = '". $InvDesc ."',dblCommission =dblCommission + $Commission ,intcompanyiD  = ". $CompId .",intStatus = ". $Status .",dblPaidAmount =dblPaidAmount + $PaidAmt,dblBalance =dblBalance + $BalanceAmt,dblTotalTaxAmount =dblTotalTaxAmount + $,dblFreight =dblFreight + $FreightAmt ,dblInsurance =dblInsurance + $InsuranceAmt ,dblOther =dblOther + $OtherAmt,dblVatGL =dblVatGL + $VatGLAmt , dblTotalAmount =dblTotalAmount + $TotalAmt,strCurrency = '". $Currency ."',intPaid = ". $Paid .",intCreditPeriod = ". $CreditPeriod .",dblCurrencyRate = ". $CurrencyRate ." WHERE (strInvoiceNo = '". $InvNo ."') and strType='$strPaymentType' AND ( strSupplierId = ". $SupId .") ";
	//}
	//echo $sql;
	
	
		$sql= "INSERT INTO invoiceheader(strInvoiceNo, strSupplierId,dtmDate,dblAmount ,strDescription, dblCommission, intcompanyiD, intStatus,dblPaidAmount,dblBalance, dblTotalTaxAmount,dblFreight,dblInsurance, dblOther,dblVatGL, dblTotalAmount, strCurrency,intPaid,intCreditPeriod,dblCurrencyRate,strType,strBatchNo)VALUES('$InvNo','$SupId','$InvDt','$InvAmt','$InvDesc','$Commission','$CompId','$Status','0', '$TotalAmt','$TotalTaxAmt','$FreightAmt','$InsuranceAmt','$OtherAmt','$VatGLAmt','$TotalAmt','$Currency','$Paid','$CreditPeriod','$CurrencyRate','$strPaymentType',
		'$batchno')";
$res=$db->executeQuery($sql);	
	
	if($res==1)
	{
		if(!empty($accPaccId)){
		$sql="UPDATE suppliers SET strAccPaccID='$accPaccId' WHERE strSupplierID='$SupId ';";
		$db->executeQuery($sql);
		}
	}
}

function DeleteInvoiceDetails($InvNo,$strPaymentType)
{
	global $db;
	if($strPaymentType=="S")
	{
		$sql= "DELETE FROM invoicedetails WHERE (strInvoiceNo = '". $InvNo ."')";
	}
	else if($strPaymentType=="G")
	{
		$sql= "DELETE FROM generalinvoicedetails WHERE (strInvoiceNo = '". $InvNo ."')";
	}
	$db->executeQuery($sql);
}

function DeleteInvoiceGlAccounts($InvNo,$strPaymentType)
{
	global $db;
	if($strPaymentType=="S")
	{
		$sql= "DELETE FROM invoiceglbreakdown WHERE (strInvoiceNo = '". $InvNo ."')";
	}
	else if($strPaymentType=="G")
	{
		$sql= "DELETE FROM generalinvoiceglbreakdown WHERE (strInvoiceNo = '". $InvNo ."')";
	}
	
	//echo $sql;
	$db->executeQuery($sql);
}
function DeleteInvoiceTax($InvNo,$strPaymentType)
{
	global $db;
	if($strPaymentType=="S")
	{
		$sql= "DELETE FROM invoicetaxes WHERE (strInvoiceNo = '". $InvNo ."')";
	}
	else if($strPaymentType=="G")
	{
		$sql= "DELETE FROM generalinvoicetaxes WHERE (strInvoiceNo = '". $InvNo ."')";
	}
	$db->executeQuery($sql);
}

//Edit Invoice
if(strcmp($RequestType,"SearchInvoiceNoEdit")== 0)
{
	$InvNo = $_GET["InvoiceNo"];

	$ResponseXML .= "<Result>\n";
	$result=SearchInvoiceNoEdit($InvNo);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<SupId><![CDATA[" . $row["SupID"]  . "]]></SupId>\n";
		$ResponseXML .= "<SupNm><![CDATA[" . $row["SupNm"]  . "]]></SupNm>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function SearchInvoiceNoEdit($InvNo)
{
	global $db;
	$sql= "	SELECT suppliers.strSupplierID AS SupID, suppliers.strTitle AS SupNm
			FROM suppliers Inner Join invoiceheader ON invoiceheader.strSupplierId = suppliers.strSupplierID
			WHERE invoiceheader.strInvoiceNo =  '". $InvNo ."' " ;
	//echo $sql;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"GetSupplierInvoiceExst")== 0)
{
	$InvNo = $_GET["InvoiceNo"];
	$SupId = $_GET["SupplierId"];
	
	$ResponseXML .= "<Result>\n";
	$result =  GetSupplierInvoiceExst($InvNo,$SupId);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<CompId><![CDATA[" . $row["CompId"]  . "]]></CompId>\n";
		$ResponseXML .= "<CompNm><![CDATA[" . $row["CompNm"]  . "]]></CompNm>\n";
		$ResponseXML .= "<CompCd><![CDATA[" . $row["CompCd"]  . "]]></CompCd>\n";
		$ResponseXML .= "<AccPacID><![CDATA[" . $row["AccPacID"]  . "]]></AccPacID>\n";
		$ResponseXML .= "<InvCurrency><![CDATA[" . $row["InvCurrency"]  . "]]></InvCurrency>\n";
		$ResponseXML .= "<CreditDays><![CDATA[" . $row["CreditDays"]  . "]]></CreditDays>\n";
		
		$ResponseXML .= "<InvDate><![CDATA[" . $row["InvDate"]  . "]]></InvDate>\n";
		$ResponseXML .= "<InvAmt><![CDATA[" . $row["InvAmt"]  . "]]></InvAmt>\n";
		$ResponseXML .= "<InvDes><![CDATA[" . $row["InvDes"]  . "]]></InvDes>\n";
		$ResponseXML .= "<InvCommission><![CDATA[" . $row["InvCommission"]  . "]]></InvCommission>\n";
		$ResponseXML .= "<InvTotTaxAmt><![CDATA[" . $row["InvTotTaxAmt"]  . "]]></InvTotTaxAmt>\n";
		
		$ResponseXML .= "<InvFreight><![CDATA[" . $row["InvFreight"]  . "]]></InvFreight>\n";
		$ResponseXML .= "<InvInsurance><![CDATA[" . $row["InvInsurance"]  . "]]></InvInsurance>\n";
		$ResponseXML .= "<InvOther><![CDATA[" . $row["InvOther"]  . "]]></InvOther>\n";
		$ResponseXML .= "<InvVatGL><![CDATA[" . $row["InvVatGL"]  . "]]></InvVatGL>\n";
		
		$ResponseXML .= "<InvTotAmt><![CDATA[" . $row["InvTotAmt"]  . "]]></InvTotAmt>\n";
		$ResponseXML .= "<PaidStatus><![CDATA[" . $row["PaidStatus"]  . "]]></PaidStatus>\n";
		$ResponseXML .= "<strBatchNo><![CDATA[".$row["strBatchNo"]."]]></strBatchNo>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function GetSupplierInvoiceExst($InvNo,$SupId)
{
	global $db;
	/*$sql= "	SELECT companies.intCompanyID AS CompId, companies.strName AS CompNm, companies.strComCode AS CompCd,
			suppliers.strAccPaccID AS AccPacID, creditperiods.dblNoOfDays AS CreditDays FROM suppliers 
			Inner Join creditperiods ON suppliers.intCreditPeriod = creditperiods.intSerialNO 
			Inner Join invoiceheader ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			inner join companies ON invoiceheader.intcompanyiD = companies.intCompanyID 
			WHERE invoiceheader.strInvoiceNo = '". $InvNo ."' AND invoiceheader.strSupplierId = '". $SupId ."' " ;*/
	$sql = "SELECT
			companies.intCompanyID AS CompId,
			companies.strName AS CompNm,
			companies.strComCode AS CompCd,
			suppliers.strAccPaccID AS AccPacID,
			invoiceheader.strCurrency AS InvCurrency,
			invoiceheader.dtmDate AS InvDate,
			invoiceheader.dblAmount AS InvAmt,
			invoiceheader.strDescription AS InvDes,
			invoiceheader.dblCommission AS InvCommission,
			invoiceheader.dblTotalTaxAmount AS InvTotTaxAmt,
			invoiceheader.dblFreight AS InvFreight,
			invoiceheader.dblInsurance AS InvInsurance,
			invoiceheader.dblOther AS InvOther,
			invoiceheader.dblVatGL AS InvVatGL,
			invoiceheader.dblTotalAmount AS InvTotAmt,
			invoiceheader.intPaid AS PaidStatus,
			invoiceheader.strBatchNo,
			creditperiods.dblNoOfDays
			FROM suppliers 
			left Join creditperiods ON suppliers.intCreditPeriod = creditperiods.intSerialNO 
			Inner Join invoiceheader ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			inner join companies ON invoiceheader.intcompanyiD = companies.intCompanyID
			WHERE invoiceheader.strInvoiceNo = '". $InvNo ."' AND invoiceheader.strSupplierId = '". $SupId ."' ";
			//echo $sql;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadSupplierGLEdit")== 0)
{
	$invNo = $_GET["invNo"];
	$supId = $_GET["supId"];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadSupplierGLEdit($invNo,$supId);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<GLAccId><![CDATA[" . $row["GLAccId"]  . "]]></GLAccId>\n";
		$ResponseXML .= "<GLAccDesc><![CDATA[" . $row["GLAccDesc"]  . "]]></GLAccDesc>\n";
		$ResponseXML .= "<GLAccAmt><![CDATA[" . $row["GLAccAmt"]  . "]]></GLAccAmt>\n";
		$ResponseXML .= "<Selected><![CDATA[True]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
function LoadSupplierGLEdit($InvNo,$SupId)
{
	global $db;
	global $FactoryID;
	$sql = "SELECT glaccounts.strAccID AS GLAccId, glaccounts.strDescription AS GLAccDesc, invoiceglbreakdown.dblAmount AS GLAccAmt
			FROM invoiceheader
			Inner Join invoiceglbreakdown ON invoiceheader.strInvoiceNo = invoiceglbreakdown.strInvoiceNo AND invoiceheader.strType = invoiceglbreakdown.strType
			Inner Join glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID
			Inner Join companies ON invoiceheader.intcompanyiD = companies.intCompanyID AND companies.strComCode = glaccounts.strFacCode
			WHERE invoiceheader.strInvoiceNo = '". $InvNo ."' AND invoiceheader.strSupplierId = '". $SupId ."' AND companies.intCompanyID='$FactoryID'";
	//echo $sql;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"LoadPoDetailsEdit")== 0)
{
	$SupId = $_GET["SupplierId"];
	$InvNo = $_GET["InvoiceNo"];
	
	$ResponseXML .= "<Result>\n";
	$result=LoadPoDetailsEdit($SupId,$InvNo,$strPaymentType);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<PO><![CDATA[" . $row["POYear"] . "/" . $row["PONo"] . "]]></PO>\n";
		$ResponseXML .= "<Currency><![CDATA[" . $row["Currency"]  . "]]></Currency>\n";
		$ResponseXML .= "<POAmount><![CDATA[" . $row["POValue"]  . "]]></POAmount>\n";
		$ResponseXML .= "<POBalance><![CDATA[" . $row["POBalance"]  . "]]></POBalance>\n";
		$ResponseXML .= "<Selected><![CDATA[True]]></Selected>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadPoDetailsEdit($SupId,$InvNo,$strPaymentType)
{
	global $db;
	//print("aaa");
	if($strPaymentType=="S")
	{
		$sql= "SELECT purchaseorderheader.intYear AS POYear, purchaseorderheader.intPONo AS PONo, 
				purchaseorderheader.strCurrency AS Currency, purchaseorderheader.dblPOValue AS POValue,
				purchaseorderheader.dblPOBalance AS POBalance
				FROM purchaseorderheader
				Inner Join invoicedetails ON invoicedetails.intPONO = purchaseorderheader.intPONo AND
				invoicedetails.intPOYear = purchaseorderheader.intYear
				WHERE (invoicedetails.strInvoiceNo =  '". $InvNo ."') AND (invoicedetails.strSupplierId =  '". $SupId ."')" ;
	//
	}
	else if($strPaymentType=="G")
	{
		$sql= "SELECT purchaseorderheader.intYear AS POYear, purchaseorderheader.intPONo AS PONo, 
				purchaseorderheader.strCurrency AS Currency, purchaseorderheader.dblPOValue AS POValue,
				purchaseorderheader.dblPOBalance AS POBalance
				FROM purchaseorderheader
				Inner Join invoicedetails ON invoicedetails.intPONO = purchaseorderheader.intPONo AND
				invoicedetails.intPOYear = purchaseorderheader.intYear
				WHERE (invoicedetails.strInvoiceNo =  '". $InvNo ."') AND (invoicedetails.strSupplierId =  '". $SupId ."')" ;

	}
	
	//echo($sql);
	
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"ShowAllTaxExst")== 0)
{
	$InvNo = $_GET["InvoiceNo"];
	$SupId = $_GET["SupplierId"];
	
	$ResponseXML .= "<Result>\n";
	$result=ShowAllTaxExst($InvNo,$SupId);
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

function ShowAllTaxExst($InvNo,$SupId)
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
				concat(purchaseorderheader.intYear,'/',purchaseorderheader.intPONo) AS PO
				from 
				purchaseorderheader
				Inner Join gengrnheader ON gengrnheader.intGenPONo = purchaseorderheader.intPONo 
				AND gengrnheader.intYear = purchaseorderheader.intYear
				Inner Join gengrndetails ON gengrndetails.strGenGrnNo = gengrnheader.strGenGrnNo 
				AND gengrndetails.intYear = gengrnheader.intYear
				left Join purchaseorderdetails ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo 
				AND purchaseorderdetails.intYear = purchaseorderheader.intYear 
				AND purchaseorderdetails.intMatDetailID = gengrndetails.intMatDetailID 
				WHERE  gengrnheader.strInvoiceNo =  '$InvNo' AND gengrnheader.intStatus = '1' 
				AND (purchaseorderheader.strSupplierID =  '1')
				AND (purchaseorderheader.intStatus <> '11')
				-- GROUP BY  gengrnheader.intGrnNo,gengrnheader.intGRNYear;";
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
function SaveAccPaccInvoiceHeader($InvNo,$SupId,$InvDt,$batchno,$entryNo,$TotalAmt,$ArrPoNo,$invDescription,$dueDate,$InvDt,$VatGLAmt,$TotalTaxAmt,$CurrencyRate,$Currency)
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
	$currID=$_GET['currID'];
	$ResponseXML .= "<Result>\n";
	$sql="SELECT exchangerate.rate AS Rate
		FROM
		currencytypes
		Inner Join exchangerate ON exchangerate.currencyID = currencytypes.intCurID
		WHERE
		currencytypes.intStatus =  '1' AND
		exchangerate.intStatus =  '1' AND
		currencytypes.strCurrency  =  '$currID';";
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<Rate><![CDATA[" . $row["Rate"]  . "]]></Rate>\n";
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
			//echo $sql;
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
	$sql="SELECT strBatchNo FROM invoiceheader WHERE strInvoiceNo='$InvNo' AND strSupplierId='$SupNo';";
	
	$res=$db->RunQuery($sql);
	while ($row=mysql_fetch_array($res)) {

	$ResponseXML .= "<BatchNo><![CDATA[".$row["strBatchNo"]."]]></BatchNo>\n";
	}
	$ResponseXML .= "</Result>\n";
	echo $ResponseXML;
}


?>
