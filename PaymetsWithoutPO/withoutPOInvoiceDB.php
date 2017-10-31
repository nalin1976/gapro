<?php
	session_start();
	include "../Connector.php";
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$DBOprType = $_GET["DBOprType"]; 
	

	if (strcmp($DBOprType,"WithouPOInvNoTask") == 0)
	{	
		 $invNo=$_GET["invNo"];
		 $payeeId=$_GET["payeeId"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<InvNo>\n";
				
		 $result=getWithouPOInvNo($invNo,$payeeId);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<WithouPOInvNo><![CDATA[" . $row["invoiceNo"]  . "]]></WithouPOInvNo>\n";
		 }
		 $ResponseXML .= "</InvNo>";
		 echo $ResponseXML;
	}
	
	
	else if (strcmp($DBOprType,"WithouPOInvNoOperation") == 0)
	{	
		 $task=$_GET["task"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<InvNo>\n";
				
		 $result=WithouPOInvNoOperation($task);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<dblWithoutPOInvNo><![CDATA[" . $row["dblWithoutPOInvNo"]  . "]]></dblWithoutPOInvNo>\n";
		 }
		 $ResponseXML .= "</InvNo>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getFactoryList") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<Factory>\n";
		
		 $result=getFactoryList();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<compID><![CDATA[" . $row["strComCode"]  . "]]></compID>\n";
			$ResponseXML .= "<compName><![CDATA[" . $row["strName"]  . "]]></compName>\n";
		 }
		 
		 $ResponseXML .= "</Factory>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getGLAccountList") == 0)
	{

		 $fc=$_GET["facID"];
		 $NameLike=$_GET["NameLike"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccs>\n";

		 $result=getGLAccList($fc,$NameLike);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<accNo><![CDATA[" . $row["strAccID"]  . "]]></accNo>\n";
			$ResponseXML .= "<accDes><![CDATA[" . $row["strDescription"]  . "]]></accDes>\n";
		 }
		 
		 $ResponseXML .= "</GLAccs>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getTaxTypes") == 0)
	{	
		 $ResponseXML = "";
		 $ResponseXML .= "<TaxTypes>\n";
				 
		 $result=getTaxTypes();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<taxTypeID><![CDATA[" . $row["strTaxTypeID"]  . "]]></taxTypeID>\n";
			$ResponseXML .= "<taxType><![CDATA[" . $row["strTaxType"]  . "]]></taxType>\n";
			$ResponseXML .= "<taxRate><![CDATA[" . $row["dblRate"]  . "]]></taxRate>\n";
		 }
		 $ResponseXML .= "</TaxTypes>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getEntryNo") == 0)
	{	
		 $batchNo=$_GET["batchNo"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<BatchEntryNo>\n";
				 
		 $result=getEntryNo($batchNo);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<entryNo><![CDATA[" . $row["batchEntryNo"]  . "]]></entryNo>\n";
		 }
		 $ResponseXML .= "</BatchEntryNo>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"saveWithoutPOInvoice") == 0)
	{	
		 $invoiceNo=$_GET["invoiceNo"];
		 $payeeID=$_GET["payeeID"];
		 $companyID=$_GET["companyID"];
		 $invDate=$_GET["invDate"];
		 $discription=$_GET["discription"];
		 $batchNo=$_GET["batchNo"];
		 $batchEntryNo=$_GET["batchEntryNo"];
		 $vatNo=$_GET["vatNo"];
		 $accpacID=$_GET["accpacID"];
		 $currency=$_GET["currency"];
		 $rate=$_GET["rate"];
		 $amount=$_GET["amount"];
		 $discount=$_GET["discount"];
		 $taxAmt=$_GET["taxAmt"];
		 $totalInvAmount=$_GET["totalInvAmount"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<NewWithoutPOInvoice>\n";
		 if(saveWithoutPOInvoice($invoiceNo,$payeeID,$companyID,$invDate,$discription,$batchNo,$batchEntryNo,$vatNo,$accpacID,$currency,$rate,$amount,$discount,$taxAmt,$totalInvAmount))
		 {
	
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		} 
		else
		{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
	
		 $ResponseXML .= "</NewWithoutPOInvoice>";
		 echo $ResponseXML;
	
	}
	else if (strcmp($DBOprType,"saveWithoutPOInvoiceGLAllowcation") == 0)
	{	
		 $invoiceNo=$_GET["invoiceNo"];
		 $glAccNo=$_GET["glAccNo"];
		 $amount=$_GET["amount"];
		 $payeeID=$_GET["payeeID"];
		 
		
		 $ResponseXML = "";
		 $ResponseXML .= "<NewWithoutPOInvoiceGLAccs>\n";
		 if(saveWithoutPOInvoiceGLAllowcation($invoiceNo,$glAccNo,$amount,$payeeID))
		 {
	
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		} 
		else
		{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
	
		 $ResponseXML .= "</NewWithoutPOInvoiceGLAccs>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"saveWithoutPOInvoiceTaxes") == 0)
	{	
		 $invoiceNo=$_GET["invoiceNo"];
		 $taxID=$_GET["taxID"];
		 $amount=$_GET["amount"];
		
		 $ResponseXML = "";
		 $ResponseXML .= "<NewWithoutPOInvoiceTaxes>\n";
		 if(saveWithoutPOInvoiceTaxes($invoiceNo,$taxID,$amount))
		 {
		 	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 } 
		 else
		 {
		 	$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
	
		 $ResponseXML .= "</NewWithoutPOInvoiceTaxes>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"rollBackTrance") == 0)
	{	
		$invoiceNo=$_GET["invoiceNo"];
	
		$ResponseXML = "";
		$ResponseXML .= "<CalcelWithoutPOInvoice>\n";
		if(rollBackTrance($invoiceNo))
		{
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		} 
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		
		$ResponseXML .= "</CalcelWithoutPOInvoice>";
		echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getInvoicesData") == 0)
	{	
		$payeeID=$_GET["payeeID"];
		$dateFrom=$_GET["dateFrom"];
		$dateTo=$_GET["dateTo"];
		$invNoLike=$_GET["invNoLike"];
		$type=$_GET["type"];
		
		$ResponseXML = "";
		$ResponseXML .= "<WithoutPOInvoiceData>\n";
		
		$result=getInvoicesData($payeeID,$dateFrom,$dateTo,$invNoLike,$type);
		
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<invNo><![CDATA[" . $row["invoiceNo"]  . "]]></invNo>\n";
			$ResponseXML .= "<payee><![CDATA[" . $row["strTitle"]  . "]]></payee>\n";
			$ResponseXML .= "<description><![CDATA[" . $row["discription"]  . "]]></description>\n";
			$ResponseXML .= "<date><![CDATA[" . $row["invDate"]  . "]]></date>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["amount"]  . "]]></amount>\n";
		 }
		
		$ResponseXML .= "</WithoutPOInvoiceData>";
		echo $ResponseXML;
	}
	
function getInvoicesData($payeeID,$dateFrom,$dateTo,$invNoLike,$type)
{
	global $db;
	
	if($payeeID!=0)
		$strSQL="select withoutpoinvoice.*,payee.strTitle from withoutpoinvoice inner join payee on (withoutpoinvoice.payeeID=payee.intPayeeID) where withoutpoinvoice.payeeID='$payeeID' and withoutpoinvoice.invDate>='$dateFrom' and withoutpoinvoice.invDate<='$dateTo' and withoutpoinvoice.invoiceNo like'%$invNoLike%' and  withoutpoinvoice.intStatus=$type";
	else if($payeeID==0)
	{
		$strSQL="select withoutpoinvoice.*,payee.strTitle from withoutpoinvoice inner join payee on (withoutpoinvoice.payeeID=payee.intPayeeID) where withoutpoinvoice.invDate>='$dateFrom' and withoutpoinvoice.invDate<='$dateTo' and withoutpoinvoice.invoiceNo like'%$invNoLike%' and  withoutpoinvoice.intStatus=$type";
	}
	//echo($strSQL);
	$result=$db->RunQuery($strSQL);
	return $result;
}
function rollBackTrance($invoiceNo)
{
	global $db;
	$strSQL="delete from withoutpoinvoice where invoiceNo='$invoiceNo'";
	$db->RunQuery($strSQL);

	$strSQL="delete from withoutpoinvoiceglallowcation where invoiceNo='$invoiceNo'";
	$db->RunQuery($strSQL);

	$strSQL="delete from withoutpoinvoicetaxes where invoiceNo='$invoiceNo'";
	$db->RunQuery($strSQL);

	return true;

}

function saveWithoutPOInvoiceTaxes($invoiceNo,$taxID,$amount)
{
	global $db;
	$strSQL="INSERT INTO withoutpoinvoicetaxes(invoiceNo,taxID,amount) VALUES('$invoiceNo','$taxID','$amount')";
	$db->RunQuery($strSQL);
	return true;
}	
	
function saveWithoutPOInvoiceGLAllowcation($invoiceNo,$glAccNo,$amount,$payeeID)
{
	global $db;
	$strSQL="INSERT INTO withoutpoinvoiceglallowcation(invoiceNo,glAccNo,amount,payeeID) VALUES('$invoiceNo','$glAccNo','$amount', '$payeeID')";
	
	//echo $strSQL;
	$db->RunQuery($strSQL);
	return true;
}
	
function saveWithoutPOInvoice($invoiceNo,$payeeID,$companyID,$invDate,$discription,$batchNo,$batchEntryNo,$vatNo,$accpacID,$currency,$rate,$amount,$discount,$taxAmt,$totalInvAmount)
{

	global $db;
	$strSQL="INSERT INTO withoutpoinvoice(invoiceNo, payeeID, companyID, invDate, discription, batchNo, batchEntryNo,vatNo,accpacID,currency,rate,amount,discount,taxAmt,totalInvAmount) VALUES('$invoiceNo','$payeeID','$companyID','$invDate', '$discription', '$batchNo', '$batchEntryNo', '$vatNo', '$accpacID', '$currency', '$rate','$amount', '$discount', '$taxAmt', '$totalInvAmount')";
	
	//print($strSQL);
	$db->RunQuery($strSQL);
	return true; 


}
	
function getEntryNo($batchNo)
{
	global $db;
	$strSQL="SELECT batchNo,batchEntryNo FROM withoutpoinvoice WHERE batchNo='$batchNo'";
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getTaxTypes()
{
	global $db;
	$strSQL="SELECT strTaxTypeID,strTaxType,dblRate FROM taxtypes";
	$result=$db->RunQuery($strSQL);
	return $result; 
}
function getWithouPOInvNo($invNo,$payeeId)
{	
	$compCode=$_SESSION["FactoryID"];
	global $db; 
	/*if($task==1)
	{
		$strSQL="SELECT  dblWithoutPOInvNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($task==2)
	{
		$strSQL="update syscontrol set  dblWithoutPOInvNo= dblWithoutPOInvNo+1 WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		$strSQL="SELECT dblWithoutPOInvNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result;
	}*/
	
	$strSQL="SELECT invoiceNo FROM withoutpoinvoice WHERE invoiceNo='$invNo' AND payeeID='$payeeId'";
	
	//echo($strSQL);
	
	$result=$db->RunQuery($strSQL);
	return $result;
	
	
}

function WithouPOInvNoOperation($task)
{	
	$compCode=$_SESSION["FactoryID"];
	global $db; 
	if($task==1)
	{
		$strSQL="SELECT  dblWithoutPOInvNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($task==2)
	{
		$strSQL="update syscontrol set  dblWithoutPOInvNo= dblWithoutPOInvNo+1 WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		$strSQL="SELECT dblWithoutPOInvNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result;
	}
}

function getFactoryList()
{
	global $db;
	$strSQL="SELECT strComCode ,strName FROM companies WHERE intStatus=1 ORDER BY strName";
	$result=$db->RunQuery($strSQL);
	return $result;
}
function getGLAccList($facID,$NameLike)
{
	global $db;
	$strSQL="SELECT  * FROM glaccounts WHERE strFacCode='$facID' and strDescription like '$NameLike%'";
	$result=$db->RunQuery($strSQL);
	return $result;
}




?>