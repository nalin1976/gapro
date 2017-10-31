<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Pending Invoice Listing</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">PENDING FINAL INVOICE LISTING</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnBLD1" style="text-align:center">
        <td>Pending Final Invoice for date <?php $dateTo; ?></td>
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
        </tr>
      </thead> 
		 
      <?php
		$sql = "SELECT
				CIH.strInvoiceNo,
				CIH.dtmETA AS dtmInvoiceDate,
				CID.strStyleID,
				CID.strBuyerPONo,
				CID.dblQuantity,
				CIH.strCurrency,
				(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge) AS grossAmount,
				F.dblDiscount AS discount,
				(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge-F.dblDiscount) AS netAmount,
				buyers_main.strMainBuyerName,
				CIH.dtmDiscReceiptDate,
				CIH.dtmDiscountDate
				FROM
				commercial_invoice_header AS CIH
				INNER JOIN commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
				INNER JOIN finalinvoice AS F ON CIH.strInvoiceNo = F.strInvoiceNo
				INNER JOIN buyers ON buyers.strBuyerID = CIH.strBuyerID
				INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
				WHERE CIH.intPaidStatus = 0 AND date(CIH.dtmETA) <='$dateTo'
";
		/*if($checkDate==1)
	$sql1 .= "and date(CIH.dtmETA) >='$dateFrom' and date(CIH.dtmETA) <='$dateTo' ";
			*/
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
	?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php echo $row['strInvoiceNo']; ?></td>
      	<td height="20"><?php echo $row['strMainBuyerName']; ?></td>
        <td ><?php echo $row['dtmInvoiceDate']; ?></td>
        <td><?php echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo $row['dblQuantity']; ?></td>
        <td><?php echo $row['strCurrency']; ?></td>
        <td style="text-align:right"><?php echo $row['grossAmount']; ?></td>
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