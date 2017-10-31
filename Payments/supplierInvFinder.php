<?php
session_start();
include "../Connector.php";
$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web - Invoices Finder</title>
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
<script src="supplierInvFinder.js" type="text/javascript"></script>


<body onload="InitializeInvoiceFinder();">

<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr>
    <tr>
    <td>
    <table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
    <tr>
    		<td class="mainHeading">Supplier Invoice List</td>
		</tr>
    <tr>
          <td colspan="2"><table width="100%" border="0" class="bcgl1">
            <tr>
              <td width="1%" height="32" rowspan="3">&nbsp;</td>
              <td width="8%" class="normalfnt">Invoice No </td>
              <td colspan="3"><span class="normalfnt">
                <input name="txtinvoiceno" type="text" class="txtbox" id="txtinvoiceno" size="15" />
              </span></td>
              <td width="10%" class="normalfnt">Entry No</td>
              <td><input type="text" name="txtEntryNo" id="txtEntryNo" size="15"/></td>
              <td colspan="2" ><table width="321" height="25" class="tableBorder" border="0" cellpadding="0" cellspacing="0"  >
                <tr >
                  <td width="205" height="25" class="normalfnth2Bm" >Payment Type</td>
                  <td width="265" ><select name="cboPymentType" class="txtbox" id="cboPymentType" style="width:150px" onchange="SearchInvoices()" >
                    <?php 
								$strSQL="SELECT strTypeID,strDescription FROM paymenttype ORDER BY intID";
								$result = $db->RunQuery($strSQL);
								while($row = mysql_fetch_array($result))
								{
									echo "<option value=\"". $row["strTypeID"] ."\">" . $row["strDescription"] ."</option>" ;
								}
								
							?>
                  </select></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td class="normalfnt">Date From</td>
              <td colspan="3"><span class="normalfnt">
                <input disabled="disabled" style="background-color:#CCC" name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
              </span></td>
              <td><span class="normalfnt">Date To</span></td>
              <td width="26%"><span class="normalfnt">
                <input disabled="disabled"  style="background-color:#CCC"  name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
              </span>
              <input type="checkbox" id="chkActInAct" name="chkActInAct"  onclick="actInAct(this);"/> </td>
              <td width="8%">&nbsp;</td>
              <td width="31%">&nbsp;</td>
              </tr>
            <tr>
              <td height="21" class="normalfnt">Paid</td>
              <td width="5%"><span class="normalfnt">
                <input name="paid" id="paid" type="checkbox" value="" />
              </span></td>
              <td width="5%"><span class="normalfnt">UnPaid</span></td>
              <td width="6%"><span class="normalfnt">
                <input name="unpaid" id="unpaid" type="checkbox" value="" />
              </span></td>
              <td class="normalfnt">Supplier</td>
              <td class="normalfnt"><select name="cbosupplier" class="txtbox" id="cbosupplier" style="width:240px" > 
              <option value="0"></option>
              <?php 
			  		$sql="SELECT strSupplierID AS SupID, strTitle AS SupNm FROM suppliers WHERE intstatus = 1 ORDER BY SupNm ASC;";
			  		$res=$db->RunQuery($sql);
					while($row=mysql_fetch_array($res))
					{  ?>
						<option value="<?php echo $row['SupID'];?>"	><?php echo $row['SupNm'];?></option>	
               
               <?php } ?>
              </select></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt"><div align="right"><img src="../images/search.png" alt="go" width="80" height="24" class="mouseover" onclick="SearchInvoices();" /></div></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2">
		  <div id="divinvData" style="width:945px;height:320px;overflow:scroll" class="" >
		  <table id="tblinvdata" width="950" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" >
            <tr class="mainHeading4">
<!--			  <td width="1%" height="29" bgcolor="#498CC2" class="normaltxtmidb2"></td>
-->              <td width="16%" height="25" >Invoice No </td>
              <td width="25%"  >Supplier</td>
              <td width="15%" >Date </td>
              <td width="15%" >Amount</td>
              <td width="15%" >Paid</td>
              <td width="14%" >Balance</td>
			  <td width="14%" >View</td>
            </tr>
          </table>
		  </div>
		  </td>
    </tr> 
  </table>
    </td>
    </tr>   
</table>
</form>
</body>
</html>
