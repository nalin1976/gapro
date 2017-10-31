<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Mode</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
}
-->
</style>
<!--<script src="button.js"></script>
<script src="Search.js"></script>-->
<script src="button.js" type="text/javascript"></script>
<script src="mode.js" type="text/javascript"></script>

</head>

<body>
<?php
	include "../../Connector.php";	
?>
	
<form id="frmBuyers" name="frmBuyers" method="post" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="22" bgcolor="#588DE7" class="TitleN2white">Mode</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" height="157" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Mode</td>
                      <td><select name="cboMode" class="txtbox"  onchange="getModeDetails();" style="width:198px" id="cboMode">
                        <?php
	
	$SQL = "SELECT 	strMode,strLocation FROM Mode ";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strMode"] ."\">". $row["strMode"] ." - " . $row["strLocation"] ."</option>" ;
	}
	
	?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Mode</td>
                      <td><input name="txtMode" type="text" AutoCompleteType="Disabled" autocomplete="off" class="txtbox" id="txtMode"  size="25" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Inland</td>
                      <td><input name="txtInland" type="text" class="txtbox" id="txtInland"  size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Place Of Discharging </td>
                      <td width="72%"><input name="txtPlaceDischarging " type="text" class="txtbox" id="txtPlaceDischarging"  size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Location Of Goods</td>
                      <td><input name="txtLocation" type="text" class="txtbox" id="txtLocation" size="50" /></td>
                    </tr>
                    
                  </table></td>
                  </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td width="22%">&nbsp;</td>
                      <td width="19%"><img src="../../images/new.png" alt="New" name="New" onclick="ClearForm();"/></td>
					  <td><img src="../../images/save.png" alt="Save" name="save" width="84" height="24" onclick="saveData();"/></td>
                      <td width="15%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="deleteData();"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="26%">&nbsp;</td>
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
</form>
</body>
</html>
