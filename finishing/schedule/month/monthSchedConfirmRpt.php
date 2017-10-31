<?php 
/*include "../../../Connector.php";
$backwardseperator = "../../../";
$strScheduleNo = $_GET["intScheduleNo"];
$arrNo = explode('/',$strScheduleNo);
$intScheduleNo = $arrNo[0];*/

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Shipment Plan :: Month</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="../../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="../../../javascript/jquery.js" language="javascript" type="text/javascript"></script>
<script src="../../../javascript/jquery-ui.js" language="javascript" type="text/javascript"></script>
<script src="monthShipSchedule.js" language="javascript" type="text/javascript"></script> 

</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php  include 'monthShipScheduleRpt.php';?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="850" border="0" cellspacing="0" cellpadding="0" class="tablezRED" align="center">
      <tr>
        <td height="25" align="center"><img src="../../../images/conform.png" width="115" height="24" onClick="confirmMonthSchedule(<?php echo $intScheduleNo; ?>,<?php echo $intYear; ?>,<?php echo $intMonth ?>);"></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
