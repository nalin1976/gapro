<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
$orderId 		= $_POST["cboListOrderNo"];
$orderNo		= $_POST["txtListOrderNo"];
$status			= $_POST["cboMode"];
$reportPlace	= $_GET["ReportPlace"];
if(!isset($reportPlace) && $reportPlace=="")
{
	//echo 'HI';
}
else
{
	if($reportPlace=='I')
		$status	= 0;
	else
		$status	= 1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Invoice Costing List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
    table.fixHeader {
        border: thin #CCCCCC;
        border-width: 2px 2px 2px 2px;
        width: 850px;
    }
    tbody.ctbody {
        height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

</style>

<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="invoiceCostList-java.js" type="text/javascript"></script>
<script src="invoiceCost-java.js" type="text/javascript"></script>
<style type="text/css">
<!--
tbody.ctbody1 {        height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
}
-->
</style>
</head>

<body >
<form name="frmInvoiceCostingList" id="frmInvoiceCostingList" action="invoiceCostList.php" method="post">
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="61%" height="31" bgcolor="#498CC2" class="mainHeading"><div align="center">Invoice Cost List</div></td>      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="tableBorder">
      <tr>
        <td width="2%" height="27">&nbsp;</td>
        <td width="5%" class="normalfnt">Mode</td>
        <td width="16%"><select name="cboMode" class="txtbox" id="cboMode" style="width:150px" >
          <option value="0" <?php echo ($status=='0' ? "selected=\"selected\"":"")?>>Pending for Process</option>
          <option value="1" <?php echo ($status=='1' ? "selected=\"selected\"":"")?>>Processed</option>
          <option value="10" <?php echo ($status=='10' ? "selected=\"selected\"":"")?>>Canceled</option>
        </select></td>
        <td width="3%">&nbsp;</td>
        <td width="8%" class="normalfnt">Order No </td>
        <td width="18%"><select name="cboListOrderNo" class="txtbox" id="cboListOrderNo" style="width:150px" >
		<?php
		$sql="select IH.intStyleId,O.strOrderNo from invoicecostingheader IH 
			inner join orders O on O.intStyleId=IH.intStyleId
			where IH.intStatus=0
			order by O.strOrderNo";
		$result=$db->RunQuery($sql);
			echo "<option value="."".">"."Select One"."</option>";
		while($row=mysql_fetch_array($result))
		{
			if($orderId==$row["intStyleId"])
				echo "<option value=".$row["intStyleId"]." selected=\"selected\">".$row["strOrderNo"]."</option>";
			else
				echo "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
		}
		?></select></td>
        <td width="4%">&nbsp;</td>
        <td width="11%" class="normalfnt">Order No Like </td>
        <td width="17%"><input type="text" name="txtListOrderNo" id="txtListOrderNo" style="width:120px" maxlength="30" value="<?php echo ($orderNo=="" ? "":$orderNo)?>" /></td>
        <td width="4%">&nbsp;</td>
        <td width="12%"><img src="../../images/search.png" alt="search" width="80" height="24" class="mouseover" onclick="loadInvoiceCosting();"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="17" bgcolor="#FAD163" class="normalfntMid"><div align="center">Invoice Costing List Details </div></td>
        </tr>
      <tr>
        <td>
		<!--<div id="divcons2" style="overflow:scroll; height:470px; width:950px;">-->
		<table width="100%" cellpadding="0" cellspacing="1" id="tblInvoiceCostingList" bgcolor="#C58B8Bd" class="bcgcolor">
          <thead>
            <tr class='mainHeading4'>
              <th width="17%"  height="25" >Order No</th>
              <th width="51%" >Fabric Description </th>
              <th width="6%" >FOB</th>
              <th width="7%" >CM</th>
              <th width="9%" >CM Reduced</th>
              <th width="8%" nowrap="nowrap">Reports</th>
              <th width="2%" nowrap="nowrap">&nbsp;</th>
            </tr>
          </thead>
          <tbody class="ctbody1">
            <?php
	$SQL = "SELECT O.intStyleId,O.strOrderNo,IH.dblNewCM,IH.dblReduceCM,IH.strFabric,IH.intStatus,
	if(B.intinvFOB=1,round((select IH.dblTotalCostValue from invoicecostingheader IH where IH.intStyleId=O.intStyleId),2),round((select O1.reaFOB from orders O1 where O1.intStyleId=O.intStyleId),2))as fob
	FROM invoicecostingheader IH	
	INNER JOIN orders O ON IH.intStyleId = O.intStyleId 
	inner join buyers B on B.intBuyerID=O.intBuyerID
	WHERE IH.intStatus =  '$status'";
	
	if($orderId!="")
	$SQL .=" and IH.intStyleId='$orderId'";
	
	if($orderNo!="")
	$SQL .=" and O.strOrderNo like '%$orderNo%'";
	
	$SQL.=" ORDER BY O.strOrderNo";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if($manageInvoiceCostingMain)
			$url = "<a href=\"invoiceCost.php?id=1&intStyleId=".$row["intStyleId"]."\" class=\"non-html pdf\" target=\"_blank\">".$row["strOrderNo"]."</a>";
		else
			$url = $row["strOrderNo"];
?>
            <tr class='bcgcolor-tblrowWhite'>
              <td  height="25" class="normalfnt" id="<?php echo $row["intStyleId"]?>" nowrap="nowrap">&nbsp;<?php echo $url ?></td>
              <td class="normalfnt" nowrap="nowrap">&nbsp;<?php echo $row["strFabric"]?></td>
              <td class="normalfntRite" nowrap="nowrap">&nbsp;<?php echo number_format($row["fob"],2);?>&nbsp;</td>
              <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dblNewCM"]?>&nbsp;</td>
              <td class="normalfntRite" nowrap="nowrap"><?php echo $row["dblReduceCM"]?>&nbsp;</td>
              <td class="normalfntMid" nowrap="nowrap"><img src="../../images/view2.png" id="butReport"  class="mouseover"  border="0" onclick="OpenReportPopUp_List(this);" /></td>
              <td class="normalfntMid" nowrap="nowrap">&nbsp;</td>
            </tr>
            <?php
	}
?>
		<tr class='bcgcolor-tblrowWhite'>
              <td class="normalfnt" colspan="7" nowrap="nowrap">&nbsp;</td>
            </tr>
          </tbody>
        </table>
		<!--</div>--></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
