<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create New User</title>
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

function checkemail(str)
{
	var filter= /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str))
		return true;
	else
		return false;
}

function validateForm()
{
	var email = document.getElementById('txtemailaddress').value;
	if (!checkemail(email))
	{
		alert("Pease enter Valid email address");
		document.getElementById('txtemailaddress').focus();
		return false;
	}	
	else if (document.getElementById('txtpassword').value == "" || document.getElementById('txtpassword').value == null)
	{
		alert("Pease enter the password.");
		document.getElementById('txtpassword').focus();
		return false;
	}
	else if (document.getElementById('txtpassword').value !=  document.getElementById('txtpassword2').value )
	{
		alert("The password and Retype Password does not match.");
		document.getElementById('txtpassword2').focus();
		return false;
	}
	else if (document.getElementById('txtname').value == "" || document.getElementById('txtname').value == null)
	{
		alert("Please enter your name.");
		document.getElementById('txtname').focus();
		return false;
	}
	else if (document.getElementById('cboFactory').value == "Select One" )
	{
		alert("Please selcet the company name.");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else
	{
		return true;
	}
	return true;
}

function PrepairSubmition()
{
	if (validateForm())
	{
			var email = document.getElementById('txtemailaddress').value;
			createXMLHttpRequest();
			xmlHttp.onreadystatechange = HandleUserAvailability;
			xmlHttp.open("GET", 'userHandling.php?RequestType=CheckUserAvailability&Email=' + email, true);
			xmlHttp.send(null);
	}
}

function HandleUserAvailability()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
		  	var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("User already exists. Please try with another email address.");
			}
			else
			{
				document.frmcategories.submit();
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
            <td height="35" bgcolor="#498CC2" class="TitleN2white">Create New User</td>
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
                      <td width="31%" class="normalfnt">E-Mail Address</td>
                      <td width="64%" class="normalfnt"><input name="txtemailaddress" type="text" class="txtbox" id="txtemailaddress" size="40" /></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Password</td>
                      <td class="normalfnt"><input name="txtpassword" type="password" class="txtbox" id="txtpassword" size="40" /></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Re-Type Password</td>
                      <td class="normalfnt"><input name="txtpassword2" type="password" class="txtbox" id="txtpassword2" size="40" /></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Name</td>
                      <td class="normalfnt"><input name="txtname" type="text" class="txtbox" id="txtname" size="40" /></td>
                      </tr>
					  <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Factory / Office </td>
                      <td class="normalfnt">
					  					  <select id="cboFactory" name="cboFactory" style="width:253px;" class="txtbox">
				
                          <?php
	
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1' order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		//if ($_SESSION["CompanyID"] ==  $row["intCompanyID"])
		//	echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		//else
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
	</select>
                      </td>
					  </tr>
					  <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Copy User From </td>
                      <td class="normalfnt">
					  					  <select id="cboCopy" name="cboCopy" style="width:253px;" class="txtbox">
				
                          <?php
	
	$SQL = "SELECT intUserID,UserName FROM useraccounts";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		//if ($_SESSION["CompanyID"] ==  $row["intCompanyID"])
		//	echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		//else
			echo "<option value=\"". $row["intUserID"] ."\">" . $row["UserName"] ."</option>" ;
	}
	
	?>
	</select><input type="checkbox" id="chkCopy" name="chkCopy"/> </td>
					  </tr>
					  
                    <tr>
                      <td height="21">&nbsp;</td>
                      <td valign="top" class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td bgcolor="#D6E7F5"><table width="100%" border="0">
                    <tr>
                      <td width="20%">&nbsp;</td>
                      <td width="30%" class="normalfntp2"><div align="center"><img src="images/next.png" alt="next" width="95" height="24" onclick="PrepairSubmition();" /></div></td>
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
    <td class="specialFnt1">ePlan Web : : California Link (Pvt) Ltd. All Rights Reserved. 2009(c)</td>
  </tr>
</table>
</body>
</html>
