<?php
	session_start();
	include("../../../Connector.php");
	$backwardseperator = "../../../";
	$orderno=$_GET["orderno"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Commercial Invoice</title>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<script src="orderspec.js"></script>


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
<link type="text/css" href="../../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        
		<script type="text/javascript" src="../../../js/jquery-1.4.4.min.js"></script>
		<link href="../../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../../../js/jquery-ui-1.8.9.custom.min.js"></script>
		<script src="jquery.fixedheader.js" type="text/javascript"></script>
		<script src="pl_plugin_search.js" type="text/javascript"></script>
		
        
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
	
</head>

<body><!-- setDefaultDate-->
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include $backwardseperator.'Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">Order Specification</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td height="300">
    <div  id="tabs" >
			<ul><li><a href="#tabs-1" onclick="">Header</a></li>
                <li><a href="#tabs-2" onclick="getInvoiceDetail();">Style Ratio</a></li>
				
			</ul>
			
            <div id="tabs-1">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        
        
      </tr>
      <tr>
        <td height="250" colspan="2" class="normalfnt">
		<div id="divcons1"  style="width:100%px;">
		  <table width="108%"  id="tblGen">
		    <tr>
		      <td><table width="100%" height="26" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		        <tr>
		          <td width="2%">&nbsp;</td>
		          <td width="12%">Select Order #</td>
		          <td width="21%"><select name="cboInvoiceNo"  class="txtbox" id="cboInvoiceNo" style="width:160px" onchange="loadDetails(this);" >
		            <option value=""></option>
		            <?php 
                   $sqlInvoice="SELECT intOrderId,strOrder_No FROM orderspec order by strOrder_No desc";
                   $resultInvoice=$db->RunQuery($sqlInvoice);
						 while($row=mysql_fetch_array( $resultInvoice)) { ?>
		            <option value="<?php echo $row['intOrderId'];?>"><?php echo $row['strOrder_No'];?></option>
		            <?php }?>
		            </select></td>
		          <td width="12%">Order # <span class="compulsory">*</span></td>
		          <td width="21%"><input name="txtOrderNo"  type="text" class="txtbox" id="txtOrderNo" maxlength="15" style="width:158px"  /></td>
		          <td width="12%">Style # <span class="compulsory">*</span></td>
		          <td width="20%"><input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo"  style="width:158px" maxlength="25" /></td>
		          </tr>
		        </table></td>
		      </tr>
		    <tr>
		      <td height="65"><table width="100%" height="26" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>Style Description</td>
		          <td><input name="txtStyleDesc"  type="text" class="txtbox" id="txtStyleDesc"  style="width:158px" maxlength="50" /></td>
		          <td>WFX Id <span class="compulsory">*</span></td>
		          <td><input name="txtunitPrice"  type="text" class="txtbox" id="txtunitPrice"  style="width:158px" maxlength="40" /></td>
		          <td>Item</td>
		          <td><input name="txtItem"  type="text" class="txtbox" id="txtItem"  style="width:158px" maxlength="30" /></td>
		          </tr>
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>Gender </td>
		          <td>
                  <select name="txtGender" class="txtbox" id="txtGender" style="width:160px" >
		            <option value=""></option>
		            <?php 
                   $sqlInvoice1="SELECT intId,strGender
								 FROM gender Order by strGender";
                   $resultInvoice1=$db->RunQuery($sqlInvoice1);
						 while($row1=mysql_fetch_array( $resultInvoice1)) { ?>
		            <option value="<?php echo $row1['intId'];?>"><?php echo $row1['strGender'];?></option>
		            <?php }?>
		            </select>
                  </td>
		          <td>Material No</td>
		          <td><input name="txtMateNo"  type="text" class="txtbox" id="txtMateNo"  style="width:158px" maxlength="50" /></td>
		          <td>Construction Type</td>
		          <td><input name="txtConstructionType"  type="text" class="txtbox" id="txtConstructionType"  style="width:158px" maxlength="30" /></td>
		          </tr>
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>Season</td>
		          <td><input name="txtSeason"  type="text" class="txtbox" id="txtSeason"  style="width:158px" maxlength="30" /></td>
		          <td>Buyer</td>
		          <td><select name="txtBuyer" class="txtbox" id="txtBuyer" style="width:160px" >
		            <option value=""></option>
		            <?php 
                   $sqlInvoice1="SELECT buyers.strBuyerID,
								 CONCAT(buyers.strName,' - ',buyers.strBuyerCode) AS Buyer1
								 FROM buyers Order by strName";
                   $resultInvoice1=$db->RunQuery($sqlInvoice1);
						 while($row1=mysql_fetch_array( $resultInvoice1)) { ?>
		            <option value="<?php echo $row1['strBuyerID'];?>"><?php echo $row1['Buyer1'];?></option>
		            <?php }?>
		            </select></td>
		          <td>Price Unit<span class="compulsory">&nbsp;*</span></td>
                  
		          <td><select name="cboUmoQty1" type="text"  id="cboUmoQty1" class="txtbox" style="width:50px" >
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
		          <td width="2%"></td>
		          <td width="12%"></td>
		          <td width="21%"></td>
		          <td width="12%"></td>
		          <td width="21%"></td>
		          <td width="12%"></td>
		          <td width="20%"></td>
		          </tr>
		        </table></td>
		      </tr>
		    <tr>
		      <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		        <tr>
		          <td>&nbsp;</td>
		          <td height="25">Division/ Brand </td>
		          <td><input name="txtDivision" type="text" class="txtbox" id="txtDivision"  style="width:158px" maxlength="30" /></td>
		          <td>Item # </td>
		          <td><input name="txtItemNo" type="text" class="txtbox" id="txtItemNo"  style="width:158px" maxlength="30" /></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
		        <tr>
		          <td width="2%">&nbsp;</td>
		          <td width="12%" height="25">Sorting Type</td>
		          <td width="21%"><input name="txtSortingType" type="text" class="txtbox" id="txtSortingType"  style="width:158px" maxlength="30" /></td>
		          <td width="12%">Wash Code </td>
		          <td width="21%"><input name="txtWashCode"  type="text" class="txtbox" id="txtWashCode"  style="width:158px" maxlength="30" /></td>
		          <td width="12%">&nbsp;</td>
		          <td width="20%">&nbsp;</td>
                  
		          </tr>
                   <tr>
		          <td width="2%">&nbsp;</td>
		          <td width="12%" height="25">Garment Type</td>
		          <td width="21%"><input name="txtGarment" type="text" class="txtbox" id="txtGarment"  style="width:158px" maxlength="30" /></td>
                   <td width="12%" height="25">Quality</td>
		          <td width="21%"><input name="txtQuality" type="text" class="txtbox" id="txtQuality"  style="width:158px" maxlength="30" /></td>
		         
                  
		          </tr>
		        </table></td>
		      </tr>
		    <tr>
		      <td></td>
		      </tr>
		    <tr>
		      <td height="15" style="display:none">&nbsp;</td>
		      </tr>
		    </table>
		</div>		</td>
        </tr>
		 <tr bgcolor="#D6E7F5">
		
		<td><table width="870" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="91" height="29">&nbsp;</td>
        <td width="233"></td>
        <td width="96"><img src="../../../images/new.png" alt="new"  name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="clearForm(); "/></td>
        <td width="9">&nbsp;</td>
        <td width="84"><img src="../../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="saveDetails();" /></td>
        <td width="8">&nbsp;</td>
        <td width="173"><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0" class="mouseover"  /></a></td>
        <td width="91">&nbsp;</td>
		<td width="113">&nbsp;</td>
      </tr>
    </table></td>
		</tr>
		
		
    </table></div>
    <div id="tabs-2" style="width:100%">
    <table align="center" width="900" border="0" cellspacing="0" cellpadding="0" class="normalfnt bcgl1">
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="48%">&nbsp;</td>
        <td width="49%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:center"><div id="divcons"  style="overflow:scroll; height:300px; width:900px; background-color:#FFF; text-align:center">
          <table width="600"  cellpadding="0" cellspacing="1" style="background-color:#CCCCFF" id="tblSizes" align="center">
            <tr bgcolor="#498CC2" class="normaltxtmidb2">
              <td width="3%" >&nbsp;</td>
              <td width="8%" height="20" >Size</td>
              <td width="9%" >Color</td>
              <td width="9%" >Color-Code</td>
              <td width="9%" >Qty</td>
              <td width="13%" >Price  </td>
              <td width="19%" >MRP  </td>
              <td width="7%" >SKU  </td>
              <td width="13%" >Fabric  </td>
              <td width="12%" >Description</td>
              <td width="7%" >PliNo</td>
              <td width="7%" >Pre Pack No</td>
              <td width="7%" >Pre Pack Type</td>
              </tr>           
            </table>
        </div></td>
        <td>&nbsp;</td>
      </tr>
        <tr>
          <td height="31">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><div align="center"><img src="../../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="saveDetailData();" />  &nbsp;&nbsp;&nbsp;</div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </div>
    
    </div>
    
    
    
    </div>
			

      </div>
		</td>
	  </tr>
  
</table>
<?php if($orderno!=''){?>
<script type="text/javascript">
$('#cboInvoiceNo').val('<?php echo $orderno;?>');
	loadDetails();
</script>
<?php }?>
</body>

</html>