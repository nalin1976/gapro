<?php
$backwardseperator = "../../../../";
include '../../../../Connector.php' ;
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro | Suspended VAT Report</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../../../javascript/calendar/theme.css" />
<script src="../../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../../javascript/script.js" type="text/javascript"></script>
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
<script>
function checkDate()
{
	if(document.getElementById("chkDate").checked==true)
	{
		document.getElementById("txtFromDate").disabled=false;
		document.getElementById("txtToDate").disabled=false;
		document.getElementById("txtFromDate").value="<?php echo date('Y-m-d') ?>";
		document.getElementById("txtToDate").value="<?php echo date('Y-m-d') ?>";
	}
	else
	{
		
		document.getElementById("txtFromDate").disabled=true;
		document.getElementById("txtToDate").disabled=true;
		document.getElementById("txtFromDate").value="";
		document.getElementById("txtToDate").value="";
		
	}
}

function showReport()
{
		var company      = document.getElementById("cboFactory").value;
		var dateFrom  	 = document.getElementById("txtFromDate").value;
		var dateTo	   	 = document.getElementById("txtToDate").value;
		var Vat	       	 = document.getElementById("txtVat").value;
		var CurrencyRate = document.getElementById("txtCurrencyRate").value;
		var ReportType   = document.getElementById("cboReportType").value;
		var currency     = document.getElementById("cboCurrency").value;
		var chkDate		 = document.getElementById("chkDate").checked;
		
		if(ReportType==1)
		{
			/*if(company=="")
			{
				alert("Please select a ' Company '.");
				document.getElementById("cboFactory").focus();
				return;
			}*/
			if(Vat=="")
			{
				alert("Please enter a 'VAT Percentage'.");
				document.getElementById("txtVat").focus();
				return;
			}
			if(CurrencyRate=="")
			{
				alert("Please enter a 'Currency Rate'.");
				document.getElementById("txtCurrencyRate").focus();
				return;
			}
			newwindow=window.open('svat4rpt.php?dateFrom='+dateFrom+'&dateTo='+dateTo+'&company='+company+'&vatRate='+Vat+'&currency='+currency +'&CurrencyRate='+CurrencyRate +'&chkDate='+chkDate,'svat4rpt');
			if (window.focus) {newwindow.focus()}
			
		}
		if(ReportType==2)
		{
			if(Vat=="")
			{
				alert("Please enter a 'VAT Percentage'.");
				document.getElementById("txtVat").focus();
				return;
			}
			if(CurrencyRate=="")
			{
				alert("Please enter a 'Currency Rate'.");
				document.getElementById("txtCurrencyRate").focus();
				return;
			}
			newwindow=window.open('svat5rpt.php?dateFrom='+dateFrom+'&dateTo='+dateTo+'&company='+company+'&vatRate='+Vat+'&currency='+currency +'&CurrencyRate='+CurrencyRate +'&chkDate='+chkDate,'svat5rpt');
			if (window.focus) {newwindow.focus()}
		}
		if(ReportType==3)
		{
			/*if(company=="")
			{
				alert("Please select a ' Company '.");
				document.getElementById("cboFactory").focus();
				return;
			}*/
			if(Vat=="")
			{
				alert("Please enter a 'VAT Percentage'.");
				document.getElementById("txtVat").focus();
				return;
			}
			if(CurrencyRate=="")
			{
				alert("Please enter a 'Currency Rate'.");
				document.getElementById("txtCurrencyRate").focus();
				return;
			}
			
		window.open('svat4rpt.php?dateFrom='+dateFrom+'&dateTo='+dateTo+'&company='+company+'&vatRate='+Vat+'&currency='+currency +'&CurrencyRate='+CurrencyRate +'&chkDate='+chkDate,'svat4rpt');
		window.open('svat5rpt.php?dateFrom='+dateFrom+'&dateTo='+dateTo+'&company='+company+'&vatRate='+Vat+'&currency='+currency +'&CurrencyRate='+CurrencyRate +'&chkDate='+chkDate,'svat5rpt');
		window.open('suspendedTaxInvoice.php?dateFrom='+dateFrom+'&dateTo='+dateTo+'&company='+company+'&vatRate='+Vat+'&currency='+currency +'&CurrencyRate='+CurrencyRate +'&chkDate='+chkDate,'printpdf');
			
	}
		if(Vat=="")
		{
			alert("Please enter a 'VAT Percentage'.");
			document.getElementById("txtVat").focus();
			return;
		}
		if(ReportType=="")
		{
			alert("Please select a 'Report Type'.");
			document.getElementById("cboReportType").focus();
			return;
		}
		if(currency=="")
		{
			alert("Please select a 'Currency'.");
			document.getElementById("cboCurrency").focus();
			return;
		}
			
}
function ClearForm()
{
	document.getElementById("cboFactory").value = "";
	document.getElementById("txtVat").value = "";
	document.getElementById("cboReportType").value = "";
	document.getElementById("txtCurrencyRate").value = "";
	
	if(document.getElementById("chkDate").checked==false)
	{
		document.getElementById("txtFromDate").disabled=false;
		document.getElementById("txtToDate").disabled=false;
		document.getElementById("txtFromDate").value="<?php echo date('d/m/Y') ?>";
		document.getElementById("txtToDate").value="<?php echo date('d/m/Y') ?>";
		document.getElementById("chkDate").checked="checked";
	}
	else
	{
		document.getElementById("txtFromDate").value="<?php echo date('d/m/Y') ?>";
		document.getElementById("txtToDate").value="<?php echo date('d/m/Y') ?>";
	}
	
}
</script>
</head>
<body>

<form id="frmSVATReport" name="frmSVATReport" >
  <table width ="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php include '../../../../Header.php'; ?></td>
  </tr>
  <tr>
  <td height="2"></td>
  </tr>
  <tr>
    <td><table width="500" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder" cellspacing="2">
    
    <tr>
      <td height="25"class="mainHeading"> Suspended VAT Report</td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td><table width="100%" border="0" align="center"  cellspacing="0" cellpadding="2">
  <tr>
    <td><table width="100%" border="0" cellpadding="1" align="center" class="tableBorder">
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="5" class="normalfnt">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="2" class="normalfnt">Company</td>
        <td colspan="3"><select name="cboFactory" style="width:278px" id="cboFactory" tabindex="1">
          <?php
		$SQL ="select strCustomerID,concat(strName,'-',strMLocation)as strName
				from eshipping.customers
				order by strName";	
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCustomerID"] ."\">" . $row["strName"] ."</option>" ;
	}		  
		 ?>
        </select></td>
        </tr>
      <tr>
        <td class="normalfnt" style="text-align:center"><input name="chkDate" id="chkDate" type="checkbox" checked="checked" onclick="checkDate()" /></td>
        <td colspan="2" class="normalfnt">Invoice Date From</td>
        <td><span class="normalfnt">
          <input name="txtFromDate" type="text" tabindex="7" class="txtbox" id="txtFromDate" style="width:90px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date('Y-m-d');?>" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" />
        </span></td>
        <td><span class="normalfnt">To</span></td>
        <td width="140" class="normalfnt"><input name="txtToDate" type="text" tabindex="7" class="txtbox" id="txtToDate" style="width:90px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date('Y-m-d');?>" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="resetto" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
        </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="2" class="normalfnt">VAT Percentage<span class="compulsoryRed"> *</span></td>
        <td width="160" class="normalfnt"><input name="txtVat" type="text" class="txtbox" id="txtVat" onkeypress="return CheckforValidDecimal(this.value, 2,event);"  style="width:90px" maxlength="3" tabindex="3"/>&nbsp;&nbsp;%</td>
        <td width="18" class="normalfnt">&nbsp;</td>
        <td width="140" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td width="20" class="normalfnt">&nbsp;</td>
        <td colspan="2" class="normalfnt">Currency / Rate<span class="compulsoryRed"> *</span></td>
        <td colspan="2" class="normalfnt"><select name="cboCurrency" id="cboCurrency" style="width:165px" disabled="disabled">
          <option value="2" selected="selected">SLR</option>
          <!-- <?php
		  $sql = "select intCurID,strCurrency from currencytypes order by intCurID;";
		  $result = $db->RunQuery($sql);
		  while($row = mysql_fetch_array($result))
		  {
		  		echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
		  }		  
		  ?>-->
        </select></td>
        <td class="normalfnt"><label for="textfield"></label>
          <input type="text" name="txtCurrencyRate" id="txtCurrencyRate" style="width:90px" /></td>
        </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="2" class="normalfnt">Report Type<span class="compulsoryRed"></span></td>
        <td colspan="2" class="normalfnt"><select name="cboReportType" id="cboReportType" style="width:165px">
          <option value="3" selected="selected">All</option>
          <option value="1">SVAT Format 4</option>
          <option value="2">SVAT Format 5</option>
        </select></td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" class="normalfnt">&nbsp;</td>
        <td width="112" class="normalfnt">&nbsp;</td>
        <td colspan="4" class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tableBorder">
  <tr>
    <td align="center"><img src="../../../../images/new.png" alt="New" name="New" class="mouseover" id="butNew" style="display:inline" onclick="ClearForm();" tabindex="7"/><img src="../../../../images/report.png" alt="report" name="report" class="mouseover" id="butReport" style="display:inline" onclick="showReport();" tabindex="6"/><a href="../../../../main.php" id="td_coDelete" class="noborderforlink"><img src="../../../../images/close.png" alt="Close" name="Close" border="0" id="Close" style="display:inline" tabindex="9"/></a></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
          </tr>
        </table></td>
  </tr>
 </table>
 </td>
 </tr>
 </table>  
 </form>
</body>
</html>
