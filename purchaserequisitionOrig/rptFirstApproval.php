<?php
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro -  PR First Approval Report</title>
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
    <td><table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="60%">&nbsp;</td>
        <td width="40%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="800px" align="center" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td colspan="4" class="head1">Approve/Reject Status </td>
        </tr>
      <tr>
        <td width="140" valign="top" class="normalfnt">Remarks</td>
        <td colspan="3"><textarea name="textfield" cols="75" id="txtApprovalRemarks" ></textarea><br>&nbsp;</td>
      </tr>
      <tr >
        <td colspan="4" align="center">
       	<img src="../images/approve.png" onclick="ConfirmFirstApproval('<?php echo $_GET["No"];?>');" alt="view" /></div>
        <img src="../images/reject.png" onclick="RejectPR('<?php echo $_GET["No"];?>');" alt="view"/></div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
