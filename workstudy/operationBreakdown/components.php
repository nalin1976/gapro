<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Components</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>

</head>

<body>

<?php
include "../../Connector.php";

?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Components<span class="vol">#</span></div>
	</div>
	<div class="main_body">
	<table align="center" border="0" cellspacing="1" width="600">
		<tr>
			<td class="normalfnt" width="113">&nbsp;</td>
			<td class="normalfnt" width="120">Search</td>
			<td width="216">
				<select class="txtbox" style="width: 203px;">	
					<option>#</option>
					<option>#</option>  
					<option>#</option>  
					<option>#</option>  
					<option>#</option>    
				</select>                 
		  </td>
		</tr>
		<tr>
			<td class="normalfnt" width="113">&nbsp;</td>
			<td class="normalfnt" width="120">Com. CatCode</td>
			<td width="216">
				<select class="txtbox" style="width: 203px;">	
					<option>#</option>
					<option>#</option>  
					<option>#</option>  
					<option>#</option>  
					<option>#</option>    
				</select>                 
		  </td>
			<td width="130"><input type="checkbox" checked="checked"  class="chkbox"></td>              
			<td width="5"></td>
		</tr>
		<tr>
			<td class="normalfnt" width="113">&nbsp;</td>
			<td class="normalfnt" width="120">Com. Code</td>
			<td width="216"><input style="width:200px;" class="txtbox" type="text" maxlength="10"></td>
		</tr>
		<tr>
			<td class="normalfnt" width="113">&nbsp;</td>
			<td class="normalfnt" width="120">Component</td>
			<td width="216"><input style="width:200px;" class="txtbox" type="text" maxlength="10"></td>
		</tr>
		<tr>
			<td class="normalfnt" width="113">&nbsp;</td>
		</tr>
		<tr>
			<td class="normalfnt" width="113">&nbsp;</td>
			<td class="normalfnt" width="120">Active</td>
			<td width="216"><input type="checkbox" checked="checked"  class="chkbox"></td>
		</tr>
	</table>
	<br />
	<table width="600">
		<tr>
			<td width="22%">&nbsp;</td>
			<td width="19%"><img src="../../images/new.png" class="mouseover"></td>
			<td><img src="../../images/save.png" alt="Save" class="mouseover"></td>
			<td width="15%"><img src="../../images/delete.png" class="mouseover" height="24"></td>
			<td width="18%"><a href="#"><img src="../../images/close.png" id="Close" border="0"></a></td>
			<td width="26%">&nbsp;</td>
		</tr>
	</table>
</div>
</div>
</body>
</html>
