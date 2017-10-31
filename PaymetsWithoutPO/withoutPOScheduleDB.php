<?php
	session_start();
	include "../Connector.php";
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$DBOprType = $_GET["DBOprType"]; 

	if (strcmp($DBOprType,"WithouPOPayNoTask") == 0)
	{	
		 $task=$_GET["task"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<SchedNo>\n";
				
		 $result=getWithouPOSchedNo($task);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<WithouPOSchedNo><![CDATA[" . $row["dblWithoutPOSheduleNo"]  . "]]></WithouPOSchedNo>\n";
		 }
		 $ResponseXML .= "</SchedNo>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getPayeeInvoices") == 0)
	{	
		 $payeeID=$_GET["payeeID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<Invoices>\n";
				
		 $result=getPayeeInvoices($payeeID);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<invoiceNo><![CDATA[" . $row["invoiceNo"]  . "]]></invoiceNo>\n";
			$ResponseXML .= "<discription><![CDATA[" . $row["discription"]  . "]]></discription>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["amount"]  . "]]></amount>\n";
			$ResponseXML .= "<taxAmt><![CDATA[" . $row["taxAmt"]  . "]]></taxAmt>\n";
			$ResponseXML .= "<discount><![CDATA[" . $row["discount"]  . "]]></discount>\n";
			$ResponseXML .= "<totalInvAmount><![CDATA[" . $row["totalInvAmount"]  . "]]></totalInvAmount>\n";
			$ResponseXML .= "<invDate><![CDATA[" . $row["invDate"]  . "]]></invDate>\n";
		 }
		 $ResponseXML .= "</Invoices>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"WithouPONewShedule") == 0)
	{	
		 $scheduleNo=$_GET["scheduleNo"];
		 $payeeID=$_GET["payeeID"];
		 $datex=$_GET["datex"];
		 $amount=$_GET["amount"];
		 $tottax=$_GET["tottax"];
		 $totdiscunt=$_GET["totdiscunt"];
		 $totamount=$_GET["totamount"];

		 
		 $ResponseXML = "";
		 $ResponseXML .= "<Invoices>\n";
				
		 if(saveNewSchedule($scheduleNo,$payeeID,$datex,$amount,$tottax,$totdiscunt,$totamount))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 } 
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</Invoices>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"WithouPONewSheduleInvs") == 0)
	{	
		 $scheduleNo=$_GET["scheduleNo"];
		 $invID=$_GET["invID"];

		 $ResponseXML = "";
		 $ResponseXML .= "<Invoices>\n";
				
		 if(saveNewScheduleInvs($scheduleNo,$invID))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 } 
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</Invoices>";
		 echo $ResponseXML;
	}

function saveNewScheduleInvs($scheduleNo,$invID)
{
	global $db; 
	$strSQL="INSERT INTO withoutpoinvoicescheduledetails(strScheduleNo,strInvoiceNo) VALUES('$scheduleNo','$invID')";
	$db->RunQuery($strSQL);

	$strSQL="UPDATE withoutpoinvoice SET intStatus=1 WHERE invoiceNo='$invID' ";
	$db->RunQuery($strSQL);
	return true;

}


function saveNewSchedule($scheduleNo,$payeeID,$datex,$amount,$tottax,$totdiscunt,$totamount)
{
	global $db; 
	$strSQL="INSERT INTO withoutpoinvoicescheduleheader(strScheduleNo, strPayeeID,dtDate,dblAmount,dblTotTax, dblTotDiscount, dblTotAmount)  VALUES('$scheduleNo','$payeeID','$datex','$amount','$tottax','$totdiscunt','$totamount')";
	$db->RunQuery($strSQL);
	return true; 

}
	
function getWithouPOSchedNo($task)
{
	$compCode=$_SESSION["FactoryID"];
	global $db; 
	if($task==1)
	{
		$strSQL="SELECT  dblWithoutPOSheduleNo FROM syscontrol   WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($task==2)
	{
		$strSQL="update syscontrol set  dblWithoutPOSheduleNo= dblWithoutPOSheduleNo+1   WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		$strSQL="SELECT dblWithoutPOSheduleNo FROM syscontrol   WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result;
	}
}

function getPayeeInvoices($payeeID)
{
	global $db;
	$strSQL="SELECT invoiceNo,discription,amount,taxAmt,discount,totalInvAmount,invDate FROM withoutpoinvoice WHERE payeeID='$payeeID' AND intStatus=0";
	//print($strSQL);
	$result=$db->RunQuery($strSQL);
	return $result;

}

	
?>