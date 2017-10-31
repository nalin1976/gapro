<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pich Time</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
include "../../Connector.php";
?>
<form id="frmOperations" name="frmOperations" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom_center1">
	<div class="main_top">
		<div class="main_text">Pich Time<span class="vol"></span></div>
	</div>
	<div class="main_body">
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="126" class="normalfnt">Style No</td>
			<td width="256"><input style="width: 201px;" class="txtbox" type="text"></td>  
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">PO No</td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>     
		</tr>
	</table>	
	
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="164" bgcolor="#E8E8E8" class="normalfnt"><b>Workers :</b></td>  
			<td width="429">&nbsp;</td>  
		</tr>
	</table>
	
	<table border="0" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="128" class="normalfnt">M/O</td>
			<td width="254"><input style="width: 201px;" class="txtbox" type="text"></td>  
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Helpers</td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>    
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Total Workers</td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>    
		</tr>
	</table>
		
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="166" bgcolor="#E8E8E8" class="normalfnt"><b>Total SMV :</b></td>
			<td width="427">&nbsp;</td>   
		</tr>
	</table>
	
	<table border="0" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="131" class="normalfnt">M/SMV</td>
			<td width="251"><input style="width: 201px;" class="txtbox" type="text"></td>  
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">H/SMV</td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>    
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Total SMV<li style="list-style:none; font-size:9px;">(without non line SMV)</li></td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>    
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Total SMV</td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>    
		</tr>
	</table>		
	
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="141" class="normalfnt"></td>
			<td width="142"><img src="../../images/cal.png"/></td>
			<td width="107">&nbsp;</td>   
		</tr>
	</table>
	
	<table border="0" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="131" class="normalfnt">Total P/T</td>
			<td width="251"><input style="width: 201px;" class="txtbox" type="text"></td>  
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Machine P/T</td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>    
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Req. M/O</td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>    
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Req. Helpers</td>
			<td><input style="width: 201px;" class="txtbox" type="text"></td>    
		</tr>
	</table>
	
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="131" class="normalfnt">P/T Variance %</td>
			<td width="251"><input style="width: 201px;" class="txtbox" type="text"></td>  
		</tr>		
	</table>
	
	<table class="table" width="400">
		<tr>
			<td width="22%">&nbsp;</td>
			<td width="19%"><img src="../../images/edit_icon.png"name="New"></td>
			<td><img src="../../images/save.png"></td>
			<td width="18%"><a href="../../main.php"><img src="../../images/close.png" border="0"></a></td>
			<td width="26%">&nbsp;</td>
		</tr>
	</table>
	</div>
</div>
</form>	
</body>
</html>