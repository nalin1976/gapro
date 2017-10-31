<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$dateFrom  = $_GET['DateFrom'];
$dateTo  = $_GET['DateTo'];
$locationId	= $_GET["locationId"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Bank Letter Register</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">BANK LETTER REGISTER</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnBLD1" style="text-align:center">
        <td>Bank Letters for the Period of <?php echo $dateFrom; ?> to <?php echo $dateTo; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="116">Bank Letter No</th>
        <th width="116" height="25">Date </th>
        <th width="131">Buyer</th>
        <th width="87">Inv No</th>
        <th width="94">On Board Date</th>
        <th width="79">Style No</th>
        <th width="92">Po No</th>
        <th width="81">Pcs</th>
        <th width="81">Currency</th>
        <th width="81">Gross Amt</th>
        <th width="81">Discount</th>
        <th width="81">Net Amt</th>
        </tr>
      </thead> 
		<?php
			$sql = "SELECT DISTINCT
buyers_main.strMainBuyerName,
bankletter_detail.strInvoiceNo,
commercial_invoice_detail.strStyleID,
commercial_invoice_detail.strBuyerPONo,
Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS dblAmount,
bankletter_header.intSerialNo,
bankletter_header.dtmDate,
cdn_header.dtmSailingDate,
finalinvoice.dblDiscount,
finalinvoice.strDiscountType
FROM
bankletter_detail
INNER JOIN bankletter_detail ON bankletter_detail.intSerialNo = bankletter_header.intSerialNo
INNER JOIN buyers_main ON buyers_main.intMainBuyerId = bankletter_header.intMainBuyerId
INNER JOIN commercial_invoice_header ON commercial_invoice_header.strInvoiceNo = bankletter_detail.strInvoiceNo
INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = bankletter_detail.strInvoiceNo
INNER JOIN cdn_header ON cdn_header.strInvoiceNo = bankletter_detail.strInvoiceNo
INNER JOIN finalinvoice ON finalinvoice.strInvoiceNo = bankletter_detail.strInvoiceNo
GROUP BY commercial_invoice_header.strInvoiceNo

						" ;
						
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$discount=0;
			if($row['strDiscountType']=='value')
				$discount = $row['discount'];
			else
				$discount = ($row['discount']/100)*$row['dblAmount'];
		?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php echo $row['intSerialNo']; ?></td>
      	<td height="20"><?php echo $row['dtmDate']; ?></td>
        <td ><?php echo $row['strMainBuyerName']; ?></td>
        <td><?php echo $row['strInvoiceNo']; ?></td>
        <td><?php echo $row['dtmSailingDate']; ?></td>
        <td class="normalfntRite"><?php echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo $row['dblQuantity']; ?></td>
        <td class=""><?php echo "USD"; ?></td>
        <td class="normalfntRite"><?php echo $row['dblAmount']; ?></td>
        <td class="normalfntRite"><?php echo $discount; ?></td>
        <td class="normalfntRite"><?php echo $row['dblAmount']-$discount; ?></td>
        </tr>
        <?php
		}
		?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>