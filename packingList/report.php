<?php
session_start();
include "../Connector.php";

//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../excel/Classes/PHPExcel.php';
require_once '../excel/Classes/PHPExcel/IOFactory.php';


// 		get db data 
$packingListNo 	= '10051';
$buyerId		= 1;

$sql 			= "select * from packinglistheader where intPackingListNo='$packingListNo'";
$result 		= $db->open($sql);
while($row=mysql_fetch_array($result))
{
	$strStyleId = $row["intStyleId"];
}

//		get template
$file = 'templates/temp1.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$objPHPExcel = PHPExcel_IOFactory::load($file);
//////////////////////////////////////////////// end of load template //////////////////////////////////
$arrColumn 			= array();
$arrColumnIndex 	= array();
$arrRow 			= array();
$pub_dataStartRow	= '';
$pub_sizeCount		=0;

	
////////////////////////////////////////////////////////////////////////////////////////////////////////
setStyleId($strStyleId);
setSize();
addRows();

setCTNNo();
//setColor();


function setCTNNo()
{
	global $objPHPExcel;
	global $arrColumn;
	global $arrColumnIndex;
	global $arrRow;
	global $pub_dataStartRow;
	global $pub_sizeCount;
	
	$rec = getGridRecord(' intFromCtn , intToCtn ');
	while($row=mysql_fetch_array($rec))
	{
		//cartons no
		$noOfCtns = ((int)$row['intToCtn']-(int)$row['intFromCtn']+1);
		
		setArray('gridCtnNo');
		$value = $row['intFromCtn'].' - '.$row['intToCtn'];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($arrColumnIndex[0],$pub_dataStartRow+$i,$value);
		
		//color
		setArray('gridColor');
		$value = $row['strColor'];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($arrColumnIndex[0],$pub_dataStartRow+$i,$value);
		
		//No of cartons
		setArray('gridNoOfCtn');
		$value = $noOfCtns;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($arrColumnIndex[0],$pub_dataStartRow+$i,$value);
		
		//pcs/ctns
		setArray('gridPcsPerCtns');
		$value = $row['dblPscCtn'];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($arrColumnIndex[0],$pub_dataStartRow+$i,$value);
		
		//Total Qty
		setArray('gridTotalQty');
		$value = $row['dblTotal'];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((int)$arrColumnIndex[0]+$pub_sizeCount-1,$pub_dataStartRow+$i,$value);
		
		//Net Net Wgt
		setArray('gridNetNetWgt');
		$value = $row['dblNetNetWgt'];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((int)$arrColumnIndex[0]+$pub_sizeCount-1,$pub_dataStartRow+$i,$value);
		
		//Net  Wgt
		setArray('gridNetWgt');
		$value = $row['dblNetWgt'];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((int)$arrColumnIndex[0]+$pub_sizeCount-1,$pub_dataStartRow+$i,$value);
		
		//Net Net Wgt
		setArray('gridGrossWgt');
		$value = $row['dblGrossWgt'];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((int)$arrColumnIndex[0]+$pub_sizeCount-1,$pub_dataStartRow+$i,$value);
		
		
		setArray('gridTotalNetWgt');
		$value = $row['dblNetWgt']*$noOfCtns;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((int)$arrColumnIndex[0]+$pub_sizeCount-1,$pub_dataStartRow+$i,$value);
		
		
		setArray('gridTotalGrossWgt');
		$value = $row['dblGrossWgt']*$noOfCtns;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((int)$arrColumnIndex[0]+$pub_sizeCount-1,$pub_dataStartRow+$i,$value);
		
		
		//set size values
		setArray('sizeValue');
		$colorIndex = $row['intColorIndex'];
		$rec2	    = getSizeValues($colorIndex);
		$n=0; 
		while($row2=mysql_fetch_array($rec2))
		{
			$value = $row2['dblQty']*$noOfCtns;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((int)$arrColumnIndex[0]+$n++,$pub_dataStartRow+$i,$value);
		}
		
		$i++;
	}
}

function getSizeValues($index)
{
	global $db;
	global $packingListNo;
	global $objPHPExcel;
	$sql 			= "	SELECT  strSize,dblQty FROM packinglistcartons_size
					WHERE
					packinglistcartons_size.intPackingListNo =  '$packingListNo' and
					intColorIndex=$index ORDER BY packinglistcartons_size.strSize ASC";
					//$objPHPExcel->getActiveSheet()->setCellValue('A4',$sql);
	$result 		= $db->open($sql);
	return $result;
}

function getGridRecord($fields)
{
	global $db;
	global $packingListNo;
	global $objPHPExcel;
	$sql 			= "select * from packinglistcartons where intPackingListNo=$packingListNo";
					//$objPHPExcel->getActiveSheet()->setCellValue('A4',$sql);
	$result 		= $db->open($sql);
	return $result;
}
function addRows()
{
	global $objPHPExcel;
	global $arrColumn;
	global $arrColumnIndex;
	global $arrRow;
	global $pub_dataStartRow;
	
	setArray('dataStart');
	$pub_dataStartRow = $arrRow[0];
	$rec = getCartonsRowCount();
	$rowCount = mysql_num_rows($rec);
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($pub_dataStartRow+1, $rowCount);
}

function getCartonsRowCount()
{
	global $db;
	global $packingListNo;
	global $objPHPExcel;
	$sql 			= "select * from packinglistcartons where intPackingListNo=$packingListNo";
					//$objPHPExcel->getActiveSheet()->setCellValue('A4',$sql);
	$result 		= $db->open($sql);
	return $result;
}
function setSize()
{
	global $db;
	global $buyerId;
	global $objPHPExcel;
	global $arrColumn;
	global $arrColumnIndex;
	global $arrRow;
	global $pub_sizeCount;
	
	setArray('sizeTopHeader');
	$count = count($arrColumn);
	$MainHeadRow = $arrRow[0];
	$arrBeforeHead =array();
	for($i=0;$i<$count;$i++)
	{
		//set main header to array
		$arrBeforeHead[$i] =$objPHPExcel->getActiveSheet()->getCell($arrColumn[0].$arrRow[0])->getValue();
	}
	
	//set array to headers
	setArray('sizeHeader');
	$headCount = count($arrColumn);
	$rec = getSizesDetails();
	$sizeHeaderCount = mysql_num_rows($rec);
	$pub_sizeCount = $sizeHeaderCount;
	$sizeHeaderWidth = $objPHPExcel->getActiveSheet()->getColumnDimension($arrColumn[0])->getWidth();
	
	$intLoop = 0;
	$arrSize = array();
	while($row = mysql_fetch_array($rec))
	{
		$intLoop++;
		$Asize	= $row['strSize'];
		$arrSize [$intLoop-1] = $Asize;
		
		
		if($intLoop==1)
		 	continue;
			
		
		//insert columns
		$objPHPExcel->getActiveSheet()->insertNewColumnBefore($arrColumn[0], 1);
		//set width to inserted columns
		$objPHPExcel->getActiveSheet()->getColumnDimension($arrColumn[0])->setWidth($sizeHeaderWidth);
	}
	$objPHPExcel->getActiveSheet()->mergeCells($arrColumn[0].$MainHeadRow.':'.code((int)$arrColumnIndex[$i]+(int)$sizeHeaderCount).$MainHeadRow);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($arrColumnIndex[0],$MainHeadRow,$arrBeforeHead[0]);
	
	 for($i=0;$i<count($arrSize);$i++)
	 {
	 	for($n=0;$n<count($arrRow);$n++)
		{
	 		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($arrColumnIndex[$n]+$i,$arrRow[$n],$arrSize[$i]);
			$objPHPExcel->getActiveSheet()->getStyle(code($arrColumnIndex[$n]+$i).$arrRow[$n])->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
		}
	 }
		
}

function getSizesDetails()
{
	global $db;
	global $packingListNo;
	global $objPHPExcel;
	$sql 			= "	SELECT DISTINCT packinglistcartons_size.strSize FROM packinglistcartons_size
					WHERE
					packinglistcartons_size.intPackingListNo =  '$packingListNo'
					ORDER BY packinglistcartons_size.strSize ASC";
					//$objPHPExcel->getActiveSheet()->setCellValue('A4',$sql);
	$result 		= $db->open($sql);
	return $result;
}


function setStyleId($styleId)
{
	global $arrColumn ;
	global $arrColumnIndex;
	global $arrRow ;	
	global $db;
	global $objPHPExcel;
	
	setArray('styleId');

	$count = count($arrColumn);
	for($i=0;$i<$count;$i++)
	{
		//$objPHPExcel->getActiveSheet()->setCellValue($arrColumn[$i].$arrRow[$i],$styleId);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($arrColumnIndex[$i], $arrRow[$i], $styleId);
	}
	
}

function setArray($type)
{
	global $db;
	global $arrColumn;
	global $arrColumnIndex;
	global $arrRow;
	global $buyerId;
	global $objPHPExcel;
	$arrColumn =  '';
	$arrColumnIndex =  '';
	$arrRow =   '';
    
	$sql = "SELECT `columnIndex`, `column`, `row` FROM packinglist_map_details WHERE	id =  '$buyerId' and mapType='$type' Order By `column` DESC";
	//$objPHPExcel->getActiveSheet()->setCellValue('A4',$sql);
	$result = $db->open($sql);
	while($row=mysql_fetch_array($result))
	{
		$arrColumn[]=$row['column'];
		$arrColumnIndex[]=$row['columnIndex'];
		$arrRow[]=$row['row'];
	}
}

function code($index)
{
	return chr($index+65);

}
///////////////////////////////////////////////// download file //////////////////////////
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;

?>