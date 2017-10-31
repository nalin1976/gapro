<?php
include '../Connector.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro | Variation Report</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<style type="text/css">
table.fixHeader {
	border: solid #FFFFFF;
	border-width: 1px 1px 1px 1px;
	width: 1050px;
}

tbody.ctbody {
	height: 580px;
	overflow-y: auto;
	overflow-x: hidden;
}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000" id="tblMain">
	<thead>
      <tr bgcolor="#CCCCCC">
        <th height="25" colspan="4" class="normalfntMid" scope="col">&nbsp;</th>
        <th height="25" colspan="2" class="normalfntMid" scope="col">Pre Order Costing </th>
        <th colspan="2" class="normalfntMid" scope="col">Invoice Costing </th>
        <th colspan="3" class="normalfntMid" scope="col">First Sale </th>
        </tr>
      <tr bgcolor="#CCCCCC">
        <th width="2%" height="25" scope="col" class="normalfntMid">No</th>
        <th width="20%" scope="col" class="normalfntMid">Description</th>
        <th width="8%" scope="col" class="normalfntMid">Origin</th>
        <th width="7%" scope="col" class="normalfntMid">Unit</th>
        <th width="9%" scope="col" class="normalfntMid">CON/PC</th>
        <th width="11%" scope="col" class="normalfntMid">Unit Price </th>
        <th width="10%" scope="col" class="normalfntMid">CON/PC</th>
        <th width="11%" scope="col" class="normalfntMid">Unit Price</th>
        <th width="10%" scope="col" class="normalfntMid">CON/PC</th>
        <th width="10%" scope="col" class="normalfntMid">Unit Price</th>
        <th width="2%" scope="col" class="normalfntMid">&nbsp;</th>
      </tr>
	  </thead>
	  <tbody class="ctbody">
<?php
$sql="select OD.intMatDetailID,MIL.strItemDescription,IPT.strOriginType,OD.strUnit,OD.reaConPc as orderConPC,OD.dblUnitPrice as orderUnitPrice,(ICD.reaConPc/12) as invoiceConPc,ICD.dblUnitPrice as invoiceUnitPrice,FCWD.dblUnitPrice as firstSaleUnitPrice,FCWD.reaConPc as firstSaleConPc
from orders O
inner join orderdetails OD on OD.intStyleId=O.intStyleId
inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID
inner join itempurchasetype IPT on IPT.intOriginNo=OD.intOriginNo
left join invoicecostingdetails ICD on ICD.intStyleId=OD.intStyleId and ICD.strItemCode=OD.intMatDetailID
left join firstsalecostworksheetdetail FCWD on FCWD.intStyleId=OD.intStyleId and FCWD.intMatDetailID=OD.intMatDetailID
where O.intStyleId=579 
order by MIL.intMainCatID,MIL.strItemDescription";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$invoBGColor					= '#FFFFFF';
	$firstSaleBGColor				= '#FFFFFF';
	$invoConPcFontColor				= '#000000';
	$invoUnitPriceFontColor			= '#000000';
	$firstSaleConPcFontColor		= '#000000';
	$firstSaleUnitPriceFontColor	= '#000000';
	$orderConPC						= round($row["orderConPC"],4);
	$orderUnitPrice					= round($row["orderUnitPrice"],4);
	$invoiceConPc					= round($row["invoiceConPc"],4);
	$invoiceUnitPrice				= round($row["invoiceUnitPrice"],4);
	$firstSaleConPc					= round($row["firstSaleConPc"],4);
	$firstSaleUnitPrice				= round($row["firstSaleUnitPrice"],4);
	
	if($orderConPC!=$invoiceConPc)
	{
		$invoConPcFontColor		= '#FF0000';
	}
	if($orderUnitPrice!=$invoiceUnitPrice)
	{
		$invoUnitPriceFontColor		= '#FF0000';
	}
	if($orderConPC!=$firstSaleConPc)
	{
		$firstSaleConPcFontColor		= '#FF0000';
	}
	if($orderUnitPrice!=$firstSaleUnitPrice)
	{
		$firstSaleUnitPriceFontColor		= '#FF0000';
	}
	if($invoiceConPc=="")
	{
		$invoBGColor = '#FFD5D5';
	}
	if($firstSaleConPc=="")
	{
		$firstSaleBGColor = '#FFD5D5';
	}
?>
      <tr bgcolor="#FFFFFF">
        <td height="20" class="normalfntRite"><?php echo ++$i.'.';?></td>
        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strItemDescription"];?></td>
        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strOriginType"]?></td>
        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strUnit"]?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($orderConPC,4)?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($orderUnitPrice,4)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $invoBGColor?>"  style="color:<?php echo $invoConPcFontColor?>"><?php echo $invoiceConPc=="" ? "":number_format($invoiceConPc,4)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $invoBGColor?>" style="color:<?php echo $invoUnitPriceFontColor?>"><?php echo $invoiceUnitPrice=="" ? "":number_format($invoiceUnitPrice,4)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $firstSaleBGColor?>" style="color:<?php echo $firstSaleConPcFontColor?>"><?php echo $firstSaleConPc=="" ? "":number_format($firstSaleConPc,4)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $firstSaleBGColor?>" style="color:<?php echo $firstSaleUnitPriceFontColor?>"><?php echo $firstSaleUnitPrice=="" ? "":number_format($firstSaleUnitPrice,4)?></td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
      </tr>
<?php
}
?>
<tr class="bcgcolor-tblrowWhite">
          <td colspan="11" class="normalfnt" nowrap="nowrap" >&nbsp;</td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
