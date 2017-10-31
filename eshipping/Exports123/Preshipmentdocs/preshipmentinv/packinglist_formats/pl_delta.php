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
$plunit			=$holder_header["strUnit"];

$str_dyn		="select strSize from shipmentplsizeindex where strPLNo='$plno'";
$result_dyn		=$db->RunQuery($str_dyn);

$col_dyn		=mysql_num_rows($result_dyn);

$col_width		=90/($col_dyn+13);

$vol_arr=explode("X",$holder_header['strCTNsvolume']);
$mesurment=$holder_header['strCTNsvolume'];
$l=	$vol_arr[0];
$w=	$vol_arr[1];
$h=	$vol_arr[2];
$ctn_volume=$l*$w*$h;

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

<body><table width="800" border="0" cellspacing="0" cellpadding="3">
  <tr></tr>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
  </tr>

  <?php 
  $str_color_row="select strColor from shipmentpldetail where strPLNo='$plno' group by strColor order by intRowNo";
  $result_color_row=$db->RunQuery($str_color_row);
    
  while($row_clors=mysql_fetch_array($result_color_row)){
	  $colorz=$row_clors["strColor"];
	  $tot_QtyPcs=0;
	  ?>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr  class="tbl-h-fnt">
        <td colspan="2"  nowrap="nowrap" class="border-Left-Top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt">TOTAL</td>
        <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">how many ass in one carton</td>
        <td rowspan="2"  class="border-top-right-fntsize9 tbl-h-fnt">units per carton</td>
        <td rowspan="2"  class="border-top-right-fntsize9 tbl-h-fnt">COLOR CODE</td>
        <td rowspan="2"  class="border-top-right-fntsize9 tbl-h-fnt">COLOR</td>
        <td colspan="<?php echo $col_dyn;?>" width="0" class="border-top-right-fntsize9 tbl-h-fnt"> RATIO</td>
        </tr>
      <tr class="tbl-h-fnt">
        <td colspan="2" class="border-left-right-fntsize9 tbl-h-fnt" >CTN NO</td>
        <td class="border-right-fntsize9 tbl-h-fnt">CTNS</td>
        <?php 
		$str_dyn		="select strSize from shipmentplsizeindex where strPLNo='$plno'";
		$result_dyn		=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="<?php echo $col_width.'%';?>" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td>
        <?php }?>
        </tr>
      <?php 
			$bool_1st=1;
			$str_row_data="select 
							strPLNo, 
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
							where strPLNo='$plno' and strColor='$colorz'";
	  	 $result_row_data=$db->RunQuery($str_row_data);
		 
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {
			 $current_ctnno=$row_row_data['dblPLNoFrom'];
			 $row_index=$row_row_data['intRowNo'];
		?>	
	  
	  <tr class="tbl-h-fnt">
        <td class="border-Left-Top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblPLNoFrom'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblPlNoTo'];?></td>
        <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofCTNS'];$tot_NoofCTNS+=$row_row_data['dblNoofCTNS'];?></td>
                <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo 1;?></td>

        <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></td>
        <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strColor'];?></td>
        <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strColor'];?></td>
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
	$col_atrray[$row_cell_data['intColumnNo']]= $row_cell_data['dblPcs'];?>
        <td class="border-top-right-fntsize9 tbl-h-fnt" style="width:25px;" nowrap="nowrap"><?php echo $col_atrray[$count];?></td>
        <?php $count++;}?>
        </tr>
	  
	  
	  
	  <?php   }?>
      <tr class="tbl-h-fnt">
        <td class="border-top-right-fntsize9">&nbsp;</td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">TOTAL</td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_NoofCTNS;?></td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <?php for($i=0;$i<$col_dyn;$i++){?>
        <td class="border-top" ><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
        <?php }?>
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
        </tr>
      <tr  class="tbl-h-fnt">
        <td width="3%" 	><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
        <td width="3%" 	><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
        <td width="3%" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="3%" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="7%" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="7%" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="7%" ><input type="text" style="width: 100px; visibility:hidden" class="txtbox" /></td>
        <td colspan="<?php echo $col_dyn;?>" width="<?php echo $col_width*$col_dyn.'%';?>"  >&nbsp;</td>
        </tr>
     </table></td>
  </tr>
  <?php }?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
</table>

<?php
function size_wise_total($obj,$col)
{
	global $db,$plno;
	$size_tot		=0;
	$str			="select intRowNo,dblPcs from shipmentplsubdetail
						where strPLNo='$plno' and intColumnNo='$obj'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=size_ctn_total($row['intRowNo'],$row['dblPcs'],$col);
	}
	return $size_tot;
}

function size_ctn_total($row,$pcs,$col)
{
	global $db,$plno;
	$size_tot		=0;
	$str			="select dblNoofCTNS from shipmentpldetail 
						where strPLNo='$plno' and intRowNo='$row' and strColor='$col'";
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