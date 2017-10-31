<?php

include "../../../Connector.php";
$id=$_GET['id'];

if($id=='beginSearch')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<DispatchNoteSearchDetails>";
	
	$plNo=$_GET['plNo'];
	$poNo=$_GET['poNo'];
	$buyerCode=$_GET['buyerCode'];
	$dateFrom=$_GET['dateFrom'];
	$dateTo=$_GET['dateTo'];
	
	$dateFromArray 	= explode('/',$dateFrom);
	$FormatDateFrom = $dateFromArray[2]."-".$dateFromArray[1]."-".$dateFromArray[0];
	
	$dateToArray 	= explode('/',$dateTo);
	$FormatDateTo = $dateToArray[2]."-".$dateToArray[1]."-".$dateToArray[0];
	
	
	
	 $sql="SELECT
	 		exportdispatchdetail.strPLNo,
			exportdispatchdetail.strOrderNo,
			exportdispatchheader.intDispatchNo,
			exportdispatchheader.dtmDate,
			exportdispatchheader.strBuyerCode,
			buyers.strName,
			buyers.strBuyerCode AS BuyerCode
			FROM
			exportdispatchdetail
			INNER JOIN exportdispatchheader ON exportdispatchdetail.intDispatchNo = exportdispatchheader.intDispatchNo
			INNER JOIN buyers ON exportdispatchheader.strBuyerCode=buyers.strBuyerID WHERE dtmDate>='$FormatDateFrom'";
		
	if($buyerCode!='')
		$sql.="AND exportdispatchheader.strBuyerCode=$buyerCode";
	if($dateTo!='')
		$sql.="AND dtmDate<='$FormatDateTo'";
	if($plNo!='')
		$sql.="AND strPLNo='$plNo'";
	if($poNo!='')
		$sql.="AND strOrderNo='$poNo'";

	
	//echo $sql;
			
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<DispatchNo><![CDATA[" . $row["intDispatchNo"]  . "]]></DispatchNo>\n";
		$ResponseXML .= "<DispatchDate><![CDATA[" . $row["dtmDate"]  . "]]></DispatchDate>\n";
		$ResponseXML .= "<BuyerId><![CDATA[" . $row["strBuyerCode"]  . "]]></BuyerId>\n";
		$ResponseXML .= "<BuyerName><![CDATA[" . $row["strName"]  . "]]></BuyerName>\n";
		$ResponseXML .= "<BuyerCode><![CDATA[" . $row["BuyerCode"]  . "]]></BuyerCode>\n";
	}
				
	
	$ResponseXML .= "</DispatchNoteSearchDetails>";
	echo $ResponseXML;	
}

if($id=='load_po_no')
{
	$sql="SELECT DISTINCT strOrderNo FROM exportdispatchdetail ORDER BY strOrderNo;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$order_arr.=$row['strOrderNo']."|";
				 
	}
	echo $order_arr;
	
}
?>