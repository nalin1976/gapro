<?php
$backwardseperator = "../../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Credit/ Debit Notes</title>
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
<script src="creditdebitnote.js" type="text/javascript"></script>
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

<body >

<?php
	include "../../../Connector.php";	
	
				
?>

<form name="frmbom" id="frmbom" >
<table width="950" border="0" align="center" cellspacing="1" cellpadding="0" bgcolor="#FEFFFF">
<tr>
    <td height="32"><?php include '../../../Header.php'; ?></td>
</tr>
<tr>
    <td height="25" bgcolor="#498CC2" align="center"><span class="TitleN2white">Credit/ Debit Notes</span></td>
</tr>
<?php 
$strSerial="select dblAdvSerialNo from syscontrol";
$resultSerial=$db->RunQuery($strSerial);
$rowserial=mysql_fetch_array($resultSerial);
?>

  
    <tr>
      <td colspan="2" class="bcgcolor" height="14"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="normalfnt">
        <tr>
          <td width="50%"><div align="right">
            <input type="radio" id="rdoCredit" name="rdoCredit" onchange="NewNo();" />
            Credit Note</div></td>
          <td width="50%" valign="middle"><div align="left">
            <input type="radio" id="rdoDebit"  name="rdoCredit"  onchange="NewNo();"/>
            Debit Note</div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
        <td colspan="2"  height="38" ><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt bcgl1">
          <tr>           
            <td width="15%" height="36"><dd>Transaction No</td>
            <td width="22%"><input name="txtSerail"  type="text" class="txtbox" disabled="disabled" id="txtSerail" tabindex="3" style="width:100px; text-align:center"  maxlength="100"  />
            <img src="../../../images/view.png" alt="load" width="91" height="19" class="mouseover"/></td>
            <td width="13%"><dd>Customer</td>
            <td width="17%"><select id="cmbCustomer" class="txtbox" style="width:180px" onchange="viewIOU();"  name="cmbCustomer">
               <option value=""></option>
               <?php 
				$str="	select 	strCustomerID, strName 
						from customers order by strName";
				$results=$db->RunQuery($str);
					while($row=mysql_fetch_array($results)){?>
               <option value="<?php echo $row['strCustomerID'];?>"><?php echo $row['strName'];?></option>
               <?php }?>
             </select></td>
            <td width="10%"><dd>Date</td>
            <td width="20%"><input name="txtDate" style="width:100px; text-align:center" type="text" class="txtbox" id="txtDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
          </tr>
        </table></td>
    </tr>
  	 <tr>
  	   <td colspan="2"  height="14"></td>
    </tr>
  	 <tr>
      <td colspan="2"  height="14"><table width="100%" border="0" cellspacing="1" cellpadding="0" >
        <tr>
          <td width="38%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt bcgl1" >
            <tr>
              <td width="50%" height="28"><dd>Invoice No</td>
              <td  width="50%"><select   name="cmbIOU" class="txtbox" id="cmbIOU" style="width:120px" tabindex="4">
                <option value=""></option>
               
              </select></td>
            </tr>
            <tr>
              <td  height="27"><dd>Description</td>
              <td><input name="txtDescription"  type="text" class="txtbox" id="txtDescription"  style="width:160px"  maxlength="100" tabindex="5" /></td>
            </tr>
            <?php 
			$strTax="select dblRate from tax where strTaxCode='VAT'";
			$resultsTax=$db->RunQuery($strTax);
			$rowtax=mysql_fetch_array($resultsTax);
			?>
            <tr>
              <td  height="27"><dd>Amount</td>
              <td><input name="txtAmount"  type="text" class="txtbox" id="txtAmount"  style="width:100px; text-align:right;"  maxlength="14" tabindex="6" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/><input type="hidden" value="<?php echo $rowtax['dblRate'];?>" id="amtVat" /></td>
            </tr>
            <tr>
              <td  height="27"><dd>Vat Amount</td>
              <td><input name="txtVat"  type="text" class="txtbox" id="txtVat" onfocus="setvat();"  style="width:100px; text-align:right"  maxlength="14" tabindex="7" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
            </tr>
            <tr>
              <td  height="27"><dd>Toatal</td>
              <td><input name="txtTotal"  type="text" class="txtbox " id="txtTotal"  style="width:100px; text-align:right"  maxlength="14" tabindex="8" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onfocus="settotal();"/></td>
            </tr>
            <tr class="bcgcolor-highlighted">
              <td colspan="2"><div align="center"><img src="../../../images/add_alone.png" alt="add" width="72" height="18" onclick="addtogrid();" class="mouseover" /></div></td>
              </tr>
          </table></td>
           <td  width="2%"></td>
          <td width="60%" valign="top"><div id="divcons1"  style="overflow:scroll; height:160px; width:100%;" >
              <table width="100%" height="23" class="normalfnt" cellpadding="0" cellspacing="1" bgcolor="#ccccff" id="tblDetail">
                <tr bgcolor="#498CC2" >
                   <td width="10%" height="20"  class="normaltxtmidb2"></td>
                  <td width="45%" height="20"  class="normaltxtmidb2">Description</td>                  
                   <td width="15%" height="20"  class="normaltxtmidb2">Amount</td>
                  <td width="15%"  class="normaltxtmidb2">Vat</td>
                   <td width="15%" height="20"  class="normaltxtmidb2">Total</td>
                 
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
        <td colspan="2" class="normalfnt " ></td>
    </tr>
     <tr><td height="32" colspan="2" class="normalfnt bcgl1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr bgcolor="#d6e7f5">
         <td width="24%" height="29">&nbsp;</td>
         <td width="12%"><img src="../../../images/new.png" alt="new" width="96" height="24" class="mouseover" onclick=" NewNo();"/></td>
         <td width="20%" id="cellsave"><img src="../../../images/save-confirm.png" alt="save" width="174" height="24" class="mouseover" onclick="saveForm();" /></td>
         <td width="13%"><img src="../../../images/print.png" alt="cancel" width="104" height="24" class="mouseover" onclick="printNote();"/></td>
         <td width="12%"><a href="../../../main.php"><img src="../../../images/close.png" alt="close" width="97" height="24" class="mouseover noborderforlink" /></a></td>
         <td width="19%">&nbsp;</td>
       </tr>
     </table></td></tr>    
  </table>
</td>
  </tr>
 
        
    </table></td>
  </tr>
</table>
</form>
<div style="  width: 200px; visibility:hidden; height:70 2px;" id="savingprogress" ></div>
</body>
</html>

