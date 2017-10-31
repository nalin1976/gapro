<?php
session_start();
require_once('../../Connector.php');
include('../washingCommonScript.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$request=$_GET['req'];
$factory=$_SESSION['FactoryID'];
#FTransIn +
#IWash +
#SubOut -
#SubIn +
#IFin 
#1 - MainStore
#2 - SubStore

$ResponseXml='';
$wScripts=new wasCommonScripts();

if($request=="loadStyle")
{
	$comId=$_GET['comId'];
	$sql_loadStyle="SELECT DISTINCT O.strStyle,O.intStyleId FROM orders AS O Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = O.intStyleId WHERE was_stocktransactions.intCompanyId ='$comId' order by O.strStyle;";
	//echo $sql_loadStyle;
	$resS=$db->RunQuery($sql_loadStyle);
	$ResponseXml="<loadDet>";
	$strStyle = "<option value=\"". "" ."\">"."Select One"."</option>\n";
	while($rowS=mysql_fetch_array($resS))
	{
		$strStyle .= "<option value=\"". $rowS["intStyleId"] ."\">".$rowS["strStyle"]."</option>\n";	
	}
	
	$resOrder = loadOrderNolist($comId);
	$strOrder = "<option value=\"". "" ."\">"."Select One"."</option>\n";
	while($rowO=mysql_fetch_array($resOrder))
	{
		$strOrder .= "<option value=\"". $rowO["intStyleId"] ."\">".$rowO["strOrderNo"]."</option>\n";	
	}
	
	$ResponseXml.="<styleNo><![CDATA[" . trim($strStyle)  . "]]></styleNo>";
	$ResponseXml.="<OrderNo><![CDATA[" . trim($strOrder)  . "]]></OrderNo>";
	
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
	$company=	$_SESSION['FactoryID'];
	$sFac	=	$_GET['sFac'];
	$ResponseXml.="<loadQty>";
			
	/*$RCVDQty	= 	getRCVDQty($po,$color,$company);*/
	// +
	$AVGQty 	=	($wScripts->getSubContractorBalance($po,$color,$sFac)+$wScripts->getMrnIssueQty($po,$color,$sFac)+$wScripts->getIssuedToWashQty($po,$color,$sFac)+ $wScripts->getReturnToFactoryQty($po,$color,$sFac)+$wScripts->getIssuedToOtherBalance($po,$color,$factory,$sFac));
	//$subBal		=    getSubBal($po,$color);
	$sqlF="SELECT DISTINCT companies.intCompanyID,CONCAT(companies.strName,'-',companies.strCity) as com FROM was_stocktransactions AS s 
INNER JOIN companies ON s.intFromFactory = companies.intCompanyID WHERE s.intStyleId='$po';";
//echo $sqlF;
$fCom='';
	$resF=$db->RunQuery($sqlF);
	$Nr=mysql_num_rows($resF);
		if($Nr!=1){
			$cName .= "<option value=\"\"></option>\n";
		}
		while($rowS=mysql_fetch_array($resF))
		{
			$cName .= "<option value=\"".  trim($rowS['intCompanyID']) ."\">".trim($rowS['com'])."</option>\n";
			$fCom=$rowS['intCompanyID'];
		}
		$isWash=$wScripts->getIssuedToWashQty($po,$color,$factory,$fCom);
		$gpFFg=$wScripts->GetAvailableQtyForGP($po,$color,$factory,$fCom);
		
	$ResponseXml.="<RCVDQty><![CDATA[" .$RCVDQty. "]]></RCVDQty>";
	$ResponseXml.="<ORDERQty><![CDATA[" . $wScripts->getOrderQty($po). "]]></ORDERQty>\n";
	$ResponseXml.="<IQty><![CDATA[" . ($gpFFg-$isWash) . "]]></IQty>";
	$ResponseXml.="<GPQty><![CDATA[" . $wScripts->gpQty($po,$color,$factory,$fCom) . "]]></GPQty>";
	$ResponseXml.="<cName><![CDATA[" . trim($cName)  . "]]></cName>\n";
	$ResponseXml.="<Nr><![CDATA[" . trim($Nr)  . "]]></Nr>";
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

if(strcmp($request,"loadDets")==0){
	$gp=$_GET['gp'];
	$sql="SELECT
was_issuedtootherfactory.strRemarks,was_issuedtootherfactory.intStyleId,was_issuedtootherfactory.intStatus, was_issuedtootherfactory.intReason,was_issuedtootherfactory.intDamages, 
was_issuedtootherfactory.intToFactory,was_issuedtootherfactory.dblQty,was_issuedtootherfactory.strVehicleNo FROM was_issuedtootherfactory WHERE concat(was_issuedtootherfactory.intYear,'/',was_issuedtootherfactory.dblGPNo) = '$gp';";
	$res=$db->RunQuery($sql);
	$ResponseXml.="<DET>";
	$row=mysql_fetch_assoc($res);
		$ResponseXml.="<po><![CDATA[" .$row['intStyleId']. "]]></po>";
		$ResponseXml.="<vNo><![CDATA[" .$row['strVehicleNo']. "]]></vNo>";
		$ResponseXml.="<gpQty><![CDATA[" .$row['dblQty']. "]]></gpQty>";
		$ResponseXml.="<ToFac><![CDATA[" .$row['intToFactory']. "]]></ToFac>";
		$ResponseXml.="<Reason><![CDATA[" .$row['intReason']. "]]></Reason>";
		$ResponseXml.="<Remarks><![CDATA[" .$row['strRemarks']. "]]></Remarks>";
		$ResponseXml.="<Status><![CDATA[" .$row['intStatus']. "]]></Status>";
		$ResponseXml.="<Damages><![CDATA[" .$row['intDamages']. "]]></Damages>";
		

	$ResponseXml.="</DET>";
	echo $ResponseXml;
}

if($request=="URLLoadQtyWhenChangeSewFactory")
{
$po			  =	$_GET['orderNo'];
$color		  =	$_GET['color'];
$company	  =	$_SESSION['FactoryID'];
$sFac		  =	$_GET['sFac'];
$ResponseXml .= "<loadQty>";
$fCom			= $sFac;
	$AVGQty 	=	($wScripts->getSubContractorBalance($po,$color,$sFac)+$wScripts->getMrnIssueQty($po,$color,$sFac)+$wScripts->getIssuedToWashQty($po,$color,$sFac)+ $wScripts->getReturnToFactoryQty($po,$color,$sFac)+$wScripts->getIssuedToOtherBalance($po,$color,$factory,$sFac));

/*	$sqlF = "SELECT DISTINCT companies.intCompanyID,CONCAT(companies.strName,'-',companies.strCity) as com FROM was_stocktransactions AS s 
INNER JOIN companies ON s.intFromFactory = companies.intCompanyID WHERE s.intStyleId='$po';";*/

//$fCom='';
	//$resF=$db->RunQuery($sqlF);
	//$Nr=mysql_num_rows($resF);
		//if($Nr!=1){
		//	$cName .= "<option value=\"\"></option>\n";
		//}
		//while($rowS=mysql_fetch_array($resF))
		//{
		//	$cName .= "<option value=\"".  trim($rowS['intCompanyID']) ."\">".trim($rowS['com'])."</option>\n";
		//	$fCom=$rowS['intCompanyID'];
		//}
		$isWash=$wScripts->getIssuedToWashQty($po,$color,$factory,$fCom);
		$gpFFg=$wScripts->GetAvailableQtyForGP($po,$color,$factory,$fCom);
		
	$ResponseXml .= "<RCVDQty><![CDATA[" .$RCVDQty. "]]></RCVDQty>";
	$ResponseXml .= "<ORDERQty><![CDATA[" . $wScripts->getOrderQty($po). "]]></ORDERQty>\n";
	$ResponseXml .= "<IQty><![CDATA[" . ($gpFFg-$isWash) . "]]></IQty>";
	$ResponseXml .= "<GPQty><![CDATA[" . $wScripts->gpQty($po,$color,$factory,$fCom) . "]]></GPQty>";
	//$ResponseXml .= "<cName><![CDATA[" . trim($cName)  . "]]></cName>\n";
	//$ResponseXml .= "<Nr><![CDATA[" . trim($Nr)  . "]]></Nr>";
	$ResponseXml .= "</loadQty>";
	echo $ResponseXml;
}

function loadOrderNolist($comID)
{
	global $db;
	$sql = " SELECT DISTINCT O.intStyleId,O.strOrderNo FROM orders AS O Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = O.intStyleId WHERE was_stocktransactions.intCompanyId ='$comID' order by O.strStyle;";
	
	return $db->RunQuery($sql);		
}

function getRCVDQty($po,$color,$company){
	global $db;
	$sql="select sum(dblQty) as RCVDQty from was_stocktransactions where intStyleId='$po' and strColor='$color'  and strType in ('FTransIn','FacRCvIn','SubOut','IWash','SubIn') and intCompanyId='$company' group by intStyleId,strColor;";/* and strType='FTransIn'*/
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['RCVDQty'];
}

function getOrderQty($po){
global $db;
	$sql = " select intQty from orders where intStyleId='$po' ";
	$res=$db->RunQuery($sql);		
	$row=mysql_fetch_array($res);
	return $row['intQty'];
}

function getAvlQty($po,$color,$company){
	global $db;
	$sql="select COALESCE(sum(dblQty),0) as IQty  from was_issuedtootherfactory where intStyleId='$po' and strColor='$color' and intCompanyId='$company' group by intStyleId,strColor";
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


function getSubBal($po,$color){
	global $db;
$sqlS="SELECT
Sum(was_stocktransactions.dblQty) as SQty FROM was_stocktransactions WHERE was_stocktransactions.strType IN ('SubOut', 'SubIn','FacOut','FacRCvIn') AND was_stocktransactions.intStyleId = '$po' AND was_stocktransactions.strColor = '$color' GROUP BY was_stocktransactions.intStyleId,was_stocktransactions.strColor;";
//echo $sqlS; 
$resS=$db->RunQuery($sqlS);
$row=mysql_fetch_array($resS);
	return $row['SQty'];
}


?>