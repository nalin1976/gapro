<?php
include "../../Connector.php";
include '../../eshipLoginDB.php';
$pub_styleId	= $_GET["StyleID"];
$buyer 			= $_GET["buyer"];
$styleName 		= $_GET["styleName"];
$checkDate		= $_GET["CheckDate"];
$dateFrom		= $_GET["DateFrom"];
$dateTo			= $_GET["DateTo"];
$orderStatus 	= $_GET["orderStatus"];
$orderType		= 1;

//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$file = 'postordercostingsummary.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$objPHPExcel = PHPExcel_IOFactory::load($file);
$i = 1;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,"Post Order Costing Summary Report ");
// cell content bold
$styleArray = array(
			'font' => array(
			'bold' => true
			)
		);
// cell content bold		
//--------------------------------------------------------
$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);

$i=6;
 $sql = "select o.intStyleId,concat(date_format(o.dtmOrderDate,'%Y%m'),'',o.intCompanyOrderNo)as oritOrderNo,o.strOrderNo,
o.strStyle,o.strDescription,dv.strDivision,o.intQty as orderQty,o.reaExPercentage ,round(o.intQty*o.reaExPercentage/100) as exQty,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od where od.intStyleId=o.intStyleId) as preMaterialCost,
round(o.reaSMV*o.reaSMVRate,4) as preCMvalue,o.dblFacProfit as preProfit,o.reaFOB as preFob,
round(ih.dblTotalCostValue,2) as invMatcost,ih.dblTotalCostValue as invFob,o.dblActualEfficencyLevel,ih.dblNewCM, o.dblFacProfit as preorderProfit,o.reaSMVRate as smvRate,o.reaFinance as preFinance, o.reaECSCharge as preESC, o.reaUPCharges as preUpcharge,(select round(sum(od.dbltotalcostpc),4) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial= od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=4) as preServiceCost,
(select round(sum(od.dbltotalcostpc),4) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial= od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=5) as preOtherCost,
(select round(sum(od.dbltotalcostpc),4) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial= od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=6) as preWashCost, o.strBuyerOrderNo,b.intinvFOB as buyerInvFOB,
(select sum(ph.dblTotalQty) as qty from productionbundleheader ph where ph.intStyleId=o.intStyleId) as cutQty,
(select dblSMV from  firstsale_actualdata fa where fa.intStyleId=o.intStyleId) as actSMV
from orders o inner join buyerdivisions dv on 
dv.intDivisionId = o.intDivisionId and dv.intBuyerID = o.intBuyerID
left join invoicecostingheader ih on ih.intStyleId= o.intStyleId
inner join buyers b on b.intBuyerID = o.intBuyerID
 where o.intStyleId>0 ";
 	
	if($pub_styleId !='')
		$sql .= " and o.intStyleId='$pub_styleId' ";
	if($status !='')
		$sql .= " and o.intStatus in ($status) ";
	if($buyer != '')
		$sql .= "and o.intBuyerID = '$buyer' ";
	if($styleName != '')
		$sql .= "and o.strStyle = '$styleName' ";
	if($checkDate=='1')
		$sql .= "and o.dtmOrderDate >='$dateFrom' and o.dtmOrderDate <='$dateTo' ";
	if($orderType!="")
		$sql .= "and o.intOrderType='$orderType' ";
	$sql .= "order by o.strOrderNo ";
	$result = $db->RunQuery($sql);
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1,mysql_num_rows($result)-1);
	while($row=mysql_fetch_array($result))
	{
		
		$pub_styleId = $row["intStyleId"];
		$url = "rptPostOrderCosting.php?&StyleID=".$row["intStyleId"];
		//$shipQty = getShipQty($row["buyerInvFOB"]);
		$shipQty = round(getShipQty($pub_styleId),0);
		
		$invFob = ($row["buyerInvFOB"]==1?$row["invFob"]:$row["preFob"]);
		$cutQty = $row["cutQty"];
		$orderQty = $row["orderQty"];
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row["oritOrderNo"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row["strOrderNo"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row["strStyle"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$row["strDescription"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$row["strDivision"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,round($row["orderQty"],0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row["reaExPercentage"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,round($row["exQty"],0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,round($shipQty,0));
		$preorderMaterialCost = $row["preMaterialCost"]; 
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,round($preorderMaterialCost,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,round($row["preCMvalue"],4));
		$preorderProfit = $row["preProfit"];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,round($preorderProfit,4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,round($row["preFob"],4));
		$preorderCost = round(($row["preFob"] - $row["preorderProfit"])*$row["orderQty"],2);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$preorderCost);
		$preTargetSales = round($row["preFob"]*$row["orderQty"],2);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,$preTargetSales);
		$totValue=0;
		$purchasedQty=0;
// start 2011-09-13 get total purchased qty (normal po qty & value) ----------------------------------------------
	$sql_po = "select round(pd.dblUnitPrice/ph.dblExchangeRate,4) as UnitPrice ,pd.dblQty,pd.dblAdditionalQty 
from purchaseorderdetails pd inner join purchaseorderheader ph on 
pd.intPONo = ph.intPONo and ph.intYear= pd.intYear
where ph.intStatus=10 and pd.intPOType=0 and pd.intStyleId='$pub_styleId' ";
	$resultpurch = $db->RunQuery($sql_po);
	
	while($row_po = mysql_fetch_array($resultpurch))
	{
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
where cbh.intStatus=1 and cbh.intToStyleId='$pub_styleId' ";
	$result_bulk = $db->RunQuery($sql_bulk);
	
	while($row_b = mysql_fetch_array($result_bulk))
	{
		$purchasedQty += $row_b["dblQty"];
		$totValue += $row_b["dblQty"]*$row_b["UnitPrice"];
	}
//end 2011-09-13 get total bulk allocation Qty and value -------------------------------------------------

//start 2011-09-13 get leftover allocated qty and value ---------------------------------------------

	$LeftAlloDet = getLeftAlloQtyandPrice($pub_styleId);
	$arrLeftAlloDet = explode('**',$LeftAlloDet);
	$purchasedQty += $arrLeftAlloDet[1];
	$totValue += $arrLeftAlloDet[0];
	
//end 2011-09-13 get leftover allocated qty and value------------------------------------------------

//start 2011-09-13 total interjob transfer in qty and value
	$interjobDet = getInterJobWAprice($pub_styleId);
	$arrInterjobDet = explode('**',$interjobDet);
	$purchasedQty += $arrInterjobDet[1];
	$totValue += $arrInterjobDet[0];
//end 2011-09-13 total interjob transfer in qty and value

$totValue = round($totValue/$orderQty,2);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,round($totValue,2));
	$actCM = $row["smvRate"]*$row["actSMV"];
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$i,round($actCM,2));
	$postProfit = $row["preFob"]-($totValue +$actCM + $row["preFinance"]+$row["preESC"]+$row["preUpcharge"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$i,round($postProfit,4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$i,round($row["preFob"],2));
	$postCost = ($totValue + $row["preServiceCost"]+$row["preOtherCost"]+$row["preWashCost"]+$actCM)*$row["orderQty"];
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$i,round($postCost,2));
	$actProdCost = round($row["preFob"]*$row["orderQty"],4);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$i,round($actProdCost,2));
	$matVariPostorder = ($preorderMaterialCost - $totValue);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$i,round($matVariPostorder,2));
	$postCMVarience = $row["preCMvalue"]-$actCM;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$i,round($postCMVarience,2));
	$profitVariPost = ($preorderProfit-$postProfit);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$i,round($profitVariPost,2));
	$prePostValVarience = round($preTargetSales,2) - round($actProdCost,2);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$i,$prePostValVarience);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$i,round($row["invMatcost"],2));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$i,round($row["dblNewCM"],4));
	$invProfit = $row["preFob"] - $invFob;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$i,round($invProfit,4));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$i,round($invFob,2));
	$actSalesValue = round($invFob*$shipQty,2);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$i,round($actSalesValue,2));
	$actSalesValue = round($invFob*$shipQty);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$i,round($actSalesValue,2));
	$salesVari = $preTargetSales - $actSalesValue;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31,$i,round($salesVari,2));
	$cutRatio = $cutQty/$shipQty*100;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(32,$i,round($cutRatio,2));
	$i++;
	}

function getLeftAlloQtyandPrice($pub_styleId)
{
	global $db;
	$sql = "SELECT COALESCE(sum(LCD.dblQty)) as LeftAlloqty, LCD.intGrnNo,LCD.intGrnYear, LCD.strGRNType,LCD.strColor,LCD.strSize,LCD.intFromStyleId,LCD.intMatDetailId
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$pub_styleId'  and  LCH.intStatus=1
group by LCD.intGrnNo,LCD.intGrnYear,LCD.strGRNType,LCD.strColor,LCD.strSize,LCD.intMatDetailId ";
			
	$result = $db->RunQuery($sql);
	$price =0;
	$leftOverQty =0;
	$waPrice =0;
	while($row = mysql_fetch_array($result))
	{
		$lQty = $row["LeftAlloqty"];
		$matDetailId = $row["intMatDetailId"];
		
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
function getInterJobWAprice($styleId)
{
	global $db;
	
	$sql = "select COALESCE(Sum(ID.dblQty),0) as interJobQty,ID.strColor,ID.strSize,ID.intGrnNo, ID.intGrnYear,ID.strGRNType,intStyleIdFrom,ID.intMatDetailId from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
where IH.intStyleIdTo='$styleId' and IH.intStatus=3
group by ID.strColor,ID.strSize,ID.intGrnNo,ID.intGrnYear,ID.strGRNType,ID.intMatDetailId ";

	$result = $db->RunQuery($sql);
	$price =0;
	$leftOverQty =0;
	$waPrice =0;
	while($row = mysql_fetch_array($result))
	{
		$lQty = $row["interJobQty"];
		$matDetailId = $row["intMatDetailId"];
		
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
function getLeftoverPrice($matDetailId,$intGrnNo,$grnYear,$color,$size,$grnType)
{
	global $db;
	$sql = "select dblUnitPrice from stocktransactions_leftover where intMatDetailId='$matDetailId' and
 strColor='$color' and strSize='$size' and intGrnNo='$intGrnNo' and intGrnYear='$grnYear' and strGRNType='$grnType' and strType='Leftover' ";
 	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["dblUnitPrice"];
}

function GetBuyerName($buyerId)
{
global $db;
	$sql = "select strName from buyers where intBuyerID='$buyerId'";
 	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strName"];
}
function getShipQty($pub_styleId)
{
	$eshipDB = new eshipLoginDB();
	$sql = " select sum(cid.dblQuantity) as shipQty from commercial_invoice_detail cid inner join
	 commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
inner join shipmentplheader plh on plh.strPLNo = cid.strPLNo
where plh.intStyleId='$pub_styleId' and cih.strInvoiceType='F' ";
	
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["shipQty"];
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;
