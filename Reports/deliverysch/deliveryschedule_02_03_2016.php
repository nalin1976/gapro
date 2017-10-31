<?php 

session_start();

$backwardseperator = "../../";
//include "authentication.inc";

//require_once('class_deliveryschedule.php');

//$class_deliveryschedule = new deliveryschedule;

include "Connector.php"; 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delivery Schedule Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/delivery.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/deliveryschedule.js"></script>
<script language="javascript" type="text/javascript">

function dateArrange()
{
	
	if(document.getElementById("frmDateCheck").checked==false){
	document.getElementById("txtToDate").value="";
	document.getElementById("txtToDate").disabled=true;
	document.getElementById("txtFrmDate").value="";
	document.getElementById("txtFrmDate").disabled=true;
	}
	else{
	document.getElementById("txtToDate").disabled=false;
	document.getElementById("txtFrmDate").disabled=false;
	
	}
}

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

function SetCalendarDate(){

	//Get the current date
	var dt_current = new Date();
	
	var iCurrentMonth = dt_current.getMonth() + 1;
	var iCurrentYear = dt_current.getFullYear();
	
		
	document.getElementById('txtFrmDate').value = 01 + '/' + iCurrentMonth + '/' + iCurrentYear ; 
	
	switch(iCurrentMonth){
		
	
		case 1 : 	
		case 3 :
		case 5 :
		case 7 :
		case 8 :
		case 10 :
		case 12 :
			
			document.getElementById('txtToDate').value = 31 + '/' + iCurrentMonth + '/' + iCurrentYear ; 
			break;
			
		case 4 :
		case 6 :
		case 9 :
		case 11 :
		
			document.getElementById('txtToDate').value = 30 + '/' + iCurrentMonth + '/' + iCurrentYear ; 
			break;
			
		default:
			document.getElementById('txtToDate').value = 28 + '/' + iCurrentMonth + '/' + iCurrentYear ; 
			break;
			break;
	}	
	
}

</script>

</head>

<body onload="SetCalendarDate()">
<div id="div_blanket" style="background:#999999; opacity:0.5; z-index:9002; position:absolute; display:none;">
	<div style="z-index:9003; opacity:1;"><img src="../../images/485.gif" alt="Loading......" style=" position:absolute; top:300px; left:600px;" /></div>
</div>
<form id="frmDeliverySchedule">
<tr>
  <td><?php include '../../Header.php'; ?></td>
</tr>
<table width="1250px" class="bcgl1" border="0" align="center">
<tr>
	<td>
		<table width="100%" border="0">
        	<tr><td width="96%" class="mainHeading">Delivery Forcast</td></tr>
        
        </table>

	</td>
</tr>
<tr>
	<td>
    	<table border="0" width="100%" class="normalfnt">
        	<tr><td width="25%">&nbsp;</td>
            	<td width="33%" align="right">&nbsp;Product Category
                	<select id="cmbProductCategory" name="cmbProductCategory">
                    	<option value="-1"></option>
                        <?php
							
							$strSql = "SELECT intCatId, strCatName FROM productcategory WHERE intStatus = 1";
							$result = $db->RunQuery($strSql);
							
							while($rowProductCategory = mysql_fetch_array($result)){
								
								echo "<option value=\"".$rowProductCategory["intCatId"]."\">".$rowProductCategory["strCatName"]."</option>";
								
							}
							
							
						
						?>
                    </select>                	
                </td>
                <td width="32%">
                	<table width="100%" border="0" class="normalfnt">
                    	<tr><td width="39%" align="right">Buyers List&nbsp;</td>
                        	<td width="61%" align="right" >
                            	<select id="cmbBuyer" name="cmbBuyer">
                                	<option value="-1"></option>
                                    
                                    <?php 
										
										$SQL = "SELECT intBuyerID,strName FROM buyers b where intStatus='1';";	
										$result = $db->RunQuery($SQL);	
										
										while($row = mysql_fetch_array($result))
										{
											echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
										}
									
									?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="10%">&nbsp;Summary&nbsp;<span style="padding: 3px 3px 3px 3px;"><input type="checkbox" id="chkSummary" name="chkSummary" /></span></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
	<td>
    	<table border="0" width="100%">
        	<tr><td width="33%">&nbsp;</td>
            	
                <td width="47%">
                	<table width="100%" border="0" class="normalfnt">
                    	 <tr>
                    <td width="55%" align="right" ><!--<input type="checkbox" id="frmDateCheck"   name="frmDateCheck" class="txtbox" tabindex="5" onchange="dateArrange();" />-->&nbsp;&nbsp; From</td>
                    <td width="19%" align="right"><input name="txtFrmDate" value="<?php echo $_POST['txtFrmDate'];?>" type="text" class="txtbox" id="txtFrmDate" style="width:85px; text-align:right"  onmousedown="DisableRightClickEvent();" tabindex="5" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
                    <td width="7%" align="right"  >To</td>
                    <td width="19%" align="right"><input name="txtToDate" value="<?php echo $_POST['txtToDate'];?>" type="text"  class="txtbox" id="txtToDate" style="width:85px; text-align:right" tabindex="6"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;width:1px" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
                   
                   
                   
                  </tr>
                    </table>
                </td>
                 <td width="7%" valign="middle" align="right"><img src="../../images/search.png" onclick="ListSchedule()" /></td>
                <td width="13%"><img src="../../images/download.png" onclick="exportExcel()" /></td>
               
            </tr>
        </table>
    </td>
</tr>
<tr>
	<td width="100%">
    	<div style="width:1250px; height:550px; border:#06F thin solid; white-space:nowrap; overflow-x:scroll; overflow-y:scroll; z-index:9001; " id="divListing">
    	
        
        
        </div>	
    </td>
</tr>

</table>


</form>
</body>
</html>