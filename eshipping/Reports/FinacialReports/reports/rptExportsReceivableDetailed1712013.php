<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Exports Receivable - Detail</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Exports Receivable - Detail</td>
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
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "Exports Receivables as at $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="79" height="25">Buyer</th>
        <th width="49">Date</th>
         <th width="113">Bank Letter Date</th>
        <th width="68">Invoice No</th>
        <th width="60">Style No</th>
        <th width="50">PO No</th>
        <th width="44">PCS</th>
        <th width="59">Currency</th>
    
        <th width="77">Net Amount</th>
        
 		<th width="77">Bills Discounted</th>
        <th width="77">Net Receivable</th>
        <th width="59">Due Date</th>
        </tr>
      </thead> 
<?php
		
	  $sql = "SELECT
				commercial_invoice_header.strInvoiceNo,
				DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
				sum(commercial_invoice_detail.dblAmount) AS grossAmount,
				Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
				commercial_invoice_detail.strStyleID,
				commercial_invoice_detail.strBuyerPONo,
				commercial_invoice_header.strCurrency,
				finalinvoice.dblDiscount as discount,
				buyers_main.strMainBuyerName,
				finalinvoice.strDiscountType,
				DATE(bankletter_header.dtmDate) AS bnkDate,
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

				WHERE commercial_invoice_header.strInvoiceNo 
					NOT IN (SELECT strInvoiceNo FROM receipt_detail) and date( commercial_invoice_header.dtmInvoiceDate) <='$dateTo'
				GROUP BY commercial_invoice_header.strInvoiceNo ORDER BY buyers_main.strMainBuyerName,dtmInvoiceDate
				";
$result = $db->RunQuery($sql);
//echo $sql;
$discount=0;
$netAmt=0;
$grandTotGrossAmount=0;
$mloc = '';
//$billDiscount=0;
while($row = mysql_fetch_array($result))
{
	
	$discount= $row["discount"];
	$dtmdate= $row["bnkDate"];
	//echo $dtmdate;
	
	$Sql_dueDate="SELECT
				DATE(bankletter_header.dtmDate) AS bnkDate,
				buyers_main.intCreditPeriod,
				DATE_ADD(bankletter_header.dtmDate,INTERVAL buyers_main.intCreditPeriod DAY) AS dueDate,
				bankletter_detail.strInvoiceNo
				FROM
				bankletter_header
				INNER JOIN buyers_main ON bankletter_header.intMainBuyerId = buyers_main.intMainBuyerId
				INNER JOIN bankletter_detail ON bankletter_header.intSerialNo = bankletter_detail.intSerialNo
				WHERE  bankletter_detail.strInvoiceNo= '".$row["strInvoiceNo"]."' ";
	$result_due = $db->RunQuery($Sql_dueDate);
	//echo $Sql_dueDate;
	$row_val = mysql_fetch_array($result_due);
	if($row_val!=''){
	$bnkDate= $row_val["bnkDate"];
	}
	else{
	 $bnkDate= '-';
	}
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php if($mloc!=$row["strMainBuyerName"]){echo $row["strMainBuyerName"];}?></td>
        <td ><?php echo $row["dtmInvoiceDate"]; ?></td>
        <td><?php echo $bnkDate; ?></td>
        <td><?php echo $row["strInvoiceNo"]; ?></td>
        <td><?php echo $row["strStyleID"]; ?></td>
        <td><?php echo $row["strBuyerPONo"]; ?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblQuantity"],0);?></td>
        <td><?php echo $row["strCurrency"] ?></td>
        <?php
		
		
			if($row['strDiscountType']=='value'){
							$discount = $row["discount"];}
						else{
							$discount = ($row['discount']/100)*$row['grossAmount'];	
						}
		
					$netAmt=$row["grossAmount"]-$discount;
		?>
        

        
        <td class="normalfntRite"><?php echo number_format($netAmt,2);?></td>
        <td class="normalfntRite"><?php 
						if ($row["billDiscount"] !='')
							{$billDiscount= $netAmt;}
							
						else
							{$billDiscount=0 ;}
							
		echo number_format($billDiscount,2);?></td>
		
		
        <td class="normalfntRite"><?php echo number_format($netAmt-$billDiscount,2);?></td>
        <td class="normalfntRite"><?php
											if($row_val["dueDate"]!=''){
										echo $row_val["dueDate"];
										}
										else{
										 echo '-';
										}?></td>        
	</tr>
<?php
	$totQuantity		+= round($row["dblQuantity"],0);
	$totGrossAmount		+= round($row["grossAmount"],2);
	$totDiscount		+= round($discount,2);
	$totNetAmount		+= round($row["grossAmount"]-$discount,2);
	$billDis			+=round($billDiscount,2);
?>
	
<?php
$grandTotQuantity 		+= $totQuantity;
$grandTotGrossAmount	+= $totGrossAmount;
$grandTotDiscount		+= $totDiscount;
$grandTotNetAmount		+= $totNetAmount;

//$totQuantity 	= 0;
$totGrossAmount	= 0;
$totDiscount	= 0;
$totNetAmount	= 0;

$mloc=$row["strMainBuyerName"];
}
?>

    	<tr bgcolor="#FFFFFF" class="normalfnt">
		<td height="20" colspan="6"><b>GRAND TOTAL</b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0) ?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($grandTotNetAmount,2);?></b></td>  
         <td nowrap class="normalfntRite"><b><?php echo number_format($billDis,2);?></b></td>   
         <td nowrap class="normalfntRite"><b><?php echo number_format($grandTotNetAmount-$billDis,2);?></b></td> 
         <td>&nbsp;</td>  
	</tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>