<?php 
	session_start();
echo $CDNNo = $_GET["CDNNo"];
	
	include "../../Connector.php";
$str="select
	CH.strSLPANo, 	 
	CH.strInvoiceNo, 
	CH.strVessel, 
	CH.strVoyageNo, 
	date(CH.dtmSailingDate) as dtmSailingDate, 
	CH.strExVesel, 
	CH.strLorryNo, 
	CH.strBLNo,
	CH.strVSLOPRCode, 
	CH.strCNTOPRCode,  
	CH.strCustomesEntry, 
	CH.dblTareWt, 
	CH.strSealNo,
	C.strMLocation, 
	date(CH.dtmDate) as dtmDate ,
	CH.strDriverName, 
	CH.strCleanerName, 
	C.strName as shipperName,
	C.strAddress1 as shipperAddress1,
	C.strAddress2 as shipperAddress2,
	C.strCountry as shipperCountry,
	B.strName as buyerName,
	B.strAddress1 as buyerAddress1,
	B.strAddress2 as buyerAddress2,
	B.strCountry as buyerCountry,
	city.strPortOfLoading as portOfDischarge,
	city.strCity as destination,
	IH.strPortOfLoading as portOfLoading,
	WC.strName as signator,
	WC.strIdNo as signatorIDNo,
	WFC.strName as declarant,
	WFC.strIdNo as declarantIDNo,
	WFC.strPhone as PhoneNo,
	sum(CD.dblGrossMass) as grossWgt,
	sum(CD.dblNetMass) as netWgt,
	sum(CD.intCBM) as CBM,
	IH.strMarksAndNos,
	CONT.strMeasurement,
	CH.strCTNMeasure
	from 
	cdn_header CH	
	left join buyers B on B.strBuyerID=CH.intConsignee
	left join city on city.strCityCode=CH.strPortOfDischarge
	left join invoiceheader IH on IH.strInvoiceNo=CH.strInvoiceNo
	left join customers C on C.strCustomerID=IH.strCompanyID
	left join wharfclerks WC on WC.intWharfClerkID=CH.intSignatory 
	left join wharfclerks WFC on WFC.intWharfClerkID=CH.intDeclarentName 
	left join cdn_detail CD on CD.intCDNNo=CH.intCDNNo and CD.intCDNNo=CH.intCDNNo
	left join container CONT on CONT.intContainerId= CH.strContainerNo
	LEFT JOIN shippingnote SN ON SN.strInvoiceNo=CH.strInvoiceNo
	where CH.intCDNNo=$CDNNo
	group by CH.strInvoiceNo";
	
$result=$db->RunQuery($str);
$row=mysql_fetch_array($result);

		$InvoiceNo=$row["strInvoiceNo"];
		$Vessel=$row["strVessel"];
		$VoyageNo=$row["strVoyageNo"];
		$SailingDate=$row["dtmSailingDate"];
		$ExVesel=$row["strExVesel"];
		$LorryNo=$row["strLorryNo"];
		$BLNo=$row["strBLNo"];
		$CustomerEntry=$row["strCustomesEntry"];
		$TareWt=$row["dblTareWt"];
		$SealNo=$row["strSealNo"];
		$SailingDateArry=explode("-",$SailingDate);
		$NewSailingDateArry=$SailingDateArry[2]."/".$SailingDateArry[1]."/".$SailingDateArry[0];
		$DriverName=$row["strDriverName"];
		$CleanerName=$row["strCleanerName"];
		$shipperName=$row["shipperName"];
		$shipperAddress1=$row["shipperAddress1"];
		$shipperAddress2=$row["shipperAddress2"];
		$shipperCountry=$row["shipperCountry"];
		$buyerName=$row["buyerName"];
		$buyerAddress1=$row["buyerAddress1"];
		$buyerAddress2=$row["buyerAddress2"];
		$buyerCountry=$row["buyerCountry"];
		$portOfDischarge=$row["portOfDischarge"];
		$portOfLoading=$row["portOfLoading"];
		$signator=$row["signator"];
		$grossWgt=$row["grossWgt"];
		$netWgt=$row["netWgt"];
		$CBM=$row["CBM"];
		$VSLOPRCode=$row["strVSLOPRCode"];
		$CNTOPRCode=$row["strCNTOPRCode"];
		$Date = $row["dtmDate"];
		$signatorIDNo = $row["signatorIDNo"];
		$declarant = $row["declarant"];
		$declarantIDNo = $row["declarantIDNo"];
		$PhoneNo = $row["PhoneNo"];
		$MarksAndNos = $row["strMarksAndNos"];
		$contmeasurement = $row["strMeasurement"];
		$CTNMeasure = $row["strCTNMeasure"];
		$location=$row["strMLocation"];
		$destination=$row["destination"];
		$SLPANo=$row["strSLPANo"];
		
		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web - Export CDN :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.latter{
font-family: Verdana;
	font-size: 12px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:600;
}
</style>

</head>

<body>
<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="99%"class="cusdec-normalfnt2bldBLACK"align="center" height="33" valign="bottom">CARGO DISPATCH NOTE / FCL CONTAINER LOAD PLAN - EXP 3b </td>
  </tr>
  <tr>
    <td><table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td height="100"colspan="4" rowspan="4" class="border-top-left-fntsize12" style="vertical-align:top" ><table width="447" height="92" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="241" height="5">&nbsp;&nbsp;1. a Shipper(Name and Address) </td>
              <td width="206" class="normalfnt">&nbsp;<strong>INV.NO :&nbsp;<?php echo $InvoiceNo;  ?></strong></td>
            </tr>
            <tr>
              <td height="15" colspan="2">&nbsp;&nbsp;<strong><?php echo $shipperName;  ?></strong></td>
            </tr>
            <tr>
              <td height="15" colspan="2">&nbsp;&nbsp;<strong><?php echo $shipperAddress1; ?></strong></td>
            </tr>
            <tr>
              <td height="15" colspan="2">&nbsp;&nbsp;<strong><?php echo $shipperAddress2; ?></strong></td>
            </tr>
            <tr>
              <td height="15" colspan="2">&nbsp;&nbsp;<strong><?php echo $shipperCountry; ?></strong></td>
            </tr>
        </table></td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;7. Lorry Trailer No </td>
        <td colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;8. SN / (B/L) No. </td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong> <?php
				  	$sql_Lorry   = "SELECT
									cdn_lorrydetail.dblCBM,
									cdn_lorrydetail.strLorryNo
									FROM
									cdn_lorrydetail
									WHERE
									cdn_lorrydetail.strCDNNo =  '$CDNNo' limit 1";
					$resultLorry = $db->RunQuery($sql_Lorry);
					if(mysql_num_rows($resultLorry)>0)
					{
					
				  ?>
                  
                 
                  <?php
				  while($rowLorry = mysql_fetch_array($resultLorry))
				  {
				  ?>				
                  <strong><?php echo $rowLorry["strLorryNo"]; ?></strong>
                    
                 
                  <?php
				  }
				  ?>
                
                <?php  } ?></strong></td>
        <td colspan="2"  class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $BLNo; ?></strong></td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;9. Tare Wt.(Kg) </td>
        <td colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;10. SLPA No </td>
      </tr>
      <tr>
        <td height="18" colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $TareWt; ?></strong></td>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $SLPANo; ?></strong></td>
      </tr>
      <tr>
        <td height="100" colspan="4" rowspan="8" style="vertical-align:top" class="border-top-left-fntsize12"><table width="447" height="100" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="447" height="5">&nbsp;&nbsp;1. b Consignee(Name and Address)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OUR REF. EX-0466.</td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $buyerName; ?></strong></td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $buyerAddress1; ?></strong></td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $buyerAddress2; ?></strong></td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $buyerCountry; ?></strong></td>
            </tr>
            
        </table></td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;11. Seal No. 9308 </td>
        <td colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;11 B Customer Entry </td>
      </tr>
      <tr>
        <td height="25"colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $SealNo;?></strong></td>
        <td height="25"colspan="2" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $CustomerEntry; ?></strong></td>
      </tr>
      <tr>
        <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;12. Name of Driver </td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $DriverName; ?></strong></td>
      </tr>
	 
      <tr>
        <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;13. Name of Cleaner </td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $CleanerName; ?></strong></td>
      </tr>
      <tr>
        <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;14. Any Others Accompanying </td>
      </tr>
      <tr>
        <td height="18" colspan="4" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo ""; ?></strong></td>
      </tr>
      <tr>
        <td width="114" height="50" rowspan="6" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; B </div></td>
        <td width="121" rowspan="6" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; R </div></td>
        <td width="107" rowspan="6" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S </div></td>
        <td width="113" rowspan="6" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; L </div></td>
        <td colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;15. Time of Departure from Stores/CFS . </td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;&nbsp; The container/lorry was stuffed/loaded under strict strict security</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;condition &amp; I certify that this container/lorry is safe to behandled in</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;the port. </td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;</td>
      </tr>
      <tr>
        <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;3.a Voyge No./Date 8228</td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;3. b Ex-Vessel </td>
        <td colspan="4" class="border-left-right-fntsize12" >&nbsp;&nbsp;16. Name of Certifying security officer/authorized signatory.</td>
      </tr>
      <tr>
        <td height="32" colspan="2"  class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $VoyageNo." ".$NewSailingDateArry;?></strong></td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $ExVesel;?></strong></td>
        <td colspan="4" class="border-left-right-fntsize12" >
          <div align="center"><strong><?php echo $signator ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID NO :<?php echo $signatorIDNo; ?></strong> </div></td>
      </tr>
      <tr>
        <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;4. Veessel 8122/3</td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;6. Port of loading</td>
        <td colspan="4" class="border-left-right-fntsize12"  >
          <div align="center"></div></td>
      </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-fntsize12" >&nbsp;&nbsp;<strong><?php echo $Vessel; ?></strong></td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $portOfLoading; ?></strong></td>
        <td colspan="4" class="border-left-right-fntsize12"  >&nbsp;&nbsp;17. Signature, Designation and Date</td>
      </tr>
      <tr>
        <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;5. Port of Discharge 3424/5 </td>
        <td class="border-top-left-fntsize12">&nbsp;&nbsp;VSL.OPR.CODE</td>
        <td class="border-top-left-fntsize12">&nbsp;&nbsp;CTN.OPR.CODE</td>
        <td colspan="3" class="border-left-fntsize12" >&nbsp;</td>
        <td class="border-right-fntsize12" ><strong><?php echo date("d-M-y",strtotime($Date)) ;?></strong></td>
      </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-fntsize12" >&nbsp;&nbsp;<strong><?php echo $portOfDischarge; ?></strong></td>
        <td class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $VSLOPRCode; ?></strong></td>
        <td class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $CNTOPRCode; ?></strong></td>
        <td width="111"   class="border-left-fntsize12">&nbsp;</td>
        <td width="137"   >&nbsp;</td>
        <td   >&nbsp;</td>
        <td   class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-top-left-fntsize12">18. Marks &amp; Numbers/Container </td>
        <td colspan="2" class="border-top-fntsize12">&nbsp;&nbsp;
          19. Number &amp; Kind of packages </td>
        <td colspan="2" class="border-top-fntsize12">&nbsp;&nbsp;
          20. Description of Codes*</td>
        <td width="84" height="21" class="border-top-left-fntsize12">&nbsp;21.(a)Gross Wt.</td>
        <td width="113" class="border-Left-Top-right-fntsize12">&nbsp;22. Cube CBM </td>
      </tr>
      <tr>
        <td height="10" colspan="2" class="border-left-fntsize12">&nbsp;No.</td>
        <td >&nbsp; &nbsp;  </td>
        <td ></td>
        <td colspan="2" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php
			$sql = "select strDescOfGoods,strFabrication,ID.strHSCode
					from invoicedetail ID
					inner join cdn_header CH on CH.strInvoiceNo=ID.strInvoiceNo
					where CH.strInvoiceNo='$InvoiceNo'
					group by ID.strHSCode";
			$result=$db->RunQuery($sql);
			$boolcheck = false;
			while($row=mysql_fetch_array($result))
			{
				if($boolcheck)
				{
					$DescOfGoods = $DescOfGoods.'\\'.$row["strDescOfGoods"];
					$Fabrication = $Fabrication.'\\'.$row["strFabrication"];
					
				}
				else
				{
					$DescOfGoods = $row["strDescOfGoods"];
					$Fabrication = $row["strFabrication"];
				}
			$boolcheck = true;
			}
		?>
        
              <tr>
                <td class="normalfnt"><bb></td>
              </tr>
              <tr>
                <td class="normalfnt"><bb><strong></strong></td>
              </tr>
        </table>
        </td>
        <td height="10" class="border-left-fntsize12"><div align="center">(Kg.)6292</div></td>
        <td width="113"  class="border-left-right-fntsize12"><div align="center">6324</div></td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" align="center" >&nbsp;</td>
        <td colspan="2" valign="top" >&nbsp;</td>
        <td height="10" class="border-left-fntsize12"><div align="center"><strong><?php echo number_format($grossWgt,2); ?></strong></div></td>
        <td width="113"  class="border-left-right-fntsize12"><div align="center"><strong><?php echo $CBM; ?></strong></div></td>
      </tr>
      <tr>
        <td colspan="2" rowspan="12" class="border-left-fntsize12" valign="top"><table width="201" height="228" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="17">&nbsp;</td>
            <td width="184" valign="top"><textarea name="textarea" readonly='readonly'  style='border:0px; height:250px; width:180px;overflow:hidden;
' class="latter"><?php echo $MarksAndNos ; ?></textarea></td>
          </tr>
        </table></td>
        <td colspan="4" rowspan="13" valign="top"><table width="442" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="404" valign="top" class="normalfnt" style="font-size:12px">
                <?php
				$sql = "SELECT
						Sum(cdn_detail.dblQuantity) AS QtySum,
						Sum(cdn_detail.intNoOfCTns) AS QtyCtn
						FROM
						cdn_detail
						WHERE
						cdn_detail.intCDNNo = '$CDNNo'
						group by cdn_detail.intCDNNo";
				$result=$db->RunQuery($sql);
				$row=mysql_fetch_array($result);
				
				$sql1 = "SELECT DISTINCT
						cdn_detail.strBuyerPONo,
						cdn_detail.strStyleID,
						cdn_detail.strPLNo
						FROM
						cdn_detail
						WHERE
						cdn_detail.intCDNNo =  '$CDNNo'";
				$result1=$db->RunQuery($sql1);
				
				
				?>
                <?php echo $row["QtyCtn"]; ?>&nbsp;Cartons Containing<br />
                <?php echo $row["QtySum"]; ?>&nbsp;Pcs of &nbsp;<?php echo $DescOfGoods; ?><br />
                &nbsp;<?php echo $Fabrication; ?><br />
                &nbsp;Contract No :<br />
                &nbsp;&nbsp;&nbsp;&nbsp;Style No :&nbsp;
                <?php
				$i=1;
                while($row1=mysql_fetch_array($result1))
				{
					echo $row1["strStyleID"]; if($i<mysql_num_rows($result1)){ echo " / "; }
					$plno =  $row1["strPLNo"];
					$i++;
				}
                ?>
                <br />
                &nbsp;&nbsp;&nbsp;&nbsp;Order No :&nbsp;
                <?php
				$j=1;
				$result1=$db->RunQuery($sql1);
                while($row1=mysql_fetch_array($result1))
				{
					echo $row1["strBuyerPONo"];  if($j<mysql_num_rows($result1)){ echo " / "; }
					$j++;
				}
                ?>
                <br /><br />
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="vertical-align:top">
                <tr>
                <td width="223" style="text-align:left">
                <?php
				if($CTNMeasure==1)
				{
                	$sql_PL_CDN = "";
				?>
                <table width="95%" border="0" cellspacing="0" cellpadding="0" style="vertical-align:top">
                  <tr>
                    <td width="63%" style="text-align:center; font-size:10px" class="border-bottom"><b>CTN Measurement :</b></td>
                    <td width="37%" style="text-align:center; font-size:10px" class="border-bottom"><b>No of CTNS</b></td>
                    </tr>
                  <?php 
				  $str_ctns="SELECT SUM(dblNoofCTNS) as dblNoofCTNS, strCartoon  FROM shipmentpldetail SPD
LEFT JOIN cartoon CTN ON CTN.intCartoonId=SPD.strCTN
WHERE strPLNo = '$plno' 
GROUP BY strCTN";
				  $result_ctns=$db->RunQuery($str_ctns);
				 if(mysql_num_rows($result_ctns)>0)
				 {
				  while($row_ctn=mysql_fetch_array($result_ctns)){
			?>
				  
                  <tr>
                    <td style="text-align:center; font-size:10px"><?php echo $row_ctn['strCartoon'];?></td>
                    <td style="text-align:center; font-size:10px"><?php echo  $row_ctn['dblNoofCTNS'];?></td>
                    </tr><?php $totCtn=$totCtn+$row_ctn['dblNoofCTNS']; }?>
					<tr>
                    <td style="text-align:center; font-size:10px">&nbsp;</td>
                    <td style="text-align:center; font-size:10px" class="border-top-bottom"><?php echo  $totCtn;?></td>
                    </tr>
                  </table>
                  <?php }
				
				else
				{
					$str_ctn_det="SELECT strCTN, dblQty FROM cdn_ctndetail WHERE strCDNNo = '$CDNNo' 
GROUP BY strCTN";
				  $result_ctns_det=$db->RunQuery($str_ctn_det);
				  while($row_ctns_det=mysql_fetch_array($result_ctns_det)){
				?>
                	<tr>
                    <td style="text-align:center; font-size:10px"><?php echo $row_ctns_det['strCTN'];?></td>
                    <td style="text-align:center; font-size:10px"><?php echo  $row_ctns_det['dblQty'];?></td>
                    </tr><?php $totCtn=$totCtn+$row_ctns_det['dblQty']; }?>
					<tr>
                    <td style="text-align:center; font-size:10px">&nbsp;</td>
                    <td style="text-align:center; font-size:10px" class="border-top-bottom"><?php echo  $totCtn;?></td>
                    </tr>
                  </table>	
                <?php
				}
				}
				?>
                  </td>
                  <td width="202" style="text-align:center">
                  <?php
				  	$sql_Lorry   = "SELECT
									cdn_lorrydetail.dblCBM,
									cdn_lorrydetail.strLorryNo
									FROM
									cdn_lorrydetail
									WHERE
									cdn_lorrydetail.strCDNNo =  '$CDNNo'";
					$resultLorry = $db->RunQuery($sql_Lorry);
					if(mysql_num_rows($resultLorry)>0)
					{
					
				  ?>
                  
                  <table width="184" border="0" cellspacing="0" cellpadding="0" style="vertical-align:top">
                  <tr>
                    <td style="text-align:center; font-size:10px" class="border-bottom"><b>Lorry No</b></td>
                    <td style="text-align:center; font-size:10px" class="border-bottom"><b>CTNS</b></td>
                  </tr>
                  <?php
				  while($rowLorry = mysql_fetch_array($resultLorry))
				  {
				  ?>				
                  <tr>
                    <td style="text-align:center; font-size:10px"><?php echo $rowLorry["strLorryNo"]; ?></td>
                    <td style="text-align:center; font-size:10px"><?php echo $rowLorry["dblCBM"]; ?></td>
                  </tr>
                  <?php
				  }
				  ?>
                </table>
                <?php  } ?>
                </td></tr></table>               <br />
                
                
              </td>
              <td width="16" valign="top">&nbsp;</td>
            </tr>
          </table></td>
        <td height="10" class="border-top-left-fntsize12">&nbsp;21.(b)Net Wt.</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12"><div align="center">(Kg.)6160</div></td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12"><div align="center"><strong><?php echo number_format($netWgt,2)?></strong></div></td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-top-left-fntsize12">&nbsp;21.(c) 6294</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12">&nbsp;&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-top-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td height="5" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" align="center" ><table width="67" height="15" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="67" class="border-All-fntsize12"><div align="center" >DOOR</div></td>
            </tr>
        </table></td>
        <td colspan="2" >&nbsp;</td>
        <td height="5" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="26" colspan="3" class="border-top-left-fntsize12">&nbsp;&nbsp;21. Type of container </td>
        <td colspan="2" class="border-top-left-fntsize12" >&nbsp;31. Custom Export Office</td>
        <td colspan="3" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;&nbsp;Received ....................... Packages / Container </td>
      </tr>
      <tr>
        <td height="20" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;Height :<?php echo $height;?> Length :<?php echo $length;?> Type : <?php echo $type;?></td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;trailer in apparent good order and condition. </td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;24. Reefer Temperature Required </td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;33. SLPA Supervising Officer/ Pier Clerk </td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12"><div align="right"><?php echo $temperature;?></div></td>
        <td height="10" ><sup>o</sup>F</td>
        <td height="10" ><sup>o</sup>C</td>
        <td colspan="2"  class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;</td>
        <td colspan="2"  class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;Date</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;Signature</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;25. Place of Delivery&nbsp;:&nbsp;&nbsp;<strong><?php echo $destination ?></strong></td>
        <td colspan="2"  class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3"  class="border-Left-Top-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="15" colspan="3" rowspan="2" class="border-left-fntsize12">&nbsp;
            <table width="340" height="18" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="30" height="18"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="50"><div align="center">CY</div></td>
                <td width="50"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="50"><div align="center">CYS</div></td>
                <td width="50"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="50"><div align="center">DOOR</div></td>
              </tr>
          </table></td>
        <td colspan="2" rowspan="2"  class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;I certify that the commoditiea loaded into </td>
      </tr>
      <tr>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;trailer/lorry mentioned above at our premises </td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;</td>
        <td colspan="2" class="border-top-left-fntsize12" ><span >&nbsp;32. SLPA Export Office </span></td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;were packed in our stores under strict security</td>
      </tr>
      <tr>
        <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;26. Place of Receipt </td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;condition and it is safe for handling </td>
      </tr>
      <tr>
        <td height="2" colspan="3" class="border-left-fntsize12">&nbsp;
            <table width="340" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="40"><div align="center">CY</div></td>
                <td width="43"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="43"><div align="center">PORT</div></td>
                <td width="40"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="43"><div align="center">CFS</div></td>
                <td><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td><div align="center">DOOR</div></td>
              </tr>
          </table></td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="3" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;34. Name of Company Preparing this note</td>
      </tr>
      <tr>
        <td height="2" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;27. Remarks </td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" ><dd><strong><?php echo $shipperName ; ?></strong></td>
      </tr>
      <tr>
        <td height="3" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;35. Names of declarent 3140/1 </td>
      </tr>
      <tr>
        <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;<strong><?php echo $declarant ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID NO :<?php echo $declarantIDNo; ?></strong></td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;28(a). Time of Arrival at Customs Gate </td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;28(b). Customs Officer </td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;36. Telephone No.</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" ><strong>&nbsp; &nbsp; &nbsp; +94-11-2668000</strong></td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;29(a). Time of Arrival Alongside </td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;29(b) Pier Clerk </td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3"class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;37. Signature of Declarant</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3"class="border-left-right-fntsize12" ><div align="right"><strong><?php echo date("d-M-y",strtotime($Date)) ;?></strong>&nbsp;&nbsp;Date&nbsp;&nbsp;</div></td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;30(a). Time &amp; Date Dc..Loanted/Dish </td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;30(b). Superviser/Pier Clerk </td>
        <td colspan="3" class="border-left-right-fntsize12" ><div align="center"></div></td>
      </tr>
      
      <tr>
        <td height="10" colspan="3" class="border-bottom-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-left-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
      </tr>
      <tr class="normalfnt">
        <td height="10" colspan="2" style="font-size:10px"><b>DARK CAGES FOR OFFICIAL USE ONLY.</b> </td>
        <td height="10" ></td>
        <td height="10" colspan="3" style="font-size:10px">Need to be filled only when used as Container Load Plan.</td>
        <?php 
$SQLNO3 =   "SELECT
			customers.strName,customers.strMLocation
			FROM
			invoiceheader
			Inner Join customers ON invoiceheader.intManufacturerId = customers.strCustomerID
			WHERE
			invoiceheader.intInvoiceId = '$invoiceno'";
			
			
	$r13=$db->RunQuery($SQLNO3);
	$r134=mysql_fetch_array($r13);			
?>
<?php
		$sql_loc = "SELECT
invoiceheader.intManufacturerId,
customers.strMLocation
FROM
invoiceheader
INNER JOIN customers ON customers.strCustomerID = invoiceheader.intManufacturerId
WHERE invoiceheader.strInvoiceNo='$InvoiceNo'";
$result_loc = $db->RunQuery($sql_loc);
$row_loc=mysql_fetch_array($result_loc);
?>
        <td height="10" style="font-size:11px"><b>Factory :</b></td>
        <td height="10" ><?php echo $row_loc['strMLocation']; ?></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
