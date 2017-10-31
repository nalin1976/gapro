<?php
 session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro | PR Document Uploader</title>
<style type="text/css">
<!--
.nobcg {	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function Continue()
{
	window.close();
}
</script>
</head>

<body>
<table width="429" border="0" cellpadding="1" cellspacing="0" class="bcgl1">
  <tr>
    <td height="31" colspan="4" class="mainHeading">Uploading Process</td>
  </tr>
  <tr>
    <td width="15" height="19">&nbsp;</td>
    <td colspan="3" class="normalfnt2bld">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt"><?php

/*if ($_FILES["file"]["error"] > 0)
  {
  //echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }

else
  {
  mkdir("../../upload files", 0700);
  mkdir("../../upload files/cws", 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"], 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"]."/fabInvoice", 0700);
  $filename = basename($_FILES['file']['name']);
  echo $filename.'</br>';
  	
  move_uploaded_file($_FILES["file"]["tmp_name"],"../../upload files/cws/".$_SESSION["styleId"].'/fabInvoice/'. $filename);
  }

if ($_FILES["filePoc"]["error"] > 0)
  {
 // echo "Error: " . $_FILES["fileQuat"]["error"] . "<br />";
  }

else
  {
  mkdir("../../upload files", 0700);
  mkdir("../../upload files/cws", 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"], 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"]."/pocInvoice", 0700);
  $filenameQ = basename($_FILES['filePoc']['name']);
  echo $filenameQ.'</br>';
  	
  move_uploaded_file($_FILES["filePoc"]["tmp_name"],"../../upload files/cws/".$_SESSION["styleId"].'/pocInvoice/'. $filenameQ);
  }*/
  
  if ($_FILES["fileBPO"]["error"] > 0)
  {
  //echo "Error: " . $_FILES["fileBOQ"]["error"] . "<br />";
  }

else
  {
  mkdir("../../upload files", 0700);
  mkdir("../../upload files/cws", 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"], 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"]."/BPO", 0700);
  $filenameB = basename($_FILES['fileBPO']['name']);
  echo $filenameB.'</br>';
  	
  move_uploaded_file($_FILES["fileBPO"]["tmp_name"],"../../upload files/cws/".$_SESSION["styleId"].'/BPO/'. $filenameB);
  }
  
?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="177">&nbsp;</td>
    <td width="161">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
      <tr>
        <td align="right"><img src="../../images/continue.png" width="116" height="24" alt="continue" onclick="Continue();" /></td>
      </tr>
    </table></td>
  </tr>
 
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
