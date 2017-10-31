<?php 
	session_start();
 $backwardseperator = "../"; 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Stock Movement</title>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="itemStock.js" type="text/javascript"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
include "../Connector.php";
?>
<body>
<form id="frmStockMvItem" name="frmStockMvItem" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table cellpadding="0" cellspacing="0" align="center">
    	<tr><td height="10"></td></tr>
        <tr><td>
    	<table cellpadding="2" cellspacing="0" align="center" class="bcgl1"><tr><td>
    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td class="mainHeading"> Stock Movement</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
        <table width="500" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
          <tr>
            <td width="150">Main Category</td>
            <td width="350"><select name="cboMainCat" id="cboMainCat" style="width:285px;" onChange="getSubcategory();">
            <?php
						$intMainCat = $_POST["cboMainCat"];
							
						$SQL = 	"SELECT matmaincategory.intID, matmaincategory.strDescription FROM matmaincategory ";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							if($intMainCat==$row["intID"])
								echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
							else
								echo "<option value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;
						}
						
						?>
            </select>            </td>
          </tr>
          
          <tr>
            <td>Sub Category</td>
            <td><select name="cboSubcat" id="cboSubcat" style="width:285px;" onChange="getMatIemList();">
             <?php
						$intSubCatNo = $_POST["cboSubcat"];
							
						$SQL = 	"SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory  MSC
								WHERE MSC.intCatNo <>'' ";
								
						if($intMainCat!='')
							$SQL .= " AND MSC.intCatNo =  '$intMainCat'";
							
						$SQL .= " order by MSC.StrCatName ";
						
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($intSubCatNo==$row["intSubCatNo"])
							echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;
						}
						
						?>
            </select>            </td>
          </tr>
          <tr>
            <td>Material Like</td>
            <td><input type="text" name="txtmaterial" id="txtmaterial" style="width:284px;" onKeyPress="EnterSubmitLoadItem(event);"></td>
          </tr>
          <tr>
            <td>Material</td>
            <td><select name="cboMaterial" id="cboMaterial" style="width:285px;">
            <?php
					$intMatItem = $_POST["cboMaterial"];
						
					$SQL = 	"SELECT MIL.intItemSerial, MIL.strItemDescription 
							FROM matitemlist MIL  ";		
					
					$SQL .= " Order By strItemDescription";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					/*while($row = mysql_fetch_array($result))
					{
					if($intMatItem==$row["intItemSerial"])
						echo "<option selected=\"selected\" value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;								
					else
						echo "<option value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;
					}*/
						
					?>
            </select>            </td>
          </tr>
          
          <tr>
            <td>Color</td>
            <td><select name="cboColor" class="txtbox" id="cboColor" style="width:285px" >
                    <?php
					$strColor = $_POST["cboColor"];
						
					$SQL = 	"SELECT strColor FROM colors";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					if($strColor==$row["strColor"])
						echo "<option selected=\"selected\" value=\"". $row["strColor"] ."\">" . trim($row["strColor"]) ."</option>" ;								
					else
						echo "<option value=\"". $row["strColor"] ."\">" . trim($row["strColor"]) ."</option>" ;
					}
						
					?>
                      </select></td>
          </tr>
          <tr>
            <td>Size</td>
            <td><select name="cboSize" class="txtbox" id="cboSize" style="width:285px" >
						<?php
						$strSize = $_POST["cboSize"];
							
						$SQL = 	"SELECT strSize FROM sizes";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($strSize==$row["strSize"])
							echo "<option selected=\"selected\" value=\"". $row["strSize"] ."\">" . trim($row["strSize"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["strSize"] ."\">" . trim($row["strSize"]) ."</option>" ;
						}
							
						?>
						  </select></td>
          </tr>
          <tr>
            <td class="normalfnt">Order No </td>
                      <td><select name="cboStyle" class="txtbox" id="cboStyle" style="width:180px" onChange="GetScNo(this)" >
                        <?php
						$strStyleId = $_POST["cboStyle"];
							
						$SQL = 	"select O.intStyleId,O.strOrderNo from orders O
inner join specification S on O.intStyleId=S.intStyleId Order By strOrderNo";

						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($strStyleId==$row["intStyleId"])
							echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;
						}
							
						?>
                      </select>
                        <select name="cboSc" class="txtbox" id="cboSc" style="width:100px" onChange="GetStyleId(this)" >
                          <?php
						$ScNo = $_POST["cboSc"];
							
						$SQL = 	"select O.intStyleId,intSRNO from orders O
inner join specification S on O.intStyleId=S.intStyleId Order By intSRNO DESC";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($ScNo==$row["intStyleId"])
							echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["intSRNO"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intStyleId"] ."\">" . trim($row["intSRNO"]) ."</option>" ;
						}
							
						?>
                        </select>          </tr>
          <tr>
            <td>Store</td>
            <td><select name="cboStore" id="cboStore" style="width:285px;">
            <?php
						$intMainStores = $_POST["cboStore"];
							
						$SQL = 	"SELECT mainstores.strMainID, mainstores.strName FROM mainstores";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($intMainStores==$row["strMainID"])
							echo "<option selected=\"selected\" value=\"". $row["strMainID"] ."\">" . trim($row["strName"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["strMainID"] ."\">" . trim($row["strName"]) ."</option>" ;
						}
							
						?>
            </select>            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="98%" border="0" cellspacing="0" cellpadding="0" class="bcgl1" align="center" height="30">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
              <tr >
                <td width="145" height="20">Date From</td>
                <td width="121"><input  name="txtDfrom" type="text" class="txtbox" id="txtDfrom" style="width:80px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                <td width="83">Date To</td>
                <td width="139"><input  name="txtDto" type="text" class="txtbox" id="txtDto" style="width:80px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="240" border="0" cellspacing="0" cellpadding="0" align="center" >
          <tr>
            <td width="29"><input type="radio" name="rdoS" id="rbItem" value="rbStyle" checked="checked"></td>
            <td width="69" class="normalfnt">Item Wise</td>
            <td width="42"><input name="rdoS" type="radio" id="rdoStyleWise" value="with" /></td>
            <td width="100" class="normalfnt">Style Wise</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td ><table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFE1E1" class="bcgl1">
          <tr>
            <td align="center" >
			<img src="../images/new.png" width="96" height="24" onClick="clearPage();"><img src="../images/report.png" width="108" height="24" onClick="viewItemStockRpt();">
           <a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0"></a>		   </td>
          </tr>
        </table></td>
      </tr>
      <tr>
      	<td height="5"></td>
      </tr>
    </table></td></tr></table>
    </td></tr></table>
    </td>
  </tr>
</table>
</form>
</body>
</html>
