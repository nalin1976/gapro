<?php
 session_start();
 $_SESSION["supplierCode"] = $_GET["SupplierCode"];
 
 ini_set("upload_max_filesize","10M");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document Uploader</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Button.js"></script>
<script type="text/javascript">

function submit1(){
if(document.getElementById("file").value=="")
{
alert("Please Select a document.");
document.getElementById("file").focus();
return false;
}

document.formstyle.submit();
}

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
<form action="uploader.php" method="post" enctype="multipart/form-data" name="formstyle" id="formstyle">
  <table width="429" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
    <tr>
      <td height="31" colspan="4" bgcolor="#498CC2" class="mainHeading">Document Uploader</td>
    </tr>
    <tr>
      <td width="15" height="34">&nbsp;</td>
      <td colspan="3" class="normalfnt2bld">Please select your document </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="74" class="normalfnt">Image</td>
      <td colspan="2"><input name="file" type="file" class="txtbox" id="file" size="40" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="177">&nbsp;</td>
      <td width="161">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" colspan="4" class="tableBorder"><div align="center"><img src="../../images/ok.png" alt="ok" width="86" height="24" class="nobcg"  onclick="submit1();" /></div></td>
    </tr>
    <tr>
      <td height="30" colspan="4" ><div  id="divUploader" style="width:100%;height:150px;overflow:scroll"><table width="100%" border="1" cellspacing="0" cellpadding="0" rules="all">
        
<?php
$file = "";
$url = "upload/". $_SESSION["supplierCode"]."/";
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$dh = opendir($url);
while (($file = readdir($dh)) != false)
{
	if($file!='.' && $file!='..')
	{
?>
        <tr>
          <td height="18" width="3%" class="normalfntMid"><?php echo ++$loop;?></td>
          <td width="61%" class="normalfnt">&nbsp;<?php echo $file;?></td>
          <td width="19%" class="normalfntMid"><a href="#" onclick="RemoveFile(this,'<?php echo $url.''.$file ;?>')">remove</a></td>
          <td width="17%" class="normalfntMid"><a href="<?php echo $url.''.rawurlencode($file) ;?>" target="<?php echo $file?>">open</a></td>
        </tr>
<?php
	}
}
?>
      </table>
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>