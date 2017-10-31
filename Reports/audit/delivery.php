<?php
session_start();
$backwardseperator = "../../";

include "../../Connector.php"; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delivery Schedule Audit</title>
<link href="../../js/jquery-ui.css" type="text/css" rel="stylesheet" />
<link href="../../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<link href="../../javascript/calendar/theme.css" type="text/css" rel="stylesheet" />


<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>

<script src="../../js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="../../js/jquery-ui.min.js" type="text/javascript"></script>


<style type="text/css">
body{ font-size:11px;} 
.mainFrame{border:#FCB334 thin solid; border-radius:3px; padding:200px;}
.blankWall{padding:20px; border-left:#FCB334 thin solid; border-right:#FCB334 thin solid}
.labelText{font-size:11px; font-weight:bold;}
.selectText{font-size:11px; }
.RightBorder{border-right:#FCB334 thin solid;}
.LeftBorder{border-left:#FCB334 thin solid;}
.labelPadding{padding: 9px;}
.textPadding{padding: 18px;}
.bottomLeftRight{border-left:#FCB334 thin solid; 
    border-bottom-left-radius:3px; 
    border-bottom:#FCB334 thin solid;
    border-right:#FCB334 thin solid;
    border-bottom-right-radius:3px;
  }
  .LRBorder{border-left:#FCB334 thin solid; border-right:#FCB334 thin solid;}

</style>
<style>
  
  .custom-combobox {
    position: relative;
    display: inline-block;
   }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
  
  .ui-autocomplete {
    max-height: 300px;
    overflow-y: auto;   /* prevent horizontal scrollbar */
    overflow-x: hidden; /* add padding to account for vertical scrollbar */
    z-index:1000 !important;
	}
</style>

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

<script type="text/javascript"> 
 $(document).ready(function (){

    $("#cmbStyleId").change(function(){

        var styleId = $(this).val();

        $("#cmbSCNo").val(styleId);
    });

    $("#cmbSCNo").change(function(){
       var styleId = $(this).val();

       $("#cmbStyleId").val(styleId);
    });

    $("#btnReport").click(function(){

      var styleCode = $("#cmbSCNo").val();
      var fromDate  = $("#dtmDateFrom").val();
      var toDate    = $("#dtmDateTo").val();

      var option    = 0;



      if((styleCode == -1) && (fromDate == "")){
        alert(" Please select required selection"); return;
      }

      if((fromDate != "") && (toDate == "")){
        alert("Please select To-Date  to view report"); return;
      }

      if((styleCode != -1) && (fromDate == "")){
        option = 1;
      }

      if((fromDate != "") && (toDate != "")){
        option = 2;
      }

      

      var url = "rptdeliveryaudit.php?opt="+option+"&stylecode="+styleCode+"&frmdate="+fromDate+"&todate="+toDate;
      window.open(url);

    });

 });
</script>

</head>

<body>
<div class="container">
	<div class="row" >
   	  <div class="col-lg-12 col-sm-12" ><?php include '../../Header.php'; ?></div>
      <div class="col-lg-1">&nbsp;</div>
        <div class="col-lg-10">
            <div class="col-lg-12 col-sm-12 blankWall">&nbsp;</div>
        	  <div class="col-lg-1 labelText LeftBorder labelPadding">&nbsp;Style No</div>
            <div class="col-lg-3 col-sm-3">
            	<select id="cmbStyleId" name="cmbStyleId" class="form-control selectText">
                  <option value="-1"></option>
                	<?php 

                      $sql = " SELECT * FROM orders ";
                      $results = $db->RunQuery($sql);

                      while($row = mysql_fetch_array($results)){

                         echo "<option value=\"".$row["intStyleId"]."\">".$row["strStyle"]."</option>"; 

                      }

                  ?>
                </select>
                
            </div>    
            <div class="col-lg-8 labelText RightBorder labelPadding">&nbsp;</div>     
            <div class="col-lg-12 LRBorder" >&nbsp;</div>
            
            <div class="col-lg-1 labelText LeftBorder labelPadding">&nbsp;SC No</div>
            <div class="col-lg-3">
               <select id="cmbSCNo" name="cmbSCNo" class="form-control selectText">
                  <option value="-1"></option>
               <?php
                $sql = " SELECT * FROM specification ORDER BY intSRNO DESC ";
                      $results = $db->RunQuery($sql);

                      while($row = mysql_fetch_array($results)){

                         echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>"; 

                      }
               ?>
             </select>
             
            </div>  
            <div class="col-lg-8 labelText RightBorder labelPadding">&nbsp;</div> 
            <div class="col-lg-12 LRBorder">&nbsp;</div>
        	  <div class="col-lg-1 labelText LeftBorder textPadding selectText">&nbsp;From</div>
            <div class="col-lg-3 "><input type="text" class ="form-control" id="dtmDateFrom" onclick="return showCalendar(this.id, '%Y/%m/%d');"><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></div>
            
            <div class="col-lg-1 labelText textPadding">&nbsp;To</div>
            <div class="col-lg-3"><input type="text" class="form-control" id="dtmDateTo" onclick="return showCalendar(this.id, '%Y/%m/%d');"><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></div>
            <div class="col-lg-4 RightBorder textPadding">&nbsp;</div>
            <div class="col-lg-12 LRBorder labelPadding">&nbsp;</div>
            <div class="col-lg-6 LeftBorder labelPadding">&nbsp;</div>
            <div class="col-lg-3">
              <button type="button" class="btn btn-warning btn-md" style="font-weight:bold;" id="btnReport" >View</button>&nbsp;
              <button type="button" class="btn btn-warning btn-md" style="font-weight:bold;" >Close</button>
            </div>
            <div class="col-lg-3 RightBorder labelPadding">&nbsp;</div>
            <div class="col-lg-12 bottomLeftRight labelPadding">&nbsp;</div>
        </div>
      
      
    </div>
</div> 


<script src="../../bootstrap/js/jquery.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<script src="../../bootstrap/js/bootstrap.min.js"></script> 
</body>
</html>
