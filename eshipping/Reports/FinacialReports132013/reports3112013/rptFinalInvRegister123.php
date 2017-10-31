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
        <th width="81">Status</th>
        </tr>
      </thead> 
		 <?php
		$sql = "SELECT
					finalinvoice.strInvoiceNo,
					buyers_main.strMainBuyerName,
					DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
					commercial_invoice_detail.strBuyerPONo,
					commercial_invoice_detail.strStyleID,
					Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
					Sum(commercial_invoice_detail.dblAmount) AS grossAmount,
					commercial_invoice_header.strCurrency,
					finalinvoice.dblDiscount as discount,
					buyers_main.intMainBuyerId,
					finalinvoice.strDiscountType,
					commercial_invoice_header.dblExchange,
					commercial_invoice_header.strCompanyID,
					customers.strMLocation,
					customers.strCountry,
					country.strCountry
					FROM
					finalinvoice
					INNER JOIN commercial_invoice_header ON finalinvoice.strInvoiceNo = commercial_invoice_header.strInvoiceNo
					INNER JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strBuyerID
					INNER JOIN buyers_main ON buyers.intMainBuyerId = buyers_main.intMainBuyerId
					LEFT JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
					INNER JOIN customers ON commercial_invoice_header.strCompanyID = customers.strCustomerID
					INNER JOIN city ON commercial_invoice_header.strFinalDest = city.strCityCode
					INNER JOIN country ON city.strCountryCode = country.strCountryCode
					
				WHERE buyers_main.intMainBuyerId !='' 
				";

		if($checkDate==1)
		$sql.= " and date(dtmInvoiceDate) >='$dateFrom' and date(dtmInvoiceDate) <='$dateTo' ";
		
		$sql.="  GROUP BY finalinvoice.strInvoiceNo ORDER BY finalinvoice.strInvoiceNo, strBuyerPONo ";
			//echo $sql;
			$result = $db->RunQuery($sql);
			$totQuantity 	= 0;
			$totGrossAmount	= 0;
			$totDiscount	= 0;
			$totNetAmount	= 0;
			
			
			while($row = mysql_fetch_array($result))
			{
				$invoiceNo=$row['strInvoiceNo'];
				//echo $row["intCancelInv"];
				
				 $sql_recept="SELECT
							receipt_detail.strInvoiceNo,
							receipt_detail.intSerialNo,
							receipt_header.dtmReceiptDate as receiptDate,
							discount_detail.strRefNo as DisNo,
							DATE(discount_detail.dtmInvoiceDate) AS dtmDesDate
							FROM
							receipt_header
							INNER JOIN receipt_detail ON receipt_header.intSerialNo = receipt_detail.intSerialNo
							LEFT JOIN discount_detail ON receipt_detail.strInvoiceNo = discount_detail.strInvoiceNo
							WHERE receipt_detail.strInvoiceNo='$invoiceNo'
							GROUP BY
							receipt_detail.strInvoiceNo";
				
				$result_rec = $db->RunQuery($sql_recept);
				
				$row_rec = mysql_fetch_array($result_rec);
				//echo $row_rec["intSerialNo"];
				
				
				 $status='';
					 $val_sql= "SELECT
						cdn_header.strInvoiceNo ,
						cdn_header.intCDNConform,
						cdn_header.intCancel
						FROM cdn_header
						WHERE cdn_header.strInvoiceNo='$invoiceNo' ";
						//die($val_sql);
							$result_val = $db->RunQuery($val_sql);
//$val_sql;
//echo $invoiceNo=$row["strInvoiceNo"];

								if($row["intCancelInv"]==1)
									{
										$status= "Cancel";
									}
									
									else
									{
										$status= "Confirm";
									}
						
				
				
				if($row['strDiscountType']=='value')
					$discount = $row['discount'];
				else 
					$discount = ($row['discount']/100)*$row["grossAmount"];
					
				$totQuantity		+= round($row["dblQuantity"],0);
				$totGrossAmount		+= round($row["grossAmount"],2);
				$totDiscount		+= round($discount,2);
				$totNetAmount		+= round($row["grossAmount"]-$discount,2);
				
				
	?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php echo $row['strInvoiceNo']; ?></td>
      	<td height="20"><?php echo $row['strMainBuyerName']; ?></td>
      	<td ><?php echo $row['strMLocation']; ?></td>
      	<td ><?php echo $row['strCountry']; ?></td>
        <td ><?php echo $row['dtmInvoiceDate']; ?></td>
        <td><?php  echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo number_format($row['dblQuantity'],0); ?></td>
        <td><?php echo $row['strCurrency']; ?></td>
        <td class="normalfntRite"><?php echo number_format($row['grossAmount'],2); ?></td>
        <td class="normalfntRite"><?php echo number_format($discount,2); ?></td>
        <td class="normalfntRite"><?php echo number_format(($row["grossAmount"]-$discount),2); ?></td>
        <td class="normalfntRite"><?php 
		if($row_rec["intSerialNo"] !='')
				{
				echo "REC".$row_rec["intSerialNo"];
				}
				else{echo ("-");}
		
		 ?></td>
        <td class="normalfntRite"><?php echo $row_rec['receiptDate']; ?></td>
        <td class="normalfntRite"><?php
		if($row_rec["DisNo"] !='')
				{
				echo "DIS".$row_rec["DisNo"];
				}
				else{echo ("-");}
		
		 		 ?></td>
        <td class="normalfntRite"><?php echo $row_rec['dtmDesDate']; ?></td>
        <td class="normalfntRite"><?php echo $status; ?></td>
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