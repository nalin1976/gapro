<?php
session_start();
$backwardseperator = "../../";
$userId = $_SESSION["UserID"];
include "../lineInput/${backwardseperator}authentication.inc";

$pp_cancleLineInput =true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Production Line Input</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cutPCNewInputEntry.js?n=1" type="text/javascript"></script>

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
$serial = $_GET["inputSerialNumber"];
?>

<body  <?php if($id!=0){?>onload="loadInputFrom(<?php echo $year; echo "," ; echo $serial; echo "," ; echo $pp_cancleLineInput;?>)" <?php }?> >

<?php
	include "../../Connector.php";	
?>
<form name="frmLineInput" id="frmLineInput" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
   <tr>
		<td><?php include $backwardseperator."Header.php";?></td>
   </tr>
   <tr>
     <td>
     	<table width="850" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder" cellpadding="0" cellspacing="1">
        <tr>
         <td height="24"class="mainHeading">Line Input</td>
        </tr>
         <tr>
         <td>
          	<table width="100%" border="0" cellpadding="0" cellspacing="1" align="center" bgcolor="#FFFFFF">
            <tr>
              <td>
               <table width="100%" border="0" cellpadding="0" cellspacing="1">
            <tr>
              <td height="17"><table width="100%" border="0" class="main_border_line">
			  <tr>
			    <td width="3%"></td>
			  <td width="15%"></td>
			  <td width="32%"></td>
			  <td width="13%"></td>
			  <td width="37%"></td>
			  </tr>
			  <tr>
			    <td class="normalfnt">&nbsp;</td>
			  <?php
				$SQL = "SELECT dblCutGPTransferIN FROM syscontrol";
				$result = $db->RunQuery($SQL);
				$row = mysql_fetch_array($result);
				
			  ?>
			  <td class="normalfnt">&nbsp;Line Input No </td>
			  <td><input type="text" name="txtSearchInputNo" id="txtSearchInputNo" value="<?php echo $serial?>" style="width:148px" readonly="" /><input type="text" name="txtSearchInputYear" id="txtSearchInputYear" value="<?php echo $year?>"  style="width:46px"  readonly=""/>              </td>
			  <td class="normalfnt"></td>
			  <td></td>
			  </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>					
                  <td class="normalfnt">&nbsp;Factory</td>
                  <td colspan="3"> <select name="cboFactory"  id="cboFactory" class="txtbox"style="width:584px"  onchange="loadStylePoCutNo();" disabled="disabled">
<?php
$SQL = "SELECT	intCompanyID,strName,strCity FROM companies c inner join usercompany uc on  uc.companyId = c.intCompanyID WHERE intManufacturing=1 and uc.userId='$userId' ORDER BY strName ";
$result = $db->RunQuery($SQL);
	echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
while($row = mysql_fetch_array($result))
{
	if($_SESSION["FactoryID"]==$row["intCompanyID"])
		echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\" >" . $row["strName"] ." - ".$row["strCity"] . "</option>";
	else
		echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ".$row["strCity"] . "</option>";
}
?>
                    </select></td>
                </tr>
			  <tr>
			    <td class="normalfnt">&nbsp;</td>
			  <td class="normalfnt">&nbsp;Order No</td>
			  <td><select name="cboPoNo1" id="cboPoNo1" class="txtbox"style="width:200px" onchange="loadCutNo(this.value);">
<?php
$SQL = "SELECT O.strOrderNo,PBH.intStyleId,PBH.strCutNo,O.strStyle,PBH.intCutBundleSerial 
FROM productionbundleheader PBH 
inner join productiongptindetail PGTID ON PBH.intCutBundleSerial = PGTID.intCutBundleSerial 
inner join productiongptinheader PGTIH ON PGTID.dblCutGPTransferIN = PGTIH.dblCutGPTransferIN 
inner join orders O ON PBH.intStyleId = O.intStyleId 
WHERE PGTIH.intFactoryId = '".$_SESSION["FactoryID"]."' and PGTID.dblBalQty!=0 
group by PBH.intStyleId order by O.strOrderNo ASC";
$result = $db->RunQuery($SQL);
	echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
while($row = mysql_fetch_array($result))
{
	if($_POST["cboPoNo1"]==$row["intStyleId"])
		echo "<option value=\"" . $row["intStyleId"] ."\" selected=\"selected\">" . $row["strOrderNo"] . "</option>";
	else		
		echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
}
?>
                    </select></td>
			  <td class="normalfnt">&nbsp;Style</td>
			  <td><select name="cboStyle1" id="cboStyle1" class="txtbox"style="width:200px" onchange="loadCutNo(this.value);">
<?php
	
	$result = $db->RunQuery($SQL);
	echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
	while($row = mysql_fetch_array($result))
	{
		if($_POST["cboPoNo1"]==$row["intStyleId"])
			echo "<option value=\"" . $row["intStyleId"] ."\" selected=\"selected\">" . $row["strStyle"] . "</option>";
		else
			echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strStyle"] . "</option>";
	}
?>
              </select></td>
			  </tr>
			  <tr>
			    <td class="normalfnt">&nbsp;</td>
			  <td class="normalfnt">&nbsp;Cut No</td>
			  <td><select name="cboCutNo" id="cboCutNo" class="txtbox" style="width:200px" onchange="getInputEntryDetails()">
<?php
if($_POST["cboPoNo1"]!="")
{
	$sql = "SELECT PBH.intCutBundleSerial,PBH.strCutNo 
	FROM productionbundleheader PBH inner join productiongptindetail PTID on PBH.intCutBundleSerial=PTID.intCutBundleSerial 
	WHERE PBH.intStyleId = '".$_POST["cboPoNo1"]."' AND PTID.dblBalQty!=0 
	group by PBH.strCutNo order by PBH.strCutNo ASC";
	$result=$db->RunQuery($sql1);
		echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCutBundleSerial"] ."\">" . $row["strCutNo"] ."</option>";
	}
}
?>
              </select></td>
			  <td class="normalfnt">&nbsp;Pattern No</td>
			  <td><select name="cboPatternNo"  id="cboPatternNo" class="txtbox" style="width:200px">
              </select></td>
			  </tr>
			  <tr>
			    <td class="normalfnt">&nbsp;</td>
			    <td class="normalfnt">&nbsp;Line No</td>
			    <td><select name="cboTeam" id="cboTeam" class="txtbox" style="width:200px">
			      <?php
						$SQL = "SELECT	* FROM plan_teams order by strTeam";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intTeamNo"] ."\">" . $row["strTeam"] . "</option>";
						}
					?>
			      </select></td>
			    <td class="normalfnt">&nbsp;Input Date</td>
			    <?php
			  $date=date("d/m/Y");
			  
			  ?>
			    
			    <td><input name="txtInputtDate" type="text" tabindex="9" class="txtbox" id="txtInputtDate"style="width:198px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $date ?>" ><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
			      <input type="hidden" name="txtYear" id="txtYear" value="<?php echo date(Y); ?>" /><input type="hidden" name="txtUser" id="txtUser" value="<?php echo $_SESSION["UserID"] ?>" /></td>
			    </tr>
			  </table></td>
            </tr>
            <tr>
              <td height="165"><table width="98%" height="165" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%"><table width="100%" border="0"  class="main_border_line">
                        <tr>
                          <td colspan="3"><div id="divcons" style="overflow:scroll; height:400px; width:850px;">
							<!-- Populating Table Grid with Events [start]-->
                              <table width="100%" cellpadding="0" cellspacing="1" id="tblevents" >
                                <tr>
                                  <td width="10%" bgcolor="#498CC2" class="grid_header">Size</td>
                                  <td width="8%" height="25" bgcolor="#498CC2" class="grid_header">Bundle No</td>
                                  <td width="10%" bgcolor="#498CC2" class="grid_header">Range</td>
                                  <td width="13%" bgcolor="#498CC2" class="grid_header">Shade</td>
                                  <td width="10%" height="18" bgcolor="#498CC2" class="grid_header">Bal Qty</td>
                                  <td width="10%" bgcolor="#498CC2" class="grid_header">Input</td>
                                  <td width="5%" bgcolor="#498CC2" class="grid_header"><input name="checkbox" type="checkbox" id="chkCheckAll" onclick="checkAll(this);" /></td>
                                  <td width="12%" bgcolor="#498CC2" class="grid_header" >Remarks</td>
								  <td width="12%" bgcolor="#498CC2" class="grid_header" >Color</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
              <tr>
              <td height="17"><table width="100%" border="0">
			  <tr>
			  <td width="10%" class="normalfnt" align="right" colspan="2"></td>
			  <td width="20%"></td>
			  <td width="20%" class="normalfnt" align="right"></td>
			  <td width="30%" class="normalfnt" align="left"></td>
			  </tr>
<tr>
			  <td width="10%" class="normalfnt" align="right">&nbsp;</td>
			  <td width="30%">&nbsp;</td>
			  <td width="25%"></td>
			  <td width="20%" class="normalfnt" align="right">All Bundles</td>
			  <td width="15%" class="normalfnt" align="left"><input type="text" name="txtBundles" id="txtBundles" class="txtbox" size="13px"  style="text-align:right;width:100px" readonly="readonly"/></td>
			  </tr>
<tr>
			  <td width="10%" class="normalfnt" align="right">&nbsp;</td>
			  <td width="30%">&nbsp;</td>
			  <td width="25%"></td>
			  <td width="20%" class="normalfnt" align="right">Line Input Qty/Pcs</td>
			  <td width="15%" class="normalfnt" align="left"><input type="text" name="txtTotInpQty" id="txtTotInpQty" class="txtbox"  style="text-align:right;width:100px" readonly="readonly"></td>
			  </tr>			  </table>
			  </td>
			  </tr>
                  <tr>
                    <td ><table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td class="normalfntMid">
						  <img  src="../../images/new.png" alt="New" name="New" id="butNew" tabindex="9" onclick="clearform();" class="mouseover"/><img src="../../images/save.png" alt="Save"  class="mouseover"  onclick="SaveLineInputDetails();"/><img src="../../images/cancel.jpg" id="butCancle" width="108" height="24" onclick="cancleLineInput()" style="display:none" /><img src="../../images/report.png" width="108" height="24" onclick="popreporter()" /><a href="../../main.php"><img src="../../images/close.png" alt="close" border="0" class="mouseover" /></a></td>
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
