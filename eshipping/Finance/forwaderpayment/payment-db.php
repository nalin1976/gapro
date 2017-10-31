<?php

include "../../Connector.php";
$id=$_GET['id'];

if($id=="loadGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";
	
	$searchDate=$_GET['searchDate'];
	$forwaderId=$_GET['forwaderId'];
	$dateFrom=$_GET['dateFrom'];
	$dateTo  =$_GET['dateTo'];
	
	$dateFromArray 	= explode('/',$dateFrom);
	$FormatDateFrom   = $dateFromArray[2]."-".$dateFromArray[1]."-".$dateFromArray[0];
	
	$dateToArray 	= explode('/',$dateTo);
	$FormatDateTo   = $dateToArray[2]."-".$dateToArray[1]."-".$dateToArray[0];
	
	$sql="SELECT strInvoiceNo,dtmDate,dblAmount,dblPaidAmount FROM forwader_invoice_header WHERE intForwaderId=$forwaderId ";	
	if($searchDate==1)
		$sql.="AND dtmDate<='$FormatDateTo' AND dtmDate>='$FormatDateFrom';";
		
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		if($row["dblPaidAmount"]==0)
		{
			$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$ResponseXML .= "<InvDate><![CDATA[" . $row["dtmDate"]  . "]]></InvDate>\n";
			$ResponseXML .= "<Amount><![CDATA[" . $row["dblAmount"]  . "]]></Amount>\n";
		}
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}

if($id=='saveGrid')
{
	$forwaderId=$_GET['forwaderId'];
	$invId=$_GET['invId'];
	$chequeNo  =$_GET['chequeNo'];
	$chequeValue=$_GET['chequeValue'];
	
	$sql="UPDATE forwader_invoice_header 
		  SET 
		  strChequeNo='$chequeNo',
		  dblPaidAmount=$chequeValue
		  WHERE
		  intForwaderId=$forwaderId AND strInvoiceNo='$invId'";
		  
	$result=$db->RunQuery($sql);
	
	$sql_select="SELECT 
				strCommercialInvoiceNo
				FROM
				forwader_invoice_detail
				WHERE
				strInvoiceNo='$invId'";
	$result_select=$db->RunQuery($sql_select);
	while($row=mysql_fetch_array($result_select))
	{
	$commercialInv=$row['strCommercialInvoiceNo'];
	$sql_update_comm="UPDATE commercial_invoice_header
						SET
						strFChequeNo='$chequeNo',
						intPaidStatus=1
						WHERE
						strInvoiceNo='$commercialInv'";
						
	$result_update_comm=$db->RunQuery($sql_update_comm);
	}
}