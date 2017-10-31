<?php
session_start(); 
$gatePassNoArray = explode("/",$_GET["gatePassNo"]);

$gatePassNo =$gatePassNoArray[1];
$gatePassYear = $gatePassNoArray[0];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>General GatePass :: Confirm Report </title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.4.2.min.js"></script>
<script language="javascript" src="gengatepass.js" type="text/javascript"></script>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php include 'generalgatepassreport.php'; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="800" border="0" cellspacing="0" cellpadding="0" class="tablezRED">
  <tr>
    <td align="center"><img src="../../images/conform.png" onClick="confirmGenGP(<?php echo $gatePassNo; ?>,<?php echo $gatePassYear; ?>);"></td>
  </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>
