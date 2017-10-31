<?php
session_start();
include "../../Connector.php";
$backwardseperator 	= '../../';
$report_companyId 	= $_SESSION["FactoryID"];
$xml = simplexml_load_file('../../config.xml');
$reportname = $xml->PreOrder->ReportName;
$profitMargin = $xml->companySettings->MinimumProfitMargin;

$txtDfrom  	= $_GET["txtDfrom"];
$txtDto    	= $_GET["txtDto"];
$checkDate	= $_GET["checkDate"];
$buyer		= $_GET["Buyer"];
$chkDelDate	= $_GET["chkDelDate"];
$delDfrom	= $_GET["delDfrom"];
$delDto		= $_GET["delDto"];
$orderType	= $_GET["orderType"];
$division	= $_GET["Division"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Style Wise Material Cost Counting Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>
<body>
<style type="text/css">
.OBOrderType-Bulk{
	background-color: #FFF;
}

.OBOrderType-SampleInvoice{
	background-color: #FAC5DB;
}

.OBOrderType-SampleNonInvoice{
	background-color: #39F;
}

.OBOrderType-Seconds{
	background-color: #FC9;
}

.OBOrderType-Assorted{
	background-color: #E6E6E6;
}
.OBOrderType-Confirmed{
	background-color: #00CC66;
}

</style>
<style type="text/css">
table.fixHeader {
	border: solid #FFFFFF;
	border-width: 2px 2px 2px 2px;
	width: 1050px;
}

tbody.ctbody {
	height: 650px;
	overflow-y: auto;
	overflow-x: hidden;
}
</style>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td style="display:none">
    <?php include $backwardseperator.'reportHeader.php'; ?>    </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="36" colspan="6" class="head2">Order Book</td>
      </tr>
	  <?php if($checkDate=="true") {?>
      <tr>
        <td width="133" class="normalfnt">&nbsp;<b>Order Date From</b></td>
        <td width="30" class="normalfnt">:</td>
        <td width="144" class="normalfnt">&nbsp;<?php echo $txtDfrom;?></td>
        <td width="36" class="normalfnt"><b>To</b></td>
        <td width="18" class="normalfnt">:</td>
        <td width="1443" class="normalfnt">&nbsp;<?php echo $txtDto;?></td>
      </tr>
	  <?php } ?>
	  
	  <?php if($chkDelDate=="true") {?>
      <tr>
        <td width="133" class="normalfnt">&nbsp;<b>Deliver Date From</b></td>
        <td width="30" class="normalfnt">:</td>
        <td width="144" class="normalfnt">&nbsp;<?php echo $delDfrom;?></td>
        <td width="36" class="normalfnt"><b>To</b></td>
        <td width="18" class="normalfnt">:</td>
        <td width="1443" class="normalfnt">&nbsp;<?php echo $delDto;?></td>
      </tr>
	  <?php } ?>
	  
	  <?php if($buyer!="") {?>
      <tr>
        <td width="133" class="normalfnt">&nbsp;<b>Buyer Name</b></td>
        <td class="normalfnt" width="30">:</td>
        <td colspan="3" class="normalfnt">&nbsp;<?php echo GetBuyerName($buyer);?></td>
      </tr>
	  	<?php } ?>
        
        
        <tr>
          <td colspan="6" >&nbsp;</td>
        </tr>
        <tr>
          <td><table width="96" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td class="border-Left-Top-right-fntsize10" style="text-align:center" bgcolor="#00CC66" >Confirmed</td>
            </tr>
          <tr>
            <td class="border-Left-Top-right-fntsize10" style="text-align:center" bgcolor="#FFFF99">Pending</td>
          </tr>
          </table></td>
          <td colspan="5"><table width="856" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="1">&nbsp;</td>
              <td width="30" class="txtbox OBOrderType-Bulk">&nbsp;</td>
              <td width="183" class="normalfnt">&nbsp;Bulk </td>
              <td width="30" class="txtbox OBOrderType-SampleInvoice">&nbsp;</td>
              <td width="183" class="normalfnt">&nbsp;Sample Invoice </td>
              <td width="30" class="txtbox OBOrderType-SampleNonInvoice">&nbsp;</td>
              <td width="183" class="normalfnt">&nbsp;Sample Non Invoice </td>
              <td width="30" class="txtbox OBOrderType-Seconds">&nbsp;</td>
              <td width="183" class="normalfnt">&nbsp;Seconds&nbsp;</td>
              <td width="30" >&nbsp;</td>
              <td width="183" class="normalfnt">&nbsp;</td>
            </tr>
          </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="2" cellspacing="1" id="tblGRNDetails" bgcolor="#000000" class="fixHeader">
		<thead>
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <th nowrap="nowrap" >Orit Order No</th>
			  <th height="25" nowrap="nowrap" >Order No</th>
              <th nowrap="nowrap">Style No</th>
              <th nowrap="nowrap">Division</th>
              <th nowrap="nowrap">Order Qty</th>
              <th nowrap="nowrap">Excess&nbsp;<br/>%</th>
              <th nowrap="nowrap">Excess&nbsp;<br/>Qty</th>
              <th nowrap="nowrap">FOB&nbsp;<br/>(PCS)</th>
              <th nowrap="nowrap">Profit&nbsp;<br/>(PCS)</th>
              <th nowrap="nowrap">Profit Margin&nbsp;<br/>(PCS) %</th>
              <th nowrap="nowrap">C&amp;M&nbsp;<br/>(PCS)</th>
              <th nowrap="nowrap">C&amp;M Earned&nbsp;<br/>(Order Qty)</th>
              <th nowrap="nowrap">Total Order<br /> Qty</th>
              <th nowrap="nowrap">Fabric Mat Cost&nbsp;<br/>(PCS)</th>
              <th nowrap="nowrap">Total Fabric Value&nbsp;<br/>(USD)</th>
              <th nowrap="nowrap">Other Mat Cost&nbsp;<br/>(PCS)</th>
              <th nowrap="nowrap">Total Other <br />Cost Value&nbsp;(USD)</th>
              <th nowrap="nowrap">Wash Cost&nbsp;<br/>(PCS)</th>
              <th nowrap="nowrap">Total Wash <br />Cost Value&nbsp;(USD)</th>
              <th nowrap="nowrap">Total Cost &nbsp;<br/>(PCS)</th>
              <th nowrap="nowrap">Total Cost Value&nbsp;<br/>(USD)</th>
              <th nowrap="nowrap" title="Preorder FOB * Order Qty(Without Excess)">Sales Value&nbsp;<br/>(USD)</th>
              <th nowrap="nowrap">HTML Order<br/>Summery</th>
              <th nowrap="nowrap">Excel Order <br/>Summery </th>
              <th nowrap="nowrap">&nbsp;</th>
            </tr>
            </thead>
	<tbody class="ctbody">
<?php
$sql="select concat(date_format(O.dtmOrderDate,'%Y%m'),'',O.intCompanyOrderNo)as oritOrderNo,D.strDivision,O.reaFOB,O.dblFacProfit,O.intStyleId,O.strOrderNo,O.strStyle,O.intQty,O.reaExPercentage,O.reaSMVRate,O.reaSMV,O.intStatus,O.intOrderType from orders O inner join buyerdivisions D on D.intDivisionId=O.intDivisionId ";

if($checkDate=="true")
{
	if($txtDfrom!="")
	{
		$DateFromArray	= explode('/',$txtDfrom);
		$formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
		$sql.=" AND date(O.dtmOrderDate)>='$formatedFromDate' ";
	}
	if($txtDto!="")
	{
		$DateToArray	= explode('/',$txtDto);
		$formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
		$sql.=" AND date(O.dtmOrderDate)<='$formatedToDate' ";
	}
}

if($chkDelDate=="true")
{
	$sql .= " and O.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
	if($delDfrom!="")
	{
		$delDfromArray	= explode('/',$delDfrom);
		$formatedDelDfromArray	= $delDfromArray[2].'-'.$delDfromArray[1].'-'.$delDfromArray[0];
		$sql .= "and date(DS.dtDateofDelivery)>='$formatedDelDfromArray' ";
	}
	if($delDto!="")
	{
		$delDToArray	= explode('/',$delDto);
		$formatedDelDToArray	= $delDToArray[2].'-'.$delDToArray[1].'-'.$delDToArray[0];
		$sql .= "and date(DS.dtDateofDelivery)<='$formatedDelDToArray' ";
	}
	$sql .= ")";
}

if($buyer!="")
	$sql .= "and O.intBuyerID='$buyer' ";

if($orderType!="")
	$sql .= "and O.intOrderType='$orderType' ";

if($division!="")
	$sql .= "and O.intDivisionId='$division' ";
	
$sql.=" order by O.strOrderNo;";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
$orderType	= $row["intOrderType"];

if($row["intStatus"]=='11')
	$orderStatueBGColor = '#00CC66';
else
	$orderStatueBGColor = '#FFFF99';
	
$values 			= GetValues($row["intStyleId"]);
$bgColor			= "bcgcolor-tblrowWhite";
$totprofitMargin 	= ($row["dblFacProfit"]/$row["reaFOB"])*100;
$cmEarned 			= round($row["reaSMVRate"]*$row["reaSMV"],4);
$salesValue			= round($row["reaFOB"]* round($row["intQty"]),2);

switch($orderType)
{
	case 1:
		$bgColor = 'OBOrderType-Bulk';
		break;
	case 2:
		$bgColor = 'OBOrderType-SampleInvoice';
		break;
	case 3:
		$bgColor = 'OBOrderType-SampleNonInvoice';
		break;
	case 4:
		$bgColor = 'OBOrderType-Seconds';
		break;
	case 5:
		$bgColor = 'OBOrderType-Assorted';
		break;
}
?>

	<tr class="<?php echo $bgColor;?>" onmouseover="this.style.background ='#FFFFFF';" onmouseout="this.style.background='';">
		<td nowrap="nowrap" class="normalfnt" style="background:<?php echo $orderStatueBGColor;?>"><?php echo $row["oritOrderNo"]?></td>
		<td height="15" nowrap="nowrap" class="normalfnt"><a href="../../<?php echo $reportname?>?styleID=<?php echo $row["intStyleId"]?>" target="_blank" id="poreport" rel="1"><?php echo $row["strOrderNo"]?></a></td>
		<td nowrap="nowrap" class="normalfnt"><?php echo $row["strStyle"]?></td>
		<td nowrap="nowrap" class="normalfnt"><?php echo $row["strDivision"]?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($row["intQty"],0)?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo $row["reaExPercentage"]?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format((($row["intQty"]*$row["reaExPercentage"])/100),0)?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo $row["reaFOB"]?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo $row["dblFacProfit"]?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($totprofitMargin,2)?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($cmEarned,4)?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($cmEarned * $row["intQty"],2)?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0)?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($values[0],4);?></td>
		<td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($values[1],2);?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($values[2],4);?></td>
		<td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($values[3],2);?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($values[6],4);?></td>
		<td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($values[7],2);?></td>
		<td nowrap="nowrap" class="normalfntRite"><?php echo number_format($values[4],4);?></td>
		<td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($values[5],2);?></td>	
		<td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($salesValue,2);?></td>
		<td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/costestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="costestimatesheet.php">Click Here</a></td>
	    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/xclcostestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="xclcostestimatesheet.php">Click Here</a></td>
	    <td nowrap="nowrap" class="normalfntRite" >&nbsp;&nbsp;</td>
	</tr>

<?php 
$totOrderQty 		+= round($row["intQty"],0);
$totExOrderQty 		+= round(($row["intQty"]*$row["reaExPercentage"])/100,0);
$totWithExOrderQty	+= round($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0);
$totFabricMatCost	+= round($values[0],4);
$totFabricMatValue	+= round($values[1],2);
$totOtherMatCost	+= round($values[2],4);
$totOtherMatValue	+= round($values[3],2);
$totMatCost			+= round($values[4],4);
$totMatValue		+= round($values[5],2);
$totWashCost		+= round($values[6],4);
$totWashValue		+= round($values[7],2);
$totCMEarnedPerPcs	+= round($cmEarned,4);
$totCMEarnedTotal	+= round($cmEarned * $row["intQty"],2);
$totSalesValue		+= $salesValue;
}
?>   
	<tr bgcolor="#EAEAEA">
	  <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
	  <td height="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOrderQty,0);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totExOrderQty,0);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedPerPcs,4);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedTotal,2);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWithExOrderQty,0);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totFabricMatCost,4);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totFabricMatValue,2);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOtherMatCost,4);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totOtherMatValue,2);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashCost,4);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashValue,2);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totMatCost,4);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totMatValue,2);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totSalesValue,2);?></b>&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
	  <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
	</tr>
    <tr bgcolor="#FFFFFF">
	  <td colspan="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
	  </tr>
    </tbody>
 </table></td>
  </tr>
  <tr>
        <td height="21" class="copyright" align="right">&nbsp;</td>
  </tr>
  
</table>
</body>
</html>
<?php
function  GetValues($styleId)
{
global $db;
$array = array();
	$sql="select COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=1),0)as totalFabCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=1),0)as totalValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(2,3,4,5)),0)as totalOtherCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(2,3,4,5)),0)as totalOtherValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId'),0)as grandTotalFabCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId'),0)as grandTotalValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(6)),0)as totalWashCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(6)),0)as totalWashValue;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["totalFabCostPc"];
		$array[1] = $row["totalValue"];
		$array[2] = $row["totalOtherCostPc"];
		$array[3] = $row["totalOtherValue"];
		$array[4] = $row["grandTotalFabCostPc"];
		$array[5] = $row["grandTotalValue"];
		$array[6] = $row["totalWashCostPc"];
		$array[7] = $row["totalWashValue"];
	}
	return $array;
}

function GetBuyerName($buyer)
{
global $db;
	$sql="select strName from buyers where intBuyerID='$buyer'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strName"];
	}
}
?>
<script language="javascript" type="text/javascript">

</script>