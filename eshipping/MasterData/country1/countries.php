<?php
 session_start();
 include "../../Connector.php";
$backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Countries</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
</head>

<body>

<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td height="139"><table width="100%" border="0">
      <tr>
        <td width="26%">&nbsp;</td>
        <td width="48%"><form id="frmmaterial4" name="frmmaterial4" method="post" action="">
          <table width="100%" border="0" class="bcgl1">
            <tr>
              <td height="16" colspan="2" bgcolor="#498CC2" class="TitleN2white">Countries</td>
            </tr>
            <tr>
              <td width="33%" height="0" class="normalfnt">Search</td>
              <td width="67%"><select name="cboCountryList" class="txtbox" id="cboCountryList" style="width:160px" tabindex="4" onchange="getCountryDetails();">
                
                <?php
	
	$SQL = "SELECT country.strCountryCode, country.strCountry FROM country WHERE (((country.intStatus)=1));";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountryCode"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	
	?>
                
                </select></td>
            </tr>
            <tr>
              <td height="0" class="normalfnt">Country Code</td>
              <td width="67%"><input name="txtCountryCode" type="text" class="txtbox" style="width:160px" id="txtCountryCode" size="25" onclick="checkvalue();"/></td>
              </tr>
            <tr>
              <td height="-1" class="normalfnt">Country Name</td>
              <td width="67%"><input name="txtCountry" type="text" class="txtbox" style="width:160px" id="txtCountry" size="25" /></td>
              </tr>
            <tr>
              <td height="3" class="normalfnt">Reference</td>
              <td height="3">
                <input name="txtReference" type="text" class="txtbox" style="width:160px" id="txtReference" size="25" maxlength="100" />
              </td>
              </tr>
            <tr>
              <td height="21" colspan="2" bgcolor="#d6e7f5"><table width="100%" border="0">
                <tr>
                  <td width="19%"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                  <td width="22%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="ConfirmDelete(this.name)"/></td>
                  <td width="24%"><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="butCommand(this.name)"/></td>
                  <td width="23%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                  <td width="15%">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
                </form>
        </td>
        <td width="26%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>


</body>
</html>
