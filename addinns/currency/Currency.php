<?php
 session_start();
 $backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
//include "${backwardseperator}HeaderConnector.php";
//include "${backwardseperator}permissionProvider.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Currency</title>


<link href="../../Currency/css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var pub_currency='<?php echo $_SESSION["sys_currency"];?>';

</script>
<script src="Button.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js"></script>

</head>

<body>
<?php
include "../../Connector.php";
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Currency<span class="vol">(Ver 0.3)</span><span id="currency_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td height="139"><table align="center" width="550" border="0">
      <tr>
        <td width="48%"><form id="frmCurrencyType" name="frmCurrencyType" method="post" action=""><table id="tblCurrencyMain" width="100%" border="0" class="tableBorder">
          <!--<tr>
<td height="35" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
      <td width="72%" class="mainHeading">Currency </td>
      <td width="9%" class="seversion"> (Ver 0.3) </td>
      <td width="6%" id="popup_close_button">&nbsp;</td>
    </tr>
  </table></td>
          </tr>-->
          <tr>
            <td height="96">
              <table width="100%" border="0" class="bcgl1">
                
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
                    
					<tr>
					  <td height="30" class="normalfnt">&nbsp;Currency</td>
					  <td class="normalfnt"><select name="currency_cboCurr" class="txtbox" id="currency_cboCurr" onchange="getCurrencyDetails();" style="width:150px" tabindex="1" >
                        <?php
			$SQL="SELECT currencytypes.strCurrency,currencytypes.intCurID FROM currencytypes WHERE (((currencytypes.intStatus)<>10)) order by strCurrency";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCurID"] ."\">" . cdata($row["strCurrency"]) ."</option>" ;
	}
		  
					?>
                      </select></td>
					  <td class="normalfnt">&nbsp;</td>
					  <td class="normalfnt">&nbsp;</td>
					  </tr>
					<tr>
					  <td height="20" colspan="4" class="mainHeading4" >New Currency</td>
					  </tr>
					<tr>
						<td width="16%" height="30" class="normalfnt">&nbsp;Country&nbsp;<span class="compulsoryRed">*</span></td>
                        <td class="normalfnt"><select name="currency_cboCountry" class="txtbox" id="currency_cboCountry" style="width:151px" tabindex="2">
							<?php
			$SQL="SELECT country.strCountry,country.intConID FROM country WHERE country.intStatus=1 order by country.strCountry;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
	
		echo "<option value=\"". $row["intConID"] ."\">" . cdata($row["strCountry"]) ."</option>" ;
	
	}
		  
					?> 	
						
                        </select>
<img  src="../../images/add.png" width="16" height="16" align="absmiddle" class="mouseover" onclick="showCountryPopUp()"/></td>
					    <td class="normalfnt">Title&nbsp;<span class="compulsoryRed">*</span></td>
					    <td class="normalfnt"><span class="normalfntp2">
					      <input name="currency_txtTitle" type="text" class="txtbox" id="currency_txtTitle" style="width:150px" maxlength="50" tabindex="3"/>
					    </span></td>
					</tr>
                    <tr>
                      <td width="16%" height="30">&nbsp;Currency&nbsp;<span class="compulsoryRed">*</span></td>
                      <td width="34%"><input name="currency_txtCurrency" type="text" class="txtbox" id="currency_txtCurrency" style="width:149px" maxlength="10" tabindex="4"/></td>
                      <td width="20%" class="normalfnt">Fractional Unit&nbsp;<span class="compulsoryRed">*</span></td>
                      <td width="30%" class="normalfntp2"><input name="currency_txtFraction" type="text" class="txtbox" id="currency_txtFraction" style="width:150px" maxlength="8" tabindex="5"/></td>
                    </tr>
                    <tr>
                      <td height="26">&nbsp;Active</td>
                      <td><input type="checkbox" name="currency_chkActive" id="currency_chkActive" checked="checked" tabindex="6"/></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""  align="center">
                <table width="80%" border="0" style="border:none;"  >
                    <tr>
                      <td>&nbsp;</td>
                      <td><?php if ($CanUpdateCurrencyRates) { ?><img src="../../images/new.png" alt="New" id="butNew" name="New" width="96" height="24" onclick="clearFields();" tabindex="11" class="mouseover"/><?php } ?></td>
                      <td><?php if ($CanUpdateCurrencyRates) { ?> <img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="butCommand_currency(this.name)" class="mouseover" tabindex="7" id="butSave"/><?php } ?></td>
                      <td><?php if ($CanUpdateCurrencyRates) { ?> <img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="ConfirmDeleteCurrency(this.name);" id="butDelete" tabindex="8" class="mouseover"/><?php } ?></td>
					  					  				  					  					                      <td class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" id="butReport" border="0" class="mouseover" tabindex="9" onclick="loadReportCurrency();"/></td>
                      <td id="tdDelete"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" tabindex="10" id="butClose" class="mouseover"/></a></td>
                      <td>&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>			
          </tr>
        </table></form>        </td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
</div>
</body>
</html>
