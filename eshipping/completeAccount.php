<?php
session_start();
include "Connector.php";
$email = $_GET["userEmail"];
$sql = "SELECT useraccounts.intUserID,useraccounts.UserName,useraccounts.Name,useraccounts.intCompanyID, companies.strName FROM useraccounts INNER JOIN companies ON useraccounts.intCompanyID = companies.intCompanyID WHERE UserName = '$email'";
$result = $db->RunQuery($sql);				
while($row = mysql_fetch_array($result))
{
	$usersName = $row["UserName"];
	$companyName = $row["strName"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Create New User</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style></head>

<body>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include 'Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td height="35" bgcolor="#498CC2" class="TitleN2white">Create New User</td>
            </tr>
          <tr>
            <td height="165"><form id="frmcategories" name="form1" method="post" action="">
              <table width="100%" height="170" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" height="26" class="head1">Complete</td>
                  </tr>
                <tr class="bcgl1">
                  <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                    <tr>
                      <td width="5%" bgcolor="#E1EBFB">&nbsp;</td>
                        <td width="31%" bgcolor="#E1EBFB" class="normalfnt">E-Mail Address</td>
                        <td colspan="2" bgcolor="#E1EBFB" class="normalfnth2B"><?php echo $email; ?></td>
                      </tr>
                    <tr>
                      <td bgcolor="#E1EBFB">&nbsp;</td>
                        <td bgcolor="#E1EBFB" class="normalfnt">Name</td>
                        <td colspan="2" bgcolor="#E1EBFB" class="normalfnth2B"><?php echo $usersName; ?></td>
                      </tr>
                    <tr>
                      <td bgcolor="#E1EBFB">&nbsp;</td>
                        <td bgcolor="#E1EBFB" class="normalfnt">Company</td>
                        <td width="44%" bgcolor="#E1EBFB" class="normalfnth2B"><?php echo $companyName; ?></td>
                        <td width="20%" bgcolor="#E1EBFB" class="normalfnth2B"><a href="userManager.php"><img src="images/continue.png" alt="continue" width="116" height="24" border="0" /></a></td>
                    </tr>
                    </table></td>
                  </tr>
                <tr class="bcgl1">
                  <td height="21" class="normalfnth2">The fallowing previlages have been granted to this user. </td>
                  </tr>
                <tr class="bcgl1">
                  <td><table width="100%" border="0" class="bcgl1">
                    <?php
				  
				  
				    $SQL = "SELECT role.RoleName FROM useraccounts INNER JOIN userpermission ON useraccounts.intUserID = userpermission.intUserID INNER JOIN role ON userpermission.RoleID = role.RoleID WHERE useraccounts.UserName ='" . $_GET["userEmail"] . "';";
			
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
					
				  
				  ?>
                    <tr>
                      <td width="5%">&nbsp;</td>
                        <td width="7%" class="normalfnt"><img src="images/ok-mark.png" alt="ok" width="18" height="15" /></td>
                        <td width="88%" class="normalfnt"><?php echo $row["RoleName"];?></td>
                      </tr>
                    
                    <?php
					}
					?>
                    
                    </table></td>
                  </tr>
                <tr class="bcgl1">
                  <td bgcolor="#D6E7F5"><table width="100%" border="0">
                    <tr>
                      <td width="20%">&nbsp;</td>
                        <td class="normalfntp2"><div align="center"><a href="userManager.php"><img src="images/continue.png" alt="continue" width="116" height="24" border="0" /></a></div>                        
                        <div align="center"></div></td>
                        <td width="20%">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
              </form></td>
            </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="specialFnt1">ePlan Web : : California Link (Pvt) Ltd. All Rights Reserved. 2009(c)</td>
  </tr>
</table>
</body>
</html>
