<?php 
session_start();
include "../../Connector.php";
include '../../eshipLoginDB.php';
$pub_styleId	= $_GET["StyleID"];
$buyer 			= $_GET["buyer"];
$styleName 		= $_GET["styleName"];
$checkDate		= $_GET["CheckDate"];
$dateFrom		= $_GET["DateFrom"];
$dateTo			= $_GET["DateTo"];
$orderStatus 	= $_GET["orderStatus"];
$orderType		= $_GET["OrderType"];

//header('Content-Type: application/vnd.ms-word');
//header('Content-Disposition: attachment;filename="report.doc"');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Post Order Costing Summary Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.vertical-text {
	color:#333;
	position:absolute
	border:0px solid black;
	writing-mode:tb-rl;
	-webkit-transform:rotate(90deg);
	-moz-transform:rotate(270deg);
	-o-transform: rotate(90deg);
	-ms-transform: rotate(90deg);
	display:inline;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
	font-weight:bold;
	min-width:150px;
	min-height:200px;
	line-height:normal;
	word-spacing:normal;
	white-space:nowrap;
}

.vertical-text1 {	color:#333;
	position:absolute
	border:0px solid black;
	writing-mode:tb-rl;
	-webkit-transform:rotate(90deg);
	-moz-transform:rotate(270deg);
	-o-transform: rotate(90deg);
	-ms-transform: rotate(90deg);
	display:inline;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:13px;
	font-weight:bold;
	min-width:150px;
	min-height:200px;
	line-height:normal;
	word-spacing:normal;
	white-space:nowrap;
}
</style>
<style type="text/css">
    table.fixHeader {
        border: solid #FFFFFF;
        border-width: 2px 2px 2px 2px;
        width: 1050px;
    }
    tbody.ctbody {
        height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

</style>

</head>
<body>
<?php 
$status = '';
	switch($orderStatus)
	{
		case 'all':
		{
			$status = '';
			break;
		}
		case 'completed':
		{
			$status = '13';
			break;
		}
		case 'approved':
		{
			$status = '11';
			break;
		}
		case 'pending':
		{
			$status = '0,10';
			break;
		}
	}
?>
<table width="100%" border="0" align="center" cellpadding="0">
	<tr>
		<td height="53" colspan="6" class="head2">Post Order Costing Summary Report </td>
	</tr>
<?php if($styleName!="") {?>    
  	<tr>
		<td width="137" class="normalfnt">&nbsp;<b>Order No</b>&nbsp;</td>
		<td width="6" class="normalfnt"><b>:</b></td>
		<td colspan="4" class="normalfnt">&nbsp;<?php echo $styleName;?>&nbsp;</td>
	</tr>
<?php } ?>
<?php if($buyer!="") {?>   
  	<tr>
		<td width="137" class="normalfnt">&nbsp;<b>Buyer Name</b>&nbsp;</td>
	  <td width="6" class="normalfnt"><b>:</b></td>
		<td colspan="4" class="normalfnt">&nbsp;<?php echo GetBuyerName($buyer)?>&nbsp;</td>
	</tr>
<?php } ?>
<?php if($checkDate=='1') {?> 
  <tr>
	  <td width="137" class="normalfnt">&nbsp;<b>Order Date From</b>&nbsp;</td>
	<td width="6" class="normalfnt"><b>:</b></td>
	<td width="125" class="normalfnt">&nbsp;<?php echo $dateFrom?>&nbsp;</td>
	<td width="29" class="normalfnt">&nbsp;<b>To</b>&nbsp;</td>
	<td width="7" class="normalfnt"><b>:</b></td>
	<td width="2168" class="normalfnt">&nbsp;<?php echo $dateTo?>&nbsp;</td>
  </tr>
<?php } ?>
  <tr>
    <td height="53" colspan="6">
	<table width="100%" border="0" class="fixHeader" cellspacing="0">
	<thead >
    <tr>
    <th colspan="10" rowspan="2" class="bcgl1txt1B">&nbsp;</th>
    <th height="29" colspan="6" class="bcgl1txt1B">Preorder</th>
     <th colspan="10" class="bcgl1txt1B">Post Order</th>
      <th colspan="9" class="bcgl1txt1B">Invoice</th>
    </tr>
    <tr>
    <th colspan="4" class="bcgl1txt1B">Per PC</th>
     <th colspan="2" class="bcgl1txt1B">Total</th>
    <th colspan="4" class="bcgl1txt1B">Per PC</th>
     <th colspan="2" class="bcgl1txt1B">Total</th> 
      <th colspan="3" class="bcgl1txt1B">Per PC</th> 
       <th class="bcgl1txt1B">Total</th> 
        <th colspan="4" class="bcgl1txt1B">Per PC</th>
     <th colspan="2" class="bcgl1txt1B">Total</th> 
       <th class="bcgl1txt1B">Total</th> 
        <th class="bcgl1txt1B">%</th> 
    </tr>
    <tr>
    <th class="bcgl1txt1" height="168"><span class="vertical-text1" style="vertical-align:-65px;">Orit Order No </span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-80px;">Order No </span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-82px;">Style No </span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-52px;">Style Description </span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-85px; margin:0 0 0 -15px;">Division</span></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/orderQty.png" /></th>  
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/excess_percent.png" /></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/excess_qty.png" /></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-82px;">Recut Qty</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-82px;">Ship Qty</span></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/tot_Material_cost.png" /></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-100px; margin:0 0 0 5px;">CM</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-92px; margin:0 0 0 5px;">Profit</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-95px;">FOB</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-97px; margin:0 0 0 5px;">Cost</span></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/targetSales.png" /></th>
   <th class="bcgl1txt1" valign="bottom"><img src="../../images/tot_Material_cost.png" /></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-100px; margin:0 0 0 5px;">CM</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-92px; margin:0 0 0 5px;">Profit</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-95px;">FOB</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-97px; margin:0 0 0 5px;">Cost</span></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/actProdCost.png" /></th>
    <th width="4%" class="bcgl1txt1" valign="bottom"><img src="../../images/mat_vari_pre_post.png" /></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/cmVari_pre_post.png" /></th>
     <th width="4%" class="bcgl1txt1" valign="bottom"><img src="../../images/pre_post_profit.png" /></th>
     <th class="bcgl1txt1" valign="bottom"><img src="../../images/pre_post_profit.png" /></th>
   <th class="bcgl1txt1" valign="bottom"><img src="../../images/tot_Material_cost.png" /></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-100px; margin:0 0 0 5px;">CM</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-92px; margin:0 0 0 5px;">Profit</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-95px;">FOB</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-97px; margin:0 0 0 5px;">Cost</span></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/actSalesValue.png" /></th>
     <th class="bcgl1txt1" valign="bottom"><img src="../../images/salesVari_target_invoice.png" /></th>
   <!-- <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-70px; margin:0 0 0 5px;">Sales Varience</span></th>-->
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/cutship.png" /></th>
    </tr>
	</thead>
	<tbody class="ctbody">      
     <?php 
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
(select dblSMV from  firstsale_actualdata fa where fa.intStyleId=o.intStyleId) as actSMV,
(select sum(RO.intRecutQty) from orders_recut RO where RO.intStyleId=o.intStyleId group by RO.intStyleId) as recutQty
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
	while($row=mysql_fetch_array($result))
	{
		$pub_styleId = $row["intStyleId"];
		$url = "rptPostOrderCosting.php?&StyleID=".$row["intStyleId"];
		//$shipQty = getShipQty($row["buyerInvFOB"]);
		$shipQty = round(getShipQty($pub_styleId),0);
		
		$invFob = ($row["buyerInvFOB"]==1?$row["invFob"]:$row["preFob"]);
		$cutQty = $row["cutQty"];
		$orderQty = $row["orderQty"];
		$recutQty	= round($row["recutQty"]);
	 ?>
       <tr onmouseover="this.style.background ='#E8E8FF';" onmouseout="this.style.background='';">
        <td height="20" class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row["oritOrderNo"]; ?>&nbsp;</td>
        <td class="normalfntTAB" nowrap="nowrap">&nbsp;<a href="<?php echo $url; ?>" target="postordercostingRpt.php" style="text-decoration:underline" title="Click here to view Post Order Costing Report"><?php echo $row["strOrderNo"]; ?></a>&nbsp;</td>
        <td class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row["strStyle"]; ?>&nbsp;</td>
        <td class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row["strDescription"]; ?>&nbsp;</td>
        <td class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row["strDivision"]; ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["orderQty"],0); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo $row["reaExPercentage"]; ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["exQty"],0); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($recutQty,0); ?>&nbsp;</td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($shipQty,0); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
		$preorderMaterialCost = $row["preMaterialCost"]; 
		echo number_format($preorderMaterialCost,2); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["preCMvalue"],4); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
		$preorderProfit = $row["preProfit"];
		echo number_format($preorderProfit,4); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["preFob"],2); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap"><?php 
		$preorderCost = round(($row["preFob"] - $row["preorderProfit"])*$row["orderQty"],2);
		echo number_format($preorderCost,2);
		?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap"><?php 
		$preTargetSales = round($row["preFob"]*$row["orderQty"],2);
		echo number_format($preTargetSales,2);
		?></td>
        <td  class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;
        <?php 
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
echo number_format($totValue,2);
		?>&nbsp;</td>
        <td  class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
		$actCM = $row["smvRate"]*$row["actSMV"];
		echo number_format($actCM,4);
		?>&nbsp;</td>
        <td  class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
		$postProfit = $row["preFob"]-($totValue +$actCM + $row["preFinance"]+$row["preESC"]+$row["preUpcharge"]);
		echo number_format($postProfit,4);
		?>&nbsp;</td>
      <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["preFob"],2); ?>&nbsp;</td>
       <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
	  $postCost = ($totValue + $row["preServiceCost"]+$row["preOtherCost"]+$row["preWashCost"]+$actCM)*$row["orderQty"];
	  echo number_format($postCost,2);
	   ?>&nbsp;</td>
       <td class="normalfntRiteTAB"  nowrap="nowrap"><?php 
		$actProdCost = round($row["preFob"]*$row["orderQty"],4);
		echo number_format($actProdCost,2);
		?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php
		
		$matVariPostorder = ($preorderMaterialCost - $totValue);
		echo  number_format($matVariPostorder,2); ?>&nbsp;</td>
         <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
		$postCMVarience = $row["preCMvalue"]-$actCM;
		echo number_format($postCMVarience,2); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
		$profitVariPost = ($preorderProfit-$postProfit);
		echo number_format($profitVariPost,2); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
		$prePostValVarience = round($preTargetSales,2) - round($actProdCost,2);
		echo number_format($prePostValVarience,2);
		?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["invMatcost"],2); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["dblNewCM"],4) ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;
        <?php 
		$invProfit = $row["preFob"] - $invFob;
		echo number_format($invProfit,4);
		?>&nbsp;        </td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invFob,2); ?>&nbsp;</td>
       <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
		$actSalesValue = round($invFob*$shipQty,2);
		echo number_format($actSalesValue,2);
		?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;
        <?php 
		$actSalesValue = round($invFob*$shipQty);
		echo number_format($actSalesValue,2);
		?>        </td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;
        <?php 
		$salesVari = $preTargetSales - $actSalesValue;
		echo number_format($salesVari,2);
		?>&nbsp;</td>
        
       <!-- <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;&nbsp;</td>-->
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;
        <?php 
		$cutRatio = $cutQty/$shipQty*100;
		echo number_format($cutRatio,2); ?>&nbsp;</td>
      </tr>
     <?php
	 $totOrderQty += $row["orderQty"];
	 $totExQty += $row["exQty"]; 
	 $totPreMatCost += $row["preMaterialCost"]; 
	 $totPreCM += $row["preCMvalue"]; 
	 $totPreProfit += $row["preProfit"];
	 $totPreFOB += $row["preFob"]; 
	 $totPostMatCost += $totValue;
	 $totPostCM += $actCM;
	 $totPastProfit += $postProfit;
	 $totmatVariPostorder += $matVariPostorder;
	 $totprofitVariPost += $profitVariPost;
	 $totInvMatcost += $row["invMatcost"];
	 $totInvCM += $row["dblNewCM"];
	 $totInvFob += $row["invFob"];
	 $totinvProfit += $invProfit;
	 $totinvFobVari += $invFobVari;
	 $totinvPreMatVari += $invPreMatVari;
	 }
	 ?>
        <tr class="bcgcolor-tblrowWhite">
        <td colspan="34" class="normalfnt" nowrap="nowrap">&nbsp;</td>
        </tr>
	  </tbody>
    </table>  
  </table>
</td>
  </tr>
</table>
<?php 
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
?>
</body>
</html>
