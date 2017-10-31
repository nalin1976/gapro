<?php
session_start();
$backwardseperator = "../";
include "$backwardseperator".''."Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<title>Shipment Packing List</title>
<style type="text/css">
.dataTable { font-family:Verdana, Arial, Helvetica, sans-serif; border-collapse: collapse; border:1px solid #999999; width: 750px; font-size:12px;}
.dataTable td, .dataTable th {border: 1px solid #999999; padding: 3px 5px; margin:0px;}
.dataTable thead th { background-color:#cccccc; color:#444444; font-weight:bold; text-align:left;}
.dataTable thead a {text-decoration:none; color:#444444; }
.dataTable thead a:hover { text-decoration: underline;}

/* Firefox has missing border bug! https://bugzilla.mozilla.org/show_bug.cgi?id=410621 */
/* Firefox 2 */
html</**/body .dataTable, x:-moz-any-link {margin:1px;}
/* Firefox 3 */
html</**/body .dataTable, x:-moz-any-link, x:default {margin:1px}
</style>
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
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
        <script type="text/javascript">
 var freezeRow=1; //change to row to freeze at
  var freezeCol=3; //change to column to freeze at
  var myRow=freezeRow;
  var myCol=freezeCol;
  var speed=100; //timeout speed

  var myTable;
  var noRows;
  var myCells,ID;
  

  
function setUp(){
	if(!myTable){myTable=document.getElementById("tblPL");}
 	myCells = myTable.rows[0].cells.length;
	noRows=myTable.rows.length;

	for( var x = 0; x < myTable.rows[0].cells.length; x++ ) {
		colWdth=myTable.rows[0].cells[x].offsetWidth;
		myTable.rows[0].cells[x].setAttribute("width",colWdth-4);

	}
}


function right(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myCol<(myCells)){
		for( var x = 0; x < noRows; x++ ) {
			myTable.rows[x].cells[myCol].style.display="";
		}
		if(myCol >freezeCol){myCol--;}
		ID = window.setTimeout('right()',speed);
	}
}

function left(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myCol<(myCells-1)){
		for( var x = 0; x < noRows; x++ ) {
			myTable.rows[x].cells[myCol].style.display="none";
		}
		myCol++
		ID = window.setTimeout('left()',speed);

	}
}

function down(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myRow<(noRows-1)){
			myTable.rows[myRow].style.display="none";
			myRow++	;

			ID = window.setTimeout('down()',speed);
	}
}

function upp(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}
	if(myRow<=noRows){
		myTable.rows[myRow].style.display="";
		if(myRow >freezeRow){myRow--;}
		ID = window.setTimeout('upp()',speed);
	}
}


</script>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}
.buttonDn {width:20px;position: absolute;bottom:22px;
}
.buttonUp {width:20px;position: absolute;top:2px;
}
.div_verticalscroll {position: relative;
#left:900px;
#top:-220px;
right:0px;
width:18px;
height:220px;
background:#EAEAEA;
border:1px solid #C0C0C0;
}

-->
</style>
</head>
<body>
<table width="950" border="0" cellspacing="3" cellpadding="0" bgcolor="#FFFFFF" align="center">
  <tr>
    <td align="center"><?php include "".$backwardseperator."Header.php"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#316895" class="TitleN2white" height="25">Shipment Packing List</td>
  </tr>
  <tr>
    <td>
    
    <table width="950" border="0" cellspacing="3" cellpadding="0" align="center">
      <tr>
        <td><form id="pl_header"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt bcgl1">
          <tr>
            <td height="5" colspan="8"></td>
          </tr>
          <tr>
            <td height="25" title="PL Number is an auto generated number.">PL No</td>
            <td id='plno_cell' title="PL Number is an auto generated number."><input name="txtPLNo"  type="text" class="txtbox" id="txtPLNo" tabindex="1" style="width:146px" disabled="disabled" /></td>
            <td>Date</td>
            <td><input style="text-align:center" name="txtSailingDate" tabindex="2"  type="text" class="txtbox" id="txtSailingDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="calender" type="text"  class="txtbox" style="visibility:hidden;width:5px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            <td>Order No</td>
            <td><select name="cmbStyle" class="txtbox" id="cmbStyle" style="width:150px" tabindex="3">
              <option value=""></option>
              <?php 
			$buyerstr="select distinct strStyle from style_ratio_plugin";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{1
		?>
              <option value="<?php echo $buyerrow['strStyle'];?>"><?php echo $buyerrow['strStyle'];?></option>
              <?php } ?>
            </select></td>
            <td>Style <span style="color:#F00">*</span></td>
            <td><input name="txtProductCode" type="text" class="txtbox" id="txtProductCode" style="width:146px" maxlength="50" tabindex="4"/></td>
          </tr>
          <tr>
            <td height="25" nowrap="nowrap">Material #</td>
            <td><input name="txtMaterialNo" type="text" class="txtbox" id="txtMaterialNo" style="width:146px"  maxlength="50" tabindex="5"/></td>
            <td>Fabric</td>
            <td><input name="txtFabric" type="text" class="txtbox" id="txtFabric" style="width:146px" maxlength="50" tabindex="6"/></td>
            <td>Label</td>
            <td><input name="txtLable" type="text" class="txtbox" id="txtLable" style="width:146px"  maxlength="50" tabindex="7"/></td>
            <td>Color</td>
            <td><input name="txtColor" type="text" class="txtbox" id="txtColor" style="width:146px" maxlength="50" tabindex="8"/></td>
          </tr>
          <tr>
            <td height="25">ISD No</td>
            <td><input name="txtISD" type="text" class="txtbox" id="txtISD" style="width:146px" maxlength="50" tabindex="9"/></td>
            <td nowrap="nowrap">PrePacK Code</td>
            <td><input name="txtPrePackCode" type="text" class="txtbox" id="txtPrePackCode" style="width:146px" maxlength="50" tabindex="10"/></td>
            <td>Season</td>
            <td><input name="txtSeason" type="text" class="txtbox" id="txtSeason" style="width:146px" maxlength="50" tabindex="11"/></td>
            <td>Division</td>
            <td><input name="txtDivision" type="text" class="txtbox" id="txtDivision" style="width:146px" maxlength="50" tabindex="12"/></td>
          </tr>
          <tr>
            <td height="25" nowrap="nowrap">CTN Volume </td>
            <td><input name="txtCTNS" type="text" class="txtbox" id="txtCTNS" style="width:146px"  maxlength="50" tabindex="13" title="Separate using 'X'." /></td>
            <td>Wash Code</td>
            <td><input name="txtWashCode" type="text" class="txtbox" id="txtWashCode" style="width:146px" maxlength="50" tabindex="14" /></td>
            <td>Article</td>
            <td><input name="txtArticle" type="text" class="txtbox" id="txtArticle" style="width:146px" maxlength="50" tabindex="15"/></td>
            <td>CBM</td>
            <td><input name="txtCBM" type="text" class="txtbox" id="txtCBM" style="width:146px" maxlength="50" tabindex="16" /></td>
          </tr>
          <tr>
            <td height="25">Item #</td>
            <td><input name="txtItemNo" type="text" class="txtbox" id="txtItemNo" style="width:146px" maxlength="50" tabindex="17"/></td>
            <td>Item</td>
            <td><input name="txtItem" type="text" class="txtbox" id="txtItem" style="width:146px" maxlength="50" tabindex="18"/></td>
            <td nowrap="nowrap">Manu. Ord. # </td>
            <td><input name="txtManufactOrderNo" type="text" class="txtbox" id="txtManufactOrderNo" style="width:146px"  maxlength="50" tabindex="19"/></td>
            <td nowrap="nowrap">Manu. Style</td>
            <td><input name="txtManufactStyle" type="text" class="txtbox" id="txtManufactStyle" style="width:146px" maxlength="50" tabindex="20"/></td>
          </tr>
          <tr>
            <td height="25">DO #</td>
            <td><input name="txtDO" type="text" class="txtbox" id="txtDO" style="width:146px"  maxlength="50" tabindex="21"/></td>
            <td>Sorting Type</td>
            <td><input name="txtSortingType" type="text" class="txtbox" id="txtSortingType" style="width:146px" maxlength="50" tabindex="22"/></td>
            <td>Manufacturer </td>
            <td><select name="cboFactory"  class="txtbox" style="width:150px" id="cboFactory"  tabindex="23" >
              <option value=""></option>
              <?php 
			$strtofactory="select strCustomerID,strName from customers  order by strName";
		
			$factresults=$db->RunQuery($strtofactory);
			
			while($factrow=mysql_fetch_array($factresults))
			{
		?>
              <option value="<?php echo $factrow['strCustomerID'];?>"><?php echo $factrow['strName'];?></option>
              <?php } ?>
            </select></td>
            <td>WT Unit </td>
            <td><select name="txtUnit" type="text" id="txtUnit" class="txtbox" style="width:150px" tabindex="24">
              <option value=""></option>
              <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
            </select></td>
          </tr>
          <tr>
            <td width="10%" height="5"></td>
            <td width="15%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
          </tr>
        </table></form></td>
      </tr>
      <tr>
        <td height="5"></td>
      </tr>
       <tr>
        <td  bgcolor="#9BBFDD" class="head1" nowrap="nowrap"> Packing List Details</td>
      </tr>
      <tr>
        <td class="tableBorder" height="25"><table width="100" cellpadding="0" cellspacing="0">
          
          <tr>
            <td colspan="2"><table>
              <tr>
                <td><div id="divcons" style="overflow: -moz-scrollbars-horizontal; height:220px; width:930px;">
                  <table style="width:100%;"  cellpadding="0" cellspacing="1" bgcolor="#ffffff"  id="tblPL">
                    <tr class="mainHeading4">
                      <td height="25" bgcolor="#498CC2" class="normaltxtmidb2">Style Ratio</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
            <td><div style="cursor: pointer;" class="div_verticalscroll" onmouseover="this.style.cursor='pointer'">
              <div style="height: 50%;" onmousedown="upp();" onmouseup="upp(1);"><img src="../images/uF035.png" alt="s" class="buttonUp" /></div>
              <div style="height: 50%;" onmousedown="down();" onmouseup="down(1);"><img src="../images/uF036.png" alt="s" class="buttonDn" /></div>
            </div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="5"></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" class="tableBorder" cellspacing="0" cellpadding="0" >
          <tr >
            <td colspan="2" >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#D6E7F5">
            <td width="23%" height="30"><div align="right">
              <span class="head1"><img src="../images/insert_row.jpg"  title="Insert Row" class="mouseover" onclick="insert_row()" align="right"/></span></div></td>
            <td width="12%" height="30"><div align="center">
              <input type="image" tabindex="25" src="../images/new.png" alt="n" id='btnNew'/>
            </div></td>
            <td width="11%" ><div align="center">
              <input name="image" type="image" class="mouseover" tabindex="26" src="../images/view.png" alt="s" id="btnView" />
            </div></td>
            <td width="11%"><div align="center">
              <input type="image" tabindex="27" src="../images/save.png" alt="p"  class="mouseover" id='btnSave'/>
            </div></td>
            <td width="11%"><div align="center">
              <input type="image" tabindex="28" src="../images/report.png " alt="c"  class="mouseover"  id="btnPrint"/>
            </div></td>
            <td width="11%"><div align="center">
              <a href="styleratioplplugin.php"><input type="image" src="../images/back.png" class="noborderforlink"/></a>
            </div></td>
            <td width="21%"><a href="<?php echo $backwardseperator?>main.php"><img src="../images/close.png" alt="c"  class="mouseover noborderforlink"  /></a></td>
          </tr>
        </table></td>
      </tr>
      
	</table>
    
 </td>
  </tr>
 
</table>
</body>
<script src="shipmentpackinglist.js" type="text/javascript"></script>
</html>