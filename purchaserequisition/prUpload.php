<?php
 session_start();
 $no	= explode('/',$_GET["No"]);
 $_SESSION["no"] = $no[0].'-'.$no[1];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Document Uploader</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">

function RemoveFile(obj,url)
{
	if(confirm('Are you sure you want to remove this item?'))
	{		
		var td = obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);		

		var url = 'purchaserequisitionxml.php?RequestType=RemoveFile&url='+url;
		htmlobj=$.ajax({url:url,async:false});
	}
}

function submit1()
{
	if(document.getElementById("file").value=="" && document.getElementById("fileQuat").value=="" && document.getElementById("fileBOQ").value=="")
	{
		alert("Please Select a document.");
		//document.getElementById("file").focus();
		return false;
	}
//	var url = 'db.php?id=UploadFile&url='+ <?php echo $_GET["SupplierCode"]?>;
//	htmlobj=$.ajax({url:url,async:false});
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
<form action="uploader_file.php" method="post" enctype="multipart/form-data" name="formstyle" id="formstyle">
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
      <td width="74" class="normalfnt">Job Card</td>
      <td colspan="2"><input name="file" type="file" class="txtbox" id="file" size="40" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="normalfnt">Quatation</td>
      <td colspan="2"><input name="fileQuat" type="file" class="txtbox" id="fileQuat" size="40" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="normalfnt">BOQ</td>
      <td colspan="2"><input name="fileBOQ" type="file" class="txtbox" id="fileBOQ" size="40" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="177">&nbsp;</td>
      <td width="161">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" colspan="4" class="tableBorder"><div align="center"><img src="../images/ok.png" alt="ok" width="86" height="24" class="nobcg"  onclick="submit1();" /></div></td>
    </tr>
    <tr>
      <td height="30" colspan="4" >
	  <div  id="divUploader" style="width:100%;height:150px;overflow: -moz-scrollbars-horizonral;">
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
		<thead>
		<tr class="mainHeading4">
		  <td height="22" >No</td>
		  <td >Document Name</td>
		  <td >Del</td>
		  <td >Open</td>
		</tr>
		</thead>
        <tbody style="overflow:auto;">
<?php
$file = "";
$url = "../upload files/purchase requestion/". $_SESSION["no"]."/jobCard/";
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
          <td width="7%" class="normalfntMid"><a href="#" onclick="RemoveFile(this,'<?php echo $url.''.$file ;?>')"><img src="../images/del.png" border="0" /></a></td>
          <td width="10%" class="normalfntMid"><a href="<?php echo $url.''.$file ;?>" target="_blank"><img src="../images/pdf.png" border="0" /></a></td>
        </tr>
		
<?php
	}
}
?>
<?php
$file = "";
$url = "../upload files/purchase requestion/". $_SESSION["no"]."/Quatation/";
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
          <td width="7%" class="normalfntMid"><a href="#" onclick="RemoveFile(this,'<?php echo $url.''.$file ;?>')"><img src="../images/del.png" border="0" /></a></td>
          <td width="10%" class="normalfntMid"><a href="<?php echo $url.''.$file ;?>" target="_blank"><img src="../images/pdf.png" border="0" /></a></td>
        </tr>
		
<?php
	}
}
?>
<?php
$file = "";
$url = "../upload files/purchase requestion/". $_SESSION["no"]."/BOQ/";
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
          <td width="7%" class="normalfntMid"><a href="#" onclick="RemoveFile(this,'<?php echo $url.''.$file ;?>')"><img src="../images/del.png" border="0" /></a></td>
          <td width="10%" class="normalfntMid"><a href="<?php echo $url.''.$file ;?>" target="_blank"><img src="../images/pdf.png" border="0" /></a></td>
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