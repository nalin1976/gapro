<?php
 session_start();
 $backwardseperator = "../../";
 include "../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | GL Allocation For Cost Center</title>

<link href="file:///C|/Program Files/Inetpub/wwwroot/GaPro/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script  language="javascript" type="text/javascript" src="accPackGL.js">
</script>
</head>

<body>
<tr>
	<td><?php include $backwardseperator."Header.php";  ?></td>
</tr>
<tr><td>&nbsp;</td></tr>
<table width="640" height="260" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tableBorder3">
  <tr>
    <td height="25" bgcolor="#498CC2" class="mainHeading">GL Allocation For Cost Center</td>
  </tr>
  <tr>
    <td><table width="81%" border="0">
      <tr>
        <td width="90%"><form id="frmGLAllocation" name="frmGLAllocation" >
          <table width="88%" border="0">

            <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="">
                <tr >
                  <td width="2%" height="23">&nbsp;</td>
                  <td width="18%" class="normalfnt">Cost Center </td>
                  <td width="80%" colspan="2"><label>
                  <select name="cboFactory" class="txtbox" id="cboFactory" onchange="getGLAccountsToAllowcation()" style="width:300px" tabindex="1">
<?php
	//$SQL="select * from companies where intStatus = '1';";
	$SQL="select intCostCenterId,strDescription from costcenters where intStatus=1 order by strDescription";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intCostCenterId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
?>
                  </select>
                  </label></td>
                </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td width="18%" class="normalfnt">Account ID</td>
                  <td width="32%"><input name="txtAccID" class="txtbox"  type="text" id="txtAccID" maxlength="20" readonly="readonly" tabindex="2"/></td>
                  <td style="visibility:hidden"><img src="../../images/allocate.png" alt="search" onclick="checkValidation()" tabindex="3"/></td>
                </tr>
				<tr>
                  <td height="12">&nbsp;</td>
                  <td width="18%" class="normalfnt"><!--<input type="checkbox" onclick="selectDeselectAll(this);" />--></td>
                  <td width="32%">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="165"><table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr class="bcgl1">
                  <td width="100%"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3"><div id="divcons" style="overflow:scroll; height:330px; width:620px;">
                       
                          <table width="600"  bgcolor="#CCCCFF" height="25" cellpadding="0" cellspacing="1" id="tblGLs">
                            <tr>
                              <td width="39"  class="mainHeading4"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this);"  /></td>
                              <td width="115"  class="mainHeading4"><div align="center">Account ID</div></td>
                              <td width="243"  class="mainHeading4"><div align="center">Description</div></td>
                              <td width="135" class="mainHeading4"><div align="center">Account Type</div></td>
							<td width="60"  class="mainHeading4"><div align="center">Status</div></td>
                            </tr>
                          </table>                      
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td bgcolor=""><table width="100%" border="0" >
                    <tr>
                      <td width="26%">&nbsp;</td>
                      <td width="12%"><span class="normalfntp2"><img src="../../images/new.png"  onclick="clearGlAForm('frmGLAllocation','tblGLs');" tabindex="7"/></span></td>
                      <td width="12%" class="normalfntp2"><img src="../../images/save.png" alt="report" width="84" height="24" onclick="saveGLAllowcation()" tabindex="4"/></td>
                      <td width="12%" class="normalfntp2"><img src="../../images/report.png" onclick="glReport('cboFactory');" tabindex="5"/></td>
                      <td width="12%" class="normalfntp2"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0"  tabindex="6"/></a></td>
                      <td width="26%">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    
  </tr>
</table>
</body>
</html>
