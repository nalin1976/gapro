<?php

$backwardseperator = "../../";
session_start();
$intPubCompanyId		=$_SESSION["FactoryID"];

$calanderId = $_POST["cboCalander"];
$previous = $_POST["cboprevious"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro : : Planning Board</title>
<link href="../css/planning.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/core.css" type="text/css" charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../teams/teams-js.js" type="text/javascript"></script>
<script src="../../js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="plan-js.js" type="text/javascript"></script>
<script src="../orderBook/orderBook-js.js" type="text/javascript"></script>
<script src="../calender/calender-js.js" type="text/javascript"></script>
<script src="../learningCurve/curves-js.js" type="text/javascript"></script>
<script type="text/javascript" src="../learningCurve/charts/jquery.min.js"></script>
<script type="text/javascript" src="../learningCurve/charts/highcharts.js"></script>
<script type="text/javascript" src="../learningCurve/charts/highslide-full.min.js"></script>
<script type="text/javascript" src="../learningCurve/charts/highslide.config.js" charset="utf-8"></script>


<script type="text/javascript" src="dragable-content.js"></script>	
	
	<script src="../js/jquery-1.js"></script>
	<script src="../js/jquery-ui-1.js"></script>



<script language="javascript">

var ie	= document.all
var ns6	= document.getElementById&&!document.all

var isMenu 	= false ;

var menuSelObj = null ;
var overpopupmenu = false;

function mouseSelect(e)
{
	var obj = ns6 ? e.target.parentNode : event.srcElement.parentElement;

	if( isMenu )
	{
		if( overpopupmenu == false )
		{
			isMenu = false ;
			overpopupmenu = false;
			document.getElementById('menudiv').style.display = "none" ;
			//document.getElementById('menudiv1').style.display = "none" ;
			return true ;
		}
		return true ;
	}
	//return false;
}


// POP UP MENU
function	ItemSelMenu(e)
{
	//alert('ABC');
	var	obj = ns6 ? e.target.parentNode : event.srcElement.parentElement;	

      menuSelObj = obj ;
	if (ns6)
	{
	//alert(document.getElementById('menudiv').style.top );
		document.getElementById('menudiv').style.left = (e.clientX+document.body.scrollLeft)+'px';
		//alert(document.getElementById('menudiv').style.top );
		document.getElementById('menudiv').style.top = (e.clientY+document.body.scrollTop)+'px';
	} else
	{
		document.getElementById('menudiv').style.pixelLeft = event.clientX+document.body.scrollLeft;
		document.getElementById('menudiv').style.pixelTop = event.clientY+document.body.scrollTop;
	}
	document.getElementById('menudiv').style.display = "";
	document.getElementById('item1_splitQty').style.backgroundColor='#FFFFFF';
	document.getElementById('item2_applyCurve').style.backgroundColor='#FFFFFF';
	document.getElementById('item3_remove').style.backgroundColor='#FFFFFF';
	document.getElementById('item4_join').style.backgroundColor='#FFFFFF';
	document.getElementById('item5_eSchedule').style.backgroundColor="#FFFFFF";
	document.getElementById('item1_splitQty').style.color="#000099";
	document.getElementById('item2_applyCurve').style.color="#000099";
	document.getElementById('item3_remove').style.color="#000099";
	document.getElementById('item4_join').style.color="#000099";
	document.getElementById('item5_eSchedule').style.color="#000099";
	
	//disableAndEnableRightClickpopUp(); validate strip Completed
	//document.getElementById('item4').style.backgroundColor='#FFFFFF';
	isMenu = true;
	return false ;
}

/*function	ItemSelMenu1(e,obj)
{
	createPop(obj);
	var	obj = ns6 ? e.target.parentNode : event.srcElement.parentElement;	

      menuSelObj = obj ;
	if (ns6)
	{
	//alert(document.getElementById('menudiv').style.top );
		document.getElementById('menudiv1').style.left = (e.clientX+document.body.scrollLeft)+'px';
		//alert(document.getElementById('menudiv').style.top );
		document.getElementById('menudiv1').style.top = (e.clientY+document.body.scrollTop)+'px';
	} else
	{
		document.getElementById('menudiv1').style.pixelLeft = event.clientX+document.body.scrollLeft;
		document.getElementById('menudiv1').style.pixelTop = event.clientY+document.body.scrollTop;
	}
	document.getElementById('menudiv1').style.display = "";
	//disableAndEnableRightClickpopUp();
	document.getElementById('item1').style.backgroundColor='#FFFFFF';
	document.getElementById('item2').style.backgroundColor='#FFFFFF';
	document.getElementById('item3').style.backgroundColor='#FFFFFF';
	document.getElementById('item4').style.backgroundColor='#FFFFFF';
	document.getElementById('item1').style.color="#000099";
	document.getElementById('item2').style.color="#000099";
	document.getElementById('item3').style.color="#000099";
	document.getElementById('item4').style.color="#000099";
	//alert(obj.id);
	document.getElementById('tbl_menuDiv1').rows[0].id=obj.id;
	
	//disableAndEnableRightClickpopUp();
	//document.getElementById('item4').style.backgroundColor='#FFFFFF';
	isMenu = true;
	return false ;
}*/
document.onmousedown 	= mouseSelect;
</script>






<script language="javascript">
//Ruwan
$(document).ready(function(){
	
	$('#calanderDiv').css({height: ((document.documentElement.clientHeight)-200)+"px"});
	
	window.onresize=function()
	{
		
		$('#calanderDiv').css({height: ((document.documentElement.clientHeight)-200)+"px"});
		$('#calanderDiv').css({width: ((document.documentElement.clientHeight)+400)+"px"});
	}
	
	
	
		
})
	
	

function changeCalander()
{
	document.forms['form1'].submit();
	
}

</script>


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
<style>
	.strip{		
		color: #660000;
		cursor:move;
		height:22px;
		line-height:18px;
		overflow:hidden;
		background:#D6E7F5;
		opacity:0.6;
		
		font-size: 9px;
		font-family: verdana, arial, sans-serif;
		font-weight:light;
		margin:10px 10px 10px 10px;
		border: green solid 1px;
		white-space: normal;
	}
	
.drag {border: 1px solid black; background-color: rgb(240, 240, 240); position: relative; padding: 0.5em; margin: 0 0 0.5em 1.5em; cursor: move;}
.dragme{
	position:relative;
	left: 72px;
	top: 150px;
}
</style>

<style type="text/css">
	#draggable, #draggable2 { width: 100px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
	#droppable { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px; }
	.classTeam{background:#FFFFFF; float:left; margin: 0px; height:25px;}
	.ui-widget-header p, .ui-widget-content p { margin: 0; }

</style>

<style type="text/css">
	html, body { 
				height: 100%; 
				width: 100%; 
				} 
</style>
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
		border-left: 0px solid #B4B4B4;
		border-right: 0px solid ;
		border-bottom: 0px ;
	}
	.classGridBox div{

		border-top: 0px;
		border-left: 0px solid #B4B4B4;
		border-right: 0px solid ;
		border-bottom: 0px ;


	}
</style> 

<script type="text/javascript">
   function handle(delta) {

               if (delta < 0)

                   return false;

               else

                   return false;

           }


           /** Event handler for mouse wheel event.

            */

           function wheel(event){

               var delta = 0;

               if (!event) /* For IE. */

                   event = window.event;

               if (event.wheelDelta) { /* IE/Opera. */

                   delta = event.wheelDelta/120;

                   alert(delta)

                   /** In Opera 9, delta differs in sign as compared to

IE.

                    */

                   if (window.opera)

                       delta = -delta;

               } else if (event.detail) { /** Mozilla case. */

                   /** In Mozilla, sign of delta is different than in

IE.

                    * Also, delta is multiple of 3.

                    */

                   delta = -event.detail/3;

               }

               /** If delta is nonzero, handle it.

                * Basically, delta is now positive if wheel was

scrolled up,

                * and negative, if wheel was scrolled down.

                */

               if (delta)

                   handle(delta);

               /** Prevent default actions caused by mouse wheel.

                * That might be ugly, but we handle scrolls somehow

                * anyway, so don't bother here..

                */

               if (event.preventDefault)

                   event.preventDefault();

               event.returnValue = false;

           }


           /** Initialization code.

            * If you use your own event management code, change it as

required.

            */

           if (window.addEventListener)

           /** DOMMouseScroll is for mozilla. */

               window.addEventListener('DOMMouseScroll', wheel, false);

           /** IE/Opera. */

           window.onmousewheel = document.onmousewheel = wheel;


  </script>
  	
    
     <link href="../plug/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="../plug/jquery.min.js"></script>
  <script src="../plug/jquery-ui.js"></script>
  

<!--  <style type="text/css">
   <!-- #drag ,#drag1 ,#drag2 ,#drag3,#drag4,#drag5,#drag6,#drag7,#drag8,#drag9,#drag10 { font-size:11px;color:#0000CC;   width: 150px; height: 18px; background-color:#F9C7FA;cursor: pointer;opacity:0.6 }
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
	 //newdiv.style.position = 'absolute';
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
  <script type="text/javascript" src="popupMenu.js"></script>


<?php   ?>
</head>

<body oncontextmenu="return false;">

<div id="menudiv" style="position:absolute;display:none;top:0px;left:0px;z-index:500;" onmouseover="javascript:overpopupmenu=true;" onmouseout="javascript:overpopupmenu=false;">
<table width=150 cellspacing=1 cellpadding=0 bgcolor=lightgray>
  <tr><td>
    <table bgcolor="" width=150 cellspacing=0 cellpadding=0>
      <tr>
        <td id="item1_splitQty" width="180" height="20" onMouseOver="this.style.backgroundColor='#D5EDFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'" class="onstripmenu" onclick="checkSplit();"><b>Split Qty</b></td>
      </tr>
      <tr>
        <td id="item2_applyCurve" width="118" height="16" onMouseOver="this.style.backgroundColor='#D5EDFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'" class="onstripmenu"  onclick="createApplyLearningCurvePopUp();"><b>Apply Learning Curve</b></td>
      </tr>
	  <tr>
		<td id="item3_remove"  width="118" height="16" onMouseOver="this.style.backgroundColor='#D5EDFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'" class="onstripmenu"   onclick="removeStrip();"><b>Remove Strip</b></td>
	  </tr>
	   <tr>
		<td id="item4_join"  width="118" height="16" onMouseOver="this.style.backgroundColor='#D5EDFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'" class="onstripmenu"   onclick="createJoinStripPopUp();"><b>Join Strip</b></td>
	  </tr>
	     <tr>
		<td id="item5_eSchedule"  width="118" height="16" onMouseOver="this.style.backgroundColor='#D5EDFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'" class="onstripmenu" onclick="showEventSchedule();" ><b>Event Schedule</b></td>
	  </tr>
	 <!-- <tr>
		<td id="item4" bgcolor="#ffffff" width="118" height="16" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'" class="seversion">Item4</td>
	  </tr>-->
    </table>
  </td></tr>
</table>
</div>
<div id="footer">
    <table width="101%"  height="48" cellpadding="0" cellspacing="0" bgcolor="" class="tablezRED">
       <tr>
        <td width="6%" height="22">&nbsp;</td>
        <td width="7%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="23%">&nbsp;</td>
      </tr>
      <tr>
        <td height="24" colspan="8" align="center" valign="top"><img  src="../../images/orderbook.png" alt="order Book" name="butOrderBook" class="mouseover" id="butOrderBook" onclick="loadOrderBook();" /><img src="../../images/teams.png" alt="calender" name="butCalender" class="mouseover" id="butCalender" onclick="loadTeamsWindow();" /><img src="../../images/learningcurve.png" alt="calender" name="butCalender" width="171" height="24" class="mouseover" id="btnLearningCurve" onclick="loadLearningCurve();" /><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="savePlanningDetails();" /><img src="../../images/report.png" name="butReport" width="108" height="24" class="mouseover" id="butReport" onclick="grnReport();"/><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" class="mouseover" /></a></td>
      </tr>
  </table>
</div>	
<form  id="form1" action="plan.php" method="post">
<table width="1107" border="0" align="center" bgcolor="#FFFFFF">
<tbody>
    <tr style="background:#660000">
        <td class="mbari9" height="35" >Planning Board</td>
    </tr>
    <tr class="normalfnt"  width="0">
    	
        <td><label>Period : </label>
            					 <select name="cboprevious" class="txtbox" style="width:150px" id="cboprevious">
                                      <option value="0"></option>
                                      <option value="-31">1 Month Previous</option>
                                      <option value="-61">2 Month Previous</option>
                                      <option value="-92">3 Month Previous</option>                         
                               	 </select>
                                 <label>&nbsp;&nbsp;&nbsp;&nbsp;to : &nbsp;&nbsp;&nbsp;&nbsp;</label>
                                 <select name="cboCalander" class="txtbox" onchange="changeCalander();" style="width:150px" id="cboCalander">
                                      <option value=""></option>
                                      <option value="3">3 Months</option>
                                      <option value="6">6 Months</option>
                                      <option value="12">12 Months</option>                         
                               	 </select>
        </td>
    </tr>
    <tr>
    	<td>  
        <table cellpadding="0" cellspacing="0" style=" margin-top:20px;"> 
            <tbody>
                <tr>
                    <td>
                    <?php
					if (isset($calanderId))
					{
					?>	
                    <div id="calanderDiv" style="overflow:scroll; height:350px; width:1200px;">
                        <table border="0" cellspacing="0" cellpadding="0" class="normalfnt_week">
                            <tbody>
                                <tr > 
                              	     	<td>&nbsp;&nbsp;&nbsp;</td>
                                <?php
									//get the unix timestamp of the previous day 
									$d = strtotime($previous.'days');
									//calculate no of dates
									$now = time();
									$after_dates = strtotime($calanderId.'month');
									$datediff = $after_dates - $now;
									$no_of_dates = floor($datediff/(60*60*24));
									
									$cellDate = date("Y-m-d",strtotime('+0 day',$d));
									//echo $cellDate;
									for($i=0; $i<$no_of_dates;$i++)
									{
										// check date whether saterday or  sunday 
										$checkDates = date("w", strtotime(date("Y-m-d",strtotime($i.'days',$d))));
										if($checkDates==6 || $checkDates==0)
										{
								?>        
										<td height="25"><div id="calanderDiv" style="width:40px; height:25px;background-color:#FFC5A8;  margin-left:1px;" ><div id="<?php echo date("Y-m-d",strtotime($i.'days',$d));?>" style="padding-top:5px;" onclick="calanderClick(this.id);"><?php echo date("m-d",strtotime($i.'days',$d));?></div></div></td>   										
										<?php
										}
										else
										{
										?>
                                        	<td><div id="calanderDiv" style="width:40px; height:25px;background-color:#939393;  margin-left:1px;" ><div id="<?php echo date("Y-m-d",strtotime($i.'days',$d));?>" style="padding-top:5px;"><?php echo date("m-d",strtotime($i.'days',$d));?></div></div></td>   
                                         <?php
										}
									}//end for loop
									?>
                                    
                                   
                                        
                                    
                                </tr>
                                   	<tr>
                                	<td><div style="background-color:#FC3; height:25px; width:71px; margin-bottom:1px; margin-right:1px;"><div style="padding-top:6px;">INITIAL</div></div></td>                                
                         			<td height="25" colspan="<?php echo $no_of_dates;?>" class="normaltxtmidb2"><div class="classTeam" id="divInitial" style="width:100%"  >&nbsp;</div></td>                               
                           		 	</tr>
                               		<?php 
									include "../../Connector.php";
								
									$sql_teams = "SELECT
plan_teams.strTeam,
plan_teams.intTeamNo,
date(plan_teamsvaliddates.dtmValidFrom) AS validDate,
date(plan_teamsvaliddates.dtmValidTo) AS validDateTo,
DATEDIFF( plan_teamsvaliddates.dtmValidTo,plan_teamsvaliddates.dtmValidFrom) AS dateDifferent,
plan_teams.dblWorkingHours,
plan_teams.dblMealHours
FROM
plan_teams
Inner Join plan_teamsvaliddates ON plan_teams.intTeamNo = plan_teamsvaliddates.intTeamId 
WHERE date(plan_teamsvaliddates.dtmValidFrom) >= '$cellDate' AND plan_teams.intSubTeamOf <'1'";
										$result = $db->RunQuery($sql_teams);
										while($row=mysql_fetch_array($result))
										{
											$teamID 			= $row['intTeamNo'];
											$teamName 			= $row['strTeam'];	
											$validDate 			= $row['validDate'];
											$validDateTo 		= $row['validDateTo'];
											//$dateDifferent 		= $row['dateDifferent'];
											//$dblWorkingHours 	= $row['dblWorkingHours'];
											
															
									?>
                               				 <tr>                               
                                			 <td><div style="background-color:#8AD9FF; height:25px; width:71px; margin-bottom:1px; margin-right:1px;"><div style="padding-top:6px;"><?php echo $teamName; ?></div></div></td>
                                			<td height="25" style="background-color:#FFFFFF" class="normaltxtmidb2" colspan="<?php echo $no_of_dates; ?>"><div class="classTeam" style="float:left; margin-bottom:1px;" id="team<?php echo $teamID; ?>">
                                			<?php
                                			for($i=0; $i<$no_of_dates; $i++)
											{
												//check valid from date with calander date
												if(date("Y-m-d",strtotime($i.'days',$d))>=$validDate && date("Y-m-d",strtotime($i.'days',$d))<= $validDateTo)
												{
													//chnge cell color validfrom date to vaildto date
													//for($a=0; $a<=$dateDifferent; $a++)
													//{
											?>
                         								<div title="active" id="<?php echo date("Y-m-d",strtotime($i++.'days',$d)); ?>" style="width:40px; height:25px; background-color:#E4E4E4; margin-right:1px; ">&nbsp;</div>                                                  
                                                <?php
													//}
													//$a--;
													//$i = $i + $a;
													$i--;
												}
                                                else
												{
												?>
                                                	<div title="inActive" id="<?php echo date("Y-m-d",strtotime($i.'days',$d)); ?>" style="width:40px; height:25px; background-color:#C8C8C8; margin-right:1px; ">&nbsp;</div>
                                                 
                                			<?php
												}
											}//end of for
											?>
                                			 </div>
                                             </td>
                                			</tr>
                                            
                                            
                                            <!-- Select sub teams -->
                                           <?php 
										   $sql_subTeam = "SELECT
plan_teams.intTeamNo,
plan_teams.strTeam,
date(plan_teamsvaliddates.dtmValidFrom) AS validDate,
date(plan_teamsvaliddates.dtmValidTo) AS validDateTo
FROM
plan_teams
INNER JOIN plan_teamsvaliddates ON plan_teams.intTeamNo = plan_teamsvaliddates.intTeamId
WHERE plan_teams.intSubTeamOf='$teamID'";
											$result_subTeam = $db->RunQuery($sql_subTeam);
										   while($row2 = mysql_fetch_array($result_subTeam))
										   {
											   $subTeamId		= $row2['intTeamNo'];
											   $subTeamName		= $row2['strTeam'];
											   $subvalidDate	= $row2['validDate'];
											   $subvalidDateTo	= $row2['validDateTo'];
										   ?>
                                           <tr>
                                           <td><div style="background-color:#CCFFFF; height:25px; width:71px; margin-bottom:1px; margin-right:1px;"><div style="padding-top:6px;"><?php echo $subTeamName; ?></div></div></td>
                                           <td height="25" style="background-color:#FFFFFF" class="normaltxtmidb2" colspan="<?php echo $no_of_dates; ?>"><div class="classTeam" style="float:left; margin-bottom:1px;" id="team<?php echo $subTeamId; ?>">
                                			<?php
                                			for($i=0; $i<$no_of_dates; $i++)
											{
												//check valid from date with calander date
												if(date("Y-m-d",strtotime($i.'days',$d))>=$subvalidDate && date("Y-m-d",strtotime($i.'days',$d))<= $subvalidDateTo)
												{
													//chnge cell color validfrom date to vaildto date
													//for($a=0; $a<=$dateDifferent; $a++)
													//{
											?>
                         								<div title="active" id="<?php echo date("Y-m-d",strtotime($i++.'days',$d)); ?>" style="width:40px; height:25px; background-color:#E4E4E4; margin-right:1px; ">&nbsp;</div>                                                  
                                                <?php
													//}
													//$a--;
													//$i = $i + $a;
													$i--;
												}
                                                else
												{
												?>
                                                	<div title="inActive" id="<?php echo date("Y-m-d",strtotime($i.'days',$d)); ?>" style="width:40px; height:25px; background-color:#C8C8C8; margin-right:1px; ">&nbsp;</div>
                                                 
                                			<?php
												}
											}//end of for
											?>
                                			 </div>
                                             </td>
                                           </tr>
                                           
                                            
                               				 <?php
										   }
									  } //end of while
																					
					}// end of isset if clause
                           
                                ?>
                                 
                            </tbody>
                        </table>
                        <div align="justify"></div>
                    </div>
                    </td>
                </tr>
            </tbody>
         </table>
        </td>
    </tr>
<tbody>            
</table>
<script type="text/javascript">

	//var no_of_dates = <?php //echo $no_of_dates;?>
	
	/////////////////////////// START FOR TEAM VALUES LOADING.... ///////////////////////////////
	<?php 

	 $sql = "SELECT
DATE(bpodelschedule.dtDateofDelivery) AS dateOfDilivery,
plan_learningcurveheader.strCurveName AS curveName,
orders.intStyleId AS orderStyleId,
plan_stripes.intID,
plan_stripes.strStyleID,
orders.strOrderNo,
orders.strStyle AS orderStyle,
plan_stripes.smv,
plan_stripes.intTeamNo,
plan_stripes.intLearningCuveId,
plan_stripes.dblLeftPercent,
plan_stripes.startDate,
plan_stripes.startTime,
plan_stripes.startTimeLeft,
plan_stripes.endDate,
plan_stripes.endTime,
plan_stripes.totalHours,
plan_stripes.dblQty,
plan_stripes.dblActQty,
plan_stripes.dblStripWidth,
((hour(plan_stripes.startTime)*60) +minute(plan_stripes.startTime)) AS startTotalMin,
((hour(plan_stripes.endTime)*60) +minute(plan_stripes.endTime)) AS lastDayMin,
SUM(productionlineoutputheader.dblTotQty) AS actualQty,
(SELECT COUNT(DISTINCT productionlineoutputheader.dtmDate)FROM productionlineoutputheader INNER JOIN plan_stripes on productionlineoutputheader.intStyleId=plan_stripes.strStyleID )AS datesCount
FROM
plan_stripes
Inner Join orders ON plan_stripes.strStyleID = orders.intStyleId
Left Join plan_learningcurveheader ON plan_learningcurveheader.id = plan_stripes.intLearningCuveId
Left Join bpodelschedule ON bpodelschedule.intStyleId = orders.intStyleId
Inner Join plan_teamsvaliddates ON plan_stripes.intTeamNo = plan_teamsvaliddates.intTeamId
Left Join productionlineoutputheader ON plan_stripes.strStyleID = productionlineoutputheader.intStyleId
WHERE date(plan_teamsvaliddates.dtmValidFrom) >= '$cellDate'
GROUP BY
plan_stripes.intID";
	$result = $db->RunQuery($sql);
	$maxV = 0;
	
	while($row=mysql_fetch_array($result))
	{

		$stripId =  $row['intID'];
		
?>	
		var arrProp = [];
		var stripId					=		<?php echo $row['intID']; ?>;
		arrProp['id']				=		stripId;
		arrProp['orderStyleId']		=		<?php echo $row['orderStyleId']; ?>;
		arrProp['orderNo']			=		'<?php echo $row['strOrderNo']; ?>';
		arrProp['orderStyle']		=		'<?php echo $row['orderStyle']; ?>';
		arrProp['smv']				=		<?php echo $row['smv']; ?>;
		arrProp['style']			=		'<?php echo $row['strStyleID']; ?>';
		arrProp['qty']				=		'<?php echo $row['dblQty']; ?>';
		arrProp['actQty']			=		'<?php echo $row['actualQty']; ?>';
		arrProp['new']				=		'0';
		arrProp['totalHours']		=		<?php echo $row['totalHours']; ?>;
	
		arrProp['startDate']	    =	 '<?php echo $row['startDate']; ?>';
	
		
		arrProp['startTime']	=		'<?php echo $row['startTime']; ?>';
		arrProp['team']			=		<?php echo $row['intTeamNo']; ?>;
		arrProp['curve']		=		<?php echo $row['intLearningCuveId']; ?>;
		arrProp['curveName']	= 		'<?php echo $row['curveName']; ?>';
		arrProp['endDate']		=		'<?php echo $row['endDate']; ?>';
		arrProp['endTime']		=		'<?php echo $row['endTime']; ?>';
		//arrProp['startTotalMin']=		'<?php echo $row['startTotalMin']; ?>';
		arrProp['lastDayMin']=		'<?php echo $row['lastDayMin']; ?>';
		arrProp['cellLeft']=		'<?php echo $row['dblLeftPercent']; ?>';
		//arrProp['behindQty']=		'<?php //echo $row['dblBehindQty']; ?>';
		arrProp['behindQty']=		0;
		arrProp['removeStatus']	=	0;
		arrProp['stripWidth']	= '<?php echo $row['dblStripWidth'];?>';
		arrProp['deliveryDate']	= '<?php echo $row['dateOfDilivery']; ?>';
		arrProp['datesCount']	= '<?php echo $row['datesCount']; ?>';
		//arrProp['behindQty']	= 0;
		//arrProp['joinStripCnt']	= 0;
		arrStrip[stripId]=arrProp;
		arrProp = null;
	
		i = 1;

<?php
	}
?>
	
	<?php
		$sql = "select * from plan_teams";
		$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		
	?>
		//TEAM DETAILS
		
		var arrT			=	[];
		arrT['id'] 			=	 <?php echo $row['intTeamNo']; 		?>;
		arrT['strTeam'] 	=	 '<?php echo $row['strTeam']; 		?>';
		arrT['subTeamOf']	=	<?php echo $row['intSubTeamOf'] ;?>;
		arrT['efficency']	=	 <?php echo $row['intEfficency']; 	?>;
		arrT['machines']	=	 <?php echo $row['intMachines']; 	?>;
		arrT['mealHours']	=	<?php echo $row['dblMealHours']; ?>;
		arrT['totalStripWidth']  = 0;
		
		arrTeam[arrT['id']]	=	arrT;
	<?php
	}
	   $sql1 = "SELECT
plan_teams.strTeam,
plan_teams.intTeamNo,
date(plan_teamsvaliddates.dtmValidFrom) AS validDate,
DATEDIFF( plan_teamsvaliddates.dtmValidTo,plan_teamsvaliddates.dtmValidFrom) AS dateDifferent,
plan_teams.dblWorkingHours,
plan_teams.dblMealHours,
plan_teams.dblStartTime
FROM
plan_teams
Inner Join plan_teamsvaliddates ON plan_teams.intTeamNo = plan_teamsvaliddates.intTeamId";
	   $result1 = $db->RunQuery($sql1);	
	   while($row1 = mysql_fetch_array($result1))
	   {
		    $dblWorkingHours = $row1["dblWorkingHours"];
			//calculate minuts
			$H1 = floor($dblWorkingHours);
			$M1 = ($H1*60)+ (($dblWorkingHours-$H1)*100)+($row1['dblMealHours']*60);
			$wokingMInutes = $M1;	
			
	?>	
		var arrC			=	[];
		
		arrC['teamId'] 			=	 <?php echo $row1['intTeamNo']; 		?>;
		arrC['workingMinutes']	=	 <?php echo $wokingMInutes; 	?>;
		///alert(arrC['workingMinutes']);
		arrC['workingHours']	=	 <?php echo $row1['dblWorkingHours']; 	?>;
		arrC['startTime']       =    <?php echo $row1['dblStartTime'];   ?>; 
		
		arrM[arrC['teamId']]	=	arrC;
		
	<?php 
	
	   }
	?>
		
	///////////////////////////////Array for Curves/////////////////////////////////////////
	
	
	<?php
		$sql = "SELECT id,strCurveName FROM plan_learningcurveheader";
		$result = $db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
		$curveId=$row['id'];
	?>
		
	<?php		
			$sql1="SELECT dblEfficency FROM plan_learningcurvedetails WHERE id=$curveId";
			$effi="";
	
			$result1 = $db->RunQuery($sql1);
	
			while($row1=mysql_fetch_array($result1))
			{
				$effi.=$row1['dblEfficency'];
				$effi.=",";
			}
	?>
		var arrCu=[];
		arrCu['id']= <?php echo $row['id'];?>;
		
		arrCu['curveName']='<?php echo $row['strCurveName']; ?>';
		arrCu['efficiency']= '<?php echo $effi ;?>'; 
		arrCurve[arrCu['id']]=arrCu;
		<?php
		}
		?>
	
	
	createAllStrips();
</script>
</form>
</body>
</html>


