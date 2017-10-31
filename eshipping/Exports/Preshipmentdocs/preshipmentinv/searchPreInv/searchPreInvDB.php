<?php
session_start();
$backwardseperator = "../../../../";
include "$backwardseperator".''."Connector.php";
header('Content-Type: text/xml'); 	
$request=$_GET["request"];


if($request=='load_po_no')
{
	$sql="SELECT DISTINCT strBuyerPONo FROM invoicedetail ORDER BY strBuyerPONo;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$po_arr.=$row['strBuyerPONo']."|";
				 
	}
	echo $po_arr;
		
}

if($request=='load_style_no')
{
	$sql="SELECT DISTINCT strStyleID FROM invoicedetail ORDER BY strStyleID";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$style_arr.=$row['strStyleID']."|";
				 
	}
	echo $style_arr;
		
}

if ($request=='load_inv_grid')
{
	
	$invNo		=$_GET["invNo"];
	$ponumber	=$_GET["ponumber"];
	$style		=$_GET["style"];
	$manuId		=$_GET["manuId"];
	//$DO			=$_GET["DO"];
		
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];
	$str="SELECT DISTINCT
			invoiceheader.strInvoiceNo,
			date(invoiceheader.dtmInvoiceDate) AS dtmInvoiceDate,
			invoicedetail.strStyleID,
			invoicedetail.strBuyerPONo,
			sum(invoicedetail.dblQuantity) AS dblQuantity,
			sum(invoicedetail.intNoOfCTns) AS intNoOfCTns,
			customers.strMLocation,
			city.strCity
			FROM
			invoiceheader
			INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
			INNER JOIN customers ON customers.strCustomerID = invoiceheader.intManufacturerId
			INNER JOIN city ON city.strCityCode = invoiceheader.strFinalDest
			WHERE invoiceheader.strInvoiceNo!=''";
					
	if($invNo!="")
		$str.=" and strInvoiceNo='$invNo'";
	if($ponumber!="")
		$str.=" and strBuyerPONo='$ponumber'";
	if($style!="")
		$str.=" and strStyleID='$style'";
	if($manuId!="")
		$str.=" and strCustomerID='$manuId'";
	
	$str.=" GROUP BY invoiceheader.strInvoiceNo";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{	
		
		//$pldate		 =$row["strSailingDate"];
		$xml_string .= "<InvNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvNo>\n";
		$xml_string .= "<InvDate><![CDATA[" . $row["dtmInvoiceDate"]   . "]]></InvDate>\n";	
		$xml_string .= "<StyleId><![CDATA[" . $row["strStyleID"]   . "]]></StyleId>\n";	
		$xml_string .= "<PoNo><![CDATA[" . $row["strBuyerPONo"]   . "]]></PoNo>\n";	
		$xml_string .= "<Qty><![CDATA[" . $row["dblQuantity"]   . "]]></Qty>\n";
		$xml_string .= "<Ctns><![CDATA[" . $row["intNoOfCTns"] . "]]></Ctns>\n";
		$xml_string .= "<Manu><![CDATA[" . $row["strMLocation"]   . "]]></Manu>\n";
		$xml_string .= "<Dest><![CDATA[" . $row["strCity"]   . "]]></Dest>\n";		
	} 
	$xml_string.='</data>';
	echo $xml_string;
}

?>