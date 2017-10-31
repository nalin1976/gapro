<?php 

session_start();
$styleNo =  $_GET['No'];
//echo $styleNo;
$Qty = $_GET['Qty'];
//echo $Qty;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | BuyerPO Document Uploader</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.4.2.min.js"></script>

<script type="text/javascript">

function submit(styleNo)
{
	//alert(styleNo);
	if(document.getElementById("ratiofile").value=="")
	{
		alert("Please Select a document.");
		document.getElementById("ratiofile").focus();
		return false;
	}
	//alert(styleNo);
	var url = 'styleratio/uploader_ratio_file.php?styleNo=' + styleNo;
	document.formstyle.submit(styleNo);
	
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

<form action="uploader_ratio_file.php?var=<?php echo $styleNo;?>&Qty=<?php echo $Qty; ?>" method="post"  enctype="multipart/form-data" name="formstyle" id="formstyle">
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
      <td width="74" class="normalfnt">Document</td>
      <td colspan="2"><input name="ratiofile" type="file" class="txtbox" id="ratiofile" size="40" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="177">&nbsp;</td>
      <td width="161">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" colspan="4" class="tableBorder"><div align="center"><img src="../images/ok.png" alt="ok" width="86" height="24" class="nobcg"  onclick="submit(<?php echo $styleNo;?>);" /></div></td>
    </tr>
     </table>
 </form>
 

</body>
</html>