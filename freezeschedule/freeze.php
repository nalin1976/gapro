<?php

session_start();

include "../Connector.php";

$backwardseperator = "../";





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Freeze Delivery Schedule</title>

<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<link href="../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />


<script src="../js/jquery.min.js"></script>

<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="freeze.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="../javascript/script.js"></script>


<script type="text/javascript">
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

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

function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

function SetCalendarDate(){

	//Get the current date
	var dt_current = new Date();
	
	var iCurrentMonth = dt_current.getMonth() + 1;
	var iCurrentYear = dt_current.getFullYear();
	
		
	document.getElementById('txtFrmDate').value = 01 + '/' + iCurrentMonth + '/' + iCurrentYear ; 
	
	switch(iCurrentMonth){
		
	
		case 1 : 	
		case 3 :
		case 5 :
		case 7 :
		case 8 :
		case 10 :
		case 12 :
			
			document.getElementById('txtToDate').value = 31 + '/' + iCurrentMonth + '/' + iCurrentYear ; 
			break;
			
		case 4 :
		case 6 :
		case 9 :
		case 11 :
		
			document.getElementById('txtToDate').value = 30 + '/' + iCurrentMonth + '/' + iCurrentYear ; 
			break;
			
		default:
			document.getElementById('txtToDate').value = 28 + '/' + iCurrentMonth + '/' + iCurrentYear ; 
			break;
			break;
	}	
	
}
</script>
<style type="text/css">
.setWidth{ width:175px; text-align: left; }

.caret-right{
	position: relative;
	left:100px;
	
}

.textAlign{
	text-align: right;
}

.table-fixed thead{
	width:97%;
}

.table-fixed tbody{
	height: 230px;
	overflow-y:auto;
	width:100%; 
}

.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}

.table-fixed tbody td, .table-fixed thead > tr> th {
  float: left;
  border-bottom-width: 0;

}

th{

	font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
	font-size:09pt;
	font-weight: bold;
}

.table-fixed td{
	table-layout: fixed;
	word-wrap: break-word;
}

.table-fixed tr{
	font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
	font-size:09pt;
	height: 90px;
}

.labelformat{

	font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
	font-size:09pt;
	font-weight: bold;
}

.textformat{
	font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
	font-size:09pt;
	
}

.thFullBorder{
	border-width: 1px;
	border-color: "000000";
	border-style: solid;

}

.thBorderTRB{

	border-bottom-color: "000000";
	border-bottom-width: 1px;
	border-bottom-style: solid;
}

.textalign{
	text-align: center;
}

.hover{background-color:yellow;}

.Completed{
	background-color: #00A800;
	color: #ffffff;
}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
      <td><?php include '../Header.php';  ?></td>
    </tr>
    <tr>
    	<td>
    		<table width="100%">
    			<tr><td border="1" width="15%" height="60">&nbsp;</td></tr>
    			<tr><td border="1" width="15%">&nbsp;</td>
    				<td border="1" width="70%">
	    				<div class="container" id="wrapper">
		    				<div class="col-md-12 col-height">&nbsp;</div>
		    				<div class="col-md-12 ">&nbsp;</div>
		    				<div class="col-sm-1">&nbsp;</div>
		    				<div class="col-sm-1 labelformat">&nbsp;</div>
		    				
		    				<div class="col-sm-1 labelformat">Date From</div>
		    				<div class="col-sm-1"><input class="form-control textformat" name="txtFrmDate" value="<?php echo $_POST['txtFrmDate'];?>" type="text" class="txtbox" id="txtFrmDate" style="width:105px; text-align:right"  onmousedown="DisableRightClickEvent();" tabindex="5" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></div>
		    				<div class="col-sm-1 textAlign labelformat">To</div>
		    				<div class="col-sm-1"><input class="form-control textformat" name="txtToDate" value="<?php echo $_POST['txtToDate'];?>" type="text"  class="txtbox" id="txtToDate" style="width:105px; text-align:right" tabindex="6"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;width:1px" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></div>
		    				<div class="col-sm-2 textAlign">&nbsp;</div>
		    				<div class="col-md-11"></div><div class="col-md-1"></div>
		    				<div class="col-md-12">&nbsp;</div>
		    				<div class="col-sm-1" >&nbsp;</div>
		    				<div class="col-sm-2 labelformat" style="text-align:right">Freeze Month</div>
		    				<div class="col-sm-1" >
		    					<div class="dropdown">
			    					<select class="form-control textformat" id="cmbFreezeMonth" style="width:80px;">
			    						<option value="1">1</option>
			    						<option value="2">2</option>
			    						<option value="3">3</option>
			    						<option value="4">4</option>
			    						<option value="5">5</option>
			    						<option value="6">6</option>
			    						<option value="7">7</option>
			    						<option value="8">8</option>
			    						<option value="9">9</option>
			    						<option value="10">10</option>
			    						<option value="11">11</option>
			    						<option value="12">12</option>	
			    					</select>
			    				</div>				    				
		    				</div>
		    				<div class="col-sm-1 labelformat" style="text-align: right;">Freeze Year</div>
		    				<div class="col-sm-1" >
		    					<div class="dropdown">
			    					<select class="form-control textformat" id="cmbFreezeYear" style="width:80px;">
			    						<option value="2016">2016</option>
			    						<option value="2017">2017</option>
			    						<option value="2018">2018</option>
			    						<option value="2019">2019</option>
			    						<option value="2020">2020</option>			    						
			    					</select>
			    				</div>				    				
		    				</div>
		    				<div class="col-sm-2">&nbsp;</div>
		    				<div class="col-sm-1">
		    					<button class="btn btn-success" id="btnFreeze"> Freeze </button>
		    				</div>
		    			</div>	

    				</td>
    				<td border="1" width="15%">&nbsp;</td>
    			</tr>


    			<tr><td colspan="3">&nbsp;</td></tr>
    			
    				
    		</table>	
    	</td>
    </tr>

</table>

</body>