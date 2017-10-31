<?php

session_start();
include "../../Connector.php" ;

$txtDfrom  = $_GET["txtDfrom"];
$txtDto    = $_GET["txtDto"];
$checkDate = $_GET["checkDate"];
$buyer		= $_GET["Buyer"];
$chkDelDate	= $_GET["chkDelDate"];
$delDfrom	= $_GET["delDfrom"];
$delDto		= $_GET["delDto"];

//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$file = 'xclrptOrderBook.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$objPHPExcel = PHPExcel_IOFactory::load($file);

$detailSql="select concat(date_format(O.dtmOrderDate,'%Y%m'),'',O.intCompanyOrderNo)as oritOrderNo,D.strDivision,O.reaFOB,O.dblFacProfit,O.strDescription,O.intStyleId,O.strOrderNo,O.strStyle,O.intQty,O.reaExPercentage,O.reaSMVRate,O.reaSMV from orders O inner join buyerdivisions D on D.intDivisionId=O.intDivisionId ";
if($checkDate=="true")
{
	if($txtDfrom!="")
	{
		$DateFromArray	= explode('/',$txtDfrom);
		$formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
		$detailSql .=" AND date(O.dtmOrderDate)>='$formatedFromDate' ";
	}
	if($txtDto!="")
	{
		$DateToArray	= explode('/',$txtDto);
		$formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
		$detailSql .=" AND date(O.dtmOrderDate)<='$formatedToDate' ";
	}
}

if($chkDelDate=="true")
{
	$detailSql .= " and O.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
	if($delDfrom!="")
	{
		$delDfromArray	= explode('/',$delDfrom);
		$formatedDelDfromArray	= $delDfromArray[2].'-'.$delDfromArray[1].'-'.$delDfromArray[0];
		$detailSql .= "and date(DS.dtDateofDelivery)>='$formatedDelDfromArray' ";
	}
	if($delDto!="")
	{
		$delDToArray	= explode('/',$delDto);
		$formatedDelDToArray	= $delDToArray[2].'-'.$delDToArray[1].'-'.$delDToArray[0];
		$detailSql .= "and date(DS.dtDateofDelivery)<='$formatedDelDToArray' ";
	}
	$detailSql .= ")";
}

if($buyer!="")
	$detailSql .= "and O.intBuyerID='$buyer' ";
	
$detailSql .=" order by O.strOrderNo;";
			
			$detailResult = $db->RunQuery($detailSql);
$i	= 4;
$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1,mysql_num_rows($detailResult)+1);	
while ($details=mysql_fetch_array($detailResult))
{
	$values				= GetValues($details["intStyleId"]);
	//$totprofitMargin = ($details["reaFOB"]*$profitMargin)/100;
	$totprofitMargin 	= ($details["dblFacProfit"]/$details["reaFOB"])*100;
	$cmEarned 			= round($details["reaSMVRate"]*$details["reaSMV"],4);
	$salesValue			= round($details["reaFOB"]* round($details["intQty"]),2);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$details["oritOrderNo"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$details["strOrderNo"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$details["strStyle"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$details["strDescription"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$details["strDivision"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$details["intQty"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$details["reaExPercentage"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,round((($details["intQty"]*$details["reaExPercentage"])/100),0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$details["reaFOB"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$details["dblFacProfit"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,round($totprofitMargin,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,round($cmEarned,4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,round($cmEarned * $details["intQty"],2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,round($details["intQty"]+(($details["intQty"]*$details["reaExPercentage"])/100),0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,round($values[0],4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,round($values[1],2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$i,round($values[2],4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$i,round($values[3],2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$i,round($values[6],4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$i,round($values[7],2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$i,round($values[4],4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$i,round($values[5],2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$i,round($salesValue,2));
	$i++;
	
	$totOrderQty 		+= round($details["intQty"],0);
	$totExOrderQty 		+= round(($details["intQty"]*$details["reaExPercentage"])/100,0);
	$totWithExOrderQty	+= round($details["intQty"]+(($details["intQty"]*$details["reaExPercentage"])/100),0);
	$totFabricMatCost	+= round($values[0],4);
	$totFabricMatValue	+= round($values[1],2);
	$totOtherMatCost	+= round($values[2],4);
	$totOtherMatValue	+= round($values[3],2);
	$totMatCost			+= round($values[4],4);
	$totMatValue		+= round($values[5],2);
	$totWashCost		+= round($values[6],4);
	$totWashValue		+= round($values[7],2);
	$totCMEarnedPerPcs	+= round($cmEarned,4);
	$totCMEarnedTotal	+= round($cmEarned * $details["intQty"],2);
	$totSalesValue		+= $salesValue;
}
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$totOrderQty);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,round($totExOrderQty,0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,round($totCMEarnedPerPcs,4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,round($totCMEarnedTotal,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,round($totWithExOrderQty,0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,round($totFabricMatCost,4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,round($totFabricMatValue,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$i,round($totOtherMatCost,4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$i,round($totOtherMatValue,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$i,round($totWashCost,4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$i,round($totWashValue,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$i,round($totMatCost,4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$i,round($totMatValue,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$i,round($totSalesValue,2));
			
function  GetValues($styleId)
{
global $db;
$array = array();
	$sql="select COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=1),0)as totalFabCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=1),0)as totalValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(2,3,4,5)),0)as totalOtherCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(2,3,4,5)),0)as totalOtherValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId'),0)as grandTotalFabCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId'),0)as grandTotalValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(6)),0)as totalWashCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(6)),0)as totalWashValue;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["totalFabCostPc"];
		$array[1] = $row["totalValue"];
		$array[2] = $row["totalOtherCostPc"];
		$array[3] = $row["totalOtherValue"];
		$array[4] = $row["grandTotalFabCostPc"];
		$array[5] = $row["grandTotalValue"];
		$array[6] = $row["totalWashCostPc"];
		$array[7] = $row["totalWashValue"];
	}
	return $array;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;
?>