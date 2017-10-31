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
    <td>&nbsp;</td>
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
				F.dblDiscount AS discount,
				SUM(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge-F.dblDiscount) AS netAmount
				FROM commercial_invoice_header CIH
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				LEFT JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId 
				where B.intMainBuyerId <> '' ";
	if($buyerId!="")
		$sql .= "and B.intMainBuyerId in($buyerId) ";
		
	if($checkDate==1)
		$sql .= "and date(CIH.dtmInvoiceDate) >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";
		
		$sql .= "GROUP BY B.intMainBuyerId
				 ORDER BY CIH.strCurrency,MB.strMainBuyerName";
		 
	//echo $sql;
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	
	$grossAmtt=$row["grossAmount"];
	//echo $discount_amt=$row["discount"];
	
	 $sql_dis = "SELECT DISTINCT
				CIH.strInvoiceNo,
				F.dblDiscount AS dblDiscount,
				 date(CIH.dtmInvoiceDate) AS dtmInvoiceDate,
				sum(CID.dblQuantity) AS dblQuantity,
				date(CIH.dtmETA) as dtmETA,
				F.strDiscountType,
				SUM(CID.dblAmount) AS dblAmount
				FROM commercial_invoice_header CIH
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				LEFT  JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId
				WHERE MB.intMainBuyerId='".$row["intMainBuyerId"]."'";
				
				
				
		if($checkDate)
		{
			$sql_dis .="AND date(dtmInvoiceDate) >='$dateFrom' and date(dtmInvoiceDate) <='$dateTo'";
		}
				
				 
		$sql_dis .="GROUP BY CIH.strInvoiceNo";
	$res_dis = $db->RunQuery($sql_dis);
	//echo $sql_dis;
	
	$tot_Quantity=0;
	$discount = 0;
	$gross_Amt   = 0;
	$discount_amt	=0;
	$tot_NetAmount=0;
	
	while($row_dis = mysql_fetch_array($res_dis))
	{
		//echo $row_dis['dblDiscount'];
		if($row_dis['strDiscountType']=='value')
		{		
			$discount_amt += $row_dis['dblDiscount'];			
		}
		else
		{
			$discount_amt += ($row_dis['dblDiscount']/100)*$row_dis['dblAmount'];
		
		}
	
		$gross_Amt +=$row_dis['dblAmount'];
		$tot_Quantity +=$row_dis["dblQuantity"];
		$tot_NetAmount=$gross_Amt-$discount_amt;
		//echo $totQuantity;
	//echo $totGrossAmount;
		
	
	}?>
        <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><b><?php echo $row["strMainBuyerName"]; ?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($tot_Quantity,0);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($gross_Amt,2);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($discount_amt,2);?></b></td>
        <td class="normalfntRite"><b><?php echo number_format($tot_NetAmount,2);?></b></td>        
        </tr>
        
<?php
		

	
	
	$currency 		 = $row["strCurrency"];
	$totQuantity	+= round($tot_Quantity,0);
	$totGrossAmount	+= round($gross_Amt,2);
	$totDiscount	+= round($discount_amt,2);
	$totNetAmount	+= round($tot_NetAmount,2);
	//echo $totQuantity;
	//echo $totGrossAmount;
	//echo $discount_amt;

	}
?>
	<tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><b>TOTAL EXPORTS</b></td>
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