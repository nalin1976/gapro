<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
	  $comID = $_POST["cboFactory"];
	  $styleNo = $_POST["cboStyleNo"];
	  $styleID = $_POST["cboOrderNo"];
	  $dfrom = $_POST["txtDfrom"];
	  $dto = $_POST["txtDto"];
	  $intyear = $_POST["cboYear"];
	  $style=$_POST['cboStyle'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gapro : Washing - Sub Contractor Receive List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>

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
<script language="javascript" type="text/javascript">

function showReport()
{
	var fFac=document.getElementById('cboFactory').value.trim();
	var po=document.getElementById('cboOrderNo').value.trim();
	var style=document.getElementById('cboStyle').value.trim();
	var dFrm=document.getElementById('txtDfrom').value.trim();
	var dTo=document.getElementById('txtDto').value.trim();
	
	window.open("rptWashReceiveSummaryReport.php?fFac="+fFac+"&po="+po+"&style="+style+"&dFrm="+dFrm+"&dTo="+dTo,"WRS");
}
function searchFrom()
{
	$("#frmWRS").submit();
}

function selectStyle(obj){
	var path="subContractRcvdList_xml.php?req=getStyle&po="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('cboStyle').value=htmlobj.responseText;
}

function selectPo(obj){
	var path="subContractRcvdList_xml.php?req=getPo&style="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('cboOrderNo').value=htmlobj.responseText;
}

function showGP(obj){
	var AOD=obj.parentNode.parentNode.childNodes[1].innerHTML;
	window.open('../subcontractorRcvdList/rptSubContractorTransferIn.php?req='+AOD,'new');
}
</script>
</head>

<body>
<form name="frmWRS" method="post" id="frmWRS">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php include $backwardseperator.'Header.php'?></td>
    </tr>
    <?php
	include "../../Connector.php";	
	include("class.subContractRcvdList.php");
	$wrsr=new washReceiveSummary();
?>
    <tr>
      <td><table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="800" border="0" cellspacing="0" cellpadding="3" align="center" class="tableFooter">
            <tr>
              <td width="800"><table width="800" border="0" cellspacing="0" cellpadding="0" class="normalfnt" align="center">
                <tr>
                  <td colspan="4" class="mainHeading" height="26">Sub Contract Receive List</td>
                  </tr>
                <tr>
                  <td width="130">&nbsp;</td>
                  <td width="164">&nbsp;</td>
                  <td width="116">&nbsp;</td>
                  <td width="290">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" colspan="4"><table width="550" border="0" cellspacing="0" cellpadding="2" class="bcgl1" align="center">

                    <tr class="normalfnt">
                      <td width="136">Sub Contractor</td>
                      <td width="210" colspan="3"><select name="cboFactory" id="cboFactory" style="width:355px;">
                        <option value=""></option>
                        <?php 
						$result = $wrsr->getFromFactories();
						while($row = mysql_fetch_assoc($result))
						{
							if($comID==$row["intCompanyID"])
								echo "<option value=\"".$row['intCompanyID']."\" selected=\"selected\">" . $row["strName"] . "</option>";
							else
								echo "<option value=\"".$row['intCompanyID']."\">" . $row["strName"] . "</option>";
						}
							
					  ?>
                        </select></td>
                    </tr>
                    <tr class="normalfnt">
                      <td>PO No</td>
                      <td><select name="cboOrderNo" id="cboOrderNo" style="width:122px;" onChange="selectStyle(this)">
                         <option value="" selected="selected">Select One</option>
                        <?php 
					  	$sql = "";
							
						$result = $wrsr->getPoNumbers($_SESSION['FactoryID']);
						while($row = mysql_fetch_assoc($result))
						{
							if($styleID==$row["intStyleId"])
								echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;
							else		
								echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
						}
							
					  ?>
                      </select></td>
                      <td>Style</td>
                      <td><select name="cboStyle" id="cboStyle" style="width:121px;" tabindex="2" onChange="selectPo(this)">
                                        <option value="" selected="selected">Select One</option>
                  <?php 

			$result = $wrsr->getPoNumbers($_SESSION['FactoryID']);		
			while($row = mysql_fetch_array($result))
			{
			
							if($style==$row["strStyle"])
								echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . trim($row["strStyle"]) ."</option>" ;
							else		
								echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
			}
		?>
                                      </select></td>
                    </tr>
                    <tr class="normalfnt">
                      <td>Date From</td>
                      <td><input type="text" name="txtDfrom" id="txtDfrom" style="width:120px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $dfrom; ?>" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                      <td>Date To</td>
                      <td><input type="text" name="txtDto" id="txtDto" style="width:121px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $dto; ?>" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                    </tr>
                    <tr class="normalfnt">
                      <td colspan="4"></td>
                      </tr>
                    
                    <tr class="normalfnt">
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><img src="../../images/search.png" width="80" height="24" onClick="searchFrom();"></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4">
                  <table width="830" border="0" cellpadding="2" cellspacing="0" class="bcgl1">
                    <tr><td width="830">
                  <div id="divwash" style="overflow:scroll; width:820; height:300px;">
                    <table width="813" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                      	<td width="76" class="grid_header">AOD No</td>
                      	<td width="91" class="grid_header" height="20"> PO No</td>
                        <td width="102" class="grid_header" height="20">Style No</td>
                        <td width="127" class="grid_header">Style</td>
                        <td width="137" class="grid_header">Color</td>
                        <td width="84" class="grid_header">Order Qty</td>
                        <td width="87" class="grid_header"><strong>Sent Qty</strong></td>
                        <td width="109" class="grid_header"><strong>Rceive Note</strong></td>
                      </tr>
                      <?php 
	
						$result = $wrsr->getMainDetails($_SESSION['FactoryID'],$chk=1,$styleID,$style,$dfrom,$dto,$comID);
										
							$i=0;						
					  while($row=mysql_fetch_assoc($result)){
						$rcvd=0;
						$totGp=0;
						
						if($i%2 == 0)
								$cls = 'grid_raw2';
						else
								$cls = 'grid_raw';
					?>
                    <tr  height="20">
                    	<td width="76" class='<?php echo $cls;?>' style="text-align:left;"><?php echo $row['strGatePassNo'];?></td>
                        <td width="91" class='<?php echo $cls;?>' style="text-align:left;">&nbsp;<?php echo $row['strOrderNo'];?></td>
                        <td width="102" class='<?php echo $cls;?>' style="text-align:left;">&nbsp;<?php echo $row['strStyle'];?></td>
                        <td width="127" class='<?php echo $cls;?>' style="text-align:left;">&nbsp;<?php echo $row['strDescription'];?></td>
                        <td width="137" class='<?php echo $cls;?>' style="text-align:left;">&nbsp;<?php echo $row['strColor'];?></td>
                        <td width="84" class='<?php echo $cls;?>' style="text-align:right;"><?php echo $row['intQty'];?>&nbsp;</td>
                        <td width="87" class='<?php echo $cls;?>' style="text-align:right;"><?php echo $row['dblQty'];?>&nbsp;</td>
                        <td width="109" class='<?php echo $cls;?>' style="text-align:right;"><img src="../../images/report.png" onClick="showGP(this);" /></td>
                       
                    </tr>
            <?php $i++;
			}?>
                    </table>
                  </div></td></tr></table></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><img src="../../images/report.png" onClick="showReport();" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
