<?php
session_start();
$backwardseperator = "../../../";
$pub_url = "/gapro/";
include "../../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Washing Machine</title>

<script src="Button.js"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body onload="ClearFormwMachine();">
<form id="frmWmachine" name="frmWmachine" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">Wash Machine</div></div>
<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td height="139" ><table width="560" border="0" align="center">
      <tr>
        <td width="62%">
        <fieldset class="fieldsetStyle" style="width:500px;-moz-border-radius: 5px;">
        	<table width="100%" border="0" class="">
          <tr>
              <td height="7" colspan="3">&nbsp;</td>
            </tr>
                    <tr>
                      <td width="120" >&nbsp;</td>
                      <td width="143" class="normalfnt">Machine Name </td>
                      <td width="275" align="left"><select name="frmWmachine_cboWmachine" onchange="getWMachDetails();"class="txtbox" id="frmWmachine_cboWmachine" style="width:162px;height:18px;">
					  
					  <?php
					  $SQL="SELECT * FROM was_machine  order by strMachineName";
					
					
						$result = $db->RunQuery($SQL);
						
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intMachineId"] ."\">" . $row["strMachineName"] ."</option>" ;
						}  
					  ?>
                      </select></td>
                </tr>
                 
                    
                    <tr>
                    <td>&nbsp;</td>
                      <td class="normalfnt" >Machine Name <span class="compulsoryRed">*</span></td>
                      <td align="left"><input name="frmWmachine_txtDes" type="text" class="txtbox" id="frmWmachine_txtDes" style="width:160px" maxlength="30" /></td>
                      </tr>
					  
					 <tr>
                      <td width="120" >&nbsp;</td>
                      <td width="143" class="normalfnt">Machine Type <span class="compulsoryRed">*</span></td>
                      <td width="275" align="left"><select name="frmWmachine_cboWmachineType" onchange=""class="txtbox" id="frmWmachine_cboWmachineType" style="width:150px">
					  
					  <?php
					  $SQL=" SELECT * FROM was_machinetype order by strMachineType;";
					
					
						$result = $db->RunQuery($SQL);
						
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intMachineId"] ."\">" . $row["strMachineType"] ."</option>" ;
						}  
					  ?>
                      </select>&nbsp;&nbsp;<img  src="../../../images/add.png" width="16" height="16" onclick="showMachTypePopUp()" size="1" class="mouseover" align="absbottom" style="display:none;"/></td>
                </tr>
				<tr>
                      <td width="120" >&nbsp;</td>
                      <td width="143" class="normalfnt">Machine Capacity</td>
                      <td width="275" align="left"><input type="text" name="was_machineCapacity" id="was_machineCapacity" style="width:100px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value, 2,event);" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);" maxlength="10"/></td>
                </tr>
					<tr>
                    	<td>&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td align="left"><input type="checkbox" name="frmWmachine_chkActive" id="frmWmachine_chkActive" checked="checked" /></td>
                    </tr>
					     <tr>
              <td height="3">&nbsp;</td>
              <td height="3">&nbsp;<span id="seasons_txtHint" style="color:#FF0000"></span></td>
            </tr>            
          <tr>
            <td height="21" colspan="3">
              <table width="100%" border="0" class="tableFooter">
                <tr>
                  <td width="10%">&nbsp;</td>
                  <td ><img src="<?php echo $pub_url;?>images/new.png" alt="New" name="New" onclick="ClearFormwMachine();" class="mouseover" /></td>
                  <td id="tdSave" ><img  src="<?php echo $pub_url;?>images/save.png" class="mouseover" alt="Save" name="Save" onclick="butCommandvMach(this.name)" id="Save"/></td>
                  <td><img src="<?php echo $pub_url;?>images/delete.png" class="mouseover" alt="Delete" name="Delete" onclick="ConfirmDeletewMach(this.name);" /></td>
                  <td  class="normalfnt"><img src="<?php echo $pub_url;?>images/report.png" alt="Report" border="0" class="mouseover" onclick="loadReportwMachine();"  /></td>
                  <td width="10"  id="tdDelete"><a href="<?php echo $pub_url;?>main.php"><img src="<?php echo $pub_url;?>images/close.png" alt="Close" name="Close"  border="0" id="Close"/></a></td>
                  <td width="10%">&nbsp;</td>
                </tr>
               </table>             </td>
          </tr>
        </table>
       </fieldset> 
       </td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
