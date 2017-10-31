<?php
 session_start();
include "../../../Connector.php";
$backwardseperator = "../../../";

$mainId		= $_GET["mainId"];
$subId		= $_GET["subId"];
$matItem	= $_GET["maiItem"];
$color		= $_GET["color"];
$size		= $_GET["size"];
$style		= $_GET["style"];
$mainStores	= $_GET["mainStores"];
$with0		= $_GET["with0"];
$x			= $_GET["x"];
$CompanyID  	= $_SESSION["FactoryID"];
$withLeftVal = $_GET["withLeftVal"];
$report_companyId = $CompanyID;

//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../../excel/Classes/PHPExcel.php';
require_once '../../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$file = 'subcategory.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}

//$i=4;
$i = 3;
$y = 0;
$objPHPExcel = PHPExcel_IOFactory::load($file);

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
		
if($x == 'all' || $x == "running")
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Stock Balance");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Value");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Not Trim Inspected Qty");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Value");
}

if($x == 'all' || $x == "bulk")
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Bulk Stock Balance");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Value");
}

if($x == 'all' || $x == "leftOvers")
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Leftover Stock Balance");
	if($withLeftVal=='true')
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Value");
}   
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Total Qty");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Total Value");
	
	  $sql = "(select ms.StrCatName,ms.intSubCatNo,sum(st.dblQty) as StockQty,
	(select  sum(stt.dblQty)
	from  stocktransactions_temp stt   inner join matitemlist mil on stt.intMatDetailId= mil.intItemSerial
	inner join grnheader gh on gh.intGrnNo= stt.intGrnNo and gh.intGRNYear=stt.intGrnYear
	 inner join matsubcategory mss on mss.intSubCatNo = mil.intSubCatID 
	where stt.strType='GRN' and gh.intStatus=1   
	and stt.intMatDetailId= mil.intItemSerial and mss.intSubCatNo =ms.intSubCatNo";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and stt.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and stt.intStyleId = '$style'";
	if($color != "")
		$sql .= " and stt.strColor = '$color'";
	if($size != "")
		$sql .= " and stt.strSize = '$size'";
		
	$sql .= " ) as tempQty,
	(select  sum(st.dblQty)
	from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
	 inner join matsubcategory msb on msb.intSubCatNo = mil.intSubCatID 
	where msb.intSubCatNo = ms.intSubCatNo ";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";	
		
	$sql .= " ) as bulkQty,
	(select  sum(st.dblQty)
	from  stocktransactions_leftover st  inner join matitemlist mil on st.intMatDetailId= mil.intItemSerial
	 inner join matsubcategory msl on  msl.intSubCatNo = mil.intSubCatID 
	where msl.intSubCatNo=ms.intSubCatNo ";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";	
		
	$sql .= " ) as leftoverQty
	from matsubcategory ms inner join matitemlist mil on
	ms.intSubCatNo = mil.intSubCatID 
	inner join stocktransactions st on st.intMatDetailId= mil.intItemSerial
	where st.strMainStoresID>0 ";
	
	//start check running stock conditions (stocktransactions) 
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";	
	//end check running stock conditions (stocktransactions) 					
	$sql .= " group by ms.StrCatName)
	union 
	(
	select  mss.StrCatName,mss.intSubCatNo,0,sum(st.dblQty) as StockQty,0,0
	from  stocktransactions_temp st   inner join matitemlist mil on st.intMatDetailId= mil.intItemSerial
	inner join grnheader gh on gh.intGrnNo= st.intGrnNo and gh.intGRNYear=st.intGrnYear
	 inner join matsubcategory mss on mss.intSubCatNo = mil.intSubCatID 
	where st.strType='GRN' and gh.intStatus=1 ";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
		
	$sql .= " and mss.intSubCatNo not in
	(
	select ms.intSubCatNo from matsubcategory ms inner join matitemlist mil on
	ms.intSubCatNo = mil.intSubCatID 
	inner join stocktransactions st on st.intMatDetailId= mil.intItemSerial
	where st.strMainStoresID>0 ";
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
	$sql .=" ) 
	group by mss.StrCatName 
	)
	union 
	(
	select  ms.StrCatName,ms.intSubCatNo,0,0,sum(st.dblQty) as StockQty,0
	from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
	 inner join matsubcategory ms on ms.intSubCatNo = mil.intSubCatID 
	where st.strMainStoresID>0 ";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId' ";
		
	$sql .= " and ms.intSubCatNo not in (select ms.intSubCatNo from matsubcategory ms inner join matitemlist mil on
	ms.intSubCatNo = mil.intSubCatID 
	inner join stocktransactions st on st.intMatDetailId= mil.intItemSerial
	where st.strMainStoresID>0 ";
	
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	$sql .= " ) ";	
	$sql .= " group by ms.StrCatName 
	)
	union 
	(
	select  ms.StrCatName,ms.intSubCatNo,0,0,0,sum(st.dblQty) as StockQty
	from  matitemlist mil inner join stocktransactions_leftover st on st.intMatDetailId= mil.intItemSerial
	 inner join matsubcategory ms on ms.intSubCatNo = mil.intSubCatID 
	where st.strMainStoresID>0 "; 
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
	$sql .= " and ms.intSubCatNo not in (select ms.intSubCatNo from matsubcategory ms inner join matitemlist mil on
	ms.intSubCatNo = mil.intSubCatID 
	inner join stocktransactions st on st.intMatDetailId= mil.intItemSerial" ;
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
	$sql .= " )
	group by ms.StrCatName 
	)
	order by StrCatName";
	$result = $db->RunQuery($sql);
	$totQty =0;
	$totValue =0;
	 $i++;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1,mysql_num_rows($result)-1);	
	while($row = mysql_fetch_array($result))
	{
		$subCatTotQty=0;
		$y = 0;
		$subcatStockValue = getSubcategoryStockValue($row["intSubCatNo"],'stocktransactions',$mainStores,$style,$color,$size);
		$tempValue = getSubcategoryStockValue($row["intSubCatNo"],'stocktransactions_temp',$mainStores,$style,$color,$size);
		$bulkValue = getSubcategoryStockValue($row["intSubCatNo"],'stocktransactions_bulk',$mainStores,$style,$color,$size);
		$leftoverValue = getSubcategoryStockValue($row["intSubCatNo"],'stocktransactions_leftover',$mainStores,$style,$color,$size);
		
		
		$totStockQty += $row["StockQty"];
		$totStockVal += $subcatStockValue;
		$totTempQty += $row["tempQty"];
		$totTempValue += $tempValue;
		$totBulkQty += $row["bulkQty"];
		$totBulkValue += $bulkValue;
		$totLQty += $row["leftoverQty"];
		$totLValue += $leftoverValue;
		
		switch($x)
			{
				case 'all':
				{
					$subCatTotQty= $row["StockQty"]+$row["tempQty"]+$row["bulkQty"]+$row["leftoverQty"];
					$subcatTotValue = $subcatStockValue + $tempValue +$bulkValue;
					if($withLeftVal=='true')
						$subcatTotValue += $leftoverValue;
					break;
				}
				case 'running':
				{
					$subCatTotQty= $row["StockQty"]+$row["tempQty"];
					$subcatTotValue = $subcatStockValue + $tempValue;
					break;
				}
				case 'leftOvers':
				{
					$subCatTotQty= $row["leftoverQty"];
					$subcatTotValue = $leftoverValue;					
					break;
				}
				case 'bulk':
				{
					$subCatTotQty= $row["bulkQty"];
					$subcatTotValue = $bulkValue;
					break;
				}
			}	
		
		$totQty += $subCatTotQty;
		$totValue += $subcatTotValue;

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row["StrCatName"]);
		if($x == 'all' || $x == "running")
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row["StockQty"],2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($subcatStockValue,4));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row["tempQty"],2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($tempValue,2));
		}
		
		if($x == 'all' || $x == "bulk")
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row["bulkQty"],2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($bulkValue,4));
		}
		
		if($x == 'all' || $x == "leftOvers")
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row["leftoverQty"],2));
			if($withLeftVal=='true')
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($leftoverValue,4));
		}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($subCatTotQty,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($subcatTotValue,4));		 
		 $i++;
	 } 
	 	$y=0;
		//$i;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,"Grand Total");
		if($x == 'all' || $x == "running")
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totStockQty,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totStockVal,4));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totTempQty,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totTempValue,4));
		}
		
		if($x == 'all' || $x == "bulk")
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totBulkQty,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totBulkValue,4));
		}
		
		if($x == 'all' || $x == "leftOvers")
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totLQty,2));
			if($withLeftVal=='true')
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totLValue,4));
		}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totQty,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($totValue,4));
			 
function getSubcategoryStockValue($subcategoryId,$tbl,$mainStores,$style,$color,$size)
{
	global $db;
	if($tbl != 'stocktransactions_bulk')
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intGrnNo,st.intGrnYear ,st.intStyleId,st.strGRNType,st.strColor,st.strSize
from  matitemlist mil inner join $tbl st on st.intMatDetailId= mil.intItemSerial";
		if($tbl == 'stocktransactions_temp')
			$sql .= " inner join grnheader gh on gh.intGrnNo= st.intGrnNo and gh.intGRNYear=st.intGrnYear and gh.intStatus=1 and st.strType='GRN' ";
		$sql .= " where mil.intSubCatID='$subcategoryId'";
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
		$sql .=" group by st.intMatDetailId,st.intGrnNo,st.intGrnYear,intStyleId,st.strGRNType,st.strColor,st.strSize
having qty>0 ";
//echo $sql;
	}
	else
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intBulkGrnNo as intGrnNo,st.intBulkGrnYear as intGrnYear,'style' as intStyleId, 'B' as strGRNType,st.strColor,st.strSize 
from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
 where mil.intSubCatID='$subcategoryId' ";
 		if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
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
		$sql = " select distinct gd.dblInvoicePrice as grnprice,gh.dblExRate as exRate
from grnheader gh inner join grndetails gd on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intGrnNo='$grnNo' and gh.intGRNYear='$grnYear' and gd.intMatDetailID='$matdetailID' 
 and gd.strColor ='$color' and  gd.strSize = '$size' ";
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