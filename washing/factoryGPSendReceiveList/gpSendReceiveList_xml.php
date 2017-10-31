<?php
session_start();
include_once('../../Connector.php');

$req=$_GET['req'];

if(strcmp($req,"loadStyle")==0){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$po=$_GET['po'];
	$sql="SELECT DISTINCT orders.strStyle,was_stocktransactions.intFromFactory FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.strType IN ('FacRCvIn', 'FTransIn', 'FacOut', 'mrnIssue', 'IRtn') AND  was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."'   AND was_stocktransactions.intStyleId='$po'  ORDER BY orders.strOrderNo ASC;";
	
			$res=$db->RunQuery($sql);
			$ResponseXML="<DET>";
			while($row=mysql_fetch_array($res)){
				$ResponseXML.="<style><![CDATA[".$row['strStyle']."]]></style>";
				$ResponseXML.="<FromFactory><![CDATA[".$row['intFromFactory']."]]></FromFactory>";				
			}
			$ResponseXML.="</DET>";
			echo $ResponseXML;
}
if(strcmp($req,"loadPo")==0){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];
	$sql="SELECT DISTINCT orders.intStyleId,was_stocktransactions.intFromFactory  FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.strType IN ('FacRCvIn', 'FTransIn', 'FacOut', 'mrnIssue', 'IRtn') AND  was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."'   AND orders.strStyle='$style'  ORDER BY orders.strOrderNo ASC;";
	
			$res=$db->RunQuery($sql);
			$ResponseXML="<DET>";
			while($row=mysql_fetch_array($res)){
				$ResponseXML.="<po><![CDATA[".$row['intStyleId']."]]></po>";
				$ResponseXML.="<FromFactory><![CDATA[".$row['intFromFactory']."]]></FromFactory>";
			}
			$ResponseXML.="</DET>";
			echo $ResponseXML;
}

if(strcmp($req,"loadColor")==0){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$po=$_GET['po'];
	$sql="SELECT DISTINCT was_stocktransactions.strColor  FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.strType IN ('FacRCvIn', 'FTransIn', 'FacOut', 'mrnIssue', 'IRtn') AND  was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."'   AND orders.intStyleId='$po'  ORDER BY orders.strOrderNo ASC;";
	
			$res=$db->RunQuery($sql);
			$ResponseXML="<DET>";
			while($row=mysql_fetch_array($res)){
				$ResponseXML.="<color><![CDATA[<option value=\"".$row['strColor']."\">".$row['strColor']."</option>]]></color>";
			}
			$ResponseXML.="</DET>";
			echo $ResponseXML;
}
?>