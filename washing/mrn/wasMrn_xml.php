<?php
session_start();
require_once('../../Connector.php');
include('../washingCommonScript.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$request=$_GET['req'];
$wScripts=new wasCommonScripts();
if($request=="loadColor"){
	$orderNo=$_GET['orderNo'];
	$sql="SELECT DISTINCT
		productionbundleheader.strColor
		FROM
		orders
		INNER JOIN productionbundleheader ON productionbundleheader.intStyleId = orders.intStyleId
		WHERE
		orders.intStyleId = '$orderNo'
		order by strColor;";
		//echo $sql;
	$res=$db->RunQuery($sql);
	$ResponseXml.="<SetColor>";
	while($row=mysql_fetch_array($res)){
		$ResponseXml.="<Color><![CDATA[" . trim($row['strColor'])  . "]]></Color>";
	}
	$ResponseXml.="</SetColor>";
	echo $ResponseXml;
}
if($request=="loadQty"){
	$po		=	$_GET['orderNo'];
	$color	=	$_GET['color'];
	$company=	$_SESSION['FactoryID'];
	$fFac	=	$_GET['fFac'];
	$ResponseXml.="<loadQty>";
	/*$RCVDQty	= 	getRCVDQty($po,$color,$company);
	$AVGQty 	=	getAvlQty($po,$color,$company);*/
	
	$RCVDQty	= 	$wScripts->gpQtyForMrn($po,$color,$company);
	$AVGQty 	=	getAvlQty($po,$color,$company);
	
	$ResponseXml.="<RCVDQty><![CDATA[" .$RCVDQty. "]]></RCVDQty>";
	$ResponseXml.="<ORDERQty><![CDATA[" . getOrderQty($po). "]]></ORDERQty>";
	$ResponseXml.="<IQty><![CDATA[" .($RCVDQty)."]]></IQty>";//-$AVGQty
	
	$ResponseXml.="</loadQty>";
	echo $ResponseXml;
}

if($request=='loadPo'){
	$style=$_GET['style'];
	$sql="SELECT o.intStyleId FROM orders o WHERE o.strStyle='$style';";
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
	$sql="SELECT o.strStyle FROM orders o  WHERE o.intStyleId='$po';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	
	$ResponseXml.="<Det>";
	$ResponseXml.="<StyleNo><![CDATA[" . trim($row['strStyle'])  . "]]></StyleNo>";
	$ResponseXml.="</Det>";
	echo $ResponseXml;
}

function getOrderQty($po){
global $db;
	$sql = " select intQty from orders where intStyleId='$po' ";
	$res=$db->RunQuery($sql);		
	$row=mysql_fetch_array($res);
	return $row['intQty'];
}



function getRCVDQty($po,$color,$company){
	global $db; // and strType in ('FTransIn') 
	$sql="select sum(dblQty) as RCVDQty from was_stocktransactions where intStyleId='$po' and strColor='$color' and intCompanyId='$company' group by intStyleId,strColor;";/* and strType='FTransIn'*/
	//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['RCVDQty'];
}

function getAvlQty($po,$color,$company){
	global $db;
	$sql="select COALESCE(sum(dblQty),0) as IQty  from was_mrn where intStyleId='$po' and strColor='$color' group by intStyleId,strColor";
	//echo $sql;
	$res=$db->RunQuery($sql);	
		
	$row=mysql_fetch_array($res);
		return $row['IQty'];
}


?>