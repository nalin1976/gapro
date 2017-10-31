<?php
session_start();
include "../Connector.php"; 
$backwardseperator = "../";
$companyId	= $_SESSION["FactoryID"];

if(!isset($_POST["txtOrderNo"]))
{
	$txtDateFrom 	= ($txtDateFrom=="" ? date('Y-m-d'):$txtDateFrom);
	$txtDateTo   	= ($txtDateTo=="" ? date('Y-m-d'):$txtDateTo);
	$chkDate 		= 'on';
}
else
{
	$chkDate		= $_POST["chkDate"];
	$txtDateFrom	= trim($_POST["txtFromDate"]);
	$txtDateTo		= trim($_POST["txtToDate"]);
}

$txtOrderNo		 = trim($_POST["txtOrderNo"]);
$txtAllocationNo = trim($_POST["txtAllocationNo"]);
$cboSubCategory  = $_POST["cboSubCategory"];
$cboItem 		 = $_POST["cboItem"];
$cboLOCompany	 = $_POST["cboLOCompany"];
$txtItem		 = trim($_POST["txtItem"]);

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
function SearchDetails()
{
	document.frmItemWiseLeftOverList.submit();
}
function loadData(evt)
{
	
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 13)
	 {
		 document.frmItemWiseLeftOverList.submit();
	 }
}

</script>

<body>
<form id="frmItemWiseLeftOverList" name="frmItemWiseLeftOverList" method="post" action="itemWiseLeftOverList.php">
<tr>
	<td><?php include '../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
  <td height="25" colspan="5" class="mainHeading">Item Wise Left Over Allocation Listing</td>
  </tr>
  <tr>
    <td colspan="2" ><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="24" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
              <tr>
                <td width="20">&nbsp;</td>
                <td width="68" height="24">Order No </td>
                <td width="194"><input name="txtOrderNo" id="txtOrderNo" class="txtbox" style="width:180px" type="text" value="<?Php echo($txtOrderNo=='' ? "":$txtOrderNo);?>" /></td>
                <td width="80">&nbsp;</td>
                <td width="194">&nbsp;</td>
                <td width="85">Sub Category</td>
                <td><select name="cboSubCategory"  id="cboSubCategory" class="txtbox" style="width:200px" tabindex="3">
                  <?php
$SQL = "select intSubCatNo,StrCatName from matsubcategory order by StrCatName";		
$result = $db->RunQuery($SQL);
	echo "<option value = \"". "" . "\">" . "" . "</option>";
while($row = mysql_fetch_array($result))
{
	if($cboSubCategory==$row["intSubCatNo"])
		echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
	else
		echo "<option value=\"" . $row["intSubCatNo"] ."\">" . $row["StrCatName"] . "</option>";
	
}
?>
                </select></td>
                <td width="87">&nbsp;</td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td height="24">&nbsp;</td>
                <td>&nbsp;</td>
                <td>Allocation No</td>
                <td><input name="txtAllocationNo" id="txtAllocationNo" class="txtbox" style="width:190px" type="text" value="<?Php echo($txtAllocationNo=='' ? "":$txtAllocationNo);?>" onkeyup="loadData(event);"/></td>
                <td>Item</td>
                <td><select name="cboItem"  id="cboItem" class="txtbox" style="width:200px" tabindex="3">
                  <?php
$SQL = "SELECT DISTINCT	IWLD.intMatDetailId, M.strItemDescription 
FROM itemwiseleftover_detail IWLD 
inner join matitemlist M on IWLD.intMatDetailId = M.intItemSerial order by M.strItemDescription";		
$result = $db->RunQuery($SQL);
	echo "<option value = \"". "" . "\">" . "" . "</option>";
while($row = mysql_fetch_array($result))
{
	if($cboItem==$row["intMatDetailId"])
		echo "<option selected=\"selected\" value=\"". $row["intMatDetailId"] ."\">" . $row["strItemDescription"] ."</option>" ;
	else
		echo "<option value=\"" . $row["intMatDetailId"] ."\">" . $row["strItemDescription"] . "</option>";
	
}
?>
                </select></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><input type="checkbox" name="chkDate" id="chkDate" onclick="clearDate(this)" <?php echo ($chkDate=='on' ? "checked=\"checked\"":"")?>/></td>
                <td height="24">Date From </td>
                <td><input name="txtFromDate" type="text" tabindex="9" class="txtbox" id="txtFromDate" style="width:70px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y-%m-%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?Php echo($txtDateFrom=='' ? "":$txtDateFrom);?>" <?php echo ($chkDate=="on" ? "":"disabled=\"disabled\"")?>/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');">
                  To
                  <input name="txtToDate" type="text" tabindex="9" class="txtbox" id="txtToDate" style="width:70px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y-%m-%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?Php echo($txtDateTo=='' ? "":$txtDateTo);?>" <?php echo ($chkDate=="on" ? "":"disabled=\"disabled\"")?>/><input name="reset12" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" /></td>
                <td>Company</td>
                <td><select name="cboLOCompany"  id="cboLOCompany" class="txtbox" style="width:190px" tabindex="2" >
  <?php
$SQL = "select intCompanyID,strName from companies where intStatus=1 order by strName";		
$result = $db->RunQuery($SQL);
	echo "<option value = \"". "" . "\">" . "All" . "</option>";
while($row = mysql_fetch_array($result))
{
if($cboLOCompany==$row["intCompanyID"])
	echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
else
	echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] . "</option>";
	
}
?>
</select></td>
                <td>Item Like </td>
                <td width="202"><input type="text" class="txtbox" name="txtItem" id="txtItem" style="width:200px" value="<?Php echo ($txtItem);?>" /></td>
                <td><img src="../images/search.png" alt="search" onclick="SearchDetails()"/></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><div id="divGRNDetails" style="overflow:scroll; width:950px;height:400px">
            <table width="1100" border="0" cellpadding="0" cellspacing="1" id="tblGRNDetails" bgcolor="#CCCCFF">
              <tr class="mainHeading4">
                <td width="75" height="25" nowrap="nowrap" >&nbsp;LeftOver No&nbsp;</td>
                <td width="68" nowrap="nowrap" >&nbsp;Order No&nbsp;</td>
                <td width="66" nowrap="nowrap" >&nbsp;strBuyerPoNo&nbsp;</td>
                <td width="53" nowrap="nowrap" >&nbsp;Item Description&nbsp;</td>
                <td width="67" nowrap="nowrap" >&nbsp;Color&nbsp;</td>
                <td width="108" nowrap="nowrap" >&nbsp;Size&nbsp;</td>
                <td width="49" nowrap="nowrap" >&nbsp;strUnit&nbsp;</td>
                <td width="36" nowrap="nowrap" >&nbsp;Allowcation Qty&nbsp;</td>
                <td width="41" nowrap="nowrap" >&nbsp;Saved By&nbsp;</td>
                <td width="70" nowrap="nowrap" >&nbsp;Saved Date&nbsp;</td>
                <td width="74" nowrap="nowrap"  >&nbsp;Company Code&nbsp;</td>
                <td width="77" nowrap="nowrap" >&nbsp;Grn No&nbsp;</td>
                </tr>
<?php
$sql="select concat(IWLH.intSerialYear,'/',IWLH.intSerialNo) as leftoverNo,IWLD.intStyleId,IWLD.strBuyerPoNo,MIL.strItemDescription,
IWLD.strColor,IWLD.strSize,IWLD.strUnit,IWLD.dblQty ,UA.Name,IWLH.dtmDate,C.strComCode,concat(IWLD.intGRNYear,'/',IWLD.intGRNNo) as GRNNo,O.strOrderNo,IWLD.intMatDetailId,IWLD.strGRNType,IWLD.intGRNYear,IWLD.intGRNNo
from itemwiseleftover_header IWLH
inner join itemwiseleftover_detail IWLD ON IWLH.intSerialNo=IWLD.intSerialNo and IWLH.intSerialYear=IWLD.intSerialYear
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
	<tr class="bcgcolor-tblrowWhite">
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
        </div></td>
      </tr>
    </table>
	<tr>
	<td>
      <table width="100%" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td width="12%" align="center" >
        <img src="../images/report.png" alt="close" border="0" onclick="ViewNormalReport('N')"/>
        <img src="../images/download.png" alt="close" border="0" onclick="ViewNormalReport('E')"/>
        <a href="../main.php"><img src="../images/close.png" alt="close" border="0" /></a>
        </td>
      </tr>
    </table>
	</td>
	</tr>
	
</table>
</form>
<script type="text/javascript" src="frmItemWiseLeftOver.js"></script>
</body>
</html>
