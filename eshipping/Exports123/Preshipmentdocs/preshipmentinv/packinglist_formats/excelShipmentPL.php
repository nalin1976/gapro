<?php
include "../../Connector.php";
require_once('../../excel/Classes/PHPExcel.php');
require_once('../../excel/Classes/PHPExcel/IOFactory.php');

$plno=$_GET['plno'];
$xmldoc=simplexml_load_file('../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;




$str_header		="SELECT 	shipmentplheader.strPLNo, 
				shipmentplheader.strSailingDate, 
				shipmentplheader.strStyle, 
				SUM(dblQtyPcs) AS dblQtyPcs,
				SUM(dblNoofCTNS) AS dblNoofCTNS,
				SUM(dblQtyDoz) AS dblQtyDoz,
				ROUND(SUM(dblTotGross),2) AS dblTotGross,
				ROUND(SUM(dblTotNet),2) AS dblTotNet,
				ROUND(SUM(dblTotNetNet),2) AS dblTotNetNet,
				(SELECT SUM(orderspecdetails.dblPcs) FROM orderspecdetails WHERE orderspecdetails.intOrderId=orderspec.intOrderId) AS ordpcs,
				shipmentplheader.strProductCode, 
				shipmentplheader.strMaterial, 
				shipmentplheader.strFabric, 
				shipmentplheader.strLable, 
				shipmentplheader.strColor, 
				shipmentplheader.strISDno, 
				shipmentplheader.strPrePackCode, 
				shipmentplheader.strSeason, 
				shipmentplheader.strDivision, 
				shipmentplheader.strCTNsvolume, 
				shipmentplheader.strWashCode, 
				shipmentplheader.strArticle, 
				shipmentplheader.strCBM, 
				shipmentplheader.strItemNo, 
				shipmentplheader.strItem, 
				shipmentplheader.strManufactOrderNo, 
				shipmentplheader.strManufactStyle, 
				shipmentplheader.strDO, 
				shipmentplheader.strSortingType, 
				shipmentplheader.strFactory, 
				shipmentplheader.strUnit,
				shipmentplheader.strTrnsportMode,
				shipmentplheader.strMarksNos,
				shipmentplheader.intMulYes,
				customers.strName,
				customers.strMLocation,
				customers.strAddress1,
				customers.strAddress2,
				customers.strCountry,
				customers.strEMail,
				customers.strFax,
				customers.strPhone,
				shipmentplheader.strShipTo,
				shipmentplheader.strInvNo			 
				FROM 
				shipmentplheader
				INNER JOIN shipmentpldetail ON shipmentpldetail.strPLNo=shipmentplheader.strPLNo
				INNER JOIN orderspec ON shipmentplheader.strStyle = orderspec.strOrder_No
				INNER JOIN customers ON customers.strCustomerID = shipmentplheader.strFactory
							where
							shipmentplheader.strPLNo='$plno' group by strPLNo";
$result_header	=$db->RunQuery($str_header);
$holder_header	=mysql_fetch_array($result_header);

$myValue=$holder_header['intMulYes'];

$str_dyn		="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno'";
$result_dyn		=$db->RunQuery($str_dyn);

$col_dyn		=mysql_num_rows($result_dyn);

$col_width		=90/($col_dyn+13);


$shipToId		= $holder_header['strShipTo'];
$shipSql		= "SELECT
					buyers.strName AS shipName,
					buyers.strAddress1 AS shipAddress1,
					buyers.strAddress2 AS shipAddress2,
					buyers.strAddress3 AS shipAddress3,
					buyers.strCountry AS shipCountry
					FROM
					buyers
					WHERE strBuyerID=$shipToId";
					
$resultShip		=$db->RunQuery($shipSql);
$rowShip		= mysql_fetch_array($resultShip);






$excel = new PHPExcel();
//$excel->createSheet(0);

$excel->setActiveSheetIndex(0);
$rowno = 6;
 $rowNoForGrid = 8;
$no  = 1;
	$title = "Packing List.xls";	
	$excel->getActiveSheet()->setTitle('Packing List');


		  	$str_pre_pack ="SELECT DISTINCT srtPack FROM shipmentpldetail WHERE strPLNo='$plno'";
	 $result_prepack=$db->RunQuery($str_pre_pack);
	 while($row_prepack=mysql_fetch_array($result_prepack))
	 {
		
			$prepack=$row_prepack["srtPack"];	 
			if($prepack=="1Pre Pack")
			$prepack_desc="SINGLE PRE PACK ";
			else if($prepack=="2Ratio")
			{
				if($myValue==1)
					$prepack_desc="MULT Y (RATIO PACK) ";
				else
					$prepack_desc="MULT N (RATIO PACK) ";
			}
			else if($prepack=="3Bulk")
			$prepack_desc="BULK PACK ";
			
			
			$tot_QtyPcs=0;	 
			$tot_NoofCTNS=0;
			$tot_QtyDoz=0;
			
			$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowno,$prepack_desc);
			$rowno++;
			
			$excel->getActiveSheet()->setCellValue("A8",'CTN NO');
			$excel->getActiveSheet()->mergeCells('A8:A9');
			$excel->getActiveSheet()->getStyle('A8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$excel->getActiveSheet()->getStyle('A8')->getFill()->getStartColor()->setARGB('#CCCCCC');

			
			
			$excel->getActiveSheet()->setCellValue("B8",'PRE PACK NO');
			$excel->getActiveSheet()->mergeCells('B8:B9');
			
			$excel->getActiveSheet()->setCellValue("C8",'EDI NO');
			$excel->getActiveSheet()->mergeCells('C8:C9');
			
			$excel->getActiveSheet()->setCellValue("D8",'COLOUR');
			$excel->getActiveSheet()->mergeCells('D8:D9');
			
			$excel->getActiveSheet()->setCellValue("E8",'RATIO');
	
			$excel->getActiveSheet()->setCellValue("F8",'NO OF PCS');
			$excel->getActiveSheet()->mergeCells('F8:F9');
	
			$excel->getActiveSheet()->setCellValue("G8",'NO OF CTNS');
			$excel->getActiveSheet()->mergeCells('G8:G9');
			
			$excel->getActiveSheet()->setCellValue("H8",'QTY');
			$excel->getActiveSheet()->mergeCells('H8:H9');
			
			$excel->getActiveSheet()->setCellValue("I8",'QTY');
			$excel->getActiveSheet()->mergeCells('I8:I9');
			
			$excel->getActiveSheet()->setCellValue("J8",'CARTONE');
			$excel->getActiveSheet()->mergeCells('J8:J9');
			
	  
	 }
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$title.'"');
header('Cache-Control: max-age=10');

$Writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5'); $Writer->save('php://output'); 

			
?>