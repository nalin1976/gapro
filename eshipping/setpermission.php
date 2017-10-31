<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web :: Create Permission</title>
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

function ReloadImage()
{
	var obj = document.getElementById('CAPTCHA');
    var src = obj.src;
    var pos = src.indexOf('?');
    if (pos >= 0) {
       src = src.substr(0, pos);
    }
    var date = new Date();
    obj.src = src + '?v=' + date.getTime();
}

function SetPermission()
{
			var CategoryID = document.getElementById('cmdCategoryID').value;
			var RoleName = document.getElementById('txtRoleName').value;
			var RolleDescription = document.getElementById('txtRolleDescription').value;
			createXMLHttpRequest();
			xmlHttp.onreadystatechange = SetPermissionRequest;
			xmlHttp.open("GET", 'userHandling.php?RequestType=SetPermission&CategoryID=' + CategoryID+  '&RoleName=' +RoleName+ '&RolleDescription=' +RolleDescription, true);
			xmlHttp.send(null);
}

function SetPermissionRequest()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
		  	var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("Permission Created");
			}
			else
			{
				alert("Sorry!\nErrer occur while saving the dsta.Please seve it again.")
			}
		}		
	}
}




</script>

</head>
<?php
	
	include "Connector.php";
	
	?>
<body>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include 'Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="26%">&nbsp;</td>
        <td width="48%"><table width="100%" border="0">
          <tr>
            <td height="35" bgcolor="#498CC2" class="TitleN2white">Create Permission </td>
          </tr>
          <tr>
            <td height="165"><form name="frmcategories" id="frmcategories" method="post" action="usergenerator.php">
              <table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" height="26" class="head1">Basic Information</td>
                </tr>
                <tr class="bcgl1">
                  <td><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="31%" class="normalfnt">Role Category </td>
                      <td width="64%" class="normalfnt"><select name="cmdCategoryID"  class="txtbox" id="cmdCategoryID" style="width:253px;"/>
<?php
$sql="select * from rolecategories order by categoryID";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	echo "<option value=\"".$row["categoryID"]."\">".$row["categoryName"]."</option>\n";
}
?>
                      
                      </select></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Role Name </td>
                      <td class="normalfnt"><input name="txtRoleName" type="text" class="txtbox" id="txtRoleName" size="40" /></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Role Description </td>
                      <td class="normalfnt"><input name="txtRolleDescription" type="text" class="txtbox" id="txtRolleDescription" size="40" /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td bgcolor="#D6E7F5"><table width="100%" border="0">
                    <tr>
                      <td width="20%">&nbsp;</td>
                      <td width="30%" class="normalfntp2"><div align="center"><img src="images/save.png" alt="next" width="84" height="24" onclick="SetPermission();" /></div></td>
                      <td width="30%" class="normalfntp2"><div align="center"><a href="main.php"><img src="images/close.png" alt="Close" width="97" height="24" border="0" /></a></div></td>
                      <td width="20%">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table>
                        </form>            </td>
          </tr>
        </table></td>
        <td width="26%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="specialFnt1">ePlan Web : : California Link (Pvt) Ltd. 2009 © All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>
