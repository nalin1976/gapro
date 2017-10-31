<?php 
include "../../../Connector.php";
include "../../../eshipLoginDB.php";
$backwardseperator = "../../../";
$intScheduleNo = $_GET["wkScheduleNo"];
$destId = $_GET["destId"];
//$arrScheduleNo = explode('/',$intScheduleNo);
$intSno = $intScheduleNo;

$arr_DestList = array();
	$DestinationID = explode(",",$destId);
	$loop=0;
	
	$conntVal=0.0000164;
	//$dest_List = implode(",",$arr_DestList);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Shipment Plan :: Week</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="head2BLCK">Weekly Shipment Plan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
       <th width="77" height="22" >FTY</th>
        <th width="77" >PO #</th>
        <th width="185" >Description</th>
        <th width="98" >Main Product Code</th>
        <th width="55" >Season Code</th>
         <th width="55" >Wash Code</th>
        <th width="47" >Color</th>
        <th width="79" >PO Qty(Doz)</th>
        <th width="68" >Qty(Ctn)</th>
        <th width="80" >Qty(Pcs)</th>
        <th width="65" >PO ETD</th>
        <th width="87" >Fabric</th>
        <th width="40" >L(INH)</th>
        <th width="40" >W(INH)</th>
        <th width="40" >H(INH)</th>
        <th width="40" >CBM</th>
        <th width="79" >ISD #</th>
        <th width="79" >DC #</th>
         <th width="79" >DO #</th>
        <th width="107" >Destination</th>
        
      </tr>
      </thead>
      <?php 
	 $firstRow = true;
	  foreach($DestinationID as $value)
		{
			//$arr_DestList[$loop] ="'" . $value . "'";
			//$loop++;
			$arrVal = explode('*',$value);
			$cityId = $arrVal[0];
			$mode = $arrVal[1];
			$currCityId = $cityId;
			
			if($firstRow)
			{
				$preCityId = $arrVal[0];
				$shipMode = getShipMode($mode);
				$preMode =  $arrVal[1];
	  ?>
       <tr bgcolor="#EBEBEB">
       <td colspan="20" class="normalfnt" height="20"><?php echo getDestination($arrVal[0]).'  '.$shipMode;?></td>
       </tr>
       <?php 
	   $firstRow = false;
		}
			else
			{
				if((($currCityId != $preCityId) && $value !='')  || (($preMode != $mode) && $value !=''))
				{
					$shipMode = getShipMode($mode);
					
	   ?>
       	 <tr bgcolor="#EBEBEB">
       <td colspan="20" class="normalfnt" height="20"><?php echo getDestination($arrVal[0]).'  '.$shipMode;?></td>
       </tr>
       <?php
	   			} 
	   		}
	   ?>
        <?php 
		
		$totQty =0;
		$totCtn=0;
		$totCBM =0;
	  $sql = " Select o.strOrderNo,o.strStyle,o.strDescription,fwsd.intCityId,fwsd.strType,fwsd.dblCtnQty,fwsd.dblPcsQty,
date(fmsd.dtmDeliveryDate) as POETD,fmsd.dblDelQty,o.intStyleId,o.intSeasonId,o.strColorCode,c.strComCode,fos.strMaterialNo,
fos.dblCTN_l,fos.dblCTN_w,fos.dblCTN_h,fos.strWashCode,fwsd.strISDNo,fwsd.strDCNo,fwsd.strDONo  
from orders o inner join finishing_week_schedule_details fwsd on 
o.intStyleId = fwsd.intStyleId inner join finishing_month_schedule_details fmsd on 
fmsd.intScheduleDetailId= fwsd.intMonthScheduleDetId 
inner join companies c on c.intCompanyID = o.intCompanyID
inner join finishing_order_spec fos on fos.intStyleId = o.intStyleId
where fwsd.intWkScheduleId='$intSno' and fwsd.intCityId='$cityId' and fwsd.strType = '$mode'";
//echo $sql;
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		//$fabric = getMainFabric($row["strStyle"]);
		$destination = getDestination($row["intCityId"]);
		$colorCode = $row["strColorCode"];
	  ?>
      <tr class="bcgcolor-tblrowWhite">
       <td width="77" class="normalfnt" height="20" nowrap="nowrap"><?php echo $row["strComCode"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strOrderNo"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strDescription"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strStyle"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["intSeasonId"]; ?></td>
         <td class="normalfnt" nowrap="nowrap"><?php echo $row["strWashCode"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo ($colorCode == ''? '&nbsp;':$colorCode); ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dblDelQty"]; ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dblCtnQty"]; ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dblPcsQty"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["POETD"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strMaterialNo"];?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dblCTN_l"];?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dblCTN_w"];?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dblCTN_h"];?></td>
       <td class="normalfntRite" nowrap="nowrap"><?php
	   $cbm = $conntVal*$row["dblCTN_l"]*$row["dblCTN_w"]*$row["dblCTN_h"]*$row["dblCtnQty"];
	    echo round($cbm,2); ?></td> 
          <td class="normalfnt" nowrap="nowrap"><?php echo $row["strISDNo"]; ?></td>
            <td class="normalfnt" nowrap="nowrap"><?php echo $row["strDCNo"]; ?></td>
              <td class="normalfnt" nowrap="nowrap"><?php echo $row["strDONo"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $destination; ?></td>
       
      </tr>
      <?php 
	  $totQty += $row["dblPcsQty"];
		$totCtn += $row["dblCtnQty"];
		$totCBM += round($cbm,2);
	  }
	  if($totQty !=0)
	  {
	  ?>
      <tr class="bcgcolor-tblrowWhite">
      <td colspan="8" height="20">&nbsp;</td>
      <td class="normalfntRite"><?php echo $totCtn; ?></td>
       <td class="normalfntRite"><?php echo $totQty; ?></td>
        <td colspan="5"></td>
        <td class="normalfntRite"><?php echo $totCBM; ?></td>
       <td colspan="4"></td> 
      </tr>
      <?php
	  } 
	  		$preCityId = $currCityId;
			$preMode = $mode;
	  }
	  ?>
     
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getMainFabric($styleId)
{
	global $db;
	$sql = "select mil.strItemDescription from matitemlist mil inner join orderdetails od on od.intMatDetailID = mil.intItemSerial inner join orders o on
o.intStyleId = od.intStyleId where od.intMainFabricStatus=1 and o.intStyleId='$styleId'";
	$result = $db->RunQuery($sql);
	$rows = mysql_fetch_array($result);
	
	return $rows["strItemDescription"];
}

function getDestination($city)
{
	$eshipDB = new eshipLoginDB();
	$sql = "select strCity from city where strCityCode = '$city' ";
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strCity"];
}

function getShipMode($mode)
{
	global $db;
	$sql = "select strCode from shipmentmode where intShipmentModeId='$mode' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strCode"];
}
?>
</body>
</html>
