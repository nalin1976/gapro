<?php
 session_start();
include "../../Connector.php";
$txtDfrom  	= $_GET["txtDfrom"];
$txtDto    	= $_GET["txtDto"];
$checkDate	= $_GET["checkDate"];
$buyer		= $_GET["Buyer"];
$chkDelDate	= $_GET["chkDelDate"];
$delDfrom	= $_GET["delDfrom"];
$delDto		= $_GET["delDto"];

//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$file = 'xclSalesReport.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$i	= 1;
$objPHPExcel = PHPExcel_IOFactory::load($file);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,"Sales Report");


if($checkDate == 'true') 
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,"Order Date From");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$txtDfrom);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,"Order Date To");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$txtDto);
}

if($chkDelDate == 'true') 
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,"Deliver Date From");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$delDfrom);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,"Deliver Date From To");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$delDto);
}

if($buyer != '')
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,"Buyer Name");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,getBuyerName($buyer));
}


	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$details["oritOrderNo"]);
$firstRow 			= true;
$formatedFromDate 	= '';
$formatedToDate 	= '';

$sql = "select b.strName as buyer,bd.strDivision as buyerDivision,sum(o.reaFOB*o.intQty) as Fob,
sum(o.dblFacProfit) as profit,sum(o.intQty) as orderQty,(sum(o.dblFacProfit*o.intQty)) as orderValue,
b.intBuyerID,bd.intDivisionId,ceil((sum(o.intQty) + sum(o.intQty*o.reaExPercentage)/100)) as totOrderQty
from buyers b inner join buyerdivisions bd on bd.intBuyerID= b.intBuyerID
inner join orders o on o.intBuyerID = b.intBuyerID and o.intDivisionId = bd.intDivisionId ";

if($checkDate=="true")
{
	if($txtDfrom!="")
	{
		$DateFromArray		= explode('/',$txtDfrom);
		$formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
		$sql.=" AND date(o.dtmOrderDate)>='$formatedFromDate' ";
	}
	if($txtDto!="")
	{
		$DateToArray		= explode('/',$txtDto);
		$formatedToDate		= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
		$sql.=" AND date(o.dtmOrderDate)<='$formatedToDate' ";
	}
}

if($chkDelDate=="true")
{
	$sql .= " and o.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
	if($delDfrom!="")
	{
		$delDfromArray			= explode('/',$delDfrom);
		$foDeliFromArray	= $delDfromArray[2].'-'.$delDfromArray[1].'-'.$delDfromArray[0];
		$sql .= "and date(DS.dtDateofDelivery)>='$foDeliFromArray' ";
	}
	if($delDto!="")
	{
		$delDToArray			= explode('/',$delDto);
		$foDelToArray	= $delDToArray[2].'-'.$delDToArray[1].'-'.$delDToArray[0];
		$sql .= "and date(DS.dtDateofDelivery)<='$foDelToArray' ";
	}
	$sql .= ") ";
}

if($buyer!="")
	$sql .= "and o.intBuyerID='$buyer' ";

$sql .= "group by buyer,buyerDivision order by  buyer,buyerDivision ";
	$result=$db->RunQuery($sql);	
	$i	= 5;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1,mysql_num_rows($result)+1);
	
	while($row=mysql_fetch_array($result))
	{
	//$i	= 4;
		$avgMargin 			= round($row["orderValue"]/$row["orderQty"],4);
		$buyerID 			= $row["intBuyerID"];
		$costValue 			= getTotCostingValue($row["intBuyerID"],$row["intDivisionId"],$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray);
		$fobValue 			= $row["Fob"]/$row["orderQty"];
		$fob 				= number_format($fobValue,2);
		
		//pending details
		$pendingStatus		= '0,10';
		$resPending 		= getSalesData($row["intBuyerID"],$row["intDivisionId"],$pendingStatus,$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray);
		$rowP 				= mysql_fetch_array($resPending);
		
		$PendingAvgMargin 	= round($rowP["orderValue"]/$rowP["orderQty"],4);
		$PendingCostValue 	= getCostingValue($row["intBuyerID"],$row["intDivisionId"],$pendingStatus,$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray);
		$pendingFob 		= $rowP["Fob"]/$rowP["orderQty"];
		$pendingTotProfit 	= round($rowP["orderValue"],2);
		//end pending details
		
		//Approve details
		$AppStatus			= '11';
		$resApprove 		= getSalesData($row["intBuyerID"],$row["intDivisionId"],$AppStatus,$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray);
		$rowA 				= mysql_fetch_array($resApprove);
		
		$ApproveAvgMargin 	= round($rowA["orderValue"]/$rowA["orderQty"],4);
		$AppCostValue 	  	= round(getCostingValue($row["intBuyerID"],$row["intDivisionId"],$AppStatus,$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray),2);
		$AppFob 			= round($rowA["Fob"]/$rowA["orderQty"],2);
		$appTotProfit 		= round($rowA["orderValue"],2);
		//end Approve details
		
		//total values
		$totFOB 			+= round($fobValue,2);
		$totavgMargin 		+= $avgMargin;
		$totCostValue 		+= round($costValue,2);
		$totQty 			+= $row["orderQty"];
		$totOrderValue 		+= round($row["orderValue"],2);
		
		$totAppFOB 			+= round($AppFob,2);
		$totAppAvgMargin 	+= $ApproveAvgMargin;
		$totAppOrderQty 	+= $rowA["orderQty"];
		$totAppCostVal 		+= round($AppCostValue,2);
		$totAvgProfit 		+= round($appTotProfit,2);
		
		$totPendingFOB 		+= round($pendingFob,2);
		$totPendAvgMargin 	+= $PendingAvgMargin;
		$totPendOrderQty 	+= $rowP["orderQty"];
		$totPendCostVal 	+= round($PendingCostValue,2);
		$totPendProfit 		+= round($pendingTotProfit,2);
		//end total values
		
		if($firstRow)
		{
			$preBuyerId 		= $buyerID;
			$buyFOB 			+= round($fobValue,2);
			$buyavgMargin 		+= $avgMargin;
			$buyerOrderQty 		+=$row["orderQty"]; 
			$buyCostValue 		+= round($costValue,2);
			$buyTotProfit 		+= round($row["orderValue"],2);
			$buyerAppFob 		+= $AppFob;
			$BuyerAppAvgMargin 	+= $ApproveAvgMargin;
			$buyerAppQty 		+= $rowA["orderQty"];
			$buyerAppCostValue 	+= $AppCostValue;
			$buyappTotProfit 	+= $appTotProfit;
			$buyerPenFob 		+= round($pendingFob,2);
			$buyerPendAvgMargin += $PendingAvgMargin;
			$buyerPenQty 		+= $rowP["orderQty"];
			$buyerPenCostValue 	+= $PendingCostValue;
			$bpendingTotProfit 	+= $pendingTotProfit;
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row["buyer"]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,$row["buyerDivision"]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$fob);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$avgMargin);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,round($row["orderQty"]));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,round($costValue,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,round($row["orderValue"],2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$AppFob == '0'? '-':round($AppFob,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,($ApproveAvgMargin == 0?'-':$ApproveAvgMargin));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$rowA["orderQty"] == ''?'-':round($rowA["orderQty"]));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$AppCostValue == 0?'-':round($AppCostValue,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,$appTotProfit == ''? '-':round($appTotProfit,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,$pendingFob == ''? '-':round($pendingFob,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,$PendingAvgMargin == 0?'-':$PendingAvgMargin);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$rowP["orderQty"] == ''?'-':round($rowP["orderQty"]));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,$PendingCostValue == 0?'-':round($PendingCostValue,2));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,$pendingTotProfit == ''? '-':round($pendingTotProfit,2));
			
			$firstRow = false;
		}
		else
		{
			if($preBuyerId != $buyerID)
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,"Total");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,round(GetBuyerWiseFBTotal('FOB',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,round(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,round($buyerOrderQty,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,round($buyCostValue,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,round($buyTotProfit,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,round(GetBuyerWiseFBTotal('FOB',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,round(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,round($buyerAppQty));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,round($buyerAppCostValue,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,round($buyappTotProfit,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,round(GetBuyerWiseFBTotal('FOB',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,round(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,round($buyerPenQty));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,round($buyerPenCostValue,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,round($bpendingTotProfit,2));
				
				$buyFOB 			= 0;
				$buyavgMargin 		= 0;
				$buyerOrderQty 		= 0;
				$buyCostValue 		= 0;
				$buyTotProfit 		= 0;
				$buyCostValue 		= 0;
				$buyerAppFob 		= 0;
				$BuyerAppAvgMargin 	= 0;
				$buyerAppQty 		= 0;
				$buyerAppCostValue 	= 0;
				$buyappTotProfit 	= 0;
				$buyerPenFob 		= 0;
				$buyerPendAvgMargin = 0;
				$buyerPenQty 		= 0;
				$buyerPenCostValue 	= 0;
				$bpendingTotProfit 	= 0;
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,$row["buyer"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,$row["buyerDivision"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$fob);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$avgMargin);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,round($row["orderQty"]));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,round($costValue,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,round($row["orderValue"],2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,($AppFob == '0'? '-':round($AppFob,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,($ApproveAvgMargin == 0?'-':$ApproveAvgMargin));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,($rowA["orderQty"] == ''?'-':round($rowA["orderQty"])));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,($AppCostValue == 0?'-':round($AppCostValue,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,($appTotProfit == ''? '-':round($appTotProfit,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,($pendingFob == ''? '-':round($pendingFob,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,($PendingAvgMargin == 0?'-':$PendingAvgMargin));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,($rowP["orderQty"] == ''?'-':round($rowP["orderQty"])));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,($PendingCostValue == 0?'-':round($PendingCostValue,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,($pendingTotProfit == ''? '-':round($pendingTotProfit,2)));
				
				$buyFOB 			+= round($fobValue,2);
				$buyavgMargin 		+= $avgMargin;
				$buyerOrderQty 		+=$row["orderQty"]; 
				$buyCostValue 		+= round($costValue,2);
				$buyTotProfit 		+= round($row["orderValue"],2);
				$buyerAppFob 		+= $AppFob;
				$BuyerAppAvgMargin 	+= $ApproveAvgMargin;
				$buyerAppQty 		+= $rowA["orderQty"];
				$buyerAppCostValue 	+= $AppCostValue;
				$buyappTotProfit 	+= $appTotProfit;
				$buyerPenFob 		+= round($pendingFob,2);
				$buyerPendAvgMargin += $PendingAvgMargin;
				$buyerPenQty 		+= $rowP["orderQty"];
				$buyerPenCostValue 	+= $PendingCostValue;
				$bpendingTotProfit 	+= $pendingTotProfit;
			}
			else
			{
				$buyFOB 			+= round($fobValue,2);
				$buyavgMargin 		+= $avgMargin;
				$buyerOrderQty 		+=$row["orderQty"]; 
				$buyCostValue 		+= round($costValue,2);
				$buyTotProfit 		+= round($row["orderValue"],2);
				$buyerAppFob 		+= $AppFob;
				$BuyerAppAvgMargin 	+= $ApproveAvgMargin;
				$buyerAppQty 		+= $rowA["orderQty"];
				$buyerAppCostValue 	+= $AppCostValue;
				$buyappTotProfit 	+= $appTotProfit;
				$buyerPenFob 		+= round($pendingFob,2);
				$buyerPendAvgMargin += $PendingAvgMargin;
				$buyerPenQty 		+= $rowP["orderQty"];
				$buyerPenCostValue 	+= $PendingCostValue;
				$bpendingTotProfit 	+= $pendingTotProfit;
				
				//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,$row["buyer"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,$row["buyerDivision"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$fob);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$avgMargin);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,round($row["orderQty"]));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,round($costValue,2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,round($row["orderValue"],2));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,($AppFob == '0'? '-':round($AppFob,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,($ApproveAvgMargin == 0?'-':$ApproveAvgMargin));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,($rowA["orderQty"] == ''?'-':round($rowA["orderQty"])));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,($AppCostValue == 0?'-':round($AppCostValue,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,($appTotProfit == ''? '-':round($appTotProfit,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,($pendingFob == ''? '-':round($pendingFob,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,($PendingAvgMargin == 0?'-':$PendingAvgMargin));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,($rowP["orderQty"] == ''?'-':round($rowP["orderQty"])));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,($PendingCostValue == 0?'-':round($PendingCostValue,2)));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,($pendingTotProfit == ''? '-':round($pendingTotProfit,2)));		
			}		
		}
		$preBuyerId = $buyerID; 
	}
	
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,"Total");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,round(GetBuyerWiseFBTotal('FOB',$buyerID,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,round(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,round($buyerOrderQty,0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,round($buyCostValue,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,round($buyTotProfit,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,round(GetBuyerWiseFBTotal('FOB',$buyerID,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,round(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,round($buyerAppQty));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,round($AppCostValue,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,round($buyappTotProfit,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,round(GetBuyerWiseFBTotal('FOB',$buyerID,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,round(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,round($buyerPenQty));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,round($buyerPenCostValue,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,round($bpendingTotProfit,2));


		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,++$i,"Grand Total");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,round(GetBuyerWiseFBTotal1('FOB',$buyer,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,round(GetBuyerWiseFBTotal1('APM',$buyer,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,round($totQty,0));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,round($totCostValue,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,round($totOrderValue,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,round(GetBuyerWiseFBTotal1('FOB',$buyer,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,round(GetBuyerWiseFBTotal1('APM',$buyer,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,round($totAppOrderQty));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,round($totAppCostVal,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,round($totAvgProfit,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,round(GetBuyerWiseFBTotal1('FOB',$buyer,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,round(GetBuyerWiseFBTotal1('APM',$buyer,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),4));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,round($totPendOrderQty));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,round($totPendCostVal,2));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,round($totPendProfit,2));
//
function getTotCostingValue($buyerId,$intDivisionId,$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray)
{
global $db;
	/*BEGIN - Change calculation by Mr.Nandimithra.
	$sql = " select sum(od.dblTotalValue) as costingValue from orderdetails od inner join orders o on
o.intStyleId = od.intStyleId
where o.intBuyerID='$buyerId' and o.intDivisionId='$intDivisionId' ";
	if($checkDate=="true")
	{
		if($formatedFromDate !='')
			$sql.=" AND date(o.dtmOrderDate)>='$formatedFromDate' ";
		if($formatedToDate != '')	
			$sql.=" AND date(o.dtmOrderDate)<='$formatedToDate' ";
	}
	
	if($chkDelDate=="true")
	{
		$sql .= " and o.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
		
		if($foDeliFromArray !='')
			$sql .= "and date(DS.dtDateofDelivery)>='$foDeliFromArray' ";
		if($foDelToArray != '')	
			$sql .= "and date(DS.dtDateofDelivery)<='$foDelToArray' ";
			
		$sql .= ")";
	}END - Change calculation by Mr.Nandimithra.
*/

	$sql = " select sum(o.reaFOB * o.intQty) as salesValue from orders o
where o.intBuyerID='$buyerId' and o.intDivisionId='$intDivisionId' ";
	if($checkDate=="true")
	{
		if($formatedFromDate !='')
			$sql.=" AND date(o.dtmOrderDate)>='$formatedFromDate' ";
		if($formatedToDate != '')	
			$sql.=" AND date(o.dtmOrderDate)<='$formatedToDate' ";
	}
	
	if($chkDelDate=="true")
	{
		$sql .= " and o.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
		
		if($foDeliFromArray !='')
			$sql .= "and date(DS.dtDateofDelivery)>='$foDeliFromArray' ";
		if($foDelToArray != '')	
			$sql .= "and date(DS.dtDateofDelivery)<='$foDelToArray' ";
			
		$sql .= ")";
	}
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
return $row["salesValue"];
}

function getSalesData($buyerId,$intDivisionId,$status,$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray)
{
	global $db;
	$sql = "select sum(o.reaFOB*o.intQty) as Fob,sum(o.dblFacProfit) as profit,sum(o.intQty) as orderQty,(sum(o.dblFacProfit*o.intQty)) as orderValue,ceil((sum(o.intQty) + sum(o.intQty*o.reaExPercentage)/100)) as totOrderQty
from orders o 
where o.intBuyerID='$buyerId' and o.intDivisionId='$intDivisionId' and o.intStatus in ($status)";
	if($checkDate=="true")
	{
		if($formatedFromDate !='')
			$sql.=" AND date(o.dtmOrderDate)>='$formatedFromDate' ";
		if($formatedToDate != '')	
			$sql.=" AND date(o.dtmOrderDate)<='$formatedToDate' ";
	}
	
	if($chkDelDate=="true")
	{
		$sql .= " and o.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
		
		if($foDeliFromArray !='')
			$sql .= "and date(DS.dtDateofDelivery)>='$foDeliFromArray' ";
		if($foDelToArray != '')	
			$sql .= "and date(DS.dtDateofDelivery)<='$foDelToArray' ";
			
		$sql .= ")";
	}

	return $db->RunQuery($sql);
}

function getCostingValue($buyerId,$intDivisionId,$status,$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray)
{
	global $db;
	$sql = " select sum(od.dblTotalValue) as costingValue from orderdetails od inner join orders o on
o.intStyleId = od.intStyleId
where o.intBuyerID='$buyerId' and o.intDivisionId='$intDivisionId' and o.intStatus in ($status) ";
	if($checkDate=="true")
	{
		if($formatedFromDate !='')
			$sql.=" AND date(o.dtmOrderDate)>='$formatedFromDate' ";
		if($formatedToDate != '')	
			$sql.=" AND date(o.dtmOrderDate)<='$formatedToDate' ";
	}
	
	if($chkDelDate=="true")
	{
		$sql .= " and o.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
		
		if($foDeliFromArray !='')
			$sql .= "and date(DS.dtDateofDelivery)>='$foDeliFromArray' ";
		if($foDelToArray != '')	
			$sql .= "and date(DS.dtDateofDelivery)<='$foDelToArray' ";
			
		$sql .= ")";
	}
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["costingValue"];
}

function getBuyerName($buyer)
{
	global $db;
	$sql = " select strName from buyers where intBuyerID='$buyer' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strName"];
}

function GetBuyerWiseFBTotal($type,$buyer,$checkDate,$txtDfrom,$txtDto,$status,$chkDelDate,$foDeliFromArray,$foDelToArray)
{
global $db;
$sql = "select sum(o.reaFOB*o.intQty) as Fob,
sum(o.intQty) as orderQty,(sum(o.dblFacProfit*o.intQty)) as orderValue
from buyers b inner join buyerdivisions bd on bd.intBuyerID= b.intBuyerID
inner join orders o on o.intBuyerID = b.intBuyerID and o.intDivisionId = bd.intDivisionId WHERE o.intStatus in ($status) ";

if($checkDate=="true")
{
	if($txtDfrom!="")
	{
		$DateFromArray	= explode('/',$txtDfrom);
		$formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
		$sql.=" AND date(o.dtmOrderDate)>='$formatedFromDate' ";
	}
	if($txtDto!="")
	{
		$DateToArray	= explode('/',$txtDto);
		$formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
		$sql.=" AND date(o.dtmOrderDate)<='$formatedToDate' ";
	}
}

if($chkDelDate=="true")
{
	$sql .= " and o.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
	
	if($foDeliFromArray !='')
		$sql .= "and date(DS.dtDateofDelivery)>='$foDeliFromArray' ";
	if($foDelToArray != '')	
		$sql .= "and date(DS.dtDateofDelivery)<='$foDelToArray' ";
		
	$sql .= ")";
}

if($buyer!="")
	$sql .= "and o.intBuyerID='$buyer' ";

$sql .= "group by o.intBuyerID";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($type=='FOB')
			return $row["Fob"]/$row["orderQty"];
		else if($type=='APM')
			return $row["orderValue"]/$row["orderQty"];
	}
}

function GetBuyerWiseFBTotal1($type,$buyer,$checkDate,$txtDfrom,$txtDto,$status,$chkDelDate,$foDeliFromArray,$foDelToArray)
{
global $db;
$sql = "select sum(o.reaFOB*o.intQty) as Fob,sum(o.intQty) as orderQty,(sum(o.dblFacProfit*o.intQty)) as orderValue from buyers b inner join buyerdivisions bd on bd.intBuyerID= b.intBuyerID
inner join orders o on o.intBuyerID = b.intBuyerID and o.intDivisionId = bd.intDivisionId WHERE o.intStatus in ($status) ";

if($checkDate=="true")
{
	if($txtDfrom!="")
	{
		$DateFromArray	= explode('/',$txtDfrom);
		$formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
		$sql.=" AND date(o.dtmOrderDate)>='$formatedFromDate' ";
	}
	if($txtDto!="")
	{
		$DateToArray	= explode('/',$txtDto);
		$formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
		$sql.=" AND date(o.dtmOrderDate)<='$formatedToDate' ";
	}
}

if($chkDelDate=="true")
{
	$sql .= " and o.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
	
	if($foDeliFromArray !='')
		$sql .= "and date(DS.dtDateofDelivery)>='$foDeliFromArray' ";
	if($foDelToArray != '')	
		$sql .= "and date(DS.dtDateofDelivery)<='$foDelToArray' ";
		
	$sql .= ")";
}
	
if($buyer!="")
	$sql .= "and o.intBuyerID='$buyer' ";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($type=='FOB')
			return $row["Fob"]/$row["orderQty"];
		else if($type=='APM')
			return $row["orderValue"]/$row["orderQty"];
	}
}
//

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;
?>