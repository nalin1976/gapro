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
       <th width="86">Net Amount</th>
		<th width="86">Bills Discounted</th>
        <th width="86">Net Receivable</th>
        </tr>
      </thead> 
<?php
  	$sql1 = "SELECT
			commercial_invoice_header.strInvoiceNo,
			DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
			buyers_main.strMainBuyerName,
			commercial_invoice_header.strCurrency,
			buyers_main.intMainBuyerId
			FROM
			commercial_invoice_header
			INNER JOIN buyers ON commercial_invoice_header.strBuyerID = buyers.strBuyerID
			INNER JOIN buyers_main ON buyers.intMainBuyerId = buyers_main.intMainBuyerId
			WHERE strInvoiceNo NOT IN (SELECT strInvoiceNo 
			FROM receipt_detail) AND date(dtmInvoiceDate)  <='$dateTo'
			GROUP BY buyers_main.intMainBuyerId ";
				
										 
	
$result1 = $db->RunQuery($sql1);
//echo $sql;
//$totDiscount=0;
//$discountt=0;
$totGrossAmountInBaseCurr=0;
$tot_billDiscount=0;
while($row1 = mysql_fetch_array($result1))
{
$buyerId= $row1["intMainBuyerId"];
//

		 $sql = "SELECT
				commercial_invoice_header.strInvoiceNo,
				DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
				sum(commercial_invoice_detail.dblAmount) AS grossAmount,
				Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
				date(bankletter_header.dtmDate) AS bnkDate,
				commercial_invoice_detail.strStyleID,
				commercial_invoice_detail.strBuyerPONo,
				commercial_invoice_header.strCurrency,
				finalinvoice.dblDiscount as discount,
				buyers_main.strMainBuyerName,
				finalinvoice.strDiscountType,
				buyers_main.intMainBuyerId,
				sum(discount_detail.dblDiscountAmt) AS billDiscount 
				FROM
				commercial_invoice_header
				LEFT JOIN receipt_detail ON commercial_invoice_header.strInvoiceNo = receipt_detail.strInvoiceNo
LEFT JOIN commercial_invoice_detail ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
LEFT JOIN finalinvoice ON commercial_invoice_header.strInvoiceNo = finalinvoice.strInvoiceNo
INNER JOIN buyers ON commercial_invoice_header.strBuyerID = buyers.strBuyerID
INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
LEFT JOIN discount_detail ON commercial_invoice_header.strInvoiceNo = discount_detail.strInvoiceNo
LEFT JOIN bankletter_detail ON commercial_invoice_header.strInvoiceNo = bankletter_detail.strInvoiceNo
LEFT JOIN bankletter_header ON bankletter_detail.intSerialNo = bankletter_header.intSerialNo

				WHERE commercial_invoice_header.strInvoiceNo NOT IN (SELECT strInvoiceNo 
			FROM receipt_detail) and date( commercial_invoice_header.dtmInvoiceDate) <='$dateTo'  ";
	
		$sql .= "AND buyers_main.intMainBuyerId='$buyerId' ";
		$sql .= "GROUP BY commercial_invoice_header.strInvoiceNo ";
	$result = $db->RunQuery($sql);	 
		
	//echo $sql;
$discountt=0;
$netnetamt=0;
$invNetAmt=0;
 $net_Amt=0;
$grossAmt=0;
$discount=0;
$totDiscount=0;
$tot_billDiscount=0;
$bill_Discount=0;
while($row = mysql_fetch_array($result))
	{
		//echo $row["billDiscount"];
					$grossAmt += $row["grossAmount"];
					$ax= $row['dblQuantity'];
					$aa+=$ax;
					
					//$invNetAmt+=$row["dblInvoiceNetAmt"];
					$grossAmt+=$row["dblInvoiceAmt"];
					
						if($row['strDiscountType']=='value'){
							$discount = $row['discount'];
							}
						else{
							$discount = ($row['discount']/100)*$row['grossAmount'];	
						}
						$netnetamt=($row["grossAmount"]-$discount);
			  $totDiscount+=$discount;
			 $net_Amt	= ($grossAmt-$totDiscount);
			
					 
					
					
						if ($row["billDiscount"] !='')
							{$bill_Discount = $netnetamt;
							 number_format($bill_Discount,2);
							}
							
						else
							{$bill_Discount=0 ;}
							
								$tot_billDiscount +=$bill_Discount;
								//echo number_format($tot_billDiscount,2);
		//echo number_format($billDiscount,1);
		 
					  //$billDiscount+=$row['billDiscount'];
					
					  //echo $billDiscount;
					  
					//echo $totDiscount;
					
}?>
		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row1["strMainBuyerName"]; ?></td>
        <td><?php echo $row1["strCurrency"] ?></td>
  
        <?php
		//echo $row["dblInvoiceNetAmt"];
		
		//echo $row["dblDiscountAmt"];
		//echo $row["dblInvoiceDiscountAmt"];
		//echo $discount;
		//if($row["dblDiscountAmt"]!='')
			//$discount = $row["dblInvoiceNetAmt"];
			//echo $discount;
			//echo $row["dblInvoiceNetAmt"];
			

			
		?>
        
        <td class="normalfntRite"><?php echo number_format(($net_Amt),2);?></td>
        <td class="normalfntRite"><?php echo number_format($tot_billDiscount,2);?></td>  
        <td class="normalfntRite"><?php echo number_format(($net_Amt-$tot_billDiscount),2);?></td>
          
	</tr>
<?php
	$totGrossAmountInBaseCurr		+= round($grossAmt,2);
	$totDiscountInBaseCurr			+= round($totDiscount,2);
	$totNetAmountInBaseCurr			+= round(($grossAmt-$totDiscount),2);
	 $totbillDiscount				+=round(($tot_billDiscount),2);
	$NetReceivable					+=round(($net_Amt-$tot_billDiscount),2);
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="2"><b>TOTAL</b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totNetAmountInBaseCurr,2);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($totbillDiscount,2) ;?></b></td> 
        <td class="normalfntRite"><b><?php echo number_format($NetReceivable,2);?></b></td>   
     
	</tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>