<?php
	session_start();
	
	include "../Connector.php";
$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro:Advance Payments Finder</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
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


</head>
<script src="advancepayment.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>


<body onload="setDefaultDateofFinder()">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Advance Payments Finder<span class="vol"></span><span id="advancePayments_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="form1" name="form1" method="post" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="85%" class="head1" >
		  <table border="0">
		  	<tr>
				<td width="58" class="normalfnt">Supplier</td>
				<td width="223" class="normalfnt"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:200px" >
                  <option value=""></option>
                  <?php
					$SQL = "SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus=1 ORDER BY strTitle;";	
					$result = $db->RunQuery($SQL);		
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
					
					?>
                </select></td>
				<td width="28" class="normalfnt"><input type="checkbox" onclick="edDate(this);" name="chk" id="chk" /></td>
				<td width="69" class="normalfnt">Date From </td>
				<td width="103" class="normalfnt"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');" disabled="disabled"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width=2px;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
				<td width="60" class="normalfnt">Date To </td>
				<td width="100" class="normalfnt"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');" disabled="disabled"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
				<td width="111"><table cellspacing="0" cellpadding="0">
				  <tr>
                    <td width="96" class="normalfnt">Payment Type</td>
				    </tr>
				  </table>				</td>
				<td width="157"  > <?php 
			  $type = $_POST["cboPaymentType"];
			  $checked	= "selected=\"selected\""; 
		  ?>
		  <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefreshListing();">
		  	<option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
			<option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
			<option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
			<option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
		  </select></td>
			</tr>
			<tr>
				<td class="normalfnt">PO No</td>
				<td><input type="text"  id="txtPoNo" name="txtPoNo" style="width:200px"/></td>
				<td class="normalfnt"></td>
				<td class="normalfnt"></td>
				<td class="normalfnt"></td>
				<td class="normalfnt"></td>
				<td class="normalfnt"></td>
				<td class="normalfnt" style="text-align:right;">&nbsp;</td>
				<td class="normalfnt"><span class="normalfnt" style="text-align:left;"><img src="../images/search.png" alt="go"  class="mouseover" onclick="fillAvailableAdvData();" /></span></td>
			</tr>
		  </table>		  </td>
        </tr>
          <td colspan="3">
		  <div class="bcgl1" id="divAdvData"  style="overflow: -moz-scrollbars-vertical; width:945px;height:200px ; background:#FFFFFF">
		  <table id="tblAdvData" width="922" border="0" cellpadding="0" cellspacing="1" bordercolor="#162350" bgcolor="#CCCCFF" >
		  	<thead>
            <tr>
			  <td width="10%"  height="20" bgcolor="" class="grid_header">PO No</td>
              <td width="16%" height="" bgcolor="" class="grid_header">Payment No</td>
              <td width="12%" bgcolor="" class="grid_header">Date</td>
              <td width="16%" bgcolor="" class="grid_header">Amount </td>
              <td width="12%" bgcolor="" class="grid_header">Tax</td>
              <td width="16%" bgcolor="" class="grid_header">Total Amount </td>
              <td width="10%" bgcolor="" class="grid_header">View</td>
            </tr>
			</thead>
			<tbody>
			</tbody>
          </table>
		  </div>		  </td>
        </tr>
		<tr>
			 <td align="center"><img src="../images/new.png" border="0" onclick="clearAdPay();" />
			 <span class="normalfnt"><a href="../main.php"><img src="../images/close.png"  border="0" /></a></span></td>
        </tr>

      </table></td>
    </tr>
    
  </table>
</form>
</div>
</div>
</body>
</html>
