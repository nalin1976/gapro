<?php
session_start();
$backwardseperator = "../../";

include "../../Connector.php";	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Exchange Rate</title>

<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css">
<script src="../../calendar/calendar.js" type="text/javascript" language="javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

<script src="exRate.js" type="text/javascript" language="javascript"></script>
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
<form name="frmExRange" id="frmExRange" method="post" action="">
  <table width="100%" border="0">
    <tr>
      <td><?php include $backwardseperator."Header.php"; ?></td>
    </tr>
    <tr>
      <td><table width="550" border="0" align="center" class="tableBorder" cellspacing="0">

        <tr>
          <td colspan="4" height="25" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                <td width="72%" class="mainHeading">Exchange Rate </td>
                <td width="15%" class="seversion"> (Ver 0.4) </td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td height="5" width="32%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
          <td width="9%">&nbsp;</td>
          <td width="34%">&nbsp;</td>
        </tr>
		
            <tr>
			<td colspan="4" align="center">
			<table width="50%">
        <tr>
          <td class="normalfntRite" width="27%">Date &nbsp;<span class="compulsoryRed" >*</span></td>
          <td colspan="3"><input name="txtValidFrom" type="text"  class="txtbox" id="txtValidFrom" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" tabindex="1"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        </tr>
			</table>			</td>
			</tr>
		
        
        <tr>
          <td colspan="4" align="center">
          	<table width="100%" border="0" class="bcgl1" >
                        <tr><td><div align="center" id="divItem" style="overflow:scroll; width:100%; height:150px;"><table width="100%" border="0" bgcolor="#FAD163" cellspacing="1" id="tblExchngRate" align="center" cellpadding="3">
            <tr >
             <td width="10%" class="normaltxtmidb2" bgcolor="D1A739">Select </td>
            <td width="40%" class="normaltxtmidb2" bgcolor="D1A739">Currency</td>
              <td width="60%" class="normaltxtmidb2" bgcolor="D1A739">Rate</td>
            </tr>
            <?php 
			$sysCur=trim($_SESSION["sys_currency"],' ');
			
			$SQL = "select * from currencytypes where intStatus=1";
			$result = $db->RunQuery($SQL);
			$loop = 1;
			while($row=mysql_fetch_array($result))
			{
			$extCur=$row["intCurID"];
			?>
            <tr <?php if($extCur==$sysCur){?> id=1  <?php }?>  >
              <td bgcolor="#FFFFFF" align="center"><input name="chkCurr" <?php if($extCur==$sysCur){?> disabled="disabled" checked="checked" <?php }?> type="checkbox" value="" id="<?php echo $row["intCurID"];?>" tabindex="<?php echo $loop++;?>"></td>
              <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row["intCurID"];?>" <?php if($extCur==$sysCur){?> style="color:#FF0000" <?php }?>><?php echo $row["strTitle"]; ?></td>
              <td bgcolor="#FFFFFF" class="normalfntMid"><input name="txtRate" type="text" size="15"<?php if($extCur==$sysCur){?>value="1" disabled="disabled" <?php } else{?> value="0" <?php }?> style="text-align:right" maxlength="7" onKeyPress="return CheckforValidDecimal(this.value, 7,event);" tabindex="<?php echo $loop++;?>"></td>
            </tr>
            <?php 
			}
			?>
          </table></div></td></tr></table></td>
          </tr>
		  <tr>
		  <td colspan="4">		  </td>
		  </tr>
		  
            <tr>
			<td colspan="4" align="center">
			<table width="39%">
			<tr>
              <td width="53%" align="center"><img src="../../images/new.png" alt="new" width="96" height="24" id="butNew" class="mouseover" onClick="ClearExchangeRateForm();"></td>
			  <td width="47%" align="center"><img src="../../images/save.png" alt="save" width="84" height="24" id="butSave" class="mouseover" onClick="SaveExchangeRate();"></td>
			</tr>
			</table>			</td>
			</tr>
		  
		  
        <tr >
          <td colspan="4"><table width="550" border="0">
            <tr>
              <td align="right">&nbsp;</td>
              <td colspan="2" align="left">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="right"><table width="100%" border="0" class="bcgl1">
                <tr>
                  <td><div align="center" id="divItem" style="overflow:scroll; width:100%; height:150px;">
                  
                    <table width="100%" border="0" bgcolor="#FAD163" cellspacing="1" id="tblExDetails" cellpadding="3">
                      <tr>
                        <td width="5%" class="normaltxtmidb2" bgcolor="D1A739">Del</td>
                        <td width="15%" class="normaltxtmidb2" bgcolor="D1A739">Currency</td>
                        <td width="10%" class="normaltxtmidb2" bgcolor="D1A739">Rate</td>
                        <td width="10%" class="normaltxtmidb2" bgcolor="D1A739">Date From</td>
                       <!-- <td width="10%" class="normaltxtmidb2" bgcolor="D1A739">Date To</td>-->
                      </tr>
                      <?php 
					  		$sql_sel = "Select e.currencyID, c.strTitle, e.dateFrom, e.rate
							            from currencytypes c inner join exchangerate e on
										c.intCurID = e.currencyID where e.intStatus=1 group by e.currencyID,e.dateFrom order by c.strTitle,e.dateFrom";
										
							$resultS = $db->RunQuery($sql_sel);
						while($rowS=mysql_fetch_array($resultS))
						{							
							$IsBaseCurrency = CheckBaseCurrency($rowS["currencyID"]);
					  ?>
                      <tr class="bcgcolor-tblrowWhite">
                        <td id="<?php echo $rowS["currencyID"];?>" align="center">
						<?php if(!$IsBaseCurrency){ ?>
						<img src="../../images/del.png" id="<?php echo $rowS["currencyID"];?>" onClick="deleteRecord(this);">
						<?php } ?>
						</td>
						
                        <td class="normalfnt"><?php echo $rowS["strTitle"]; ?></td>
                        <td class="normalfntRite"><?php echo $rowS["rate"];  ?></td>
                        <td class="normalfntMid"><?php echo $rowS["dateFrom"]; ?></td>
                        <!--<td class="normalfnt"><?php //echo $rowS["dateTo"]; ?></td>-->
                      </tr>
                      <?php } ?>
                    </table>
                  </div></td>
                </tr>
              </table></td>
              </tr>
            <tr>
			<td colspan="3" align="center">
			<table width="40%">
			<tr>
              <td width="50%" align="center"><img src="../../images/report.png"   class="mouseover" onClick="viewGroupDetails();"></td>
              <td width="50%" align="center"><a href="../../main.php"><img src="../../images/close.png" border="0" alt="close" width="97" height="24"></a></td>
			  </tr>
			</table>			</td>
			</tr>
          </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
function CheckBaseCurrency($currencyId)
{
global $db;
	
	$sql="select intBaseCurrency from systemconfiguration where intBaseCurrency='$currencyId'";	
	$result=$db->RunQuery($sql);
	$boo = false;
	while($row=mysql_fetch_array($result))
	{
		$boo =  true;
	}
	return $boo;	
}
?>
