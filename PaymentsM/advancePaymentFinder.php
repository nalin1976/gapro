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
      <td><table bordercolor="#162350" width="100%" border="0">
        <tr>
          <td width="4%">&nbsp;</td>
          <td  width="44%" class="head1" >&nbsp;</td>
          <td width="52%"  ><table width="479" height="40" border="0" cellpadding="0" cellspacing="0" class="normalfnt2BITAB">
            <tr>
              <td height="21" colspan="5" align="center" class="normalfntBtab">Payment Types </td>
            </tr>
            <tr class="containers">
              <td width="133" >&nbsp;</td>
              <?php 
					$type = $_POST["rdoType"];
					if($type=='G')
						$checkedG	= "checked=\"checked\"";
					else if($type=='W')
						$checkedW	= "checked=\"checked\"";
					else if($type=='B')
						$checkedB	= "checked=\"checked\"";
					else
						$checkedS	= "checked=\"checked\"";
				?>
              <td width="98" class="normalfnth2B" ><input name="rdoType" type="radio" <?php echo $checkedS; ?> value="S" id="rdoStyle" onclick="pageRefreshListing();" />
                  <span class="normalfntSMB">Style </span></td>
              <td width="16" class="normalfnth2B" >&nbsp;</td>
              <td width="98" class="normalfnth2B" ><input name="rdoType" type="radio" <?php echo $checkedG; ?> value="G" id="rdoGeneral" onclick="pageRefreshListing();" />
                  <span class="normalfntSMB">General </span></td>
              <td width="132" >&nbsp;</td>
            </tr>
            <tr class="containers">
              <td >&nbsp;</td>
              <td class="normalfnth2B" ><input name="rdoType" type="radio" <?php echo $checkedB; ?> value="B" id="rdoBulk" onclick="pageRefreshListing();"/>
                  <span class="normalfntSMB">Bulk </span></td>
              <td class="normalfnth2B" >&nbsp;</td>
              <td class="normalfnth2B" ><input name="rdoType" type="radio" disabled="disabled" <?php echo $checkedW; ?> value="W" id="rdoWash"  onclick="pageRefreshListing();"/>
                  <!--<span class="normalfntSMB">Wash </span></td>-->
              <td >&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3"><table width="100%" border="0">
            <tr>
              <td width="1%" height="32">&nbsp;</td>
              <td width="6%" class="normalfnt">Supplier</td>
              <td width="23%"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:200px" >
                <option value="0"></option>
					<?php
					$SQL = "SELECT distinct
							suppliers.strSupplierID,
							suppliers.strTitle
							FROM
							purchaseorderheader
							Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
							WHERE suppliers.intStatus=1
							ORDER BY
							suppliers.strTitle ASC";	
					$result = $db->RunQuery($SQL);		
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
					
					?>
                  </select>	</td>
              <td width="10%" class="normalfnt"> Date From </td>
              <td width="16%"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
			  
              <td width="8%" class="normalfnt">Date To </td>
              <td width="36%"><table width="100%" border="0">
                <tr>
                  <td width="46%"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
				  
                  <td width="28%"><span class="normalfnt"><img src="../images/search.png" alt="go"  class="mouseover" onclick="fillAvailableAdvData();" /></span></td>
                  <td width="27%"><a href="../main.php"><img src="../images/close.png"  border="0" /></a></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="3">
		  <div class="bcgl1" id="divAdvData"  style="width:945px;height:200px ; background:#FFFFFF">
		  <table id="tblAdvData" width="945" border="0" cellpadding="0" cellspacing="1" bordercolor="#162350" bgcolor="#CCCCFF" >
            <tr>
			  <td width="0%"  height="33" bgcolor="" class="grid_header"></td>
              <td width="15%" height="25" bgcolor="" class="grid_header">Payment No</td>
              <td width="15%" bgcolor="" class="grid_header">Date</td>
              <td width="17%" bgcolor="" class="grid_header">Amount </td>
              <td width="17%" bgcolor="" class="grid_header">Tax</td>
              <td width="17%" bgcolor="" class="grid_header">Total Amount </td>
              <td width="17%" bgcolor="" class="grid_header">View</td>
              <td width="2%" bgcolor="" class="grid_header">&nbsp;</td>
            </tr>
			<!--<tr>
              <td height="20" class="normalfnt">Payment No dfdf </td>
              <td height="20" class="normalfnt">Payment No dfdf </td>
              <td height="20" class="normalfnt" style="text-align:right">Payment No dfdf </td>
              <td height="20" class="normalfnt"><div align="center"><img src="../images/butt_1.png" width="15" height="15" /></div></td>
            </tr>-->
          </table>
		  </div>		  </td>
        </tr>
      </table></td>
    </tr>
    
  </table>
</form>
</div>
</div>
</body>
</html>
