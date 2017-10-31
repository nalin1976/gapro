<?php 
session_start();
include "../../../Connector.php";
$factoryId  = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$locationId	= $_GET["locationId"];

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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Factorywise Exports Detailed</td>
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
        <th width="229" height="25">Factory</th>
        <th width="98">Buyer</th>
        <th width="74">Date</th>
        <th width="87">Invoice No</th>
        <th width="86">Style No</th>
        <th width="74">PO No</th>
        <th width="68">PCS</th>
        <th width="59">Currency</th>
        <th width="92">Net Amount in Invoice Curr  </th>
        <th width="78">Net Amount in USD</th>
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
						INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo ";
	if($locationId!="")
	 	$sql_factory .= "WHERE CIH.strCompanyID in ($locationId) ";
		
	 if($checkDate==1)
	 	$sql_factory .= "AND DATE(CIH.dtmETA) >='$dateFrom' AND DATE(CIH.dtmETA) <='$dateTo' ";
		
		$sql_factory .= "GROUP BY C.strCustomerID ";
	 
	 	//echo $sql_factory;
	$result_fac=$db->RunQuery($sql_factory);
	while($row_fac=mysql_fetch_array($result_fac))
	{
		$sql = "SELECT
				B.intMainBuyerId,
				MB.strMainBuyerName,
				CIH.strInvoiceNo,
				DATE(CIH.dtmETA) as dtmInvoiceDate,
				CID.strStyleID,
				CID.strBuyerPONo,
				sum(CID.dblQuantity) as dblQuantity,
				CIH.strCurrency,
				CIH.dblExchange,
				sum(F.dblDiscount) AS discount,
				F.strDiscountType AS strDiscountType,
				sum((CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge)) AS netAmount,
				sum((CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge)) AS netAmountInBaseCurr
				FROM commercial_invoice_header CIH
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId 
				where CIH.strCompanyID = '".$row_fac["strCompanyID"]."' AND DATE(CIH.dtmETA) >='$dateFrom' AND DATE(CIH.dtmETA) <='$dateTo' 
				GROUP BY CIH.strInvoiceNo
				order by CIH.strInvoiceNo";
		$result = $db->RunQuery($sql);	
		$mloc = '';			
		while($row = mysql_fetch_array($result))
		{
			if($row['strDiscountType']=='value')
				$discount = $row['discount'];
			else
				$discount = ($row['discount']/100)*$row['netAmount'];		
		?>
		<tr bgcolor="#FFFFFF" class="normalfnt">
		<td height="20"><?php if($mloc!=$row_fac["strMLocation"]){echo $row_fac["strMLocation"];}?></td> 
		<td><?php echo $row["strMainBuyerName"]; ?></td>
		<td height="20"><?php echo $row["dtmInvoiceDate"]; ?></td>
		<td ><?php echo $row["strInvoiceNo"]; ?></td>
		<td><?php echo $row["strStyleID"]; ?></td>
		<td><?php echo $row["strBuyerPONo"] ?></td>
		<td class="normalfntRite"><?php echo number_format($row["dblQuantity"],0);?></td>
		<td class="normalfntRite"><?php echo $row["strCurrency"] ?></td>
		<td class="normalfntRite"><?php echo number_format($row["netAmount"]-$discount,2);?></td>
		<td class="normalfntRite"><?php echo number_format($row["netAmountInBaseCurr"]-$discount,2);?></td>
		
		
		</tr>
		<?php 
		$totQuantity		+= round($row["dblQuantity"],0);
		$totNetAmount		+= round($row["netAmount"]-$discount,2);
		$totnetAmountInBaseCurr		+= round($row["netAmountInBaseCurr"]-$discount,2);
		
		$mloc=$row_fac["strMLocation"];
		}
                
				$fulltotQuantity +=$totQuantity; 
				$fulltotGrossAmount +=$totNetAmount;
				$fulltotNetAmount +=$totNetAmount; 
				
                    ?>
	 <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="6"><b><?php echo $row_fac["strMLocation"]; ?> Total</b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0)?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totNetAmount,2);?></b></td>
        <td width="78" nowrap class="normalfntRite"><b><?php echo number_format($totNetAmount,2);?></b></td>        
	</tr>
    <?php
	$totQuantity 	= 0;
    $totGrossAmount = 0; 
    $totNetAmount	= 0;
	}
	
?>

	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="6">Grand Total</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($fulltotQuantity,0) ?></b></td>
        <td>&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($fulltotGrossAmount,2);?></b></td>
        <td width="78" nowrap class="normalfntRite"><b><?php echo number_format($fulltotNetAmount,2);?></b></td>        
	</tr>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>