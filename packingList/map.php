<?php
$backwardseperator = "../";
session_start();
$facId =  $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Packing List</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="packinglist-java.js" type="text/javascript"></script>
<script src="map.js" type="text/javascript"></script>
<script type="text/javascript" >
	function pageSubmit()
	{
		document.getElementById("frmbom").submit();
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
</head>

<body>

<?php
	include "../Connector.php";	
	$mapId = $_GET["mapId"];
	if($mapId!='')
	{
		$sql = "select * from packinglist_map_header where id=$mapId";
		$result = $db->open($sql);
		while($row=mysql_fetch_array($result))
		{
			$buyerName = $row["buyerName"];
		}
	}
	
?>
<form name="frmbom" id="frmbom" action="Details/grndetails.php" method="post" >
<table width="950" height="246" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../Header.php'; ?></td>
</tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td height="36" colspan="8"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="4%" height="24" bgcolor="#498CC2" >&nbsp;</td>
            <td width="8%" bgcolor="#498CC2" class="normalfnt">&nbsp;</td>
            <td width="3%" bgcolor="#498CC2" class="normalfnt">&nbsp;</td>
            <td width="6%" bgcolor="#498CC2" class="normalfntSM">&nbsp;</td>
            <td width="16%" bgcolor="#498CC2" class="TitleN2white">Excel Data Map</td>
            <td width="2%" bgcolor="#498CC2" class="normalfntSM">&nbsp;</td>
            <td width="17%" bgcolor="#498CC2" class="normalfnt">&nbsp;</td>
            <td width="9%" bgcolor="#498CC2" class="normalfnt">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="19%" class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Record Id </td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt"><input value="<?php echo $mapId;?>" name="txtId" type="text" class="txtbox" id="txtId" size="10" onfocus="this.blur();" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td width="4%" class="normalfnt">&nbsp;</td>
        <td width="11%" class="normalfnt">&nbsp;</td>
        <td width="15%" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Buyer</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:160px" onchange="addBuyerToTextBox(this);" >
          <option value="" ></option>
          <?php
		 
			$SQL = "SELECT 
					packinglist_map_header.id,
					packinglist_map_header.buyerName
					FROM packinglist_map_header
					WHERE
					packinglist_map_header.intCompany =  '$facId'
					";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				if($row["buyerName"]==$buyerName)
					echo "<option selected=\"selected\" value=\"". $row["id"] ."\">" . $row["buyerName"] ."</option>" ;
				else
					echo "<option value=\"". $row["id"] ."\">" . $row["buyerName"] ."</option>" ;
			}
			?>
        </select></td>
        <td class="normalfnt"><input value="<?php echo $buyerName ?>" name="txtBuyer" type="text" class="txtbox" id="txtBuyer" size="25" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td width="12%" class="normalfnt">Excel Template </td>
        <td width="4%" class="normalfnt">&nbsp;</td>
        <td width="17%" class="normalfnt"><input name="fileExcel" type="file" class="txtbox" id="fileExcel" size="20" /></td>
        <td width="18%" class="normalfnth2">(uploaded)</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnth2">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
    </table>      </td>
  </tr>
  <tr><td>
  <table width="100%" border="0" class="bcgl1" id="tblType">
  	<?php 
		$sqlMain = "select * from packinglist_map_details where id=$mapId";
		$resultMain = $db->open($sqlMain);
		//echo $sql;
		while($rowMain=mysql_fetch_array($resultMain))
		{
			$mapType = $rowMain["mapType"];
			$columnIndex = $rowMain["columnIndex"];
			$rowId = $rowMain["row"];
	?>
      <tr>
        <td width="5%" class="normalfnt">&nbsp;</td>
        <td width="5%" class="normalfnt">&nbsp;</td>
        <td width="5%" class="normalfnt">&nbsp;</td>
        <td width="4%" class="normalfnt"><img src="../images/del.png" alt="del" name="butDelete" id="butDelete" onclick="deleteRow(this);"/></td>
        <td width="14%" class="normalfnt">Map Type </td>
        <td width="22%" class="normalfnt"><select name="cboType" class="txtbox" id="cboType" style="width:200px" onchange="addNewRow(this)" >
          <option value="" ></option>
          <?php
			$SQL = "SELECT * FROM packinglist_map_types;";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				if($row["type"]==$mapType)
					echo "<option selected=\"\" value=\"". $row["type"] ."\">" . $row["description"] ."</option>" ;
				else
					echo "<option value=\"". $row["type"] ."\">" . $row["description"] ."</option>" ;
			}
			?>
        </select></td>
        <td width="4%" class="normalfnt" >Cell</td>
        <td width="6%" class="normalfnt" ><select name="cboColumnId" class="txtbox" id="cboColumnId" style="width:50px" >
          <option value="" ></option>
          <?php
			$SQL = "SELECT * FROM packinglist_excelrange;";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
			if($row["no"]==$columnIndex)
				echo "<option selected=\"selected\" value=\"". $row["no"] ."\">" . $row["code"] ."</option>" ;
			else
				echo "<option value=\"". $row["no"] ."\">" . $row["code"] ."</option>" ;
			}
			?>
        </select></td>
        <td width="6%" class="normalfnt" ><input value="<?php echo $rowId;?>" name="txtRowId" type="text" class="txtbox" id="txtRowId" size="4" maxlength="4" /></td>
        <td width="15%" class="normalfnt" >&nbsp;</td>
        <td width="14%" class="normalfnt">&nbsp;</td>
      </tr>
	 <?
	 }
	 ?>
    </table>
  </td></tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="14%" height="29">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="9%"><img src="../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="newPage();"/></td>
        <td width="10%"><img  border="0" src="../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="saveMap();" /></td>
        <td width="14%"><a href="../main.php"><img src="../images/close.png" name="butClose" width="97" height="24" border="0" class="mouseover" id="butClose" /></a></td>
        <td width="10%">&nbsp;</td>
        <td width="23%">&nbsp;</td>
      </tr>
    </table></td></tr>
</table>
</form>
</body>
</html>


