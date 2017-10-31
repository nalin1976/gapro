<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Production Line Output</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cutPCNewOutPutEntry.js?n=1" type="text/javascript"></script>

<script type="text/javascript">
//----------------------hem-------------------------------------------------------------------
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
</head>

<?php 
$id = $_GET["id"];
$year = $_GET["intYear"];
$serial = $_GET["OutputSerialNumber"];
?>

<body  <?php if($id!=0){?>onload="loadInputFrom(<?php echo $year; echo "," ; echo $serial;?>)" <?php }?> >
<?php
	include "../../Connector.php";	
?>
<form name="frmProductionOutput" id="frmProductionOutput" method="post" action="">
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
   <tr>
		<td><?php include $backwardseperator."Header.php";?></td>
   </tr>
   <tr>
     <td>
     	<table width="850" border="0" cellpadding="0" cellspacing="1" align="center" bgcolor="#FFFFFF" class="tableBorder">
        <tr>
         <td height="24"class="mainHeading">Line Output</td>
        </tr>
         <tr>
         <td>
          	<table width="100%" border="0" cellpadding="0" cellspacing="1" align="center" bgcolor="#FFFFFF">
            <tr>
              <td>
               <table width="100%" border="0" cellpadding="0" cellspacing="1">
                <td ><table width="100%" border="0" class="main_border_line" cellpadding="0" cellspacing="1">
                  <tr>
                    <td width="4%"></td>
                    <td width="15%"></td>
                    <td width="35%"></td>
                    <td width="10%"></td>
                    <td width="36%"></td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;Line Out No </td>
                    <td><input type="text" name="txtSearchLineOutNo" id="txtSearchLineOutNo" value="<?php echo $serial?>"  size="16px" readonly="" />&nbsp;<input type="text" name="txtSearchLineOutYear" id="txtSearchLineOutYear" value="<?php echo $year?>" style="width:40px" readonly=""/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;Factory</td>
                    <td colspan="3"><select name="cboFactory"  id="cboFactory" class="txtbox" style="width:566px"  onchange="loadPONo();" disabled="disabled">
                        <?php
						$SQL = "SELECT	intCompanyID,strName,strCity FROM companies  WHERE intManufacturing=1 ORDER BY strName ASC";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
						if($_SESSION["FactoryID"]==$row["intCompanyID"]){
							echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\" >" . $row["strName"] ." - ".$row["strCity"] . "</option>";
							}
							else{
							echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ".$row["strCity"] . "</option>";
							}
						}
					?>
                      </select>                    </td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;Order No</td>
                    <td><span class="normalfnt">
                      <select name="cboPoNo" id="cboPoNo" class="txtbox" style="width:200px"  onchange="loadLineNo();">
                        <?php
/*$sql = "SELECT distinct productionlineinputheader.intStyleId, orders.strOrderNo 
FROM productionlineinputheader
inner JOIN orders ON productionlineinputheader.intStyleId = orders.intStyleId
inner JOIN productionbundleheader ON productionlineinputheader.strCutNo = productionbundleheader.strCutNo
WHERE productionlineinputheader.intFactory = '".$_SESSION["FactoryID"]."'
GROUP BY  productionlineinputheader.intStyleId order by orders.strOrderNo ASC";*/
$sql = "SELECT distinct PLIH.intStyleId, O.strOrderNo 
FROM productionlineinputheader PLIH
inner join productionlineindetail PLID on PLIH.intLineInputSerial=PLID.intLineInputSerial and PLIH.intLineInputYear=PLID.intLineInputYear
inner JOIN orders O ON PLIH.intStyleId = O.intStyleId
WHERE PLIH.intFactory = '".$_SESSION["FactoryID"]."'
and PLID.dblBalQty >0
order by O.strOrderNo ASC";
$result = $db->RunQuery($sql);

echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
while($row = mysql_fetch_array($result))
{					
echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
}
?>
                      </select>
                    </span></td>
                    <?php
			  $date=date("d/m/Y");
			  
			  ?>
                    <td class="normalfnt">&nbsp;Date</td>
                    <td><input name="txtDate" type="text" tabindex="9" class="txtbox" id="txtDate" style="width:180px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $date ?>"/>
                        <input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
                        <input type="hidden" name="txtYear" id="txtYear" value="<?php echo date(Y); ?>" />
                      <input type="hidden" name="txtUser" id="txtUser" value="<?php echo $_SESSION["UserID"] ?>" /></td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;Line No</td>
                    <td><select name="cboLineNo" id="cboLineNo" class="txtbox" style="width:200px"  onchange="loadCutNo();">
<?php
$SQL = "SELECT 
productionlineinputheader.strTeamNo, 
plan_teams.strTeam 
FROM productionlineinputheader 
inner join plan_teams ON productionlineinputheader.strTeamNo=plan_teams.intTeamNo
WHERE productionlineinputheader.intFactory = '".$_SESSION["FactoryID"]."' group by productionlineinputheader.strTeamNo 
order by productionlineinputheader.strTeamNo ASC";
$result = $db->RunQuery($SQL1);
while($row = mysql_fetch_array($result))
{
	echo "<option value=\"" . $row["strTeamNo"] ."\">" . $row["strTeam"] . "</option>";
}
?>
                    </select></td>
                    <td class="normalfnt">&nbsp;Start</td>
                    <td><input name="cboStartDate" id="cboStartDate" class="txtbox" style="width:180px" disabled="disabled"/>                    </td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;Cut No</td>
                    <td><select name="cboCutNo" id="cboCutNo" class="txtbox" style="width:200px"  onchange="loadBundleNo();">
                      </select>
                        <input type="hidden" name="txtPattern" id="txtPattern" value="" /></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;Bundle No </td>
                    <td><select name="cboBundleNo" id="cboBundleNo" class="txtbox" style="width:200px" onchange="LoadGrid();">
                    </select></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td></td>
                  </tr>
                </table></td>
              </tr>
           
            <tr>
              <td height="165"><table width="98%" height="165" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%"><table width="100%" border="0" class="main_border_line">
                        <tr>
                          <td colspan="3"><div id="divcons" style="overflow:scroll; height:400px; width:850px;">
							<!-- Populating Table Grid with Events [start]-->
                              <table width="100%" cellpadding="0" cellspacing="1" id="tblevents" >
                                <tr class="">
                                  <td width="10%" height="25" class="grid_header">Cut No</td>
                                  <td width="10%" class="grid_header">Size</td>
                                  <td width="10%" class="grid_header">Bundle No</td>
                                  <td width="14%" class="grid_header">Range</td>
                                  <td width="10%" class="grid_header">Shade</td>
                                  <td width="6%" class="grid_header">Bal Qty</td>
                                  <td width="6%" class="grid_header">Output</td>
                                  <td width="5%" class="grid_header"><input name="checkbox" type="checkbox" id="chkCheckAll" onclick="checkAll(this);" /></td>
                                  <td width="1%" class="grid_header" style="display:none"></td>
								  <td width="12%" class="grid_header">Remark</td>
								  <td width="16%" class="grid_header">Color</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
              <tr>
              <td height="17"><table width="100%" border="0">
			  <tr>
			  <td colspan="5" class="normalfnt" align="right"></td>
			  </tr>
			  <tr>
			  <td width="10%" class="normalfnt" align="right"></td>
			  <td width="30%"></td>
			  <td width="25%"></td>
			  <td width="20%" class="normalfnt" align="right">All Bundles</td>
			  <td width="15%" class="normalfnt" align="right"><input type="text" name="txtBundles" id="txtBundles" class="txtbox" size="13px"  style="text-align:right" readonly="readonly" /></td>
			  </tr>
			  <tr>
			  <td width="10%" class="normalfnt" align="right"></td>
			  <td width="30%"></td>
			  <td width="25%"></td>
			  <td width="20%" class="normalfnt" align="right">Line Input Qty/Pcs</td>
			  <td width="15%" class="normalfnt" align="right"><input type="text" name="txtTotOutQty" id="txtTotOutQty" class="txtbox"  style="text-align:right" size="13px" readonly="readonly"></td>
			  </tr>
			  </table>			  </td>
			  </tr>
                  <tr >
                    <td ><table width="100%" border="0" class="tableFooter">
                        <tr>
                          <td  class="normalfntMid">
						  <img  src="../../images/new.png" alt="New" name="New" id="butNew" tabindex="9" onclick="clearform();" class="mouseover"/>	
						  <img src="../../images/save.png" alt="Save"  class="mouseover"  onclick="SaveOutputData();"/>
						  <a href="../../main.php"><img src="../../images/close.png" alt="close"   border="0" class="mouseover" /></a></td>
                          </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
          </table>
              </td>
            </tr>
            </table>
         </td>
         </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
