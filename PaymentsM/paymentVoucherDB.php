<?php
	session_start();
	include "../Connector.php";
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$DBOprType = $_GET["DBOprType"]; 
	$strPaymentType=$_GET["strPaymentType"];
	
	//echo $strPaymentType;
	
	if (strcmp($DBOprType,"getBank") == 0)
	{	
		 $batchID=$_GET["batchID"];
		
		 $ResponseXML = "";
		 $ResponseXML .= "<bank>\n";
				 
		 $result=getBank($batchID);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<bankID><![CDATA[" . $row["strBankCode"]  . "]]></bankID>\n";
			$ResponseXML .= "<bankName><![CDATA[" . $row["strBankName"]  . "]]></bankName>\n";
			$ResponseXML .= "<strCurrency><![CDATA[" . $row["strCurrency"]  . "]]></strCurrency>\n";
			$ResponseXML .= "<rate><![CDATA[" . $row["rate"]  . "]]></rate>\n";
			
		 }
		 $ResponseXML .= "</bank>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"PaymentAmt") == 0)
	{	
		 $payNo=$_GET["payNo"];
		 $ResponseXML = "";
		 $ResponseXML .= "<amt>\n";
				 
		 $result=getPaymentAmt($payNo);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<paymentAmt><![CDATA[" . $row["dblAmount"]  . "]]></paymentAmt>\n";
		 }
		 $ResponseXML .= "</amt>";
		 echo $ResponseXML;
	}
	
	
	else if (strcmp($DBOprType,"getTypeOfCurrency") == 0)
	{	
		 $ResponseXML = "";
		 $ResponseXML .= "<CurrencyTypes>\n";
				 
		 $result=getCurrencyTypes();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<currType><![CDATA[" . $row["strCurrency"]  . "]]></currType>\n";
			$ResponseXML .= "<currRate><![CDATA[" . $row["dblRate"]  . "]]></currRate>\n";
		 }
		 $ResponseXML .= "</CurrencyTypes>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getScheduals") == 0)
	{	
		 $supID=$_GET["supID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<schedulNos>\n";
				 
		 $result=getSupSchedules($supID,$strPaymentType);
		 echo "<option value='0'></option>";
		 while($row = mysql_fetch_array($result))
		 {
			//$ResponseXML .= "<schNo><![CDATA[" . $row["strScheduelNo"]  . "]]></schNo>\n";
			$ResponseXML .= "<option value=\"". $row["strScheduelNo"] ."\">" . $row["strScheduelNo"] . "</option>";	
		 }
		 $ResponseXML .= "</schedulNos>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getInvoiceSchedual") == 0)
	{	
		 $schdNo=$_GET["schdNo"];
		 $supid=$_GET["supid"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<schdData>\n";
				 
		 $result=getInvoiceSchedul($schdNo,$strPaymentType,$supid);
		 $flg_firstyn  = "";
         $flg_newdocyn = "";
         $te_docmain   = ""; 
   
		 while($row = mysql_fetch_array($result))
		 {
/*		  $strInvoiceNo  = $row["strInvoiceNo"];
		  $totalValue    = $row["totalValue"];
		  $paidValue     = $row["paidValue"];
		  $advancePaid   = $row["advancePaid"];
		  $strPONO       = $row["strPONO"];
		  
		  $te_strComponent = $strPONO."/".$advancePaid;
		  
			if($te_docmain != $te_strComponent)
			{
			$advancePaid = $advancePaid;
			}
			else
			{ 
			$advancePaid = 0;  
			}
			$te_docmain = $te_strComponent; */
		    
			$ResponseXML .= "<invNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></invNo>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["dblTotalAmount"] . "]]></amount>\n";
			$ResponseXML .= "<paidAmt><![CDATA[" . $row["dblPaidAmount"]  . "]]></paidAmt>\n";
			$ResponseXML .= "<balance><![CDATA[" . $row["dblBalance"]  . "]]></balance>\n";
			
			$flg_firstyn  = "n";
            $flg_firstyn2 = "n";    
		 }
		 $ResponseXML .= "</schdData>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"saveNewPaymentVoucher") == 0)
	{	
		 //$voucherNo=$_GET["voucherNo"];
		 $schedualeNo=$_GET["schedualeNo"];
		 $description=$_GET["description"];
		 $batchNo=$_GET["batchNo"];
		 $bankCode=$_GET["bankCode"];
		 $supID=$_GET["supID"];
		 $chequeNo=$_GET["chequeNo"];
		 $datex=$_GET["datex"];
		 $amount=$_GET["amount"];
		 $currency=$_GET["currency"];
		 $rate=$_GET["rate"];
		 $accpakID=$_GET["accpakID"];
		 $userName=$_GET["userid"];
		 $userID=$_SESSION["UserID"];
		 $strFactory=$_SESSION["FactoryID"] ;
		
		 $result = getPaymentVoucherNo($strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
		 	$voucherNo = $row['dblPaymentVoucherNo'];
		 }
		 $ResponseXML = "";
		 $ResponseXML .= "<savePVData>\n";
				 
		 if(saveNewPVData($voucherNo, $schedualeNo, $description, $batchNo, $bankCode, $supID, $chequeNo, $datex,$amount,$currency,$rate,$accpakID,$userID,$strPaymentType,$strFactory))
		{ 
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
			$ResponseXML .= "<voucherNo><![CDATA[".$voucherNo."]]></voucherNo>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		 $ResponseXML .= "</savePVData>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"saveNewPaymentVoucherDetails") == 0)
	{	
		 $voucherNo=$_GET["voucherNo"];
		 $invoiceNo=$_GET["invoiceNo"];
		 $amount=$_GET["amount"];
		 $balance=$_GET["balance"];
		 $paidAmount=$_GET["paidAmount"];
		 $supId=$_GET["supId"];
		
		 
		 
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<savePVDetails>\n";
				 
		 if(saveNewPVDetails($voucherNo, $invoiceNo, $amount, $balance, $paidAmount,$supId,$strPaymentType))
		{ 
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		 $ResponseXML .= "</savePVDetails>";
		 echo $ResponseXML;
	}

	
	
	else if (strcmp($DBOprType,"getSupData") == 0)
	{	
		 $supID=$_GET["supID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<supData>\n";
				 
		 $result=getSupData($supID);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<accPacID><![CDATA[" . $row["strAccPaccID"]  . "]]></accPacID>\n";
		 }
		 $ResponseXML .= "</supData>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getPaymentVouchers") == 0)
	{	
		 $supID=$_GET["supID"];
		 $dateFrom=$_GET["dateFrom"];
		 $dateTo=$_GET["dateTo"];
		 $voucherNo=$_GET["voucherNo"];
		 $invoiceNo=$_GET["invoiceNo"];
		 
		 
		 ///echo("BBBBBB BBB V");
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<PaymentData>\n";
				 
		 $result=getPaymentData($supID,$dateFrom,$dateTo,$strPaymentType,$voucherNo,$invoiceNo);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<strSupCode><![CDATA[" . $row["strSupCode"]  . "]]></strSupCode>\n";
			$ResponseXML .= "<payVoucherNo><![CDATA[" . $row["intVoucherNo"]  . "]]></payVoucherNo>\n";
			$ResponseXML .= "<datex><![CDATA[" . $row["dtDate"]  . "]]></datex>\n";
			$ResponseXML .= "<amount><![CDATA[" . round($row["PaidAmount"],4)  . "]]></amount>\n";
			$ResponseXML .= "<chequeNo><![CDATA[" . $row["strCheque"]  . "]]></chequeNo>\n";
			$ResponseXML .= "<type><![CDATA[" . $row["strType"]  . "]]></type>\n";
			
			
		 }
		 $ResponseXML .= "</PaymentData>";
		 echo $ResponseXML;
	}
	
	
	
	else if (strcmp($DBOprType,"getPaymentVouchersToPrint") == 0)
	{	
		 $supID=$_GET["supID"];
		 $payeeCat=$_GET["payeeCat"];

		 
		 $ResponseXML = "";
		 $ResponseXML .= "<PaymentData>\n";
				 
		 $result=getPaymentVouchersToPrint($supID,$payeeCat);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<payVoucherNo><![CDATA[" . $row["intVoucherNo"]  . "]]></payVoucherNo>\n";
			$ResponseXML .= "<datex><![CDATA[" . $row["dtDate"]  . "]]></datex>\n";
			$ResponseXML .= "<description><![CDATA[" . $row["strDescription"]  . "]]></description>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["PaidAmount"]  . "]]></amount>\n";
			$ResponseXML .= "<tax><![CDATA[" . $row["dblTaxAmt"]  . "]]></tax>\n";
			$ResponseXML .= "<type><![CDATA[" . $row["strType"]  . "]]></type>\n";
			
			
		 }
		 $ResponseXML .= "</PaymentData>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"PaymentVoucherNoTask") == 0)
	{	
		 $task=$_GET["task"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<paymentVoucher>\n";
				 
		 $result=getPaymentVoucherNo($strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<paymentVoucherNo><![CDATA[" . $row["dblPaymentVoucherNo"]  . "]]></paymentVoucherNo>\n";
		 }
		 $ResponseXML .= "</paymentVoucher>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"saveChequePrinterHeader") == 0)
	{	
		$chequeRefNo=$_GET["chequeRefNo"];
		$supID=$_GET["supID"];
		$chDate=$_GET["chDate"];
		$payee=$_GET["payee"];
		$bankID=$_GET["bankID"];
		$chequeType=$_GET["chequeType"];
		$totalAmount=$_GET["totalAmount"];
		$chkFormtat=$_GET["chkFormtat"];
		
		$userID=$_SESSION["UserID"];
		$factoryID=$_SESSION["FactoryID"];
		
		$ResponseXML = "";
		$ResponseXML .= "<Data>\n";
		
		if(saveChequePrinterHeader($chequeRefNo,$supID,$chDate,$payee,$bankID,$chequeType,$totalAmount,$chkFormtat,$userID,$factoryID))
		{
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
			
		$ResponseXML .= "</Data>";
		echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"saveChequePrinterDetails") == 0)
	{	
		$chequeRefNo=$_GET["chequeRefNo"];
		$voucherNo=$_GET["voucherNo"];
		$Description=$_GET["Description"];
		$amount=$_GET["amount"];
		$taxamount=$_GET["taxamount"];
		$chqMode=$_GET["chqMode"];
		
		$ResponseXML = "";
		$ResponseXML .= "<Data>\n";
		
		if(saveChequePrinterDetails($chequeRefNo,$voucherNo,$Description,$amount,$taxamount,$chqMode))
		{
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
			
		$ResponseXML .= "</Data>";
		echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"ChequeReferenceTask") == 0)
	{	
		 $task=$_GET["task"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<ChequeReference>\n";
				 
		 $result=getChequeReference($task);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<dblChequeRefNo><![CDATA[" . $row["dblChequeRefNo"]  . "]]></dblChequeRefNo>\n";
		 }
		 $ResponseXML .= "</ChequeReference>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"findChequeDetails") == 0)
	{	
		 $supID=$_GET["supID"];
		 $dateFrom=$_GET["dateFrom"];
		 $dateTo=$_GET["dateTo"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<ChequeData>\n";
				 
		 $result=findChequeDetails($supID,$dateFrom,$dateTo);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<chequeRefNo><![CDATA[" . $row["chequeRefNo"]  . "]]></chequeRefNo>\n";
			$ResponseXML .= "<chDate><![CDATA[" . $row["chDate"]  . "]]></chDate>\n";
			$ResponseXML .= "<totalAmount><![CDATA[" . $row["totalAmount"]  . "]]></totalAmount>\n";
			$ResponseXML .= "<chequeType><![CDATA[" . $row["chequeType"]  . "]]></chequeType>\n";
			$ResponseXML .= "<bankName><![CDATA[" . $row["bankName"]  . "]]></bankName>\n";
			$ResponseXML .= "<chqFormatID><![CDATA[" . $row["chqFormatID"]  . "]]></chqFormatID>\n";
			$ResponseXML .= "<strFromat><![CDATA[" . $row["strFromat"]  . "]]></strFromat>\n";
			$ResponseXML .= "<isChequePrinted><![CDATA[" . $row["isChequePrinted"]  . "]]></isChequePrinted>\n";

		 }
		 $ResponseXML .= "</ChequeData>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"findPayees") == 0)
	{	
		 $payeeCat=$_GET["payeeCat"];
		 
		 global $db; 
		 if($payeeCat=="S")
		 {
			$strSQL="SELECT strSupplierID AS pid ,strTitle AS payee FROM suppliers WHERE intStatus=1 order by strTitle";
		 }
		 else if($payeeCat=="P")
		 {
		  	$strSQL="SELECT intPayeeID AS pid ,strTitle AS payee FROM payee WHERE intStatus=1 order by strTitle";
		 } 
		 $result=$db->RunQuery($strSQL);
		
		 $ResponseXML = "";
		 $ResponseXML .= "<PayeeData>\n";

		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<PayeeID><![CDATA[" . $row["pid"]  . "]]></PayeeID>\n";
			$ResponseXML .= "<Payee><![CDATA[" . $row["payee"]  . "]]></Payee>\n";

		 }
		 $ResponseXML .= "</PayeeData>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"loadBatch") == 0)
	{
	 header('Content-Type: text/xml'); 
     echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	 
	 $cboCurrency=$_GET["cboCurrency"];
	 
	 $sql1 = "SELECT
				batch.intBatch,
				batch.strDescription
				FROM
				currencytypes
				Inner Join batch ON currencytypes.intCurID = batch.strCurrency
				WHERE = strCurrency = '$cboCurrency'";
	 $result1 = $db->RunQuery($sql1);
	 $ResponseXML .= "<loadBatch>";
	 while($row1 = mysql_fetch_array($result1)){  
	  $ResponseXML .= "<option value=\"". $row["intBatch"] ."\">" . $row["strDescription"] . "</option>";		
	 }	
	 $ResponseXML .= "</loadBatch>";
	 echo $ResponseXML;		
	}
	
	
function findChequeDetails($supID,$dateFrom,$dateTo)
{
	global $db; 
	if($supID==0)
	{
		$strSQL="SELECT chequeprinterhead.isChequePrinted, chequeprinterhead.chequeRefNo,chequeprinterhead.chDate, chequeprinterhead.totalAmount ,chequeprinterhead.chequeType,bank.strName as bankName,chequeformat.strFromat, chequeformat.chqFormatID FROM chequeprinterhead INNER JOIN bank ON (chequeprinterhead.bankID=bank.strBankCode) INNER JOIN chequeformat on (chequeprinterhead.intchqFormat=chequeformat.chqFormatID) WHERE chequeprinterhead.chDate>='$dateFrom' AND chequeprinterhead.chDate<='$dateTo' order by chequeprinterhead.isChequePrinted ";
	}
	else if($supID!=0)
	{
	 	$strSQL="SELECT chequeprinterhead.isChequePrinted,chequeprinterhead.chequeRefNo,chequeprinterhead.chDate, chequeprinterhead.totalAmount ,chequeprinterhead.chequeType,bank.strName as bankName,chequeformat.strFromat, chequeformat.chqFormatID FROM chequeprinterhead INNER JOIN bank ON (chequeprinterhead.bankID=bank.strBankCode) INNER JOIN chequeformat on (chequeprinterhead.intchqFormat=chequeformat.chqFormatID)  WHERE chequeprinterhead.supID='$supID' And chequeprinterhead.chDate>='$dateFrom' AND chequeprinterhead.chDate<='$dateTo'  order by chequeprinterhead.isChequePrinted";

	}
	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result; 

}

	
function getChequeReference($task)
{
	$compCode=$_SESSION["FactoryID"];
	
	global $db; 
	if($task==1)
	{
		$strSQL="SELECT dblChequeRefNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($task==2)
	{
		$strSQL="update syscontrol set  dblChequeRefNo= dblChequeRefNo+1  WHERE syscontrol.intCompanyID='$compCode'";	
		$db->RunQuery($strSQL);
		
		$strSQL="SELECT dblChequeRefNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result;
	}
}
	
function saveChequePrinterHeader($chequeRefNo,$supID,$chDate,$payee,$bankID,$chequeType,$totalAmount,$chkFormtat,$userID,$factoryID)
{
	global $db;
	$strSQL="INSERT INTO  chequeprinterhead(chequeRefNo,supID,chDate,payee,bankID, chequeType, intchqFormat, totalAmount, userID, factoryID) VALUES('$chequeRefNo','$supID','$chDate','$payee', '$bankID','$chequeType','$chkFormtat', '$totalAmount', '$userID', '$factoryID')";	
	
	//echo $strSQL;
	$db->RunQuery($strSQL);
	return true;
}
	
function saveChequePrinterDetails($chequeRefNo,$voucherNo,$Description,$amount,$taxamount,$chqMode)
{
	global $db;
	$strSQL="INSERT INTO chequeprinterdetails(chequeRefNo,voucherNo,amount,taxAmount,chqMode,description) values('$chequeRefNo','$voucherNo','$amount', '$taxamount','$chqMode','$Description')";	
	
	$db->RunQuery($strSQL);
	
	if($chqMode=="PO")
	{
		$strSQL="Update paymentheader set intChequePrinted=1 where intVoucherNo='$voucherNo'";
	}
	else if($chqMode=="WPO")
	{
		$strSQL="Update withoutpovoucher set intchequeprint=1 where strVoucherNo='$voucherNo'";
	}
	else if($chqMode=="ADVP")
	{
		$strSQL="Update advancepayment set intchequeprint=1 where PaymentNo='$voucherNo'";
	}
	
	
	$db->RunQuery($strSQL);
	
	return true;
}
	
	
	
function saveNewPVDetails($voucherNo, $invoiceNo, $amount, $balance, $paidAmount,$supId,$strPaymentType)
{
	global $db;

	$strSQL="INSERT INTO paymentdetails(strVoucherNo,strInvoiceNo,dblAmount,balance,PaidAmount,strType)VALUES('$voucherNo', '$invoiceNo', '$amount', '$balance', '$paidAmount','$strPaymentType')";
	//echo $strSQL;
	$db->RunQuery($strSQL);
	
	
	$strSQL="UPDATE invoiceheader SET dblPaidAmount = (dblPaidAmount + $amount),
                                      dblBalance    = (dblBalance - $amount)
             WHERE strInvoiceNo='$invoiceNo' and strType='$strPaymentType' AND strSupplierId = '$supId'";	 		
    $db->RunQuery($strSQL);

	$sql1 = "select dblAmount,dblPaidAmount,dblBalance from invoiceheader 
			 WHERE strInvoiceNo='$invoiceNo' and strType='$strPaymentType' AND strSupplierId = '$supId'";
	$result1 = $db->RunQuery($sql1);
	while($row1 = mysql_fetch_array($result1)){
	 $dblAmount     = $row1["dblAmount"];
	 $dblPaidAmount = $row1["dblPaidAmount"];
	 $dblBalance    = $row1["dblBalance"];
	}
	
	if($dblAmount == $dblPaidAmount){
	 $sql2 = "update invoiceheader set intPaid = '1'  WHERE strInvoiceNo='$invoiceNo' and strType='$strPaymentType' AND strSupplierId = '$supId'";	
	 $db->RunQuery($sql2);
	}
	
	
	return true;
}
	
function saveNewPVData($voucherNo, $schedualeNo, $description, $batchNo, $bankCode, $supID, $chequeNo, $datex,$amount,$currency,$rate,$accpakID,$userID,$strPaymentType,$strFactory)
{
	global $db;
	$strSQL="INSERT INTO paymentheader(intVoucherNo, strSchedulNo, strSupCode,  strDescription, strCheque, dtDate, strCurrency, dblRate, strBatch,strBankCode,dblAmount,strAccpacID,strUserID,strType,userFactoryCode) VALUES('$voucherNo', '$schedualeNo', '$supID', '$description', '$chequeNo', '$datex','$currency','$rate','$batchNo', '$bankCode','$amount','$accpakID','$userID','$strPaymentType','$strFactory')";
	
	$db->RunQuery($strSQL);
	//echo($strSQL);

return true;
} 

function getPaymentAmt($payNo)
{
	global $db;
	$strSQL="select  dblAmount from paymentheader where intVoucherNo='$payNo'";
	$result=$db->RunQuery($strSQL);
	return $result;


}
function getPaymentVoucherNo($strPaymentType)
{

	$compCode=$_SESSION["FactoryID"];
	global $db; 
		if($strPaymentType=="S")
		{
			$strSQL			=	"SELECT dblPaymentVoucherNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set  dblPaymentVoucherNo= dblPaymentVoucherNo+1  WHERE syscontrol.intCompanyID='$compCode'";
			$result_update	=	$db->RunQuery($strSQL);
		}
		else if($strPaymentType=="G")
		{
			$strSQL			=	"SELECT dblGeneralVoucherNo as dblPaymentVoucherNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set  dblGeneralVoucherNo= dblGeneralVoucherNo+1  WHERE syscontrol.intCompanyID='$compCode'";	
			$result_update	=	$db->RunQuery($strSQL);
		}
		else if($strPaymentType=="B")
		{
			$strSQL			=	"SELECT dblBulkVoucherNo as dblPaymentVoucherNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
			//echo $strSQL;
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set  dblBulkVoucherNo= dblBulkVoucherNo+1  WHERE syscontrol.intCompanyID='$compCode'";	
			$result_update	=	$db->RunQuery($strSQL);
		}
		return $result; 
	
}

function getPaymentData($supID,$dateFrom,$dateTo,$strPaymentType,$voucherNo,$invoiceNo)
{
	global $db;
			
	$strSQL = "SELECT DISTINCT
				suppliers.strTitle as strSupCode,
				paymentheader.intVoucherNo,
				paymentheader.dtDate,
				sum(paymentdetails.dblAmount) as PaidAmount,
				paymentheader.strCheque,
				paymentdetails.strType
				FROM
				paymentheader
				Inner Join paymentdetails ON paymentheader.intVoucherNo = paymentdetails.strVoucherNo AND paymentheader.strType = paymentdetails.strType
				Inner Join suppliers ON paymentheader.strSupCode = suppliers.strSupplierID
				WHERE paymentheader.strType='$strPaymentType'";	
				if($supID!="0"){
			    $strSQL .=" AND paymentheader.strSupCode='$supID'";
		        }
				if($dateFrom!=""){
					$strSQL .=" AND paymentheader.dtDate>='$dateFrom'";
				}
				if($dateTo!=""){
					$strSQL .=" AND paymentheader.dtDate<='$dateTo'";
				}
				if($voucherNo!=""){
					$strSQL .=" AND paymentheader.intVoucherNo='$voucherNo'";
				}
				if($invoiceNo!=""){
					$strSQL .=" AND strInvoiceNo='$invoiceNo'";
				}	
				
				$strSQL .= " GROUP BY paymentheader.intVoucherNo";
				//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getPaymentVouchersToPrint($supID,$payeeCat)
{
	global $db;

	if($supID==0)
	{
		if($payeeCat==1)
		{
			$strSQL="SELECT paymentheader.strType,invoicetaxes.dblamount AS dblTaxAmt, paymentheader.intVoucherNo,paymentheader.strDescription,  paymentheader.strCheque,paymentheader.dtDate, SUM(paymentdetails.PaidAmount) AS PaidAmount FROM paymentheader INNER JOIN paymentdetails ON (paymentheader.intVoucherNo=paymentdetails.strVoucherNo) LEFT JOIN invoicetaxes ON (paymentdetails.strInvoiceNo=invoicetaxes.strinvoiceno) AND (paymentheader.strSupCode=invoicetaxes.strsupplierid) WHERE paymentheader.intChequePrinted=0 GROUP BY paymentheader.intVoucherNo, paymentheader.strDescription, paymentheader.strCheque,paymentheader.dtDate";
		}
		else if($payeeCat==2)
		{
			$strSQL="";
		
		
		}
		else if($payeeCat==3)
		{
			$strSQL="";
		
		}
		
	}
	else
	{
		if($payeeCat==1)
		{
			$strSQL="SELECT paymentheader.strType,invoicetaxes.dblamount AS dblTaxAmt, paymentheader.intVoucherNo,paymentheader.strDescription,  paymentheader.strCheque,paymentheader.dtDate, SUM(paymentdetails.PaidAmount) AS PaidAmount FROM paymentheader INNER JOIN paymentdetails ON (paymentheader.intVoucherNo=paymentdetails.strVoucherNo) LEFT JOIN invoicetaxes ON (paymentdetails.strInvoiceNo=invoicetaxes.strinvoiceno) AND (paymentheader.strSupCode=invoicetaxes.strsupplierid) WHERE  paymentheader.strSupCode='$supID' And paymentheader.intChequePrinted=0  GROUP BY paymentheader.intVoucherNo, paymentheader.strDescription, paymentheader.strCheque,paymentheader.dtDate";
		}
		else if($payeeCat==2)
		{
			$strSQL="SELECT withoutpovoucher.strVoucherNo as intVoucherNo, withoutpovoucher.dtDate,withoutpovoucher.strDescription, withoutpovoucher.dblTotalAmount as PaidAmount,SUM(withoutpoinvoicetaxes.amount) AS dblTaxAmt FROM withoutpovoucher INNER JOIN withoutpoinvoicescheduledetails ON withoutpoinvoicescheduledetails.strScheduleNo = withoutpovoucher.strScheduleNo LEFT JOIN withoutpoinvoicetaxes ON withoutpoinvoicescheduledetails.strInvoiceNo = withoutpoinvoicetaxes.invoiceNo WHERE withoutpovoucher.intchequeprint=0 And withoutpovoucher.strPayeeID='$supID' GROUP BY withoutpovoucher.strVoucherNo,withoutpovoucher.dtDate,withoutpovoucher.strDescription,withoutpovoucher.strPayeeID, withoutpovoucher.dblTotalAmount  ORDER BY withoutpovoucher.dtDate";
		}
		else if($payeeCat==3)
		{
			$strSQL="SELECT PaymentNo as intVoucherNo,paydate as dtDate,description as strDescription,poamount  as PaidAmount,taxamount  AS dblTaxAmt,totalamount FROM advancepayment WHERE intchequeprint=0 and supid='$supID'";
			
		}
	}
	
	//echo $strSQL;
	
	$result=$db->RunQuery($strSQL);
	return $result; 
}



function getBank($batchID)
{
	global $db;
	$strSQL="SELECT
				bank.strBankCode,
				bank.strBankName,
				batch.strCurrency,
				currencytypes.strCurrency,
				exchangerate.rate
				FROM
				batch
				Inner Join bank ON (batch.strBankCode = bank.intBankId)
				Inner Join currencytypes ON batch.strCurrency = currencytypes.intCurID
				Inner Join exchangerate ON currencytypes.intCurID = exchangerate.currencyID
			WHERE   batch.intBatch = '$batchID'";	

	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getSupData($supID)
{
	global $db;
	$strSQL="SELECT strAccPaccID FROM suppliers WHERE strSupplierID='$supID'";	
	
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getCurrencyTypes()
{
	global $db;
	$strSQL="SELECT strCurrency,dblRate FROM currencytypes WHERE intStatus=1";
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getSupSchedules($supID,$strPaymentType)
{
	global $db;
	//$strSQL="SELECT strScheduelNo FROM paymentscheduleheader WHERE intStatus='0' AND strSupplierId='$supID' and strType='$strPaymentType'";
	//echo $strSQL;
	$strSQL = "SELECT distinct
				paymentscheduleheader.strScheduelNo
				FROM
				paymentscheduleheader
				Inner Join paymentscheduledetails ON paymentscheduleheader.strScheduelNo = paymentscheduledetails.strScheduelNo 
				AND paymentscheduleheader.strType = paymentscheduledetails.strType
				Inner Join invoiceheader ON paymentscheduledetails.strInvoiceNo = invoiceheader.strInvoiceNo 
				AND paymentscheduleheader.strSupplierId = invoiceheader.strSupplierId AND paymentscheduledetails.strType = invoiceheader.strType
				WHERE paymentscheduleheader. intStatus='0' AND paymentscheduleheader.strSupplierId='$supID' and paymentscheduleheader.strType='$strPaymentType'
				AND invoiceheader.intPaid != '1'";
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getInvoiceSchedul($schdNo,$strPaymentType,$supid)
{	
		
		global $db;
		
				 $strSQL = "SELECT distinct
						invoiceheader.strInvoiceNo,
						invoiceheader.dblTotalAmount,
						invoiceheader.dblPaidAmount,
						invoiceheader.dblBalance,
						paymentscheduleheader.strScheduelNo
						FROM
						invoiceheader
						Inner Join paymentscheduleheader ON invoiceheader.strSupplierId = paymentscheduleheader.strSupplierId
						Inner Join paymentscheduledetails ON paymentscheduleheader.strScheduelNo = paymentscheduledetails.strScheduelNo 
						AND invoiceheader.strInvoiceNo = paymentscheduledetails.strInvoiceNo
						WHERE
						invoiceheader.strSupplierId =  '$supid' AND
						invoiceheader.intStatus =  '1' AND 
						invoiceheader.intPaid != '1' AND 
						invoiceheader.strType = '$strPaymentType'";
						
					if($schdNo != '0'){
					 $strSQL .= " AND paymentscheduledetails.strScheduelNo =  '$schdNo'";
					}
							
		//echo $strSQL;
		$result=$db->RunQuery($strSQL);
		return $result;

}	





?>