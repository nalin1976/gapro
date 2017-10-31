<?php
	  include "../../Connector.php"; 
	  $Remark  = $_GET["Remark"];
	  $rowNo   = $_GET["rowNo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="generalPo-java.js" type="text/javascript"></script>
</head>

<body>
<form id="frmRemark" name="frmRemark">
<div style="position:absolute; width: 400px; height: 71px;" id="NoSearch" >
  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="tablezRED">
    <tr>
      <td  colspan="3" class="mainHeading" valign="middle"><img src="../../images/cross.png" alt="rep" align="right" onclick="CloseGenPOPopUp('popupLayer1');" /></td>
    </tr>
    <tr>
      <td width="2" height="22" class="normalfnt"></td>
      <td width="62" height="22" class="normalfnt">Remarks</td>
      <td width="322" rowspan="2" class="normalfnt">
        <textarea name="textareaNote" id="textareaRemark" cols="45" rows="2" onkeypress="enterRemark(this,event,<?php echo $rowNo; ?>);"><?php echo $Remark; ?></textarea></td>
      </tr>
    <tr>
      <td height="22" class="normalfnt"></td>
      <td height="22" class="normalfnt">&nbsp;</td>
    </tr>
  </table>
</div>
</form>
</td>
</body>
</html>