<?php 
session_start();
include "../../Connector.php";
			
$pub_styleId		= $_GET["StyleID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Post Order Costing Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
	border:0px solid black;
	writing-mode:tb-rl;
	-webkit-transform:rotate(90deg);
	-moz-transform:rotate(270deg);
	-o-transform: rotate(90deg);
	white-space:nowrap;
	display:inline;
	bottom:100px;
	width:10px;
	height:20px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
	font-weight:bold;
/*	text-shadow: 0px 0px 1px #333;*/
}

</style>
</head>
<body>
<table width="1100" border="0" align="center" cellpadding="0">
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
    <td height="53" colspan="19"><table width="100%" border="0" class="tablez" cellspacing="0">
      <tr>
        <td width="18%" rowspan="2" align="left" valign="bottom" class="bcgl1txt1B"><img src="../../images/items.png" alt="items" /></td>
        <td width="3%" rowspan="2" class="bcgl1txt1"><span class="vertical-text">Origin</span></td>
        <td width="4%" rowspan="2" class="bcgl1txt1"><span class="vertical-text">Unit</span></td>
        <td width="5%" rowspan="2" valign="bottom" class="bcgl1txt1"><img src="../../images/con-pc.png" alt="conpc" /></td>
        <td width="5%" rowspan="2" valign="bottom" class="bcgl1txt1"><img src="../../images/qty.png" alt="qty" /></td>
        <td width="2%" rowspan="2" valign="bottom" class="bcgl1txt1"><img src="../../images/wastage.png" alt="wastage" /></td>
        <td width="5%" rowspan="2" valign="bottom" class="bcgl1txt1"><img src="../../images/qty_wastage.png" alt="qty_wastage" /></td>
        <td width="5%" rowspan="2" valign="bottom" class="bcgl1txt1"><img src="../../images/total_qty.png" alt="total_qty" /></td>
        <td width="5%" rowspan="2" valign="bottom" class="bcgl1txt1"><img src="../../images/unitprice.png" alt="unitprice"/></td>
        <td width="5%" rowspan="2" valign="bottom" class="bcgl1txt1"><img src="../../images/value.png" alt="value"/></td>
        <td colspan="4" class="bcgl1txt1B">ACTUAL</td>
        <td width="5%" rowspan="2" valign="bottom" class="bcgl1txt1"><img src="../../images/variationhead.png" alt="variation"/></td>
        <td colspan="2" class="bcgl1txt1B">INVOICE COSTING</td>
<!--        <td width="6%" rowspan="2" valign="bottom" class="bcgl1txt1"></td>
        <td width="7%" rowspan="2" valign="bottom" class="bcgl1txt1"></td>-->
      </tr>
      <tr>
        <td width="5%" valign="bottom" class="bcgl1txt1"><img src="../../images/total_qty.png" alt="total_qty"/></td>
        <td width="2%" valign="bottom" class="bcgl1txt1"><img src="../../images/additionalqty.png" alt="additionalqty" /></td>
        <td width="5%" valign="bottom" class="bcgl1txt1"><img src="../../images/unitprice.png" alt="unitprice"/></td>
        <td width="5%" valign="bottom" class="bcgl1txt1" ><img src="../../images/value.png" alt="value"/></td>
        <td width="4%" class="bcgl1txt1"><img src="../images/value.png" alt="value"/></td>
        <td width="4%" valign="bottom" class="bcgl1txt1"><img src="../../images/variationhead.png" alt="variation"/></td>
      </tr>
	  <tr>
          <td class="normalfnBLD1">&nbsp;</td>	
		</tr>
	  <tr>
	  	      <td colspan="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">

            <tr>
              <td width="15%" height="31"  bgcolor="#E6EEF0" class="normalfnt2BITAB">Order No </td>
              <td width="20%"  bgcolor="#E6EEF0" class="normalfnt2BITAB">Order Description </td>
              <td width="20%" bgcolor="#E6EEF0" class="normalfnt2BITAB" >Buyer</td>
              <td width="7%" bgcolor="#E6EEF0" class="normalfnt2BITAB" >Order Qty </td>
              <td width="7%" bgcolor="#E6EEF0" class="normalfnt2BITAB" >EX Qty </td>
              <td width="8%"  bgcolor="#E6EEF0" class="normalfnt2BITAB">Price US$  </td>
              <td width="13%" bgcolor="#E6EEF0" class="normalfnt2BITAB" >Shipment Date &amp; Qty </td>              
              <td width="7%"  bgcolor="#E6EEF0" class="normalfnt2BITAB">Ship Qty </td>
              </tr>
<?php 
$sqlorders="select O.intStyleId,O.strDescription,O.strOrderNo, ".
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
              <td bgcolor="#E6EEF0" class="normalfntRiteTAB"></td>
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
		<td colspan="16" class="bcgl1txt1"></td>
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
				 (ICD.dblValue/12)*OD.dblReqQty as invoiceCostValue
				 FROM ((orderdetails OD INNER JOIN matitemlist MIL ON OD.intMatDetailID = MIL.intItemSerial) 
				 INNER JOIN matmaincategory MMC ON MIL.intMainCatID = MMC.intID) 
				 INNER JOIN itempurchasetype IP ON OD.intOriginNo = IP.intOriginNo
				 left join invoicecostingdetails ICD on ICD.intStyleId=OD.intStyleId and ICD.strItemCode=OD.intMatDetailID
				 WHERE ((OD.intStyleId)='$pub_styleId') AND ((MIL.intMainCatID)='$categoryID') 
				 ORDER BY MIL.strItemDescription;";
$result_order = $db->RunQuery($sql_orderdetails);
while($row_order = mysql_fetch_array($result_order)){
	$intMatDetailID =  $row_order["intItemSerial"];
?>
	  	<tr>		
        <td class="normalfntTAB" id="<?php echo $row_order["intItemSerial"]?>"><?php echo $row_order["strItemDescription"]?></td>
        <td class="normalfntMidTAB"><?php echo $row_order["strOriginType"]?>
        <td class="normalfntMidTAB"><?php echo $row_order["strUnit"]?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["reaConPc"],4)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblReqQty"],0)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["reaWastage"],0)?></td>
		<td class="normalfntRiteTAB"><?php
								 $QtyWaste=(round($row_order["dblReqQty"],2)+(round($row_order["dblReqQty"],2)*round($row_order["reaWastage"],2))/100);
									echo number_format($QtyWaste,0);
									?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblTotalQty"],2)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblUnitPrice"],4)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblTotalValue"],4)?></td>
<?php
	$purchasedQty = 0;
	$averageValue = 0;
	$averagePrice = 0;
	$AdditionalQty = 0;
	$totValue=0;
	
//	 $sql_leftovers = "select sum(dblQty)as leftQty from commonstock_leftoverheader LH 
//	 					inner join commonstock_leftoverdetails LD on LH.intTransferNo = LD.intTransferNo AND LH.intTransferYear = LD.intTransferYear 
//					  where LD.intMatDetailId = '" . $row_order["intItemSerial"] . "' and LH.intToStyleId = '$pub_styleId'";					  
//	$result_leftovers = $db->RunQuery($sql_leftovers);
//    while($row_leftovers = mysql_fetch_array($result_leftovers))
//    {
// 		$leftQty = $row_leftovers["leftQty"];
//    }
//	
//   $sql_bulk = "select sum(dblQty)as bulkQty 
//   				from commonstock_bulkheader BH 
//   				inner join commonstock_bulkdetails BD on BH.intTransferNo = BD.intTransferNo AND BH.intTransferYear = BD.intTransferYear 
//				where BD.intMatDetailId = '" . $row_order["intItemSerial"] . "' and BH.intToStyleId='$pub_styleId'";
//					  
//	$result_bulk = $db->RunQuery($sql_bulk);
//    while($row_bulk = mysql_fetch_array($result_bulk))
//    {
//    	$bulkQty = $row_bulk["bulkQty"];
//    }	
//	
//	 $sql_interjob = "select sum(dblQty)as interjobQty 
//	 				from itemtransfer TH 
//					inner join itemtransferdetails TD on TH.intTransferId = TD.intTransferId AND TH.intTransferYear = TD.intTransferYear 
//					 where TD.intMatDetailId = '" . $row_order["intItemSerial"] . "' and TH.intStyleIdTo = '$pub_styleId'";					  
//	$result_interjob = $db->RunQuery($sql_interjob);
//    while($row_interjob = mysql_fetch_array($result_interjob))
//    {
//   		$interjobQty = $row_interjob["interjobQty"];
//    }
//
//	 $purchasedQty += $leftQty+$bulkQty+$interjobQty;
//	   
//	
//	 $sqlcurrency = "SELECT DISTINCT PD.intPoNo,PD.intYear,PH.strCurrency 
//	 				FROM purchaseorderdetails PD 
//					INNER JOIN purchaseorderheader PH ON PD.intPONo = PH.intPONo  
//					WHERE PD.intStyleId = '$pub_styleId'  AND PD.intMatDetailID = '" . $row_order["intItemSerial"] . "'  AND PD.intPOType=0 and PH.intStatus = 10;";	
//	$resultcur = $db->RunQuery($sqlcurrency);	
//	
//	while($rowcur = mysql_fetch_array($resultcur))
//	{
//		$loop++;
//		$sqlpurch = "select COALESCE(Sum(PD.dblQty),0) as purchasedQty,COALESCE(Sum(PD.dblAdditionalQty),0) as AdditionalQty, COALESCE(sum(PD.dblUnitPrice * PD.dblQty),0) as avgValue 
//		from purchaseorderdetails PD 
//		inner join purchaseorderheader PH on PH.intPONo = PD.intPONo 
//		where PD.intStyleId = '$pub_styleId' AND PD.intMatDetailID = '" . $row_order["intItemSerial"] . "' AND PD.intPOType=0 and PH.intStatus = 10 AND PD.intPONo = " . $rowcur["intPoNo"] . " AND PD.intYear=".$rowcur["intYear"].";";
//	
//		
//		$resultpurch = $db->RunQuery($sqlpurch);
//		
//		while($rowpurch = mysql_fetch_array($resultpurch))
//		{
//			$dollarRate = 1;
//			if ( $rowcur["strCurrency"] != "USD")
//			{
//				$sql = "SELECT dblRate FROM currencytypes WHERE strCurrency = '". $rowcur["strCurrency"] . "'";
//				$rst = $db->RunQuery($sql);
//				while($rw = mysql_fetch_array($rst))
//				{
//					$dollarRate = $rw["dblRate"];
//					break;
//				}
//			}
//			
//			$purchasedQty += $rowpurch["purchasedQty"];
//			$AdditionalQty += $rowpurch["AdditionalQty"];
//			$averageValue += $rowpurch["avgValue"] / $dollarRate;
//			$averagePrice = $averageValue/$purchasedQty;
//			if ($purchasedQty > 0)
//			$isPurchased = true;
//			
//		}	
//	}

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
		<td class="normalfntRiteTAB"><?php echo number_format($purchasedQty,2)?></td>
		<td class="normalfntRiteTAB"><?php echo $AdditionalQty;?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($averagePrice,4)?></td>
		<td class="normalfntRiteTAB"><?php 
				$actualValue= round($purchasedQty,2) * round($averagePrice,4);
				echo number_format($actualValue,4);
									?></td>
		<td class="normalfntRiteTAB"><?php $Variation	= round($row_order["dblTotalValue"],4) - round($actualValue,4); echo round($Variation,4);?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["invoiceCostValue"],4)?></td>
		<td class="normalfntRiteTAB"><?php echo number_format($row_order["dblTotalValue"]-round($row_order["invoiceCostValue"],4),4)?></td>
		<!--<td class="normalfntRiteTAB"></td>
		<td class="normalfntRiteTAB"></td>-->
      </tr>
<?php
$TotQty	+= round($row_order["dblTotalQty"],2);
$TotValue	+= round($row_order["dblTotalValue"],2);
$TotactualValue	+=round($actualValue,2);
$TotVariation	+=round($Variation,2);
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
		<td class="normalfntBtab"><div align="right"><?php echo $TotQty;?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="normalfntBtab"><div align="right"><?php echo $TotValue;?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<td class="normalfntBtab"><div align="right"><?php echo $TotactualValue;?></div></td>
		<td class="normalfntBtab"><div align="right"><?php echo $TotVariation;?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<!--<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>-->
	  </tr> 
<?php
$GrandTotQty+=$TotQty;
$GrandTotValue+=$TotValue;
$GrandTotactualValue+=$TotactualValue;
$GrandTotVariation+=$TotVariation;
$TotQty	=0.0;
$TotValue=0.0;
$TotactualValue=0.0;
$TotVariation=0.0;
}
?>
	  <tr>
	  	<td colspan="6" class="normalfntBtab">GRAND TOTAL</td>		
		<td class="normalfntRiteTAB"></td>
		<td class="normalfntBtab"><div align="right"><?php echo $GrandTotQty;?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="normalfntBtab"><div align="right"><?php echo $GrandTotValue;?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
		<td class="normalfntBtab"><div align="right"><?php echo $GrandTotactualValue;?></div></td>
		<td class="normalfntBtab"><div align="right"><?php echo $GrandTotVariation;?></div></td>
		<td class="bcgl1txt1"></td>
		<td class="bcgl1txt1"></td>
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
?>

</body>
</html>
