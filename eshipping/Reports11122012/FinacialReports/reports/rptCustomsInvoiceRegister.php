<?php 
session_start();
include "../../../Connector.php";
$factoryId = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
$invoNoFrom	= $_GET["InvoNoFrom"];
$InvoNoTo	= $_GET["InvoNoTo"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Customs Invoice Register</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>ER9</td>
  </tr>
  <tr>
    <td height="36" class="head2">Customs Invoice Register</td>
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
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "Customs Invoice for the Period of $dateFrom to $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="152" height="25">Invoice No</th>
        <th width="189">Factory</th>
        <th width="189">Country</th>
        <th width="189">Buyer</th>
        <th width="93">Invoice Date</th>
        <th width="117">Style No</th>
        <th width="144">PO No</th>
        <th width="107">PCS</th>
        <th width="61">Currency</th>
        <th width="92">Gross Amount</th>
         <th width="61">CDN Quantity</th>
        <th width="92">CDN Amount</th>
         <th width="92">Final Inv Qty</th>
         <th width="92">Final Inv Amount</th>
        </tr>
      </thead> 
<?php
	  	$sql = "SELECT
					CIH.strInvoiceNo,
					MB.strMainBuyerName,
					date(CIH.dtmInvoiceDate) AS dtmInvoiceDate,
					CID.strStyleID,
					CID.strBuyerPONo,
					SUM(CID.dblQuantity) AS dblQuantity,
					CIH.strCurrency,
					MB.strCountry,
					CIH.strCompanyID,
					customers.strMLocation,
					SUM(CID.dblAmount) AS dblAmount,
					SUM(CID.dblGrossMass) AS grossAmount,
					B.strCountry AS buyerCountry
					FROM
					invoiceheader AS CIH
					INNER JOIN invoicedetail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
					INNER JOIN buyers AS B ON B.strBuyerID = CIH.strBuyerID
					INNER JOIN buyers_main AS MB ON MB.intMainBuyerId = B.intMainBuyerId
					INNER JOIN customers ON customers.strCustomerID = CIH.intManufacturerId
where B.intMainBuyerId <> ''
					 ";
	if($buyerId!="")
		$sql .= "and B.intMainBuyerId='$buyerId' ";
		
	if($checkDate==1)
		$sql .= "and date(CIH.dtmInvoiceDate) >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";
		//echo $sql;
	/*if($invoNoFrom!="")
		$sql .= "and CIH.dtmInvoiceDate >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";*/
		
		$sql .= "GROUP BY CIH.strInvoiceNo ORDER BY CIH.strInvoiceNo";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$invoiceNo=$row["strInvoiceNo"];
	
	$sql_cdn="SELECT
				cdn_header.strInvoiceNo,
				ROUND(SUM(cdn_detail.dblQuantity),2) AS cdnQuantity,
				ROUND(SUM(cdn_detail.dblAmount),2) AS cdnAmount
				FROM
				cdn_header
				INNER JOIN cdn_detail ON cdn_detail.intCDNNo = cdn_header.intCDNNo
				WHERE cdn_header.strInvoiceNo = '$invoiceNo'
				GROUP BY cdn_header.strInvoiceNo
				 ";
				 
	$result_cdn = $db->RunQuery($sql_cdn);
	$row_cdn = mysql_fetch_array($result_cdn);
	
	$sql_Finv="SELECT
				ROUND(SUM(commercial_invoice_detail.dblQuantity),2) AS finvQuantity,
				ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS finvAmount
				FROM
				commercial_invoice_header
				INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
				WHERE commercial_invoice_header.strInvoiceNo = '$invoiceNo'
				GROUP BY commercial_invoice_header.strInvoiceNo
				 ";
				 
	$result_Finv = $db->RunQuery($sql_Finv);
	$row_Finv = mysql_fetch_array($result_Finv);
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row["strInvoiceNo"]; ?></td>
    	<td ><?php echo $row['strMLocation']; ?></td>
    	<td ><?php echo $row['buyerCountry']; ?></td>
        <td ><?php echo $row["strMainBuyerName"] ?></td>
        <td class="normalfntMid"><?php echo $row["dtmInvoiceDate"]; ?></td>
        <td><?php echo $row["strStyleID"]; ?></td>
        <td><?php echo $row["strBuyerPONo"] ?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblQuantity"],0);?></td>
        <td><?php echo $row["strCurrency"] ?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblAmount"],2);?></td>
        <td class="normalfntRite"><?php echo number_format($row_cdn["cdnQuantity"],2);?></td>
        <td class="normalfntRite"><?php echo number_format($row_cdn["cdnAmount"],2);?></td>
         <td class="normalfntRite"><?php echo number_format($row_Finv["finvQuantity"],2);?></td>
         <td class="normalfntRite"><?php echo number_format($row_Finv["finvAmount"],2);?></td>
        </tr>
<?php
	$totQuantity		+= round($row["dblQuantity"],0);
	$totGrossAmount		+= round($row["dblAmount"],2);
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="7">&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0) ?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>
         <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
<?php
$totQuantity 	= 0;
$totGrossAmount	= 0;
?> 
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>