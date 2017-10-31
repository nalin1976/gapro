<?php
session_start();
$backwardseperator = "../../../../";
$plno=$_GET['plno'];
$invoiceNo=$_GET['invoiceNo'];
include "$backwardseperator".''."Connector.php";

$str_header		="select 	shipmentplheader.strPLNo, 
							strSailingDate, 
							commercial_invoice_detail.strStyleID as strProductCode,
							commercial_invoice_detail.strBuyerPONo as strStyle,  
							commercial_invoice_detail.strFabric as inv_label, 
							commercial_invoice_detail.strConstType as pl_fabric,
							commercial_invoice_detail.strDc,
							sum(dblQtyPcs) as dblQtyPcs,
							sum(dblQtyDoz) as dblQtyDoz,
							strMaterial,							
							strLable, 
							shipmentplheader.strColor, 
							shipmentplheader.strISDno, 
							strPrePackCode, 
							strSeason, 
							strDivision, 
							strCTNsvolume, 
							strWashCode, 
							strArticle, 
							shipmentplheader.strCBM, 
							strItemNo, 
							strItem, 
							strManufactOrderNo, 
							strManufactStyle, 
							strDO, 
							strSortingType, 
							strFactory, 
							shipmentplheader.strUnit					 
							from 
							shipmentplheader
							left join shipmentpldetail on shipmentpldetail.strPLNo=shipmentplheader.strPLNo
							left join commercial_invoice_detail on commercial_invoice_detail.strPLno=shipmentplheader.strPLNo
							where
							shipmentplheader.strPLNo='$plno' and commercial_invoice_detail.strInvoiceNo='$invoiceNo' group by strPLNo";
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
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt" style="font-weight:bold">
      <tr>
        <td width="15%">DATE</td>
        <td width="85%"><?php  echo  str_replace("/",".",$holder_header['strSailingDate']);?></td>
      </tr>
      <tr>
        <td>METERIAL # </td>
        <td><?php echo $holder_header['strMaterial'];?></td>
      </tr>
      <tr>
        <td>PO</td>
        <td><?php echo $holder_header['strStyle'];?></td>
      </tr>
      <tr>
        <td>COLOR</td>
        <td><?php echo $holder_header['strColor'];?></td>
      </tr>
      <tr>
        <td>COLOR CODE</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>DIVISION</td>
        <td><?php echo $holder_header['strDivision'];?></td>
      </tr>
      <tr>
        <td>SEASON</td>
        <td><?php echo $holder_header['strSeason'];?></td>
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
        <td>ITEM NO</td>
        <td><?php echo $holder_header['strItemNo'];?></td>
      </tr>
      <tr>
        <td>ITEM</td>
        <td><?php echo $holder_header['strItem'];?></td>
      </tr>
      <tr>
        <td>TTL  QTY</td>
        <td><?php echo $holder_header['dblQtyPcs']."Pcs (".$holder_header['dblQtyDoz'].")Doz";?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr  class="tbl-h-fnt">
        <td  nowrap="nowrap" colspan="2" width="0" class="border-Left-Top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td  class="border-top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td colspan="<?php echo $col_dyn;?>" width="0" class="border-top-right-fntsize9 tbl-h-fnt"> RATIO</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">NO OF</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">NO OF</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">QTY</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">QTY</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">GROSS</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">NET</td>
        <td nowrap="nowrap" width="0" class="border-top-right-fntsize9 tbl-h-fnt">TTL GRO</td>
        <td nowrap="nowrap"width="0" class="border-top-right-fntsize9 tbl-h-fnt">TTL NET</td>
        
      </tr>
      <tr class="tbl-h-fnt">
        <td colspan="2" class="border-left-right-fntsize9 tbl-h-fnt" >CTN NO</td>
        <td class="border-right-fntsize9 tbl-h-fnt">SH</td>
        <td class="border-right-fntsize9 tbl-h-fnt">CL</td>
        <?php while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="<?php echo $col_width.'%';?>" class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td>
        <?php }?>
        <td class="border-right-fntsize9 tbl-h-fnt">PCS</td>
        <td class="border-right-fntsize9 tbl-h-fnt">CTNS</td>
        <td class="border-right-fntsize9 tbl-h-fnt">PCS</td>
        <td class="border-right-fntsize9 tbl-h-fnt">DOZ</td>
        <td class="border-right-fntsize9 tbl-h-fnt">WT-KGS</td>
        <td class="border-right-fntsize9 tbl-h-fnt">WT-KGS</td>
        <td class="border-right-fntsize9 tbl-h-fnt">WT-KGS</td>
        <td width="0" class="border-right-fntsize9 tbl-h-fnt">WT-KGS</td>
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
							where strPLNo='$plno'";
	  	 $result_row_data=$db->RunQuery($str_row_data);
		 
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {
			 $current_ctnno=$row_row_data['dblPLNoFrom'];
			 $row_index=$row_row_data['intRowNo'];
			 if($prev_ctnno==$current_ctnno){
			 
			 ?>
        <tr class="tbl-h-fnt">
        <td class="border-left-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strShade'];?></td>
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
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofPCZ'];$tot_NoofPCZ+=$row_row_data['dblNoofPCZ'];?></td>
        <td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblQtyDoz'];$tot_QtyDoz+=$row_row_data['dblQtyDoz'];?></td>
        <td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td width="0" class="border-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        </tr>        
      
	  <?php }else
	  {?>
	  
	  <tr class="tbl-h-fnt">
        <td class="border-Left-Top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblPLNoFrom'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblPlNoTo'];?></td>
        <td nowrap="nowrap" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['strShade'];?></td>
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
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofPCZ'];$tot_NoofPCZ+=$row_row_data['dblNoofPCZ'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNoofCTNS'];$tot_NoofCTNS+=$row_row_data['dblNoofCTNS'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblQtyDoz'];$tot_QtyDoz+=$row_row_data['dblQtyDoz'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblGorss'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblNet'];?></td>
        <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblTotGross'];$tot_TotGross+=$row_row_data['dblTotGross'];?></td>
        <td width="0" class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $row_row_data['dblTotNet'];$tot_TotNet+=$row_row_data['dblTotNet'];?></td>
             </tr>
	  
	  
	  
	  <?php }$prev_ctnno=$current_ctnno;}?>
      <tr class="tbl-h-fnt">
        <td colspan="4" class="border-top">&nbsp;</td>
        <?php for($i=0;$i<$col_dyn;$i++){?>
        <td class="<?php if($i==$col_dyn-1) echo 'border-top-right-fntsize9';else echo 'border-top';?>" ><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
        <?php }?>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo "TTL";?></td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_NoofCTNS;?></td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyPcs;?></td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyDoz;?></td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt">&nbsp;</td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_TotGross;?></td>
        <td class="border-top-bottom-right-fntsize9 tbl-h-fnt"><?php echo $tot_TotNet;?></td>
      </tr>
      <tr  class="tbl-h-fnt">
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
        <td colspan="5" >&nbsp;</td>
        <td colspan="4"  >&nbsp;</td>
      </tr>
      <tr  class="tbl-h-fnt">
        <td width="3%" 	><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="3%" 	><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="3%" ><input type="text" style="width: 25px; visibility:hidden" class="txtbox" /></td>
        <td width="7%" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td colspan="<?php echo $col_dyn;?>" width="<?php echo $col_width*$col_dyn.'%';?>"  >&nbsp;</td>
        <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        <td width="<?php echo $col_width.'%';?>" ><input type="text" style="width: 50px; visibility:hidden" class="txtbox" /></td>
        </tr>
     <tr  class="tbl-h-fnt">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="3" style="font-size:14px"><i>SUMMARY</i></td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="border-Left-Top-right-fntsize9 tbl-h-fnt">SIZE</td>
          <td class="border-top-right-fntsize9 tbl-h-fnt">QTY PCS</td>
          <td class="border-top-right-fntsize9 tbl-h-fnt">QTY DOZ</td>
          <td >&nbsp;</td>
        </tr>
        <?php 
		$str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <tr  class="tbl-h-fnt">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="border-Left-Top-right-fntsize9 tbl-h-fnt"><?php $tot_pcs=size_wise_total($row_dyn['intColumnNo']);echo $row_dyn['strSize'];?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_pcs;?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo number_format($tot_pcs/12,2);?></td>
          <td >&nbsp;</td>
        </tr><?php }?>
        <tr  class="tbl-h-fnt">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="border-Left-Top-right-fntsize9 tbl-h-fnt">TTL</td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyPcs;?></td>
          <td class="border-top-right-fntsize9 tbl-h-fnt"><?php echo $tot_QtyDoz;?></td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt">
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="3" class="border-top">&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt">
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
function size_wise_total($obj)
{
	global $db,$plno;
	$size_tot		=0;
	$str			="select intRowNo,dblPcs from shipmentplsubdetail
						where strPLNo='$plno' and intColumnNo='$obj'";
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