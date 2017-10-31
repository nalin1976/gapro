<?php

session_start();
include "../../Connector.php" ;

$buyer		= $_GET["Buyer"];
$delDfrom	= $_GET["delDfrom"];
$delDto		= $_GET["delDto"];


//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';
require_once '../../classes/class_matinfor.php';
require_once '../../classes/class_common.php';

$MatInforClass	= new MaterialCostInfo();
$CommonClass	= new CommonPHP();

$MatInforClass->SetConnection($db);

$formatFromDate	= $CommonClass->GetFormatDateToDB($delDfrom);
$formatToDate	= $CommonClass->GetFormatDateToDB($delDto);

$fromYear		= $CommonClass->GetYearFromDate($delDfrom);
$toYear			= $CommonClass->GetYearFromDate($delDto);
//		get template
$file = 'xclrptOrderBook.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$objPHPExcel = PHPExcel_IOFactory::load($file);

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);


$month_array = array();


$sql_Month_header="SELECT
distinct CASE Month(deliveryschedule.dtmHandOverDate) 
	WHEN 1 THEN 'JAN'
	WHEN 2 THEN 'FEB'
	WHEN 3 THEN 'MAR'
	WHEN 4 THEN 'APR'
	WHEN 5 THEN 'MAY'
	WHEN 6 THEN	'JUN'
	WHEN 7 THEN 'JUL'
    WHEN 8 THEN 'AUG'
	WHEN 9 THEN 'SEP'
	WHEN 10 THEN 'OCT'
	WHEN 11 THEN 'NOV'
	WHEN 12 THEN 'DEC'	
	END  as deli_month,
year(deliveryschedule.dtmHandOverDate) AS deli_year,
Month(deliveryschedule.dtmHandOverDate) as delivery_month
FROM
deliveryschedule
WHERE
deliveryschedule.dtmHandOverDate BETWEEN  '$formatFromDate' AND '$formatToDate' AND deliveryschedule.strShippingMode <> '7'
ORDER BY year(deliveryschedule.dtmHandOverDate), Month(deliveryschedule.dtmHandOverDate)";

//========================================================================================
// Change By - Nalin Jayakody
// Change On - 11/11/2015
// Change For - To change get delivery information by HandOver date instead of delivery date request by Emaali
//========================================================================================
			
$rs_month 		= $db->RunQuery($sql_Month_header);
$i				= 5;
$x				= 5;
$detail_row		= 5;
$rowMonthCount	= mysql_num_rows($rs_month);

$SubDeliveryQty	= 0;
$SubTotHours	= 0;
$SubTotFOB		= 0;
$SubCMTot		= 0;

$MonthlyDeliQty	= 0;
$MonthlyTotHrs	= 0;
$MonthlyTotFOB	= 0;
$MonthlyCM		= 0;

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,"");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,"ORDER BOOK FOR - $fromYear - $toYear ( EXPORT -BUYER WISE)");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,"FROM - ".$formatFromDate."  TO - ".$formatToDate);

$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1,mysql_num_rows($rs_month)+1);	
while ($rowMonth = mysql_fetch_array($rs_month))
{
	
	$objPHPExcel->getActiveSheet()->getStyle("A".$x.":A".$x)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF95B3D7');		
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$x,$rowMonth["deli_month"]);
	$delivery_month	= $rowMonth["delivery_month"];
	$delivery_year	= $rowMonth["deli_year"];
	
	
	# ============================================================================================================
	#  Get CONFIRMED orders list for the given month and year
	# ============================================================================================================
	$sql_summary 	= " SELECT Sum(deliveryschedule.dblQty) as DeliQty, buyers.strName, buyerdivisions.strDivision, buyers.intBuyerID, ".
	                  "        buyerdivisions.intDivisionId, SUM(orders.reaSMV * deliveryschedule.dblQty) as tot_hours, ".
                      "        SUM(orders.reaFOB * deliveryschedule.dblQty) as tot_fob ".
                      " FROM   deliveryschedule Inner Join orders ON deliveryschedule.intStyleId = orders.intStyleId Inner Join buyers ON ".
					  "        orders.intBuyerID = buyers.intBuyerID Left Join buyerdivisions ON orders.intBuyerID = buyerdivisions.intBuyerID ".
					  "        AND orders.intDivisionId = buyerdivisions.intDivisionId ".
					  " WHERE  month(deliveryschedule.dtmHandOverDate) = '$delivery_month' AND ".
					  "        year(deliveryschedule.dtmHandOverDate) = '$delivery_year' AND deliveryschedule.strShippingMode <> '7' AND  ".
					  "        deliveryschedule.intDeliveryStatus = 1 AND orders.intStatus <> 14 ";
					  
	if($buyer != '-1'){
		$sql_summary 	.= " AND buyers.intBuyerID = '$buyer' ";
	}
	
	$sql_summary 	.=	" GROUP BY  buyers.strName, buyerdivisions.strDivision ".
					    " ORDER BY Month(deliveryschedule.dtmHandOverDate), buyers.strName ";
	
	$rs_summary		= $db->RunQuery($sql_summary);
	
	while($row_summary = mysql_fetch_array($rs_summary)){
		
		$iBuyerId		= $row_summary["intBuyerID"];
		$iDivisionId	= $row_summary["intDivisionId"];
		
		$TotHrs			= (int)$row_summary["tot_hours"]/60;
		$TotalFOB		= $row_summary["tot_fob"];
		
		$rs_StyleList	= $MatInforClass->GetStyleIdList($delivery_month, $delivery_year, 1, $iBuyerId, $iDivisionId);
		
		$DivisionRMCost	= 0;
		
		while($row_StyleList = mysql_fetch_array($rs_StyleList)){
		
			$styleId 		= $row_StyleList["intStyleId"];	
			$styleDeliQty	= $row_StyleList["dblQty"];
			
			$styleRMCost	= $MatInforClass->CalculateRMCost($styleId, $styleDeliQty);
			
			$DivisionRMCost	+= $styleRMCost;
			
		}
		
		$CMValue		= $TotalFOB - $DivisionRMCost;
		$CMPerFOB		= ($CMValue / $TotalFOB) * 100;
		$CMPerMin		= ($CMValue / $TotHrs)/60;
		
		#=======================================================================================================
		# Format borders in the excel sheet
		#=======================================================================================================
		$objPHPExcel->getActiveSheet()->getStyle("A".$detail_row.":A".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("B".$detail_row.":B".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("J".$detail_row.":J".$detail_row)->applyFromArray($styleArray);
		#=======================================================================================================
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,$row_summary["strName"]." - ".$row_summary["strDivision"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$detail_row,number_format($row_summary["DeliQty"],0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$detail_row,number_format($TotHrs,0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$detail_row,number_format($CMValue,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$detail_row,number_format($TotalFOB,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$detail_row,number_format($CMPerFOB,0)."%");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$detail_row,number_format($CMPerMin,2));
		$detail_row++;
		$i++;
		
		$SubDeliveryQty += (int)$row_summary["DeliQty"];
		$SubTotHours	+= $TotHrs;
		//$SubTotHours	+= (int)$row_summary["tot_hours"];
		$SubTotFOB		+= (int)$row_summary["tot_fob"];
		$SubCMTot		+= $CMValue;
		
	}
	
	$SubCMPerFOB		= ($SubCMTot / $SubTotFOB) * 100;
	$SubCMPerMin		= ($SubCMTot/$SubTotHours)/60;
	// Set row color to blue
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000CC');
	
	// Set font color to White
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
	
	#=======================================================================================================
	# Format borders in the excel sheet
	#=======================================================================================================
	$objPHPExcel->getActiveSheet()->getStyle("A".$detail_row.":A".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("B".$detail_row.":B".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("J".$detail_row.":J".$detail_row)->applyFromArray($styleArray);
	#=======================================================================================================
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,"TTL CONFIRMED");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$detail_row,number_format($SubDeliveryQty,0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$detail_row,number_format($SubTotHours,0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$detail_row,number_format($SubCMTot,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$detail_row,number_format($SubTotFOB,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$detail_row,number_format($SubCMPerFOB,0)."%");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$detail_row,number_format($SubCMPerMin,2));
	//$objPHPExcel->getActiveSheet()->mergeCells("A".$x.":A".$i);
	
	# ============================================================================================================
	
	$MonthlyDeliQty = $MonthlyDeliQty + $SubDeliveryQty;
	$MonthlyTotHrs	= $MonthlyTotHrs + $SubTotHours;
	$MonthlyTotFOB	= $MonthlyTotFOB + $SubTotFOB;
	$MonthlyCM		+= $SubCMTot;
	
	$SubDeliveryQty	= 0;
	$SubTotHours	= 0;
	$SubTotFOB		= 0;
	$SubCMTot		= 0;
	
	
	$detail_row		= $detail_row + 3;
	#=======================================================================================================
	# Format borders in the excel sheet
	#=======================================================================================================
	$objPHPExcel->getActiveSheet()->getStyle("A".$detail_row.":A".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("B".$detail_row.":B".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("J".$detail_row.":J".$detail_row)->applyFromArray($styleArray);
	#=======================================================================================================
	
	# ============================================================================================================
	#  Get BLOCKED orders list for the given month and year
	# ============================================================================================================
	
	$sql_summary 	= " SELECT Sum(deliveryschedule.dblQty) as DeliQty, buyers.strName, buyerdivisions.strDivision, buyers.intBuyerID, ".
	                  "        buyerdivisions.intDivisionId, SUM(orders.reaSMV * deliveryschedule.dblQty) as tot_hours, ".
                      "        SUM(orders.reaFOB * deliveryschedule.dblQty) as tot_fob ".
                      " FROM   deliveryschedule Inner Join orders ON deliveryschedule.intStyleId = orders.intStyleId Inner Join buyers ON ".
					  "        orders.intBuyerID = buyers.intBuyerID Left Join buyerdivisions ON orders.intBuyerID = buyerdivisions.intBuyerID ".
					  "        AND orders.intDivisionId = buyerdivisions.intDivisionId ".
					  " WHERE  month(deliveryschedule.dtmHandOverDate) = '$delivery_month' AND ".
					  "        year(deliveryschedule.dtmHandOverDate) = '$delivery_year' AND deliveryschedule.strShippingMode <> '7' AND  ".
					  "        deliveryschedule.intDeliveryStatus = 2 AND orders.intStatus <> 14 ";
					  
	if($buyer != '-1'){
		$sql_summary .= " AND buyers.intBuyerID = '$buyer' ";
	}				  
					  
	 $sql_summary	.= " GROUP BY  buyers.strName, buyerdivisions.strDivision ".
					   " ORDER BY Month(deliveryschedule.dtDateofDelivery), buyers.strName ";
	
	$rs_summary		= $db->RunQuery($sql_summary);

	
	
	while($row_summary = mysql_fetch_array($rs_summary)){
		
		$iBuyerId		= $row_summary["intBuyerID"];
		$iDivisionId	= $row_summary["intDivisionId"];
		
		$Tot_Hrs		= (int)$row_summary["tot_hours"]/60;
		$TotalFOB		= $row_summary["tot_fob"];
		
		$rs_StyleList	= $MatInforClass->GetStyleIdList($delivery_month, $delivery_year, 2, $iBuyerId, $iDivisionId);
		
		$DivisionRMCost	= 0;
		
		while($row_StyleList = mysql_fetch_array($rs_StyleList)){
		
			$styleId 		= $row_StyleList["intStyleId"];	
			$styleDeliQty	= $row_StyleList["dblQty"];
			
			$styleRMCost	= $MatInforClass->CalculateRMCost($styleId, $styleDeliQty);
			
			$DivisionRMCost	+= $styleRMCost;
			
			
		}
		
		$CMValue		= $TotalFOB - $DivisionRMCost;
		$CMPerFOB		= ($CMValue / $TotalFOB) * 100;
		$CMPerMin		= ($CMValue / $TotHrs)/60;
		
		#=======================================================================================================
		# Format borders in the excel sheet
		#=======================================================================================================
		$objPHPExcel->getActiveSheet()->getStyle("A".$detail_row.":A".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("B".$detail_row.":B".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("J".$detail_row.":J".$detail_row)->applyFromArray($styleArray);
		#=======================================================================================================
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,$row_summary["strName"]." - ".$row_summary["strDivision"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$detail_row,number_format($row_summary["DeliQty"],0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$detail_row,number_format($Tot_Hrs,0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$detail_row,number_format($CMValue,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$detail_row,number_format($TotalFOB,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$detail_row,number_format($CMPerFOB,0)."%");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$detail_row,number_format($CMPerMin,2));
		
		$detail_row++;
		$i++;
		
		$SubDeliveryQty += (int)$row_summary["DeliQty"];
		$SubTotHours	+= $Tot_Hrs;//(int)$row_summary["tot_hours"];
		$SubTotFOB		+= (int)$row_summary["tot_fob"];
		$SubCMTot		+= $CMValue;
		
	}
	
	$SubCMPerFOB		= ($SubCMTot / $SubTotFOB) * 100;
	$SubCMPerMin		= ($SubCMTot/$SubTotHours)/60;
	
	// Set row color to blue
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000CC');
	
	// Set font color to White
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
	
	#=======================================================================================================
	# Format borders in the excel sheet
	#=======================================================================================================
	$objPHPExcel->getActiveSheet()->getStyle("A".$detail_row.":A".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("B".$detail_row.":B".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("J".$detail_row.":J".$detail_row)->applyFromArray($styleArray);
	#=======================================================================================================

	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,"TTL BLOCKED");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$detail_row,number_format($SubDeliveryQty,0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$detail_row,number_format($SubTotHours,0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$detail_row,number_format($SubCMTot,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$detail_row,number_format($SubTotFOB,2));	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$detail_row,number_format($SubCMPerFOB,0)."%");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$detail_row,number_format($SubCMPerMin,2));
	
	# ============================================================================================================
	
	$MonthlyDeliQty = $MonthlyDeliQty + $SubDeliveryQty;
	$MonthlyTotHrs	= $MonthlyTotHrs + $SubTotHours;
	$MonthlyTotFOB	= $MonthlyTotFOB + $SubTotFOB;
	$MonthlyCM		+= $SubCMTot;
	
	$MonthlyCMPerFOB = ($MonthlyCM / $MonthlyTotFOB) * 100;
	$MonthlyCMPerMin = ($MonthlyCM/$MonthlyTotHrs)/60;
	
	# ======================================================================================================
	
	$detail_row++;
	
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF09B732');
	
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
	
	#=======================================================================================================
	# Format borders in the excel sheet
	#=======================================================================================================
	$objPHPExcel->getActiveSheet()->getStyle("A".$detail_row.":A".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("B".$detail_row.":B".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("J".$detail_row.":J".$detail_row)->applyFromArray($styleArray);
	#=======================================================================================================
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,"TOTAL");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$detail_row,number_format($MonthlyDeliQty,0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$detail_row,number_format($MonthlyTotHrs,0));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$detail_row,number_format($MonthlyCM,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$detail_row,number_format($MonthlyTotFOB,2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$detail_row,number_format($MonthlyCMPerFOB,0)."%");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$detail_row,number_format($MonthlyCMPerMin,2));
	
	# ======================================================================================================
	
	$objPHPExcel->getActiveSheet()->mergeCells("A".$x.":A".$detail_row);
	$objPHPExcel->getActiveSheet()->mergeCells("B".$x.":B".$detail_row);
	
	
	# ================================================================================================
	# Add data to Array
	# ================================================================================================
	$month_array[] = array('monthName'=>$rowMonth['deli_month']."-".$rowMonth['deli_year'], 'totQty'=>$MonthlyDeliQty, 'totHours'=>$MonthlyTotHrs, 'totCM'=>$MonthlyCM, 'totFOB'=>$MonthlyTotFOB, 'totCMPerFOB'=>$MonthlyCMPerFOB, 'totCMPerMin'=>$MonthlyCMPerMin);	
	# ================================================================================================
	
	# ================================
	$SubDeliveryQty	= 0;
	$SubTotHours	= 0;
	$SubTotFOB		= 0;
	$SubCMTot		= 0;
	
	$MonthlyDeliQty	= 0;
	$MonthlyTotHrs	= 0;
	$MonthlyTotFOB	= 0;
	$MonthlyCM		= 0;
	# ================================
	
	
	$i			= $i + 5;
	$x 			= $detail_row + 2;
	$detail_row	= $detail_row + 3;
}


#=======================================================================================================
# Summary Section
#=======================================================================================================


$detail_row	+= 3;

// Set row color to blue
$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000CC');
	
// Set font color to White
$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');

#=======================================================================================================
# Format borders in the excel sheet
#=======================================================================================================

$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);

#=======================================================================================================



$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,"Exp. Month");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$detail_row,"Order Qty");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$detail_row,"Total Hours");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$detail_row,"Total CM(USD)");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$detail_row,"Total FOB(USD)");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$detail_row,"CM/FOB");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$detail_row,"CM/MIN");


//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,print_r($month_array));	
$detail_row++;

$SummaryTotQty	 	= 0;
$SummaryTotHrs		= 0;
$SummaryTotCM		= 0;
$SummaryTotFOB		= 0;

$SummaryGrandQty	= 0;
$SummaryGrandHrs	= 0;
$SummaryGrandCM		= 0;
$SummaryGrandFOB	= 0;



foreach($month_array as $arrayValue){
	
	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,$arrayValue[0]);
	
	#=======================================================================================================
	# Format borders in the excel sheet
	#=======================================================================================================
	
	$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);
	
	#=======================================================================================================
	
	while(list($key, $value) = each($arrayValue)){
		
		switch($key){
			
			case "monthName":
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$detail_row,$value);
				
			break;
			
			case "totQty":
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$detail_row,$value);
				$SummaryTotQty = (int)$value;
			break;
			
			case "totHours":
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$detail_row,$value);
				$SummaryTotHrs = (int)$value;
			break;
			
			case "totCM":
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$detail_row,$value);
				$SummaryTotCM  = (float)$value; 
			break;
			
			case "totFOB":
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$detail_row,$value);
				$SummaryTotFOB = (float)$value;
			break;
			
			case "totCMPerFOB":
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$detail_row,number_format($value,2)."%");
			break;
			
			case "totCMPerMin":
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$detail_row,number_format($value,2));
			break;
		}
		
		
		
	}
	
	$SummaryGrandQty += $SummaryTotQty;
	$SummaryGrandHrs += $SummaryTotHrs;
	$SummaryGrandCM  += $SummaryTotCM;
	$SummaryGrandFOB += $SummaryTotFOB;
	
	$detail_row++;
	
	
	
	
}

// Set row color to blue
$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFCC00');

// Set font color to White
$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":I".$detail_row)->getFont()->setBold(true);

#=======================================================================================================
# Format borders in the excel sheet
#=======================================================================================================

$objPHPExcel->getActiveSheet()->getStyle("C".$detail_row.":C".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("D".$detail_row.":D".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("E".$detail_row.":E".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("F".$detail_row.":F".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("G".$detail_row.":G".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("H".$detail_row.":H".$detail_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("I".$detail_row.":I".$detail_row)->applyFromArray($styleArray);

#=======================================================================================================


$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$detail_row,number_format($SummaryGrandQty,0));
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$detail_row,number_format($SummaryGrandHrs,0));
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$detail_row,number_format($SummaryGrandCM,2));
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$detail_row,number_format($SummaryGrandFOB,2));
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$detail_row,number_format(($SummaryGrandCM/$SummaryGrandFOB)*100,2)."%");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$detail_row,number_format(($SummaryGrandCM/$SummaryGrandHrs)/60,2));

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;
?>