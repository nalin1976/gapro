<?php
$backwardseperator = "../../";
session_start();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Shipment Terms</title>

<link href="../../css/erpstyle.css"  rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include "../../Connector.php";
?>
<form id="frmshipmentTerm" name="frmshipmentTerm" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Shipment Terms<span class="vol">(Ver 0.3)</span><span id="shipmentTerms_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr>
    <td id="tdHeader"><?php #include $backwardseperator."Header.php";?></td>
  </tr>-->
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="62%"><table width="500" align="center" border="0" class="tableBorder">
<!--          <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Shipment Terms </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>
          </tr>-->
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="normalfnt">&nbsp; </td>
                  <td class="normalfnt">Search </td>
                  <td width="63%" align="left"><select name="shipmentTerm_cboshipment" class="txtbox" id="shipmentTerm_cboshipment" onchange="getshipmentDetails();"style="width:140px" tabindex="1">
				  <?php
				  
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				  
			//$SQL="SELECT * FROM shipmentterms WHERE intStatus <> 10 order by strShipmentTerm;";
			$SQL="SELECT * FROM shipmentterms  order by strShipmentTerm;";
			$result = $db ->RunQuery($SQL);	 
			
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
			}
		 
				  
				  
				  ?>
                  </select>                  </td>
                </tr>
                
                <tr>
                  <td width="14%" class="normalfnt">&nbsp;</td>
                  <td width="23%" height="26" class="normalfnt">Shipment Code&nbsp;<span class="compulsoryRed">*</span></td>
                  <td align="left"><input name="shipmentTerm_txtshipmentcode" type="text" class="txtbox" id="shipmentTerm_txtshipmentcode" style="width:138px" maxlength="10" onkeypress="return checkForTextNumber(this.value, event);" tabindex="2"/></td>
                </tr>
                <tr>
                  <td width="14%" class="normalfnt">&nbsp;</td>
                  <td width="23%" height="26" class="normalfnt">Shipment Term&nbsp;<span class="compulsoryRed">*</span></td>
                  <td align="left"><input name="shipmentTerm_txtshipmentmode" type="text" class="txtbox" id="shipmentTerm_txtshipmentmode" style="width:276px" maxlength="50" tabindex="3"/></td>
                </tr>
				<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td colspan="3" align="left"><input type="checkbox" name="shipmentTerm_chkActive" id="shipmentTerm_chkActive" checked="checked" tabindex="4" /></td>
                    </tr>
                <tr>
                  <td colspan="3" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                  </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableFooter">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="10%">&nbsp;</td>
                      <td width="18%"><img src="../../images/new.png" alt="New" name="New" id="butNew" tabindex="9" onclick="ClearForm();"width="96" height="24" /></td>
                      <td width="15%"><img src="../../images/save.png" alt="Save" name="Save" id="butSave" tabindex="5" onclick="butCommand(this.name)"width="84" height="24" /></td>
                      <td width="18%"><img src="../../images/delete.png" alt="Delete" name="Delete" id="butDelete" tabindex="6" onclick="ConfirmDelete(this.name)"width="100" height="24" /></td>
					  <td width="12%" class="normalfnt"><img src="../../images/report.png" alt="Report" id="butReport" tabindex="7" width="108" height="24" border="0" class="mouseover" onclick="loadReport();"  /></td>
                      <td id="td_coDelete" width="18%"><a href="../../main.php"><a href="../../main.php"><img  class="mouseover" id="butClose" src="../../images/close.png" alt="Close" name="Close" border="0" tabindex="8" /></a></td>
                      <td width="15%">&nbsp;</td>
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
</div>
</div>
</form>
</body>
</html>
