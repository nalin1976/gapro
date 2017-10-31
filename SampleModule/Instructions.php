<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Instructions</title>
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
		<div class="trans_text">Instructions<span class="volu"></span></div>
			<table width="84%" border="0">
				<tr>
					<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Assemble / Sewing</td>
					<td width="2%"></td>
				  	<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Closure / Zipper / Button / Velco</td>
					<td width="3%"></td>
					<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Internal Sample Remarks</td>
					<td width="2%"></td>
				</tr>
				<tr>
			  	  <td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
					<td width="2%"></td>
			  	  	<td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
					<td width="3%"></td>
				  	<td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
				  	<td width="2%"></td>
				</tr>	
				<tr>
					<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Labelling / Tags / hangtag</td>
					<td width="2%"></td>
				  	<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Packing</td>
					<td width="3%"></td>
					<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Buyer Comment</td>
					<td width="2%"></td>
				</tr>
				<tr>
				  	<td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
					<td width="2%"></td>
			  	  	<td width="31%" class="normalfnt"><textarea id="" name=""class="txtbox" style="width:200px; height:65px;"></textarea></td>
					<td width="3%"></td>
				  	<td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
				  	<td width="2%"></td>
				</tr>			
		  </table>
		  <table width="84%" border="0">
				<tr>
					<td colspan="3" bgcolor="#e5e4e4" class="normalfnt">Remarks</td>
					<td colspan="3"></td>
				</tr>
				<tr>
			  	  <td colspan="3" class="normalfnt"><textarea  id="" name="" class="txtbox" style="width:420px; height:65px;"></textarea></td>
					<td width="4%"></td>
				  	<td width="15%" bgcolor="#e5e4e4" class="normalfnt"></td>
				  	<td width="15%" bgcolor="#e5e4e4"></td>
					<td width="3%"></td>
				</tr>
				<tr>
			  	  	<td colspan="4"></td>
				  	<td width="15%"><img src="../images/search.png" id="butSearch" name="butSearch" width="60"/></td>
				  	<td width="15%"><img src="../images/search.png" id="butSearch" name="butSearch" width="60" /></td>
					<td width="3%"></td>
				</tr>			
		  </table>
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
