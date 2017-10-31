<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
$Fac	= $_POST["cboFactory"];
$po		= $_POST["cboStyle"];
$style	= $_POST["cboStyleNo"];
$DateFrom =$_POST['txtDateFrom'];
$DateTo = $_POST['txtDateTo'];
$GPTo	=	$_POST['cboGPTo'];
$GPFrom	=	$_POST['cboGPFrom'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Production Finish Goods Gate Passs Listing</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="finishGoodGP.js" type="text/javascript"></script>
<script type="text/javascript">
function submitForm(){
	document.getElementById('frmInputListing').submit();
}


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
	include "../../Connector.php";	
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td><?php include $backwardseperator."Header.php";?></td>
	</tr>
</table>

<!--<div class="main_bottom">

	<div class="main_top">
		<div class="main_text">Production Finish Goods Gate Pass Listing<span class="vol"> </span></div>
	</div>
	<div class="main_body">-->
	
	<form name="frmInputListing" id="frmInputListing"  method="post">
    <table width="800" border="0" class="main_border_line" align="center">
			<tr>
				<td class="mainHeading">Production Finish Goods Gate Pass Listing</td>
			</tr>
            <tr>
				<td>
		<table width="100%" border="0" class="main_border_line">
			
			<tr>
				<td width="25">&nbsp;</td>
				<td width="89" class="normalfnt">To Factory</td>
				<td  colspan="3">
				<select name="cboFactory" id="cboFactory" class="txtbox" style="width:532px" tabindex="1">
					<?php
					$SQL = "SELECT DISTINCT c.intCompanyID,c.strName,c.strCity
							FROM companies c
							INNER JOIN productionfggpheader p ON p.strToFactory=c.intCompanyID
							WHERE
							p.strFromFactory = '".$_SESSION['FactoryID']."';";
					$result = $db->RunQuery($SQL);
					
					echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
					while($row = mysql_fetch_array($result))
					{
						if($Fac==$row["intCompanyID"] )
							echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
						else
							echo "<option value=\"" . $row["intCompanyID"] ."\" >" . $row["strName"] ." - ". $row["strCity"] . "</option>";
					}
					?>
				</select>
				</td>
				<td class="normalfnt">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
            <tr>
				<td width="12">&nbsp;</td>
				<td width="89" class="normalfnt">Order No </td>
				<td width="232"><select name="cboStyle" id="cboStyle" class="txtbox" style="width:200px" onchange="selectStyle(this);">
				  <?php
						$SQL = "SELECT distinct PFGH.intStyleId,concat(O.strOrderNo) orderNo FROM productionfggpheader PFGH inner join orders O ON PFGH.intStyleId = O.intStyleId where PFGH.strFromFactory='".$_SESSION['FactoryID']."'order by O.strOrderNo ASC";
						$result = $db->RunQuery($SQL);						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							if($po==$row["intStyleId"] )
								echo "<option value=\"" . $row["intStyleId"] ."\" selected=\"selected\">" . $row["orderNo"] . "</option>";
							else
								echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["orderNo"] . "</option>";
						}
					?>
			    </select></td>
				<td class="normalfnt">Style No</td>
				<td><select name="cboStyleNo" id="cboStyleNo" class="txtbox" style="width:200px" onchange="selectPo(this)">
				  <?php
						$SQL = "SELECT distinct PFGH.intStyleId,O.strStyle FROM productionfggpheader PFGH inner join orders O ON PFGH.intStyleId = O.intStyleId where PFGH.strFromFactory='".$_SESSION['FactoryID']."'order by O.strOrderNo ASC";
						$result = $db->RunQuery($SQL);						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							if($style==$row["strStyle"])
								echo "<option value=\"" . $row["strStyle"] ."\" selected=\"selected\">" . $row["strStyle"] . "</option>";
							else
								echo "<option value=\"" . $row["strStyle"] ."\">" . $row["strStyle"] . "</option>";
						}
					?>
			    </select></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">Date From</td>
				<td><input name="txtDateFrom" type="text" tabindex="9" class="txtbox" id="txtDateFrom" style="width:100px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y/%m/%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"  value="<?php echo $DateFrom;?>"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;" onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
				
				<td width="92" class="normalfnt">Date To</td>
	  	  	  	<td width="204"><input name="txtDateTo" type="text" tabindex="9" class="txtbox" id="txtDateTo" style="width:100px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y/%m/%d');" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y/%m/%d');"  value="<?php echo $DateTo;?>"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;" onclick="return showCalendar(this.id, '%Y/%m/%d');" value=""></td>
				<td width="93">&nbsp;</td>
		  	</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">Gatepass From</td>
				<td>
              <select id="cboGPFrom" name="cboGPFrom"style="width:102px;">
                	<option value="">Select One</option>
                    	<?php
						  $sql="SELECT
								concat(productionfggpheader.intGPYear,'/',productionfggpheader.intGPnumber) AS GP
								from productionfggpheader
								WHERE
								productionfggpheader.strFromFactory =  '".$_SESSION['FactoryID']."' ";
						  $res=$db->RunQuery($sql);
						  while($row=mysql_fetch_assoc($res)){
							if($GPFrom==$row["GP"])
								echo "<option value=\"" . $row["GP"] ."\" selected=\"selected\">" . $row["GP"] . "</option>";
							else
								echo "<option value=\"" . $row["GP"] ."\">" . $row["GP"] . "</option>";
						  }
						?>
                </select>
            </td>
				<td width="92" class="normalfnt">Gatepass To</td>
				<td width="204"><select id="cboGPTo" name="cboGPTo" style="width:102px;">
                	<option value="">Select One</option>
                    	<?php
						  $sql="SELECT
								concat(productionfggpheader.intGPYear,'/',productionfggpheader.intGPnumber) AS GP
								from productionfggpheader
								WHERE
								productionfggpheader.strFromFactory =  '".$_SESSION['FactoryID']."' ";
						  $res=$db->RunQuery($sql);
						  while($row=mysql_fetch_assoc($res)){
                    		if($GPTo==$row["GP"])
								echo "<option value=\"" . $row["GP"] ."\" selected=\"selected\">" . $row["GP"] . "</option>";
							else
								echo "<option value=\"" . $row["GP"] ."\">" . $row["GP"] . "</option>";
						  }
						?>
                </select></td>
				<td width="93"><img src="../../images/search.png" onclick="submitForm();"/></td>
			</tr>
			<tr>
				<td></td>
			</tr>
            <tr>
			  	<td> </td>
              <td colspan="1"><label style="background:"></label> <label style="background:#FCDFD6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <label class="normalfnt">Canceled</label> </td>
                <td><label style="background:"></label> <label style="background:#FFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <label class="normalfnt" style="background:#FFF;display:none">Confirmed</label> </td>
			</tr>
		</table>
		
		<br/>
		
		<div id="divcons" style="overflow:scroll; height:300px; width:800px;"><table width="100%" border="0" class="main_border_line" id="tableGatePass">
			<tr>
				<td height="20" colspan="10" class="sub_containers">Gate Pass</td>
			</tr>
			<tr>
				<td width="82" class="grid_header">Transf No</td>
				<td width="157" class="grid_header">To Factory </td>
				<td width="123" class="grid_header">Order No </td>
				<td width="135" class="grid_header">Style No </td>
				<td width="72" class="grid_header">Date</td>
				<td width="72" class="grid_header">Total Qty</td>
				<td width="56" class="grid_header">View</td>
				<td width="67" class="grid_header">Report</td>
			</tr>
            <?php 
            	$sql = "SELECT O.strOrderNo,O.strStyle,PFGH.intGPnumber,PFGH.intGPYear,PFGH.dtmGPDate,PFGH.dblTotQty,C.strName,PFGH.intStatus FROM productionfggpheader PFGH inner join orders O on O.intStyleId=PFGH.intStyleId inner join companies C on C.intCompanyID=PFGH.strToFactory WHERE PFGH.strFromFactory = '".$_SESSION['FactoryID']."'";
if($Fac!="")
 	 $sql .= " AND PFGH.strToFactory = '".$Fac."'";
if($po!="")
  	$sql .= " AND PFGH.intStyleId = '".$po."'";
if($style="")
  	$sql .= " AND O.strStyle = '".$style."'";
if($DateFrom!="")
 	 $sql .= " AND PFGH.dtmGPDate >= '".$DateFrom."'";
if($DateTo!="")
  	$sql .= " AND PFGH.dtmGPDate <= '".$DateTo."'";
if($GPFrom!="")
	$sql .= " AND concat(PFGH.intGPYear,'/',PFGH.intGPnumber) >= '$GPFrom'";
if($GPTo!="")
	$sql .= " AND concat(PFGH.intGPYear,'/',PFGH.intGPnumber) <= '$GPTo'";
	
  	$sql .= "  ORDER BY PFGH.intGPYear,PFGH.intGPnumber DESC";
	//echo $sql;
	$result = $db->RunQuery($sql);
	$i=0;
	$cls="";
	while($row = mysql_fetch_array($result))
	{
		($i%2==0)?$cls="grid_raw":$cls="grid_raw2";
		$st='';
		if($row['intStatus']=='10'){
			$st="style=\"background-color:#FCDFD6;\"";
			
		}
		if($row['intStatus']=='0'){
			$st="style=\"background-color:#FFF;\"";
			//echo $row['intStatus'];
		}
		//echo $st;
	?>
    
		<tr>
				<td width="82" class="<?php echo $cls;?>" <?php echo $st; ?>><?php echo $row["intGPYear"]."/".$row["intGPnumber"] ;?></td>
				<td width="157" class="<?php echo $cls;?>" <?php echo $st; ?>><?php echo $row["strName"] ;?></td>
				<td width="123" class="<?php echo $cls;?>" <?php echo $st; ?>><?php echo $row["strOrderNo"] ;?></td>
				<td width="135" class="<?php echo $cls;?>" <?php echo $st; ?>><?php echo $row["strStyle"] ;?> </td>
				<td width="72" class="<?php echo $cls;?>" <?php echo $st; ?>><?php echo $row["dtmGPDate"] ;?></td>
				<td width="72" class="<?php echo $cls;?>" <?php echo $st; ?>><?php echo $row["dblTotQty"] ;?></td>
				<td width="56" class="<?php echo $cls;?>" <?php echo $st; ?>><a href="../washing_factoryGatepass/factoryGatepass.php?SerialNumber=<?php echo $row["intGPnumber"];?>&amp;intYear=<?php echo $row["intGPYear"];?>&amp;id=1" class="non-html pdf" target="_blank"><img border="0" src="../../images/view2.png" height="18"></a></td>
				<td width="67" class="<?php echo $cls;?>" <?php echo $st; ?>><a href="../washing_factoryGatepass/rptFactoryGatepass.php?SerialNumber=<?php echo $row["intGPnumber"];?>&amp;intYear=<?php echo $row["intGPYear"];?>" class="non-html pdf" target="_blank"><img height="18" border="0" src="../../images/report.png"></a></td>
			</tr>
	<?php $i++;
	}
	?>
		</table>
		</div>
		<br/>
        </td>
        </tr>
        <tr><td align="center"><img src="../../images/new.png"  onclick="clearForm();" /><a href="../../main.php"><img border="0" class="normalfntMid" alt="close" src="../../images/close.png"></a></td></tr>
        </table>
	</form>
<!--	</div>
	<div class="gap"></div>
</div>-->
</body>
</html>