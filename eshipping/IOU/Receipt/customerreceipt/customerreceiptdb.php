<?php 
session_start();
include("../../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["request"];

if ($request=='getData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$customerid=$_GET['customerid'];
	
	
	$str="select 	ii.intInvoiceNo, 
					ii.intIOUNo, 
					ii.strCustomerID, 
					date(ii.dtmInvoiceDate) as idate,	
					ii.dblTotalAmount,
					ii.dblPayableAmt,
					(select sum(adh.dblamount) from advancedetail adh where ii.intIOUNo=adh.intiouno)as dblAdvAllocated
					from 
					tbliouinvoice ii					
					where ii.strCustomerID='$customerid'";
	
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
			if($row["dblPayableAmt"]=="")
			$row["dblPayableAmt"]=$row["dblTotalAmount"];
			if($row["dblAdvAllocated"]=="")
			$row["dblAdvAllocated"]=0;
		$receivedamt=0;
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["intInvoiceNo"]  . "]]></InvoiceNo>\n";
		$XMLString .= "<IOUNo><![CDATA[" . $row["intIOUNo"]  . "]]></IOUNo>\n";
		$XMLString .= "<CustomerID><![CDATA[" . $row["strCustomerID"]  . "]]></CustomerID>\n";
		$XMLString .= "<idate><![CDATA[" . $row["idate"]  . "]]></idate>\n";
		$XMLString .= "<SerialNo><![CDATA[" . $row["dblSerialNo"]  . "]]></SerialNo>\n";
		$XMLString .= "<RTotAmt><![CDATA[" . $row["dblTotAmt"]  . "]]></RTotAmt>\n";
		$XMLString .= "<PayableAmt><![CDATA[" . $row["dblPayableAmt"]  . "]]></PayableAmt>\n";
		$XMLString .= "<TotalAmount><![CDATA[" . $row["dblTotalAmount"]  . "]]></TotalAmount>\n";
		$XMLString .= "<AdvanceAllo><![CDATA[" . $row["dblAdvAllocated"]  . "]]></AdvanceAllo>\n";
		$XMLString .= "<received><![CDATA[" . $receivedamt  . "]]></received>\n";		
	}
	
	$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='saveReceipt')
{
	$customerid=$_GET['customerid'];
	$Amount=$_GET['Amount'];
	$Description=$_GET['Description'];
	$advDate=date("y-m-d");
	
	$str="insert into advance_pay_header 
	( 
	strCustomerId, 
	strAdvDate, 
	strDescription, 
	strAmount, 
	strType
	)
	values
	(
	'$customerid', 
	'$advDate', 
	'$Description', 
	'$Amount', 
	'Cash');";
	$result=$db->RunQuery($str);
	
	if($result)
		echo "Sucessfully Saved.";

}

if ($request=='saveAdvanceAllocation')
{
	$advserialno=$_GET['advserialno'];
	$invoiceno=$_GET['invoiceno'];
	$amtallocated=$_GET['amtallocated'];
	$allocatingamt=$_GET['allocatingamt'];
	$advserialno=$_GET['advserialno'];
	$dateReceive=date("Y-m-d");
	
			
	$strInvUPdt="update tbliouinvoice 
	set	dblPayableAmt = dblPayableAmt-$allocatingamt,
	dblAdvAllocated =dblAdvAllocated+ $allocatingamt	
	where
	intInvoiceNo = '$invoiceno' ; ";
	$resultInvUpdt=$db->RunQuery($strInvUPdt);
	if($resultInvUpdt){
	
	$strUpdtAdvH="update advance_pay_header 
	set
	dblAllocated =dblAllocated+$allocatingamt	
	where
	advSerialNo = '$advserialno' ;";
	
	$resultAdvUpdt=$db->RunQuery($strUpdtAdvH);
	if ($resultAdvUpdt)
			{
					$strInsertAdvDtl="insert into advance_pay_detail 
					(advSerialNo, 
					strInvoiceNo, 
					dtmDate, 
					dblAmount
					)
					values
					('$advserialno', 
					'$invoiceno', 
					'$dateReceive', 
					'$allocatingamt');";
					 $resultAdvDtl=$db->RunQuery($strInsertAdvDtl);
					 
			 }
	 
	}

}

if($request=='saveHeader')
{

	$rcptSerial=$_GET['rcptSerial'];
	$customer=$_GET['customer'];
	$rcptdate=$_GET['rcptdate'];
	$amount=$_GET['amount'];
	$balance=$_GET['balance'];
	$creditnote=$_GET['creditnote'];
	$bank=$_GET['bank'];
	$chequerefno=$_GET['chequerefno'];
	$type=$_GET['type'];
	if($rcptdate){
	$InvoiceDateArray 	= explode('/',$rcptdate);
	$rcptdate = $InvoiceDateArray[2]."-".$InvoiceDateArray[1]."-".$InvoiceDateArray[0];
	}else $rcptdate=date("y-m-d");
	
	$str="insert into customerreceiptheader 
						(strRcptSerialNo, 
						strCustomerId, 
						strChequerefNo, 
						dtmReceiptDate, 
						intBankId, 
						strType, 
						dblAmount, 
						dblBalance, 
						strCreditNote
						)
						values
						('$rcptSerial', 
						'$customer', 
						'$chequerefno', 
						'$rcptdate', 
						'$bank', 
						'$type', 
						'$amount', 
						'$balance', 
						'$creditnote'
						);";
					 $result=$db->RunQuery($str);
		if( $result)
				{
					$strControl="update syscontrol set dblRcptSerialNo = dblRcptSerialNo+1";
					$resultControl=$db->RunQuery($strControl);				
				}
		if($resultControl)
		echo "successfully saved!";
}

if($request=='saveDetails')
{
	$receiptSerialNo=$_GET['receiptSerialNo'];
	$iouinvoice=$_GET['iouinvoice'];
	$iouno=$_GET['iouno'];
	$received=$_GET['received'];
	
	/*
	$strCheck="select strRcptSerialNo from customerreceiptdetail 
				where strRcptSerialNo="" and intdblIOUNo=""";
	$checkResult=$db->RunQuery($strCheck);
	$numrows=mysql_fetch_array($checkResult)
	
	if($numrows<1)
	{*/
	
	$strInvUPdt="update tbliouinvoice 
	set	dblPayableAmt = dblPayableAmt-$received
	where
	intInvoiceNo = '$iouinvoice' ";
	$resultInvUpdt=$db->RunQuery($strInvUPdt);
	if($resultInvUpdt){
	$str="insert into customerreceiptdetail 
			(strRcptSerialNo, 
			dblpaidamt, 
			intInvoiceNo, 
			intIOUNo
			)  
			values
			('$receiptSerialNo', 
			'$received', 
			'$iouinvoice', 
			'$iouno'
			)";}
	/*}
	else
	{	
		$str="update customerreceiptdetail 
				set
				strRcptSerialNo = 'strRcptSerialNo' , 
				dblpaidamt = 'dblpaidamt' , 
				intInvoiceNo = 'intInvoiceNo' , 
				intdblIOUNo = 'intdblIOUNo'
				
				where
				strRcptSerialNo = 'strRcptSerialNo' and intInvoiceNo = 'intInvoiceNo' ;";
	
	}*/
	$result=$db->RunQuery($str);
	
	if($result)
		echo "Sucessfully Saved.";
}


if($request=='newNo')
{
$strSerial="select dblRcptSerialNo from syscontrol";
$resultSerial=$db->RunQuery($strSerial);
$row=mysql_fetch_array($resultSerial);
echo $row["dblRcptSerialNo"];
}


?>
