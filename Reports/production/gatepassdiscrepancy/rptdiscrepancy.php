<?php
session_start();
include "../../../Connector.php";
$backwardseperator 	= '../../../';
$report_companyId 	= $_SESSION["FactoryID"];
$styleNo  	= $_GET["StyleNo"];
$orderNo    = $_GET["OrderNo"];
$buyer		= $_GET["Buyer"];
$toFactory	= $_GET["ToFactory"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Style Wise Material Cost Counting Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td style="display:none">
    <?php include $backwardseperator.'reportHeader.php'; ?>    </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="36" colspan="6" class="head2">GatePass Qty Discrepancies Report </td>
      </tr>
	  <?php if($checkDate=="true") {?>
      <tr>
        <td width="9%" class="normalfnt">&nbsp;<b>Date From</b></td>
        <td width="0%" class="normalfnt">:</td>
        <td width="8%" class="normalfnt">&nbsp;<?php echo $txtDfrom;?></td>
        <td width="2%" class="normalfnt"><b>To</b></td>
        <td width="1%" class="normalfnt">:</td>
        <td width="80%" class="normalfnt">&nbsp;<?php echo $txtDto;?></td>
      </tr>
	  <?php } ?>
	  
	  <?php if($buyer!="") {?>
      <tr>
        <td class="normalfnt">&nbsp;<b>Buyer Name</b></td>
        <td class="normalfnt">:</td>
        <td colspan="4" class="normalfnt">&nbsp;<?php echo GetBuyerName($buyer);?></td>
      </tr>
	<?php } ?>
    </table></td>
  </tr>
  <tr>
    <td>
			  <table width="100%" border="0" cellpadding="0" cellspacing="1" id="tblGRNDetails" bgcolor="#000000">
			  <thead>
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <th width="31%" nowrap="nowrap" >To Factory </th>
			  <th width="18%" height="25" nowrap="nowrap" >Style No </th>
              <th width="19%" nowrap="nowrap">Order No </th>
              <th width="16%" nowrap="nowrap">GatePass Qty </th>
              <th width="16%" nowrap="nowrap">GatePass Transfer In Qty </th>
              <th width="16%" nowrap="nowrap">Discrepancies</th>
            </tr>
			 </thead>

<?php
/*$sql="select 
(select strName from companies C where C.intCompanyID=PGH.intTofactory)as toFactory,O.strStyle,
O.strOrderNo,
(select sum(dblQty) from productiongpdetail PGD where PGD.intGPnumber=PGH.intGPnumber)as gatePassQty,
COALESCE((select sum(dblQty) from productiongptindetail PGTD where PGTH.dblCutGPTransferIN=PGTD.dblCutGPTransferIN),'-')as gatePassTIQty 
from productiongpheader PGH 
inner join productiongptinheader PGTH on PGTH.intGPnumber=PGH.intGPnumber
inner join orders O on O.intStyleId=PGH.intStyleId ";
if($styleNo!="")
	$sql .= "and O.strStyle='$styleNo' ";
if($orderNo!="")
	$sql .= "and O.intStyleId='$orderNo' ";
if($buyer!="")
	$sql .= "and O.intBuyerID='$buyer' ";
if($toFactory!="")
	$sql .= "and PGH.intTofactory='$toFactory' ";
$sql .= "group by PGH.intTofactory,PGH.intFromFactory,PGH.intStyleId 
order by O.strOrderNo";*/
$sql = "select 
sum(PGD.dblQty) as gatePassQty,PGH.intTofactory,O.intStyleId,
(select strName from companies C where C.intCompanyID=PGH.intTofactory)as toFactory,O.strStyle, O.strOrderNo
from productiongpheader PGH
inner join  productiongpdetail PGD on PGD.intGPnumber=PGH.intGPnumber
inner join orders O on O.intStyleId=PGH.intStyleId and PGH.intStatus=0 ";

if($styleNo!="")
	$sql .= "and O.strStyle='$styleNo' ";
if($orderNo!="")
	$sql .= "and O.intStyleId='$orderNo' ";
if($buyer!="")
	$sql .= "and O.intBuyerID='$buyer' ";
if($toFactory!="")
	$sql .= "and PGH.intTofactory='$toFactory' ";
	
$sql .= "group by PGH.intTofactory,PGH.intFromFactory,PGH.intStyleId order by O.strOrderNo ";
//echo $sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$transferInQty	= GetTransferInQty($row["intTofactory"],$row["intStyleId"]);
	$discrepancies	= $row["gatePassQty"]-($transferInQty=='-' ? 0:$transferInQty);
?>
            <tr class="bcgcolor-tblrowWhite" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["toFactory"]?>&nbsp;</td>
             <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"]?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt" id="<?php echo $row["intStyleId"];?>">&nbsp;<?php echo $row["strOrderNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["gatePassQty"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $transferInQty;?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo ($discrepancies=='0' ? '-':$discrepancies);?>&nbsp;</td>
            </tr>
<?php
}
?>
            <tr class="bcgcolor-tblrowWhite" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
            </tr>
 </table></td>
  </tr>
  <tr>
        <td height="21" class="copyright" align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
function GetTransferInQty($toFactory,$orderNo)
{
global $db;
$qty = '-';
$sql="select 
sum(PGTD.dblQty) as tiQty,
(select strName from companies C where C.intCompanyID=PGH.intTofactory)as toFactory,O.strStyle, O.strOrderNo
from productiongpheader PGH
inner join  productiongptinheader PGTH on PGTH.intGPnumber=PGH.intGPnumber
inner join  productiongptindetail PGTD on PGTH.dblCutGPTransferIN=PGTD.dblCutGPTransferIN
inner join orders O on O.intStyleId=PGH.intStyleId and O.intStyleId='$orderNo' and PGTH.intFactoryId='$toFactory' and PGH.intStatus=0
group by PGH.intTofactory,PGH.intFromFactory,PGH.intStyleId order by O.strOrderNo ";
//echo "<br/>".$sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
	{
		$qty = $row["tiQty"];
	}
	return $qty ;
}

function GetBuyerName($buyer)
{
global $db;
	$sql="select strName from buyers where intBuyerID='$buyer'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strName"];
	}
}
?>