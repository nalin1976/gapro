<?php
session_start();
include "../../Connector.php";
$backwardseperator = '../../';
$report_companyId = $_SESSION["FactoryID"];
$styleId		= $_GET["orderNo"];
$reportCat		= $_GET["ReportCat"];
$fob_update		= $_GET["fob_update"];

$deci			= 4;
$deciT			= ($reportCat=='1'?2:4);
$cVisibility	= ($reportCat=='1'?"style='visibility:hidden'":"style='visibility:visible'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Invoice Costing Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>

<blockquote>
  <form id="invoiceCostingReport" name="invoiceCostingReport" action="" >
    <table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td><?php include "../../reportHeader.php"?></td>
      </tr>
<?PHP
$sql_header="select C.strName,O.strStyle as pono,O.strOrderNo as style,strFabric,IH.dblNewCM,IH.dblFOB,IH.dblQty,IH.dblReduceCM,IH.strDescription
from invoicecostingheader IH 
inner join  orders O on IH.intStyleId=O.intStyleId
inner join companies C on C.intCompanyID=O.intCompanyID
where IH.intStyleId='$styleId'";
$result_header=$db->RunQuery($sql_header);
while($row_header=mysql_fetch_array($result_header))
{
	$factoryName 	= $row_header["strName"];
	$pono 			= $row_header["pono"];
	$style 			= $row_header["style"];
	$mainFabric 	= $row_header["strFabric"];
	$cm 			= $row_header["dblNewCM"];
	$fob 			= $row_header["dblFOB"];
	$qty 			= $row_header["dblQty"];
	$reduceCM		= $row_header["dblNewCM"]*12;	
	$remarks		= $row_header["strDescription"];
}
?>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0" rules="groups">
            <tr>
              <td width="15">&nbsp;</td>
              <td width="127" class="bcgl1txt1NB">Factory</td>
              <td width="8"><b>:</b></td>
              <td width="790" class="normalfnt">&nbsp;<?php echo $factoryName;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">PO No</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $style;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">Style</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $pono;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">Fabric</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $mainFabric;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">CM</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $cm;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">Final FOB</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $fob;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">Order Qty</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $qty;?></td>
            </tr>
          </table></td>
      </tr>
	  <tr>
	  	<td height="1">&nbsp;</td>
	  </tr>
	  <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="2" rules="all">
		 <THEAD>
		  <tr>
			<td width="2%" bgcolor="#CCCCCC" class="bcgl1txt1B">No</td>
			<td width="58%" bgcolor="#CCCCCC" class="bcgl1txt1B">Item Description</td>
			<td width="9%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Consumption<br />Per Doz</td>
			<td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">Unit Price<br />Per Pcs</td>
			<td width="6%" bgcolor="#CCCCCC" class="bcgl1txt1B">Wastage<br/>%</td>
			<td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">Finance<br/>%</td>
		    <td width="10%" bgcolor="#CCCCCC" class="bcgl1txt1B">Price<br/>
		      Per Doz</td>
		  </tr>
		  </THEAD>
<?php
$sql_1="select distinct IC.intCategoryId,IC.intCategoryName from invoicecostingcategory IC
inner join invoicecostingdetails ID on ID.strType=IC.intCategoryId
where IC.intStatus=1 and ID.intStyleId ='$styleId' and IC.intCategoryId in(1,2,3,4) order by IC.intOrderId";
$result_1=$db->RunQuery($sql_1);
while($row_1=mysql_fetch_array($result_1))
{
	$categoryId	= $row_1["intCategoryId"];
	$mainCategoryName = $row_1["intCategoryName"];
?>
	<tr>
		<td>&nbsp;</td>
		<td colspan="6" class="normalfnth2"><?php echo $mainCategoryName;?></td>
	</tr>
	<?php
	$sql_2="select distinct IP.intType
			from invoicecostingdetails ID
			inner join itempurchasetype IP on IP.intOriginNo=ID.intOrigin
			where ID.intStyleId='$styleId'
			and strType=$categoryId";		
	$result_2=$db->RunQuery($sql_2);
	
	while($row_2=mysql_fetch_array($result_2))
	{
		//$originType = $row_2["intOrigin"];
		if($categoryId!=1)
		{
			$categoryName = ($row_2["intType"]== 0 ? "Imported":"Local");
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td colspan=\"6\" class=\"normalfntLeftRedSmall\">&nbsp;&nbsp;$categoryName</td>";
			echo "</tr>";
		}
		else
		{
			$categoryName ="";		
		}
	?>

	<?php
		$totPricePerDoz = 0;
		$totConPc = 0;
		$totWastage = 0;
		$totFinancePercent = 0;
		
		$sql_3="select MIL.strItemDescription,reaConPc,ID.dblUnitPrice,ID.reaWastage,dblFinance
		from invoicecostingdetails ID 
		inner join matitemlist MIL on MIL.intItemSerial=ID.strItemCode
		inner join itempurchasetype IP on IP.intOriginNo=ID.intOrigin
		where ID.intStyleId='$styleId'
		and ID.strType='$categoryId'
		and IP.intType='".$row_2["intType"]."'
		order by MIL.strItemDescription";
		//echo $sql_3;
		$result_3=$db->RunQuery($sql_3);
		while($row_3=mysql_fetch_array($result_3))
		{
			$itemDescription 	= $row_3["strItemDescription"];
			$conPc 				= round($row_3["reaConPc"],$deci);
			$unitPrice 			= round($row_3["dblUnitPrice"],$deci);
			$wastage			= round($row_3["reaWastage"],$deci);
			$dblFinance 		= round($row_3["dblFinance"],$deci);
			//$pricePerDoz		= round(($conPc * $unitPrice),$deciT);
			$pricePerDoz		= Calculate($conPc,$unitPrice,$deciT,$reportCat);
			$visible = "style=\"visibility:hidden\"";
			if($categoryId==1 || $categoryId==2)				
			{
				$visible = "style='visibility:visible'";
			}
			else
			{
				$visible = $cVisibility;
			}
	?>
			<tr>
				<td class="normalfntRite"><?php echo ++$loop;?></td>
				<td class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $itemDescription;?>&nbsp;</td>
				<td class="normalfntRite" <?php echo $visible;?>><?php echo number_format($conPc,$deci);?>&nbsp;</td>
				<td class="normalfntRite" <?php echo $visible;?>><?php echo number_format($unitPrice,$deci);?>&nbsp;</td>
				<td class="normalfntRite"><?php echo round($wastage,$deci);?>&nbsp;</td>
				<td class="normalfntRite"><?php echo round($dblFinance,$deci);?>&nbsp;</td>
				<td class="normalfntRite"><?php echo number_format($pricePerDoz,$deciT);?>&nbsp;</td>
			</tr>

	<?php
			$totPricePerDoz 	+= $pricePerDoz;
			$totConPc 			+= round($conPc,$deci);
			$totWastage 		+= round(($pricePerDoz * $wastage)/100,$deci);
			$totFinancePercent 	+= round(($pricePerDoz * $dblFinance)/100,$deci);
			$grandTotal 		+= round($totPricePerDoz+$totWastage+$totFinancePercent,$deci);
		}
	?>

<?php 
	if($categoryId==1 || $categoryId==2)
	{		
		$mainCategoryName1 	= "Fabric";
		for($i=0;$i<=4;$i++) 
		{
			switch ($i)
			{
				case 0:
					$A = "Total $mainCategoryName1 Value";
					$B = $totPricePerDoz;
					$totPricePerDoz = 0;
					break;
				case 1:
					$A	= "$mainCategoryName1 Consumption";
					$B = $totConPc;
					$totConPc = 0;
					break;
				case 2:
					$A = "$mainCategoryName1 Wastage";
					$B = $totWastage;
					$totWastage = 0;
					break;
				case 3:
					$A = "$mainCategoryName1 Finance";
					$B = $totFinancePercent;
					$totFinancePercent = 0;
					break;
				case 4:
					$A = "Total $mainCategoryName1 Cost";
					$B = $grandTotal;
					$grandTotal = 0;
					$totalPoFob += $B;
					break;
			}
?>
			<tr>
				<td class="normalfnt">&nbsp;</td>
				<td class="normalfnt"><b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $A; ?></b>&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfntRite"><b><?php echo number_format($B,$deciT); ?></b>&nbsp;</td>
			</tr>
<?php	 
		}
	}
	else
	{
	 	for($i=0;$i<=3;$i++) 
		{
			switch ($i) 
			{
				case 0:
					$A = "Total $categoryName $mainCategoryName Value";
					$B = $totPricePerDoz;
					//$totPricePerDoz = 0;
					break;
				//case 1:
					//$A	= "$categoryName $mainCategoryName Consumption";
					//$B = $totConPc;
					//$totConPc = 0;
					break;
				case 1:
					$A = "$categoryName $mainCategoryName Wastage";
					$B = $totWastage;
					//$totWastage = 0;
					break;
				case 2:
					$A = "$categoryName $mainCategoryName Finance";
					$B = $totFinancePercent;
					//$totFinancePercent = 0;
					break;
				case 3:
					$A = "$categoryName $mainCategoryName Total";
					$B = round($totPricePerDoz+$totWastage+$totFinancePercent,$deciT);
					$grandTotal = 0;
					$totalPoFob += $B;
					break;
			}
			
	?>
			<tr>
				<td class="normalfnt">&nbsp;</td>
				<td class="normalfnt"><b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $A; ?></b>&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfntRite"><b><?php echo number_format($B,$deciT);?></b>&nbsp;</td>
			</tr>
<?php	 
	$B = 0;
		}
	}
?>

	<?php
	}
	?>
<?php
}
?>
<?php
$booOtherAvailable = false;
$sql3="(SELECT MIL.strItemDescription,ID.reaConPc,ID.dblUnitPrice,ID.reaWastage,ID.dblFinance
FROM invoicecostingdetails ID
INNER JOIN matitemlist MIL ON ID.strItemCode= MIL.intItemSerial
WHERE ID.intStyleId='$styleId' AND ID.strType IN(5))
union
(select WDP.strDescription,'1',dblUnitPrice,'0','0' 
from invoicecostingproceses IP 
inner join was_dryprocess WDP on WDP.intSerialNo=IP.intProcessId 
inner join invoicecostingheader IH on IH.intStyleId=IP.intStyleId where IH.intStyleId='$styleId') 
order by strItemDescription";
$result3 = $db->RunQuery($sql3);

   $flg_newdocyn1 = "";
   $flg_firstyn1  = "";
   $te_docmain1   = ""; 
   $te_totsubPriceperDoz3 = 0;
 
   $TotPricePerDozServices=0;	 
   $jjj=0;
   	while($fields3 = mysql_fetch_array($result3, MYSQL_BOTH)) 
   	{ 
		$itemDescription 	= $fields3["strItemDescription"];
		$o_conPc 			= round($fields3["reaConPc"],$deci);
		$o_unitPrice 		= round($fields3["dblUnitPrice"],$deci);
		$o_wastage			= round($fields3["reaWastage"],$deci);
		$o_dblFinance 		= round($fields3["dblFinance"],$deci);
		//$o_pricePerDoz	= round(($o_conPc * $o_unitPrice),$deci);
		$o_pricePerDoz		= Calculate($o_conPc,$o_unitPrice,$deciT,$reportCat);
		$booOtherAvailable 	= true;
	
		$o_totPricePerDoz 	+= $o_pricePerDoz;
		$o_totWastage 		+= ($o_pricePerDoz * $o_wastage)/100;
		$o_totFinance 		+= ($o_pricePerDoz * $o_dblFinance)/100;
		
    if($flg_newdocyn1 == "y")
    {
		if($flg_firstyn1  == "n")
	 	{	  
			echo "<tr>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";   
			echo "<td></td>";
			echo "<td></td>"; 
			echo "<td></td>"; 
			echo "<td class='normalfntRite'>".number_format($te_totsubPriceperDoz3,$deciT)."&nbsp;</td>";     
			echo "</tr>";
	  		$te_totsubPriceperDoz3 = 0;
     	}	    
    } 
	 $te_totsubPriceperDoz3 += $pricePerDoz3;
		
		echo "<tr align='center'>";
		echo "<td class='normalfntMid'>".++$loop."</td>";
		echo "<td class='normalfnt'>&nbsp;&nbsp;&nbsp;&nbsp;$itemDescription &nbsp;</td>";
		echo "<td class='normalfntRite' $cVisibility>".number_format($o_conPc,$deci)."&nbsp;</td>";
		echo "<td class='normalfntRite' $cVisibility>".number_format($o_unitPrice,$deci)."&nbsp;</td>";
		echo "<td class='normalfntRite'>$o_wastage &nbsp;</td>";
		echo "<td class='normalfntRite'>$o_dblFinance &nbsp;</td>";
		echo "<td class='normalfntRite'>".number_format($o_pricePerDoz,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
   		$flg_firstyn1  = "n";
   		$jj++;
	}
	if($booOtherAvailable)
	{
		echo "<tr align='center'>";
		echo "<td><font style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($o_totPricePerDoz,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr align='center'>";
		echo "<td><font style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Wastage</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($o_totWastage,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr align='center'>";
		echo "<td><font  style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Finance</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($o_totFinance,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
	 }
	 $totalPoFob += $o_totPricePerDoz;
	//End - 31-10-2010 - Load other cost
	?>

<?php
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'>&nbsp;</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "</tr>"; 
		
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;PO FOB</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totalPoFob,$deciT)."</b>&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;CM</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($reduceCM,$deciT)."</b>&nbsp;</td>";
		echo "</tr>"; 
		$totalCost	= round(round($totalPoFob,$deci) + round($reduceCM,$deci),$deci);
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Cost</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totalCost,$deciT)."</b>&nbsp;</td>";
		echo "</tr>";
		$totalCostPerPiece = round($totalCost/12,$deci);
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Cost per piece</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totalCostPerPiece,$deciT)."</b>&nbsp;</td>";
		echo "</tr>";
		?>

		  <tr>
			<td>&nbsp;</td>
			<td colspan="6" class='normalfnt'>&nbsp;&nbsp;&nbsp;&nbsp;<b>Remarks :- </b><?php echo $remarks;?></td>
			</tr>
		</table>
		</td>
      </tr>
    </table>
  </form>
</blockquote>
</body>
</html>
<?php
if($fob_update=='fob_update')
{
	$updateTotCost = round($totalCostPerPiece,$deciT);
	$sql="update invoicecostingheader set dblTotalCostValue='$updateTotCost' where intStyleId='$styleId' ";
	$result=$db->RunQuery($sql);
}

function Calculate($conPc,$unitPrice,$deciT,$reportCat)
{
	if($reportCat=='1')
	{
		$value = $conPc * $unitPrice;
		return round_up($value,$deciT);
		//echo
	}
	else
	{
		return round(($conPc * $unitPrice),$deciT);
	}
}

function round_up($value,$precision)
{
	$pow = pow( 10, $precision );
    return (ceil($pow*$value)+ceil($pow*$value-ceil($pow*$value)))/$pow;
} 
?>