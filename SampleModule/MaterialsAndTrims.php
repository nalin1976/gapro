<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Materials and Trims</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/tablegrid.js"></script>
</head>
<body>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="trans_layoutL">
		<div class="trans_text">Materials and Trims<span class="volu"></span></div>
			<div style="overflow:scroll; height:150px; width:798px;">
				<table style="width:780px" class="transGrid" border="1" cellspacing="1">
					<thead>
						<tr>
							<td colspan="6">Material / Parts / Accessories / Trims / Lining Usage Table</td>			
						</tr>	
						<tr>
							<td width="48">Select</td>
							<td width="407">Meterial, Parts, Trims Description</td>
							<td width="45">YY</td>	
							<td width="62">Unit</td>	
							<td width="190">Placement</td>				
						</tr>		
					</thead>	
					<tbody>
						<tr>
						  	<td width="48"><input id="" name="" type="checkbox" class="txtbox"  /></td>
							<td width="407">****</td>
							<td width="45">****</td>	
							<td width="62">****</td>
							<td width="190">****</td>			
						</tr>
						<tr>
							<td width="48"><input id="" name="" type="checkbox" class="txtbox"  /></td>
							<td width="407">****</td>
							<td width="45">****</td>
							<td width="62">****</td>
							<td width="190">****</td>				
						</tr>	
					</tbody>
				</table>
			</div>
			<br />
			<table width="800" border="0">
				<tr>
					<td width="34%">&nbsp;</td>
					<td width="12%"><img src="../images/new.png" id="butNew" name="butNew" width="90" /></td>
					<td width="11%"><img src="../images/save.png" id="butSave" name="butSave" width="80" /></td>
					<td width="12%"><a href="../main.php"><img src="../images/close.png" id="butClose" name="butClose" alt="close" width="90" border="0" /></a></td>
					<td width="31%">&nbsp;</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>
