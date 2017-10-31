<?php
session_start();
$backwardseperator = "../../../";
$pub_url = "/gapro/";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wash Formula</title>

<script src="Button.js"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body onload="ClearForm();">
<?php
include "../../../Connector.php";
?>
<form id="frmWashFormula" name="frmWashFormula" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">Wash Formula</div></div>
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
                      <td width="143" class="normalfnt">Process</td>
                      <td width="275" align="left"><select name="frmWashFormula_cboWFormula" onchange="getWFormulaDetails();"class="txtbox" id="frmWashFormula_cboWFormula" style="width:150px">
					  
					  <?php
					  $SQL="SELECT * FROM was_washformula  order by strProcessName";
					
					
						$result = $db->RunQuery($SQL);
						
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intSerialNo"] ."\">" . $row["strProcessName"] ."</option>" ;
						}  
					  ?>
                      </select>                      </td>
                </tr>
                 
                    
                    <tr>
                    	<td>&nbsp;</td>
                      <td class="normalfnt" >Process<span class="compulsoryRed">*</span></td>
                      <td align="left"><input name="frmWashFormula_txtDes" type="text" class="txtbox" id="frmWashFormula_txtDes" style="width:150px"  maxlength="20"  /></td>
                      </tr>
                    <tr>
                    <td>&nbsp;</td>
                      <td class="normalfnt" >Liqour(L)</td>
                      <td align="left"><input name="frmWashFormula_Liqour" type="text" class="txtbox" id="frmWashFormula_Liqour" style="width:100px;text-align:right" maxlength="10" onkeypress="return CheckforValidDecimal(this.value, 2,event);" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);" /></td>
                      </tr>
					<tr>
                    <td>&nbsp;</td>
                      <td class="normalfnt" >Run Time</td>
                      <td align="left"><input name="frmWashFormula_runTime" type="text" class="txtbox" id="frmWashFormula_runTime" style="width:100px;text-align:right;" maxlength="10" onkeypress="return CheckforValidDecimal(this.value, 1,event);" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);" /></td>
                      </tr>
					  
				<tr>
                    <td>&nbsp;</td>
                      <td class="normalfnt" >Temperature</td>
                      <td align="left"><input name="frmWashFormula_temp" type="text" class="txtbox" id="frmWashFormula_temp" style="width:100px;text-align:right" maxlength="10"  onkeypress="return CheckforValidDecimal(this.value, 1,event);" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);"/></td>
                      </tr>

					
					     <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">Process Type<span class="compulsoryRed">*</span></td>
              <td class="normalfnt">
              	<select id="pType" name="pType" style="width:75px;">
                	<option value=""></option>
                    <option value="1">Wet</option>
                    <option value="2">Dry</option>
                </select>
              </td>
            </tr>            
            <tr>
               <td>&nbsp;</td>
               <td class="normalfnt">Active</td>
               <td align="left"><input type="checkbox" name="frmWashFormula_chkActive" id="frmWashFormula_chkActive" checked="checked" /></td>
            </tr>
          <tr>
            <td height="21" colspan="3">
              <table width="100%" border="0" class="tableFooter">
                <tr>
                  <td width="10%">&nbsp;</td>
                  <td ><img src="<?php echo $pub_url;?>images/new.png" alt="New" name="New" onclick="ClearForm();" class="mouseover" /></td>
                  <td id="tdSave" ><img  src="<?php echo $pub_url;?>images/save.png" class="mouseover" alt="Save" name="Save" onclick="butCommand(this.name)" id="Save"/></td>
                  <td><img src="<?php echo $pub_url;?>images/delete.png" class="mouseover" alt="Delete" name="Delete" onclick="ConfirmDelete(this.name);" /></td>
                  <td  class="normalfnt"><img src="<?php echo $pub_url;?>images/report.png" alt="Report" border="0" class="mouseover" onclick="loadReport();"  /></td>
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
  </div>
 </div>
</form>

</body>
</html>
