<?php
session_start();
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../";
	include "../../authentication.inc";
	include "../../eshipLoginDB.php";	
	$userId			= $_SESSION["UserID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Final Gate Pass</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style>
.border-top-dotted {
	border-top-style:dotted;
	border-top-color:#333;
	border-top-width: thin;
	border-top-color: #000000;
	font-family: Verdana;
	font-size: 12px;
	line-height: 12px; 
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.border-bottom-dotted {
	border-bottom-style:dotted;
	border-bottom-color:#333;
	border-bottom-width: thin;
	border-bottom-color: #000000;
	font-family: Verdana;
	font-size: 12px;
	line-height: 12px; 
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}

</style>

</head>

<body>
<?php
	
	$gatePassNo			= $_GET["gatePassNo"];
	$gtPassYear			= $_GET["invDate"];
	$stylNoList			= $_GET["styleNoArray"];
	$sql_FgpHdrDetails	= "SELECT
							finishing_gatepass_header.intUserId,
							finishing_gatepass_header.intCompanyID,
							finishing_gatepass_header.intGatePassNo,
							finishing_gatepass_header.intGatePassYear,
							finishing_gatepass_header.intWkScheduleNo,
							finishing_gatepass_header.intForwarderID,
							finishing_gatepass_header.strVehicleNo,
							finishing_gatepass_header.strAuthorisedBy,
							finishing_gatepass_header.strDeliveredBy,
							finishing_gatepass_header.dtmDate,
							finishing_gatepass_header.dtmDateIn,
							finishing_gatepass_header.dtmDateOut,
							finishing_gatepass_header.strTimeIn,
							finishing_gatepass_header.strTimeOut,
							finishing_gatepass_header.strDriver,
							companies.strName as cmpName,
							companies.strAddress1 as cmpAdd1,
							companies.strAddress2 as cmpAdd2,
							companies.strStreet as cmpStr,
							companies.strCity as cmpCty,
							companies.strState as cmpState,
							companies.intCountry as cmpCntry,
							companies.strZipCode as cmpZpCd,
							companies.strPhone as cmpPhn,
							companies.strFax as cmpFax,
							companies.strEMail as cmpEmail,
							companies.strWeb as cmpWeb,
							useraccounts.Name,
							forwarder.strForwarderName,
							forwarder.strAddLine1,
							forwarder.strAddLine2,
							forwarder.strStreet,
							forwarder.strCity,
							forwarder.intCountry,
							forwarder.strPhone,
							forwarder.strEMail,
							forwarder.strFax,
							forwarder.strWeb,
							country.strCountry as cntstrCountry
							FROM
							finishing_gatepass_header
							Inner Join companies ON finishing_gatepass_header.intCompanyID = companies.intCompanyID
							Inner Join useraccounts ON finishing_gatepass_header.intUserId = useraccounts.intUserID
							Inner Join forwarder ON finishing_gatepass_header.intForwarderID = forwarder.intForwarderId
							Inner Join country ON companies.intCountry = country.intConID
							WHERE
							finishing_gatepass_header.intGatePassNo =  '$gatePassNo' AND
							finishing_gatepass_header.intGatePassYear =  '$gtPassYear'";

	$rsltFgpHdr			= $db->RunQuery($sql_FgpHdrDetails);
	$row				= mysql_fetch_array($rsltFgpHdr);
				

?>

<table width="850" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
  <tr>
    <td width="31">&nbsp;</td>
    <td colspan="8" style="text-align:center; font-size:14px"><strong><?php echo strtoupper($row["cmpName"]); ?></strong></td>
    <td width="34">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"  style="text-align:center; font-size:14px">&nbsp;</td>
    <td width="76" >&nbsp;</td>
    <td width="189" style="text-align:center;font-size:14px"><strong><?php echo strtoupper($row["cmpCty"]); ?></strong>.</td>
    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr style="text-align:left;font-size:14px">
        <td width="15%" height="26"  style="text-align:center"><strong>No</strong>.</td>
        <td width="85%"><strong><?php echo $gatePassNo; ?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" rowspan="4" class="border-All"  style="text-align:center; font-size:14px"><strong>CUTTING &amp;<br />
FINISHING PLANT</strong></td>
    <td colspan="2">&nbsp;</td>
    <td width="127">&nbsp;</td>
    <td width="106">&nbsp;</td>
    <td width="52">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2" class="border-All" style="text-align:center; font-size:14px"><strong>ADVICE OF DESPATCH</strong></td>
    <td rowspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" rowspan="4"><table width="100%" height="50" border="0" cellpadding="0" cellspacing="0" class=" normalfnt">
      <tr>
        <td><?php ?></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td height="13" colspan="3"><?php
			$companyAddress1		=	$row["cmpAdd1"];
			$companyAddress1		.=	($row["cmpAdd2"])?(','.$row["cmpAdd2"].','):',';
			$companyAddress1		.=	($row["cmpStr"])?($row["cmpStr"].','):'';
			$companyAddress2		=	($row["cmpCty"])?($row["cmpCty"].','):'';
			$companyAddress2		.=	($row["cntstrCountry"])?($row["cntstrCountry"]).'.':'';
			echo $companyAddress1."<br>";
			echo $companyAddress2;
			 ?></td>
            </tr>
          <tr>
            <td width="17%" height="30">Tele </td>
            <td width="18%">:</td>
            <td width="65%"><?php echo $row["cmpZpCd"].$row["cmpPhn"]; ?></td>
          </tr>
          <tr>
            <td height="25">Fax</td>
            <td height="25">:</td>
            <td><?php echo $row["cmpZpCd"].$row["cmpFax"];?></td>
          </tr>
          <tr>
            <td height="25" colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25">Date</td>
            <td height="25">:</td>
            <td class="border-bottom-dotted"><?php echo $row["dtmDate"];?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="52">&nbsp;</td>
    <td width="77">&nbsp;</td>
    <td width="106">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="16">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="112">&nbsp;</td>
    <td colspan="5">
    <table width="101%" height="102" border="0" cellpadding="0" cellspacing="0" style="font-size:12px">
      <tr>
        <td width="16%" height="25%">To</td>
        <td width="71%" class="border-bottom"><?php echo $row["strForwarderName"];?></td>
        <td width="13%" rowspan="4" >&nbsp;</td>
      </tr>
      <tr>
        <td height="25%">&nbsp;</td>
        <td width="71%" class="border-bottom">
        <?php
			$fwdrAdd1	=	($row["strAddLine1"])?($row["strAddLine1"].','):'';
			$fwdrAdd1  .=	($row["strAddLine2"])?($row["strAddLine2"].','):'';
			echo $fwdrAdd1;
		?>
        </td>
        </tr>
      <tr>
        <td height="25%">&nbsp;</td>
        <td width="71%" class="border-bottom">
        <?php
			$fwdrAdd2	=	($row["strStreet"])?($row["strStreet"].','):'';
			$fwdrAdd2	=	($row["strCity"])?($row["strCity"].'.'):'';
			echo $fwdrAdd2;
		?>
        </td>
        </tr>
      <tr>
        <td height="25%">Vehicle No</td>
        <td width="71%" class="border-bottom" style="font-size:12px"><?php echo $row["strVehicleNo"]; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="72">&nbsp;</td>
    <td colspan="9"><table width="100%" height="53" border="0" cellpadding="0" cellspacing="0" >
      <tr height="40">
      <!--  td class="border-Left-Top-right-fntsize9 tbl-h-fnt" style="text-align:center" width="12.5%">Item code</td-->
        <td class="border-Left-Top-right-fntsize9 tbl-h-fnt" style="text-align:center" width="12.5%">Style No</td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center" width="50%">Description Of Articles</td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center" width="12.5%">No.of Cartoons</td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center" width="12.5%">Quantity</td>
      </tr>
      <tr>
      <?php
	  
	  	$sql_detaile = "SELECT
						gapro.finishing_gatepass_detail.intStyleId,
						Sum(gapro_shipping.shipmentpldetail.dblNoofCTNS) as tCrtns,
						Sum(gapro_shipping.shipmentpldetail.dblQtyPcs) as tqtyPcs,
						gapro_shipping.shipmentpldetail.strPLNo,
						gapro_shipping.shipmentplheader.strLable,
						gapro.orders.strStyle
						FROM
						gapro.finishing_gatepass_detail
						Inner Join gapro_shipping.shipmentpldetail ON 
						gapro_shipping.shipmentpldetail.strPLNo = gapro.finishing_gatepass_detail.intPlNo
						Inner Join gapro_shipping.shipmentplheader ON 
						gapro.finishing_gatepass_detail.intPlNo = gapro_shipping.shipmentplheader.strPLNo
						Inner Join gapro.orders ON gapro.finishing_gatepass_detail.intStyleId = gapro.orders.intStyleId
						WHERE
						gapro.finishing_gatepass_detail.intGatePassNo =  '$gatePassNo' AND
						gapro.finishing_gatepass_detail.intGatePassYear =  '$gtPassYear'
						GROUP BY
						gapro_shipping.shipmentpldetail.strPLNo,
						gapro.finishing_gatepass_detail.intStyleId;";
					  
					  $result_detail	=	$db->RunQuery($sql_detaile);
					  
	  	while($row1=mysql_fetch_array($result_detail)){
	  ?>
        <!--td class="border-Left-Top-right-fntsize9 tbl-h-fnt" style="text-align:center">&nbsp;</td-->
        <td class="border-Left-Top-right-fntsize9 tbl-h-fnt" style="text-align:center"><?php echo $row1["strStyle"]; ?></td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center"><?php echo $row1["strLable"]; ?></td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center"><?php echo $row1["tCrtns"];$totCart+=$row1["tCrtns"]; ?></td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center"><?php echo $row1["tqtyPcs"]; $totPcs+= $row1["tqtyPcs"];?></td>
      </tr>
      <?php
		}
	  ?>
      <tr>
        <td class="border-Left-Top-right-fntsize9 tbl-h-fnt" style="text-align:center">&nbsp;</td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center"><strong>TOTAL</strong></td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center"><strong><?php echo $totCart; ?></strong></td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center"><strong><?php echo $totPcs; ?></strong></td>
        <!--td class="border-top-right tbl-h-fnt" style="text-align:center">&nbsp; </td-->
      </tr>
    </table></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top" >&nbsp;</td>
    <td colspan="2" class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="9" class="border-All" style="font-size:9px; text-align:center">1st Customer Copy - white&nbsp; 2nd Stores Copy - Yellow &nbsp;3rd Accounts Copy - Blue&nbsp; 4th Security Copy - Pink&nbsp; 5th Book Copy - Green</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
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
    <td colspan="2">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1">Received the above quantites and varified as correct</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="53">&nbsp;</td>
    <td colspan="9"><table width="100%" height="41" border="0" cellpadding="0" cellspacing="0">
      <tr style="text-align: center">
        <td width="163"><?php echo $row["Name"];  ?></td>
        <td width="55">&nbsp;</td>
        <td width="163"><?php echo $row["strAuthorisedBy"];?></td>
        <td width="56">&nbsp;</td>
        <td width="163"><?php echo $row["strDeliveredBy"];?></td>
        <td width="56">&nbsp;</td>
        <td width="163">&nbsp;</td>
      </tr>
      <tr>
        <td style="text-align:center" class="border-top-dotted">Prepared by</td>
        <td>&nbsp;</td>
        <td style="text-align:center" class="border-top-dotted">Authorized by</td>
        <td>&nbsp;</td>
        <td style="text-align:center" class="border-top-dotted">Delivered by</td>
        <td>&nbsp;</td>
        <td style="text-align:center" class="border-top-dotted">Signature</td>
      </tr>
    </table></td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td colspan="9" style="border-top-style:dotted; border-top-color:#333; border-top-width: thin">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="10" style="text-align:center; font-size:14px"><strong>GATE PASS</strong></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td colspan="5"><table width="102%" height="103" border="0" cellpadding="0" cellspacing="0" class=" normalfnt">
  <tr>
    <td width="13%">&nbsp;</td>
    <td width="28%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
  </tr>
  <tr>
    <td>Driver</td>
    <td style="border-bottom-style:dotted;	border-bottom-color:#333;	border-bottom-width: thin;	border-bottom-color: #000000;"><?php echo $row["strDriver"]; ?></td>
    <td>&nbsp;</td>
    <td>Vehicle</td>
    <td style="border-bottom-style:dotted;	border-bottom-color:#333;	border-bottom-width: thin;	border-bottom-color: #000000;"><?php echo $row["strVehicleNo"];?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Date in</td>
    <td style="border-bottom-style:dotted;	border-bottom-color:#333;	border-bottom-width: thin;	border-bottom-color: #000000;"><?php echo $row["dtmDateIn"];?></td>
    <td>&nbsp;</td>
    <td>Time in</td>
    <td style="border-bottom-style:dotted;	border-bottom-color:#333;	border-bottom-width: thin;	border-bottom-color: #000000;"><?php echo $row["strTimeIn"];?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Date out</td>
    <td style="border-bottom-style:dotted;	border-bottom-color:#333;	border-bottom-width: thin;	border-bottom-color: #000000;"><?php echo $row["dtmDateOut"];?></td>
    <td>&nbsp;</td>
    <td>Time out</td>
    <td style="border-bottom-style:dotted;	border-bottom-color:#333;	border-bottom-width: thin;	border-bottom-color: #000000;"><?php echo $row["strTimeOut"];?></td>
    <td>&nbsp;</td>
  </tr>
</table>
&nbsp;</td>
    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt" style="text-align:right">
      <tr>
        <td width="34%" height="30"><strong>No</strong>.</td>
        <td width="66%" style="border-bottom-style:dotted;	border-bottom-color:#333;border-bottom-width:thin;border-bottom-color: #000000;text-align: center"><strong><?php echo $gatePassNo; ?></strong></td>
        </tr>
      <tr>
        <td height="30" >No Of Packages</td>
        <td style="border-bottom-style:dotted;	border-bottom-color:#333;	border-bottom-width: thin;	border-bottom-color: #000000;">&nbsp;</td>
        </tr>
      <tr>
        <td height="30">Signature security</td>
        <td style="border-bottom-style:dotted;	border-bottom-color:#333;	border-bottom-width: thin;	border-bottom-color: #000000;">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
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
    <td colspan="2">&nbsp;</td>
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
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>



</body>
</html>