<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IOU Details</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="Upload.js" type="text/javascript"></script>
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

<body >

<?php
	include "../../Connector.php";	
	
	$filepath = NULL;
	$filepath = $_POST['filepath'];
	$hidtxt   = $_POST['hidtxt'];
	 if($hidtxt!="")
	{
		mkdir("../../OrdersXL",0777);
		$target  = "../../OrdersXL/";
		$name    = explode('.',$_FILES['filepath']['name']);
		
		if($name[1]=="XLS" || $name[1]=="xls" || $name[1]=="XLSX" || $name[1]=="xlsx")
		{
			move_uploaded_file($_FILES['filepath']['tmp_name'], $target.$_FILES['filepath']['name']);
			
		}	
	}
				
?>
<form name="frmbom" id="frmbom" enctype="multipart/form-data" method="post">
<table width="950" border="0" align="center" bgcolor="#ffffff">
<tr>
    <td style="text-align:center"><?php include $backwardseperator.'Header.php'; ?></td>
</tr>
<tr>
	<td><table width="954" border="0">
  		<tr style="background:#EDF7FC;">
        <td height="19" colspan="4">
       		<input type="file" name="filepath" id="upl1" width="150"/>
        </td>
        <td width="76%"  height="19" colspan="3">
        	<img src="../../images/upload.jpg" onclick="submitPage();" style="vertical-align:bottom; cursor:pointer"/>
            <input type="text" value="yep" name="hidtxt" style="visibility:hidden;"/>
        </td>
        </tr>
    
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr height="20">
        <td width="80%" class="normalfnth2" style="text-align:center;">
        	<div id="txtHint" style="text-align:center; width:954px; height:17px; background-color:#9BBFDD; color:#FFFFFF;">Order Upload</div>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt">
          <table width="954" cellpadding="0" cellspacing="1" bgcolor="#9BBFDD" id="">
          
            <tr>
              <td width="4%" bgcolor="#498CC2" height="25" class="normaltxtmidb2"><input type="checkbox" id="chkAll" onclick="selectAll();" /></td>	
              <td width="14%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
              <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">Style</td>
			  <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">PO</td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
              <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
			  <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Price</td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Delivery Date</td>
			</tr>
          </table>
        <div id="divcons"  style="overflow-x:hidden; overflow-y:scroll;  height:500px; width:100%;">
          <table width="954" cellpadding="0" cellspacing="1" bgcolor="#9BBFDD" id="tbliou">
          
            <tr>
              <td width="4%"></td>	
              <td width="14%"></td>
              <td width="15%"></td>
			  <td width="15%"></td>
              <td width="12%"></td>
              <td width="11%"></td>
			  <td width="11%"></td>
              <td width="10%"></td>
              <td width="12%"></td>
			</tr>
            <?php
			
			if($hidtxt!="")
			{
				// $filename = "c:\\orders.xlsx";
				
				$filename = $_SERVER['DOCUMENT_ROOT']."eshippingeam/OrdersXL/".$_FILES['filepath']['name'];//'\\ipn.log';
				
				//$filename = "..\\..\\OrdersXL\\".$_FILES['filepath']['name'];
  				//echo $filename;
	 $sheet1 = 1;
	 $arr = array(1=>'a','b','c','d','e','f','g','h');
	  
	 $sheet2 = "sheet2";
	  
	 $excel_app = new COM("Excel.application") or Die ("Did not connect");
	  
	 //$excel_app->Application->Visible = 1; #Make Excel visible.
	  
	 $Workbook = $excel_app->Workbooks->Open($filename) or Die("Did not open $filename $Workbook");
	  
	 $Worksheet = $Workbook->Worksheets($sheet1);
	  
	 $Worksheet->activate;
	  
	 $excel_cell = $Worksheet->Range("H1");
	  
	 $excel_cell->activate;
	 
	 	for($i=2; true;$i++)
		{
			$excel_cell1 = $Worksheet->Range($arr[1].$i);
			if($excel_cell1->value!="")
			{
	?>
    <tr bgcolor="#FFFFFF">
    <td style="text-align:center"><input type="checkbox" onclick="checkClick(this);" /></td>
    <?php
			}
			else
			{
				break;
			}
			for($j=1; $j<9;$j++)
	  		{
	  
			  $excel_cell = $Worksheet->Range($arr[$j].$i);  
			 
	  ?>
      		
			 <td style="text-align:center"><?php echo $excel_cell->value; ?></td>
	  <?php
			  
		   }
		  
	  ?>
      </tr>
      <?php	   
			
		}
	  
	 $excel_result = $excel_cell->value;
	  
		
	 $Workbook->Close;
	  
	 unset($Worksheet);
	  
	 unset($Workbook);
	  
	 $excel_app->Workbooks->Close();
	  
	 $excel_app->Quit();
	  
	 unset($excel_app);
  
			
			}
	
			
			?> 
          </table>
        </div></td>
        </tr>
        
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        
      
			
			<td width="41%">&nbsp;</td>    	
        
        <td width="9%"><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="updateiou('save');" /></td>
        
       
        <td width="49%"><a href="../../main.php"><img src="../../images/close.png" width="84" height="24" border="0" class="mouseover" /></a></td>
        <td width="1%">&nbsp;</td>    
      </tr>
    </table></td>
  </tr>
</table>
</form>


</body>
</html>


