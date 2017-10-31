<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Cities</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<script src="city.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php

include "../../Connector.php";

?>

<form id="frmBanks" name="form1" method="POST" action="">
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
            <td height="30" bgcolor="#588DE7" class="TitleN2white" >Cities</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="3">
                <tr>
                  <td width="5%" class="normalfnt" height="35">&nbsp;</td>
                  <td width="16%" class="normalfnt">Country <span id="txtHint" style="color:#FF0000">*</span></td>
                  <td width="79%"><select name="cboCountry"  onchange="getCityDetails();" class="txtbox" id="cboCountry"style="width:320px">
                    
                    <?php
	
	$SQL = "SELECT  strCountryCode,strCountry 
FROM country;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountryCode"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	
	?>
                    
                    
                    </select></td>
                </tr>
                <tr>
                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="39%" height="157"><select name="cboCity"  onchange="viewCity();" multiple="multiple" class="txtbox" id="cboCity"style="width:200px;height:150px;">
                        <?php ?>
                        </select></td>
                      <td width="61%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bcgl1">
                        <tr>
                          <td width="27%" height="25">City  Name <span id="txtHint" style="color:#FF0000">*</span></td>
                          <td width="73%"><input name="txtCityName" type="text" class="txtbox" style="width:230px;" id="txtCityName" maxlength="100"/></td>
                          </tr>
                        <tr>
                          <td height="25">Port <span id="txtHint" style="color:#FF0000">*</span></td>
                          <td><input name="txtPortOfLoading" type="text" class="txtbox" id="txtPortOfLoading" style="width:230px;" maxlength="100"/></td>
                          </tr>
                        <tr>
                          <td height="25">DC #</td>
                          <td><input name="txtDcNo" type="text" class="txtbox" id="txtDcNo" style="width:125px;" maxlength="50" /></td>
                          </tr>
						  	<tr>
						  	  <td height="25">To Location</td>
						  	  <td><input name="txtISDNo" type="text" class="txtbox" id="txtISDNo" style="width:230px;" maxlength="100" /></td>
						  	  </tr>
						  	<tr>
							<td height="25">PL Destination</td>
							<td><input name="txtDestination" type="text" class="txtbox" id="txtDestination" style="width:230px;" maxlength="100" /></td>
						  	</tr>
                        </table></td>
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
                      <td width="21%">&nbsp;</td>
                      <td width="19"><img src="../../images/new.png" class="mouseover" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                      <td width="21"><img src="../../images/save.png" class="mouseover"alt="Save" width="84" height="24" name="Save" onclick="savedata();"/></td>
                      <td width="21"><img src="../../images/delete.png"class="mouseover" alt="Delete" width="100" height="24" name="Delete"onclick="deleteData();"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
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
