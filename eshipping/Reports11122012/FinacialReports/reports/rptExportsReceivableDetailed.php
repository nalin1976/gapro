<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Exports Receivable - Detail</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>ER8</td>
  </tr>
  <tr>
    <td height="36" class="head2">Exports Receivable - Detail</td>
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
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "Exports Receivables as at $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="113" height="25">Buyer</th>
        <th width="128">Date</th>
        <th width="148">Invoice No</th>
        <th width="94">Style No</th>
        <th width="92">PO No</th>
        <th width="73">PCS</th>
        <th width="59">Currency</th>
        <th width="96">Gross Amount</th>
        <th width="56">Discount</th>
        <th width="86">Net Amount</th>
        </tr>
      </thead> 
<?php
	$sql1="SELECT DISTINCT
			CIH.strInvoiceNo
			FROM commercial_invoice_header CIH
			INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
			INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
			INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
			INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId
			INNER JOIN receipt_detail RD ON RD.strInvoiceNo=CIH.strInvoiceNo
			INNER JOIN receipt_header RH ON RH.intSerialNo=RD.intSerialNo ";
			
if($buyerId!="")
	$sql1 .= "where B.intMainBuyerId in($buyerId) ";

if($checkDate==1)
	$sql1 .= "and date(CIH.dtmETA) <='$dateTo' ";
	
	$sql1 .= "GROUP BY CIH.strInvoiceNo
              ORDER BY MB.strMainBuyerName";
$result1=$db->RunQuery($sql1);

while($row1=mysql_fetch_array($result1))
{
	  	$sql = "SELECT
				B.intMainBuyerId,
				MB.strMainBuyerName,
				DATE(CIH.dtmETA) AS dtmInvoiceDate,
				CIH.strInvoiceNo,
				CID.strStyleID,
				CID.strBuyerPONo,
				CID.dblQuantity,
				CIH.strCurrency,
				RD.dblInvoiceAmt AS grossAmount,
				discount_detail.dblDiscountAmt AS discount,
				RD.dblInvoiceNetAmt AS netAmount
				FROM commercial_invoice_header CIH
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId
				INNER JOIN receipt_detail RD ON RD.strInvoiceNo=CIH.strInvoiceNo
				INNER JOIN receipt_header RH ON RH.intSerialNo=RD.intSerialNo
				LEFT JOIN discount_detail ON discount_detail.strInvoiceNo = RD.strInvoiceNo
				where CIH.strInvoiceNo = '".$row1["strInvoiceNo"]."'
				ORDER BY CIH.strInvoiceNo";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row["strMainBuyerName"]; ?></td>
        <td ><?php echo $row["dtmInvoiceDate"] ?></td>
        <td><?php echo $row["strInvoiceNo"]; ?></td>
        <td><?php echo $row["strStyleID"]; ?></td>
        <td><?php echo $row["strBuyerPONo"] ?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblQuantity"],0);?></td>
        <td><?php echo $row["strCurrency"] ?></td>
        <?php
		$discount=0;
		if($row["discount"]!='')
			$discount = $row["grossAmount"];
		?>
        <td class="normalfntRite"><?php echo number_format($row["grossAmount"],2);?></td>
        <td class="normalfntRite"><?php if($discount!=0){echo number_format($discount,2);}else{echo "";};?></td>
        <td class="normalfntRite"><?php echo number_format($row["grossAmount"]-$discount,2);?></td>        
	</tr>
<?php
	$totQuantity		+= round($row["dblQuantity"],0);
	$totGrossAmount		+= round($row["grossAmount"],2);
	$totDiscount		+= round($discount,2);
	$totNetAmount		+= round($row["grossAmount"]-$discount,2);
}
?>
	
<?php
$grandTotQuantity 		+= $totQuantity;
$grandTotGrossAmount	+= $totGrossAmount;
$grandTotDiscount		+= $totDiscount;
$grandTotNetAmount		+= $totNetAmount;

$totQuantity 	= 0;
$totGrossAmount	= 0;
$totDiscount	= 0;
$totNetAmount	= 0;
}
?>

    	<tr bgcolor="#FFFFFF" class="normalfnt">
		<td height="20" colspan="5"><b>GRAND TOTAL</b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($grandTotQuantity,0) ?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($grandTotGrossAmount,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($grandTotDiscount,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($grandTotNetAmount,2);?></b></td>        
	</tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>