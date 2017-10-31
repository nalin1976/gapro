<?php
session_start();
include "authentication.inc";
$companyId = $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Create New User</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="javascript/script.js"></script>
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
/*	else if (document.getElementById('cboFactory').value == "Select One" )
	{
		alert("Please selcet the company name.");
		document.getElementById('cboFactory').focus();
		return false;
	}*/
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
				alert("User already exists. Please try with another email address.");
			else
				document.frmcategories.submit();
		}		
	}
}


function addCompaniesToText(obj)
{
/*	if(obj.checked)
		document.getElementById('txtFactory').value += obj.parentNode.id +',';
	else
		document.getElementById('txtFactory').value 
		
	alert(document.getElementById('txtFactory').value );*/
	
	
	var tbl 	= document.getElementById('tblFactory');
	var rows 	= tbl.rows.length;
	var value='';
	for(var i=1;i<rows;i++)
	{
		var chk = tbl.rows[i].cells[1].childNodes[0];
		if(chk.checked)
		{
			value +=  tbl.rows[i].cells[1].id +',';
			//alert(value);
		}
	}
	
	document.getElementById('txtFactory').value = value;
	//alert(value);
}

function ViewCopyUserCombo(obj)
{
	if(obj.checked)
		document.getElementById('cboCopy').style.visibility = "visible";		
	else
		document.getElementById('cboCopy').style.visibility = "hidden";		
}
function GetZeroIsEmpty(obj)
{
	if(obj.value=="")
		obj.value = 0;
}
function MaxQty(obj)
{
	if(obj.value>100)
		obj.value = 100;
}
</script>

</head>
<?php
	
	include "Connector.php";
	
	?>
<body>
  <tr>
    <td><?php include 'Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">

  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="26%">&nbsp;</td>
        <td width="48%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" class="mainHeading">Create New User</td>
          </tr>
          <tr>
            <td height="165"><form name="frmcategories" id="frmcategories" method="post" action="usergenerator.php">
              <table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" height="26" class="head1">Basic Information</td>
                </tr>
                <tr class="bcgl1">
                  <td><table width="100%" border="0" class="tableBorder">
                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="30%" class="normalfnt">E-Mail Address</td>
                      <td width="65%" class="normalfnt"><input name="txtemailaddress" type="text" class="txtbox" id="txtemailaddress" size="40" /></td>
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
                      <td class="normalfnt">Ex. Grn Percentage </td>
                      <td class="normalfnt"><input name="txtExGrnPercent" type="text" class="txtbox" id="txtExGrnPercent" size="2" maxlength="3" value="0" style="text-align:right" onkeypress="return IsNumberWithoutDecimals(this.value,event);" onblur="GetZeroIsEmpty(this);" onkeyup="MaxQty(this);" <?php if(!$canEditUserExcessPecentage) { ?> disabled="disabled" <?php }?>/>&nbsp;%</td>
                    </tr>
					  <tr>
                      <td>
                        <input style="visibility:hidden"  name="txtFactory" type="text" id="txtFactory" size="2" />                     </td>
                      <td class="normalfnt">Factory / Office </td>
                      <td class="normalfnt">
				  <table id="tblFactory" width="100%" border="0" class="bcgl1" cellspacing="1" bgcolor="#FFD9D9">
					<tr>
					  <td class="mainHeading2" >Factory</td>
					  <td width="57" class="mainHeading2">Select</td>
					</tr>
									
                 <?php
				
				$SQL = "SELECT intCompanyID,concat(strName,'-',strComCode)as strName FROM companies c where intStatus='1' order by strName;";
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
				{					
				?>
					<tr class="bcgcolor-tblrowWhite">
					  <td ><?php echo $row["strName"]; ?></td>
					  <td id="<?php echo $row["intCompanyID"]; ?>" align="center"><input name="chkFactory" type="checkbox" class="txtbox" id="chkFactory" value="checkbox"  onclick="addCompaniesToText(this);" /></td>
					</tr>
				<?php
				}
				?>
				  </table>							  </td>
					  </tr>
					  <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Copy User From </td>
                      <td class="normalfnt"><input type="checkbox" id="chkCopy" name="chkCopy" onclick="ViewCopyUserCombo(this);"/>
					  					  <select id="cboCopy" name="cboCopy" style="width:253px;visibility:hidden" class="txtbox" >
				
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
	</select></td>
					  </tr>
					  
                    <tr>
                      <td height="21">&nbsp;</td>
                      <td valign="top" class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td ><table width="100%" border="0"  class="tableBorder">
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
    <td class="copyright" align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>
