<?php
session_start();
include "../../Connector.php";
$backwardseperator 	= '../../';
$report_companyId 	= $_SESSION["FactoryID"];

$cboPONo			= $_GET["cboPONo"];
$cboOrderNo			= $_GET["cboOrderNo"];
$cboStyle			= $_GET["cboStyle"];
$cboGRN 			= $_GET["cboGRN"];
$cboInvoice			= $_GET["cboInvoice"];
$cboSupplier		= $_GET["cboSupplier"];

$txtInvoiceNo		= trim($_GET["txtInvoiceNo"]);
$txtPONo			= trim($_GET["txtPONo"]);
$txtGRNNo			= trim($_GET["txtGRNNo"]);
$txtOrderNo			= trim($_GET["txtOrderNo"]);
$txtStyleNo			= trim($_GET["txtStyleNo"]);
$txtSupplier		= trim($_GET["txtSupplier"]);

$cboPONoArray 	= explode('/',$cboPONo);
$cboGRNArray 	= explode('/',$cboGRN);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | PO GRN Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
              <th width="91" >Style No</th>
              <th width="70" >Order No</th>
              <th width="101" >Sub Category</th>
              <th width="149" >Description</th>
              <th width="60" >Colour</th>
              <th width="44" >Size</th>
              <th width="46" >Units</th>
              <th width="66" >PO Qty </th>
              <th width="66" >&nbsp;GRN Qty&nbsp;</th>
              <th width="56" >&nbsp;Ex-Qty&nbsp;</th>
              <th width="72" >&nbsp;Balance&nbsp;</th>
              <th width="81" >Invoice No</th>
              <th width="45">PO Price</th>
              <th width="46">Invoice Price</th>
              <th width="54">Payment Price</th>
             </tr>
			 </thead>
<?php
$loop	= 0;
$sql="select GH.intGrnNo,GH.intGRNYear,GH.intPoNo,GH.intYear,GD.intStyleId,GD.strBuyerPONO,MSC.StrCatName,MIL.strItemDescription,GD.strColor,GD.strSize,MIL.strUnit,  GD.dblQty, GD.dblPoPrice,GD.dblInvoicePrice,GD.dblPaymentPrice,  GD.dblExcessQty,GD.dblBalance,GH.strInvoiceNo,O.strOrderNo,O.strStyle,GH.intStatus,GD.intMatDetailID,S.strTitle FROM grndetails GD INNER JOIN grnheader GH ON (GD.intGrnNo=GH.intGrnNo)  AND (GH.intGRNYear=GD.intGRNYear) INNER JOIN matitemlist MIL ON (GD.intMatDetailID=MIL.intItemSerial) INNER JOIN matsubcategory MSC ON (MIL.intSubCatID=MSC.intSubCatNo)
inner join orders O on O.intStyleId = GD.intStyleId
Inner Join purchaseorderheader POH ON GH.intPoNo = POH.intPONo AND GH.intYear =  POH.intYear 
Inner Join suppliers S ON POH.strSupplierID = S.strSupplierID
WHERE GH.intStatus <> 'a' ";

if($cboPONo!="")
	$sql .= "and GH.intPoNo='$cboPONoArray[1]' and GH.intYear='$cboPONoArray[0]' ";

if($txtPONo!="")
	$sql .= "and GH.intPoNo like '%$txtPONo%' ";
	
if($cboStyle!="")
	$sql .= "and O.strStyle='$cboStyle' ";

if($txtStyleNo!="")
	$sql .= "and O.strStyle like '%$txtStyleNo%' ";
	
if($cboOrderNo!="")
	$sql .= "and GD.intStyleId='$cboOrderNo'";

if($txtOrderNo!="")
	$sql .= "and O.strOrderNo like '%$txtOrderNo%'";
	
if($cboGRN!="")
	$sql .= "and GH.intGrnNo='$cboGRNArray[1]' and GH.intGRNYear='$cboGRNArray[0]' ";

if($txtGRNNo!="")
	$sql .= "and GH.intGrnNo like '%$txtGRNNo%' ";
	
if($cboInvoice!="")
	$sql .= "and GH.strInvoiceNo='$cboInvoice' ";
	
if($txtInvoiceNo!="")
	$sql .= "and GH.strInvoiceNo like '%$txtInvoiceNo%' ";

if($cboSupplier!="")
	$sql .= "and POH.strSupplierID='$cboSupplier' ";
	
if($txtSupplier!="")
	$sql .= "and S.strTitle like '%$txtSupplier%' ";

$sql .= " order by GH.intGRNYear,GH.intGrnNo ";
//echo $sql;
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
<?php if($grnNo=="" || $grnNo!=$row["intGrnNo"]){
$grnNo = $row["intGrnNo"];
?>
            <tr class="bcgcolor-tblrowLiteBlue">
             <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../../oritreportpurchase.php?year=<?php echo $row["intYear"]?>&pono=<?php echo $row["intPoNo"]?>" target="_blank" id="poreport" rel="1">&nbsp;<?php echo $row["intYear"].'/'.$row["intPoNo"]?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt"><a href="../../../GRN/Details/grnReport.php?grnYear=<?php echo $row["intGRNYear"]?>&grnno=<?php echo $row["intGrnNo"]?>" target="_blank" id="grnreport" rel="1">&nbsp;<?php echo $row["intGRNYear"].'/'.$row["intGrnNo"]?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid"><span class="compulsoryRed"><?php echo $status;?></span></td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>			 
			  <?php
			  $totalQty = GetGrnTotValues($row["intGRNYear"],$row["intGrnNo"]);
			  $totalPOQty 	= GetPOTotValues($row["intYear"],$row["intPoNo"]);
			  ?>
			   <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo $totalPOQty ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo $totalQty[0] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo $totalQty[1] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo round($totalPOQty[0]-$totalQty[0],2) ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt"><a href="#">&nbsp;<?php echo $row["strInvoiceNo"] ?>&nbsp;</a></td>
            	<td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo  $totalQty[2] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo  $totalQty[3] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo  $totalQty[4] ?>&nbsp;</a></td>
            </tr>
<?php }
if($booFirst){
$poQty = GetPOQty($row["intPoNo"],$row["intYear"],$row["intStyleId"],$row["intMatDetailID"],$row["strColor"],$row["strSize"],$row["strBuyerPONO"]);

$booFirst = false; 
?>		
            <tr class="bcgcolor-tblrowWhite">
              <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;<?php //echo $row["intYear"].'/'.$row["intPoNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php //echo $row["intGRNYear"].'/'.$row["intGrnNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strOrderNo"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["StrCatName"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $poQty ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblQty"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblExcessQty"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round($poQty-$row["dblQty"]) ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid">&nbsp;"&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite"><?php echo $row["dblPoPrice"]; ?></td>
              <td nowrap="nowrap" class="normalfntRite"><?php echo $row["dblInvoicePrice"]; ?></td>
              <td nowrap="nowrap" class="normalfntRite"><?php echo $row["dblPaymentPrice"]; ?></td>
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
	$sql="select COALESCE((select sum(dblQty) from grndetails GD where GD.intGrnNo='$grnNo' and GD.intGRNYear='$grnYear'),0) as totalQty,
COALESCE((select sum(dblExcessQty) from grndetails GD where GD.intGrnNo='$grnNo' and GD.intGRNYear='$grnYear'),0) as totalExQty,
COALESCE((select round(sum(dblQty*dblPoPrice),2) from grndetails GD where GD.intGrnNo='$grnNo' and GD.intGRNYear='$grnYear'),0) as poPrice,
COALESCE((select round(sum(dblQty*dblInvoicePrice),2) from grndetails GD where GD.intGrnNo='$grnNo' and GD.intGRNYear='$grnYear'),0) as invoicePrice,
COALESCE((select round(sum(dblQty*dblPaymentPrice),2) from grndetails GD where GD.intGrnNo='$grnNo' and GD.intGRNYear='$grnYear'),0) as paymentPrice ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["totalQty"];
		$array[1] = $row["totalExQty"];
		$array[2] = $row["poPrice"];
		$array[3] = $row["invoicePrice"];
		$array[4] = $row["paymentPrice"];
	}
	return $array;
}

function GetPOQty($pono,$poYear,$styleId,$matId,$color,$size,$bPoNo)
{
global $db;
	$sql="select sum(dblQty)as poQty from purchaseorderdetails where intPoNo='$pono' and intYear='$poYear' and intStyleId='$styleId' and intMatDetailID='$matId' and strColor='$color' and strSize='$size' and strBuyerPONO='$bPoNo';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["poQty"];
	}
}

function GetPOTotValues($poYear,$pono)
{
global $db;
$array = array();
	$sql="select sum(dblQty)as poQty,
	round(sum(dblQty*dblUnitPrice),2)as PORate
	from purchaseorderdetails 
	where intPoNo='$pono' and intYear='$poYear' ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["poQty"];
		$array[1] = $row["PORate"];
	}
return $array;
}
?>