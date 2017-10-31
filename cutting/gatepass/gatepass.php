<?php
	session_start();
	include "../../../Connector.php";	
	$backwardseperator = "../../../";	
	
	$str_gpno="select intGPnumber from syscontrol";
	$result_gpno=$db->RunQuery($str_gpno);
	$row_gpno=mysql_fetch_array($result_gpno);
	$gpnumber=$row_gpno["intGPnumber"];
	$userid=$_SESSION["UserID"];
	$str_user="select Name from useraccounts where intUserID='$userid'";
	$results_user=$db->RunQuery($str_user);
	$user_row=mysql_fetch_array($results_user);
	$username=$user_row["Name"]
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gate Pass</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="gatepass.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../../Header.php'; ?></td>
  </tr>
  <tr>
    <td align="center"><table width="950" border="0" cellspacing="2" cellpadding="0" align="center" class="tableBorder">
      <tr>
        <td></td>
      </tr>
      <tr>
        <td class="mainHeading" >Gate Pass </td>
      </tr>
      
      <tr>
        <td class="bcgl1"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
           	
           	<tr>
            	<td height="30" width="73">GP No </td>
           	    <td><select name="cboGpNo" class="txtbox" style="width:150px" id="cboGpNo" onchange="load_gp_list();" tabindex="1">
                <option value=""></option>
                <?php 
			$gpstr="select intGPnumber, intYear from productiongpheader order by intGPnumber desc";
		
			$gpresult=$db->RunQuery($gpstr);
			
			while($gprow=mysql_fetch_array($gpresult))
			{
		?>
                <option value="<?php echo $gprow['intYear']."/".$gprow['intGPnumber'];?>"><?php echo $gprow['intYear']."->".$gprow['intGPnumber'];?></option>
                <?php } ?>
              </select></td>
              <td>Prepared By </td>
              <td><input name="txtPreparedBy" type="text" class="txtbox" id="txtPreparedBy" style="width:148px" maxlength="30" tabindex="2" disabled="disabled" value="<?php echo $username;?>"></td>
              <td height="25" >&nbsp;Vehicle No <span class="compulsoryRed"> *</span> </td>
              <td><input name="txtVehicle" type="text" class="txtbox" id="txtVehicle" style="width:148px" maxlength="30" tabindex="3"></td>
              <td>Pallet No  <span class="compulsoryRed"> *</span></td>
              <td><input name="txtPalletNo" type="text" class="txtbox" id="txtPalletNo" style="width:148px" maxlength="30" tabindex="4"></td>              
            </tr>
            
            <tr>
              <td width="73" height="30">To Factory<span class="compulsoryRed"> *</span> </td>
              <td width="150"><select name="cboToFactory" class="txtbox" style="width:150px" id="cboToFactory"  tabindex="5">
                <option value=""></option>
                <?php 
			$strtofactory="select intCompanyID,strComCode,strName from companies where intStatus=1 and intManufacturing=1 order by strName";
		
			$factresults=$db->RunQuery($strtofactory);
			
			while($factrow=mysql_fetch_array($factresults))
			{
		?>
                <option value="<?php echo $factrow['intCompanyID'];?>"><?php echo $factrow['strName'];?></option>
                <?php } ?>
              </select></td>
              <td width="73" height="25" >Buyer</td>
              <td width="150"><select name="cboBuyer" class="txtbox" style="width:150px" id="cboBuyer" onchange="filterStyle();" tabindex="6">
                  <option value=""></option>
                  <?php 
			$buyerstr="select 	intBuyerID,buyerCode,strName from buyers order by strName";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
                  <option value="<?php echo $buyerrow['intBuyerID'];?>"><?php echo $buyerrow['strName'];?></option>
                  <?php } ?>
              </select></td>
              <td width="78">PO No/Style<span class="compulsoryRed">*</span></td>
              <td width="155"><select name="cmbStyle" class="txtbox" style="width:150px" id="cmbStyle" tabindex="7"  onchange="loadCutNo();">
                  <option value=""></option>
				   <?php 
			$strpo="select  scch.intStyleId,strStyle,strOrderNo from style_cut_compo_header scch inner join orders on orders.intStyleId=scch.intStyleId  where orders.intStatus=11 order by orders.strOrderNo ";
		
			$poresults=$db->RunQuery($strpo);
			
			while($porow=mysql_fetch_array($poresults))
			{?>
                <option value="<?php echo $porow['intStyleId'];?>"><?php echo $porow['strOrderNo'].' / '.$porow['strStyle'];?></option>
             <?php } ?>
              </select></td>
			  <td width="65">Date <span class="compulsoryRed">*</span></td>
              <td width="150"><input name="txtCutDate" type="text" tabindex="8" class="txtbox" id="txtCutDate" style="width:100px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date('d/m/Y');?>" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            </tr>
			 
        </table></td>
      </tr>
	  <tr>
				<td height="25"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                  <tr>
                    <td width="5%"><table width="10" border="0" cellspacing="0" cellpadding="0" align="center" >
                      <tr>
                        <td bgcolor="#66CC00" style="widows:35px">&nbsp;</td>
                      </tr>
                    </table></td>
                    <td width="20%">Complete bundle </td>
                    <td width="5%"><table width="10" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td bgcolor="#FFFF33" style="widows:35px">&nbsp;</td>
                      </tr>
                    </table></td>
                    <td width="20%">Sent to subcontractor </td>
                    <td width="5%"><table width="10" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td bgcolor="#FE5B49" style="widows:35px">&nbsp;</td>
                      </tr>
                    </table></td>
                    <td width="20%">Defect components included </td>
					<td width="5%"><table width="10" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td bgcolor="#3974FB" style="widows:35px">&nbsp;</td>
                      </tr>
                    </table></td>
                    <td width="20%">Already gate passed </td>
                  </tr>
                </table>				</td>
			</tr>
      <tr>
        <td class="bcgl1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="4" height="10"></td>
            </tr>
			           <tr>
              <td width="25%"  align="center"><div id="divcons"  style="overflow:scroll; height:350px; width:95%;">
                  <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblCutNo">
                    <tr class="mainHeading4">
                      <td width="35%" height="25" >Cut # </td>
                      <td width="25%" >Qty</td>
                      <td width="15%"  >&nbsp;</td>
                    </tr>
                  </table>
              </div></td>
              <td width="35%" align="center"><div id="divcons"  style="overflow:scroll; height:350px; width:95%;">
                  <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblSize">
                    <tr class="mainHeading4">
                      <td height="25" width="50%">Size</td>
                      <td height="25" width="25%">Shade </td>
                      <td height="25" width="25%">PCs </td>
                    </tr>
                  </table>
              </div></td>
              <td width="5%" class="bcgl1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" height="25"><img src="../../../images/bw.png" alt="fw" width="18" height="19" class="mouseover" onclick="add_to_grid_o_b_o()"/></td>
                  </tr>
                  <tr>
                    <td align="center" height="25"><img src="../../../images/fw.png" alt="bw" width="18" height="19" class="mouseover" onclick="remove_to_grid_o_b_o()"/></td>
                  </tr>
                  <tr>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" height="25"><img src="../../../images/ff.png" alt="af" width="18" height="19" class="mouseover" onclick="addAllSizestoGrid();"/></td>
                  </tr>
                  <tr>
                    <td align="center" height="25"><img src="../../../images/fb.png" alt="ab" width="18" height="19" class="mouseover" onclick="removeAllSizesfromGrid();" /></td>
                  </tr>
              </table></td>
              <td width="35%" align="center"><div id="divcons"  style="overflow:scroll; height:350px; width:95%;">
                  <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tbladdedsizes">
                    <tr class="mainHeading4">
                      <td height="25"  width="50%"> Size </td>
                      <td height="25"  width="25%">Shade </td>
                      <td height="25"  width="25%">PCs </td>
                    </tr>
                  </table>
              </div></td>
            </tr>
            <tr>
              <td colspan="4" height="10"></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
            <tr >
              <td width="37%" align="center">
              <input type="image" src="../../../images/new.png" alt="n"  tabindex="8" onclick="newFormGP()"/>
              <img src="../../../images/save.png" alt="p"   class="mouseover" onclick="saveHeader();"/>
			  <?php if($cancelCuttingGatePass) {?>
			  <img src="../../../images/cancel.jpg" id="butCancel" alt="c"   class="mouseover" onclick="CancelGP();"/>
			  <?php } ?>
              <img src="../../../images/print.png " alt="c"   class="mouseover" onclick="print_gp();"/>
              <a href="../../../main.php"><input type="image" tabindex="22" src="../../../images/close.png" alt="c"  class="mouseover"  /></a>
			  </td>
            </tr>
        </table></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
if($_GET["gpnumber"]!=""&&$_GET["intYear"]!="")
{?>
<script type="text/javascript">
load_view_gp("<?php echo $_GET['intYear']?>","<?php echo $_GET['gpnumber']?>")
</script>
<?php }?>
</body>
</html>
