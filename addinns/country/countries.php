<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Country</title>

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
		<div class="main_text">Country<span class="vol">(Ver 0.3)</span><span id="country_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<table class="" align="center" width="600" border="0" cellspacing="1">
      <tr>
        <td width="48%"><form id="frmCountries" name="frmCountries" method="post" action="">
          <table width="590" border="0"  cellspacing="0">
            <tr>
              <td height="7" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="60" >&nbsp;</td>
              <td width="161" class="normalfnt">Search</td>
              <td width="345" align="left"><select name="countries_cboCountryList" class="txtbox" id="countries_cboCountryList" style="width:167px" tabindex="1" onchange="getCountryDetails();">
   
 <?php
	
	$SQL = "SELECT country.intConID, country.strCountry FROM country where intStatus<>10 order by strCountry asc;";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intConID"] ."\">" . cdata($row["strCountry"]) ."</option>" ;
	}
	
	?>
	
	 </select></td>
            </tr>
            <tr>
              <td >&nbsp;</td>
              <td class="normalfnt">Country Code&nbsp;<span class="compulsoryRed">*</span></td>
              <td align="left"><input name="countries_txtCountryCode" type="text" class="txtbox" id="countries_txtCountryCode"  style="width:165px"  tabindex="2" maxlength="10" onkeypress="return checkForTextNumber(this.value, event);"/></td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
              <td class="normalfnt">Country Name&nbsp;<span class="compulsoryRed">*</span></td>
              <td align="left"><input name="countries_txtCountry" type="text" class="txtbox" id="countries_txtCountry"  style="width:165px"  tabindex="3" maxlength="100" /></td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
              <td class="normalfnt">Zip Code&nbsp;</td>
              <td align="left"><input name="countries_txtZipCode" type="text" class="txtbox" id="countries_txtZipCode"  style="width:80px" maxlength="4"  tabindex="5" onkeypress="return isValidZipCode(this.value,event);" /></td>
            </tr>
			<tr>
              <td >&nbsp;</td>
			  <td class="normalfnt">Active</td>
			  <td align="left" ><input tabindex="6" type="checkbox" name="countries_chkActive" id="countries_chkActive" checked="checked" /></td>
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
				 <img id="butReport" src="../../images/report.png" alt="Report" border="0" class="mouseover" onclick="loadReport();" tabindex="9"  />
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
