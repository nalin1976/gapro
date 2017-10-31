<?php
session_start();
include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WIP SUMMARY</title>
<link type="text/css"  href="../../css/erpstyle.css" rel="stylesheet" />

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnt">Orit Trading Lanka(Pvt)Limited.</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="150">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2" class='border-Left-Top-right' style="width:150px">FACTORY</td>
    <td rowspan="2" class="border-top-right">EX RATE</td>
    <td colspan="3" class="border-top-right">Factory WIP</td>
    <td >&nbsp;</td>
    <td colspan="3" class='border-Left-Top-right'>Finish Goods(Bal @ Yard)</td>
    <td>&nbsp;</td>
    <td colspan="3" class='border-Left-Top-right'>Absorbtion of Washing</td>
    <td>&nbsp;</td>
    <td colspan="3" class='border-Left-Top-right'>Absorbtion of Finishing</td>
    <td>&nbsp;</td>
    <td colspan="3" class='border-Left-Top-right'>Absorbtion of @ Yard</td>
    <td>&nbsp;</td>
    <td colspan="3" class='border-Left-Top-right'>Grand Total</td>
  </tr>
  <tr>
    <td class="border-top-right" style="width:150px">QTY</td>
    <td style="width:150px" class="border-top-right">TTL ($)</td>
    <td style="width:150px" class="border-top-right">TTL (RS)</td>
    <td >&nbsp;</td>
    <td class='border-Left-Top-right'>QTY</td>
    <td class="border-top-right">TTL ($)</td>
    <td class="border-top-right">TTL (RS)</td>
    <td>&nbsp;</td>
    <td class='border-Left-Top-right'>QTY</td>
    <td class="border-top-right">TTL ($)</td>
    <td class="border-top-right">TTL (RS)</td>
    <td>&nbsp;</td>
    <td class='border-Left-Top-right'>QTY</td>
    <td class="border-top-right">TTL ($)</td>
    <td class="border-top-right">TTL (RS)</td>
    <td>&nbsp;</td>
    <td class='border-Left-Top-right'>QTY</td>
    <td class="border-top-right">TTL ($)</td>
    <td class="border-top-right">TTL (RS)</td>
    <td>&nbsp;</td>
    <td class='border-Left-Top-right'>QTY</td>
    <td class="border-top-right">TTL ($)</td>
    <td class="border-top-right">TTL (RS)</td>
  </tr>
  <?php 
  $str="SELECT 
strName,
sewingbal,
cutbalance,
washbalance,
atyard,
cutValue,
sewingValue,
washingValue,
atYardValue,
pureWashValue,
pureAtyardValue
FROM wip_summary";
  $result=$db->RunQuery($str);
  while($row=mysql_fetch_array($result)){
	 $factoryqty=$row['cutbalance']+$row['sewingbal']+$row['washbalance'];
	 $factoryvalue=$row['cutValue']+$row['sewingValue']+$row['washingValue'];
	 if($factoryvalue==0)
	 	continue;
?>
  
  <tr>
    <td style="width:150px" class="border-Left-Top-right" nowrap="nowrap"><?php echo $row['strName'];?></td>
    <td class="border-top-right" style="width:150px">&nbsp;</td>
    <td class="border-top-right" style="width:150px"><?php echo $factoryqty;?></td>
    <td style="width:150px" class="border-top-right"><?php echo $factoryvalue;?></td>
    <td style="width:150px" class="border-top-right">&nbsp;</td>
    <td >&nbsp;</td>
    <td class='border-Left-Top-right'><?php echo $row['atyard'];?></td>
    <td class="border-top-right"><?php echo $row['atYardValue'];?></td>
    <td class="border-top-right">&nbsp;</td>
    <td>&nbsp;</td>
    <td class='border-Left-Top-right'><?php echo $row['washbalance'];?></td>
    <td class="border-top-right"><?php echo $row['pureWashValue'];?></td>
    <td class="border-top-right">&nbsp;</td>
    <td>&nbsp;</td>
    <td class='border-Left-Top-right'>0</td>
    <td class="border-top-right">0</td>
    <td class="border-top-right">&nbsp;</td>
    <td>&nbsp;</td>
    <td class='border-Left-Top-right'><?php echo $row['atyard'];?></td>
    <td class="border-top-right"><?php echo $row['atYardValue'];?></td>
    <td class="border-top-right">&nbsp;</td>
    <td>&nbsp;</td>
    <td class='border-Left-Top-right'><?php echo $row['atYardValue'];?></td>
    <td class="border-top-right"><?php echo $row['atYardValue'];?></td>
    <td class="border-top-right">&nbsp;</td>
  </tr>
  <?php }?>
  <tr>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td >&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
  </tr>
  <tr>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:10px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:10px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:10px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:10px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:10px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
    <td style="width:150px">&nbsp;</td>
  </tr>
</table>
</body>
</html>