<?php
 session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro | Bulk Document Uploader</title>
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
<table width="429" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
  <tr>
    <td height="31" colspan="4" bgcolor="#498CC2" class="TitleN2white">Uploading Process</td>
  </tr>
  <tr>
    <td width="15" height="19">&nbsp;</td>
    <td colspan="3" class="normalfnt2bld">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt"><?php

if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
/*  else if ($_FILES["file"]["type"] != "image/jpeg")
  {
  	echo "Error: Invalid File Format. Please Select JPEG image.<br />";
  }*/
else
  {
  mkdir("../../upload files", 0700);
  mkdir("../../upload files/bulk grn", 0700);
  mkdir("../../upload files/bulk grn/".$_SESSION["no"], 0700);
  $filename = basename($_FILES['file']['name']);
  echo $filename;
  	//echo "File successfully uploaded.";
  //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  //echo "Type: " . $_FILES["file"]["type"] . "<br />";
  //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  //echo "Stored in: " . $_FILES["file"]["tmp_name"];
  move_uploaded_file($_FILES["file"]["tmp_name"],"../../upload files/bulk grn/".$_SESSION["no"].'/'. $filename);
  }

	//move_uploaded_file($_FILES["file"]["tmp_name"],"styles/" . $_FILES["file"]["name"]);
	//move_uploaded_file($_FILES["file"]["tmp_name"],"styles/wwww.jpg");
?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="177">&nbsp;</td>
    <td width="161">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" bgcolor="#D6E7F5">&nbsp;</td>
    <td bgcolor="#D6E7F5">&nbsp;</td>
    <td bgcolor="#D6E7F5">&nbsp;</td>
    <td bgcolor="#D6E7F5"><img src="../../images/continue.png" width="116" height="24" alt="continue" onclick="Continue();" /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
