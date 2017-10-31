<?php
session_start();
$backwardseperator = "../../../";
include_once("${backwardseperator}authentication.inc");
include_once("${backwardseperator}Connector.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro | Damage Entry</title>
<script src="../../../javascript/script.js" type="text/javascript"></script>
</head>
<body>
<table width="100%">
<tr>
	<td><?php include("${backwardseperator}Header.php");?></td>
</tr>
</table>
<form name="frmWetQc" id="frmWetQc">
<table width="50%" align="center" class="main_border_line" border="0">
	<tr>
    	<td class="mainHeading" colspan="4">Damage Entry</td>
    </tr>
    <tr>
    	<td colspan="4">&nbsp;</td>
    </tr>
    <tr>
    	<td width="10%" class="normalfnt"></td>
    	<td width="22%" class="normalfnt">Search</td>
    	<td width="58%"><select style="width:202px;height:20px;"></select></td>
        <td width="10%" class="normalfnt"></td>
    </tr>
    <tr>
        <td width="10%" class="normalfnt">&nbsp;</td>
    	<td class="normalfnt">Damage Type</td>
        <td><input type="text" style="width:200px;" /></td>
        <td width="10%" class="normalfnt">&nbsp;</td>
    </tr>
    <tr>
        <td width="10%" class="normalfnt">&nbsp;</td>
    	<td class="normalfnt">Damage Description</td>
    	<td><input type="text" style="width:300px;" /></td>
        <td width="10%" class="normalfnt">&nbsp;</td>
    </tr>
    <tr>
        <td width="10%" class="normalfnt">&nbsp;</td>
    	<td class="normalfnt">Active</td>
    	<td><input type="checkbox" /></td>
        <td width="10%" class="normalfnt">&nbsp;</td>
    </tr>
    <tr>
        <td class="normalfnt" colspan="4" align="center">&nbsp;</td>
    </tr>
    <tr align="center">
    	<td class="normalfnt" colspan="4" align="center">
        <div align="center">
        <img src="../../../images/new.png" /><img src="../../../images/save.png" /><img src="../../../images/report.png" /><img src="../../../images/close.png" />
        </div>
        </td>
    </tr>
</table>
</form>
</body>
</html>