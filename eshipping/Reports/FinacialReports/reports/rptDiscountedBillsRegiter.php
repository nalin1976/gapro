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
<title>WaveEDGE | Discounted Bills Regiter</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Discounted Bills Register</td>
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
        <th width="89">Granted Amount</th>
        <th width="77">Invoice Date</th>
        <th width="83">Invoice No</th>
        <th width="67">Style No</th>
        <th width="51">PO No</th>
        <th width="40">PCS</th>
        <th width="61">Currency</th>
        <th width="54">NET Amount</th>
        <th width="61">Status</th>
        </tr>
      </thead> 
      
<?php
	
		$sql_dis = "SELECT
					discount_header.strRefNo,
					discount_detail.dtmInvoiceDate,
					discount_header.intCancelStatus
					FROM
					discount_header
					INNER JOIN discount_detail ON discount_header.strRefNo = discount_detail.strRefNo
					WHERE discount_header.strRefNo !='' ";
		
	 if($checkDate==1)
	 	$sql_dis .= "AND DATE(discount_detail.dtmInvoiceDate) >='$dateFrom' AND DATE(discount_detail.dtmInvoiceDate) <='$dateTo' ";
		
		$sql_dis .= "GROUP BY  discount_header.strRefNo ";
	 
	 	 //$sql_receipt;
	$result_dis=$db->RunQuery($sql_dis);
	//echo $sql_dis;
	while($row_dis=mysql_fetch_array($result_dis))
	{
		//echo $serialNo=$row_dis["strRefNo"];
		$status	=$row_dis["intCancelStatus"];
		$serialNo=$row_dis["strRefNo"];
		
		 $sql = "SELECT
				CID.strInvoiceNo,
				CID.strStyleID,
				CID.strBuyerPONo,
				Date(discount_detail.dtmInvoiceDate) as InvoiceDate,
				commercial_invoice_header.strCurrency,
				Sum(CID.dblQuantity) AS Qun,
				Sum(CID.dblAmount) AS netAmount,
				Sum(finalinvoice.dblDiscount) AS discount,
				discount_detail.strRefNo,
				buyers_main.strMainBuyerName,
				discount_header.dblGrantedAmt,
				bank.strName as bnkname,
				RD.dtmInvoiceDate,
				DATE(receipt_header.dtmReceiptDate) as ReceiptDate
				FROM
				commercial_invoice_detail AS CID
				LEFT JOIN receipt_detail AS RD ON CID.strInvoiceNo = RD.strInvoiceNo
				LEFT JOIN commercial_invoice_header ON commercial_invoice_header.strInvoiceNo = CID.strInvoiceNo
				LEFT JOIN finalinvoice ON CID.strInvoiceNo = finalinvoice.strInvoiceNo
				LEFT JOIN discount_detail ON CID.strInvoiceNo = discount_detail.strInvoiceNo
				LEFT JOIN buyers ON commercial_invoice_header.strBuyerID = buyers.strBuyerID
				LEFT JOIN buyers_main ON buyers.intMainBuyerId = buyers_main.intMainBuyerId
				LEFT JOIN discount_header ON discount_detail.strRefNo = discount_header.strRefNo
				LEFT JOIN receipt_header ON RD.intSerialNo = receipt_header.intSerialNo
				LEFT JOIN bank ON receipt_header.strBankCode = bank.strBankCode
				WHERE discount_detail.strRefNo  = '$serialNo'	";
				
				
	 if($checkDate==1)
	 	$sql .= "AND DATE(discount_detail.dtmInvoiceDate) >='$dateFrom' AND DATE(discount_detail.dtmInvoiceDate) <='$dateTo' ";
		
		$sql .= "GROUP BY CID.strInvoiceNo ";

		$result = $db->RunQuery($sql);	
		//echo $row["dtmInvoiceDate"];
		//echo $sql;
		$mloc = '';	
		$net_amtt=0;	
		$netamtt_USD=0;
		$serialNoChk = "";	
		while($row = mysql_fetch_array($result))
		{
			
			$dblGrantedAmt=$row["dblGrantedAmt"];
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
		?>
		<tr bgcolor="#FFFFFF" class="normalfnt">
		<td height="20">
		<?php if($serialNo!=$serialNoChk)
		{
				echo "DIS". $serialNo;
		}
			else
		{
				echo "&nbsp;";
		}
		?>
        </td> 
        <td height="20"><?php echo $row["ReceiptDate"];?></td>
        <td height="20"><?php if($row["bnkname"]== "The Hongkong and Shanghai Banking Corporation Limited")
							{echo "HSBC";}
							else{echo $row["bnkname"];}
							?></td> 
		<td><?php echo $row["strMainBuyerName"]; ?></td>
        <td height="20">&nbsp;</td>
		<td height="20"><?php echo $row["InvoiceDate"]; ?></td>
		<td ><?php echo $row["strInvoiceNo"]; ?></td>
		<td><?php echo $row["strStyleID"]; ?></td>
		<td><?php echo $row["strBuyerPONo"] ?></td>
		<td class="normalfntRite"><?php echo number_format($row["Qun"],0);?></td>
		<td class="normalfntRite"><?php echo $row["strCurrency"]; ?></td>
        <td class="normalfntRite"><?php echo number_format($netamtt_USD,2);?></td>
		<td class="normalfntRite">&nbsp;</td>
        
		
		</tr>
		<?php 
		$totamt_USD +=round($netamtt_USD,2);
		$totQuantity		+= round($row["Qun"],0);
		$totNetAmount		+= round($row["netAmount"]-$discount,2);
		$totGrossAmount		+= round($row["netAmount"],2);
		$totnetAmountInBaseCurr		+= round($row["netAmountInBaseCurr"]-$discount,2);
		
		$serialNoChk=$serialNo;
		
	}
		// $mloc=$receiptNo;
		// echo $receiptNo;
			
                
				$fulltotQuantity +=$totQuantity; 
				$fulltotGrossAmt +=$totGrossAmount	; 
				$fulltotGrossAmount +=$totNetAmount;
				$fulltotNetAmount +=$totNetAmount; 
				$fulltotNetAmount_USD +=$totamt_USD ;
				$Granted_Amoun+=round($dblGrantedAmt,2);
				
                    ?>
	 <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="4"><b><?php echo "DIS". $serialNo; ?> Total</b></td>
        <td><b><?php echo $dblGrantedAmt; ?></b></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0)?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>	
        <td class="normalfntMid"><b>
						<?php
						if($status==0)
							{
								echo OK	;
							}
						else
							{
								echo Cancel;
							}
						 ?></b></td>       
	</tr>
    <?php
	$totamt_USD=0;
	$totQuantity 	= 0;
    $totGrossAmount = 0; 
    $totNetAmount	= 0;
	}
	
?>

	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="4">Grand Total</td>
        <td><b><?php echo number_format($Granted_Amoun,2) ?></b></td>
        <td nowrap class="normalfntRite">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="normalfntRite"><b><?php echo number_format($fulltotQuantity,0) ?></b></span></td>
        <td>&nbsp;</td>
       <td nowrap class="normalfntRite"><b><?php echo number_format($fulltotNetAmount_USD,2);?></b></td> 
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