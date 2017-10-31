<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web | Master Invoice</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->


</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
}
-->
</style>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        
<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
<link href="../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="masterInvoice.js"></script>
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
<?php
	include "../../Connector.php";	
?>

<form id="frmMasterInvoice" name="frmMasterInvoice" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<tr>
	<td><table width="100%" border="0">
		<tr>
			<td width="10%">&nbsp;</td>
			<td width="80%">
				<table width="100%" border="0" class="bcgl1">
					<tr>
						<td height="30" bgcolor="#588DE7" class="TitleN2white" align="center">Master Invoice </td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td ><table width="100%" border="0" class="bcgl1">
						  <tr>
						    <td height="5" colspan="7"></td>
					      </tr>
						  <tr>
						    <td class="normalfnt">&nbsp;</td>
						    <td class="normalfnt">Search Invoice</td>
						    <td class="normalfnt"><select name="cboMasterInvNo" id="cboMasterInvNo" style="width:170px" class="txtbox" onchange="loadMasterInvData();" >
							  <option value=""></option>
							  <?php
							  $sql = "select intMasterInvId,strMasterInvNo from masterinvoice_header order by strMasterInvNo;";
							 $result=$db->RunQuery($sql);
						 while($row=mysql_fetch_array( $result)) 
						 echo "<option value=".$row['intMasterInvId'].">".$row['strMasterInvNo']."</option>";
							  ?>
                              </select></td>
						   	<td class="normalfnt">Date From</td>
						   	<td class="normalfnt"><input name="txtDateFrom" style="width:100px; text-align:left" type="text" maxlength="100" class="txtbox" id="txtDateFrom" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('Y-m-d');?>" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
						  	<td class="normalfnt">Date To</td>
						    <td class="normalfnt" style="text-align:right"><input name="txtDateTo" style="width:100px; text-align:left" type="text" maxlength="100" class="txtbox" id="txtDateTo" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('Y-m-d');?>" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
					      </tr>
                           
						   <tr>
						    <td width="1%">&nbsp;</td>
						    <td width="13%" class="normalfnt">Carrier</td>
						    <td width="27%" class="normalfnt"><input type="text" class="txtbox" name="cboBuyer" id="cboBuyer" style="width:150px" /></td>
					        <td width="10%" class="normalfnt">Invoice No </td>
					        <td width="23%"><span class="normalfnt">
					          <input type="text" class="txtbox" name="txtInvoiceNo" id="txtInvoiceNo" style="width:150px" />
					        </span></td>
							<td width="9%" class="normalfnt">&nbsp;Date</td>
						    <td width="17%" class="normalfnt"><input name="txtDate" style="width:100px; text-align:left" type="text" maxlength="100" class="txtbox" id="txtDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>

						  </tr>

						  <tr>
                          <td></td>
                          	<td><img src="../../images/search.png" onclick="getInvoiceDetails();" /></td>
                          </tr> 

                           <tr>
                             
                             <td colspan="7" class="normalfnt"><div style="overflow: scroll; height: 250px; width:100%;" id="selectitem">
                               <table width="100%" cellspacing="1" cellpadding="0" class="bcgl1" id="tblDescription" bgcolor="#D8E3FA">
                               
                                   <tr>
                                     <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap"><input type="checkbox" id="checkBoxAll" name="checkBoxAll" onclick="checkAll(this)" /></td>
                                     <td height="25" width="12%"bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Invoice No </td>
                                     <td width="12%"bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Description</td>
                                     <td width="12%"bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">PO No </td>
                                     <td width="12%"bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Style No </td>
                                     <td width="12%"bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">CTNS</td>
                                     <td width="12%"bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Pcs</td>
                                     <td width="12%"bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Unit Price </td>
                                     <td width="10%"bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Amount</td>
                                   </tr>
                                   
                               </table>
                             </div></td>
                           </tr>
                          <tr>
						    <td colspan="7"></td>
					      </tr>
					    </table></td>
	              </tr>
				  <tr>
            <td height="34" colspan="2"><table width="100%" border="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="743" border="0">
                    <tr>
                      
                      <td align="center"><img src="../../images/new.png" id="btnNew" class="mouseover" name="btnNew" tabindex="29" onclick="clearData();"/><img src="../../images/save.png" alt="Save" width="84" height="24" name="btnSave" id="btnSave"  class="mouseover" onclick="saveData();" />
					  <img src="../../images/report.png" alt="Report" width="84" height="24" name="btnReport" id="btnReport"  class="mouseover" onclick="showReport();" />
					  <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="84" height="24" border="0"  class="mouseover" id="btnClose"lass="mouseover" /></a></td>
                      </tr>
                    
                </table></td>
              </tr>
			  </table>
			</td>
		  </tr>
			  </table>
	  </td>
	  
			<td width="10%"></td>
		</tr>
	</table>
	</td>
</tr>
</table>
</form>





 

</body>
</html>
