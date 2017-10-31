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
<title>eShipping Web - Examination Of Container Cargo :: Report</title>
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
			font-size:18px;
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
	$Vessel						= $row["strVessel"];
	$wharfClerk					= $row["intWharfClerk"];
	$marks1				   		= $row["strMarks"];
	$marks						= str_replace("\n","<br>",$marks1);
	$CountOfContainer			= $row["strCountOfContainer"].'x'.$row["intFeet"];
	$fcl						= $row["strFCL"];
	$customerID					= $row["strCustomerID"];
}
?>
<?php
$Declarant = $xml->companySettings->Declarant; 
?>
<table  width="979"  align="center">

  <tr>
    <td width="42" rowspan="3">&nbsp;</td>
    <td width="891"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="reporttitle" style="word-spacing:normal"><p >EXAMINATION OF CONTAINER CARGO (IMPORTS) </p>
              <p>D.G.C</p></td>
          </tr>
        </table></td>        
      </tr>
      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr height="25"> 
            <td width="86" class="font-Size12_family-times">&nbsp;</td>
            <td colspan="2" class="font-Size12_family-times" style="text-align:right">Please grant me/us permission to have container(s) particular of which are give below be</td>
          </tr>
                          <?php
$sqlconsignee="select * from customers where strCustomerID=$customerID";

$result_consignee=$db->RunQuery($sqlconsignee);
while($row_consignee=mysql_fetch_array($result_consignee))
{
	$consigneeAddress2		= str_replace(",","",$row_consignee["strAddress2"]);
}
?>
		  <tr height="25">
            <td colspan="2" class="font-Size12_family-times">Examined at my /our stores at </td>
            <td width="646" class="normalfntTAB2-fntsize12"><?php echo $consigneeAddress2?></td>
		  </tr>
          <tr height="25">
            <td colspan="3" class="normalfntTAB2-fntsize12">&nbsp;</td>
          </tr>
          <tr height="25">
            <td colspan="3" class="font-Size12_family-times">we also undertake not to break the seals except in the presence of the Custom Examination Panal and also not to dispose the de - stuffed cargo until they are released by the Custom Examination Pannal, after the examination of their contents.</td>
          </tr>
          
        
        </table></td>
        </tr>
	  

      <tr>
        <td width="28%" height="8">&nbsp;</td>
        <td width="14%" class="normalfnt_size10">&nbsp;</td>
        <td width="19%" class="normalfnt_size10">&nbsp;</td>
        <td width="19%" class="normalfnt_size10">&nbsp;</td>
        <td width="20%" class="normalfnt_size10">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" colspan="5" class="font-Size12_family-times"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%">Identify No. Of Container : </td>
            <td width="10%">&nbsp;</td>
            <td width="29%">Name of the Declarent </td>
            <td width="1%">:</td>
            <td width="35%" class="normalfntTAB2-fntsize14"><?php echo $Declarant;?></td>
          </tr>
          <tr>
            <td rowspan="6" align="center" valign="top"><?php echo($fcl==1 ? $marks:"");?></td>
            <td><?php echo $fcl==1 ? $CountOfContainer:""; ?></td>
            <td>Name and Date of Vessal </td>
            <td>:</td>
            <td class="normalfntTAB2-fntsize14"><?php echo $Vessel;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Cus. Dec. No. &amp; Date </td>
            <td>:</td>
            <td class="normalfntTAB2-fntsize14">&nbsp;</td>
          </tr>
           <?php

$sqlwalfclark="select strName,strIdNo from wharfclerks   where intWharfClerkID='$wharfClerk'";
$result_walfcleark=$db->RunQuery($sqlwalfclark);
while($row_walfcleark=mysql_fetch_array($result_walfcleark))
{
$walfclearkName = $row_walfcleark["strName"];
$walfclearkIdNo = $row_walfcleark["strIdNo"];
}
?>
          <tr>
            <td>&nbsp;</td>
            <td>Wharf clerk's /Assistant's Name </td>
            <td>:</td>
            <td class="normalfntTAB2-fntsize14"><?php echo $walfclearkName;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>CHA NO </td>
            <td>:</td>
            <td class="normalfntTAB2-fntsize14"><?php echo $walfclearkIdNo;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
        </table></td>
        </tr>
     <tr>
       <td height="21" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="font-Size12_family-times">
         <tr>
           <td width="37%" class="normalfntTAB2-fntsize12" style="text-align:center"><?php echo date("d:m:Y")?></td>
           <td width="18%">&nbsp;</td>
           <td class="normalfntTAB2" style="text-align:center">&nbsp;</td>
           </tr>
         <tr>
           <td style="text-align:center">Date</td>
           <td>&nbsp;</td>
           <td  style="text-align:center">Importer's / Clearing Agent's Name &amp; Signature </td>
           </tr>
       </table></td>
       </tr>
     <tr>
       <td height="21">&nbsp;</td>
       <td colspan="4">&nbsp;</td>
     </tr>
     <tr>
       <td height="21" colspan="5">&nbsp;</td>
     </tr>
     <tr>
       <td height="20" colspan="5" >&nbsp;</td>
     </tr>
     <tr>
       <td height="21" colspan="5" class="reportsubtitle">CUSTOM ENDOSMENT TO BE FIELD IN BY CUSTOMS</td>
       </tr>
     <tr>
       <td height="10" colspan="6">&nbsp;</td>
     </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="outline font-Size12_family-times">
        <tr>
          <td width="3%" style="text-align:center">1.</td>
          <td colspan="2">Examination by out pannal. </td>
          <td width="50%" class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td style="text-align:center">2.</td>
          <td colspan="2">Examination by panal at PVQ/SAGT/BQ. </td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td style="text-align:center">3.</td>
          <td colspan="2">Examination by panal at Gray line Yard. </td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td style="text-align:center">4.</td>
          <td colspan="2">Detail Examination at PVQ/SAGT/BQ. </td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="20%">&nbsp;</td>
          <td width="27%" style="text-align:center">Deputy Director of Customs CCED/PEU </td>
          <td class="border-left-fntsize12">&nbsp;</td>
        </tr>
    </table></td>
    <td rowspan="3" width="42">&nbsp;</td>
  </tr>
  <tr>
    <td class="font-Size12_family-times"> Examination to be done by the following panel of Office </td>
  </tr>
    <tr>
      <td class="font-Size12_family-times"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="73%" >&nbsp;</td>
      <td width="27%" class="normalfntTAB2">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align:right">&nbsp;</td>
      <td style="text-align:center">DDC (PEU)</td>
    </tr>
  </table></td>
  </tr>
</table>

</body>
</html>
