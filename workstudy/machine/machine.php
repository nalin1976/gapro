<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Work Study | Machines</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>

</head>

<body>

<?php
include "../../Connector.php";

?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Machines<span id="country_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<table class="" align="center" width="400" border="0" cellspacing="1">
      <tr>
        <td width="48%"><form id="frmCountries" name="frmCountries" method="post" action="">
          <table width="590" border="0"  cellspacing="0">
            <tr>
              <td height="7" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="60" >&nbsp;</td>
              <td width="161" class="normalfnt">Search</td>
              <td width="345" align="left"><select name="machines_cbomachineList" class="txtbox" id="machines_cbomachineList" style="width:167px" tabindex="1" onchange="getMachineDetails();">
   
 <?php
	
	$SQL = "SELECT ws_machinetypes.intMachineTypeId, ws_machinetypes.strMachineName FROM ws_machinetypes order by strMachineName asc";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intMachineTypeId"] ."\">" . cdata($row["strMachineName"]) ."</option>" ;
	}
	
	?>
	
	 </select></td>
            </tr>
            <tr>
              <td >&nbsp;</td>
              <td class="normalfnt">Machine Code&nbsp;<span class="compulsoryRed">*</span></td>
              <td align="left"><input name="machine_txtMachineCode" type="text" class="txtbox" id="machine_txtMachineCode"  style="width:165px"  tabindex="2" maxlength="10" onkeypress="return checkForTextNumber(this.value, event);"/></td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
              <td class="normalfnt">Machine Name&nbsp;<span class="compulsoryRed">*</span></td>
              <td align="left"><input name="machine_txtMachine" type="text" class="txtbox" id="machine_txtMachine"  style="width:165px"  tabindex="3" maxlength="100" /></td>
            </tr>

			<tr>
              <td >&nbsp;</td>
			  <td class="normalfnt">Active</td>
			  <td align="left" ><input tabindex="6" type="checkbox" name="machine_chkActive" id="machine_chkActive" checked="checked" /></td>
			</tr>
            <tr>
              <td >&nbsp;</td>
              <td height="3">&nbsp;</td>
              <td height="3">&nbsp;<span id="countries_txtHint" style="color:#FF0000"></span></td>
            </tr>
            <tr>
              <td height="21" colspan="3" bgcolor=""><table width="102%" border="0" class="">
                <tr>
                  <td align="center">
                  <img src="../../images/new.png" id="butNew" class="mouseover" alt="New" name="New"onclick="ClearForm();" tabindex="11"/>
                 <img src="../../images/save.png" class="mouseover" alt="Save" name="Save"  onclick="butCommandC(this.name)" id="butSave" tabindex="7"/>
		 <img src="../../images/delete.png" class="mouseover" alt="Delete" id="butDelete" name="Delete"  onclick="ConfirmDelete(this.name)" tabindex="8"/>       
                  <a id="td_coDelete" href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="butClose" tabindex="10"/></a></td>
    
                </tr>
              </table></td>
            </tr>
          </table>
         </form>        </td>
      </tr>
    </table></td>
  </tr>
</table>

</div>
</div>
</body>
</html>
