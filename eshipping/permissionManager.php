<?php
session_start();


include "Connector.php";

$userID = $_GET["userID"];
$_SESSION["changingUser"] = $userID;
$emailAddress = "";
$sql = "select UserName from useraccounts where intUserID = $userID";
$result = $db->RunQuery($sql);				
while($row = mysql_fetch_array($result))
{
	$emailAddress = $row["UserName"];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Permission Manager</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function SaveSelectedPermisions()
{
	var PermisionList = "";
	var radio = document.getElementsByName("role");
	if (radio.length == 0)
	{
		alert("The user must have ta least one previlage.");
		return;
	}

	for (var ii = 0; ii < radio.length; ii++)
	{
		if (radio[ii].checked)
		{
			PermisionList += radio[ii].id + ",";			
		}
	}
	PermisionList = PermisionList.substring(0,PermisionList.length-1);
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleUsers;
	xmlHttp.open("GET", 'userHandling.php?RequestType=UpdatePrivil&PrivilageList=' + PermisionList + '&userID=<?php echo $userID; ?>', true);
	xmlHttp.send(null); 

}

function HandleUsers()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLReuslt = xmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLReuslt[0].childNodes[0].nodeValue == "True")
			{
				ShowSuccessfullPage();

			}
			else
			{
				alert("User account creation failed.");
				window.location = "createnewuser.php";				
			}
				
		}
	}
}

function ShowSuccessfullPage()
{
	window.location = "completeAccount.php?userEmail=<?php echo $emailAddress;  ?>";
}

function checkAll(obj)
{
	var tbl = obj.parentNode.parentNode.parentNode.parentNode.parentNode;
	if (obj.checked)
	{		
		for (var loop = 1; loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[1].childNodes[0].checked = true;
		}
	}
	else
	{
		for (var loop = 1; loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[1].childNodes[0].checked = false;
		}
	}
}


</script>
</head>

<body>
<table width="950" border="0" cellpadding="0"  align="center" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td><table width="109%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="83%" height="35" bgcolor="#498CC2" class="TitleN2white"><div align="left">&nbsp;Assigning User Roles - <?php echo $emailAddress; ?> </div></td>
            <td width="17%" bgcolor="#498CC2" class="TitleN2white"><span class="normalfnBLD1"><a href="resetPassword.php" target="_self"><img src="images/resetPassword.png" width="115" height="24" border="0" /></a></span></td>
          </tr>
          <tr>
            <td height="165" colspan="2"><form id="frmcategories" name="frmcategories" method="post" >
              <table width="100%" height="172" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="23" colspan="2" class="head1"><p>User Privileges</p>                      </td>
                  </tr>
                <tr>
                  <td width="84%" height="13" class="normalfnBLD1"><p>Please select appropriate permissions.</p>
                    <p>&nbsp;</p></td>
                  <td width="16%" class="normalfnBLD1">&nbsp;</td>
                </tr>
                <tr class="bcgl1">
                  <td colspan="2">
				  <?php
				  $sql = "SELECT categoryID,categoryName,catDescription FROM rolecategories ORDER BY categoryName";
				  $resultrole = $db->RunQuery($sql);
				  while($rowrole = mysql_fetch_array($resultrole))
				 {
				  ?>
				  <table width="100%" border="0" id="tblpermisions" class="bcgl1">
				   <tr>
                      <td colspan="4" bgcolor="#99CCFF" class="head1">&nbsp;&nbsp;&nbsp;&nbsp;<span class="normalfnt">
                        <input type="checkbox" name="checkall" id="checkall" onchange="checkAll(this);" />
                      </span>&nbsp;<?php echo $rowrole["categoryName"];?></td>
                      </tr>
                    <?php
				  
				  $SQL = "SELECT RoleID,categoryID,RoleName,roleDescription,(SELECT intUserID FROM userpermission WHERE RoleID = r.RoleID AND intUserID = $userID) AS permitted FROM role r WHERE categoryID = " . $rowrole["categoryID"] . " ORDER BY RoleName;" ;
	
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
							  
				  ?>
                   
                    <tr>
                      <td width="5%">&nbsp;</td>
                        <td width="10%" class="normalfnt"><input type="checkbox" <?php if ($row["permitted"] != "" && $row["permitted"] != NULL){ ?> checked="checked" <?php } ?> name="role" id="<?php echo $row["RoleID"];?>" /></td>
                        <td width="29%" class="normalfnt"><?php echo $row["RoleName"];?></td>
                        <td width="56%" class="normalfnt"><?php echo $row["roleDescription"];?>.</td>
                    </tr>
                    <?php
				   }
				   ?>
                    </table>
					<?php
					}
					?>					</td>
                  </tr>
                <tr class="bcgl1">
                  <td colspan="2" bgcolor="#D6E7F5"><table width="100%" border="0">
                    <tr>
                      <td width="20%">&nbsp;</td>
                        <td width="30%" class="normalfntp2"><div align="center"><a href="userManager.php"><img src="images/close.png" alt="close" width="97" height="24" border="0" class="mouseover" onclick="SaveSelectedPermisions();" /></a></div></td>
                        <td width="30%" class="normalfntp2"><div align="center"><a href="javascript:SaveSelectedPermisions();"><img src="images/finish.png" alt="finish" width="96" height="24" class="noborderforlink" /></a></div></td>
                        <td width="20%">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                        </form>            </td>
            </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
