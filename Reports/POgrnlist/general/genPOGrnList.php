<?php
session_start();
include "../../../Connector.php"; 
$strPaymentType=$_GET["strPaymentType"];
$backwardseperator = "../../../";

$cboPONo		= $_POST["cboPONo"];
$cboOrderNo		= $_POST["cboOrderNo"];
$cboGRN 		= $_POST["cboGRN"];
$cboInvoice		= $_POST["cboInvoice"];

$txtInvoiceNo	= trim($_POST["txtInvoiceNo"]);
$txtPONo		= trim($_POST["txtPONo"]);
$txtGRNNo		= trim($_POST["txtGRNNo"]);

$cboPONoArray 	= explode('/',$cboPONo);
$cboGRNArray 	= explode('/',$cboGRN);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro -GEN-PO-GRN List</title>
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
<script src="genPOGrnList.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>

<body>

<form id="frmStylePOGRNList" name="frmStylePOGRNList" method="post" action="genPOGrnList.php">
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
          <td height="25" colspan="5" class="mainHeading">General Purchase Order - GRN List </td>
        </tr>
        <tr>
        <tr><td colspan="5"><table width="100%" border="0" cellspacing="2" cellpadding="0" class="tableBorder" >
          <tr>
            <td colspan="9"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBorder">
              <tr>
                <td width="10%"><span class="normalfnt">PO No</span></td>
                <td width="12%"><select name="cboPONo" class="txtbox" id="cboPONo" style="width:100px" onchange="LoadDetailsWhenChangePoNo(this)">
                  <?php
	$SQL = "SELECT CONCAT(GH.intGenPOYear ,'/' ,GH.intGenPONo) AS strPONo FROM gengrnheader GH 
			ORDER BY GH.intGenPOYear,GH.intGenPONo desc";	
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
                <td width="12%">&nbsp;</td>
                <td width="10%"><span class="normalfnt">GRN No</span></td>
                <td width="12%"><select name="cboGRN" class="txtbox" id="cboGRN" style="width:100px" >
                  <?php
	$sql="select concat(GH.intYear,'/',GH.strGenGrnNo)as grnNo from gengrnheader GH where GH.intStatus <>'a' ";

if($cboPONo!="")
	$sql .= "and GH.intGenPOYear='$cboPONoArray[0]' and GH.intGenPONo='$cboPONoArray[1]' ";
	
	$sql .= "order by GH.intYear,GH.strGenGrnNo DESC";
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
                <td width="12%">&nbsp;</td>
                <td width="10%"><span class="normalfnt">Invoice No</span></td>
                <td width="12%"><select name="cboInvoice" class="txtbox" id="cboInvoice" style="width:100px" >
                  <?php
	$sql="select distinct GH.strInvoiceNo from gengrnheader GH where GH.intStatus <>'a' ";

if($cboPONo!="")
	$sql .= "and GH.intGenPOYear='$cboPONoArray[0]' and GH.intGenPONo='$cboPONoArray[1]' ";
	
	$sql .= "order by GH.strInvoiceNo";
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
                <td width="17%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="txtPONo" type="text" class="txtbox" id="txtPONo"  style="width:98px;" value="<?php echo ($txtPONo!="" ? $txtPONo:'');?>"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="txtGRNNo" type="text" class="txtbox" id="txtGRNNo" style="width:100px" value="<?php echo ($txtGRNNo!="" ? $txtGRNNo:'')?>"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="txtInvoiceNo" type="text" class="txtbox" id="txtInvoiceNo" style="width:98px;" value="<?php echo ($txtInvoiceNo!="" ? $txtInvoiceNo:'')?>"/></td>
                <td align="right"><img src="../../../images/search.png" alt="aaa" onclick="SearchDetails()"/></td>
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
              <td width="53" >GRN No</td>
              <td width="93" >Main Category </td>
              <td width="93" >Sub Category</td>
              <td width="135" >Description</td>
              <td width="49" >Units</td>
              <td width="55" >&nbsp;PO Qty&nbsp;</td>
              <td width="55" >&nbsp;GRN Qty&nbsp;</td>
              <td width="51" >&nbsp;Ex-Qty&nbsp;</td>
              <td width="69" >&nbsp;Balance&nbsp;</td>
              <td width="82" >Invoice No</td>
             </tr>
<?php
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
			  $totalQty 	= GetGrnTotValues($row["intYear"],$row["strGenGrnNo"]);
			  $totalPOQty 	= GetPOTotValues($row["intGenPOYear"],$row["intGenPONo"]);
			  ?>
			  <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $totalPOQty; ?>&nbsp;</td>			
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $totalQty[0] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $totalQty[1] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;</a></td>
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
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo GetPOQty($row["intGenPONo"],$row["intGenPOYear"],$row["intMatDetailID"]);?>&nbsp;</td>
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
	$sql="select COALESCE((select sum(dblQty) from gengrndetails GD where GD.strGenGrnNo='$grnNo' and GD.intYear='$grnYear'),0) as totalQty,
COALESCE((select sum(dblExQty) from gengrndetails GD where GD.strGenGrnNo='$grnNo' and GD.intYear='$grnYear'),0) as totalExQty ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["totalQty"];
		$array[1] = $row["totalExQty"];
		//$array[2] = $row["totalBalanceQty"];
	}
	return $array;
}

function GetPOQty($pono,$poYear,$matId)
{
global $db;
	$sql="select sum(dblQty)as poQty from generalpurchaseorderdetails
			where intGenPoNo='$pono' 
			and intYear='$poYear'  
			and intMatDetailID='$matId' ;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["poQty"];
	}
}

function GetPOTotValues($poYear,$pono)
{
global $db;
	$sql="select sum(dblQty)as poQty from generalpurchaseorderdetails where intGenPoNo='$pono' and intYear='$poYear' ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["poQty"];
	}
}
?>