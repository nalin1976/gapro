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
<title>WaveEDGE | Bank Letter Register</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">BANK LETTER REGISTER</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnBLD1" style="text-align:left">
        <td>Bank Letters for the Period of <?php echo ($checkDate== '1' ? " $dateFrom to $dateTo":"&nbsp;");?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="116">Bank Letter No</th>
        <th width="116" height="25">Bank Letter Date </th>
        <th width="131">Buyer</th>
        <th width="87">Inv No</th>
        <th width="94">On Board Date</th>
        <th width="79">Style No</th>
        <th width="92">Po No</th>
        <th width="81">Pcs</th>
        <th width="81">Currency</th>
        <th width="81">Gross Amt</th>
        <th width="81">Discount</th>
        <th width="81">Net Amt</th>
        </tr>
      </thead> 
		<?php
			$sql = "SELECT DISTINCT
			bankletter_header.intSerialNo,
			bankletter_header.dtmDate,
			buyers_main.strMainBuyerName,
			bankletter_detail.strInvoiceNo,
			DATE(cdn_header.dtmSailingDate) AS dtmSailingDate,
			commercial_invoice_detail.strStyleID,
			commercial_invoice_detail.strBuyerPONo,
			Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
			commercial_invoice_header.strCurrency,
			ROUND(sum(commercial_invoice_detail.dblAmount),2) AS dblAmount,
			sum(finalinvoice.dblDiscount) AS dblDiscount,
			finalinvoice.strDiscountType,
			date(commercial_invoice_header.dtmInvoiceDate) as dtmInvoiceDate
			FROM
			bankletter_detail
			INNER JOIN bankletter_header ON bankletter_detail.intSerialNo = bankletter_header.intSerialNo
			INNER JOIN buyers_main ON bankletter_header.intMainBuyerId = buyers_main.intMainBuyerId
			INNER JOIN cdn_header ON cdn_header.strInvoiceNo = bankletter_detail.strInvoiceNo
			INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = bankletter_detail.strInvoiceNo
			INNER JOIN commercial_invoice_header ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
			INNER JOIN finalinvoice ON finalinvoice.strInvoiceNo = commercial_invoice_header.strInvoiceNo
			WHERE bankletter_header.intSerialNo <> ''  " ;


		//if($dateTo==1)
		if($checkDate==1)
		{
		$sql .= " AND date(commercial_invoice_header.dtmInvoiceDate) >='$dateFrom' and date(commercial_invoice_header.dtmInvoiceDate) <='$dateTo' ";
		}
		$sql .="GROUP BY bankletter_header.intSerialNo
			ORDER BY bankletter_header.intSerialNo ";
						
						
		$result = $db->RunQuery($sql);
		echo $sql;
		$discount=0;
		while($row = mysql_fetch_array($result))
		{
			$discount = $row['dblDiscount'];
			//echo $discount;
			
			if($row['strDiscountType']=='value')
				$discount = $row['discount'];
			else
				$discount = ($discount/100)*$row['dblAmount'];
		?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php
		if($row["intSerialNo"] !='')
				{
				echo "BNK".$row["intSerialNo"];
				}
				
		
		 		 ?></td>
      	<td height="20"><?php echo $row['dtmDate']; ?></td>
        <td ><?php echo $row['strMainBuyerName']; ?></td>
        <td><?php echo $row['strInvoiceNo']; ?></td>
        <td><?php echo $row['dtmSailingDate']; ?></td>
        <td class="normalfntRite"><?php echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo $row['dblQuantity']; ?></td>
        <td class=""><?php echo $row['strCurrency'];; ?></td>
        <td class="normalfntRite"><?php echo $row['dblAmount']; ?></td>
        <td class="normalfntRite"><?php echo $discount; ?></td>
        <td class="normalfntRite"><?php echo $row['dblAmount']-$discount; ?></td>
        </tr>
        
        <?php
	$totQuantity		+= round($row["dblQuantity"],0);
	$totGrossAmount		+= round($row["dblAmount"],2);
	$totDiscount		+= round($discount,2);
	$totNetAmount		+= round($row["dblAmount"]-$discount,2);
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="5"><b>TOTAL</b></td>
       
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,2);?></b></td>
        <td>&nbsp;</td> 
        <td nowrap class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totDiscount,2);?></b></td> 
        <td nowrap class="normalfntRite"><b><?php echo number_format($totNetAmount,2);?></b></td>       
	</tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>