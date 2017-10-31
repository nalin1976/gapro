<?php
	session_start();
	
	include "../Connector.php";
	$chequeRefNo=$_GET["chequeRefNo"];
	$amtInWords=$_GET["amtInWords"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Voucher - Cheque Payment Voucher</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="paymentVoucher.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style3 {color: #0000FF}
-->
</style>
</head>

<body>
<?php
$strSQL= "SELECT chequeRefNo,chDate,payee,chequeType,totalAmount FROM chequeprinterhead WHERE chequeRefNo='$chequeRefNo'";
$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	
	$payee= $row["payee"];
	$date= $row["chDate"];
	$totalAmount=$row["totalAmount"];
}

$strSQL= "update chequeprinterhead set isChequePrinted=1 WHERE chequeRefNo='$chequeRefNo'";
$db->RunQuery($strSQL);

?>
<table width="1596" border="0" align="center">
  <tr>
    <td colspan="11">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt"><?php echo(date("d/m/Y")); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="normalfnt"><?php echo($chequeRefNo); ?></td>
    <td width="55">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="normalfnt"><?php echo(date("d")); ?></td>
    <td class="normalfnt"><?php echo(date("m")); ?></td>
    <td class="normalfnt"><?php echo(date("Y")); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="normalfnt"><?php echo($payee); ?></td>
    <td>&nbsp;</td>
    <td class="normalfnt"><?php echo($payee); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt"><?php echo(number_format($totalAmount,2)); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt"><?php echo(number_format($totalAmount,2)); ?></td>
    <td>&nbsp;</td>
    <td class="normalfnt"><?php echo(number_format($totalAmount,2)); ?></td>
    <td class="normalfnt">0.00</td>
    <td class="normalfnt">0.00</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="66">&nbsp;</td>
    <td width="83">&nbsp;</td>
    <td width="132">&nbsp;</td>
    <td width="80">&nbsp;</td>
    <td width="68">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="325">&nbsp;</td>
    <td width="36">&nbsp;</td>
    <td width="35">&nbsp;</td>
    <td width="37">&nbsp;</td>
    <td width="633">&nbsp;</td>
  </tr>
</table>
</body>
</html>
