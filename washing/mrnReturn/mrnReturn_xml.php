<?php
include "../../Connector.php";
include('../washingCommonScript.php');
$requestType= $_GET["RequestType"];
$comapany =	$_SESSION["FactoryID"];
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$wScripts=new wasCommonScripts();

if($requestType='loadDets'){
	$INo=$_GET['ino'];
	$INo=split('/',$INo);
	
	$sql="select o.intStyleId,o.strOrderNo,o.strStyle,wi.strColor,wi.intStore,wi.intDepartment,wi.intSFac,wi.dblQty  from was_issue wi 
inner join orders o on o.intStyleId=wi.intStyleId
where wi.intIssueYear='$INo[0]' and wi.intIssueNo='$INo[1]';";
//echo $sql;
	$res=$db->RunQuery($sql);
	$ResponseXml.="<loadDet>";
	while($row=mysql_fetch_array($res)){
		$ResponseXml.="<poNo><![CDATA[<option value=\"" . $row['intStyleId']. "\">". $row['strOrderNo']."</option>]]></poNo>\n";
		$ResponseXml.="<style><![CDATA[<option value=\"" . $row['strStyle']. "\">". $row['strStyle']."</option>]]></style>\n";
		$ResponseXml.="<color><![CDATA[<option value=\"" . $row['strColor']. "\">". $row['strColor']."</option>]]></color>\n";
		$ResponseXml.="<store><![CDATA[". $row['intStore']."]]></store>\n";
		$ResponseXml.="<Department><![CDATA[". $row['intDepartment']."]]></Department>\n";
		$ResponseXml.="<SFac><![CDATA[". $row['intSFac']."]]></SFac>\n";
		$ResponseXml.="<iQty><![CDATA[". $row['dblQty']."]]></iQty>\n";
		$ResponseXml.="<oQty><![CDATA[". $wScripts->getOrderQty($row['intStyleId'])."]]></oQty>\n";
		$ResponseXml.="<aQty><![CDATA[". ($row['dblQty']-getRtnQty($INo))."]]></aQty>\n"; 
	}	
	
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}

function getRtnQty($INo){
	global $db;
	$sql="select COALESCE(sum(r.dblQty),0) as Qty from was_mrnReturn r where r.intIYear='$INo[0]' and r.dblINo='$INo[1]';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['Qty'];
}
?>