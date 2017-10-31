<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php"; 
include "{$backwardseperator}authentication.inc";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>Wash Issue</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="washIssue.js" type="text/javascript"></script>
<script src="washIssue_outside.js" type="text/javascript"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>

<script type="text/javascript">
function dateInDisable(obj)
{
	if(obj.checked){
		document.getElementById('machineLoading_dateIn').disabled=false;
		<?php
		
		?>
	}
	else{
		document.getElementById('machineLoading_dateIn').disabled=true;
	}
}

function dateOutDisable(obj)
{
	if(obj.checked){
		document.getElementById('machineLoading_dateOut').disabled=false;
	}
	else{
		document.getElementById('machineLoading_dateOut').disabled=true;
	}
}


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
<form id="frmWashIssues" name="frmWashIssues">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Wash Issue</div></div>
<div class="main_body">
<table width="800" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td>
	  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="">  
		<tr>
		  <td valign="top">
		  <fieldset class="fieldsetStyle" style="width:380px;height:150px;-moz-border-radius: 5px;">
		  <table width="380" border="0">		
			<tr>
			  <td class="normalfnt">Issue No</td>
			  <td colspan="0"><input type="text" name="washIssue_txtIssueNo" id="washIssue_txtIssueNo" style="width:100px" readonly="readonly"/></td>
			</tr>
			
			<tr>
			  <td class="normalfnt">Order No <span class="compulsoryRed">*</span></td>
			  <td colspan="0"><select name="washIssue_cboPoNo" class="txtbox" id="washIssue_cboPoNo" style="width:150px" onchange="loadColors(this.value)">
			  <option value="">Select One</option> 
	
			<?php
			
			$SQL="	SELECT DISTINCT o.intStyleId,o.strStyle,o.strOrderNo 
					FROM orders o
					INNER JOIN was_machineloadingheader AS ws ON ws.intStyleId=o.intStyleId 
					WHERE ws.intStatus =1;";
			
				$result =$db->RunQuery($SQL);
				while ($row=mysql_fetch_array($result))
				{
					echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
				}
		
			?>
	 </select></td>
			</tr>
	
			<tr>
			  <td class="normalfnt">Color<span class="compulsoryRed">*</span></td>
			  <td colspan="0">
			  <select name="washIssue_txtColor" id="washIssue_txtColor" style="width:150px" onchange="loadData(this.value)">
				<option value="">Select One</option>
			  </select>
			  </td>
			</tr>
			<tr>
			  <td class="normalfnt">Division</td>
	 <td colspan="0"><input type="text" name="washIssue_txtDivision" id="washIssue_txtDivision" style="width:150px"/></td>
			</tr>
			
			<tr>
			  <td class="normalfnt">Factory</td>
			  <td colspan="0"><input type="text" name="washIssue_txtFactory" id="washIssue_txtFactory" style="width:150px"/><input type="hidden" id="washIssue_txtComId" style="width:5px;"/></td>
			</tr>
			<tr>
			   <td colspan="4">
					<fieldset style="width:200px;-moz-border-radius: 5px;">
					<table>
						<tr>
							<td width="30"><input type="radio" name="washIssue_radioInorOut" id="washIssue_radioInorOut" value="0" size="25" onclick="loadIFData(this);" checked="checked" /></td>
							<td width="60" class="normalfnt">In House</td>
							<td width="30"><input type="radio" name="washIssue_radioInorOut" id="washIssue_radioInorOut2" value="1" size="25" onclick="loadIFData(this);"/></td>
							<td width="60" class="normalfnt">Outside</td>
						</tr>
					</table>
					</fieldset>
			   </td>
			</tr>
		  </table>
		  </fieldset>
		  </td>
		  <td width="400" valign="top">
		  <fieldset style="width:380px;height:150px;-moz-border-radius: 5px;" class="fieldsetStyle">
		  <table width="380" border="0" cellpadding="0" cellspacing="1" >
			<tr>
			  <td width="138"  class="normalfnt">Date<span class="compulsoryRed">*</span></td>
			  <td width="239"  class="normalfnt"><input name="washIssue_date" type="text" class="txtbox" id="washIssue_date" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  /><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/></td>
			</tr>
			<tr>
			  <td class="normalfnt">Style</td>
			  <td><input type="text" name="washIssue_txtStyle" id="washIssue_txtStyle" style="width:150px"/></td>
			</tr>
			<tr>
			  <td class="normalfnt">PO Qty</td>
			  <td width="153"><input type="text" name="washIssue_txtPoQty" id="washIssue_txtPoQty" style="width:150px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);"/></td>
			</tr>
			<tr>
			  <td class="normalfnt">Receive Qty<span class="compulsoryRed">*</span></td>
			  <td><input type="text" name="washIssue_txtReceiveQty" id="washIssue_txtReceiveQty" style="width:150px;text-align:right;" readonly="readonly"/></td>
			</tr>
			<tr>
			  <td class="normalfnt">Wash Qty</td>
			  <td><input type="text" name="washIssue_txtWashQty" id="washIssue_txtWashQty" style="width:150px;text-align:right;" readonly="readonly"/><input type="hidden" id="washIssue_hdnTotQty" value="0" style="width:10;"/></td>
			</tr>
			<tr>
			  <td class="normalfnt">Issue Qty<span class="compulsoryRed">*</span></td>
			  <td><input type="text" name="washIssue_txtIssueQty" id="washIssue_txtIssueQty" onkeypress="return CheckforValidDecimal(this.value,0,event);" style="width:150px;text-align:right;" onkeyup="checkAvlQty(this);"/><input type="hidden" id="washIssue_hdnIssedQty" value='0' /></td>
			</tr>
		  </table>
		  </fieldset>
		  </td>
		</tr>
		<tr>
			<td colspan="2">
				<table rules="none">
					<tr  class="containers">
					  <td  class="containers"><div align="center"><b>Issued No Like</b></div> </td>
					  <td><input type="text" class="txtbox" id="washIssue_txtSearch" name="washIssue_txtSearch" size="15"/></td>
					  <td  class="containers"><div align="center"><b>From</b></div></td>
					  <td  class="normalfnt"><input name="washIssue_dateFrom" type="text" class="txtbox" id="washIssue_dateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  /><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/></td>
					  <td  class="normalfnt">To</td>
					  <td  class="normalfnt"><input name="washIssue_dateOut" type="text" class="txtbox" id="washIssue_dateOut" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  /><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/></td>
					  <td  class="normalfnt"><img src="../../images/search.png" onclick="searchDetails();"/></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table align="right" border="0">
					<tr>
						<td>
						<img src="../../images/new.png" alt="new"  width="84" height="24" border="0" onclick="ClearForm();" />
						<img src="../../images/save.png" alt="save" width="84" height="24" border="0" onclick="saveWashIssue();"/>
						<img src="../../images/print.png" alt="print" width="84" height="24" border="0" onclick="printPoAvailable();" />
						<a href="../../main.php">
						<img src="../../images/close.png" alt="close" width="84" height="24" border="0"/>
						</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
		  <td height="30" colspan="2">
		  <fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">
		  <div id="div"  style="overflow:scroll; width:800px; height:200px;">
			<table width="1000" id="tblWashIssueGrid" bgcolor="#F3E8FF"  cellpadding="0" cellspacing="1" border="0">
				<thead>
					<tr bgcolor="#498CC2" class="grid_header">
						 <td width="10" class="grid_header"></td>
						 <td width="100" height="30" class="grid_header">Issue Id</td>
						 <td width="40" height="30" class="grid_header">In/Out</td>
						 <td width="100" class="grid_header">Order No.</td>
						 <td width="100" class="grid_header">Style Name</td>
						 <td width="80" class="grid_header">Color</td>
						 <td width="80" class="grid_header">Division</td>
						 <td width="150" class="grid_header">Factory</td>
						 <td width="50" class="grid_header">Date</td>
						 <td width="70" class="grid_header">PO Qty</td>
						 <td width="100" class="grid_header">Receive Qty</td>
						 <td width="70" class="grid_header">Wash Qty</td>
						 <td width="70" class="grid_header">Issue Qty</td>
					</tr>
				  </thead>
			  <?php
				$sql_loadDet="SELECT
								was_issuedheader.intIssueId,was_issuedheader.intYear,
								was_machineloadingheader.strColor,
								was_issuedheader.intMode,
								orders.strStyle,
								orders.strOrderNo,
								orders.intQty,
								buyerdivisions.strDivision,
								companies.intCompanyID as strTComCode,
								companies.strName,
								was_issuedheader.dblQty,
								was_issuedheader.dblRQty,
								was_issuedheader.dblWQty,
								was_issuedheader.dblIQty,
								was_issuedheader.dtmDate
								FROM
								was_issuedheader
								Inner Join was_machineloadingheader ON was_issuedheader.intStyleId = was_machineloadingheader.intStyleId
								Inner Join orders ON was_issuedheader.intStyleId = orders.intStyleId
								left Join buyerdivisions ON buyerdivisions.intBuyerID = orders.intBuyerID
								 Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = orders.intStyleId
								Inner Join companies ON companies.intCompanyID = was_stocktransactions.intCompanyID
								Inner Join was_actualcostheader ON was_machineloadingheader.intCostId = was_actualcostheader.intSerialNo 
								GROUP BY was_issuedheader.intIssueId
								ORDER BY was_issuedheader.dtmDate DESC";
				
				$res=$db->RunQuery($sql_loadDet);
				//echo $sql_loadDet;
			  ?>
			  <tbody>
			  <?php 
			  $count=0;
			  while($row=@mysql_fetch_array($res)){
			  $cls="";
					($count%2==0)?$cls="grid_raw":$cls="grid_raw2";
			  ?>
			  
				<tr class="bcgcolor-tblrowWhite">
					<td  class="<?php echo $cls;?>"><img src="../../images/edit.png" id="<?php echo $row['intYear']."/".$row['intIssueId'];?>" onclick="loadHeaderDet(this);" /></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['intYear']."/".$row['intIssueId'];?></td>
					<td  class="<?php echo $cls;?>"><?php if($row['intMode']=="0"){echo "In";}else{echo "Out";}?></td>
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strOrderNo'];?></td>	
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strStyle'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strColor'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strDivision'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strName'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo substr($row['dtmDate'],0,10);?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblQty'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblRQty'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblWQty'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblIQty'];?></td>
				</tr>
				<?php $count++; }
				$sql="SELECT was_issuedheader.intIssueId,was_issuedheader.intMode,was_issuedheader.intStyleId,was_issuedheader.dtmDate,was_issuedheader.dblQty,		was_issuedheader.dblRQty,was_issuedheader.dblWQty,was_issuedheader.dblIQty,was_outsidepo.strStyleDes as strStyle,was_outsidepo.intPONo as  strOrderNo,was_machineloadingheader.strColor,buyerdivisions.strDivision,was_outside_companies.strName
			FROM
			was_issuedheader
			Inner Join was_outsidepo ON was_outsidepo.intId = was_issuedheader.intStyleId
			Inner Join was_machineloadingheader ON was_issuedheader.intStyleId = was_machineloadingheader.intStyleId
			Inner Join was_outsidewash_fabdetails ON was_outsidepo.intFabId = was_outsidewash_fabdetails.intId AND was_outsidepo.intDivision = was_outsidewash_fabdetails.intDivision
			Inner Join buyerdivisions ON was_outsidewash_fabdetails.intBuyer = buyerdivisions.intBuyerID AND was_outsidewash_fabdetails.intDivision = buyerdivisions.intDivisionId
			Inner Join was_outside_companies ON was_outside_companies.intCompanyID = was_outsidewash_fabdetails.intFactory
			GROUP BY was_issuedheader.intIssueId ORDER BY was_issuedheader.dtmDate DESC;";
			$res=$db->RunQuery($sql);
			//$count=0;
			  while($row=@mysql_fetch_array($res)){
			  $cls="";
					($count%2==0)?$cls="grid_raw":$cls="grid_raw2";
			  ?>
			  
				<tr class="bcgcolor-tblrowWhite">
					<td  class="<?php echo $cls;?>"><img src="../../images/edit.png" id="<?php echo $row['intIssueId'];?>" onclick="loadHeaderDet(this);" /></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['intIssueId'];?></td>
					<td  class="<?php echo $cls;?>"><?php if($row['intMode']=="0"){echo "In";}else{echo "Out";}?></td>
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strOrderNo'];?></td>	
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strStyle'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strColor'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strDivision'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strName'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo substr($row['dtmDate'],0,10);?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblQty'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblRQty'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblWQty'];?></td>
					<td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblIQty'];?></td>
				</tr>
				<?php $count++;	}?>
			  </tbody>
			</table>
		  </div>
		  </fieldset>
		  </td>  
		</tr>
	  </table>
	 </td>
	</tr>
	</table>
	</div>
	</div>

    </form>
</body>
</html>

        
        