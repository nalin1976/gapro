<?php
	session_start();
	include("../../../Connector.php");
	$invoiceNo	= $_GET["invoiceNo"];
	$noOfPages	= $_GET["noOfPages"];
	$pageCount	= $_GET["pageCount"];
	$companyID	= $_SESSION["FactoryID"];
	include 'preshipment_queries.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Export Cusdec :: Report</title>
<link href="../../erpstyle.css" rel="stylesheet" type="text/css" />
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
<table>
<tr>
</thead>
<td>
<table width="940" align="center">
  <tr><thead>
    <td width="940"><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="32%" class="normalfnt2bldBLACK">CUSDEC - II</td>
        <td width="55%" class="normalfnt2bldBLACK"><i>SRI LANKA CUSTOMS - GOODS DECLARATION</i></td>
        <td width="13%" class="normalfnt2bldBLACK">CUSTOMS 53 </td> </thead>
      </tr>
    </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline">
      <tr>
        <td width="4%" class="border-bottom"><img src="../../../images/headerinformation2.png" width="35" height="89" /></td>
        <td width="43%" height="100"><table width="100%" height="102" border="0" cellpadding="0" cellspacing="0">
            
<?php
		    $exporterDetails = $exp_name."<br/>";
			$exporterDetails .= ($exp_Address1=="" ? "":"&nbsp;&nbsp;".$exp_Address1."<br/>");
			$exporterDetails .= ($exp_Address2=="" ? "":"&nbsp;&nbsp;".$exp_Address2."<br/>");
			$exporterDetails .= ($exp_City=="" ? "":"&nbsp;&nbsp;".$exp_City."<br/>");
			
		  ?>
            <tr>
              <td width="61%" class="border-left-fntsize10">&nbsp;<b>2.Consignee</b></td>
              <td width="39%" class="border-right-fntsize10">&nbsp;<b>TIN:<?php echo $consigneeTIN;?></b></td>
            </tr>
            <tr>
              <td colspan="2" class="border-left-right-fntsize12" valign="top">&nbsp;&nbsp;<?php echo $exporterDetails; ?></td>
            </tr>
            
            <tr>
              <td height="19" class="border-left-fntsize12">&nbsp;</td>
              <td class="border-right">&nbsp;</td>
            </tr>
        </table></td>
        <td width="53%" colspan="4"><table width="100%" height="102" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="23" colspan="3" class="border-right-fntsize10">&nbsp;<b>1. DECLARATION</b></td>
              <td colspan="2" class="normalfnt_size10">&nbsp;<b>A. OFFICE USE </b></td>
            </tr>
            <tr>
              <td width="11%" height="21" class="border-bottom-right-fntsize12"><div align="center">EX</div></td>
              <td width="13%" class="border-bottom-right"><div align="center"><?php echo $Declaration;?></div></td>
              <td width="26%" align="center" class="border-bottom-right"><div align="center">
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
              <td height="19" colspan="2" class="border-right-fntsize10">&nbsp;<b>3. Pages</b> </td>
              <td class="border-right">&nbsp;<b>4. List </b></td>
              <td colspan="2" class="normalfnt_size10">&nbsp;<b>Customs Reference</b></td>
            </tr>
            <tr>
              <td height="26" class="border-right"><div align="center"><?php echo ($pageCount+2); ?></div></td>
              <td class="border-right"><div align="center"><?php echo ($noOfPages+1);?></div></td>
              <td class="border-right"><?php  echo $i; ?></td>
              <td width="29%" class="normalfnt_size10">&nbsp;Number :</td>
              <td width="21%" class="normalfnt_size10">Date :</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="4%" class="border-bottom"><img src="../../../images/pkgsanddescriptionofgoods.png" width="35" height="151" /></td>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <?php 

					
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
			group by strHSCode
			limit ".(1+($pageCount * 3)) . ",1;";
		
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$Item_1 			= $row["noOfHSCode"];
		$totQty_1 			= $row["totQty"];
		$totPrice_1 		= $row["totPrice"];
		$totAmount_1 		= $row["totAmount"];
		$totNetNetWeight_1 	= $row["totNetNetWeight"];
		$totNetWeight_1 	= $row["totNetWeight"];
		$totGrossWeight_1 	= $row["totGrossWeight"];
		$totCBM_1 			= $row["totCBM"];
		$totPackage_1 		= $row["totPackage"];
		$strHSCode_1 		= $row["strHSCode"];
		
	}

?>
              <td width="85" height="29" class="border-top-left-fntsize10">&nbsp;<strong>31.Marks &amp; Numbers</strong></td>
              <td width="16" align="center" class="border-top-fntsize10">-</td>
              <td width="160" class="border-top-fntsize10" style="text-align:center"><strong>Container No(s)</strong></td>
              <td width="17" class="border-top-fntsize10">-</td>
              <td width="128" class="border-top-right"><strong>Number and Kind</strong></td>
              <td width="73" class="border-top-right-fntsize10">&nbsp;<strong>32.Item No</strong></td>
              <td colspan="4" class="border-top-fntsize10">&nbsp;<strong>33. Commodity (HS) Code</strong></td>
            </tr>
            <tr>
              <td height="20" class="border-left">&nbsp;</td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="normalfnt_size10" style="text-align:center"><?php echo $containerNo_1;?></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-right-fntsize10" style="text-align:center"></td>
              <td align="center" class="border-bottom-right" ><div align="center"><span class="normalfnt_size10" ><?php echo "2";?></span></div></td>
              <td colspan="4" class="border-bottom">&nbsp;&nbsp;<?php echo $strHSCode_1;?></td>
            </tr>
            <tr>
              <td rowspan="7" align="left" valign="top" class="border-left"><div align="center"><strong><?php echo "AS PER INVOICE";?></strong></div></td>
              <td height="23" class="normalfnt_size10"></td>
              <td colspan="3" class="normalfnt_size10">Goods Description</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>34. Ctry.of. Origin Code</strong></td>
              <td width="161" class="border-right-fntsize10">&nbsp;<strong>35. Gross Mass (Kg)</strong></td>
              <td width="119" class="normalfnt_size10">&nbsp;<strong>36. Preference</strong></td>
            </tr>
            <tr>
              <td height="10" class="normalfnt_size10">&nbsp;</td>
              <td colspan="3" rowspan="7" class="border-bottom-fntsize12" valign="top"><textarea name="textarea" readonly='readonly' style='border:0px; height:140px; width:308px;overflow:hidden;
' class="normalfnt_size12"><?php echo $itemDescription_1."\n\n".$commodityCode_1."\n".$Fabrication_1;?></textarea></td>
              <td class="border-right">&nbsp;</td>
              <td width="50" class="border-bottom-right" style="text-align:center">&nbsp;<?php echo "LK";?></td>
              <td width="82" class="border-bottom-right">&nbsp;</td>
              <td class="border-bottom-right"><div align="center">&nbsp;<?php echo number_format($totGrossWeight_1,2);?></div></td>
              <td class="border-bottom">&nbsp;</td>
            </tr>
            <tr>
              <td height="31" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right"><?php echo ($totPackage_1!=""?$totPackage_1." CTNS":'');?></td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>37. Procedure Code</strong></td>
              <td width="161" class="normalfnt_size10">&nbsp;<strong>38. Net Mass (Kg)</strong></td>
              <td width="119" class="normalfnt_size10">&nbsp;<strong>39. Quota</strong></td>
            </tr>
            <tr>
              <td height="25" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right"><?php echo ($qty_1=="" ? "":round($qty_1,2).'-'.$unit_1)?></td>
              <td width="50" class="border-bottom-right" style="text-align:center"><?php echo $procCode1_1;?></td>
              <td width="82" class="border-bottom-right" style="text-align:center">&nbsp;</td>
              <td class="border-bottom-right" style="text-align:center"><?php echo number_format($totNetWeight_1,2);?></td>
              <td class="border-bottom"><div align="center"><?php echo $cat_1;?></div></td>
            </tr>
            <tr>
              <td height="22" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="4" class="normalfnt_size10">&nbsp;<strong>40. Previous Document / BL / AWB No.</strong></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="4" class="border-bottom">&nbsp;&nbsp;<?php echo $PreviousDoc_1;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>41A. UMO &amp; Qty 1</strong></td>
              <td class="border-right-fntsize10">&nbsp;<strong>42. Item Price (FOB/CIF)</strong></td>
              <td class="normalfnt_size10">&nbsp;<strong>43.</strong></td>
            </tr>
            <tr>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-right">&nbsp;</td>
              <td colspan="2" class="border-bottom-right" style="text-align:center"><?php echo number_format($totQty_1,2);?></td>
              <td class="border-bottom-right" style="text-align:center"><?php echo $currency." ".number_format($totAmount_1,2);?></td>
              <td class="border-bottom">&nbsp;</td>
            </tr>
        </table>
          <span class="border-bottom-right" style="text-align:center"><?php echo $procCode2_1;?></span></td>
      </tr>
      <tr>
        <td width="4%" class="border-bottom"><img src="../../../images/additionaldocs.png" width="35" height="69" /></td>
        <td colspan="5" height="10"><table width="100%" border="0" height="20" cellspacing="0" cellpadding="0">
            <tr height="27">
              <td colspan="2" class="border-left-fntsize10">&nbsp;<b>44.Licence No.</b></td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="6%" class="border-right-fntsize10">&nbsp;</td>
              <td width="15%" class="border-right-fntsize10">&nbsp;<b>41B. UMO &amp; Qty 2</b></td>
              <td width="18%" class="border-right">&nbsp;</td>
              <td width="13%" class="normalfnt_size10">&nbsp;<b>45. Adjustments</b></td>
            </tr>
            <tr>
              <td width="8%" class="border-left-fntsize10">&nbsp;A.D. :</td>
              <td colspan="14" class="normalfnt_size10"><?php echo $invoiceNo;?></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-right-fntsize10">&nbsp;</td>
              <td class="border-bottom-right" style="text-align:center"><?php echo number_format($umoqty1_2,2)." ".$umoqtyuint1_2;?></td>
              <td class="border-bottom-right">&nbsp;</td>
              <td class="border-bottom-fntsize10">&nbsp;</td>
            </tr>
            <tr>
              <td class="border-left-fntsize10">&nbsp;<strong>TQB :</strong></td>
              <td width="12%" class="normalfnt_size10"><strong><?php echo $TQBNo;?></strong></td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[0]; ?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[1]; ?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[2]; ?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[3]; ?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[4]; ?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[5];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[6];?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[7];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[8];?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[9];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[10];?></strong></td>
              <td class="border-right-fntsize10">&nbsp;</td>
              <td class="border-right-fntsize10">&nbsp;<b>41C. UMO &amp; Qty 3</b></td>
              <td colspan="2" class="normalfnt_size10" style="text-align:center"><b>46. Value (NCY)</b></td>
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
              <td class="border-bottom-right" style="text-align:center"><?php echo round(($totQty_1)/12);?></td>
              <td colspan="2" class="border-bottom" style="text-align:center"><?php echo number_format(($totAmount_1*$exRate),2)?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="4%" class="border-bottom"><img src="../../../images/pkgsanddescriptionofgoods.png" width="35" height="151" /></td>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <?php 
		   
		$Item_2 			= "";
		$totQty_2 			= "";
		$totPrice_2 		= "";
		$totAmount_2 		= "";
		$totNetNetWeight_2 	= "";
		$totNetWeight_2 	= "";
		$totGrossWeight_2 	= "";
		$totCBM_2 			= "";
		$totPackage_2 		= "";
		$strHSCode_2 		= "";
	
 

					
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
			group by strHSCode
			limit ".(2+($pageCount*3)) . ",1;";
		
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$Item_2 			= $row["noOfHSCode"];
		$totQty_2 			= $row["totQty"];
		$totPrice_2 		= $row["totPrice"];
		$totAmount_2 		= $row["totAmount"];
		$totNetNetWeight_2 	= $row["totNetNetWeight"];
		$totNetWeight_2 	= $row["totNetWeight"];
		$totGrossWeight_2 	= $row["totGrossWeight"];
		$totCBM_2 			= $row["totCBM"];
		$totPackage_2 		= $row["totPackage"];
		$strHSCode_2 		= $row["strHSCode"];
		
	}

?>
              <td width="10%" height="29" class="border-left-fntsize10">&nbsp;<strong>31.Marks &amp; Numbers</strong></td>
              <td width="2%" align="center" class="normalfnt_size10">-</td>
              <td width="17%" class="normalfnt_size10" style="text-align:center"><strong>Container No(s)</strong></td>
              <td width="2%" class="normalfnt_size10">-</td>
              <td width="14%" class="normalfnt_size10"><strong>Number and Kind</strong></td>
              <td width="9%" class="border-left-right-fntsize10">&nbsp;<strong>32.Item No</strong></td>
              <td colspan="4" class="normalfnt_size10">&nbsp;<strong>33. Commodity (HS) Code</strong></td>
            </tr>
            <tr>
              <td height="24" class="border-left">&nbsp;</td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="normalfnt_size10" style="text-align:center"><?php echo $containerNo_2;?></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="normalfnt_size10" style="text-align:center"></td>
              <td align="center" class="border-Left-bottom-right" ><div align="center"><span class="normalfnt_size10"><?php echo "3";?></span></div></td>
              <td colspan="4" class="border-bottom">&nbsp;&nbsp;<?php echo $strHSCode_2;?></td>
            </tr>
            <tr>
              <td rowspan="7" align="left" valign="top" class="border-left"><div align="center"><strong><?php echo " AS PER INVOICE";?></strong></div></td>
              <td height="23" class="normalfnt_size10"></td>
              <td class="normalfnt_size10">Goods Description</td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>34. Ctry.of. Origin Code</strong></td>
              <td width="18%" class="border-right-fntsize10">&nbsp;<strong>35. Gross Mass (Kg)</strong></td>
              <td width="13%" class="normalfnt_size10">&nbsp;<strong>36. Preference</strong></td>
            </tr>
            <tr>
              <td height="10" class="normalfnt_size10">&nbsp;</td>
              <td colspan="3" rowspan="7" class="border-bottom-fntsize12" valign="top"><textarea name="textarea3" readonly='readonly' style='border:0px; height:140px; width:260px;overflow:hidden;
' class="normalfnt_size12"><?php echo $itemDescription_2."\n\n".$commodityCode_2."\n".$Fabrication_2;?></textarea></td>
              <td class="border-right">&nbsp;</td>
              <td width="5%" class="border-bottom-right" style="text-align:center">&nbsp;<?php echo "LK";?></td>
              <td width="10%" class="border-bottom-right">&nbsp;</td>
              <td class="border-bottom-right"><div align="center">&nbsp;<?php echo number_format($totGrossWeight_2,2);?></div></td>
              <td class="border-bottom">&nbsp;</td>
            </tr>
            <tr>
              <td height="31" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right"><?php echo ($totPackage_2!=""?$totPackage_2." CTNS":'');?></td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>37. Procedure Code</strong></td>
              <td width="18%" class="normalfnt_size10">&nbsp;<strong>38. Net Mass (Kg)</strong></td>
              <td width="13%" class="normalfnt_size10">&nbsp;<strong>39. Quota</strong></td>
            </tr>
            <tr>
              <td height="25" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right"><?php echo ($qty_2=="" ? "":round($qty_2,2).'-'.$unit_1)?></td>
              <td width="5%" class="border-bottom-right" style="text-align:center"><?php echo $procCode1_2;?></td>
              <td width="10%" class="border-bottom-right" style="text-align:center"><?php echo $procCode2_2;?></td>
              <td class="border-bottom-right" style="text-align:center"><span class="border-bottom-right" style="text-align:center"><?php echo number_format($totNetWeight_2,2);?></span></td>
              <td class="border-bottom"><div align="center"><?php echo $cat_2;?></div></td>
            </tr>
            <tr>
              <td height="22" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right"></td>
              <td colspan="4" class="normalfnt_size10">&nbsp;<strong>40. Previous Document / BL / AWB No.</strong></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="4" class="border-bottom">&nbsp;&nbsp;<?php echo $PreviousDoc_2;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>41A. UMO &amp; Qty 1</strong></td>
              <td class="border-right-fntsize10">&nbsp;<strong>42. Item Price (FOB/CIF)</strong></td>
              <td class="normalfnt_size10">&nbsp;<strong>43.</strong></td>
            </tr>
            <tr>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-right">&nbsp;</td>
              <td colspan="2" class="border-bottom-right" style="text-align:center"><span class="border-bottom-right" style="text-align:center"><?php echo number_format($totQty_2,2);?></span></td>
              <td class="border-bottom-right" style="text-align:center"><span class="border-bottom-right" style="text-align:center"><?php echo $currency." ".number_format($totAmount_2,2);?></span></td>
              <td class="border-bottom">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="4%" class="border-bottom"><img src="../../../images/additionaldocs.png" width="35" height="69" /></td>
        <td colspan="7" height="10" class="normalfnt_size10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr height="27">
              <td colspan="2" class="border-left-fntsize10">&nbsp;<b>44.Licence No.</b></td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="6%" class="border-right-fntsize10">&nbsp;</td>
              <td width="15%" class="border-right-fntsize10">&nbsp;<b>41B. UMO &amp; Qty 2</b></td>
              <td width="18%" class="border-right">&nbsp;</td>
              <td width="13%" class="normalfnt_size10">&nbsp;<b>45. Adjustments</b></td>
            </tr>
            <tr>
              <td width="8%" class="border-left-fntsize10">&nbsp;A.D. :</td>
              <td colspan="14" class="normalfnt_size10"><?php echo $invoiceNo;?></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-right-fntsize10">&nbsp;</td>
              <td class="border-bottom-right" style="text-align:center"><?php echo ($umoqty2_2=="" ? "":number_format($umoqty2_2,2))." ".$umoqtyuint2_2;?></td>
              <td class="border-bottom-right">&nbsp;</td>
              <td class="border-bottom-fntsize10">&nbsp;</td>
            </tr>
            <tr>
              <td class="border-left-fntsize10">&nbsp;<strong>TQB :</strong></td>
              <td width="12%" class="normalfnt_size10"><strong><?php echo $TQBNo;?></strong></td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[0];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[1];?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[2];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[3];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[4];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[5];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[6];?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[7];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[8];?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[9];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[10];?></strong></td>
              <td class="border-right-fntsize10">&nbsp;</td>
              <td class="border-right-fntsize10">&nbsp;<b>41C. UMO &amp; Qty 3</b></td>
              <td colspan="2" class="normalfnt_size10" style="text-align:center"><b>46. Value (NCY)</b></td>
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
              <td class="border-bottom-right" style="text-align:center"><span class="border-bottom-right" style="text-align:center"><?php echo round(($totQty_2)/12);?></span></td>
              <td colspan="2" class="border-bottom" style="text-align:center"><span class="border-bottom" style="text-align:center"><?php echo number_format(($totAmount_2*$exRate),2)?></span></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="4%" class="border-bottom"><img src="../../../images/pkgsanddescriptionofgoods.png" width="35" height="151" /></td>
        <td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
             <?php 
		   
		$Item_3 			= "";
		$totQty_3 			= "";
		$totPrice_3 		= "";
		$totAmount_3 		= "";
		$totNetNetWeight_3 	= "";
		$totNetWeight_3 	= "";
		$totGrossWeight_3 	= "";
		$totCBM_3 			= "";
		$totPackage_3 		= "";
		$strHSCode_3 		= "";
		
					
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
			group by strHSCode
			limit ".(3+($pageCount * 3)) . ",1;";
		
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$Item_3 			= $row["noOfHSCode"];
		$totQty_3 			= $row["totQty"];
		$totPrice_3 		= $row["totPrice"];
		$totAmount_3 		= $row["totAmount"];
		$totNetNetWeight_3 	= $row["totNetNetWeight"];
		$totNetWeight_3 	= $row["totNetWeight"];
		$totGrossWeight_3 	= $row["totGrossWeight"];
		$totCBM_3 			= $row["totCBM"];
		$totPackage_3 		= $row["totPackage"];
		$strHSCode_3 		= $row["strHSCode"];
		}
	
?>
              <td width="9%" height="29" class="border-left-fntsize10">&nbsp;<strong>31.Marks &amp; Numbers</strong></td>
              <td width="2%" align="center" class="normalfnt_size10">-</td>
              <td width="17%" class="normalfnt_size10" style="text-align:center"><strong>Container No(s)</strong></td>
              <td width="2%" class="normalfnt_size10">-</td>
              <td width="14%" class="normalfnt_size10"><strong>Number and Kind</strong></td>
              <td width="9%" class="border-left-right-fntsize10">&nbsp;<strong>32.Item No</strong></td>
              <td colspan="4" class="normalfnt_size10">&nbsp;<strong>33. Commodity (HS) Code</strong></td>
            </tr>
            <tr>
              <td height="24" class="border-left">&nbsp;</td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="normalfnt_size10" style="text-align:center"><?php echo $containerNo_3;?></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="normalfnt_size10" style="text-align:center"><?php echo $noOfPackages_3." CTNS";?></td>
              <td align="center" class="border-Left-bottom-right" ><div align="center"><span class="normalfnt_size10"><?php echo "4";?></span></div></td>
              <td colspan="4" class="border-bottom">&nbsp;&nbsp;<?php echo $strHSCode_3;?></td>
            </tr>
            <tr>
              <td rowspan="7" align="left" valign="top" class="border-left"><div align="center"><strong><?php echo " AS PER INVOICE";?></strong></div></td>
              <td height="23" class="normalfnt_size10"></td>
              <td class="normalfnt_size10">Goods Description</td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>34. Ctry.of. Origin Code</strong></td>
              <td width="18%" class="border-right-fntsize10">&nbsp;<strong>35. Gross Mass (Kg)</strong></td>
              <td width="13%" class="normalfnt_size10">&nbsp;<strong>36. Preference</strong></td>
            </tr>
            <tr>
              <td height="10" class="normalfnt_size10">&nbsp;</td>
              <td colspan="3" rowspan="7" class="border-bottom-fntsize12" valign="top"><textarea name="textarea2" readonly='readonly' style='border:0px; height:140px; width:296px;overflow:hidden;
' class="normalfnt_size12"><?php echo $itemDescription_3."\n\n".$commodityCode_3."\n".$commodityCode_3;?></textarea></td>
              <td class="border-right">&nbsp;</td>
              <td width="5%" class="border-bottom-right" style="text-align:center">&nbsp;<?php echo "LK";?></td>
              <td width="10%" class="border-bottom-right">&nbsp;</td>
              <td class="border-bottom-right"><div align="center">&nbsp;<?php echo number_format($totGrossWeight_3,2);?></div></td>
              <td class="border-bottom">&nbsp;</td>
            </tr>
            <tr>
              <td height="31" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right"><?php echo ($totPackage_3!=""?$totPackage_3." CTNS":'');?></td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>37. Procedure Code</strong></td>
              <td width="18%" class="normalfnt_size10">&nbsp;<strong>38. Net Mass (Kg)</strong></td>
              <td width="13%" class="normalfnt_size10">&nbsp;<strong>39. Quota</strong></td>
            </tr>
            <tr>
              <td height="25" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right"><?php echo ($qty_3=="" ? "":round($qty_3,2).'-'.$unit_1)?></td>
              <td width="5%" class="border-bottom-right" style="text-align:center"><?php echo $procCode1_3;?></td>
              <td width="10%" class="border-bottom-right" style="text-align:center"><?php echo $procCode2_3;?></td>
              <td class="border-bottom-right" style="text-align:center"><span class="border-bottom-right" style="text-align:center"><?php echo number_format($totNetWeight_3,2);?></span></td>
              <td class="border-bottom"><div align="center"><?php echo $cat_3;?></div></td>
            </tr>
            <tr>
              <td height="22" class="normalfnt_size10">&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="4" class="normalfnt_size10">&nbsp;<strong>40. Previous Document / BL / AWB No.</strong></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="4" class="border-bottom">&nbsp;&nbsp;<?php echo $PreviousDoc_3;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
              <td colspan="2" class="border-right-fntsize10">&nbsp;<strong>41A. UMO &amp; Qty 1</strong></td>
              <td class="border-right-fntsize10">&nbsp;<strong>42. Item Price (FOB/CIF)</strong></td>
              <td class="normalfnt_size10">&nbsp;<strong>43.</strong></td>
            </tr>
            <tr>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-right">&nbsp;</td>
              <td colspan="2" class="border-bottom-right" style="text-align:center"><span class="border-bottom-right" style="text-align:center"><?php echo number_format($totQty_3,2);?></span></td>
              <td class="border-bottom-right" style="text-align:center"><span class="border-bottom-right" style="text-align:center"><?php echo $currency." ".number_format($totAmount_3,2);?></span></td>
              <td class="border-bottom">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="4%" class="border-bottom"><img src="../../../images/additionaldocs.png" width="35" height="69" /></td>
        <td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr height="27">
              <td colspan="2" class="border-left-fntsize10">&nbsp;<b>44.Licence No.</b></td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="2%" class="normalfnt_size10">&nbsp;</td>
              <td width="6%" class="border-right-fntsize10">&nbsp;</td>
              <td width="15%" class="border-right-fntsize10">&nbsp;<b>41B. UMO &amp; Qty 2</b></td>
              <td width="18%" class="border-right">&nbsp;</td>
              <td width="13%" class="normalfnt_size10">&nbsp;<b>45. Adjustments</b></td>
            </tr>
            <tr>
              <td width="8%" class="border-left-fntsize10">&nbsp;<b>A.D. :</b></td>
              <td colspan="14" class="normalfnt_size10"><?php echo $invoiceNo;?></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-right-fntsize10">&nbsp;</td>
              <td class="border-bottom-right" style="text-align:center"><?php echo ($umoqty3_2=="" ? "":number_format($umoqty3_2,2))." ".$umoqtyuint3_2;?></td>
              <td class="border-bottom-right">&nbsp;</td>
              <td class="border-bottom-fntsize10">&nbsp;</td>
            </tr>
            <tr>
              <td class="border-left-fntsize10">&nbsp;<strong>TQB :</strong></td>
              <td width="12%" class="normalfnt_size10"><strong><?php echo $TQBNo;?></strong></td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[0];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[1];?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[2];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[3];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[4];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[5];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[6];?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[7];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[8];?></strong></td>
              <td class="normalfnt_size10">&nbsp;</td>
              <td class="border-All" style="text-align:center"><strong><?php echo $chars[9];?></strong></td>
              <td class="border-top-bottom-right" style="text-align:center"><strong><?php echo $chars[10];?></strong></td>
              <td class="border-right-fntsize10">&nbsp;</td>
              <td class="border-right-fntsize10">&nbsp;<b>41C. UMO &amp; Qty 3</b></td>
              <td colspan="2" class="normalfnt_size10" style="text-align:center"><b>46. Value (NCY)</b></td>
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
              <td class="border-bottom-right" style="text-align:center"><span class="border-bottom-right" style="text-align:center"><?php echo round(($totQty_3)/12);?></span></td>
              <td colspan="2" class="border-bottom" style="text-align:center"><span class="border-bottom" style="text-align:center"><?php echo number_format(($totAmount_3*$exRate),2)?></span></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="4%" rowspan="2" class="normalfnt"><img src="../../../images/culculationoftaxes.png" /></td>
        <td height="12" class="normalfnt_size10"><table width="110%" height="171" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="16%" height="19" class="border-Left-bottom-right-fntsize10" style="text-align:center"><strong>1) Type</strong></td>
              <td width="23%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(2) Tax Base</strong></td>
              <td width="14%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(3) Rate</strong></td>
              <td width="24%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(4) Amount</strong></td>
              <td width="15%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(5) MP</strong></td>
            </tr>
            <?php
$loop			= 0;
$totAmount_1	= 0;

$sqltax="select strInvoiceNo, 
	strHScode, 
	strTaxCode, 
	intPosition, 
	dblTaxBase, 
	dblRate, 
	dblAmount, 
	intMP, 
	RecordType
	 
	from 
	excusdectax
	where strInvoiceNo='$invoiceNo' AND strHScode='$commodityCode_1'AND intPosition='$itemNo_1'";



$result_tax=$db->RunQuery($sqltax);
while($row_tax=mysql_fetch_array($result_tax))
{
	$TaxCode	= $row_tax["strTaxCode"];
	$TaxBase	= $row_tax["dblTaxBase"];
	$Rate		= $row_tax["dblRate"].'%';
	$Amount		= $row_tax["dblAmount"];
	$MP			= $row_tax["intMP"];
	$totMP_1		= 0;
	

if($loop=="10"){return;}
?>
            <tr>
              <td class="border-left-right-fntsize12" style="text-align:center"><?php //echo $TaxCode1;?></td>
              <td class="border-right-fntsize12" style="text-align:right"><?php //echo ($TaxBase=="" ? "":number_format($TaxBase,0));?>&nbsp;</td>
              <td class="border-right-fntsize12" style="text-align:center"><?php // echo number_format($Rate,2);?></td>
              <td class="border-right-fntsize12" style="text-align:right"><?php //echo number_format($Amount,0);?>&nbsp;</td>
              <td class="border-right-fntsize12" style="text-align:center"><?php // echo $MP;?></td>
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
              <td class="border-left-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12" >&nbsp;</td>
              <td class="border-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12">&nbsp;</td>
            </tr>
            <?php
}
?>
            <tr>
              <td colspan="3" align="right" class="border-All" style="text-align:center">Total&nbsp;<?php //echo (1+($i * 1))?>&nbsp;Item</td>
              <td class="border-top-bottom-right-fntsize12" style="text-align:right"><?php //echo ($totAmount_1=="" ? "":number_format($totAmount_1,2));?>&nbsp;</td>
              <td class="border-top-bottom-right" style="text-align:center"><?php //echo $totMP_1;?></td>
            </tr>
        </table></td>
        <td colspan="6"><table width="100%" height="171" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="24%" height="19" class="border-Left-bottom-right-fntsize10" style="text-align:center"><strong>1) Type</strong></td>
              <td width="22%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(2) Tax Base</strong></td>
              <td width="18%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(3) Rate</strong></td>
              <td width="22%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(4) Amount</strong></td>
              <td width="14%" class="border-bottom-fntsize10" style="text-align:center"><strong>(5) MP</strong></td>
            </tr>
            <?php
$loop			= 0;
$totAmount		= 0;

$sqltax="select 	strInvoiceNo, 
	strHScode, 
	strTaxCode, 
	intPosition, 
	dblTaxBase, 
	dblRate, 
	dblAmount, 
	intMP, 
	RecordType
	 
	from 
	excusdectax
	where strInvoiceNo='$invoiceNo' AND strHScode='$commodityCode_2'AND intPosition='$itemNo_2' ";
//die ($sqltax);

$result_tax=$db->RunQuery($sqltax);
while($row_tax=mysql_fetch_array($result_tax))
{
	$TaxCode	= $row_tax["strTaxCode"];
	$TaxBase	= $row_tax["dblTaxBase"];
	$Rate		= $row_tax["dblRate"].'%';
	$Amount		= $row_tax["dblAmount"];
	$MP			= $row_tax["intMP"];
	$totMP_2	= 0;
	
if($loop=="10"){return;}
?>
            <tr>
              <td class="border-left-right-fntsize12" style="text-align:center"><?php //echo $TaxCode;?></td>
              <td class="border-right-fntsize12" style="text-align:right"><?php //echo ($TaxBase=="" ? "":number_format($TaxBase,0));?>&nbsp;</td>
              <td class="border-right-fntsize12" style="text-align:center"><?php //echo number_format($Rate,2);?></td>
              <td class="border-right-fntsize12" style="text-align:right"><?php //echo number_format($Amount,0);?>&nbsp;</td>
              <td class="normalfnt_size12" style="text-align:center"><?php //echo $MP;?></td>
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
              <td class="border-left-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12" >&nbsp;</td>
              <td class="border-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12">&nbsp;</td>
              <td class="normalfnt_size10">&nbsp;</td>
            </tr>
            <?php
}
?>
            <tr>
              <td colspan="3" align="right" class="border-All" style="text-align:center">Total&nbsp;<?php //echo (2+($i * 2))?>&nbsp;Item</td>
              <td class="border-top-bottom-right-fntsize12" style="text-align:right"><?php //echo ($totAmount_2=="" ? "":number_format($totAmount_2,2));?>&nbsp;</td>
              <td class="border-top-bottom-fntsize12" style="text-align:center"><?php //echo $totMP_2;?></td>
              <!--<td class="border-bottom">&nbsp;</td>-->
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="12" class="normalfnt_size10"><table width="100%" height="171" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="16%" height="19" class="border-Left-bottom-right-fntsize10" style="text-align:center"><strong>1) Type</strong></td>
              <td width="23%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(2) Tax Base</strong></td>
              <td width="14%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(3) Rate</strong></td>
              <td width="24%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(4) Amount</strong></td>
              <td width="15%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>(5) MP</strong></td>
            </tr>
            <?php
$loop			= 0;
$totAmount	= 0;
$sqltax="select 	strInvoiceNo, 
	strHScode, 
	strTaxCode, 
	intPosition, 
	dblTaxBase, 
	dblRate, 
	dblAmount, 
	intMP, 
	RecordType
	 
	from 
	excusdectax
	where strInvoiceNo='$invoiceNo' AND strHScode='$commodityCode_3'AND intPosition='$itemNo_3'";

$result_tax=$db->RunQuery($sqltax);
while($row_tax=mysql_fetch_array($result_tax))
{
	$TaxCode	= $row_tax["strTaxCode"];
	$TaxBase	= $row_tax["dblTaxBase"];
	$Rate		= $row_tax["dblRate"].'%';
	$Amount		= $row_tax["dblAmount"];
	$MP			= $row_tax["intMP"];
	
	

if($loop=="10"){return;}
?>
            <tr>
              <td class="border-left-right-fntsize12" style="text-align:center"><?php //echo $TaxCode;?></td>
              <td class="border-right-fntsize12" style="text-align:right"><?php //echo ($TaxBase=="" ? "":number_format($TaxBase,0));?>&nbsp;</td>
              <td class="border-right-fntsize12" style="text-align:center"><?php //echo number_format($Rate,2);?></td>
              <td class="border-right-fntsize12" style="text-align:right"><?php //echo number_format($Amount,0);?>&nbsp;</td>
              <td class="border-right-fntsize12" style="text-align:center"><?php // echo $MP;?></td>
            </tr>
            <?php
$totAmount	+= $Amount;
$loop++;
}
for($loop;$loop<10;$loop++)
{
?>
            <tr>
              <td class="border-left-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12" >&nbsp;</td>
              <td class="border-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12">&nbsp;</td>
            </tr>
            <?php
}
?>
            <tr>
              <td colspan="3" align="right" class="border-Left-Top-right" style="text-align:center">Total&nbsp;<?php //echo (3+($i * 3))?>&nbsp;Item</td>
              <td class="border-top-right-fntsize12" style="text-align:right"><?php //echo number_format($totAmount,2);?>&nbsp;</td>
              <td class="border-top-right">&nbsp;</td>
              <!--<td class="border-bottom">&nbsp;</td>-->
            </tr>
        </table></td>
        <td colspan="6"><table width="41%" height="171" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="35%" height="19" class="border-Left-bottom-right-fntsize10" style="text-align:center"><strong> Type</strong></td>
              <td width="65%" class="border-bottom-right-fntsize10" style="text-align:center"><strong>Summary Of Taxes </strong></td>
            </tr>
            <?php 
			$loop			= 0;
			if($i+1>=$noOfPage){

$totAmount	= 0;
$sqltax="select strInvoiceNo, strHScode, strTaxCode, intPosition, dblTaxBase, dblRate,sum(dblAmount) as amount, intMP, RecordType from excusdectax where strInvoiceNo='$invoiceNo' group by strTaxCode";

$result_tax=$db->RunQuery($sqltax);
while($row_tax=mysql_fetch_array($result_tax))
{
	$TaxCode	= $row_tax["strTaxCode"];
	$totalTax	= $row_tax["amount"];
	
if($loop=="10"){return;}
?>
            <tr>
              <td class="border-left-right-fntsize12" style="text-align:center"><?php //echo $TaxCode;?></td>
              <td class="border-right-fntsize12" style="text-align:right"><?php //echo number_format($totalTax,0);?>&nbsp;</td>
            </tr>
            <?php
$totTaxAmount	+= $totalTax;
$loop++;
}
if($cusdectype==1)
{
$totTaxAmount	+=250;
$loop++;
?>
 <tr>
              <td class="border-left-right-fntsize12" style="text-align:center"><?php //echo"COM";?></td>
              <td class="border-right-fntsize12" style="text-align:right"><?php // echo number_format(250,0);?>&nbsp;</td>
            </tr>


<?php }


}
for($loop;$loop<10;$loop++)
{
?>
            <tr>
              <td class="border-left-right-fntsize12">&nbsp;</td>
              <td class="border-right-fntsize12" >&nbsp;</td>
            </tr>
            <?php
}
?>
            <tr>
              <td align="right" class="border-Left-Top-right" style="text-align:center">Total</td>
              <td align="right" class="border-top-right-fntsize12" style="text-align:right"><?php //echo number_format($totTaxAmount,2);?></td>
              <!--<td class="border-bottom">&nbsp;</td>-->
            </tr>
        </table></td>
      </tr>
    </table></td>
 </tr>
</table></td></thead></tr>
</table>
</body>
</html>
