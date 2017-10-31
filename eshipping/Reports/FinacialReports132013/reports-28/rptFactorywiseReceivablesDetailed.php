<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom  = $_GET['DateFrom'];
$dateTo  = $_GET['DateTo'];
$locationId	= $_GET["locationId"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Factorywise Receivables - Detailed</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">FACTORYWISE RECEIVABLES DETAIL REPORT</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnBLD1" style="text-align:Left">
        <td>Exports for the Period  to <?php echo $dateTo; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="116">Factory</th>
        
        <th width="116" height="25">Buyer</th>
        <th width="131">Date</th>
        <th width="189">Invoice No</th>
        <th width="87">Style No</th>
        <th width="94">PO No</th>
        <th width="79">PCS</th>
        <th width="92">Inv Currency</th>
        <th width="81">Net Amt in Inv Curr</th>
        <th width="81">Net Amount in USD</th>

        </tr>
      </thead>
      <?php  
	$sql1="SELECT 
	CIH.strInvoiceNo,strCompanyID
	FROM commercial_invoice_header CIH
	INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
	LEFT JOIN receipt_detail ON CIH.strInvoiceNo = receipt_detail.strInvoiceNo AND CID.strInvoiceNo = receipt_detail.strInvoiceNo ";
	
if($locationId!="")
	$sql1 .= "where CIH.strCompanyID in($locationId) ";

if($checkDate==1)
	$sql1 .= "and date(CIH.dtmInvoiceDate) <='$dateTo' ";
	
	$sql1 .= "GROUP BY CIH.strCompanyID
				ORDER BY CIH.strCompanyID";
				//echo $sql1;
$result1=$db->RunQuery($sql1);

while($row1=mysql_fetch_array($result1))
{
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
						GROUP BY commercial_invoice_header.strInvoiceNo
";
	
		$result = $db->RunQuery($sql);
//echo $sql;


		$totQty = 0;
		$totNetAmt = 0;
		$NetAmtUSD =0;
		$currency=0;
		$totNetAmtUSD=0;
	
		while($row = mysql_fetch_array($result))
		{
			//echo $discount = $row['discount'];
			//echo $row['strDiscountType'];
						if($row['strDiscountType']=='value'){
							 $discount = $row['discount'];}
						else{
							 $discount = ($row['discount']/100)*$row['grossAmount'];	
						}
							
						//echo $discount;
					$NetAmt = ($row['grossAmount']-$discount);	
						
						//echo $NetAmt;
						$currency = $row["strCurrency"];
							
							if($currency == "USD")
									{
										$NetAmtUSD = $NetAmt;
										//$USDnetAmt = $netAmt*$Rate;
										//echo $NetAmtUSD;
									}
									else
									{
										$NetAmtUSD = ( $NetAmt / $row['dblExchange'] ); 
										
									}			
							
							
							
									
			
			//echo $row['discount'];
			$totQty += $row['dblQuantity'];
			//$NetAmt = ($row['grossAmount']-$discount);
			//$NetAmtUSD+=(($row['grossAmount']-$discount)*$row['dblExchange'])
			//echo $totNetAmt
			?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php echo $row['strMLocation']; ?></td>
        
      	<td height="20"><?php echo $row['strMainBuyerName']; ?></td>
        <td ><?php echo $row['dtmInvoiceDate']; ?></td>
        <td><?php echo $row['strInvoiceNo']; ?></td>
        <td><?php echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo $row['dblQuantity']; ?></td>
        <td><?php echo $row['strCurrency']; ?></td>
        <td class="normalfntRite"><?php echo number_format($NetAmt,2); ?></td>
        <td class="normalfntRite"><?php echo number_format($NetAmtUSD ,2); ?></td>

        </tr>

        <?php 
		
		$totNetAmt +=$NetAmt;
		$totNetAmtUSD += $NetAmtUSD;
		$gross+=$row['grossAmount'];
		$discountt+=$discount
		?>
        
        
        
                <?php
		}
		?>
        <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20" colspan="6" class="normalfnBLD1"><?php echo ""; ?>Total</td>
        <td class="normalfntRite"><?php echo number_format($totQty,2); ?></td>
        <td>&nbsp;</td>
        <td class="normalfntRite"><?php echo number_format($totNetAmt,2); ?></td>
        <td class="normalfntRite"><?php echo number_format($totNetAmtUSD,2); ?></td>

      </tr>
 <?php
				$fulltotQuantity +=$totQty; 
				$fulltotGrossAmount +=$totNetAmount;
				$fulltotNetAmount +=$totNetAmt; 
				$fulltotNetAmount_USD +=$totNetAmtUSD ;
				$fgross+=$gross;
				$discountta+=$discountt;
	}
	
?>

	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="6">Grand Total</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($fulltotQuantity,0) ?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($fulltotNetAmount,2);?></b></td>
        <td width="78" nowrap class="normalfntRite"><b><?php echo number_format($fulltotNetAmount_USD,2);?></b></td>   
     
	</tr>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>