<?php 
session_start();
include "../../../Connector.php";
$factoryId 		= $_SESSION["FactoryID"];
$checkDate		= $_GET["CheckDate"];
$dateTo	    	= $_GET["DateTo"];
$buyerId		= $_GET["BuyerId"];
$currency		= $_GET["Currency"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Exports Receivable - Summary</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Exports Receivable - Summary</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="78">&nbsp;</td>
        <td width="183">&nbsp;</td>
        <td width="63">&nbsp;</td>
        <td width="160">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "Exports Receivable Summary as at $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="113" height="25">Buyer</th>
        <th width="59">Invoice Currency</th>
        <th width="96">Invoice Value</th>
        <th width="56">Gross Receivable</th>
        <th width="86">Bills Discounted</th>
        <th width="86">Net Receivable</th>
        </tr>
      </thead> 
<?php
		$sql = "SELECT receipt_detail.strInvoiceNo,
sum(CID.dblQuantity) AS dblQuantity,
 sum(receipt_detail.dblInvoiceAmt) AS dblInvoiceAmt, 
sum(receipt_detail.dblInvoiceDiscountAmt) AS dblInvoiceDiscountAmt,
 sum(receipt_detail.dblInvoiceNetAmt) AS dblInvoiceNetAmt, SUM(discount_detail.dblDiscountAmt) AS dblDiscountAmt,
 CIH.strCurrency, buyers_main.strMainBuyerName 
FROM receipt_detail 
INNER JOIN commercial_invoice_header AS CIH ON CIH.strInvoiceNo = receipt_detail.strInvoiceNo
LEFT JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo 
INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo  
LEFT JOIN discount_detail ON discount_detail.strInvoiceNo = receipt_detail.strInvoiceNo 
INNER JOIN buyers_main ON buyers_main.intMainBuyerId = receipt_detail.intBuyerId 
where intBuyerId <> '' ";
				
	if($checkDate==1)
		$sql .= "and date(CIH.dtmInvoiceDate) <='$dateTo' ";
					
	if($buyerId!="")
		$sql .= "and intBuyerId='$buyerId' ";
		
	/*if($currency!="")
		$sql .= "and CIH.strCurrency='$currency' ";*/
				
		$sql .= "GROUP BY intBuyerId";
		 
		 echo $sql;
$result = $db->RunQuery($sql);
$discount=0;
while($row = mysql_fetch_array($result))
{
	echo $discount=$row["dblDiscountAmt"]; 
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row["strMainBuyerName"]; ?></td>
        <td><?php echo $row["strCurrency"] ?></td>
        
        <td class="normalfntRite"><?php echo number_format($row["dblInvoiceNetAmt"],2);?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblInvoiceAmt"],2);?></td>
        <?php
		//echo $row["dblInvoiceNetAmt"];
		$discount=$row["dblDiscountAmt"];
		//echo $row["dblDiscountAmt"];
		//echo $row["dblInvoiceDiscountAmt"];
		//echo $discount;
		//if($row["dblDiscountAmt"]!='')
			//$discount = $row["dblInvoiceNetAmt"];
			//echo $discount;
			//echo $row["dblInvoiceNetAmt"];
		?>
        <td class="normalfntRite"><?php if($discount!=0){echo number_format($discount,2);}else{echo "0";};?></td>
        <td class="normalfntRite"><?php echo number_format(($row["dblInvoiceAmt"]-$discount),2);?></td>        
	</tr>
<?php
	$totGrossAmountInBaseCurr		+= round($row["dblInvoiceAmt"],2);
	$totDiscountInBaseCurr			+= round($discount,2);
	$totNetAmountInBaseCurr			+= round(($row["dblInvoiceAmt"]-$discount),2);
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="3"><b>TOTAL</b></td>
    	<td nowrap class="normalfntRite"><b><?php echo number_format($totGrossAmountInBaseCurr,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totDiscountInBaseCurr,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totNetAmountInBaseCurr,2);?></b></td>        
	</tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>