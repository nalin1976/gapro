<?php
$backwardseperator = "../";
include '../authentication.inc';
session_start();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Email Config</title>

<link href="../css/erpstyle.css"  rel="stylesheet" type="text/css" />
<script src="emailconfig.js"></script>
<script src="../javascript/script.js"></script>
</head>

<body>
<?php
include "../Connector.php";
?>
<form id="frmEmailConfig" name="frmEmailConfig" method="post" action="">
  <tr>
    <td id="tdHeader"><?php include "../Header.php";?></td>
  </tr>
<table width="500" border="0" align="center" bgcolor="#FFFFFF">

  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" align="center" border="0" class="tableBorder">
          <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading">Email Config </td>
          </tr>
          <tr>
            <td >
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr height="1">
                  <td  class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="7%" class="normalfnt">&nbsp; </td>
                  <td width="17%" class="normalfnt">User</td>
                  <td width="76%"><select name="cboMainUserID" class="txtbox" id="cboMainUserID" style="width:200px">
	<?php
	$SQL="select intUserID,UserName from useraccounts where status=1 order by UserName;";
	$result = $db ->RunQuery($SQL);	 
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intUserID"] ."\">" . $row["UserName"] ."</option>" ;
	}
	?>
                  </select>                  </td>
                </tr>
                
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Permission</td>
                  <td colspan="3"><select class="txtbox" id="cboPermission"  style="width:300px" onchange="GetEmailsAccounts(this);">
<?php
			$SQL="select intSerialId,strDescription from emailconfig where intStatus=1;";
			$result=$db->RunQuery($SQL);	 
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			while($row=mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intSerialId"] ."\">" . $row["strDescription"] ."</option>" ;
			}				  
 ?>
                  </select>
                    <img src="../images/add.png" alt="add" width="16" height="16" onclick="LoadEmailsPopUp()"/></td>
                </tr>
                
				<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableFooter">
              <tr>
                <td width="100%"><div id="" style="width:100%;height:250px">
				<table align="center" width="100%" cellpadding="0" cellspacing="1" id="tblMain" border="0" class="tableFooter" bgcolor="#CCCCFF">
                  
                  <tr>
                    <td height="20" width="54" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
                    <td width="456" bgcolor="#498CC2" class="normaltxtmidb2">User Names</td>
                    </tr>
                </table>
                </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" class="tableFooter">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="18%"><img src="../images/new.png" alt="New" name="New"width="96" height="24" id="New" onclick="ClearForm();" /></td>
                <td width="15%"><img src="../images/save.png" alt="Save" name="Save"width="84" height="24" id="Save" onclick="butCommand(this.name)" /></td>
                <td width="18%"><img src="../images/delete.png" alt="Delete" name="Delete"width="100" height="24" id="Delete" onclick="ConfirmDelete(this.name)" /></td>
                <td width="12%" class="normalfnt"><img src="../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ShowRportPopUp();" /></td>
                <td id="tdDelete" width="18%"><a href="../main.php"><img src="../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                <td width="15%">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div id="divReport" style="background-color: #999999;position:absolute;width:150px;left:700px;top:427px;visibility:hidden;border: 1px solid #333333">
<table width="150">	
				<tr>
					<td width="119"  class="normalfnt"><input type="radio" id="rdCurrentDetails" name="rdReport" onclick="ViewReport(this.id);"/>&nbsp;Current Details </td>
			    </tr>	
				<tr>
					<td width="119"  class="normalfnt"><input type="radio" id="rdAllDetails" name="rdReport" onclick="ViewReport(this.id);"/>
				    All&nbsp;Details</td>
				</tr>	
  </table>	
</div>
</body>
</html>
