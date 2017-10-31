<?php
	session_start();
	include("../../../Connector.php");
	$deliveryNo	= $_GET["deliveryNo"];
	//$deliveryNo	= 165;
	$companyID	= $_SESSION["FactoryID"];
	$xml = simplexml_load_file('../../../config.xml');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Custom Value Declaration :: Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.reporttitle {
	font-family: Times New Roman;
	font-size: 25pt;
	font-weight: bold;
	color: #000000;
	margin: 0px;
	text-align: center;
	letter-spacing:normal;
	word-spacing:normal;
}
.reportsubtitle {
	font-family: Times New Roman;
	font-size: 18pt;
	font-weight: bold;
	color: #000000;
	margin: 0px;
	text-align: center;
}
.font-Size12_family-times{	font-family:Times New Roman;
			font-size:22px;
			color:#000000;
			margin:0px;
			font-weight: normal;
			text-align:justify;
		
}
-->
</style>
</head>

<body style="margin-top:50px">
<?php

$sql="select *
from deliverynote DH where intDeliveryNo=$deliveryNo";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$exporterID 				= $row["strExporterID"];
	$customerID					= $row["strCustomerID"];
	$OriinCountry				= $row["strCtryOfOrigin"];
	$PreviousDoc				= $row["strPrevDoc"];
	$totalInvoiceAmount			= $row["dblTotalInvoiceAmount"];
	$termsOfPayMent				= $row["strTermsOfPayMent"];
	$currency					= $row["strCurrency"];
	$deliveryTerms				= $row["strDeliveryTerms"];
	$insurance					= $row["dblInsurance"];
	$freight					= $row["dblFreight"];
	$others						= $row["dblOther"];
	$placeOfLoading				= $row["strPlaceOfLoading"];
	$invoiceNo					= $row["strInvoiceNo"];
	$invoiceDate				= $row["dtmInvoiceDate"];
	
}
?>
<table  width="979"  align="center" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td width="42" rowspan="3" >&nbsp;</td>
    <td width="891"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="40" class="reporttitle" style="word-spacing:normal"><p class="reportsubtitle" >SRI LANKA CUSTOM - VALUE DECLARATION </p>              </td>
          </tr>
          <tr height="30">
            <td class="normalfntMid" style="word-spacing:normal">(This Declaration shall not be required for goods imported as samples of no commercial value.)<span class="normalfnt_size12"><b>CUSTOM 308 A</b><span></td>
          </tr>
        </table></td>        
      </tr>
      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="outline">
                          <?php
$sqlconsignee="select * from customers where strCustomerID=$customerID";

$result_consignee=$db->RunQuery($sqlconsignee);
while($row_consignee=mysql_fetch_array($result_consignee))
{
	$consigneeName			= $row_consignee["strName"];
	$consigneeAddress1		= $row_consignee["strAddress1"];
	$consigneeAddress2		= $row_consignee["strAddress2"];
	$consigneeCountry		= $row_consignee["strCountry"];
	$consigneeTIN			= $row_consignee["strTIN"];
	$consigneeLocation		= $row_consignee["strLocation"];
	$consigneePPCCode	 	= $row_consignee["strPPCCode"];
	$consigneeSequenceNo 	= $row_consignee["strCode"];
}
?>
          <tr >
<?php
$sqlexporter="select *,
(SELECT strCountry FROM country S WHERE S.strCountryCode=SU.strCountry)AS exporterCountry,
(SELECT strCity FROM city C WHERE C.strCityCode=SU.strCity)AS exporterCity
 from suppliers SU where strSupplierId =$exporterID;";
$result_exporter=$db->RunQuery($sqlexporter);
while($row_exporter=mysql_fetch_array($result_exporter))
{
	$exporterName	= $row_exporter["strName"];
	$exporterAddress1	= $row_exporter["strAddress1"];
	$exporterAddress2	= $row_exporter["strAddress2"];
	$exporterCity	= $row_exporter["exporterCity"];
	$exporterCountry	= $row_exporter["exporterCountry"];
	$exporterTINNo	= $row_exporter["strTINNo"];
	
}
?> 
            <td width="446" class="border-right-fntsize10">01.Importer's Name and Address</td>
            <td class="normalfnt_size10" >03.Exporter's Nme and Address</td>
          </tr>
		  <tr >
            <td height="20" class="border-right-fntsize12">&nbsp;<?php echo $consigneeName;?></td>
            <td class="normalfnt_size12">&nbsp;<?PHP echo $exporterName;?></td>

            </tr>
          <tr >
            <td height="20" class="border-right-fntsize12">&nbsp;<?php echo $consigneeAddress1;?></td>
            <td width="444" class="normalfnt_size12">&nbsp;<?php echo $exporterAddress1;?></td>
            </tr>
          <tr >
            <td height="20" class="border-right-fntsize12">&nbsp;<?php echo $consigneeAddress2;?></td>
            <td class="normalfnt_size12">&nbsp;<?php echo $exporterAddress2;?></td>
            </tr>
          <tr >
            <td height="20" class="border-bottom-right-fntsize12">&nbsp;<?php echo $consigneeCountry;?></td>
            <td class="border-bottom-fntsize12">&nbsp;<?php echo $exporterCity.'&nbsp;'.$exporterCountry;?></td>
          </tr>
<?php

$Declarant = $xml->companySettings->Declarant; 
$DeclarentAddress = $xml->companySettings->Address;
$DeclarentCity = $xml->companySettings->City;
$DeclarentPhone = $xml->companySettings->phone;
$DeclarentDestination = $xml->companySettings->Country;
$DeclDestinationCode = $xml->companySettings->CountryCode;
$DeclarentTinNo = $xml->companySettings->TinNo; 
$DeclarantsSequenceNo = $xml->companySettings->DeclarantsSequenceNo; 

$AdNoBoi = $xml->importCusdec->ADNO_Boi; 
$AdNoGenaral = $xml->importCusdec->ADNO_Genaral;
?>
          <tr >
            <td class="border-right-fntsize10">02.VAT No </td>
            <td class="normalfnt_size10">04.Indenting Agent's Name and Address </td>
          </tr>
          <tr >
            <td height="20" class="border-right-fntsize12" style="text-align:center">&nbsp;<?php echo $consigneeTIN;?></td>
            <td class="normalfnt_size12">&nbsp;<?php echo $Declarant;?></td>
          </tr>
          <tr >
            <td height="20" class="border-right-fntsize12">&nbsp;</td>
            <td class="normalfnt_size12">&nbsp;<?php echo $DeclarentAddress;?></td>
          </tr>         
          <tr >
            <td height="20" class="border-right-fntsize12">&nbsp;</td>
            <td class="normalfnt_size12">&nbsp;<?php echo $DeclarentCity;?></td>
          </tr>
          
        
        </table></td>
        </tr>
      <tr>
        <td height="16" colspan="5" class="font-Size12_family-times"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="3" class="border-left-right-fntsize10">05.Complete Description Of Goods </td>
            </tr>
<?php 
$description ="";
$sql_details="select strItemDescription from deliverydetails where intDeliveryNo='$deliveryNo'";
$result_details = $db->RunQuery($sql_details);
while($row_details=mysql_fetch_array($result_details))
{
	$description	.= $row_details["strItemDescription"].'<br/>';
}
?>
          <tr>
            <td width="2%" class="border-left">&nbsp;</td>
            <td width="96%" rowspan="11" align="left" valign="top" class="normalfnt_size12"><table width="100%" height="270" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="top"><?php echo $description;?></td>
                </tr>
              </table>
              </td>
            <td width="2%" class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
		  <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
		  <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
		  <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
		  <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
		    <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
		    <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
		    <tr>
            <td class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="border-left-right-fntsize10">Note : </td>
            </tr>
          <tr>
            <td  height="20" class="border-left" style="text-align:center">(&Iota;)</td>
            <td class="normalfnt">&nbsp;Complete Description should include detail such as Brand/Make/Model/Art.No/Size/Composition/Volume/Grade</td>
            <td class="border-right">&nbsp;</td>
          </tr>
		  <tr>
            <td  height="20" class="border-left" style="text-align:center">&nbsp;</td>
            <td class="normalfnt">&nbsp;Thickness/Texture/GSM as applicable </td>
            <td class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td  height="20" class="border-left" style="text-align:center">(&Iota;&Iota;)</td>
            <td class="normalfnt">&nbsp;No bill of Entry (CUSDEC) would be expected unless the description of goods is duty entered.</td>
            <td class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td  height="20" class="border-left" style="text-align:center">(&Iota;&Iota;)</td>
            <td class="normalfnt">&nbsp;Attached a separate sheet with details if more space is needed. </td>
            <td class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td class="border-left" style="text-align:center">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td class="border-left" style="text-align:center">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
        </table>
          </td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-right">&nbsp;</td>
        </tr>
	   <tr>
        <td colspan="5" class="border-left-right">&nbsp;</td>
        </tr>
     <tr>
       <td colspan="5"><table width="100%" height="128" border="0" cellpadding="0" cellspacing="0" class="outline">
         <tr>
           <td width="25%" class="border-right">06.Country of Origin </td>
           <td width="25%" class="border-right-fntsize10">07.Port Of Shipment </td>
           <td width="25%" class="border-right-fntsize10" >08.AWB/BL No. and Date </td>
           <td width="25%" class="normalfnt_size10">09.Sales Contract No and Date </td>
         </tr>
         <tr>
           <td height="45" class="border-bottom-right-fntsize12" style="text-align:center"><?php echo $OriinCountry;?></td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo $placeOfLoading;?></td>
           <td style="text-align:center" class="border-bottom-right-fntsize12"><?php echo $PreviousDoc;?></td>
           <td  style="text-align:center" class="border-bottom-fntsize12">&nbsp;</td>
         </tr>
         <tr>
           <td colspan="2" class="border-right-fntsize9">10.Nature of Transaction (Sale,Hire,Gift,etc) </td>
           <td colspan="2"  class="normalfnt_size9">11.Invoice No and Date </td>
           </tr>
         <tr>
           <td height="45" colspan="2" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;</td>
           <td colspan="2" class="border-bottom-fntsize12"  style="text-align:center"><?php echo $invoiceNo .'&nbsp;&nbsp;'.$invoiceDate?></td>
           </tr>
         <tr >
           <td class="border-right-fntsize9">12.Total Invoice Value </td>
           <td class="border-right-fntsize9">13.Terms Of Payment </td>
           <td class="border-right-fntsize9">14.Currency Of Payment </td>
           <td class="normalfnt_size9">15.Terms Of Delivery </td>
         </tr>
         <tr >
           <td height="45"  style="text-align:center" class="border-right-fntsize12"><?php echo number_format($totalInvoiceAmount,2);?></td>
           <td class="border-right-fntsize12" style="text-align:center"><?php echo $termsOfPayMent;?></td>
           <td  style="text-align:center" class="border-right-fntsize12"><?php echo $currency;?></td>
           <td  style="text-align:center" class="normalfnt_size12"><?php echo $deliveryTerms;?></td>
         </tr>
       </table></td>
       </tr>    
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="4" class="border-left-right-fntsize10"><p>16.Declare any the following costs and services not included in the invoice in terms of Article 8(1) and 8(2) of Schedule E of the customs Ordinance: </p>          </td>
        </tr>
        <tr>
          <td height="45" colspan="4" style="text-align:center" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td width="3%" style="text-align:center" class="border-left-fntsize10">(a)</td>
          <td class="normalfnt_size10">Brokerage : <span class="normalfnt_size12"><b>NIL</b></span></td>
          <td class="normalfnt_size10" style="text-align:center">(b)</td>
          <td width="48%" class="border-right-fntsize10">Cost of Containers : <span class="normalfnt_size12"><b>NIL</b></span></td>
        </tr>
        <tr>
          <td class="border-left-fntsize9" style="text-align:center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-right-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td style="text-align:center" class="border-left-fntsize10">(c)</td>
          <td class="normalfnt_size10">Packing Cost : <span class="normalfnt_size12"><b>NIL</b></span></td>
          <td class="normalfnt_size10" style="text-align:center">(d)</td>
          <td class="border-right-fntsize10">Cost of goods and services suppliced by the buyer : <span class="normalfnt_size12"><b>NIL</b></span></td>
        </tr>
        <tr>
          <td class="border-left">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-right-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td style="text-align:center" class="border-left-fntsize10">(e) </td>
          <td class="normalfnt_size10">Royalties and Licence fees : <span class="normalfnt_size12"><b>NIL</b></span></td>
          <td class="normalfnt_size10" style="text-align:center">(f)</td>
          <td class="border-right-fntsize10">Value of proceeds which accrue to sellers : <span class="normalfnt_size12"><b>NIL</b></span></td>
        </tr>
        <tr>
          <td class="border-left">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-right-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td style="text-align:center" class="border-left-fntsize10">(g)</td>
          <td class="normalfnt_size10">Loading Unloading, Handling Chargers : <span class="normalfnt_size12"><b>NIL</b></span><br /> (In Country of exportation) </td>
          <td class="normalfnt_size10" style="text-align:center">(h)</td>
          <td class="border-right-fntsize10">Insuranse : <span class="normalfnt_size12"><b><?php echo number_format($insurance,2);?></b></span></td>
        </tr>
        <tr>
          <td class="border-left">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-right-fntsize12" style="text-align:center"></td>
        </tr>
        <tr>
          <td style="text-align:center" class="border-left-fntsize10">(i) </td>
          <td class="normalfnt_size10">Freight : <span class="normalfnt_size12"><b><?php echo number_format($freight,2);?></b></span></td>
          <td class="normalfnt_size10" style="text-align:center">(j)</td>
          <td class="border-right-fntsize10">Other Payments, if any : <span class="normalfnt_size12"><b><?php echo number_format($others,2);?></b></span></td>
        </tr>
        <tr>
          <td class="border-left">&nbsp;</td>
          <td width="47%" class="normalfnt_size12" style="text-align:center"></td>
          <td width="2%" style="text-align:center" class="normalfnt_size12">&nbsp;</td>
          <td class="border-right-fntsize12" style="text-align:center"></td>
        </tr>
    </table></td>
    <td rowspan="3" width="42">&nbsp;</td>
  </tr>  
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="outline">
        <tr>
          <td class="normalfnt">17.Are you related to the seller in items of Article 9 of schedule E of the customs Ordinance ? </td>
        </tr>
        <tr>
          <td height="40"  class="normalfnt_size12" style="text-align:center"><b>NIL</b></td>
        </tr>
        <tr>
          <td class="normalfnt">18.If related, was the value inflenced by the relationship? </td>
        </tr>
        <tr>
          <td height="40" class="normalfnt_size12" style="text-align:center"><b>NIL</b>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnt">19.Is the sale subject to any condition imposed by the seller?(Refer Article (1)(a),(b),(c),(d) of shedule E of the Ordinanance)</td>
        </tr>
        <tr>
          <td height="40" class="normalfnt_size12" style="text-align:center"><b>NIL</b>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
         
  </table></td>
  </tr>
</table>

</body>
</html>
