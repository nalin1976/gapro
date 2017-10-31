<?php 
session_start();
include "../../../Connector.php";
$factoryId  = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$locationId	= $_GET["locationId"];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Receipt Register</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Receipt Register</td>
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
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "Exports for the Period of $dateFrom to $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="118" height="25">Receipt No</th>
        <th width="109" height="25">Receipt Date</th>
        <th width="109" height="25">Bank</th>
        <th width="89">Buyer</th>
        <th width="77">Invoice Date</th>
        <th width="83">Invoice No</th>
        <th width="67">Style No</th>
        <th width="51">PO No</th>
        <th width="40">PCS</th>
        <th width="61">Currency</th>
        <th width="54">NET Amount</th>
        <th width="108">Claims </th>
        <th width="78">Net Receipt Amount</th>
        </tr>
      </thead> 
      
<?php
	
		$sql_receipt = "SELECT
						receipt_header.intSerialNo AS receiptNo,
						receipt_header.dtmReceiptDate AS ReceiptDate ,
						bank.strName AS bankName,
						buyers_main.strMainBuyerName,
						receipt_header.dblBuyerClaim,
						receipt_detail.strInvoiceNo,
						DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate
						
						FROM
						receipt_header
						INNER JOIN bank ON receipt_header.strBankCode = bank.strBankCode
						INNER JOIN receipt_detail ON receipt_header.intSerialNo = receipt_detail.intSerialNo
						INNER JOIN commercial_invoice_detail ON receipt_detail.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
						INNER JOIN commercial_invoice_header ON receipt_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
						INNER JOIN buyers ON commercial_invoice_header.strBuyerID = buyers.strBuyerID
						INNER JOIN buyers_main ON buyers.intMainBuyerId = buyers_main.intMainBuyerId
						 ";
	if($locationId!="")
	 	$sql_receipt .= "WHERE  receipt_header.intCancelStatus = 0 ";
		
	 if($checkDate==1)
	 	$sql_receipt .= "AND DATE(commercial_invoice_header.dtmInvoiceDate) >='$dateFrom' AND DATE(commercial_invoice_header.dtmInvoiceDate) <='$dateTo' ";
		
		$sql_receipt .= "GROUP BY  receiptNo ";
	 
	 	 //$sql_receipt;
	$result_rec=$db->RunQuery($sql_receipt);
	//echo $sql_receipt;
	while($row_rec=mysql_fetch_array($result_rec))
	{
		 $receiptNo=$row_rec["receiptNo"];
		$strInvoiceNo=$row_rec["strInvoiceNo"];
		
		 $sql = "SELECT
				CID.strInvoiceNo,
				CID.strStyleID,
				CID.strBuyerPONo,
				commercial_invoice_header.strCurrency,
				Sum(CID.dblQuantity) AS Qun,
				SUM(CID.dblAmount) as netAmount,
				SUM(finalinvoice.dblDiscount) as discount
				FROM
				commercial_invoice_detail AS CID
				INNER JOIN receipt_detail AS RD ON CID.strInvoiceNo = RD.strInvoiceNo
				INNER JOIN commercial_invoice_header ON commercial_invoice_header.strInvoiceNo = CID.strInvoiceNo
				LEFT JOIN finalinvoice ON CID.strInvoiceNo = finalinvoice.strInvoiceNo
				WHERE RD.intSerialNo = '$receiptNo' 
				GROUP BY CID.strInvoiceNo";

		$result = $db->RunQuery($sql);	
		//echo $row["dtmInvoiceDate"];
		//echo $sql;
		//echo $mloc;
		$mloc = '';	
		//echo $mloc;
		$net_amtt=0;	
		$netamtt_USD=0;	
		while($row = mysql_fetch_array($result))
		{
			if($row['strDiscountType']=='value'){
				$discount = $row['discount'];}
			else{
				$discount = ($row['discount']/100)*$row['netAmount'];
			}
				
				$net_amtt=($row["netAmount"]-$discount);
				$Rate = $row["dblExchange"];
				$currency = $row["strCurrency"];
				//$netamtt_USD=($row["dblExchange"]*$net_amtt);
				
				
				
				if($currency == "USD")
					{
						$netamtt_USD = $net_amtt;
						//echo $netamtt_USD;
					}
					else
					{
						$netamtt_USD = ( $net_amtt / $Rate ); 
						//echo $netamtt_USD;
					}
				
				
				
				
				
				//echo $net_amtt;
				//echo $row["dblExchange"];
			//echo $netamtt_USD;
			//echo (($row["netAmount"]-$discount)*$row["CIH.dblExchange"]);	
				//echo $receiptNo;	
				//echo $mloc;
		?>
		<tr bgcolor="#FFFFFF" class="normalfnt">
		<td height="20">
		<?php  if($receiptNo!=$mloc)
				{
					echo "REC". $receiptNo;
				}
				else
				{
					echo " ";
				}
		?></td> 
        <td height="20"><?php echo $row_rec["ReceiptDate"];?></td>
        <td height="20">
		<?php if($row_rec["bankName"]== "The Hongkong and Shanghai Banking Corporation Limited")
					{
						echo "HSBC";
					}
				else
					{
						echo $row_rec["bankName"];
					}
		?></td> 
		<td><?php echo $row_rec["strMainBuyerName"]; ?></td>
		<td height="20"><?php echo $row_rec["dtmInvoiceDate"]; ?></td>
		<td ><?php echo $row["strInvoiceNo"]; ?></td>
		<td><?php echo $row["strStyleID"]; ?></td>
		<td><?php echo $row["strBuyerPONo"] ?></td>
		<td class="normalfntRite"><?php echo number_format($row["Qun"],0);?></td>
		<td class="normalfntRite"><?php echo $row["strCurrency"]; ?></td>
        <td class="normalfntRite"><?php echo number_format($netamtt_USD,2);?></td>
		<td class="normalfntRite"><?php echo '';?></td>
		<td class="normalfntRite"><?php echo number_format($netamtt_USD,2);?></td>
		
		
		</tr>
		<?php 
		$totamt_USD +=round($netamtt_USD,2);
		$totQuantity		+= round($row["Qun"],0);
		$totNetAmount		+= round($row["netAmount"]-$discount,2);
		$totGrossAmount		+= round($row["netAmount"],2);
		$totnetAmountInBaseCurr		+= round($row["netAmountInBaseCurr"]-$discount,2);
		
	 $mloc=$receiptNo;
	}	
		// echo $receiptNo;
			
                
				$fulltotQuantity +=$totQuantity; 
				$fulltotGrossAmt +=$totGrossAmount	; 
				$fulltotGrossAmount +=$totNetAmount;
				$fulltotNetAmount +=$totNetAmount; 
				$fulltotNetAmount_USD +=$totamt_USD ;
				$buyerclm +=$row_rec["dblBuyerClaim"];
				$NRM+=($totGrossAmount-$row_rec["dblBuyerClaim"]);
                    ?>
	 <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="8"><b><?php echo "REC". $receiptNo; ?> Total</b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0)?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>	
        <td nowrap class="normalfntRite"><b><?php echo number_format($row_rec["dblBuyerClaim"],2);?></b></td>
        <td width="78" nowrap class="normalfntRite"><b><?php echo number_format(($totGrossAmount)-$row_rec["dblBuyerClaim"],2);?></b></td>        
	</tr>
    <?php
	$totamt_USD=0;
	$totQuantity 	= 0;
    $totGrossAmount = 0; 
    $totNetAmount	= 0;
	}
	
?>

	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="8">Grand Total</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($fulltotQuantity,0) ?></b></td>
        <td>&nbsp;</td>
       <td nowrap class="normalfntRite"><b><?php echo number_format($fulltotNetAmount_USD,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($buyerclm,2);?></b></td>
        <td width="78" nowrap class="normalfntRite"><strong><?php echo number_format($NRM,2);?></strong></td>        
	</tr>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>