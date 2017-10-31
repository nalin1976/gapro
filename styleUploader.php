<?php
 session_start();
 $_SESSION["currentStyle"] = $_GET["styleNo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Uploader</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.nobcg {
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
-->
</style>
</head>

<body>
<form action="uploader.php" method="post" enctype="multipart/form-data" name="formstyle" id="formstyle">
  <table width="429" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
    <tr>
      <td height="31" colspan="4" bgcolor="#498CC2" class="TitleN2white">Style Uploader</td>
    </tr>
    <tr>
      <td width="15" height="34">&nbsp;</td>
      <td colspan="3" class="normalfnt2bld">Please select your style</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="74" class="normalfnt">Image</td>
      <td colspan="2"><input name="file" type="file" class="txtbox" id="file" size="40" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="177">&nbsp;</td>
      <td width="161">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" bgcolor="#D6E7F5">&nbsp;</td>
      <td bgcolor="#D6E7F5">&nbsp;</td>
      <td bgcolor="#D6E7F5">&nbsp;</td>
      <td bgcolor="#D6E7F5"><a href="javascript:document.formstyle.submit();"> <img src="images/ok.png" alt="ok" width="86" height="24" class="nobcg" /> </a></td>
    </tr>
  </table>
</form>
</body>
</html>
