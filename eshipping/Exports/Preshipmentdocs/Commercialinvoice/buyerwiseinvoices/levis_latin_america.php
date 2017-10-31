<?php 
session_start();
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$invoiceNo=$_GET['InvoiceNo'];	
$sqlinvoiceheader="SELECT 	
	ID.strInvoiceNo, 
	date_format(dtmInvoiceDate,'%d-%b-%y')as  dtmInvoiceDate,
	bytType,
	sum(dblGrossMass) as gross,
	sum(dblNetMass) as net,
	sum(dblNetNet) as netnet,
	customers.strName AS CustomerName,
	CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress, 
	customers.strAddress1,
	customers.strAddress2,
	customers.strAddress1,		
	customers.strcountry AS CustomerCountry,
	buyers.strBuyerID,
	buyers.strName AS BuyerAName, 
	buyers.strAddress1 AS buyerAddress1 ,
	buyers.strAddress2 AS buyerAddress2,
	buyers.strCountry AS BuyerCountry,
	buyers.strPhone AS buyerphone,
	buyers.strFax AS BuyerFax,
	byr.strName AS BrokerName , 
	byr.strAddress1 AS BrokerAddress1 ,
	byr.strAddress2 AS BrokerAddress2,
	byr.strCountry AS BrokerCountry,
	byr.strPhone AS Brokerphone,
	byr.strFax AS BrokerFax,
	notify2.strName AS notify2Name , 
	notify2.strAddress1 AS notify2Address1 ,
	notify2.strAddress2 AS notify2Address2,
	notify2.strCountry AS notify2Country,
	notify2.strPhone AS notify2phone,
	notify2.strFax AS notify2Fax,
	strNotifyID1, 
	strNotifyID2,
	strLCNo AS LCNO,
	dtmLCDate AS LCDate, 
	strLCBankID, 
	dtmLCDate, 
	ID.strPortOfLoading, 
	ID.strPreInvoiceNo,
	city.strCity AS city,
	city.strPortOfLoading AS port,
	(select strCountry from country where country.strCountryCode=city.strCountryCode)as countrydest,
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
	bank.strName as bankname,
	bank.strAddress1 as bankaddress1,
	bank.strAddress2 as bankaddress2, 
	bank.strRefNo as bankref, 
	intCusdec,
	strIncoterms		 
	FROM 
	commercial_invoice_header ID
	LEFT JOIN customers ON ID.strCompanyID=customers.strCustomerID
	LEFT JOIN buyers ON ID.strBuyerID =buyers.strBuyerID 
	LEFT JOIN buyers notify2 ON ID.strNotifyID2 =notify2.strBuyerID
	LEFT JOIN buyers byr ON ID.strNotifyID1 =byr.strBuyerID 
	LEFT JOIN city ON ID.strFinalDest =city.strCityCode 
	LEFT JOIN bank ON ID.strLCBankID =bank.strBankCode 
	LEFT JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo=ID.strInvoiceNo
	WHERE  ID.strInvoiceNo='$invoiceNo' group by ID.strInvoiceNo";
	
	//die($sqlinvoiceheader);
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = $dateVariable;
	//die ("$dateInvoice"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 
	
	$str_commercial_inv="select 	
					strInvoiceNo, 
					strBrand, 
					strQuality, 
					strFinishedStd, 
					strPackStd, 
					strGender, 
					strFiberContent, 
					strGarmentType, 
					strBTM, 
					strConstnType, 
					strCat, 
					strCTNSType, 
					strCTNnos, 
					strCTNSize, 
					dblFOB, 
					dblFreight, 
					dblInsurance, 
					dblDestCharge, 
					strBL, 
					strVAT, 
					strContainer, 
					strHAWB, 
					strMAWB, 
					strFreightPC	 
				from finalinvoice
				where 
					strInvoiceNo='$invoiceNo'";
				$result_com_inv=$db->RunQuery($str_commercial_inv);
				$com_inv_dataholder=mysql_fetch_array($result_com_inv);
				$freight_ch=($com_inv_dataholder['dblFreight']==""?0:$com_inv_dataholder['dblFreight']);
				$insurance_ch=($com_inv_dataholder['dblInsurance']==""?0:$com_inv_dataholder['dblInsurance']);
				$dest_ch=($com_inv_dataholder['dblDestCharge']==""?0:$com_inv_dataholder['dblDestCharge']);
				$tot_ch=$freight_ch+$insurance_ch+$dest_ch;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>COMMERCIAL INVOICE</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.invoicefnt {
color:#000000;
font-family:Verdana;
font-size:10px;
font-weight:100;
margin:0;
text-align:left;
}
.invoicefntbold {
color:#000000;
font-family:Verdana;
font-size:10px;
font-weight:bold;
margin:0;
text-align:left;
}
</style>
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="900" border="0" cellspacing="0" cellpadding="1" class="normalfnt_size10">
  <tr>
    <td colspan="11" class="cusdec-normalfnt2bldBLACK" style="text-align:center">COMMERCIAL INVOICE</td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>SHIPPER/EXPORTER/SELLER :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS REG# PV 64804</strong></td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Invoice No. &amp; Date </td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;Exporter's Ref </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize10"><?php echo $dataholder['strInvoiceNo'];?> OF <?php echo $dateInvoice ;?></td>
    <td colspan="3" class="border-left-right-fntsize10"><?php echo $dataholder['strPreInvoiceNo'];?></td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<strong><?php echo $Company;?></strong></td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $Address;?></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;Buyer's Order No &amp; Date </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $City;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;WEB TOOL ID#</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10"> &nbsp;Tel # </td>
    <td colspan="4" ><?php echo $phone;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;Fax # </td>
    <td colspan="4" ><?php echo $Fax;?></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;<strong><?php echo($BrokerTitle==""?"BROKER ADDRESS :":$BrokerTitle)?></strong></td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>MANUFACTURER / SEWER NAME &amp; ADDRESS : </strong></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp; </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['CustomerName'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['BrokerName'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strAddress1'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['BrokerAddress1'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strAddress2'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['BrokerAddress2'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['CustomerCountry'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['BrokerCountry'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<strong>MID NO :</strong></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo ($dataholder['Brokerphone']!=""?"Tel : ".$dataholder['Brokerphone']:"");?> <?php echo ($dataholder['BrokerFax']!=""?"Fax : ".$dataholder['BrokerFax']:"");?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;MANUF. LOCATION / CODE # </td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>CONSIGNEE/ IMPORTER : </strong></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;<strong><?php echo($Notify1Title==""?"NOTIFY PARTY / SHIP TO :":$Notify1Title)?> </strong></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Name'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerAName'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Address1'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['buyerAddress1'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Address2'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['buyerAddress2'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Country'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerCountry'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;Tel # <?php echo $dataholder['notify2phone'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;Tel # <?php echo $dataholder['buyerphone'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;Fax #<?php echo $dataholder['notify2Fax'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;Fax #<?php echo $dataholder['BuyerFax'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Country of origin of Goods</td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;Country of Final Destination</td>
  </tr>
  
  
  <tr>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;Pre-Carriage by </td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Place of Receipt by Carrier </td>
    <td colspan="3" class="border-left-fntsize10" style="text-align:center">SRI LANKA</td>
    <td colspan="3" class="border-left-right-fntsize10" style="text-align:center"><?php echo $dataholder['countrydest'];?></td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;N.A</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;N.A</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;Terms of Delivery and Payment </td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;Vessel/Flight No.</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Port of Loading</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;PAYMENT BY T.T </td>
  </tr>
   <tr>
     <td colspan="2" class="border-left-fntsize10"><?php echo $dataholder['strCarrier'];?></td>
     <td colspan="3" class="border-left-fntsize10"><?php echo $dataholder['strPortOfLoading'].", SRI LANKA";?></td>
     <td colspan="6" class="border-left-right-fntsize10"><strong>&nbsp;<u>DDU BORNMEN DC, BELGIUM, OPEN A/C</u></strong></td>
   </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;Bank Details:</td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;Port of Discharge</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Final Destination</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankname'];?></td>
  </tr>
   <tr>
     <td colspan="2" class="border-left-fntsize10"><?php echo $dataholder['port'];?></td>
     <td colspan="3" class="border-left-fntsize10"><?php echo $dataholder['city'];?></td>
     <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankaddress1']." ".$dataholder['bankaddress2'];?></td>
   </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankref'];?></td>
  </tr>
  
  <tr>
    <td colspan="11" class="border-Left-Top-right-fntsize10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
          <td width="10%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="16%">&nbsp;</td>
          <td width="8%" >&nbsp;</td>
          <td width="6%" >&nbsp;</td>
          <td width="8%" >&nbsp;</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Quantity</span></div></td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Rate</span></div></td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Amount</span></div></td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5"><span class="invoicefntbold">DESCRIPTION OF GOODS</span></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10" style="text-align:center">PIECES</td>
        <td class="border-left-fntsize10" style="text-align:center"><?php echo $dataholder['strIncoterms'];?> UNIT</td>
        <td class="border-left-fntsize10" style="text-align:center"> <?php echo $dataholder['strIncoterms']." ". $dataholder['strCurrency'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="invoicefntbold">GENDER</span></td>
        <td colspan="4"><?php echo $com_inv_dataholder['strGender'];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10" style="text-align:center">COST <?php echo $dataholder['strCurrency'];?></td>
        <td class="border-left-fntsize10" style="text-align:center;font-size:7px"><?php echo $dataholder['city'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="invoicefntbold">FIBER CONTENT </span></td>
        <td colspan="4"><?php echo $com_inv_dataholder['strFiberContent'];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="invoicefntbold">GARMENT TYPE</span></td>
        <td colspan="4"><?php echo $com_inv_dataholder['strGarmentType'];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="invoicefntbold">CONSTN TYPE</span></td>
        <td colspan="4"><?php echo $com_inv_dataholder['strConstnType'];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="invoicefntbold">BTM / TOPS </span></td>
        <td colspan="4"><?php echo $com_inv_dataholder['strBTM'];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="invoicefntbold">QUOTA CAT</span></td>
        <td colspan="4"><?php echo $com_inv_dataholder['strCat'];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>BRAND</td>
        <td colspan="5">:<?php echo $com_inv_dataholder['strBrand'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>QUALITY STD </td>
        <td colspan="5">:<?php echo ($com_inv_dataholder['strQuality']==1?"1st Quality":($com_inv_dataholder['strQuality']==2?"2nd Quality":"3rd Quality"));?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>FINISH STD</td>
        <td colspan="5">:<?php echo $com_inv_dataholder['strFinishedStd'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      
      <tr>
        <td>PACKG STD</td>
        <td>:<?php echo $com_inv_dataholder['strPackStd'];?></td>
        <td class="border-top-bottom-left-fntsize10" style="text-align:center"><span class="invoicefntbold">ITEM</span></td>
        <td class="border-top-bottom-left-fntsize10" style="text-align:center"><span class="invoicefntbold">CTNS</span></td>
          <td colspan="2" class="border-top-bottom-left-fntsize10" style="text-align:center"><span class="invoicefntbold">PRODUCT CODE </span></td>
          <td  style="text-align:center"  class="border-top-bottom-left-fntsize10" nowrap="nowrap"><span class="invoicefntbold">CONTRACT #</span></td>
          <td  style="text-align:center" class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
		 <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <?php 
	  	$str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					strStyleID,
					dblQuantity,
					dblUnitPrice,
					dblAmount,
					intNoOfCTns,
					strISDno,
					strHSCode
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc)){
		$tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$totqty+=$row_desc["dblQuantity"];
		$totctns+=$row_desc["intNoOfCTns"];
		$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
		$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$hts_code=$row_desc["strHSCode"];
	  ?>
     
      <tr>
        <td><?php if ($bool_rec_fst==1) echo "PROD CODE #"; $bool_rec_fst=0;?></td>
        <td><span style="text-align:center"><?php echo $row_desc["strStyleID"];?></span></td>
        <td><?php echo $row_desc["strDescOfGoods"];?></td>
        <td style="text-align:right"><?php echo $row_desc["intNoOfCTns"];?></td>
          <td colspan="2" style="text-align:center"><span style="text-align:center"><?php echo $row_desc["strStyleID"];?></span></td>
          <td style="text-align:center"><?php echo $row_desc["strBuyerPONo"];$f_isd=$row_desc["strISDno"];?></td>
          <td style="text-align:center">&nbsp;</td>
          <td class="border-left-fntsize10" style="text-align:right"><?php echo $row_desc["dblQuantity"];?></td>
          <td class="border-left-fntsize10" style="text-align:right"><span class="normalfnt"><?php echo number_format($price_dtl,2);?></span></td>
          <td class="border-left-fntsize10" style="text-align:right"><span class="normalfnt"><?php echo number_format($amt_dtl,2);?></span></td>
        </tr><?php }?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo $totctns;?></strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo $totqty;?></strong></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo number_format($tot,2);?></strong></td>
        </tr>
      
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td width="6%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="8%" class="border-left-fntsize10">&nbsp;</td>
        <td width="8%" class="border-left-fntsize10">&nbsp;</td>
        <td width="10%" class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-top-left-fntsize10"><strong>TOTAL FOB COST</strong></td>
          <td class="border-top-fntsize10"><?php echo $dataholder['strCurrency'];?></td>
          <td class="border-top-fntsize10" style="text-align:right"><?php echo number_format($tot-($tot_ch*$totqty),2);?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Gross Weight</td>
        <td>:<?php echo number_format($dataholder['gross'],2);?>KGS</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize10"><strong>ADD: SEA FREIGHT </strong></td>
          <td><?php echo $dataholder['strCurrency'];?></td>
          <td style="text-align:right"><?php echo number_format($freight_ch*$totqty,2);?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Net Weight</td>
        <td>:<?php echo number_format($dataholder['net'],2);?>KGS</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize10"><strong>ADD: INSURANCE </strong></td>
          <td><?php echo $dataholder['strCurrency'];?></td>
          <td style="text-align:right"><?php echo number_format($insurance_ch*$totqty,2);?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Net Net Weight</td>
        <td>:<?php echo number_format($dataholder['netnet'],2);?>KGS</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize10"><strong>ADD: DESTINATION CHARGES </strong></td>
          <td><?php echo $dataholder['strCurrency'];?></td>
          <td style="text-align:right"><?php echo number_format($dest_ch*$totqty,2);?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize10"><strong>TOTAL DDU COST</strong></td>
        <td ><?php echo $dataholder['strCurrency'];?></td>
        <td style="text-align:right"><?php echo number_format($tot,2);?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
           <tr>
        <td colspan="3" class="border-top-fntsize10">&nbsp;TOTAL US DOLLARS (IN WORDS): </td>
        <td colspan="5" rowspan="2" class="border-top-fntsize10" valign="top"><strong><?php 
		include "../../../../Reports/numbertotext.php";
		$mat_array=explode(".",number_format($tot,2));
		echo convert_number($tot);
		echo $mat_array[1]!="00"?" AND CENTS ".convert_number($mat_array[1])." ONLY.":" ONLY.";
		?></strong></td>
        <td class="border-top-fntsize10">&nbsp;</td>
        <td class="border-top-fntsize10">TOTAL</td>
        <td class="border-All-fntsize10" style="text-align:right;font-weight:bold"><?php echo number_format($tot,2);?></td>
      </tr>
       <tr>
        <td colspan="3" >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Main Mark: </td>
    <td>&nbsp;</td>
    <td colspan="3">ISD NO:<strong><?php echo $f_isd;?></strong></td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;ISD NUMBER:</td>
    <td colspan="3" ><strong><?php echo $f_isd;?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><?php echo $dataholder['city'];?></td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize10">&nbsp;PS NO. (#)   : </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">C/NO</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;CARTON SIZE </td>
    <td colspan="4"><?php echo $com_inv_dataholder['strCTNSize'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">MADE IN SRI LANKA </td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;CARTON TYPE </td>
    <td colspan="4"><?php echo $com_inv_dataholder['strCTNSType'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;B/L #</td>
    <td colspan="3" ><?php echo $com_inv_dataholder['strBL'];?></td>
    <td>&nbsp;</td>
    <td>Side Marks </td>
    <td>&nbsp;</td>
    <td colspan="3">PRODUCT  DOCE</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;TARIFF  NUMBER(HTS CODE) : <?php echo $r_summary->summary_string($invoiceNo,'strHSCode');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">GROSS WEIGHT</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">NET WEIGHT</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp; </td>
    <td colspan="3" >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">SIZE</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;"SEE ANNEXURE FOR NET NET WEIGHT </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">MEASUREMENT : </td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;    PER PRODUCT CODE / PER SIZES"</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;<strong><?php echo ($com_inv_dataholder['strFreightPC']!="" ? "FREIGHT ".$com_inv_dataholder['strFreightPC']:"");?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">QUANTITY</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">MEASUREMENT</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-fntsize10"><strong>&nbsp;&quot;I DECLARE  THAT I  HAVE  SEEN  SUFFICIENT INFORMATION DOCUMENTS AND PROOF  TO</strong></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-fntsize10"><strong>&nbsp;THE BEST OF MY KNOWLEDGE TO GUARANTEE THAT THE INFORMATION  ON THIS  DOCUMENT</strong></td>
    <td colspan="4" class="border-Left-Top-right-fntsize10">Company seal  Signature &amp; Date</td>
  </tr>
  
  <tr>
    <td colspan="4" class="border-left-fntsize10"><strong>&nbsp;IS TRUE AND CORRECT.&quot;</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;Declaration :</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize10" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;We declare that this invoice shows the actual price of the goods </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize10" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-bottom-left-fntsize10">&nbsp;described and that all particulars are true and correct. </td>
    <td class="border-bottom-fntsize10">&nbsp;</td>
    <td class="border-bottom-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-Left-bottom-right-fntsize10" style="text-align:right">Date  <?php echo $dateInvoice ;?></td>
  </tr>
  
  <tr>
    <td width="11%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
