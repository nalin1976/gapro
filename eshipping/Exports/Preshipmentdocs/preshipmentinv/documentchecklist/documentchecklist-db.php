<?php
session_start();
include "../../Connector.php";
$id=$_GET['id'];



if($id=="loadChkDataToGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<GridDetails>";

	$cboInvoiceFormat=$_GET['cboInvoiceFormat'];
	//echo $cboInvoiceFormat;
	
	$sql="SELECT
documentformats.intDocumentId,
commercialinvformat.intCommercialInvId,
documentformats.strDocumentTitle
FROM
commercialinvformat
INNER JOIN commercialinvoicedocuments ON commercialinvoicedocuments.intFormatId = commercialinvformat.intCommercialInvId
INNER JOIN documentformats ON documentformats.intDocumentId = commercialinvoicedocuments.intDocumentId
WHERE intCommercialInvId = '$cboInvoiceFormat'
				";
	
	$result=$db->RunQuery($sql);
	
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{

			$ResponseXML .= "<docId><![CDATA[" . $row["strDocumentTitle"]  . "]]></docId>\n";
	
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}


if($id=="loadInvFormats")
{
$ResponseXML = "<XMLLoadOrderNo>\n";
$buy	= $_GET["cboBuyer"];
	$sql ="SELECT
commercialinvformat.intCommercialInvId,
commercialinvformat.strCommercialInv
FROM
commercialinvformat
where intBuyer = '$buy'";
	$result=$db->RunQuery($sql);
		$ResponseXML .="<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<option value=".$row["intCommercialInvId"].">".$row["strCommercialInv"]."</option>";
	}
$ResponseXML .= "</XMLLoadOrderNo>";
echo $ResponseXML;	
	
	
	
	/*
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$buy = $_GET['cboBuyer'];
echo $buy;

echo $load_inv ="SELECT
commercialinvformat.intCommercialInvId,
commercialinvformat.strCommercialInv
FROM
commercialinvformat
where intBuyer = '$buy'
";
$result_inv =$db->RunQuery($load_inv);
$ResponseXML ="<data>";
while($row = mysql_fetch_array($result_inv))
{ 
$ResponseXML .= "<invFor><![CDATA[".($row["strCommercialInv"])  . "]]></invFor>\n";

}
$ResponseXML .="</data>";
echo $ResponseXML;*/ 


}

if($id=="loadGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<GridDetails>";

	$mainBuyerId=$_GET['mainBuyerId'];
	
	
	$sql="SELECT
	ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS dblAmount,
	ROUND(SUM(commercial_invoice_detail.dblQuantity),2) AS dblQuantity,
	commercial_invoice_detail.strInvoiceNo,
	commercial_invoice_header.dtmInvoiceDate,
	buyers.strName,
	commercial_invoice_detail.strBuyerPONo
	FROM
	commercial_invoice_detail
	INNER JOIN commercial_invoice_header ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
	INNER JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strBuyerID
	WHERE buyers.strBuyerId = '$mainBuyerId' GROUP BY commercial_invoice_detail.strInvoiceNo
				";
	
	$result=$db->RunQuery($sql);
	
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
			$dateToArray 	= explode(' ',$row["dtmInvoiceDate"]);
			$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$ResponseXML .= "<InvAmount><![CDATA[" . $row["dblAmount"]  . "]]></InvAmount>\n";
			$ResponseXML .= "<InvDate><![CDATA[" . $dateToArray[0]  . "]]></InvDate>\n";
			$ResponseXML .= "<InvQty><![CDATA[" . $row["dblQuantity"]  . "]]></InvQty>\n";
			$ResponseXML .= "<InvPoNo><![CDATA[" . $row["strBuyerPONo"]  . "]]></InvPoNo>\n";
	
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}



if($id=='saveHeader')
{
	$serialNo=$_GET['serialNo'];
	$buyerCode=$_GET['buyerCode'];
	$newDate=$_GET['newDate'];
	
	$dateArray 	= explode('/',$newDate);
	$FormatDate = $dateArray[2]."-".$dateArray[1]."-".$dateArray[0];
	
	if($serialNo==0)
	{
		$sql_increment="UPDATE syscontrol
						SET
						intSerialNo=intSerialNo+1;";
		$result_increment=$db->RunQuery($sql_increment);
		
		$sql_select="SELECT intSerialNo FROM syscontrol;";
		$result_select=$db->RunQuery($sql_select);
		$row_select=mysql_fetch_array($result_select);
		
		$serialNo=$row_select['intSerialNo'];
	}
		
		$sql_insert="INSERT INTO bankletter_header (intSerialNo,intMainBuyerId,dtmDate)
					  VALUES ($serialNo,'$buyerCode',NOW());";
		$result_insert=$db->RunQuery($sql_insert);
		if($result_insert)
			echo $serialNo;
		else
			echo 0;
}

if($id=='saveDetail')
{
	$serialNo=$_GET['serialNo'];
	$invoiceNo=$_GET['invoiceNo'];
	//$newDate=$_GET['newDate'];
	
	$dateArray 	= explode('/',$newDate);
	$FormatDate = $dateArray[2]."-".$dateArray[1]."-".$dateArray[0];
	
	
	echo $sql_insert="INSERT INTO bankletter_detail (intSerialNo,strInvoiceNo)
					 VALUES ($serialNo,'$invoiceNo')";
	$result_insert=$db->RunQuery($sql_insert);
	
	/*$sql_update="UPDATE commercial_invoice_header
				  SET
				  intDocSubmitStatus=1,
				  dtmDocSubmitDate=NOW()
				  WHERE strInvoiceNo='$invoiceNo'";
	$result_update=$db->RunQuery($sql_update);*/
}

if($id=='deleteSavedSerials')
{
	$serialNo=$_GET['serialNo'];
	$sql_del_header="DELETE FROM bankletter_header WHERE intSerialNo=$serialNo;";
	$result_del_header=$db->RunQuery($sql_del_header);
	
	$sql_del_detail="DELETE FROM bankletter_detail WHERE intSerialNo=$serialNo;";
	$result_del_detail=$db->RunQuery($sql_del_detail);
}

if($id=='loadHeaderDetails')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$serialNo=$_GET['serialNo'];
	
	$sql="SELECT
		bankletter_header.intMainBuyerId,
		bankletter_header.dtmDate,
		bankletter_detail.strInvoiceNo,
		ROUND(SUM(commercial_invoice_detail.dblAmount),2) as dblAmount,
		ROUND(SUM(commercial_invoice_detail.dblQuantity),2) AS dblQuantity,
		commercial_invoice_detail.strBuyerPONo
		FROM
		bankletter_header
		INNER JOIN bankletter_detail ON bankletter_header.intSerialNo = bankletter_detail.intSerialNo
		INNER JOIN commercial_invoice_header ON bankletter_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
		INNER JOIN commercial_invoice_detail ON bankletter_detail.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
		WHERE bankletter_header.intSerialNo=$serialNo GROUP BY commercial_invoice_detail.strInvoiceNo;
			";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$dateFromArray 	= explode(' ',$row["dtmInvoiceDate"]);
		$dateFromArray1 = explode('-',$dateFromArray[0]);
		$dateFormatFrom = $dateFromArray1[2]."/".$dateFromArray1[1]."/".$dateFromArray1[0];
		
		$dateArray1 = explode('-',$row["dtmDate"]);
		$dateFormat = $dateArray1[2]."/".$dateArray1[1]."/".$dateArray1[0];
		
		
		$ResponseXML .= "<BuyerCode><![CDATA[" . $row["intMainBuyerId"]  . "]]></BuyerCode>\n";
		//$ResponseXML .= "<FromDate><![CDATA[" . $dateFormatFrom  . "]]></FromDate>\n";
		$ResponseXML .= "<Date><![CDATA[" . $dateFormat  . "]]></Date>\n";
		$ResponseXML .= "<InvNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvNo>\n";
		$ResponseXML .= "<Amount><![CDATA[" . $row["dblAmount"]  . "]]></Amount>\n";
		$ResponseXML .= "<InvDate><![CDATA[" . $dateFromArray[0]  . "]]></InvDate>\n";
		$ResponseXML .= "<InvQty><![CDATA[" . $row["dblQuantity"]  . "]]></InvQty>\n";
		$ResponseXML .= "<InvPoNo><![CDATA[" . $row["strBuyerPONo"]  . "]]></InvPoNo>\n";
	}		
		
	
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}

if($id=='CancelInv')
{	
$invoiceNo=$_GET['invoiceNo'];
$cboSerialNo=$_GET['cboSerialNo'];
	
	 $sql_status="UPDATE bankletter_header	
					SET intCancelStatus=1
					WHERE intSerialNo='$cboSerialNo';";
					
	$result=$db->RunQuery($sql_status);
	 //$cboRefNo;
	
	if($result)
	{
	$sql_update_comm="UPDATE commercial_invoice_header
						SET 
						commercial_invoice_header.intDocSubmitStatus=0
						WHERE
						strInvoiceNo='$invoiceNo'";
						
	$result_update_comm=$db->RunQuery($sql_update_comm);
	 //echo $cboRefNo;
	  $result_update_comm;
	}
}



?>