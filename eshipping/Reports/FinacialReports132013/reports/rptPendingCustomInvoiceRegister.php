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
<title>WaveEDGE | Customs Pending Invoice Register</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Pending CDN Register</td>
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
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "Customs Invoice  to $dateTo":"&nbsp;");?></i></b></td>
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
        </tr>
      </thead> 
<?php
	  	$sql = "SELECT CIH.strInvoiceNo, MB.strMainBuyerName, date(CIH.dtmInvoiceDate) AS dtmInvoiceDate, CID.strStyleID,
				 CID.strBuyerPONo, SUM(CID.dblQuantity) AS dblQuantity, CIH.strCurrency, CIH.strCompanyID,
				 customers.strMLocation, SUM(CID.dblAmount) AS dblAmount, SUM(CID.dblGrossMass) AS grossAmount, B.strCountry AS buyerCountry,
				 CIH.intCancelInv 
				FROM invoiceheader AS CIH 
				inner JOIN invoicedetail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo 
				LEFT JOIN buyers AS B ON B.strBuyerID = CIH.strBuyerID
				LEFT JOIN buyers_main AS MB ON MB.intMainBuyerId = B.intMainBuyerId 
				LEFT JOIN customers ON customers.strCustomerID = CIH.intManufacturerId 
				where CIH.strInvoiceNo NOT IN(SELECT
				cdn_header.strInvoiceNo
				FROM
				cdn_header
				GROUP BY
				cdn_header.strInvoiceNo) AND  CIH.intCancelInv =0 
						
					 ";
	if($buyerId!="")
		$sql .= "and buyers_main.intMainBuyerId='$buyerId' ";
		
	if($checkDate==1)
		$sql .= "and date(dtmInvoiceDate) <='$dateTo' ";
		
	/*if($invoNoFrom!="")
		$sql .= "and CIH.dtmInvoiceDate >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";*/
		
		$sql .= "GROUP BY CIH.strInvoiceNo ORDER BY CIH.strInvoiceNo";
$result = $db->RunQuery($sql);
//echo $sql;
while($row = mysql_fetch_array($result))
{
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row["strInvoiceNo"]; ?></td>
    	<td ><?php echo $row['strMLocation']; ?></td>
    	<td ><?php echo $row['strCurrency']; ?></td>
        <td ><?php echo $row["strMainBuyerName"] ?></td>
        <td class="normalfntMid"><?php echo $row["dtmInvoiceDate"]; ?></td>
        <td><?php echo $row["strStyleID"]; ?></td>
        <td><?php echo $row["strBuyerPONo"] ?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblQuantity"],0);?></td>
        <td><?php echo $row["strCurrency"] ?></td>
        <td class="normalfntRite"><?php echo number_format($row["dblAmount"],2);?></td>
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