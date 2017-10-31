<?php
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro -  PR Second Approval Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800" align="center">
  <tr>
    <td>
	<?php
		include 'rptPR.php';		
	?>
	</td>
  </tr>
   <tr>
    <td> 
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="display:<?php echo ($status=='3' ? 'none':'inline')?>"><table width="800px" align="center" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td colspan="4" class="head1">Approve/Reject Status </td>
        </tr>
      <tr>
        <td width="140" valign="top" class="normalfnt">Remarks</td>
        <td colspan="3"><textarea name="textfield" cols="75" id="txtApprovalRemarks" ></textarea><br>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" >
        <img src="../images/approve.png" onclick="ConfirmSecondApproval('<?php echo $_GET["No"];?>');" alt="view" />
        <img src="../images/reject.png" onclick="RejectPR('<?php echo $_GET["No"];?>');" alt="view"/>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
