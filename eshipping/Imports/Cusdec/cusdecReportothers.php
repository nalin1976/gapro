<?php
	session_start();
	include("../../Connector.php");
	$deliveryNo	= $_GET["deliveryNo"];
	$companyID	= $_SESSION["FactoryID"];
	$xml = simplexml_load_file('../../config.xml');
	$pub_EicAmount = $_GET["pub_EicAmount"];
	$pub_xidAmount = $_GET["pub_xidAmount"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Import Cusdec :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	font-size: 11px;
	border-right-style: solid;
	border-right-color: #000000;
	font-family: Verdana;
	color: #000000;
	margin: 0px;
	text-align: left;
	border-right-width: thin;
	font-weight: bold;
}
.style3 {font-size: 11px; color: #000000; margin: 0px; text-align:left; font-family: Verdana;}
.style4 {font-size: 11px; color: #000000; margin: 0px; text-align: left; font-family: Verdana; font-weight: bold; }
-->
</style>
</head>

<body>
<?php

$sql_page="select strItemCode from deliverydetails DD where intDeliveryNo=$deliveryNo Order By intItemNo;";
$result_page=$db->RunQuery($sql_page);
$row_page = mysql_num_rows($result_page);

$noOfPage	= ($row_page - 1)/3;
$totNoOfPage	= (ceil(($row_page - 1)/3)+1);
$count	= $noOfPage;
for($i=0;$i<$noOfPage;$i++)
{

?>
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
	$totalAmount				= $row["dblTotalAmount"];
	$deliveryTerms				= $row["strDeliveryTerms"];
	$insurance					= $row["dblInsurance"];
	$freight					= $row["dblFreight"];
	$others						= $row["dblOther"];
	$PreviousDoc				= $row["strPrevDoc"];
	$TQBNo						= $row["strTQBNo"];
	$consigneeRefCode 			= $row["strConsigneeRefCode"];
	$countryOfOriginCode		= $row["strCtryOfOrigin"];
	$marks				   		= $row["strMarks"];
	$containerNo				= $row["strContainerNo"];
	$bankCode					= $row["strBankCode"];
	$RecordType					= $row["RecordType"];
	$packageName				= $row["packageName"];
	$CountOfContainer			= $row["strCountOfContainer"].'x'.$row["intFeet"];
	$licenceNo					= $row["strLicenceNo"];
	$fcl						= $row["strFCL"];
}
?>
<table width="924" align="center">
  <tr>
    <td width="878"><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="32%" class="normalfnt2bldBLACK">CUSDEC - II</td>
        <td width="55%" class="normalfnt2bldBLACK"><i>SRI LANKA CUSTOMS - GOODS DECLARATION</i></td>
        <td width="13%" class="normalfnt2bldBLACK">CUSTOMS - 53 </td>
      </tr>
    </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline">
      <tr>
        <td width="4%" class="border-bottom"><img src="../../images/headerinformation2.png" width="35" height="89" /></td>
        <td width="43%"><table width="100%" height="91" border="0" cellpadding="0" cellspacing="0">
       <?php 
$sqlconsignee="select * from customers where strCustomerID=$customerID";
$result_consignee=$db->RunQuery($sqlconsignee);
while($row_consignee=mysql_fetch_array($result_consignee))
{
	$consigneeName		= $row_consignee["strName"];
	$consigneeAddress1	= $row_consignee["strAddress1"];
	$consigneeAddress2	= $row_consignee["strAddress2"];
	$consigneeCountry	= $row_consignee["strCountry"];
	$consigneeTIN		= $row_consignee["strTIN"];
	$consigneePPCCode	= $row_consignee["strPPCCode"];
}
?>
          <tr>
            <td width="61%" height="18" class="border-left-fntsize10">&nbsp;2.Consignee</td>
            <td width="39%" class="border-right-fntsize9">&nbsp;<span class="normalfnt">TIN:<?php echo $consigneeTIN;?></span></td>
          </tr>
          <tr>
            <td height="19" colspan="2" class="border-left-right-fntsize12">&nbsp;<?php echo $consigneeName;?></td>            
          </tr>
          <tr>
            <td colspan="2" class="border-left-right">&nbsp;<?php echo $consigneeAddress1;?></td>
          </tr>
          <tr>
            <td height="19" colspan="2" class="border-left-right">&nbsp;<?php echo $consigneeAddress2;?></td>
          </tr>
          <tr>
            <td height="19" class="border-left">&nbsp;<?php echo $consigneeCountry;?></td>
            <td class="border-right">&nbsp;</td>
          </tr>
        </table></td>
        <td width="53%" colspan="4"><table width="100%" height="91" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="15" colspan="3" class="border-right-fntsize10">&nbsp;1. DECLARATION</td>
            <td colspan="2" class="normalfnt_size10">&nbsp;A. OFFICE USE</td>
          </tr>
          <tr>
            <td width="8%" height="21" class="border-bottom-right"><div align="center">I</div></td>
            <td width="11%" class="border-bottom-right"><div align="center">M</div></td>
            <td width="18%" align="center" class="border-bottom-right"><div align="center">
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
            <td height="19" colspan="2" class="border-right-fntsize10">&nbsp;3. Pages</td>
            <td class="border-right-fntsize10">&nbsp;4. List</td>
            <td colspan="2" class="normalfnt_size10">&nbsp;Customs Reference</td>
          </tr>
          <tr>
            <td height="26" class="border-right" style="text-align:center"><?php echo $i+2;?></td>
            <td class="border-right" style="text-align:center"><?php echo $totNoOfPage;?></td>
            <td class="border-right">&nbsp;</td>
            <td width="42%" class="normalfnt_size10">&nbsp;Number :</td>
            <td width="21%" class="normalfnt_size10">Date :</td>
          </tr>
        </table></td>
      </tr>
           
     <tr>
       <td width="4%" class="border-bottom"><img src="../../images/pkgsanddescriptionofgoods.png" width="35" height="151" /></td>       
       <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
<?php 
clearVariables();
$itemCode_1	= "";					
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
	limit ".  (1+($i * 3)) . ",1;";
	
$result_details=$db->RunQuery($sqldetails);
while($row_details=mysql_fetch_array($result_details))
{	
	$itemCode_1				= $row_details["strItemCode"];
	$itemDescription		= $row_details["itemDescription"];
	$itemNo					= $row_details["intItemNo"];
	$commodityCode			= $row_details["strCommodityCode"];
	$itemPrice				= $row_details["dblItemPrice"];
	$qty					= $row_details["dblQty"];
	$noOfPackages			= $row_details["intNoOfPackages"].'&nbsp;'.$packageName;
	$grossMass				= $row_details["dblGrossMass"];
	$netMass				= $row_details["dblNetMass"];
	$procCode1				= $row_details["strProcCode1"];
	$procCode2				= $row_details["strProcCode2"];
	$itmValue				= $row_details["dblItmValue"];
	$unit					= $row_details["strUnit"];
	$umoQty1				= $row_details["strUmoQty1"];
	$umoQty2				= $row_details["strUmoQty2"];
	$umoQty3				= $row_details["strUmoQty3"];
	
	$PreviousDoc_1			= $PreviousDoc;
	$marks_1					= $marks;
	$containerNo_1			= $CountOfContainer;
	$countryOfOriginCode_1	= $countryOfOriginCode;
	$consigneePPCCode_1 		= $consigneePPCCode;
	$TQBNo_1				= $TQBNo;			
			 $chars 		= preg_split('//', $consigneePPCCode_1, -1, PREG_SPLIT_NO_EMPTY);
if($RecordType=="IM")
	$AdNo		=  $xml->importCusdec->ADNO_Boi;
elseif($RecordType="IMGEN")
	$AdNo 	= $xml->importCusdec->ADNO_Genaral;
}
?>
           <td width="92" height="26" class="border-top-left-fntsize10">&nbsp;<strong>31.Marks &amp; Numbers</strong></td>
           <td width="10" align="center" class="border-top-fntsize10">-</td>
           <td width="151" class="border-top-fntsize10" style="text-align:center"><strong>Container No(s)</strong></td>
           <td width="17" class="border-top-fntsize10">-</td>
           <td width="121" class="border-top"><strong>Number and Kind</strong></td>
           <td width="84" class="border-Left-Top-right-fntsize10">&nbsp;32.Item No</td>
           <td colspan="4" class="border-top-fntsize10">&nbsp;33. Commodity (HS) Code</td>
           </tr>
         <tr>
           <td rowspan="8" align="left" valign="top" class="border-left-fntsize12"><?php echo $marks_1;?></td>
           <td height="20" class="normalfnt_size10">&nbsp;</td>
           <td rowspan="2" align="center" valign="top" class="normalfnt_size12" style="text-align:center"><?php    
		   if ($fcl==1)
		   		echo $containerNo_1;
			?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td rowspan="2" align="center" valign="top" class="normalfnt_size12" style="text-align:center"><?php echo $noOfPackages;?></td>
           <td align="center" class="border-Left-bottom-right-fntsize12" ><div align="center"><span class="normalfnt_size12" ><?php echo $itemNo;?></span></div></td>
           <td colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $commodityCode;?></b></td>
           </tr>
         <tr>
           <td height="19" class="normalfnt_size10"></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize9">&nbsp;34. Ctry.of. Origin Code</td>
           <td width="147" class="border-right-fntsize9">&nbsp;35. Gross Mass (Kg)</td>
           <td width="112" class="normalfnt_size9">&nbsp;36. Preference</td>
         </tr>
         <tr>
           <td height="10" class="normalfnt_size10">&nbsp;</td>
           <td align="center" valign="top" class="normalfnt_size12" style="text-align:center"><span class="normalfnt_size10">Goods Description</span></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td align="center" >&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td width="38" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;<?php echo $countryOfOriginCode_1;?></td>
           <td width="104" class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-right-fntsize12"><div align="center">&nbsp;<?php echo ($grossMass=="" ? "":number_format($grossMass,2));?></div></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr>
           <td height="19" class="normalfnt_size10">&nbsp;</td>
           <td colspan="3" rowspan="6" align="left" valign="top" class="border-bottom"><strong><?php echo $itemDescription?></strong>             </td>
           <td rowspan="4" align="left" valign="top" class="border-right"><?php echo ($qty=="" ? "":round($qty,2).'-'.$unit)?></td>
           <td colspan="2" class="border-right-fntsize9">&nbsp;37. Procedure Code</strong></td>
           <td width="147" class="border-right-fntsize9">&nbsp;38. Net Mass (Kg)</td>
           <td width="112" class="normalfnt_size9">&nbsp;39. Quota</td>
         </tr>
         <tr>
           <td height="25" class="normalfnt_size10">&nbsp;</td>
           <td width="38" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo $procCode1;?></b></td>
           <td width="104" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo $procCode2;?></b></td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($netMass=="" ? "":number_format($netMass,2));?></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr>
           <td height="22" class="normalfnt_size10">&nbsp;</td>
           <td colspan="4" class="normalfnt_size10">&nbsp;40. Previous Document / BL / AWB No.</td>
           </tr>
         <tr>
           <td>&nbsp;</td>
           <td colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $PreviousDoc_1;?></b></td>
           </tr>
         <tr>
           <td>&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize9">&nbsp;41A. UMO &amp; Qty 1</td>
           <td class="border-right-fntsize9">&nbsp;42. Item Price (FOB/CIF)</td>
           <td class="normalfnt_size10">&nbsp;43.</td>
         </tr>
         <tr>
           <td class="border-bottom-left">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom-right">&nbsp;</td>
           <td colspan="2" class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty1=="" ? "":$umoQty1);?></td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><b>
		   <?php 
		   if($RecordType=='IM')
		   		echo number_format($itemPrice,2);
		   elseif($RecordType=='IMGEN')
		   		echo ($itmValue=="" ? "":number_format(($itmValue/$exRate),2));
		   ?>
		   </b></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
       </table></td>
       </tr>
     <tr>
       <td width="4%" class="border-bottom"><img src="../../images/additionaldocs.png" width="35" height="69" /></td>
       
       <td colspan="5" height="10"><table width="100%" border="0" height="20" cellspacing="0" cellpadding="0">
         <tr height="27">
           <td class="border-left-fntsize9">&nbsp;44.Licence No.</td>           
           <td colspan="14" class="normalfnt_size10"><?php echo $licenceNo;?></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-right-fntsize10">&nbsp;</td>
           <td width="15%" class="border-right-fntsize9">&nbsp;41B. UMO &amp; Qty 2</td>
           <td width="17%" class="border-right">&nbsp;</td>
           <td width="13%" class="normalfnt_size9">&nbsp;45. Adjustments</td>
         </tr>
         <tr>
           <td width="10%" class="border-left-fntsize9">&nbsp;A.D. :</td>		   
           <td colspan="14" class="normalfnt_size12"><?php echo $AdNo;?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty2=="" ? "":$umoQty2);?></td>
           <td class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-fntsize10">&nbsp;</td>
         </tr>
         <tr>
           <td class="border-left-fntsize9">&nbsp;TQB :</td>
           <td width="10%" class="normalfnt"><strong><?php echo $TQBNo_1;?></strong></td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[0];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[1];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[2];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[3];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[4];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[5];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[6];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[7];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[8];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[9];?></strong></td>
           <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[10];?></strong></td>
		   <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize9">&nbsp;41C. UMO &amp; Qty 3</td>
           <td colspan="2" class="normalfnt_size9" style="text-align:center">46. Value (NCY)</td>
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
           <td colspan="2" class="border-bottom-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty3=="" ? "":$umoQty3);?></td>
           <td colspan="2" class="border-bottom-fntsize12" style="text-align:center"><b><?php echo ($itmValue=="" ? "":number_format($itmValue,0))?></b></td>
         </tr>
       </table></td>
       </tr>
     <tr>
       <td width="4%" class="border-bottom"><img src="../../images/pkgsanddescriptionofgoods.png" width="35" height="151" /></td>
       
       <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <?php
clearVariables();
$itemCode_2	= "";
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
	limit ".  (2+($i * 3)) . ",1;";
	
$result_details=$db->RunQuery($sqldetails);

while($row_details=mysql_fetch_array($result_details))
{
	$itemCode_2				= $row_details["strItemCode"];
	$itemDescription		= $row_details["itemDescription"];
	$itemNo				= $row_details["intItemNo"];
	$commodityCode		= $row_details["strCommodityCode"];
	$qty					= $row_details["dblQty"];
	$noOfPackages			= $row_details["intNoOfPackages"].'&nbsp;'.$packageName;
	$itemPrice			= $row_details["dblItemPrice"];
	$grossMass			= $row_details["dblGrossMass"];
	$netMass				= $row_details["dblNetMass"];
	$procCode1			= $row_details["strProcCode1"];
	$procCode2			= $row_details["strProcCode2"];
	$itmValue				= $row_details["dblItmValue"];
	$unit					= $row_details["strUnit"];
	$umoQty1				= $row_details["strUmoQty1"];
	$umoQty2				= $row_details["strUmoQty2"];
	$umoQty3				= $row_details["strUmoQty3"];
	
	$PreviousDoc_1			= $PreviousDoc;
	$marks_1				= $marks;	
	$containerNo_1			= $CountOfContainer;
	$countryOfOriginCode_1	= $countryOfOriginCode;
	$TQBNo_1				= $TQBNo;
	$consigneePPCCode_1 	= $consigneePPCCode;
			$chars 		= preg_split('//', $consigneePPCCode_1, -1, PREG_SPLIT_NO_EMPTY);
			
	if($RecordType=="IM")
		$AdNo				=  $xml->importCusdec->ADNO_Boi;
	elseif($RecordType="IMGEN")
		$AdNo 			= $xml->importCusdec->ADNO_Genaral;
	
}
?>
           <td width="87" height="24" class="border-left-fntsize10">&nbsp;<strong>31.Marks &amp; Numbers</strong></td>
           <td width="17" align="center" class="normalfnt_size10">-</td>
           <td width="148" class="normalfnt_size10" style="text-align:center"><strong>Container No(s)</strong></td>
           <td width="17" class="normalfnt_size10">-</td>
           <td width="122" class="normalfnt_size10"><strong>Number and Kind</strong></td>
           <td width="78" class="border-left-right-fntsize10">&nbsp;32.Item No</td>
           <td colspan="4" class="normalfnt_size9">&nbsp;33. Commodity (HS) Code</td>
         </tr>
         <tr>
           <td height="24" class="border-left">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td rowspan="2" align="center" valign="top" class="normalfnt_size12" style="text-align:center"><?php 
		   if ($fcl==1)
		   		echo $containerNo_1;
		   
		   	?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td rowspan="2" align="center" valign="top" class="normalfnt_size12" style="text-align:center"><?php echo $noOfPackages;?></td>
           <td style="text-align:center" class="border-Left-bottom-right-fntsize12" ><?php echo $itemNo;?></div></td>
           <td colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $commodityCode;?></b></td>
         </tr>
         <tr>
           <td rowspan="7" align="left" valign="top" class="border-left-fntsize12"><?php echo $marks_1;?></td>
           <td height="19" class="normalfnt_size10"></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize9">&nbsp;34. Ctry.of. Origin Code</td>
           <td width="147" class="border-right-fntsize9">&nbsp;35. Gross Mass (Kg)</td>
           <td width="110" class="normalfnt_size10">&nbsp;36. Preference</td>
         </tr>
         <tr>
           <td height="10" class="normalfnt_size10">&nbsp;</td>
           <td align="center" valign="top" class="normalfnt_size12" style="text-align:center"><span class="normalfnt_size10">Goods Description</span></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td align="center" >&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td width="43" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;<?php echo $countryOfOriginCode_1;?></td>
           <td width="107" class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-right-fntsize12"><div align="center">&nbsp;<?php echo ($grossMass=="" ? "":number_format($grossMass,2));?></div></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr>
           <td height="19" class="normalfnt_size10">&nbsp;</td>
           <td colspan="3" rowspan="6" align="left" valign="top" class="border-bottom"><strong><?php echo $itemDescription?></strong></td>
           <td rowspan="4" align="left" valign="top" class="border-right"><?php echo ($qty=="" ? "":round($qty,2).'-'.$unit)?></td>
           <td colspan="2" class="border-right-fntsize9">&nbsp;37. Procedure Code</td>
           <td width="147" class="border-right-fntsize9">&nbsp;38. Net Mass (Kg)</td>
           <td width="110" class="normalfnt_size9">&nbsp;39. Quota</td>
         </tr>
         <tr>
           <td height="25" class="normalfnt_size10">&nbsp;</td>
           <td width="43" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo $procCode1;?></b></td>
           <td width="107" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo $procCode2;?></b></td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($netMass=="" ? "":number_format($netMass,2));?></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr>
           <td height="22" class="normalfnt_size10">&nbsp;</td>
           <td colspan="4" class="normalfnt_size9">&nbsp;40. Previous Document / BL / AWB No.</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $PreviousDoc_1;?></b></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize9">&nbsp;41A. UMO &amp; Qty 1</td>
           <td class="border-right-fntsize9">&nbsp;42. Item Price (FOB/CIF)</td>
           <td class="normalfnt_size10">&nbsp;43.</td>
         </tr>
         <tr>
           <td class="border-bottom-left">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom-right">&nbsp;</td>
           <td colspan="2" class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty1=="" ? "":$umoQty1);?></td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><b>
		   <?php
		   if($RecordType=='IM')
		   		echo number_format($itemPrice,2);
		   elseif($RecordType=='IMGEN')
		   		 echo ($itmValue=="" ? "":number_format(($itmValue/$exRate),2));
			?>
			</b></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td width="4%" class="border-bottom"><img src="../../images/additionaldocs.png" width="35" height="69" /></td>
       <td colspan="7" height="10"  class="normalfnt_size10"><table width="100%" height="20"  border="0" cellspacing="0" cellpadding="0">
         <tr height="27">
            <td class="border-left-fntsize10">&nbsp;44.Licence No.</td>  
            <td colspan="14" class="normalfnt"><?php echo $licenceNo;?></td>
            <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-right-fntsize10">&nbsp;</td>
           <td width="16%" class="border-right-fntsize9">&nbsp;41B. UMO &amp; Qty 2</td>
           <td width="17%" class="border-right">&nbsp;</td>
           <td width="12%" class="normalfnt_size10">&nbsp;45. Adjustments</td>
         </tr>
         <tr>
           <td width="10%" class="border-left-fntsize9">&nbsp;A.D. :</td>
           <td colspan="14" class="normalfnt"><?php echo $AdNo;?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty2=="" ? "":$umoQty2);?></td>
           <td class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-fntsize10">&nbsp;</td>
         </tr>
         <tr>
           <td class="border-left-fntsize9">&nbsp;TQB :</td>
           <td width="10%" class="normalfnt"><strong><?php echo $TQBNo_1;?></strong></td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[0];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[1];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[2];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[3];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[4];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[5];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[6];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[7];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[8];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[9];?></strong></td>
           <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[10];?></strong></td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize9">&nbsp;41C. UMO &amp; Qty 3</td>
           <td colspan="2" class="normalfnt_size9" style="text-align:center">46. Value (NCY)</td>
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
           <td colspan="2" class="border-bottom-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty3=="" ? "":$umoQty3);?></td>
           <td colspan="2" class="border-bottom-fntsize12" style="text-align:center"><b><?php echo ($itmValue=="" ? "":number_format($itmValue,0))?></b></td>
         </tr>
       </table></td>
       </tr>
     <tr>
       <td width="4%" class="border-bottom"><img src="../../images/pkgsanddescriptionofgoods.png" width="35" height="151" /></td>       
       <td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <?php 
clearVariables();
$itemCode_3	= "";
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
	limit ".  (3+($i * 3)) . ",1;";

$result_details=$db->RunQuery($sqldetails);
while($row_details=mysql_fetch_array($result_details))
{
	$itemCode_3				= $row_details["strItemCode"];
	$itemDescription		= $row_details["itemDescription"];
	$itemNo					= $row_details["intItemNo"];
	$commodityCode			= $row_details["strCommodityCode"];
	$qty					= $row_details["dblQty"];
	$noOfPackages			= $row_details["intNoOfPackages"].'&nbsp;'.$packageName;
	$itemPrice				= $row_details["dblItemPrice"];
	$grossMass				= $row_details["dblGrossMass"];
	$netMass				= $row_details["dblNetMass"];
	$procCode1				= $row_details["strProcCode1"];
	$procCode2				= $row_details["strProcCode2"];
	$itmValue				= $row_details["dblItmValue"];
	$unit					= $row_details["strUnit"];
	$umoQty1				= $row_details["strUmoQty1"];
	$umoQty2				= $row_details["strUmoQty2"];
	$umoQty3				= $row_details["strUmoQty3"];
	
	$PreviousDoc_1			= $PreviousDoc;
	$marks_1					= $marks;
	$containerNo_1			= $CountOfContainer;
	$countryOfOriginCode_1	= $countryOfOriginCode;
	$TQBNo_1				= $TQBNo;
	$consigneePPCCode_1 		= $consigneePPCCode;
			$chars 			= preg_split('//', $consigneePPCCode_1, -1, PREG_SPLIT_NO_EMPTY);
			
	if($RecordType=="IM")
		$AdNo				=  $xml->importCusdec->ADNO_Boi;
	elseif($RecordType="IMGEN")
		$AdNo 			= $xml->importCusdec->ADNO_Genaral;
	
}
?>
           <td width="10%" height="24" class="border-left-fntsize10">&nbsp;<strong>31.Marks &amp; Numbers</strong></td>
           <td width="2%" align="center" class="normalfnt_size10">-</td>
           <td width="17%" class="normalfnt_size10" style="text-align:center"><strong>Container No(s)</strong></td>
           <td width="2%" class="normalfnt_size10">-</td>
           <td width="14%" class="normalfnt_size10"><strong>Number and Kind</strong></td>
           <td width="9%" class="border-left-right-fntsize10">&nbsp;32.Item No</td>
           <td colspan="4" class="normalfnt_size9">&nbsp;33. Commodity (HS) Code</td>
         </tr>
         <tr>
           <td height="20" class="border-left">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td rowspan="3" align="center" valign="top" class="normalfnt_size10" style="text-align:center"><?php 
		   if ($fcl==1)
		   		echo $containerNo_1;
		   
		   	?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10" style="text-align:center"><?php echo $noOfPackages;?></td>
           <td style="text-align:center" class="border-Left-bottom-right-fntsize12" ><?php echo $itemNo;?></span></td>
           <td colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $commodityCode;?></b></td>
         </tr>
         <tr>
           <td rowspan="7" align="left" valign="top" class="border-left-fntsize12"><?php echo $marks_1;?></td>
           <td height="23" class="normalfnt_size10"></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize9">&nbsp;34. Ctry.of. Origin Code</td>
           <td width="18%" class="border-right-fntsize9">&nbsp;35. Gross Mass (Kg)</td>
           <td width="13%" class="normalfnt_size9">&nbsp;36. Preference</td>
         </tr>
         <tr>
           <td height="10" class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td align="center" >&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td width="5%" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;<?php echo $countryOfOriginCode_1;?></td>
           <td width="10%" class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-right-fntsize12"><div align="center">&nbsp;<?php echo ($grossMass=="" ? "":number_format($grossMass,2));?></div></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr>
           <td height="19" class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">Goods Description</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize10">&nbsp;37. Procedure Code</td>
           <td width="18%" class="border-right-fntsize9">&nbsp;38. Net Mass (Kg)</td>
           <td width="13%" class="normalfnt_size10">&nbsp;39. Quota</td>
         </tr>
         <tr>
           <td height="21" class="normalfnt_size10">&nbsp;</td>
           <td colspan="3" rowspan="5" align="left" valign="top" class="border-bottom"><strong><?php echo $itemDescription;?></strong></td>
           <td class="border-right"><?php echo ($qty=="" ? "":round($qty,2).'-'.$unit)?></td>
           <td width="5%" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo $procCode1;?></b></td>
           <td width="10%" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo $procCode2;?></b></td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($netMass=="" ? "":number_format($netMass,2));?></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr>
           <td height="22" class="normalfnt_size10">&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="4" class="normalfnt_size9">&nbsp;40. Previous Document / BL / AWB No.</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $PreviousDoc_1;?></b></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize9">&nbsp;41A. UMO &amp; Qty 1</td>
           <td class="border-right-fntsize9">&nbsp;42. Item Price (FOB/CIF)</td>
           <td class="normalfnt_size10">&nbsp;43.</td>
         </tr>
         <tr>
           <td class="border-bottom-left">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom-right">&nbsp;</td>
           <td colspan="2" class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty1=="" ? "":$umoQty1);?></td>
           <td height="30" class="border-bottom-right-fntsize12" style="text-align:center"><b>
		   <?php 
		   if($RecordType=='IM')
		   		echo number_format($itemPrice,2);
		   elseif($RecordType=='IMGEN')
		   		echo ($itmValue=="" ? "":number_format(($itmValue/$exRate),2));
			?>
			</b></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td width="4%" class="border-bottom"><img src="../../images/additionaldocs.png" width="35" height="69" /></td>      
       <td colspan="7" height="10"><table width="100%" border="0" height="20" cellspacing="0" cellpadding="0">
         <tr height="27">
            <td class="border-left-fntsize10">&nbsp;44.Licence No.</td>  
            <td colspan="14" class="normalfnt"><?php echo $licenceNo;?></td>
            <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-right-fntsize10">&nbsp;</td>
           <td width="16%" class="border-right-fntsize9">&nbsp;41B. UMO &amp; Qty 2</td>
           <td width="17%" class="border-right">&nbsp;</td>
           <td width="12%" class="normalfnt_size10">&nbsp;45. Adjustments</td>
         </tr>
         <tr>
           <td width="10%" class="border-left-fntsize10">&nbsp;A.D. :</td>
           <td colspan="14" class="normalfnt_size10"><?php echo $AdNo;?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty2=="" ? "":$umoQty2);?></td>
           <td class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-fntsize10">&nbsp;</td>
         </tr>
         <tr>
           <td class="border-left-fntsize10">&nbsp;TQB :</td>
           <td width="10%" class="normalfnt"><strong><?php echo $TQBNo_1;?></strong></td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[0];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[1];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[2];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[3];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[4];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[5];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[6];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[7];?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[8];?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="3%" class="border-All" style="text-align:center"><strong><?php echo $chars[9];?></strong></td>
           <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[10];?></strong></td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize9">&nbsp;41C. UMO &amp; Qty 3</td>
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
           <td colspan="2" class="border-bottom-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty3=="" ? "":$umoQty3);?></td>
           <td height="25" colspan="2" class="border-bottom-fntsize12" style="text-align:center"><b><?php echo ($itmValue=="" ? "":number_format($itmValue,0))?></b></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td width="4%" rowspan="2" class="normalfnt"><img src="../../images/culculationoftaxes.png" /></td>
       <td ><table width="100%" height="171" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="16%" height="15" class="border-Left-bottom-right-fntsize10" style="text-align:center">(1) Type</td>
           <td width="23%" class="border-bottom-right-fntsize10" style="text-align:center">(2) Tax Base</td>
           <td width="14%" class="border-bottom-right-fntsize10" style="text-align:center">(3) Rate</td>
           <td width="24%" class="border-bottom-right-fntsize10" style="text-align:center">(4) Amount</td>
           <td width="15%" class="border-bottom-right-fntsize10" style="text-align:center">(5) MP</td>
         </tr>
         <?php
$loop			= 0;
$totAmount_1	= 0;
$totMP_1		= 0;

$sqltax="select * from cusdectax where intDeliveryNo=$deliveryNo AND intItemCode='$itemCode_1' order By intPosition
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
		$sqlcom="select * from commoditycodes where strCommodityCode='$commodityCode_1' and strTaxCode='EIC'";
		$result_com=$db->RunQuery($sqlcom);
		while($row_com=mysql_fetch_array($result_com))
		{
			$optionalRate	= $row_com["dblOptRates"];
			$totEic  		= $netMass_1 * $optionalRate;
		}	
		if($Amount<$totEic)
		{
			$TaxBase		= $netMass_1;
			$Rate			= $optionalRate;
			$Amount			= $totEic;
		}	
		$pub_EicAmount += $Amount;
	}
	if($TaxCode=="COM/EX/SEAL")
	{
		$TaxBase	= "";
		$Amount		= $Amount;
		$Rate		= "";
		$TaxBase	= "";
	}
	elseif($TaxCode=="XID")
	{
		$TaxBase	= "";
		$Amount		= round($netMass_1,0);
		$Rate		= "";
		$TaxBase	= "";
		$pub_xidAmount	+=$Amount;
	}*/

if($loop=="10"){return;}
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
		$totAmount_1	+= $Amount;
		$totMP_1	= 1;
	}

$loop++;
}
for($loop;$loop<10;$loop++)
{
?>
         <tr>
           <td class="cusdec_border-left-right-tax">&nbsp;</td>
           <td class="border-right-fntsize12" >&nbsp;</td>
           <td class="border-right-fntsize12">&nbsp;</td>
           <td class="border-right-fntsize12">&nbsp;</td>
           <td class="border-right-fntsize12">&nbsp;</td>
         </tr>
         <?php
}
?>
         <tr>
           <td colspan="3" align="right" class="border-All-fntsize12" style="text-align:center">Total&nbsp;<?php echo (1+($i * 1))?>&nbsp;Item</td>
           <td class="border-top-bottom-right-fntsize12" style="text-align:right"><?php echo ($totAmount_1=="" ? "":number_format($totAmount_1,2));?>&nbsp;</td>
           <td class="border-top-bottom-right-fntsize12" style="text-align:center"><?php echo $totMP_1;?></td>
         </tr>
       </table></td>
       <td colspan="6"><table width="100%" height="171" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="24%" height="15" class="border-bottom-right-fntsize10" style="text-align:center">(1) Type</td>
           <td width="22%" class="border-bottom-right-fntsize10" style="text-align:center">(2) Tax Base</td>
           <td width="18%" class="border-bottom-right-fntsize10" style="text-align:center">(3) Rate</td>
           <td width="22%" class="border-bottom-right-fntsize10" style="text-align:center">(4) Amount</td>
           <td width="14%" class="border-bottom-fntsize10" style="text-align:center">(5) MP</td>
         </tr>
         <?php
$loop			= 0;
$totAmount_2	= 0;
$totMP_2		= 0;

$sqltax="select * from cusdectax where intDeliveryNo=$deliveryNo AND intItemCode='$itemCode_2' order By intPosition
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
		$sqlcom="select * from commoditycodes where strCommodityCode='$commodityCode_2' and strTaxCode='EIC'";
		$result_com=$db->RunQuery($sqlcom);
		while($row_com=mysql_fetch_array($result_com))
		{
			$optionalRate	= $row_com["dblOptRates"];
			$totEic  		= $netMass_2 * $optionalRate;
		}	
		if($Amount<$totEic)
		{
			$TaxBase		= $netMass_2;
			$Rate			= $optionalRate;
			$Amount			= $totEic;
		}	
		$pub_EicAmount += $Amount;	
	}
	elseif($TaxCode=="COM/EX/SEAL")
	{
		$TaxBase	= "";
		$Amount		= $Amount;
		$Rate		= "";
		$TaxBase	= "";
	}
	elseif($TaxCode=="XID")
	{
		$TaxBase	= "";
		$Amount		= round($netMass_2,0);
		$Rate		= "";
		$TaxBase	= "";
		$pub_xidAmount	+=$Amount;
	}*/

if($loop=="10"){return;}
?>
         <tr>
           <td class="cusdec-border-right-tax" style="text-align:center"><?php echo $TaxCode;?></td>
           <td class="border-right-fntsize12" style="text-align:right"><?php echo ($TaxBase=="0" ? "":number_format($TaxBase,0));?>&nbsp;</td>
           <td class="border-right-fntsize12" style="text-align:center"><?php echo ($Rate=="0" ? "":$Rate);?></td>
           <td class="border-right-fntsize12" style="text-align:right"><?php echo number_format($Amount,0);?>&nbsp;</td>
           <td class="normalfnt_size12" style="text-align:center"><?php echo $MP;?></td>
         </tr>
         <?php
	if($MP==1){
		$totAmount_2	+= $Amount;
		$totMP_2	= 1;
	}
$loop++;
}
for($loop;$loop<10;$loop++)
{
?>
         <tr>
           <td class="cusdec-border-right-tax">&nbsp;</td>
           <td class="border-right-fntsize10" >&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <?php
}
?>
         <tr>
           <td colspan="3" align="right" class="border-top-bottom-right-fntsize12" style="text-align:center">Total&nbsp;<?php echo (2+($i * 2))?>&nbsp;Item</td>
           <td class="border-top-bottom-right-fntsize12" style="text-align:right"><?php echo ($totAmount_2=="" ? "":number_format($totAmount_2,2));?>&nbsp;</td>
           <td class="border-top-bottom-fntsize12" style="text-align:center"><?php echo $totMP_2;?></td>
           <!--<td class="border-bottom">&nbsp;</td>-->
         </tr>
       </table></td>
     </tr>
     <tr>
       <td height="12" class="normalfnt_size10"><table width="100%" height="171" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="16%" height="19" class="border-Left-bottom-right-fntsize10" style="text-align:center">(1) Type</td>
           <td width="23%" class="border-bottom-right-fntsize10" style="text-align:center">(2) Tax Base</td>
           <td width="14%" class="border-bottom-right-fntsize10" style="text-align:center">(3) Rate</td>
           <td width="24%" class="border-bottom-right-fntsize10" style="text-align:center">(4) Amount</td>
           <td width="15%" class="border-bottom-right-fntsize10" style="text-align:center">(5) MP</td>
         </tr>
         <?php
$loop			= 0;
$totAmount_3	= 0;
$totMP_3		= 0;
$sqltax="select * from cusdectax where intDeliveryNo=$deliveryNo AND intItemCode='$itemCode_3' order By intPosition
limit 0,10";
//echo $sqltax;
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
		$sqlcom="select * from commoditycodes where strCommodityCode='$commodityCode_3' and strTaxCode='EIC'";
		$result_com=$db->RunQuery($sqlcom);
		while($row_com=mysql_fetch_array($result_com))
		{
			$optionalRate	= $row_com["dblOptRates"];
			$totEic  		= $netMass_3 * $optionalRate;
		}	
		if($Amount<$totEic)
		{
			$TaxBase		= $netMass_3;
			$Rate			= $optionalRate;
			$Amount			= $totEic;
		}	
		$pub_EicAmount += $Amount;	
	}
	elseif($TaxCode=="COM/EX/SEAL")
	{
		$TaxBase	= "";
		$Amount		= $Amount;
		$Rate		= "";
		$TaxBase	= "";
	}
	elseif($TaxCode=="XID")
	{
		$TaxBase	= "";
		$Amount		= round($netMass_3,0);
		$Rate		= "";
		$TaxBase	= "";
		$pub_xidAmount	+=$Amount;
	}*/

if($loop=="10"){return;}
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
		$totAmount_3	+= $Amount;
		$totMP_3	= 1;
	}
	$loop++;
}
for($loop;$loop<10;$loop++)
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
           <td colspan="3" align="right" class="border-Left-Top-right-fntsize12" style="text-align:center">Total&nbsp;<?php echo (3+($i * 3))?>&nbsp;Item</td>
           <td class="border-top-right-fntsize12" style="text-align:right"><?php echo number_format($totAmount_3,2);?>&nbsp;</td>
           <td class="border-top-right-fntsize12" style="text-align:center"><?php echo $totMP_3;?></td>
           <!--<td class="border-bottom">&nbsp;</td>-->
         </tr>
       </table></td>
       <td colspan="6"><table width="41%" height="171" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="35%" height="19" class="border-bottom-right-fntsize10" style="text-align:center">Type</td>
           <td width="65%" class="border-bottom-right-fntsize10" style="text-align:center">Summary Of Taxes</td>
           </tr>
         <?php
$count++;

$loop		= 0;
$totAmount	= 0;


	if(($i==$noOfPage-1)||($noOfPage-$i)<1)
	{
$sqltax="select sum(dblAmount)AS totalTax,strTaxCode  from cusdectax where intDeliveryNo=$deliveryNo
group by strTaxCode
order By intPosition";

$result_tax=$db->RunQuery($sqltax);

while($row_tax=mysql_fetch_array($result_tax))
{
	$TaxCode	= $row_tax["strTaxCode"];
	$totalTax	= $row_tax["totalTax"];

if($loop=="10"){return;}

?>
         <tr>
           <td class="cusdec-border-right-tax" style="text-align:center"><?php echo $TaxCode?></td>
           <td class="border-right-fntsize12" style="text-align:right"><?php echo number_format($totalTax,0);?>&nbsp;</td>
           </tr>
         <?php
$totTaxAmount	+= $totalTax;
$loop++;
}
}
for($loop;$loop<10;$loop++)
{
?>
         <tr>
           <td class="cusdec-border-right-tax">&nbsp;</td>
           <td class="border-right-fntsize12" >&nbsp;</td>
           </tr>
         <?php
}
?>
         <tr>
           <td align="right" class="border-top-right-fntsize12" style="text-align:center">Total</td>
           <td align="right" class="border-top-right-fntsize12" style="text-align:right"><?php echo number_format($totTaxAmount,0);?></td>
         </tr>
       </table></td>	   
     </tr>
    </table></td>
  </tr>
  
</table>
<?php

}
function clearVariables()
{
global $itemDescription;
global $itemNo;
global $itemCode;
global $itemDescription;
global $itemNo;
global $commodityCode;
global $qty;
global $noOfPackages;
global $itemPrice;
global $grossMass;
global $netMass;
global $procCode1;
global $procCode2;
global $itmValue;
global $unit;
global $PreviousDoc_1;
global $marks_1;
global $containerNo_1;
global $countryOfOriginCode_1;
global $consigneePPCCode_1;
global $chars;
global $AdNo;
global $TQBNo_1;
global $umoQty1;
global $umoQty2;
global $umoQty3;
global $licenceNo;

$itemDescription 		= "";
$itemNo			 		= "";
$itemCode			 	= "";
$itemDescription	 	= "";	
$itemNo				 	= "";
$commodityCode		 	= "";
$qty				 	= "";
$noOfPackages		 	= "";
$itemPrice			 	= "";
$grossMass			 	= "";
$netMass			 	= "";
$procCode1			 	= "";
$procCode2			 	= "";
$itmValue			 	= "";	
$unit				 	= "";
$PreviousDoc_1		 	= "";	
$marks_1			 	= "";
$containerNo_1		 	= "";	
$countryOfOriginCode_1 	= "";	
$consigneePPCCode_1	 	= "";
$chars				 	= "";
$AdNo				 	= "";
$TQBNo_1				= "";
$umoQty1				= "";
$umoQty2				= "";
$umoQty3				= "";
$licenceNo				= "";
}
?>
</body>
</html>
