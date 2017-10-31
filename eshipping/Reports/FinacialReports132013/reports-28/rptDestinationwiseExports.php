<?php 
session_start();
include "../../../Connector.php";
$factoryId 		= $_SESSION["FactoryID"];
$checkDate		= $_GET["CheckDate"];
$dateTo	    	= $_GET["DateTo"];
$dateFrom    	= $_GET["DateFrom"];
$buyerId		= $_GET["BuyerId"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WaveEDGE | Destinationwise Exports-Summary</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="650" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Destinationwise Exports-Summary</td>
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
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "Exports Summary for the Period of $dateFrom to $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="257" height="25">Destination</th>
        <th width="116">PCS</th>
        <th width="125">Invoice Currency</th>
        <th width="125">Gross Amount</th>
        <th width="127">Net Amount</th>
        </tr>
      </thead> 
<?php
	  	 $sql = "SELECT distinct
					CIH.strCurrency,
					country.strCountry
					FROM
					commercial_invoice_header AS CIH
					INNER JOIN commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
					INNER JOIN finalinvoice AS F ON CIH.strInvoiceNo = F.strInvoiceNo
					INNER JOIN buyers AS B ON B.strBuyerID = CIH.strBuyerID
					INNER JOIN buyers_main AS MB ON MB.intMainBuyerId = B.intMainBuyerId
					INNER JOIN city AS C ON C.strCityCode = CIH.strFinalDest
					INNER JOIN country ON country.strCountryCode = C.strCountryCode
					WHERE B.intMainBuyerId!='' 
					 ";
				
	if($checkDate==1)
		$sql .= " and date(CIH.dtmInvoiceDate) >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";
					
	if($buyerId!="")
		$sql .= " and B.intMainBuyerId=$buyerId";

		$sql .= " GROUP BY country.strCountry,CIH.strCurrency";
		
		//echo $sql;
$result = $db->RunQuery($sql);

while($row = mysql_fetch_array($result))
{
	 $sql_dis = "SELECT
	 			CIH.strInvoiceNo,
				F.dblDiscount dblDiscount,
				F.strDiscountType,
				Sum(CID.dblQuantity) AS dblQuantity,
				Sum(CID.dblAmount) AS netAmount,
				date(CIH.dtmInvoiceDate) AS dtmInvoiceDate,
				country.strCountry
				FROM
				commercial_invoice_header AS CIH
				INNER JOIN commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
				LEFT JOIN finalinvoice AS F ON CIH.strInvoiceNo = F.strInvoiceNo
				INNER JOIN buyers AS B ON B.strBuyerID = CIH.strBuyerID
				INNER JOIN buyers_main AS MB ON MB.intMainBuyerId = B.intMainBuyerId
				INNER JOIN city AS C ON C.strCityCode = CIH.strFinalDest
				INNER JOIN country ON country.strCountryCode = C.strCountryCode
				WHERE B.intMainBuyerId!='' and country.strCountry='".$row["strCountry"]."'  
				 ";
								
					if($checkDate==1)
						$sql_dis .= " and date(dtmInvoiceDate) >='$dateFrom' and date(dtmInvoiceDate) <='$dateTo' ";
									
					if($buyerId!="")
						$sql_dis .= " and B.intMainBuyerId='$buyerId' ";
				
						$sql_dis .= " GROUP BY CIH.strInvoiceNo";
		
		$res_dis = $db->RunQuery($sql_dis);
		//echo $sql_dis;
		$discount=0;
		$netAmt = 0;
		$qty = 0;
		while($row_dis = mysql_fetch_array($res_dis))
		{
			if($row_dis['strDiscountType']=='value')
				$discount += $row_dis['dblDiscount'];
			else
				$discount += ($row_dis['dblDiscount']/100)*$row_dis['netAmount'];
				
			$qty += $row_dis['dblQuantity'];
			$netAmt += $row_dis['netAmount'];
		}
	//echo $discount;
	//echo $netAmt;
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row["strCountry"]; ?></td>
        <td class="normalfntRite"><?php echo number_format($qty,0);?></td>
        <td class="normalfnt"><?php echo $row["strCurrency"]; ?></td>
        <td class="normalfntRite"><?php echo number_format($netAmt,2);?></td>
        <td class="normalfntRite"><?php echo number_format(($netAmt-$discount),2);?></td>        
	</tr>
<?php
	$totQuantity		+= $qty;
	$totNetAmount		+= $netAmt-$discount;
	$totGrossAmount		+= $netAmt ;
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><b>TOTAL</b></td>
    	<td nowrap class="normalfntRite"><b><?php echo number_format($totQuantity,0);?></b></td>
        <td nowrap class="normalfntRite">&nbsp;</td>
         <td nowrap class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>
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