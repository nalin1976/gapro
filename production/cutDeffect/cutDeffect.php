<?php
	session_start();
	include "../../Connector.php";	
	$backwardseperator = "../../";	
	$userid=$_SESSION["UserID"];
	$str_usercompany="select intCompanyID from useraccounts where intUserID='$userid'";
	$results_usercompany=$db->RunQuery($str_usercompany);
	$row_usercompany=mysql_fetch_array($results_usercompany);
	$companyid=$row_usercompany["intCompanyID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Defect Entry</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="cutDeffect.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
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
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><?php include $backwardseperator.'Header.php'; ?></td>
	</tr>
</table>

<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Component Defect<span class="vol"></span></div></div>
	<div class="main_body">
	<table>
		<tr>
			<td width="110" class="normalfnt">Defect Serial </td>
				<td width="170" class="normalfnt"><select name="cboSerial" class="txtbox" style="width:150px" id="cboSerial" onchange="filterStyle();" tabindex="4">
                  <option value=""></option>
                  <?php 
			$gpstr="select concat(intDefectYear,'/',intDefectSerial) as serialno,concat(intDefectYear,'-->',intDefectSerial) as serialtext from productiondefectheader  ";
		
			$gpresult=$db->RunQuery($gpstr);
			
			while($gprow=mysql_fetch_array($gpresult))
			{
		?>
                  <option value="<?php echo $gprow['serialno'];?>"><?php echo $gprow['serialtext'];?></option>
                  <?php } ?>
                </select></td>
				<td width="110" class="normalfnt">Factory</td>
				<td width="172"class="normalfnt"><select name="cboFactory" class="txtbox" style="width:150px" id="cboFactory"  tabindex="6">
                  <option value=""></option>
                  <?php 
			$strtofactory="select intCompanyID,strComCode,strName from companies";
		
			$factresults=$db->RunQuery($strtofactory);
			
			while($factrow=mysql_fetch_array($factresults))
			{
		?>
                  <option value="<?php echo $factrow['intCompanyID'];?>"><?php echo $factrow['strName'];?></option>
                  <?php } ?>
                </select></td>
				<td width="110" class="normalfnt">Buyer</td>
				<td class="normalfnt"><select name="cboBuyer" class="txtbox" style="width:150px" id="cboBuyer" onchange="filterStyle();" tabindex="4">
                  <option value=""></option>
                  <?php 
			$buyerstr="select 	intBuyerID,buyerCode,strName from buyers ";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
                  <option value="<?php echo $buyerrow['intBuyerID'];?>"><?php echo $buyerrow['strName'];?></option>
                  <?php } ?>
                </select></td>
		</tr>
	</table>
	<table>
		<tr>
			<td width="110" class="normalfnt">PO No</td>
			<td width="170" class="normalfnt"><select name="cmbStyle" class="txtbox" style="width:150px" id="cmbStyle" tabindex="6"  onchange="loadCutNo();">
              <option value=""></option>
              <?php 
			$strpo="select 	intStyleId, strStyle from orders where intStatus=11 order by strStyle ";
		
			$poresults=$db->RunQuery($strpo);
			
			while($porow=mysql_fetch_array($poresults))
			{?>
              <option value="<?php echo $porow['intStyleId'];?>"><?php echo $porow['strStyle'];?></option>
              <?php } ?>
            </select></td>
			<td width="110" class="normalfnt">Stage</td>
			<td width="172" class="normalfnt">
				<select id="cmbStage" class="txtbox" style="width:150px;"   name="cmbStage">
					<option value=""></option>
					<option value="cut">Cut</option>
					<option value="tin">Transfer In</option>
				</select>
			</td>
			<td width="110" class="normalfnt">Date</td>
			<td class="normalfnt"><input name="txtCutDate" type="text" tabindex="7" class="txtbox" id="txtCutDate" style="width:100px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date('d/m/Y');?>" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
		</tr>
	</table>
	<br />
	<table width="950">

			<td width="163">
				<div id="divcons" class="main_border_line"  style="overflow:scroll; height:250px; width:150px;">
				<table width="100%" class="thetable" id="tblCutNo">
					<caption>Cut</caption>
					<tr>
						<th width="70%">Cut #</th>
						<th width="20%">Qty</th>
						<th width="10%"></th>
					</tr>
									
				</table>
				</div>
			</td>
			<td width="264">
				<div id="divcons" class="main_border_line"  style="overflow:scroll; height:250px; width:250px;">
				<table width="100%" class="thetable" id="tblSize">
					<caption>Size</caption>
					<tr>
						<th width="30%">Cut No</th>
						<th width="25%">Size</th>
						<th width="25%">Shade</th>
						<th width="10%">Select</th>
					</tr>
				</table>
				</div>
			</td>
			<!--<td>
				<table width="100%" height="100%">
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><img src="../../images/bw.png" alt="fw" width="18" height="19" class="mouseover" onclick="add_to_grid_o_b_o()"/></tr>
					<tr><td><img src="../../images/fw.png" alt="bw" width="18" height="19" class="mouseover" onclick="remove_to_grid_o_b_o()"/></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><img src="../../images/ff.png" alt="af" width="18" height="19" class="mouseover" onclick="addAllSizestoGrid();"/></td></tr>
					<tr><td><img src="../../images/fb.png" alt="ab" width="18" height="19" class="mouseover" onclick="removeAllSizesfromGrid();" /></td></tr>
					<tr><td>&nbsp;</td>
					<tr><td>&nbsp;</td></tr>

			  </table>
			</td>-->
			<td width="507">
				<div id="divcons" class="main_border_line"   style="overflow:scroll; height:250px; width:499px;">
				<table width="100%" class="thetable" id="tblComponent">
					<caption>Component</caption>
					<tr>
						<th width="15%">Cut No</th>
						<th width="15%">Size</th>
						<th width="15%">Shade</th>
						<th width="30%">Component</th>
						<th width="15%">Qty</th>
						<th width="15%">Defect</th>
						<th width="5%">select</th>
					</tr>
				</table>
				</div>
			</td>
		</tr>
	</table>
	<br/>
	<table width="950" class="main_border_line">
		<tr>
			<td width="27%">&nbsp;</td>
			<td width="10%"><img src="../../images/new.png" onclick="newForm()"/></td>
			<td width="8%"><img src="../../images/save.png" class="mouseover" onclick="saveHeader();"/></td>
			<td width="10%"><img src="../../images/print.png " class="mouseover" onclick="print_gp();"/></td>
			<td width="10%"><img src="../../images/delete.png" onclick="saveDetail(01)" /></td>
			<td width="9%"><img src="../../images/cancel.jpg" class="mouseover" onclick="print_form();" /></td>
			<td width="26%">&nbsp;</td>
		</tr>
	</table>
	</body>
	<script type="text/javascript">
	document.getElementById("cboFactory").value=<?php echo $companyid;?>;
	</script>
</html>
