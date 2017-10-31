<?php 
session_start();
include "../../../Connector.php";
$factoryId 	= $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Buyerwise Exports Summary</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>ER2</td>
  </tr>
  <tr>
    <td height="36" class="head2">Buyerwise Exports Summary</td>
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
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "Exports Summary for the Period of $dateFrom to $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="434" height="25">Buyer</th>
        <th width="134">PCS</th>
        <th width="134">Gross Amount</th>
        <th width="134">Discount</th>
        <th width="134">Net Amount</th>
        </tr>
      </thead> 
<?php
	  	$sql = "SELECT
				CIH.strCurrency,
				MB.intMainBuyerId,
				MB.strMainBuyerName,
				sum(CID.dblQuantity) as dblQuantity,
				SUM(CID.dblAmount) AS grossAmount,
				SUM(F.dblDiscount) AS discount,
				SUM(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge-F.dblDiscount) AS netAmount
				FROM commercial_invoice_header CIH
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId 
				where B.intMainBuyerId <> '' ";
	if($buyerId!="")
		$sql .= "and B.intMainBuyerId in($buyerId) ";
		
	if($checkDate==1)
		$sql .= "and date(CIH.dtmETA) >='$dateFrom' and date(CIH.dtmETA) <='$dateTo' ";
		
		$sql .= "GROUP BY B.intMainBuyerId
				 ORDER BY CIH.strCurrency,MB.strMainBuyerName";
		//echo $sql;
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$sql_dis = "SELECT DISTINCT
				CIH.strInvoiceNo,
				F.dblDiscount,
				date(CIH.dtmETA) as dtmETA,
				F.strDiscountType,
				SUM(CID.dblAmount) AS dblAmount
				FROM commercial_invoice_header CIH
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId
				WHERE MB.intMainBuyerId='".$row["intMainBuyerId"]."' and date(CIH.dtmETA) >='$dateFrom' and date(CIH.dtmETA) <='$dateTo'
				GROUP BY CIH.strInvoiceNo";
	$res_dis = $db->RunQuery($sql_dis);
	
	$discount = 0;
	$grossAmt   = 0;
	while($row_dis = mysql_fetch_array($res_dis))
	{
		if($row_dis['strDiscountType']=='value')
			$discount += $row_dis['dblDiscount'];
		else
			$discount += ($row_dis['dblDiscount']/100)*$row_dis['dblAmount'];
			
		$grossAmt +=$row_dis['dblAmount'];
	}
	
	if($currency!=$row["strCurrency"] && $currency!="")
	{
		
	?>
        <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><b>TOTAL<?php echo $currency; ?> EXPORTS</b></td>
        <td class="normalfntRite"><b><?php echo number_format($totQuantity,0);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($totDiscount,2);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($totNetAmount,2);?></b></td>        
        </tr>
<?php
		$totQuantity	= 0;
		$totGrossAmount	= 0;
		$totDiscount	= 0;
		$totNetAmount	= 0;
	}
	$currency 		 = $row["strCurrency"];
	$totQuantity	+= round($row["dblQuantity"],0);
	$totGrossAmount	+= round($grossAmt,2);
	$totDiscount	+= round($discount,2);
	$totNetAmount	+= round($grossAmt-$discount,2);
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row["strMainBuyerName"]; ?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblQuantity"],0);?></td>
        <td class="normalfntRite"><?php echo number_format($grossAmt,2);?></td>
        <td class="normalfntRite"><?php echo number_format($discount,2);?></td>
        <td class="normalfntRite"><?php echo number_format($grossAmt-$discount,2);?></td>        
	</tr>
<?php
}
?>
	<tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><b>TOTAL<?php echo $currency; ?> EXPORTS</b></td>
        <td class="normalfntRite"><b><?php echo number_format($totQuantity,0);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($totDiscount,2);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($totNetAmount,2);?></b></td>        
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>