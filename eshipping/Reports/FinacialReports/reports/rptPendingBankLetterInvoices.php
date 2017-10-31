<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$dateTo	    = $_GET["DateTo"];
$checkDate	= $_GET["CheckDate"];
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
        <td><b><i><?php echo 	($checkDate!= '1' ? "PENDING BANK LETTER INVOICES REPORT as at $dateTo":"&nbsp;");?></i></b></td>
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
						DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
						commercial_invoice_detail.strStyleID,
						commercial_invoice_detail.strBuyerPONo,
						Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
						commercial_invoice_header.strCurrency,
						Sum(commercial_invoice_detail.dblAmount) AS dblAmount,
						finalinvoice.dblDiscount,
						buyers_main.strMainBuyerName
						FROM
						commercial_invoice_header
						INNER JOIN commercial_invoice_detail ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
						LEFT JOIN finalinvoice ON commercial_invoice_detail.strInvoiceNo = finalinvoice.strInvoiceNo
						INNER JOIN buyers ON commercial_invoice_header.strBuyerID = buyers.strBuyerID
						INNER JOIN buyers_main ON buyers.intMainBuyerId = buyers_main.intMainBuyerId
						WHERE commercial_invoice_header.strInvoiceNo NOT IN 
									(SELECT
									bankletter_detail.strInvoiceNo
									FROM
									bankletter_detail
									)";
					
		if($checkDate!=1)
	 	$sql .= " AND DATE(commercial_invoice_header.dtmInvoiceDate)<='$dateTo' ";
	   $sql .= 	"GROUP BY strInvoiceNo" ;
						
			$result = $db->RunQuery($sql);
			//echo $sql;
			$discount=0;
			$totQuantity=0;
			while($row = mysql_fetch_array($result))
			{
				
			if($row['strDiscountType']=='value')
				$discount = $row['dblDiscount'];
			else
				$discount = ($row['dblDiscount']/100)*$row['dblAmount'];
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
         <td class="normalfntRite"><?php echo number_format($discount,2); ?></td>
          <td class="normalfntRite"><?php echo number_format($row['dblAmount']-$discount,2); ?></td>
        </tr>
               <?php
		
			
		
         			$totQuantity		+= $row['dblQuantity'];
					//echo $row['dblQuantity'];
                    $totGrossAmount		+= $row['dblAmount'];
                    $disAmount		+=  $discount;
					$totnetAmt+=$row['dblAmount']-$discount ;
		}
		?>
         <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td  height="20" colspan="5"><b><?php echo $row_fac["strMLocation"]; ?> Total</b></td>
    	<td height="20" class="normalfntRite"><b><?php echo number_format($totQuantity,0)?></b></td>
    	<td height="20">&nbsp;</td>
    	<td height="20" class="normalfntRite"><b><?php echo number_format($totGrossAmount,0)?></b></td>
    	<td height="20" class="normalfntRite"><b><?php echo number_format($disAmount);?></b></td>
    	<td height="20" class="normalfntRite"><b><?php echo number_format($totnetAmt,2);?></b></td>
              
	</tr>
 
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>