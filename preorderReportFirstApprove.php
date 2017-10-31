<?php
 session_start();
include "authentication.inc";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Pre Order Cost :: First Approval Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<script src="javascript/aprovePreoder.js" type="text/javascript"></script>
<script src="javascript/script.js" type="text/javascript"></script>

<body>

<table width="800" align="center">
  <tr>
    <td>
	<?php
		$xml = simplexml_load_file('config.xml');
		$reportname = $xml->PreOrder->ReportName;
		$displayShortage = $xml->PreOrder->DisplayShortageForApproval;
		$displayVariationInDeferentColor = $xml->PreOrder->DisplayVeriationInDeferentColorInApprovalSheet;
		include $reportname;
		
	?>
	</td>
  </tr>
   <tr>
    <td> 
	<?php
		include "changes.php";
		
	?>
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
        <td colspan="3"><textarea name="textfield" cols="75" id="txtRemarks" onClick="reloadParent();" ></textarea><br>&nbsp;</td>
      </tr>
      <tr bgcolor="#D6E7F5">
        <td>&nbsp;</td>
        <td width="212"><div align="right"><img src="images/approve.png" onclick="FirstApprovePreOders('<?php echo $strStyleID;?>',<?php echo $UserID;?>);" alt="view" /></div></td>
        <td width="175"><div align="center"><img src="images/reject.png" onclick="RejectPreOders('<?php echo $strStyleID;?>',<?php echo $UserID;?>);" alt="view"/></div></td>
        <td width="265">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
