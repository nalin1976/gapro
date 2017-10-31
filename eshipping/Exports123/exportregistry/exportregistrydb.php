<?php
session_start();
$backwardseperator = "../../";
include "$backwardseperator".''."Connector.php";
header('Content-Type: text/xml'); 	

$request=$_GET["request"];

if ($request=='load_er_grid')
{
	
	
	$Reg_type		=$_GET["Reg_type"];
	$front_dateFrom		=$_GET["dateFrom"];
	$front_dateTo		=$_GET["dateTo"];
	
	$datefrom_array 	=explode("/",$front_dateFrom);
	$dateFrom			=$datefrom_array[2]."-".$datefrom_array[1]."-".$datefrom_array[0];
	$dateTo_array 		=explode("/",$front_dateTo);
	$dateTo				=$dateTo_array[2]."-".$dateTo_array[1]."-".$dateTo_array[0];
	
		
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];
	
	$str = "select
	cih.strInvoiceNo,
	cih.strCarrier,
	cih.strVoyegeNo,
	date(cih.dtmSailingDate) as dtmSailingDate,
	cih.dtmETA,
	buyers.strName AS BuyerAName, 
	cid.strBuyerPONo,
	cid.dblQuantity,
	cid.dblUnitPrice,
	cid.strPLno,
	cid.dblAmount,
	cih.strTransportMode,
	cid.strBuyerPONo,
	cid.strISDno,
	concat(cih.strCarrier,\" / \" ,cih.strVoyegeNo) as vessel,
	cid.strStyleID,
	cid.strDescOfGoods,
	cid.intNoOfCTns,
	cid.dblCBM,
	cid.dblQuantity,
	fi.strBL,
	fi.strHAWB,
	fi.strContainer,
	fi.strCTNSize,
	fi.strFreightPC,
	
	fi.dtmDocumentDueDate,
	fi.dtmDocumentSubDate,
	fi.dtmPaymentDueDate,
	fi.dtmPaymentSubDate,
	fi.strFileNo,
	fi.strExportNo,
	cid.strEntryNo,
	
	cih.strPayTerm,
	country.strCountry,
	city.strCity,
	forwaders.strName as Forwader,
	date(cih.dtmManufactDate) as dtmManufactDate,
	date_format(cih.dtmInvoiceDate,\"%M\") as Month	
from commercial_invoice_detail cid 
LEFT JOIN commercial_invoice_header cih ON cih.strInvoiceNo= cid.strInvoiceNo
LEFT JOIN commercialinvoice ci ON ci.strInvoiceNo=cid.strInvoiceNo
LEFT JOIN finalinvoice fi ON fi.strInvoiceNo=cid.strInvoiceNo
LEFT JOIN city ON city.strCityCode=cih.strFinalDest
left join forwaders on forwaders.intForwaderID=cih.strForwader
LEFT JOIN country ON city.strCountryCode=country.strCountryCode
LEFT JOIN buyers ON cih.strBuyerID =buyers.strBuyerID where cih.strInvoiceNo!=''";


if($Reg_type!="" )
	$str.=" and  cih.strInvoiceType = '$Reg_type'";

if($front_dateTo!="" && $front_dateFrom!="")
	$str.=" and  date(cih.dtmSailingDate) between  '$dateFrom' and '$dateTo'";
	$str.=" order by  cih.strInvoiceNo";
	
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{	
		
		$pldate		 =$row["strSailingDate"];
		$xml_string .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"] . "]]></InvoiceNo>\n";
		$xml_string .= "<Value><![CDATA[" . $row["dblAmount"]   . "]]></Value>\n";
		$xml_string .= "<BuyerAName><![CDATA[" . $row["BuyerAName"]   . "]]></BuyerAName>\n";
		$xml_string .= "<TransportMode><![CDATA[" . $row["strTransportMode"]   . "]]></TransportMode>\n";
		$xml_string .= "<Vessel><![CDATA[" . $row["vessel"]   . "]]></Vessel>\n";
		$xml_string .= "<ETD><![CDATA[" . $row["dtmSailingDate"]   . "]]></ETD>\n";
		$xml_string .= "<ETA><![CDATA[" . $row["dtmETA"]   . "]]></ETA>\n";
		$xml_string .= "<PONo><![CDATA[" . $row["strBuyerPONo"]   . "]]></PONo>\n";
		$xml_string .= "<Meterial><![CDATA[" . $row["strStyleID"]   . "]]></Meterial>\n";
		$xml_string .= "<ISDNo><![CDATA[" . $row["strISDno"]   . "]]></ISDNo>\n";
		$xml_string .= "<GarmentType><![CDATA[" . $row["strDescOfGoods"]   . "]]></GarmentType>\n";
		$xml_string .= "<NoOfCtn><![CDATA[" . $row["intNoOfCTns"]   . "]]></NoOfCtn>\n";
		$xml_string .= "<Qty><![CDATA[" . $row["dblQuantity"]   . "]]></Qty>\n";
		$xml_string .= "<BL><![CDATA[" . $row["strBL"]   . "]]></BL>\n";
		$xml_string .= "<HAWB><![CDATA[" . $row["strHAWB"]   . "]]></HAWB>\n";
		$xml_string .= "<ContNo><![CDATA[" . $row["strContainer"]   . "]]></ContNo>\n";
		$xml_string .= "<ContSize><![CDATA[" . $row["strCTNSize"]   . "]]></ContSize>\n";
		$xml_string .= "<FreightPay><![CDATA[" . $row["strFreightPC"]   . "]]></FreightPay>\n";
		$xml_string .= "<PayTerm><![CDATA[" . $row["strPayTerm"]   . "]]></PayTerm>\n";
		$xml_string .= "<DesCountry><![CDATA[" . $row["strCountry"]   . "]]></DesCountry>\n";
		$xml_string .= "<DesPort><![CDATA[" . $row["strCity"]   . "]]></DesPort>\n";
		$xml_string .= "<Agent><![CDATA[" . $row["Forwader"]   . "]]></Agent>\n";
		$xml_string .= "<ExFTY><![CDATA[" . $row["dtmManufactDate"]   . "]]></ExFTY>\n";
		$xml_string .= "<DateOfExport><![CDATA[" . $row["dtmSailingDate"]   . "]]></DateOfExport>\n";
		$xml_string .= "<Month><![CDATA[" . $row["Month"]   . "]]></Month>\n";
		
		$xml_string .= "<DocumentDueDate><![CDATA[" . $row["dtmDocumentDueDate"]   . "]]></DocumentDueDate>\n";
		$xml_string .= "<DocumentSubDate><![CDATA[" . $row["dtmDocumentSubDate"]   . "]]></DocumentSubDate>\n";
		$xml_string .= "<PaymentDueDate><![CDATA[" . $row["dtmPaymentDueDate"]   . "]]></PaymentDueDate>\n";
		$xml_string .= "<PaymentSubDate><![CDATA[" . $row["dtmPaymentSubDate"]   . "]]></PaymentSubDate>\n";
		$xml_string .= "<FileNo><![CDATA[" . $row["strFileNo"]   . "]]></FileNo>\n";
		$xml_string .= "<ExportNo><![CDATA[" . $row["strExportNo"]   . "]]></ExportNo>\n";
		$xml_string .= "<EntryNo><![CDATA[" . $row["strEntryNo"]   . "]]></EntryNo>\n";
		$xml_string .= "<CBM><![CDATA[" . $row["dblCBM"]   . "]]></CBM>\n";
			
	} 
	$xml_string.='</data>';
	echo $xml_string;
	
}

if ($request=='load_po_str')
{
	$buyerstr="select distinct strStyle from shipmentplheader order by strStyle";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
				$po_arr.=$buyerrow['strStyle']."|";
				 
			}
			echo $po_arr;
}
?>