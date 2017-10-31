<?php
session_start();
include "../../../Connector.php" ;

$mainId				= $_GET["mainId"];
$subId				= $_GET["subId"];
$matItem			= $_GET["maiItem"];
$color				= $_GET["color"];
$size				= $_GET["size"];
$style				= $_GET["style"];
$mainStores			= $_GET["mainStores"];
$with0				= $_GET["with0"];
$x					= $_GET["x"];
$dfrom				= $_GET["dfrom"];
$dTo				= $_GET["dTo"];
$CompanyID  		= $_SESSION["FactoryID"];
$report_companyId 	= $CompanyID;
$checkDate  		= $_GET["checkDate"];
$OrderType = $_GET["OrderType"];
$withLeftVal = $_GET["withLeftVal"];
	
error_reporting(E_ALL);
require_once '../../../excel/Classes/PHPExcel.php';
require_once '../../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$file = 'styleSummeryReport.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$objPHPExcel = PHPExcel_IOFactory::load($file);
$i = 4;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,"STYLE WISE STOCK SUMMERY BALANCE REPORT ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,"Date From : $dfrom To : $dTo ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,"No");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,3,"Stores");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,3,"Buyer PO No");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,3,"Description");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,3,"Color");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,3,"Size");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,3,"Supplier");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,3,"Unit");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,3,"Book Balance as At $dTo ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,3,"Currency");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,3,"Unit Price");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,3,"Book Balance Value as At $dTo ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,3,"Nature");
  $value=0;
  if($x=='leftOvers')
			$tbl = 'stocktransactions_leftover';
		else
			$tbl = 'stocktransactions';	
   //get item nature
   if($x=='leftOvers')
		$nature = 'LeftOver';
	else if($x=='running')	
		$nature = 'Running';
	   
	  $sql = "(SELECT ST.intStyleId,strOrderNo, MIL.strItemDescription, ST.strColor, ST.strSize, round(sum(ST.dblQty),4) as balanceQty,
ST.intGrnNo,ST.intGrnYear,ST.strGRNType, ST.intMatDetailId,ms.strName,ST.strUnit,1 as nature 
FROM $tbl ST 
Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId 
inner join orders O ON O.intStyleId = ST.intStyleId
inner join mainstores ms on ms.strMainID = ST.strMainStoresID
where ST.strMainStoresID>0 ";
	
	if($checkDate == 'true')
	{
		$sql .=" and date(ST.dtmDate) between '$dfrom' and '$dTo' ";		
	}
	if($mainStores != '')
		$sql .=" and ST.strMainStoresID =$mainStores ";			
	if($mainId!='')
		$sql .=" and intMainCatID =$mainId ";	
	if($subId!='')
		$sql .=" and intSubCatID =$subId ";
	if($matItem!='')
		$sql .=" and intMatDetailId =$matItem ";	
	if($color!='')
		$sql .=" and strColor ='$color' ";
	if($size!='')
		$sql .=" and strSize ='$size' ";	
	if($style!='')
		$sql .=" and ST.intStyleId ='$style' ";	
	if($x=='running')
		$sql .=" and O.intStatus not in (13,14) ";
	if($OrderType !='')
			$sql .= " and O.intOrderType ='$OrderType' ";		
	/*if($x=='leftOvers')
		$sql .=" and O.intStatus=13 ";*/	
	$sql .= "GROUP BY ST.intStyleId,ST.intMatDetailId,ST.strColor,ST.strSize,ST.intGrnNo,ST.intGrnYear,ST.strGRNType ";
	if($with0=='true')
		$sql .= "having balanceQty>=0 )";
	else
		$sql .= "having balanceQty>0 )";
	if($x == 'all')
	{
		 $sql .= " union (SELECT ST.intStyleId,strOrderNo, MIL.strItemDescription, ST.strColor, ST.strSize, round(sum(ST.dblQty),4) as balanceQty,
ST.intGrnNo,ST.intGrnYear,ST.strGRNType, ST.intMatDetailId,ms.strName,ST.strUnit,0 as nature
FROM stocktransactions_leftover ST 
Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId 
inner join orders O ON O.intStyleId = ST.intStyleId
inner join mainstores ms on ms.strMainID = ST.strMainStoresID
where  ST.strMainStoresID>0  ";
	
	if($checkDate == 'true')
	{
		$sql .=" and date(ST.dtmDate) between '$dfrom' and '$dTo' ";		
	}
	if($mainStores != '')
		$sql .=" and ST.strMainStoresID =$mainStores ";			
	if($mainId!='')
		$sql .=" and intMainCatID =$mainId ";	
	if($subId!='')
		$sql .=" and intSubCatID =$subId ";
	if($matItem!='')
		$sql .=" and intMatDetailId =$matItem ";	
	if($color!='')
		$sql .=" and strColor ='$color' ";
	if($size!='')
		$sql .=" and strSize ='$size' ";	
	if($style!='')
		$sql .=" and ST.intStyleId ='$style' ";	
	if($OrderType !='')
			$sql .= " and O.intOrderType ='$OrderType' ";		
	$sql .= "GROUP BY ST.intStyleId,ST.intMatDetailId,ST.strColor,ST.strSize,ST.intGrnNo,ST.intGrnYear,ST.strGRNType ";
	if($with0=='true')
		$sql .= "having balanceQty>=0 )";
	else
		$sql .= "having balanceQty>0 )";
	}
	
	$sql .= " order by intStyleId,strItemDescription"	;
	$result = $db->RunQuery($sql);
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1,mysql_num_rows($result)-1);	
	while($row=mysql_fetch_array($result))
	{
		$y = 0;
		$matDetailId = $row["intMatDetailId"];
		$grnNo = $row["intGrnNo"];
		$grnYear = $row["intGrnYear"];
		$value=0;
		$intStyleId = $row["intStyleId"];
		if($x=='all')
		{
			$itemNature = $row["nature"];
			switch($itemNature)
			{
				case 0:
				{
					$nature = 'LeftOver';
					break;
				}
				case 1:
				{
					$nature = 'Running';
					break;
				}
			}
		}
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["intMatDetailId"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strName"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strOrderNo"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strItemDescription"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strColor"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strSize"]);
		
		if($row["strGRNType"] == 'S')
		{
			$sqlSup = "select distinct s.strTitle,gd.dblInvoicePrice,c.strCurrency,gh.dblExRate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$grnNo' and gd.intGRNYear='$grnYear'  and gd.intMatDetailID='$matDetailId' and gd.strColor='".$row["strColor"]."' and  gd.strSize = '".$row["strSize"]."' ";

			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier 	= $rowSup["strTitle"];
			$currency 	= $rowSup["strCurrency"];
			$unitPrice 	= $rowSup["dblInvoicePrice"];
			$exRate 	= $rowSup["dblExRate"];
		}
		else if($row["strGRNType"] == 'B')
		{
			$sqlSup = "select s.strTitle,gd.dblRate,c.strCurrency,gh.dblRate as exRate
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$grnNo' and gd.intYear='$grnYear'  and gd.intMatDetailID='$matDetailId' and gd.strColor='".$row["strColor"]."' and  gd.strSize = '".$row["strSize"]."' ";
			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier 	= $rowSup["strTitle"];
			$currency 	= $rowSup["strCurrency"];
			$unitPrice 	= $rowSup["dblRate"];
			$exRate 	= $rowSup["exRate"];
			
		}
		$value = $row["balanceQty"]*$unitPrice/$exRate;
		
		//open stock leftover do not have po,grn details
		if($grnNo<20)
		{
			//$supplier = '&nbsp;';
			$supplier = 'Leftover uploaded from old ERP';
			$currency = '-';
			$unitPrice = '-';
			$value=0;
		}
		if(!($withLeftVal=='true') && $nature=='LeftOver')
			$value=0;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$supplier);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strUnit"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row["balanceQty"],4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$currency);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($unitPrice,4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($value,4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$nature);
		$i++;
		$grandTotal += round($row["balanceQty"],4);
		$grandTotalValue += round($value,4);
		$grandTotalUP += round($unitPrice,4);
	}
	
//BEGIN - Not trim inspection part
	  //get not trim inspected items from stock temp - confirmed GRN 
  if($x!='leftOvers')
  {
	  $sql_temp .= " SELECT ST.intStyleId,strOrderNo, MIL.strItemDescription, ST.strColor, ST.strSize, round(sum(ST.dblQty),4) as balanceQty,
ST.intGrnNo,ST.intGrnYear,ST.strGRNType, ST.intMatDetailId,ms.strName,ST.strUnit
FROM stocktransactions_temp ST 
Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId 
inner join orders O ON O.intStyleId = ST.intStyleId
inner join mainstores ms on ms.strMainID = ST.strMainStoresID
inner join grnheader gh on gh.intGrnNo= ST.intGrnNo and gh.intGRNYear=ST.intGrnYear
where  strType='GRN' and gh.intStatus=1 ";
	
	if($checkDate == 'true')
		$sql_temp .= " and  date(ST.dtmDate) between '$dfrom' and '$dTo' "; 
	if($mainStores != '')
		$sql_temp .=" and ST.strMainStoresID =$mainStores ";			
	if($mainId!='')
		$sql_temp .=" and intMainCatID =$mainId ";	
	if($subId!='')
		$sql_temp .=" and intSubCatID =$subId ";
	if($matItem!='')
		$sql_temp .=" and intMatDetailId =$matItem ";	
	if($color!='')
		$sql_temp .=" and strColor ='$color' ";
	if($size!='')
		$sql_temp .=" and strSize ='$size' ";	
	if($style!='')
		$sql_temp .=" and ST.intStyleId ='$style' ";	
	if($OrderType !='')
		$sql_temp .= " and O.intOrderType ='$OrderType' ";		
	$sql_temp .= " GROUP BY ST.intStyleId,ST.intMatDetailId,ST.strColor,ST.strSize,ST.intGrnNo,ST.intGrnYear,ST.strGRNType ";
	if($with0=='true')
		$sql_temp .= " having balanceQty>=0 ";
	else
		$sql_temp .= " having balanceQty>0 ";
	
	$sql_temp .= " order by ST.intStyleId,MIL.strItemDescription"	;	
	//echo $sql_temp;
	$result_T = $db->RunQuery($sql_temp);
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($i,mysql_num_rows($result_T));	
	while($rowT=mysql_fetch_array($result_T))
	{
		$y=0;
		$matDetailId = $rowT["intMatDetailId"];
		$grnNo = $rowT["intGrnNo"];
		$grnYear = $rowT["intGrnYear"];
		$value=0;
		$nature = 'Not Trim inspected';
		$intStyleId = $rowT["intStyleId"];

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$rowT["intMatDetailId"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$rowT["strName"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$rowT["strOrderNo"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$rowT["strItemDescription"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$rowT["strColor"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$rowT["strSize"]);
		

		if($rowT["strGRNType"] == 'S')
		{
			$sqlSup = "select s.strTitle,gd.dblInvoicePrice,c.strCurrency,gh.dblExRate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$grnNo' and gd.intGRNYear='$grnYear'  and gd.intMatDetailID='$matDetailId' and gd.strColor='".$rowT["strColor"]."' and  gd.strSize = '".$rowT["strSize"]."'  and gd.intStyleId = '$intStyleId'";
			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblInvoicePrice"];
			$exRate = $rowSup["dblExRate"];
		}
		else if($rowT["strGRNType"] == 'B')
		{
			$sqlSup = "select s.strTitle,gd.dblRate,c.strCurrency,gh.dblRate as exRate
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$grnNo' and gd.intYear='$grnYear'  and gd.intMatDetailID='$matDetailId' and gd.strColor='".$rowT["strColor"]."' and  gd.strSize = '".$rowT["strSize"]."' ";

			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblRate"];
			$exRate = $rowSup["exRate"];
			
		}
		$value = $rowT["balanceQty"]*$unitPrice/$exRate;
		
		//open stock leftover do not have po,grn details
		if($grnNo<20)
		{
			$supplier = 'Leftover uploaded from old ERP';
			$currency = '-';
			$unitPrice = '-';
			$value=0;
		}
		
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$supplier);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$rowT["strUnit"]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($rowT["balanceQty"],4));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$currency);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($unitPrice,4));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($value,4));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$nature);
	  		$i++;
			$grandTotal += round($rowT["balanceQty"],4);
			$grandTotalValue += round($value,4);
			$grandTotalUP += round($unitPrice,4);
	} 
}	
	$y = 0;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i,1);	
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Grand Total");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$grandTotal);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$grandTotalUP);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$grandTotalValue);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
//END
	
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;
?>