<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Color Block Contrast Color</title>
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
		<div class="trans_text">Color Block Contrast Color<span class="volu"></span></div>
		  <div style="overflow:scroll; height:150px; width:798px;">
		    <table width="1200" border="1" cellspacing="1" class="transGrid">
              <thead>
                <tr>
                  <td colspan="11">Color Block & Contrast Color placement and body location instruction</td>
                </tr>
                <tr>
                  <td width="75">Body Panel</td>
                  <td width="124">Color Combo 1</td>
                  <td>Color Combo 1</td>
                  <td>Color Combo 2</td>
                  <td>Color Combo 3</td>
                  <td>Color Combo 4</td>
                  <td>Color Combo 5</td>
                  <td>Color Combo 6</td>
                  <td>Color Combo 7</td>
                  <td>Color Combo 8</td>
                  <td>Color Combo 9</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td width="75"><input name="checkbox" id="checkbox" type="checkbox" class="txtbox"  /></td>
                  <td width="124">****</td>
                  <td width="98">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="110">****</td>
                </tr>
                <tr>
                  <td width="75"><input name="checkbox2" id="checkbox2" type="checkbox" class="txtbox"  /></td>
                  <td width="124">****</td>
                  <td width="98">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="105">****</td>
                  <td width="110">****</td>
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
