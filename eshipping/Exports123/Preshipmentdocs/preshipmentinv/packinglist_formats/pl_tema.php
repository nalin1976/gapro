<?php
session_start();
$backwardseperator = "../../";
$plno=$_GET['plno'];
include "$backwardseperator".''."Connector.php";

$str_header		="select 	shipmentplheader.strPLNo, 
							strSailingDate, 
							strStyle, 
							sum(dblQtyPcs) as dblQtyPcs,
							sum(dblQtyDoz) as dblQtyDoz,
							strProductCode, 
							strMaterial, 
							strFabric, 
							strLable, 
							shipmentplheader.strColor, 
							strISDno, 
							strPrePackCode, 
							strSeason, 
							strDivision, 
							strCTNsvolume, 
							strWashCode, 
							strArticle, 
							strCBM, 
							strItemNo, 
							strItem, 
							strManufactOrderNo, 
							strManufactStyle, 
							strDO, 
							strSortingType, 
							strFactory, 
							strUnit,
							strTrnsportMode				 
							from 
							shipmentplheader
							left join shipmentpldetail on shipmentpldetail.strPLNo=shipmentplheader.strPLNo
							
							where
							shipmentplheader.strPLNo='$plno' group by strPLNo";
$result_header	=$db->RunQuery($str_header);
$holder_header	=mysql_fetch_array($result_header);

$str_dyn		="select strSize from shipmentplsizeindex where strPLNo='$plno'";
$result_dyn		=$db->RunQuery($str_dyn);

$col_dyn		=mysql_num_rows($result_dyn);

$col_width		=90/($col_dyn+13);

$vol_arr=explode("X",$holder_header['strCTNsvolume']);
$l=	$vol_arr[0];
$w=	$vol_arr[1];
$h=	$vol_arr[2];
$ctn_volume=round($l*$w*$h*.0000164,2);	   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Packing List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style >
.tbl-h-fnt{
	font-family:Verdana;
	font-size:9px;
	font-weight:bold;
	text-align:center;
	line-height:18px;
}

</style>
</head>

<body><table width="1000" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="font-family:Verdana;font-size:22px;text-align:center;font-weight:700" bgcolor="#D6D6D6"><u>ORIT  TRADING LANKA PVT (LTD)</u></td>
      </tr>
      <tr>
        <td style="font-family:Verdana;font-size:18px;text-align:center;font-weight:700" bgcolor="#D6D6D6" height="35"><u>SEETHAWAKA AVISSAWELLA</u></td>
      </tr>
      <tr>
        <td style="font-family:Verdana;font-size:18px;text-align:center;font-weight:200" ><i> PACKING/ WEIGHT LIST&nbsp;</i></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt" style="font-weight:bold">
      <tr>
        <td width="15%">PL# &amp; DATE</td>
        <td width="85%"><?php echo $holder_header['strPLNo']." OF ".$holder_header['strSailingDate'];?></td>
      </tr>
      <tr>
        <td>CONTRACT # </td>
        <td><?php echo $holder_header['strStyle'];?></td>
      </tr>
      <tr>
        <td>TEMA SPECIAL CODE </td>
        <td><?php echo $holder_header['strArticle'];?></td>
      </tr>
      <tr>
        <td>MAIN PRODUCT CODE </td>
        <td><?php echo $holder_header['strProductCode'];?></td>
      </tr>
      <tr>
        <td>FABRIC</td>
        <td><?php echo $holder_header['strFabric'];?></td>
      </tr>
      <tr>
        <td>LABEL</td>
        <td><?php echo $holder_header['strLable'];?></td>
      </tr>
      <tr>
        <td>ITEM</td>
        <td><?php echo $holder_header['strItem'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr  class="tbl-h-fnt">
        <td  nowrap="nowrap" colspan="2" width="0" class="border-Left-Top-right-fntsize9 tbl-h-fnt">CTN NO</td>
        <td width="5%" class="border-top-right-fntsize9 tbl-h-fnt">SH</td>
        <td width="5%" rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TEMA ORDER NO</td>
        <td width="5%" rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TEMA SPECIAL CODE</td>
        <td width="5%" class="border-top-right-fntsize9 tbl-h-fnt">COLOUR</td>
        <td width="5%" rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TEMA STYLE NAME</td>
        <td width="5%" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap">DESCRIPTION OF GOODS</td>
        <td colspan="<?php echo $col_dyn;?>" width="0" class="border-top-right-fntsize9 tbl-h-fnt">RATIO</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">NO OF</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">NO OF</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">QTY</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">QTY</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">GROSS</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">NET</td>
        <td colspan="3" nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt">MEASUREMENT</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">TTL GRO</td>
        <td nowrap="nowrap"width="0" class="border-top-right-fntsize9 tbl-h-fnt">TTL NET</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL</td>
      </tr>
	  
      <tr class="tbl-h-fnt">
        <td colspan="2" class="border-left-right-fntsize9 tbl-h-fnt" >&nbsp;</td>
        <td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
		<td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
		<td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
		<?php while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="<?php echo $col_width.'%';?>" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td><?php }?>
        <td class="border-right-fntsize9 tbl-h-fnt">PCS</td>
        <td class="border-right-fntsize9 tbl-h-fnt">CTNS</td>
        <td class="border-right-fntsize9 tbl-h-fnt">PCS</td>
        <td class="border-right-fntsize9 tbl-h-fnt">DOZ</td>
        <td class="border-right-fntsize9 tbl-h-fnt">WT-<?php echo $holder_header['strUnit'];?></td>
        <td class="border-right-fntsize9 tbl-h-fnt">WT-<?php echo $holder_header['strUnit'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt">L(INCH)</td>
        <td width="0" class="border-top-right-fntsize9 tbl-h-fnt">W(INCH)</td>
        <td width="0" class="border-top-right-fntsize9 tbl-h-fnt">H(INCH)</td>
        <td class="border-right-fntsize9 tbl-h-fnt">WT-<?php echo $holder_header['strUnit'];?></td>
        <td width="0" class="border-right-fntsize9 tbl-h-fnt">WT-<?php echo $holder_header['strUnit'];?></td>
        <td width="0" class="border-right-fntsize9 tbl-h-fnt">MEASUREMENT</td>
        </tr>
        <?php $str_row_data="select 	strPLNo, 
								intRowNo, 
								dblPLNoFrom, 
								dblPlNoTo, 
								strShade, 
								strColor, 
								strLength,
								dblNoofPCZ, 
								dblNoofCTNS, 
								dblQtyPcs, 
								dblQtyDoz, 
								dblGorss, 
								dblNet, 
								dblNetNet, 
								dblTotGross, 
								dblTotNet, 
								dblTotNetNet
								 
								from 
								shipmentpldetail 
								where strPLNo='$plno'";
	  	 $result_row_data=$db->RunQuery($str_row_data);
		 
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {$row_index=$row_row_data['intRowNo']?>
         
            
            <tr class="tbl-h-fnt">
            <td class="border-Left-Top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblPLNoFrom'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblPlNoTo'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strShade'];?></td>
			<td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strStyle'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strArticle'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strColor'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strProductCode'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strItem'];?></td>
			<?php 		
					$str_cell_data="select 	ssi.strPLNo, 
											ssi.intColumnNo, 
											ssi.strSize,
											ssd.intRowNo,
											ssd.dblPcs											
											from 
											shipmentplsizeindex ssi
											left join shipmentplsubdetail ssd
											on ssi.intColumnNo=ssd.intColumnNo and ssi.strPLNo=ssd.strPLNo
											where ssi.strPLNo='$plno' and ssd.intRowNo='$row_index' order by ssi.intColumnNo";
				 
				 $result_cell_data=$db->RunQuery($str_cell_data);
				 $count=0;
				 unset($col_atrray); 
while(($row_cell_data=mysql_fetch_array($result_cell_data))|| ($count<$col_dyn))
{
	$col_atrray[$row_cell_data['intColumnNo']]= $row_cell_data['dblPcs']*$row_row_data['dblNoofCTNS'];?>
	<td class="border-top-right-fntsize9 tbl-h-fnt" style="width:25px;" nowrap="nowrap"><?php echo $col_atrray[$count];?></td>
<?php $count++;}?>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofPCZ'];$tot_NoofPCZ+=$row_row_data['dblNoofPCZ'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofCTNS'];$tot_NoofCTNS+=$row_row_data['dblNoofCTNS'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblQtyDoz'];$tot_QtyDoz+=$row_row_data['dblQtyDoz'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblGorss'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNet'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $l;?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $w;?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $h;?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblTotGross'];$tot_TotGross+=$row_row_data['dblTotGross'];?></td>
            <td width="0" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblTotNet'];$tot_TotNet+=$row_row_data['dblTotNet'];?></td>
            <td width="0" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $cbm=number_format($ctn_volume*$row_row_data['dblNoofCTNS'],2);$tot_ctn_volume+=$cbm;?></td>
            </tr>
            
		<?php }?> 
        <tr class="tbl-h-fnt">
              <td colspan="8" class="border-top">&nbsp;</td>
              <?php for($i=0;$i<$col_dyn;$i++){?>
              <td class="<?php if($i==$col_dyn-1) echo 'border-top-right-fntsize9';else echo 'border-top';?>" ><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td><?php }?>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo "TTL";?></td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_NoofCTNS;?></td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyPcs;?></td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyDoz;?></td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_TotGross;?></td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_TotNet;?></td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_ctn_volume;?></td>
            </tr>
		
		<tr  class="tbl-h-fnt">
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
		  <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td colspan="8"  >&nbsp;</td>
	    </tr>		
		<tr  class="tbl-h-fnt">
		  <td width="0" 	><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
		  <td width="0" 	><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
          
          <td width="5%" 	><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
          <td width="5%" 	><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
          <td width="5%" 	><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
          <td width="5%" 	><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
          <td width="5%" 	><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td ><input type="text" style="width: 25px; visibility:hidden" class="txtbox" /></td>
		  <td colspan="<?php echo $col_dyn;?>" width="<?php echo $col_width*$col_dyn.'%';?>"  >&nbsp;</td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" ></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 20px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 20px; visibility:hidden" class="txtbox" /></td>
		  <td nowrap="nowrap" width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 20px; visibility:hidden" class="txtbox" /></td>
          <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td nowrap="nowrap" width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 80px; visibility:hidden" class="txtbox" /></td>
	    </tr>
        <?php 
		$str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <?php }?>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="border-Left-Top-right-fntsize9 tbl-h-fnt">COLOUR</td>
          <td colspan="<?php echo $col_dyn;?>" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL SIZE BREAKDOWN</td>
          <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL PCS</td>
          <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL CTN</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="border-Left-Top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strColor'];?></td>
          <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="<?php echo $col_width.'%';?>" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td><?php }?>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td  class="border-Left-Top-right-fntsize9 tbl-h-fnt">PO QTY </td>
          <?php 
		  $str_dyn="select dblPcs,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="<?php echo $col_width.'%';?>" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['dblPcs'];?></td><?php }?>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"></span></td>
          <td  class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td  class="border-Left-Top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
          <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $tot_pcs=size_wise_total($row_dyn['intColumnNo'],"0");?></td><?php }?>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo shade_wise_tot_pcs("0");?></td>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo shade_wise_tot_ctns("0");?></td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td  class="border-Left-Top-right-fntsize9 tbl-h-fnt">MIX SHADE (R)</td>
         <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $tot_pcs=size_wise_total($row_dyn['intColumnNo'],"1");?></td><?php }?>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo shade_wise_tot_pcs("1");;?></td>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo shade_wise_tot_ctns("1");;?></td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td  class="border-Left-Top-right-fntsize9 tbl-h-fnt">MIX SHADE (O/R)</td>
          <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $tot_pcs=size_wise_total($row_dyn['intColumnNo'],"2");?></td><?php }?>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo shade_wise_tot_pcs("2");;?></td>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo shade_wise_tot_ctns("2");;?></td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td  class="border-Left-Top-right-fntsize9 tbl-h-fnt">SHIPPED QTY</td>
          <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $tot_pcs=size_wise_total($row_dyn['intColumnNo'],'');?></td><?php }?>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyPcs;?></td>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_NoofCTNS;?></td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td class="border-top">&nbsp;</td>
		  <td colspan="<?php echo $col_dyn;?>" class="border-top">&nbsp;</td>
		  <td class="border-top">&nbsp;</td>
		  <td class="border-top">&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
	    </tr>
		
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
function size_wise_total($obj,$mix)
{
	global $db,$plno;
	$size_tot		=0;
	$str			="select intRowNo,dblPcs from shipmentplsubdetail
						where strPLNo='$plno' and intColumnNo='$obj'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=size_ctn_total($row['intRowNo'],$row['dblPcs'],$mix);
	}
	return $size_tot;
}

function size_ctn_total($row,$pcs,$mix)
{
	if($mix=="0")
	{
		$mix="and strShade=''";
	}
	else if($mix=="1")
	{
		$mix="and strShade='mix'";
	}
	else if($mix=="2")
	{
		$mix=" and strShade!='mix' and strShade!=''";
	}
	global $db,$plno;
	$size_tot		=0;
	$str			="select dblNoofCTNS from shipmentpldetail 
						where strPLNo='$plno' and intRowNo='$row' ";
						
	
	$str.=$mix;
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=$row['dblNoofCTNS']*$pcs;
	}
	return $size_tot;
} 

function shade_wise_tot_ctns($mix)
{
	if($mix=="0")
	{
		$mix="and strShade=''";
	}
	else if($mix=="1")
	{
		$mix="and strShade='mix'";
	}
	else if($mix=="2")
	{
		$mix="and strShade!='mix' and strShade!=''";
	}
	global $db,$plno;
	$shade_tot		=0;
	$str			="select sum(dblNoofCTNS) as CTNS from shipmentpldetail 
						where strPLNo='$plno' ";
						
	$str.=$mix;
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$shade_tot+=$row['CTNS'];
	}
	return $shade_tot;
} 

function shade_wise_tot_pcs($mix)
{
	if($mix=="0")
	{
		$mix="and strShade=''";
	}
	else if($mix=="1")
	{
		$mix="and strShade='mix'";
	}
	else if($mix=="2")
	{
		$mix="and strShade!='mix' and strShade!=''";
	}
	
	global $db,$plno;
	$shade_tot		=0;
	$str			="select sum(dblQtyPcs) as PCS from shipmentpldetail 
						where strPLNo='$plno' ";
						
	
	$str.=$mix;
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$shade_tot+=$row['PCS'];
	}
	return $shade_tot;
} 
?>
</body>
</html>