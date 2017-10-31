<?php
session_start();
$backwardseperator = "../../";
$plno=$_GET['plno'];
$xmldoc=simplexml_load_file('../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
include "$backwardseperator".''."Connector.php";

$str_header		="SELECT 	shipmentplheader.strPLNo, 
				shipmentplheader.strSailingDate, 
				shipmentplheader.strStyle, 
				SUM(dblQtyPcs) AS dblQtyPcs,
				SUM(dblNoofCTNS) AS dblNoofCTNS,
				SUM(dblQtyDoz) AS dblQtyDoz,
				SUM(dblTotGross) AS dblTotGross,
				SUM(dblTotNet) AS dblTotNet,
				SUM(dblTotNetNet) AS dblTotNetNet,
				(SELECT SUM(orderspecdetails.dblPcs) FROM orderspecdetails WHERE orderspecdetails.intOrderId=orderspec.intOrderId) AS ordpcs,
				shipmentplheader.strProductCode, 
				shipmentplheader.strMaterial, 
				shipmentplheader.strFabric, 
				shipmentplheader.strLable, 
				shipmentplheader.strColor, 
				shipmentplheader.strISDno, 
				shipmentplheader.strPrePackCode, 
				shipmentplheader.strSeason, 
				shipmentplheader.strDivision, 
				shipmentplheader.strCTNsvolume, 
				shipmentplheader.strWashCode, 
				shipmentplheader.strArticle, 
				shipmentplheader.strCBM, 
				shipmentplheader.strItemNo, 
				shipmentplheader.strItem, 
				shipmentplheader.strManufactOrderNo, 
				shipmentplheader.strManufactStyle, 
				shipmentplheader.strDO, 
				shipmentplheader.strSortingType, 
				shipmentplheader.strFactory, 
				shipmentplheader.strUnit,
				shipmentplheader.strTrnsportMode,
				shipmentplheader.strMarksNos,
				buyers.strName AS buyerName,
				buyers.strAddress1 AS buyerAddress1,
				buyers.strAddress2 AS buyerAddress2,
				buyers.strCountry AS buyerCountry				 
				FROM 
				shipmentplheader
				INNER JOIN shipmentpldetail ON shipmentpldetail.strPLNo=shipmentplheader.strPLNo
				INNER JOIN orderspec ON shipmentplheader.strStyle = orderspec.strOrder_No
				INNER JOIN buyers ON buyers.strBuyerID = shipmentplheader.strShipTo
				where
				shipmentplheader.strPLNo='$plno' group by strPLNo";
$result_header	=$db->RunQuery($str_header);
$holder_header	=mysql_fetch_array($result_header);

$str_dyn		="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno'";
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
<table width="1147" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="12" style="text-align:center" class="normalfnBLD1">PACKING LIST</td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td width="101">&nbsp;</td>
    <td width="161">&nbsp;</td>
    <td width="124">&nbsp;</td>
    <td width="80">&nbsp;</td>
    <td width="52">&nbsp;</td>
    <td width="95">&nbsp;</td>
    <td width="103">&nbsp;</td>
    <td width="132">&nbsp;</td>
    <td width="129">&nbsp;</td>
    <td width="90">&nbsp;</td>
    <td width="60">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td rowspan="5" valign="top"><img src="../../images/callogo.jpg" /></td>
    <td colspan="2" class="normalfnt">EAM MALIBAN TEXTLIES (PVT) LTD</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt"><u>SHIP TO</u></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnt">PINNAWALA ROAD, BALANGODA</td>
    <td colspan="4" rowspan="4">&nbsp;</td>
    <td colspan="3" class="normalfnt"><?php echo $holder_header['buyerName']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnt">SRI LANKA</td>
    <td colspan="3" class="normalfnt"><?php echo $holder_header['buyerAddress1']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3" class="normalfnt"><?php echo $holder_header['buyerAddress2']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3" class="normalfnt"><?php echo $holder_header['buyerCountry']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="normalfnt"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnt" style="text-align:center"><u>DESCRIPTION</u></td>
    <td colspan="4" class="normalfnt"><?php $holder_header['strLable']; ?></td>
    <td>&nbsp;</td>
    <td class="normalfnt"><u>SHIPMENT DATE</u></td>
    <td class="normalfnt"><?php echo $holder_header['strSailingDate']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="border-top-left" style="text-align:center">TOTAL ORDER QTY</td>
    <td class="border-Left-Top-right" style="text-align:center"><?php echo round($holder_header['ordpcs'],0); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="border-Left-Top-right" style="text-align:center" bgcolor="#CCCCCC"><u>PO NO</u></td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="border-Left-Top-right" style="text-align:center" bgcolor="#CCCCCC"><u>STYLE NO</u></td>
    <td>&nbsp;</td>
    <td class="border-top-left" style="text-align:center" bgcolor="#CCCCCC"><u>TTL CTN</u></td>
    <td class="border-Left-Top-right" style="text-align:center" bgcolor="#CCCCCC"><u>TTL PCS</u></td>
    <td class="normalfnt">&nbsp;</td>
    <td class="border-top-left" style="text-align:center">TOTAL SHIP QTY</td>
    <td class="border-Left-Top-right" style="text-align:center"><?php echo $holder_header['dblQtyPcs']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="border-Left-bottom-right" style="text-align:center" bgcolor="#CCCCCC"><?php echo $holder_header['strStyle']; ?></td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="border-Left-bottom-right" style="text-align:center" bgcolor="#CCCCCC"><?php echo $holder_header['strProductCode']; ?></td>
    <td>&nbsp;</td>
    <td class="border-bottom-left" style="text-align:center" bgcolor="#CCCCCC"><?php echo $holder_header['dblNoofCTNS']; ?></td>
    <td class="border-Left-bottom-right" style="text-align:center" bgcolor="#CCCCCC"><?php echo $holder_header['dblQtyPcs']; ?></td>
    <td class="normalfnt">&nbsp;</td>
    <td class="border-top-left" style="text-align:center">SHIP %</td>
    <td class="border-Left-Top-right" style="text-align:center"><?php echo round(($holder_header['dblQtyPcs']/$holder_header['ordpcs'])*100,2); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="10"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3" rowspan="2" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">CTN NO</td>
        <td width="" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">ALU NO</td>
        <td width="" rowspan="2" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">COLOUR</td>
        <td width="" colspan="<?php echo $col_dyn;?>" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">SIZE</td>
        <td width="" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">PCS PER</td>
        <td width="" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">NO OF</td>
        <td width="" bgcolor="#CCCCCC" class="border-Left-Top-right" style="text-align:center">NO OF</td>
      </tr>
      <tr>
        <td class="border-left" style="text-align:center" bgcolor="#CCCCCC">NO'S</td>
        <?php 
		$result_dyn		=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td class="border-top-left" style="text-align:center" bgcolor="#CCCCCC" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td><?php }?>
        <td class="border-left" style="text-align:center" bgcolor="#CCCCCC">CTN</td>
        <td class="border-left" style="text-align:center" bgcolor="#CCCCCC">CTN</td>
        <td class="border-left-right" style="text-align:center" bgcolor="#CCCCCC">PCS</td>
      </tr>
      <?php $str_row_data="select 	strPLNo, 
								intRowNo, 
								dblPLNoFrom, 
								dblPlNoTo,
								strTagNo, 
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
								dblTotNetNet,
								strCartoon
								 
								from 
								shipmentpldetail 
								left join cartoon on cartoon.intCartoonId=shipmentpldetail.strCTN
								where strPLNo='$plno'
								order by dblPLNoFrom ";
	  	 $result_row_data=$db->RunQuery($str_row_data);
		 
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {$row_index=$row_row_data['intRowNo']?>

      <tr>
        <td width="5%" bgcolor="" class="border-top-left" style="text-align:center"><?php echo $row_row_data['dblPLNoFrom'];?></td>
        <td width="2%" bgcolor="" class="border-top-left" style="text-align:center">-</td>
        <td width="5%" bgcolor="" class="border-top-left" style="text-align:center"><?php echo $row_row_data['dblPlNoTo'];?></td>
        <td width="" class="border-top-left" style="text-align:center" bgcolor="">&nbsp;</td>
        <td width="" bgcolor="" class="border-top-left" style="text-align:center"><?php echo $row_row_data['strColor'];?></td>
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
	$col_atrray[$row_cell_data['intColumnNo']]= $row_cell_data['dblPcs'];	
	$col_atrray_tot[$row_cell_data['intColumnNo']]+= $row_cell_data['dblPcs']*$row_row_data['dblNoofCTNS'];	
	$col_atrray_sum[$prepack][$row_row_data['strColor']][$row_cell_data['intColumnNo']]+= $row_cell_data['dblPcs'];	
	$col_array_sum[$row_row_data['strColor']][$row_cell_data['intColumnNo']]+= $row_cell_data['dblPcs']*$row_row_data['dblNoofCTNS'];
	
	?>
          
        <td width="" class="border-top-left" style="text-align:center" bgcolor="" nowrap="nowrap"><?php echo $col_atrray[$count];?></td>
        <?php $count++;}?>
        <td width="5%" class="border-top-left" style="text-align:center" bgcolor="">&nbsp;</td>
        <td width="5%" class="border-top-left" style="text-align:center" bgcolor=""><?php echo $row_row_data['dblNoofCTNS'];$tot_NoofCTNS+=$row_row_data['dblNoofCTNS'];?></td>
        <td width="5%" class="border-Left-Top-right" style="text-align:center" bgcolor=""><?php echo $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="5" bgcolor="" class="border-top" style="text-align:center">&nbsp;</td>
        <?php for($i=0;$i<$col_dyn;$i++){?>
              <td class="<?php if($i==$col_dyn-1) echo 'border-top';else echo 'border-top';?>" >&nbsp;</td><?php }?>
        <td class="border-top" style="text-align:center" bgcolor="">&nbsp;</td>
        <td class="border-top-bottom-left" style="text-align:center" bgcolor="#CCCCCC"><?php echo $tot_NoofCTNS;?></td>
        <td class="border-All" style="text-align:center" bgcolor="#CCCCCC"><?php echo $tot_QtyPcs; ?></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="10" class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="10" ><table width="80%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" class="normalfnt"><u>SUMMARY</u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">CTN NO</td>
        <td width="" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">ALU NO</td>
        <td width="" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">COLOUR</td>
        <?php 
		$result_dyn		=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="" bgcolor="#CCCCCC" class="border-top-left" nowrap="nowrap" style="text-align:center"><?php echo $row_dyn['strSize'];?></td><?php }?>
        <td width="" bgcolor="#CCCCCC" class="border-Left-Top-right" style="text-align:center">TTL</td>
      </tr>
      <?php 
		
		$str_row_data="SELECT dblPLNoFrom,
							MAX(dblPlNoTo) as dblPlNoTo,
							strColor ,
							SUM(dblQtyPcs) as dblQtyPcs
							FROM shipmentpldetail 
							WHERE strPLNo='$plno' 
							GROUP BY strColor order by dblPLNoFrom";
	  	 $result_row_data=$db->RunQuery($str_row_data);
		 $row_tot=0;
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {		
		 	 			
			 $row_tot+=$row_row_data['dblQtyPcs']; 
			 $row_index=$row_row_data['intRowNo']?>
      <tr>
        <td width="5%" bgcolor="" class="border-top-left" style="text-align:center"><?php echo $row_row_data['dblPLNoFrom'];?></td>
        <td width="2%" bgcolor="" class="border-top-left" style="text-align:center">-</td>
        <td width="5%" bgcolor="" class="border-top-left" style="text-align:center"><?php echo $row_row_data['dblPlNoTo'];?></td>
        <td bgcolor="" class="border-top-left" style="text-align:center">&nbsp;</td>
        <td bgcolor="" class="border-top-left" style="text-align:center"><?php echo $row_row_data['strColor'];?></td>
        <?php 		
					
		$result_dyn		=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn))	
		
		{?>
	<td class="border-top-left" style="text-align:center" nowrap="nowrap"><?php echo  $col_atrray_sum[$prepack][$row_row_data['strColor']][$row_dyn['intColumnNo']];
		?></td>
<?php $count++;}?>
        <td bgcolor="" class="border-Left-Top-right" style="text-align:center" width="5%"><?php echo $row_row_data['dblQtyPcs'];?></td>
      </tr>
      
      <?php } ?>
      <tr>
        <td bgcolor="" class="border-top" style="text-align:center">&nbsp;</td>
        <td bgcolor="" class="border-top" style="text-align:center">&nbsp;</td>
        <td bgcolor="" class="border-top" style="text-align:center">&nbsp;</td>
        <td bgcolor="" class="border-top" style="text-align:center">&nbsp;</td>
        <?php for($i=0;$i<$col_dyn;$i++){?>
              <td class="<?php if($i==$col_dyn-1) echo 'border-top';else echo 'border-top';?>" >&nbsp;</td><?php }?>
        <td class="border-top" style="text-align:center" nowrap="nowrap">&nbsp;</td>
        <td bgcolor="" class="border-All" style="text-align:center"><?php echo $row_tot;?></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="10" class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="normalfnt">CARTON DIMENSIONS:(INCH)</td>
    <td class="normalfnt" style="text-align:center">CTNS</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">CBM</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
		$str_ctns="SELECT (intWidth*intLength*intHeight*SUM(dblNoofCTNS)*.0000164) AS totCBM,strCartoon,sum(dblNoofCTNS) as dblNoofCTNS 
					FROM shipmentpldetail SPD
					INNER JOIN cartoon CTN ON CTN.intCartoonId=  SPD.strCTN
					WHERE strPLNo=$plno group by strCartoon";
		$result_cdn=$db->RunQuery($str_ctns);
		while($row_cdn=mysql_fetch_array($result_cdn))
		{?>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="normalfnt" style="text-align:center"><?php echo $row_cdn['strCartoon'];?></td>
    <td class="normalfnt" style="text-align:center"><?php echo $row_cdn['dblNoofCTNS'];$tot_ctns+=$row_cdn['dblNoofCTNS'];?></td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center"><?php echo number_format($row_cdn['totCBM'],2);$tot_cbm+=number_format($row_cdn['totCBM'],2);?></td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="normalfnt" style="text-align:center">TOTAL</td>
    <td class="border-top-bottom" style="text-align:center"><?php echo $tot_ctns;?></td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="border-top-bottom" style="text-align:center"><?php echo number_format($tot_cbm,2);?></td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="border-top" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="border-top" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="normalfnt">GROSS WEIGHT :</td>
    <td class="normalfnt" style="text-align:center"><?php echo round($holder_header['dblTotGross'],2)." ".$holder_header['strUnit'];?></td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="normalfnt">NET WEIGHT :</td>
    <td class="normalfnt" style="text-align:center"><?php echo round($holder_header['dblTotNet'],2); echo " ".$holder_header['strUnit'];?></td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>