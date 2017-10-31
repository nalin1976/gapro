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
        <td>Final Invoice for the Period  <?php if( $checkDate==1)echo ' of ' .$dateFrom; ?> to <?php echo $dateTo; ?></td>
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
				DATE(RD.dtmInvoiceDate) AS dtmRecDate,
				RD.intSerialNo,
				DATE(DD.dtmInvoiceDate) AS dtmDesDate,
				DD.strRefNo,
				CIH.strInvoiceNo,
				buyers.strCountry,
				date(CIH.dtmInvoiceDate) AS dtmInvoiceDate,
				CID.strStyleID,
				CID.strBuyerPONo,
				Sum(CID.dblQuantity) AS dblQuantity,
				CIH.strCurrency,
				Sum(CID.dblAmount) AS grossAmount,
				F.dblDiscount AS discount,
				F.strDiscountType,
				Sum(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge) AS netAmount,
				buyers_main.strMainBuyerName,
				CIH.dtmDiscReceiptDate,
				CIH.dtmDiscountDate,
				customers.strMLocation,
				CIH.dtmETA,
				invoiceheader.intCancelInv,
				DATE(receipt_header.dtmReceiptDate) as dtmReceiptDate,
				receipt_header.intCancelStatus,
				discount_header.intCancelStatus as disCancel
				 
				FROM commercial_invoice_header AS CIH 
				INNER JOIN commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo 
				LEFT JOIN finalinvoice AS F ON CIH.strInvoiceNo = F.strInvoiceNo 
				INNER JOIN buyers ON buyers.strBuyerID = CIH.strBuyerID 
				INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId 
				INNER JOIN customers ON customers.strCustomerID = CIH.strCompanyID 
				LEFT JOIN receipt_detail AS RD ON RD.strInvoiceNo = CIH.strInvoiceNo  
				LEFT JOIN discount_detail AS DD ON DD.strInvoiceNo = CIH.strInvoiceNo  AND RD.strInvoiceNo = DD.strInvoiceNo
				LEFT JOIN invoiceheader ON CIH.strInvoiceNo = invoiceheader.strInvoiceNo
				LEFT JOIN receipt_header ON receipt_header.intSerialNo = RD.intSerialNo
				LEFT JOIN cdn_detail ON cdn_detail.strInvoiceNo = CIH.strInvoiceNo
				LEFT JOIN discount_header ON discount_header.strRefNo = DD.strRefNo
				WHERE buyers_main.intMainBuyerId!='' 
				";

		if($checkDate==1)
		$sql.= " and date(CIH.dtmInvoiceDate) >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";
		
		$sql.="  GROUP BY CIH.strInvoiceNo ORDER BY CIH.strInvoiceNo, strBuyerPONo ";
			
			$result = $db->RunQuery($sql);
			//echo $sql;
			$totQuantity 	= 0;
			$totGrossAmount	= 0;
			$totDiscount	= 0;
			$totNetAmount	= 0;
			
			
			while($row = mysql_fetch_array($result))
			{
				 $invoiceNo = $row["strInvoiceNo"];
				
				
					 $sql_final="SELECT
					commercial_invoice_header.strInvoiceNo,
					Sum(commercial_invoice_detail.dblQuantity) AS dblfQuantity,
					Sum(commercial_invoice_detail.dblAmount) AS dblfAmount,
					finalinvoice.dblDiscount as dblfDiscount,
					finalinvoice.strDiscountType as strfDiscountType
					FROM
					commercial_invoice_header
					INNER JOIN commercial_invoice_detail ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
					LEFT JOIN finalinvoice ON commercial_invoice_header.strInvoiceNo = finalinvoice.strInvoiceNo
					WHERE commercial_invoice_header.strInvoiceNo='$invoiceNo'
					GROUP BY commercial_invoice_header.strInvoiceNo
					ORDER BY commercial_invoice_header.strInvoiceNo";

			$result_final = $db->RunQuery($sql_final);
			 $sql_final;
			$row_final = mysql_fetch_array($result_final);
						
				
				
				
				
				
				
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
										$status= "Confirmed";
									}
						
				
				
				if($row['strDiscountType']=='value')
					$discount = $row_final['dblfDiscount'];
				else 
					$discount = ($row_final['dblfDiscount']/100)*$row_final["dblfAmount"];
					
				$totQuantity		+= round($row_final["dblfQuantity"],0);
				$totGrossAmount		+= round($row_final["dblfAmount"],2);
				$totDiscount		+= round($discount,2);
				$totNetAmount		+= round($row_final["dblfAmount"]-$discount,2);
				
				
	?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php echo $row['strInvoiceNo']; ?></td>
      	<td height="20"><?php echo $row['strMainBuyerName']; ?></td>
      	<td ><?php echo $row['strMLocation']; ?></td>
      	<td ><?php echo $row['strCountry']; ?></td>
        <td ><?php echo $row['dtmInvoiceDate']; ?></td>
        <td><?php  echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo number_format($row_final['dblfQuantity'],0); ?></td>
        <td><?php echo $row['strCurrency']; ?></td>
        <td class="normalfntRite"><?php echo number_format($row_final['dblfAmount'],2); ?></td>
        <td class="normalfntRite"><?php echo number_format($discount,2); ?></td>
        <td class="normalfntRite"><?php echo number_format(($row_final["dblfAmount"]-$discount),2); ?></td>
        <td class="normalfntRite"><?php 
			
							if($row["intCancelStatus"]=='0')
								{
									echo "REC".$row["intSerialNo"];
								}
							else{echo ("-");
								}
		
		 ?></td>
        <td class="normalfntRite"><?php 
									if($row["intCancelStatus"]=='0')
										{
											echo $row['dtmReceiptDate'];
										}
											 ?>
        </td>
        <td class="normalfntRite"><?php
		if($row["disCancel"] =='0')
				{
				echo "DIS".$row["strRefNo"];
				}
				else{echo ("-");}
		
		 		 ?></td>
        <td class="normalfntRite"><?php
								if($row["disCancel"] =='0')
				{
					echo $row['dtmDesDate'];
				}
		  ?></td>
        <td class="normalfntRite"><?php echo $status; ?></td>
        </tr>
         <?php
			}
		?>
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20" colspan="7" class="normalfnBLD1">Total Values</td>
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