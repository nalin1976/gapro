<?php

include "../../Connector.php";
$id=$_GET['id'];

if($id=="loadGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$forwaderId=$_GET['forwaderId'];
	$carrierName=$_GET['carrierName'];
	
	$sql="SELECT
			commercial_invoice_detail.strBuyerPONo,
			commercial_invoice_header.intCusdec,
			commercial_invoice_header.intInvoiceId,
			commercial_invoice_header.strInvoiceNo,
			commercial_invoice_header.strCarrier,
			commercial_invoice_header.strForwader
			FROM
			commercial_invoice_detail
			INNER JOIN commercial_invoice_header ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo";
			
	if($forwaderId!=0 && $carrierName!='')
		$sql.=" WHERE strForwader='$forwaderId' AND strCarrier='$carrierName';";
	else if($forwaderId!=0 && $carrierName=='')
		$sql.=" WHERE strForwader='$forwaderId';";
	else if($carrierName!='' && $forwaderId==0)
		$sql.=" WHERE strCarrier='$carrierName';";
	
	//echo $sql;	
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<CusdecNo><![CDATA[" . $row["intCusdec"]  . "]]></CusdecNo>\n";
		$ResponseXML .= "<BPONo><![CDATA[" . $row["strBuyerPONo"]  . "]]></BPONo>\n";
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;	
}

if($id=='checkExists')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<CheckDetails>";

	$forwaderId=$_GET['forwaderId'];
	
	$sql="SELECT strBpoNo FROM forwader_invoice_detail WHERE strForwaderId='$forwaderId';";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<BPONo><![CDATA[" . $row["strBpoNo"]  . "]]></BPONo>\n";
	}
	$ResponseXML .= "</CheckDetails>";
	echo $ResponseXML;	
}

if($id=="saveHeader")
{
	$forwaderId=$_GET['forwaderId'];
	$carrierName=$_GET['carrierName'];
	$forwaderInvNo=$_GET['forwaderInvNo'];
	$amount=$_GET['amount'];
	$forInvDate=$_GET['forInvDate'];
	
	$dateForInvArray 	= explode('/',$forInvDate);
	$FormatDateForInv   = $dateForInvArray[2]."-".$dateForInvArray[1]."-".$dateForInvArray[0];
	
	$sql="INSERT INTO forwader_invoice_header (strForwaderId,strInvoiceNo,dtmDate,dblAmount)
		  VALUES('$forwaderId','$forwaderInvNo','$FormatDateForInv',$amount)";
	$result=$db->RunQuery($sql);
	
	if($result)
		echo 1;
	else
		echo 0;
	
}

if($id=='saveDetail')
{
	$forwaderId=$_GET['forwaderId'];
	$forwaderInvNo=$_GET['forwaderInvNo'];
	$cusdecNo=$_GET['cusdecNo'];
	$bpoNo=$_GET['bpoNo'];
	$commercialInvoiceNo=$_GET['commercialInvoiceNo'];
	
	$sql="INSERT INTO forwader_invoice_detail (strForwaderId,strInvoiceNo,intCusdecNo,strBpoNo,strCommercialInvoiceNo)
		  VALUES('$forwaderId','$forwaderInvNo',$cusdecNo,'$bpoNo','$commercialInvoiceNo');";
		  
	$result=$db->RunQuery($sql);
}

