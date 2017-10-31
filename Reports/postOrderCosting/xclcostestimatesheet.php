<?php
include "../../Connector.php";
include '../../eshipLoginDB.php';
$pub_styleId		= $_GET["StyleID"];

//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$file = 'postordercosting.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$objPHPExcel = PHPExcel_IOFactory::load($file);
$i = 1;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i++,"Post Order Costing");
// cell content bold
$styleArray = array(
			'font' => array(
			'bold' => true
			)
		);
// cell content bold		
//--------------------------------------------------------
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

$i=3;
$sqlorders="select O.intStyleId,O.strDescription,O.strOrderNo,o.strBuyerOrderNo, ".
			"(select B.strName from buyers B where B.intBuyerID=O.intBuyerID) AS BuyerName, ".
			"O.intQty, ".
			"round((O.intQty*O.reaExPercentage)/100,2) AS ExQty ".
			"from orders O where O.intStyleId='$pub_styleId';";
$result_orders = $db->RunQuery($sqlorders);
while($row_orders=mysql_fetch_array($result_orders ))
{
	$Printed		= false;
	$StyleId		= $row_orders["intStyleId"];
	$Description	= $row_orders["strDescription"];
	$BuyerName		= $row_orders["BuyerName"];
	$Qty			= $row_orders["intQty"];
	$ExQty			= $row_orders["ExQty"];
	$orderNo		= $row_orders["strOrderNo"];
	$buyerOrderNo   = $row_orders["strBuyerOrderNo"];
	$shipQty = getShippedQty($buyerOrderNo); 
	
	$sqldelivery="SELECT date(dtDateofDelivery) as deliveryDate,dblQty as deliveryQty FROM deliveryschedule where intStyleId='$pub_styleId' order By dtDateofDelivery ";
	$result_delivery=$db->RunQuery($sqldelivery);						
	while($row_delivery=mysql_fetch_array($result_delivery))
	{	
		
		if($Printed==true)
		{
			$StyleId		= "";
			$Description	= "";
			$BuyerName		= "";
			$Qty			= "";
			$ExQty			= "";			
		}
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,$orderNo);
				
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$Description);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$BuyerName);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$Qty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$ExQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row_delivery["deliveryDate"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$row_delivery["deliveryQty"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$shipQty);
	}
}
//--------------------------------------------------------
$i				= 7;
$TotQty			= 0.0;
$TotactualValue	= 0.0;
$TotVariation	= 0.0;
//$objPHPExcel->getActiveSheet()->getStyle('A6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sql_category="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID ".
			  "FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial)) ".
			  "INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID ".
			  "WHERE ((orderdetails.intStyleId)='$pub_styleId') ".
			  "ORDER BY matmaincategory.intID;";

$result_Category = $db->RunQuery($sql_category);
$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+2,mysql_num_rows($result_Category));

while($row_Category = mysql_fetch_array($result_Category))
{
	$category=$row_Category["strDescription"];
	$categoryID=$row_Category["intID"];
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,$category);
	$celId = 'A'.$i;
	$objPHPExcel->getActiveSheet()->getStyle($celId)->applyFromArray($styleArray);
	
	$sql_orderdetails="SELECT OD.strOrderNo,OD.intStyleId,OD.strUnit,OD.dblUnitPrice,OD.reaConPc,OD.reaWastage,OD.strCurrencyID,			 OD.intOriginNo, OD.dblFreight,OD.dblTotalQty,OD.dblReqQty,OD.dblTotalValue,OD.dbltotalcostpc,MIL.strItemDescription,MMC.strDescription,			 IP.strOriginType,MIL.intMainCatID,MIL.intItemSerial,(ICD.dblValue/12)*ICH.dblQty as invoiceCostValue,
	 ICD.reaConPc/12 as invConpc,ICD.dblUnitPrice as invUnitprice 
					FROM ((orderdetails OD INNER JOIN matitemlist MIL ON OD.intMatDetailID = MIL.intItemSerial) 
				 	INNER JOIN matmaincategory MMC ON MIL.intMainCatID = MMC.intID) 
				 	INNER JOIN itempurchasetype IP ON OD.intOriginNo = IP.intOriginNo
				 	left join invoicecostingdetails ICD on ICD.intStyleId=OD.intStyleId and ICD.strItemCode=OD.intMatDetailID
					 left join invoicecostingheader ICH on ICH.intStyleId = OD.intStyleId
				 	WHERE ((OD.intStyleId)='$pub_styleId') AND ((MIL.intMainCatID)='$categoryID') 
				 	ORDER BY MIL.strItemDescription;";
	$result_order = $db->RunQuery($sql_orderdetails);
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+2,mysql_num_rows($result_order)+1);
	while($row_order = mysql_fetch_array($result_order))
	{
		$y	= 0;
		
		$intMatDetailID =  $row_order["intItemSerial"];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,++$i,$row_order["strItemDescription"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row_order["strOriginType"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,$row_order["strUnit"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["reaConPc"],4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["dblReqQty"],0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["reaWastage"],0));
		$QtyWaste=(round($row_order["dblReqQty"],2)+(round($row_order["dblReqQty"],2)*round($row_order["reaWastage"],2))/100);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($QtyWaste,0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["dblTotalQty"],0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["dblUnitPrice"],4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["dblTotalValue"],4));
		
		$cellId = 'A'.$i;
		$cellRange = 'B'.$i.':Q'.$i;
	$objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle($cellId), $cellRange);
		
		$purchasedQty = 0;
		$averageValue = 0;
		$averagePrice = 0;
		$AdditionalQty = 0;
		$totValue=0;
		
		$sql_po = "select round(pd.dblUnitPrice/ph.dblExchangeRate,4) as UnitPrice ,pd.dblQty,pd.dblAdditionalQty 
		from purchaseorderdetails pd inner join purchaseorderheader ph on 
		pd.intPONo = ph.intPONo and ph.intYear= pd.intYear
		where ph.intStatus=10 and pd.intPOType=0 and pd.intStyleId='$pub_styleId' and pd.intMatDetailID='$intMatDetailID'  ";
		$resultpurch = $db->RunQuery($sql_po);
		
		while($row_po = mysql_fetch_array($resultpurch))
		{
			$AdditionalQty += $row_po["dblAdditionalQty"];
			$purchasedQty += $row_po["dblQty"];
			$totValue += $row_po["dblQty"]*$row_po["UnitPrice"];
		}
		// end 2011-09-13 get total purchased qty -------------------------------------------------
		
		//start 2011-09-13 get total bulk allocation Qty and value --------------------------------------
		$sql_bulk = " select cbd.dblQty,round(bgd.dblRate/bgh.dblRate,4) as UnitPrice
		from commonstock_bulkdetails cbd inner join commonstock_bulkheader cbh on
		cbd.intTransferNo = cbh.intTransferNo and cbd.intTransferYear = cbh.intTransferYear
		inner join bulkgrnheader bgh on bgh.intBulkGrnNo = cbd.intBulkGrnNo  and bgh.intYear = cbd.intBulkGRNYear
		inner join bulkgrndetails bgd on bgd.intBulkGrnNo = bgh.intBulkGrnNo and bgd.intYear = bgh.intYear
		and bgd.intMatDetailID=cbd.intMatDetailId
		where cbh.intStatus=1 and cbh.intToStyleId='$pub_styleId' and cbd.intMatDetailId='$intMatDetailID' ";
		$result_bulk = $db->RunQuery($sql_bulk);
		
		while($row_b = mysql_fetch_array($result_bulk))
		{
			$purchasedQty += $row_b["dblQty"];
			$totValue += $row_b["dblQty"]*$row_b["UnitPrice"];
		}
		//end 2011-09-13 get total bulk allocation Qty and value -------------------------------------------------
		
		//start 2011-09-13 get leftover allocated qty and value ---------------------------------------------
		
		$LeftAlloDet = getLeftAlloQtyandPrice($pub_styleId,$intMatDetailID);
		$arrLeftAlloDet = explode('**',$LeftAlloDet);
		$purchasedQty += $arrLeftAlloDet[1];
		$totValue += $arrLeftAlloDet[0];
		
		//end 2011-09-13 get leftover allocated qty and value------------------------------------------------
		
		//start 2011-09-13 total interjob transfer in qty and value
		$interjobDet = getInterJobWAprice($pub_styleId,$intMatDetailID);
		$arrInterjobDet = explode('**',$interjobDet);
		$purchasedQty += $arrInterjobDet[1];
		$totValue += $arrInterjobDet[0];
		//end 2011-09-13 total interjob transfer in qty and value
		
		$averagePrice = round($totValue/$purchasedQty,4);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($purchasedQty,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($AdditionalQty,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($averagePrice,4));
		$actualValue= round($purchasedQty,2) * round($averagePrice,4);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($actualValue,4));
		$Variation	= round($row_order["dblTotalValue"],4) - round($actualValue,4);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($Variation,4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["invConpc"],4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["invUnitprice"],4));
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["invoiceCostValue"],4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($row_order["dblTotalValue"]-round($row_order["invoiceCostValue"],4),4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y++,$i,round($actualValue-round($row_order["invoiceCostValue"],4),4));
		
		$TotQty	+= round($row_order["dblTotalQty"],2);
		$TotValue	+= round($row_order["dblTotalValue"],2);
		$TotactualValue	+=round($actualValue,2);
		$TotVariation	+=round($Variation,2);
	}
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,"SUB TOTAL");
		$celId = 'A'.$i;
		$objPHPExcel->getActiveSheet()->getStyle($celId)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$TotQty);
		$celId = 'J'.$i;
		$objPHPExcel->getActiveSheet()->getStyle($celId)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$TotValue);
		$celId = 'N'.$i;
		$objPHPExcel->getActiveSheet()->getStyle($celId)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$TotactualValue);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,$TotVariation);
		
		$cellId = 'A'.$i;
		$cellRange = 'B'.$i.':Q'.$i;
	$objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle($cellId), $cellRange);
	
		$GrandTotQty+=$TotQty;
		$GrandTotValue+=$TotValue;
		$GrandTotactualValue+=$TotactualValue;
		$GrandTotVariation+=$TotVariation;
		$TotQty	=0.0;
		$TotValue=0.0;
		$TotactualValue=0.0;
		$TotVariation=0.0;
}
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,"GRAND TOTAL");
		$celId = 'A'.$i;
		$objPHPExcel->getActiveSheet()->getStyle($celId)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$GrandTotQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$GrandTotValue);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$GrandTotactualValue);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,$GrandTotVariation);
		$cellId = 'A'.$i;
		$cellRange = 'B'.$i.':Q'.$i;
	$objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle($cellId), $cellRange);

//BEGIN
function getLeftAlloQtyandPrice($pub_styleId,$intMatDetailID)
{
	global $db;
	$sql = "SELECT COALESCE(sum(LCD.dblQty)) as LeftAlloqty, LCD.intGrnNo,LCD.intGrnYear, LCD.strGRNType,LCD.strColor,LCD.strSize,LCD.intFromStyleId
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$pub_styleId'  and 
						LCD.intMatDetailId = '$intMatDetailID' and LCH.intStatus=1
group by LCD.intGrnNo,LCD.intGrnYear,LCD.strGRNType,LCD.strColor,LCD.strSize";
						
	$result = $db->RunQuery($sql);
	$price =0;
	$leftOverQty =0;
	$waPrice =0;
	while($row = mysql_fetch_array($result))
	{
		$lQty = $row["LeftAlloqty"];
		$totQty += $lQty;
		$intGrnNo = $row["intGrnNo"];
		if($intGrnNo>30)
		{
			$strGRNType = $row["strGRNType"];
			switch($strGRNType)
			{
				case 'S':
				{
					$LOprice = getGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$row["intFromStyleId"],$matDetailId);
					$price += $LOprice*$lQty;
					break;
				}
				case 'B':
				{
					$BAprice = getBulkGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$matDetailId);
					$price += $BAprice*$lQty;
					break;
				}
			}
		}
		else
		{
			$LAprice = getLeftoverPrice($matDetailId,$intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$row["strGRNType"]);
			$price += $LAprice*$lQty;
		}
	}
	$arrAlloDet = $price.'**'.$totQty;
	return $arrAlloDet;
}
function getInterJobWAprice($styleId,$matDetailId)
{
	global $db;
	
	$sql = "select COALESCE(Sum(ID.dblQty),0) as interJobQty,ID.strColor,ID.strSize,ID.intGrnNo, ID.intGrnYear,ID.strGRNType,intStyleIdFrom from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
where IH.intStyleIdTo='$styleId'
and  ID.intMatDetailId='$matDetailId'
and IH.intStatus=3
group by ID.strColor,ID.strSize,ID.intGrnNo,ID.intGrnYear,ID.strGRNType";

	$result = $db->RunQuery($sql);
	$price =0;
	$leftOverQty =0;
	$waPrice =0;
	while($row = mysql_fetch_array($result))
	{
		$lQty = $row["interJobQty"];
		$totQty += $lQty;
		$intGrnNo = $row["intGrnNo"];
		$fromStyleID = $row["intStyleIdFrom"];
		if($intGrnNo>30)
		{
			$strGRNType = $row["strGRNType"];
			switch($strGRNType)
			{
				case 'S':
				{
					$LOprice = getGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$fromStyleID,$matDetailId);
					$price += $LOprice*$lQty;
					break;
				}
				case 'B':
				{
					$BAprice = getBulkGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$matDetailId);
					$price += $BAprice*$lQty;
				}
			}
		}
	}	
	
	$arrAlloDet = $price.'**'.$totQty;
	return $arrAlloDet;
	
	
}
function getGRNprice($intGrnNo,$grnYear,$strColor,$strSize,$styleId,$matDetailId)
{
	global $db;
	
	$sql = "select gd.dblPaymentPrice/gh.dblExRate as unitPrice
from grndetails gd inner join grnheader gh on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intStatus =1 and gd.intStyleId='$styleId' and gd.intMatDetailID='$matDetailId' and gd.strColor='$strColor' and gd.strSize = '$strSize' and  gd.intGrnNo='$intGrnNo' and gd.intGRNYear='$grnYear'";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["unitPrice"];
}
function getBulkGRNprice($intGrnNo,$grnYear,$strColor,$strSize,$matDetailId)
{
	global $db;
	
	$sql = "select bpo.dblUnitPrice/bgh.dblRate as uintprice
from  bulkgrnheader bgh inner join bulkgrndetails bgd on
bgh.intBulkGrnNo = bgd.intBulkGrnNo and bgh.intYear = bgd.intYear		
inner join bulkpurchaseorderdetails bpo on
bpo.intBulkPoNo = bgh.intBulkPoNo and 
bpo.intYear = bgh.intBulkPoYear and 
bpo.intMatDetailId = bgd.intMatDetailID
where bgh.intStatus=1 and  bgd.intMatDetailID='$matDetailId' and bgh.intBulkGrnNo='$intGrnNo' and bgh.intYear='$grnYear' and bgd.strColor='$strColor' and  bgd.strSize='$strSize'";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["uintprice"];
}
function getShippedQty($buyerOrderNo)
{
	$eshipDB = new eshipLoginDB();
	$sql = "select sum(cid.dblQuantity) as shipQty from commercial_invoice_detail cid inner join
	 commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
where cid.strBuyerPONo='$buyerOrderNo' and cih.strInvoiceType='F' ";
	
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["shipQty"];
}
function getLeftoverPrice($matDetailId,$intGrnNo,$grnYear,$color,$size,$grnType)
{
	global $db;
	$sql = "select dblUnitPrice from stocktransactions_leftover where intMatDetailId='$matDetailId' and
 strColor='$color' and strSize='$size' and intGrnNo='$intGrnNo' and intGrnYear='$grnYear' and strGRNType='$grnType' and strType='Leftover' ";
 	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["dblUnitPrice"];
}
//END
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;


?>