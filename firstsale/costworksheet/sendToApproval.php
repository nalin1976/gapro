<?php
 session_start();
include "authentication.inc";
$styleId =$_GET["styleId"];	
$invID =$_GET["invID"];	
$reqApparelApprov = $_GET["reqApparelApprov"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Cost WorkSheet</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
<script src="javascript/script.js" type="text/javascript"></script>
<script src="costWorksheet.js" type="text/javascript"></script>
<body>
<table width="800" align="center">
  <tr>
    <td>
	
	</td>
  </tr>
   <tr>
    <td> <?php include "costworksheetRpt.php";?></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td align="center"><table width="900px" align="center" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td class="normalfnt"></td>
      </tr>
      <tr>
        <td class="normalfnt"><?php include "changes.php";?></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
      </tr>
     
      <tr bgcolor="#D6E7F5">
        <td align="center"><img src="../../images/send2app.png" onclick="sendToApproval('<?php echo $styleId;?>',<?php echo $invID;?>,<?php echo $reqApparelApprov; ?>);" alt="view" id="sentoApproval" name="sentoApproval" /><img src="../../images/close.png" onclick="closeWindow();" alt="view"/></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>