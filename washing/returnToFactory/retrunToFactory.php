<?php
session_start();
$backwardseperator = "../../";
$user=$_SESSION["UserID"];
$factory=$_SESSION['FactoryID'];
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing Return to factory</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="wasreturnToFactory.js?n=1" type="text/javascript"></script>

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
$serial = $_GET["SerialNumber"];
?>

<body  <?php if($id!=0){?>onload="loadInputFrom(<?php echo $year; echo "," ; echo $serial;?>)" <?php }?> >
<?php
	include "{$backwardseperator}Connector.php";	
?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td><?php include "{$backwardseperator}Header.php";?></td>
	</tr>
</table>
		<form name="frmProductionFinishGoodRecieved" id="frmProductionFinishGoodRecieved" method="post" action="">
		<table border="0" align="center" class="main_border_line">
        <tr>
			<td class="mainHeading">Return to Factory </td>
 		</tr>
        <tr>
            <td>
              <table border="0" class="main_border_line" cellpadding="0" cellspacing="2"> 
                  <tr>
                      <td colspan="7" >&nbsp;</td>
                  </tr>
                <tr>
                  <td class="normalfnt" style="width:50px;" >&nbsp;</td>
                  <td class="normalfnt" style="width:100px;" >Serial #</td>
                  <td class="normalfnt" style="width:150px;" >
               	  <input type="text" id="txtSerial" name="txtSerial" readonly="readonly"  style="width:100px;" value="<?php echo $serial?>"/></td>
			      <td class="normalfntRite" style="width:50px;" >&nbsp;</td>
			      <td class="normalfnt" style="width:100px;" >Date</td>
			  <?php
			  $date=date("d/m/Y");
			  
			  ?>
			  <td align="left" style="width:150px;" ><input name="txtDate" type="text" tabindex="9" class="txtbox" id="txtDate" style="width:150px"   value="<?php echo $date ?>" readonly="readonly"/>	</td>
              <td class="normalfntRite" style="width:50px;">&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt" style="width:50px;">&nbsp;</td>
                  <td class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;">GatePass No</span></td>
                  <td colspan="4" style="width:500px">
			  <?php
			  $date=date("d/m/Y");
			  
			  ?>
			  <select name="cboGPNo"  id="cboGPNo" class="txtbox" style="width:486px" onchange="loadDets(this);">
                <?php

			//$SQL = "SELECT	intGPnumber,intGPYear,strToFactory FROM productionfggpheader ORDER BY intGPnumber DESC";
			$SQL="SELECT
			productionfggpheader.intGPnumber,productionfggpheader.intGPYear,
			CONCAT(productionfggpheader.intGPYear,'/',intGPnumber,' --> ',orders.strOrderNo,'/',orders.strStyle) as GPNO,
			productionfggpheader.strToFactory
			FROM
			productionfggpheader
			INNER JOIN orders ON productionfggpheader.intStyleId = orders.intStyleId
			WHERE productionfggpheader.strToFactory='$factory'
			ORDER BY intGPnumber DESC;";
			
			$result = $db->RunQuery($SQL);
			echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
			while($row = mysql_fetch_array($result))
			{
				//echo "<option value=\"" . $row["intGPYear"]."/".$row["intGPnumber"] ."\">" . $row["intGPYear"]."/".$row["intGPnumber"] . "</option>";	
				echo "<option value=\"" . $row["intGPYear"]."/".$row["intGPnumber"] ."\">" . $row["GPNO"]. "</option>";	
			}
			?>
              </select>
                  <td style="width:50px;"><input type="hidden" name="txtYear" id="txtYear" value="<?php echo date(Y); ?>" /><input type="hidden" name="txtUser" id="txtUser" value="<?php echo $_SESSION["UserID"] ?>" /></td>
                </tr>
                <tr>
                  <td class="normalfnt" style="width:50px;">&nbsp;</td>
                  <td class="normalfnt" style="width:125px;">From Factory</td>
                  <td colspan="4" style="width:400px"><select name="cboFactory"  id="cboFactory" class="txtbox" style="width:486px" onchange="clearGP();">
                    <?php
						$SQL = "SELECT	intCompanyID,strName,strCity FROM companies WHERE  intCompanyID='". $_SESSION["FactoryID"]."' ORDER BY strName ASC";
						$result = $db->RunQuery($SQL);
						//intManufacturing=1 AND
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							if($_SESSION["FactoryID"]==$row["intCompanyID"]){
								echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\" >" . $row["strName"] ." - ".$row["strCity"]. "</option>";
							}else{
								echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
							}
						}
					?>
                  </select></td>
                  <td style="width:50px"></td>
                  </tr>
                <tr>
                  <td class="normalfnt" style="width:50px;">&nbsp;</td>
                  <td class="normalfnt" style="width:125px;">To Factory</td>
                  <td colspan="4" style="width:400px"><select name="cboToFactory"  id="cboToFactory" class="txtbox" style="width:486px">
                    <?php
						$SQL = "SELECT	intCompanyID,strName,strCity FROM companies WHERE intManufacturing=1 ORDER BY strName ASC";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
								echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
						}
					?>
                  </select></td>
                  <td style="width:50px"></td>
                  </tr>
			  <tr>
			    <td class="normalfnt" style="width:50px;">&nbsp;</td>
			  <td class="normalfnt" style="width:125px;">Order No </td>
			  <td><select name="cboPoNo" id="cboPoNo" class="txtbox" style="width:150px" onchange="selectPOStyles(this,'cboStyle'),loadColor(this);">
			  
			  <?php 
		$SQL = "SELECT DISTINCT orders.intStyleId,orders.strOrderNo FROM productionfinishedgoodsreceiveheader Inner Join orders ON    productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId ORDER BY orders.strOrderNo ASC";
			  echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						$result = $db->RunQuery($SQL);	
						while($row=mysql_fetch_array($result)){
						  echo "<option value = \"". $row['intStyleId'] . "\">" . $row['strOrderNo']  . "</option>"; 
						}				
						
					?>
			  
              </select></td>
			  <td class="normalfntRite">&nbsp;</td>
			  <td class="normalfnt" style="width:100px">Style</td>
			  <td style="width:150px;"><select name="cboStyle" id="cboStyle" class="txtbox" style="width:152px" onchange="selectPOStyles(this,'cboPoNo'),loadColor(document.getElementById('cboPoNo'));">
			  
				  <?php
						$sqlS="SELECT DISTINCT orders.intStyleId,orders.strStyle FROM productionfinishedgoodsreceiveheader Inner Join orders ON    productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId ORDER BY orders.strOrderNo ASC;";
						$res = $db->RunQuery($sqlS);
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row=mysql_fetch_array($res)){
							echo "<option value = \"". $row['intStyleId']. "\">" . $row['strStyle'] . "</option>";
						}
					?>
			  
              </select></td>
              <td style="width:50px"></td>
			  </tr>
			  <tr>
			    <td class="normalfnt" style="width:50px;">&nbsp;</td>
			  <td class="normalfnt" style="width:125px;">Color</td>
			  <td><select name="cboColor" id="cboColor" class="txtbox" style="width:150px" onchange="loadStylePoNoGrids(this.value);">
			  
			  <?php
			  echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
				?>
			  
              </select></td>
			  <td class="normalfntRite">&nbsp;</td>
			  <td class="normalfnt" style="width:100px">Order Qty </td>
			  <td style="width:150px" ><input type="text" id="txtOrderQty" name="txtOrderQty" disabled="disabled" style="width:150px" /></td>
              <td style="width:50px"></td>
			  </tr>
			  <tr>
			    <td  class="normalfnt" style="width:50px;">&nbsp;</td>
			    <td  class="normalfnt" style="width:125px;" valign="top">Remarks </td>
			    <td><textarea name="txtRemarks" type="text" class="txtbox" id="txtRemarks"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" value="" onkeypress="return imposeMaxLength(this,event, 100);"  rows="1" cols="19"></textarea></td>
			    <td class="normalfntRite">&nbsp;</td>
			    <td valign="top" class="normalfnt" style="width:100px;display:none;">GatePass Qty </td>
			    <td valign="top"><input type="text" id="txtGpQty" name="txtGpQty" disabled="disabled" style="width:150px;display:none;" /></td>
                <td style="width:50px"></td>
			    </tr>
              </table></td>
            </tr>
			
			<tr>
				<td colspan="7" align="center"> 
                <table width="68%">
                <tr>
                <td>
				<div style="height:100px;width:170px; overflow:scroll;" >
					<table id="tblCutNos" name="tblCutNos" border="0" align="center" width="150">
						<thead>
						  <tr>
                            <td class="grid_header" style="height:20px;">Cut No</td>
                            <td class="grid_header" style="height:20px;"><input type="checkbox" id="chkAllCuts" onclick="checkAll(this,'tblCutNos');" /></td>
                          </tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
                </td>
                <td style="display:none;">
                <div style="height:100px;width:170px; overflow:scroll;" >
					<table id="tblShades" name="tblShades" border="0" align="center" width="150">
						<thead>
							<tr>
                            	<td class="grid_header" style="height:20px;">Shade</td>
                            	<td class="grid_header" style="height:20px;"><input type="checkbox" id="chkAllShades" onclick="checkAll(this,'tblShades');" /></td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
                </td>
                </tr>
                </table>
				</td>
			</tr>
			
			  <tr>
			  <td height="0"><input type="hidden" name="txtFromFactory" id="txtFromFactory" value="" /><input type="hidden" name="txtGpNo" id="txtGpNo" value="" /><input type="hidden" name="txtGPTYear" id="txtGPTYear" value="" /></td>
			  </tr>
			  		
            <tr>
              <td height="165"><table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%"><table width="100%" border="0"   class="main_border_line">
                        <tr>
                          <td colspan="3"><div id="divTable2" style="overflow:scroll; height:300px; width:730px;">
							<!-- Populating Table Grid with Events [start]-->
                              <table width="100%" cellpadding="0" cellspacing="1" id="tblSecond" >
                                <thead>
								<tr>
                                  <td width="10%" height="18"  class="grid_header">Cut No</td>
                                  <td width="12%" class="grid_header">Size</td>
                                  <td width="12%" class="grid_header">Bundle No</td>
                                  <td width="18%" class="grid_header">Range</td>
                                  <td width="12%" class="grid_header">Shade</td>
                                  <td width="8%" class="grid_header">Bal Qty</td>
                                  <td width="8%" class="grid_header">Return Qty</td>
                                  <td width="3%" class="grid_header"><input name="chkAllSecond" type="checkbox" id="chkAllSecond" onclick="checkAllTblSecond(this);" /></td>
                                  <td style="display:none" width="1%" class="grid_header"></td>
                                  <td style="display:none" width="1%" class="grid_header"></td>
                                   <td width="12%" class="grid_header">Remarks</td>
                                </tr>
								</thead>
								<tbody>
								</tbody>
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
			  <td width="20%"></td>
			  <td width="25%" class="normalfnt" align="right"> Qty/Pcs</td>
			  <td width="15%" class="normalfnt" align="left"><input type="text" name="txtTotGpQty" id="txtTotGpQty" class="txtbox"  style="text-align:right" size="16px" readonly="readonly"></td>
			  </tr>
			  
			  </table>
			  </td>
			  </tr>
			  
              <tr>
              <td height="17"><table width="100%" border="0">
			  <tr>
			  <td width="10%" class="normalfnt" align="right"></td>
			  <td width="10%" class="normalfnt" align="right"></td>
			  <td width="15%" class="normalfnt" align="right"></td>
			  <td width="70	%" class="normalfnt" align="right"></td>
			  </tr>
			  </table>
			  </td>
			  </tr>
				  
                  <tr class="bcgl1">
                    <td bgcolor=""><table width="100%" border="0" class="tableFooter">
                        <tr>
                          <td width="24%">&nbsp;</td>
						  <td align="center">
                          <img  src="../../images/new.png" alt="New" name="butNew" id="butNew" tabindex="9" onclick="ClearForm();" class="mouseover"/>
                          <img src="../../images/conform.png" alt="confirm" name="btnConfirm" id="btnConfirm" class="mouseover"  onclick="confirmData();" style="display:none;"/>
                          <img src="../../images/save.png" alt="Save" name="butSave" id="butSave" class="mouseover"  onclick="SavePData();"/>
                         <a href="../../main.php"><img src="../../images/close.png" alt="close"   border="0" class="mouseover" /></a>
						 </td>
                          <td width="24%">&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
			
			
			
          </table>
        </form>    
</body>
</html>
