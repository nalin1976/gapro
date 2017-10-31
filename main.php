<?php
session_start();
include "authentication.inc";
include "cancelLeftoverReservation.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="mainPagePanelViewers/planPanel/planDetail.js"></script>

<title>Welcome to GaPro Web</title>


<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="mainPagePanelViewers/panelCSS.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td colspan="3"><?php include 'Header.php'; ?></td>
  </tr>
  <tr><td height="50" colspan="3">&nbsp;</td></tr>
  <tr>
    <td colspan="3" align="center"><img src="images/mainScreen.jpg" width="855" height="566" border="0" class="mainImage" style="border-color:#FF8000" />
<!--	<object width="1000" height="1000">
<param name="movie" value="images/wel-newyear.swf">
<embed src="images/wel-newyear.swf" width="855" height="566"></embed>
</object>-->	</td>
  </tr>
  <tr>
    <td width="1060" height="18" align="right"  class="copyright">&nbsp;</td>
    <td width="1" align="center" >&nbsp;</td>
    <td width="139" align="center" >&nbsp;</td>
  </tr>
</table>
</body>

<script language="javascript" type="text/javascript" src="mainPagePanelViewers/panelJS.js"></script>
<script language="javascript" type="text/javascript" src="mainPageViewers/viewersJS.js"></script>
<?php 
include "mainPagePanelViewers/panel.php";
include "mainPagePanelViewers/panelMenu.php";


?>
</html>
