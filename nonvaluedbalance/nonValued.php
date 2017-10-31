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
    <tr>
      <td><table width="700" class="tableBorder" border="0" cellspacing="3" cellpadding="0" align="center">
        <!--<tr>
    <td>
      <div align="left">
        
        </div></td></tr>-->
        <tr>
          <td class="mainHeading" >Non-Valued Balance Break Down</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="normalfnt bcgl1" >
            <tr>
              <td width="12%"  height="25" nowrap="nowrap">&nbsp;PO/ Style No</td>
              <td width="20%"><select name="cmbStyle" class="txtbox" style="width:180px" id="cmbStyle" tabindex="6"  onchange="LoadColor();">
                <option value=""></option>
                <?php 
			$strpo="select  scch.intStyleId,strOrderNo,strStyle from style_cut_compo_header scch inner join orders on orders.intStyleId=scch.intStyleId  where orders.intStatus=11 order by strOrderNo";
		
			$poresults=$db->RunQuery($strpo);
			
			while($porow=mysql_fetch_array($poresults))
			{?>
                <option value="<?php echo $porow['intStyleId'];?>"><?php echo $porow['strOrderNo']."/ ".$porow['strStyle'];?></option>
                <?php } ?>
                </select></td>
              <td width="12%">&nbsp;&nbsp;Date<span style="color:#FF0000"></span></td>
              <td width="20%"><input name="txtCutDate" type="text" tabindex="10" class="txtbox" id="txtCutDate" style="width:100px"  value="<?php echo date('d/m/Y');?>" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
            </tr>
            <tr>
              <td height="25">&nbsp;Process<span style="color:#FF0000"></span></td>
              <td><select name="cboProcess" class="txtbox" style="width:180px" id="cboProcess" tabindex="5">
                <option value=""></option>
                <?php 
			$processstr="SELECT
						  strProcess,
						  intSerial
						FROM production_process
						ORDER BY intSequence";
		
			$processresults=$db->RunQuery($processstr);
			
			while($processrow=mysql_fetch_array($processresults))
			{
		?>
                <option value="<?php echo $processrow['intSerial'];?>"><?php echo $processrow['strProcess'];?></option>
                <?php } ?>
              </select></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <!--<tr bgcolor="#CA521A" >
        <td height="3" class="mbari9"></td>
      </tr>-->
        <!--<tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1 normalfnt">
            <tr>
              <td height="30" width="12%">&nbsp;</td>
              <td width="5%"><div align="right"></div></td>
              <td width="11%"><div align="center"></div></td>
              <td width="5%">
                  <div align="right"></div></td>
              <td width="27%"><div align="center"></div></td>
              <td width="16%"><div align="center"></div></td>
              <td width="12%"><div align="center"></div></td>
              <td width="12%"><div align="center"></div></td>
            </tr>
        </table></td>
      </tr>-->
        <!-- <tr>
        <td height="22" class="mbari9"></td>
      </tr>-->
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt bcgl1">
            <tr>
              <td height="30" colspan="10" >
                <div id="divcons2"  style="overflow:scroll;  width:690px;">
                  <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblLayer">
                   
                    <tr class="mainHeading4">
<?php 
$str_nonvalue="SELECT 	
intNonValueId, 
strNonValueTitle	 
FROM 
production_nonvaluebalances ";
$result_nonvalue=$db->RunQuery($str_nonvalue);
while($row_noninvoice=mysql_fetch_array($result_nonvalue)){
$noninvoice_title[$i++]=$row_noninvoice["strNonValueTitle"];
$noninvoice_id[$j++]=$row_noninvoice["intNonValueId"];	
}
foreach($noninvoice_title as $title){
?>

                      <td  height="25"  ><?php echo $title;?></td>
                      <?php }?>
                      </tr>
                       <tr class="normalfnt" bgcolor="#FFFFFF">
                      <?php 
					  foreach($noninvoice_id as $nid){
?>

                      <td  height="25" style="text-align:center" ><input name="<?php echo $nid;?>" type="text" class="txtbox" style="text-align:right; width:80px; " id="<?php echo $nid;?>"  maxlength="5" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
                      <?php }?>
                      </tr>
                    </table>
                </div></td>
            </tr>
            <tr>
              <td width="11%" >&nbsp;</td>
              <td width="10%">&nbsp;</td>
              <td width="13%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="5%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" class="bcgl1" cellspacing="0" cellpadding="0">
            <tr >
              <td width="23%" height="30"><div align="right">
                <img  src="../../images/new.png" id='btnNew'/>
              </div></td>
              <td width="11%"><div align="center">
                <img id="btnSave"  src="../../images/save.png"  class="mouseover" />
              </div></td>
              <td width="24%"><a href="../../../main.php">
                <img   src="../../images/close.png" class="mouseover"  />
              </a></td>
            </tr>
          </table></td>
        </tr>
        <!--<tr>
        <td height="5"></td>
      </tr>-->
        <!--<tr>
        <td class="bcgl1"><div id="divcons"  style="overflow:scroll; height:150px; width:100%;" >
            <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03"  id="tblLayer">
              <tr class="mainHeading4">
                <td width="10%"  >Pattern No</td>
                <td width="10%"  >Style</td>
                <td width="10%"  >Size</td>
                <td width="10%"  >Cut No</td>
                <td width="10%"  >Bundle No</td>
                <td width="10%"  >Shade</td>
                <td width="10%"  >Number Range</td>
                <td width="10%"  >Component</td>
                <td width="10%"  >Pcs</td>
                <td width="10%"  >Serial #</td>
              </tr>
            </table>
        </div></td>
      </tr>-->
      </table></td>
    </tr>
    <tr>
		<td>&nbsp;</td>
	</tr>
</table>
</body>
	
    <script src="nonValued.js" type="text/javascript"></script>
</html>