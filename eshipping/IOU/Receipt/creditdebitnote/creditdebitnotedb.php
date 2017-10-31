<?php
	session_start();
	include "../../../Connector.php";	
	header('Content-Type: text/xml'); 	
	$request=$_GET["request"];
	
	if ($request=='getIOU')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$customerid=$_GET['customerid'];
	
	
	$str="select intInvoiceNo as intIOUNo from  tbliouinvoice where strCustomerID='$customerid' and dblPayableAmt>0";
	
	$XMLString= "<Data>";
	$XMLString .= "<IOUz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<IOUNo><![CDATA[" . $row["intIOUNo"]  . "]]></IOUNo>\n";
		
		//$XMLString .= "<Qty><![CDATA[" . $row["intQty"]  . "]]></Qty>\n";
	}
	
	$XMLString .= "</IOUz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='newNo')
{
			$str="select dblCnDNoteNo from syscontrol ";
			$results = $db->RunQuery($str); 
			$row= mysql_fetch_array($results);
			echo $row["dblCnDNoteNo"];
}

if ($request=='saveHeader')
{	
	$formSerial=$_GET['formSerial'];
	$customer=$_GET['customer'];
	$rcptdate=$_GET['formDate'];
	$chequerefno=$_GET['chequerefno'];
	$notetype=$_GET['notetype'];
	if($rcptdate){
	$InvoiceDateArray 	= explode('/',$rcptdate);
	$rcptdate = $InvoiceDateArray[2]."-".$InvoiceDateArray[1]."-".$InvoiceDateArray[0];
	}else $rcptdate=date("y-m-d");
	
	$str="	insert into tblcndnoteheader 
						(strCnDNo, 
						dtmDate, 
						intCustomerId, 
						strVatNo, 
						strType
						)
						values
						('$formSerial', 
						'$rcptdate', 
						'$customer', 
						'0', 
						'$notetype'
						);";
					 $result=$db->RunQuery($str);
		if( $result)
				{
					$strControl="update syscontrol set dblCnDNoteNo = dblCnDNoteNo+1";
					$resultControl=$db->RunQuery($strControl);				
				}
		if($resultControl)
		echo "successfully saved!";
	
}

if ($request=='saveDetail')
{
	$receiptSerialNo=$_GET['receiptSerialNo'];
	$iouno=$_GET['iouno'];
	$amount=$_GET['amount'];
	$total=$_GET['total'];
	$vat=$_GET['vat'];
	$description=$_GET['description'];
	$notetype=$_GET['notetype'];
	
	$str="	insert into tblcndnotedetail 
			(strCnDNo, 
			intInvoiceNo, 
			strDescription, 
			dblAmount, 
			dblVat, 
			dblTotal
			)
			values
			('$receiptSerialNo', 
			'$iouno', 
			'$description', 
			'$amount', 
			'$vat', 
			'$total');";


	$result=$db->RunQuery($str);
	if (($result) && $notetype=='C'){
		$str_adjust_payable="update tbliouinvoice set dblPayableAmt = dblPayableAmt-$total where	intInvoiceNo = '$iouno' ";
		$result_adjust_payable=$db->RunQuery($str_adjust_payable);
		if($result_adjust_payable)
				echo "updated";
	}
	else if (($result) && $notetype=='D'){
		$str_adjust_payable="update tbliouinvoice set dblPayableAmt = dblPayableAmt+$total where	intInvoiceNo = '$iouno' ";
		$result_adjust_payable=$db->RunQuery($str_adjust_payable);
		if($result_adjust_payable)
				echo "updated";
	}
}
?>