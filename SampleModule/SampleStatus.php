<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Status</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="trans_layoutS">
		<div class="trans_text">Sample Status<span class="volu"></span></div>
			<table align="center" width="62%" border="0">
				<tr>
					<td width="4%" class="normalfnt"></td>
					<td width="31%" class="normalfnt">ID</td>
		  	  	  <td width="65%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
				</tr>
				<tr>	
					<td width="4%" class="normalfnt"></td>
					<td width="31%" class="normalfnt">Description</td>
			  	  <td width="65%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
				</tr>
	  	  </table>
			<br />
			<table align="center" width="367" border="0">
      			<tr>
					<td width="15%">&nbsp;</td>
					<td width="26%"><img src="../images/new.png" width="90" /></td>
					<td width="23%"><img src="../images/save.png" width="80" /></td>
					<td width="26%"><a href="../main.php"><img src="../images/close.png" alt="close" width="90" border="0" /></a></td>
					<td width="10%">&nbsp;</td>
      			</tr>
		  </table>
		</div>
	</div>
</div>
</body>
</html>
