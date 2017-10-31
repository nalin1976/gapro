<?php

$backwardseperator = "../../";
session_start();
$intPubCompanyId		=$_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PRODUCTION PLAN</title>
<link href="../css/planning.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/core.css" type="text/css" charset="utf-8">
<script src="productionPlan.js"></script>
<!--<link href="dragable-content.css" rel="stylesheet" type="text/css"/>-->

<!--<script type="text/javascript">
var rememberPositionedInCookie = true;
var rememberPosition_cookieName = 'demo';
</script>-->

<script src="../js/jquery-1.js"></script>
<script src="../js/jquery-ui-1.js"></script>
	
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="java.js" type="text/javascript"></script>

<script src="../teams/teams-js.js" type="text/javascript"></script>
<script src="../calender/calender-js.js" type="text/javascript"></script>
<script src="../learningCurve/curves-js.js" type="text/javascript"></script>
<script src="plan-js.js" type="text/javascript"></script>
<script src="../orderBook/orderBook-js.js" type="text/javascript"></script>


<script type="text/javascript">

	$(function() {
		$("#draggable3").draggable({ containment: '#containment-wrapper', scroll: false });
	});
</script>
		
<style type="text/css">

	.drag {border: 1px solid black; background-color: rgb(240, 240, 240); position: relative; padding: 0.5em; margin: 0 0 0.5em 1.5em; cursor: move;}
	.dragme{
		position:relative;
		left: 72px;
		top: 150px;
	}
	#draggable, #draggable2 { width: 100px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
	#droppable { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px; }
	.classTeam{background:#FFFFFF;height:17px ;float: left;margin: 1px;}
	.ui-widget-header p, .ui-widget-content p { margin: 0; }

</style>

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

<link href="../plug/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="../plug/jquery.min.js"></script>
  <script src="../plug/jquery-ui.js"></script>
<!--  <style type="text/css">
   <!-- #drag ,#drag1 ,#drag2 ,#drag3,#drag4,#drag5,#drag6,#drag7,#drag8,#drag9,#drag10 { font-size:11px;color:#0000CC;   width: 150px; height: 18px; background-color:#F9C7FA;cursor: pointer;opacity:0.6 }-->
  </style>-->

	
  <script>
  
  var mainId = 0;
  
	
  
  function checkPosition(obj)
  {
  	var initialTop = document.getElementById("divInitial").style.top;
	//alert(initialTop);
  	//alert(obj.style.left);
	//obj.style.top = '197px';
  }
 function move()
 {
 	var T = this.style.top;
	var L = this.style.left;
	
 }
 
 	var i = 0;
	

 
 
 
 function createObject_old1(obj)
 {

 	var style = obj.cells[2].innerHTML;
 	var newdiv = document.createElement('div');
	var nDrag = 'drag'+(++i);
	
	
	 //popupbox.id = "popupLayer" + zindex;
     newdiv.style.position = 'relative';
    // popupbox.style.zIndex = zindex;
     newdiv.style.left = 0 + 'px';
     newdiv.style.top = 0 + 'px';  
	
   newdiv.setAttribute('id',nDrag);
  
	//newdiv.setAttribute('name',nextDrag);
    //onmousedown="grab(document.getElementById('frmOrderBook'),event);"
	//newdiv.onmousedown = "grab(document.getElementById('drag'),event);";
  var htmltext = 	 "<table style=\"background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf; width=\"100px\" class=\"cursercross\" onMouseDown=\"grab(document.getElementById('"+nDrag+"'),event);\">"+
			 " <tr >"+
			"	<td colspan=\"5\" align=\"center\">"+style+"</td>"+
			"  </tr>"+
			"  </table>";
			

					
	newdiv.innerHTML =	htmltext;			
	newdiv.style.zIndex	 = 1;
	
	 //newdiv.style.position = 'absolute';
	//newdiv.onclick = "alert(123)";
	//newdiv.setAttribute('classname','dragableElement');
	//newdiv.setAttribute("class", "dragableElement");
	newdiv.onclick = objectclick;
	//newdiv.style.position='absolute';
  	document.getElementById('divInitial').appendChild(newdiv);
	
	inc("inc.js");
 }
 
/* function inc(filename)
{
	var body = document.getElementsByTagName('body').item(0);
	script = document.createElement('script');
	script.src = filename;
	script.type = 'text/javascript';
	body.appendChild(script)
}*/

function createObject1(obj)
{

	var style = obj.cells[1].innerHTML+" - "+obj.cells[2].innerHTML;
	  $(document).ready(function() {
	  		 $("#drag"+(mainId++)).draggable();
			 $(style).draggable();
	  });
  	
  	var newdiv = document.createElement('div');
  	newdiv.setAttribute('id','drag'+mainId);
	newdiv.onmousemove = move;
  	newdiv.innerHTML = style;	
	//newdiv.style.top = '-190px';
	//alert(newdiv.style.top);
  	document.getElementById('boxdiv2').appendChild(newdiv);

}

  </script>
  
<script type="text/javascript">
	function loadfun()
	{
		document.getElementById('myDiv').style.height = (screen.height - 420)+'px';
	}
</script>
</head>


<body onload="loadfun()">
<script type="text/javascript">

</script>
<div id="header">
	<table width="100%" cellpadding="0" cellspacing="0" bgcolor="" class="tablezRED">
      <tr>
		 <td class="mbari9" height="30" >PRODUCTION PLAN</td>
        
      </tr>
    </table>

</div>
<div id="footer">

    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="" class="tablezRED">
      <tr>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" align="center">				
				<tr align="center">
				  	  
				  <td ><input type="checkbox" name="productionPlan_PlannedQty" id="productionPlan_PlannedQty" checked="checked" disabled="disabled" /></td>
				  <td class="normalfnt" width="100">Planned Quantity</td>
				  <td class="normalfnt" width="20">&nbsp;</td>		  
				  <td ><input type="checkbox" name="productionPlan_PlannedTTL" id="productionPlan_PlannedTTL" checked="checked" /></td>
				  <td class="normalfnt" width="80">Planned TTL</td>
				  <td class="normalfnt"  width="20">&nbsp;</td>		  
				  <td ><input type="checkbox" name="productionPlan_PlannedEfy" id="productionPlan_PlannedEfy" checked="checked" /></td>
				  <td class="normalfnt" width="110">Planned Efficiency</td>
				  <td width="20">&nbsp;</td>
				  <td ><input type="checkbox" name="productionPlan_ActualQty" id="productionPlan_ActualQty" checked="checked" /></td>
				  <td class="normalfnt" width="100">Actual Quantity</td>
				  <td class="normalfnt" width="20">&nbsp;</td>		  
				  <td ><input type="checkbox" name="productionPlan_ActualTTL" id="productionPlan_ActualTTL" checked="checked" /></td>
				  <td class="normalfnt" width="75">Actual TTL</td>
				  <td class="normalfnt"  width="20">&nbsp;</td>		  
				  <td ><input type="checkbox" name="productionPlan_ActualEfy" id="productionPlan_ActualEfy" checked="checked" /></td>
				  <td class="normalfnt" width="100">Actual Efficiency</td>
				  <td class="normalfnt"  width="20">&nbsp;</td>
				  <td><img border="0" src="../../images/report.png" name="butReport" width="108" height="24" class="mouseover" id="butReport" onclick="loadReport();" />
				  </td>
				  <td class="normalfnt"  width="20">&nbsp;</td>
				  <td align="center"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" class="mouseover" /></a></td>
				  
				</tr>
			</table>
		</td>
	  </tr>      
    </table>

</div>	

<!--<div onmouseup="checkPosition(this);" id="draggable3" >Style 2</div>-->

<?php
	include "../../Connector.php";	
?>


<form name="frmProductionPlan" id="frmProductionPlan" action="productionPlanReport.php" method="post" >
<table id="tblPboard" width="1107" height="180" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td height="40" >&nbsp;</td>
</tr>
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="1" cellspacing="0" >
          <tr>
            <td height="18" width="5"  class="normalfntSM">&nbsp;</td>
            <td class="normalfnt" width="70" >Start Date:</td>
            <td width="100"><input name="txtStartDate" type="text" class="txtbox" id="txtStartDate" size="10" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>           
            <td width="50" class="normalfnt">&nbsp;</td>
			<td class="normalfnt" width="70" >End Date:</td>
            <td width="100"><input name="txtEndDate" type="text" onchange="dateValidate();"  class="txtbox" id="txtEndDate" size="10" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>      
			<td><img src="../../images/search.png" alt="save" name="butSearch" width="84" height="24" class="mouseover" id="butSearch" onclick="loadDays();" /></td>     
            <td width="*" class="normalfnt">&nbsp;</td>
          </tr>		  
		</table>
	</td>
  </tr>  
 
  <tr><td >&nbsp;</td></tr>
  <style type="text/css">
	#boxdiv1 div{
		float: left;
		margin: 0px;
	}

	#divInitial div{
		float: left;
		margin: 0px;
	}


	.classTeam div{
		float: left;
		margin: 0px;
		border-top: 0px;
		border-left: 1px solid #B4B4B4;
		border-right: 1px solid ;
		border-bottom: 1px ;
	}
	.classGridBox div{

		border-top: 0px;
		border-left: 1px solid #B4B4B4;
		border-right: 1px solid ;
		border-bottom: 1px ;
	}
	.tableCellProductPlan1 {
		border: 1px solid #666666;
		background-color: #ECE9D8;
		font-family: Verdana;
		font-size: 10px;
		color: #000000;
		text-align: center;
		font-weight: bold;
	}
	.tableCellProductPlan2 {
		border: 1px solid #666666;
		background-color: #f3f7fa;
		font-family: Verdana;
		font-size: 7px;
		color: #000000;
		text-align: center;
		font-weight: bold;
		padding-top:4px;
	}
	.tableCellProductPlan3 {
		border: 1px solid #666666;
		background-color: #F8DDB6;
		font-family: Verdana;
		font-size: 10px;
		color:  #000000;
		text-align: center;
		font-weight: bold;
	}
	.tableCellProductPlan4 {
		border: 1px solid #666666;
		background-color: #FFE8DA;
		font-family: Verdana;
		font-size: 10px;
		color:  #000000;
		text-align: center;
		font-weight: bold;
	}
	
	.div2{
		position:absolute;
		left:0px;
		margin-left:0px;
	}
</style> 
 	<tr>
    <td>
		<table height="362" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td  class="normalfnt">
				<div id="myDiv" style="overflow:scroll; height:400px; width:1200px;">			
					
				<table width="<?php echo 8+60+80+(75+2)*cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y")); ?>"  border="1" cellpadding="0" cellspacing="0" bordercolor="#162350"  id="tblMain">
				<tr>
					<td  class="normaltxtmidb2" >
						<div id="boxdiv1" >
	<!--
		<table height="362" border="0" cellpadding="0" cellspacing="0">
     		<tr>
				<td class="normalfnt">
					<div id="boxdiv1" style="overflow:scroll; height:450px; width:17500px;">
						<div id="div1">
						-->
						<div  class="tableCellProductPlan1"  id="divInitialQQ" style="width:60px; height:15px;">Team</div>
						<div  class="tableCellProductPlan1"  id="divInitialQQ" style="width:80px; height:15px;">Title</div>
					<?php
					
					//echo cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));
						for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
					?>
							<div  class="tableCellProductPlan1"  id="divInitialQQ" style="width:75px; height:15px;"><?php echo $i."/".date("M");?></div>
					<?php	
						}	
					?>
					</div>
					</td>
					</tr>
						
					<?php
						$SQL="select distinct plan_teams.intTeamNo,plan_teams.strTeam,plan_stripes.intTeamNo from plan_teams,plan_stripes where plan_teams.intTeamNo=plan_stripes.intTeamNo;";
							
						$result = $db->RunQuery($SQL);
						while($row1 = mysql_fetch_array($result))
						{	
					?>				
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan2"  id="divInitialQQ" style="width:60px; height:15px;">&nbsp;</div>
								<div  class="tableCellProductPlan2"  id="divInitialQQ" style="width:80px; height:15px;">Style No.</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan2"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:60px; height:15px;"><?php echo $row1["strTeam"]; ?></div>
								<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:80px; height:15px;">Planned Qty</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:60px; height:15px;">&nbsp;</div>
								<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:80px; height:15px;">Planned TTL</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:60px; height:15px;">&nbsp;</div>
								<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:80px; height:15px;">Planned Eff</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan2"  id="divInitialQQ" style="width:60px; height:15px;">&nbsp;</div>
								<div  class="tableCellProductPlan2"  id="divInitialQQ" style="width:80px; height:15px;">Style No.</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan2"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>	
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:60px; height:15px;">&nbsp;</div>
								<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:80px; height:15px;">Actual Qty</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:60px; height:15px;">&nbsp;</div>
								<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:80px; height:15px;">Actual TTL</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:60px; height:15px;">&nbsp;</div>
								<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:80px; height:15px;">Actual Eff</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan4"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>
							<tr>
							<td  class="normaltxtmidb2" >
								<div id="boxdiv1" >
			
								<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:60px; height:15px;">&nbsp;</div>
								<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:80px; height:15px;">Variance</div>
							<?php
								for($i=1;$i<=cal_days_in_month ( CAL_GREGORIAN, date("m"), date("Y"));$i++){
							?>
									<div  class="tableCellProductPlan3"  id="divInitialQQ" style="width:75px; height:15px;">&nbsp;</div>
							<?php	
								}	
							?>
							</div>
							</td>
							</tr>
						<?php } ?>
					 </table>
				  </div>
				 
				</td>  
			<tr >			
     	</table>
	</td>
   </tr>
  

</table>

</form>

	
	<script type="text/javascript" src="dragable-content.js"></script>	
	

</body>

</html>


