<?php
session_start();
$backwardseperator = "../../";
$user=$_SESSION["UserID"];
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Washing Factory/Gate Pss-[PO wise]</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="factoryGatepass.js?n=1" type="text/javascript"></script>
<script src="fg_js.js" type="text/javascript"></script>
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
	include "../../Connector.php";	
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "{$backwardseperator}Header.php";?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="28%">&nbsp;</td>
        <td width="51%">
<!--		
<div class="main_bottom">

	<div class="main_top">
		<div class="main_text">Finish Goods-Factory/Gate Pass-[PO wise]<span class="vol"> </span></div>
	</div>
	<div class="main_body">-->
	
		<form name="frmProductionGatePass" id="frmProductionGatePass" method="post" action="">
          <table width="100%" border="0" class="main_border_line">
          	<tr>
            	<td class="mainHeading">Finish Goods-Factory/Gate Pass-[PO wise]</td>
            </tr>
            <tr>
              <td height="17"><table width="100%" border="0" class="main_border_line">
			  <tr>
			  <td width="20%"></td>
			  <td width="30%"></td>
			  <td width="20%"></td>
			  <td width="30%"></td>
			  </tr>
			  <tr>
			  <td class="normalfnt">&nbsp;Gate Pass #</td>
			  <td><input type="text" id="txtGPass" name="txtGPass" size="16px" readonly=""  value="<?php echo $serial?>"/><input type="text" name="txtSearchYear" id="txtSearchYear" value="<?php echo $year?>" style="width:40px" readonly=""/></td>
			  			  <?php
			  $date=date("d/m/Y");
			  
			  ?>

			  <td class="normalfntRite">&nbsp;Date</td>
			  <td><input name="txtDate" type="text" tabindex="9" class="txtbox" id="txtDate" style="width:152px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $date ?>"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
					<input type="hidden" name="txtYear" id="txtYear" value="<?php echo date(Y); ?>" /><input type="hidden" name="txtUser" id="txtUser" value="<?php echo $_SESSION["UserID"] ?>" /></td>
			  </tr>
              <tr>
                  <td class="normalfnt">&nbsp;Gate Pass</td>
                  <td colspan="3"><select name="cboGPNo"  id="cboGPNo" class="txtbox" style="width:250px" onchange="loadGPNoDetail(this);">
                    <?php
					
					
						$SQL = "SELECT DISTINCT
								productionfinishedgoodsreceiveheader.intStatus,
								productionfinishedgoodsreceiveheader.dblTotQty,
								productionfinishedgoodsreceiveheader.dblBalQty,
								productionfinishedgoodsreceiveheader.intGPYear,
								productionfinishedgoodsreceiveheader.dblGatePassNo,
								concat(productionfinishedgoodsreceiveheader.intGPYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo,'-->',orders.strOrderNo) AS GP
								FROM
								productionfinishedgoodsreceiveheader
								Inner Join orders ON productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId
								WHERE
								productionfinishedgoodsreceiveheader.strTComCode =  '".$_SESSION['FactoryID']."'
								HAVING productionfinishedgoodsreceiveheader.dblTotQty =  productionfinishedgoodsreceiveheader.dblBalQty
								ORDER BY
								concat(productionfinishedgoodsreceiveheader.intGPYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo)   ASC";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
						
							echo "<option value=\"" . $row["intGPYear"].'/'.$row["dblGatePassNo"]."\">" . $row["GP"] . "</option>";
							
						}
					?>
                  </select></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;From Factory</td>
                  <td colspan="3"><select name="cboFromFactory"  id="cboFromFactory" class="txtbox" style="width:505px" onchange="loadPoNoAndStyle();" disabled="disabled">
                    <?php
					
					
						$SQL = "SELECT	companies.intCompanyID,companies.strName,companies.strCity 
						FROM companies					
					    ORDER BY companies.strName ASC";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
						if($_SESSION["FactoryID"]==$row["intCompanyID"]){
							echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\" >" . $row["strName"] ." - ". $row["strCity"] . "</option>";
							}
							else{
							echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
							}
						}
					?>
                  </select></td>
                </tr>
				
                <tr>
                  <td class="normalfnt">&nbsp;To Factory</td>
                  <td colspan="3"><select name="cboToFactory"  id="cboToFactory" class="txtbox" style="width:505px">
                    <?php
						$SQL = "SELECT	intCompanyID,strName,companies.strCity FROM companies WHERE intManufacturing=1 
								AND companies.intCompanyID !='".$_SESSION["FactoryID"]."' ORDER BY strName ASC";
							
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
						}
					?>
                  </select></td>
                </tr>
				
			  <tr>
			  <td class="normalfnt">&nbsp;Order No </td>
			  <td><select name="cboPoNo" id="cboPoNo" class="txtbox" style="width:155px" onchange="loadStylePoNoGrids(this.value);">
			  
			  <?php
				$SQL = "select distinct o.intStyleId,o.strOrderNo 
						from productionfinishedgoodsreceiveheader p 
						inner join orders o on o.intStyleId=p.intStyleNo
						where p.strTComCode='".$_SESSION["FactoryID"]."' 
						 order by o.strOrderNo ASC";
				$result = $db->RunQuery($SQL);
								
				echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
				}
			 ?>
			  
              </select></td>
			  <td class="normalfntRite">&nbsp;Style</td>
			  <td><select name="cboStyle" id="cboStyle" class="txtbox" style="width:152px" onchange="loadStylePoNoGrids(this.value);">
			  
			 <?php
				$SQL = "select distinct o.intStyleId,o.strStyle 
						from productionfinishedgoodsreceiveheader p 
						inner join orders o on o.intStyleId=p.intStyleNo
						where p.strTComCode='".$_SESSION["FactoryID"]."' 
						 order by o.strOrderNo ASC";
						 		
						$result = $db->RunQuery($SQL);
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strStyle"] . "</option>";
						}
			?>
			  
              </select></td>
			  </tr>
			  <tr>
			  <td class="normalfnt">&nbsp;Vehicle No </td>
			  <td><input name="txtVehicleNo" type="text" tabindex="5" class="txtbox" id="txtVehicleNo" style="width:152px" maxlength="15"/></td>
			  <td class="normalfntRite" style="display:none;">Available Qty </td>
			  <td><input type="text" id="txtAvlQty" name="txtAvlQty" style="display:none;"/></td>
			  </tr>
              <tr>
			  <td class="normalfnt">&nbsp;Remarks </td>
			  <td colspan="3"><textarea name="txtRemarks"  type="text" tabindex="6" class="txtbox" id="txtRemarks" style="width:500px;height:25px;" onkeypress="return imposeMaxLength(this,event, 150);"></textarea></td>
			  </tr>
              </table></td>
            </tr>
			  
			  
		
			  <tr>
              <td height="17"><table width="100%" border="0"  class="main_border_line">
			  <tr>
			  <td colspan="5" class="normalfnt" align="right"></td>
			  </tr>
			  <tr>
			  <td width="5%"></td>
			  <td width="40%">
              	<div id="divTable1" style="overflow:scroll; height:100px; width:300px;display:none;">
							<!-- Populating Table Grid with Events [start]-->
                      <table width="100%" cellpadding="0" cellspacing="1" id="tblFirst" >
                          <tr>
                             <td width="35%" height="18" class="grid_header">Cut No</td>
                             <td width="35%" class="grid_header">Date</td>
                             <td width="30%" class="grid_header"><input name="checkbox" type="checkbox" id="chkCheckAll" onclick="checkAll(this);"  /></td>
                         </tr>
                     </table>
                 </div>
              </td>
              <td width="10%"></td>
			  <td width="40%">
              	<div  style="overflow:scroll; height:100px; width:100px;display:none;">
							<!-- Populating Table Grid with Events [start]-->
                      <table width="100%" cellpadding="0" cellspacing="1" id="tblShades" >
                      	<thead>
                          <tr>
                             <td width="85%" height="18" class="grid_header">Shade</td>
                             <td width="15%" class="grid_header"><input name="checkbox" type="checkbox" id="chkCheckAllShades" onclick="checkAllShades(this);"  /></td>
                         </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                 </div>
              </td>
			  <td width="5%"></td>
			  </tr>
			  
			  <tr>
              <td height="17" colspan="5">
              <div style="height:200px;overflow:scroll;">
              <table width="100%" border="0" id="tblMainInvGrid">
              <thead>
			  <tr>
			  <th width="30%" class="grid_header">Invoice No</th>
			  <th width="12%" class="grid_header">Shade</th>
			  <th width="13%" class="grid_header">Bal Qty</th>
              <th width="9%" class="grid_header">GP Qty</th>
			  <th width="4%" class="grid_header"><input type="checkbox" onclick="checkAllShadeInvCols(this);" id="chkSG"/ style="display:none;"></th>
			  <th  width="32%" class="grid_header" style="display:none;">Remarks</th>
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
              <td height="165"><table width="98%" height="165" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%"><table width="100%" border="0"   class="main_border_line">
                        <tr>
                          <td colspan="3"><div id="divTable2" style="overflow:scroll; height:300px; width:700px;">
							<!-- Populating Table Grid with Events [start]-->
                              <table width="100%" cellpadding="0" cellspacing="1" id="tblSecond" >
                                <tr>
                                  <td width="10%" height="18" class="grid_header">Cut No</td>
                                  <td width="12%" class="grid_header">Size</td>
                                  <td width="12%" class="grid_header">Bundle No</td>
                                  <td width="19%" class="grid_header">Range</td>
                                  <td width="12%" class="grid_header">Shade</td>
                                  <td width="10%" class="grid_header">Bal Qty</td>
                                  <td width="8%" class="grid_header">GP Qty</td>
                                  <td width="3%" class="grid_header">
                                  <input name="chkAllSecond" type="checkbox" id="chkAllSecond" onclick="checkAllTblSecond(this);" disabled="disabled"/></td>
                                  <td style="display:none" width="1%" class="grid_header"></td>
                                   <td width="12%" class="grid_header">Remarks</td>
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
			  <td width="20%" class="normalfnt" align="right">Gate Pass Qty/Pcs</td>
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
                          <td width="15%" align="center">&nbsp;</td>
                          <td width="80%"  class="normalfntMid">
                          <img  src="../../images/new.png" alt="New" name="New" id="butNew" tabindex="9" onclick="clearForm();" class="mouseover"/>
                          <img src="../../images/save.png" id="btnSave" alt="Save"  class="mouseover"  onclick="SaveFinishGoodGPData();"/ style="display:inline;">
                          <img src="../../images/report.png" id="btnRpt" alt="Report"  class="mouseover"  onclick="showReport();" style="display:none;"/>
                          <img src="../../images/cancel.jpg" id="btnCancel" alt="Cancel" class="mouseover" onclick="cancelGP()" style="display:none;"/>
                          <img src="../../images/conform.png" id="btnConfirm" alt="Confirm"  class="mouseover"  onclick="ConfirmGP();" style="display:none;"/>
                          <a href="../../main.php"><img src="../../images/close.png" alt="close"   border="0" class="normalfntMid" /><a>
                          </td>
                          <td width="15%">&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
			
			
			
          </table>
        </form>
		
<!--	</div>
	<div class="gap"></div>
</div>-->
		
		</td>
        <td width="21%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
