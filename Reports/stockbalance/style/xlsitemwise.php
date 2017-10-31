<?php 
session_start();
	include "../../../Connector.php" ;

	$mainId		= $_GET["mainId"];
	$subId		= $_GET["subId"];
	$matItem	= $_GET["maiItem"];
	$color		= $_GET["color"];
	$size		= $_GET["size"];
	$style		= $_GET["style"];
	$mainStores	= $_GET["mainStores"];
	$with0		= $_GET["with0"];
	$x			= $_GET["x"];
	$txtmatItem	= $_GET["txtmatItem"];
	$CompanyID  	= $_SESSION["FactoryID"];
	$OrderType  = $_GET["OrderType"];
	$report_companyId = $CompanyID;
	$withLeftVal = $_GET["withLeftVal"];
	//$checkDate  = $_GET["checkDate"];
	
//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../../excel/Classes/PHPExcel.php';
require_once '../../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$file = 'itemwisestockbalance.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$objPHPExcel = PHPExcel_IOFactory::load($file);

$i = 2;
$y = 0;
$SQL = 	"SELECT  mainstores.strName FROM mainstores where strMainID=$mainStores";
$result = $db->RunQuery($SQL);
while($row = mysql_fetch_array($result))
	$sStores =  $row["strName"];
	
if($sStores=='')
	$sStores = 'All';	
	
switch($x)
{
	case 'all':
	{
		$reportType = 'All';
		break;
	}
	case 'running':
	{
		$reportType = 'Running';
		break;
	}
	case 'leftOvers':
	{
		$reportType = 'Leftover';
		break;
	}
	case 'bulk':
	{
		$reportType = 'Bulk';
		break;
	}
}		
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,1,"STOCK BALANCE REPORT ($sStores) - $reportType ");
		
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Material");				
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Color");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Size");
	
if($x == 'all' || $x == "running")
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Stock Balance");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Value");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Not Trim Inspected Qty");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Value");
}

if($x == 'all' || $x == "leftOvers")
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Leftover Stock Balance");
	if($withLeftVal=='true')
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Value");
}

if($x == 'all' || $x == "bulk")
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Bulk Stock Balance");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Value");
}   
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Total Qty");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Total Value");
	
if($x=='leftOvers')
			$tbl='stocktransactions_leftover';
		else
			$tbl = 'stocktransactions';	
		
		$sql = "(select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize, sum(st.stockQty) as stockQty,
(select sum(temp.tempQty) from tempstock_view temp 
inner join  matitemlist mil on mil.intItemSerial= temp.intMatDetailId
inner join orders o on o.intStyleId = temp.intStyleId
where st.intMatDetailId = temp.intMatDetailId and st.strColor = temp.strColor and st.strSize = temp.strSize ";
		if($mainStores != '')
			$sql .=" and temp.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and temp.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and temp.strColor ='$color' ";
		if($size!='')
			$sql .=" and temp.strSize ='$size' ";	
		if($style!='')
			$sql .=" and temp.intStyleId ='$style' ";
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";
				
		$sql .= " ) as tempQty,
(select sum(sl.leftoverStock) from leftstock_view sl
inner join  matitemlist mil on mil.intItemSerial=  sl.intMatDetailId
inner join orders o on o.intStyleId = sl.intStyleId
 where st.intMatDetailId = sl.intMatDetailId and st.strColor = sl.strColor and st.strSize = sl.strSize ";
		if($mainStores != '')
			$sql .=" and sl.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and sl.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and sl.strColor ='$color' ";
		if($size!='')
			$sql .=" and sl.strSize ='$size' ";	
		if($style!='')
			$sql .=" and sl.intStyleId ='$style' ";
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";
				 
 		$sql .= " ) as leftoverQty,
(select sum(sb.bulkQty) from bulkstock_view sb 
inner join  matitemlist mil on mil.intItemSerial= sb.intMatDetailId
where st.intMatDetailId = sb.intMatDetailId and st.strColor = sb.strColor and st.strSize = sb.strSize ";
		if($mainStores != '')
			$sql .=" and sb.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and sb.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and sb.strColor ='$color' ";
		if($size!='')
			$sql .=" and sb.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		$sql .= " ) as bulkQty
from stock_view st inner join matitemlist mil on mil.intItemSerial= st.intMatDetailId
inner join orders o on o.intStyleId = st.intStyleId 
where st.strMainStoresID>0 ";
		if($mainStores != '')
			$sql .=" and st.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and st.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and st.strColor ='$color' ";
		if($size!='')
			$sql .=" and st.strSize ='$size' ";	
		if($style!='')
			$sql .=" and st.intStyleId ='$style' ";
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";
		$sql .= " group by st.intMatDetailId,st.strColor,st.strSize)
union 
(select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,0,sum(st.tempQty) as tempQty,0,0 
from tempstock_view st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId
inner join orders o on o.intStyleId = st.intStyleId
where st.strMainStoresID>0 ";
		if($mainStores != '')
			$sql .=" and st.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and st.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and st.strColor ='$color' ";
		if($size!='')
			$sql .=" and st.strSize ='$size' ";	
		if($style!='')
			$sql .=" and st.intStyleId ='$style' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";		
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
			
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
inner join orders o on o.intStyleId = stt.intStyleId
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize ";
 		if($mainStores != '')
			$sql .=" and stt.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and stt.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and stt.strColor ='$color' ";
		if($size!='')
			$sql .=" and stt.strSize ='$size' ";	
		if($style!='')
			$sql .=" and stt.intStyleId ='$style' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";		
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .= " ) group by st.intMatDetailId,st.strColor,st.strSize )
	union
 (select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,0,0,sum(leftoverStock) as leftoverStock,0
from leftstock_view st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId
inner join orders o on o.intStyleId = st.intStyleId
where st.strMainStoresID>0 ";
	if($mainStores != '')
			$sql .=" and st.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and st.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and st.strColor ='$color' ";
		if($size!='')
			$sql .=" and st.strSize ='$size' ";	
		if($style!='')
			$sql .=" and st.intStyleId ='$style' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
inner join orders o on o.intStyleId = stt.intStyleId
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize ";
 	if($mainStores != '')
			$sql .=" and stt.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and stt.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and stt.strColor ='$color' ";
		if($size!='')
			$sql .=" and stt.strSize ='$size' ";	
		if($style!='')
			$sql .=" and stt.intStyleId ='$style' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .=" )  group by st.intMatDetailId,st.strColor,st.strSize ) ";
 	$sql .= " union
 (select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,0,0,0,sum(bulkQty) as bulkQty
from bulkstock_view st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId
where st.strMainStoresID>0 ";
	if($mainStores != '')
			$sql .=" and st.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and st.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and st.strColor ='$color' ";
		if($size!='')
			$sql .=" and st.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize ";
 if($mainStores != '')
			$sql .=" and stt.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and stt.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and stt.strColor ='$color' ";
		if($size!='')
			$sql .=" and stt.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .= " ) group by st.intMatDetailId,st.strColor,st.strSize )";
 $sql .= " order by strItemDescription ";

		$result = $db->RunQuery($sql);
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1,mysql_num_rows($result)+1);	
		while($row = mysql_fetch_array($result))
		{
			
			$y = 0;
			$stockQty = round($row["stockQty"],2);
			$tempQty = round($row["tempQty"],2);
			$leftoverQty = round($row["leftoverQty"],2);
			$bulkQty = round($row["bulkQty"],2);
			
			$stockValue =0;
			$tempValue =0;
			$leftoverValue =0;
			$bulkValue=0;
			
			if($stockQty>0)
				$stockValue = getStockValue('stocktransactions',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			if($tempQty>0)	
				$tempValue = getStockValue('stocktransactions_temp',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			if($leftoverQty>0)	
				$leftoverValue = getStockValue('stocktransactions_leftover',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			if($bulkQty>0)	
			$bulkValue = getStockValue('stocktransactions_bulk',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			
			//$totQty = $stockQty + $tempQty + $leftoverQty +$bulkQty; 
			//$totValue = $stockValue + $tempValue +$leftoverValue +$bulkValue;
			
			$totStockQty += $stockQty;
			$totTempQty += $tempQty;
			$totLeftQty += $leftoverQty;
			$totBulkQty += $bulkQty;
			
			
			$totStockValue += $stockValue;
			$totTempValue += $tempValue;
			$totLeftValue += $leftoverValue;
			$totBulkValue += $bulkValue;
			
			
			switch($x)
			{
				case 'all':
				{
					$totQty = $stockQty + $tempQty + $leftoverQty +$bulkQty;
					$totValue = $stockValue + $tempValue  +$bulkValue; 
					if($withLeftVal=='true')
						$totValue += $leftoverValue;		
					break;
				}
				case 'running':
				{
					$totQty = $stockQty + $tempQty;
					$totValue = $stockValue + $tempValue; 	
					break;
				}
				case 'leftOvers':
				{
					$totQty = $leftoverQty;
					$totValue = $leftoverValue;	
					break;
				}
				case 'bulk':
				{
					$totQty = $bulkQty;
					$totValue = $bulkValue;	
					break;
				}
			}	
			
			$grandTotQty += $totQty;
			$grandTotValue += $totValue;
			
			if($totQty ==0 && $with0=='false')
				continue;
			$i++;
				 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strItemDescription"]);
				 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strColor"]);
				 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["strSize"]);
			 
			if($x == 'all' || $x == "running")
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$stockQty == 0? '':round($stockQty,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$stockValue == 0? '':round($stockValue,4));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$tempQty == 0? '':round($tempQty,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$tempValue == 0? '':round($tempValue,4));
			}
			
			if($x == 'all' || $x == "leftOvers")
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$leftoverQty == 0? '':round($leftoverQty,2));
				if($withLeftVal=='true')
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$leftoverValue == 0? '':round($leftoverValue,4));
			}
			
			if($x == 'all' || $x == "bulk")
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$bulkQty == 0? '':round($bulkQty,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$bulkValue == 0? '':round($bulkValue,4));
			}
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totQty == 0? '':round($totQty,4));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totValue == 0? '':round($totValue,4));			
		}
		$y = 0;
		$i++;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Grand Total");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"");
			if($x == 'all' || $x == "running")
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totStockQty == 0? '':round($totStockQty,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totStockValue == 0? '':round($totStockValue,4));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totTempQty == 0? '':round($totTempQty,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totTempValue == 0? '':round($totTempValue,4));
			}
			
			if($x == 'all' || $x == "leftOvers")
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totLeftQty == 0? '':round($totLeftQty,2));
				if($withLeftVal=='true')
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totLeftValue == 0? '':round($totLeftValue,4));
			}
			
			if($x == 'all' || $x == "bulk")
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totBulkQty == 0? '':round($totBulkQty,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$totBulkValue == 0? '':round($totBulkValue,4));
			}
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$grandTotQty == 0? '':round($grandTotQty,4));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$grandTotValue == 0? '':round($grandTotValue,4));
		
function getStockValue($tbl,$matDetailID,$color,$size,$style,$mainStores,$subcategoryId,$OrderType)
{
	global $db;
	if($tbl != 'stocktransactions_bulk')
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intGrnNo,st.intGrnYear ,st.intStyleId,st.strGRNType,st.strColor,st.strSize
from  matitemlist mil inner join $tbl st on st.intMatDetailId= mil.intItemSerial
inner join orders o on o.intStyleId = st.intStyleId ";
		if($tbl == 'stocktransactions_temp')
			$sql .= " inner join grnheader gh on gh.intGrnNo= st.intGrnNo and gh.intGRNYear=st.intGrnYear and gh.intStatus=1 and st.strType='GRN' ";
		$sql .= " where st.intMatDetailId ='$matDetailID'";
	if($subcategoryId != "")
		$sql .= " and  mil.intSubCatID='$subcategoryId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
	if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";
		$sql .=" group by st.intMatDetailId,st.intGrnNo,st.intGrnYear,intStyleId,st.strGRNType,st.strColor,st.strSize
having qty>0 ";
	}
	else
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intBulkGrnNo as intGrnNo,st.intBulkGrnYear as intGrnYear,'style' as intStyleId, 'B' as strGRNType,st.strColor,st.strSize 
from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
 where st.intMatDetailId ='$matDetailID' ";
 		if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
		if($subcategoryId != "")
		$sql .= " and  mil.intSubCatID='$subcategoryId'";	
		if($color != "")
		$sql .= " and st.strColor = '$color'";
		if($size != "")
		$sql .= " and st.strSize = '$size'";
 		$sql .= " group by st.intMatDetailId,intGrnNo,intGrnYear,st.strColor,st.strSize
having qty>0";
	}	
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$grnQty = $row["qty"];
		$grnValue += getGRNValue($grnQty,$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"],$row["intStyleId"],$row["intMatDetailId"],$row["strColor"],$row["strSize"]);
	}
	return round($grnValue,4);
}

function getGRNValue($grnQty,$grnNo,$grnYear,$grnType,$styleID,$matdetailID,$color,$size)
{
	global $db;
	if($grnType == 'S')
	{
		$sql = " select gd.dblInvoicePrice as grnprice,gh.dblExRate as exRate
from grnheader gh inner join grndetails gd on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intGrnNo='$grnNo' and gh.intGRNYear='$grnYear' and gd.intMatDetailID='$matdetailID' 
 and gd.intStyleId='$styleID' and gd.strColor ='$color' and  gd.strSize = '$size' ";
	}
	else if($grnType == 'B')
	{
		$sql = " select gd.dblRate as grnprice,gh.dblRate as exRate
from bulkgrnheader gh inner join bulkgrndetails gd on
gh.intBulkGrnNo = gd.intBulkGrnNo and gh.intYear = gd.intYear
where gh.intBulkGrnNo='$grnNo'  and gh.intYear='$grnYear' and intMatDetailID='$matdetailID' and gd.strColor='$color' and gd.strSize = '$size'";
	}
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$grnValue = $grnQty*$row["grnprice"]/$row["exRate"];
	return $grnValue;
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;
?>