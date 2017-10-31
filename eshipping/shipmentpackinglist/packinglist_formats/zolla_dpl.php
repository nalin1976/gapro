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

<body>
<table width="850" border="0" cellspacing="0" cellpadding="4" class="normalfnt">
  <tr>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:24px" height="35" bgcolor="#CCCCCC">ORIT TRADING LANKA (PVT) LTD</td>
      </tr>
      <tr>
        <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:12px" height="20" bgcolor="#999999">07-02, East Tower, World Trade Centre, Echelon Square, Colombo 01, Sri Lanka. Tel: 0094-111-2346370    Fax:0094-111-2346376</td>
      </tr>
      <tr>
        <td style="font-family:Verdana;font-size:18px;text-align:center;font-weight:200" ><i> DETAILED PACKING LIST&nbsp;</i></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> <strong>INVOICE No.</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Date</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Contract No.</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Date</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Order No.</strong></td>
    <td>&nbsp;</td>
    <td><strong>Order date</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Specification No.</strong></td>
    <td>&nbsp;</td>
    <td><strong>Specification Date</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr style="background-color:#CCC">
        <td rowspan="2"  class="border-Left-Top-right-fntsize9 tbl-h-fnt">ARTICLE</td>
        <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt">COLOR</td>
        <td rowspan="2" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap">Carton/<br />
          Bar code<br /> Number</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt" colspan="<?php echo $col_dyn;?>">SIZE</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt">TOTAL</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt">QTY OF</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt">TOTAL</td>
      </tr>
      <tr>
        
        <?php while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td class="border-top-right-fntsize9 tbl-h-fnt" style="background-color:#CCC" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td><?php }?>
        <td class="border-top-right-fntsize9 tbl-h-fnt" style="background-color:#CCC">PCS/CTN</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt" style="background-color:#CCC">CTN</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt" style="background-color:#CCC">QTY/ART</td>
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
								strTagNo, 
								dblTotNetNet
								 
								from 
								shipmentpldetail 
								where strPLNo='$plno'";
	  	 $result_row_data=$db->RunQuery($str_row_data);
		 
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {$row_index=$row_row_data['intRowNo'];
		 $tot_NoofCTNS+=$row_row_data['dblNoofCTNS'];
		 $row_gross_wt=0;
		 $row_net_wt  =0;
		 ?>
      
       <tr>
        <td  class="border-Left-Top-right-fntsize9 tbl-h-fnt"><?php echo $holder_header['strStyle'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strColor'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strTagNo'];?></td>
        <?php 		
					$str_cell_data="select 	ssi.strPLNo, 
											ssi.intColumnNo, 
											ssi.strSize,
											ssi.dblGross,
											ssi.dblNet,
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
	$row_gross_wt+=$row_cell_data['dblPcs']*$row_cell_data['dblGross'];
	$row_net_wt  +=$row_cell_data['dblPcs']*$row_cell_data['dblNet'];
	$col_atrray[$row_cell_data['intColumnNo']]= $row_cell_data['dblPcs'];?>
	<td class="border-top-right-fntsize9 tbl-h-fnt" style="width:25px;" nowrap="nowrap"><?php echo $col_atrray[$count]; ?></td>
<?php $count++;}?>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofPCZ'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofCTNS'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></td>
      </tr><?php }?>
       <tr>
         <td  class="border-top-left-fntsize9 tbl-h-fnt">TOTAL</td>
         <td class="border-top tbl-h-fnt">&nbsp;</td>
         <td class="border-top tbl-h-fnt">&nbsp;</td>
         <td class="border-top-right-fntsize9 tbl-h-fnt"  colspan="<?php echo $col_dyn;?>">&nbsp;</td>
         <td class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
         <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_NoofCTNS;?></td>
         <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyPcs;?></td>
       </tr>
      <tr>
        <td  class="border-top tbl-h-fnt">&nbsp;</td>
        <td  class="border-top tbl-h-fnt">&nbsp;</td>
        <td  class="border-top tbl-h-fnt">&nbsp;</td>
        <td  class="border-top tbl-h-fnt" colspan="<?php echo $col_dyn;?>">&nbsp;</td>
        <td  class="border-top tbl-h-fnt">&nbsp;</td>
        <td  class="border-top tbl-h-fnt">&nbsp;</td>
        <td  class="border-top tbl-h-fnt">&nbsp;</td>
      </tr>
      <tr>
        <td ><input type="text" style="width: 100px; visibility:hidden" class="txtbox" /></td>
        <td ><input type="text" style="width: 100px; visibility:hidden" class="txtbox" /></td>
        <td ><input type="text" style="width: 100px; visibility:hidden" class="txtbox" /></td>
        <?php for($i=0;$i<$col_dyn;$i++){?>
              <td ><input type="text" style="width: 25px; visibility:hidden" class="txtbox" /></td><?php }?>
        <td ><input type="text" style="width: 60px; visibility:hidden" class="txtbox" /></td>
        <td ><input type="text" style="width: 60px; visibility:hidden" class="txtbox" /></td>
        <td ><input type="text" style="width: 60px; visibility:hidden" class="txtbox" /></td>
        </tr>
      
      <tr>
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
    <td>Total net weight:</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total gross weight:</td>
    <td>&nbsp;</td>
    <td>Name:</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total No. of cartons:</td>
    <td><strong><?php echo $tot_NoofCTNS;?></strong></td>
    <td>Position:</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total Volume:</td>
    <td><strong><?php echo  $holder_header['strCTNsvolume'];?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>(Signature, Stamp)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
</table>
</body>
</html>