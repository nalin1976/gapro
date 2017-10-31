<?php 
session_start();
include("../../../Connector.php");
$request=$_GET['request'];

if($request=="loadCDN")
{
	$invoiceNo = $_GET['invoiceNo'];
	$sql="SELECT
	cdn_header.intCDNNo
	FROM
	cdn_header
	WHERE strInvoiceNo='$invoiceNo'";
	
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	echo $row['intCDNNo'];
	
}
?>