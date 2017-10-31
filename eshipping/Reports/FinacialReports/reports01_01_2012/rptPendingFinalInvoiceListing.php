<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Pending Invoice Listing</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">PENDING FINAL INVOICE LISTING</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnBLD1" style="text-align:center">
        <td>Pending Final Invoice for date <?php $dateTo; ?></td>
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
        </tr>
      </thead> 
		 
      <?php
	  

		 $sql = "SELECT
			cdn_header.strInvoiceNo,
			Sum(cdn_detail.dblQuantity) AS dblQuantity,
			Sum(cdn_detail.dblAmount) AS grossAmount,
			cdn_detail.strStyleID,
			cdn_detail.strBuyerPONo,
			buyers_main.strMainBuyerName
			FROM
			cdn_header
			LEFT JOIN cdn_detail ON cdn_header.strInvoiceNo = cdn_detail.strInvoiceNo
			LEFT JOIN buyers ON buyers.strBuyerID = cdn_header.intConsignee
			LEFT JOIN buyers_main ON buyers.intMainBuyerId = buyers_main.intMainBuyerId
			WHERE cdn_header.strInvoiceNo NOT IN 
					(SELECT commercial_invoice_header.strInvoiceNo FROM commercial_invoice_header
					INNER JOIN commercial_invoice_detail ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo  
					GROUP BY commercial_invoice_header.strInvoiceNo )
					GROUP BY cdn_header.strInvoiceNo
					ORDER BY buyers_main.strMainBuyerName, cdn_header.strInvoiceNo
			   ";
								
/*
		if($dateTo!='')
		{
		$sql .= " and date(dtmInvoiceDate) <='$dateTo' ";
		}
		$sql .="GROUP BY cdn_header.strInvoiceNo";*/
		
			$result = $db->RunQuery($sql);
			

			//echo $sql;
			//$qty=0;
			//$grossamt=0;
			while($row = mysql_fetch_array($result))
			{
				$invoiceNo=$row['strInvoiceNo'];
				
							
			$sql_sub="SELECT
					invoiceheader.strInvoiceNo,
					date(invoiceheader.dtmInvoiceDate) AS dtmInvoiceDate,
					invoiceheader.strCurrency
					FROM
					invoiceheader
					WHERE invoiceheader.strInvoiceNo='$invoiceNo'
					GROUP BY
					invoiceheader.strInvoiceNo";
					$result_sub = $db->RunQuery($sql_sub);
					$row_sub = mysql_fetch_array($result_sub);

	?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php echo $row['strInvoiceNo']; ?></td>
      	<td height="20"><?php echo $row['strMainBuyerName']; ?></td>
        <td ><?php echo $row_sub['dtmInvoiceDate']; ?></td>
        <td><?php echo $row['strStyleID']; ?></td>
        <td><?php echo $row['strBuyerPONo']; ?></td>
        <td class="normalfntRite"><?php echo $row['dblQuantity']; ?></td>
        <td><?php echo $row_sub['strCurrency']; ?></td>
        <td style="text-align:right"><?php echo number_format($row['grossAmount'],2); ?></td>
        </tr>
        <?php
       				 $qty+=$row['dblQuantity']; 
					 $grossamt+=$row['grossAmount'];
       
			
}
		?>   	    
                
                <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="4"><b>TOTAL</b></td>
     
        <td nowrap class="normalfntRite"><b>&nbsp;</b></td>
        
        <td nowrap class="normalfntRite"><b><?php echo number_format($qty);?></b></td>
        <td nowrap class="normalfntRite"><b>&nbsp;</b></td> 
        <td nowrap class="normalfntRite"><b><?php echo number_format($grossamt,2);?></b></td>       
	</tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>