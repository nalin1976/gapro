<?php
session_start();
 //require("../../sajax.php");     // before user rights
 //sajax_init();
 //$sajax_debug_mode = 1;
 //sajax_export("loadStyleNo");
 //sajax_handle_client_request(); 
$backwardseperator = "../../";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PRICE INQUIRY</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="priceInquiry-java.js" type="text/javascript"></script>
<script type="text/javascript">

    /**** browser version filters ****/
    var isIE = (navigator.appName == "Microsoft Internet Explorer");
    var isIEWin = (isIE && navigator.userAgent.indexOf("Win") != -1);
    var isIEMac = (isIE && navigator.userAgent.indexOf("Mac") != -1);
 <?php
   //sajax_show_javascript();
 ?>
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

function loadStyleNo(){

//x_loadStyleNo(loadStyleNo_x);

}

 
 function loadStyleNo_x(str_styleno) 
 {
 var cbointStyleId = document.frmpriceinq.cbointStyleId
 alert(str_styleno);
 /*
 var the_array = str_styleno.split("####");    
 cbointStyleId.options.length = the_array.length+1;
 var loop=0;
 if(str_styleno != "")
 {
  for(loop;loop<the_array.length+1;loop++)
  {
   lines = the_array[loop].split("**");   
   cbointStyleId.options[0].value = "";
   cbointStyleId.options[0].text  = "";

   cbointStyleId.options[loop+1].value = lines[0];
   cbointStyleId.options[loop+1].text  = lines[1];
  }
 }*/
}

function DateDisable(obj)
{
	if(obj.checked){
		document.getElementById('DateFrom').disabled=false;
		document.getElementById('DateTo').disabled=false;
	}
	else{
		document.getElementById('DateFrom').disabled=true;
		document.getElementById('DateTo').disabled=true;
	}
}

</script>

</head>

<body onload="clearTable();">

<form name="frmpriceinq" id="frmpriceinq">
<?php
		  include "../../Connector.php"; 
		  
?>
<td><?php include '../../Header.php'; ?></td>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    
  </tr>
    <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">PRICE INQUIRY</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="border-All" >
      <tr>
        <td width="1%" valign="top">&nbsp;</td>
        <td width="99%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" border="0" >
          <tr>
            <td class="normalfnt">Supplier</td>
 <td colspan="3"><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:320px" onchange="clearTable();"> 

		<?php
		$SQL = "SELECT strTitle,strSupplierID FROM suppliers s where intStatus='1' order by strTitle;";	
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["strSupplierID"]."\">".$row["strTitle"]."</option>";
			}
	
 	    ?>
 </select></td>
            
 <td width="17%" class="normalfntRite">Category</td>
 <td width="36%" colspan="3" align="left"><select name="cboCategory" class="txtbox" id="cboCategory" style="width:170px" onchange="loadSubCategory();">
    <?php	
	$SQL = "SELECT intID,strDescription from matmaincategory ORDER BY intID";	
	$result = $db->RunQuery($SQL);	
	echo "<option value=\"".""."\">" .""."</option>";	
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
    </select></td>
</tr>

<tr>
 <td width="11%" class="normalfnt">Sub Category</td>
 <td colspan="3"><select name="cboSubCategory" class="txtbox" id="cboSubCategory" style="width:170px" onchange="clearTable();"> 
    <?php	
	$SQL = "SELECT intSubCatNo,StrCatName from matsubcategory ORDER BY intSubCatNo";	
	$result = $db->RunQuery($SQL);		
	echo "<option value=\"".""."\">" .""."</option>";
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
	}
	
	?>
    </select></td>

 <td width="17%" class="normalfntRite">Item</td>
 <td colspan="4"><select name="cboItem" class="txtbox" id="cboItem" style="width:170px" onchange="clearTable();">
    <?php	
	$SQL = "SELECT intItemSerial,StrItemDescription from matitemlist ORDER BY intItemSerial";	
	$result = $db->RunQuery($SQL);		
	echo "<option value=\"".""."\">" .""."</option>";
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intItemSerial"] ."\">" . $row["StrItemDescription"] ."</option>" ;
	}
	
	?>
    </select></td>
</tr>
</table></td>
<tr valign="top">
  <td ><table width="100%" border="0" >
    <tr>
      <td width="11%" class="normalfnt"><input  type="checkbox" name="chkDate" id="chkDate"  onclick="DateDisable(this);"/></td>
      <td width="4%" class="normalfnt"><div align="left">From</div></td>
      <td width="19%" class="normalfnt"><input name="DateFrom" type="text" class="txtbox" id="DateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateFrom=="" ? date ("d/m/Y"):$DateFrom) ?>" disabled="disabled"/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
      <td width="6%" class="normalfnt"><div align="right">To</div></td>
      <td width="60%" class="normalfnt"><input name="DateTo" type="text" class="txtbox" id="DateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateTo=="" ? date ("d/m/Y"):$DateTo) ?>" disabled="disabled"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  /></td>
    </tr>
  </table></td>
<tr valign="top">
<td><table width="100%" border="0">
<tr>
<td width="11%" class="normalfnt"><div align="left"><b>Date</div></td>
<td width="6%" class="normalfnt"><div align="left">Latest</div></td>
<td width="4%"><input type="radio" name="sortDate" id="sortDate" value="DL" onclick="clearTable();"/></td>

<td width="6%" class="normalfnt"><div align="left">Earliest</div></td>
<td width="4%"><input type="radio" name="sortDate" id="sortDate" value="DE" onclick="clearTable();"/></td>

<td width="8%" class="normalfnt"><div align="left">No Sorting</div></td>
<td width="61%"><input type="radio" name="sortDate" id="sortDate" value="NO" checked="checked" onclick="clearTable();"/></td>
</tr>

<tr>
<td width="11%" class="normalfnt"><div align="left"><b>Price</div></td>
<td width="6%" class="normalfnt"><div align="left">Lowest</div></td>
<td width="4%"><input type="radio" name="sortPrice" id="sortPrice" value="PL" onclick="clearTable();"/></td>

<td width="6%" class="normalfnt"><div align="left">Highest</div></td>
<td width="4%"><input type="radio" name="sortPrice" id="sortPrice" value="PH" onclick="clearTable();"/></td>

<td width="8%" class="normalfnt"><div align="left">No Sorting</div></td>
<td width="61%"><input type="radio" name="sortPrice" id="sortPrice" value="NO" checked="checked" onclick="clearTable();"/></td>
</tr>

</table></td>
</tr>
<tr><td align="right"><img src="../../images/search.png" name="search" width="108" height="24" class="mouseover" id="search"  onclick="clearTable();"/></td></tr>
</table></td>
</tr>
</table></td>
</tr>
<tr>
 <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><div id="divcons2" style="overflow:scroll; height:240px; width:950px;">
          <table width="1200" cellpadding="0" cellspacing="1" id="tblMain" bgcolor="#CCCCFF" >
            <tr>
              <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Supplier</td>
              <td width="9%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">PO No</td>
              <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">PO Date</td>
              <td width="30%" bgcolor="#498CC2" class="normaltxtmidb2">Item</td>
			  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Unit Price</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Currency</td>
              </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
    </table></td>
  </tr>
</table>
</form>

<div style="left:345px; top:360px; z-index:10; position:absolute; width: 240px; visibility:hidden;" id="copyPOMain"><table width="221" height="58" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="69">&nbsp;</td>
            <td width="115">&nbsp;</td>
			<td width="1" class="normalfntRiteTAB style1" bgcolor="#FF0000" ><a href="#" onclick="closeCopyPo();">X</a></td>
          </tr>
          <tr>
            <td><div align="center">PO No </div></td>
            <td><select name="select" class="txtbox" id="cboPONo" style="width:100px" onchange="copyPO();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>		
</div>
</body>
</html>

<?php
/*
function loadStyleNo($cboDeliverto){
 
 include "../../Connector.php"; 
 global $db;

  $sql= "SELECT strStyle FROM orders where strOrderNo = '$cboDeliverto'"; 

  //return $sql; 
  //$result = mysql_query($sql) or die("SQL Error sql".mysql_error());

  $result = $db->RunQuery($sql);

  if(mysql_num_rows($result))      
  {
   while($fields = mysql_fetch_array($result,MYSQL_BOTH))
   { 
    $strStyle      = $fields['strStyle'];

	$te_return.= "$strStyle"."####";
   }
   $te_return =  substr($te_return,0,-2);
  }
  else{
	$te_return = "";  
  }
   return  $te_return;

}
*/

 function loadStyleNo()
 {
  global $db;
  include "../../Connector.php"; 
 
  $sqlquery = "(SELECT intStyleId,strStyle FROM orders WHERE orders.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM                         invoicecostingheader)) ORDER BY orders.intStyleId"; 
   //return $sqlquery;
   $result = $db->RunQuery($sqlquery);
  
  if(mysql_num_rows($result))
  {
   while($fields_oag = mysql_fetch_array($result,MYSQL_BOTH))
   {
	$intStyleId    = $fields_oag['intStyleId'];
    $strStyle      = $fields_oag['strStyle'];
    $te_return    .= $intStyleId."**".$strStyle."####";
   }
   $te_return = substr($te_return,0,-4);
  }
  else
  {
   $te_return = "";
  }
  return "$te_return";
 }
?>





