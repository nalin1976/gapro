<?php 
session_start();
include "../../../Connector.php";
$checkDate	= $_GET["CheckDate"];
$dateFrom  = $_GET['DateFrom'];
$dateTo  = $_GET['DateTo'];
$locationId	= $_GET["locationId"];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | FactoryWise Receivables - Summary</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Factorywise Receivables Summary</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnBLD1" style="text-align:Left">
        <td>Exports for the Period to <?php echo $dateTo; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="89" height="25">Factory</th>
        <th width="60">PCS</th>
        <th width="58">Net Amount</th>
        </tr>
      </thead>
      <?php
	$sql_factory = "SELECT C.strMLocation,
						CIH.strCompanyID,
						CIH.strInvoiceNo,
						F.dblDiscount,
						F.strDiscountType
						FROM commercial_invoice_header CIH 
						INNER JOIN customers C ON C.strCustomerID = CIH.strCompanyID
						LEFT JOIN receipt_detail ON receipt_detail.strInvoiceNo = CIH.strInvoiceNo
						LEFT JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo ";
	if($locationId!="")
	 	$sql_factory .= "WHERE CIH.strCompanyID in ($locationId) ";
		
	 if($checkDate==1)
	 	$sql_factory .= "and date(CIH.dtmInvoiceDate) <='$dateTo' ";
		
		$sql_factory .= "GROUP BY C.strCustomerID ";
				//echo $sql_factory;
$result1=$db->RunQuery($sql_factory);
$discount=0;
$sumPcs = 0;
$sumAmt = 0;
while($row1=mysql_fetch_array($result1))
{
	$discount_amt=$row1["dblDiscount"];
	
	  	 $sql_inv="SELECT
				commercial_invoice_header.strInvoiceNo,
				DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
				sum(commercial_invoice_detail.dblAmount) AS dblAmount,
				Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
				finalinvoice.dblDiscount as dblDiscount,
				buyers_main.strMainBuyerName,
				finalinvoice.strDiscountType,
				commercial_invoice_header.strCompanyID,
				customers.strMLocation
				FROM
				commercial_invoice_header
				LEFT JOIN receipt_detail ON commercial_invoice_header.strInvoiceNo = receipt_detail.strInvoiceNo AND receipt_detail.intBuyerId = commercial_invoice_header.strBuyerID
				LEFT JOIN commercial_invoice_detail ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
				LEFT JOIN bankletter_header ON receipt_detail.intSerialNo = bankletter_header.intSerialNo
				LEFT JOIN finalinvoice ON commercial_invoice_header.strInvoiceNo = finalinvoice.strInvoiceNo
				INNER JOIN buyers ON commercial_invoice_header.strBuyerID = buyers.strBuyerID
				INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
				INNER JOIN customers ON commercial_invoice_header.strCompanyID = customers.strCustomerID
				WHERE commercial_invoice_header.strInvoiceNo 
					NOT IN (SELECT strInvoiceNo FROM receipt_detail) and commercial_invoice_header.strCompanyID = '".$row1["strCompanyID"]."'
					AND date( commercial_invoice_header.dtmInvoiceDate) <='$dateTo'
						GROUP BY commercial_invoice_header.strInvoiceNo";
 
					
			//echo $sql_inv;		
		$result_inv = $db->RunQuery($sql_inv);
		//echo $discount;
		$sumPcs = 0;
		$sumAmt = 0;
		while($row_inv = mysql_fetch_array($result_inv))
		{
			 
			//echo $discount;
			//echo $row_inv['dblDiscount'];
			if($row_inv['strDiscountType'] =='value')
				$discount=$row_inv["dblDiscount"];
				
				
			else
				$discount = ($row_inv["dblDiscount"]/100)*$row_inv['dblAmount'];
			
			//echo $row_inv['dblAmount']; 
			//echo $discount;
			$sumPcs += $row_inv['dblQuantity'];
			$sumAmt += ($row_inv['dblAmount']-$discount);
			$factoryName = $row1['strMLocation'];
			//echo $discount;
		}
		//echo $discount;
	?>
    	 <tr bgcolor="#FFFFFF" class="normalfnt">
      	<td height="20"><?php echo $factoryName; ?></td>
        <td class="normalfntRite"><?php echo $sumPcs; ?></td>
        <td class="normalfntRite"><?php echo number_format($sumAmt,2); ?></td>
        
<?php

	$totQuantity		+= round($sumPcs,0);
	$totNetAmount		+= round($sumAmt,2);
	$totamt_USD +=round($netamtt_USD,2);
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><b>TOTAL</b></td>
    	<td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totNetAmount ,2);?></b></td>        
	</tr>
 
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>