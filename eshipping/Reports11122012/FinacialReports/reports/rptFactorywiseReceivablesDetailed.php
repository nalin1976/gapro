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
      <tr class="normalfnBLD1" style="text-align:center">
        <td>Exports for the Period of <?php echo $dateFrom; ?> to <?php echo $dateTo; ?></td>
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
	$sql1="SELECT DISTINCT
	CIH.strInvoiceNo,strCompanyID
	FROM commercial_invoice_header CIH
	INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
	INNER JOIN receipt_detail ON CIH.strInvoiceNo = receipt_detail.strInvoiceNo AND CID.strInvoiceNo = receipt_detail.strInvoiceNo ";
	
if($locationId!="")
	$sql1 .= "where CIH.strCompanyID in($locationId) ";

if($checkDate==1)
	$sql1 .= "and date(CIH.dtmETA) >='$dateFrom' and date(CIH.dtmETA) <='$dateTo' ";
	
	$sql1 .= "GROUP BY CIH.strCompanyID
				ORDER BY CIH.strCompanyID";
				//echo $sql1;
$result1=$db->RunQuery($sql1);
while($row1=mysql_fetch_array($result1))
{
		$sql = "SELECT
					CIH.strInvoiceNo,
					CIH.dtmInvoiceDate,
					customers.strMLocation,
					CID.strStyleID,
					CID.strBuyerPONo,
					CID.dblQuantity,
					CIH.strCurrency,
					(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge) AS grossAmount,
					F.dblDiscount AS discount,
					(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge-F.dblDiscount) AS netAmount,
					buyers_main.strMainBuyerName
					FROM
					commercial_invoice_header AS CIH
					INNER JOIN commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
					INNER JOIN customers ON customers.strCustomerID = CIH.strCompanyID
					INNER JOIN finalinvoice AS F ON CIH.strInvoiceNo = F.strInvoiceNo
					INNER JOIN buyers ON buyers.strBuyerID = CIH.strBuyerID
					INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
					INNER JOIN receipt_detail ON CIH.strInvoiceNo = receipt_detail.strInvoiceNo AND CID.strInvoiceNo = receipt_detail.strInvoiceNo
					where CIH.strCompanyID = '".$row1["strCompanyID"]."'
					GROUP BY CIH.strInvoiceNo
";
		$result = $db->RunQuery($sql);
		$totQty = 0;
		$totNetAmt = 0;
		while($row = mysql_fetch_array($result))
		{
			$totQty += $row['dblQuantity'];
			$totNetAmt += $row['netAmount'];
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
        <td class="normalfntRite"><?php echo number_format($row['netAmount'],2); ?></td>
        <td class="normalfntRite"><?php echo number_format($row['netAmount'],2); ?></td>
        
        </tr>
        <?php
		}
		?>
        <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20" colspan="6" class="normalfnBLD1"><?php echo ""; ?>Total</td>
        <td class="normalfntRite"><?php echo number_format($totQty,2); ?></td>
        <td>&nbsp;</td>
        <td class="normalfntRite"><?php echo number_format($totNetAmt,2); ?></td>
        <td class="normalfntRite"><?php echo number_format($totNetAmt,2); ?></td>
      </tr>
<?php
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