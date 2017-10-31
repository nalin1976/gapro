<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reset Password</title>
<script language="javascript" type="text/javascript" >
function validateForm()
{
	if (document.getElementById('txtPassword').value !=  document.getElementById('txtRetype').value )
	{
		alert("The password and Retype Password does not match.");
		document.getElementById('txtPassword').focus();
		return false;
	}
	document.getElementById('frmReset').submit();
}
</script>

<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:259px;
	top:105px;
	width:369px;
	height:173px;
	z-index:1;
}
-->
</style>
</head>

<body>
<form name="frmReset" id="frmReset" action="changePassword.php" method="post" >
<div id="Layer1">
  <table width="357" height="160" border="0" bordercolor="#000000" class="txtbox">
    <tr>
      <td colspan="2" class="bcgcolor-highlighted"><strong>Reset Password </strong></td>
    </tr>
    <tr>
      <td width="163">New Password </td>
      <td width="184"><input name="txtPassword" type="password" id="txtPassword" /></td>
    </tr>
    <tr>
      <td>Retype Password </td>
      <td><input name="txtRetype" type="password" id="txtRetype" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><img src="images/continue.png" alt="continue" width="116" height="24" onclick="validateForm();" /></td>
    </tr>
  </table>
</div>
</form>
</body>
</html>
