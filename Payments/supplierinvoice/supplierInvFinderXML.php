<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
$strPaymentType=$_GET["strPaymentType"];

if(strcmp($RequestType,"LoadSupplier")== 0)
{
	$ResponseXML = "<Result>\n";
	$result=LoadSupplier();
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<SupId><![CDATA[" . $row["SupID"]  . "]]></SupId>\n";
		$ResponseXML .= "<SupNm><![CDATA[" . $row["SupNm"]  . "]]></SupNm>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

function LoadSupplier()
{
	global $db;
	$sql= "	SELECT strSupplierID AS SupID, strTitle AS SupNm FROM suppliers WHERE intstatus = 1 ORDER BY SupNm ASC" ;
	return $db->RunQuery($sql);
}

if(strcmp($RequestType,"SearchInvoices")== 0)
{	
	$InvoiceNo = $_GET["InvoiceNo"];
	$SupplierId = $_GET["SupplierId"];
	$FromDt = $_GET["FromDt"];
	$ToDt = $_GET["ToDt"];
	$Paid = $_GET["Paid"];
	$UnPaid = $_GET["UnPaid"];
	$entryNo = $_GET['entryNo'];
	if ($FromDt != "" && $ToDt != "")
	{
		$FromDtD = substr($FromDt,0,2);
		$FromDtM = substr($FromDt,3,2);
		$FromDtY = substr($FromDt,6,4);
		$FromDt = $FromDtY . "-" . $FromDtM ."-". $FromDtD ;
		
		$ToDtD = substr($ToDt,0,2);
		$ToDtM = substr($ToDt,3,2);
		$ToDtY = substr($ToDt,6,4);
		$ToDt = $ToDtY . "-" . $ToDtM ."-". $ToDtD ;
		//echo $FromDt  ." ". $ToDt;
	}
	
	$ResponseXML = "<Result>\n";
	//lasantha 
	$result= SearchInvoiceDetails($InvoiceNo,$SupplierId,$FromDt,$ToDt,$strPaymentType,$Paid,$UnPaid,$entryNo);
	
	/*//Search By Invoice Number Only
	if($InvoiceNo != "" && $SupplierId.length == 0 && $Paid = "false" && $UnPaid = "false" && $FromDt == "" && $ToDt == "")
	{
		$result=SearchInvoice($InvoiceNo,$strPaymentType); //OK
	}
	//Search By Supplier Only
	elseif($SupplierId.length > 0 && $InvoiceNo == "" && $Paid == "false" && $UnPaid == "false" && $FromDt == "" && $ToDt == "")
	{
		$result=SearchInvoicesSupplier($SupplierId,$strPaymentType);
	}
	//Search By Paid Only
	elseif($Paid == "true" && $SupplierId.length == 0 && $InvoiceNo == "" && $UnPaid == "false" && $FromDt == "" && $ToDt == "")
	{
		$result=SearchInvoicesPaid($strPaymentType);
	}
	//Search By UnPaid Only
	elseif($UnPaid == "true" && $SupplierId.length == 0 && $InvoiceNo == "" && $Paid == "false" && $FromDt == "" && $ToDt == "")
	{
		$result=SearchInvoicesUnPaid($strPaymentType);
	}
	//Search By DateRange Only
	elseif($FromDt != "" && $ToDt != "" && $SupplierId.length == 0 && $InvoiceNo == "" && $Paid == "false" && $UnPaid == "false")
	{
		$result=SearchInvoicesDateRange($FromDt,$ToDt,$strPaymentType);
	}
	//Search By Invoice Number And DateRange
	elseif($InvoiceNo != "" && $SupplierId.length == 0 && $Paid == "false" && $UnPaid == "false" && $FromDt != "" && $ToDt != "")
	{
		$result=SearchInvoiceDateRange($InvoiceNo,$FromDt,$ToDt,$strPaymentType);
	}
	//Search By Supplier And DateRange
	elseif($InvoiceNo == "" && $SupplierId.length > 0 && $Paid == "false" && $UnPaid == "false" && $FromDt != "" && $ToDt != "")
	{
		$result=SearchInvoiceSupplierDateRange($SupplierId,$FromDt,$ToDt,$strPaymentType);
	}
	//Search By Supplier And DateRange With Paid
	elseif($InvoiceNo == "" && $SupplierId.length > 0 && $Paid == "true" && $UnPaid == "false" && $FromDt != "" && $ToDt != "")
	{
		$result=SearchInvoiceSupplierDateRangePaid($SupplierId,$FromDt,$ToDt,$strPaymentType);
	}
	//Search By Supplier And DateRange With UnPaid
	elseif($InvoiceNo == "" && $SupplierId.length > 0 && $Paid == "false" && $UnPaid == "true" && $FromDt != "" && $ToDt != "")
	{
		$result=SearchInvoiceSupplierDateRangeUnPaid($SupplierId,$FromDt,$ToDt,$strPaymentType);
	}
	//Search By Supplier And DateRange With Paid OR UnPaid
	elseif($InvoiceNo == "" && $SupplierId.length > 0 && $Paid == "true" && $UnPaid == "true" && $FromDt != "" && $ToDt != "")
	{
		$result=SearchInvoiceSupplierDateRange($SupplierId,$FromDt,$ToDt,$strPaymentType);
	}
	//Search All Invoices
	else
	{
		$result=SearchInvoices($strPaymentType);   //OK
	}*/
	
	while($row = mysql_fetch_array($result))
	{
		$invoiceData = $row["InvoiceDate"];
		$invDateArray = explode('-',$invoiceData);
		$formatedInvDate = $invDateArray[2].'/'.$invDateArray[1].'/'.$invDateArray[0];
		
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["InvoiceNo"]  . "]]></InvoiceNo>\n";
		$ResponseXML .= "<Supplier><![CDATA[" . $row["Supplier"]  . "]]></Supplier>\n";
		$ResponseXML .= "<InvoiceDate><![CDATA[" . $formatedInvDate  . "]]></InvoiceDate>\n";
		$ResponseXML .= "<InvoiceAmt><![CDATA[" . $row["InvoiceAmt"]  . "]]></InvoiceAmt>\n";
		$ResponseXML .= "<PaidAmt><![CDATA[" . $row["PaidAmt"]  . "]]></PaidAmt>\n";
		$ResponseXML .= "<BalanceAmt><![CDATA[" . $row["BalanceAmt"]  . "]]></BalanceAmt>\n";
		$ResponseXML .= "<SupplierId><![CDATA[" . $row["SupplierId"]  . "]]></SupplierId>\n";
		$ResponseXML .= "<batchStatus><![CDATA[" . $row["batchStatus"]  . "]]></batchStatus>\n";
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

/*function SearchInvoices($strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID where invoiceheader.strType='$strPaymentType' 
			ORDER BY InvoiceNo ASC";
			//echo $sql;
	return $db->RunQuery($sql);
}
//invoice number
function SearchInvoice($InvoiceNo,$strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.strInvoiceNo LIKE '%". $InvoiceNo ."%' and invoiceheader.strType='$strPaymentType'";
			//echo $sql;
	return $db->RunQuery($sql);
}

function SearchInvoicesSupplier($SupplierId,$strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.strSupplierId = '". $SupplierId ."' AND invoiceheader.strType='$strPaymentType' ";
			echo $sql;
	return $db->RunQuery($sql);
}

function SearchInvoicesPaid($strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.intPaid = 1  and invoiceheader.strType='$strPaymentType'";
			echo $sql;
	return $db->RunQuery($sql);
}

function SearchInvoicesUnPaid($strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.intPaid = 0 and invoiceheader.strType='$strPaymentType'";
			echo $sql;
	return $db->RunQuery($sql);
}

function SearchInvoicesDateRange($FromDt,$ToDt,$strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.dtmDate >= '". $FromDt ."' AND invoiceheader.dtmDate <= '". $ToDt ."' and invoiceheader.strType='$strPaymentType'";
	echo $sql;
	return $db->RunQuery($sql);
}

function SearchInvoiceDateRange($FromDt,$ToDt,$strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.strInvoiceNo LIKE '%". $InvoiceNo ."%' 
			AND invoiceheader.dtmDate >= '". $FromDt ."' AND invoiceheader.dtmDate <= '". $ToDt ."' and invoiceheader.strType='$strPaymentType'";
			echo $sql;
	return $db->RunQuery($sql);
}
function SearchInvoiceSupplierDateRange($SupplierId,$FromDt,$ToDt,$strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.strSupplierId = '". $SupplierId ."' 
			AND invoiceheader.dtmDate >= '". $FromDt ."' AND invoiceheader.dtmDate <= '". $ToDt ."' and invoiceheader.strType='$strPaymentType'";
			echo $sql;
	return $db->RunQuery($sql);
}

function SearchInvoiceSupplierDateRangePaid($SupplierId,$FromDt,$ToDt,$strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.strSupplierId = '". $SupplierId ."' 
			AND invoiceheader.dtmDate >= '". $FromDt ."' AND invoiceheader.dtmDate <= '". $ToDt ."' AND invoiceheader.strType='$strPaymentType' and invoiceheader.intPaid = 1 ";
			echo $sql;
	return $db->RunQuery($sql);
}

function SearchInvoiceSupplierDateRangeUnPaid($SupplierId,$FromDt,$ToDt,$strPaymentType)
{
	global $db;
	$sql = "SELECT invoiceheader.strInvoiceNo AS InvoiceNo, invoiceheader.dtmDate AS InvoiceDate, 
			invoiceheader.dblAmount AS InvoiceAmt, invoiceheader.dblPaidAmount AS PaidAmt,
			invoiceheader.dblBalance AS BalanceAmt, suppliers.strTitle AS Supplier,suppliers.strSupplierID As SupplierId
			FROM invoiceheader Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID 
			WHERE invoiceheader.strSupplierId = '". $SupplierId ."' 
			AND invoiceheader.dtmDate >= '". $FromDt ."' AND invoiceheader.dtmDate <= '". $ToDt ."' AND invoiceheader.strType='$strPaymentType' And invoiceheader.intPaid = 0 ";
			echo $sql;
	return $db->RunQuery($sql);
}*/
#######################-- lasantha searching--- #############################################################
function SearchInvoiceDetails($InvoiceNo,$SupplierId ,$FromDt,$ToDt,$strPaymentType,$Paid,$UnPaid,$entryNo){
	global $db;
	$sql="SELECT 
				invoiceheader.strInvoiceNo AS InvoiceNo, 
				date(invoiceheader.dtmDate) AS InvoiceDate, 
				invoiceheader.dblAmount AS InvoiceAmt, 
				invoiceheader.dblPaidAmount AS PaidAmt,
				invoiceheader.dblBalance AS BalanceAmt, 
				suppliers.strTitle AS Supplier,
				suppliers.strSupplierID As SupplierId,
				B.posted as batchStatus
				FROM invoiceheader 
				Inner Join suppliers ON invoiceheader.strSupplierId = suppliers.strSupplierID
				inner join batch B ON invoiceheader.strBatchNo = B.intBatch ";
				if(!empty($entryNo))
				{
					$sql.=" Inner Join accpacinvoiceheader ach ON ach.strInvoiceNo=invoiceheader.strInvoiceNo "; 
				}
	$sql.="WHERE invoiceheader.strType='$strPaymentType'";
	if(!empty($InvoiceNo))
	{
		$sql.=" AND invoiceheader.strInvoiceNo LIKE '%". $InvoiceNo ."%'";		
	}
	
	if(!empty($FromDt) && !empty($ToDt))
	{

		$sql.=" AND invoiceheader.dtmDate BETWEEN '". $FromDt ."' AND  '". $ToDt ."'";
	}
	
	if($SupplierId > 0)
	{
		$sql .=" AND invoiceheader.strSupplierId = '". $SupplierId ."'";
	}
	if(!empty($Paid) && $Paid=='true')
	{
		$sql .=" AND invoiceheader.intPaid = '1'"; 
	}
	if(!empty($UnPaid) && $UnPaid=='true')
	{
		$sql .=" AND invoiceheader.intPaid = '0'";
	}
	if(!empty($entryNo))
	{
		$sql .=" AND ach.strEntryNo = '$entryNo'";
	}
	$sql.=" ORDER BY InvoiceNo ASC;";
	//echo $sql;
	return $db->RunQuery($sql);
}
#######################-- END --- #############################################################
?>