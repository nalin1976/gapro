<?php
include "../../Connector.php";

$checkDate	= $_GET["checkDate"];
$txtDfrom	= $_GET["txtDfrom"];
$txtDto		= $_GET["txtDto"];
$companyId	= $_GET["companyId"];
$PONo		= $_GET["PONo"];
$ReportType	= $_GET["ReportType"];
$style		= $_GET["style"];
$buyer		= $_GET["buyer"];
$division	= $_GET["division"];
$season		= $_GET["season"];
$i = 0;
if($ReportType=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="WipReport.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WIP REPORT</title>

<style type="text/css">
<!--
tbody.ctbody1 {
        height: 580px;

        overflow-y: auto;

        overflow-x: hidden;
}



.cutting-sub
{
	background:#A0BC2C;
	
}

.sawing-sub
{
	background:#FA8686;
	
}

.washing-sub
{
	background:#FFAC25;
	
}

.shipping-sub
{
	background:#92CDDC;
	
}

.packing-sub
{
	background:#d28de8;
	
}

.qc-sub
{
	background:#B2A1C7;
	
}

td.cutting-fnt
{
	color:#819E00;
	
}
td.sawing-fnt
{
	color:#DB0000;
	
}
td.washing-fnt
{
	color:#C17700;
	
}

td.shipping-fnt
{
	color:#02A9D3;
	
}

td.packing-fnt
{
	color:#8D08BA;
	
}

td.qc-fnt
{
	color:#755E93;
	
}

td.main-border{
	-moz-border-radius: 3px 3px 3px 3px;
	-webkit-border-radius: 10px;
 	border:#9EB6CE 1px solid;
}
table.menu-hide-class tr:hover{
	background:#9EB6CE;
	cursor:pointer;
}

#menu-hide td{
	
	border-bottom:#eee 1px solid;
}

.cutting_unhide{
	display:none;	
}

.sawing_unhide{
	display:none;	
}

.washing_unhide{
	display:none;	
}

.qc_unhide{
	display:none;	
}

.packing_unhide{
	display:none;	
}

.shipping_unhide{
	display:none;	
}
-->
</style>
</head>
<link type="text/css"  href="../../css/erpstyle.css" rel="stylesheet" />
<style type="text/css">

  
</style>

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript" ></script>
<script type="text/javascript">
var prev_row_no=-99;
var menu_rowindex=-99;
$(document).ready(function() 
{
	/*$("#tblMain2").fixedHeader({
	width: '100%',height: document.documentElement.clientHeight-50
	});	*/
	
	$('#tblMain2 tbody tr').click(function(){
		if($(this).attr('bgColor')!='#EEE'){
			var color=$(this).attr('bgColor')
			$(this).attr('bgColor','#EEE')
			$(this).css('color','#fff')	
			if(prev_row_no!=-99){
			$('#tblMain2 tbody')[0].rows[prev_row_no].bgColor=pub_bg_color_click;
			$('#tblMain2 tbody')[0].rows[prev_row_no].style.color='#666';	
			}
			if(prev_row_no==$(this).index())
			{
				prev_row_no=-99
			}
			else
			prev_row_no=$(this).index()			
			pub_bg_color_click=color
			
			}			
			
		})
		
		$('.ordno').mouseover(function(e){
			menu_rowindex =this.parentNode.rowIndex;
			var comment=commentarray[$('#tblMain2 tbody tr')[menu_rowindex-2].cells[2].id];
			if(comment=='')
				return false;
			$('#cell_comment').html(comment)
			$('#dv_tooltip').css({
				top: (e.pageY+10)+'px',
				left: e.pageX+'px'
			}).show();
			return false;
		})	
		
		$('.ordno').mouseout(function(){
			var menu_rowindex =this.rowIndex;
			$('#dv_tooltip').css('display','none');
			return false;
		})	
		
		$(".trclass").bind("contextmenu", function(e) {
		menu_rowindex =this.rowIndex;
		$('#grid_menu').css({
			top: e.pageY+'px',
			left: e.pageX+'px'
		}).show();
		return false;
		});
	
		$(document).click(function() {
			$("#grid_menu").hide();
		});	
		
		$("#auto_cal_weight").click(function(e){
			$("#grid_menu").hide();
			$('#dv_menu').css({
			top: (e.pageY-20)+'px',
			left: e.pageX+'px'
			}).show();
			$('#txtBuyerPO').val($('#tblMain2 tbody tr')[menu_rowindex-2].cells[2].childNodes[0].nodeValue);
			$('#txtStyleId').val($('#tblMain2 tbody tr')[menu_rowindex-2].cells[2].id);
			return false;			
		})
		
		$("#capture_session").click(function(e){
			$("#grid_menu").hide();
			$('#dv_session').css({
			top: (e.pageY-200)+'px',
			left: (e.pageX-100)+'px'
			}).show();
			$('#txtOrders').val($('#tblMain2 tbody tr').length-2);
			return false;			
		})
		
		$('#WIP_Explore').click(function(){
				var styleid			=$('#tblMain2 tbody tr')[menu_rowindex-2].cells[2].id;
				var url				='wip_pop.php?request=confirm_pl&styleid='+styleid;
				var xml_http_obj	=$.ajax({url:url,async:false});
				drawPopupArea(800,304,'frm_wip_explore');
				$('#frm_wip_explore').html(xml_http_obj.responseText)
				$('#frm_wip_explore').css('border','0');
				$('#frm_wip_explore').css('background-color','');
			})
		$('#WIP_New_Explore').click(function(){
				var styleid			=$('#tblMain2 tbody tr')[menu_rowindex-2].cells[2].id;
				var url				='wip_pop.php?request=confirm_pl&styleid='+styleid;
				window.open(url,'wip_d');
			})
		
		$("#btn_pop_close").click(function(e){
			$("#dv_menu").hide();
			return false;			
		})
		
		$("#group_cutting").click(function(){
			
			$('.cutting').css('display','none');
			$('.cutting_unhide').show()
		})
		
		$(".cutting_unhide").click(function(){
			
			$('.cutting_unhide').css('display','none');
			$('.cutting').show()
		})
		
		$("#group_sawing").click(function(){
			
			$('.sawing').css('display','none');
			$('.sawing_unhide').show()
		})
		
		$(".sawing_unhide").click(function(){
			
			$('.sawing_unhide').css('display','none');
			$('.sawing').show()
		})
		$("#group_washing").click(function(){
			
			$('.washing').css('display','none');
			$('.washing_unhide').show()
		})
		
		$(".washing_unhide").click(function(){
			
			$('.washing_unhide').css('display','none');
			$('.washing').show()
		})
		
		$("#group_qc").click(function(){
			
			$('.qc').css('display','none');
			$('.qc_unhide').show()
		})
		
		$(".qc_unhide").click(function(){
			
			$('.qc_unhide').css('display','none');
			$('.qc').show()
		})
		
		$("#group_packing").click(function(){
			
			$('.packing').css('display','none');
			$('.packing_unhide').show()
		})
		
		$(".packing_unhide").click(function(){
			
			$('.packing_unhide').css('display','none');
			$('.packing').show()
		})
		
		$("#group_shipping").click(function(){
			
			$('.shipping').css('display','none');
			$('.shipping_unhide').show()
		})
		
		$(".shipping_unhide").click(function(){
			
			$('.shipping_unhide').css('display','none');
			$('.shipping').show()
		})
		$('.dv_session_close').click(function(){
			$('#dv_session').css('display','none');
			
			})
})
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
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td class=" main-border"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td class="head2 " style="color:#045182;text-align:left;" >  Work In Progress <span style="color:#318cc5;font:12px Verdan;display:none">*BETA VERSION</span></td>
      </tr>
      <tr>
        <td><table  width="100%" cellspacing="1" cellpadding="5"  bgcolor="#D0D7E5" id="tblMain2" class="fixHeader">
          <thead>
            <tr bgcolor="#D9E2EE">
              <th  height="25" colspan="8" nowrap="nowrap" class="normalfntMid">Order</th>
              <th nowrap="nowrap" class="normalfntMid cutting_unhide" style="background:#BCD75C" >Cutting</th>
              <th colspan="4" nowrap="nowrap" class="normalfntMid cutting" id='group_cutting' style="background:#BCD75C"><span class="normalfntMid cutting" style="background:#BCD75C">Cutting</span></th>
              <th nowrap="nowrap" class="normalfntMid sawing_unhide" style="background:#FFB6B6">Sewing</th>              
              <th colspan="16" nowrap="nowrap" class="normalfntMid sawing" style="background:#FFB6B6" id="group_sawing">Sewing</th>
              <th nowrap="nowrap" class="normalfntMid washing_unhide" style="background:#FFC666">Washing</th>
              <th colspan="11" nowrap="nowrap" class="normalfntMid washing" style="background:#FFC666" id='group_washing'>Washing</th>
              <th nowrap="nowrap" class="normalfntMid qc_unhide" style="background:#CCC0D9">QC</th>
              <th colspan="6" nowrap="nowrap" class="normalfntMid qc" style="background:#CCC0D9" id="group_qc">QC</th>
              <th nowrap="nowrap" class="normalfntMid packing_unhide" style="background:
#e6bdf3">Packing</th>
              <th colspan="7" nowrap="nowrap" class="normalfntMid packing" style="background:
#e6bdf3" id="group_packing">Packing</th>
              <th nowrap="nowrap" class="normalfntMid shipping_unhide" style="background:#B6DDE8">Shipping</th>
              <th colspan="2" nowrap="nowrap" class="normalfntMid shipping" style="background:#B6DDE8" id='group_shipping'>Shipping</th>
              <th nowrap="nowrap" class="normalfntMid" style="visibility:hiddens"><span class="normalfntMid" style="visibility:hiddens">(SHIP</span>/CUT )% </th>
              <th nowrap="nowrap" class="normalfntMid" style="visibility:hiddens">&nbsp;</th>
            </tr>
            <tr bgcolor="#9EB6CE">
              <th   class="normalfntMid" nowrap="nowrap" height="25">No</th>
              <th  class="normalfntMid" nowrap="nowrap">Manufacturer </th>
              <th  class="normalfntMid" nowrap="nowrap">Order No</th>
              <th  class="normalfntMid" nowrap="nowrap">Style No</th>
              <th  class="normalfntMid" nowrap="nowrap">Buyer</th>
              <th  class="normalfntMid" nowrap="nowrap">Order Qty</th>
              <th  class="normalfntMid" nowrap="nowrap">Color</th>
              <th  class="normalfntMid" nowrap="nowrap">Season</th>
              <th  class="normalfntMid cutting-sub cutting_unhide" nowrap="nowrap">Un-hide</th>
              <th  class="normalfntMid cutting-sub cutting" nowrap="nowrap">Qty</th>
              <th  class="normalfntMid cutting-sub cutting" nowrap="nowrap"> Dispatch</th>
              <th  class="normalfntMid cutting-sub cutting" nowrap="nowrap">Non-Valued</th>
              <th  class="normalfntMid cutting-sub cutting" nowrap="nowrap" title="(Cut Quatity - Dispatch Quantity)">Balance</th>
              
              <th nowrap="nowrap"  class="normalfntMid sawing-sub sawing_unhide">Un-hide</th>
              <th nowrap="nowrap"  class="normalfntMid cutting-sub sawing">Receive</th>
              <th  class="normalfntMid cutting-sub sawing" nowrap="nowrap ">Return Qty</th>
              <th  class="normalfntMid cutting-sub sawing" nowrap="nowrap">Variance</th>
              <th  class="normalfntMid cutting-sub sawing" nowrap="nowrap">Cut Issue</th>
              <th  class="normalfntMid cutting-sub sawing" nowrap="nowrap" title="(Received Quantity - Line In Quantity)">Balance</th>
              <th  class="normalfntMid cutting-sub sawing" nowrap="nowrap" title="(Raw Material + Labor)">Rate</th>
              <th  class="normalfntMid cutting-sub sawing" nowrap="nowrap">Value</th>
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap" title="(Received Quantity - Line In Quantity)">Line Input</th>
              
              
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap">Line Output </th>
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap" title="(Line In - Line Out)">Balance</th>
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap">Wash Ready</th>
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap"> Dispatch</th>
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap">Non-Valued</th>
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap" title="(Line Out - Dispatch)">Balance</th>
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap" title="(Raw Material + Labor)">Rate</th>
              <th  class="normalfntMid sawing-sub sawing" nowrap="nowrap">Value</th>
              <th  class="normalfntMid washing-sub washing_unhide" nowrap="nowrap">Un-hide</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Received</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Variance</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Wet Qty</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Dry Qty</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Other Issue</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Sub Out</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Sub In</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Non-Valued</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Balance</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Rate</th>
              <th  class="normalfntMid washing-sub washing" nowrap="nowrap">Value</th>
              <th nowrap="nowrap"  class="normalfntMid qc-sub qc_unhide">Un-hide</th>
              <th nowrap="nowrap"  class="normalfntMid qc-sub qc">QC In</th>
              <th  class="normalfntMid qc-sub qc" nowrap="nowrap">QC Out</th>
              <th  class="normalfntMid qc-sub qc" nowrap="nowrap">Non-Valued</th>
              <th  class="normalfntMid qc-sub qc" nowrap="nowrap">Balance</th>
              <th  class="normalfntMid qc-sub qc" nowrap="nowrap">Rate</th>
              <th  class="normalfntMid qc-sub qc" nowrap="nowrap">Value</th>
              <th nowrap="nowrap "  class="normalfntMid packing-sub packing_unhide">Un-hide</th>
              <th nowrap="nowrap "  class="normalfntMid packing-sub packing">In</th>
              <th nowrap="nowrap"  class="normalfntMid packing-sub packing">Packed</th>
              <th nowrap="nowrap"  class="normalfntMid packing-sub packing">Dispatch</th>
              <th nowrap="nowrap"  class="normalfntMid packing-sub packing">Non-Valued</th>
              <th nowrap="nowrap"  class="normalfntMid packing-sub packing">Balance</th>
              <th nowrap="nowrap"  class="normalfntMid packing-sub packing">Rate</th>
              <th nowrap="nowrap"  class="normalfntMid packing-sub packing">Value</th>
              <th nowrap="nowrap"  class="normalfntMid shipping-sub shipping_unhide">Un-hide</th>
              <th nowrap="nowrap"  class="normalfntMid shipping-sub shipping">Shipped</th>
              <th nowrap="nowrap"  class="normalfntMid shipping-sub shipping">Balance</th>
              <th nowrap="nowrap"  class="normalfntMid" style="visibility:hiddens">Ratio</th>
              <th nowrap="nowrap"  class="normalfntMid" style="visibility:hiddens">&nbsp;</th>
            </tr>
          </thead>
          <tbody class="ctbody1">
            <?php
          
		   $sql ="select comp.strName,
		   			ordr.intStyleId,
					ordr.strStyle,
					ordr.strOrderNo,
					WV.dblCutting,
					WV.dblSewing,
					WV.dblOH,
					pwip.intStyleID, 
					pwip.strColor, 
					pwip.strSeason, 
					pwip.intSourceFactroyID, 
					pwip.intDestinationFactroyID, 
					pwip.intOrderQty, 
					pwip.intCutQty, 
					pwip.intCutIssueQty, 
					pwip.intCutReceiveQty, 
					pwip.intCutReturnQty, 
					pwip.intInputQty, 
					pwip.intOutPutQty, 
					pwip.intMissingPcs, 
					pwip.intWashReady, 
					pwip.intSentToWash, 
					pwip.intMissingPcsBeforeWash, 
					pwip.intIssuedtoWash, 
					pwip.intFGReturnsBeforeWash,
					pwip.intFGgatePass, 
					pwip.intFGReceived,
					ordr.intQty,
					ordr.intSeasonId,
					ordr.reaSMV,
					ordr.reaSMVRate,
					B.buyerCode,
					pwip.intDryQty,
					intWashSubOut,
					intWashSubIn,
					intPackQty,
					FabricCostPerPCS,
					AccessoriesCostPerPCS
					FinishingAccessoriesCostPerPCS,
					PackingAccessoriesCostPerPCS,
					ServicesCostPerPCS,
					ServicesCostPerPCS,
					WashingCostPerPCS,
					intShipped
					from 
					wip pwip inner join orders ordr on ordr.intStyleID=pwip.intStyleID
					left join companies comp on comp.intCompanyID=pwip.intDestinationFactroyID
					left join wip_valuation WV on WV.intCompanyId=pwip.intDestinationFactroyID
					inner join wipvaluation V_WV on V_WV.intStyleId=ordr.intStyleId
					inner join buyers B on B.intBuyerID=ordr.intBuyerID
					where pwip.intStatus=1 and pwip.intStyleID <> 'a' "; 
		
		if($companyId!="")
		$sql .= "and pwip.intDestinationFactroyID='$companyId' ";
		
		if($PONo!="")
		$sql .= "and pwip.intStyleID='$PONo' ";
		
		if($division!="")
		$sql .= "and ordr.intDivisionId='$division' ";
		
		if($style!="")
		$sql .= "and ordr.strStyle='$style' ";
		
		if($season!="")
		$sql .= "and ordr.intSeasonId='$season' ";
		
		if($buyer!="")
		$sql .= "and ordr.intBuyerID='$buyer' ";
		
		if($checkDate=='true')
		$sql .= "and ordr.dtmDate BETWEEN '$txtDfrom' AND '$txtDto' ";
		
		$sql .= "order by ordr.strOrderNo";
		//die($sql);
		$result=$db->RunQuery($sql);
		
		while($row=mysql_fetch_array($result))
		{
			
			$styleid=$row["intStyleId"];
			/*$str_rawmatetial="SELECT
					FabricCostPerPCS,
					FinishingAccessoriesCostPerPCS,
					PackingAccessoriesCostPerPCS,
					ServicesCostPerPCS,
					ServicesCostPerPCS,
					WashingCostPerPCS
					FROM wipvaluation
					WHERE intStyleId = $styleid";*/
			//$result_rawmaterial=$db->Runquery($str_rawmatetial);
			//$dataholder_rawmaterial=mysql_fetch_array($result_rawmaterial);
			$season = '';
			if($row["intSeasonId"] != '')	
			$season = getSeason($row["intSeasonId"]);
			$Cuttingbalance = $row["intCutQty"]-$row["intCutIssueQty"];
			$factoryCuttingBlance=$row["intCutReceiveQty"]-$row["intInputQty"];
			$inOutBal = $row["intInputQty"]-$row["intOutPutQty"];
			//$cutRate = round(((($row["dblOH"]*$row["dblCutting"])/100)*($row["reaSMVRate"]))+($row["FabricCostPerPCS"]),4);
			$cutRate = round(((($row["dblOH"]*$row["dblCutting"])/100))+($row["FabricCostPerPCS"]),4);
			$sewingTotBal = ($row["intOutPutQty"]-$row["intWashReady"]);
			$sewingRate = round(((($row["dblOH"]*$row["dblSewing"])/100))+($row["FabricCostPerPCS"]+$row["AccessoriesCostPerPCS"]),4);
	
        ?>
            <tr bgcolor="#FFFFFF" class="trclass">
              <td  height="25" class="normalfntMid"  nowrap="nowrap"><?php echo ++$i; ?></td>
              <td  height="25" class="normalfnt"  nowrap="nowrap"><?php echo $row["strName"]; ?></td>
              <td  height="25" class="normalfnt ordno"  nowrap="nowrap" id="<?php echo $row["intStyleId"]; ?>"><?php echo $row["strOrderNo"]; ?></td>
              <td  class="normalfnt"  nowrap="nowrap"><?php echo $row["strStyle"]; ?></td>
              <td  class="normalfnt"  nowrap="nowrap"><?php echo $row["buyerCode"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intQty"]; ?></td>
              <td  class="normalfnt"  nowrap="nowrap"><?php echo $row["strColor"]; ?></td>
              <td  class="normalfnt"  nowrap="nowrap"><?php echo $season; ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt cutting_unhide"><a style="color:inherit;text-decoration:underline" href="../../Reports/production/cutqtyrpt.php?orderNo=<?php echo $row['intStyleId'];?>" target="productDetailRpt.php"><?php echo number_format($row["intCutQty"],0); ?></a></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt cutting"><a style="color:inherit;text-decoration:underline" href="../../Reports/production/cutqtyrpt.php?orderNo=<?php echo $row['intStyleId'];?>" target="productDetailRpt.php"><?php echo number_format($row["intCutQty"],0); ?></a></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt cutting"><?php echo number_format($row["intCutIssueQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt cutting"><?php echo $cutnonbal=getNonVal($styleid,1);?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt cutting"><?php echo ($Cuttingbalance>=0?number_format($Cuttingbalance-$cutnonbal,0):0) ?></td>
              
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing_unhide"><?php echo number_format($row["intCutReceiveQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt sawing"><?php echo number_format($row["intCutReceiveQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt sawing"><?php echo number_format($row["intCutReturnQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt sawing"><?php echo number_format($row["intCutIssueQty"]-$row["intCutReceiveQty"]-$row["intCutReturnQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt sawing"><?php echo number_format($row["intInputQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt sawing"><?php echo $factoryCuttingBlance; ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt sawing"><?php echo number_format($cutRate,4); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite cutting-fnt sawing"><?php $faccutvalue=$factoryCuttingBlance*$cutRate;$cutvalue=$Cuttingbalance*$cutRate; echo number_format(($faccutvalue+$cutvalue),4);?></td>
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing"><?php echo number_format($row["intInputQty"],0); ?></td>
              
              <td  class="normalfntRite sawing-fnt sawing"  nowrap="nowrap"><?php echo number_format($row["intOutPutQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing"><?php echo number_format($inOutBal,0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing"><?php echo number_format($row["intWashReady"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing"><?php echo number_format($row["intFGgatePass"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing"><?php echo $sewnonbal=getNonVal($styleid,'2');?></td>
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing"><?php echo number_format($sewing_bal=$row["intWashReady"]-$row["intFGgatePass"]-$sewnonbal,0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing"><?php echo $sewingRate?></td>
              <td  nowrap="nowrap"  class="normalfntRite sawing-fnt sawing"><?php echo number_format($sewingRate*$sewing_bal,2);?></td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing_unhide"><?php echo number_format($row["intIssuedtoWash"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing"><?php echo number_format($row["intIssuedtoWash"],0); ?></td>
              <td  class="normalfntRite washing-fnt washing"  nowrap="nowrap">0</td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing">0</td>
              <td  class="normalfntRite washing-fnt washing"  nowrap="nowrap"><?php echo number_format($row["intDryQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing">0</td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing"><?php echo number_format($row["intWashSubOut"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing"><?php echo number_format($row["intWashSubIn"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing">0</td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing">0</td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing">0</td>
              <td  nowrap="nowrap"  class="normalfntRite washing-fnt washing">0</td>
              <td  nowrap="nowrap "  class="normalfntRite qc-fnt qc_unhide">0</td>
              <td  nowrap="nowrap "  class="normalfntRite qc-fnt qc">0</td>
              <td  nowrap="nowrap"  class="normalfntRite qc-fnt qc">0</td>
              <td  nowrap="nowrap"  class="normalfntRite qc-fnt qc">0</td>
              <td  nowrap="nowrap"  class="normalfntRite qc-fnt qc">0</td>
              <td  nowrap="nowrap"  class="normalfntRite qc-fnt qc">0</td>
              <td  nowrap="nowrap"  class="normalfntRite qc-fnt qc">0</td>
              <td  nowrap="nowrap"  class="normalfntRite packing-fnt packing_unhide"><?php echo number_format($row["intPackQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite packing-fnt packing "><?php echo number_format($row["intPackQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite packing-fnt packing "><?php echo number_format($row["intPackQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite packing-fnt packing"><?php echo number_format($row["intPackQty"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite packing-fnt packing">0</td>
              <td  nowrap="nowrap"  class="normalfntRite packing-fnt packing">0</td>
              <td  nowrap="nowrap"  class="normalfntRite packing-fnt packing">0</td>
              <td  nowrap="nowrap"  class="normalfntRite packing-fnt packing">0</td>
              <td  nowrap="nowrap"  class="normalfntRite shipping-fnt  shipping_unhide"><?php echo number_format($row["intShipped"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite shipping-fnt shipping"><?php echo number_format($row["intShipped"],0); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite shipping-fnt shipping">0</td>
              <td  nowrap="nowrap"  class="normalfntRite shipping-fnt"><?php echo number_format(($row["intShipped"]/$row["intCutQty"])*100,2); ?></td>
              <td  nowrap="nowrap"  class="normalfntRite shipping-fnt" style="visibility:hiddens">&nbsp;</td>
            </tr>
            <?php
		}
		?>
            <tr bgcolor="#FFFFFF" style="display:none">
              <td  height="25" class="normalfntMid"  nowrap="nowrap">&nbsp;</td>
              <td  height="25" class="normalfnt"  nowrap="nowrap">&nbsp;</td>
              <td  height="25" class="normalfnt"  nowrap="nowrap" id="<?php echo $row["intStyleId"]; ?>2">&nbsp;</td>
              <td  class="normalfnt"  nowrap="nowrap">&nbsp;</td>
              <td  class="normalfnt"  nowrap="nowrap">&nbsp;</td>
              <td  class="normalfntRite"  nowrap="nowrap">&nbsp;</td>
              <td  class="normalfnt"  nowrap="nowrap">&nbsp;</td>
              <td  class="normalfnt"  nowrap="nowrap">&nbsp;</td>
              <td colspan="6"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="2"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="5"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  class="normalfntRite"  nowrap="nowrap">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="2"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="2"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  class="normalfntRite"  nowrap="nowrap">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="2"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="2"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="3"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="2"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="5"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
              <td colspan="13"  nowrap="nowrap"  class="normalfntRite">&nbsp;</td>
            </tr>
            <tr class="bcgcolor-tblrowWhite">
              <td height="46" colspan="63" nowrap="nowrap" class="normalfnt" >&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<div style="display:none; position:absolute; left: 65px; top: 87px;" id="dv_tooltip"><table width="400" border="0" cellspacing="5" cellpadding="0"  bgcolor="#000000" style="opacity: 0.7;-moz-border-radius: 10px 10px 10px 10px;
	-webkit-border-radius: 10px;
 	border:#FFF 1px solid;" >
  <tr>
    <td style="color:#FFF;" class="normalfnt" valign="top" id="cell_comment"><p><strong>Date : </strong>1st/March</p><p><strong>dsdadasd</strong></p></td>
  </tr>
</table>
</div>
<div style="display:none; position:absolute; left: 65px; top: 87px; border:1px #333" id="dv_session">
  <table  border="0" cellspacing="0" bgcolor="#FFFFFF"  cellpadding="3" style="-moz-border-radius: 3px 3px 3px 3px;
	 	border:#9EB6CE 1px solid;" class="normalfnt">
    <tr style="">
      <td height="20" valign="top" style="color:#045182;text-align:left;"><strong>CAPTURE SESSION</strong></td>
      <td style="color:#045182;text-align:right;font-size:120%" valign="top"><span class="mouseover dv_session_close" ><strong>&nbsp;&nbsp;X&nbsp;</strong></span></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" class="normalfnt"><table width="400" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="40%">Date:</td>
          </tr>
        <tr>
          <td><input type="text" name="txtSession" id="txtSession" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo date('Y-m-d');//($txtDfrom=="" ? "":$txtDfrom);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
          </tr>
        <tr>
          <td>Number of orders:</td>
        </tr>
        <tr>
          <td><input type="text" id="txtOrders" name="txtOrders"  class="txtbox" disabled="disabled" style="width:90px;"/></td>
        </tr>
        <tr>
          <td>Remarks:</td>
          </tr>
        <tr>
          <td><textarea name="txtMarksofPKGS" tabindex="22"  rows="4" id="txtMarksofPKGS" style="width:390px;"></textarea></td>
        </tr>
        <tr>
          <td align="center"><img src="../../images/accept.png" width="16" height="16" /> &nbsp;&nbsp;&nbsp;&nbsp;<img src="../../images/deletered.png" width="16" height="16"  class="mouseover dv_session_close"/></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div style="display:none; position:absolute; left: 65px; top: 87px; border:1px #333" id="dv_menu"><table width="420" border="0" cellspacing="0" cellpadding="0" style="border:#999 1px solid;-moz-border-radius: 2px;background:#FFF;opacity: 0.9;">
  <tr>
    <td align="center"><table width="395" border="0" cellspacing="5" cellpadding="0"  bgcolor="#FFFFFF" style="opacity: 0.9;" >
      <tr>
        <td  class="normalfnt" valign="top">Order No:</td>
      </tr>
      <tr>
        <td  class="normalfnt" valign="top" id='comment_vindow'><input name="txtBuyerPO" type="text" tabindex="2" class="txtbox" id="txtBuyerPO" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:390px" maxlength="20" readonly="readonly"/><input type="hidden" id="txtStyleId"  name="txtStyleId"  /></td>
      </tr>
      <tr>
        <td  class="normalfnt" valign="top">Date:</td>
      </tr>
      <tr>
        <td  class="normalfnt" valign="top"><input type="text" name="txtCommentDate " id="txtCommentDate" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo date('Y-m-d');//($txtDfrom=="" ? "":$txtDfrom);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
      </tr>
      <tr>
        <td  class="normalfnt" valign="top">Comment:</td>
      </tr>
      <tr>
        <td  class="normalfnt" valign="top"><textarea name="txtComment" tabindex="22"  rows="4" id="txtComment" style="width:390px;"></textarea></td>
      </tr>
      <tr>
        <td  class="normalfnt" valign="top" style="text-align:center"><img src="../../images/accept.png" width="16" height="16" id="btn_save_popup"/> &nbsp;&nbsp;&nbsp;&nbsp;<img src="../../images/deletered.png" width="16" height="16" id='btn_pop_close'/></td>
      </tr>
    </table></td>
  </tr>
</table>

</div>
<div style=" padding: 2px; display: none; position: absolute; background-color: #F8F8F8; top: 667px; left: 330px;" id="grid_menu" >
			<table width="150" id='menu-hide' class="normalfnt menu-hide-class" cellpadding="3" style="border:1px solid #9EB6CE">
            	<tr>
                    <td id="auto_cal_weight" class="normalfnt" height="20">Add Comment</td>
                </tr>
                <tr>
                    <td id="WIP_Explore" class="normalfnt" height="20">Explore</td>
                </tr>
                <tr>
                    <td id="WIP_New_Explore" class="normalfnt" height="20">Explore in New Tab</td>
                </tr>
                <tr>
                    <td id="" class="normalfnt" height="20">Non-Valued Balance</td>
                </tr>
                <tr>
                    <td class="normalfnt" height="20" id="capture_session">Capture</td>
                </tr>
                <tr>
                    <td id="" class="normalfnt" height="20">Reload Capture</td>
                </tr>
                <tr>
                    <td id="" class="normalfnt" height="20">Order Complete</td>
                </tr>
                <tr>
                    <td id="" class="normalfnt" height="20">Switch to Review Mode</td>
                </tr>
            </table>
		
</div>
<script type="text/javascript">

var prev_row_no=-99;

var pub_bg_color_click='#FFFFFF';

$(document).ready(function()
{
     $('#tblMain tbody tr').click(function(){
         if($(this).attr('bgColor')!='#82FF82')
             {
                 var color=$(this).attr('bgColor')
                 $(this).attr('bgColor','#82FF82')
                 if(prev_row_no!=-99){
                    $('#tblMain tbody')[0].rows[prev_row_no].bgColor=pub_bg_color_click;           
                       }
                  if(prev_row_no==$(this).index())
                   {
                         prev_row_no=-99

                                }

						else
							prev_row_no=$(this).index()                                   

						pub_bg_color_click=color                  
					   }                                             
		})
		$('#btn_save_popup').click(function(){
				var styleid=$('#txtStyleId').val();
				var commentdate=$('#txtCommentDate').val();	
				var comment=$('#txtComment').val();	
				var url				='wipdb.php?request=save_comment&styleid='+styleid+'&commentdate='+commentdate+'&comment='+comment;
				var xml_http_obj	=$.ajax({url:url,async:false});
				commentarray[styleid]=xml_http_obj.responseText;
				$("#dv_menu").hide();
		})
		
});

</script>
</body>
</html>
<?php
function getNonVal($styleid,$processid)
{
	
	global $db;
	$sql = " SELECT SUM(dblQty) as qty FROM production_nonvalue_header PNH
			INNER JOIN production_nonvalue_detail PND 
			ON PND.intNonValueSerial=PNH.intNonValueSerial
			WHERE intStyleId='$styleid' AND intProcessId=$processid";
	$result = $db->RunQuery($sql); 
	$row = mysql_fetch_array($result);
	
	return $row["qty"];
}

function getSeason($seasonId)
{
	global $db;
	$sql = " select strSeason from seasons where intSeasonId='$seasonId' ";
	$result = $db->RunQuery($sql); 
	$row = mysql_fetch_array($result);
	
	return $row["strSeason"];
}
?>
<script type="text/javascript">
var commentarray=[];
<?php 
	$str="SELECT intStyleId FROM wip WHERE intStatus=1";
	$result=$db->RunQuery($str);	
	while($row=mysql_fetch_array($result))
	{
		$styleid=$row['intStyleId'];
		$comment='';
		$str_comment="select concat('<p><strong>Date : </strong>', DATE_FORMAT(dtmDateComment ,'%D/ %M') ,'</p><p><strong>',stComment,'</strong></p>') as comment from wip_comment where intStyleId='$styleid' ORDER BY dtmDateComment DESC ";
		$result_comment=$db->RunQuery($str_comment);
		while($row_comment=mysql_fetch_array($result_comment))
		{
			$comment.=$row_comment["comment"];
		}
		?>
        commentarray[<?php echo $styleid?>]="<?php echo $comment?>"
		
	<?php }
	
?>
</script>