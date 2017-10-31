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
	
	$sql="select m.intStyleId,m.strColor,m.dblBalQty,m.intStore,m.intDepartment,m.dblQty,m.strRemarks from was_mrn m where m.dblMrnNo='$mrnNo[1]' and m.intMrnYear='$mrnNo[0]';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	
	$ResponseXml.="<Det>";
	
	$ResponseXml.="<intStyleId><![CDATA[" . trim($row['intStyleId'])  . "]]></intStyleId>";
	$ResponseXml.="<strColor><![CDATA[" . trim($row['strColor'])  . "]]></strColor>";
	$ResponseXml.="<dblBalQty><![CDATA[" . trim($row['dblBalQty'])  . "]]></dblBalQty>";
	$ResponseXml.="<dblQty><![CDATA[" . trim($row['dblQty'])  . "]]></dblQty>";
	$ResponseXml.="<intStore><![CDATA[" . trim($row['intStore'])  . "]]></intStore>";
	$ResponseXml.="<intDepartment><![CDATA[" . trim($row['intDepartment'])  . "]]></intDepartment>";
	$ResponseXml.="<strRemarks><![CDATA[" . trim($row['strRemarks'])  . "]]></strRemarks>";
	
	$ResponseXml.="</Det>";
	echo $ResponseXml;
}
if($request=='loadPo'){
	$style=$_GET['style'];
	$sql="SELECT o.intStyleId FROM orders o INNER JOIN was_mrn ON was_mrn.intStyleId = o.intStyleId WHERE o.strStyle='$style';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	
	$ResponseXml.="<Det>";
	$ResponseXml.="<StyleId><![CDATA[" . trim($row['intStyleId'])  . "]]></StyleId>";
	$ResponseXml.="</Det>";
	echo $ResponseXml;
}
if($request=='loadStyle'){
	$po=$_GET['po'];
	$sql="SELECT o.strStyle FROM orders o INNER JOIN was_mrn ON was_mrn.intStyleId = o.intStyleId WHERE o.intStyleId='$po';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	
	$ResponseXml.="<Det>";
	$ResponseXml.="<StyleNo><![CDATA[" . trim($row['strStyle'])  . "]]></StyleNo>";
	$ResponseXml.="</Det>";
	echo $ResponseXml;
}

?>