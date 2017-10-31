<?php 
include "../../Connector.php";

$id=$_GET["id"];

if($id=="loadGrn")
{
		$grnFromNo		= $_GET["grnFromNo"];
		$grnToNo		= $_GET["grnToNo"];
		$grnFromDate	= $_GET["grnFromDate"];
		$grnToDate		= $_GET["grnToDate"];
		$intStatus		= $_GET["intStatus"];
		$invNo 			= $_GET["invNo"];
		$intPoNo		= $_GET["PoNo"];
		$intCompanyId	= $_GET["intCompanyId"];
		$intUserId		= $_GET["intUserId"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<GRNList>";
		$SQL=  "SELECT DISTINCT
				grnheader.intGrnNo AS GrnNo,
				grnheader.intPoNo AS PoNo,
				grnheader.intYear AS PoYear,
				suppliers.strTitle AS SupplierName,
				grnheader.intGRNYear AS GrnYear,
				grnheader.dtmRecievedDate AS GrnDate,
				grnheader.strInvoiceNo AS invNo,
				useraccounts.name As UserName,
				purchaseorderheader.intDelToCompID as grnFactory
				
				FROM
				grnheader
				Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND purchaseorderheader.intYear = grnheader.intYear
				Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID 
				Inner Join useraccounts ON useraccounts.intUserID = grnheader.intUserId
				 WHERE
				 grnheader.intStatus = '$intStatus' ";
				
				if($grnFromNo!=0)
				{
					$SQL.=" AND grnheader.intGrnNo>=".(int)$grnFromNo;
				}
						
				if($grnToNo!="")
				{
					$SQL.=" AND grnheader.intGrnNo<=".(int)$grnToNo;
				}

				if($grnFromDate!="")
				{
					$SQL.=" AND grnheader.dtmRecievedDate>='$grnFromDate' ";
				}
				if($grnToDate!="")
				{
					$SQL.=" AND grnheader.dtmRecievedDate<='$grnToDate'";
				}
				
				if($invNo!="")
				{
					$SQL.=" AND grnheader.strInvoiceNo LIKE '%$invNo%' ";
				}
				
				if($intPoNo!="")
				{
					$SQL.=" AND grnheader.intPoNo=$intPoNo ";
				}
				if($intCompanyId!="")
				{
					$SQL.=" AND grnheader.intCompanyID=$intCompanyId ";
				}
				if($intUserId!="")
				{
					$SQL.=" AND grnheader.intUserId=$intUserId ";
				}
				
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<GrnNo><![CDATA[" . $row["GrnNo"]  . "]]></GrnNo>\n";
				 $ResponseXML .= "<PoNo><![CDATA[" . $row["PoNo"]  . "]]></PoNo>\n"; 
				 $ResponseXML .= "<PoYear><![CDATA[" . $row["PoYear"]  . "]]></PoYear>\n"; 
				 $ResponseXML .= "<SupplierName><![CDATA[" . $row["SupplierName"]  . "]]></SupplierName>\n";
				 $ResponseXML .= "<GrnYear><![CDATA[" . $row["GrnYear"]  . "]]></GrnYear>\n";
				 $ResponseXML .= "<GrnDate><![CDATA[" . substr($row["GrnDate"],0,10)  . "]]></GrnDate>\n";
				 $ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n"; 
				 $ResponseXML .= "<UserName><![CDATA[" . $row["UserName"]  . "]]></UserName>\n";  
				 $ResponseXML .= "<InvNo><![CDATA[" . $row["invNo"]  . "]]></InvNo>\n";
				 $ResponseXML .= "<grnFactory><![CDATA[" . $row["grnFactory"]  . "]]></grnFactory>\n";  
			}
			$ResponseXML .= "</GRNList>";
			echo $ResponseXML;
}
?>