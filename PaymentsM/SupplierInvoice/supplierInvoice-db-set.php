<?php
session_start();
$intCompanyId = $_SESSION['CompanyID'];
include('../../Connector.php');

$type=$_GET['type'];
if($type =="Save")
{
 $txtInvoiceNo = trim($_GET["txtInvoiceNo"]);
 $cboBatchNo   = trim($_GET["cboBatchNo"]);	
 $cboAccount   = trim($_GET["cboAccount"]);	
 $cboType      = trim($_GET["cboType"]);	
 $cboCurrency  = trim($_GET["cboCurrency"]);	
 $txtCreditPeriod = trim($_GET["txtCreditPeriod"]);	
 $txtDate      = trim($_GET["txtDate"]);	
 $txtAccPaccID = trim($_GET["txtAccPaccID"]);	

$sql_insert("INSERT INTO invoiceheader(strInvoiceNo,strSupplierId,dtmDate,dblAmount,strDescription,dblCommission,intcompanyiD,intStatus,dblPaidAmount,dblBalance,dblTotalTaxAmount,dblFreight,dblInsurance,dblOther,dblVatGL,dblTotalAmount,strCurrency,intPaid,intCreditPeriod,dblCurrencyRate,strType,strBatchNo) VALUES('$txtInvoiceNo','','$txtDate','')");	
$result=$db->RunQuery($sql_insert);
if($result)
  echo "Saved Successfully."; 
else
  echo "Saved Error."; 
 	
}
