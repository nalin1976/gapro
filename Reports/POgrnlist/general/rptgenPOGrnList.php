<?php
session_start();
include "../../../Connector.php";
$backwardseperator 	= '../../../';
$report_companyId 	= $_SESSION["FactoryID"];

$cboPONo			= $_GET["cboPONo"];
$cboOrderNo			= $_GET["cboOrderNo"];
$cboInvoice			= $_GET["cboInvoice"];

$txtInvoiceNo		= trim($_GET["txtInvoiceNo"]);
$txtPONo			= trim($_GET["txtPONo"]);
$txtGRNNo			= trim($_GET["txtGRNNo"]);

$cboPONoArray 	= explode('/',$cboPONo);
$cboGRNArray 	= explode('/',$cboGRN);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | PO GRN Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td colspan="4">
    <?php include $backwardseperator.'reportHeader.php'; ?>
    </td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td width="100%" height="36" class="head2">Purchase Order vs. GRN Report</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td colspan="4">
			  <table width="100%" border="0" cellpadding="0" cellspacing="1" id="tblGRNDetails" bgcolor="#000000">
			  <thead>
            <tr bgcolor="#CCCCCC" class="normalfntMid">
			  <th width="39" height="25" >PO No </th>
              <th width="56" >GRN No</th>
              <th width="101" >Main Category </th>
              <th width="101" >Sub Category</th>
              <th width="149" >Description</th>
              <th width="46" >Units</th>
              <th width="66" >&nbsp;Quantity&nbsp;</th>
              <th width="56" >&nbsp;Ex-Qty&nbsp;</th>
              <th width="72" >&nbsp;Balance&nbsp;</th>
              <th width="81" >Invoice No</th>
             </tr>
			 </thead>
<?php
$loop	= 0;
$sql="select GH.strGenGrnNo,GH.intYear,GH.intGenPONo,GH.intGenPOYear,GD.intMatDetailID,MSC.StrCatName,MMC.strDescription,
		MIL.strItemDescription,MIL.strUnit,GD.dblQty,GD.dblExQty,
		GH.strInvoiceNo,GH.intStatus
		FROM gengrndetails GD 
		INNER JOIN gengrnheader GH ON (GD.strGenGrnNo=GH.strGenGrnNo)  AND (GH.intYear=GD.intYear) 
		INNER JOIN genmatitemlist MIL ON (GD.intMatDetailID=MIL.intItemSerial) 
		INNER JOIN genmatsubcategory MSC ON (MIL.intSubCatID=MSC.intSubCatNo)
		INNER JOIN genmatmaincategory MMC ON (MIL.intMainCatID=MMC.intID)
		WHERE GH.intStatus <> 'a' ";

if($cboPONo!="")
	$sql .= "and GH.intGenPONo='$cboPONoArray[1]' and GH.intGenPOYear='$cboPONoArray[0]' ";

if($txtPONo!="")
	$sql .= "and GH.intGenPONo like '%$txtPONo%' ";
	
if($cboGRN!="")
	$sql .= "and GH.strGenGrnNo='$cboGRNArray[1]' and GH.intYear='$cboGRNArray[0]' ";

if($txtGRNNo!="")
	$sql .= "and GH.strGenGrnNo like '%$txtGRNNo%' ";
	
if($cboInvoice!="")
	$sql .= "and GH.strInvoiceNo='$cboInvoice' ";
	
if($txtInvoiceNo!="")
	$sql .= "and GH.strInvoiceNo like '%$txtInvoiceNo%' ";

$sql .= " order by GH.intYear,GH.strGenGrnNo ";
$result=$db->RunQuery($sql);
$grnNo = "";
while($row=mysql_fetch_array($result))
{
if($row["intStatus"]=='0')
	$status = "Pending GRN";
elseif($row["intStatus"]=='1')
	$status = "Confirm GRN";
elseif($row["intStatus"]=='10')
	$status = "Cancel GRN";
$booFirst = true;
?>
<?php if($grnNo=="" || $grnNo!=$row["strGenGrnNo"]){
$grnNo = $row["strGenGrnNo"];
?>
            <tr class="bcgcolor-tblrowLiteBlue">
             <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../../GeneralInventory/GeneralPO/reportpo.php?&intYear=<?php echo $row["intGenPOYear"]?>&bulkPoNo=<?php echo $row["intGenPONo"]?>" target="_blank" id="poreport" rel="1">&nbsp;<?php echo $row["intGenPOYear"].'/'.$row["intGenPONo"]?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt"><a href="../../../GeneralInventory/GeneralGRN/Details/gengrnReport.php?grnno=<?php echo $row["intYear"].'/'.$row["strGenGrnNo"]?>" target="_blank" id="grnreport" rel="1">&nbsp;<?php echo $row["intYear"].'/'.$row["strGenGrnNo"]?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid"><span class="compulsoryRed"><?php echo $status;?></span></td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
			  <?php
			  $totalQty = GetGrnTotValues($row["intYear"],$row["strGenGrnNo"]);
			  ?>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo $totalQty[0] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo $totalQty[1] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt"><a href="#">&nbsp;<?php echo $row["strInvoiceNo"] ?>&nbsp;</a></td>
            </tr>
<?php }
if($booFirst){
$booFirst = false; 
?>		
            <tr class="bcgcolor-tblrowWhite">
              <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;<?php //echo $row["intYear"].'/'.$row["intPoNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php //echo $row["intGRNYear"].'/'.$row["intGrnNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strDescription"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["StrCatName"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblQty"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblExQty"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid">&nbsp;"&nbsp;</td>
            </tr>
<?php } ?>
<?php 
$loop++;
}
?>
          </table></td>
  </tr>
  <tr>
    <td width="766" height="21" class="normalfntRite">&nbsp;</td>
    <td width="67" class="normalfntRite">&nbsp;</td>
    <td lass="normalfntRiteBlue">&nbsp;</td>
    <td width="9">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0">
      <tr>
        <td width="5%" class="normalfnt">User : </td>
        <td width="9%" class="normalfnt">
          <?php 
		$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
		$result = $db->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		?>        </td>
        <td width="4%" class="normalfnt">Date:</td>
        <td width="12%" class="normalfnt"><?php echo date("Y/m/d"); ?></td>
        <td width="64%" class="normalfnt"><?php echo $grnNoArray[1]?></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
function  GetGrnTotValues($grnYear,$grnNo)
{
global $db;
$array = array();
	$sql="select COALESCE((select sum(dblQty) from gengrndetails GD where GD.strGenGrnNo='$grnNo' and GD.intYear='$grnYear'),0) as totalQty,
COALESCE((select sum(dblExQty) from gengrndetails GD where GD.strGenGrnNo='$grnNo' and GD.intYear='$grnYear'),0) as totalExQty";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["totalQty"];
		$array[1] = $row["totalExQty"];
		//$array[2] = $row["totalBalanceQty"];
	}
	return $array;
}
?>