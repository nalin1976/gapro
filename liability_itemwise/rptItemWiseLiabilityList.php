<?php
session_start();
include "../Connector.php"; 
$backwardseperator = "../";
$companyId			= $_SESSION["FactoryID"];

$chkDate			= $_GET["chkDate"];
$txtDateFrom		= trim($_GET["txtFromDate"]);
$txtDateTo			= trim($_GET["txtToDate"]);
$txtOrderNo		 	= trim($_GET["txtOrderNo"]);
$txtAllocationNo 	= trim($_GET["txtAllocationNo"]);
$cboSubCategory  	= $_GET["cboSubCategory"];
$cboItem 		 	= $_GET["cboItem"];
$cboLOCompany	 	= $_GET["cboLOCompany"];
$txtItem		 	= trim($_GET["txtItem"]);
$reportFormat		= $_GET["ReportFormat"];

if($reportFormat=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="ItemwiseLiability.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Item Wise Left Over Allocation List</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../js/jquery-ui-1.8.9.custom.css"/>

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
.style3 {color: #000000}
-->
</style>

</head>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>

<body>
<form id="frmItemWiseLeftOverList" name="frmItemWiseLeftOverList" method="post" action="itemWiseLeftOverList.php">
<table width="950" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><table width="1100" border="0" cellpadding="1" cellspacing="1" id="tblGRNDetails" bgcolor="#333333">
        <thead>
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <th width="75" height="25" nowrap="nowrap" >&nbsp;Liability No&nbsp;</th>
              <th width="68" nowrap="nowrap" >&nbsp;Order No&nbsp;</th>
              <th width="66" nowrap="nowrap" >&nbsp;strBuyerPoNo&nbsp;</th>
              <th width="53" nowrap="nowrap" >&nbsp;Item Description&nbsp;</th>
              <th width="67" nowrap="nowrap" >&nbsp;Color&nbsp;</th>
              <th width="108" nowrap="nowrap" >&nbsp;Size&nbsp;</th>
              <th width="49" nowrap="nowrap" >&nbsp;strUnit&nbsp;</th>
              <th width="36" nowrap="nowrap" >&nbsp;Allowcation Qty&nbsp;</th>
              <th width="41" nowrap="nowrap" >&nbsp;Saved By&nbsp;</th>
              <th width="70" nowrap="nowrap" >&nbsp;Saved Date&nbsp;</th>
              <th width="70" nowrap="nowrap" >Cancel By</th>
              <th width="70" nowrap="nowrap" >Cancel Date</th>
              <th width="74" nowrap="nowrap"  >&nbsp;Company Code&nbsp;</th>
              <th width="77" nowrap="nowrap" >&nbsp;GRN No&nbsp;</th>
              </tr>
            </thead>
  <?php
$sql="select concat(IWLH.intSerialYear,'/',IWLH.intSerialNo) as leftoverNo,IWLD.intStyleId,IWLD.strBuyerPoNo,MIL.strItemDescription,
IWLD.strColor,IWLD.strSize,IWLD.strUnit,IWLD.dblQty ,UA.Name,IWLH.dtmDate,C.strComCode,concat(IWLD.intGRNYear,'/',IWLD.intGRNNo) as GRNNo,O.strOrderNo,IWLD.intMatDetailId,IWLD.strGRNType,IWLD.intGRNYear,IWLD.intGRNNo,
date(IWLH.dtmCanceled) as CancelDate,(Select U.Name from useraccounts U where U.intUserID = IWLH.intCancelBy) as CancelBy
from itemwiseliability_header IWLH
inner join itemwiseliability_detail IWLD ON IWLH.intSerialNo=IWLD.intSerialNo and IWLH.intSerialYear=IWLD.intSerialYear
inner join matitemlist MIL ON MIL.intItemSerial=IWLD.intMatDetailId
inner join useraccounts UA ON UA.intUserID=IWLH.intUserId
inner join companies C ON C.intCompanyID=IWLH.intCompanyId
inner join orders O ON O.intStyleId=IWLD.intStyleId
where IWLH.intStatus<>'a' ";

if($txtOrderNo!="")
	$sql .= "and O.strOrderNo='$txtOrderNo' ";
	
if($txtAllocationNo!="")
	$sql .= "and IWLH.intSerialNo='$txtAllocationNo' ";
	
if($cboItem!="")
	$sql .= "and IWLD.intMatDetailId='$cboItem' ";

if($cboLOCompany!="")
	$sql .= "and IWLH.intCompanyId='$cboLOCompany' ";
	
if($chkDate=='on')
	$sql .= "and date(IWLH.dtmDate)>='$txtDateFrom' and date(IWLH.dtmDate)<='$txtDateTo' ";

if($txtItem!="")
	$sql .= " and MIL.strItemDescription like '%$txtItem%' ";
if($cboSubCategory!="")
	$sql .= " and MIL.intSubCatID = $cboSubCategory ";
	
$sql .= " order by IWLH.intSerialYear,IWLH.intSerialNo ";
//echo $sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	
?>
            <tr bgcolor="#FFFFFF">
              <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["leftoverNo"]  ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strOrderNo"]?>&nbsp;</td>	
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strBuyerPoNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt" style="text-align:right">&nbsp;<?php echo $row["dblQty"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["Name"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["dtmDate"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["CancelBy"]; ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["CancelDate"]; ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strComCode"] ?>&nbsp;</td>
              <?php
		if($row["strGRNType"]=="B")
		{
		?>
              <td nowrap="nowrap" class="normalfnt"><a href="../BulkGRN/Details/grnReport.php?grnYear=<?php echo $row["intGRNYear"]?>&amp;grnno=<?php echo $row["intGRNNo"]?>" target="_blank" id="Bulkgrnreport" rel="1">&nbsp;<u><?php echo $row["GRNNo"]?></u>&nbsp;</a></td>	
              <?php
		}
		else
		{
		?>
              <td nowrap="nowrap" class="normalfnt"><a href="../GRN/Details/grnReport.php?grnYear=<?php echo $row["intGRNYear"]?>&amp;grnno=<?php echo $row["intGRNNo"]?>" target="_blank" id="grnreport" rel="1">&nbsp;<u><?php echo $row["GRNNo"]?></u>&nbsp;</a></td>
              <?php
		}
		?>
              </tr>
  <?php 
}
?>
            </table>
          </td>
        </tr>
      </table>
    
</table>
</form>
<script type="text/javascript" src="frmItemWiseLeftOver.js"></script>
</body>
</html>
