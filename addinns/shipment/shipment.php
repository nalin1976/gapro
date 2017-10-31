<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Shipment Mode</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include "../../Connector.php";
?>
<form id="frmshipmentMode" name="frmshipmentMode" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Shipment Mode<span class="vol">(Ver 0.3)</span><span id="shipmentMode_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr>
    <td id="tdHeader"><?php #include "../../Header.php";?></td>
  </tr>-->
  <tr>
    <td><table width="550" border="0" align="center">
      <tr>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
<!--          <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Shipment Mode </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>
          </tr>-->
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="normalfnt">&nbsp;  </td>
                  <td class="normalfnt">Search</td>
                  <td width="60%" align="left"><select name="shipmentmode_cboshipment" class="txtbox" onchange="getshipmentDetails();"id="shipmentmode_cboshipment" style="width:140px" tabindex="1">
				<?php
				//$SQL="SELECT * FROM shipmentmode WHERE intStatus<>10 order by strDescription ;";  
				 $SQL="SELECT * FROM shipmentmode order by strDescription ;";  
				 
					$result = $db->RunQuery($SQL);
					
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intShipmentModeId"] ."\">" . cdata($row["strDescription"]) ."</option>" ;
	}   
                  
				  ?>
				  </select>                  </td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td height="26" class="normalfnt">Shipment Code <span class="compulsoryRed">*</span></td>
                  <td align="left"><input name="shipmentmode_txtshipmentcode" onkeypress="return checkForTextNumber(this.value, event);" type="text" class="txtbox" id="shipmentmode_txtshipmentcode" style="width:138px" maxlength="10"  tabindex="2"/></td>
                </tr>
                
                <tr>
                  <td width="16%" class="normalfnt">&nbsp;</td>
                  <td width="24%" height="26" class="normalfnt">Shipment Mode&nbsp;<span class="compulsoryRed">*</span></td>
                  <td align="left"><input name="shipmentmode_txtshipmentmode" type="text" class="txtbox" id="shipmentmode_txtshipmentmode" style="width:276px" maxlength="50" tabindex="3" /></td>
                </tr>
				<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td align="left"><input type="checkbox" name="shipmentmode_chkActive" id="shipmentmode_chkActive" checked="checked"  tabindex="4"/></td>
                    </tr>
                <tr>
                  <td colspan="3" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                  </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableFooter">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter" align="center">
                    <tr>
					  <td width="15%"></td>
                      <td width="18%"><img src="../../images/new.png" alt="New" name="New" tabindex="9" id="butNew" width="96" height="24" onclick="ClearForm();"/></td>
                      <td width="13%"><img src="../../images/save.png" alt="Save" name="Save" id="butSave" tabindex="5" width="84" height="24" onclick="butCommand(this.name)"/></td>
                      <td width="16%"><img src="../../images/delete.png" alt="Delete" id="butDelete" tabindex="6" name="Delete" width="100" height="24" onclick="ConfirmDelete(this.name);"/></td>
					  <td width="17%" class="normalfnt"><img src="../../images/report.png" alt="Report" id="butReport" tabindex="7" width="108" height="24" border="0" class="mouseover" onclick="loadReport();"  /></td>
                      <td id="tdDelete" width="39%"><a id="td_coDelete" href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="butClose" tabindex="10"/></a></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
<!--<p class="txtbox">&nbsp;</p>-->
</form>
</body>
</html>
