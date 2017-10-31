<?php
session_start();
require_once('../../Connector.php');
include('../washingCommonScript.php');
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
$factory=$_SESSION['FactoryID'];
$ResponseXml='';
$wScripts=new wasCommonScripts();

if($request=="loadCompany"){
	$orderNo=$_GET['orderNo'];
	$sql="SELECT DISTINCT companies.intCompanyID,CONCAT(companies.strName,'-',companies.strCity) as com FROM was_stocktransactions AS s 
INNER JOIN companies ON s.intFromFactory = companies.intCompanyID WHERE s.intStyleId='$orderNo' and s.intCompanyId='$factory';";

	$res=$db->RunQuery($sql);
	$Nr=mysql_num_rows($res);
	$ResponseXml.="<det>";
	if($Nr!=1){
		$cName .= "<option value=\"\"></option>\n";
	}
	while($rowS=mysql_fetch_array($res))
	{
		$cName .= "<option value=\"".  trim($rowS['intCompanyID']) ."\">".trim($rowS['com'])."</option>\n";
	}
	$ResponseXml.="<cName><![CDATA[" . trim($cName)  . "]]></cName>\n";
	$ResponseXml.="<Nr><![CDATA[" . trim($Nr)  . "]]></Nr>";
	$ResponseXml.="</det>";
	echo $ResponseXml;
}

if($request=="loadStyle")
{
	$comId=$_GET['comId'];
	$sql_loadStyle="SELECT DISTINCT O.strStyle,O.intStyleId FROM orders AS O Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = O.intStyleId WHERE was_stocktransactions.intFromFactory ='$comId' and was_stocktransactions.intCompanyId='$factory' order by O.strStyle;";
	//echo $sql_loadStyle;
	$resS=$db->RunQuery($sql_loadStyle);
	$ResponseXml="<loadDet>";
	$strStyle = "<option value=\"". "" ."\">"."Select One"."</option>\n";
	while($rowS=mysql_fetch_array($resS))
	{
		$strStyle .= "<option value=\"". $rowS["intStyleId"] ."\">".$rowS["strStyle"]."</option>\n";	
	}
	
	$resOrder = loadOrderNolist($comId,$factory);
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
if($request=="loadPO")
{
	$sId=$_GET['sId'];
	$styleName = $_GET['styleName'];
	
	$sql_loadPO="SELECT DISTINCT O.strOrderNo,O.intStyleId
				FROM orders O 
				INNER JOIN productionfinishedgoodsreceiveheader p ON p.intStyleNo=O.intStyleId
				";
				
		if($sId !='')
			$sql_loadPO .= " WHERE 	O.strStyle ='$styleName' ";
			
		$sql_loadPO .= " order by O.strOrderNo ";		
				//echo $sql_loadPO;
	$resPO=$db->RunQuery($sql_loadPO);
	$ResponseXml="<loadDet>";
	$strOrder = "<option value=\"". "" ."\">"."Select One"."</option>\n";
	while($rowPO=mysql_fetch_array($resPO))
	{
		
		$strOrder .= "<option value=\"". $rowPO["intStyleId"] ."\">".$rowPO["strOrderNo"]."</option>\n";	
	}
	
	$ResponseXml.="<orderNo><![CDATA[" . trim($strOrder) . "]]></orderNo>";
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}

if($request=="loadColor"){
	$orderNo=$_GET['orderNo'];
	$sql="select distinct strColor from was_stocktransactions where intStyleId='$orderNo' and  intCompanyId='$factory' order by strColor;";
	$res=$db->RunQuery($sql);
	$ResponseXml.="<SetColor>";
	$colorO='';
	while($row=mysql_fetch_array($res)){
		$ResponseXml.="<Color><![CDATA[" . trim($row['strColor']) . "]]></Color>";
		//$colorO.="<option value=\"".trim($row['strColor'])."\">".trim($row['strColor'])."</option>";
	}
	//$ResponseXml.="<Color><![CDATA[".$colorO."]]></Color>";
	$ResponseXml.="</SetColor>";
	echo $ResponseXml;
}

if($request=="loadQty"){
	$po		=	$_GET['orderNo'];
	$color	=	$_GET['color'];
	$fFac	=	$_GET['fFac'];
	
	$ResponseXml.="<loadQty>";
	$RCVDQty	= 	getRCVDQty($po,$color);
	//$AVGQty 	=	getAvlQty($po,$color);
	$subBal		=    getSubBal($po,$color);
	
	$AVGQty 	=	$wScripts->gpQtyForIssued($po,$color,$factory,$fFac)- ($wScripts->getSubContractorBalance($po,$color,$fFac)+$wScripts->getIssuedToOtherBalance($po,$color,$factory,$fFac)+ $wScripts->getReturnToFactoryQty($po,$color,$fFac)+$wScripts->getMrnIssueQty($po,$color,$fFac)+$wScripts->getIssuedToWashQty($po,$color,$fFac));
	
	$ResponseXml.="<RCVDQty><![CDATA[" . $wScripts->gpQtyForIssued($po,$color,$factory,$fFac) . "]]></RCVDQty>";
	$ResponseXml.="<ORDERQty><![CDATA[" . getOrderQty($po). "]]></ORDERQty>";
	$ResponseXml.="<IQty><![CDATA[" .  $wScripts->GetAvailableQty($po,$color,$factory,$fFac) . "]]></IQty>";
	$ResponseXml.="<IssuedQty><![CDATA[" . getAvlQty($po,$color,$fFac). "]]></IssuedQty>";
	
	$ResponseXml.="</loadQty>";
	echo $ResponseXml;
}

if($request=="loadDet"){
	$iNo   	=	$_GET['iNo'];
	$iYear 	=	$_GET['iYear'];
	
	$sql="select strFComCode,intStyleNo,strColor,dblQty,intStatus from was_issuedtowashheader where dblIssueNo='$iNo ' and intIssueYear='$iYear';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	$ResponseXml.="<loadData>";
	
		$ResponseXml.="<FComCode><![CDATA[" .$row['strFComCode']. "]]></FComCode>";
		$ResponseXml.="<PONo><![CDATA[" .$row['intStyleNo']. "]]></PONo>";
		$ResponseXml.="<Color><![CDATA[" .$row['strColor']. "]]></Color>";
		$ResponseXml.="<Qty><![CDATA[" .$row['dblQty']. "]]></Qty>";
		$ResponseXml.="<Style><![CDATA[" .getStyle($row['intStyleNo']). "]]></Style>";
		$ResponseXml.="<Status><![CDATA[" .$row['intStatus']. "]]></Status>";
		
	$ResponseXml.="</loadData>";
	echo $ResponseXml;
}
if($request=="loadGrid")
{
//pd.strSize,;pd.strSize,
	$orderNo=$_GET['orderNo'];
	$sql_loadGrid="SELECT
					pd.strColor,
					Sum(pd.lngRecQty  ) QTY,
					
					ph.strTComCode
					FROM
					productionfinishedgoodsreceivedetails AS pd
					Inner Join productionfinishedgoodsreceiveheader AS ph ON ph.dblTransInNo = pd.dblTransInNo AND ph.intGPTYear = pd.intGPTYear
					Inner Join orders ON ph.intStyleNo = orders.intStyleId
					WHERE
					orders.intStyleId  =  '$orderNo'
					group by pd.strColor,ph.strTComCode;";
	
	$sql_res=$db->RunQuery($sql_loadGrid);
	$ResponseXml="<loadDet>";
	while($rowLoad=mysql_fetch_array($sql_res))
	{
		$sql_colorQty=" select sum(wid.dblIssueQty) BQty 
						from was_issuedtowashdetails wid inner join was_issuedtowashheader wih on
						wid.dblIssueNo = wih.dblIssueNo and wid.intIssueYear = wih.intIssueYear
						where wid.strColor ='" . trim($rowLoad["strColor"])."' and strSize='". trim($rowLoad["strSize"]) ."'
						and wih.intStyleNo='$orderNo' and wih.strFComCode='". $rowLoad["strTComCode"] ."'";
						//echo $sql_colorQty;
		$res=$db->RunQuery($sql_colorQty);		
		$rowColor=mysql_fetch_array($res);
		
		$washIssueQty =trim($rowColor["BQty"]);
		if(is_null($washIssueQty) || $washIssueQty == '')
			 $washIssueQty =0;
			 
		$bal=trim($rowLoad["QTY"]) - $washIssueQty;
		
		$ResponseXml.="<strColor><![CDATA[" . trim($rowLoad["strColor"])  . "]]></strColor>";
		$ResponseXml.="<QTY><![CDATA[" . $bal . "]]></QTY>";
		$ResponseXml.="<TQTY><![CDATA[" . trim($rowLoad["QTY"]). "]]></TQTY>";
		$ResponseXml.="<strSize><![CDATA[" . trim($rowLoad["strSize"])  . "]]></strSize>";
	}
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}
if($request=="getOrderQty")
{
	$orderNo=$_GET['orderNo'];
	$ResponseXml="<loadDet>";
	
	$sql = " select intQty from orders where intStyleId='$orderNo' ";
	$res=$db->RunQuery($sql);		
	$row=mysql_fetch_array($res);
	
	$ResponseXml.="<orderQty><![CDATA[" . $row["intQty"] . "]]></orderQty>";
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}
if($request=="loadData")
{
	$serial=$_GET['serial'];
	$sql_loadGrid="SELECT
					wih.dtmIssueDate,
					wih.intStyleNo,
					O.strStyle,
					O.strOrderNo,
					O.intQty,
					p.strTComCode
					FROM
					was_issuedtowashheader AS wih
					Inner Join orders AS O ON O.intStyleId = wih.intStyleNo
					Inner Join productionfinishedgoodsreceiveheader AS p ON p.intStyleNo = O.intStyleId
					WHERE wih.dblIssueNo='$serial'";

	$sql_res=$db->RunQuery($sql_loadGrid);
	$ResponseXml="<loadDet>";
	while($rowLoad=mysql_fetch_array($sql_res))
	{
		$ResponseXml.="<intStyleNo><![CDATA[" . trim($rowLoad["intStyleNo"])  . "]]></intStyleNo>";
		$ResponseXml.="<dtmIssueDate><![CDATA[" . trim(substr($rowLoad["dtmIssueDate"],0,10))  . "]]></dtmIssueDate>";
		$ResponseXml.="<strStyle><![CDATA[" . trim($rowLoad["strStyle"])  . "]]></strStyle>";
		$ResponseXml.="<intCompanyID><![CDATA[" . trim($rowLoad["strTComCode"])  . "]]></intCompanyID>";
		$ResponseXml.="<strOrderNo><![CDATA[" . trim($rowLoad["strOrderNo"])  . "]]></strOrderNo>";
		$ResponseXml.="<intQty><![CDATA[" . trim($rowLoad["intQty"])  . "]]></intQty>";
	}
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}

if($request=="fillGrid")
{
	$serial=$_GET['serial'];
	$styleNo=$_GET['styleNo'];
	
	$sql_fillGrid="SELECT  pd.strColor,sum(pd.lngRecQty) QTY,pd.strSize,ph.intStyleNo
					FROM productionfinishedgoodsreceivedetails pd
					INNER JOIN productionfinishedgoodsreceiveheader ph ON ph.dblTransInNo=pd.dblTransInNo 
					WHERE  ph.intStyleNo='$styleNo' AND pd.strColor IN (SELECT wid.strColor
					FROM was_issuedtowashdetails wid
					WHERE wid.dblIssueNo='$serial' )
					group by pd.strColor,pd.strSize,ph.strTComCode;"; 
				//echo $sql_fillGrid;
				//die();
				
	$sql_res=$db->RunQuery($sql_fillGrid);
	$ResponseXml="<loadGridDet>";
	while($rowLoad=mysql_fetch_array($sql_res))
	{
		$sql_colorQty="select sum(dblIssueQty) BQty
						from was_issuedtowashdetails
						where strColor ='".trim($rowLoad["strColor"]) ."' and strSize='".trim($rowLoad["strSize"]) ."';";
						
		$res=$db->RunQuery($sql_colorQty);		
		$rowColor=mysql_fetch_array($res);
		$bal=trim($rowLoad["QTY"])- trim($rowColor["BQty"]);//
		
		$ResponseXml.="<strColor><![CDATA[" . trim($rowLoad["strColor"])  . "]]></strColor>";
		$ResponseXml.="<QTY><![CDATA[" .$bal. "]]></QTY>";
		$ResponseXml.="<TQTY><![CDATA[" .$rowLoad["QTY"]. "]]></TQTY>"; 
		$ResponseXml.="<strSize><![CDATA[" . trim($rowLoad["strSize"])  . "]]></strSize>";
		$ResponseXml.="<intStyleNo><![CDATA[" . trim($rowLoad["intStyleNo"])  . "]]></intStyleNo>";
	}
	$sql_qty="SELECT wid.dblIssueQty
FROM
was_issuedtowashdetails AS wid
Inner Join productionfinishedgoodsreceiveheader AS ph
Inner Join productionfinishedgoodsreceiveheader ON ph.dblTransInNo = productionfinishedgoodsreceiveheader.dblTransInNo AND ph.intGPTYear = productionfinishedgoodsreceiveheader.intGPTYear
Inner Join was_issuedtowashheader ON was_issuedtowashheader.intStyleNo = productionfinishedgoodsreceiveheader.intStyleNo AND was_issuedtowashheader.dblIssueNo = wid.dblIssueNo AND was_issuedtowashheader.intIssueYear = wid.intIssueYear
WHERE wid.dblIssueNo='$serial';";
				//echo $sql_qty;
	$sql_ResQty=$db->RunQuery($sql_qty);
	while($rowLoad=mysql_fetch_array($sql_ResQty))
	{
		$ResponseXml.="<dblIssueQty><![CDATA[" . trim($rowLoad["dblIssueQty"])  . "]]></dblIssueQty>";
	}
	$ResponseXml.="</loadGridDet>";
	echo $ResponseXml;

}

function loadOrderNolist($comID,$factory)
{
	global $db;
	$sql = " SELECT DISTINCT O.intStyleId,O.strOrderNo FROM orders AS O Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = O.intStyleId WHERE was_stocktransactions.intFromFactory ='$comID' and was_stocktransactions.intCompanyId='$factory'  order by O.strStyle;";
	//echo $sql ;
	return $db->RunQuery($sql);		
}

function getRCVDQty($po,$color){
	global $db;
	$sql="select sum(dblQty) as RCVDQty from was_stocktransactions where intStyleId='$po' and strColor='$color'  and strType='FTransIn'
group by intStyleId,strColor;";/* and strType='FTransIn'*/
//echo $sql;
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

function getAvlQty($po,$color,$fFac){
global $db;
	//$sql="select sum(dblQty) as WQty from was_stocktransactions where intStyleId='$po' and strColor='$color' and strMainStoresID=1 group by intStyleId,strColor;";
	//$sql="select sum(dblQty) as WQty from was_stocktransactions where intStyleId='$po' and strColor='$color' group by intStyleId,strColor;";
	$sql="select COALESCE(sum(dblQty),0) as IQty  from was_issuedtowashheader where intStyleNo='$po' and strColor='$color' and strFComCode='$fFac' group by intStyleNo,strColor;";
	//echo $sql;
	$res=$db->RunQuery($sql);	
		
	$row=mysql_fetch_array($res);
		return $row['IQty'];
}
function getSubBal($po,$color){
	global $db;
$sqlS="SELECT
Sum(was_stocktransactions.dblQty) as SQty FROM was_stocktransactions WHERE was_stocktransactions.strType IN ('SubOut', 'SubIn','FacOut','FacRCvIn') AND was_stocktransactions.intStyleId = '$po' AND was_stocktransactions.strColor = '$color' GROUP BY was_stocktransactions.intStyleId,was_stocktransactions.strColor;";
//echo $sqlS; 
$resS=$db->RunQuery($sqlS);
$rowS=mysql_fetch_array($resS);
	return $rowS['SQty'];
}
function getStyle($po){
	global $db;
	$sql="select strStyle from orders where intStyleId='$po';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['strStyle'];
}
function getIssuedQty($po,$color){
	global $db;
	$sql="select strStyle from orders where intStyleId='$po';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['strStyle'];	
}
?>