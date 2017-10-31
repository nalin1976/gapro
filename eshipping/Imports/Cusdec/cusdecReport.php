<?php
	session_start();
	include("../../Connector.php");
	include("../../authentication.inc");
	$deliveryNo	= $_GET["deliveryNo"];
	$companyID	= $_SESSION["FactoryID"];
	$pub_EicAmount	= 0;
	$pub_xidAmount	= 0;
	$xml = simplexml_load_file('../../config.xml');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Import Cusdec :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style3 {font-size: 11px; color: #000000; margin: 0px; text-align:left; font-family: Verdana;}
-->
</style>
</head>

<body >
<?php
$sql="select *,
(select strCountry from country CU where CU.strCountryCode=DH.strCtryOfOrigin)AS OriinCountry,
(select strCountry from country CU where CU.strCountryCode=DH.strCtryOfExp)AS ExportCountry,
(select strCountry from country CU where CU.strCountryCode=DH.strCityCode)AS CityCountry,
(select strPackageName from packagetypes PT where PT.intPackageID=DH.strPackType)AS packageName
from deliverynote DH where intDeliveryNo=$deliveryNo";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$exporterID 				= $row["strExporterID"];
	$customerID					= $row["strCustomerID"];
	$Vessel						= $row["strVessel"];
	$voyageNo 					= $row["strVoyageNo"];
	$VoyageDate 				= substr($row["dtmVoyageDate"],0,10);
		$VoyageNoArray 			= explode('-',$VoyageDate);
		$formatedVoyageDate 	= $VoyageNoArray[2]."/".$VoyageNoArray[1]."/".$VoyageNoArray[0];
	$packages					= $row["dblPackages"];
	$OriinCountry				= $row["OriinCountry"];
	$exportCountry				= $row["ExportCountry"];
	$exportCountryCode			= $row["strCtryOfExp"];
	$cityCountry				= $row["CityCountry"];
	$cityCountryCode			= $row["strCityCode"];
	$officeOfEntry				= $row["strOfficeOfEntry"];
	$currency					= $row["strCurrency"];
	$exRate						= $row["dblExRate"];
	$totalInvoiceAmount			= $row["dblTotalInvoiceAmount"];
	$totalAmount				= $row["dblTotalAmount"];
	$deliveryTerms				= $row["strDeliveryTerms"];
	$insurance					= $row["dblInsurance"];
	$freight					= $row["dblFreight"];
	$others						= $row["dblOther"];
	$PreviousDoc				= $row["strPrevDoc"];
	$TQBNo						= $row["strTQBNo"];
	$consigneeRefCode 			= $row["strConsigneeRefCode"];
	$countryOfOriginCode		= $row["strCtryOfOrigin"];
	$authorizedBy				= $row["strAuthorizedBy"];
	$marks1				   		= $row["strMarks"];
	$marks						= str_replace("\n","<br>",$marks1);
	$containerNo				= $row["strContainerNo"];
	$bankCode					= $row["strBankCode"];	
	$RecordType					= $row["RecordType"];
	$mode						= $row["strMode"];
	$termsOfPayMent				= $row["strTermsOfPayMent"];
	$wharfClerk					= $row["intWharfClerk"];
	$dblCBM						= $row["dblCBM"];
	$fcl						= $row["strFCL"];
	$weight						= $row["strWeight"];
	$CountOfContainer			= $row["strCountOfContainer"].'x'.$row["intFeet"];
	$packageName				= $row["packageName"];
	$lcno						= $row["strLCNO"];
	$preferenceCode				= $row["strPreferenceCode"];
	$licenceNo					= $row["strLicenceNo"];
	$containerCount				= $row["strCountOfContainer"];
	$placeOfLoading				= $row["strPlaceOfLoading"];
	$bankRefName				= $row["strBankRefNo"];
}
?>
<table width="939"  align="center">
  <tr>
    <td width="931"><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="33%" class="cusdec-normalfnt2bldBLACK">CUSDEC - I </td>
        <td width="54%" class="cusdec-normalfnt2bldBLACK"><i>SRI LANKA CUSTOMS - GOODS DECLARATION</i></td>
        <td width="13%" class="cusdec-normalfnt2bldBLACK">CUSTOMS - 53 </td>
      </tr>
    </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline">
      <tr>
        <td width="4%" rowspan="7" align="center" valign="middle" class="border-bottom"><img src="../../images/headerinformation.png"/></td>
        <td width="44%"><table width="100%" height="127" border="0" cellpadding="0" cellspacing="0">
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
          <tr>
            <td width="56%" class="border-left-fntsize9">&nbsp;2.Exporter</td>
            <td width="44%" class="border-right-fntsize10">&nbsp;TIN:<span class="normalfnt"><?php echo $exporterTINNo;?></span></td>
          </tr>
          <tr>
            <td colspan="2" class="border-left-right-fntsize12">&nbsp;<?php echo $exporterName;?></td>
            </tr>
          <tr>
            <td colspan="2" class="border-left-right">&nbsp;<?php echo $exporterAddress1;?></td>
            </tr>
          <tr>
            <td colspan="2" class="border-left-right">&nbsp;<?php echo $exporterAddress2;?></td>
            </tr>
          <tr>
            <td height="19" colspan="2" class="border-left-right">&nbsp;<?php echo $exporterCity;?></td>
            </tr>
          <tr>
            <td height="19" class="border-left">&nbsp;<?php echo $exporterCountry;?></td>
            <td class="border-right">&nbsp;</td>
          </tr>
          <tr>
            <td height="19" class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>

        </table></td>
        <td width="52%" colspan="4"><table width="100%" height="127" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td  colspan="3" class="border-right-fntsize9">&nbsp;1. DECLARATION</td>
            <td colspan="2" class="normalfnt_size10">&nbsp;A. OFFICE USE</td>
          </tr>
          <tr>
            <td width="7%" height="21" class="border-bottom-right"><div align="center">I</div></td>
            <td width="7%" class="border-bottom-right"><div align="center">M</div></td>
            <td width="23%" align="center" class="border-bottom-right"><div align="center">
			<?php 
				if($RecordType=='IM')
					echo 5;
				elseif($RecordType=='IMGEN')
					echo 4;
			?>
			</div></td>
            <td colspan="2" class="normalfnt_size10">&nbsp;Manifest :</td>
          </tr>
          <tr>
            <td  colspan="2" class="border-right-fntsize10">&nbsp;3. Pages</td>
            <td class="border-right-fntsize10">&nbsp;4. List</td>
            <td colspan="2" class="normalfnt_size10">&nbsp;Customs Reference</td>
          </tr>
          <tr>
            <td height="26" class="border-bottom-right"><div align="center">1</div></td>
            <td class="border-bottom-right" style="text-align:center" id="totNoOfPages"></td>
            <td class="border-bottom-right">&nbsp;</td>
            <td width="43%" class="border-bottom-fntsize10">&nbsp;Number :</td>
            <td width="20%" class="border-bottom-fntsize10">Date :</td>
          </tr>
          <tr>
            <td colspan="2" class="border-right-fntsize10">&nbsp;5. Items</td>
            <td height="19" colspan="3" class="normalfnt_size10"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="27%" class="border-right-fntsize10">&nbsp;6. Total Packages</td>
                <td width="73%" class="normalfnt_size10">&nbsp;7. Declarants Sequence Number</td>
                </tr>
            </table></td>
            </tr>
          <tr>
            <td height="19" class="normalfnt_size10">&nbsp;</td>
            <td height="19" class="border-right" id="noOfItem"></td>
            <td height="19" colspan="3" class="normalfnt_size10"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr height="100%">
                <td width="27%" align="center" class="border-right"><div align="center"><b><?php echo $packages;?></b></div></td>
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
				<td width="73%" align="center" ><?php 
				 $DeclarantsSequenceNo = $xml->companySettings->DeclarantsSequenceNo; 
				 if($RecordType=='IM')
				 	echo  $consigneeSequenceNo;
				 else
				 	echo "";
				 ?></td>
                </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" height="122" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="56%" class="border-top-left-fntsize10">&nbsp;8.Consignee</td>
            <td width="44%" class="border-top-right-fntsize9" >TIN:<span class="normalfnt"><?php echo $consigneeTIN;?></span></td>
          </tr>
          <tr>
            <td colspan="2" class="border-left-right-fntsize12">&nbsp;<?php echo $consigneeName;?></td>
          </tr>
          <tr>
            <td colspan="2" class="border-left-right">&nbsp;<?php echo $consigneeAddress1;?></td>
          </tr>
          <tr>
            <td height="19" colspan="2" class="border-left-right">&nbsp;<?php echo $consigneeAddress2;?></td>
            </tr>
          <tr>
            <td height="19" class="border-left">&nbsp;<?php echo $consigneeCountry;?></td>
            <td class="border-right-fntsize9">Ref.Code:<span class="normalfnt"><?php echo $deliveryNo.'/'.$consigneeRefCode;?> </span></td>
          </tr>
          <tr>
            <td height="19" class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
        </table></td>
        <td colspan="4" class="border-top-fntsize10"><table width="100%" height="122" border="0" cellpadding="0" cellspacing="0">
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
          <tr>
            <td colspan="4" class="normalfnt_size10">&nbsp;9. Person Responsible for Financial Settlement&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TIN :<span class="normalfnt"><?php echo $consigneeTIN;?></span></td>
            </tr>
          <tr>
            <td colspan="4" class="normalfnt_size10">&nbsp;<?php echo $consigneeName;?></td>
          </tr>
          <tr>
            <td colspan="4" class="normalfnt_size10">&nbsp;<?php echo $consigneeAddress1;?></td>
          </tr>
          <tr>
            <td height="19" colspan="4" class="normalfnt_size10">&nbsp;<?php echo $consigneeAddress2.'&nbsp;'.$consigneeCountry;?></td>
            </tr>
          <tr>
            <td width="34%" class="border-top-right-fntsize9">10.City of Last Consi/First Dest</td>
            <td width="21%" class="border-top-right-fntsize9">11.Trading Country</td>
            <td width="22%" class="border-top-right-fntsize9">12.Value Details</td>
            <td width="23%" class="border-top-fntsize10">13.C.A.P</td>
          </tr>
          <tr>
            <td height="19" class="border-right-fntsize12" style="text-align:center">
			<?php 			
				if($RecordType=='IM')
					echo $cityCountry;
				elseif($RecordType=='IMGEN')
					echo $cityCountryCode;
			?></td>
            <td height="19" class="border-right-fntsize12"  style="text-align:center"><?php echo $cityCountryCode;?></td>
            <td class="border-right-fntsize12-bold" id="totalReportValue" style="text-align:center;"></td>
            <td class="normalfnt" style="text-align:center"><?php echo $containerCount;?></td>
          </tr>
        </table></td>
      </tr>
	  

      <tr>
        <td height="8"><table width="100%" height="80" border="0" cellpadding="0" cellspacing="0">
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
          <tr>
            <td width="56%" class="border-top-left-fntsize10">&nbsp;14. Declarant / Representative</td>
            <td width="44%" class="border-top-right-fntsize9" >TIN : <span class="normalfnt_size11"> <?php echo $DeclarentTinNo;?></span></td>
          </tr>
          <tr>
            <td colspan="2" class="border-left-right-fntsize10">&nbsp;<?php echo $Declarant;?></td>
            </tr>
          <tr>
            <td colspan="2" class="border-left-right-fntsize10">&nbsp;<?php echo $DeclarentAddress;?></td>
          </tr>
          <tr>
            <td height="19" colspan="2" class="border-Left-bottom-right-fntsize10">&nbsp;<?php echo $DeclarentCity;?></td>
            </tr>          
                  </table></td>
        <td colspan="4" class="normalfnt_size10"><table width="100%" height="80" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="55%" class="border-top-right-fntsize10">15. Country Of Export</td>
            <td width="22%" class="border-top-right-fntsize9">15A. Ctry.Ex.Code</td>
            <td width="23%" class="cusdec_border-top-fntsize9" >17A.Ctry.Dst.Code</td>
          </tr>
          <tr>
            <td class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;
			<?php
				if($RecordType=='IM')
					echo $exportCountry;
				elseif($RecordType=='IMGEN')
					echo $exportCountryCode;
			?></td>
            <td class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;<?php echo $exportCountryCode;?></td>
            <td class="border-bottom-fntsize12" style="text-align:center">&nbsp;<?php echo $DeclDestinationCode;?></td>
          </tr>
          <tr>
            <td class="border-right-fntsize10">&nbsp;16. Country Of Origin</td>
            <td colspan="2" class="normalfnt_size10">&nbsp;17. Country of Destination</td>
            </tr>
          <tr>
            <td height="19" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;
			<?php 
			if($RecordType=='IM')
				echo $OriinCountry;
			elseif($RecordType=='IMGEN')
				echo $countryOfOriginCode;
			?></td>
            <td height="19" colspan="2" class="border-bottom">&nbsp;
			<?php 
			if($RecordType=='IM')
				echo $DeclarentDestination;
			elseif($RecordType=='IMGEN')
				echo $DeclDestinationCode;
			?></td>
            </tr>
        </table></td>
        </tr>
      <tr>
        <td height="16" class="normalfnt_size10"><table width="102%" height="36" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="73%" height="12"  class="border-left-fntsize9">&nbsp;18. Vessel / Flight</td>
            <td width="15%" class="normalfnt_size10-fntsize10">&nbsp;Flag</td>
            <td width="12%" class="border-left-right-fntsize9" >&nbsp;19. FCL</td>
          </tr>
          <tr>
            <td height="24" class="border-bottom-left-fntsize12">&nbsp;<b><?php echo $Vessel;?></b></td>
            <td height="24" class="border-bottom-left">&nbsp;</td>
            <td class="border-Left-bottom-right-fntsize12" style="text-align:center"><?php echo $fcl;?></td>
          </tr>


        </table></td>
        <td colspan="4" class="normalfnt_size10"><table width="102%" height="37" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="55%" height="13" class="normalfnt_size9">&nbsp;20. Delivery Terms</td>
            <td width="45%" class="style3" >&nbsp;</td>
          </tr>
          <tr>
            <td height="24" class="border-bottom-fntsize12" style="text-align:center">&nbsp;<?php echo $deliveryTerms;?></td>
            <td class="border-bottom" >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td ><table width="102%" height="40" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="72%"  class="border-left-fntsize9">&nbsp;21. Voyage No. / Date</td>
            <td width="16%" class="normalfnt_size10">&nbsp;</td>
            <td width="12%" class="border-right" >&nbsp;</td>
          </tr>
          <tr>
            <td height="24" class="border-bottom-left-fntsize12">&nbsp;<b><?php echo $voyageNo.'-'.$formatedVoyageDate?></b></td>
            <td height="24" class="border-bottom-right">&nbsp;</td>
            <td class="border-bottom-right" >&nbsp;</td>
          </tr>
        </table></td>
        <td colspan="4" ><table width="102%" height="40" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2" class="border-right-fntsize9">&nbsp;22. Currency and Total Amount Invoiced</td>
            <td width="22%" class="border-right-fntsize9">&nbsp;23. Exchange Rate</td>
            <td colspan="2" class="normalfnt_size9">&nbsp;24. Natu.of.Transt.</td>
            </tr>
          <tr>
            <td width="13%" height="24" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;<b><?php echo $currency;?></b></td>
            <td width="42%" height="24" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo number_format($totalInvoiceAmount,2);?></b></td>
            <td height="24" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo number_format($exRate,4);?></b></td>
            <td width="12%" height="24" class="border-bottom-right">&nbsp;</td>
            <td width="11%" class="border-bottom" >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
     <tr>
       <td height="21"><table width="102%" height="48" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td height="24" colspan="2" class="border-left-right-fntsize9" style="text-align:center">25. Mode of trans. at Border</td>
           <td colspan="2" class="border-right-fntsize9" style="text-align:center">26. Inland Mode of Transport</td>
           <td colspan="2" class="border-right-fntsize9">27. Place of Loading /Discharging</td>
           </tr>
         <tr>
           <td width="13%" height="24" class="border-Left-bottom-right-fntsize12" style="text-align:center"><?php echo $mode;?></td>
           <td width="12%" height="24" class="border-bottom-right">&nbsp;</td>
           <td width="13%" height="24" class="border-bottom-right">&nbsp;</td>
           <td width="12%" height="24" class="border-bottom-right">&nbsp;</td>
           <td width="38%" height="24" class="border-bottom-right-fntsize12" style="text-align:center"><?php echo $placeOfLoading;?></td>
           <td width="12%" class="border-bottom-right" style="text-align:center">LK</td>
         </tr>
       </table></td>
       <td colspan="4"><table width="102%" height="48" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="62%" rowspan="2" class="border-bottom-fntsize10">&nbsp;28. Financial and Banking Data<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  Terms of Payment : <?php echo $termsOfPayMent;?></strong></td>
           <td width="38%" height="24" class="normalfnt_size10" style="text-align:center">Bank Code</td>
         </tr>
         <tr>
           <td height="24" class="border-bottom" style="text-align:center"><?php 
		   $bankMain = explode('.',$bankCode);
		   echo $bankMain[0];
		   ?></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td height="21"><table width="102%" height="48" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="50%" height="24" class="border-left-right-fntsize10">&nbsp;29. Office of Entry / Exit</td>
           <td width="50%" class="border-right-fntsize9">30. Location of Goods</td>
           </tr>
         <tr>
           <td height="24" class="border-Left-bottom-right-fntsize12">&nbsp;<b><?php echo $officeOfEntry;?></b></td>
           <td height="24" class="border-bottom-right-fntsize12"  style="text-align:center">
<?php
$sqlmode="select strPlaceofDcs  from mode where  strMode='$mode'";
$result_mode=$db->RunQuery($sqlmode);
while($row_mode=mysql_fetch_array($result_mode))
{
	echo $row_mode["strPlaceofDcs"];
}
?></td>
           </tr>
       </table></td>
       <td colspan="4"><table width="102%" height="48" border="0" cellpadding="0" cellspacing="0">
<?php 
$sql_bank="select strName,strRefNo from bank B where B.strBankCode='$bankCode'";
$result_bank=$db->RunQuery($sql_bank);
while($row_bank=mysql_fetch_array($result_bank))
{
	$bankName 		= $row_bank["strName"];
	//$bankRefName 	= $row_bank["strRefNo"];
	$bankBranch		= explode('.',$bankCode);
}
?>
         <tr>
           <td width="5%" height="24" class="normalfnt_size10">28A.</td>
           <td width="16%" class="normalfnt_size10">Bank Name :</td>
           <td height="24" class="normalfnt_size10"><?php echo $bankName?></td>
           <td width="38%" class="normalfnt_size10">Ref. No:<span class="normalfnt" style="text-align:center"><?php echo $bankRefName;?></span></td>
         </tr>
         <tr>
           <td height="24" class="border-bottom-fntsize10">&nbsp;</td>
           <td height="24" class="border-bottom-fntsize10">Branch :</td>
           <td width="41%" class="border-bottom-fntsize10"><?php echo $bankBranch[1];?></td>
           <td class="border-bottom" style="text-align:center" ><?php echo $lcno;?></td>
         </tr>
       </table></td>
	   </tr>
     <tr>
       <td height="21" class="border-bottom"> <img src="../../images/pkgsanddescriptionofgoods.png"/> </td>
       <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
<?php 
$sqldetails="select strStyleNo,
	strItemCode,
	strItemDescription AS itemDescription, 
	intItemNo,
	strCommodityCode,
	dblQty,
	intNoOfPackages,
	dblItemPrice,
	dblGrossMass,
	dblNetMass,
	strProcCode1,
	strProcCode2,
	dblItmValue,
	strUnit,
	strUmoQty1,
	strUmoQty2,
	strUmoQty3
	from deliverydetails DD where intDeliveryNo=$deliveryNo 	
	Order By intItemNo
	limit 0,1;";

$result_details=$db->RunQuery($sqldetails);
while($row_details=mysql_fetch_array($result_details))
{
	$styleNo			= $row_details["strStyleNo"];
	$itemCode			= $row_details["strItemCode"];
	$itemDescription	= $row_details["itemDescription"];
	$itemNo				= $row_details["intItemNo"];
	$commodityCode		= $row_details["strCommodityCode"];
	$noOfPackages		= $row_details["intNoOfPackages"].'&nbsp;'.$packageName;
	$qty				= $row_details["dblQty"];	
	$itemPrice			= $row_details["dblItemPrice"];
	$grossMass			= $row_details["dblGrossMass"];
	$netMass			= $row_details["dblNetMass"];
	$procCode1			= $row_details["strProcCode1"];
	$procCode2			= $row_details["strProcCode2"];
	$itmValue			= $row_details["dblItmValue"];
	$unit				= $row_details["strUnit"];
	$umoQty1			= $row_details["strUmoQty1"];
	$umoQty2			= $row_details["strUmoQty2"];
	$umoQty3			= $row_details["strUmoQty3"];
	
}
?>
           <td width="1%" height="19" class="border-left-fntsize10">&nbsp;</td>
           <td width="12%" class="normalfnt_size10"><strong>Marks &amp; Numbers</strong></td>
           <td width="1%" align="center" class="normalfnt_size10">&nbsp;</td>
           <td width="15%" class="normalfnt_size10" style="text-align:center"><strong>Container No(s)</strong></td>
           <td width="2%" class="normalfnt_size10">-</td>
           <td width="17%" class="normalfnt_size10"><strong>Number and Kind</strong></td>
           <td width="10%" class="border-left-right-fntsize10">&nbsp;32. Item No</td>
           <td colspan="4" class="normalfnt_size10">&nbsp;33. Commodity (HS) Code</td>
           </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td rowspan="9" align="left" valign="top" class="border-bottom-fntsize12"><?php echo $marks;?></td>
           <td height="25" class="normalfnt_size10">&nbsp;</td>
           <td rowspan="3" align="center" valign="top" class="normalfnt_size12" style="text-align:center"><?php 
		   if ($fcl==1)
		   		echo $CountOfContainer;
		   
		   	?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td rowspan="3" align="center" valign="top" class="normalfnt_size12" style="text-align:center"><?php echo  $noOfPackages;?></td>
           <td align="center" class="border-Left-bottom-right-fntsize12" ><div align="center"><span class="normalfnt_size10" ><?php echo $itemNo;?></span></div></td>
           <td height="25" colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $commodityCode;?></b></td>
           </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="19" class="normalfnt_size10"></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize10">&nbsp;34. Ctry.of. Origin Code</td>
           <td width="15%" class="border-right-fntsize10">&nbsp;35. Gross Mass (Kg)</td>
           <td width="11%" class="normalfnt_size9">&nbsp;36. Preference</td>
         </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="25" class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td height="25"width="7%" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;<?php echo $countryOfOriginCode;?></td>
           <td width="9%" class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-right-fntsize12"><div align="center">&nbsp;<?php echo number_format($grossMass,2);?></div></td>
           <td class="border-bottom" style="text-align:center"><?php echo $preferenceCode;?></td>
         </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="21" class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">Goods Description</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize10">&nbsp;37. Procedure Code</td>
           <td width="15%" class="border-right-fntsize10">&nbsp;38. Net Mass (Kg)</td>
           <td width="11%" class="normalfnt_size9">&nbsp;39. Quota</td>
         </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="25" class="normalfnt_size10">&nbsp;</td>
           <td colspan="3" rowspan="5" align="left" valign="top" class="border-bottom"><strong><?php echo $itemDescription;?></strong></td>
           <td rowspan="3" align="center" valign="top" class="border-right"><?php echo round($qty,2).'&nbsp;-'.$unit?></td>
           <td height="25" width="7%" class="border-bottom-right" style="text-align:center"><b><?php echo $procCode1;?></b></td>
           <td width="9%" class="border-bottom-right" style="text-align:center"><b><?php echo $procCode2;?></b></td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo number_format($netMass,2);?></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="19" class="normalfnt_size10">&nbsp;</td>
           <td colspan="4" class="normalfnt_size10">&nbsp;40. Previous Document / BL / AWB No.</td>
           </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td>&nbsp;</td>
           <td height="30" colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $PreviousDoc;?></b></td>
           </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td>&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize10">&nbsp;41A. UMO &amp; Qty 1</td>
           <td class="border-right-fntsize9">&nbsp;42. Item Price (FOB/CIF)</td>
           <td class="normalfnt_size10">&nbsp;43.</td>
         </tr>
         <tr>
           <td class="border-bottom-left">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom-right">&nbsp;</td>
           <td colspan="2" class="border-bottom-right-fntsize12" style="text-align:center">
		   <?php echo ($umoQty1=="" ? "":$umoQty1);?></td>
           <td height="30" class="border-bottom-right-fntsize12" style="text-align:center"><b>
		   <?php
		   if($RecordType=='IM')
		   		echo number_format($itemPrice,2);
		   elseif($RecordType=='IMGEN')
		  		echo number_format(($itmValue/$exRate),2);
		   ?></b></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
       </table></td>
       </tr>
     <tr>
       <td height="20" class="border-bottom"><img src="../../images/additionaldocs.png" height="61" /></td>
       <td colspan="5" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr height="20">
           <td width="8%" class="border-left-fntsize10">&nbsp;Licence No:</td>
           <td colspan="12" class="normalfnt"><?php echo $licenceNo;?></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="normalfnt_size10">&nbsp;</td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="2%" class="border-right-fntsize10">&nbsp;</td>
           <td width="16%" class="border-right-fntsize10">&nbsp;41B. UMO &amp; Qty 2</td>
           <td width="15%" class="border-right">&nbsp;</td>
           <td width="11%" class="normalfnt_size9">&nbsp;45. Adjustments</td>
         </tr>
         <tr>
           <td class="border-left-fntsize10">&nbsp;A.D. :</td>
           <td colspan="12" class="normalfnt">
		   <?php 
		   		if($RecordType=="IM")
					echo $AdNoBoi;
				elseif($RecordType="IMGEN")
					echo $AdNoGenaral;
			?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty2=="" ? "":$umoQty2);?></td>
           <td class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-fntsize10">&nbsp;</td>
         </tr>
         <tr>
           <td class="border-left-fntsize10">&nbsp;TQB :</td>
           <td width="16%" class="normalfnt"><strong><?php echo $TQBNo;
		   
		   $string = $consigneePPCCode;

			$chars = preg_split('//', $string, -1, PREG_SPLIT_NO_EMPTY);
			
			
		   
		   ?></strong></td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[0]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[1]; ?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[2]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[3]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[4]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[5]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[6]; ?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[7]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[8]; ?></strong></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-All" style="text-align:center"><strong><?php echo $chars[9]; ?></strong></td>
           <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[10]; ?></strong></td>
		   <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;41C. UMO &amp; Qty 3</td>
           <td colspan="2" class="normalfnt_size10" style="text-align:center">46. Value (NCY)</td>
           </tr>
         <tr>
           <td class="border-bottom-left">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty3=="" ? "":$umoQty3);?></td>
           <td colspan="2" class="border-bottom-fntsize12" style="text-align:center"><b><?php echo number_format($itmValue,0)?></b></td>
         </tr>
       </table></td>
       </tr>
     <tr>
       <td height="21" class="border-bottom"><img src="../../images/culculationoftaxes.png" /></td>
       <td><table width="100%" height="228" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="22%" height="19" class="border-Left-bottom-right-fntsize10" style="text-align:center">(1) Type</td>
           <td width="27%" class="border-bottom-right-fntsize10" style="text-align:center">(2) Tax Base</td>
           <td width="14%" class="border-bottom-right-fntsize10" style="text-align:center">3) Rate</td>
           <td width="26%" class="border-bottom-right-fntsize10" style="text-align:center">(4) Amount</td>
           <td width="11%" class="border-bottom-right-fntsize10" style="text-align:center">5) MP</td>        
         </tr>
<?php
$loop			= 0;
$totAmount		= 0;
$totMP			= 0;

$sqltax="select * from cusdectax where intDeliveryNo=$deliveryNo AND intItemCode=$itemCode
order By intPosition
limit 0,10";

$result_tax=$db->RunQuery($sqltax);
while($row_tax=mysql_fetch_array($result_tax))
{
	$TaxCode	= $row_tax["strTaxCode"];
	$TaxBase	= $row_tax["dblTaxBase"];
	$Rate		= $row_tax["dblRate"];
	$Amount		= $row_tax["dblAmount"];
	$MP			= $row_tax["intMP"];
	
	/*if($TaxCode=="EIC")
	{
		$sqlcom="select * from commoditycodes where strCommodityCode='$commodityCode' and strTaxCode='EIC'";
		$result_com=$db->RunQuery($sqlcom);
		while($row_com=mysql_fetch_array($result_com))
		{
			$optionalRate	= $row_com["dblOptRates"];
			$totEic  		= $netMass * $optionalRate;
		}	
		if($Amount<$totEic)
		{
			$TaxBase		= $netMass;
			$Rate			= $optionalRate;
			$Amount			= $totEic;
		}	
		$pub_EicAmount		= $Amount;
	}
	if($TaxCode=="COM/EX/SEAL")
	{
		$TaxBase		= "";
		$Amount			= $Amount;
		$Rate			= "";
		$TaxBase		= "";
	}
	elseif($TaxCode=="XID")
	{
		$TaxBase		= "";
		$Amount			= round($netMass,0);
		$Rate			= "";
		$TaxBase		= "";
		$pub_xidAmount	= $Amount;
	}*/

if($loop=="12"){return;}
?>
         <tr>
           <td class="cusdec_border-left-right-tax" style="text-align:center"><?php echo $TaxCode;?></td>
           <td class="border-right-fntsize12" style="text-align:right"><?php echo ($TaxBase=="0" ? "":number_format($TaxBase,0));?>&nbsp;</td>
           <td class="border-right-fntsize12" style="text-align:center"><?php echo ($Rate=="0" ? "":$Rate);?></td>
           <td class="border-right-fntsize12" style="text-align:right"><?php echo number_format($Amount,0);?>&nbsp;</td>
           <td class="border-right-fntsize12" style="text-align:center"><?php echo $MP;?></td>         
         </tr>      

<?php
if($MP==1){
$totAmount	+= $Amount;
$totMP	= 1;
}
$loop++;
}
for($loop;$loop<12;$loop++)
{
?>
	    <tr>
           <td class="cusdec_border-left-right-tax">&nbsp;</td>
           <td class="border-right-fntsize10" >&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>         
         </tr>
<?php
}
?>
         <tr>
           <td colspan="3" align="right" class="border-All-fntsize12" style="text-align:center"><b>Total</b></td>
           <td class="border-top-bottom-right-fntsize12" style="text-align:right"><b><?php echo number_format($totAmount,0);?></b>&nbsp;</td>
           <td class="border-top-bottom-right-fntsize12" style="text-align:center"><b><?php echo $totMP;?></b></td>         
         </tr>



       </table></td>
       <td colspan="4"><table width="100%" height="228" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td class="border-right-fntsize10">48. A.C. Number</td>
           <td colspan="3" class="normalfnt_size10">&nbsp;49. Identification of Warehouse &amp; Period</td>
         </tr>
         <tr>
           <td width="52%" height="22" class="border-bottom-right-fntsize10">&nbsp;</td>
           <td colspan="3" class="border-bottom">&nbsp;</td>
           </tr>
         <tr>
           <td class="normalfntSM">&nbsp;Mode of Payment </td>
           <td width="12%" class="normalfnt_size10">:</td>
           <td width="22%" class="normalfnt_size10">&nbsp;</td>
           <td width="14%" class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td class="normalfntSM">&nbsp;Assessment Number </td>
           <td class="normalfnt_size10">:</td>
           <td class="normalfnt_size10">Date :</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td class="normalfntSM">&nbsp;Reciept Numbre </td>
           <td class="normalfnt_size10">:</td>
           <td class="normalfnt_size10">Date :</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td class="normalfntSM">&nbsp;Guarantee </td>
           <td class="normalfnt_size10">:</td>
           <td class="normalfnt_size10">Date :</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td class="normalfntSM">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
		 
         <tr>
           <td class="normalfntSM">&nbsp;Total Fees</td>
           <td class="normalfnt_size10">:</td>
           <td class="normalfnt_size10">Rs.</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td height="19" class="border-bottom">&nbsp;Total Declaration</td>
           <td class="border-bottom">:</td>
           <td class="border-bottom">Rs.</td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
         </tr>

       </table></td>
     </tr>
     <tr>
       <td height="10" class="normalfnt_size10"><img src="../../images/officeuse.png" /></td>
       <td colspan="6"><table width="100%" height="266" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="58%" height="10" class="border-left-right-fntsize10">&nbsp;50.</td>
           <td width="12%" class="normalfnt_size10" >&nbsp;<strong>C.</strong></td>
           <td width="16%" class="normalfnt_size10" >(Total Invoice Amount)</td>
           <td width="2%" class="normalfnt_size10" >&nbsp;</td>
           <td width="3%" class="normalfnt_size10" >&nbsp;</td>
           <td width="9%" class="normalfntMid_size10">Currency</td>
         </tr>
     <!--    <tr>
           <td height="19" class="border-left-right">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>-->
         <tr height="10">
           <td height="10" class="border-left-right-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $dblCBM.'&nbsp;'.$weight;?>&nbsp;&nbsp;CBM</td>
           <td class="normalfnt_size10">&nbsp;FOB / CIF</td>
           <td class="normalfnt" style="text-align:right"><?php echo number_format($totalAmount,2);?></td>
           <td class="normalfntRite_size10">&nbsp;</td>
           <td class="normalfntRite_size10">&nbsp;</td>
           <td class="normalfntMid_size10"><?php echo $currency;?></td>
         </tr>
         <tr height="10">
           <td height="10" class="border-left-right-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $consigneeLocation;?></td>
           <td class="normalfnt_size10">&nbsp;FREIGHT</td>
           <td class="normalfnt" style="text-align:right"><?php echo number_format($freight,2);?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr height="10">
           <td height="10" class="border-left-right">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;INSURANCE</td>
           <td class="normalfnt" style="text-align:right"><?php echo number_format($insurance,2);?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr height="10">
           <td height="10" class="border-Left-bottom-right">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;OTHER</td>
           <td class="normalfnt" style="text-align:right"><?php echo number_format($others,2);?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr height="15">
           <td height="10" class="border-Left-bottom-right">&nbsp;51.</td>
           <td class="border-bottom-fntsize10">&nbsp;TOTAL</td>
           <td class="border-bottom-fntsize12" style="text-align:right"><?php 
		   $totalInvoiceAmount	= ($totalAmount+$freight+$insurance+$others);
		   echo number_format($totalInvoiceAmount,2);
		   ?> </td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr height="25">
           <td class="border-Left-bottom-right">&nbsp;52.</td>
           <td colspan="5" class="dotborder-bottom">&nbsp;53. I &nbsp; &nbsp;
             <?php echo $authorizedBy;?></td>         
         </tr>        
         <tr height="10">
           <td height="10" class="border-left-right">&nbsp;D.</td>
           <td colspan="5" class="dotborder-bottom">&nbsp;</td>
           </tr>
         <tr height="25">
           <td   class="border-left-right">&nbsp;</td>
          
           <td colspan="5" class="normalfnt_size10">&nbsp;Do hereby affirm that the particulars and the values entered by me are true and correct.</td>
           </tr>
         <tr height="10">
           <td  class="border-left-right">&nbsp;</td>
           <td colspan="2" class="dotborder-bottom">&nbsp;</td>
           <td class="normalfnt_size10" ></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr height="10">
           <td height="10" class="border-left-right">&nbsp;</td>
           <td colspan="2" class="border-bottom-fntsize10" style="text-align:center">SIGNATURE &amp; DATE</td>
           <td class="border-bottom" style="text-align:center">&nbsp;</td>
           <td colspan="2" class="border-bottom-fntsize10" style="text-align:center"><?php echo date("d-m-Y");?></td>
           </tr>
         <tr height="10">
           <td height="10" class="border-left-right">&nbsp;</td>
           <?php

$sqlwalfclark="select strName,strIdNo from wharfclerks   where intWharfClerkID='$wharfClerk'";
$result_walfcleark=$db->RunQuery($sqlwalfclark);
while($row_walfcleark=mysql_fetch_array($result_walfcleark))
{
$walfclearkName = $row_walfcleark["strName"];
$walfclearkIdNo = $row_walfcleark["strIdNo"];
}
?>
           <td colspan="2" class="normalfnt" style="text-align:center"></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td colspan="2" class="normalfnt" style="text-align:center">&nbsp;</td>
           </tr>
         <tr height="10">
           <td height="10" class="border-left-right">&nbsp;</td>
           <td colspan="2" class="dotborder-bottom" style="text-align:center"><?php echo $walfclearkName;?></td>
           <td class="normalfntMid_size10">&nbsp;</td>
           <td colspan="2" class="dotborder-bottom" style="text-align:center"><?php echo $walfclearkIdNo;?></td>
           </tr>
         <tr height="10">
           <td height="10" class="border-left-right">&nbsp;</td>
           <td colspan="2" class="normalfnt_size10" style="text-align:center"><span class="normalfnt_size10" style="text-align:center">DECLARATION SUBMITTED BY</span></td>
           <td class="normalfntMid_size10">&nbsp;</td>
           <td colspan="2" class="normalfntMid_size10">ID NUMBER</td>
         </tr>
       </table></td>
       </tr>
    </table></td>
  </tr>
  
</table>
<script type="text/javascript">
var to		= <?php echo ($totalInvoiceAmount * $exRate)?>;
document.getElementById('totalReportValue').innerHTML =  to.toFixed(0);
var deliveryNo 		= <?php echo $deliveryNo?>;
var pub_EicAmount	= <?php echo $pub_EicAmount;?>;
var pub_xidAmount	= <?php echo $pub_xidAmount;?>;
var detailrowCount  = <?php
$sql="select intDeliveryNo from deliverydetails where intDeliveryNo=$deliveryNo";
$result=$db->RunQuery($sql);
$rowCount	= mysql_num_rows($result);
echo  $rowCount;
?>;
document.getElementById('noOfItem').innerHTML = detailrowCount;
document.getElementById('totNoOfPages').innerHTML = (Math.ceil((detailrowCount-1)/3)+1);
if(detailrowCount>1)
{
	test();
}
function test()
{
	newwindow=window.open('cusdecReportothers.php?deliveryNo=' +deliveryNo+ '&pub_EicAmount=' +pub_EicAmount+ '&pub_xidAmount=' +pub_xidAmount ,'cusdecother');
	if (window.focus) {newwindow.focus()}
}
</script>
</body>
</html>
