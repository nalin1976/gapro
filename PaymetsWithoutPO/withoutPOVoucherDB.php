<?php
	session_start();
	include "../Connector.php";
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$DBOprType = $_GET["DBOprType"]; 

	if (strcmp($DBOprType,"WithouPOVoucherNoTask") == 0)
	{	
		 $task=$_GET["task"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<VoucherNo>\n";
				
		 $result=getWithouPOVoucherNo($task);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<WithouPOVoucherNo><![CDATA[" . $row["dblWithoutPOVoucherNo"]  . "]]></WithouPOVoucherNo>\n";
		 }
		 $ResponseXML .= "</VoucherNo>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getSchedules") == 0)
	{	
		 $payeeID=$_GET["payeeID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<Schedules>\n";
				
		 $result=getschedulesNos($payeeID);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<schedulesNo><![CDATA[" . $row["strScheduleNo"]  . "]]></schedulesNo>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["dblTotAmount"]  . "]]></amount>\n";
		 }
		 $ResponseXML .= "</Schedules>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getInvoiceDetails") == 0)
	{	
		 $schedulaNo=$_GET["schedulaNo"];
		 $payeeID=$_GET["payeeID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<ScheduleDetails>\n";
				
		 $result=getInvoiceDetailss($schedulaNo,$payeeID);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<invoiceNo><![CDATA[" . $row["invoiceNo"]  . "]]></invoiceNo>\n";
			$ResponseXML .= "<description><![CDATA[" . $row["discription"]  . "]]></description>\n";
			$ResponseXML .= "<datex><![CDATA[" . $row["invDate"]  . "]]></datex>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["amount"]  . "]]></amount>\n";
			$ResponseXML .= "<tax><![CDATA[" . $row["taxAmt"]  . "]]></tax>\n";
			$ResponseXML .= "<discount><![CDATA[" . $row["discount"]  . "]]></discount>\n";
			$ResponseXML .= "<totalAmt><![CDATA[" . $row["totalInvAmount"]  . "]]></totalAmt>\n";
			$ResponseXML .= "<currency><![CDATA[" . $row["currency"]  . "]]></currency>\n";		
		 }
		 $ResponseXML .= "</ScheduleDetails>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"SaveNewVoucher") == 0)
	{	
		 $voucherNo=$_GET["voucherNo"];
		 $datex=$_GET["datex"];
		 $payeeID=$_GET["payeeID"];
		 $description=$_GET["description"];
		 $batchno=$_GET["batchno"];
		 $scheduleno=$_GET["scheduleno"];
		 $chequeno=$_GET["chequeno"];
		 $accno=$_GET["accno"];
		 $taxcode=$_GET["taxcode"];
		 $currFrom=$_GET["currFrom"];
		 $rateFrom=$_GET["rateFrom"];
		 $currTo=$_GET["currTo"];
		 $rateTo=$_GET["rateTo"];
		 $totalAmt=$_GET["totalAmt"];
		 //$txtUserID=$_GET["txtUserID"];
		 
		 $txtUserID=$_SESSION["UserID"];
		 $factoryID=$_SESSION["FactoryID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<NewVoucher>\n";
				
		 if(saveNewvoucher($voucherNo,$datex,$payeeID,$description,$batchno,$scheduleno, $chequeno,$accno,$taxcode,$currFrom,$rateFrom,$currTo,$rateTo,$totalAmt,$txtUserID,$factoryID))
		 {
		 	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 } 
		 else
		 {
		 	$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 
		 $ResponseXML .= "</NewVoucher>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getPaymentVoucherList") == 0)
	{	
		 $payeeID=$_GET["payeeID"];
		 $dateFrom=$_GET["dateFrom"];
		 $dateTo=$_GET["dateTo"];
		 
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<Schedules>\n";
				
		 $result=getPaymentVoucherList($payeeID,$dateFrom,$dateTo);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<VoucherNo><![CDATA[" . $row["strVoucherNo"]  . "]]></VoucherNo>\n";
			$ResponseXML .= "<Payee><![CDATA[" . $row["strTitle"]  . "]]></Payee>\n";
			$ResponseXML .= "<Payeeid><![CDATA[" . $row["strPayeeID"]  . "]]></Payeeid>\n";
			$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
			$ResponseXML .= "<Date><![CDATA[" . $row["dtDate"]  . "]]></Date>\n";
			$ResponseXML .= "<Amount><![CDATA[" . $row["dblTotalAmount"]  . "]]></Amount>\n";
			
		 }
		 $ResponseXML .= "</Schedules>";
		 echo $ResponseXML;
	}
	
	
function getPaymentVoucherList($payeeID,$dateFrom,$dateTo)
{
	global $db; 
	//echo $payeeID;
	if($payeeID==0)
	{
		$strSQL="SELECT withoutpovoucher.*,payee.strTitle FROM withoutpovoucher INNER JOIN payee ON (withoutpovoucher.strPayeeID=payee.intPayeeID ) WHERE withoutpovoucher.dtDate>='$dateFrom' AND withoutpovoucher.dtDate<='$dateTo'";
		//echo($strSQL);
	}
	else
	{
		$strSQL="SELECT withoutpovoucher.*,payee.strTitle FROM withoutpovoucher INNER JOIN payee ON (withoutpovoucher.strPayeeID=payee.intPayeeID ) WHERE withoutpovoucher.strPayeeID='$payeeID' AND withoutpovoucher.dtDate>='$dateFrom' AND withoutpovoucher.dtDate<='$dateTo'";
	}
	$result=$db->RunQuery($strSQL);
	return $result;

}
	
function saveNewvoucher($voucherNo,$datex,$payeeID,$description,$batchno,$scheduleno, $chequeno,$accno,$taxcode,$currFrom,$rateFrom,$currTo,$rateTo,$totalAmt,$txtUserID,$factoryID)
{
	global $db; 
	$strSQL="INSERT INTO withoutpovoucher(strVoucherNo,dtDate, strPayeeID,strDescription, strScheduleNo,strBatchNo, strChequeno, strAccNo,strTaxCode,strCurrFrom,dblRatefrom,strCurrTo,dblRateTo,dblTotalAmount,strUser,userFactory) VALUES('$voucherNo','$datex', '$payeeID', '$description','$scheduleno','$batchno', '$chequeno','$accno','$taxcode', '$currFrom','$rateFrom', '$currTo', '$rateTo', '$totalAmt','$txtUserID','$factoryID') ";
	
	//print($strSQL);
	$db->RunQuery($strSQL);
	
	$strSQL="UPDATE withoutpoinvoicescheduleheader SET intStatus=1 WHERE  strScheduleNo='$scheduleno'";
	//print($strSQL);
	
	$db->RunQuery($strSQL);
	return true;
	
}

function getInvoiceDetailss($schedulaNo,$payeeID)
{
	global $db; 
	$strSQL="SELECT withoutpoinvoice.invoiceNo, withoutpoinvoice.invDate, withoutpoinvoice.discription, withoutpoinvoice.currency, withoutpoinvoice.amount,withoutpoinvoice.discount,withoutpoinvoice.taxAmt,withoutpoinvoice.totalInvAmount FROM withoutpoinvoice INNER  JOIN withoutpoinvoicescheduledetails  ON (withoutpoinvoice.invoiceNo=withoutpoinvoicescheduledetails.strInvoiceNo) WHERE withoutpoinvoicescheduledetails.strScheduleNo='$schedulaNo'  AND withoutpoinvoice.payeeID='$payeeID'";
	
	//print($strSQL);
	$result=$db->RunQuery($strSQL);
	return $result;
	
}	

function getschedulesNos($payeeID)
{
	global $db; 
	$strSQL="SELECT strScheduleNo,dblTotAmount FROM withoutpoinvoicescheduleheader WHERE intStatus=0 AND strPayeeID='$payeeID'";
	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result;
}	

function getWithouPOVoucherNo($task)
{
	$compCode=$_SESSION["FactoryID"];
	//print($compCode);
	global $db; 
	if($task==1)
	{
		$strSQL="SELECT  dblWithoutPOVoucherNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
		//print($strSQL);
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($task==2)
	{
		$strSQL="update syscontrol set  dblWithoutPOVoucherNo= dblWithoutPOVoucherNo+1  WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		$strSQL="SELECT dblWithoutPOVoucherNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result;
	}
}
	
?>