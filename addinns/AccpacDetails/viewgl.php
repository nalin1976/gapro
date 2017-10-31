<?php
session_start();
include "../../Connector.php";
$backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View GL Account</title>

<link href="file:///C|/Program Files/Inetpub/wwwroot/GaPro/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script  language="javascript" type="text/javascript" src="accPackGL.js">
</script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<form name="frmViewGlAcc" id="frmViewGlAcc">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">View GL Account</div></div>
<div class="main_body">
<table width="526" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" class="">
      <tr>
        <td width="77%">
          <table width="100%" border="0">

            <tr>
              <td height="17">
              <fieldset style="-moz-border-radius: 5px;">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="" id="">
                  <tr>
                    <td width="4%" height="25">&nbsp;</td>
                    <td width="19%" class="normalfnt">ID</td>
                    <td><select name="cboID" class="txtbox" id="cboID" onchange="setValues(1)" style="width:150px" tabindex="1">
                    
					<?php
						$SQL="select distinct strAccID from glaccounts order by strAccID;";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["strAccID"] ."\">" . $row["strAccID"] ."</option>" ;
						}
				
					?>
					
					</select>                    </td>
                    <td width="16%">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="12">&nbsp;</td>
                    <td width="19%" class="normalfnt">Description</td>
                    <td width="61%"><select name="cboDescription" class="txtbox" onchange="setValues(2)" id="cboDescription" style="width:300px" tabindex="2">
					<?php
						$SQL="select strDescription from glaccounts group by strDescription";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["strDescription"] ."\">" . $row["strDescription"] ."</option>" ;
						}
					
					?>
										
										
										</select></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="12">&nbsp;</td>
                    <td width="19%" class="normalfnt">Factory</td>
                    <td width="61%">
					<select name="cboFactory" class="txtbox" id="cboFactory" onchange="setValues(3)" style="width:300px" tabindex="3">
					
						<?php
							$SQL="select intCostCenterId,strDescription from costcenters where intStatus=1 order by strDescription";
							
							$result = $db->RunQuery($SQL);
							echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
							while($row = mysql_fetch_array($result))
							{
							echo "<option value=\"". $row["intCostCenterId"] ."\">" . $row["strDescription"] ."</option>" ;
							}
						?>  

                    </select></td>
                    <td><img src="../../images/search.png" onclick="LoadGLAccstoViewTable()" alt="search" width="80" height="24" tabindex="4"/></td>
                  </tr>
              </table>
              </fieldset>
              </td>
            </tr>
            <tr>
              <td height="165"><table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%">
                    <fieldset style="-moz-border-radius: 5px;">
                    <table width="100%" border="0" class="" id="tblGlDets">
                        <tr>
                          <td colspan="3">
						  
						  
						  <div id="divcons" style="overflow:scroll; height:130px; width:500px;">
                              <table width="600"  bgcolor="" cellpadding="0" cellspacing="1" class="normalfnt" id="tblGLs">
                                <tr>
                                  <td width="29" class="grid_header">Del</td>
                                  <td width="32" class="grid_header">Edit</td>
                                  <td width="75" class="grid_header">Account ID</td>
                                  <td width="194" height="16" class="grid_header">Description</td>
                                  <td width="91" class="grid_header">Account Type</td>
                                  <td width="77" class="grid_header">Fac Code</td>
                                </tr>
 

                              </table>
                          </div>
						  
						  
						  </td>
                        </tr>
                    </table>
                    </fieldset>
                    </td>
                  </tr>
                  <tr class="">
                    <td bgcolor=""><table width="100%" border="0" class="tableBorder3">
                        <tr>
                          <td width="22%" class="normalfntp2">&nbsp;</td>
                          <td width="18%" class="normalfntp2"><a href="addGL.php"><img src="../../images/back.png"  border="0" tabindex="5"/></a></td>
                          <td width="22%" class="normalfntp2"><img src="../../images/report.png" alt="report" width="108" height="24" tabindex="6" /></td>
                          <td width="22%" class="normalfntp2"><a href="addGL.php"><img src="../../images/close.png" alt="close" width="108" height="24" border="0" tabindex="7"/></a></td>
                          <td width="16%">&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
          </table>
        </td>
    
      </tr>
    </table></td>
  </tr>
  
</table>
</div>
</div
></form>
</body>
</html>
