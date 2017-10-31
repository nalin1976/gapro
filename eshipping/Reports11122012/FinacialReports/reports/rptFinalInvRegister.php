<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
$checkDate  = $_GET['CheckDate'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Invoice Register</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">FINAL INVOICE REGISTER</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnBLD1" style="text-align:center">
        <td>Customs Invoice for the Period of <?php echo $dateFrom; ?> to <?php echo $dateTo; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="116">Invoice No</th>
        <th width="116" height="25">Buyer</th>
        <th width="131">Factory</th>
        <th width="131">Country</th>
        <th width="131">Invoice Date</th>
        <th width="87">Style No</th>
        <th width="94">PO No</th>
        <th width="79">PCS</th>
        <th width="92">Currency</th>
        <th width="92">Gross Amount</th>
        <th width="92">Discount</th>
        <th width="92">Net Amt</th>
        <th width="81">Receipt No</th>
        <th width="81">Receipt Date</th>
        <th width="81">Discount No</th>
        <th width="81">Discount Date</th>
        </tr>
      </thead> 
		 <?php
		$sql = "SELECT
CIH.strInvoiceNo,
CIH.dtmInvoiceDate,
CID.strStyleID,
CID.strBuyerPONo,
CID.dblQuantity,
CIH.strCurrency,
SUM(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge) AS grossAmount,
SUM(F.dblDiscount) AS discount,
F.strDiscountType,
SUM(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge) AS netAmount,
buyers_main.strMainBuyerName,
CIH.dtmDiscReceiptDate,
CIH.dtmDiscountDate,
customers.strMLocation,
CIH.dtmETA
FROM
commercial_invoice_header AS CIH
INNER JOIN commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
INNER JOIN finalinvoice AS F ON CIH.strInvoiceNo = F.strInvoiceNo
INNER JOIN buyers ON buyers.strBuyerID = CIH.strBuyerID
INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
INNER JOIN customers ON customers.strCustomerID = CIH.strCompanyID
WHERE buyers_main.intMainBuyerId!='' 
";

		if($checkDate==1)
		$sql.= " and date(CIH.dtmETA) >='$dateFrom' and date(CIH.dtmETA) <='$dateTo' ";
		
		$sql.=" GROUP BY CIH.strInvoiceNo, strBuyerPONo";
			//echo $sql;
			$result = $db->RunQuery($sql);
			$totQuantity 	= 0;
			$totGrossAmount	= 0;
			$totDiscount	= 0;
			$totNetAmount	= 0;
			
			
			while($row = mysql_fetch_array($result))
			{
				if($row['strDiscountType']=='value')
					$discount = $row['discount'];
				else 
					$discount = ($row['discount']/100)*$row["grossAmount"];
					
				$totQuantity		+= round($row["dblQuantity"],0);
				$totGrossAmount		+= round($row["grossAmount"],2);
				$totDiscount		+= round($discount,2);
				$totNetAmount		+= round($row["netAmount"]-$discount,2);
	?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php echo $row['strInvoiceNo']; ?></td>
      	<td height="20"><?php echo $row['strMainBuyerName']; ?></td>
      	<td ><?php echo $row['strMLocation']; ?></td>
      	<td >&nbsp;</td>
        <td ><?php echo $row['dtmETA']; ?></td>
        <td><?php  echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo number_format($row['dblQuantity'],0); ?></td>
        <td><?php echo $row['strCurrency']; ?></td>
        <td class="normalfntRite"><?php echo number_format($row['grossAmount'],2); ?></td>
        <td class="normalfntRite"><?php echo number_format($discount,2); ?></td>
        <td class="normalfntRite"><?php echo number_format(($row['netAmount']-$discount),2); ?></td>
        <td class="normalfntRite">&nbsp;</td>
        <td class="normalfntRite"><?php echo $row['dtmDiscReceiptDate']; ?></td>
        <td class="normalfntRite">&nbsp;</td>
        <td class="normalfntRite"><?php echo $row['dtmDiscountDate']; ?></td>
        </tr>
         <?php
			}
		?>
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20" colspan="7" class="normalfnBLD1">Total USD Value</td>
        <td class="normalfntRite"><?php echo $totQuantity; ?></td>
        <td>&nbsp;</td>
        <td><span class="normalfntRite"><?php echo number_format($totGrossAmount,2); ?></span></td>
        <td><span class="normalfntRite"><?php echo number_format($totDiscount,2); ?></span></td>
        <td><span class="normalfntRite"><?php echo number_format($totNetAmount,2); ?></span></td>
        <td class="normalfntRite">&nbsp;</td>
        <td class="normalfntRite">&nbsp;</td>
        <td class="normalfntRite">&nbsp;</td>
        <td class="normalfntRite">&nbsp;</td>
        </tr>
       
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>