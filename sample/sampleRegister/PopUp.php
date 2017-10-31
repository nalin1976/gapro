<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>

<div style="width: 470px; height: 320px; background-color: rgb(214, 231, 245); text-align: center; border: 1px solid rgb(3, 118, 191); position: absolute;" id="SampleRegisterOptPopup">



<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Sample Requisitions Pop Up</title>
<link type="text/css" rel="stylesheet" href="../../css/erpstyle.css">
<link type="text/css" rel="stylesheet" href="../../css/tableGrib.css">
<script src="../../js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="../../js/tablegrid.js" type="text/javascript"></script>

<script src="../../javascript/script.js"></script>
<script src="SampleRegisterFunction.js"></script> <!-- added on 02/03/2011 by Chandima Batuwita-->



<div>
	<div align="center">
		<div id="popup1" class="trans_layoutS">
		  <div class="trans_text">Sample Register Pop Up<span class="volu"></span></div>
		  <div style="overflow: scroll; height: 150px; width: 400px;">
              <table cellspacing="1" border="1" id="opt_table" class="transGrid" style="width: 400px;">
                <thead>
                  <tr>
                    <td colspan="4"><b>Sample Operators Pop UpDetails</b></td>
                  </tr>
                  <tr>
                    <td width="40%"><b>Select</b></td>
                    <td width="30%"><b>Operator Name</b></td>
                    <td width="30%"><b>Start Date</b></td>
                    <td width="30%"><b>No of Days</b></td>
                  </tr>
	             <tr><td><input type="checkbox" id="93" name="opt_checkbox"></td><td>GUINEA-BISSAU</td><td><input type="text" onClick="return showCalendar(1,'%Y-%m-%d');" id="1" readonly="true" name="txtbx_Issueddate" class="txtbox2"><input type="reset" onClick="return showCalendar(1, '%Y-%m-%d');" style="visibility: hidden; height: 1px ! important;" class="txtbox" name="reset"></td><td><input type="text" id="2/" name="No_of_days" class="txtbox2"></td></tr><tr><td><input type="checkbox" id="94" name="opt_checkbox"></td><td>GUYANA </td><td><input type="text" onClick="return showCalendar(2,'%Y-%m-%d');" id="2" readonly="true" name="txtbx_Issueddate" class="txtbox2"><input type="reset" onClick="return showCalendar(2, '%Y-%m-%d');" style="visibility: hidden; height: 1px ! important;" class="txtbox" name="reset"></td><td><input type="text" id="3/" name="No_of_days" class="txtbox2"></td></tr><tr><td><input type="checkbox" id="95" name="opt_checkbox"></td><td>HAITI </td><td><input type="text" onClick="return showCalendar(3,'%Y-%m-%d');" id="3" readonly="true" name="txtbx_Issueddate" class="txtbox2"><input type="reset" onClick="return showCalendar(3, '%Y-%m-%d');" style="visibility: hidden; height: 1px ! important;" class="txtbox" name="reset"></td><td><input type="text" id="4/" name="No_of_days" class="txtbox2"></td></tr><tr>
                    <td width="40%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                  </tr>
                </thead>
			</table>	
		  </div>
				<br>
			<table border="0" align="center" width="367">
      			<tbody><tr>
					<td width="15%">&nbsp;</td>
					<td width="23%"><img width="80" onClick="validateOperatorPopUp();" src="../../images/save.png"></td>
					<td width="26%"><img width="90" onClick="closePopUp();" alt="close" src="../../images/close.png"></td>	
					<td width="10%">&nbsp;</td>
      			</tr>
		  </tbody></table>
	  </div>
  </div>
		</div>
	</div>