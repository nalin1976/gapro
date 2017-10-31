<?php 
session_start();
include "../../Connector.php";
$xmldoc=simplexml_load_file('../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$cusId = $_GET['cusId'];
echo $cusId;	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EXPORT CUSDEC SUMMARY</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.fnt4{
		font-family:Arial;
		font-size:4px;
		text-align:center;
		line-height:6px;
}
.fnt6{
		font-family:Arial;
		font-size:6px;
		text-align:center;
		line-height:8px;
}
.fnt7{
		font-family:Arial;
		font-size:7px;
		text-align:center;
		line-height:9px;
}
.fnt8{
		font-family:Arial;
		font-size:8px;
		text-align:center;
		line-height:10px;
}
.fnt9{
		font-family:Arial;
		font-size:11px;
		line-height:11px;
}
.fnt12{
		font-family:Arial;
		font-size:12px;
		text-align:center;
		line-height:14px;
}
.fnt12-bold{
		font-family:Arial;
		font-size:12px;
		font-weight:900;
		line-height:14px;
}

.fnt12-bold-head{
		font-family:Arial;
		font-size:13px;
		text-align:center;
		font-weight:900;
		line-height:14px;
}

.fnt14-bold{
		font-family:Arial;
		font-size:16px;
		font-weight:700;
		line-height:20px;
}
.fnt16-bold{
		font-family:Arial;
		font-size:18px;
		text-align:center;
		font-weight:700;
		line-height:20px;
}
.fnt30-bold{
		font-family:Arial;
		font-size:34px;
		text-align:center;
		font-weight:700;
}

</style>
<?PHP //$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
//include("printer.php");?>
</head>

<?php
$sql="SELECT
				
									buyers.strBuyerId,
									buyers.strName
									FROM
									buyers
									where strBuyerId ='$cboBuyer'
									";
							$result=$db->RunQuery($sql);
							
							$datahol				=mysql_fetch_array($result);
	$consigneee 			= $datahol['strName'];
?>

<body class="body_bound">
<table width="790" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
    <td width="4%">&nbsp;</td>
    <td width="92%"><table width="99%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
      <tr>
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6" class="fnt16-bold" style="text-align:center">EAM MALIBAN TEXTILES (PVT) LTD</td>
      </tr>
      <tr>
        <td colspan="6" class="fnt14-bold" style="text-align:center">EXPORT CUSDEC SUMMARY</td>
      </tr>
            <tr>
        <td colspan="6" class="fnt13-bold" style="text-align:center">EXPORT ENTRY PASSING DETAILS</td>
      </tr>
                 <tr>
        <td colspan="6" class="fnt13-bold" style="text-align:left"><b>LOCATION / DEBIT A/C - 
	<?php     $sql_location = "SELECT
							customers.strCustomerID,
							customers.strMLocation
							FROM
							customers
							WHERE
							customers.strCustomerID ='$cusId'";
							$result=$db->RunQuery($sql_location);
							$row=mysql_fetch_array($result);
							echo $row['strMLocation'];
		?></b></td>
      </tr>
      <tr>
        <td>
      <table align="center" width="91%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="94">Serial #</th>
        
        <th width="129" height="25">Invoice No</th>
        <th width="164">Entry Date</th>
        <th width="207">Entry No</th>
        <th width="187">Main Buyer</th>
        <th width="176">Ship Qty</th>
       </tr>
      </thead>
      <?php  
	
					$sql = "SELECT
							cih.strInvoiceNo,
							date(cih.dtmSailingDate) AS dtmSailingDate,
							cih.dtmETA,
							sum(cid.dblQuantity) AS dblQuantity,
							fi.dtmDocumentDueDate,
							fi.dtmDocumentSubDate,
							fi.dtmPaymentDueDate,
							fi.dtmPaymentSubDate,
							cid.strEntryNo,
							
							date(cih.dtmManufactDate) AS dtmManufactDate,
							customers.strCustomerID,
							customers.strMLocation,
							buyers_main.strMainBuyerCode
							FROM
							commercial_invoice_detail AS cid
							LEFT JOIN commercial_invoice_header AS cih ON cih.strInvoiceNo = cid.strInvoiceNo
							LEFT JOIN finalinvoice AS fi ON fi.strInvoiceNo = cid.strInvoiceNo
							LEFT JOIN buyers ON cih.strBuyerID = buyers.strBuyerID
							LEFT JOIN customers ON cih.strCompanyID = customers.strCustomerID
							INNER JOIN buyers_main ON buyers.intMainBuyerId = buyers_main.intMainBuyerId
							WHERE customers.strCustomerID='$cusId'
							GROUP BY strInvoiceNo ORDER BY strInvoiceNo";
	
					$result = $db->RunQuery($sql);
		$Serial=0;
		while($row = mysql_fetch_array($result))
		{
			$Serial+=1;
			
			?> 
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td style="text-align:center"><?php echo $Serial; ?></td>
        
      	<td style="text-align:center" height="20"><?php echo $row['strInvoiceNo']; ?></td>
        <td style="text-align:center"><?php echo $row['dtmETA']; ?></td>
        <td style="text-align:center"><?php echo $row['strEntryNo']; ?></td>
        <td style="text-align:center"><?php echo $row['strMainBuyerCode']; ?></td>
        <td style="text-align:right"><?php echo $row['dblQuantity']; ?></td>
        </tr>

        
        
                <?php
		}
		?>
 <?php
				$fulltotQuantity +=$totQty; 
				$fulltotGrossAmount +=$totNetAmount;
				$fulltotNetAmount +=$totNetAmt; 
				$fulltotNetAmount_USD +=$totNetAmtUSD ;
				$fgross+=$gross;
				$discountta+=$discountt;

	
?>

  </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html></td>
  </tr>
</table>
</body>
</html>