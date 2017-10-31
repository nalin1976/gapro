<?php 
session_start();
include "../../Connector.php";
$styleid=$_GET["styleid"];
$str_order="SELECT 
strOrderNo,
intStyleId,
strStyle,
intQty,
DATE_FORMAT(strRevisedDate ,'%d/%m/%Y') AS strRevisedDate,
DATE_FORMAT(dtmAppDate ,'%d/%m/%Y') AS dtmAppDate,
reaExPercentage,
UA.Name as merchant,
DATE_FORMAT(dtmDate ,'%d/%m/%Y') AS dtmDate
FROM
orders O
INNER JOIN useraccounts UA ON UA.intUserID=O.intUserID
WHERE intStyleId='$styleid'";
$result_order=$db->RunQuery($str_order);
$data_order=mysql_fetch_array($result_order);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<link type="text/css"  href="../../css/erpstyle.css" rel="stylesheet" />
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" bgcolor="#FFFFFF"  cellpadding="3" style="-moz-border-radius: 3px 3px 3px 3px;
	 	border:#9EB6CE 1px solid;" class="normalfnt">
      <tr style="">
        <td height="20" valign="top" style="color:#045182;text-align:left;"> <strong>WIP NON-VALUED BALANCE BREAK DOWN</strong></td>
        <td style="color:#045182;text-align:right;font-size:120%" valign="top"><span onclick="closeWindow()" class="mouseover" ><strong>&nbsp;&nbsp;X&nbsp;</strong></span></td>
      </tr>
      <tr>
        <td colspan="2" valign="top" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt" style="color:#666">
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Order Specification</strong></legend>
              <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>Order No </td>
                  <td>Style </td>
                  <td>Buyer</td>
                  <td>Order Qty </td>
                  <td>Recut Qty</td>
                  <td>Excess [%]</td>
                  <td>Manufacturer </td>
                  <td>Merchandiser</td>
                  <td>Created Date</td>
                  <td>Confirmed Date</td>
                  <td>Revise Date</td>
                  <td>No of Revisions</td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td nowrap="nowrap"><?php echo $data_order['strOrderNo'];?></td>
                  <td><?php echo $data_order['strStyle'];?></td>
                  <td>&nbsp;</td>
                  <td><?php echo $data_order['intQty'];?></td>
                  <td>&nbsp;</td>
                  <td><?php echo $data_order['reaExPercentage'];?></td>
                  <td>&nbsp;</td>
                  <td><?php echo $data_order['merchant'];?></td>
                  <td><?php echo $data_order['dtmDate'];?></td>
                  <td><?php echo $data_order['dtmAppDate'];?></td>
                  <td><?php echo $data_order['strRevisedDate'];?></td>
                  <td>&nbsp;</td>
                  </tr>
                </table>
  <p>&nbsp;</p>
              </fieldset></td>
          </tr>
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Cutting Summary</strong></legend>
              <table  border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>Cut No</td>
                  <td>Date</td>
                  <td>Factory</td>
                  <td>To Factory</td>
                  <td>Cut Qty</td>
                  </tr>
                <?php 
				$str_cutting="SELECT 
								strFromFactory,
								strToFactory,
								strCutNo,
								DATE_FORMAT(dtmCutDate,'%d/%m/%Y') cutdate,
								dblTotalQty
								FROM
								productionbundleheader
								WHERE 
								intStyleId=$styleid AND cut_type=1
								ORDER BY dtmCutDate,strCutNo
								";
				$result_cutting=$db->RunQuery($str_cutting);
				while($row_cutting=mysql_fetch_array($result_cutting)){
				?>
                
                <tr bgcolor="#FFFFFF">
                  <td><?php echo $row_cutting["strCutNo"];?></td>
                  <td><?php echo $row_cutting["cutdate"];?></td>
                  <td><?php echo getManufacturer($row_cutting["strFromFactory"]);?></td>
                  <td><?php echo getManufacturer($row_cutting["strToFactory"]);?></td>
                  <td style="text-align:right"><?php echo $cutqty=$row_cutting["dblTotalQty"];$totalcutqty+=$cutqty;?></td>
                  </tr><?php }?>
                  <tr bgcolor="#FFFFFF">
                  <td colspan="4"><strong>Total</strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totalcutqty,0);?></strong></td>
                </tr>
              </table>
<p>&nbsp;</p>
              </fieldset></td>
          </tr>
          
          <tr>
            <td colspan="2" >&nbsp;</td>
            </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>     
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php 
function getManufacturer($obj){
	global $db;
	$str="SELECT strName FROM companies WHERE intcompanyiD='$obj'";
	$result=$db->RunQuery($str);
	$row=mysql_fetch_array($result);
	return $row["strName"];
}
?>