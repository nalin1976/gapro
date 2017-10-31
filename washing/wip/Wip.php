<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php"; 
include "{$backwardseperator}authentication.inc";
include_once('class.wip.php');

$objWip=new wip();

$factory=$_POST['wip_cboFactory'];
$po		=$_POST['wip_cboPoNo'];
$frmDate	=$_POST['wip_fromDate'];

$chk	=	$_POST['chkED'];

							$dt=date("Y-m");
						 	$day=date("D");
							$m= date("m"); // Month value
							$de= date("d"); //today's date
							$y= date("Y"); // Year value
						 	$pd="";$nd="";
							 if($day=='Sun'){
								
								 $pd= date('Y-m-d', mktime(0,0,0,$m,($de-1),$y)); 
								 $nd= date('Y-m-d', mktime(0,0,0,$m,($de+1),$y));
							 }
							 else{
								 $pd= date('Y-m-d', mktime(0,0,0,$m,($de-1),$y));
								 $nd= date('Y-m-d', mktime(0,0,0,$m,($de),$y));
							 }
$toDate	=$_POST['wip_toDate'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>Washing WIP </title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<style>
/* TimeEntry styles */
.timeEntry_control {
	vertical-align: middle;
	margin-left: 3px;
}
* html .timeEntry_control { /* IE only */
	margin-top: -4px;
}

</style>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="wip.js" type="text/javascript"></script>

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
$(function () {
	$('#wip_txtTimeIn').timeEntry({spinnerImage: 'spinnerDefault.png'});
	$('#wip_txtTimeOut').timeEntry({spinnerImage: 'spinnerDefault.png'});
});
</script>
</head>

<body>
<form id="frmWip" name="frmWip" action="Wip.php" method="post">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<script type="text/javascript" src="../javascript/jquery.timeentry.js"></script>
<script type="text/javascript" src="../javascript/jquery.mousewheel.js"></script>
<!--<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Washing Wip</div></div>
<div class="main_body">-->
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="bcgl1">
  	<tr>
    	<td class="mainHeading">Washing Wip</td>
    </tr>
    <tr>
      <td valign="top">
	  <fieldset class="fieldsetStyle" style="height:50px;">
      <table width="1000" border="0">
		<tr>
		  <td class="normalfnt">
          
            	<table width="998" border="0">
                	<tr>
                    	<td width="50" class="normalfnt">&nbsp;</td>
          				<td width="433">&nbsp;</td>
                    
                    	
                        
                 
                    	<td width="34" rowspan="1">&nbsp;</td>
                    	<td width="43" class="normalfnt">&nbsp;</td>
          				<td width="124" colspan="0">&nbsp;</td>
                        <td width="33" rowspan="1">Date</td>
                 
                   	  <td width="132"><input name="wip_toDate" type="text" disabled="disabled" class="txtbox" id="wip_toDate"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" style="width:100px"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php if(empty($toDate)){ echo $nd;}else { echo $toDate;} ?>" /><input name="reset2" id="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/></td>
                        <td width="107" colspan="0"><img src="../../images/search.png" onclick="submitFrom();" /></td>
                    </tr>
                </table>
         
          </td>
		  </tr>
      </table>
      </fieldset>
	  </td>
	</tr>
	<tr class="containers" style="text-align:center;">
      <td colspan="2" >Washing WORK IN PROGRESS</td>
	</tr>
	<tr>
      <td height="30" colspan="2">
      <div id="div"  style="overflow:scroll; width:1500px; height:400px;">
        <table width="3000" id="tblWIPGrid"  cellpadding="0" cellspacing="1" border="0">
          <thead>
            <tr>
              <td rowspan="2" class="grid_header" style="width:80px;">DIVISION</td>
              <td rowspan="2" class="grid_header" style="width:120px;">MILL</td>
              <td rowspan="2" class="grid_header" style="width:170px;">STYLE</td>
              <td rowspan="2" class="grid_header" style="width:170px;">PO . NUMBER</td>
              <td rowspan="2" class="grid_header" style="width:100px;">COLOUR</td>
              <td rowspan="2" class="grid_header" style="width:100px;">ORDER QTY</td>
			  <td rowspan="2" class="grid_header" style="width:80px;">CUT QTY</td>
              <td rowspan="2" class="grid_header" style="width:130px;">RCVE TO DAY</td>
              <td rowspan="2" class="grid_header" style="width:100px;">RCVE TOTAL</td>
              <td class="grid_header" colspan="3">RETURN TO FAC:</td>
              <td rowspan="2" class="grid_header" style="width:120px;">BALANCES AT FTY::</td>
              <td rowspan="2" class="grid_header" style="width:100px;">TO DAY WASH</td>
              <td rowspan="2" class="grid_header" style="width:120px;">WASH COMPLETED</td>
              <td rowspan="2" class="grid_header" style="width:150px;">BALANCE AT WASHING </td>
              <td rowspan="2" class="grid_header" style="width:150px;">CHECK TO DAY</td>
              <td rowspan="2" class="grid_header" style="width:150px;">CHECK TOTAL</td>
              <td rowspan="2" class="grid_header" style="width:150px;">CHECK BALANCES</td>
              <td rowspan="2" class="grid_header" style="width:150px;">OUT SIDE SENT</td>
              <td rowspan="2" class="grid_header" style="width:150px;">OUT SIDE RCVD</td>
              <td rowspan="2" class="grid_header" style="width:150px;">BALANCE AT OUT SIDE</td>
              <td rowspan="2" class="grid_header" style="width:150px;">DELIVERD TO DAY</td>
              <td rowspan="2" class="grid_header" style="width:150px;">DELIVERD TOTAL</td>
              <td rowspan="2" class="grid_header" style="width:150px;">BALANCE AT WASHING PLANT</td>
              <!--<td class="grid_header" style="width:150px;">BALANCE AT SW1</td>-->
              <td rowspan="2" class="grid_header" style="width:200px;">REMARKS</td>
            </tr>
            <tr>
              <td class="grid_header" style="width:60px;">SEND</td>
              <td class="grid_header" style="width:60px;">RCVD</td>
              <td class="grid_header" style="width:80px;">TO BE RCVD</td>
              </tr>
          </thead>
          <tbody>
				<?php
				

							$resWip=$objWip->getMainDetals($_SESSION['FactoryID'],date('Y-m-d'));
							$fCom='';
							while($rowWip=mysql_fetch_assoc($resWip)){
							$cls="";
							if((!isset($fCom)) || ($fCom != $rowWip['intFromFactory']))
								{?>
									<tr>
                                    	<td colspan="10"><?php echo $rowWip['strName']; ?></td>
                                    </tr>
							<?php	}
							$r=0;
							($r%2==0)?$cls="grid_raw":$cls="grid_raw2";
							$po=$rowWip['intStyleId']; 
							?>
				
				<tr>
					<td class="<?php echo $cls;?>" style="text-align:left;"><?php $fCom=$rowWip['intFromFactory']; echo $rowWip['strDivision'];?></td>
					<td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $objWip->getMill($po); ?></td>
					<td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $rowWip['strStyle'];?></td>
					<td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $rowWip['strOrderNo'];?></td>
					<td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $rowWip['strColor'];?></td>
					<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $rowWip['intQty'];?></td>
					<td class="<?php echo $cls;?>" style="text-align:right;">
						<?php 
						
						$cutQty=$objWip->getCutQty($po);
						echo $cutQty;
						?>
                    </td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $objWip->getTotRcvd($po,$_SESSION['FactoryID'],date('Y-m-d'));?></td>
					<td class="<?php echo $cls;?>" style="text-align:right;width:60px;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;width:60px;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;width:80px;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td><!--$rowWip['RTot']-$washQty-->
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td> 
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
					<td class="<?php echo $cls;?>" style="text-align:right;">&nbsp;</td>
				</tr>
				<?php $r++;  }	?>
          </tbody>
        </table>
      </div>
      </td>  
    </tr>
    <tr>
    	<td>
			<table align="center" border="0">
				<tr>
					<td><img src="../../images/new.png" alt="new"  width="84" height="24" border="0" onclick="ClearForm('new');" id="new" /><img src="../../images/save.png" alt="save" width="84" height="24" border="0" onclick="saveIssuedWash();"/><img src="../../images/print.png" alt="print" width="84" height="24" border="0" onclick="printPoAvailable();" /><a href="../../main.php"><img src="../../images/close.png" alt="close" width="84" height="24" border="0"/></a><img src="../../images/report.png" />
					</td>
				</tr>
			</table>
    	</td>
    </tr>
  </table>
<!-- </div>
 </div>-->
</form>
<?php 


?>
</body>
</html>

        
        