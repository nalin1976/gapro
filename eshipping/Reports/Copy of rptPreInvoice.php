<?php 

include "../Connector.php";
$sqlinvoiceheader="SELECT 	
	strInvoiceNo, 
	dtmInvoiceDate, 
	bytType, 
	customers.strName AS CustomerName,
	CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress, 
	customers.strAddress1,
	customers.strAddress2,	
	customers.strcountry AS CustomerCountry,
	buyers.strBuyerID,
	buyers.strName AS BuyerAName, 
	buyers.strAddress1 AS buyerAddress1 ,
	buyers.strAddress2 AS buyerAddress2,
	buyers.strCountry AS BuyerCountry,
	strNotifyID1, 
	strNotifyID2,
	strLCNo AS LCNO,
	dtmLCDate AS LCDate, 
	strLCBankID, 
	dtmLCDate, 
	ID.strPortOfLoading, 
	city.strCity AS city,
	strCarrier, 
	strVoyegeNo, 
	dtmSailingDate, 
	strCurrency, 
	dblExchange, 	
	intNoOfCartons, 
	intMode, 
	strCartonMeasurement, 
	strCBM, 
	strMarksAndNos, 
	strGenDesc, 
	bytStatus, 
	intFINVStatus, 
	intCusdec
		 
	FROM 
	invoiceheader ID
	LEFT JOIN customers ON ID.strCompanyID=customers.strCustomerID
	LEFT JOIN buyers ON ID.strBuyerID =buyers.strBuyerID 
	LEFT JOIN city ON ID.strFinalDest =city.strCityCode 
	WHERE strInvoiceNo='111'";
	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$dateInvoice"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 
	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web :: Import Entry :: Cusdec List Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
.fontColor12 {FONT-SIZE:7PT; ; FONT-FAMILY:Verdana; }
-->
</style>
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%">&nbsp;</td>
        <td width="7%" class="normalfnt">&nbsp;</td>
        <td width="69%" class="tophead"><p class="topheadBLACK">COMMERCIAL INVOICE</p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" cellspacing="0">
      <tr>
        <td colspan="2" class="border-Left-Top-right"><strong>1. SHIPPER</strong></td>
        <td colspan="2" class="border-top-right"><strong>3. NO &amp; DATE OF INVOICE</strong></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right"><?php echo $dataholder['CustomerName'];?></td>
        <td colspan="2" class="border-bottom-right"><span class="paragraph"><span class="fontColor12"><?php echo $dataholder['strInvoiceNo'];?></span><span class="fontColor12"> OF </span><span class="fontColor12"><?php echo $dateInvoice ;?></span></span></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right"><?php echo $dataholder['strAddress1'];?></td>
        <td colspan="2" class="border-right"><strong>4. NO &amp; DATE OF L/C</strong></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right"><?php echo $dataholder['strAddress2'];?></td>
        <td colspan="2" class="border-right"><span class="fontColor12"><?php echo $dataholder['LCNO']; ?> OF <?php echo $LCDate; ?></span></td>
        </tr>
      <tr>
        <td colspan="2" class="border-Left-bottom-right">&nbsp;</td>
        <td colspan="2" class="border-bottom-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right"><strong>2. FOR ACCOUNT &amp; RISK OF MESSERS</strong></td>
        <td colspan="2" class="border-right"><strong>5. NOTIFY PARTY</strong></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right"><span class="fontColor12"><?php echo $dataholder['BuyerAName'];?></span></td>
        <td colspan="2" class="border-right"><span class="fontColor12">
          <?php 

$buyerid=$dataholder['strNotifyID1'];
if ($dataholder['strBuyerID']==$dataholder['strNotifyID1'])
{
	$buyer= "SAME AS CONSIGNEE.";
}
else 
{	
	$sqlselectNotify="SELECT 
	strName, 
	strAddress1, 
	strAddress2, 
	strCountry, 
	strPhone	 
	FROM 
	buyers 
	WHERE strBuyerID='$buyerid'";
	$buyerresult=$db->RunQuery($sqlselectNotify);
	$buyerresultholder=mysql_fetch_array($buyerresult);
	die($sqlselectNotify);
	$buyer=$buyerresultholder['strName'];
	$notfyaddress1=$buyerresultholder['strAddress1'];
	$notifyaddress2=$buyerresultholder['strAddress2'];
	$notifycountry=$buyerresultholder['strCountry'];
}

echo $buyer;

?>
        </span></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right"><span class="fontColor12"><?php echo $dataholder['buyerAddress1'];?></span></td>
        <td colspan="2" class="border-right"><span class="fontColor12"><?php echo $notfyaddress1;?></span></td>
        </tr>
	  <tr>
        <td colspan="2" class="border-left-right"><span class="fontColor12"><?php echo $dataholder['buyerAddress2']; ?></span></td>
        <td colspan="2" class="border-right"><span class="fontColor12"><?php echo $notfyaddress2;?></span></td>
        </tr>
	  <tr>
        <td colspan="2" class="border-left-right"><span class="fontColor12"><?php echo $dataholder['BuyerCountry']."."; ?></span></td>
        <td colspan="2" class="border-right"><span class="fontColor12"><?php echo $notifycountry;?></span></td>
        </tr>
      <tr>
        <td colspan="2" class="border-Left-bottom-right">&nbsp;</td>
        <td colspan="2" class="border-bottom-right">&nbsp;</td>
        </tr>
      <tr>
        <td width="25%" class="border-left-right"><strong>6.PORT OF LOADING</strong></td>
        <td width="25%" class="border-right"><strong>7.FINAL DESTINATION</strong></td>
        <td width="25%" class="border-right"><strong>8.CARRIER</strong></td>
        <td width="25%" class="border-right"><strong>9.SAILING ON OR ABOUT</strong></td>
      </tr>
      <tr>
        <td class="border-Left-bottom-right"><span class="fontColor12"><?php echo $dataholder['strPortOfLoading']; ?></span></td>
        <td class="border-bottom-right"><span class="fontColor12"><?php echo $dataholder['city']; ?></span></td>
        <td class="border-bottom-right"><span class="fontColor12"><?php echo $dataholder['strCarrier']; ?></span></td>
        <td class="border-bottom-right"><span class="fontColor12"><?php echo $LCDate; ?></span></td>
      </tr>


    </table></td>
  </tr>

  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" id="tblInvoice"  >
  <tr>
    <td width="230" class="border-All"><strong>10.MARKS & NOS</strong></td>
    <td width="230"  class="border-top-bottom"><strong>11.DESCRIPTION</strong></td>
    <td width="110" class="border-All"><strong>12.QUANTITY</strong></td>
    <td width="110" class="border-top-bottom"><strong>13.UNIT PRICE</strong></td>
    <td width="110" class="border-All"><strong>14.AMOUNT</strong></td>
  </tr>
  <?
		$sqlinvdtl="";  
  
  
  ?>
  <tr>
    <td>fgdfgdfh<br/>jhsdjhj</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table></td>
  </tr>
  <tr>
  	<td width="694" class="normalfnt"><strong>BALANCE FOB 1,800.00 / DOZEN US DOLLARS PAYBLE COLOMBO</strong></td>	
    <td width="96" class="normalfnt"><strong>5,000.00</strong></td>
  </tr>
  <tr ><td colspan="2" class="normalfnt"><div align="center">TOTAL FOB COLOMBO US DOLLARS FIVE THOUSAND ONLY<br/> 
    COUNTRY OF ORIGIN : SRI LANKA TOTAL <br/>
    PCS : SEVENTY-FIVE ONLY <br/>
    TEXTILE QUOTA CATEGORY NO : PYJAMA / 641
    <br/>
    TOTAL DOZENS : SIX AND 3/12 DOZENS ONLY</div></td></tr>
</table>
</body>
</html>
