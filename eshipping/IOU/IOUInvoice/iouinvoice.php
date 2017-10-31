<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IOU Invoice </title>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../AATestRB/InterJob/java.js" type="text/javascript"></script>
<script src="../NewFabricInspectionJS.js"></script>
<script src="iouInvoice.js"></script>
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
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
	
</head>
<body>
<!--<body onload="setDefaultDate()">-->
<form name="frmFabricIns" id="frmFabricIns" >
<table width="950" border="0" align="center" class="bcgl1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../../Header.php'; 
 ?></td>
</tr>
  
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">IOU Invoice </td>
  </tr>
  <tr>
    <td height="41" colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" rowspan="2" class="bcgl1 "><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="radiobutton" type="radio" value="radiobutton" id="radiobutton2" />
              &nbsp;&nbsp; Import</td>
          </tr>
          <tr>
            <td  height="25" class="ui-icon-contact">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name="radiobutton" type="radio" value="radiobutton" id="radio2" />
              &nbsp;&nbsp; Export</td>
          </tr>
        </table></td>
        <td  width="9%" height="26">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IOU No </td>
        <td  width="12%"><select name="cboiouno" style="width:100px" id="cboiouno" class="txtbox" onchange="setbydelivery(this);" >
          <?php
				$SQL = " SELECT 	intIOUNo FROM tbliouheader WHERE intSettled=1  ";
		
				$result = $db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intIOUNo"] ."\">" . $row["intIOUNo"] ."</option>" ;
				}
							?>
        </select></td>
        <td  width="10%">&nbsp;&nbsp;Invoice No</td>
        <td  width="11%"><input name="txtinvoiceNO" style="width:100px" id="txtinvoiceNO" class="txtbox" value="<?php $SQL = ' SELECT intInvoiceno 	FROM syscontrol';
                    		$result = $db->RunQuery($SQL);
								$row=mysql_fetch_array($result);echo $row['intInvoiceno']?>" disabled="disabled" /></td>
        <td  width="9%">&nbsp;&nbsp;Delivery No </td>
        <td  width="12%"><select name="cboDelivery" style="width:100px" id="cboDelivery" class="txtbox" onchange="setbydelivery(this);">
          <?php
				$SQL = " SELECT 	intIOUNo,intDeliveryNo FROM tbliouheader WHERE intSettled=1 ";
		
				$result = $db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intIOUNo"] ."\">" . $row["intDeliveryNo"] ."</option>" ;
				}
			?>
        </select></td>
        <td  width="9%">&nbsp;&nbsp;B/L No </td>
        <td  width="12%"><input name="txtBL" readonly="readonly" class="txtbox" id="txtBL" style="width:100px" /></td>
      </tr>
      
      <tr>
        <td height="25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SE No </td>
        <td><input name="txtSEno" type="text" class="txtbox" id="txtSEno" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  style="width:100px" maxlength="10" /></td>
        <td>&nbsp;&nbsp;Entry No </td>
        <td><input name="txtClrShading2224" type="text" class="txtbox" id="txtClrShading2224" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  style="width:100px" maxlength="10" /></td>
        <td>&nbsp;&nbsp;Inv Dat</td>
        <td><input name="txtCurrentDate" type="text" class="txtbox" id="txtCurrentDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('Y/m/d');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
        <td>&nbsp;&nbsp;Due Date </td>
        <td><input name="txtduedate" type="text" class="txtbox" id="txtVoyageDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('Y/m/d');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
      </tr>
    </table>    </td>
  </tr>
   <tr><td class="bcgcolor" height="10">
  
  </td>
  </tr> 
  <tr>
    <td  height="10">
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="bcgl1">
                      <tbody><tr>
                        <td height="25" width="20%" class="normalfnt">&nbsp;&nbsp;Consignee</td>
                        <td width="35%" class="normalfnt"><input style="width: 260px;" id="txtConsignee" class="txtbox" readonly="readonly" name="txtConsignee"></td>
                        <td width="15%" class="normalfnt">Exporter</td>
                         <td width="30%" class="normalfnt"><input  style="width: 260px;" id="txtExporter" class="txtbox" readonly="readonly" name="txtExporter"></td>
                      </tr>
                      <tr>
                        <td class="normalfnt" height="25">&nbsp;&nbsp;Forwader</td>
                        <td class="normalfnt"><input style="width: 260px;" id="txtForwader" class="txtbox" readonly="readonly" name="txtForwader"></td>
                        <td class="normalfnt">Wharf Clerk </td>
                        <td class="normalfnt"><input style="width: 260px;" id="txtClerk" readonly="readonly" class="txtbox" name="txtClerk"></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;&nbsp;Vessel / Flight </td>
                        <td class="normalfnt"><table cellspacing="0" width="85%">
                            <tbody><tr>
                              <td width="31%"><input type="text" style="width:80px" readonly="readonly" id="txtVessel" class="txtbox" name="txtVessel"></td>
                              <td align="center" width="32%">No Of PKGS </td>
                              <td width="37%"><input type="text" style="width:80px" readonly="readonly" id="txtPKGS" class="txtbox" name="txtPKGS"></td>
                            </tr>
                        </tbody></table></td>
                        <td class="normalfnt">Merchandiser</td>
                        <td class="normalfnt"><table cellspacing="0" cellpadding="0" border="0" width="100%" readonly="readonly">
                            <tbody><tr>
                              <td width="41%"><input type="text" style="width: 260px;" id="txtMerchandiser" class="txtbox" readonly="readonly" name="txtMerchandiser"></td>
                            </tr>
                        </tbody></table></td>
                      </tr>
                      <tr>
                        <td class="normalfnt" height="25">&nbsp;&nbsp;Reason For Dupplicate </td>
                        <td class="normalfnt"><input type="text" style="width: 260px;"  id="txtReason" class="txtbox" readonly="readonly" name="txtReason"></td>
                        <td class="normalfnt">Vat </td>
                        <td class="normalfnt"><div align="left">
  <input type="checkbox" id="chkVat" class="txtbox" checked="checked"/>&nbsp;&nbsp;Include Vat
                        </div></td>
                      </tr>
                    </tbody></table>    </td>
  </tr>
  <tr><td class="bcgcolor" height="10"></td>
  </tr> 
  <tr>
    <td  ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td height="30" width="11%"><div align="center">Hanging </div></td>
        <td width="13%"><input name="txtHanging" type="text" class="txtbox normalfntRite" id="txtHanging" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  style="width:100px" maxlength="10" value="0"/></td>
        <td width="13%"><div align="center">Documentation</div></td>
        <td width="13%"><input name="txtDocumentation" type="text" class="txtbox normalfntRite" id="txtDocumentation" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  style="width:100px" maxlength="10" value="0"/></td>
        <td width="13%"><div align="center">Agency Fee</div></td>
        <td width="12%"><input name="txtAgency" type="text" class="txtbox normalfntRite" id="txtAgency" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  style="width:100px" maxlength="10" value="0"/></td>
        <td width="11%"><div align="center">Other</div></td>
        <td width="14%"><input value="0" name="txtOther" type="text" class="txtbox normalfntRite" id="txtOther" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  style="width:100px" maxlength="10" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td height="30" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td  class="bcgcolor" height="15"></td>
          </tr>
        </table></td>
		<td width="20%" class="bcgl1"><div align="center"><img src="../../images/addmark.png" width="47" height="24"  class="mouseover" onclick="loadExpensePop()"/></div></td>
      </tr>
    </table></td>
  </tr>
 <!-- <tr>
    <td class="bcgcolor" height="10"></td>
  </tr>-->
  
   
  <tr><td align="center" class="bcgl1"><div id="divcons"  style="overflow:scroll; height:230px; width:950px;"><table width="100%" cellpadding="0"  cellspacing="1" id="tbliou" bgcolor="#ccccff">
                      <tr>
                        <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
                         <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Other</td>
                        <td width="5%" height="24" bgcolor="#498CC2" class="normaltxtmidb2">Id</td>
                        <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">Expenses</td>
                        <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Estimate</td>
                        <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Actual</td>
                        <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Ex/Short</td>
                        <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice</td>
                        </tr>
                      <!--<tr>
                        <td    class="normalfnt">&nbsp;</td>
                        <td    class="normalfnt">1</td>
                        <td    class="normalfnt"> 10 </td>
                        <td    class="normalfnt">10</td>
                        <td    class="normalfnt">110</td>
                        <td    class="normalfnt">10</td>
                        <td    class="normalfnt">10</td>
                        </tr>-->
                      
                    </table></div>
  </td></tr> 
  <tr><td><table width="100%" cellpadding="1" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
      	<td width="6%">&nbsp;</td>
        <td width="12%" height="29">&nbsp;</td>
        <td width="12%"><img src="../../images/new.png" alt="new" name="butNew" width="84" height="24" class="mouseover"  id="butNew" onclick="frmReload();"/></td>
        <td width="12%"><img src="../../images/cancel.jpg" width="84" height="24" onclick="frmReload();" /></td>
        <td width="12%"><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="updateiou('save');" /></td>
        <td width="12%"><img src="../../images/report.png" alt="butReportList" name="butReportList" width="84" height="24" class="mouseover" id="butReport" onclick="printthis();"/></td>
        <td width="12%"><a href="../../main.php"><img src="../../images/close.png" width="84" height="24" border="0" class="mouseover"  /></a></td>
        
        <td width="12%"><label></label></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div style="  width: 200px; visibility:hidden; height:70 2px;" id="confirmReport" >
<table border=0><tr><td height="55" align="center"><h3>Saving......</h3>
</body>
</html>