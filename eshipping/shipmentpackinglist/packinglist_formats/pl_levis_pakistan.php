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

<body><table width="100%" border="0" cellspacing="0" cellpadding="3">
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
        <td>PL# &amp; DATE</td>
        <td><?php echo $holder_header['strPLNo']." OF ".$holder_header['strSailingDate'];?></td>
      </tr>
      <tr>
        <td>CONTRACT # </td>
        <td><?php echo $holder_header['strStyle'];?></td>
      </tr>
      <tr>
        <td>MAIN PRODUCT CODE </td>
        <td><?php echo $holder_header['strProductCode'];?></td>
      </tr>
      <tr>
        <td>PRE PACK CODE </td>
        <td><?php echo $holder_header['strPrePackCode'];?></td>
      </tr>
      <tr>
        <td>WASH CODE </td>
        <td><?php echo $holder_header['strWashCode'];?></td>
      </tr>
      <tr>
        <td>COLOUR</td>
        <td><?php echo $holder_header['strColor'];?></td>
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
      <tr>
        <td>TTL  QTY</td>
        <td><?php echo $holder_header['dblQtyPcs']."Pcs (".$holder_header['dblQtyDoz'].")Doz";?></td>
      </tr>
      <tr>
        <td>ISD # </td>
        <td><?php echo $holder_header['strISDno'];?></td>
      </tr>
      <tr>
        <td width="15%">TRANSPORT MODE</td>
        <td width="85%"><?php echo $holder_header['strTrnsportMode'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr  class="tbl-h-fnt">
        <td  nowrap="nowrap" width="0" class="border-Left-Top-right-fntsize9 tbl-h-fnt">PO NO.</td>
        <td  nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">STYLE NO.</td>
        <td width="5%" class="border-top-right-fntsize9 tbl-h-fnt">CARTON TAG#</td>
        <td width="5%" class="border-top-right-fntsize9 tbl-h-fnt">CTN NO.</td>
        <td width="5%" class="border-top-right-fntsize9 tbl-h-fnt">INSEAM</td>
        <td colspan="<?php echo $col_dyn;?>" width="0" class="border-top-right-fntsize9 tbl-h-fnt">SIZE RATIO TOTAL :</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">NO OF</td>
        
        
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">GROSS</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">NET</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">MEASURMENT</td>
      </tr>
	  
      <tr class="tbl-h-fnt">
        <td class="border-left-right-fntsize9 tbl-h-fnt" >&nbsp;</td>
        <td class="border-right-fntsize9 tbl-h-fnt" >&nbsp;</td>
        <td class="border-right-fntsize9 tbl-h-fnt" >&nbsp;</td>
        <td class="border-right-fntsize9 tbl-h-fnt" >&nbsp;</td>
        <td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td><?php while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="<?php echo $col_width.'%';?>" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td><?php }?>
        <td class="border-right-fntsize9 tbl-h-fnt">PCS</td>
        
        
        <td class="border-right-fntsize9 tbl-h-fnt">WT-<?php echo $holder_header['strUnit'];?></td>
        <td class="border-right-fntsize9 tbl-h-fnt">WT-<?php echo $holder_header['strUnit'];?></td>
        <td class="border-right-fntsize9 tbl-h-fnt">(INCH)</td>        
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
		 {$row_index=$row_row_data['intRowNo'];
		 $tot_NoofCTNS+=$row_row_data['dblNoofCTNS'];
		 ?>
         
            
            <tr class="tbl-h-fnt">
            <td class="border-Left-Top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strStyle'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strProductCode'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strColor'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblPLNoFrom'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strLength'];?></td><?php 		
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
	$col_atrray[$row_cell_data['intColumnNo']]= $row_cell_data['dblPcs'];?>
	<td class="border-top-right-fntsize9 tbl-h-fnt" style="width:25px;" nowrap="nowrap"><?php echo $col_atrray[$count];?></td>
<?php $count++;}?>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofPCZ'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></td>
            
            
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblGorss'];$tot_TotGross+=$row_row_data['dblTotGross'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNet'];$tot_TotNet+=$row_row_data['dblTotNet'];?></td>
            <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo  $holder_header['strCTNsvolume'];?></td>
           
            </tr>
            
		<?php }?> 
        <tr class="tbl-h-fnt">
              <td class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">TOTAL</td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_NoofCTNS;?></td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
              <?php for($i=0;$i<$col_dyn;$i++){?>
              <td class="<?php if($i==$col_dyn-1) echo 'border-top-right-fntsize9';else echo 'border-top';?>" ><input type="text" style="width: 25px; visibility:hidden" class="txtbox" /></td><?php }?>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><strong><?php echo $tot_QtyPcs;?></strong></td>
              
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_TotGross;?></td>
              <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_TotNet;?></td>
              <td class="border-top">&nbsp;</td>
            </tr>
		
		<tr  class="tbl-h-fnt">
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
		  <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
		  <td colspan="4" >&nbsp;</td>
		  
	    </tr>		
		<tr  class="tbl-h-fnt">
		  <td width="0" 	><input type="text" style="width: 80px; visibility:hidden" class="txtbox" /></td>
		  <td width="0" 	><input type="text" style="width: 80px; visibility:hidden" class="txtbox" /></td>
          <td width="5%" 	><input type="text" style="width: 80px; visibility:hidden" class="txtbox" /></td>
          <td width="5%" 	><input type="text" style="width: 80px; visibility:hidden" class="txtbox" /></td>
          <td width="5%" 	><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td colspan="<?php echo $col_dyn;?>"></td>
          <td ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
		  <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 100px; visibility:hidden" class="txtbox" /></td>
		  	  
	    </tr>
        <?php 
		$str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <?php }?>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td rowspan="2" class="border-Left-Top-right-fntsize9 tbl-h-fnt">STYLE NO.</td>
          <td rowspan="2"  class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
          <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL CTN </td>
          <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">INSEAM</td>
          <td colspan="<?php echo $col_dyn;?>" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL SIZE BREAKDOWN</td>
          <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL QTY</td>
          <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL GRO</td>
          <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">TOTAL NET</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="<?php echo $col_width.'%';?>" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td><?php }?>
          <td >&nbsp;</td>
        </tr>
         <?php
		$str_len="select distinct strLength, sum(dblNoofCTNS) as tot_length_ctns, sum(dblTotGross) as gross_length_weight, sum(dblTotNet) as net_length_weight from  shipmentpldetail where strPLNo='$plno' group by strLength order by intRowNo";
		$result_len= $db->RunQuery($str_len);
		while($row_len=mysql_fetch_array($result_len)){
			$length_tot=0;?>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td class="border-Left-Top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strProductCode'];?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_len['tot_length_ctns'];?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_len['strLength'];?></td>
           <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){
			    ?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $tot_pcs=size_wise_total($row_dyn['intColumnNo'],$row_len['strLength']);$length_tot+=$tot_pcs;?></td><?php }?>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $length_tot;?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_len['gross_length_weight'];?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_len['net_length_weight'];?></td>
          <td >&nbsp;</td>
         </tr>
         <?php }?>
        <tr  class="tbl-h-fnt" style="text-align:left">
          <td >&nbsp;</td>
          <td  class="border-Left-Top-right-fntsize9 tbl-h-fnt">TOTAL :</td>
          <td class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_NoofCTNS;?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>" class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
          <td  class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyPcs;?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_TotGross;?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_TotNet;?></td>
          <td >&nbsp;</td>
         </tr>
        <tr  class="tbl-h-fnt" style="text-align:left">
		  <td >&nbsp;</td>
          <td colspan="4" class="border-top">&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
		  <td colspan="3" class="border-top">&nbsp;</td>
		  <td >&nbsp;</td>
		</tr>
        <tr  class="tbl-h-fnt">
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
        </tr>
        <tr  class="tbl-h-fnt">
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
        </tr>
        <tr  class="tbl-h-fnt">
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
        </tr>
        <tr  class="tbl-h-fnt">
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
		  
	    </tr>		
		
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
function size_wise_total($obj,$length)
{
	global $db,$plno;
	$size_tot		=0;
	$str			="select dblPcs,shipmentpldetail.intRowNo from  shipmentpldetail 
left join shipmentplsubdetail on shipmentplsubdetail.strPLNo=shipmentpldetail.strPLNo and shipmentplsubdetail.intRowNo=shipmentpldetail.intRowNo
where shipmentplsubdetail.strPLNo='$plno' and shipmentpldetail.strLength='$length' and shipmentplsubdetail.intColumnNo='$obj'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=size_ctn_total($row['intRowNo'],$row['dblPcs']);
	}
	return $size_tot;
}

function size_ctn_total($row,$pcs)
{
	global $db,$plno;
	$size_tot		=0;
	$str			="select dblNoofCTNS from shipmentpldetail 
						where strPLNo='$plno' and intRowNo='$row'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=$row['dblNoofCTNS']*$pcs;
	}
	return $size_tot;
} 
?>
</body>
</html>