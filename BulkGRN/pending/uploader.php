<?php
 session_start();
 $no	= $_GET["No"];
 $year  = $_GET["Year"];
 $_SESSION["no"] = $year.'-'.$no;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Document Uploader</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="Button.js"></script>
<script type="text/javascript">

</script>
<style type="text/css">
<!--
.nobcg {
	border-top-width: 0px;
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
</head>

<body>
<form action="uploader_file.php" method="post" enctype="multipart/form-data" name="formstyle" id="formstyle">
  <table width="429" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
    <tr>
      <td width="427" height="31" bgcolor="#498CC2" class="mainHeading">View Upload Document</td>
    </tr>
    
    <tr>
      <td height="30" >
	  <div  id="divUploader" style="width:100%;height:150px;overflow: -moz-scrollbars-horizonral;">
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
		<thead>
		<tr class="mainHeading4">
		  <td height="22" >No</td>
		  <td >Document Name</td>
		  <td >Open</td>
		</tr>
		</thead>
        <tbody style="overflow:auto;">
<?php
$file = "";
$url = "../../upload files/bulk grn/". $_SESSION["no"]."/";
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$dh = opendir($url);
while (($file = readdir($dh)) != false)
{
	if($file!='.' && $file!='..')
	{
?>
		
        <tr class="bcgcolor-tblrowWhite">
          <td height="18" width="4%" class="normalfntMid"><?php echo ++$loop;?></td>
          <td width="79%" class="normalfnt">&nbsp;<?php echo $file;?></td>
          <td width="10%" class="normalfntMid"><a href="<?php echo $url.''.$file ;?>" target="_new"><img src="../../images/pdf.png" border="0" /></a></td>
        </tr>
		
<?php
	}
}
?>
</tbody>
      </table>
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>