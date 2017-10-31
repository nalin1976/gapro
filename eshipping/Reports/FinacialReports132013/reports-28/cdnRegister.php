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
<title>WaveEDGE | CDN Register</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">CDN  Register</td>
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
        <td colspan="4" class="normalfnt"><b><i><?php echo 	($checkDate== '1' ? "CDN Register for the Period of $dateFrom to $dateTo":"&nbsp;");?></i></b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="71" height="25">Invoice No</th>
        <th width="76">Factory</th>
        <th width="65">Country</th>
        <th width="66">Buyer</th>
        <th width="53">CDN Date</th>
        <th width="56">Sailing Date</th>
        <th width="52">Style No</th>
        <th width="44">PO No</th>
        <th width="41">Pre Inv PCS</th>
        <th width="59">Currency</th>
        <th width="57">Pre Inv Gross Amount</th>
         <th width="56">CDN Quantity</th>
        <th width="57">CDN Amount</th>
         <th width="46">Final Inv Qty</th>
         <th width="57">Final Inv Amount</th>
          <th width="59">Status</th>
        </tr>
      </thead> 
<?php
	  	$sql = "SELECT
					cdn_header.strInvoiceNo,
					buyers_main.strMainBuyerName,
					date(CIH.dtmInvoiceDate) AS dtmInvoiceDate,
					CID.strStyleID,
					CID.strBuyerPONo,
					Sum(CID.dblQuantity) AS dblAQuantity,
					CIH.strCurrency,
					buyers_main.strCountry,
					CIH.strCompanyID,
					customers.strMLocation,
					Sum(CID.dblAmount) AS dblAAmount,
					Sum(CID.dblGrossMass) AS grossAmount,
					buyers.strCountry AS buyerCountry,
					DATE(CIH.dtmInvoiceDate) as dtmInvoiceDate,
					sum(cdn_detail.dblQuantity) as cdn_Quantity,
					sum(cdn_detail.dblAmount) as cdn_Amount
					FROM
					cdn_header
					INNER JOIN invoiceheader AS CIH ON cdn_header.strInvoiceNo = CIH.strInvoiceNo
					LEFT JOIN commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
					INNER JOIN buyers ON buyers.strBuyerID = CIH.strBuyerID
					INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
					INNER JOIN customers ON customers.strCustomerID = CIH.strCompanyID
					LEFT JOIN receipt_detail AS RD ON RD.strInvoiceNo = CIH.strInvoiceNo
					LEFT JOIN discount_detail AS DD ON DD.strInvoiceNo = CIH.strInvoiceNo AND RD.strInvoiceNo = DD.strInvoiceNo
					LEFT JOIN cdn_detail ON cdn_header.strInvoiceNo = cdn_detail.strInvoiceNo

					WHERE cdn_header.strInvoiceNo <> ''  ";
					 
	if($buyerId!="")
		$sql .= " B.intMainBuyerId='$buyerId' ";
		
	if($checkDate==1)
		$sql .= "date(CIH.dtmInvoiceDate) >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";
		//echo $sql;
	/*if($invoNoFrom!="")
		$sql .= "and CIH.dtmInvoiceDate >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";*/
		
		$sql .= "GROUP BY cdn_header.strInvoiceNo ORDER BY cdn_header.strInvoiceNo";
		
$result = $db->RunQuery($sql);
//echo $sql;
while($row = mysql_fetch_array($result))
{
	$invoiceNo=$row["strInvoiceNo"];
	
 
	
					
	
	$sql_cdn="SELECT
				SUM(cdn_detail.dblQuantity) AS cdnyQuantity,
				ROUND(SUM(cdn_detail.dblAmount),2) AS cdnAamount
				FROM
				cdn_detail
				WHERE cdn_detail.strInvoiceNo='$invoiceNo'
				GROUP BY cdn_detail.strInvoiceNo
				 ";
				 
	$result_cdn = $db->RunQuery($sql_cdn);
	//echo $sql_cdn;
	$row_cdn = mysql_fetch_array($result_cdn);
	
		$cdnyQuantity=$row_cdn["cdnyQuantity"];
	$cdnAamount =$row_cdn['cdnAamount'];
	$cdnDateArr=explode(" ",$row_cdn["dtmDate"]);
	$cdnSailDateArr = explode(" ",$row_cdn['dtmSailingDate']);
	












	 $sql_final="SELECT
				commercial_invoice_header.strInvoiceNo,
				sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
				sum(commercial_invoice_detail.dblAmount) AS dblAmount
				FROM
				commercial_invoice_header
				INNER JOIN commercial_invoice_detail ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
				WHERE commercial_invoice_header.strInvoiceNo='$invoiceNo'
				GROUP BY
				commercial_invoice_header.strInvoiceNo
				ORDER BY commercial_invoice_header.strInvoiceNo
				 ";


	$result_final = $db->RunQuery($sql_final);
	//echo $sql_final;
	$row_final = mysql_fetch_array($result_final);
	
	 $fqty=$row_final["dblQuantity"];
	$famt = $row_final['dblAmount'];
	
	
	
				$sql_pre="SELECT
			sum(invoicedetail.dblQuantity) as pre_qty,
			sum(invoicedetail.dblAmount) as pre_amt,
			invoicedetail.strInvoiceNo,
			invoicedetail.strStyleID as pre_strStyleID,
			invoicedetail.strBuyerPONo as pre_strBuyerPONo
			FROM
			invoicedetail
			WHERE invoicedetail.strInvoiceNo = '$invoiceNo'
			GROUP BY
			invoicedetail.strInvoiceNo";

	$result_pre = $db->RunQuery($sql_pre);
	//echo $sql_cdn;
	$row_pre = mysql_fetch_array($result_pre);
	
	 $preqty=$row_pre["pre_qty"];
	$preamt = $row_pre['pre_amt'];
		 $prestyle=$row_pre["pre_strStyleID"];
	$prePoNo = $row_pre['pre_strBuyerPONo'];
	
	
	
	
	
	 $status='';
					 $val_sql= "SELECT
						cdn_header.strInvoiceNo ,
						cdn_header.intCDNConform,
						cdn_header.intCancel
						FROM cdn_header
						WHERE cdn_header.strInvoiceNo='$invoiceNo' ";
						//die($val_sql);
							$result_val = $db->RunQuery($val_sql);
//$val_sql;
//echo $invoiceNo=$row["strInvoiceNo"];

								$row_val = mysql_fetch_array($result_val);
								
									if($row_val["intCancel"]==1)
									{
										$status= "Cancel";
									}
									
									else
									{
										$status= "Confirm";
									}
	
	
	
	
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20"><?php echo $row["strInvoiceNo"]; ?></td>
    	<td class="normalfntMid"><?php echo $row['strMLocation']; ?></td>
    	<td class="normalfntMid"><?php echo $row['buyerCountry']; ?></td>
        <td class="normalfntMid"><?php echo $row["strMainBuyerName"] ?></td>
        <td class="normalfntMid"><?php echo $cdnDateArr[0]; ?></td>
        <td class="normalfntMid"><?php echo $cdnSailDateArr[0]; ?></td>
        <td class="normalfntMid"><?php echo $prestyle; ?></td>
        <td class="normalfntMid"><?php echo $prePoNo; ?></td>
        <td class="normalfntMid"><?php echo $preqty;?></td>
        <td class="normalfntMid"><?php echo $row["strCurrency"] ?></td>
        <td class="normalfntMid"><?php echo number_format($preamt,2);?></td>
        <td class="normalfntMid"><?php echo $cdnyQuantity;?></td>
        <td class="normalfntRite"><?php echo number_format($cdnAamount,2);?></td>
         <td class="normalfntRite"><?php echo $fqty;?></td>
         <td class="normalfntRite"><?php echo number_format($famt,2);?></td>
         <td class="normalfntRite"><?php echo $status; ?></td>
        </tr>
<?php
	$totQuantity		+= $preShipQty;
	$totGrossAmount		+= round($preShipAmt,2);
	
	$totCDNQuantity		+= $cdnyQuantity;
	$totCDNAmount		+= round($cdnAamount,2);
	
	$totFInvQuantity	+= $fqty;
	$totFInvAmount		+= round($famt,2);
	
	$totprevQuantity	+= $preqty;
	$totpreAmount		+= round($preamt ,2);
	
}
?>
	    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td  height="20" colspan="8"><b>Totless</b></td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totprevQuantity,0) ?></b></td>
       <td nowrap class="normalfntRite">&nbsp;</td>
        <td nowrap class="normalfntRite"><b><?php echo number_format($totpreAmount,2);?></b></td>
         <td nowrap class="normalfntRite"><b><?php echo $totCDNQuantity;?></b></td>
          <td nowrap class="normalfntRite"><b><?php echo number_format($totCDNAmount,2);?></b></td>
          <td nowrap class="normalfntRite"><b><?php echo $totFInvQuantity;?></b></td>
         <td nowrap class="normalfntRite"><b><?php echo number_format($totFInvAmount,2);?></b></td>
         <td>&nbsp;</td>
        </tr>
<?php
$totQuantity 	= 0;
$totGrossAmount	= 0;

$totCDNQuantity 	= 0;
$totCDNAmount		= 0;

$totFInvQuantity 	= 0;
$totFInvAmount		= 0;
?> 
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>