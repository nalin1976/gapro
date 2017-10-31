<?php

	include "../Connector.php";
	include "../classes/class_buyer.php";
	$backwardseperator = "../";
	
	$class_buyer = new Buyer();
	$class_buyer->SetConnection($db);
	
	$resBuyerList 	= $class_buyer->GetBuyerList();
	
	$currentDate	= date('d/m/Y');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript" src="../js/jquery-1.9.1.js" language="javascript"></script>
<title>Delivery Cut Off Report</title>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="../javascript/deliverycutoff.js"></script>
<script type="text/javascript">

function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
	// if we add this call we close the calendar on single-click.
	// just to exemplify both cases, we are using this only for the 1st
	// and the 3rd field, while 2nd and 4th will still require double-click.
	cal.callCloseHandler();
}

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

function closeHandler(cal) {
  cal.hide();                        // hide the calendar
	//  cal.destroy();
  _dynarch_popupCalendar = null;
}

</script>
</head>

<body>
<table width="100%" height="443" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  		<table border="0" width="100%" cellpadding="1" cellspacing="0">
         <tr height="25">
        	<td width="45%">&nbsp;</td>
            <td width="6%" class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buyer</td>
            <td width="9%">
            	<select id="cmbBuyer" name="cmbBuyer">
                    <option value="-1"></option>
                    <?php 
						
						while($rowBuyers = mysql_fetch_array($resBuyerList)){
							
							 echo "<option value=\"". $rowBuyers["intBuyerID"] ."\">" . $rowBuyers["strName"] ."</option>" ;
						}
                    ?>
                </select>
            </td>
            <td width="5%" class="normalfnt" align="right">&nbsp;&nbsp;&nbsp;Date</td>
            <td width="16%"><input name="txtCutOffDate" value="<?php echo $currentDate ;?>" type="text" class="txtbox" id="txtCutOffDate" style="width:148px"  onmousedown="DisableRightClickEvent();" tabindex="5" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
            <td width="19%" class="normalfnt" align="right">
            	<img src="../images/search.png" id="cmdSearch" />&nbsp;&nbsp;
                <img src="../images/exceldw.gif" id="cmdExcelFile" />
            </td>
          </tr>  
        </table>
  	  </td>
  </tr>
   <tr><td>&nbsp;</td></tr>
  <tr><td height="380" valign="top">
	  <table border="0" width="100%" cellpadding="1" cellspacing="0">
        	<tr><td width="11%" height="379">&nbsp;</td>
            	<td width="78%" valign="top">
                	<div style="width:100%; border:#FFAB33 thin solid; height:379px; border-bottom-left-radius: 10px; overflow-y:scroll; box-shadow:5px 5px 5px #888888">
                    	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                			<thead>
                            	<tr class="mainHeading4" height="25"><td width="6%">SC No</td>
                                	<td width="14%">Style</td>
                                    <td width="12%">Merchandiser</td>
                                    <td width="22%">Buyer</td>
                                    <td width="14%">Buyer PO</td>
                                    <td width="11%">Delivery Qty</td>
                                    <td width="12%">Cut Off Date</td>
                                    <td width="9%">Delivery Date</td>
                                </tr>
                            </thead>
                            <tbody id="tbDeliveries">                            	
                            </tbody>
                		</table>
                	</div>
                </td>
                <td width="11%">&nbsp;</td>
          </tr>
        </table>
  	  </td>
  </tr>
</table>  
</body>
</html>

