<?php

include "../../../Connector.php";
$id=$_GET['id'];
if($id=='loadInvoiceCombo')
{
	$forwaderId=$_GET['forwaderId'];
	$sql="SELECT
		  forwader_invoice_header.strInvoiceNo
		  FROM
		  forwader_invoice_header
		  WHERE intForwaderId=$forwaderId
			";
	$result=$db->RunQuery($sql);
	$response="<option value='0'></option>";
	while($row=mysql_fetch_array($result))
	{
		$response.="<option value=".$row['strInvoiceNo'].">".$row['strInvoiceNo']."</option>";
	}
	echo $response;
}

if($id=="loadGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$forwaderId=$_GET['forwaderId'];
	$invoiceNo=$_GET['invoiceNo'];
	$accSubmitted=$_GET['accSubmitted'];
	$dateFrom=$_GET['dateFrom'];
	$dateTo=$_GET['dateTo'];
	$searchDate=$_GET['searchDate'];
	
	
	$dateFromInvArray 	= explode('/',$dateFrom);
	$FormatDateFrom   = $dateFromInvArray[2]."-".$dateFromInvArray[1]."-".$dateFromInvArray[0];
	
	$dateToArray 	= explode('/',$dateTo);
	$FormatDateTo   = $dateToArray[2]."-".$dateToArray[1]."-".$dateToArray[0];
	
	
	$sql="SELECT
			forwader_invoice_header.strInvoiceNo,
			forwader_invoice_header.dtmDate,
			forwader_invoice_header.dblAmount,
			forwader_invoice_header.strChequeNo,
			forwader_invoice_header.dblPaidAmount,
			forwader_invoice_header.intSubmitStatus,
			forwader_invoice_header.dtmSubmitDate
			FROM
			forwader_invoice_header
			WHERE intForwaderId=$forwaderId 
			";
			
	if($invoiceNo!=0)
		$sql.=" AND strInvoiceNo='$invoiceNo'";
	if($accSubmitted=='Submitted')
		$sql.=" AND intSubmitStatus=1";
	if($accSubmitted=='NotSubmitted')
		$sql.=" AND intSubmitStatus=0";
	if($searchDate==1)
		$sql.=" AND  dtmDate<='$FormatDateTo' AND dtmDate >='$FormatDateFrom'";
	//echo $sql;	
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
			$dateSubmitArray 	= explode('-',$row['dtmSubmitDate']);
			$FormatDateSubmit   = $dateSubmitArray[2]."/".$dateSubmitArray[1]."/".$dateSubmitArray[0];
			
			$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$ResponseXML .= "<Date><![CDATA[" . $row["dtmDate"]  . "]]></Date>\n";
			$ResponseXML .= "<Amount><![CDATA[" . $row["dblAmount"]  . "]]></Amount>\n";
			$ResponseXML .= "<ChequeNo><![CDATA[" . $row["strChequeNo"]  . "]]></ChequeNo>\n";
			$ResponseXML .= "<PaidAmount><![CDATA[" . $row["dblPaidAmount"]  . "]]></PaidAmount>\n";
			$ResponseXML .= "<SubmitStatus><![CDATA[" . $row["intSubmitStatus"]  . "]]></SubmitStatus>\n";
			$ResponseXML .= "<SubmitDate><![CDATA[" . $FormatDateSubmit  . "]]></SubmitDate>\n";
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;	
}

?>