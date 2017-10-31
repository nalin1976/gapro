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

$str_header		="SELECT
					shipmentplheader.strPLNo,
					shipmentplheader.strSailingDate,
					shipmentplheader.strStyle,
					Sum(shipmentpldetail.dblQtyPcs) AS dblQtyPcs,
					Sum(shipmentpldetail.dblNoofCTNS) AS dblNoofCTNS,
					Sum(shipmentpldetail.dblQtyDoz) AS dblQtyDoz,
					Sum(shipmentpldetail.dblTotGross) AS dblTotGross,
					Sum(shipmentpldetail.dblTotNet) AS dblTotNet,
					Sum(shipmentpldetail.dblTotNetNet) AS dblTotNetNet,
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
					customers.strName,
					customers.strMLocation,
					customers.strAddress1,
					customers.strAddress2,
					customers.strCountry,
					buyers.strName AS buyerName,
					buyers.strAddress1 AS buyerAddress1,
					buyers.strAddress2 AS buyerAddress2,
					buyers.strCountry As buyerCountry
					FROM
					shipmentplheader
					INNER JOIN shipmentpldetail ON shipmentpldetail.strPLNo = shipmentplheader.strPLNo
					INNER JOIN orderspec ON shipmentplheader.strStyle = orderspec.strOrder_No
					INNER JOIN customers ON customers.strCustomerID = shipmentplheader.strFactory
					INNER JOIN buyers ON buyers.strBuyerID = shipmentplheader.strShipTo
					where
					shipmentplheader.strPLNo='$plno'
					group by strPLNo";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Packing List-Eddie Bauer</title>
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

<body><table width="1050" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="43">&nbsp;</td>
    <td width="42">&nbsp;</td>
    <td width="58">&nbsp;</td>
    <td width="72">&nbsp;</td>
    <td width="62">&nbsp;</td>
    <td width="43">&nbsp;</td>
    <td width="70">&nbsp;</td>
    <td width="51">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" style="text-align:center; font-size:14px" class="normalfnBLD1"><u>PACKING LIST</u></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" style="text-align:center" class="normalfnBLD1"><?php echo $holder_header['buyerCountry']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><u>S.NAME &amp; ADDRESS</u></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnt" style="text-align:right"><u>CONSIGNEE:</u></td>
    <td colspan="5" class="normalfnt"><?php echo $holder_header['buyerName']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $Company; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $holder_header['buyerAddress1']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6" class="normalfnt"><?php echo $Address;  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $holder_header['buyerAddress2']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $City ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $holder_header['buyerCountry']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $phone; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnt" style="text-align:right" nowrap="nowrap">COMMERCIAL INVOICE#: </td>
    <td colspan="2" class="normalfnt" style="text-align:center" >EXP/53665</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="normalfnt"><u>SHIP TO:</u></td>
    <td colspan="5" class="normalfnt"><?php echo $holder_header['buyerName']; ?></td>
    <td colspan="2" class="border-top-left">ORDER QTY:</td>
    <td class="border-Left-Top-right" style="text-align:right"><?php echo $holder_header['ordpcs'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><u>MANUFACTURE NAME &amp; ADDRESS </u></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $holder_header['buyerAddress1']; ?></td>
    <td class="border-top-left" nowrap="nowrap">SHIP QTY: </td>
    <td class="border-top-left">&nbsp;</td>
    <td class="border-Left-Top-right" style="text-align:right"><?php echo $holder_header['dblQtyPcs']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt">EAM MALIBAN TEXTILES(PVT) LTD </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $holder_header['buyerAddress2']; ?></td>
    <td colspan="2" class="border-top-left" style="text-align:center">%</td>
    <td class="border-Left-Top-right" style="text-align:right"><?php echo round((($holder_header['dblQtyPcs']*100)/$holder_header['ordpcs']),2) ;?>%</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt" >Deraniyagala</td>
    <td colspan="2" style="text-align:right" class="normalfnt">CODE(LKZ):</td>
    <td class="normalfnBLD1" style="text-align:center">946333</td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt"><?php echo $holder_header['buyerCountry']; ?></td>
    <td colspan="2" class="border-top-left">MODE:</td>
    <td class="border-Left-Top-right" style="text-align:left" nowrap="nowrap"><?php echo $holder_header['strTrnsportMode']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt">Sri Lanka. </td>
    <td colspan="2" class="normalfnt" style="text-align:right">SEASON NO: </td>
    <td class="normalfnBLD1" style="text-align:center"><?php echo $holder_header['strSeason']; ?></td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnt">&nbsp;</td>
    <td colspan="2" class="border-top-bottom-left">DATE:</td>
    <td class="border-All" style="text-align:right"><?php echo $holder_header['strSailingDate']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt" nowrap="nowrap">EDDIE BAUER PO NO </td>
    <td>&nbsp;</td>
    <td class="normalfnt">STYLE NO</td>
    <td>&nbsp;</td>
    <td class="normalfnt" nowrap="nowrap">TTL PCS</td>
    <td>&nbsp;</td>
    <td class="normalfnt" nowrap="nowrap">TTL CTNS </td>
    <td>&nbsp;</td>
    <td colspan="8" class="normalfnt"><u>Style Description</u></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-All" bgcolor="#CCCCCC" style="text-align:center"><?php echo $holder_header['strStyle'];?></td>
    <td >&nbsp;</td>
    <td class="border-All" bgcolor="#CCCCCC" style="text-align:center"><?php echo $holder_header['strProductCode'];?></td>
    <td>&nbsp;</td>
    <td class="border-All" bgcolor="#CCCCCC" style="text-align:center"><?php echo $holder_header['dblQtyPcs'];?></td>
    <td>&nbsp;</td>
    <td class="border-All" bgcolor="#CCCCCC" style="text-align:center"><?php echo $holder_header['dblNoofCTNS'];?></td>
    <td>&nbsp;</td>
    <td colspan="8" rowspan="2" class="normalfnt" valign="top"><?php echo $holder_header['strItem']; ?> <?php echo $holder_header['strLable']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="9">&nbsp;</td>
    <td width="41" colspan="2">&nbsp;</td>
    <td width="80">&nbsp;</td>
    <td width="57">&nbsp;</td>
    <td width="84">&nbsp;</td>
    <td width="91">&nbsp;</td>
    <td width="47">&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td width="57">&nbsp;</td>
    <td width="49">&nbsp;</td>
    <td width="23">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center">CTN NO</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">NO OF CTN</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">UPC # </td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">COLOR NAME </td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center" nowrap="nowrap">BUYER ITEM # </td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">SIZE</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">TOTAL PIECES BY SKU IN EACH CARTON </td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">PACK QTY</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">O/QTY</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">3%</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">%</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">TOTAL PIECES </td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">CTN M.MENT</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">NET.NET WGHT. PER CTN</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">NET. WGHT PER CTN</td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center">GROSS WGHT. PER CTN</td>
    <td class="border-Left-Top-right" bgcolor="#CCCCCC" style="text-align:center">TTL GROSS WEIGHT</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  	$sql_array="SELECT DISTINCT
					ssi.strPLNo,
					ssi.intColumnNo,
					ssi.strSize,
					COUNT(ssi.strSize) AS noOfRows,
					Sum(shipmentpldetail.dblQtyPcs) as packQty,
					shipmentpldetail.strColor,
					orderspecdetails.dblPcs,
					orderspecdetails.strSKU,
					SUM(shipmentpldetail.dblGorss) AS TTLWeight
					FROM
					shipmentplsizeindex AS ssi
					LEFT JOIN shipmentplsubdetail AS ssd ON ssi.intColumnNo = ssd.intColumnNo AND ssi.strPLNo = ssd.strPLNo
					INNER JOIN shipmentpldetail ON shipmentpldetail.intRowNo = ssd.intRowNo AND shipmentpldetail.strPLNo = ssd.strPLNo
					INNER JOIN shipmentplheader ON shipmentplheader.strPLNo = ssd.strPLNo
					INNER JOIN orderspec ON orderspec.strOrder_No = shipmentplheader.strStyle
					INNER JOIN orderspecdetails ON orderspecdetails.intOrderId = orderspec.intOrderId AND orderspecdetails.strColor = shipmentpldetail.strColor AND orderspecdetails.strSize = ssi.strSize
					where ssi.strPLNo='$plno' AND ssd.dblPcs!=''
					GROUP BY shipmentpldetail.strColor, ssi.strSize
				";
				
	$result_array=$db->RunQuery($sql_array);
	//$poNo=$holder_header['strStyle'];
	$color_w_summary=array();
	$size_w_summary=array();
	$net_w_summary=array();
	$size_w_summary1=array();
	while($row_array=mysql_fetch_array($result_array))
	{
		$size_w_summary[$row_array["strColor"]][$row_array["strSize"]]["packQty"]=$row_array['packQty'];
		$size_w_summary[$row_array["strColor"]][$row_array["strSize"]]["orderedQty"]=$row_array['dblPcs'];
		$size_w_summary[$row_array["strColor"]][$row_array["strSize"]]["noOfRows"]=$row_array['noOfRows'];
		$size_w_summary1[$row_array["strColor"]][$row_array["strSize"]][$row_array["strSKU"]]=$row_array['TTLWeight'];
		
		$color_w_summary[$row_array["strColor"]]["noOfRows"]+=1;
		$color_w_summary[$row_array["strColor"]][$row_array["strSize"]]["colorTTL"]+=$row_array['packQty'];
		$color_w_summary[$row_array["strColor"]]["colorTTL"]+=$row_array['packQty'];
	}
  ?>
  <?php
  		$sql_row_data="SELECT DISTINCT
						ssi.strPLNo,
						ssi.intColumnNo,
						ssi.strSize,
						ssd.intRowNo,
						ssd.dblPcs,
						shipmentpldetail.dblPLNoFrom,
						shipmentpldetail.dblPlNoTo,
						shipmentpldetail.dblNoofCTNS,
						shipmentpldetail.dblQtyPcs,
						shipmentpldetail.dblGorss,
						shipmentpldetail.dblNet,
						shipmentpldetail.dblNetNet,
						shipmentpldetail.dblTotGross,
						shipmentpldetail.dblTotNet,
						shipmentpldetail.dblTotNetNet,
						cartoon.strCartoon,
						cartoon.intLength,
						cartoon.intWidth,
						cartoon.intHeight,
						orderspec.strOrder_No,
						orderspecdetails.strSKU,
						shipmentpldetail.strColor
						FROM
						shipmentplsizeindex AS ssi
						LEFT JOIN shipmentplsubdetail AS ssd ON ssi.intColumnNo = ssd.intColumnNo AND ssi.strPLNo = ssd.strPLNo
						INNER JOIN shipmentpldetail ON shipmentpldetail.intRowNo = ssd.intRowNo AND shipmentpldetail.strPLNo = ssd.strPLNo
						INNER JOIN cartoon ON cartoon.intCartoonId = shipmentpldetail.strCTN
						INNER JOIN shipmentplheader ON shipmentplheader.strPLNo = ssd.strPLNo
						INNER JOIN orderspec ON orderspec.strOrder_No = shipmentplheader.strStyle
						INNER JOIN orderspecdetails ON orderspecdetails.intOrderId = orderspec.intOrderId AND orderspecdetails.strColor = shipmentpldetail.strColor AND orderspecdetails.strSize = ssi.strSize
						where ssi.strPLNo='$plno' AND ssd.dblPcs!=''
						GROUP BY shipmentpldetail.dblPLNoFrom
						";
		$result_row_data=$db->RunQuery($sql_row_data);
		
		  //echo mysql_num_rows($result_column);
		  $pre_row_color='';
		  //$preSize='';
		  $preSku='';
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {
  ?>
  

  
  <tr>
    <td>&nbsp;</td>
    <td class="border-top-left" style="text-align:center"><?php echo $row_row_data['dblPLNoFrom']; ?></td>
    <td class="border-top-left" style="text-align:center"><?php echo $row_row_data['dblPlNoTo']; ?></td>
	<?php
		$noOfCTNS=$row_row_data['dblPlNoTo']-$row_row_data['dblPLNoFrom']+1;
	?>
    <td class="border-top-left" style="text-align:center"><?php echo $noOfCTNS;$tot_NoofCTNS+=$noOfCTNS;?></td>
    <td class="border-top-left" style="text-align:center"><?php if($preSku!=$row_row_data['strSKU'])echo $row_row_data['strSKU']; else echo '""'; ?></td>
    <td class="border-top-left" style="text-align:center" nowrap="nowrap"><?php if($pre_row_color!=$row_row_data['strColor']) echo $row_row_data['strColor'];  else echo '""';?></td>
    <td class="border-top-left" style="text-align:center">&nbsp;</td>
    <td class="border-top-left" style="text-align:center"><?php echo $row_row_data['strSize']; ?></td>
    <td class="border-top-left" style="text-align:center"><?php echo $row_row_data['dblPcs']; ?></td>
	<?php
	$net_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]][$row_row_data['strSKU']]+=$row_row_data['dblNet'];
		if($preSku!=$row_row_data['strSKU'])
		{
	?>
    <td class="border-top-left" style="text-align:center" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["packQty"]; ?></td>
    
    <td class="border-top-left" style="text-align:center" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><?php echo round($size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["orderedQty"],0); ?></td>
    
    <td class="border-top-left" style="text-align:center" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><span class="normalfnt"><?php echo ($size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["orderedQty"]*1.03); ?></span></td>
    
    <td class="border-top-left" nowrap="nowrap" style="text-align:center" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><span class="normalfnt"><?php echo round(($size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["packQty"]*100/$size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["orderedQty"]),2) ?></span></td>
    <?php
		}
	?>
    <td class="border-top-left" style="text-align:center"><?php echo $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></td>
    <td class="border-top-left" bgcolor="#CCCCCC" nowrap="nowrap"><?php echo $row_row_data["strCartoon"];?></td>
    <td class="border-top-left" style="text-align:center"><?php echo $row_row_data["dblNetNet"]; ?></td>
    <td class="border-top-left" style="text-align:center"><?php echo $row_row_data["dblNet"]; ?></td>
    <td class="border-top-left" style="text-align:center"><?php echo $row_row_data["dblGorss"]; ?></td>
    <?php
   		if($preSku!=$row_row_data['strSKU'])
		{
   ?>
    <td class="border-Left-Top-right" style="text-align:center" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><?php echo round($size_w_summary1[$row_row_data["strColor"]][$row_row_data["strSize"]][$row_row_data["strSKU"]],2); ?></td>
    <td>&nbsp;</td>
    <?php
		}
	?>
  </tr>
  <?php
  $pre_row_color=$row_row_data['strColor'];
  $preSku=$row_row_data['strSKU'];
  }
  ?>
  
  
    <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="border-top">&nbsp;</td>
    <td class="border-top-bottom-left" style="text-align:center"><?php echo $tot_NoofCTNS;?></td>
    <td class="border-top-left">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top-bottom-left" style="text-align:center"><?php echo $tot_QtyPcs;?></td>
    <td class="border-top-bottom-left" style="text-align:center"><?php echo round($holder_header['ordpcs'],0); ?></td>
    <td class="border-top-left">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top-bottom-left" style="text-align:center"><?php echo $tot_QtyPcs;?></td>
    <td class="border-top-left">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-All" style="text-align:center"><?php echo round($holder_header['dblTotGross'],2); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td colspan="2" rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td colspan="8" rowspan="2"><table width="500" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3" class="border-top-left">COLOR SUMMARY &amp; SIZE BREAKDOWN </td>
        <td width="46" class="border-top-left">&nbsp;</td>
        <td width="72" class="border-left">&nbsp;</td>
        <td width="58">&nbsp;</td>
        <td width="47">&nbsp;</td>
        <td width="44">&nbsp;</td>
      </tr>
	  <tr>
        <td width="56" class="border-top-left" style="text-align:center">UPC #</td>
        <td width="84" class="border-top-left" style="text-align:center">COLOR CODE</td>
        <td width="92" class="border-top-left" style="text-align:center">BUYER ITEM #</td>
        <td width="46" class="border-top-left" style="text-align:center">SIZE</td>
        <td width="72" class="border-top-left" style="text-align:center">TOTAL</td>
        <td width="58" class="border-top-left" style="text-align:center">Color TTL</td>
        <td width="47" class="border-top-left" style="text-align:center">Wt.Per Pce</td>
        <td width="44" class="border-Left-Top-right" style="text-align:center" bgcolor="#CCCCCC">Net Net Wt</td>
      </tr>
	  <?php
	  $sql_size="SELECT DISTINCT
					orderspecdetails.strSize,
					orderspecdetails.strColor,
					orderspecdetails.strSKU,
					orderspec.strOrder_No,
					finishing_garment_weight.strSize,
					finishing_garment_weight.dblWeight
					FROM
					orderspecdetails
					INNER JOIN orderspec ON orderspecdetails.intOrderId = orderspec.intOrderId
					INNER JOIN shipmentplheader ON shipmentplheader.strStyle = orderspec.strOrder_No
					INNER JOIN finishing_garment_weight ON finishing_garment_weight.strOrderId = orderspec.strOrder_No AND finishing_garment_weight.strSize = orderspecdetails.strSize
					WHERE shipmentplheader.strPLNo='$plno'
					ORDER BY strSKU
					";
				
	$result_size=$db->RunQuery($sql_size);
	$preColor='';
	$totNet=0;
	while($row_size=mysql_fetch_array($result_size))
	{
		$sql_color_size_net="";
		$result_color_size_net=$db->RunQuery($sql_color_size_net);
		$row_color_size_net=mysql_fetch_array($result_color_size_net);
	  ?>
	  <tr>
	    <td class="border-top-left" style="text-align:center"><?php echo $row_size['strSKU']; ?></td>
	    <td class="border-top-left" style="text-align:center" nowrap="nowrap"><?php if($preColor!=$row_size['strColor']) echo $row_size['strColor']; else echo '""'; ?></td>
	    <td class="border-top-left" style="text-align:center">&nbsp;</td>
	    <td class="border-top-left" style="text-align:center"><?php echo $row_size['strSize']; ?></td>
	    <td class="border-top-left" style="text-align:center"><?php echo $color_w_summary[$row_size['strColor']][$row_size['strSize']]['colorTTL'];  ?></td>
        <?php
			if($preColor!=$row_size['strColor'])
			{
		?>
		<td class="border-top-left" style="text-align:center" rowspan="<?php echo $color_w_summary[$row_size['strColor']]['noOfRows'];  ?>"><?php echo $color_w_summary[$row_size['strColor']]['colorTTL'];  ?></td>
        <?php
			}
		?>
		<td class="border-top-left" style="text-align:center"><?php echo $row_size['dblWeight']; ?></td>
	    <td class="border-Left-Top-right" style="text-align:center" bgcolor="#CCCCCC"><?php echo $net_w_summary[$row_size['strColor']][$row_size['strSize']][$row_size['strSKU']];$totNet+=$net_w_summary[$row_size['strColor']][$row_size['strSize']][$row_size['strSKU']]; ?></td>
	    </tr>
		<?php
		$preColor=$row_size['strColor'];
		}
		?>
		<tr>
	    <td class="border-top" style="text-align:center">&nbsp;</td>
	    <td class="border-top" style="text-align:center">&nbsp;</td>
	    <td class="border-top" style="text-align:center">&nbsp;</td>
	    <td class="border-top-bottom-left" style="text-align:center">TOTAL</td>
	    <td class="border-top-bottom-left" style="text-align:center"><?php echo $holder_header['dblQtyPcs'];?></td>
	    <td class="border-top-bottom-left" style="text-align:center"><?php echo $holder_header['dblQtyPcs'];?></td>
	    <td class="border-top-left" style="text-align:center">&nbsp;</td>
	    <td class="border-All" style="text-align:center" bgcolor="#CCCCCC"><?php echo $totNet; ?></td>
	    </tr>
    </table>	</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td colspan="2" class="normalfnt"><u>MARKS & NOS</u></td>
    <td colspan="3">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="29%" class="normalfnt">Ship From:</td>
    <td width="71%" class="normalfnt">EAM MALIBAN TEXTILES(PVT) LTD </td>
  </tr>
  <tr>
    <td class="normalfnt">Ship To:</td>
    <td rowspan="4" valign="top" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>	</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt"><u>Dimension</u></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <?php 
		$str_ctns="SELECT (intWidth*intLength*intHeight*SUM(dblNoofCTNS)*.0000164) AS totCBM,strCartoon,sum(dblNoofCTNS) as dblNoofCTNS 
					FROM shipmentpldetail SPD
					INNER JOIN cartoon CTN ON CTN.intCartoonId=  SPD.strCTN
					WHERE strPLNo=$plno group by strCartoon";
		$result_cdn=$db->RunQuery($str_ctns);
		while($row_cdn=mysql_fetch_array($result_cdn))
		{?>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt" nowrap="nowrap">1)-cm <?php echo $row_cdn['strCartoon'];?> </td>
    <td class="normalfnt" style="text-align:center"><?php echo $row_cdn['dblNoofCTNS'];$tot_ctns+=$row_cdn['dblNoofCTNS'];?></td>
    <td class="normalfnt" style="text-align:center"><?php echo number_format($row_cdn['totCBM'],2);$tot_cbm+=number_format($row_cdn['totCBM'],2);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt">&nbsp;</td>
    <td class="border-top" style="text-align:center"><?php echo $tot_ctns;?></td>
    <td class="border-top" style="text-align:center"><?php echo number_format($tot_cbm,2);?></td>
    <td class="normalfnt">CBM</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt">&nbsp;</td>
    <td class="border-top" style="text-align:center">&nbsp;</td>
    <td class="border-top" style="text-align:center">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-top-left">Net Weight - </td>
    <td class="border-top-left" style="text-align:center"><?php echo $holder_header['dblTotNet'];?></td>
    <td class="border-left">Kg</td>
    <td class="normalfnt">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-top-left">Weight - </td>
    <td class="border-top-left" style="text-align:center"><?php echo round($holder_header['dblTotNetNet'],2);?></td>
    <td class="border-left">Kg</td>
    <td class="normalfnt">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-top-left">ss Weight - </td>
    <td class="border-top-left" style="text-align:center"><?php echo round($holder_header['dblTotGross'],2);?></td>
    <td class="border-left">Kg</td>
    <td class="normalfnt">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-top">&nbsp;</td>
    <td class="border-top" style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>


</body>
</html>
