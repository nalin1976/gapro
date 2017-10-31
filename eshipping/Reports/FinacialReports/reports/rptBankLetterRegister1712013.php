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
      <tr class="normalfnBLD1" style="text-align:center">
        <td>Bank Letters for the Period of <?php echo $dateFrom; ?> to <?php echo $dateTo; ?></td>
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
		
		$sql_bnk="SELECT
				bankletter_detail.strInvoiceNo,
				bankletter_detail.intSerialNo
				FROM
				bankletter_detail
				INNER JOIN commercial_invoice_detail ON bankletter_detail.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
				GROUP BY bankletter_detail.intSerialNo
				ORDER BY bankletter_detail.intSerialNo";
		
		
				$result_bnk = $db->RunQuery($sql_bnk);
		//echo $sql;
		while($row_bnk = mysql_fetch_array($result_bnk))
		{
		
		 $intSerialNo=$row_bnk["intSerialNo"];
		//echo $intSerialNo;
		
		$sql = "SELECT bankletter_detail.strInvoiceNo,
					bankletter_detail.intSerialNo,
					DATE(bankletter_header.dtmDate) AS dtmBankLetterDate,
					buyers_main.strMainBuyerName,
					DATE(cdn_header.dtmSailingDate) AS dtmSailingDate,
					commercial_invoice_detail.strStyleID,
					commercial_invoice_detail.strBuyerPONo,
					DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
					commercial_invoice_header.strCurrency
					FROM
					bankletter_header
					INNER JOIN bankletter_detail ON bankletter_header.intSerialNo = bankletter_detail.intSerialNo
					INNER JOIN buyers_main ON bankletter_header.intMainBuyerId = buyers_main.intMainBuyerId
					LEFT JOIN cdn_header ON bankletter_detail.strInvoiceNo = cdn_header.strInvoiceNo
					INNER JOIN commercial_invoice_detail ON bankletter_detail.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
					INNER JOIN commercial_invoice_header ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
					WHERE bankletter_header.intSerialNo='$intSerialNo' AND bankletter_header.intCancelStatus = 0 ";
					
			if($checkDate==1)
	 	$sql .= "AND DATE(commercial_invoice_header.dtmInvoiceDate) >='$dateFrom' AND DATE(commercial_invoice_header.dtmInvoiceDate) <='$dateTo' ";
	   $sql .= 	"GROUP BY bankletter_detail.strInvoiceNo ORDER BY bankletter_header.intSerialNo" ;
					

						
						
		$result = $db->RunQuery($sql);
		//echo $sql;
		//$discount=0;
		//$totDiscount=0;
		//$totQuantity=0;
		$bnkltNo="";
		while($row = mysql_fetch_array($result))
		{
			
			$strInvoiceNo=$row['strInvoiceNo'];
			$intSerial_No=$row['intSerialNo'];
			
						$sql_detail="SELECT
						commercial_invoice_detail.strInvoiceNo,
						sum(commercial_invoice_detail.dblQuantity) as dblQuantity,
						sum(commercial_invoice_detail.dblAmount) AS dblAmount,
						finalinvoice.dblDiscount,
						finalinvoice.strDiscountType
						FROM
						commercial_invoice_detail
						LEFT JOIN finalinvoice ON commercial_invoice_detail.strInvoiceNo = finalinvoice.strInvoiceNo
						WHERE commercial_invoice_detail.strInvoiceNo='$strInvoiceNo'
						GROUP BY commercial_invoice_detail.strInvoiceNo";
			
							 
	$result_detail = $db->RunQuery($sql_detail);
	$row_detail = mysql_fetch_array($result_detail);
			
			
			//echo $row['dtmBankLetterDate'];
			$discount = $row_detail['dblDiscount'];
			//echo $discount;
			
			if($row['strDiscountType']=='value')
				$discount = $row_detail['discount'];
			else
				$discount = ($discount/100)*$row_detail['dblAmount'];
		?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php if($intSerial_No!=$bnkltNo)
        				{
							echo "BNK".$intSerial_No;
						}
					else
						{
							echo "&nbsp;";
						}
						
		?></td>
      	<td height="20"><?php echo $row['dtmBankLetterDate']; ?></td>
        <td ><?php echo $row['strMainBuyerName']; ?></td>
        <td><?php echo $row['strInvoiceNo']; ?></td>
        <td><?php echo $row['dtmSailingDate']; ?></td>
        <td class="normalfntRite"><?php echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo $row_detail['dblQuantity']; ?></td>
        <td class=""><?php echo $row['strCurrency'];; ?></td>
        <td class="normalfntRite"><?php echo $row_detail['dblAmount']; ?></td>
        <td class="normalfntRite"><?php echo number_format($discount,2); ?></td>
        <td class="normalfntRite"><?php echo number_format($row_detail['dblAmount']-$discount,2); ?></td>
        </tr>
      <?php  ?>  
        <?php
	$totQuantity		+= round($row_detail["dblQuantity"],0);
	$totGrossAmount		+= round($row_detail["dblAmount"],2);
	$totDiscount		+= round($discount,2);
	$totNetAmount		+= round($row_detail["dblAmount"]-$discount,2);
	$bnkltNo=$intSerial_No;
}}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="5"><b>TOTAL</b></td>
       
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0);?></b></td>
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