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
          <table width="100%" border="0">
            <tr>
              <td height="16" colspan="3" bgcolor="#498CC2" class="TitleN2white">Brand</td>
            </tr>
            <tr>
              <td height="7" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="23%" height="0" class="normalfnt">Search</td>
              <td width="38%"><select name="cboBrandList" class="txtbox" id="cboBrandList" style="width:162px" tabindex="4" onchange="getCountryDetails();">
   
 <?php
	
	$SQL = "SELECT strBrand,intId FROM brand WHERE intStatus=1";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intId"] ."\">" . $row["strBrand"] ."</option>" ;
	}
	
	?>
	
	 </select></td>
	 
              <td width="39%">&nbsp;</td>
            </tr>
            <tr>
              <td height="0" class="normalfnt">Brand</td>
              <td width="38%"><input name="txtBrandCode" type="text" maxlength="60" class="txtbox" style="width:160px" id="txtBrandCode" size="25" onclick="checkvalue();"/></td>
              <td width="39%">&nbsp;</td>
            </tr>
           
            <tr>
              <td height="3">&nbsp;</td>
              <td height="3" colspan="2">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
            </tr>
            <tr>
              <td height="21" colspan="3" bgcolor="#d6e7f5"><table width="100%" border="0">
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
