<?php 
session_start();
include "../../../Connector.php";
$factoryId 		= $_SESSION["FactoryID"];
$checkDate		= $_GET["CheckDate"];
$dateTo	    	= $_GET["DateTo"];
$dateFrom    	= $_GET["DateFrom"];
$location		= $_GET["Location"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Factorywise Exports-Summary</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="650" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Factorywise Exports-Summary</td>
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
        <th width="360" height="25">Factory</th>
        <th width="135">PCS</th>
        <th width="135">Gross Amount</th>
        <th width="135">Net Amt in <br/>
          (USD)</th>
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
						LEFT JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo ";
	if($locationId!="")
	 	$sql_factory .= "WHERE CIH.strCompanyID in ($location) ";
		
	 if($checkDate==1)
	 	$sql_factory .= "AND DATE(CIH.dtmETA) >='$dateFrom' AND DATE(CIH.dtmETA) <='$dateTo' ";
		
		$sql_factory .= "GROUP BY C.strCustomerID ";
	 
	 	//echo $sql_factory;
	$result_fac=$db->RunQuery($sql_factory);
while($row_fac = mysql_fetch_array($result_fac))
{
	$sql = "SELECT
				B.intMainBuyerId,
				MB.strMainBuyerName,
				CIH.strInvoiceNo,
				DATE(CIH.dtmETA) AS dtmETA,
				DATE(CIH.dtmInvoiceDate) AS dtmInvoiceDate,
				CID.strStyleID,
				CID.strBuyerPONo,
				sum(CID.dblQuantity) as dblQuantity,
				CIH.strCurrency,
				CIH.dblExchange,
				F.dblDiscount AS discount,
				F.strDiscountType AS strDiscountType,
				SUM(CID.dblAmount) AS netAmount,
				sum((CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge)) AS netAmountInBaseCurr
				FROM commercial_invoice_header CIH
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				LEFT JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId 
				where CIH.strCompanyID = '".$row_fac["strCompanyID"]."' ";
				
				if($checkDate)
				{
					$sql .=" AND DATE(dtmInvoiceDate) >='$dateFrom' AND DATE(dtmInvoiceDate) <='$dateTo'" ;
				}
				
				$sql .="GROUP BY CIH.strInvoiceNo
						order by CIH.strInvoiceNo";
		$result = $db->RunQuery($sql);	
		//echo $sql;
		$mloc = '';	
		$qty  = 0;
		$net_amtt=0;	
		$netamtt_USD=0;	
		$grossAmt=0;
		while($row = mysql_fetch_array($result))
		{
			if($row['strDiscountType']=='value'){
				$discount = $row['discount'];}
			else{
				$discount = ($row['discount']/100)*$row['netAmount'];	
				}
				
				
				$net_amtt+=($row["netAmount"]-$discount);
				$Rate = $row["dblExchange"];
				$currency = $row["strCurrency"];
				//echo $Rate;
				
				if($currency == "USD")
					{
						$netamtt_USD = $net_amtt;
						//echo $netamtt_USD;
						//echo $net_amtt;
					}
					else
					{
						$netamtt_USD = ( $net_amtt / $Rate ); 
						//echo $netamtt_USD;
					}
				
				
				$mloc	=	$row_fac["strMLocation"];
				$qty 	+=  $row["dblQuantity"];
				$grossAmt	+=$row['netAmount'];
				//$netAmt += $row["netAmount"]- $discount;
			//echo $row['netAmount'];	
		}
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row_fac["strMLocation"]; ?></td>
        <td class="normalfntRite"><?php echo number_format($qty,0);?></td>
        <td class="normalfntRite"><?php echo number_format($grossAmt,2);?></td>
        <td class="normalfntRite"><?php echo number_format($netamtt_USD,2);?></td>        
	</tr>
<?php

	$totQuantity		+= round($qty,0);
	$totNetAmount		+= round($netAmt,2);
	$totamt_USD			 +=round($netamtt_USD,2);
	$totgrossAmt 		+=round($grossAmt,2);
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><b>TOTAL</b></td>
    	<td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totgrossAmt ,2);?></b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totamt_USD ,2);?></b></td>        
	</tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>