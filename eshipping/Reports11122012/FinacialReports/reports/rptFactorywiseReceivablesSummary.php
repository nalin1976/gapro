<?php 
session_start();
include "../../../Connector.php";
$checkDate	= $_GET["CheckDate"];
$dateFrom  = $_GET['DateFrom'];
$dateTo  = $_GET['DateTo'];
$locationId	= $_GET["locationId"];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | FactoryWise Receivables - Summary</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Factorywise Receivables Summary</td>
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
        <th width="89" height="25">Factory</th>
        <th width="60">PCS</th>
        <th width="58">Net Amount</th>
        </tr>
      </thead>
      <?php
	$sql_factory = "SELECT C.strMLocation,
						CIH.strCompanyID,
						CIH.strInvoiceNo,
						F.dblDiscount,
						F.strDiscountType
						FROM commercial_invoice_header CIH 
						INNER JOIN customers C ON C.strCustomerID = CIH.strCompanyID
						INNER JOIN receipt_detail ON receipt_detail.strInvoiceNo = CIH.strInvoiceNo
						INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo ";
	if($locationId!="")
	 	$sql_factory .= "WHERE CIH.strCompanyID in ($locationId) ";
		
	 if($checkDate==1)
	 	$sql_factory .= "AND DATE(CIH.dtmETA) >='$dateFrom' AND DATE(CIH.dtmETA) <='$dateTo' ";
		
		$sql_factory .= "GROUP BY C.strCustomerID ";
				//echo $sql_factory;
$result1=$db->RunQuery($sql_factory);
while($row1=mysql_fetch_array($result1))
{
	  	$sql_inv="SELECT
					receipt_detail.strInvoiceNo,
					SUM(commercial_invoice_detail.dblQuantity) AS dblQuantity,
					SUM(commercial_invoice_detail.dblAmount) AS dblAmount,
					finalinvoice.dblDiscount,
					finalinvoice.strDiscountType
					FROM
					receipt_detail
					INNER JOIN commercial_invoice_detail ON receipt_detail.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
					INNER JOIN commercial_invoice_header ON receipt_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
					INNER JOIN finalinvoice ON finalinvoice.strInvoiceNo = commercial_invoice_header.strInvoiceNo
					WHERE strCompanyID= '".$row1["strCompanyID"]."'
					GROUP BY commercial_invoice_header.strInvoiceNo
					";
					
		$result_inv = $db->RunQuery($sql_inv);
		$sumPcs = 0;
		$sumAmt = 0;
		while($row_inv = mysql_fetch_array($result_inv))
		{
			$discount=0;
			
			if($row_inv['strDiscountType'] =='value')
				$discount=$row_inv['dblDiscount'];
			else
				$discount = ($row_inv['discount']/100)*$row_inv['dblAmount'];
			
			$sumPcs += $row_inv['dblQuantity'];
			$sumAmt += $row_inv['dblAmount']-$discount;
			$factoryName = $row1['strMLocation'];
			
		}
	?>
    	 <tr bgcolor="#FFFFFF" class="normalfnt">
      	<td height="20"><?php echo $factoryName; ?></td>
        <td class="normalfntRite"><?php echo $sumPcs; ?></td>
        <td class="normalfntRite"><?php echo $sumAmt; ?></td>
        
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