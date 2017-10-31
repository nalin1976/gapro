<?php
session_start();
include "../../../Connector.php"; 
$strPaymentType=$_GET["strPaymentType"];
$backwardseperator = "../../../";

$cboPONo		= $_POST["cboPONo"];
$cboGRN 		= $_POST["cboGRN"];
$cboInvoice		= $_POST["cboInvoice"];

$txtInvoiceNo	= trim($_POST["txtInvoiceNo"]);
$txtPONo		= trim($_POST["txtPONo"]);
$txtGRNNo		= trim($_POST["txtGRNNo"]);


$cboPONoArray 	= explode('/',$cboPONo);
$cboGRNArray 	= explode('/',$cboGRN);

if(!isset($_POST["cboPONo"]) && $_POST["cboGRN"]==""){
		$dateFrom 	= date('Y-m-d');
		$dateTo  	= date('Y-m-d');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Bulk PO-GRN List</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
.style3 {color: #000000}
-->
</style>

</head>
<script src="bulkpogrnlist.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>

<body>

<form id="frmBulkPOGRNList" name="frmBulkPOGRNList" method="post" action="bulkpogrnlist.php">
<tr>
	<td><?php include '../../../Header.php'; ?></td>
</tr>
<table width="100" class="tableBorder" align="center">
<tr>
 <td>
  <table width="100%" height="520" border="0" align="center" bgcolor="#FFFFFF">
    
    <tr>
      <td height="494" colspan="4"><table width="100%" cellpadding="0" cellspacing="0" >
        <tr>
          <td height="25" colspan="5" class="mainHeading">Bulk Purchase Order - GRN List </td>
        </tr>
        <tr>
        <tr><td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
          <tr>
            <td width="29%" height="78"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
              <tr>
                <td height="20" class="normalfnt">PO No</td>
                <td><select name="cboPONo" class="txtbox" id="cboPONo" style="width:100px" onchange="LoadDetailsWhenChangePoNo(this)">
<?php
	$SQL = "SELECT CONCAT(BPH.intYear ,'/' ,BPH.intBulkPoNo) AS strPONo FROM bulkpurchaseorderheader BPH 
			ORDER BY BPH.intYear,BPH.intBulkPoNo desc";	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		if($cboPONo==$row["strPONo"])
			echo "<option selected=\"selected\" value=\"". $row["strPONo"] ."\">" . $row["strPONo"] ."</option>" ;
		else
			echo "<option value=\"". $row["strPONo"] ."\">" . $row["strPONo"] ."</option>" ;
	}	
?>
                </select></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="txtPONo" type="text" class="txtbox" id="txtPONo"  style="width:98px;" value="<?php echo ($txtPONo!="" ? $txtPONo:'');?>"/></td>
              </tr>
            </table></td>
            <td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
              <tr>
                <td width="35%" height="20"><span class="normalfnt">GRN No</span></td>
                <td width="65%"><select name="cboGRN" class="txtbox" id="cboGRN" style="width:100px" >
<?php
	$sql="select concat(BGH.intYear,'/',BGH.intBulkGrnNo)as grnNo from bulkgrnheader BGH where BGH.intStatus <>'a'";

if($cboPONo!="")
	$sql .= "and BGH.intBulkPoYear='$cboPONoArray[0]' and BGH.intBulkPoNo='$cboPONoArray[1]'";
	
	$sql .= "order by BGH.intYear,BGH.intBulkGrnNo DESC";
$result=$db->RunQuery($sql);
	echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
while($row=mysql_fetch_array($result))
{
	if($cboGRN==$row["grnNo"])
		echo "<option selected=\"selected\" value=\"". $row["grnNo"] ."\">" . $row["grnNo"] ."</option>" ;
	else
		echo "<option value=\"". $row["grnNo"] ."\">" . $row["grnNo"] ."</option>" ;
}
?>
                </select></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="txtGRNNo" type="text" class="txtbox" id="txtGRNNo" style="width:100px" value="<?php echo ($txtGRNNo!="" ? $txtGRNNo:'')?>"/></td>
              </tr>
            </table></td>
            <td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
              <tr>
                <td width="52%" height="20"><span class="normalfnt">Invoice No</span></td>
                <td width="48%"><select name="cboInvoice" class="txtbox" id="cboInvoice" style="width:100px" >
<?php
	$sql="select distinct BGH.strInvoiceNo from bulkgrnheader BGH where BGH.intStatus <>'a' ";

if($cboPONo!="")
	$sql .= "and BGH.intBulkPoYear='$cboPONoArray[0]' and BGH.intBulkPoNo='$cboPONoArray[1]'  ";
	
	$sql .= "order by BGH.strInvoiceNo";
$result=$db->RunQuery($sql);
	echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
while($row=mysql_fetch_array($result))
{
	if($cboInvoice==$row["strInvoiceNo"])
		echo "<option selected=\"selected\" value=\"". $row["strInvoiceNo"] ."\">" . $row["strInvoiceNo"] ."</option>" ;
	else
		echo "<option value=\"". $row["strInvoiceNo"] ."\">" . $row["strInvoiceNo"] ."</option>" ;
}
?>
    
                </select></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="txtInvoiceNo" type="text" class="txtbox" id="txtInvoiceNo" style="width:98px;" value="<?php echo ($txtInvoiceNo!="" ? $txtInvoiceNo:'')?>"/></td>
              </tr>
            </table></td>
            <td width="11%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><img src="../../../images/search.png" alt="" onclick="SearchDetails()"/></td>
              </tr>
            </table></td>
          </tr>
        </table></td></tr>
          <tr>
          <td height="407" colspan="5">
		  <div class="tableBorder" id="divGRNDetails" style="overflow:scroll; width:945px;height:400px">
		  <table width="1150" border="0" cellpadding="0" cellspacing="1" id="tblGRNDetails" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
			  <td width="42" height="25" >PO No </td>
              <td width="48" >GRN No</td>
              <td width="75" >Sub Category</td>
              <td width="103" >Description</td>
              <td width="48" >Colour</td>
              <td width="35" >Size</td>
              <td width="39" >Units</td>
              <td width="41" >&nbsp;PO Qty&nbsp;</td>
              <td width="45" >&nbsp;GRN Qty&nbsp;</td>
              <td width="39" >&nbsp;Ex-Qty&nbsp;</td>
              <td width="60" >&nbsp;PO Balance&nbsp;</td>
              <td width="95" >Invoice No</td>
              <td width="45">Rate</td>
              </tr>
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
	
if($dateFrom!="")
	$sql .= "and date(BGH.dtmConfirmedDate) >='$dateFrom' and  date(BGH.dtmConfirmedDate) <='$dateTo' ";
	
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
              <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;<?php //echo $row["intYear"].'/'.$row["intPoNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php //echo $row["intGRNYear"].'/'.$row["intGrnNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["StrCatName"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round($poQty,2);?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round($row["GrnQty"],2) ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round($row["dblExQty"],2) ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round(GetPOBalQty($row["intBulkPoNo"],$row["intBulkPoYear"],$row["intMatDetailID"],$row["strColor"],$row["strSize"],$row["strUnit"]),2); ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid">&nbsp;"&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite"><?php echo $row["dblRate"]; ?></td>
              </tr>
<?php } ?>
<?php 
$loop++;
}
?>
          </table>
		  </div>		  </td>
        </tr>
		<tr height="35">	    
			<td width="10%" align="center">
			<img src="../../../images/new.png" alt="new" onclick="ClearForm()" />
			<img src="../../../images/report.png" onclick="ViewReport(0)"/>
			<img src="../../../images/download.png" onclick="ViewReport(1)"/>
			<a href="../../../main.php"><img src="../../../images/close.png" border="0" /></a></td>
		</tr>
		
      </table></td>
    </tr>
  </table>
</td>  </tr></table>
</form>
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