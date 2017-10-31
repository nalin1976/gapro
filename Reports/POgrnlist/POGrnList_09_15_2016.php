<?php
session_start();
include "../../Connector.php"; 
$strPaymentType=$_GET["strPaymentType"];
$backwardseperator = "../../";

$cboPONo		= $_POST["cboPONo"];
$cboOrderNo		= $_POST["cboOrderNo"];
$cboStyle		= $_POST["cboStyle"];
$cboGRN 		= $_POST["cboGRN"];
$cboInvoice		= $_POST["cboInvoice"];
$cboSupplier	= $_POST["cboSupplier"];

$txtInvoiceNo	= trim($_POST["txtInvoiceNo"]);
$txtPONo		= trim($_POST["txtPONo"]);
$txtGRNNo		= trim($_POST["txtGRNNo"]);
$txtOrderNo		= trim($_POST["txtOrderNo"]);
$txtStyleNo		= trim($_POST["txtStyleNo"]);
$txtSupplier	= trim($_POST["txtSupplier"]);

$cboPONoArray 	= explode('/',$cboPONo);
$cboGRNArray 	= explode('/',$cboGRN);

if(!isset($_POST["txtInvoiceNo"]) && $_POST["txtInvoiceNo"]==""){
		$dateFrom 	= date('Y-m-d');
		$dateTo  	= date('Y-m-d');
		$chkDate	= 'on';
		$height		= '400px';
}
else
{
	$chkDate		= $_POST["chkDate"];
	$dateFrom	= trim($_POST["txtFromDate"]);
	$dateTo		= trim($_POST["txtToDate"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - PO-GRN List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
.style3 {color: #000000}
-->
</style>

</head>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="POGrnList.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript">
var oldLink = null;
// code to change the active stylesheet
function setActiveStyleSheet(link, title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  if (oldLink) oldLink.style.fontWeight = 'normal';
  oldLink = link;
  link.style.fontWeight = 'bold';
  return false;
}

// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar


  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;

// If this handler returns true then the "date" given as
// parameter will be disabled.  In this example we enable
// only days within a range of 10 days from the current
// date.
// You can use the functions date.getFullYear() -- returns the year
// as 4 digit number, date.getMonth() -- returns the month as 0..11,
// and date.getDate() -- returns the date of the month as 1..31, to
// make heavy calculations here.  However, beware that this function
// should be very fast, as it is called for each day in a month when
// the calendar is (re)constructed.
function isDisabled(date) {
  var today = new Date();
  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
}

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
}

function showFlatCalendar() {
  var parent = document.getElementById("display");

  // construct a calendar giving only the "selected" handler.
  var cal = new Calendar(0, null, flatSelected);

  // hide week numbers
  cal.weekNumbers = false;

  // We want some dates to be disabled; see function isDisabled above
  cal.setDisabledHandler(isDisabled);
  cal.setDateFormat("%A, %B %e");

  // this call must be the last as it might use data initialized above; if
  // we specify a parent, as opposite to the "showCalendar" function above,
  // then we create a flat calendar -- not popup.  Hidden, though, but...
  cal.create(parent);

  // ... we can show it here.
  cal.show();
  

}
</script>
<body>

<form id="frmStylePOGRNList" name="frmStylePOGRNList" method="post" action="POGrnList.php">
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<table width="1250" align="center" border="0" cellpadding="0" cellspacing="0">

<tr>
 <td>
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">    
    <tr>
      <td colspan="4"><table width="100%" cellpadding="0" cellspacing="0" >
        <tr>
          <td colspan="5" class="mainHeading">Style Purchaser Order - GRN List </td>
        </tr>
        <tr>
        <tr><td colspan="5"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="tableBorder">
          <tr>
            <td width="2%" height="31" >&nbsp;</td>
            <td width="8%" ><span class="normalfnt">Supplier</span></td>
            <td width="19%" ><span class="normalfnt">
              <select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:235px" >
                <?php
	$sql="select distinct S.strSupplierID,S.strTitle  
			from grnheader GH 
			Inner Join purchaseorderheader POH ON GH.intPoNo = POH.intPONo 
			AND GH.intYear =  POH.intYear 
			Inner Join suppliers S ON POH.strSupplierID = S.strSupplierID
			where GH.intStatus <>'a' ";

if($cboPONo!="")
	$sql .= "and GH.intYear='$cboPONoArray[0]' and GH.intPoNo='$cboPONoArray[1]' ";
if($cboInvoice!="")
	$sql .= "and GH.strInvoiceNo='$cboInvoice' ";
	
	$sql .= "order by S.strTitle";

$result=$db->RunQuery($sql);
	echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
while($row=mysql_fetch_array($result))
{
	if($cboSupplier==$row["strSupplierID"])
		echo "<option selected=\"selected\" value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	else
		echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
}
?>
              </select>
            </span></td>
            <td width="5%" ><span class="normalfnt">PO No</span></td>
            <td width="14%" ><input name="txtPONo" type="text" class="txtbox" id="txtPONo"  style="width:140px;" value="<?php echo ($txtPONo!="" ? $txtPONo:'');?>"/></td>
            <td width="7%" ><span class="normalfnt">Style No</span></td>
            <td width="15%" ><input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" style="width:140px" value="<?php echo ($txtStyleNo!="" ? $txtStyleNo :'')?>"/></td>
            <td width="7%" ><span class="normalfnt">Invoice No</span></td>
            <td width="13%" ><select name="cboInvoice" class="txtbox" id="cboInvoice" style="width:140px" onchange="loadSuppliers(this);" >
              <?php
	$sql="select distinct GH.strInvoiceNo from grnheader GH where GH.intStatus <>'a' ";

if($cboPONo!="")
	$sql .= "and GH.intYear='$cboPONoArray[0]' and GH.intPoNo='$cboPONoArray[1]' ";
	
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
            <td width="10%"><img src="../../images/search.png" alt="search" width="90" height="24" onclick="SearchDetails()"/></td>
            </tr>
          <tr>
            <td class="normalfntMid"><input type="checkbox" name="chkDate" id="chkDate" onclick="clearDate(this)" <?php echo ($chkDate=='on' ? "checked=\"checked\"":"")?>/></td>
            <td class="normalfnt">GRN Date From</td>
            <td class="normalfnt"><input name="txtFromDate" type="text" tabindex="9" class="txtbox" id="txtFromDate" style="width:95px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y-%m-%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?Php echo($dateFrom=='' ? "":$dateFrom);?>" <?php echo ($chkDate=="on" ? "":"disabled=\"disabled\"")?>/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" />
To
<input name="txtToDate" type="text" tabindex="9" class="txtbox" id="txtToDate" style="width:95px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y-%m-%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?Php echo($dateTo=='' ? "":$dateTo);?>" <?php echo ($chkDate=="on" ? "":"disabled=\"disabled\"")?>/><input name="reset12" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" /></td>
            <td ><span class="normalfnt">GRN No</span></td>
            <td ><input name="txtGRNNo" type="text" class="txtbox" id="txtGRNNo" style="width:140px" value="<?php echo ($txtGRNNo!="" ? $txtGRNNo:'')?>"/></td>
            <td ><span class="normalfnt">Order No </span></td>
            <td ><input type="text" name="txtOrderNo" id="txtOrderNo" style="width:140px;" value="<?php echo ($txtOrderNo!="" ? $txtOrderNo :'')?>"/></td>
            <td >&nbsp;</td>
            <td ><input name="txtInvoiceNo" type="text" class="txtbox" id="txtInvoiceNo" style="width:140px;" value="<?php echo ($txtInvoiceNo!="" ? $txtInvoiceNo:'')?>"/></td>
            <td>&nbsp;</td>
          </tr>
        </table></td></tr>
          <tr>
          <td colspan="5">
		  <div id="divGRNDetails" style="overflow:scroll; width:1250px;height:500px">
		  <table width="1260" border="0" cellpadding="0" cellspacing="1" id="tblGRNDetails" bgcolor="#CCCCFF" >
            <tr class="mainHeading4">
			  <td width="42" height="25" >PO No </td>
              <td width="48" >GRN No</td>
              <td width="60" >Style No</td>
              <!--
                Comment On - 08/23/2016
                Comment By - Nalin Jayakody
                Comment For - Remove duplicate with style number
              -->
              <!--<td width="52" >Order No</td> -->
              <!-- ======================================== -->
              <td width="45" >SC No</td>
              <td width="75" >Sub Category</td>
              <td width="103" >Description</td>
              <td width="48" >Colour</td>
              <td width="35" >Size</td>
              <td width="39" >Units</td>
              <td width="41" >&nbsp;PO Qty&nbsp;</td>
              <td width="45" >&nbsp;GRN Qty&nbsp;</td>
              <td width="39" >&nbsp;Ex-Qty&nbsp;</td>
              <td width="60" >&nbsp;PO Balance&nbsp;</td>
              <td width="60" >&nbsp;Return To Supplier</td>
              <td width="95" >Invoice No</td>
              <td width="45">PO Price</td>
              <td width="46">Invoice Price</td>
              <td width="54">Payment Price</td>
             </tr>
<?php
$sql="select GH.intGrnNo,GH.intGRNYear,GH.intPoNo,GH.intYear,GD.intStyleId,GD.strBuyerPONO,MSC.StrCatName,MIL.strItemDescription,GD.strColor,GD.strSize,MIL.strUnit,  GD.dblQty,GD.dblPoPrice,GD.dblInvoicePrice,GD.dblPaymentPrice,  GD.dblExcessQty,GD.dblBalance,GH.strInvoiceNo,O.strOrderNo,O.strStyle,GH.intStatus,GD.intMatDetailID,S.strTitle, specification.intSRNO FROM grndetails GD INNER JOIN grnheader GH ON (GD.intGrnNo=GH.intGrnNo)  AND (GH.intGRNYear=GD.intGRNYear) INNER JOIN matitemlist MIL ON (GD.intMatDetailID=MIL.intItemSerial) INNER JOIN matsubcategory MSC ON (MIL.intSubCatID=MSC.intSubCatNo)
inner join orders O on O.intStyleId = GD.intStyleId
Inner Join purchaseorderheader POH ON GH.intPoNo = POH.intPONo AND GH.intYear =  POH.intYear 
Inner Join suppliers S ON POH.strSupplierID = S.strSupplierID
Inner Join specification ON O.intStyleId = specification.intStyleId
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
	
	
if($dateFrom!="")
	$sql .= "and date(GH.dtmRecievedDate) >='$dateFrom' and  date(GH.dtmRecievedDate) <='$dateTo' ";
	
$sql .= " order by GH.intGRNYear,GH.intGrnNo ";
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
             <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../oritreportpurchase.php?year=<?php echo $row["intYear"]?>&pono=<?php echo $row["intPoNo"]?>" target="_blank" id="poreport" rel="1">&nbsp;<?php echo $row["intYear"].'/'.$row["intPoNo"]?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt"><a href="../../GRN/Details/grnReport.php?grnYear=<?php echo $row["intGRNYear"]?>&grnno=<?php echo $row["intGrnNo"]?>" target="_blank" id="grnreport" rel="1">&nbsp;<?php echo $row["intGRNYear"].'/'.$row["intGrnNo"]?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid"><span class="compulsoryRed"><?php echo $status;?></span></td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
			    <?php
			  $totalQty 	= GetGrnTotValues($row["intGRNYear"],$row["intGrnNo"]);
			  $totalPOQty 	= GetPOTotValues($row["intYear"],$row["intPoNo"]);
			  ?>
			  <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo $totalPOQty[0]; ?>&nbsp;</a></td>			
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo $totalQty[0] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo $totalQty[1] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo round($totalPOQty[0]-$totalQty[0],4);?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt"><a href="#">&nbsp;<?php echo $row["strInvoiceNo"] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo  $totalQty[2] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo  $totalQty[3] ?>&nbsp;</a></td>
              <td nowrap="nowrap" class="normalfntRite"><a href="#">&nbsp;<?php echo  $totalQty[4] ?>&nbsp;</a></td>
            </tr>
<?php }
if($booFirst){
$poQty = GetPOQty($row["intPoNo"],$row["intYear"],$row["intStyleId"],$row["intMatDetailID"],$row["strColor"],$row["strSize"],$row["strBuyerPONO"]);

$SupplierReturnQty = GetSupplierReturnQty($row["intGrnNo"], $row["intGRNYear"], $row["intStyleId"],$row["intMatDetailID"],$row["strColor"],$row["strSize"]);
$booFirst = false; 
?>		
            <tr class="bcgcolor-tblrowWhite">
              <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;<?php //echo $row["intYear"].'/'.$row["intPoNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php //echo $row["intGRNYear"].'/'.$row["intGrnNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"] ?>&nbsp;</td>
              <!--
                Comment On - 08/23/2016
                Comment By - Nalin Jayakody
                Comment For - Remove duplicate with style number
              -->
              <!-- <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strOrderNo"] ?>&nbsp;</td> -->
              <!-- ================================================= -->
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["intSRNO"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["StrCatName"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $poQty;?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblQty"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblExcessQty"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo round($poQty-$row["dblQty"],4); ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $SupplierReturnQty; ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid">&nbsp;"&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblPoPrice"]; ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblInvoicePrice"]; ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblPaymentPrice"]; ?>&nbsp;</td>
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
			<img src="../../images/new.png" alt="new" onclick="ClearForm()" />
			<img src="../../images/report.png" onclick="ViewReport(0)"/>
			<img src="../../images/download.png" onclick="ViewReport(1)"/>
			<a href="../../main.php"><img src="../../images/close.png" border="0" /></a></td>
		</tr>
		
      </table></td>
    </tr>
  </table>
</td>  </tr></table>
</form>
</body>
</html>
<script type="text/javascript">

function clearDate(obj)
{
	if(!obj.checked)
	{
		document.getElementById('txtFromDate').value="";
		document.getElementById('txtToDate').value="";
		document.getElementById("txtFromDate").disabled =true;
		document.getElementById("txtToDate").disabled =true;
	}
	else
	{
		document.getElementById("txtFromDate").disabled =false;
		document.getElementById("txtToDate").disabled =false;
		document.getElementById('txtFromDate').value="<?php echo date('Y-m-d');?>";
		document.getElementById('txtToDate').value="<?php echo date('Y-m-d');?>";
	}
}
</script>
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

function GetSupplierReturnQty($grnNo, $grnYear, $styleId, $matItemId, $itemColor, $itemSize){
    
    global $db;
    
    $sql = " SELECT Sum(returntosupplierdetails.dblQty) AS ReturnSupQty FROM returntosupplierdetails WHERE intGrnNo = '$grnNo' AND intGrnYear = '$grnYear' AND intStyleId = '$styleId' AND intMatdetailID = '$matItemId' AND strColor = '$itemColor' AND strSize = '$itemSize'";
    
    $result = $db->RunQuery($sql);
    
    while($row = mysql_fetch_array($result)){
        
        return $row["ReturnSupQty"];
        
    }
}
?>