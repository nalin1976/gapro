<?php
session_start();
include_once('../../Connector.php');

$req=$_GET['req'];

if(strcmp($req,"loadStyle")==0){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$po=$_GET['po'];
	$sql="SELECT DISTINCT orders.strStyle,was_stocktransactions.intFromFactory,orders.intQty FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE  was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."'   AND was_stocktransactions.intStyleId='$po'  ORDER BY orders.strOrderNo ASC;";
	
			$res=$db->RunQuery($sql);
			$ResponseXML="<DET>";
			while($row=mysql_fetch_array($res)){
				$ResponseXML.="<style><![CDATA[".$row['strStyle']."]]></style>";
				$ResponseXML.="<FromFactory><![CDATA[".$row['intFromFactory']."]]></FromFactory>";	
				$ResponseXML.="<OQty><![CDATA[".$row['intQty']."]]></OQty>";			
			}
			$ResponseXML.="</DET>";
			echo $ResponseXML;
}
if(strcmp($req,"loadPo")==0){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];
	$sql="SELECT DISTINCT orders.intStyleId,was_stocktransactions.intFromFactory,orders.intQty  FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."'   AND orders.strStyle='$style'  ORDER BY orders.strOrderNo ASC;";
	
			$res=$db->RunQuery($sql);
			$ResponseXML="<DET>";
			while($row=mysql_fetch_array($res)){
				$ResponseXML.="<po><![CDATA[".$row['intStyleId']."]]></po>";
				$ResponseXML.="<FromFactory><![CDATA[".$row['intFromFactory']."]]></FromFactory>";
				$ResponseXML.="<OQty><![CDATA[".$row['intQty']."]]></OQty>";
			}
			$ResponseXML.="</DET>";
			echo $ResponseXML;
}

if(strcmp($req,"loadColor")==0){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$po=$_GET['po'];
	$sql="SELECT DISTINCT was_stocktransactions.strColor  FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."'   AND orders.intStyleId='$po'  ORDER BY orders.strOrderNo ASC;";
	
			$res=$db->RunQuery($sql);
			$ResponseXML="<DET>";
			while($row=mysql_fetch_array($res)){
				$ResponseXML.="<color><![CDATA[<option value=\"".$row['strColor']."\">".$row['strColor']."</option>]]></color>";
			}
			
	 $sqlM="SELECT DISTINCT
			concat(was_mrn.intMrnYear,'/',was_mrn.dblMrnNo) AS MRN,
			COALESCE(Sum(was_labtestinggp.dblQty),0) AS QTY,
			was_mrn.dblQty AS MrnQty
			FROM
			was_mrn
			left JOIN was_labtestinggp ON was_mrn.dblMrnNo = was_labtestinggp.dblRequestNo AND was_mrn.intMrnYear = was_labtestinggp.intRequestYear
			where intStyleId='$po'
			HAVING
			MrnQty > QTY 
			ORDER BY
			concat(was_mrn.intMrnYear,was_mrn.dblMrnNo) ASC";

			$resM=$db->RunQuery($sqlM);
			while($rowM=mysql_fetch_array($resM)){
				$ResponseXML.="<MRN><![CDATA[<option value=\"\">Select One</option><option value=\"".$rowM['MRN']."\">".$rowM['MRN']."</option>]]></MRN>";
			}
			
			$ResponseXML.="</DET>";
			echo $ResponseXML;
}

if($req=="URLLoadMRNDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$mrnNo = $_GET["MrnNo"];
	$mrnNo 	= explode('/',$mrnNo);
	$ResponseXml = "<XMLLoadMRNDetails>";
		$sql="select dblQty from was_mrn where dblMrnNo='$mrnNo[1]' and intMrnYear='$mrnNo[0]'";
		
		$result=$db->RunQuery($sql);
			$row=mysql_fetch_array($result);
			$ResponseXml .= "<MRNQty><![CDATA[" .($row['dblQty']- gpQty($mrnNo)) . "]]></MRNQty>";
		
	$ResponseXml .= "</XMLLoadMRNDetails>";
	echo $ResponseXml;	
}

function gpQty($mrnNo){
	global $db;
	$sql="select sum(dblQty) as QTY from was_labtestinggp where intRequestYear='".$mrnNo[0]."' and dblRequestNo='".$mrnNo[1]."';";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row['QTY'];
	
}
?>