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
<title>WaveEDGE | Factorywise Receivables Summary - Buyers</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Factorywise Receivables Summary (Buyers)</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td class="normalfnBLD1" style="text-align:center">Exports for the Period of <?php echo $dateFrom; ?> to <?php echo $dateTo; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="89" height="25">Factory</th>
        <th width="100">Buyer</th>
        <th width="60">PCS</th>
        <th width="81">Inv Currency</th>
        <th width="67">Net Amt in Inv Currency</th>
        <th width="58">Net Amount</th>
        </tr>
      </thead> 
      <?php
	 $sql_factory = "SELECT C.strMLocation,CIH.strCompanyID,CIH.strInvoiceNo
					FROM commercial_invoice_header CIH 
					INNER JOIN customers C ON C.strCustomerID = CIH.strCompanyID
					INNER JOIN receipt_detail ON receipt_detail.strInvoiceNo = CIH.strInvoiceNo ";
	if($locationId!="")
	 $sql_factory .= " WHERE CIH.strCompanyID in ($locationId) ";
	 if($checkDate==1)
	 $sql_factory .= " AND DATE(CIH.dtmETA) >='$dateFrom' AND DATE(CIH.dtmETA) <='$dateTo'";
	 $sql_factory .= " GROUP BY C.strCustomerID ";
	 
	$result_fac=$db->RunQuery($sql_factory);
	//echo $sql_factory;
		while($row_fac= mysql_fetch_array($result_fac))
		{
			
		$sql_buyer = "SELECT DISTINCT intMainBuyerId
						FROM
						buyers_main
						INNER JOIN receipt_header ON receipt_header.strBuyerCode = buyers_main.intMainBuyerId
						";
		$res_buyer = $db->RunQuery($sql_buyer);
		
		while($row_buyer = mysql_fetch_array($res_buyer))
		{
		 $sql = "SELECT
				CIH.strInvoiceNo,
				B.intMainBuyerId,
				MB.strMainBuyerName,
				SUM(CID.dblQuantity) AS dblQuantity,
				CIH.strCurrency,
				CIH.dblExchange,
				round(SUM(CID.dblAmount),2) AS grossAmount,
				SUM(F.dblDiscount) AS discount,
				F.strDiscountType,
				round(SUM(CID.dblAmount),2) AS netAmount
				FROM commercial_invoice_header CIH
				INNER JOIN customers C ON C.strCustomerID = CIH.strCompanyID 
				INNER JOIN commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
				INNER JOIN finalinvoice F ON CIH.strInvoiceNo= F.strInvoiceNo
				INNER JOIN buyers B ON B.strBuyerID=CIH.strBuyerID
				INNER JOIN buyers_main MB ON MB.intMainBuyerId=B.intMainBuyerId
				INNER JOIN receipt_detail ON receipt_detail.strInvoiceNo = CIH.strInvoiceNo 
				where CIH.strCompanyID = '".$row_fac["strCompanyID"]."' AND MB.intMainBuyerId = '".$row_buyer["intMainBuyerId"]."' 
				GROUP BY strInvoiceNo
				ORDER BY MB.strMainBuyerName,C.strMLocation";
				$result = $db->RunQuery($sql);
				
				$netAmt1 = 0;
				$netQty  = 0;
				$netAmt  = 0;
				$USDnetAmt=0;
				if(mysql_num_rows($result)>0)
				{ 
					 while($row = mysql_fetch_array($result))
					{
						if($row['strDiscountType']=='value')
							$discount = $row['discount'];
						else
							$discount = ($row['discount']/100)*$row['netAmount'];
							
						$currency = $row["strCurrency"];
						$netAmt1  = $row["netAmount"]-$discount;
						$netAmt += $netAmt1;
						$netQty += $row['dblQuantity'];
						$Rate = $row["dblExchange"];
						
						$mainName = $row["strMainBuyerName"];
					}
					if($currency == "USD")
					{
						$USDnetAmt = $netAmt;
					}
					else
					{
						$USDnetAmt = ( $netAmt / $Rate ); 
					}
					?>
                        <tr bgcolor="#FFFFFF" class="normalfnt">
                        <td height="20"><?php echo $row_fac["strMLocation"]; ?></td> 
                        <td><?php echo $mainName; ?></td>
                        
                        <td class="normalfntRite"><?php echo number_format($netQty,0);?></td>
                        <td class="normalfntRite"><?php echo $currency; ?></td>
                        <td class="normalfntRite"><?php echo number_format($netAmt,2);?></td>
                        <td class="normalfntRite"><?php echo number_format($USDnetAmt,2);?></td>
                        
                             
                    </tr>
                    <?php 
                    $totQuantity		+= round($netQty,0);
                    $totGrossAmount		+= round($netAmt,2);
                    $totNetAmount		+= round($USDnetAmt,2);
					
				  }
                }
                
				$fulltotQuantity +=round($totQuantity); 
				$fulltotGrossAmount +=round($totGrossAmount);
				$fulltotNetAmount +=round($totNetAmount); 
                    ?>
	 <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><b><?php echo $row_fac["strMLocation"]; ?> Total</b></td>
    	<td height="20">&nbsp;</td>
    	<td height="20" class="normalfntRite"><b><?php echo number_format($totQuantity,0)?></b></td>
    	<td height="20">&nbsp;</td>
    	<td height="20" class="normalfntRite"><b><?php echo number_format($totGrossAmount,2);?></b></td>
    	<td height="20" class="normalfntRite"><b><?php echo number_format($totNetAmount,2);?></b></td>
              
	</tr>
    <?php
	$totQuantity 	= 0;
    $totGrossAmount = 0; 
    $totNetAmount	= 0;
	
		
	?>
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