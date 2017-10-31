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
				ROUND(SUM(dblTotGross),2) AS dblTotGross,
				ROUND(SUM(dblTotNet),2) AS dblTotNet,
				ROUND(SUM(dblTotNetNet),2) AS dblTotNetNet,
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
				shipmentplheader.intMulYes,
				customers.strName,
				customers.strMLocation,
				customers.strAddress1,
				customers.strAddress2,
				customers.strCountry,
				customers.strEMail,
				customers.strFax,
				customers.strPhone,
				shipmentplheader.strShipTo,
				shipmentplheader.strInvNo			 
				FROM 
				shipmentplheader
				INNER JOIN shipmentpldetail ON shipmentpldetail.strPLNo=shipmentplheader.strPLNo
				INNER JOIN orderspec ON shipmentplheader.strStyle = orderspec.strOrder_No
				INNER JOIN customers ON customers.strCustomerID = shipmentplheader.strFactory
							where
							shipmentplheader.strPLNo='$plno' group by strPLNo";
$result_header	=$db->RunQuery($str_header);
//echo $str_header;
$holder_header	=mysql_fetch_array($result_header);

$myValue=$holder_header['intMulYes'];

$str_dyn		="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno'";

$result_dyn		=$db->RunQuery($str_dyn);
//echo $str_dyn;
$col_dyn		=mysql_num_rows($result_dyn);

$col_width		=90/($col_dyn+13);


$shipToId		= $holder_header['strShipTo'];
$shipSql		= "SELECT
					buyers.strName AS shipName,
					buyers.strAddress1 AS shipAddress1,
					buyers.strAddress2 AS shipAddress2,
					buyers.strAddress3 AS shipAddress3,
					buyers.strCountry AS shipCountry
					FROM
					buyers
					WHERE strBuyerID=$shipToId";
					
$resultShip		=$db->RunQuery($shipSql);
//echo $shipSql;
$rowShip		= mysql_fetch_array($resultShip);
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
    <td class="normalfnt2bldBLACKmid"><u>PACKING LIST / WEIGHT LIST</u></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" rowspan="2" valign="top"><table width="420">
          <tr>
            <td width="107" rowspan="2"><img src="../../images/callogo.jpg" /></td>
            <td width="301" height="30"><span class="normalfnth2B"><u>MARKS & NUMBERS</u></span></td>
            </tr>
          <tr>
            <td class="normalfntMid" height="20" style="text-align:left"><span class="normalfnt"><?php echo $rowShip['shipName'];?><br />
                <?php echo $rowShip['shipAddress1'];?><br />
                <?php echo $rowShip['shipAddress2'];?><br />
                <?php echo $rowShip['shipAddress3'];?><br />
                <?php echo $rowShip['shipCountry'];?></span></td>
            </tr>
          <tr>
            <td height="20" colspan="2" class="normalfnBLD1">Description: <?php echo $holder_header['strLable']; ?></td>
            </tr>
        </table></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B" ><?php echo $Company;?></td>
      </tr>
      
      <tr>
        <td width="25%" valign="bottom" class="normalfnBLD1">Invoice No: <?php echo $holder_header['strInvNo'];?></td>
        <td width="25%" valign="top" class="normalfnt">&nbsp;</td>
        <td width="25%" class="normalfnt" valign="top"><span class="normalfntMid" style="text-align:left"><?php echo $holder_header['strAddress1']?> <br />
            <?php echo $holder_header['strMLocation'];?><br />
            <?php echo $holder_header['strCountry'];?><br />
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-h-fnt">
      <tr>
        <td bgcolor="#CCCCCC" class="border-Left-Top-right tbl-h-fnt"><u>P.O. NO.</u></td>
        <td>&nbsp;</td>
        <td bgcolor="#CCCCCC" class="border-Left-Top-right tbl-h-fnt"><u>STYLE NO:</u></td>
        <td>&nbsp;</td>
        <td bgcolor="#CCCCCC" class="border-Left-Top-right tbl-h-fnt"><u>TTL CTN</u></td>
        <td bgcolor="#CCCCCC" class="border-top-right tbl-h-fnt"><u>TTL PCS</u></td>
        <td>&nbsp;</td>
        <td  class="border-Left-Top-right tbl-h-fnt">TOTAL ORDER QTY</td>
        <td  class="border-top-right tbl-h-fnt"><?php echo $holder_header['ordpcs'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="10%" bgcolor="#CCCCCC" class="border-Left-bottom-right tbl-h-fnt"><?php echo $holder_header['strStyle'];?></td>
        <td width="10%">&nbsp;</td>
        <td width="10%" bgcolor="#CCCCCC" class="border-Left-bottom-right tbl-h-fnt"><?php echo $holder_header['strProductCode'];?></td>
        <td width="10%">&nbsp;</td>
        <td width="10%" bgcolor="#CCCCCC" class="border-Left-bottom-right tbl-h-fnt"><?php echo $holder_header['dblNoofCTNS'];?></td>
        <td width="10%" bgcolor="#CCCCCC" class="border-bottom-right tbl-h-fnt"><?php echo $holder_header['dblQtyPcs'];?></td>
        <td width="10%">&nbsp;</td>
        <td width="14%" class="border-All tbl-h-fnt">TOTAL SHIPPED QTY</td>
        <td width="10%" class="border-top-bottom-right tbl-h-fnt"><?php echo $holder_header['dblQtyPcs'];?> (<?php echo number_format($holder_header['dblQtyPcs']/$holder_header['ordpcs']*100,2);?> %)</td>
        <td width="6%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
     <?php
	 $str_pre_pack ="SELECT DISTINCT srtPack FROM shipmentpldetail WHERE strPLNo='$plno'";
	 $result_prepack=$db->RunQuery($str_pre_pack);
	 while($row_prepack=mysql_fetch_array($result_prepack)){
			$prepack=$row_prepack["srtPack"];	 
			if($prepack=="1Pre Pack")
			$prepack_desc="SINGLE PRE PACK ";
			else if($prepack=="2Ratio")
			{
				if($myValue==1)
					$prepack_desc="MULT Y (RATIO PACK) ";
				else
					$prepack_desc="MULT N (RATIO PACK) ";
			}
			else if($prepack=="3Bulk")
			$prepack_desc="BULK PACK ";
			
			
			$tot_QtyPcs=0;	 
			$tot_NoofCTNS=0;
			$tot_QtyDoz=0;
			
	 ?>
     <tr  class="tbl-h-fnt" style="border-top:1px dotted;">
		  <td colspan="5" style="text-align:left;border-top:1px dotted;"><?php echo $prepack_desc;?></td>
		  <td colspan="<?php echo $col_dyn;?>" style="text-align:left;border-top:1px dotted;">&nbsp;</td>
		  <td colspan="5" style="text-align:left;border-top:1px dotted;">&nbsp;</td>
	  </tr>
      <tr  class="tbl-h-fnt" bgcolor="#CCCCCC">
        <td  nowrap="nowrap" colspan="2" class="border-Left-Top-right-fntsize12 tbl-h-fnt">CTN NO</td>
        <td width="26" class="border-top-right-fntsize12 tbl-h-fnt" nowrap="nowrap">PACK UPC</td>
        
        <td width="100" class="border-top-right-fntsize12 tbl-h-fnt">COLOR/PACK</td>
        <td colspan="<?php echo $col_dyn;?>" width="25" class="border-top-right-fntsize12 tbl-h-fnt">RATIO</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">PCS/CTN</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">PACKS/CTN</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">TTL/CTNS</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">TTL/PCS</td>
 
        </tr>
	  
      <tr class="tbl-h-fnt" bgcolor="#CCCCCC">
        <td colspan="2" class="border-left-right-fntsize12 tbl-h-fnt" >&nbsp;</td>
        <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
        <td class="border-right-fntsize12 tbl-h-fnt">DESCRIPTION</td>
        
        <?php 
		$result_dyn		=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="38" class="border-top-right-fntsize12 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td><?php }?>
        <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
        <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
        <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
        <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
        
        </tr>
        <?php 
		$str_row_data="SELECT
						orderspec.intOrderId,
						orderspecdetails.intOrderId,
						shipmentpldetail.strColor,
						orderspecdetails.strSize,
						orderspecdetails.dblPcs,
						shipmentpldetail.strPLNo,
						shipmentpldetail.intRowNo,
						shipmentpldetail.dblPLNoFrom,
						shipmentpldetail.dblPlNoTo,
						 sum(shipmentpldetail.dblQtyPcs) as dblQtyPcs,
						orderspecdetails.strPackUpc,
						shipmentpldetail.strTagNo,
						shipmentpldetail.strPrePack,
						shipmentpldetail.strShade,
						shipmentpldetail.strLength,
						shipmentpldetail.dblNoofPCZ,
						shipmentpldetail.dblNoofCTNS,
						shipmentpldetail.dblQtyDoz,
						shipmentpldetail.dblGorss,
						shipmentpldetail.dblNet,
						shipmentpldetail.dblNetNet,
						shipmentpldetail.dblTotGross,
						shipmentpldetail.dblTotNet,
						shipmentpldetail.dblTotNetNet,
						cartoon.strCartoon
						FROM
						orderspec
						INNER JOIN orderspecdetails ON orderspecdetails.intOrderId = orderspec.intOrderId
						INNER JOIN shipmentplheader ON shipmentplheader.strStyle = orderspec.strOrder_No
						INNER JOIN shipmentpldetail ON shipmentplheader.strPLNo = shipmentpldetail.strPLNo
						INNER JOIN shipmentplsubdetail ON shipmentpldetail.strPLNo = shipmentplsubdetail.strPLNo AND shipmentpldetail.intRowNo = shipmentplsubdetail.intRowNo
						INNER JOIN shipmentplsizeindex ON shipmentplsubdetail.strPLNo = shipmentplsizeindex.strPLNo AND shipmentplsubdetail.intColumnNo = shipmentplsizeindex.intColumnNo AND orderspecdetails.strSize = shipmentplsizeindex.strSize
						INNER JOIN cartoon ON shipmentpldetail.strCTN = cartoon.intCartoonId
						WHERE
						 shipmentpldetail.strPLNo='$plno' and srtPack='$prepack'
							GROUP BY shipmentpldetail.dblPlNoTo 
							ORDER BY
							shipmentpldetail.dblPlNoTo ASC,
							orderspecdetails.strColor  ";

						
	  	 $result_row_data=$db->RunQuery($str_row_data);
		//echo $str_row_data;
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {$row_index=$row_row_data['intRowNo']?>
         
         	<?php
				$intOrderId=$row_row_data['intOrderId'];
				$color_code_color=$row_row_data['strColor'];
				$color_code_sql="SELECT DISTINCT
								orderspecdetails.strColorCode,
								orderspecdetails.intOrderId
								FROM
								orderspecdetails WHERE orderspecdetails.intOrderId=$intOrderId AND strColor='$color_code_color'";
								
				$result_color=$db->RunQuery($color_code_sql);
				//echo $color_code_sql;
				$row_color_code=mysql_fetch_array($result_color);
			?>
            
            <tr class="tbl-h-fnt">
            <td class="border-Left-Top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['dblPLNoFrom'];?></td>
            <td class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['dblPlNoTo'];?></td>
            
            
            
            <!--            Pack UPC                  -->

            <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['strPackUpc']; ?></td>
            
            <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['strColor'];?> - <?php echo $row_color_code['strColorCode']; ?></td>
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
				 $smallValue=1;
				 
				 if($prepack=='2Ratio' && $myValue==0)
				 {
					 $smallValueSql="SELECT DIStinct
									shipmentplsubdetail.intRowNo,
									shipmentplsubdetail.dblPcs
									FROM
									shipmentpldetail
									RIGHT JOIN shipmentplsubdetail ON shipmentplsubdetail.strPLNo = shipmentpldetail.strPLNo AND shipmentplsubdetail.intRowNo = shipmentpldetail.intRowNo
									WHERE shipmentplsubdetail.intRowNo=$row_index AND shipmentpldetail.strPLNo='$plno'
									ORDER BY shipmentplsubdetail.dblPcs ASC
									limit 1
									";
					$result_Small = $db->RunQuery($smallValueSql);
					$smallValue1 = mysql_fetch_array($result_Small);
					$smallValue   = $smallValue1['dblPcs'];
				 }
				 $count=0;
				 $ttl_pcs=0;
				 $packs_ctn= 0;
                 $ttl_ctns= 0;
				 //$tot_ttl_pcs=0;
				 //$tot_ttl_pcs2=0;
				 $ttl_pcs= $row_row_data['dblQtyPcs'];$tot_QtyPcs;
				// $tot_QtyPcs=0;
				 unset($col_atrray); 
				 
while(($row_cell_data=mysql_fetch_array($result_cell_data))|| ($count<$col_dyn))
{
	if($prepack=="2Ratio")
		$col_atrray[$row_cell_data['intColumnNo']]= $row_cell_data['dblPcs']/$smallValue;
	else
		$col_atrray[$row_cell_data['intColumnNo']]= $row_cell_data['dblPcs'];	
	$col_atrray_tot[$row_cell_data['intColumnNo']]+= $row_cell_data['dblPcs']*$row_row_data['dblNoofCTNS'];	
	$col_atrray_sum[$prepack][$row_row_data['strColor']][$row_cell_data['intColumnNo']]+= $row_cell_data['dblPcs']*$row_row_data['dblNoofCTNS'];	
	$col_array_sum[$row_row_data['strColor']][$row_cell_data['intColumnNo']]+= $row_cell_data['dblPcs']*$row_row_data['dblNoofCTNS'];


																		
	
	?>
	<td class="border-top-right-fntsize12 tbl-h-fnt" style="width:25px;" nowrap="nowrap"><?php echo $col_atrray[$count];?></td>
<?php $count++;}?>		
							<?php
							
							 $packs_ctn= $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];
                             $ttl_ctns= $row_row_data['dblNoofCTNS'];$tot_NoofCTNS+=$row_row_data['dblNoofCTNS'];
							 $ttl_pcs= $row_row_data['dblQtyPcs'];$tot_QtyPcs;
							 
							$ttl_pcs =	$row_row_data['dblNoofPCZ']* $row_row_data['dblNoofCTNS'];		
						 $tot_ttl_pcs = $tot_ttl_pcs +$ttl_pcs;	
						 //$tot_ttl_pcs2=$tot_ttl_pcs2+$tot_ttl_pcs;
						//echo $tot_ttl_pcs;
							 
							 ?>
					<!--          PCS/CTN      -->	
            <td class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['dblNoofPCZ'];$tot_NoofPCZ+=$row_row_data['dblNoofPCZ'];?></td>
            <td class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $ttl_pcs/$ttl_ctns;?></td>
            
             	<!--               TTL/CTNS             -->
            <td class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $ttl_ctns;?></td>
            <td class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $ttl_pcs ;?></td>
																		
            
           
            </tr>
            
		<?php }?> 
        <tr class="tbl-h-fnt">
              <td colspan="6" class="border-top">&nbsp;</td>
              <?php
			  
			   for($i=0;$i<$col_dyn;$i++){?>
              <td class="<?php if($i==$col_dyn-1) echo 'border-top-right-fntsize12';else echo 'border-top';?>" ><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td><?php }?>
              
              <td class="border-top-bottom-right-fntsize12 tbl-h-fnt"><?php echo $tot_NoofCTNS+=$row_row_data['dblNoofCTNS'];?></td>
              <td class="border-top-bottom-right-fntsize12 tbl-h-fnt"><?php echo $tot_ttl_pcs;?></td>
              
            </tr>
		
		<tr  class="tbl-h-fnt">
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td colspan="3" >&nbsp;</td>
		  <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
		  <td colspan="5" >&nbsp;</td>
	    </tr>	
        <!--                                                               END BULK PACK                                          -->	
        
        
		<tr  class="tbl-h-fnt">
		  <td colspan="11"  style="text-align:center"><u><?php echo $prepack_desc;?>SUMMARY</u></td>
		  <td colspan="<?php echo $col_dyn;?>"></td>
		  <td colspan="5" >&nbsp;</td>
	  </tr>
      <tr  class="tbl-h-fnt" bgcolor="#CCCCCC">
        <td  nowrap="nowrap" colspan="2" class="border-Left-Top-right-fntsize12 tbl-h-fnt">CTN NO</td>
        <td width="26" class="border-top-right-fntsize12 tbl-h-fnt" nowrap="nowrap">PRE PACK</td>
        
        <td width="28" class="border-top-right-fntsize12 tbl-h-fnt">COLOR</td>
        
         <td colspan="<?php echo $col_dyn;?>" width="38" class="border-top-right-fntsize12 tbl-h-fnt">RATIO</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">TOTAL</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">O QTY</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">DEF</td>
         <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">SHORT/EX</td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        </tr>
	  
      <tr class="tbl-h-fnt" bgcolor="#CCCCCC">
      
        <td colspan="2" class="border-left-right-fntsize12 tbl-h-fnt" >&nbsp;</td>
        <td class="border-right-fntsize12 tbl-h-fnt">NO'S</td>
        <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
        
        <?php 
		$result_dyn		=$db->RunQuery($str_dyn);
		while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td width="38" class="border-top-right-fntsize12 tbl-h-fnt" nowrap="nowrap"><?php echo $row_dyn['strSize'];?></td><?php }?>
        <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
         <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
         <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
         <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
        <td width="71" bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        </tr>
        <?php 
		
		/*$str_row_data="SELECT dblPLNoFrom,
							MAX(dblPlNoTo) as dblPlNoTo,
							strColor ,
							strPrePack,
							SUM(dblQtyPcs) as dblQtyPcs
							FROM shipmentpldetail 
							WHERE strPLNo='$plno' AND srtPack='$prepack' 
							GROUP BY strColor order by dblPLNoFrom";*/
							
		$str_row_data="SELECT
						shipmentpldetail.dblPLNoFrom,
						Max(shipmentpldetail.dblPlNoTo) AS dblPlNoTo,
						shipmentpldetail.strColor,
						shipmentpldetail.strPrePack,
						Sum(shipmentpldetail.dblQtyPcs) AS dblQtyPcs,
						shipmentplheader.strStyle,
						sum(orderspecdetails.dblPcs) as dblPcs,
						orderspec.intOrderId
						FROM
						shipmentpldetail
						INNER JOIN shipmentplheader ON shipmentpldetail.strPLNo = shipmentplheader.strPLNo
						INNER JOIN orderspec ON shipmentplheader.strStyle = orderspec.strOrder_No
						INNER JOIN orderspecdetails ON orderspec.intOrderId = orderspecdetails.intOrderId
						WHERE shipmentpldetail.strPLNo='$plno' AND srtPack='$prepack'
						GROUP BY strColor
						order by dblPLNoFrom";
	  	 $result_row_data=$db->RunQuery($str_row_data);
		 //echo $str_row_data;
		 $row_tot=0;
		 $ratioQty=0;
		 $fullRatioQty=0;
		 		 $PlNoTo=0;
		 $totPlNoTo=0;
		$totQty1=0;
		$ratioQty1=0;
		//$totSize=0;
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {		
		 	 			
			 $row_tot+=$row_row_data['dblQtyPcs']; 
			 $row_index=$row_row_data['intRowNo'];?>
         
            <?php
				$intOrderId=$row_row_data['intOrderId'];
				$color_code_color=$row_row_data['strColor'];
				$color_code_sql="SELECT DISTINCT
								orderspecdetails.strColorCode,
								orderspecdetails.intOrderId
								FROM
								orderspecdetails WHERE orderspecdetails.intOrderId=$intOrderId AND strColor='$color_code_color'";
								
				$result_color=$db->RunQuery($color_code_sql);
				//echo $color_code_sql;
				$row_color_code=mysql_fetch_array($result_color);
			?>
            <tr class="tbl-h-fnt">
            
            <td colspan="2" class="border-Left-Top-right-fntsize12 tbl-h-fnt"><?php
					$PlNoTo=($row_row_data['dblPlNoTo']- $row_row_data['dblPLNoFrom'])+1;
					$totPlNoTo+=$PlNoTo;
					 echo $PlNoTo  ;?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['strStyle'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['strColor'];?> - <?php echo $row_color_code['strColorCode']; ?></td>
          
        <?php 		
					
		$result_dyn		=$db->RunQuery($str_dyn);
		$ratioQty		= 0;
		$ratioQty_size=0;
		$oqty=0;
		//$totSize=0;
		
		while($row_dyn=mysql_fetch_array($result_dyn))	
		
		{?>
        
	<td class="border-top-right-fntsize12 tbl-h-fnt" style="width:25px;" nowrap="nowrap"><?php 
							echo  $col_atrray_sum[$prepack][$row_row_data['strColor']][$row_dyn['intColumnNo']];
							$ratioQty+=$col_atrray_sum[$prepack][$row_row_data['strColor']][$row_dyn['intColumnNo']];
							//$totSize=$col_atrray_sum[$prepack][$row_row_data['strColor']][$row_dyn['intColumnNo']]
									// + $col_atrray_sum[$prepack][$row_row_data['strColor']][$row_dyn['intColumnNo']][1];
									 
								 
		?></td>
                        
            
        
<?php $count++;}?>
            <td class="border-top-right-fntsize12 tbl-h-fnt"><?php
												 echo $ratioQty;
												 $fullRatioQty+=$ratioQty?></td>
	<td class="border-top-right-fntsize12 tbl-h-fnt" style="width:25px;" nowrap="nowrap"><?php
										echo  $ratioQty1;
		?></td>
            <td class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $ratioQty-$oqty	 ?></td>
            <td class="border-top-right-fntsize12 tbl-h-fnt"><?php echo TEST ?></td>
            <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
            <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
            <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
            </tr>
            
		<?php }?> 
        <tr class="tbl-h-fnt">
        	<td colspan="2" class="border-All" style="text-align:center"><b><?php echo $totPlNoTo;?></b></td>
             <td class="border-top">&nbsp;</td>
              <td  class="border-top">&nbsp;</td>
              <?php for($i=0;$i<$col_dyn;$i++){?>
              
              <!---------------------------------------------------------------------------------------------------------------------------->
              <td class="<?php if($i==$col_dyn-1) echo 'border-top-right-fntsize12';else echo 'border-top';?>" >
                        <input type="text" style="width: 40px; visibility:hidden" class="txtbox" />	</td><?php }?>
              <td class="border-top-bottom-right-fntsize12 tbl-h-fnt"><?php echo $fullRatioQty;?></td>
              <td class="border-top-bottom-right-fntsize12 tbl-h-fnt"><?php echo $totQty1; ?></td>
              <td class="border-top-bottom-right-fntsize12 tbl-h-fnt"><?php echo $fullRatioQty-$totQty1; ?></td>
               <td class="border-top-bottom-right-fntsize12 tbl-h-fnt"><?php echo TEST; ?></td>
              <td width="71" bgcolor="#FFFFFF"></td>
              <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
              <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
              <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
            </tr>		
		<tr  class="tbl-h-fnt">
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td colspan="3" >&nbsp;</td>
		  <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
		  <td colspan="5" >&nbsp;</td>
	    </tr>
        <?php }?>
		<tr  class="tbl-h-fnt">
        <td width="70" 	><input type="text" style="width:20px; visibility:hidden" class="txtbox" /></td>
        <td width="70" 	><input type="text" style="width: 20px; visibility:hidden" class="txtbox" /></td>
        <td ><input type="text" style="width: 80px; visibility:hidden" class="txtbox" /></td>
        <td ><input type="text" style="width: 80px; visibility:hidden" class="txtbox" /></td>
        <td ><input type="text" style="width: 80px; visibility:hidden" class="txtbox" /></td>
        <td colspan="<?php echo $col_dyn;?>" width="38"  >&nbsp;</td>
        <td width="71" ><input type="text" style="width: 40px; visibility:hidden" class="txtbox" ></td>
        <td width="71" ><input type="text" style="width: 40px; visibility:hidden" class="txtbox" /></td>
        <td width="71" ><input type="text" style="width: 40px; visibility:hidden" class="txtbox" /></td>
        <td width="71" ><input type="text" style="width: 40px; visibility:hidden" class="txtbox" /></td>
        <td width="71" ><input type="text" style="width: 130px; visibility:hidden" class="txtbox" /></td>
        </tr>
        
        <!-----------------------------------------------------------TOTAL SUMMARY OF PACKING LIST---------------------------------------------->
        
      <tr  class="tbl-h-fnt">
		  <td colspan="<?php echo $col_dyn+10;?>" style="border-top:2px dashed">TOTAL SUMMARY OF PACKING LIST</td>
	   </tr>   
      <tr  class="tbl-h-fnt" bgcolor="#CCCCCC">
        <td  nowrap="nowrap" colspan="2" bgcolor="#FFFFFF"></td>
        <td width="26" class="border-Left-Top-right-fntsize12 tbl-h-fnt" nowrap="nowrap">PACK UPC</td>
        <td width="27" class="border-top-right-fntsize12 tbl-h-fnt" nowrap="nowrap">G.W</td>
        <td width="27" class="border-top-right-fntsize12 tbl-h-fnt" nowrap="nowrap">N.W</td>
        <td width="27" class="border-top-right-fntsize12 tbl-h-fnt" nowrap="nowrap">N.N.W</td>
        
        <td  width="38" colspan="3" class="border-top-right-fntsize12 tbl-h-fnt">M'MENT</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">G.W</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">N.W</td>
        <td nowrap="nowrap" width="71" class="border-top-right-fntsize12 tbl-h-fnt">CBM</td>

        <td width="71" bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        </tr>
	  
      <tr class="tbl-h-fnt" bgcolor="#CCCCCC">
        <td colspan="2" bgcolor="#FFFFFF"></td>
        <td class="border-left-right-fntsize12 tbl-h-fnt" >/ STYLE</td>
        <td class="border-right-fntsize12 tbl-h-fnt">(KGS)</td>
         <td class="border-right-fntsize12 tbl-h-fnt">(KGS)</td>
         <td class="border-right-fntsize12 tbl-h-fnt">(KGS)</td>
         <td colspan="3" class="border-right-fntsize12 tbl-h-fnt">(CM)</td>
         <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
         <td class="border-right-fntsize12 tbl-h-fnt">(KGS)</td>
         <td class="border-right-fntsize12 tbl-h-fnt">&nbsp;</td>
      
        <td width="71" bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF">	</td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        <td width="71" nowrap="nowrap"  bgcolor="#FFFFFF"></td>
        
        </tr>
        <?php 
		$str_row_data="SELECT
								shipmentpldetail.dblPLNoFrom,
								Max(shipmentpldetail.dblPlNoTo) AS dblPlNoTo,
								shipmentpldetail.strColor,
								Sum(shipmentpldetail.dblQtyPcs) AS dblQtyPcs,
								shipmentplheader.strStyle,
								orderspec.intOrderId,
								shipmentpldetail.dblTotGross,
								shipmentpldetail.dblTotNet,
								shipmentpldetail.dblTotNetNet,
								orderspecdetails.strColorCode,
								cartoon.strCartoon
								FROM
								shipmentpldetail
								INNER JOIN shipmentplheader ON shipmentpldetail.strPLNo = shipmentplheader.strPLNo
								INNER JOIN orderspec ON shipmentplheader.strStyle = orderspec.strOrder_No
								INNER JOIN orderspecdetails ON orderspec.intOrderId = orderspecdetails.intOrderId AND shipmentpldetail.strColor = orderspecdetails.strColor
								INNER JOIN cartoon ON shipmentpldetail.strCTN = cartoon.intCartoonId
								WHERE shipmentpldetail.strPLNo='$plno'
								GROUP BY shipmentpldetail.strColor
								order by dblPLNoFrom";
	  	 $result_row_data=$db->RunQuery($str_row_data);
		 //echo $str_row_data;
		
		////////////////////////////////////////////////////////////////////////////////////////////// echo $str_row_data;
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {		
		 	 $row_tot=0;			
			 $row_tot+=$row_row_data['dblQtyPcs']; 
			 $row_index=$row_row_data['intRowNo'];
         	 $color_ord_tot=0;
			 $color=$row_row_data['strColor'];
			 
 $color_sql="SELECT DISTINCT
							orderspecdetails.intOrderId,
							orderspecdetails.strColor,
							orderspecdetails.strColorCode
							FROM
							orderspecdetails
							WHERE intOrderId=".$row_row_data['intOrderId']."" ;
								
	if($color!="WHITE '1'")
		$color_sql .= " and strColor ='$color' ";
					
	else
		$color_sql .= " and strColor LIKE '%WHITE \'1\'%' ";
		
		
			$result_color_data = $db->RunQuery($color_sql);
			$color_row = mysql_fetch_array($result_color_data);
		?>
            
  <!--   -----------------------------------------------------------------------------------------------------------------------------       -->
      <tr class="tbl-h-fnt">
            <td colspan="2" bgcolor="#FFFFFF"></td>
            <td nowrap="nowrap"  class="border-Left-Top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['strColor'];?> - <?php echo $row_row_data['strColorCode'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['dblTotGross'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['dblTotNet'];?></td>
            <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['dblTotNetNet'];?></td>
            <td colspan="3" nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt"><?php echo $row_row_data['strCartoon'];?></td>
             <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt">d</td>
              <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt">d</td>
               <td nowrap="nowrap" class="border-top-right-fntsize12 tbl-h-fnt">d</td>
          
  
<?php $count++;}?>

        <tr  class="tbl-h-fnt">
          <td height="18" >&nbsp;</td>
          <td >&nbsp;</td>
          
          <td colspan="3" class="border-top">&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>" class="border-top">&nbsp;</td>
          <td colspan="2" class="border-top">&nbsp;</td>
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
         

       
              
        <!-------------------------------------------------MARKS & NUMBERS-------------------------------------------------------------------->
        <tr  class="tbl-h-fnt">
          
         
          
          <td colspan="15"  style="border-top:2px dashed" align="left"> <B> <U> MARKS & NUMBERS </U> <B></td>
          <td height="18" >&nbsp;</td>
           <td >&nbsp;</td>
          <td colspan="<?php echo $col_dyn;?>" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
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
         
         
       
        <tr  class="tbl-h-fnt">
          <td >&nbsp;</td>
           
           <td  style="text-align:left">P.O # :</td>
            <td ><?php echo $holder_header['strProductCode'];?></td>
        
		<td >&nbsp;</td>
          <td colspan="3" style="text-align:left">GROSS WEIGHT :</td>
          
          <td ><?php echo number_format($holder_header['dblTotGross'],2)." ".$holder_header['strUnit'];?></td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        
        
        <tr  class="tbl-h-fnt">
        <td >&nbsp;</td>
        <td  style="text-align:left">ST #:</td>
           <td ><?php echo $holder_header['strStyle'];?></td>
          <td >&nbsp;</td>
          <td colspan="3" style="text-align:left">NET WEIGHT :</td>
          <td ><?php echo number_format($holder_header['dblTotNet'],2)." ".$holder_header['strUnit'];?></td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr  class="tbl-h-fnt">
          <td >&nbsp;</td>
          <td style="text-align:left">PACK UPC :</td>
          <td ><?php echo $row_row_data['strPackUpc']; ?></td>
          <td colspan="3" style="text-align:left">NET NET WEIGHT :</td>
          <td ><?php echo number_format($holder_header['dblTotNetNet'],2)." ".$holder_header['strUnit'];?></td>
          <td colspan="<?php echo $col_dyn;?>">&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
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
	//echo $str;
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