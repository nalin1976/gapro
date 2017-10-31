<?php
session_start();
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../";
	$userid=$_SESSION["UserID"];
	$str_user="select Name from useraccounts where intUserID='$userid'";
	$results_user=$db->RunQuery($str_user);
	$user_row=mysql_fetch_array($results_user);
	$username=$user_row["Name"]
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gate Pass</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="sewinggatepass.js?n=1" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
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
</head>

<body><form id="frmSawingGatePass" name="frmSawingGatePass">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php';?></td>
  </tr>
  <tr>
  	<td height="5"></td>
  </tr>
  <tr>
    <td><table width="950" border="0" cellspacing="0" cellpadding="2" align="center" class="tableBorder">
      <tr class="mainHeading">
        <td width="880" height="25">Gate Pass </td>
        </tr>
		<tr>
			
		</tr>
		<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBorder">
  		  <tr >
            <td ><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
                <tr>
                  <td width="87">GP No </td>
                  <td width="152"><select name="txtGPNo" id="txtGPNo" style="width:150px;" onChange="load_gp_list(this.value);">
                    <option value=""></option>
                    <?php 
			$strGPNo="select concat(intGPnumber,'/',intYear) as GPNumber
							from productiongpheader
							where intFromFactory='$companyId'
							and strType='R'";
		
			$GPresults=$db->RunQuery($strGPNo);
			
			while($GProw=mysql_fetch_array($GPresults))
			{
		?>
                    <option value="<?php echo $GProw['GPNumber'];?>"><?php echo $GProw['GPNumber'];?></option>
                    <?php } ?>
                  </select></td>
                  <td width="85">Date <span class="compulsoryRed">*</span></td>
                  <td width="134"><input name="txtGPDate" type="text" tabindex="8" class="txtbox" id="txtGPDate" style="width:100px"  onmousedown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onFocus="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date('d/m/Y');?>" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  <td width="76" height="25" >&nbsp;Vehicle No <span class="compulsoryRed"> *</span> </td>
                  <td width="150"><input name="txtVehicle" type="text" class="txtbox" id="txtVehicle" style="width:148px" maxlength="30" tabindex="3"></td>
                  <td width="65">Pallet No <span class="compulsoryRed"> *</span></td>
                  <td width="161"><input name="txtPalletNo" type="text" class="txtbox" id="txtPalletNo" style="width:150px" maxlength="30" tabindex="4"></td>
                </tr>
                <tr>
                  <td >To Factory <span class="compulsoryRed">*</span></td>
                  <td><select name="cboToFactory" id="cboToFactory" style="width:150px;">
                    <option value=""></option>
                    <?php 
			$strtofactory="select intCompanyID,strComCode,strName 
							from companies 
							where intStatus=1 and intManufacturing=1 and intCompanyID !='$companyId'
							order by strName";
		
			$factresults=$db->RunQuery($strtofactory);
			
			while($factrow=mysql_fetch_array($factresults))
			{
		?>
                    <option value="<?php echo $factrow['intCompanyID'];?>"><?php echo $factrow['strName'];?></option>
                    <?php } ?>
                  </select></td>
                  <td height="25" >TransferIn No</td>
                  <td><select name="cboTransferInNo" id="cboTransferInNo" style="width:130px;" onChange="LoadOrderNo(this.value);">
                    <option value=""></option>
                    <?php
				   $sql = "select concat(intGPTYear,'/',dblCutGPTransferIN) as transferInNo
							from productiongptinheader
							where intFactoryId='$companyId'
							order by transferInNo";
				 
				  $result=$db->RunQuery($sql);
			
			while($row=mysql_fetch_array($result))
			{
		?>
                    <option value="<?php echo $row['transferInNo'];?>"><?php echo $row['transferInNo'];?></option>
                    <?php } ?>
                  </select></td>
                  <td>Order No </td>
                  <td><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onChange="loadCutNo(this);loadDetails();">
                  </select></td>
                  <td>Cut No </td>
                  <td><select name="cboCutNo" id="cboCutNo" style="width:150px;" onChange="loadDetails();">
                  </select></td>
                </tr>
                <tr>
                  <td width="87" >Reason Code <span class="compulsoryRed">*</span></td>
                  <td height="25" colspan="3"><select name="cboReasonCode" id="cboReasonCode" style="width:375px;" >
                    <option value=""></option>
<?php
$sql = "select RA.intRCAllowId,RC.strDescription
from tblreasoncodeallocation RA
inner join tblreasoncodes RC on RC.intResonCodeId=RA.intResonCodeId
inner join tblprocesses P on P.intCode=RA.intCode
where P.strFileName ='sewinggatepass.php'
order by RC.strDescription";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
	<option value="<?php echo $row['intRCAllowId'];?>"><?php echo $row['strDescription'];?></option>
<?php 
} 
?>
                  </select></td>
                  <td>Remarks</td>
                  <td colspan="3"><textarea name="txtRemarks" style="width:374px;height:20px" rows="1" class="txtbox" id="txtRemarks" tabindex="4" onKeyPress="return imposeMaxLength(this,event, 200);" onBlur="ControlableKeyAccess(event);" ></textarea></td>
                  </tr>
            </table></td>
		    </tr>
</table>
</td>
		</tr>
       
      <tr class="mainHeading2" align="right">
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><div style="width:100%; height:350px; overflow:scroll;">
        <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblMainGrid">
  <tr class="mainHeading4">
    <td width="5%" height="22"><input type="checkbox" id="checkBoxAll" name="checkBoxAll" onClick="checkAll(this)" /></td>
    <td width="19%" nowrap="nowrap">Cut No</td>
    <td width="19%" nowrap="nowrap">Size</td>
    <td width="19%" nowrap="nowrap">Bundle No </td>
    <td width="19%" nowrap="nowrap">PCs</td>
    <td width="19%" nowrap="nowrap">Shade</td>
    </tr>
</table>

        </div></td>
        </tr>
      <tr>
        <td height="5"></td>
        </tr>
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
  <tr>
    <td align="center"><img src="../../images/new.png" width="96" height="24" onClick="clearPage();"><img src="../../images/save.png" width="84" height="24" id="butSave" onClick="saveData();"><img src="../../images/print.png " alt="c"   class="mouseover" onClick="print_gp();"/><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
  </tr>
</table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></form>
</body>
</html>
