<?php
session_start();
include("../../../Connector.php");
$backwardseperator = "../../../";
header('Content-Type: text/xml'); 	
$request=$_GET["request"];
	

if ($request=='load_OrderNo')
{
	$server = "192.168.1.28";
	$msDb = "WFX";
	$link = mssql_connect($server, 'sa', 'sqlserver2005',true);
	
	$msSelected = mssql_select_db($msDb,$link);
	$stmt = mssql_init("xspGetOCForArticleTMP0",$link); 
	
	
	$styleNo=$_GET['styleNo'];
	$type='SQLVARCHAR';
	
	mssql_bind($stmt, '@BuyerReference', $styleNo, SQLVARCHAR)
			or die("Unable to bind".mssql_get_last_message());
	
	$rez = mssql_execute($stmt) or die(mssql_get_last_message());
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml_string='<data>';
	while($row=mssql_fetch_array($rez))
	{
		$xml_string .= "<StyleNo><![CDATA[" . $row['BuyerReference']   . "]]></StyleNo>\n";
		$xml_string .= "<PoNo><![CDATA[" . $row['OrderRefNum']   . "]]></PoNo>\n";
	}
	$xml_string.='</data>';
	echo $xml_string;
}	

?>