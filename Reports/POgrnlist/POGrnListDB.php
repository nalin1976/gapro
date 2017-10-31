<?php
session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 
$Opperation=$_GET["Opperation"];

if($Opperation=="URLLoadDetailsWhenChangePoNo")
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadDetailsWhenChangePoNo>";
$poNo	= $_GET["PoNo"];
	$ResponseXML .= "<StyleNo><![CDATA[" . GetStyleNo($poNo)  . "]]></StyleNo>\n";
	$ResponseXML .= "<OrderNo><![CDATA[" . GetOrderNo($poNo)  . "]]></OrderNo>\n";
	$ResponseXML .= "<GRNNo><![CDATA[" . GetGrnNo($poNo)  . "]]></GRNNo>\n";
	$ResponseXML .= "<InvoNo><![CDATA[" . GetInvoNo($poNo)  . "]]></InvoNo>\n";
	$ResponseXML .= "<Supplier><![CDATA[" . GetSupplierId($poNo)  . "]]></Supplier>\n";
$ResponseXML .= "</XMLLoadDetailsWhenChangePoNo>";
echo $ResponseXML;
}
if($Opperation=="URLLoadSuppliers")
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadSuppliers>";
$invoiceNo	= $_GET["invoiceNo"];
	$ResponseXML .= "<Supplier><![CDATA[" . getSuppliers($invoiceNo)  . "]]></Supplier>\n";
$ResponseXML .= "</XMLLoadSuppliers>";
echo $ResponseXML;
}
function getSuppliers($invoiceNo)
{
	global $db;
	$sql = "select distinct S.strSupplierID,S.strTitle  
			from grnheader GH 
			Inner Join purchaseorderheader POH ON GH.intPoNo = POH.intPONo 
			AND GH.intYear =  POH.intYear 
			Inner Join suppliers S ON POH.strSupplierID = S.strSupplierID
			where GH.intStatus <>'a' ";
	if($invoiceNo!="")
	$sql .= "and GH.strInvoiceNo='$invoiceNo' ";
	
	$sql .= "order by S.strTitle";
	$result=$db->RunQuery($sql);
		$string .= "<option value=\"". "" ."\">" . "Select One" ."</option>";
	while($row=mysql_fetch_array($result))
	{
		$string .= "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>";
	}
	return $string;
}

function GetStyleNo($poNo)
{
global $db;
$poNoArray 	= explode('/',$poNo);
$sql="select distinct O.strStyle from grnheader GH 
inner join grndetails GD on GD.intGrnNo=GH.intGrnNo and GH.intGRNYear=GH.intGRNYear
inner join orders O on O.intStyleId=GD.intStyleId
where GH.intStatus <> 'a' ";

if($poNo!="")
	$sql .= "and GH.intYear='$poNoArray[0]' and GH.intPoNo='$poNoArray[1]'";
	
	$sql .= "order by O.strStyle";
	
	$result=$db->RunQuery($sql);
		$string .= "<option value=\"". "" ."\">" . "Select One" ."</option>";
	while($row=mysql_fetch_array($result))
	{
		$string .= "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>";
	}
	return $string;
}

function GetOrderNo($poNo)
{
global $db;
$poNoArray 	= explode('/',$poNo);
$sql="select distinct O.intStyleId,O.strOrderNo from grnheader GH 
inner join grndetails GD on GD.intGrnNo=GH.intGrnNo and GH.intGRNYear=GH.intGRNYear
inner join orders O on O.intStyleId=GD.intStyleId
where GH.intStatus <> 'a' ";

if($poNo!="")
	$sql .= "and GH.intYear='$poNoArray[0]' and GH.intPoNo='$poNoArray[1]'";
	
	$sql .= "order by O.strOrderNo";
	
	$result=$db->RunQuery($sql);
		$string .= "<option value=\"". "" ."\">" . "Select One" ."</option>";
	while($row=mysql_fetch_array($result))
	{
		$string .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
	}
	return $string;
}

function GetGrnNo($poNo)
{
global $db;
$poNoArray 	= explode('/',$poNo);
	$sql="select concat(GH.intGRNYear,'/',GH.intGrnNo)as grnNo from grnheader GH where GH.intStatus <>'a' ";

if($poNo!="")
	$sql .= "and GH.intYear='$poNoArray[0]' and GH.intPoNo='$poNoArray[1]' ";
	
	$sql .= "order by intGRNYear,intGrnNo DESC";
	$result=$db->RunQuery($sql);
		$string .= "<option value=\"". "" ."\">" . "Select One" ."</option>";
	while($row=mysql_fetch_array($result))
	{
		$string .= "<option value=\"". $row["grnNo"] ."\">" . $row["grnNo"] ."</option>";
	}
	return $string;
}

function GetInvoNo($poNo)
{
global $db;
$poNoArray 	= explode('/',$poNo);
	$sql="select distinct GH.strInvoiceNo from grnheader GH where GH.intStatus <>'a' ";

if($poNo!="")
	$sql .= "and GH.intYear='$poNoArray[0]' and GH.intPoNo='$poNoArray[1]' ";
	
	$sql .= "order by GH.strInvoiceNo";
	$result=$db->RunQuery($sql);
		$string .= "<option value=\"". "" ."\">" . "Select One" ."</option>";
	while($row=mysql_fetch_array($result))
	{
		$string .= "<option value=\"". $row["strInvoiceNo"] ."\">" . $row["strInvoiceNo"] ."</option>";
	}
	return $string;
}
function GetSupplierId($poNo)
{
	global $db;
$poNoArray 	= explode('/',$poNo);
	$sql="select distinct S.strSupplierID,S.strTitle  
			from grnheader GH 
			Inner Join purchaseorderheader POH ON GH.intPoNo = POH.intPONo 
			AND GH.intYear =  POH.intYear 
			Inner Join suppliers S ON POH.strSupplierID = S.strSupplierID
			where GH.intStatus <>'a' ";

if($poNo!="")
	$sql .= "and GH.intYear='$poNoArray[0]' and GH.intPoNo='$poNoArray[1]' ";
	
	$sql .= "order by S.strTitle";
	$result=$db->RunQuery($sql);
		$string .= "<option value=\"". "" ."\">" . "Select One" ."</option>";
	while($row=mysql_fetch_array($result))
	{
		$string .= "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>";
	}
	return $string;

}
?>