<?php 

include "../../../Connector.php";

$optHeaderAllEntry		= $_GET["optHeaderAllEntry"];
$optHeaderEntryPass		= $_GET["optHeaderEntryPass"];
$optHeaderAwaitingEntry	= $_GET["optHeaderAwaitingEntry"];

$cmbBuyer				= $_GET["cmbBuyer"];
$cmbExporter			= $_GET["cmbExporter"];
$cboCustomer			= $_GET["cboCustomer"];
$chkEntry				= $_GET["chkEntry"];

$dtmEntryFrom			= $_GET["dtmEntryFrom"];
	$DateFromArray	= explode('/',$dtmEntryFrom);
		$formatedFromDate = $DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];
$dtmEntryTo				= $_GET["dtmEntryTo"];
	$DateToArray	= explode('/',$dtmEntryTo);
		$formatedToDate = $DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web :: Import Entry :: Cusdec List Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%"><img src="../../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="7%" class="normalfnt">&nbsp;</td>
        <td width="69%" class="tophead"><p class="topheadBLACK">IMPORTS CUSDEC LIST</p></td>
      </tr>
    </table></td>
  </tr>
 <?php
 $sql="select DH.intDeliveryNo,
strInvoiceNo,
dblTotalAmount,
(select strName from suppliers SU where SU.strSupplierId=DH.strExporterID)AS ExporterName,
(select strName from customers CU where CU.strCustomerID=DH.strCustomerID)AS CustomerName,
dblPackages,
strPrevDoc,
strVessel,
date(dtmVoyageDate)AS voyageDate,
(select Name from useraccounts UA where UA.intUserID=DH.intClearedBy)AS ClearedBy,
date(dtmClearedOn)AS clearedDate,
strLocationOfGoods 
from deliverynote DH
where intDeliveryNo <> 0";
if($optHeaderEntryPass=="true")
	$sql .=" AND intStatus=1";

if($optHeaderAwaitingEntry=="true")
	$sql .=" AND intStatus=0";
	
if($cmbBuyer!="")
	$sql .=" AND strBuyerId='$cmbBuyer'";
if($cmbExporter!="")
	$sql .=" AND strExporterID ='$cmbExporter'";
if($cboCustomer!="")
	$sql .=" AND strCustomerID='$cboCustomer'";

if($chkEntry=="true")
{
	if($formatedFromDate!="")
		$sql .=" AND dtmClearedOn >= '$formatedFromDate'";
		
	if($formatedToDate!="")
		$sql .=" AND dtmClearedOn <= '$formatedToDate'";
}
		$sql .=" Order By intDeliveryNo";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
 ?>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td width="14%" class="normalfnth2Bm">Delivery No </td>
        <td width="16%" class="normalfnth2Bm">Invoice No </td>
        <td width="13%" class="normalfnth2Bm">Amount</td>
        <td width="25%" class="normalfnth2Bm">Exporter</td>
        <td colspan="2" class="normalfnth2Bm">Consignee</td>
        </tr>
      <tr>
        <td class="normalfntMid"><?php echo $row["intDeliveryNo"];?></td>
        <td class="normalfntMid"><?php echo $row["strInvoiceNo"];?></td>
        <td class="normalfntMid"><?php echo $row["dblTotalAmount"];?></td>
        <td class="normalfntMid"><?php echo $row["ExporterName"];?></td>
        <td colspan="2" class="normalfntMid"><?php echo $row["CustomerName"];?></td>
        </tr>
      <tr>
        <td class="normalfnth2Bm">No of Packages</td>
        <td class="normalfnth2Bm">Previous Docs</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2Bm">Vessel</td>
        <td colspan="2" class="normalfnth2Bm">Voyage date</td>
        </tr>
      <tr>
        <td class="normalfntMid"><?php echo $row["dblPackages"];?></td>
        <td class="normalfntMid"><?php echo $row["strPrevDoc"];?></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfntMid"><?php echo $row["strVessel"];?></td>
        <td colspan="2" class="normalfntMid"><?php echo $row["voyageDate"];?></td>
        </tr>
      <tr>
        <td class="normalfnth2Bm">Cleared by</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2Bm">Cleared On</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td colspan="2" class="normalfnth2Bm">Location of Goods</td>
      </tr>
      <tr>
        <td class="normalfntMid"><?php echo $row["ClearedBy"];?></td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfntMid"><?php echo $row["clearedDate"];?></td>
        <td class="normalfnth2B">&nbsp;</td>
        <td colspan="2" class="normalfntMid"><?php echo $row["strLocationOfGoods"];?></td>
      </tr>
      <tr>
        <td class="normalfnth2Bm">Item(s)</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td width="16%" class="normalfnth2Bm">Quantity</td>
        <td width="16%" class="normalfnth2Bm">Value</td>
      </tr>
<?php
$sql_details="select strItemCode,
(select strDescription from item I where I.strItemCode=DD.strItemCode)AS ItemDescription,
dblQty,
dblItmValue
from deliverydetails DD
where intDeliveryNo='".$row["intDeliveryNo"]."'";

$result_details=$db->RunQuery($sql_details);
while($row_details=mysql_fetch_array($result_details))
{
?>
      <tr>
        <td class="normalfntMid"><?php echo $row_details["strItemCode"];?></td>
        <td colspan="3"  class="normalfnt"><?php echo $row_details["ItemDescription"];?></td>
        <td class="normalfntMid"><?php echo $row_details["dblQty"];?></td>
        <td class="normalfntMid"><?php echo $row_details["dblItmValue"];?></td>
      </tr>
<?php
}
?>
    </table></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td class="normalfnt2bldBLACKmid"></td>
  </tr>
</table>
</body>
</html>
