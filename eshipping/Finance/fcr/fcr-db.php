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
	
	$sql="SELECT DISTINCT
			commercial_invoice_detail.strBuyerPONo,
			commercial_invoice_detail.strEntryNo,
			commercial_invoice_header.intCusdec,
			commercial_invoice_header.intInvoiceId,
			commercial_invoice_header.strInvoiceNo,
			commercial_invoice_header.strCarrier,
			commercial_invoice_header.strForwader
			FROM
			commercial_invoice_detail
			INNER JOIN commercial_invoice_header ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo WHERE dtmFCRRecDate='0000-00-00'";
			
	if($forwaderId!=0)
		$sql.=" AND strForwader='$forwaderId'";
	if($carrierName!='')
		$sql.=" AND strCarrier='$carrierName'";
	
	//echo $sql;	
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<Forwader><![CDATA[" . $row["strForwader"]  . "]]></Forwader>\n";
		$ResponseXML .= "<CusdecNo><![CDATA[" . $row["strEntryNo"]  . "]]></CusdecNo>\n";
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
	
	$sql="SELECT strBpoNo FROM fcr_detail WHERE intForwaderId=$forwaderId;";
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
	$fcrNo=$_GET['fcrNo'];
	$amount=$_GET['amount'];
	$fcrDate=$_GET['fcrDate'];
	
	$dateFcrArray 	= explode('/',$fcrDate);
	$FormatDateFcr   = $dateFcrArray[2]."-".$dateFcrArray[1]."-".$dateFcrArray[0];
	
	$sql="INSERT INTO fcr_header (intForwaderId,strFcrNo,dtmDate)
		  VALUES($forwaderId,'$fcrNo','$FormatDateFcr')";
	$result=$db->RunQuery($sql);
	
	if($result)
		echo 1;
	else
		echo 0;
	
}

if($id=='saveDetail')
{
	/*$forwaderId=$_GET['forwaderId'];
	$fcrNo=$_GET['fcrNo'];
	$cusdecNo=$_GET['cusdecNo'];
	$bpoNo=$_GET['bpoNo'];*/
	$commercialInvoiceNo=$_GET['commercialInvoiceNo'];
	
	$fcrDate=$_GET['fcrDate'];
	$dateFcrArray 	= explode('/',$fcrDate);
	$FormatDateFcr   = $dateFcrArray[2]."-".$dateFcrArray[1]."-".$dateFcrArray[0];
	
	//$sql="INSERT INTO fcr_detail (intForwaderId,strFcrNo,intCusdecNo,strBpoNo,strCommercialInvoiceNo)
		//  VALUES($forwaderId,'$fcrNo','$cusdecNo','$bpoNo','$commercialInvoiceNo');";
		  
	//$result=$db->RunQuery($sql);
	
	$sql_update_comm="UPDATE commercial_invoice_header
						SET 
						dtmFCRRecDate='$FormatDateFcr'
						WHERE
						strInvoiceNo='$commercialInvoiceNo'";
						
	$result_update_comm=$db->RunQuery($sql_update_comm);
}

