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
					round(Sum(shipmentpldetail.dblTotGross),2) AS dblTotGross,
					round(Sum(shipmentpldetail.dblTotNet),2) AS dblTotNet,
					round(Sum(shipmentpldetail.dblTotNetNet),2) AS dblTotNetNet,
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
					buyers.strCountry As buyerCountry,
					shipmentplheader.strInvNo
					FROM
					shipmentplheader
					INNER JOIN shipmentpldetail ON shipmentpldetail.strPLNo = shipmentplheader.strPLNo
					INNER JOIN orderspec ON shipmentplheader.strStyle = orderspec.strOrder_No
					INNER JOIN customers ON customers.strCustomerID = shipmentplheader.strFactory
					INNER JOIN buyers ON buyers.strBuyerID = shipmentplheader.strShipTo
					where
					shipmentplheader.strPLNo='$plno'
					group by strPLNo
					";

$result_header	=$db->RunQuery($str_header);
$holder_header	=mysql_fetch_array($result_header);

$str_dyn		="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno'";
$result_dyn		=$db->RunQuery($str_dyn);

$col_dyn		=mysql_num_rows($result_dyn);

$col_width		=90/($col_dyn+13);
$orderNo = $holder_header['strStyle'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Packing List-EDDIE BAUER</title>
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
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="147">&nbsp;</td>
    <td width="152">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="29">&nbsp;</td>
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
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
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
    
    <td colspan="4" style="text-align:center;font-size:18px;" class="normalfnBLD1"><?php echo $holder_header['buyerCountry']; ?></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6" class="normalfnBLD1"><u>SHIPPER NAME &amp; ADDRESS</u></td>
     <td class="normalfnBLD1" style="text-align:right"><u>CONSIGNEE:</u></td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnBLD1">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo $Company; ?></td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnBLD1"><?php echo $holder_header['buyerName']; ?></td>
    <td>&nbsp;</td>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo $Address;  ?></td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnBLD1"><?php echo $holder_header['buyerAddress1']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo $City ?></td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnBLD1"><?php echo $holder_header['buyerAddress2']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo $phone; ?></td>
    <td>&nbsp;</td>
     <td colspan="5" class="normalfnBLD1"><?php echo $holder_header['buyerCountry']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
    <td colspan="8" class="normalfnBLD1" >COMMERCIAL INVOICE #:&nbsp;<?php /*echo $holder_header['strInvNo']*/; ?></td>
    <!--<td colspan="2">&nbsp;</td>-->
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
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
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6" class="normalfnBLD1"><u>MANUFACTURE NAME &amp; ADDRESS </u></td>
    <td class="normalfnBLD1" style="text-align:right"><u>SHIP TO:</u></td>
    <td>&nbsp;</td>
    <td class="normalfnBLD1">&nbsp;</td>
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td colspan="2" class="normalfnBLD1" style="text-align:center"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo $holder_header['strName']; ?></td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnBLD1"><?php echo $holder_header['buyerName']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1; border-All" nowrap="nowrap">ORDER QTY:&nbsp;</td>
    <td colspan="2" class="normalfnBLD1; border-All" style="text-align:right"><?php echo round($holder_header['ordpcs'],0);?>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo  $holder_header['strAddress1'] .", ".$holder_header['strMLocation'] ?></td>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnBLD1"><?php echo $holder_header['buyerAddress1']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1; border-All">SHIP QTY:&nbsp;</td>
    <td colspan="2" class="normalfnBLD1; border-All" style="text-align:right"><?php echo $holder_header['dblQtyPcs']; ?>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1" >&nbsp;</td>
    <td colspan="4" class="normalfnBLD1" ><?php echo $holder_header['strCountry']; ?></td>
    <td style="text-align:right" class="normalfnBLD1">&nbsp;</td>
    <td colspan="5" class="normalfnBLD1"><?php echo $holder_header['buyerAddress2']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1; border-All">&nbsp;</td>
    
    
    <td colspan="2" class="normalfnBLD1; border-All" style="text-align:right"><?php echo round((($holder_header['dblQtyPcs']*100)/$holder_header['ordpcs']),2) ;?>%&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6" class="normalfnBLD1">&nbsp;</td>
    <td class="normalfnBLD1" style="text-align:right">&nbsp;</td>
     <td colspan="5" class="normalfnBLD1"><?php echo $holder_header['buyerCountry']; ?></td>
    <td>&nbsp;</td>
    <td></td>
    <?php $mode=explode(" ", $holder_header['strTrnsportMode']); ?>
    <td colspan="2" class="normalfnBLD1; border-All">MODE:&nbsp;</td>
    <td colspan="2" class="normalfnBLD1; border-All" style="text-align:right" nowrap="nowrap"><?php echo $mode[0]; ?>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1" style="text-align:center">EDDIE BAUER PO NO:</td>
    <td >&nbsp;</td>
    <td class="normalfnBLD1" style="text-align:center">STYLE NO:</td>
    <td >&nbsp;</td>
    <td class="normalfnBLD1" style="text-align:center">TTL PCS</td>
    <td>&nbsp;</td>
    <td style="text-align:center"><span class="normalfnBLD1">TTL CTNS</span></td>
    
    <td>&nbsp;</td>
    <td></td>
    <?php $sailingDate= explode(" ", $holder_header['strSailingDate']); ?>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" class="normalfnBLD1; border-All">DATE:&nbsp;</td>
    <td colspan="2" class="normalfnBLD1; border-All" style="text-align:right"><?php echo $sailingDate[0]; ?>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnBLD1; border-All" style="text-align:center"><?php echo $holder_header['strStyle'];?></td>
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td class="normalfnBLD1; border-All"  style="text-align:center"><?php echo $holder_header['strProductCode'];?></td>
    <td class="normalfnBLD1">&nbsp;</td>
    <td class="border-All" style="text-align:center"><span class="normalfnBLD1"><?php echo $holder_header['dblQtyPcs'];?></span></td>
    <td>&nbsp;</td>
    <td style="text-align:center" class="border-All"><span class="normalfnBLD1"><?php echo $holder_header['dblNoofCTNS'];?></span></td>
    <td>&nbsp;</td>
    <td colspan="10" class="normalfnBLD1">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:center"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="6" class="normalfnBLD1"><U>Style Description :</U></td>
    <td>&nbsp;</td>
    <td valign="top" class="normalfnBLD1">&nbsp;</td>
    <td valign="top" class="normalfnBLD1">&nbsp;</td>
    <td valign="top" class="normalfnBLD1">&nbsp;</td>
    <td valign="top" class="normalfnBLD1">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="4">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="70">&nbsp;</td>
    <td width="126">&nbsp;</td>
    <td width="135">&nbsp;</td>
    <td width="128">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="39">&nbsp;</td>
    <td colspan="6" class="normalfnBLD1"><?php echo $holder_header['strLable']; ?></td>
    <td colspan="4" class="normalfnBLD1" valign="top">&nbsp;</td>
    <td width="4">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="22">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    	 <tr>
         
         <td colspan="3" nowrap="nowrap" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">CTN NO</span></td>
    <td nowrap="nowrap" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">NO OF CTN</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">UPC #</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">COLOR NAME</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">BUYER ITEM #</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">SIZE</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">TOTAL PIECES BY SKU IN EACH CARTON</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">PACK QTY</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">O/QTY</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">3%</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">%</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">TOTAL PIECES</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">CTN M.MENT CM</span></td>
    <td width="" bgcolor="#CCCCCC" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">NET NET Weight PER CTN</span></td>
    <td class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">NET. WGHT. PER CTN</span></td>
    <td colspan="3" class="border-top-left" bgcolor="#CCCCCC" style="text-align:center"><span class="normalfnBLD1">GROSS. WGHT PER CTN</span></td>
    
   
    <td width="" bgcolor="#CCCCCC" class="border-Left-Top-right" style="text-align:center"><span class="normalfnBLD1">TTL GROSS WEGHT</span></td>
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
					SUM(shipmentpldetail.dblTotGross) AS TTLWeight
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
		$noColor = $row_array["strColor"];
		$noSize  = $row_array["strSize"];
		
		$sql_no_rows="SELECT
						shipmentplsizeindex.strSize,
						SUM(shipmentpldetail.dblQtyPcs) AS packQty
						FROM
						shipmentpldetail
						INNER JOIN shipmentplsizeindex ON shipmentplsizeindex.strPLNo = shipmentpldetail.strPLNo
						INNER JOIN shipmentplsubdetail ON shipmentplsubdetail.intRowNo = shipmentpldetail.intRowNo AND shipmentplsubdetail.strPLNo = shipmentpldetail.strPLNo AND shipmentplsubdetail.intColumnNo = shipmentplsizeindex.intColumnNo
						WHERE strColor='$noColor' AND shipmentpldetail.strPLNo=$plno AND shipmentplsizeindex.strSize='$noSize'";
		$resultNo=$db->RunQuery($sql_no_rows);
		
		$sql_no_rows2="SELECT
orderspecdetails.strSize,
orderspecdetails.strColor,
sum(orderspecdetails.dblPcs) AS dblPcs
FROM
orderspec
INNER JOIN orderspecdetails ON orderspecdetails.intOrderId = orderspec.intOrderId
WHERE orderspec.strOrder_No='$orderNo' AND orderspecdetails.strColor='$noColor' AND orderspecdetails.strSize='$noSize'
GROUP BY strColor,strSize,strSKU
";
		$resultNo2=$db->RunQuery($sql_no_rows2);
		
		$rowQty	= mysql_fetch_array($resultNo);
		
		$rowQty2	= mysql_fetch_array($resultNo2)	;		
		
		
		$sql_no_rows1="SELECT
						shipmentplsizeindex.strSize
						FROM
						shipmentpldetail
						INNER JOIN shipmentplsizeindex ON shipmentplsizeindex.strPLNo = shipmentpldetail.strPLNo
						INNER JOIN shipmentplsubdetail ON shipmentplsubdetail.intRowNo = shipmentpldetail.intRowNo AND shipmentplsubdetail.strPLNo = shipmentpldetail.strPLNo AND shipmentplsubdetail.intColumnNo = shipmentplsizeindex.intColumnNo
						WHERE strColor='$noColor' AND shipmentpldetail.strPLNo=$plno AND shipmentplsizeindex.strSize='$noSize'";
		$resultNo1=$db->RunQuery($sql_no_rows1);
		
		
		
		$size_w_summary[$row_array["strColor"]][$row_array["strSize"]]["packQty"]=$rowQty['packQty'];
		$size_w_summary[$row_array["strColor"]][$row_array["strSize"]]["orderedQty"]=$rowQty2['dblPcs'];
		$size_w_summary[$row_array["strColor"]][$row_array["strSize"]]["noOfRows"]=mysql_num_rows($resultNo1);
		$size_w_summary1[$row_array["strColor"]][$row_array["strSize"]][$row_array["strSKU"]]=$row_array['TTLWeight'];
		
		$color_w_summary[$row_array["strColor"]]["noOfRows"]+=1;
		$color_w_summary[$row_array["strColor"]][$row_array["strSize"]]["colorTTL"]+=$rowQty['packQty'];
		$color_w_summary[$row_array["strColor"]]["colorTTL"]+=$rowQty['packQty'];
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
						orderspecdetails.strPliNo,
						shipmentpldetail.strColor,
						orderspecdetails.strColorCode
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
		  $totCBM=0;
		  $totWeight=0;
		 while($row_row_data=mysql_fetch_array($result_row_data))
		 {
  ?>
  
  

    <td class="border-top-left"  style="text-align:center"><?php echo $row_row_data['dblPLNoFrom']; ?></td>
    <td colspan="2" class="border-top-left" style="text-align:center;"><span class="normalfnt"><?php echo $row_row_data['dblPlNoTo']; ?></span></td>
    <?php
		$noOfCTNS=$row_row_data['dblPlNoTo']-$row_row_data['dblPLNoFrom']+1;
	?>
    <td class="border-top-left" style="text-align:center; width:5%"><span class="normalfnt"><?php echo $noOfCTNS;$tot_NoofCTNS+=$noOfCTNS;?></span></td>
	
    <td class="border-top-left" style="text-align:center; width:12%"><?php if($preSku!=$row_row_data['strSKU'])echo $row_row_data['strSKU']; else echo '""'; ?></td>
    <td class="border-top-left" style="text-align:center; width:20%"><span class="normalfnt"><?php if($pre_row_color!=$row_row_data['strColor']) echo $row_row_data['strColor']."(".$row_row_data['strColorCode'].")";  else echo '""';?></span></td>
    <td class="border-top-left" style="text-align:center; width:20%" nowrap="nowrap"><span class="normalfnt"><?php echo $row_row_data['strColorCode']; ?></span></td>
    <td class="border-top-left" style="text-align:center; width:5%"><span class="normalfnt"><?php echo $row_row_data['strSize']; ?></span></td>
    <td class="border-top-left" style="text-align:center"><span class="normalfnt"><?php echo $row_row_data['dblPcs']; ?></span></td>
	<?php
	$net_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]][$row_row_data['strSKU']]+=$row_row_data['dblTotNet'];
		if($preSku!=$row_row_data['strSKU'])
		{
	?>
    	<td class="border-top-left" style="text-align:center; width:5%" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><span class="normalfnt"><?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["packQty"]; ?></span></td>
    	<td class="border-top-left" style="text-align:center; width:5%" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><span class="normalfnt"><?php echo round($size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["orderedQty"],0); ?></span></td>
    	<td class="border-top-left" style="text-align:center; width:5%" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><span class="normalfnt"><?php echo round(($size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["orderedQty"]*1.03),0); ?></span></td>
    	<td class="border-top-left" nowrap="nowrap" style="text-align:center; width:5%" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><span class="normalfnt"><?php echo round(($size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["packQty"]*100/$size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["orderedQty"]),0) ?></span></td>
      <?php
		}
	  ?>
    <td class="border-top-left" style="text-align:center; width:5%"><span class="normalfnt"><?php echo $row_row_data['dblQtyPcs'];$tot_QtyPcs+=$row_row_data['dblQtyPcs'];?></span></td>
    <td class="border-top-left" style="text-align:center; width:20%" nowrap="nowrap"><span class="normalfnt"><?php echo $row_row_data["strCartoon"];?></span></td>
    <td class="border-top-left" style="text-align:center; width:5%"><span class="normalfnt"><?php echo $row_row_data["dblTotNetNet"]; ?></span></td>
    <td class="border-top-left" style="text-align:center; width:5%"><span class="normalfnt"><?php echo $row_row_data["dblNet"]; ?></span></td>
    <td colspan="3" class="border-top-left" style="text-align:center; width:5%"><span class="normalfnt"><?php echo $row_row_data["dblGorss"]; ?></span></td>
    
    
   
   <?php
   		if($preSku!=$row_row_data['strSKU'])
		{
   ?>
   
    <td class="border-Left-Top-right" style="text-align:center; width:5%" rowspan="<?php echo $size_w_summary[$row_row_data["strColor"]][$row_row_data["strSize"]]["noOfRows"]; ?>"><span class="normalfnt"><?php echo round($size_w_summary1[$row_row_data["strColor"]][$row_row_data["strSize"]][$row_row_data["strSKU"]],2); $totWeight+=round($size_w_summary1[$row_row_data["strColor"]][$row_row_data["strSize"]][$row_row_data["strSKU"]],2); ?></span></td>
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
    <td colspan="3" class="border-top">&nbsp;</td>
    <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1"><?php echo $tot_NoofCTNS;?></span></td>
    <td colspan="2" class="border-top-left">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1"><?php echo $holder_header['dblQtyPcs'];?></span></td>
    <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1"><?php echo round($holder_header['ordpcs'],0); ?></span></td>
    <td class="border-top-left">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1"><?php echo $holder_header['dblQtyPcs'];?></span></td>
    <td class="border-top-left">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td colspan="2" class="border-top">&nbsp;</td>
    <td class="border-top" style="text-align:center">&nbsp;</td>
    <td class="border-All" style="text-align:center"><span class="normalfnBLD1"><?php echo $totWeight; ?></span></td>
    <td class="" style="text-align:center">&nbsp;</td>
    <td class="" style="text-align:center">&nbsp;</td>
    </tr>
 
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
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
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td colspan="3" rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td colspan="7" rowspan="2"><table width="500" border="0" cellpadding="0" cellspacing="0">
      <tr>
      <td width="46">&nbsp;</td>
      <td width="46">&nbsp;</td>
        <td colspan="3" class="border-top-left" nowrap="nowrap"><span class="normalfnBLD1">COLOR SUMMARY &amp; SIZE BREAKDOWN </span></td>
        <td width="46" class="border-top-left">&nbsp;</td>
        <td width="72" class="border-left">&nbsp;</td>
        <td width="58">&nbsp;</td>
        <td width="47">&nbsp;</td>
      </tr>
	  <tr>
      <td width="56" ><span class="normalfnBLD1">&nbsp;</span></td>
        <td width="56" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">UPC #</span></td>
        <td width="84" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">COLOR CODE</span></td>
        <td width="84" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">BUYER ITEM#</span></td>
        <td width="46" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">SIZE</span></td>
        <td width="72" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">TOTAL</span></td>
        <td width="58" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">Color TTL</span></td>
        <td width="47" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">Wt.Per Pce</span></td>
        <td width="44" class="border-Left-Top-right" style="text-align:center"><span class="normalfnBLD1">Net Net Wt</span></td>
      </tr>
	  <?php
	$sql_size="SELECT DISTINCT
				ssi.strSize,
				shipmentpldetail.strColor,
				shipmentpldetail.dblTotNetNet,
				orderspecdetails.strPliNo,
				orderspec.strOrder_No,
				orderspecdetails.strSKU,
				orderspecdetails.strColorCode,
				finishing_garment_weight.dblWeight
				FROM
				shipmentplsizeindex AS ssi
				LEFT JOIN shipmentplsubdetail AS ssd ON ssi.intColumnNo = ssd.intColumnNo AND ssi.strPLNo = ssd.strPLNo
				INNER JOIN shipmentpldetail ON shipmentpldetail.intRowNo = ssd.intRowNo AND shipmentpldetail.strPLNo = ssd.strPLNo
				INNER JOIN shipmentplheader ON shipmentplheader.strPLNo = ssd.strPLNo
				INNER JOIN orderspec ON orderspec.strOrder_No = shipmentplheader.strStyle
				INNER JOIN orderspecdetails ON orderspecdetails.intOrderId = orderspec.intOrderId AND orderspecdetails.strColor = shipmentpldetail.strColor AND orderspecdetails.strSize = ssi.strSize
				
				INNER JOIN finishing_garment_weight ON shipmentplheader.strStyle = finishing_garment_weight.strOrderId AND ssi.strSize = finishing_garment_weight.strSize
				where ssi.strPLNo='$plno' AND ssd.dblPcs!=''
				GROUP BY strSKU
				ORDER BY strColor,strSKU";
				
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
      <td ><span class="normalfnt"></span></td>
      <td class="border-top-left"><span class="normalfnt"><?php /*if($preSku!=$row_size['strSKU'])echo $row_size['strSKU']; else echo '""';*/ echo $row_size['strSKU']; ?></span></td>
	    <td class="border-top-left" style="text-align:center; width:20%"><span class="normalfnt"><?php if($preColor!=$row_size['strColor']) echo $row_size['strColor']."(".$row_size['strColorCode'].")"; else echo '""'; ?></span></td>
	    <td class="border-top-left" style="text-align:center; width:20%" nowrap="nowrap"><span class="normalfnt"><?php echo $row_size['strColorCode']; ?></span></td>
	    <td class="border-top-left" style="text-align:center; width:8%"><span class="normalfnt"><?php echo $row_size['strSize']; ?></span></td>
	    <td class="border-top-left" style="text-align:center; width:8%"><span class="normalfnt"><?php echo $color_w_summary[$row_size['strColor']][$row_size['strSize']]['colorTTL'];  ?></span></td>
		
        <?php
			if($preColor!=$row_size['strColor'])
			{
		?>
        		<td class="border-top-left" style="text-align:center; width:8%" rowspan="<?php echo $color_w_summary[$row_size['strColor']]['noOfRows'];  ?>"><span class="normalfnBLD1"><?php echo $color_w_summary[$row_size['strColor']]['colorTTL'];  ?></span></td>
		<?php
			}
		?>
        <td class="border-top-left" style="text-align:center; width:8%"><span class="normalfnt"><?php echo $row_size['dblWeight']; ?></span></td>
	    <td class="border-Left-Top-right" style="text-align:center; width:8%"><span class="normalfnt"><?php echo $row_size['dblTotNetNet']; ?></span></td>
	    </tr>
		<?php
			$preColor=$row_size['strColor'];
		}
		?>
		<tr>
         <td style="text-align:center">&nbsp;</td>
          <td class="border-top" style="text-align:center">&nbsp;</td>
	    <td class="border-top" style="text-align:center">&nbsp;</td>
	    <td class="border-top" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1">TOTAL</span></td>
	    <!--<td class="border-top" style="text-align:center">&nbsp;</td>-->
	    <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1"><?php echo $holder_header['dblQtyPcs'];?></span></td>
	    <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1"><?php echo $holder_header['dblQtyPcs'];?></span></td>
	    <td class="border-top-left" style="text-align:center">&nbsp;</td>
	    <td class="border-All" style="text-align:center"><span class="normalfnBLD1"><?php echo round($holder_header['dblTotNetNet'],2);?></span></td>
         
	    </tr>
    </table>	 
    <td colspan="2" class="normalfnBLD1">&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td></td>
    </tr>
</table>	</td>
  </tr>
  
 <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
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
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
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
    <td colspan="4" class="normalfnBLD1" style="font-size:9px">CTN Dimension(L*W*H):- </td>
    <td class="normalfnBLD1" style="font-size:9px"><span class="normalfnBLD1" style="font-size:9px"><?php echo $row_cdn['strCartoon'];?></span></td>
    <td class="normalfnBLD1" style="text-align:center"><?php echo $row_cdn['dblNoofCTNS'];$tot_ctns+=$row_cdn['dblNoofCTNS'];?></td>
    <td class="normalfnBLD1" style="text-align:center"><?php echo number_format($row_cdn['totCBM'],2);$tot_cbm+=number_format($row_cdn['totCBM'],2);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="normalfnBLD1">&nbsp;</td>
    <td class="normalfnBLD1" style="text-align:center"><?php echo $tot_ctns;?></td>
    <td class="border-top" style="text-align:center"><span class="normalfnBLD1"><?php echo number_format($tot_cbm,2);?>CBM</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="normalfnBLD1">&nbsp;</td>
    <td style="text-align:center">&nbsp;</td>
    <td style="text-align:center">&nbsp;</td>
    <td class="border-top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
    <td colspan="3" style="text-align:left"><span class="normalfnBLD1"><u>MARKS &amp; NOS</u></span></td>
    
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnBLD1" style="font-size:9px" nowrap="nowrap">Net Net Weight - </td>
    <td class="normalfnBLD1" style="font-size:9px">&nbsp;</td>
    <td class="normalfnBLD1" nowrap="nowrap"><span class="normalfnBLD1" style="text-align:right"><?php echo round($holder_header['dblTotNetNet'],2);?></span></td>
    <td class="normalfnBLD1" style="font-size:9px">Kg</td>
    <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
    <td class="normalfnBLD1">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" style="text-align:left"><span class="normalfnBLD1">Ship From:</span></td>
    <td colspan="4" class="normalfnBLD1"><?php echo $Company; ?></td>
    
    
    
    <td colspan="">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  

  <tr>
    <td>&nbsp;</td>
    <td class="normalfnBLD1" style="font-size:9px" nowrap="nowrap">Net Weight - </td>
    <td class="normalfnBLD1" style="font-size:9px">&nbsp;</td>
    <td class="normalfnBLD1" nowrap="nowrap"><span class="normalfnBLD1" style="text-align:right"><?php echo round($holder_header['dblTotNet'],2);?></span></td>
    <td class="normalfnBLD1" style="font-size:9px">Kg</td>
    <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
    <td class="normalfnBLD1">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" style="text-align:left"><span class="normalfnBLD1">Ship To:</span></td>
    <td colspan="4" class="normalfnBLD1"><?php echo $holder_header['buyerName']; ?></td>
    
    
    
    <td colspan="">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnBLD1" style="font-size:9px" nowrap="nowrap">Gross Weight - </td>
    <td class="normalfnBLD1" style="font-size:9px">&nbsp;</td>
    <td class="normalfnBLD1" nowrap="nowrap"><span class="normalfnBLD1" style="text-align:right"><?php echo round($holder_header['dblTotGross'],2);?></span></td>
    <td class="normalfnBLD1" style="font-size:9px">Kg</td>
    <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
    <td class="normalfnBLD1">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo $holder_header['buyerAddress1']; ?></td>
    
    
    
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo $holder_header['buyerAddress2']; ?></td>
    
    
    
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td style="text-align:center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="4" class="normalfnBLD1"><?php echo $holder_header['buyerCountry']; ?></td>
    
    
    
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>


</body>
</html>
