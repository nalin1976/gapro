<?php
	session_start();
	include("../../../Connector.php");
	$invoiceNo	= $_GET["invoiceNo"];
	//$invoiceNo = '900020';
	$companyID	= $_SESSION["FactoryID"];
	//include("preshipment_queries.php");
	include 'preshipment_queries.php';
	$pub_EicAmount	= 0;
	
	$sql = "select 	intInvoiceNo,
			strHSCode,
			count(strHSCode) as noOfHSCode,
			sum(dblQty) as totQty, 
			sum(dblPrice) as totPrice, 
			sum(dblAmount) as totAmount, 
			sum(dblNetNetWeight) as totNetNetWeight, 
			sum(dblNetWeight) as totNetWeight, 
			sum(dblGrossWeight) as totGrossWeight, 
			sum(dblCBM) as totCBM, 
			sum(dblPackages) as totPackage 
			from 
			shipping_pre_inv_detail 
			where intInvoiceNo='$invoiceNo'
			group by strHSCode";
		
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$Item 				= $row["noOfHSCode"];
		$totQty 			= $row["totQty"];
		$totPrice 			= $row["totPrice"];
		$totAmount 			= $row["totAmount"];
		$totNetNetWeight 	= $row["totNetNetWeight"];
		$totNetWeight 		= $row["totNetWeight"];
		$totGrossWeight 	= $row["totGrossWeight"];
		$totCBM 			= $row["totCBM"];
		$totPackage 		= $row["totPackage"];
		$strHSCode 			= $row["strHSCode"];
		
	}

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Export Cusdec :: Report</title>
<link href="../../erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style3 {font-size: 11px; color: #000000; margin: 0px; text-align:left; font-family: Verdana;}
-->
</style>
</head>

<body >
<table width="920"  align="center">
  <tr>
    <td width="920"><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
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
        <td width="4%" rowspan="7" align="center" valign="middle" class="border-bottom"><img src="../../../images/headerinformation.png"/></td>
        <td width="44%"><table width="100%" height="127" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="56%" class="border-left-fntsize9">&nbsp;2.Exporter</td>
            <td width="44%" class="border-right-fntsize10">&nbsp;TIN:<b><?php echo $exp_tin;?></b></td>
          </tr>
		  <?php
		  $exporterDetails = $exp_name."<br/>";
			$exporterDetails .= ($exp_Address1=="" ? "":"&nbsp;&nbsp;".$exp_Address1."<br/>");
			$exporterDetails .= ($exp_Address2=="" ? "":"&nbsp;&nbsp;".$exp_Address2."<br/>");
			$exporterDetails .= ($exp_City=="" ? "":"&nbsp;&nbsp;".$exp_City."<br/>");
			
		  $consigneeDetails = $consigneeName."<br/>";
			$consigneeDetails .= ($consigneeAdd1=="" ? "":"&nbsp;&nbsp;".$consigneeAdd1."<br/>");
			$consigneeDetails .= ($consigneeAdd2=="" ? "":"&nbsp;&nbsp;".$consigneeAdd2."<br/>");
			$consigneeDetails .= ($consigneeCountry=="" ? "":"&nbsp;&nbsp;".$consigneeCountry."<br/>");
		
		  $manufDetails = $manuf_name."<br/>";
			$manufDetails .= ($manuf_Addr1=="" ? "":"&nbsp;&nbsp;".$manuf_Addr1."<br/>");
			$manufDetails .= ($manuf_Addr2=="" ? "":"&nbsp;&nbsp;".$manuf_Addr2."<br/>");
			$manufDetails .= ($manuf_City=="" ? "":"&nbsp;&nbsp;".$manuf_City."<br/>");
			
		  ?>
          <tr>
            <td colspan="2" class="border-left-right-fntsize12" valign="top">&nbsp;&nbsp;<?php echo $exporterDetails; ?></td>
            </tr>
          
          <tr>
            <td height="19" class="border-left">&nbsp;</td>
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
            <td height="21" colspan="2" class="border-bottom-right"><div align="center">EX</div></td>
            <td width="23%" align="center" class="border-bottom-right"><div align="center"><?php echo $Declaration;?></div></td>
            <td colspan="2" class="normalfnt_size10">&nbsp;Manifest :</td>
          </tr>
          <tr>
            <td  colspan="2" class="border-right-fntsize10">&nbsp;3. Pages</td>
            <td class="border-right-fntsize10">&nbsp;4. List</td>
            <td colspan="2" class="normalfnt_size10">&nbsp;Customs Reference</td>
          </tr>
          <tr>
            <td width="7%" height="26" class="border-bottom-right"><div align="center">1</div></td>
            <td width="7%" class="border-bottom-right"><div align="center" id="div_page">1</div></td>
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
            <td height="19" class="border-right"><?php echo $Item;  ?></td>
            <td height="19" colspan="3" class="normalfnt_size10"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr height="100%">
                <td width="27%" align="center" class="border-right"><div align="center"><b><?php echo $totPackage; ?> </b></div></td>
				<td width="73%" align="center" ><?php echo $sequenceno; ?></td>
                </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
	  
      <tr>
        <td><table width="100%" height="122" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="56%" class="border-top-left-fntsize10">&nbsp;8.Consignee</td>
            <td width="44%" class="border-top-right-fntsize9" >TIN:<strong><?php echo $consigneeTIN;?></strong></td>
          </tr>
          <tr>
            <td colspan="2" class="border-left-right-fntsize12" valign="top">&nbsp;&nbsp;<?php echo $consigneeDetails; ?></td>
          </tr>
          
          <tr>
            <td height="19" class="border-left">&nbsp;</td>
            <td class="border-right-fntsize9">Ref.Code:<b><?php echo $deliveryNo.'/'.$consigneeRefCode;?></b></td>
          </tr>
          <tr>
            <td height="19" class="border-left">&nbsp;</td>
            <td class="border-right">&nbsp;</td>
          </tr>
        </table></td>
        <td colspan="4" class="border-top-fntsize10"><table width="100%" height="122" border="0" cellpadding="0" cellspacing="0">
      
          <tr>
            <td colspan="4" class="normalfnt_size10">&nbsp;9. Person Responsible for Financial Settlement&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TIN :<span class="normalfnt"><?php echo $consigneeTIN;?></span></td>
            </tr>
          <tr>
            <td colspan="4" class="normalfnt_size12" valign="top">&nbsp;&nbsp;<?php echo $consigneeDetails; ?></td>
          </tr>
          
          <tr>
            <td width="34%" class="border-top-right-fntsize9">10.City of Last Consi/First Dest</td>
            <td width="21%" class="border-top-right-fntsize9">11.Trading Country</td>
            <td width="22%" class="border-top-right-fntsize9">12.Value Details</td>
            <td width="23%" class="border-top-fntsize10">13.C.A.P</td>
          </tr>
          <tr>
            <td height="19" class="border-right-fntsize12" style="text-align:center"><?php echo $FDestCity;?></td>
            <td height="19" class="border-right-fntsize12"  style="text-align:center"><?php echo $CountryCode;?></td>
            <td class="border-right-fntsize12-bold" id="totalReportValue" style="text-align:center;"></td>
            <td class="normalfnt" style="text-align:center"><?php echo $containerCount;?></td>
          </tr>
        </table></td>
      </tr>
	  

      <tr>
        <td height="8"><table width="100%" height="80" border="0" cellpadding="0" cellspacing="0">

          <tr>
            <td width="56%" class="border-top-left-fntsize10">&nbsp;14. Declarant / Representative</td>
            <td width="44%" class="border-top-right-fntsize9" >TIN : <span class="normalfnt_size11"> <?php echo $DeclarentTinNo1."114192600-7000";?></span></td>
          </tr>
          <tr>
            <td colspan="2" class="border-left-right-fntsize12" valign="top">&nbsp;&nbsp;<?php echo $manufDetails; ?></td>
            </tr>
          
          <tr>
            <td height="19" colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
            </tr>          
                  </table></td>
        <td colspan="4" class="normalfnt_size10"><table width="100%" height="80" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="55%" class="border-top-right-fntsize10">15. Country Of Export</td>
            <td width="22%" class="border-top-right-fntsize9">15A. Ctry.Ex.Code</td>
            <td width="23%" class="cusdec_border-top-fntsize9" >17A.Ctry.Dst.Code</td>
          </tr>
          <tr>
            <td class="border-bottom-right-fntsize12" style="text-align:center">SRI LANKA </td>
            <td class="border-bottom-right-fntsize12" style="text-align:center">LK</td>
            <td class="border-bottom-fntsize12" style="text-align:center">&nbsp;<?php echo $CountryCode;?></td>
          </tr>
          <tr>
            <td class="border-right-fntsize10">&nbsp;16. Country Of Origin</td>
            <td colspan="2" class="normalfnt_size10">&nbsp;17. Country of Destination</td>
            </tr>
          <tr>
            <td height="19" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;LK</td>
            <td height="19" colspan="2" class="border-bottom">&nbsp;<?php echo $FDestCountry;?></td>
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
            <td height="24" class="border-bottom-left-fntsize12">&nbsp;<b><?php echo $Carrier;?></b></td>
            <td height="24" class="border-bottom-left">&nbsp;</td>
            <td class="border-Left-bottom-right-fntsize12" style="text-align:center"><?php echo ($Freight<=0?"0":"1");?></td>
          </tr>


        </table></td>
        <td colspan="4" class="normalfnt_size10"><table width="102%" height="37" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="55%" height="13" class="normalfnt_size9">&nbsp;20. Delivery Terms</td>
            <td width="45%" class="style3" >&nbsp;</td>
          </tr>
          <tr>
            <td height="24" class="border-bottom-fntsize12" style="text-align:center">&nbsp;<?php echo $IncoTerm;?></td>
            <td class="border-bottom" >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td ><table width="102%" height="40" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="72%"  class="border-left-fntsize10">&nbsp;21. Voyage No. / Date</td>
            <td width="16%" class="normalfnt_size10">&nbsp;</td>
            <td width="12%" class="border-right" >&nbsp;</td>
          </tr>
          <tr>
            <td height="24" class="border-bottom-left-fntsize12">&nbsp;<?php echo $Voyage.'-'.$formatedVoyageDate?></td>
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
            <td width="13%" height="24" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;<b><?php echo $Currency;?></b></td>
            <td width="42%" height="24" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo number_format(($amount-($Freight+$Insurancy)),2);?></b></td>
            <td height="24" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo $exRate;?></b></td>
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
           <td width="13%" height="24" class="border-Left-bottom-right-fntsize12" style="text-align:center"><?php echo $ShipmentMode; ?></td>
           <td width="12%" height="24" class="border-bottom-right">&nbsp;</td>
           <td width="13%" height="24" class="border-bottom-right">&nbsp;</td>
           <td width="12%" height="24" class="border-bottom-right">&nbsp;</td>
           <td width="38%" height="24" class="border-bottom-right-fntsize12" style="text-align:center"><?php echo $PortOfLoading;?></td>
           <td width="12%" class="border-bottom-right" style="text-align:center">LK</td>
         </tr>
       </table></td>
       <td colspan="4"><table width="102%" height="48" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="62%" rowspan="2" class="border-bottom-fntsize10">&nbsp;28. Financial and Banking Data<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  Terms of Payment : <?php echo $PayTerm;?></strong></td>
           <td width="38%" height="24" class="normalfnt_size10" style="text-align:center">Bank Code</td>
         </tr>
         <tr>
           <td height="24" class="border-bottom" style="text-align:center"><?php  echo $BankCode; ?></td>
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
           <td height="24" class="border-Left-bottom-right-fntsize12">&nbsp;<b><?php echo $OfficeOfEntry;?></b></td>
           <td height="24" class="border-bottom-right-fntsize12"  style="text-align:center"><?php echo $manuf_City;?></td>
           </tr>
       </table></td>
       <td colspan="4"><table width="102%" height="48" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="5%" height="24" class="normalfnt_size10">28A.</td>
           <td width="16%" class="normalfnt_size10">Bank Name :</td>
           <td height="24" class="normalfnt_size10"><?php echo $bank;?></td>
           <td width="38%" class="normalfnt_size10">Ref. No:<span class="normalfnt_size10"><?php echo $bankRefName;?></span></td>
         </tr>
         <tr>
           <td height="24" class="border-bottom-fntsize10">&nbsp;</td>
           <td height="24" class="border-bottom-fntsize10">Branch :</td>
           <td width="41%" class="border-bottom-fntsize10"><?php echo $brnch_name;?></td>
           <td class="border-bottom" style="text-align:center" ><?php echo $lcno;?></td>
         </tr>
       </table></td>
	   </tr>
     <tr>
       <td height="21" class="border-bottom"> <img src="../../../images/pkgsanddescriptionofgoods.png"/> </td>
       <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>

           <td width="1%" height="19" class="border-left-fntsize10">&nbsp;</td>
           <td width="15%" class="normalfnt_size10"><strong>Marks &amp; Numbers</strong></td>
           <td width="1%" align="center" class="normalfnt_size10">&nbsp;</td>
           <td width="12%" class="normalfnt_size10" style="text-align:left"><strong>Container No(s)</strong></td>
           <td width="2%" class="normalfnt_size10">-</td>
           <td width="17%" class="normalfnt_size10"><strong>Number and Kind</strong></td>
           <td width="10%" class="border-left-right-fntsize10">&nbsp;32. Item No</td>
           <td colspan="4" class="normalfnt_size10">&nbsp;33. Commodity (HS) Code</td>
           </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td rowspan="9" align="left" valign="top" class="border-bottom-fntsize12"><textarea name="textarea" readonly='readonly' style='border:0px; height:200px; width:130px;overflow:hidden;
' class="normalfnt_size12"><?php echo $marks;?></textarea></td>
           <td height="25" class="normalfnt_size10">&nbsp;</td>
           <td align="center" valign="top" class="normalfnt_size12" style="text-align:center"><?php 
		   if ($fcl==1)
		   		echo $CountOfContainer.'<br>'.$containerNo;
		   else
		   		echo $containerNo;
		   	?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td align="center" valign="top" class="normalfnt_size12" style="text-align:center"></td>
           <td align="center" class="border-Left-bottom-right-fntsize12" ><div align="center"><span class="normalfnt_size10" ><?php echo "1";?></span></div></td>
           <td height="25" colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $strHSCode;?></b></td>
           </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="19" class="normalfnt_size10"></td>
           <td align="center" valign="top" class="normalfnt_size12" style="text-align:left"><span class="normalfnt_size10">Goods Description</span></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td align="center" valign="top" class="normalfnt_size12" style="text-align:center"></td>
           <td class="border-right">&nbsp;</td>
           <td colspan="2" class="border-right-fntsize10">&nbsp;34. Ctry.of. Origin Code</td>
           <td width="15%" class="border-right-fntsize10">&nbsp;35. Gross Mass (Kg)</td>
           <td width="11%" class="normalfnt_size9">&nbsp;36. Preference</td>
         </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="25" class="normalfnt_size10">&nbsp;</td>
           <td colspan="3" rowspan="7" align="center" valign="top" class="border-bottom-fntsize12" style="text-align:left"><table width="230" height="156" border="0" cellpadding="0" cellspacing="0">
             <tr>
               <td width="230" valign="top"><textarea name="textarea" readonly='readonly' style='border:0px; height:156px; width:230px;overflow:hidden;
' class="normalfnt_size12"><?php echo $itemDescription."\n".$material."\n".$commodityCode."\n".$Fabrication;?></textarea></td>
             </tr>
           </table></td>
           <td class="border-right"><?php echo  $noOfPackages." CTNS";?></td>
           <td height="25"width="7%" class="border-bottom-right-fntsize12" style="text-align:center">&nbsp;<?php echo "LK";?></td>
           <td width="9%" class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-right-fntsize12"><div align="center">&nbsp;<?php echo number_format($totGrossWeight,2);?></div></td>
           <td class="border-bottom" style="text-align:center"><?php echo $preferenceCode;?></td>
         </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="21" class="normalfnt_size10">&nbsp;</td>
           <td class="border-right"><?php echo round($qty,2).'&nbsp;-'.$unit?></td>
           <td colspan="2" class="border-right-fntsize10">&nbsp;37. Procedure Code</td>
           <td width="15%" class="border-right-fntsize10">&nbsp;38. Net Mass (Kg)</td>
           <td width="11%" class="normalfnt_size9">&nbsp;39. Quota</td>
         </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="25" class="normalfnt_size10">&nbsp;</td>
           <td rowspan="3" align="center" valign="top" class="border-right"></td>
           <td height="25" width="7%" class="border-bottom-right" style="text-align:center"><b><?php echo $procedureCode1;?></b></td>
           <td width="9%" class="border-bottom-right" style="text-align:center"><b><?php echo $procedureCode2;?></b></td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo number_format($totNetWeight,2);?></td>
           <td class="border-bottom"><div align="center"><?php echo $catno; ?></div></td>
         </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td height="19" class="normalfnt_size10">&nbsp;</td>
           <td colspan="4" class="normalfnt_size10">&nbsp;40. Previous Document / BL / AWB No.</td>
           </tr>
         <tr>
           <td align="left" valign="top" class="border-left-fntsize12">&nbsp;</td>
           <td>&nbsp;</td>
           <td height="30" colspan="4" class="border-bottom-fntsize12">&nbsp;&nbsp;<b><?php echo $BL	;?></b></td>
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
		   <?php echo number_format($totQty,2);?></td>
           <td height="21" class="border-bottom-right-fntsize12" style="text-align:center"><b><?php echo $currency." ".number_format($totAmount,2);?></b></td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
       </table></td>
       </tr>
     <tr>
       <td height="20" class="border-bottom"><img src="../../../images/additionaldocs.png" height="61" /></td>
       <td colspan="5" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr height="20">
           <td width="8%" class="border-left-fntsize10">&nbsp;Licence No:</td>
           <td colspan="12" class="normalfnt"><strong><?php echo $licenceNo; ?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="2%" class="border-right-fntsize10">&nbsp;</td>
           <td width="16%" class="border-right-fntsize10">&nbsp;41B. UMO &amp; Qty 2</td>
           <td width="16%" class="border-right">&nbsp;</td>
           <td width="11%" class="normalfnt_size9">&nbsp;45. Adjustments</td>
         </tr>
         <tr>
           <td class="border-left-fntsize10">&nbsp;A.D. :</td>
           <td colspan="12" class="normalfnt">
		   <?php 
		   		echo "380(COMINV. ".$invoiceNo.")";
			?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo ($umoQty2=="" ? "":$umoQty2)." ".$UMOQtyUnit2;?></td>
           <td class="border-bottom-right">&nbsp;</td>
           <td class="border-bottom-fntsize10">&nbsp;</td>
         </tr>
         <tr>
           <td class="border-left-fntsize10">&nbsp;</td>
           <td width="16%" class="normalfnt"><strong><?php 
		   
		   $string = $PCCode;

			$chars = preg_split('//', $string, -1, PREG_SPLIT_NO_EMPTY);
			
			
		   
		   ?></strong></td>
           <td width="2%" class="border-All" style="text-align:center"><strong><?php echo $chars[0]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[1]; ?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="2%" class="border-All" style="text-align:center"><strong><?php echo $chars[2]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[3]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[4]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[5]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[6]; ?></strong></td>
           <td width="2%" class="normalfnt_size10">&nbsp;</td>
           <td width="2%" class="border-All" style="text-align:center"><strong><?php echo $chars[7]; ?></strong></td>
           <td width="2%" class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[8]; ?></strong></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="border-All" style="text-align:center" width="2%"><strong><?php echo $chars[9]; ?></strong></td>
           <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[10]; ?></strong></td>
		   <td class="border-right-fntsize10" width="6%">&nbsp;</td>
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
           <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo round(($totQty)/12);?></td>
           <td colspan="2" class="border-bottom-fntsize12" style="text-align:center"><b><?php echo number_format(($totAmount*$exRate),2)?></b></td>
         </tr>
       </table></td>
       </tr>
     <tr>
       <td height="21" class="border-bottom"><img src="../../../images/culculationoftaxes.png" /></td>
       <td><table width="100%" height="195" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="22%" height="19" class="border-Left-bottom-right-fntsize10" style="text-align:center">(1) Type</td>
           <td width="27%" class="border-bottom-right-fntsize10" style="text-align:center">(2) Tax Base</td>
           <td width="14%" class="border-bottom-right-fntsize10" style="text-align:center">3) Rate</td>
           <td width="26%" class="border-bottom-right-fntsize10" style="text-align:center">(4) Amount</td>
           <td width="11%" class="border-bottom-right-fntsize10" style="text-align:center">5) MP</td>        
         </tr>

         <tr>
           <td class="border-left-right-fntsize12" style="text-align:center"><?php echo $TaxCode;?></td>
           <td class="border-right-fntsize12" style="text-align:right"><?php echo ($TaxBase=="0" ? "":number_format($TaxBase,0));?>&nbsp;</td>
           <td class="border-right-fntsize12" style="text-align:center"><?php echo ($Rate=="0" ? "":number_format($Rate,2));?></td>
           <td class="border-right-fntsize12" style="text-align:right"><?php echo number_format($Amount,0);?>&nbsp;</td>
           <td class="border-right-fntsize12" style="text-align:center"><?php echo "1";?></td>         
         </tr>      


 <tr>
           <td class="border-left-right-fntsize12" style="text-align:center">COM</td>
           <td class="border-right-fntsize12" style="text-align:center">&nbsp;</td>
           <td class="border-right-fntsize12" style="text-align:center">&nbsp;</td>
           <td class="border-right-fntsize12" style="text-align:right">250&nbsp;</td>
           <td class="border-right-fntsize12" style="text-align:center">1</td>         
         </tr>


	    <tr>
           <td  class="border-left-right-fntsize12">&nbsp;</td>
           <td class="border-right-fntsize10" >&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>
           <td class="border-right-fntsize10">&nbsp;</td>         
         </tr>
         <tr>
           <td height="32" colspan="3" align="right" class="border-All-fntsize12" style="text-align:center"><b>Total</b></td>
           <td class="border-top-bottom-right-fntsize12" style="text-align:right"><b><?php echo number_format($totAmount,0);?></b>&nbsp;</td>
           <td class="border-top-bottom-right-fntsize12" style="text-align:center"><b><?php ?></b></td>         
         </tr>



       </table></td>
       <td colspan="4"><table width="100%" height="195" border="0" cellpadding="0" cellspacing="0">
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
           <td height="19" class="normalfntSM">&nbsp;Assessment Number </td>
           <td class="normalfnt_size10">:</td>
           <td class="normalfnt_size10">Date :</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td height="19" class="normalfntSM">&nbsp;Reciept Number </td>
           <td class="normalfnt_size10">:</td>
           <td class="normalfnt_size10">Date :</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td height="19" class="normalfntSM">&nbsp;Guarantee </td>
           <td class="normalfnt_size10">:</td>
           <td class="normalfnt_size10">Date :</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td height="19" class="normalfntSM">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
		 
         <tr>
           <td height="19" class="normalfntSM">&nbsp;Total Fees</td>
           <td class="normalfnt_size10">:</td>
           <td class="normalfnt_size10">Rs.</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr>
           <td height="19" class="normalfnt_size10">&nbsp;Total Declaration</td>
           <td >:</td>
           <td class="normalfnt_size10">Rs.</td>
           <td >&nbsp;</td>
         </tr>
         <tr>
           <td height="21" class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
         </tr>

       </table></td>
     </tr>
     <tr>
       <td height="10" class="normalfnt_size10"><img src="../../../images/officeuse.png" /></td>
       <td colspan="6"><table width="100%" height="266" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="58%" rowspan="5" class="border-left-right-fntsize10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
             <tr>
               <td width="10%">50.</td>
               <td width="40%">US$</td>
               <td width="50%"><?php echo number_format($totAmount,2);?></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>CBM</td>
               <td><?php echo $totCBM;?></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>TQB No. </td>
               <td><?php echo $TQBNo;?></td>
             </tr>
             <tr>
               <td colspan="3"><div align="center">GOODS TRANSFER DOCS NO : ORT/th/117/09/10</div></td>
               </tr>
           </table></td>
           <td width="12%" height="10" class="normalfnt_size10" >&nbsp;<strong>C.</strong></td>
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
           <td height="10" class="normalfnt_size10">&nbsp;FOB / CIF</td>
           <td class="normalfntRite_size10"><?php echo number_format($totAmount,2);?></td>
           <td class="normalfntRite_size10">&nbsp;</td>
           <td class="normalfntRite_size10">&nbsp;</td>
           <td class="normalfntMid_size10"><?php echo $Currency;?></td>
         </tr>
         <tr height="10">
           <td height="10" class="normalfnt_size10">&nbsp;FREIGHT</td>
           <td class="normalfntRite_size10"><?php echo number_format($Freight,2);?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr height="10">
           <td height="10" class="normalfnt_size10">&nbsp;INSURANCE</td>
           <td class="normalfntRite_size10"><?php echo number_format($Insurancy,2);?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr height="10">
           <td height="10" class="normalfnt_size10">&nbsp;OTHER</td>
           <td class="normalfntRite_size10"><?php echo number_format($Other,2);?></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td class="normalfnt_size10">&nbsp;</td>
         </tr>
         <tr height="15">
           <td height="10" class="border-All-fntsize12">&nbsp;51. VERIFICATION AT SEETHAWAKA AT IND PARK </td>
           <td class="border-bottom-fntsize10">&nbsp;TOTAL</td>
           <td class="border-bottom" style="text-align:right"><?php 
		   $totalInvoiceAmount	= ($totAmount+$Freight+$Insurancy+$Other);
		  // $totalDetailAmount=($freight+$insurance+$others);
		   //echo number_format($totalInvoiceAmount,2);
		   echo number_format($totalInvoiceAmount,2);
		   ?> </td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
           <td class="border-bottom">&nbsp;</td>
         </tr>
         <tr height="25">
           <td class="border-Left-bottom-right">&nbsp;52.</td>
           <td colspan="5" class="dotborder-bottom">&nbsp;53. I &nbsp; &nbsp;
             <?php echo $Authorizedby;?></td>         
         </tr>        
         <tr height="10">
           <td height="10" class="border-left-right">&nbsp;D.</td>
           <td colspan="5" class="dotborder-bottom">&nbsp;</td>
           </tr>
         <tr height="25">
           <td   class="border-left-right">&nbsp;</td>
          
           <td colspan="5" class="normalfnt_size10">&nbsp;Do hereby affirm that the particulars and the values entered by me &nbsp;are true and correct.</td>
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

           <td colspan="2" class="normalfnt" style="text-align:center"></td>
           <td class="normalfnt_size10">&nbsp;</td>
           <td colspan="2" class="normalfnt" style="text-align:center">&nbsp;</td>
           </tr>
         <tr height="10">
           <td height="10" class="border-left-right">&nbsp;</td>
           <td colspan="2" class="dotborder-bottom" style="text-align:center"><?php echo $WharfClerkName?></td>
           <td class="normalfntMid_size10">&nbsp;</td>
           <td colspan="2" class="dotborder-bottom" style="text-align:center"><?php echo $WharfClerk;?></td>
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
var invoiceNo 		= '<?php  echo $invoiceNo;?>';
var detailrowCount  = <?php
$sql="SELECT strHSCode FROM shipping_pre_inv_detail WHERE intInvoiceNo='$invoiceNo' group by strHSCode";
$result=$db->RunQuery($sql);
$rowCount	= mysql_num_rows($result);
echo  $rowCount;
?>;
if(detailrowCount>=1)
{
	
	var noOfPages = Math.ceil((detailrowCount-1)/3);
	for(var x=0;x<noOfPages;x++)
	{
		document.getElementById("div_page").innerHTML=(noOfPages+1);
		newwindow=window.open('export_cusdec_ii.php?invoiceNo=' +invoiceNo+ '&noOfPages=' +noOfPages+'&x='+x ,'cusdecother');
		if (window.focus) {newwindow.focus();}
	}
}
</script>
</body>
</html>
