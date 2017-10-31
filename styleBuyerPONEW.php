<?php
 session_start();
 include "authentication.inc";
 
$factory = $_POST["cboFactory"];
$buyer = $_POST["cboCustomer"];
$styleID = $_POST["cboStyles"];
$srNo = $_POST["cboSR"];

if ($factory != "Select One")
{
	$styleID = "Select One";
	$srNo = "Select One";
}

if ($_POST["txtStyle"] != "")
	$styleID = $_POST["txtStyle"];

$xml = simplexml_load_file('config.xml');

$EnableAdvancedBuyePO = $xml->BuyerPO->EnableAdvanceMode;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Style Buyer PO</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}

-->
</style>



<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">

var index = 0;
var styles =new Array();
var message = "Following Style Numbers has been updated as completed.\n\n";

function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "Select One";
	document.getElementById("cboCustomer").value = "Select One";
}

function submitForm()
{
	document.frmcomplete.submit();
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
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="styleBuyerPO.php">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Style - Buyer PO </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="72" bgcolor="#99CCFF" class="txtbox">Factory</td>
                  <td width="72" class="txtbox"><select name="cboFactory" class="txtbox" id="cboFactory" style="width:170px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
					
$xml = simplexml_load_file('config.xml');
$reportname = $xml->PreOrder->ReportName;

	include "Connector.php"; 
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($factory == $row["intCompanyID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  <td width="72" bgcolor="#99CCFF" class="txtbox">Buyer</td>
                  <td width="72" class="txtbox"><select name="cboCustomer" class="txtbox" style="width:180px" id="cboCustomer">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if ($buyer == $row["intBuyerID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  <td width="72" bgcolor="#99FF66" class="txtbox">Style No </td>
                  <td width="155" class="txtbox"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="getScNo();resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70" bgcolor="#99FF66" class="txtbox">SC No</td>
                  <td width="150" class="txtbox"><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="getStyleNo1();resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId 
WHERE  orders.intStatus = 11";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  </tr>
                <tr>
                  <td height="26">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td bgcolor="#99FF66" class="txtbox">Like</td>
                  <td><input name="txtStyle" type="text" class="txtbox" id="txtStyle" value="<?php echo $_POST["txtStyle"]; ?>" /></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:930px; height:400px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="910" bgcolor="#CCCCFF" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="15%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">SC No </td>
                <td width="29%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Company</td>
                <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2"><div align="right">Order Quantity </div></td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT orders.intStyleId,strDescription,strStyle, companies.strComCode, buyers.strName,intQty,dtmAppDate,intSRNO FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID INNER JOIN specification ON orders.intStyleId = specification.intStyleId  WHERE orders.intStatus = 11  " ;
			
			
			if ($factory != "Select One")
			{
				$sql.= " and orders.intCompanyID = $factory";
			}
			if ($buyer != "Select One")
			{
				$sql.= " and orders.intBuyerID = $buyer";
			}
			if ($styleID != "Select One" &&  $styleID != "")
			{
				$sql.= " and orders.intStyleId like '%$styleID%'";
			}
			$sql.= " order by intStyleId ";
			
			
			
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrow";
				else
					echo "bcgcolor-tblrowWhite";
			   ?>">
                <td height="21" class="normalfnt"><?php echo  $row["strStyle"]; ?></td>
                <td class="normalfnt"><?php echo  $row["intSRNO"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfntRite"><?php echo  $row["intQty"]; ?>&nbsp;</td>
                 <?php 
            if ($EnableAdvancedBuyePO == "true")
            {
            ?>
            <td class="normalfnt"><img src="images/view2.png" border="0" class="mouseover" onclick="showBPODeliveryFormMenu('<?php echo  $row["intStyleId"]; ?>');"  /></td>
            <?php
            }
            else
            {
            ?>
                <td class="normalfnt"><a href="buyerPO.php?styleID=<?php echo  $row["intStyleId"]; ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></td>
               <?php 
               }
               ?>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
</form>
</body>
</html>
