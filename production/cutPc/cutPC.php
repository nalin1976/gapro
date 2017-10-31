<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cut PC's Transfer In Note</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cutPC.js" type="text/javascript"></script>

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
<?php 
$id = $_GET["id"];
$year = $_GET["intYear"];
$serial = $_GET["inputSerialNumber"];
?>
</head>

<body <?php if($id!=0){?>onload="loadInputFrom(<?php echo $year; echo "," ; echo $serial;?>)" <?php }?> ><?php
	include "../../Connector.php";	
?>
 <form name="frmCutPcTrnsfIn" id="frmCutPcTrnsfIn">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
  <td height="3"></td>
  </tr>
  <tr>
    <td>
	<table width ="850" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
		<tr>
     		 <td height="24"class="mainHeading"> Cut PC's Transfer In Note </td>
		</tr>
         <tr>
         <td>
          <table width="100%" border="0">
			<tr><td height="17"><table width="100%" border="0" class="main_border_line">
			  <tr>
			  <td width="20%"></td>
			  <td width="40%"></td>
			  <td width="15%"></td>
			  <td width="25%"></td>
			  </tr>
			  <tr>
			  <?php
				$SQL = "SELECT dblCutGPTransferIN FROM syscontrol";
				$result = $db->RunQuery($SQL);
				$row = mysql_fetch_array($result);
				
			  ?>
			  <td class="normalfnt">&nbsp;Tranfer In No</td>
			  <td><input type="text" name="cboTransferin" id="cboTransferin" class="txtbox"  size="16px" readonly=""/><input type="text"  name="cboTransferinYear" id="cboTransferinYear" class="txtbox" style="width:40px" readonly=""/>
              </td>
			  <td class="normalfnt"></td>
			  <td>
               </td>
			  </tr>
			  </table>
			</td></tr>
            <tr>
              <td height="17"><table width="100%" border="0" class="main_border_line">
			  <tr>
			  <td width="20%"></td>
			  <td width="40%"></td>
			  <td width="15%"></td>
			  <td width="25%"></td>
			  </tr>
			  
                <tr>
                  <td class="normalfnt">&nbsp;To Factory</td>
                  <td colspan="3"><select name="cboFactory"  id="cboFactory" class="txtbox" style="width:535px" onchange="loadData1();" tabindex="1" disabled="disabled">
                      <?php
						$SQL = "SELECT	intCompanyID, strName, strCity FROM companies WHERE intManufacturing=1 ORDER BY strName ASC";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
						if($_SESSION["FactoryID"]==$row["intCompanyID"]){
							echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\" >" . $row["strName"] ." - ".$row["strCity"]. "</option>";
							}
							else{
							echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ".$row["strCity"]. "</option>";
							}
						}
					?>
                    </select> </td>
                </tr>
			  <tr>
			  <?php
				$SQL = "SELECT dblCutGPTransferIN FROM syscontrol";
				$result = $db->RunQuery($SQL);
				$row = mysql_fetch_array($result);
				
			  ?>
			  <td class="normalfnt">&nbsp;Date</td>
			  <?php
			  $date=date("d/m/Y");
			  
			  ?>
			  <td><input name="txtCutDate" type="text" class="txtbox" id="txtCutDate" style="width:160px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" tabindex="3" value="<?php echo $date ?>"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
			  <td class="normalfnt"></td>
			  <td></td>
			  </tr>
                <tr>
                  <td class="normalfnt">&nbsp;Gate Pass No</td>
	  
                  <td colspan="3"><select name="cboGPNo" id="cboGPNo" class="txtbox" style="width:533px" onchange="getGatePassDetails()" tabindex="4">
				  
				  <?php
/*$SQL = "SELECT * 
		 FROM productiongpheader 
		 join productiongpdetail on 
		 productiongpheader.intGPnumber=productiongpdetail.intGPnumber
		 where productiongpheader.intTofactory='".$_SESSION["FactoryID"]."' AND dblBalQty != 0 GROUP BY productiongpheader.intGPnumber order by intTofactory asc";
		 
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intGPnumber"] ."\">" .$row["intYear"] ."/".$row["intGPnumber"]."</option>";
						}*/
					?>
				  
                    </select>
                    
<input type="text" name="cboTransferin" id="cboTransferin" class="txtbox"  size="16px" readonly="" style="display:none"/><input type="text"  name="cboTransferinYear" id="cboTransferinYear" class="txtbox" style="width:40px; display:none" readonly=""/>    

<input type="text" name="cboTransIn" id="cboTransIn" class="txtbox" style="width:160px; display:none" readonly="" value="" tabindex="2">                 </td>
                </tr>
			
			  <tr>
			  <td class="normalfnt">&nbsp;Gate Pass Date</td>
			  <td><select name="cboGpDate" disabled="disabled" id="cboGpDate" class="txtbox" style="width:147px">
                      <?php
						$SQL = "SELECT	* FROM productiongpheader";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							$GPNoteDate = $row["dtmDate"];
							$AppGPNoteDate = explode('-',$GPNoteDate);
							$GPNoteDate = $AppGPNoteDate[2]."/".$AppGPNoteDate[1]."/".$AppGPNoteDate[0];
						
							echo "<option value=\"" . $row["dtmDate"] ."\">" . $GPNoteDate . "</option>";
						}
					?>
                    </select>
					<input type="hidden" name="txtYear" id="txtYear" /><input type="hidden" name="txtUser" id="txtUser" value="<?php echo $_SESSION["UserID"] ?>" />
                    
                    <input type="text" name="txtGpNoteNo" readonly="" id="txtGpNoteNo" class="txtbox" style="width:160px; display:none" tabindex="5"></td>
			  <td class="normalfnt"></td>
			  <td></td>
			  </tr>
			  <tr>
			  <td class="normalfnt">&nbsp;From Factory</td>
			  <td colspan="3"><select name="cboFromFactory" disabled="disabled"  id="cboFromFactory" class="txtbox" style="width:533px">
                      <?php
						$SQL = "SELECT	intCompanyID,strName,strCity FROM companies ORDER BY strName ASC";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ".$row["strCity"]. "</option>";
						}
					 ?>
                    </select> </td>
			  </tr>
			  
			  
              </table></td>
            </tr>
            <tr>
              <td height="165"><table width="100%%" height="165" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="100%"><table width="100%" border="0" class="main_border_line">
                        <tr>
                          <td colspan="3"><div id="divcons" style="overflow:scroll; height:350px; width:850px;">
							<!-- Populating Table Grid with Events [start]-->
                              <table width="100%" cellpadding="0" cellspacing="1" id="tblevents" >
                                <tr>
                                  <td width="14%" height="25" class="grid_header">PO No</td>
                                  <td width="17%" height="25" class="grid_header">Style</td>
                                  <td width="9%" class="grid_header">Cut No</td>
                                  <td width="8%" class="grid_header">Size</td>
                                  <td width="11%" class="grid_header">Bundle No</td>
                                  <td width="7%" class="grid_header">GP PC's</td>
                                   <td width="7%" class="grid_header">Balance Qty</td>
                                  <td width="7%" class="grid_header">Recieved</td>
                                  <td width="3%" class="grid_header"><input name="checkbox" type="checkbox" id="chkCheckAll" onclick="checkAll(this);" /></td>
                                  <td width="10%" class="grid_header">Remarks</td>
								  <td width="15%" class="grid_header">Color</td>
                                 <!-- <td style="display:none" width="1%" class="grid_header">Cut Bundle Serial</td>
                                  <td style="display:none" width="1%" class="grid_header">Bundle No</td>
                                  <td style="display:none" width="1%" class="grid_header">Style</td>-->
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
                  
                    </table></td>
                  </tr>
                  <tr >
                    <td ><table width="100%" border="0" class="tableFooter">
                        <tr>
                          <td class="normalfntMid">
						  <img  src="../../images/new.png" alt="New" name="New" id="butNew" tabindex="9" onclick="clearform();" class="mouseover"/>
						  <img src="../../images/save.png" alt="Save" id="butSave" name="butSave" class="mouseover" onclick="SaveEventTemplates();" tabindex="6"/>
						  <a href="../../main.php"><img src="../../images/close.png" alt="close"   border="0" class="mouseover" id="butClose" name="butClose"  tabindex="7"/></a></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
			
          </table>
		</td>
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
