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
	$filter				=$_GET["filter"];
	$invoice_No			=$_GET["invoice_No"];
	$Location			=$_GET["Location"];
		
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];
	
	$str = "select
	cih.strInvoiceNo,
	cih.strCarrier,
	cih.strVoyegeNo,
	date(cih.dtmSailingDate) as dtmSailingDate,
	cih.dtmETA,
	buyers.strName, 
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
	cid.strFileNum,
	cid.strLotNum,
	
	fi.strExportNo,
	cid.strEntryNo,
	cid.strFabric,
	customers.strCustomerID,
	customers.strMLocation,
	
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
LEFT JOIN customers ON cih.strCompanyID = customers.strCustomerID
LEFT JOIN buyers ON cih.strBuyerID =buyers.strBuyerID where cih.strInvoiceNo!=''";


if($Reg_type!="" )
	$str.=" and  cih.strInvoiceType = '$Reg_type'";
	
if($filter==1)	
	$str.=" and  cih.strInvoiceNo = '$invoice_No'";
	
if($filter==2)	
	$str.=" and  cid.strBuyerPONo = '$invoice_No'";
	
if($filter==3)	
	$str.=" and  cid.strStyleID = '$invoice_No'";
	
	
if($filter==4)	
	$str.=" and buyers.strName = '$invoice_No'";
	
if($filter==6)	
	$str.=" and cid.strLotNum  = '$invoice_No'";
	
if($Location==4)	
	$str.=" and customers.strCustomerID = '4'";
	
if($Location==5)	
	$str.=" and customers.strCustomerID = '5'";
	
if($Location==6)	
	$str.=" and customers.strCustomerID = '6'";
	
if($Location==7)	
	$str.=" and customers.strCustomerID = '7'";
	
if($Location==8)	
	$str.=" and customers.strCustomerID = '8'";
	
if($Location==9)	
	$str.=" and customers.strCustomerID = '9'";
	
if($Location==10)	
	$str.=" and customers.strCustomerID = '10'";
	
if($Location==11)	
	$str.=" and customers.strCustomerID = '11'";
	
if($Location==12)	
	$str.=" and customers.strCustomerID = '12'";

if($front_dateTo!="" && $front_dateFrom!="")
	$str.=" and  date(cih.dtmSailingDate) between  '$dateFrom' and '$dateTo'";
	$str.=" order by  cih.strInvoiceNo";
	
	$result=$db->RunQuery($str);
	//echo $str;
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{	
		 $invNo=$row["strInvoiceNo"];
		$sql_st="SELECT cdn_header.intCancel,
				cdn_header.intCDNConform,
				cdn_header.strInvoiceNo
				FROM
				cdn_header
				WHERE
				cdn_header.strInvoiceNo = '$invNo'";
				
				$result_st=$db->RunQuery($sql_st);
				
				
				while($row_st=mysql_fetch_array($result_st))
			{	
				if($row_st['intCancel']!=0)
					{
					 $status="Cancel";
					}
				else if($row_st['intCDNConform']!=0)
					{
					 $status="Confirm";
					}
				else 
					{
					 $status="pending";
					}
			
				
			//echo $status;
		
		$pldate		 =$row["strSailingDate"];
		$xml_string .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"] . "]]></InvoiceNo>\n";
		$xml_string .= "<status><![CDATA[" . $status. "]]></status>\n";
		$xml_string .= "<Value><![CDATA[" . $row["dblAmount"]   . "]]></Value>\n";
		$xml_string .= "<BuyerAName><![CDATA[" . $row["strName"]   . "]]></BuyerAName>\n";
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
		$xml_string .= "<Fabric><![CDATA[" . $row["strFabric"]   . "]]></Fabric>\n";
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
		$xml_string .= "<FileNo><![CDATA[" . $row["strFileNum"]   . "]]></FileNo>\n";
		$xml_string .= "<LotNo><![CDATA[" . $row["strLotNum"]   . "]]></LotNo>\n";
		
		$xml_string .= "<ExportNo><![CDATA[" . $row["strExportNo"]   . "]]></ExportNo>\n";
		$xml_string .= "<EntryNo><![CDATA[" . $row["strEntryNo"]   . "]]></EntryNo>\n";
		$xml_string .= "<CBM><![CDATA[" . $row["dblCBM"]   . "]]></CBM>\n";
			
		}	
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



if($request=='loadCDNPo')
{
	$sql="SELECT DISTINCT commercial_invoice_detail.strBuyerPONo FROM commercial_invoice_detail ORDER BY commercial_invoice_detail.strBuyerPONo";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$po_arr.=$row['strBuyerPONo']."|";
				 
	}
	echo $po_arr;
	
}


if($request=='loadCDNInv')
{
	$sql="SELECT DISTINCT strInvoiceNo FROM commercial_invoice_detail order by strInvoiceNo";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$inv_arr.=$row['strInvoiceNo']."|";
				 
	}
	echo $inv_arr;
	
}


if($request=='loadCDNstyle')
{
			$sql=" SELECT DISTINCT
			commercial_invoice_detail.strStyleID
			FROM
			commercial_invoice_detail order by strStyleID";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styl_arr.=$row['strStyleID']."|";
				 
	}
	echo $styl_arr;
	
}





if($request=='loadInv')
{
	$invNo= $_GET['invoice_No'];
	 $sql_inv="SELECT DISTINCT commercial_invoice_detail.strInvoiceNo FROM commercial_invoice_detail WHERE strInvoiceNo = '$invNo'";
	$result_inv=$db->RunQuery($sql_inv);
	$row=mysql_fetch_array($result_inv);
	
	if(mysql_num_rows($result_inv)>0)
		echo $row['strInvoiceNo'];
	else
		echo "fail";
}



if($request=='loadpo_No')
{
	$po_No= $_GET['po_No'];
    $sql_po="SELECT DISTINCT commercial_invoice_detail.strBuyerPONo FROM commercial_invoice_detail WHERE strBuyerPONo = '$po_No'";
	$result_po=$db->RunQuery($sql_po);
	$row=mysql_fetch_array($result_po);
	
	if(mysql_num_rows($result_po)>0)
		echo $row['strBuyerPONo'];
	else
		echo "fail";
}




if($request=='loadtxtStyleNo')
{
	$StyleNo= $_GET['StyleNo'];
    $sql_style="SELECT DISTINCT commercial_invoice_detail.strStyleID FROM commercial_invoice_detail WHERE strStyleID = '$StyleNo'";
	$result_style=$db->RunQuery($sql_style);
	$row=mysql_fetch_array($result_style);
	
	if(mysql_num_rows($result_style)>0)
		echo $row['strStyleID'];
	else
		echo "fail";
}



if($request=='loadbuyer')
{
			 $sql=" SELECT 
					buyers.strName
					FROM
					buyers
					GROUP BY
					buyers.strName";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$byr_arr.=$row['strName']."|";
				 
	}
	echo $byr_arr;
	
}


if($request=='loadbuyer')
{
	$StyleNo= $_GET['StyleNo'];
    $sql_style="SELECT DISTINCT commercial_invoice_detail.strStyleID FROM commercial_invoice_detail WHERE strStyleID = '$StyleNo'";
	$result_style=$db->RunQuery($sql_style);
	$row=mysql_fetch_array($result_style);
	
	if(mysql_num_rows($result_style)>0)
		echo $row['strStyleID'];
	else
		echo "fail";
}

if($request=='savefileno')
{
 $File_No=$_GET['File_No'];
 $invNo=$_GET['invNo'];
$lotNo=$_GET['lotNo'];
 $PoNo=$_GET['PoNo'];
	  $sql_file="UPDATE commercial_invoice_detail
					SET
					commercial_invoice_detail.strFileNum='$File_No',	
					commercial_invoice_detail.strLotNum='$lotNo'
					WHERE
					commercial_invoice_detail.strInvoiceNo='$invNo'";
	$result_file=$db->RunQuery($sql_file);									
								
}


if($request=='loadlotNo')
{
			 $sql="SELECT
					commercial_invoice_detail.strLotNum
					FROM
					commercial_invoice_detail
					GROUP BY
					commercial_invoice_detail.strLotNum";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$byr_arr.=$row['strLotNum']."|";
				 
	}
	echo $byr_arr;
	
}



if($request=='loadlotNoToGrid')
{
	$lotNo= $_GET['lotNo'];
 $sql_lot="SELECT DISTINCT commercial_invoice_detail.strLotNum FROM commercial_invoice_detail WHERE strLotNum = '$lotNo'";
	$result_lot=$db->RunQuery($sql_lot);
	$row=mysql_fetch_array($result_lot);
	
	if(mysql_num_rows($result_lot)>0)
		echo $row['strLotNum'];
	else
		echo "fail";
}
?>