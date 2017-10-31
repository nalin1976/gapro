<?php
$backwardseperator = "../../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web -Fund Transfer</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<link type="text/css" href="../../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />

<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<script src="fundtransfer.js" type="text/javascript"></script>
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
<?php
	include "../../../Connector.php";	
	
				
?>
</head>
<body >
<table width="950" border="0" align="center" cellspacing="0" cellpadding="0" class="bcgl1" bgcolor="#FEFFFF">
<tr>
    <td height="32"><?php include '../../../Header.php'; ?></td>
</tr>
<tr>
  <td bgcolor="#498CC2" align="center"><span class="TitleN2white">IOU Fund Transfer</span></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt bcgl1">
    <tr>
      <td width="11%" height="36"><div align="center">Transaction No
        </dd>
      </div></td>
      <td width="22%"><input name="txtSerail"  type="text" class="txtbox" disabled="disabled" id="txtSerail" tabindex="3" style="width:100px; text-align:center"  maxlength="100" value="<?php echo "TRF-".$rowserial['dblFundTransferNo'];?>" />
          <img src="../../../images/view.png" alt="load" width="91" height="19" class="mouseover"/></td>
      <td width="4%"><div align="center">Bank
        </dd>
      </div></td>
      <td width="19%"><select id="cmbBank" class="txtbox" style="width:180px"   name="cmbBank">
          <option value=""></option>
          <?php 
				$strBank="	select 	strBankCode,strName from bank order by strName";
				$resultsBank=$db->RunQuery($strBank);
					while($rowBank=mysql_fetch_array($resultsBank)){?>
          <option value="<?php echo $rowBank['strBankCode'];?>"><?php echo $rowBank['strName'];?></option>
          <?php }?>
      </select></td>
      <td width="6%"><div align="center">Date
        </dd>
      </div></td>
      <td width="14%"><input name="txtDate" style="width:100px; text-align:center" type="text" class="txtbox" id="txtDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
      <td width="10%" ><div align="center">Total Amount</div></td>
      <td width="14%" ><input readonly="readonly" name="txtTotal" tabindex="4" type="text" class="txtbox" id="txtTotal" style="width:120px; text-align:right;"  maxlength="20"  onkeypress="return CheckforValidDecimal(this.value, 4,event);"  value="0"/></td>
    </tr>
  </table></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><table width="100%" border="0" cellspacing="1" cellpadding="0" >
    <tr>
      <td width="38%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt bcgl1" >
           <tr>
            <td  height="27"><dd>IOU Number</td>
            <td><select id="cmbIOUno" class="txtbox" style="width:180px"   name="cmbIOUno" tabindex="4">
              <option value=""></option>
              <?php 
					$strWharf="	select
								intWharfClerkID,
								strName
								from 
								wharfclerks";
				$resultsWharf=$db->RunQuery($strWharf);
					while($rowWharf=mysql_fetch_array($resultsWharf)){?>
              <option value="<?php echo $rowWharf['intWharfClerkID'];?>"><?php echo $rowWharf['strName'];?></option>
              <?php }?>
            </select></td>
          </tr>
          <tr>
            <td  height="27"><dd>Key Wharf</dd></td>
            <td><select id="cmbKeyWharf" class="txtbox" style="width:180px"   name="cmbKeyWharf" tabindex="4">
              <option value=""></option>
              <?php 
					$strWharf="	select
								intWharfClerkID,
								strName
								from 
								wharfclerks";
				$resultsWharf=$db->RunQuery($strWharf);
					while($rowWharf=mysql_fetch_array($resultsWharf)){?>
              <option value="<?php echo $rowWharf['intWharfClerkID'];?>"><?php echo $rowWharf['strName'];?></option>
              <?php }?>
            </select></td>
          </tr>
          <tr>
            <td width="44%" height="28"><dd>Wharf Clerk</dd></td>
            <td  width="56%"><select id="cmbWharf" class="txtbox" style="width:180px"   name="cmbWharf" tabindex="4">
                <option value=""></option>
                <?php 
					$strWharf="	select
								intWharfClerkID,
								strName
								from 
								wharfclerks";
				$resultsWharf=$db->RunQuery($strWharf);
					while($rowWharf=mysql_fetch_array($resultsWharf)){?>
                <option value="<?php echo $rowWharf['intWharfClerkID'];?>"><?php echo $rowWharf['strName'];?></option>
                <?php }?>
            </select></td>
          </tr>
         
          <tr>
            <td  height="27"><dd>Expense Type</dd></td>
            <td><input name="txtAccountName"  type="text" class="txtbox" id="txtAccountName"  style="width:160px"  maxlength="30" tabindex="5" /></td>
          </tr>
          <?php 
			$strTax="select dblRate from tax where strTaxCode='VAT'";
			$resultsTax=$db->RunQuery($strTax);
			$rowtax=mysql_fetch_array($resultsTax);
			?>
          <tr>
            <td  height="27"><dd>Account No</dd></td>
            <td><input name="txtAccountNo"  type="text" class="txtbox" id="txtAccountNo"  style="width:160px"  maxlength="100" tabindex="6" /></td>
          </tr>
          <tr>
            <td  height="27"><dd>Amount</dd></td>
            <td><input name="txtAmount"  type="text" class="txtbox" id="txtAmount"  style="width:100px; text-align:right"  maxlength="14" tabindex="7" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr class="bcgcolor-highlighted">
            <td colspan="2"><div align="center"><img src="../../../images/add_alone.png" alt="add" width="72" height="18" onclick="addtogrid();" class="mouseover" /></div></td>
          </tr>
      </table></td>
      <td  width="2%"></td>
      <td width="60%" valign="top"><div id="divcons1"  style="overflow:scroll; height:180px; width:100%;" >
          <table width="100%" height="23" class="normalfnt " cellpadding="0" cellspacing="1"bgcolor="#ccccff" id="tblDetail">
            <tr bgcolor="#498CC2" >
              <td width="10%"  class="normaltxtmidb2">&nbsp;</td>
              <td width="15%" height="20"  class="normaltxtmidb2">IOU #</td>
              <td width="20%" height="20"  class="normaltxtmidb2">Key Wharf</td>
              <td width="20%" height="20"  class="normaltxtmidb2">Wharf Clerk</td>
              <td width="20%"  class="normaltxtmidb2">Type</td>
              <td width="15%" height="20"  class="normaltxtmidb2">Amount</td>
            </tr>
          </table>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td colspan="3"  height="14"></td>
    </tr>
  </table></td>
</tr>
<tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#d6e7f5">
        <td width="24%" height="29">&nbsp;</td>
        <td width="12%"><img src="../../../images/new.png" alt="new" width="96" height="24" class="mouseover" onclick="newFrm();"/></td>
        <td width="20%" id="cellsave"><img src="../../../images/save-confirm.png" alt="save" width="174" height="24" class="mouseover" onclick="saveForm();" /></td>
        <td width="13%"><img src="../../../images/print.png" alt="cancel" width="104" height="24" class="mouseover" onclick="printNote();"/></td>
        <td width="12%"><a href="../../../main.php"><img src="../../../images/close.png" alt="close" width="97" height="24" class="mouseover noborderforlink" /></a></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
</tr>
</table>  
</body>
</html>