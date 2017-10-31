<?php
session_start();
$backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Banks</title>

<script src="bank-js.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../bank/Button.js"></script>
<script src="../country/Button.js"></script>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />


<style type="text/css">
<!--
.style1 {color: #800040}
-->
</style>
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
		<div class="main_text">Banks<span class="vol">(Ver 0.3)</span><span id="banks_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="frmBanks" name="frmBanks" method="POST" action="">

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr>
    <td id="td_coHeader"><?php #include "../../Header.php";?></td>
  </tr>-->
  <tr>
    <td align="center"><table width="65%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="tableBorder" cellspacing="0">
<!--          <tr class="">
            <td height="25" class="mainHeading"   ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Banks </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table>
              </td>
          </tr>-->
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0">
                    <tr>
                      <td width="10%" class="normalfnt" height="25">&nbsp;</td>
                      <td width="20%" class="normalfnt">&nbsp;</td>
                      <td width="70%" >&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Search</td>
                      <td><select name="bank_cboBank" class="txtbox" id="bank_cboBank" style="width:162px" onchange="getBankDetails();" tabindex="1">
                        <?php
	
	$SQL = "SELECT bank.intBankId, bank.strBankName FROM bank  where intStatus<>10 order by strBankName asc";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$x = $row["strBankName"];
	?>
		
		<option value="<?php echo $row["intBankId"] ?>"/><?php echo cdata($x) ?></option>
		<?php
	}
	
	?>
                      </select></td>
                    </tr><tr>
                        <td class="normalfnt" height="25">&nbsp;</td>
                        <td class="normalfnt">Bank Code <span class="compulsoryRed">*</span> </td>
                        <td><input tabindex="2" name="bank_txtBankCode" type="text" id="bank_txtBankCode" style="width:160px" maxlength="10" onkeypress="return checkForTextNumber(this.value, event);"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt" height="25">&nbsp;</td>
                      <td class="normalfnt">Bank Name <span class="compulsoryRed">*</span></td>
                      <td><input maxlength="50" tabindex="3" name="bank_txtBankName" type="text" class="txtbox" id="bank_txtBankName" style="width:300px" /></td>
                    </tr>
					
					
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td class="normalfnt"><input tabindex="4" type="checkbox" name="bank_chkActive" id="bank_chkActive" checked="checked" /></td>
                    </tr>					
                    
                    <td style="visibility:hidden" colspan="3" class="">&nbsp;</td>					
                      </table></td>
                </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="10%">&nbsp;</td>
                      <td width="10%">&nbsp;</td>
                      <td width="15%"><img  src="../../images/new.png" alt="New" name="New" id="butNew" tabindex="9" onclick="clearformbank();" class="mouseover"/></td>
                      <td width="15%"><img src="../../images/save.png" alt="Save" name="Save" id="butSave" tabindex="5" onclick="bankSave(this.name)"  class="mouseover"/></td>
                      <td width="15%"><img   class="mouseover" src="../../images/delete.png" alt="Delete" name="Delete" id="butDelete" tabindex="6" onclick="ConfirmDeleteBnk(this.name);"/></td>
					          <td width="12%" class="normalfnt"><img  class="mouseover" src="../../images/report.png" alt="Report"  id="butReport" tabindex="7"  border="0"  onclick="loadBnkReport();"  /></td>
                      <td width="15%" id="td_coDelete"><a href="../../main.php"><img  class="mouseover" src="../../images/close.png" alt="Close" name="Close" id="butClose" tabindex="8" border="0"/></a></td>
                      <td width="10%">&nbsp;</td>
                      <td width="10%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>  
</table>


<div style="left:585px; top:485px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReportBranch();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReportBranch();"/></div></td>
  </tr>
  </table>	  
</div>

</form>
</div>
</div>
</body>
</html>
