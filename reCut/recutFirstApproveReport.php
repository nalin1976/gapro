<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro - Recut :: First Approval Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="../javascript/script.js" type="text/javascript"></script>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include 'recutReport.php';?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head1">Approve/Reject Status </td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="17%" class="normalfnt">Remarks</td>
        <td width="83%"><textarea name="txtRemarks" id="txtRemarks" cols="50" rows="2" onKeyPress="return imposeMaxLength(this,event, 200);"></textarea></td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
      <tr>
        <td align="center"><img src="../images/approve.png" width="113" height="24" onClick="recutFirstApp(<?php echo $recutNo; ?>,<?php echo $recutYear; ?>);"><img src="../images/reject.png" width="102" height="24" onClick="rejectRecut(<?php echo $recutNo; ?>,<?php echo $recutYear; ?>);"></td>
       
      </tr>
    </table></td>
  </tr>
</table>
<script src="recutApproved.js" language="javascript"></script>
</body>
</html>
