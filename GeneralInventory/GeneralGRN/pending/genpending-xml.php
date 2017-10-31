<?php 
session_start();
include "../../../Connector.php";

$id=$_GET["id"];

if($id=="loadGrn")
{
		$grnFromNo		= $_GET["grnFromNo"];
		$grnToNo		= $_GET["grnToNo"];
		$grnFromDate	= $_GET["grnFromDate"];
		$grnToDate		= $_GET["grnToDate"];
		$intStatus		= $_GET["intStatus"];
		$invNo 			= $_GET["invNo"];
		$intGenPoNo		= $_GET["PoNo"];
		$companyID = $_GET["company"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$limitText = " limit 0,50 ";
		$ResponseXML .= "<GRNList>";
		$SQL=  "SELECT DISTINCT
				gengrnheader.strGenGrnNo AS GrnNo,
				gengrnheader.intGenPoNo AS PoNo,
				gengrnheader.intGenPOYear AS PoYear,
				suppliers.strTitle AS SupplierName,
				gengrnheader.intYear AS GrnYear,
				gengrnheader.dtRecdDate AS GrnDate,
				gengrnheader.strInvoiceNo AS invNo
				FROM
				gengrnheader
				Inner Join generalpurchaseorderheader ON
				gengrnheader.intGenPoNo = generalpurchaseorderheader.intGenPoNo AND generalpurchaseorderheader.intYear=gengrnheader.intGenPOYear
				Inner Join suppliers 
				ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID 
				WHERE gengrnheader.intStatus = '$intStatus' ";
				
				if($grnFromNo!="")
				{
					$SQL.=" AND gengrnheader.strGenGrnNo>='$grnFromNo'";
				}
						
				if($grnToNo!="")
				{
					$SQL.=" AND gengrnheader.strGenGrnNo<='$grnToNo'";
				}

				if($grnFromDate!="")
				{
					$SQL.=" AND gengrnheader.dtRecdDate>='$grnFromDate' ";
				}
				if($grnToDate!="")
				{
					$SQL.=" AND gengrnheader.dtRecdDate<='$grnToDate'";
				}
				
				if($invNo!="")
				{
					$SQL.=" AND gengrnheader.strInvoiceNo LIKE '%$invNo%' ";
				}
				
				if($intGenPoNo!="")
				{
					$SQL.=" AND gengrnheader.intGenPoNo=$intGenPoNo ";
				}
				
				if($companyID!=0)
				{
					$SQL.=" AND gengrnheader.intCompId=$companyID ";
				}
				
				$SQL.=" order by dtRecdDate desc $limitText ";
			
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<GrnNo><![CDATA[" . $row["GrnNo"]  . "]]></GrnNo>\n";
				 $ResponseXML .= "<PoNo><![CDATA[" . $row["PoYear"] . "/" . $row["PoNo"]  . "]]></PoNo>\n"; 
				 $ResponseXML .= "<SupplierName><![CDATA[" . $row["SupplierName"]  . "]]></SupplierName>\n";
				 $ResponseXML .= "<GrnYear><![CDATA[" . $row["GrnYear"]  . "]]></GrnYear>\n";
				 $ResponseXML .= "<GrnDate><![CDATA[" . $row["GrnDate"]  . "]]></GrnDate>\n";
				 $ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";  
			}
			$ResponseXML .= "</GRNList>";
			echo $ResponseXML;
}
?>