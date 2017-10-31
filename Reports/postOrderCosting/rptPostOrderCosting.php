<?php 
session_start();
include "../../Connector.php";
include '../../eshipLoginDB.php';
			
$pub_styleId		= $_GET["StyleID"];
$deciQty=0;
$deci=4;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Post Order Costing Report</title>
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
</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0">
<tr><td>
  <table align="center" width="100%" border="0">
<tr>
  <td align="center" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="75%" align="center" class="head2">COSTING SUMMARY</td>
      </tr>
    <?php 
	$SQLPO = "SELECT O.strOrderNo,O.strStyle,O.strDescription,B.strName,O.intQty,O.reaExPercentage
			  FROM orders O
			  inner join buyers B on B.intBuyerID=O.intBuyerID
			  WHERE intStyleId='$pub_styleId' ";
	$result_PO = $db->RunQuery($SQLPO);
	$rowPO = mysql_fetch_array($result_PO);
	$orderQty			= round($rowPO["intQty"],0);
	$exPercent			= round($rowPO["reaExPercentage"],0);
	$exQty				= round(($orderQty*$exPercent/100),0);
	$totOrderQty		= round($orderQty+($orderQty*$exPercent/100),0);
	$recutQty			= round(GetRecutQty($pub_styleId));
	$cuttableQty		= round($totOrderQty+$recutQty);
	?>
    <tr>
      <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="7%" class="normalfnt" ><b>Order No</b></td>
          <td width="0%"><b>:</b></td>
          <td width="92%"><?php echo $rowPO["strOrderNo"]; ?></td>
          </tr>
        <tr>
          <td class="normalfnt" height="20"><b>Style No</b></td>
          <td><b>:</b></td>
          <td><?php echo $rowPO["strStyle"]; ?></td>
          </tr>
        <tr>
          <td class="normalfnt" ><b>Order Description</b></td>
          <td><b>:</b></td>
          <td><?php echo $rowPO["strDescription"]?></td>
          </tr>
        <tr>
          <td class="normalfnt" ><b>Buyer</b></td>
          <td><b>:</b></td>
          <td><?php echo $rowPO["strName"]?></td>
          </tr>
        </table></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td><table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="45%"><table width="92%" border="0" cellspacing="1" cellpadding="2" class="normalfntRite" bgcolor="#000000">
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <th width="23%" height="20">&nbsp;</th>
              <th colspan="3">PER PCS</th>
              </tr>
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <th width="23%" height="20">&nbsp;</th>
              <th width="24%">PER ORDER (USD)</th>
              <th width="27%">POST ORDER (USD)</th>
              <th width="26%">VARIANCE (USD)</th>
              </tr>
            <?php 
	 $sql_cost = "select o.reaFOB,o.reaSMVRate,o.reaSMV,o.dblFacProfit as preProfit,o.reaFinance as preFinance,
o.reaECSCharge as preESC, o.reaUPCharges as preUpcharge, o.reaFinPercntage,o.intQty,
(select (sum(od.dbltotalcostpc)) as fabCost from orderdetails od 
inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID where od.intStyleId=o.intStyleId 
  and mil.intMainCatID =1) as fabCost,
(select (sum(od.dbltotalcostpc)) as fabCost from orderdetails od 
inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID where od.intStyleId=o.intStyleId 
  and mil.intMainCatID =2) as AccCost,
(select (sum(od.dbltotalcostpc)) as fabCost from orderdetails od 
inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID where od.intStyleId=o.intStyleId 
  and mil.intMainCatID =3) as packingCost,
(select (sum(od.dbltotalcostpc)) as fabCost from orderdetails od 
inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID where od.intStyleId=o.intStyleId 
  and mil.intMainCatID =4) as ServiceCost,
(select (sum(od.dbltotalcostpc)) as fabCost from orderdetails od 
inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID where od.intStyleId=o.intStyleId 
  and mil.intMainCatID =5) as otherCost,
(select od.dbltotalcostpc as wetWashPrice
from orderdetails od inner join matitemlist mil on mil.intItemSerial=od.intMatDetailID
where mil.strItemDescription like'%WASHING - WET COST%' and od.intStyleId=o.intStyleId) as wetWashPrice,
 (select od.dbltotalcostpc as dryWashPrice
from orderdetails od inner join matitemlist mil on mil.intItemSerial=od.intMatDetailID
where mil.strItemDescription like'%WASHING - DRY COST%' and od.intStyleId=o.intStyleId) as dryWashPrice,
(select dblSMV from  firstsale_actualdata fa where fa.intStyleId=o.intStyleId) as actSMV,
(select dblDryWashPrice from  firstsale_actualdata fa where fa.intStyleId=o.intStyleId) as actDryWashPrice,
(select dblWetWashPrice from  firstsale_actualdata fa where fa.intStyleId=o.intStyleId) as actWetWashPrice,
(select sum(ph.dblTotalQty) as qty from productionbundleheader ph where ph.intStyleId=o.intStyleId) as cutQty
from orders o
where o.intStyleId='$pub_styleId' ";
	 $result_cost = $db->RunQuery($sql_cost);
	$rowCost = mysql_fetch_array($result_cost);
	$preFabCost = $rowCost["fabCost"];
	$preAccCost = $rowCost["AccCost"];
	$prePacCost = $rowCost["packingCost"];
	$preServiceCost = $rowCost["ServiceCost"];
	$preOtherCost = $rowCost["otherCost"];
	$preFinance = $rowCost["preFinance"];
	$preWetWashPrice = $rowCost["wetWashPrice"];
	$preDryWashPrice = $rowCost["dryWashPrice"];
	$financePct = $rowCost["reaFinPercntage"];
	$orderQty = $rowCost["intQty"];
	
	$postFabDetails = getPostOrderPrice($pub_styleId,1,$financePct,$orderQty);
	$arrPostFabDetails = explode('*',$postFabDetails);
	$postFabValue = $arrPostFabDetails[0];
	$postFinance += $arrPostFabDetails[1];
	
	$postAccDetails = getPostOrderPrice($pub_styleId,2,$financePct,$orderQty);
	$arrPostAccDetails = explode('*',$postAccDetails);
	$postAccValue = $arrPostAccDetails[0];
	$postFinance += $arrPostAccDetails[1];
	
	$postPacDetails = getPostOrderPrice($pub_styleId,3,$financePct,$orderQty);
	$arrPostPacDetails = explode('*',$postPacDetails);
	$postPacValue = $arrPostPacDetails[0];
	$postFinance += $arrPostPacDetails[1];
	
	$postServiceDetails = getPostOrderPrice($pub_styleId,4,$financePct,$orderQty);
	$arrPostServiceDetails = explode('*',$postServiceDetails);
	$postServiceValue = $arrPostServiceDetails[0];
	$postFinance += $arrPostServiceDetails[1];
	
	$postOtherDetails = getPostOrderPrice($pub_styleId,5,$financePct,$orderQty);
	$arrPostOtherDetails = explode('*',$postOtherDetails);
	$postOtherValue = $arrPostOtherDetails[0];
	$postFinance += $arrPostOtherDetails[1];
	
	$postWetValue = $rowCost["actWetWashPrice"];
	$postDryValue = $rowCost["actDryWashPrice"];
	$shipQty = getShipQty($pub_styleId);
	$shipPrice	= GetShipPrice($pub_styleId);
	  ?>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">FABRIC</td>
              <td><?php echo number_format($preFabCost,2); ?></td>
              <td><?php echo number_format($postFabValue,2); ?></td>
              <td><?php echo number_format($preFabCost-$postFabValue,2);  ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">ACCESSORIES</td>
              <td><?php echo number_format($preAccCost,2); ?></td>
              <td><?php echo number_format($postAccValue,2); ?></td>
              <td><?php echo number_format($preAccCost-$postAccValue,2);  ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">PACKING</td>
              <td><?php echo number_format($prePacCost,2); ?></td>
              <td><?php echo number_format($postPacValue,2); ?></td>
              <td><?php echo number_format($prePacCost-$postPacValue,2);  ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">SERVICES</td>
              <td><?php echo number_format($preServiceCost,2); ?></td>
              <td><?php echo number_format($postServiceValue,2); ?></td>
              <td><?php echo number_format($preServiceCost-$postServiceValue,2);  ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">OTHER COST</td>
              <td><?php echo number_format($preOtherCost,2); ?></td>
              <td><?php echo number_format($postOtherValue,2); ?></td>
              <td><?php echo number_format($preOtherCost-$postOtherValue,2);  ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">FINANCE</td>
              <td><?php echo number_format($preFinance,2); ?></td>
              <td><?php echo number_format($postFinance,2); ?></td>
              <td><?php echo number_format($preFinance-$postFinance,2); ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">WASHING_WET </td>
              <td><?php echo number_format($preWetWashPrice,2); ?></td>
              <td><?php echo number_format($postWetValue,2); ?></td>
              <td><?php echo number_format($preWetWashPrice-$postWetValue,2);  ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">WASHING_DRY</td>
              <td><?php echo number_format($preDryWashPrice,2); ?></td>
              <td><?php echo number_format($postDryValue,2); ?></td>
              <td><?php echo number_format($preDryWashPrice-$postDryValue,2);  ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">CM</td>
              <td><?php $cm = $rowCost["reaSMVRate"]*$rowCost["reaSMV"]; echo number_format($cm,2);?></td>
              <td><?php $actCM = $rowCost["reaSMVRate"]*$rowCost["actSMV"]; echo number_format($actCM,2);?></td>
              <td><?php echo number_format($cm-$actCM,2);  ?></td>
              </tr>
            <tr bgcolor="#EBEBEB">
              <td class="normalfnt" height="20">TOTAL COST</td>
              <td><?php $preTotCost = $preFabCost+$preAccCost+$prePacCost+$preServiceCost+$preOtherCost+$preWetWashPrice+$preDryWashPrice+$cm;
		echo number_format($preTotCost,2);
		?></td>
              <td><?php 	$postTotValue = $postFabValue+$postAccValue+$postPacValue+$postServiceValue+$postOtherValue+$postWetValue+$postDryValue+$actCM;
		echo number_format($postTotValue,2);
?></td>
              <td><?php echo number_format($preTotCost-$postTotValue,2);  ?></td>
              </tr>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">FINAL FOB PRICE</td>
              <td><?php echo number_format($rowCost["reaFOB"],2); ?></td>
              <td><?php echo number_format($rowCost["reaFOB"],2); ?></td>
              <td><?php echo number_format($rowCost["reaFOB"]-$rowCost["reaFOB"],2);  ?></td>
              </tr>
            <tr bgcolor="#EBEBEB">
              <td class="normalfnt" height="20">PROFIT</td>
              <td><?php echo number_format($rowCost["preProfit"],2); ?></td>
              <td><?php $totValue = $postFabValue+$postAccValue+$postPacValue+$postServiceValue+$postOtherValue+$postWetValue+$postDryValue;
		$postProfit = $rowCost["reaFOB"]-($totValue +$actCM + $preFinance+$rowCost["preESC"]+$rowCost["preUpcharge"]);
		echo number_format($postProfit,2);
		?></td>
              <td><?php echo number_format($postProfit-$rowCost["preProfit"],2); ?></td>
              </tr>
            </table></td>
          <td width="55%" valign="bottom"><table width="80%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="normalfnt" height="20"><b>TOTAL PROFITABILITY</b></td>
            </tr>
            <tr>
              <td><table width="38%" border="0" cellspacing="1" cellpadding="2"  class="normalfnt" bgcolor="#000000">
                <tr bgcolor="#FFFFFF">
                  <td height="20" >ORDER QTY </td>
                  <td class="normalfnt">PCS</td>
                  <td class="normalfntRite"><?php echo number_format($orderQty)?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20">EXCESS </td>
                  <td class="normalfnt">%</td>
                  <td class="normalfntRite"><?php echo number_format($exPercent)?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20">EXCESS QTY </td>
                  <td class="normalfnt">PCS</td>
                  <td class="normalfntRite"><?php echo number_format($exQty)?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20" nowrap="nowrap">TOTAL ORDER QTY</td>
                  <td class="normalfnt">PCS</td>
                  <td class="normalfntRite"><?php echo number_format($totOrderQty)?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20" nowrap="nowrap">RECUT ORDER QTY</td>
                  <td class="normalfnt">PCS</td>
                  <td class="normalfntRite"><?php echo number_format($recutQty)?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20">CUTTABLE QTY </td>
                  <td class="normalfnt">PCS</td>
                  <td class="normalfntRite"><?php echo number_format($cuttableQty)?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20">PRICE</td>
                  <td class="normalfnt">USD</td>
                  <td class="normalfntRite"><?php echo number_format($shipPrice,2)?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="49%" height="20">CUT QTY </td>
                  <td width="14%" class="normalfnt">PCS</td>
                  <td width="37%" class="normalfntRite"><?php echo $rowCost["cutQty"]; ?></td>
                  </tr>
                <tr bgcolor="#FFFFFF" >
                  <td height="20">SHIPPED QTY </td>
                  <td class="normalfnt">PCS</td>
                  <td class="normalfntRite"><?php echo $shipQty; ?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20">CUT /SHIP </td>
                  <td class="normalfnt">%</td>
                  <td class="normalfntRite"><?php echo round($shipQty/$rowCost["cutQty"]*100); ?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20">TOTAL COST&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td class="normalfnt">USD</td>
                  <td class="normalfntRite"><?php $totCost=$rowCost["cutQty"]*$postTotValue; echo round($totCost,2); ?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20">TOTAL INCOME&nbsp;&nbsp;&nbsp;</td>
                  <td class="normalfnt">USD</td>
                  <td class="normalfntRite"><?php $totIncome =$shipQty*$postTotValue; echo round($totIncome,2); ?></td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="20">ORDER PROFIT&nbsp;&nbsp;&nbsp;</td>
                  <td class="normalfnt">USD</td>
                  <td class="normalfntRite"><?php echo round($totIncome-$totCost,2); ?></td>
                  </tr>
                </table></td>
            </tr>
            </table></td>
          </tr>
  </table>
        
        </td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      </tr>
  </table></td>				
</tr>

<tr>
  <td align="center" class="head2" style="border-top-style:dashed;border-top-width:1px">POST ORDER COSTING</td>
</tr>

</table>

</td></tr>
  <tr>
    <td height="53" colspan="20"><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
      <tr class="bcgcolor-tblrowWhite normalfntMid">
        <td width="18%" rowspan="2" align="center" valign="bottom" style="font-size:13px"><b>Item Description</b></td>
        <td width="3%" rowspan="2" height="25"><span class="vertical-text" style="vertical-align:-85px;">Origin</span></td>
        <td width="4%" rowspan="2" ><span class="vertical-text" style="vertical-align:-92px;">Unit</span></td>
        <td width="5%" rowspan="2" ><span class="vertical-text" style="vertical-align:-80px;">Con-Pc</span></td>
        <td width="5%" rowspan="2" valign="bottom"><img src="../../images/orderQty.png" /></td>
        <td width="2%" rowspan="2" ><span class="vertical-text" style="vertical-align:-63px; margin:0 0 0 -25px;">Wastage %</span></td>
        <td width="5%" rowspan="2" ><span class="vertical-text" style="vertical-align:-50px; margin:0 0 0 -35px;">Qty + Wastage</span></td>
        <td width="5%" rowspan="2" ><span class="vertical-text" style="vertical-align:-72px;  margin:0 0 0 -15px;">Total Qty</span></td>
        <td width="5%" rowspan="2" ><span class="vertical-text" style="vertical-align:-70px;  margin:0 0 0 -10px;">Recut Qty</span></td>
        <td width="5%" rowspan="2" ><span class="vertical-text" style="vertical-align:-62px; margin:0 0 0 -25px;" >Unit Price $</span></td>
        <td width="5%" rowspan="2" ><span class="vertical-text" style="vertical-align:-80px;" >Value $</span></td>
        <td colspan="4" height="25"><b>ACTUAL</b></td>
        <td width="5%" rowspan="2" valign="bottom"><img src="../../images/vari_pre_post.png" /></td>
        <td colspan="3" ><b>INVOICE COSTING</b></td>
        <td width="4%" rowspan="2" valign="bottom"><img src="../../images/vari_pre_inv.png" /></td>
        <td width="4%" rowspan="2" valign="bottom"><img src="../../images/vari_post_inv.png" /></td>
<!--        <td width="6%" rowspan="2" valign="bottom" class="bcgl1txt1"></td>
        <td width="7%" rowspan="2" valign="bottom" class="bcgl1txt1"></td>-->
      </tr>
      <tr class="bcgcolor-tblrowWhite">
        <td width="5%" height="168" ><span class="vertical-text" style="vertical-align:-40px; margin:0 0 0 -25px;">Processed Qty</span></td>
        <td width="2%" ><span class="vertical-text" style="vertical-align:-40px; margin:0 0 0 -25px;">Additional Qty</span></td>
        <td width="5%" ><span class="vertical-text" style="vertical-align:-50px; margin:0 0 0 -25px;">Unit Price $</span></td>
        <td width="5%" ><span class="vertical-text" style="vertical-align:-65px;">Value $</span></td>
        <td ><span class="vertical-text" style="vertical-align:-67px;">Con-Pc</span></td>
        <td  width="5%" ><span class="vertical-text" style="vertical-align:-50px; margin:0 0 0 -25px;">Unit Price $</span></td>
        <td width="4%" ><span class="vertical-text" style="vertical-align:-65px;">Value $</span></td>
      </tr>
	  <tr style="display:none">
	  	      <td colspan="21" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">

            <tr>
              <td width="15%" height="31"  bgcolor="#E6EEF0" class="normalfnt2BITAB">Order No </td>
              <td width="20%"  bgcolor="#E6EEF0" class="normalfnt2BITAB">Order Description </td>
              <td width="20%" bgcolor="#E6EEF0" class="normalfnt2BITAB" >Buyer</td>
              <td width="7%" bgcolor="#E6EEF0" class="normalfnt2BITAB" >Order Qty </td>
              <td width="7%" bgcolor="#E6EEF0" class="normalfnt2BITAB" >EX Qty </td>
              <td width="8%"  bgcolor="#E6EEF0" class="normalfnt2BITAB">Price US$  </td>
              <td width="13%" bgcolor="#E6EEF0" class="normalfnt2BITAB" >Shipment Date &amp; Qty </td>              
              <td width="7%" colspan="2"  bgcolor="#E6EEF0" class="normalfnt2BITAB">Shipped Qty </td>
              </tr>
<?php 
$sqlorders="select O.intStyleId,O.strDescription,O.strOrderNo,strBuyerOrderNo, ".
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
	
	$sqldelivery="SELECT concat(date(dtDateofDelivery),'-->',dblQty) AS DelivertDate FROM deliveryschedule where intStyleId='$pub_styleId' ".
				 "order By dtDateofDelivery ";
	$result_delivery=$db->RunQuery($sqldelivery);						
	while($row_delivery=mysql_fetch_array($result_delivery)){
	
		if($Printed==true){
			$StyleId		= "";
			$Description	= "";
			$BuyerName		= "";
			$Qty			= "";
			$ExQty			= "";			
		}
		$shipmentDetails =  getShippedQty($StyleId); 
		$arrShipDet = explode('**',$shipmentDetails);
		$shipQty = $arrShipDet[0];
		$comInvFob = $arrShipDet[1];
?>     
            <tr>
              <td bgcolor="#E6EEF0" class="normalfntTAB"><?php echo $orderNo;?></td>
              <td bgcolor="#E6EEF0" class="normalfntTAB"><?php echo $Description?></td>
              <td bgcolor="#E6EEF0" class="normalfntTAB"><?php echo $BuyerName?></td>
              <td bgcolor="#E6EEF0" class="normalfntRiteTAB"><?php echo $Qty?></td>
              <td bgcolor="#E6EEF0" class="normalfntRiteTAB"><?php echo $ExQty?></td>
              <td bgcolor="#E6EEF0" class="normalfntRiteTAB"><?php echo $comInvFob; ?></td>
              <td bgcolor="#E6EEF0" class="normalfntTAB"><?php echo $row_delivery["DelivertDate"]?></td> 
			   <?php  $Printed =true; ?>         
              <td bgcolor="#E6EEF0" class="normalfntRiteTAB"><?php echo $shipQty; ?></td>
              </tr>
<?php
}
}
?>

          </table></td>
	  </tr>
	    <?php
$loop=0;
$i=0;
$TotQty	=0.0;
$TotactualValue=0.0;
$TotVariation=0.0;
$totInvValue =0;
$totPreInvVariation =0;
$totInvPostVariation =0;

$sql_category="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID ".
			  "FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial)) ".
			  "INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID ".
			  "WHERE ((orderdetails.intStyleId)='$pub_styleId') ".
			  "ORDER BY matmaincategory.intID;";

$result_Category = $db->RunQuery($sql_category);
while($row_Category = mysql_fetch_array($result_Category)){
	$category=$row_Category["strDescription"];
	$categoryID=$row_Category["intID"];
?>
	  <tr class="backcolorWhite">
	  	<td height="20" class="normalfnt" bgcolor="#CCCCCC"><?php echo $category;?></td>
		<td colspan="20" class="normalfnt"></td>
	  </tr>
<?php
$sql_orderdetails="SELECT OD.strOrderNo, 
				 OD.intStyleId, 
				 OD.strUnit, 
				 OD.dblUnitPrice, 
				 OD.reaConPc, 
				 OD.reaWastage, 
				 OD.strCurrencyID, 
				 OD.intOriginNo, 
				 OD.dblFreight , 
				 OD.dblTotalQty, 
				 OD.dblReqQty, 
				 OD.dblTotalValue, 
				 OD.dbltotalcostpc, 
				 MIL.strItemDescription, 
				 MMC.strDescription, 
				 IP.strOriginType, 
				 MIL.intMainCatID, 
				 MIL.intItemSerial ,
				 (ICD.dblValue/12)*ICH.dblQty as invoiceCostValue,
				 ICD.reaConPc/12 as invConpc,ICD.dblUnitPrice as invUnitprice,
				 (select sum(ROD.dblTotalQty) from orderdetails_recut ROD inner join orders_recut ROH on ROH.intRecutYear=ROD.intRecutYear and ROH.intRecutNo=ROD.intRecutNo where OD.intStyleId=ROH.intStyleId and OD.intMatDetailID=ROD.intMatDetailID group by ROH.intStyleId,ROD.intMatDetailID)as recutQty
				 FROM ((orderdetails OD INNER JOIN matitemlist MIL ON OD.intMatDetailID = MIL.intItemSerial) 
				 INNER JOIN matmaincategory MMC ON MIL.intMainCatID = MMC.intID) 
				 INNER JOIN itempurchasetype IP ON OD.intOriginNo = IP.intOriginNo
				 left join invoicecostingdetails ICD on ICD.intStyleId=OD.intStyleId and ICD.strItemCode=OD.intMatDetailID
				 left join invoicecostingheader ICH on ICH.intStyleId = OD.intStyleId
				 WHERE ((OD.intStyleId)='$pub_styleId') AND ((MIL.intMainCatID)='$categoryID') 
				 ORDER BY MIL.strItemDescription;";
$result_order = $db->RunQuery($sql_orderdetails);
while($row_order = mysql_fetch_array($result_order)){
	$intMatDetailID =  $row_order["intItemSerial"];
?>
	  	<tr class="backcolorWhite">		
        <td class="normalfnt" nowrap="nowrap" id="<?php echo $row_order["intItemSerial"]?>">&nbsp;<?php echo $row_order["strItemDescription"]?></td>
        <td class="normalfnt"><?php echo $row_order["strOriginType"]?>
        <td class="normalfnt"><?php echo $row_order["strUnit"]?></td>
		<td class="normalfntRite"><?php echo number_format($row_order["reaConPc"],4)?></td>
		<td class="normalfntRite"><?php echo number_format($row_order["dblReqQty"],$deciQty);?></td>
		<td class="normalfntRite"><?php echo number_format($row_order["reaWastage"],$deciQty);?></td>
		<td class="normalfntRite"><?php
								 $QtyWaste=(round($row_order["dblReqQty"],2)+(round($row_order["dblReqQty"],2)*round($row_order["reaWastage"],2))/100);
									echo number_format($QtyWaste,$deciQty);
									?></td>
		<td class="normalfntRite"><?php echo number_format($row_order["dblTotalQty"],$deciQty)?></td>
		<td class="normalfntRite"><?php echo number_format($row_order["recutQty"],$deciQty)?></td>
		<td class="normalfntRite"><?php echo number_format($row_order["dblUnitPrice"],$deci)?></td>
		<td class="normalfntRite"><?php echo number_format($row_order["dblTotalValue"],$deci)?></td>
<?php
	$purchasedQty = 0;
	$averageValue = 0;
	$averagePrice = 0;
	$AdditionalQty = 0;
	$totValue=0;
	
	$purchDetails = getPostOrderItemDetails($pub_styleId,$intMatDetailID);
	$arrpurchDetails = explode('**',$purchDetails);
	$purchasedQty += $arrpurchDetails[1];
	$totValue += $arrpurchDetails[0];
	$averagePrice = round($totValue/$purchasedQty,4);
?>
		<td class="normalfntRite"><?php echo number_format($purchasedQty,$deciQty)?></td>
		<td class="normalfntRite"><?php echo number_format($AdditionalQty,$deciQty);?></td>
		<td class="normalfntRite"><?php echo number_format($averagePrice,$deci)?></td>
		<td class="normalfntRite"><?php 
				$actualValue= round($purchasedQty,$deciQty) * round($averagePrice,4);
				echo number_format($actualValue,$deci);
									?></td>
                                   
		<td class="normalfntRite"><?php $Variation	= round($row_order["dblTotalValue"],$deci) - round($actualValue,$deci); echo round($Variation,$deci);?></td>
         <td  class="normalfntRite"><?php echo number_format($row_order["invConpc"],$deci)?></td>
          <td  class="normalfntRite"><?php echo number_format($row_order["invUnitprice"],$deci)?></td>
		<td class="normalfntRite"><?php echo number_format($row_order["invoiceCostValue"],$deci)?></td>
	<td class="normalfntRite"><?php $PreInvVariation = $row_order["dblTotalValue"]-round($row_order["invoiceCostValue"],$deci);
		echo number_format($PreInvVariation,$deci);?></td>
        <td class="normalfntRite"><?php $InvPostVariation = $actualValue-round($row_order["invoiceCostValue"],$deci);
		echo number_format($InvPostVariation,$deci);?></td>
		<!--<td class="normalfntRiteTAB"></td>
		<td class="normalfntRiteTAB"></td>-->
      </tr>
<?php
$TotQty	+= round($row_order["dblTotalQty"],$deciQty);
$TotValue	+= round($row_order["dblTotalValue"],$deci);
$TotactualValue	+=round($actualValue,$deci);
$TotVariation	+=round($Variation,$deci);
$totInvValue += round($row_order["invoiceCostValue"],$deci);
$totPreInvVariation += round($PreInvVariation,$deci);
$totInvPostVariation += round($InvPostVariation,$deci);
$loop=0;
$i=0;
}
?>
	  <tr bgcolor="#EBEBEB">
	  	<td colspan="6" class="normalfnt">&nbsp;TOTAL</td>		
		<td class="normalfnt"></td>
		<td class="normalfntRite"><div align="right"><?php echo number_format($TotQty,$deciQty);?></div></td>
		<td class="normalfntRite">&nbsp;</td>
		<td class="normalfntRite">&nbsp;</td>
		<td class="normalfntRite"><div align="right"><?php echo number_format($TotValue,$deci);?></div></td>
		<td class="normalfntRite">&nbsp;</td>
		<td class="normalfntRite">&nbsp;</td>
		<td class="normalfntRite">&nbsp;</td>
		<td class="normalfntRite"><div align="right"><?php echo number_format($TotactualValue,$deci);?></div></td>
		<td class="normalfntRite"><div align="right"><?php echo number_format($TotVariation,$deci);?></div></td>
		<td class="normalfntRite">&nbsp;</td>
		<td class="normalfntRite">&nbsp;</td>
        <td class="normalfntRite"><div align="right"><?php echo number_format($totInvValue,$deci);?></div></td>
        <td class="normalfntRite"><div align="right"><?php echo number_format($totPreInvVariation,$deci);?></div></td>
        <td class="normalfntRite"><div align="right"><?php echo number_format($totInvPostVariation,$deci);?></div></td>    
		<!--<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>-->
	  </tr>
	  <tr bgcolor="#FFFFFF">
	    <td colspan="21" height="8"></td>
	    </tr> 
<?php
$GrandTotQty+=$TotQty;
$GrandTotValue+=$TotValue;
$GrandTotactualValue+=$TotactualValue;
$GrandTotVariation+=$TotVariation;
$grandInvValue += $totInvValue;
$grandPreInvVariation += $totPreInvVariation;
$grandInvPostVariation += $totInvPostVariation;
$TotQty	=0.0;
$TotValue=0.0;
$TotactualValue=0.0;
$TotVariation=0.0;
$totInvValue=0;
$totPreInvVariation =0;
$totInvPostVariation =0;
}
?>
	  <tr bgcolor="#EBEBEB">
	  	<td colspan="6" class="normalfnt">&nbsp;GRAND TOTAL</td>		
		<td class="normalfntRite"></td>
		<td class="normalfntRite"><div align="right"><?php echo number_format($GrandTotQty,$deciQty);?></div></td>
		<td class="normalfntRite">&nbsp;</td>
		<td class="normalfntRite"></td>
		<td class="normalfntRite"><div align="right"><?php echo number_format($GrandTotValue,$deci);?></div></td>
		<td class="normalfntRite"></td>
		<td class="normalfntRite"></td>
		<td class="normalfntRite"></td>
		<td class="normalfntRite"><div align="right"><?php echo number_format($GrandTotactualValue,$deci);?></div></td>
		<td class="normalfntRite"><div align="right"><?php echo number_format($GrandTotVariation,$deci);?></div></td>
		<td class="normalfntRite"></td>
		<td class="normalfntRite"></td>
        <td class="normalfntRite"><div align="right"><?php echo number_format($grandInvValue,$deci);?></div></td>
        <td class="normalfntRite"><div align="right"><?php echo number_format($grandPreInvVariation,$deci);?></div></td>
        <td class="normalfntRite"><div align="right"><?php echo number_format($grandInvPostVariation,$deci);?></div></td>
	  </tr> 
	  </table>

  </table></td>
  </tr>
</table>
<?php
function getPostOrderItemDetails($pub_styleId,$intMatDetailID)
{
// start 2011-09-13 get total purchased qty (normal po qty & value) ----------------------------------------------
	
	$poDetails = getPurchasedQty($pub_styleId,$intMatDetailID);
	$arrPODet = explode('**',$poDetails);
	$purchasedQty += $arrPODet[1];
	$totValue += $arrPODet[0];
// end 2011-09-13 get total purchased qty -------------------------------------------------

//start 2011-09-13 get total bulk allocation Qty and value --------------------------------------
	
	$bulkDetails = getBulkDetails($pub_styleId,$intMatDetailID);
	$arrBulk =  explode('**',$bulkDetails);
	$purchasedQty += $arrBulk[1];
	$totValue += $arrBulk[0];
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

	$arrPODet = $totValue.'**'.$purchasedQty;
	return $arrPODet; 
} 
function getPurchasedQty($pub_styleId,$intMatDetailID)
{
	global $db;
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
	$arrPODet = $totValue.'**'.$purchasedQty;
	return $arrPODet; 
}
function getBulkDetails($pub_styleId,$intMatDetailID)
{
	global $db;
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
	$arrPODet = $totValue.'**'.$purchasedQty;
	return $arrPODet; 
}
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

function getShippedQty($StyleId)
{
	$eshipDB = new eshipLoginDB();
	$sql = "select sum(cid.dblQuantity) as shipQty,dblUnitPrice from commercial_invoice_detail cid inner join
	 commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
inner join shipmentplheader plh on plh.strPLNo = cid.strPLNo
where plh.intStyleId='$StyleId' and cih.strInvoiceType='F' ";
	
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["shipQty"].'**'.$row["dblUnitPrice"];
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
function getPostOrderPrice($pub_styleId,$mainCatID,$financePct,$orderQty)
{
	global $db;
	$sql = " select od.intMatDetailID,i.intType from orderdetails od inner join matitemlist mil on 
mil.intItemSerial = od.intMatDetailID 
inner join itempurchasetype i on i.intOriginNo = od.intOriginNo
and od.intStyleId='$pub_styleId' and mil.intMainCatID='$mainCatID' ";
	
	$result = $db->RunQuery($sql);
	$financeVal = 0;
	while($row = mysql_fetch_array($result))
	{
		$poDetails = getPostOrderItemDetails($pub_styleId,$row["intMatDetailID"]);
		$arrpurchDetails = explode('**',$poDetails);
		$purchasedQty += $arrpurchDetails[1];
		$totValue += $arrpurchDetails[0];
		if($row["intType"]==0)
			$financeVal += ($arrpurchDetails[0]/$orderQty)*$financePct/100;
			
	}
	
	$price = $totValue/$orderQty;
	return $price.'*'.$financeVal;
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

function GetShipPrice($pub_styleId)
{
	$eshipDB = new eshipLoginDB();
	$sql = " select  dblUnitPrice from commercial_invoice_detail cid inner join
	 commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
inner join shipmentplheader plh on plh.strPLNo = cid.strPLNo
where plh.intStyleId='$pub_styleId' and cih.strInvoiceType='F' group by plh.intStyleId ";
	
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["dblUnitPrice"];
}

function GetRecutQty($pub_styleId)
{
global $db;
$sql="select sum(RO.intRecutQty) as recutQty 
from orders_recut RO
where RO.intStyleId='$pub_styleId'
group by RO.intStyleId";
$result = $db->RunQuery($sql);
$row = mysql_fetch_array($result);
return $row["recutQty"];
}
?>
</body>
</html>