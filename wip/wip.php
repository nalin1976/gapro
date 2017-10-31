<?php
session_start();
$backwardseperator = "../../";
include $backwardseperator."authentication.inc";
$txtDfrom	= date("Y-m-01");
$txtDto		= date("Y-m-d");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Production Wip</title>

<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript" ></script>
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

<script type="text/javascript">
function viewReport()
{
	var ReportType = "N";
	var checkDate 	= document.getElementById("checkDate").checked;
	var txtDfrom  	= document.getElementById("txtDfrom").value;
	var txtDto    	= document.getElementById("txtDto").value;
	var companyId   =  document.getElementById("cmbFactory").value;
	var PONo        =  document.getElementById("cmbStyleId").value;
	var division    =  document.getElementById("cmbDivision").value;
	var buyer       =  document.getElementById("cmbBuyer").value;
	var style		=  document.getElementById("cmbStyle").value;
	var season		=  document.getElementById("cmbSeason").value;
	
	var reportName = "wipReport_final.php";	
	var url  = reportName+"?txtDfrom="+txtDfrom+"&txtDto="+txtDto+"&companyId="+companyId+"&checkDate="+checkDate+"&PONo="+PONo+"&ReportType="+ReportType+"&style="+style+"&buyer="+buyer+"&division="+division+"&season="+season;
	
	window.open(url,reportName);	
}


function setDateChecked(objChk)
{
	
	if(!objChk.checked)
	{
		document.getElementById("txtDfrom").disabled= true;
		document.getElementById("txtDto").disabled= true;			
	}
	else
	{
		document.getElementById("txtDfrom").disabled=false;
		document.getElementById("txtDto").disabled= false;	
	}	
}

function ShowExcelReport()
{
	var ReportType = "E";
	var checkDate 	= document.getElementById("checkDate").checked;
	var txtDfrom  	= document.getElementById("txtDfrom").value;
	var txtDto    	= document.getElementById("txtDto").value;
	var companyId   =  document.getElementById("cmbFactory").value;
	var PONo        =  document.getElementById("cmbStyleId").value;
	var division    =  document.getElementById("cmbDivision").value;
	var buyer       =  document.getElementById("cmbBuyer").value;
	var style		=  document.getElementById("cmbStyle").value;
	var season		=  document.getElementById("cmbSeason").value;
	
	var reportName = "wipReport.php";	
	var url  = reportName+"?txtDfrom="+txtDfrom+"&txtDto="+txtDto+"&companyId="+companyId+"&checkDate="+checkDate+"&PONo="+PONo+"&ReportType="+ReportType+"&style="+style+"&buyer="+buyer+"&division="+division+"&season="+season;
	window.open(url,reportName);
	
}

function LoadBuyerDivision(buyerId)
{
	var url = '../../Reports/orderbook/orderBookxml.php?RequestType=URLLoadBuyerDivision&BuyerId='+buyerId.value;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cmbDivision').innerHTML = htmlobj.responseText;
}
	</script>
</head>
<body>
<?php
include "../../Connector.php";
?>
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>

<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="25" class="mainHeading">WIP Report</td>
          </tr>
          <tr>
            <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                          <tr>
                            <td colspan="5" height="15"><fieldset class="roundedCorners" >
                              <legend class="legendHeader">&nbsp;Cut Date&nbsp;</legend> 
                              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                <tr>
                                  <td width="33" class="normalfntMid"><input name="checkDate" id="checkDate" type="checkbox" checked="checked" onclick="setDateChecked(this);"/></td>
                                  <td width="105">Date From </td>
                                  <td width="131"><input type="text" name="txtDfrom " id="txtDfrom" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfrom=="" ? "":$txtDfrom);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                  <td width="76">To</td>
                                  <td width="194"><input type="text" name="txtDto" id="txtDto" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDto=="" ? "":$txtDto);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                  </tr>
                                </table>
                              </fieldset></td>
                          </tr>
                         
                          <tr >
                            <td >&nbsp;</td>
                            <td >Factory</td>
                            <td colspan="3"><select name="cmbFactory" class="txtbox" style="width:300px" id="cmbFactory"  tabindex="6">
                              <option value=""></option>
                              <?php 
			$strtofactory="select intCompanyID,strComCode,strName from companies";
		
			$factresults=$db->RunQuery($strtofactory);
			
		while($factrow=mysql_fetch_array($factresults))
		{
			if($cmbFactory==$factrow["intCompanyID"])
			echo "<option selected=\"selected\" value=\"". $factrow["intCompanyID"] ."\">" . $factrow["strName"] ."</option>" ;
			else
			echo "<option value=\"". $factrow["intCompanyID"] ."\">" . $factrow["strName"] ."</option>" ;
		}
		?>
                              </select></td>
                          </tr>
                          <tr >
                            <td >&nbsp;</td>
                            <td >Buyer</td>
                            <td colspan="3" ><select name="cmbBuyer" class="txtbox" style="width:300px" id="cmbBuyer"  tabindex="6" onchange="LoadBuyerDivision(this)">
                              <option value=""></option>
                              <?php 
			$strtofactory="SELECT 	 strName,intBuyerID FROM buyers WHERE intStatus=1 ORDER BY strName";
		
			$factresults=$db->RunQuery($strtofactory);
			
		while($factrow=mysql_fetch_array($factresults))
		{
			
			echo "<option value=\"". $factrow["intBuyerID"] ."\">" . $factrow["strName"] ."</option>" ;
		}
		?>
                              </select></td>
                          </tr>
                          <tr >
                            <td >&nbsp;</td>
                            <td >PO Number</td>
                            <td colspan="3" ><select name="cmbStyleId" class="txtbox" style="width:300px" id="cmbStyleId" tabindex="6">
                              <option value=""></option>
                              <?php 
			$strpo="select 	intStyleId, strOrderNo from orders where intStatus=11 order by strOrderNo ";
		
			$poresults=$db->RunQuery($strpo);
			
		while($porow=mysql_fetch_array($poresults))
		{
			if($cmbStyle==$porow["intStyleId"])
			echo "<option selected=\"selected\" value=\"". $porow["intStyleId"] ."\">" . $porow["strOrderNo"] ."</option>" ;
			else
			echo "<option value=\"". $porow["intStyleId"] ."\">" . $porow["strOrderNo"] ."</option>" ;
		}		
		?>
                              </select></td>
                          </tr>
                          <tr >
                            <td >&nbsp;</td>
                            <td >Style</td>
                            <td colspan="3" ><select name="cmbStyle" class="txtbox" style="width:300px" id="cmbStyle" tabindex="6">
                              <option value=""></option>
                              <?php 
			$strpo="SELECT 	 strStyle FROM orders WHERE intStatus=11 GROUP BY strStyle ORDER BY strStyle";
		
			$poresults=$db->RunQuery($strpo);
			
		while($porow=mysql_fetch_array($poresults))
		{
			
			echo "<option value=\"". $porow["strStyle"] ."\">" . $porow["strStyle"] ."</option>" ;
		}		
		?>
                            </select></td>
                          </tr>
                          
                          <tr >
                          <td >&nbsp;</td>
                          <td >Division</td>
                          <td colspan="3" ><select name="cmbDivision" class="txtbox" style="width:300px" id="cmbDivision"  tabindex="6">
                            <option value=""></option>
                            <?php 
			$strtofactory="SELECT strDivision, intDivisionId FROM buyerdivisions WHERE intStatus=1 ORDER BY strDivision";
		
			$factresults=$db->RunQuery($strtofactory);
			
		while($factrow=mysql_fetch_array($factresults))
		{
			
			echo "<option value=\"". $factrow["intDivisionId"] ."\">" . $factrow["strDivision"] ."</option>" ;
		}
		?>
                          </select></td>
                        </tr>
                        <tr >
                            <td >&nbsp;</td>
                            <td >Season</td>
                            <td colspan="3" ><select name="cmbSeason" class="txtbox" style="width:300px" id="cmbSeason" tabindex="6">
                              <option value=""></option>
                              <?php 
			$strpo="SELECT strSeason, intSeasonId FROM seasons WHERE intStatus=1 ORDER BY strSeason";
		
			$poresults=$db->RunQuery($strpo);
			
		while($porow=mysql_fetch_array($poresults))
		{
			
			echo "<option value=\"". $porow["intSeasonId"] ."\">" . $porow["strSeason"] ."</option>" ;
		}		
		?>
                            </select></td>
                          </tr>
                        <tr style="display:none" >
                          <td  >&nbsp;</td>
                          <td  >&nbsp;</td>
                          <td colspan="3"  ><table width="100%" border="0" cellspacing="3" cellpadding="0" class="normalfnt">
                            <tr>
                              <td><input type="checkbox" name="rdoRptType" id="RPT1" class="txtbox" checked/>
                                Cutting </td>
                            </tr>
                            <tr>
                              <td><input type="checkbox" name="RPT" id="RPT2" class="txtbox" checked="checked"/>
                                Sawing</td>
                            </tr>
                            <tr>
                              <td><input type="checkbox" name="RPT2" id="RPT3" class="txtbox" checked="checked"/> </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>                                Washing - to - Shipping Process </td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr style="display:none" >
                          <td >&nbsp;</td>
                          <td colspan="4" >&nbsp;</td>
                          </tr>
                         
                      </table></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
              <tr>
                <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0">
                    <tr>
                      <td width="25%" align="center">                     
                      <img src="../../images/new.png" alt="new" onclick="ClearForm();"/>
                     	<img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" onclick="viewReport();"/><img src="../../images/download.png"  border="0" onclick="ShowExcelReport();" />
                      <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a>                      </td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
function ClearForm(){	
	setTimeout("location.reload(true);",0);
	//$("#frmBalance")[0].reset();
}


<!--</form>-->
</body>
</html>


