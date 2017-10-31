<?php
session_start();
$backwardseperator = "../../../";
include "../../../Connector.php"; 

$buyerId = $_GET["buyerId"];
$subcat = $_GET["subcat"];
$buyerName = $_GET["buyerName"];
//echo $unitPrice;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Formula Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td colspan="4">&nbsp;</td></tr>
  <tr>
    <td colspan="4" class="head2BLCK">Formula Allocation - <?php echo $buyerName; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="800" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="293" height="22">Item Description</th>
        <th width="137">First Sale Category</th>
        <th width="178">Unitprice Formula</th>
        <th width="171">Conpc Formula</th>
      </tr>
      <?php 
	  $sql = "select mil.strItemDescription,fsc.intCategoryName,
(select fsf.strFormulaDesc from firstsale_formula fsf where fsf.intId = ffa.intUnitPriceFormulaId) as upriceformula,
(select fsf.strFormulaDesc from firstsale_formula fsf where fsf.intId = ffa.intConPcFormulaId) as conpcformula
from firstsale_formulaallocation ffa inner join matitemlist mil on
ffa.intMatDetailId = mil.intItemSerial
inner join firstsalecostingcategory fsc on fsc.intCategoryId = ffa.intMainCatID
where ffa.intBuyerId='$buyerId' and ffa.intSubCatId='$subcat' 
order by mil.strItemDescription ";

$result_fs = $result=$db->RunQuery($sql);
		while($row = mysql_fetch_array($result_fs))
		{

	  ?>
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><?php echo $row["strItemDescription"]; ?></td>
        <td><?php echo $row["intCategoryName"]; ?></td>
        <td><?php echo $row["upriceformula"]; ?></td>
        <td><?php echo $row["conpcformula"]; ?></td>
      </tr>
      <?php 
	  }
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
