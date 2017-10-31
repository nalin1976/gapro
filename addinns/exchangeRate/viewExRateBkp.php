<?php 
session_start();
$backwardseperator = "../../";

include "../../Connector.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>View Exchange Rate</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css">
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css">
<script src="../../calendar/calendar.js" type="text/javascript" language="javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

<script src="exRate.js" type="text/javascript" language="javascript"></script>
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
		$Dfrom = $_POST["txtDfrom"];
	?>
<body>
<form name="frmViewDetails" method="post" action="" id="frmViewDetails">
  <table width="800" border="0">
    <tr>
      <td class="head1" align="center">Exchange Rate Details</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><table width="800" border="0">
        <tr>
          <td class="normalfnBLD1">Date From :</td>
          <td><input name="txtDfrom" type="text"  class="txtbox" id="txtDfrom" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $Dfrom; ?>"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
          <td class="normalfnBLD1">Date To :</td>
          <td><input name="txtDto" type="text"  class="txtbox" id="txtDto" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $_POST["txtDto"]; ?>"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
          <td><img src="../../images/view2.png" width="62" height="21" class="mouseover" onClick="viewDetails()"></td>
        </tr>
      </table></td>
    </tr>
    <?php 
   
   $arrDfrom = explode('-',$_POST["txtDfrom"]);
   $arrDto   = explode('-',$_POST["txtDto"]);
   
   ?>
    <tr>
      <td><?php  
	  //$my_time = strtotime($_POST["txtDfrom"]); 
	  ///echo date('Y-m-d',$my_time);?></td>
    </tr>
    <tr>
      <td><?php if($arrDfrom[1]>$arrDto[1])
	  				echo 'Invalid Date Range';?></td>
    </tr>
   
    <tr>
      <td><table width="250" border="1" align="center">
        <tr>
          <td width="250" class="normalfntBtab">Country</td>
          <td width="107" class="normalfntBtab">Currency Type</td>
          <?php 
		  if($arrDto[1]==$arrDfrom[1])
		  {
		  		for($i=intval($arrDfrom[2]); $i<=$arrDto[2];$i++)
				{
					if($i<10)
						$i = '0'.$i;
					
							
		  ?>
          <td width="117" class="normalfntBtab"><?php echo $arrDfrom[1].'/'.$i; ?></td>
          <?php 
		  	}
		  }
		  if($arrDto[1]>$arrDfrom[1])
		  {
		  $DaysinMonth = cal_days_in_month(CAL_GREGORIAN, $arrDfrom[1], $arrDfrom[0]) ; 

		  for($i=intval($arrDfrom[2]); $i<=$DaysinMonth;$i++)
				{
					if($i<10)
						$i = '0'.$i;
					
							
		  ?>
          <td width="117" class="normalfntBtab"><?php echo $arrDfrom[1].'/'.$i; ?></td>
          <?php 
		  	}
			   for($j=1; $j<=$arrDto[2];$j++)
			   {
			   		if($j<10)
						$j = '0'.$j;
			   ?>
               	 <td width="117" class="normalfntBtab"><?php echo $arrDto[1].'/'.$j; ?></td>	
               <?php
			   }
		  }
		  ?>
        </tr>
        <tr>
         
        <?php 
			$SQL = "select strCurrency,intCurID,intConID from currencytypes ";
			$result = $db->RunQuery($SQL);
			if($Dfrom != '')
			{
			while($row=mysql_fetch_array($result))
			{
			$currID = $row["strCurrency"];
			$cID = $row["intCurID"];
		?>
		  <td class="normalfnt"><?php echo GetCountry($row["intConID"]);?></td>
          <td class="normalfnt"><?php echo $row["strCurrency"]; ?></td>
        <?php 
		  if($arrDfrom[1]==$arrDto[1])
		  {
		  		for($i=intval($arrDfrom[2]); $i<=intval($arrDto[2]);$i++)
				{
					if($i<10)
						$j = '0'.$i;
					else
						$j = $i;
						
				$dtmDate = $arrDfrom[0].'-'.$arrDfrom[1].'-'.$j; 
				$SQLEx = " select * from exchangerate
where dateFrom<= '$dtmDate' and dateTo>='$dtmDate' and currencyID='$cID'";
				
				$ckAv = $db->CheckRecordAvailability($SQLEx);
				
				if($ckAv == 1)
				{
				$resultD = $db->RunQuery($SQLEx);	
				while($rowD = mysql_fetch_array($resultD))
				{
		  ?>
          <td width="117" class="normalfnt"><?php echo $rowD["rate"]; ?></td>
          <?php
		         }
				 }
				 else
				 {
				 ?>
                  <td width="117">&nbsp;</td>
                 <?php
				 
				 } 
		  	}
		  }
		  
		   if($arrDto[1]>$arrDfrom[1])
		  {
		  $DaysinMonth = cal_days_in_month(CAL_GREGORIAN, $arrDfrom[1], $arrDfrom[0]) ; 

		  for($i=intval($arrDfrom[2]); $i<=$DaysinMonth;$i++)
				{
					if($i<10)
						$i = '0'.$i;
					$dtmDate = $arrDfrom[0].'-'.$arrDfrom[1].'-'.$i; 
					$SQLEx = " select * from exchangerate
where dateFrom<= '$dtmDate' and dateTo>='$dtmDate' and currencyID='$cID'";
					$ckAv = $db->CheckRecordAvailability($SQLEx);
				
				if($ckAv == 1)
				{
				$resultD = $db->RunQuery($SQLEx);	
				while($rowD = mysql_fetch_array($resultD))
				{		
		  ?>
          <td width="117" class="normalfnt"><?php echo $rowD["rate"]; ?></td>
           <?php
		         }
				 }
				 else
				 {
				 ?>
                  <td width="117">&nbsp;</td>
                 <?php
				 
				 } ?>
          <?php 
		  	}
			   for($j=1; $j<=$arrDto[2];$j++)
			   {
			   		if($j<10)
						$j = '0'.$j;
						$dtmDateto = $arrDto[0].'-'.$arrDto[1].'-'.$j; 
						$SQLEx = " select * from exchangerate
where dateFrom<= '$dtmDateto' and dateTo>='$dtmDateto' and currencyID='$cID'";
					$ckAv = $db->CheckRecordAvailability($SQLEx);
				
				if($ckAv == 1)
				{
				$resultD = $db->RunQuery($SQLEx);	
				while($rowD = mysql_fetch_array($resultD))
				{	
			   ?>
               	 <td width="117" class="normalfnt"><?php echo $rowD["rate"]; ?></td>
                 <?php
		         }
				 }
				 else
				 {
				 ?>
                  <td width="117">&nbsp;</td>
                 <?php
				 
				 } ?>	
               <?php
			   }
		  } ?>
        </tr>
         <?php 
		 }
		  }
		  ?>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <script language="javascript" type="text/javascript">
  function viewDetails()
  {
  	 document.getElementById('frmViewDetails').submit();
  }
  </script>
</form>
<?php
function GetCountry($countryCode)
{
	global $db;
	$sql="select strCountry from country where intConID='$countryCode'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strCountry"];
	}
}
?>
</body>
</html>
