<?php
include "../../Connector.php";
include('../washingCommonScript.php');
$requestType= $_GET["RequestType"];
$comapany =	$_SESSION["FactoryID"];
$wScripts=new wasCommonScripts();

if($requestType=="LoadOrderNo")
{
$styleNo  = $_GET["StyleNo"];
$tabIndex = $_GET["TabIndex"];

if($tabIndex=='0')
{
	$sql = "select distinct O.intStyleId,O.strOrderNo from was_stocktransactions WS inner join orders O on O.intStyleId=WS.intStyleId ";	
	if($styleNo!="")
 		$sql .= "where O.strStyle='$styleNo' ";	 
	 $sql .= "group by WS.intStyleId having sum(WS.dblQty) > 0 order by O.strOrderNo";
}
elseif($tabIndex=='1')
{
/*	$sql = "select distinct O.intStyleId,O.strOrderNo from was_stocktransactions WS inner join orders O on O.intStyleId=WS.intStyleId where (COALESCE((select sum(dblQty) from was_stocktransactions WS where strType='SubOut' group by WS.intStyleId,WS.strColor),0) + COALESCE((select sum(dblQty) from was_stocktransactions WS where strType='SubIn' group by WS.intStyleId,WS.strColor),0)) < 0 and WS.strType in('SubOut','SubIn') ";*/

$sql="select distinct O.intStyleId,O.strOrderNo
from was_stocktransactions WS 
inner join orders O on O.intStyleId=WS.intStyleId where O.intStyleId <>0 ";	
	if($styleNo!="")
 		$sql .= "and O.strStyle='$styleNo' ";	 
	 $sql .= "order by O.strStyle";
}
	 	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
}
elseif($requestType=="LoadColor")
{
$orderId 	= $_GET["OrderId"];
$tabIndex	= $_GET["TabIndex"];
if($tabIndex=='0')
{
	$sql = "select distinct WS.strColor from was_stocktransactions WS where strMainStoresID=1 and WS.intStyleId='$orderId' group by WS.intStyleId having sum(WS.dblQty) > 0 order by WS.strColor";
}
elseif($tabIndex=='1')
{
/*	$sql = "select distinct WS.strColor from was_stocktransactions WS where (COALESCE((select sum(dblQty) from was_stocktransactions WS where strType='SubOut' group by WS.intStyleId,WS.strColor),0) + COALESCE((select sum(dblQty) from was_stocktransactions WS where strType='SubIn' group by WS.intStyleId,WS.strColor),0)) < 0 and WS.strType in('SubOut','SubIn') and WS.intStyleId=$orderId order by WS.strColor";*/
		$sql = "select distinct WS.strColor from was_stocktransactions WS where strMainStoresID=1 and WS.intStyleId='$orderId' group by WS.intStyleId order by WS.strColor";
}
	$result=$db->RunQuery($sql);
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
	}
}
elseif($requestType=="LoadDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
$orderId 	= $_GET["OrderId"];
$color 		= $_GET["Color"];
$fFC 		= $_GET["fFC"];
$ResponseXML = "<XMLLoadDetails>"; 
	$AVGQty 	=	$wScripts->gpQtyForIssued($orderId,$color,$comapany,$fFC)-($wScripts->getSubContractorBalance($orderId,$color,$fFC)+$wScripts->getMrnIssueQty($orderId,$color)+$wScripts->getIssuedToWashQty($orderId,$color)+ $wScripts->getReturnToFactoryQty($orderId,$color)+$wScripts->getIssuedToOtherBalance($orderId,$color,$comapany));
		//$ResponseXML .= "<TotReceiveQty><![CDATA[" . GetTotReceiveQty($orderId,$color,$comapany) . "]]></TotReceiveQty>\n";
		$ResponseXML .= "<TotReceiveQty><![CDATA[" .$wScripts->GetAvailableQty($orderId,$color,$comapany,$fFC) . "]]></TotReceiveQty>\n";
		$ResponseXML .= "<TotSendToOut><![CDATA[" . GetTotSendToOutQty($orderId,$color,$fFC) . "]]></TotSendToOut>\n";
		$ResponseXML .= "<TotReFrOut><![CDATA[" . GetTotReceiveFromOutQty($orderId,$color,$fFC) . "]]></TotReFrOut>\n";
		$ResponseXML .= "<OrderQty><![CDATA[" . GetOrderQty($orderId) . "]]></OrderQty>\n";
		$ResponseXML .= "<RvdQty><![CDATA[" . getRcvdQty($orderId,$comapany) . "]]></RvdQty>\n";
		$sql="SELECT DISTINCT companies.intCompanyID,CONCAT(companies.strName,'-',companies.strCity) as com FROM was_stocktransactions AS s 
INNER JOIN companies ON s.intFromFactory = companies.intCompanyID WHERE s.intStyleId='$orderId';";
//echo $sql;
	$res=$db->RunQuery($sql);
	$Nr=mysql_num_rows($res);
		if($Nr!=1){
			$cName .= "<option value=\"\"></option>\n";
		}
		while($rowS=mysql_fetch_array($res))
		{
			$cName .= "<option value=\"".  trim($rowS['intCompanyID']) ."\">".trim($rowS['com'])."</option>\n";
		}
	$ResponseXML.="<cName><![CDATA[" . trim($cName)  . "]]></cName>\n";
	$ResponseXML.="<Nr><![CDATA[" . trim($Nr)  . "]]></Nr>";
		
$ResponseXML .= "</XMLLoadDetails>";
echo $ResponseXML;
}
elseif($requestType=="URLLoadReDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
$orderId 	= $_GET["OrderId"];
$color 		= $_GET["Color"];
$sFac 		= $_GET["sFac"];

$ResponseXML = "<XMLLoadDetails>";
	
		$ResponseXML .= "<TotSendToOut><![CDATA[" . GetTotSendToOutQty($orderId,$color,$sFac) . "]]></TotSendToOut>\n";
		$ResponseXML .= "<TotReFrOut><![CDATA[" . GetTotReceiveFromOutQty($orderId,$color,$sFac ) . "]]></TotReFrOut>\n";
		$ResponseXML .= "<SubContractor><![CDATA[" . GetSubContractor($orderId,$color,$sFac ) . "]]></SubContractor>\n";
		
		$sql="SELECT DISTINCT companies.intCompanyID,CONCAT(companies.strName,'-',companies.strCity) as com FROM was_stocktransactions AS s 
INNER JOIN companies ON s.intFromFactory = companies.intCompanyID WHERE s.intStyleId='$orderId';";
//echo $sql;
	$res=$db->RunQuery($sql);
	$Nr=mysql_num_rows($res);
		if($Nr!=1){
			$cName .= "<option value=\"\"></option>\n";
		}
		while($rowS=mysql_fetch_array($res))
		{
			$cName .= "<option value=\"".  trim($rowS['intCompanyID']) ."\">".trim($rowS['com'])."</option>\n";
		}
	$ResponseXML.="<cName><![CDATA[" . trim($cName)  . "]]></cName>\n";
	$ResponseXML.="<Nr><![CDATA[" . trim($Nr)  . "]]></Nr>";
	$ResponseXML .= "</XMLLoadDetails>";
echo $ResponseXML;
}

else if($requestType=="URLLoadSubComReDetails"){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$po=$_GET['OrderId'];
	$sub=$_GET['subFac'];
	$color=$_GET['Color'];
	$sFac=$_GET['sFac'];
	
	$ResponseXML = "<XMLLoadDetails>\n";
	$ResponseXML .= "<TotSendToOut><![CDATA[" . GetTotSendToOutQtySW($po,$sub,$color,$sFac). "]]></TotSendToOut>\n";
	$ResponseXML .= "<TotReFrOut><![CDATA[" . GetTotReceiveFromOutQtySW($po,$color,$sFac,$sub) . "]]></TotReFrOut>\n";
	
	$ResponseXML .= "</XMLLoadDetails>";
echo $ResponseXML;
}
else if($requestType=="getStyle"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$po 	= $_GET["poNo"];
	$ResponseXML = "<XMLStyle>";		
	$result=setStyle($po);
	while($row=mysql_fetch_array($result)){
		$ResponseXML .= "<Style><![CDATA[" . trim($row["strStyle"]) . "]]></Style>\n";
		$ResponseXML .= "<COLOR><![CDATA[" . trim($row["strColor"]) . "]]></COLOR>\n";
		$ResponseXML .= "<PUR><![CDATA[" .  getPur($po) . "]]></PUR>\n";
		$ResponseXML .= "<Factory><![CDATA[" .  getFactory($po) . "]]></Factory>\n";
		
	}
	$ResponseXML .= "</XMLStyle>";
	echo $ResponseXML;
	
}

else if($requestType=="getPo"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$style 	= $_GET["style"];
	$result=setPo($style);
	$ResponseXML = "<XMLPO>";	
	while($row=mysql_fetch_array($result)){
		$ResponseXML .= "<PO><![CDATA[" . trim($row["intStyleId"]) . "]]></PO>\n";
		$ResponseXML .= "<COLOR><![CDATA[" . trim($row["strColor"]) . "]]></COLOR>\n";
		$ResponseXML .= "<PUR><![CDATA[" .  getPur($row["intStyleId"]) . "]]></PUR>\n";
		$ResponseXML .= "<Factory><![CDATA[" .  getFactory($row["intStyleId"]) . "]]></Factory>\n";
	}
	$ResponseXML .= "</XMLPO>";
	echo $ResponseXML;

}

//----f
else if($requestType=="LoadStyleAndOderNo"){
	$fFac=$_GET['fFac'];
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$sql="SELECT DISTINCT orders.strOrderNo,orders.intStyleId,orders.strStyle FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."' AND was_stocktransactions.intFromFactory='$fFac';";
	$result=$db->RunQuery($sql);
	$opt="<option value=\"\"></option>";
	$optS="<option value=\"\"></option>";
	$ResponseXML = "<XMLPO>";	
	while($row=mysql_fetch_array($result)){
		$opt.="<option value=\"".trim($row["intStyleId"])."\">".trim($row["strOrderNo"])."</option> ";
		$optS.="<option value=\"".trim($row["strStyle"])."\">".trim($row["strStyle"])."</option> ";
	}
		$ResponseXML .= "<PO><![CDATA[" . $opt . "]]></PO>\n";
		$ResponseXML .= "<Style><![CDATA[" . $optS . "]]></Style>\n";
	$ResponseXML .= "</XMLPO>";
	echo $ResponseXML;
	
}

//-----------------
/*else if($requestType=="GetSentAODDets"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$SAOD=$_GET['SAOD'];
	$AODNo=split("/",$SAOD);
	
	$sqlCV="create view WashsubOut as SELECT concat(was_subcontractout.intAODYear,'/',was_subcontractout.intAODNo) as OUTAOD FROM was_subcontractout;";
	//echo $sqlCV;
	$db->RunQuery($sqlCV);
	$sql="select OUTAOD from WashsubOut where OUTAOD like '$SAOD';";
	$res=$db->RunQuery($sql);
	$ResponseXML = "<XMLDet>";	
	while($row=mysql_fetch_array($res)){
		$ResponseXML .= "<OUTAOD><![CDATA[" . $row['OUTAOD'] . "]]></OUTAOD>\n";
	}
	$ResponseXML .= "</XMLDet>";
	$sqlDV="drop view WashsubOut;";
	$db->RunQuery($sqlDV);
	echo $ResponseXML;
}*/

else if($requestType=="GetSentAODDets"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$SAOD=$_GET['SAOD'];
	$AODNo=split("/",$SAOD);
	
	$sql="SELECT was_subcontractout.intSFac,was_subcontractout.strColor,was_subcontractout.intSubContractNo,orders.strOrderNo,orders.intStyleId,orders.strStyle FROM was_subcontractout INNER JOIN orders ON was_subcontractout.intStyleId = orders.intStyleId WHERE was_subcontractout.intAODNo='".$AODNo[1]."' AND was_subcontractout.intAODYear='".$AODNo[0]."';";
	
	$res=$db->RunQuery($sql);
	$ResponseXML = "<XMLDet>";	
	while($row=mysql_fetch_array($res)){
		$ResponseXML .= "<SFac><![CDATA[" . $row['intSFac'] . "]]></SFac>\n";
		$ResponseXML .= "<StyleId><![CDATA[" . $row['intStyleId'] . "]]></StyleId>\n";
		$ResponseXML .= "<OrderNo><![CDATA[" . $row['strOrderNo'] . "]]></OrderNo>\n";
		$ResponseXML .= "<Style><![CDATA[" . $row['strStyle'] . "]]></Style>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row['strColor'] . "]]></Color>\n";
		$ResponseXML .= "<SubContractNo><![CDATA[" . $row['intSubContractNo'] . "]]></SubContractNo>\n";
	}
	$ResponseXML .= "</XMLDet>";
	echo $ResponseXML;
}


//----
//BEGIN - Functions
function GetTotReceiveQty($orderId,$color,$comapany)
{
global $db;
$qty = 0;
	$sql="select sum(WS.dblQty)as stockQty from was_stocktransactions WS where strMainStoresID=1 and WS.intStyleId=$orderId and WS.strColor='$color' and WS.strType!='IFin' and WS.intCompanyId='$comapany' group by WS.intStyleId,WS.strColor";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];
	}
	return $qty;
}

function GetTotSendToOutQty($orderId,$color,$sFac)
{
global $db;
$qty = 0;
	$sql="select sum(WS.dblQty)as stockQty from was_stocktransactions WS where strMainStoresID=1 and WS.intStyleId=$orderId and WS.strColor='$color' and WS.strType='SubOut' and intFromFactory='$sFac' group by WS.intStyleId,WS.strColor";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"]*-1;
	}
	return $qty;
}

function GetTotReceiveFromOutQty($orderId,$color,$sFac)
{
global $db;
$qty = 0;
	$sql="select sum(WS.dblQty)as stockQty from was_stocktransactions WS where strMainStoresID=1 and WS.intStyleId=$orderId and WS.strColor='$color' and WS.strType='SubIn' and intFromFactory='$sFac' group by WS.intStyleId,WS.strColor";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];
	}
	return $qty;
}

function setStyle($po){
	global $db;
	$sql="SELECT DISTINCT orders.strStyle,was_stocktransactions.strColor FROM orders INNER JOIN was_stocktransactions ON was_stocktransactions.intStyleId = orders.intStyleId WHERE orders.intStyleId = '$po';";
	return $db->RunQuery($sql);
	
}

function setPo($style){
	global $db;
	$sql="SELECT DISTINCT orders.intStyleId,was_stocktransactions.strColor FROM orders INNER JOIN was_stocktransactions ON was_stocktransactions.intStyleId = orders.intStyleId WHERE orders.strStyle = '$style';";	
	//$sql="SELECT orders.intStyleId FROM orders WHERE orders.strStyle = '$style';";
	return $db->RunQuery($sql);
}

function getPur($PO){
global $db;
$SQL="SELECT was_subcontractout.strPurpose from was_subcontractout WHERE was_subcontractout.intStyleId =  '$PO';";
//echo $SQL;
$res = $db->RunQuery($SQL);
$arrRemarks=array();
$c=0;
	while($row=mysql_fetch_array($res)){
		$arrRemarks[$c]=$row['strPurpose'];
		$c++;
	}
	return implode(",",$arrRemarks);
}

function getFactory($PO){
global $db;
	$SQL=" SELECT DISTINCT was_subcontractout.intSubContractNo from was_subcontractout WHERE was_subcontractout.intStyleId =  '$PO';";
	$res = $db->RunQuery($SQL);
	$row=mysql_fetch_array($res);
	return	$row['intSubContractNo'];
}

function GetOrderQty($po){
	global $db;
	$SQL=" SELECT orders.intQty FROM orders WHERE orders.intStyleId=  '$po';";
	
	$res = $db->RunQuery($SQL);
	$row=mysql_fetch_array($res);
	return	$row['intQty'];
}

function getRcvdQty($po,$comapany){
global $db;
	$SQL="SELECT coalesce(Sum(was_stocktransactions.dblQty),0) AS WRcvd FROM was_stocktransactions WHERE was_stocktransactions.strType = 'FTransIn' AND was_stocktransactions.intStyleId='$po' AND was_stocktransactions.intCompanyId='$comapany' GROUP BY was_stocktransactions.intStyleId";
	
	$res = $db->RunQuery($SQL);
	$row=mysql_fetch_array($res);
	return	$row['WRcvd'];
}

function GetSubContractor($orderId,$color,$sFac){
	global $db;
	$sql="select intSubContractNo from was_subcontractout where intStyleId='$orderId' and strColor='$color' and intSFac='$sFac' GROUP BY intSubContractNo; ";
	$res=$db->RunQuery($sql);
	$c=0;
	$r='';
	while($row=mysql_fetch_array($res)){
		$r.=$row['intSubContractNo'];
		$c++;
	}
	if($c == 0 || $c > 1){
		return "";
	}
	else{
		return $r;	
	}
}

function  GetTotSendToOutQtySW($po,$sCom,$color,$sFac){
global $db;
$qty = 0;
	$sql="SELECT was_subcontractout.intStyleId,was_subcontractout.strColor,Sum(was_subcontractout.dblQty) AS stockQty,was_subcontractout.intSFac
		  FROM was_subcontractout
		  WHERE 
		  was_subcontractout.intSubContractNo = '$sCom' AND was_subcontractout.intStyleId = '$po' 
		  AND was_subcontractout.strColor='$color' AND was_subcontractout.intSFac='$sFac'
		  GROUP BY
		  was_subcontractout.intStyleId,
		  was_subcontractout.strColor,
		  was_subcontractout.intSFac,was_subcontractout.intSubContractNo;";
	//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];
	}
	return $qty;
}

function GetTotReceiveFromOutQtySW($po,$color,$sFac,$sCom)
{
global $db;
$qty = 0;
	$sql="SELECT was_subcontractin.intStyleId,was_subcontractin.strColor,Sum(was_subcontractin.dblQty) AS stockQty,was_subcontractin.intSubContractNo
		  FROM was_subcontractin
		  WHERE
		  was_subcontractin.intStyleId='$po' AND
		  was_subcontractin.strColor='$color' AND
		  was_subcontractin.intSFac='$sFac' AND
		  was_subcontractin.intSubContractNo='$sCom'
		  GROUP BY
		  was_subcontractin.intStyleId,
		  was_subcontractin.strColor,
		  was_subcontractin.intSubContractNo";
	//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];
	}
	return $qty;
}
//END - Functions
?>