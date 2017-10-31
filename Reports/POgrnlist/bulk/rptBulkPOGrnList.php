<?php
session_start();
include "../../../Connector.php"; 
$backwardseperator = "../../../";
$report_companyId 	= $_SESSION["FactoryID"];

$cboPONo		= $_GET["cboPONo"];
$cboGRN 		= $_GET["cboGRN"];
$cboInvoice		= $_GET["cboInvoice"];

$txtInvoiceNo	= trim($_GET["txtInvoiceNo"]);
$txtPONo		= trim($_GET["txtPONo"]);
$txtGRNNo		= trim($_GET["txtGRNNo"]);


$cboPONoArray 	= explode('/',$cboPONo);
$cboGRNArray 	= explode('/',$cboGRN);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Bulk PO-GRN List</title>
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
        <td width="100%" height="36" class="head2">Bulk Purchase Order vs. GRN Report</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="1150" border="0" cellpadding="0" cellspacing="1" id="tblGRNDetails" bgcolor="#000000">
		<thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="42" height="25" >PO No </th>
        <th width="48" >GRN No</th>
        <th width="75" >Sub Category</th>
        <th width="103" >Description</th>
        <th width="48" >Colour</th>
        <th width="35" >Size</th>
        <th width="39" >Units</th>
        <th width="41" >&nbsp;PO Qty&nbsp;</th>
        <th width="45" >&nbsp;GRN Qty&nbsp;</th>
        <th width="39" >&nbsp;Ex-Qty&nbsp;</th>
        <th width="60" >&nbsp;PO Balance&nbsp;</th>
        <th width="95" >Invoice No</th>
        <th width="45">Rate</th>
      </tr>
	  </thead>
      <?php
$sql="select BGH.intBulkGrnNo,BGH.intYear,BGH.intBulkPoNo,BGH.intBulkPoYear,MSC.StrCatName,
		MIL.strItemDescription,BGD.strColor,BGD.strSize,BGD.strUnit,round(BGD.dblQty,2) as GrnQty,BGD.dblRate,
		round(BGD.dblExQty,2) as dblExQty,round(BGD.dblBalance,4) as dblBalance ,BGH.strInvoiceNo,
		BGH.intStatus,BGD.intMatDetailID
		FROM bulkgrndetails BGD 
		INNER JOIN bulkgrnheader BGH ON (BGD.intBulkGrnNo=BGH.intBulkGrnNo)  AND (BGH.intYear=BGD.intYear) 
		INNER JOIN matitemlist MIL ON (BGD.intMatDetailID=MIL.intItemSerial) 
		INNER JOIN matsubcategory MSC ON (MIL.intSubCatID=MSC.intSubCatNo)
		WHERE BGH.intBulkPoNo <> 'a'";

if($cboPONo!="")
	$sql .= "and BGH.intBulkPoNo='$cboPONoArray[1]' and BGH.intBulkPoYear='$cboPONoArray[0]' ";

if($txtPONo!="")
	$sql .= "and BGH.intBulkPoNo like '%$txtPONo%' ";
	
if($cboGRN!="")
	$sql .= "and BGH.intBulkGrnNo='$cboGRNArray[1]' and BGH.intYear='$cboGRNArray[0]' ";

if($txtGRNNo!="")
	$sql .= "and BGH.intBulkGrnNo like '%$txtGRNNo%' ";
	
if($cboInvoice!="")
	$sql .= "and BGH.strInvoiceNo='$cboInvoice' ";
	
if($txtInvoiceNo!="")
	$sql .= "and BGH.strInvoiceNo like '%$txtInvoiceNo%' ";
	
$sql .= " order by BGH.intBulkPoYear,BGH.intBulkPoNo ";
//echo $sql;
$result=$db->RunQuery($sql);
$GrnNo = "";
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
      <?php if($GrnNo=="" || $GrnNo!=$row["intBulkGrnNo"]){
$GrnNo = $row["intBulkGrnNo"];
?>
      <tr class="bcgcolor-tblrowLiteBlue">
        <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../../BulkPo/bulkPurchaeOrderReport.php?intYear=<?php echo $row["intBulkPoYear"]?>&bulkPoNo=<?php echo $row["intBulkPoNo"]?>" target="_blank" id="poreport" rel="1">&nbsp;<?php echo $row["intBulkPoYear"].'/'.$row["intBulkPoNo"]?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt"><a href="../../../BulkGRN/Details/grnReport.php?grnYear=<?php echo $row["intYear"]?>&grnno=<?php echo $row["intBulkGrnNo"]?>" target="_blank" id="grnreport" rel="1">&nbsp;<?php echo $row["intYear"].'/'.$row["intBulkGrnNo"]?>&nbsp;</a></td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
        <td nowrap="nowrap" class="normalfntMid"><span class="compulsoryRed"><?php echo $status;?></span></td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
        <?php
			  $totalQty 	= GetGrnTotValues($row["intYear"],$row["intBulkGrnNo"]);
			  $totalPOQty 	= GetPOTotValues($row["intBulkPoYear"],$row["intBulkPoNo"]);
			  ?>
        <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo round($totalPOQty,2); ?>&nbsp;</a></td>
        <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo round($totalQty[0],2); ?>&nbsp;</a></td>
        <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo round($totalQty[1],2); ?>&nbsp;</a></td>
        <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo round($totalPOQty-$totalQty[0],2);?>&nbsp;</a></td>
        <td nowrap="nowrap" class="normalfnt"><a href="#">&nbsp;<?php echo $row["strInvoiceNo"] ?>&nbsp;</a></td>
        <td></td>
      </tr>
      <?php }
if($booFirst){
$poQty = GetPOQty($row["intBulkPoNo"],$row["intBulkPoYear"],$row["intMatDetailID"],$row["strColor"],$row["strSize"],$row["strUnit"]);
$booFirst = false; 
?>
      <tr class="bcgcolor-tblrowWhite">
        <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;
            <?php //echo $row["intYear"].'/'.$row["intPoNo"]?>
          &nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;
            <?php //echo $row["intGRNYear"].'/'.$row["intGrnNo"]?>
          &nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["StrCatName"] ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"] ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"] ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"] ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"] ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round($poQty,2);?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round($row["GrnQty"],2) ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round($row["dblExQty"],2) ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round(GetPOBalQty($row["intBulkPoNo"],$row["intBulkPoYear"],$row["intMatDetailID"],$row["strColor"],$row["strSize"],$row["strUnit"]),2); ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntMid">&nbsp;&quot;&nbsp;</td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo $row["dblRate"]; ?></td>
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
	$sql="select COALESCE((select round(sum(dblQty),2) from bulkgrndetails BGD where BGD.intBulkGrnNo='$grnNo' and BGD.intYear='$grnYear'),0) as totalQty,
COALESCE((select round(sum(dblExQty),2) from bulkgrndetails BGD where BGD.intBulkGrnNo='$grnNo' and BGD.intYear='$grnYear'),0) as totalExQty";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["totalQty"];
		$array[1] = $row["totalExQty"];
		//$array[2] = $row["totalBalanceQty"];
	}
	return $array;
}

function GetPOQty($pono,$poYear,$matId,$color,$size,$unit)
{
global $db;
	$sql="select round(sum(dblQty),2) as poQty 
			from bulkpurchaseorderdetails 
			where intBulkPoNo='$pono' 
			and intYear='$poYear' 
			and intMatDetailId='$matId' 
			and strColor='$color' 
			and strSize='$size' 
			and strUnit='$unit'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["poQty"];
	}
}
function GetPOBalQty($pono,$poYear,$matId,$color,$size,$unit)
{
global $db;
	$sql="select round(dblPending,2)as poBalQty 
			from bulkpurchaseorderdetails 
			where intBulkPoNo='$pono' 
			and intYear='$poYear' 
			and intMatDetailId='$matId' 
			and strColor='$color' 
			and strSize='$size' 
			and strUnit='$unit'";			
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["poBalQty"];
	}
}
function GetPOTotValues($poYear,$pono)
{
global $db;
	$sql="select round(sum(dblQty),2) as poQty from bulkpurchaseorderdetails where intBulkPoNo='$pono' and intYear='$poYear' ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["poQty"];
	}
}
?>