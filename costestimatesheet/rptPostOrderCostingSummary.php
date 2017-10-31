<?php 
session_start();
include "../Connector.php";
$pub_styleId		= $_GET["StyleID"];
$buyer = $_GET["buyer"];
$styleName = $_GET["styleName"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Post Order Costing Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0">
  <tr>
    <td height="53" class="head2">Post Order Costing Summary Report     
  <tr>
    <td height="53"><table width="100%" border="0" class="tablez" cellspacing="0">
      <tr>
        <td width="3%" rowspan="2" class="bcgl1txt1" height="168"><span class="vertical-text1" style="vertical-align:-114px;">Orit Order No </span></td>
        <td width="4%" rowspan="2" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-129px;">Order No </span></td>
        <td width="5%" rowspan="2" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-129px;">Style No </span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-99px;">Style Description </span></td>
        <td width="2%" rowspan="2" class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-130px; margin:0 0 0 -15px;">Division</span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-125px; margin:0 0 0 -20px;">Order Qty</span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-120px;  margin:0 0 0 -15px;">Excess[%]</span></td>
        <td width="5%" rowspan="2" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-95px; margin:0 0 0 -25px;" >Excess Qty [Pc's]</span></td>
        <td height="27" colspan="4" class="bcgl1txt1B">PRE ORDER (PC's)</td>
        <td colspan="5" class="bcgl1txt1B">POST ORDER</td>
        <td colspan="6" class="bcgl1txt1B">INVOICE</td>
      </tr>
      <tr>
        <td width="5%" height="279"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-78px; margin:0 0 0 -25px;">Total Material Cost</span></td>
        <td width="2%"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-135px; margin:0 0 0 5px;">CM</span></td>
        <td width="5%"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-125px; margin:0 0 0 5px;">Profit</span></td>
        <td width="5%"  class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-130px;">FOB</span></td>
        <td  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-78px;">Total Material Cost</span></td>
        <td  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-135px;">CM</span></td>
        <td  width="5%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-125px; margin:0 0 0 -5px;">Profit</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-5px;">Varience [Pre vs Post - Material Cost]</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-40px;">Varience [Pre vs Post - Profit]</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-80px;">Total Material Cost</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-137px;">CM</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-130px;">Profit</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-133px;">FOB</span></td>
         <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-50px;">Varience [Pre vs Inv - FOB]</span></td>
          <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-25px;">Varience [Inv vs Post - Material]</span></td>
      </tr>
<!--      <tr>
        <td colspan="21" class="bcgl1txt1">&nbsp;</td>
      </tr>-->
      
     <?php 
	 $sql = "select o.intStyleId,concat(date_format(o.dtmOrderDate,'%Y%m'),'',o.intCompanyOrderNo)as oritOrderNo,o.strOrderNo,
o.strStyle,o.strDescription,dv.strDivision,o.intQty as orderQty,o.reaExPercentage ,round(o.intQty*o.reaExPercentage/100) as exQty,
(select round(sum(od.dblTotalValue),4) from orderdetails od where od.intStyleId=o.intStyleId) as preMaterialCost,
round(o.reaSMV*o.reaSMVRate,4) as preCMvalue,o.dblFacProfit as preProfit,o.reaFOB as preFob,
round(ih.dblTotalCostValue*ih.dblQty) as invMatcost,ih.dblTotalCostValue as invFob,o.dblActualEfficencyLevel,ih.dblNewCM
from orders o inner join buyerdivisions dv on 
dv.intDivisionId = o.intDivisionId and dv.intBuyerID = o.intBuyerID
left join invoicecostingheader ih on ih.intStyleId= o.intStyleId where o.intStyleId>0 ";
	if($buyer != '')
		$sql .= " and o.intBuyerID = '$buyer' ";
	if($styleName != '')
		$sql .= " and o.strStyle = '$styleName' ";	
	$sql .= " order by o.strOrderNo ";
	
	$result = $db->RunQuery($sql);						
	while($row=mysql_fetch_array($result)){
		$pub_styleId = $row["intStyleId"];
		$url = "postordercostingRpt.php?&StyleID=".$row["intStyleId"];
	 ?>
       <tr>
        <td class="normalfntTAB" nowrap="nowrap"><a href="<?php echo $url; ?>" target="postordercostingRpt.php"><?php echo $row["oritOrderNo"]; ?></a></td>
        <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["strOrderNo"]; ?></td>
        <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["strStyle"]; ?></td>
        <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["strDescription"]; ?></td>
        <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["strDivision"]; ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["orderQty"],0); ?></td>
        <td class="normalfntRiteTAB"><?php echo $row["reaExPercentage"]; ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["exQty"],0); ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["preMaterialCost"],4); ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["preCMvalue"],4); ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["preProfit"],4); ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["preFob"],2); ?></td>
        <td  class="normalfntRiteTAB">
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
	/*$interjobDet = getInterJobWAprice($pub_styleId);
	$arrInterjobDet = explode('**',$interjobDet);
	$purchasedQty += $arrInterjobDet[1];
	$totValue += $arrInterjobDet[0];*/
//end 2011-09-13 total interjob transfer in qty and value
echo number_format($totValue,4);
		?>
        </td>
        <td  class="normalfntRiteTAB"><?php 
		$actCM = $row["preCMvalue"]/100*$row["dblActualEfficencyLevel"];
		echo number_format($actCM,4);
		?></td>
        <td  class="normalfntRiteTAB"><?php 
		$preorderMaterialCost = $row["preMaterialCost"];
		$preorderProfit = $row["preProfit"];
		$postProfit = $preorderProfit + ($preorderMaterialCost - $totValue);
		echo number_format($postProfit,4);
		?></td>
        <td class="normalfntRiteTAB"><?php 
		$matVariPostorder = ($preorderMaterialCost - $totValue);
		echo  number_format($matVariPostorder,4); ?></td>
        <td class="normalfntRiteTAB"><?php 
		$profitVariPost = $preorderProfit-$postProfit;
		echo number_format($profitVariPost,4); ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["invMatcost"],4); ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["dblNewCM"],4) ?></td>
        <td class="normalfntRiteTAB">
        <?php 
		$invMatVarience = $preorderMaterialCost-$row["invMatcost"];
		$invProfit = $preorderProfit + $invMatVarience;
		echo number_format($invProfit,4);
		?>
        </td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["invFob"],2); ?></td>
        <td class="normalfntRiteTAB"><?php 
		$invFobVari = $row["preFob"]- $row["invFob"];
		echo number_format($invFobVari,4);
		?></td>
        <td class="normalfntRiteTAB">
        <?php 
		$invPreMatVari = ($row["invMatcost"]-$totValue);
		echo number_format($invPreMatVari,4); ?></td>
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
      <tr>
        <td colspan="12" height="7"></td>
      </tr>
      <tr>
        <td colspan="5" class="normalfntBtab">TOTAL</td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totOrderQty,0); ?></td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totExQty,0); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totPreMatCost,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totPreCM,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totPreProfit,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totPreFOB,2); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totPostMatCost,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totPostCM,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totPastProfit,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totmatVariPostorder,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totprofitVariPost,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totInvMatcost,4); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totInvCM,4); ?></td>  
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totinvProfit,4); ?></td>
         <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totInvFob,2); ?></td>
        <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totinvFobVari,4); ?></td>
         <td class="normalfntBtab" style="text-align:right"><?php echo number_format($totinvPreMatVari,4); ?></td>
         
      </tr>
      <tr style="display:none">
        <td colspan="5" class="normalfntBtab">GRAND TOTAL</td>
        <td class="normalfntRiteTAB">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
         <td class="normalfntBtab">&nbsp;</td>
          <td class="normalfntBtab">&nbsp;</td>
      </tr>
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
?>
</body>
</html>
