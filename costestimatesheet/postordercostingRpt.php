<?php 
session_start();
include "../Connector.php";
include '../eshipLoginDB.php';
			
$pub_styleId		= $_GET["StyleID"];
$deciQty=0;
$deci=4;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Post Order Costing Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}
</script>
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
	/*	text-shadow: 0px 0px 1px #333;*/
}

</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0">
  <table align="center" width="100%" border="0">
<tr>
<td align="center" >&nbsp;</td>				
</tr>

<tr>
 <td align="center" >&nbsp;</td>
</tr>
<tr>
 <td align="center" class="head2">Post Order Costing</td>
 </tr>

</table>


  <tr>
    <td height="53" colspan="20"><table width="100%" border="0" class="tablez" cellspacing="0">
      <tr>
        <td width="18%" rowspan="2" align="left" valign="bottom" class="bcgl1txt1B"><img src="../images/items.png" alt="items" /></td>
        <td width="3%" rowspan="2" class="bcgl1txt1" height="25"><span class="vertical-text" style="vertical-align:-85px;">Origin</span></td>
        <td width="4%" rowspan="2" class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-92px;">Unit</span></td>
        <td width="5%" rowspan="2" class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-80px;">Con-Pc</span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-95px;">Qty</span></td>
        <td width="2%" rowspan="2" class="bcgl1txt1" ><span class="vertical-text" style="vertical-align:-63px; margin:0 0 0 -25px;">Wastage %</span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-50px; margin:0 0 0 -35px;">Qty + Wastage</span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-72px;  margin:0 0 0 -15px;">Total Qty</span></td>
        <td width="5%" rowspan="2" class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-62px; margin:0 0 0 -25px;" >Unit Price $</span></td>
        <td width="5%" rowspan="2" class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-80px;" >Value $</span></td>
        <td colspan="4" class="bcgl1txt1B" height="25">ACTUAL</td>
        <td width="5%" rowspan="2" class="bcgl1txt1"><span class="vertical-text"  style="vertical-align:-20px; margin:0 0 0 -25px;">Varience(Pre Vs Post)</span></td>
        <td colspan="3" class="bcgl1txt1B">INVOICE COSTING</td>
        <td width="4%" rowspan="2" class="bcgl1txt1B"><span class="vertical-text"  style="vertical-align:-24px; margin:0 0 0 -25px;">Varience(Pre Vs Inv)</span></td>
        <td width="4%" rowspan="2" class="bcgl1txt1B"><span class="vertical-text"  style="vertical-align:-20px; margin:0 0 0 -25px;">Varience(Post Vs Inv)</span></td>
<!--        <td width="6%" rowspan="2" valign="bottom" class="bcgl1txt1"></td>
        <td width="7%" rowspan="2" valign="bottom" class="bcgl1txt1"></td>-->
      </tr>
      <tr>
        <td width="5%" height="168"  class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-40px; margin:0 0 0 -25px;">Processed Qty</span></td>
        <td width="2%"  class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-40px; margin:0 0 0 -25px;">Additional Qty</span></td>
        <td width="5%"  class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-50px; margin:0 0 0 -25px;">Unit Price $</span></td>
        <td width="5%"  class="bcgl1txt1" ><span class="vertical-text" style="vertical-align:-65px;">Value $</span></td>
        <td  class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-67px;">Con-Pc</span></td>
        <td  width="5%" class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-50px; margin:0 0 0 -25px;">Unit Price $</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text" style="vertical-align:-65px;">Value $</span></td>
        </tr>
	  <tr>
          <td class="normalfnBLD1">&nbsp;</td>	
		</tr>
	  <tr>
	  	      <td colspan="20"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">

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
		$shipQty = getShippedQty($buyerOrderNo); 
?>     
            <tr>
              <td bgcolor="#E6EEF0" class="normalfntTAB"><?php echo $orderNo;?></td>
              <td bgcolor="#E6EEF0" class="normalfntTAB"><?php echo $Description?></td>
              <td bgcolor="#E6EEF0" class="normalfntTAB"><?php echo $BuyerName?></td>
              <td bgcolor="#E6EEF0" class="normalfntRiteTAB"><?php echo $Qty?></td>
              <td bgcolor="#E6EEF0" class="normalfntRiteTAB"><?php echo $ExQty?></td>
              <td bgcolor="#E6EEF0" class="normalfntRiteTAB"></td>
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
	    <tr>
          <td class="normalfnBLD1">&nbsp;</td>	
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
	  <tr>
	  	<td class="normalfnt2BITAB"><div align="left"><?php echo $category;?></div></td>
		<td colspan="19" class="bcgl1txt1"></td>
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
				 ICD.reaConPc/12 as invConpc,ICD.dblUnitPrice as invUnitprice
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
	  	<tr>		
        <td class="normalfntTAB" nowrap="nowrap" id="<?php echo $row_order["intItemSerial"]?>"><?php echo $row_order["strItemDescription"]?></td>
        <td class="normalfntMidTAB"><?php echo $row_order["strOriginType"]?>
        <td class="normalfntMidTAB"><?php echo $row_order["strUnit"]?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["reaConPc"],4)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblReqQty"],$deciQty);?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["reaWastage"],$deciQty);?></td>
		<td class="normalfntRiteTAB"><?php
								 $QtyWaste=(round($row_order["dblReqQty"],2)+(round($row_order["dblReqQty"],2)*round($row_order["reaWastage"],2))/100);
									echo number_format($QtyWaste,$deciQty);
									?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblTotalQty"],$deciQty)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblUnitPrice"],$deci)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblTotalValue"],$deci)?></td>
<?php
	$purchasedQty = 0;
	$averageValue = 0;
	$averagePrice = 0;
	$AdditionalQty = 0;
	$totValue=0;
	
// start 2011-09-13 get total purchased qty (normal po qty & value) ----------------------------------------------
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
?>
		<td class="normalfntRiteTAB"><?php echo number_format($purchasedQty,$deciQty)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($AdditionalQty,$deciQty);?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($averagePrice,$deci)?></td>
		<td class="normalfntRiteTAB"><?php 
				$actualValue= round($purchasedQty,$deciQty) * round($averagePrice,4);
				echo number_format($actualValue,$deci);
									?></td>
                                   
		<td class="normalfntRiteTAB"><?php $Variation	= round($row_order["dblTotalValue"],$deci) - round($actualValue,$deci); echo round($Variation,$deci);?></td>
         <td  class="normalfntRiteTAB"><?php echo number_format($row_order["invConpc"],$deci)?></td>
          <td  class="normalfntRiteTAB"><?php echo number_format($row_order["invUnitprice"],$deci)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["invoiceCostValue"],$deci)?></td>
	<td class="normalfntRiteTAB"><?php $PreInvVariation = $row_order["dblTotalValue"]-round($row_order["invoiceCostValue"],$deci);
		echo number_format($PreInvVariation,$deci);?></td>
        <td class="normalfntRiteTAB"><?php $InvPostVariation = $actualValue-round($row_order["invoiceCostValue"],$deci);
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
	<tr>
	<td colspan="14" height="7"></td>
	</tr>
	  <tr>
	  	<td colspan="6" class="normalfntBtab">TOTAL</td>		
		<td class="normalfntRiteTAB"></td>
		<td class="normalfntBtab"><div align="right"><?php echo number_format($TotQty,$deciQty);?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="normalfntBtab"><div align="right"><?php echo number_format($TotValue,$deci);?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<td class="normalfntBtab"><div align="right"><?php echo number_format($TotactualValue,$deci);?></div></td>
		<td class="normalfntBtab"><div align="right"><?php echo number_format($TotVariation,$deci);?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
        <td class="normalfntBtab"><div align="right"><?php echo number_format($totInvValue,$deci);?></div></td>
        <td class="normalfntBtab"><div align="right"><?php echo number_format($totPreInvVariation,$deci);?></div></td>
        <td class="normalfntBtab"><div align="right"><?php echo number_format($totInvPostVariation,$deci);?></div></td>    
		<!--<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>-->
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
	  <tr>
	  	<td colspan="6" class="normalfntBtab">GRAND TOTAL</td>		
		<td class="normalfntRiteTAB"></td>
		<td class="normalfntBtab"><div align="right"><?php echo number_format($GrandTotQty,$deciQty);?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="normalfntBtab"><div align="right"><?php echo number_format($GrandTotValue,$deci);?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<td class="normalfntBtab"><div align="right"><?php echo number_format($GrandTotactualValue,$deci);?></div></td>
		<td class="normalfntBtab"><div align="right"><?php echo number_format($GrandTotVariation,$deci);?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
        <td class="normalfntBtab"><div align="right"><?php echo number_format($grandInvValue,$deci);?></div></td>
         <td class="normalfntBtab"><div align="right"><?php echo number_format($grandPreInvVariation,$deci);?></div></td>
        <td class="normalfntBtab"><div align="right"><?php echo number_format($grandInvPostVariation,$deci);?></div></td>
		<!--<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>-->
	  </tr> 

	  </table>

    </table></td>
  </tr>
</table>
<?php 
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
?>

</body>
</html>
