<?php
include "../../../Connector.php";
$backwardseperator = "../../../";
$strScheduleNo = $_GET["intScheduleNo"];
$arrNo = explode('/',$strScheduleNo);
$intScheduleNo = $arrNo[0];
$intYear = $arrNo[2];
$intMonth = $arrNo[1];
//$intScheduleNo = '100006';
switch($intMonth)
{
	case 1:
	{
		$strMonth = 'January';
		break;
	}
	case 2:
	{
		$strMonth = 'February';
		break;
	}
	case 3:
	{
		$strMonth = 'March';
		break;
	}
	case 4:
	{
		$strMonth = 'April';
		break;
	}
	case 5:
	{
		$strMonth = 'May';
		break;
	}
	case 6:
	{
		$strMonth = 'June';
		break;
	}
	case 7:
	{
		$strMonth = 'July';
		break;
	}
	case 8:
	{
		$strMonth = 'August';
		break;
	}
	case 9:
	{
		$strMonth = 'September';
		break;
	}
	case 10:
	{
		$strMonth = 'October';
		break;
	}
	case 11:
	{
		$strMonth = 'November';
		break;
	}
	case 12:
	{
		$strMonth = 'December';
		break;
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Shipment Plan :: Month</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="head2BLCK">Estimate Shipment Plan - <?php echo $strMonth; ?> - <?php echo $intYear; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="850" border="0" cellspacing="1" cellpadding="1"  align="center" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <td width="78" height="25" >PO #</td>
        <td width="186" >Description</td>
        <td width="102" >Style</td>
        <td width="75" >Col</td>
        <td width="100" >Dim</td>
        <td width="87" >Qty/dz</td>
        <td width="87" >PO ETD</td>
        <td width="133" >Remarks</td>
      </tr>
      <?php 
	  $sql = "select o.strOrderNo,o.strStyle,o.strDescription,sum(fms.dblQty) as planQty,fms.strRemarks,
o.strColorCode,o.dblDimension,fms.dtmHODate,date_format(fms.dtmDeliveryDate,'%m/%d') as dtmDeliveryDate,date_format(fms.dtmHODate,'%m/%d') as HOdate
from finishing_month_schedule_details fms inner join orders o on o.intStyleId = fms.intStyleId
where fms.intScheduleNo='$intScheduleNo'
group by fms.dtmHODate,fms.intStyleId
order by fms.dtmHODate,o.strOrderNo";
	$result = $db->RunQuery($sql);
	$firstRow = true;
	$subTot = 0;
	while($row=mysql_fetch_array($result))
	{
		$currHOdate = $row["dtmHODate"];
		$color = ($row["strColorCode"] == ''?'&nbsp;':$row["strColorCode"]);
		$dim = ($row["dblDimension"] == ''?'&nbsp;':$row["dblDimension"]);
		$remarks = ($row["strRemarks"] == ''?'&nbsp;':$row["strRemarks"]);
		
		if($firstRow == true)
		{
			$preHOdate = $row["dtmHODate"];
			$subTot += $row["planQty"];
	  ?>
      	<tr bgcolor="#F7F7F7">
        <td colspan="8" class="normalfnt" height="22">Shipment Handover On - <?php echo $row["HOdate"]; ?></td>
        </tr>
      <tr class="bcgcolor-tblrowWhite">
        <td class="normalfnt" height="20" nowrap="nowrap"><?php echo $row["strOrderNo"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strDescription"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strStyle"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $color; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $dim; ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["planQty"]; ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dtmDeliveryDate"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $remarks; ?></td>
      </tr>
      	<?php
		$firstRow = false; 
			}
			else
			{
				if($preHOdate!=$currHOdate)
				{
		?>
        <tr bgcolor="#F7F7F7">
        <td colspan="5" class="normalfntMid" height="20">Total Qty </td>
        <td class="normalfntMid"><?php echo $subTot; $subTot=0; ?></td>
        <td colspan="2" class="normalfntMid">&nbsp;</td>
        </tr>
        <tr bgcolor="#F7F7F7">
        <td colspan="8" class="normalfnt" height="22">Shipment Handover On - <?php echo $row["HOdate"]; ?></td>
        </tr>
         <tr class="bcgcolor-tblrowWhite">
        <td class="normalfnt" height="20" nowrap="nowrap"><?php echo $row["strOrderNo"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strDescription"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strStyle"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $color; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $dim; ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["planQty"]; ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dtmDeliveryDate"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $remarks; ?></td>
      </tr>
      <?php 
	  $subTot += $row["planQty"];
	  			}
				else
				{
				$subTot += $row["planQty"];
	  ?>
      <tr class="bcgcolor-tblrowWhite">
        <td class="normalfnt" height="20" nowrap="nowrap"><?php echo $row["strOrderNo"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strDescription"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strStyle"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $color; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $dim; ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["planQty"]; ?></td>
        <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dtmDeliveryDate"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $remarks; ?></td>
      </tr>
        <?php 
				}
			}
		?>
      <?php 
	  	$preHOdate = $currHOdate;
	  }
	  ?>
       <tr bgcolor="#F7F7F7">
        <td colspan="5" class="normalfntMid" height="20">Total Qty </td>
        <td class="normalfntMid"><?php echo $subTot; $subTot=0; ?></td>
        <td colspan="2" class="normalfntMid">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
