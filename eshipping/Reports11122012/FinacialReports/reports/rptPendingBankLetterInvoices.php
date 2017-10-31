<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$dateTo	    = $_GET["DateTo"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Pending Bank Letter Invoices</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">PENDING BANK LETTER INVOICES REPORT</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnBLD1" style="text-align:center">
        <td><b><i><?php echo 	($checkDate== '1' ? "Exports Receivable Summary as at $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
   
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="116">Invoice No</th>
        <th width="116" height="25">Buyer</th>
        <th width="131">Invoice Date</th>
        <th width="87">Style No</th>
        <th width="94">PO No</th>
        <th width="79">PCS</th>
        <th width="92">Currency</th>
        <th width="81">Gross Amount</th>
        <th width="81">Discount Amt</th>
        <th width="81">Net Amt</th>
        </tr>
      </thead> 
		<?php
			$sql = "SELECT
commercial_invoice_header.strInvoiceNo,
commercial_invoice_detail.strStyleID,
commercial_invoice_detail.strBuyerPONo,
Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
Sum(commercial_invoice_detail.dblAmount) AS dblAmount,
buyers.intMainBuyerId,
buyers_main.strMainBuyerName,
commercial_invoice_header.dtmInvoiceDate,
commercial_invoice_header.strCurrency,
finalinvoice.strDiscountType,
finalinvoice.dblDiscount
FROM
commercial_invoice_header
INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
INNER JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strBuyerID
INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
INNER JOIN finalinvoice ON finalinvoice.strInvoiceNo = commercial_invoice_header.strInvoiceNo
WHERE commercial_invoice_header.strInvoiceNo NOT IN (SELECT strInvoiceNo FROM bankletter_detail)
GROUP BY commercial_invoice_detail.strInvoiceNo

						";
						
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
        <td><?php echo $row['strInvoiceNo']; ?></td>
      	<td height="20"><?php echo $row['strMainBuyerName']; ?></td>
        <td ><?php echo $row['dtmInvoiceDate']; ?></td>
        <td><?php echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo $row['dblQuantity']; ?></td>
        <td><?php echo $row['strCurrency']; ?></td>
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