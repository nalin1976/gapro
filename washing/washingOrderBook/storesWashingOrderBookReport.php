<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
include_once('class.WashingOrderBook.php');

$report_companyId=$_SESSION['FactoryID'];
$sNO = $_GET['q'];
$wob=new washingOrderBook();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro| Washing Actual Cost Order Book</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
-->
table
{
	border-spacing:0px;

	
}
</style>
</head>
<body>
<table align="center" width="90%" border="0">

<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
  <?php include('../../reportHeader.php'); ?>
</td>
</tr>
<tr>
 <td align="center" class="head2">
  Washing Order Report
 </td>
 </tr>
</table>
<br />
<table width="99%" border="1" align='center' cellpadding=1 cellspacing=1 rules="all" >
  <tr bgcolor="#CCCCCC">
    <td width="7%" rowspan="2"  nowrap="nowrap">Orit Order No</td>
    <td width="6%" rowspan="2"  nowrap="nowrap">Order No</td>
    <td width="3%" rowspan="2"  nowrap="nowrap">Style</td>
    <td width="4%" rowspan="2"  nowrap="nowrap">Color</td>
    <td width="15%" rowspan="2"  nowrap="nowrap">Fabric ID </td>
    <td width="12%" rowspan="2"  nowrap="nowrap">Buyer</td>
    <td width="6%" rowspan="2"  nowrap="nowrap">Order Qty </td>
    <td width="9%" rowspan="2"  nowrap="nowrap">OH Cost per PC($)</td>
    <td width="10%" rowspan="2"  nowrap="nowrap">Water Cost per PC($)</td>
    <td  nowrap="nowrap" colspan="2" width="10%">Chemical Cost per PC($)</td>
    <td width="6%" rowspan="2"  nowrap="nowrap">Budget Cost($)</td>
    <td width="6%" rowspan="2"  nowrap="nowrap">Total Cost($) </td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="5%"   nowrap="nowrap">Wet</td>
    <td width="5%"   nowrap="nowrap">Dry</td>
  </tr>
  <?php 
  	  $sId='';
	  $res=$wob->getCostDetails();
	  while($rowM=mysql_fetch_assoc($res)){
		  $runTime=0; 
		  $runTime=$wob->getRunTime($rowM['COSTID']);
		  $ChemCostWet=$wob->getChemicalCost($rowM['COSTID'],1);
		  $ChemCostDry=$wob->getChemicalCost($rowM['COSTID'],2);
		  $OHCost=$rowM['dblOHCostMin']*($runTime+$rowM['dblHTime']);
		  $LUP=$rowM['dblUnitPrice']* $wob->getLiqour($rowM['COSTID']);
		  $PCs	= $rowM['dblQty'];
		  $ChemCost = $ChemCostWet+$ChemCostDry;
		  $totCost=$LUP+$OHCost+$ChemCost;
	  ?>
  <tr class="bcgcolor-tblrowWhite" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
    <td class='normalfnt' ><?php if($sId != $rowM['intStyleId']){echo $wob->getOritOrderNo($rowM['intStyleId']);}?></td>
    <td class='normalfnt' ><a rel="1" id="poreport" target="_blank" href="../actualcost/chemicalCostSheet.php?q=<?php echo $rowM['intSerialNo'];?>&po_location=<?php if($rowM['intCat']==0){echo 'inhouse';}else {echo 'outside';}?>"><?php echo $rowM['strOrderNo']; $sId=$rowM['intStyleId'];?></a></td>
    <td class='normalfnt'  ><?php echo $rowM['strStyle'];?></td>
    <td class='normalfnt' ><?php echo $rowM['strColor'];?></td>
    <td class='normalfnt'  ><?php echo $rowM['strItemDescription'];?></td>
    <td class='normalfnt'  ><?php echo $rowM['strName'];?></td>
    <td class='normalfntRite'  ><?php echo $rowM['intQty'];?></td>
    <td class='normalfntRite'  ><?php echo number_format(($OHCost/$PCs),4);?></td>
    <td class='normalfntRite'  ><?php echo number_format($LUP/$PCs,4);?></td>
    <td class='normalfntRite' ><?php  echo number_format($ChemCostWet/$PCs,4);?></td>
    <td class='normalfntRite' ><?php  echo number_format($ChemCostDry/$PCs,4);?></td>
    <td class='normalfntRite' ><?php  //echo number_format($OHCost,2);?></td>
    <td class='normalfntRite' ><?php  echo number_format(($totCost),2);/*echo $LUP;echo "-".$OHCost;echo "-".$ChemCost;*/?></td>
  </tr>
  <?php }?>
</table>
</body>
</html>
