<?php
session_start();
require_once('../../Connector.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$request=$_GET['req'];
$companyId	= $_SESSION["FactoryID"];

if($request=="URLLoadMRNDetails")
{
$mrnNo = $_GET["MrnNo"];
$mrnNo 	= explode('/',$mrnNo);
$ResponseXml = "<XMLLoadMRNDetails>";
	$sql="select intDepartment,intStyleId,strColor,dblQty,intStore from was_mrn where dblMrnNo='$mrnNo[1]' and intMrnYear='$mrnNo[0]'";
	$result=$db->RunQuery($sql);
	$orderId='';
	
	
	
	//while(
		  $row=mysql_fetch_array($result);//)	{
		$ResponseXml .= "<Dept><![CDATA[" . trim($row['intDepartment'])  . "]]></Dept>";
		$ResponseXml .= "<Store><![CDATA[" . trim($row['intStore'])  . "]]></Store>";
		$ResponseXml .= "<OrderNo><![CDATA[" . GetOrderNo($row['intStyleId']) . "]]></OrderNo>";
		$ResponseXml .= "<StyleNo><![CDATA[" . GetStyleNo($row['intStyleId']) . "]]></StyleNo>";
		$orderId=$row['intStyleId'];
		$ResponseXml .= "<Color><![CDATA[" . "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" . "]]></Color>";
		$ResponseXml .= "<OrderQty><![CDATA[" . GetOrderQty($row['intStyleId']) . "]]></OrderQty>";
		$ResponseXml .= "<MRNQty><![CDATA[" . $row['dblQty'] . "]]></MRNQty>";
		
	//}
	
	$sqlF="SELECT DISTINCT companies.intCompanyID,CONCAT(companies.strName,'-',companies.strCity) as com FROM was_stocktransactions AS s 
INNER JOIN companies ON s.intFromFactory = companies.intCompanyID WHERE s.intStyleId='$orderId';";
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
		//die($Nr);
	$ResponseXml .= "<AvailableQty><![CDATA[" . GetAvailableQty($orderId, $row["strColor"],$companyId,$fCom) . "]]></AvailableQty>";
	$ResponseXml.="<cName><![CDATA[" . trim($cName)  . "]]></cName>\n";
	$ResponseXml.="<Nr><![CDATA[" . trim($Nr)  . "]]></Nr>";
	
$ResponseXml .= "</XMLLoadMRNDetails>";
echo $ResponseXml;	
}

function GetOrderNo($styleId) 
{
global $db;
	$sql="select intStyleId,strOrderNo from orders where intStyleId='$styleId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$combo .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
return $combo;
}

function GetStyleNo($styleId) 
{
global $db;
	$sql="select distinct strStyle from orders where intStyleId='$styleId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$combo .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
return $combo;
}

function GetOrderQty($styleId) 
{
global $db;
	$sql = " select intQty from orders where intStyleId='$styleId' ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["intQty"];
	}
}

function GetAvailableQty($styleId,$color,$companyId,$fFac)
{
global $db;
$qty = 0;
	$sql="select COALESCE(sum(dblQty),0) as RCVDQty from was_stocktransactions where intStyleId='$styleId' and strColor='$color' and intCompanyId='$companyId' and intFromFactory='$fFac' AND strMainStoresID=1 group by intStyleId,strColor;";
	$result=$db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$qty = $row['RCVDQty'];
	}
return $qty;
}
?>