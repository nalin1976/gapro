<?php 
session_start();
include "../../Connector.php";
$backwardseperator = "../../";
include "{$backwardseperator}authentication.inc";
$companyId=$_SESSION["FactoryID"];
$styleID = $_GET["styleID"];
$styleName = $_GET["styleName"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Bulk Allocation : : Style Wise</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">Allocation From Common Stock - Style Wise</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACK">Order No : <?php echo $styleName; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="850" border="0" cellspacing="0" cellpadding="0" class="tablez">
      <tr>
        <td width="78" class="normalfntBtab" height="30">PO No</td>
        <td width="266" class="normalfntBtab">Item</td>
        <td width="117" class="normalfntBtab">Allocation No</td>
        <td width="99" class="normalfntBtab">Color</td>
        <td width="82" class="normalfntBtab">Size</td>
        <td width="84" class="normalfntBtab">Unit</td>
        <td width="124" class="normalfntBtab">Qty</td>
      </tr>
      <?php
	  $totQty = 0; 
	  $SQL = " SELECT  CBH.intTransferNo,CBH.intTransferYear,M.strItemDescription,
			CBD.strColor,CBD.strSize,CBD.strUnit,CBD.intBulkPoNo,CBD.intBulkPOYear,sum(CBD.dblQty) as qty
			from commonstock_bulkheader CBH inner join commonstock_bulkdetails CBD on 
			CBH.intTransferNo = CBD.intTransferNo and 
			CBH.intTransferYear = CBD.intTransferYear 
			inner join matitemlist M on M.intItemSerial = CBD.intMatDetailId
			where CBH.intToStyleId='$styleID'  and CBH.intStatus=1 and CBH.intCompanyId='$companyId'
			group by CBH.intTransferNo,CBH.intTransferYear,M.strItemDescription,
			CBD.strColor,CBD.strSize,CBD.strUnit,CBD.intBulkPoNo,CBD.intBulkPOYear";
			
			$result = $db->RunQuery($SQL);
			
			while($row =  mysql_fetch_array($result))
			{
			
			$BPONo = $row["intBulkPOYear"].'/'.$row["intBulkPoNo"];
			$totQty += $row["qty"]; 
	  ?>
      <tr>
        <td class="normalfntTAB" height="26"><?php echo $BPONo; ?></td>
        <td class="normalfntTAB"><?php echo $row["strItemDescription"]; ?></td>
        <td class="normalfntTAB"><?php echo substr($row["intTransferYear"],2,2).'/'.$row["intTransferNo"]; ?></td>
        <td class="normalfntTAB"><?php echo $row["strColor"]; ?></td>
        <td class="normalfntTAB"><?php echo $row["strSize"]; ?></td>
        <td class="normalfntTAB"><?php echo $row["strUnit"]; ?></td>
        <td class="normalfntRiteTAB"><?php echo number_format($row["qty"],2); ?></td>
      </tr>
      <?php 
	  }
	  ?>
       <tr>
        
        <td class="normalfnBLD1TAB" colspan="6" align="center">Total</td>
        <td class="normalfnBLD1TAB" align="right" height="30"><?php echo number_format($totQty,2); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
