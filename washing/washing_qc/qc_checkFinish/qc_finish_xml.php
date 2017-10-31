<?php
session_start();
include "../../../Connector.php";
$req=$_GET['req'];
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


if(strcmp($req,"getOpDet")==0){
	$opId=$_GET['opId'];
	$ResponseXML = "<XMLDet>";
	$sql="select was_operators.strShift,was_operators.strEpfNo from was_operators where intOperatorId='$opId';";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_assoc($res)){
		$ResponseXML.="<Shift><![CDATA[" . $row["strShift"]  . "]]></Shift>\n";
		$ResponseXML.="<EpfNo><![CDATA[" . $row["strEpfNo"]  . "]]></EpfNo>\n";
	}
	$ResponseXML .= "</XMLDet>";
	echo $ResponseXML;
}

if(strcmp($req,"getColorDet")==0){
	$poNo=$_GET['poNo'];
	$ResponseXML = "<XMLDet>";
	$sql="SELECT
			was_stocktransactions.strColor,
			was_stocktransactions.intFromFactory
			FROM
			was_stocktransactions
			INNER JOIN orders ON orders.intStyleId = was_stocktransactions.intStyleId
			WHERE
			was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."' AND was_stocktransactions.intStyleId='$poNo';";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_assoc($res)){
		$ResponseXML.="<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML.="<FromFactory><![CDATA[" . $row["intFromFactory"]  . "]]></FromFactory>\n";
	}
	$ResponseXML .= "</XMLDet>";
	echo $ResponseXML;
}
?>