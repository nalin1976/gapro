<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Units</title>

<link href="../../Units/css/erpstyle.css" rel="stylesheet" type="text/css" />
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
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Units<span class="vol">(Ver 0.3)</span><span id="units_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="frmUnits" name="frmUnits" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr>
    <td><?php #include "../../Header.php";?></td>
  </tr>-->
  <tr>
    <td align="center"><table width="600" border="0">
      <tr>

        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <!--<tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Units</td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>
          </tr>-->
          <tr>
            <td  class="bcgl1">
              <table width="100%" border="0">
                
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tr>
				  <td width="17%"></td>
				  <td width="35%"></td>
				  <td width="14%"></td>
				  <td width="34%"></td>
				  </tr>
                    <tr>
                      <td height="30">Unit</td>
                      <td><select name="units_cbounit" class="txtbox" tabindex="1"onchange="getUnitsDetails();" id="units_cbounit" style="width:150px">
                        <?php
				$SQL="SELECT intUnitID,strUnit FROM units order by strUnit";
				$result = $db->RunQuery($SQL);
				
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". cdata($row["intUnitID"]) ."\">" . cdata($row["strUnit"]) ."</option>" ;
	}  
				
				?>
                      </select></td>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfntp2">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#D6E7F5" class="mainHeading4">
                      <td  height="25" colspan="4" valign="middle" ><div align="center">New Unit</div></td>
                      </tr>
                    <tr>
                      <td  height="25">Unit <span class="compulsoryRed">*</span></td>
                      <td><input name="units_txtunit" type="text" tabindex="2" class="txtbox" id="units_txtunit" style="width:150px" maxlength="10" onkeypress="return checkForTextNumber(this.value, event);"/></td>
                      <td class="normalfnt">No of Pcs</td>
                      <td class="normalfntp2"><input name="units_txtunit2" type="text" class="txtbox" id="units_txtunit2" style="width:100px; text-align:right" tabindex="3" onkeypress="return CheckforValidDecimal(this.value, 4,event);" maxlength="10"/></td>
                    </tr>
                    <tr>
                      <td height="25">Description</td>
                      <td colspan="3"><input name="units_txtunit3" tabindex="4" type="text" class="txtbox" id="units_txtunit3" style="width:385px" maxlength="100"/></td>
                      </tr>
					<tr>
                      <td class="normalfnt" height="25">Active</td>
                      <td colspan="3"><input tabindex="5" type="checkbox" name="units_chkActive" id="units_chkActive" checked="checked"  /></td>
                    </tr>
                    </table></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""  align="center">
                <table width="200" border="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td><img src="../../images/new.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();" id="butNew" tabindex="10"/></td>
                      <td><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="butCommand(this.name)" id="butSave" tabindex="6"/></td>
                      <td><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="ConfirmDelete(this.name);" id="butDelete" tabindex="7"/></td>
					  <td class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="loadReport();"  id="butReport" tabindex="8" /></td>
                      <td><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="butClose" tabindex="9"/></a></td>
                      <td>&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>
</div>
</body>
</html>
