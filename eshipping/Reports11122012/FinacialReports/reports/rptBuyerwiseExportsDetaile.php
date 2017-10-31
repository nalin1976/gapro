<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Buyerwise Exports Detail</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>ER1</td>
  </tr>
  <tr>
    <td height="36" class="head2">Buyerwise Exports Detail</td>
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
	/*$sql1="SELECT DISTINCT
	CIH.strInvoiceNo,
	F.dblDiscount,
	date(CIH.dtmETA) as dtmETA,
	F.strDiscountType
	FROM commercial_invoice_header CIH
	INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
	INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
	INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
	INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId ";
if($buyerId!="")
	$sql1 .= "where B.intMainBuyerId in($buyerId) ";

if($checkDate==1)
	$sql1 .= "and date(CIH.dtmETA) >='$dateFrom' and date(CIH.dtmETA) <='$dateTo' ";
	
	$sql1 .= "GROUP BY CIH.strInvoiceNo
				ORDER BY MB.strMainBuyerName,CIH.strInvoiceNo";*/
				
	$sql1 = "SELECT
				CIH.strCurrency,
				MB.intMainBuyerId,
				MB.strMainBuyerName,
				sum(CID.dblQuantity) as dblQuantity,
				SUM(CID.dblAmount) AS grossAmount,
				SUM(F.dblDiscount) AS discount,
				SUM(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge-F.dblDiscount) AS netAmount
				FROM commercial_invoice_header CIH
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId 
				where B.intMainBuyerId <> '' ";
	if($buyerId!="")
		$sql1 .= "and B.intMainBuyerId in($buyerId) ";
		
	if($checkDate==1)
		$sql1 .= "and date(CIH.dtmETA) >='$dateFrom' and date(CIH.dtmETA) <='$dateTo' ";
		
		$sql1 .= "GROUP BY B.intMainBuyerId
				 ORDER BY CIH.strCurrency,MB.strMainBuyerName";
//echo $sql1;
$result1=$db->RunQuery($sql1);

while($row1=mysql_fetch_array($result1))
{
	
	  	$sql = "SELECT
						B.intMainBuyerId,
						MB.strMainBuyerName,
						CIH.strInvoiceNo,
						date(CIH.dtmInvoiceDate) AS dtmInvoiceDate,
						CID.strStyleID,
						CID.strBuyerPONo,
						sum(CID.dblQuantity) AS dblQuantity,
						CIH.strCurrency,
						sum(CID.dblAmount) AS grossAmount,
						F.dblDiscount AS discount,
						F.strDiscountType,
						sum(CID.dblAmount) AS netAmount
						FROM commercial_invoice_header CIH 
						INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo 
						INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo 
						INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID 
						INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId 
				where MB.intMainBuyerId='".$row1["intMainBuyerId"]."'
				";
				
		if($checkDate==1)
			$sql .= " and date(CIH.dtmETA) >='$dateFrom' and date(CIH.dtmETA) <='$dateTo' ";
			
		$sql .= " GROUP BY CIH.strInvoiceNo
				order by CIH.strInvoiceNo";
		//echo $sql;
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
		if($row['strDiscountType']=='value')
			$discount = $row['discount'];
		else
			$discount = ($row['discount']/100)*$row['netAmount'];
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row["strMainBuyerName"]; ?></td>
        <td ><?php echo $row1["dtmETA"] ?></td>
        <td><?php echo $row["strInvoiceNo"]; ?></td>
        <td><?php echo $row["strStyleID"]; ?></td>
        <td><?php echo $row["strBuyerPONo"] ?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblQuantity"],0);?></td>
        <td><?php echo $row["strCurrency"] ?></td>
        <td class="normalfntRite"><?php echo number_format($row["grossAmount"],2);?></td>
        <td class="normalfntRite"><?php echo number_format($discount,2);?></td>
        <td class="normalfntRite"><?php echo number_format($row["netAmount"]-$discount,2);?></td>        
	</tr>
<?php
	$totQuantity		+= round($row["dblQuantity"],0);
	$totGrossAmount		+= round($row["grossAmount"],2);
	$totDiscount		+= round($discount,2);
	$totNetAmount		+= round($row["netAmount"]-$discount,2);
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="5">&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0) ?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totDiscount,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totNetAmount,2);?></b></td>        
	</tr>
<?php
$totQuantity 	= 0;
$totGrossAmount	= 0;
$totDiscount	= 0;
$totNetAmount	= 0;
}
?> 
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>