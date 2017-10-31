<?php
session_start();
require_once('../../Connector.php');
include('../washingCommonScript.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$request=$_GET['req'];
$mrnNo=$_GET['mrn'];
$mrnNo=split('/',$mrnNo);

if($request=="loadDets"){
	
	$sql="select m.intStyleId,m.strColor,m.dblBalQty,m.intStore,m.intDepartment,m.dblQty from was_mrn m where m.dblMrnNo='$mrnNo[1]' and m.intMrnYear='$mrnNo[0]';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	
	$ResponseXml.="<Det>";
	
	$ResponseXml.="<intStyleId><![CDATA[" . trim($row['intStyleId'])  . "]]></intStyleId>";
	$ResponseXml.="<strColor><![CDATA[" . trim($row['strColor'])  . "]]></strColor>";
	$ResponseXml.="<dblBalQty><![CDATA[" . trim($row['dblBalQty'])  . "]]></dblBalQty>";
	$ResponseXml.="<dblQty><![CDATA[" . trim($row['dblQty'])  . "]]></dblQty>";
	$ResponseXml.="<intStore><![CDATA[" . trim($row['intStore'])  . "]]></intStore>";
	$ResponseXml.="<intDepartment><![CDATA[" . trim($row['intDepartment'])  . "]]></intDepartment>";
	
	$ResponseXml.="</Det>";
	echo $ResponseXml;
}
?>