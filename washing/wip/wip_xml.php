<?php
include('../../Connector.php');
$request=$_GET['req'];
$comId=$_GET['comId'];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$ResponseXml='';
if($request=="loadPo")
{
	$sql_loadPo="SELECT
				orders.strOrderNo,
				companies.strName,
				orders.intStyleId
				FROM
				orders
				Inner Join productionfinishedgoodsreceiveheader ON productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId
				Inner Join companies ON companies.intCompanyID = productionfinishedgoodsreceiveheader.strTComCode
				WHERE
				companies.intCompanyID ='$comId' AND orders.intStatus='11';";
	//echo $sql_loadPo;
	$res=$db->RunQuery($sql_loadPo);
	
	$ResponseXml="<loadDet>";
	while($row=mysql_fetch_array($res))
	{
		$ResponseXml.="<poNo><![CDATA[" . trim($row["intStyleId"])  . "]]></poNo>";
		$ResponseXml.="<poDesc><![CDATA[" . trim($row["strOrderNo"])  . "]]></poDesc>";
	}
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}
if($request=="loadGrid")
{
	$sql_loadGrid="SELECT wid.dblIssueNo,c.strComCode,c.strName cName,o.strStyle,wid.strColor,o.strOrderNo
					FROM was_issuedtowashdetails wid
					INNER JOIN was_issuedtowashheader wih ON wih.dblIssueNo = wid.dblIssueNo
					INNER JOIN orders o ON o.intStyleId=wih.intStyleNo
					INNER JOIN companies c ON c.intCompanyID=o.intCompanyID
					INNER JOIN buyers b ON b.intBuyerID = o.intBuyerID
					WHERE o.intCompanyID='$comId';";
	//echo $sql_loadGrid;
	$res=$db->RunQuery($sql_loadGrid);
	
	$ResponseXml="<loadDet>";
	while($row=mysql_fetch_array($res))
	{
		$ResponseXml.="<strComCode><![CDATA[" . trim($row["strComCode"])  . "]]></strComCode>";
		$ResponseXml.="<cName><![CDATA[" . trim($row["cName"])  . "]]></cName>";
		$ResponseXml.="<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>";
		$ResponseXml.="<strDivision><![CDATA[" . trim($row["strDivision"])  . "]]></strDivision>";
		$ResponseXml.="<strOrderNo><![CDATA[" . trim($row["strOrderNo"])  . "]]></strOrderNo>";
		$ResponseXml.="<intStyleId><![CDATA[" . trim($row["strStyle"])  . "]]></intStyleId>";
		$ResponseXml.="<intQty><![CDATA[" . trim($row["intQty"])  . "]]></intQty>";
		$ResponseXml.="<intCutQty><![CDATA[" . trim($row["intCutQty"])  . "]]></intCutQty>";
		$ResponseXml.="<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>";
	}
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}
?>