<?php
 session_start();
 $backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Currency</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<link href="../../Currency/css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include "../../Connector.php";
?>
<form id="frmCurrency" name="form1" method="post" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php';?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="35" bgcolor="#498CC2" class="TitleN2white">Currency</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td class="normalfnt"><table width="100%" border="0">

                    <tr>
                      <td width="17%">Currency</td>
                      <td width="83%"><select name="cboCurr" class="txtbox" id="cboCurr" onchange="getCurrencyDetails();" style="width:150px">
                        <?php
			$SQL="SELECT currencytypes.strCurrency,currencytypes.strTitle,currencytypes.dblRate FROM currencytypes WHERE (((currencytypes.intStatus)=1));";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCurrency"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
		  
					?>
                      </select></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                    <tr>
                      <td width="17%" height="21" bgcolor="#D6E7F5" class="normalfntMid">New Currency</td>
                      <td colspan="3" bgcolor="#D6E7F5">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="30">Currency</td>
                      <td width="29%"><input name="txtCurrency" type="text" class="txtbox" id="txtCurrency" /></td>
                      <td width="20%" class="normalfnt">Title</td>
                      <td width="34%" class="normalfntp2"><input name="txtTitle" type="text" class="txtbox" id="txtTitle" /></td>
                    </tr>
                    <tr>
                      <td height="26">Rate</td>
                      <td><input name="txtRate" type="text" class="txtbox" id="txtRate" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                      <td>Fractional Unit</td>
                      <td><span class="normalfntp2">
                        <input name="txtFraction" type="text" class="txtbox" id="txtFraction" />
                      </span></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                      <td colspan="2" class="normalfntp2">&nbsp;</td>
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
                      <td width="11%">&nbsp;</td>
                      <td width="20%"><img src="../../images/new.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();"/></td>
                      <td width="19%"><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="butCommand(this.name)"/></td>
                      <td width="22%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="ConfirmDelete(this.name);"/></td>
                      <td width="17%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="11%">&nbsp;</td>
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
