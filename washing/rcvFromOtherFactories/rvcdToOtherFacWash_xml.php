<?php
session_start();
require_once('../../Connector.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$request=$_GET['req'];
#FTransIn +
#IWash +
#SubOut -
#SubIn +
#IFin 
#1 - MainStore
#2 - SubStore

$ResponseXml='';

if($request=="loadCompany")
{
	$serial=$_GET['serial'];
	$gp=split('/',$serial);
	$ResponseXml="<loadDet>";
	$sql_loadCom="SELECT companies.intCompanyID,companies.strName,fac.dblGPNo,orders.strOrderNo,orders.intStyleId,orders.strStyle,fac.intSFactory,
fac.strRemarks,fac.intReason
FROM was_issuedtootherfactory AS fac Inner Join companies ON fac.intCompanyId = companies.intCompanyID Inner Join orders ON fac.intStyleId = orders.intStyleId WHERE fac.dblGPNo =  '".$gp[1]."' AND fac.intYear =  '".$gp[0]."';";
	//echo $sql_loadCom;
	$resS=$db->RunQuery($sql_loadCom);
	
	while($row=mysql_fetch_array($resS)){
		$ResponseXml.="<CompanyId><![CDATA[".$row['intCompanyID']."]]></CompanyId>";
		$ResponseXml.="<SId><![CDATA[".$row['intSFactory']."]]></SId>";
		$ResponseXml.="<PONo><![CDATA[" .$row['strOrderNo']. "]]></PONo>";
		$ResponseXml.="<StyleId><![CDATA[" .$row['intStyleId']. "]]></StyleId>";
		$ResponseXml.="<Style><![CDATA[" .$row['strStyle']. "]]></Style>";
		$ResponseXml.="<Remarks><![CDATA[" .$row['strRemarks']. "]]></Remarks>";
		$ResponseXml.="<Reason><![CDATA[" .$row['intReason']. "]]></Reason>";
		
	}
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}

if($request=="loadColor"){
	$orderNo=$_GET['orderNo'];
	$sql="select distinct strColor from was_stocktransactions where intStyleId='$orderNo' order by strColor;";
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
	$serial	=   $_GET['serial'];
	$factory=	$_GET['factory'];
	$gp		=	split('/',$serial);
	$company=	$_SESSION['FactoryID'];
	$ResponseXml.="<loadQty>";
	$RCVDQty	= 	getRCVDQty($po,$color,$factory,$gp[1],$gp[0]);
	$AVGQty 	=	getAvlQty($po,$color,$company,$gp[1],$gp[0]);
	//$subBal		=    getSubBal($po,$color);
	
	$ResponseXml.="<RCVDQty><![CDATA[" .$RCVDQty. "]]></RCVDQty>";
	$ResponseXml.="<ORDERQty><![CDATA[" . getOrderQty($po). "]]></ORDERQty>";
	$ResponseXml.="<IQty><![CDATA[" . (($RCVDQty-$AVGQty) + $subBal). "]]></IQty>";
	//$ResponseXml.="<IssuedQty><![CDATA[" . getAvlQty($po,$color). "]]></IssuedQty>";
	
	$ResponseXml.="</loadQty>";
	echo $ResponseXml;
}

if($request=="loadRPOs"){
	$facId=$_GET['comId'];
	$sql="SELECT orders.strOrderNo,orders.intStyleId,orders.strStyle FROM was_issuedtootherfactory Inner Join orders ON was_issuedtootherfactory.intStyleId = orders.intStyleId WHERE was_issuedtootherfactory.intToFactory ='$facId';";
	
	$res=$db->RunQuery($sql);
	$ResponseXml.="<PoList>";
    while($row=mysql_fetch_array($res)){
		$ResponseXml.="<styleId><![CDATA[" .$row['intStyleId']. "]]></styleId>";
		$ResponseXml.="<orderNo><![CDATA[" .$row['strOrderNo']. "]]></orderNo>";
		$ResponseXml.="<StyleNo><![CDATA[" .$row['strStyle']. "]]></StyleNo>";
	}
	$ResponseXml.="</PoList>";
	echo $ResponseXml;
}

if($request=='rcvColors'){
	$facId=$_GET['comId'];
	$styleId=$_GET['poNo'];
	$sql="SELECT distinct was_issuedtootherfactory.strColor FROM was_issuedtootherfactory WHERE was_issuedtootherfactory.intToFactory =  '$facId' AND was_issuedtootherfactory.intStyleId =  '$styleId';";
	$res=$db->RunQuery($sql);
	$ResponseXml.="<RCVColor>";
    while($row=mysql_fetch_array($res)){
		$ResponseXml.="<Color><![CDATA[" .$row['strColor']. "]]></Color>";

	}
	$ResponseXml.="</RCVColor>";
	echo $ResponseXml;
}

if($request=="rcvQtys"){
	$facId=$_GET['comId'];
	$styleId=$_GET['poNo'];
	$color=$_GET['color'];
	
	$ResponseXml.="<RCVQty>";
		$ResponseXml.="<orderQty><![CDATA[" .getOrderQty($styleId). "]]></orderQty>";
		$ResponseXml.="<RcvdQty><![CDATA[" .getTotQty($facId,$styleId,$color). "]]></RcvdQty>";

	$ResponseXml.="</RCVQty>";
	echo $ResponseXml;
}
function loadOrderNolist($comID)
{
	global $db;
	$sql = " SELECT DISTINCT O.intStyleId,O.strOrderNo FROM orders AS O Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = O.intStyleId WHERE was_stocktransactions.intCompanyId ='$comID' order by O.strStyle;";
	
	return $db->RunQuery($sql);		
}

function getRCVDQty($po,$color,$factory,$gp,$year){
	global $db;
	/*
	Comment - Factory id remove because there is no cancel button. To cancel please transfer in to same location
	$sql="select sum(w.dblQty) as RcvdQty  from was_issuedtootherfactory w where w.intToFactory='$factory' and w.dblGPNo='$gp' and w.intYear='$year' and w.strColor='$color' and w.intStyleId='$po' group by w.intStyleId,w.strColor;";*/
	$sql="select sum(w.dblQty) as RcvdQty  from was_issuedtootherfactory w where w.dblGPNo='$gp' and w.intYear='$year' and w.strColor='$color' and w.intStyleId='$po' group by w.intStyleId,w.strColor;";
//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['RcvdQty'];
}

function getOrderQty($po){
global $db;
	$sql = " select intQty from orders where intStyleId='$po' ";
	$res=$db->RunQuery($sql);		
	$row=mysql_fetch_array($res);
	return $row['intQty'];
}

function getAvlQty($po,$color,$company,$gpNo,$gpYear){
	global $db;
	/*
	Comment - Factory id remove because there is no cancel button. To cancel please transfer in to same location
	$sql="select COALESCE(sum(dblQty),0) as IQty  from was_rcvdfromfactory where intStyleId='$po' and strColor='$color' and intCompanyId='$company' and dblGPNo='$gpNo' and intGPYear='$gpYear'*/
	
	$sql="select COALESCE(sum(dblQty),0) as IQty  from was_rcvdfromfactory where intStyleId='$po' and strColor='$color' and dblGPNo='$gpNo' and intGPYear='$gpYear'
group by intStyleId,strColor;";
	//echo $sql;
	$res=$db->RunQuery($sql);	
		
	$row=mysql_fetch_array($res);
		return $row['IQty'];
}

function getTotQty($fac,$po,$color){
	global $db;
	$sql="SELECT Sum(was_issuedtootherfactory.dblQty) AS totRcved
FROM was_issuedtootherfactory WHERE was_issuedtootherfactory.intToFactory = '$fac' AND was_issuedtootherfactory.intStyleId =  '$po' and was_issuedtootherfactory.strColor='$color' GROUP BY 
was_issuedtootherfactory.strColor,was_issuedtootherfactory.intStyleId,was_issuedtootherfactory.intToFactory;";
$res=$db->RunQuery($sql);	
		
	$row=mysql_fetch_array($res);
		return $row['totRcved'];
}
?>