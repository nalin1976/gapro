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
$division	= $_GET["Division"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Sales Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
table.fixHeader {
	border: solid #FFFFFF;	
	border-width: 2px 2px 2px 2px;	
	width: 100%;
}

tbody.ctbody {
	height: 650px;
	overflow-y: auto;
	overflow-x: hidden;
}
</style>
</head>

<body><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="6" class="head2BLCK">Sales Report</td>
  </tr>
<?php if($checkDate == 'true') {?>
	<tr class="normalfnBLD1">
		<td width="13%" height="20">&nbsp;&nbsp;Order Date From </td>
		<td width="1%">:</td>
		<td width="20%"><?php echo $txtDfrom; ?></td>
		<td width="7%">Date To</td>
		<td width="1%">:</td>
		<td width="58%"><?php echo $txtDto; ?></td>
	</tr>
<?php } ?>

<?php if($chkDelDate == 'true') {?>
	<tr class="normalfnBLD1">
		<td width="13%" height="20">&nbsp;&nbsp;Deliver Date From </td>
		<td width="1%">:</td>
		<td width="20%"><?php echo $delDfrom; ?></td>
		<td width="7%">Date To</td>
		<td width="1%">:</td>
		<td width="58%"><?php echo $delDto; ?></td>
	</tr>
<?php } ?>

<?php if($buyer != '') {?>
	<tr class="normalfnBLD1" >
		<td height="20">&nbsp;&nbsp;Buyer Name</td>
		<td width="1%">:</td>
		<td width="20%"><?php echo getBuyerName($buyer); ?></td>
		<td width="7%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="58%">&nbsp;</td>
	</tr>
  <?php }?>
  	<tr>
    	<td colspan="6"><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000" class="fixHeader">
  	<tr bgcolor="#CCCCCC" class="normalfntMid">
		<th width="148" rowspan="2" height="20">Buyer Name</th>
		<th width="50" rowspan="2">FOB<br/>(PCS)</th>
		<th width="86" rowspan="2">Average Profit Margin<br/>(PCS)</th>
		<th width="80" rowspan="2">Total Order Qty</th>
		<th width="69" rowspan="2">Total Value</th>
		<th width="77" rowspan="2">Total Profit</th>
		<th height="24" colspan="5">Approved </th>
		<th colspan="5">Pending</th>
    </tr>
  	<tr bgcolor="#CCCCCC" class="normalfntMid">
		<th width="77" height="20">FOB<br/>(PCS)</th>
		<th width="97">Average Profit Margin<br/>(PCS)</th>
		<th width="74">Total Order Qty</th>
		<th width="60">Total Value</th>
		<th width="72">Total Profit</th>
		<th width="60">FOB<br/>(PCS)</th>
		<th width="59">Average Profit Margin<br/>(PCS)</th>
		<th width="41">Total Order Qty</th>
		<th width="36">Total Value</th>
		<th width="65">Total Profit</th>
  	</tr>
    <tbody class="ctbody">
<?php 
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

if($division!="")
	$sql .= "and O.intDivisionId='$division' ";

$sql .= "group by buyer,buyerDivision order by  buyer,buyerDivision ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
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
  ?>
   <tr class="normalfnt" bgcolor="#FFFFFF" >
    <td height="20" colspan="16" nowrap="nowrap"><b><?php echo $row["buyer"]; ?></b></td> 
  </tr>
   <tr class="normalfntRite" bgcolor="#FFFFFF" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
    <td height="20" class="normalfnt" nowrap="nowrap">&nbsp;&nbsp;&nbsp;<?php echo $row["buyerDivision"]; ?></td>
    <td><?php echo $fob; ?></td>
    <td><?php echo $avgMargin; ?></td>
    <td><?php echo number_format($row["orderQty"]); ?></td>
    <td><?php echo number_format($costValue,2); ?></td>
    <td><?php echo number_format($row["orderValue"],2); ?></td>
     <td><?php echo ($AppFob == '0'? '-':number_format($AppFob,2)); ?></td>
    <td><?php echo ($ApproveAvgMargin == 0?'-':$ApproveAvgMargin);  ?></td>
    <td><?php echo ($rowA["orderQty"] == ''?'-':number_format($rowA["orderQty"])); ?></td>
    <td><?php echo ($AppCostValue == 0?'-':number_format($AppCostValue,2)); ?></td>
    <td><?php echo ($appTotProfit == ''? '-':number_format($appTotProfit,2)); ?></td>
    <td><?php echo ($pendingFob == ''? '-':number_format($pendingFob,2)); ?></td>
    <td><?php echo ($PendingAvgMargin == 0?'-':$PendingAvgMargin); ?></td>
    <td><?php echo ($rowP["orderQty"] == ''?'-':number_format($rowP["orderQty"])); ?></td>
    <td><?php echo ($PendingCostValue == 0?'-':number_format($PendingCostValue,2)); ?></td>
    <td><?php echo ($pendingTotProfit == ''? '-':number_format($pendingTotProfit,2)); ?></td>
  </tr>
  <?php
  		$firstRow = false;
  		}
		else
		{
			if($preBuyerId != $buyerID)
			{
			?>
            <tr bgcolor="#FFFFFF" class="normalfntRite" >
            <td height="20" class="normalfnt"><b> Total</b></td>
	<td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('FOB',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerOrderQty,0); ?></b></td>
    <td height="20"><b><?php echo number_format($buyCostValue,2); ?></b></td>
    <td height="20"><b><?php echo number_format($buyTotProfit,2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('FOB',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerAppQty); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerAppCostValue,2); ?></b></td>
    <td height="20"><b><?php echo number_format($buyappTotProfit,2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('FOB',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerPenQty); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerPenCostValue,2); ?></b></td>
    <td height="20"><b><?php echo number_format($bpendingTotProfit,2); ?></b></td>
            </tr>
            <?php 
			
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
			?>
             <tr class="normalfnt" bgcolor="#FFFFFF" >
    <td height="20" colspan="16" nowrap="nowrap"><b><?php echo $row["buyer"]; ?></b></td> 
  </tr>
   <tr class="normalfntRite" bgcolor="#FFFFFF" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
    <td height="20" class="normalfnt" nowrap="nowrap">&nbsp;&nbsp;&nbsp;<?php echo $row["buyerDivision"]; ?></td>
    <td><?php echo $fob; ?></td>
    <td><?php echo $avgMargin; ?></td>
    <td><?php echo number_format($row["orderQty"]); ?></td>
    <td><?php echo number_format($costValue,2); ?></td>
    <td><?php echo number_format($row["orderValue"],2); ?></td>
     <td><?php echo ($AppFob == '0'? '-':number_format($AppFob,2)); ?></td>
    <td><?php echo ($ApproveAvgMargin == 0?'-':$ApproveAvgMargin);  ?></td>
    <td><?php echo ($rowA["orderQty"] == ''?'-':number_format($rowA["orderQty"])); ?></td>
    <td><?php echo ($AppCostValue == 0?'-':number_format($AppCostValue,2)); ?></td>
    <td><?php echo ($appTotProfit == ''? '-':number_format($appTotProfit,2)); ?></td>
    <td><?php echo ($pendingFob == ''? '-':number_format($pendingFob,2)); ?></td>
    <td><?php echo ($PendingAvgMargin == 0?'-':$PendingAvgMargin); ?></td>
    <td><?php echo ($rowP["orderQty"] == ''?'-':number_format($rowP["orderQty"])); ?></td>
    <td><?php echo ($PendingCostValue == 0?'-':number_format($PendingCostValue,2)); ?></td>
    <td><?php echo ($pendingTotProfit == ''? '-':number_format($pendingTotProfit,2)); ?></td>
  </tr>
            <?php
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
			?>
            <tr class="normalfntRite" bgcolor="#FFFFFF" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
    <td height="20" class="normalfnt" nowrap="nowrap">&nbsp;&nbsp;&nbsp;<?php echo $row["buyerDivision"]; ?></td>
    <td><?php echo $fob; ?></td>
    <td><?php echo $avgMargin; ?></td>
    <td><?php echo number_format($row["orderQty"]); ?></td>
    <td><?php echo number_format($costValue,2); ?></td>
    <td><?php echo number_format($row["orderValue"],2); ?></td>
    <td><?php echo ($AppFob == '0'? '-':number_format($AppFob,2)); ?></td>
    <td><?php echo ($ApproveAvgMargin == 0?'-':$ApproveAvgMargin); ?></td>
    <td><?php echo ($rowA["orderQty"] == ''?'-':number_format($rowA["orderQty"])); ?></td>
    <td><?php echo ($AppCostValue == 0?'-':number_format($AppCostValue,2)); ?></td>
    <td><?php echo ($appTotProfit == ''? '-':number_format($appTotProfit,2)); ?></td>
    <td><?php echo ($pendingFob == ''? '-':number_format($pendingFob,2)); ?></td>
    <td><?php echo ($PendingAvgMargin == 0?'-':$PendingAvgMargin);?></td>
    <td><?php echo ($rowP["orderQty"] == ''?'-':number_format($rowP["orderQty"])); ?></td>
    <td><?php echo ($PendingCostValue == 0?'-':number_format($PendingCostValue,2)); ?></td>
    <td><?php echo ($pendingTotProfit == ''? '-':number_format($pendingTotProfit,2)); ?></td>
  </tr>
            <?php
			}
		}
		$preBuyerId = $buyerID; 
  	}
  ?>
   <tr bgcolor="#FFFFFF" class="normalfntRite" >
             <td height="20" class="normalfnt"><b> Total</b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('FOB',$buyerID,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerOrderQty,0); ?></b></td>
    <td height="20"><b><?php echo number_format($buyCostValue,2); ?></b></td>
    <td height="20"><b><?php echo number_format($buyTotProfit,2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('FOB',$buyerID,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerAppQty); ?></b></td>
    <td height="20"><b><?php echo number_format($AppCostValue,2); ?></b></td>
    <td height="20"><b><?php echo number_format($buyappTotProfit,2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('FOB',$buyerID,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal('APM',$preBuyerId,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerPenQty); ?></b></td>
    <td height="20"><b><?php echo number_format($buyerPenCostValue,2); ?></b></td>
    <td height="20"><b><?php echo number_format($bpendingTotProfit,2); ?></b></td>
            </tr>
 <tr class="normalfntRite" bgcolor="#EBEBEB">
 	<td height="20" class="normalfnt"><b>Grand Total</b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal1('FOB',$buyer,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal1('APM',$buyer,$checkDate,$txtDfrom,$txtDto,'0,10,11',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($totQty,0); ?></b></td>
    <td height="20"><b><?php echo number_format($totCostValue,2); ?></b></td>
    <td height="20"><b><?php echo number_format($totOrderValue,2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal1('FOB',$buyer,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal1('APM',$buyer,$checkDate,$txtDfrom,$txtDto,'11',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($totAppOrderQty); ?></b></td>
    <td height="20"><b><?php echo number_format($totAppCostVal,2); ?></b></td>
    <td height="20"><b><?php echo number_format($totAvgProfit,2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal1('FOB',$buyer,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),2); ?></b></td>
    <td height="20"><b><?php echo number_format(GetBuyerWiseFBTotal1('APM',$buyer,$checkDate,$txtDfrom,$txtDto,'0,10',$chkDelDate,$foDeliFromArray,$foDelToArray),4); ?></b></td>
    <td height="20"><b><?php echo number_format($totPendOrderQty); ?></b></td>
    <td height="20"><b><?php echo number_format($totPendCostVal,2); ?></b></td>
    <td height="20"><b><?php echo number_format($totPendProfit,2); ?></b></td>
 </tr>
 <tr class="bcgcolor-tblrowWhite" >
   <td colspan="16" class="normalfnt">&nbsp;</td>
   </tr>
    </tbody>
</table></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>

<?php 
function getTotCostingValue($buyerId,$intDivisionId,$checkDate,$formatedFromDate,$formatedToDate,$chkDelDate,$foDeliFromArray,$foDelToArray)
{
global $db;
/* BEGIN - Change calculation by Mr.Nandimithra.	
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
	}
	 END - Change calculation by Mr.Nandimithra.	
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
?>
</body>
</html>