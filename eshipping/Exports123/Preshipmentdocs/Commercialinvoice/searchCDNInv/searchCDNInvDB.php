<?php
session_start();
$backwardseperator = "../../../../";
include "$backwardseperator".''."Connector.php";
header('Content-Type: text/xml'); 	
$request=$_GET["request"];


if($request=='load_po_no')
{
	$sql="SELECT DISTINCT strBuyerPONo FROM cdn_detail ORDER BY strBuyerPONo;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$po_arr.=$row['strBuyerPONo']."|";
				 
	}
	echo $po_arr;
		
}

if($request=='load_style_no')
{
	$sql="SELECT DISTINCT strStyleID FROM cdn_detail ORDER BY strStyleID";
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
	$invoiceType = $_GET["invoiceType"];
	//$DO			=$_GET["DO"];
	$style=$_GET['style'];
		
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	
	
	if($invoiceType=="1")
	{
		 $str="SELECT DISTINCT
				cdn_header.strInvoiceNo,
				cdn_header.intCDNConform,
				cdn_header.intCancel,
				date(cdn_header.dtmDate) AS dtmInvoiceDate,
				cdn_detail.strStyleID,
				cdn_detail.strBuyerPONo,
				Sum(cdn_detail.dblQuantity) AS dblQuantity,
				Sum(cdn_detail.intNoOfCTns) AS intNoOfCTns,
				customers.strMLocation,
				city.strCity,
				invoiceheader.strTransportMode
				FROM
				cdn_header
				INNER JOIN cdn_detail ON cdn_detail.strInvoiceNo = cdn_header.strInvoiceNo
				INNER JOIN invoiceheader ON invoiceheader.strInvoiceNo = cdn_header.strInvoiceNo
				INNER JOIN customers ON customers.strCustomerID = invoiceheader.intManufacturerId
				INNER JOIN city ON city.strCityCode = invoiceheader.strFinalDest
				WHERE cdn_header.strInvoiceNo!=''
	";
						
		if($invNo!="")
			$str.=" and cdn_header.strInvoiceNo='$invNo'";
		if($ponumber!="")
			$str.=" and cdn_detail.strBuyerPONo='$ponumber'";
		if($style!="")
			$str.=" and cdn_detail.strStyleID='$style'";
		if($manuId!="")
			$str.=" and strCustomerID='$manuId'";
		
	$str.="GROUP BY invoiceheader.strInvoiceNo";
	}
		
		else if($invoiceType=="2")
		{
						$str="SELECT DISTINCT
					invoiceheader.strInvoiceNo,
					invoiceheader.dtmInvoiceDate,
					invoicedetail.strStyleID,
					invoicedetail.strBuyerPONo,
					Sum(invoicedetail.dblQuantity) AS dblQuantity,
					Sum(invoicedetail.intNoOfCTns) AS intNoOfCTns,
					customers.strMLocation,
					city.strCity,
					invoiceheader.strTransportMode
					
					FROM 	invoiceheader
					INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo=invoiceheader.strInvoiceNo
					INNER JOIN customers ON customers.strCustomerID = invoiceheader.intManufacturerId
					INNER JOIN city ON city.strCityCode = invoiceheader.strFinalDest
					WHERE invoiceheader.strInvoiceNo!=''
					";

								
				if($invNo!="")
					$str.=" and invoiceheader.strInvoiceNo='$invNo'";
				if($ponumber!="")
					$str.=" and invoicedetail.strBuyerPONo='$ponumber'";
				if($style!="")
					$str.=" and invoicedetail.strStyleID='$style'";
				if($manuId!="")
					$str.=" and strCustomerID='$manuId'";
				
				$str.="GROUP BY invoiceheader.strInvoiceNo";	
				
		}	
			else
				{	
									$str="SELECT DISTINCT
										commercial_invoice_detail.strInvoiceNo,
										commercial_invoice_header.dtmInvoiceDate,
										commercial_invoice_detail.strStyleID,
										commercial_invoice_detail.strBuyerPONo,
										Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
										Sum(commercial_invoice_detail.intNoOfCTns) AS intNoOfCTns,
										customers.strMLocation,
										city.strCity,
										commercial_invoice_header.strTransportMode

										FROM 	commercial_invoice_header
										INNER JOIN commercial_invoice_detail ON 				commercial_invoice_detail.strInvoiceNo=commercial_invoice_header.strInvoiceNo
										INNER JOIN customers ON customers.strCustomerID = commercial_invoice_header.strCompanyID
										INNER JOIN city ON city.strCityCode = commercial_invoice_header.strFinalDest
										WHERE commercial_invoice_header.strInvoiceNo!=''
										";
										
						if($invNo!="")
							$str.=" and commercial_invoice_header.strInvoiceNo='$invNo'";
						if($ponumber!="")
							$str.=" and commercial_invoice_detail.strBuyerPONo='$ponumber'";
						if($style!="")
							$str.=" and commercial_invoice_detail.strStyleID='$style'";
						if($manuId!="")
							$str.=" and strCustomerID='$manuId'";
						
						$str.="GROUP BY commercial_invoice_header.strInvoiceNo";
									
				
				}
	
	$result=$db->RunQuery($str);
	
	//echo $str; 
	
	
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
		$xml_string .= "<Mode><![CDATA[" . $row["strTransportMode"]   . "]]></Mode>\n";	
		
		if($row['intCancel']==1)
			$xml_string .= "<Status>Cancelled</Status>\n";
		else if($row['intCDNConform']==1)
			$xml_string .= "<Status>Shipped</Status>\n";
		else
			$xml_string .= "<Status>Pending</Status>\n";
			
	
	} 
	$xml_string.='</data>';
	echo $xml_string;
}

if($request=='loadDoctype')
{		
	$cdn_arr = "<option value=''></option>";
	$invoiceType = $_GET["InvoiceType"];
	
	if($invoiceType=="1")
	{
		 $sql_docCdn="SELECT strInvoiceNo FROM cdn_header ORDER BY strInvoiceNo desc";
	}
	else if($invoiceType=="2")
	{
		$sql_docCdn="SELECT strInvoiceNo FROM invoiceheader ORDER BY strInvoiceNo desc";
	}
	else
	{
		$sql_docCdn="SELECT strInvoiceNo FROM commercial_invoice_header ORDER BY strInvoiceNo desc";
	}	
		
		$result_doc=$db->RunQuery($sql_docCdn);
		
		 
		while($row=mysql_fetch_array($result_doc))
	{
		
		$cdn_arr.= "<option value=".$row['strInvoiceNo'].">".$row['strInvoiceNo']."</option>";
				 
	}
	echo $cdn_arr;
		
}

?>