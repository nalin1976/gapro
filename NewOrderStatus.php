<?php
	session_start();
	include "Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ORDER STATUS</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />


<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
-->
</style>


<script type="text/javascript" src="javascript/NewOrderStatus.js"></script>
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="javascript/script.js" type="text/javascript"></script>



<!--<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="javascript/script.js" type="text/javascript"></script>-->






</head>


<body>
<form name="frmOrderStatus" id="frmOrderStatus">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include 'Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="3%" height="24" class="normalfnt">Company</td>
            <td width="6%" class="normalfnt"><select name="cboCompanyID" class="txtbox" id="cboCompanyID" style="width:200px">
			<?php
			
				$SQL = "SELECT intCompanyID,strName FROM companies  where intStatus='1' order by strName;";
				
				$result = $db->RunQuery($SQL);
				
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
				if ($_POST["cboCompanyID"] ==  $row["intCompanyID"])
				echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
				else
				echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
				}
			
			?>
                  </select>            </td>
            <td width="10px" class="normalfnt">&nbsp;</td>
            <td width="150px" class="normalfnt">Search by Customer</td>
            <td width="100px" class="normalfnt"><select name="cboCustomer" class="txtbox" id="cboCustomer" style="width:150px">
			<?php
			
				$SQL_customer = "SELECT buyers.intBuyerID,buyers.strName from buyers WHERE buyers.intStatus='1' order by strName;";
				
				$result_customer = $db->RunQuery($SQL_customer);
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result_customer))
				{
				if ($_POST["cbobuyerpono"] ==  $row["intBuyerID"])
				echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
				else
				echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
				}
			
			?>
                  </select></td>
            <td width="100px" class="normalfnt">Style ID Like</td>
            <td width="100px" class="normalfnt"><input name="txtstyleid" type="text" class="txtbox" id="txtstyleid" /></td>
            <td width="100px" class="normalfnt"><img src="images/search.png" alt="search" width="80" height="24" onclick="getStyleDeialsCount();getStyleDeials(1);" /></td>
            </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="105%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="21" bgcolor="#9BBFDD" ><div align="center" >
		<table width="105%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
		<td width="53%" height="21"  class="normalfnth2"><div align="center">Issue Items</div></td>
		<td width="0%" class="normalfnt"  >&nbsp;</td>
		<td width="47%" class="normalfnt"  ><table width="454" border="0" cellpadding="0" cellspacing="0" class="tablezRED" id="tblCaption">
          <tr>
            <td width="89"><div align="center">No of Styles :</div></td>
            <td width="77">0</td>
            <td width="49">From :</td>
            <td width="56">0</td>
            <td width="30">To :</td>
            <td width="56">0</td>
            <td width="23" onclick="getStyleDeials(1)"><img src="images/fb.png" width="18" height="19" /></td>
            <td width="23" onclick="getStyleDeials(2)"><img src="images/fw.png" width="18" height="19" /></td>
            <td width="23" onclick="getStyleDeials(3)"><img src="images/bw.png" width="18" height="19" /></td>
            <td width="26" onclick="getStyleDeials(4)"><img src="images/ff.png" width="18" height="19" /></td>
          </tr>
        </table></td>
		</tr>
		</table>
		</div></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divStyles" style="overflow:scroll; height:300px; width:970px;">
          <table width="5300" cellpadding="0" cellspacing="0" id="tblStyles">
            <tr class="normaltxtmidb2">
              <td style="width:20px" width="10" height="33" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
              <td style="width:200px" width="100" bgcolor="#498CC2" class="normaltxtmidb2"><span class="normaltxtmidb2" style="width:200px">Customer</span></td>
              <td style="width:150px" bgcolor="#498CC2" class="normaltxtmidb2">Style ID</td>
              <td style="width:200px" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
              <td width="150px" bgcolor="#498CC2" class="normaltxtmidb2">Buyer PO</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">FOB</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">SMV</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Est. YY</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Act YY</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">CM</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Order Date</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Sizw</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">GMT ETD</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Rev. ETD</td>
              <td width="150px" bgcolor="#498CC2" class="normaltxtmidb2">PLND Cut Date</td>
              <td width="150px" bgcolor="#498CC2" class="normaltxtmidb2">Act Cut Date</td>
              <td width="150px" bgcolor="#498CC2" class="normaltxtmidb2">PLND Input Date</td>
              <td width="150px" bgcolor="#498CC2" class="normaltxtmidb2">Act Input Date</td>
              <td width="150px" bgcolor="#498CC2" class="normaltxtmidb2">PLND Finish Date</td>
              <td width="150px" bgcolor="#498CC2" class="normaltxtmidb2">Act Shipment Date</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Shipment QTY</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">PLND Finish Date</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Act Shipment Date</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Shipment Date</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">+/-</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Feb PO</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">SMPL YDG RCVD</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Lab Dip Aprvd</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Fab Test Sent</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Feb tet Passd</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Bulk Approved</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Fab. Inspect</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">PITN ORG SMP TGT</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">PTTD RCVD</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">ORG SMPL RCVD</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">SIZE - QTY</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">SIZE - SIZE</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">SIZE - TGT</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">SIZE - SENT</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">SIZE - APVD</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Gold Seal - SIZE</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Gold Seal - TGT</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Gold Seal - SENT</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">Gold Seal - APVD</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">TESTING - QTY</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">TESTING - SIZE</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">TESTING - TGT</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">TESTING - SENT</td>
              <td width="100px" bgcolor="#498CC2" class="normaltxtmidb2">TESTING - APVD</td>
            </tr>
            <!--<tr>
              <td bgcolor="#CCCCCC" class="normalfnt">WWWWWWWWWW</td>
              <td bgcolor="#CCCCCC" class="normalfnt">FABR</td>
              <td bgcolor="#CCCCCC" class="normalfnt">POC1010</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><img src="images/add.png" width="16" height="16" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0.250</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><img src="images/add.png" width="16" height="16" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0.250</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="dtpPLNDCutDate" type="text" class="txtbox" id="dtpPLNDCutDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="dtpActCutDate" type="text" class="txtbox" id="dtpActCutDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="dtpPLNDInputDate" type="text" class="txtbox" id="dtpPLNDInputDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="dtpActInputDate" type="text" class="txtbox" id="dtpActInputDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="dtpPLNDFinishDate" type="text" class="txtbox" id="dtpPLNDFinishDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid" width="150px"><input name="dtpActShipmentDate" type="text" class="txtbox" id="dtpActShipmentDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="txtData2" type="text" id="txtData2" class="txtbox" size="15" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#CCCCCC" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#99FF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#99FF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#99FF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#99FF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#99FF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#99FF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#99FF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
              <td bgcolor="#FFFF99" class="normalfntMid"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
            </tr>-->
            <!--/*            <tr>
              <td bgcolor="#CCCCCC"><div align="center">
                  <input type="checkbox" name="chksel2" id="chksel2" />
              </div></td>
              <td bgcolor="#CCCCCC" class="normalfnt">ACCE</td>
              <td bgcolor="#CCCCCC" class="normalfnt">ZIPPR1010</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0.254</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0.254</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">145.24</td>
              <td bgcolor="#99FF99" class="normalfntMid">442</td>
              <td bgcolor="#99FF99" class="normalfntMid">.2542</td>
              <td bgcolor="#99FF99" class="normalfntMid">0.254</td>
              <td bgcolor="#99FF99" class="normalfntMid">0.254</td>
              <td bgcolor="#99FF99" class="normalfntMid">145.24</td>
              <td bgcolor="#99FF99" class="normalfntMid">442</td>
              <td bgcolor="#99FF99" class="normalfntMid">.2542</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.254</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.254</td>
              <td bgcolor="#FFFF99" class="normalfntMid">145.24</td>
              <td bgcolor="#FFFF99" class="normalfntMid">442</td>
              <td bgcolor="#FFFF99" class="normalfntMid">.2542</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.254</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.254</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.254</td>
              <td bgcolor="#FFFF99" class="normalfntMid">145.24</td>
              <td bgcolor="#FFFF99" class="normalfntMid">442</td>
              <td bgcolor="#FFFF99" class="normalfntMid">.2542</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.254</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.254</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.254</td>
              <td bgcolor="#FFFF99" class="normalfntMid">145.24</td>
              <td bgcolor="#FFFF99" class="normalfntMid">442</td>
              <td bgcolor="#FFFF99" class="normalfntMid">.2542</td>
            </tr>
            <tr>
              <td bgcolor="#CCCCCC"><div align="center">
                  <input type="checkbox" name="chksel3" id="chksel3" />
              </div></td>
              <td bgcolor="#CCCCCC" class="normalfnt">ACCE</td>
              <td bgcolor="#CCCCCC" class="normalfnt">LABLE1010</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">12</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0.175</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0.175</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">&nbsp;</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">10</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">0</td>
              <td bgcolor="#CCCCCC" class="normalfntMid">789.21</td>
              <td bgcolor="#99FF99" class="normalfntMid">4247</td>
              <td bgcolor="#99FF99" class="normalfntMid">.2241</td>
              <td bgcolor="#99FF99" class="normalfntMid">0.175</td>
              <td bgcolor="#99FF99" class="normalfntMid">0.175</td>
              <td bgcolor="#99FF99" class="normalfntMid">789.21</td>
              <td bgcolor="#99FF99" class="normalfntMid">4247</td>
              <td bgcolor="#99FF99" class="normalfntMid">.2241</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.175</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.175</td>
              <td bgcolor="#FFFF99" class="normalfntMid">789.21</td>
              <td bgcolor="#FFFF99" class="normalfntMid">4247</td>
              <td bgcolor="#FFFF99" class="normalfntMid">.2241</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.175</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.175</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.175</td>
              <td bgcolor="#FFFF99" class="normalfntMid">789.21</td>
              <td bgcolor="#FFFF99" class="normalfntMid">4247</td>
              <td bgcolor="#FFFF99" class="normalfntMid">.2241</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.175</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.175</td>
              <td bgcolor="#FFFF99" class="normalfntMid">0.175</td>
              <td bgcolor="#FFFF99" class="normalfntMid">789.21</td>
              <td bgcolor="#FFFF99" class="normalfntMid">4247</td>
              <td bgcolor="#FFFF99" class="normalfntMid">.2241</td>
            </tr>*/-->
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="62%" height="29"><table width="100%" border="0">
          <tr>
            <td width="5%" ><input type="text" name="textfield" size="3" class="osc1TXT" disabled="disabled"></td>
            <td width="23%" class="normalfnt">Order Placement</td>
            <td width="6%" ><input type="text" name="textfield" size="3" class="osc2TXT" disabled="disabled"></td>
            <td width="21%" class="normalfnt">Fabric Purchase</td>
            <td width="5%" ><input type="text" name="textfield" size="3" class="osc3TXT" disabled="disabled"></td>
            <td width="10%" class="normalfnt">Sample</td>
            <td width="7%" ><input type="text" name="textfield" size="3" class="osc4TXT" disabled="disabled"></td>
            <td width="23%" class="normalfnt">Trim Purchasing</td>
            </tr>
        </table></td>
        <td width="11%"><img src="images/ok.png" width="102" height="24"  onclick="getPOAmtCategoryWise()" /></td>
        <td width="11%"><img src="images/report.png" width="108" height="24" onclick="ShowPreOrderReport();" /></td>
        <td width="11%"><img src="images/close.png" width="97" height="24" border="0" onclick="getCategories()" /></td>
        <td width="5%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>