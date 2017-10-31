<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Upload</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function upload_po()
{
	
	if(document.getElementById("sample_po_sheet").value=='')
	{
		alert("There is no file to upload. Please select the specific file.")	
		document.getElementById("sample_po_sheet").focus();
		return false;
	}
	document.frmTuka.submit();
}
</script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php';?></td>
    <?php 
//excel upload part goes here

//$file_type= $_POST["cboFileType"];
$filepath	    = $_FILES["sample_po_sheet"]["name"];
mkdir("../../upload files", 0700);
$filenameB = basename($filepath);
$file = "../../upload files/".$filepath;
move_uploaded_file($_FILES["sample_po_sheet"]["tmp_name"],"../../upload files/". $filepath);
?>
  </tr>
  <tr>
    <td align="center"><table width="500" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
      <tr>
        <th width="399" height="20" bgcolor="#316895" class="TitleN2white">PL Upload</th>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt bcgl1">
          <tr>
            <td  colspan="2" ><form enctype="multipart/form-data" id="frmTuka" name="frmTuka" method="POST" action="upload_packing_list.php" > <table width="100%" cellpadding="2" cellspacing="0">
              
              <tr>
                <td width="28%"  height="25">Pl XML</td>
                <td width="2%">&nbsp;</td>
                <td width="70%"><input type="file" name="sample_po_sheet" style="width:250px;" id="sample_po_sheet" class="txtbox"  size="32" />
                  <img src="../../images/files_upload_icon.png"  align="absmiddle" class="mouseover" onclick="upload_po()"/></td>
              </tr>
              <?php if($uploaded){?>
              <tr>
                <td  height="25" colspan="3" style="color:#00C"> <strong>* Successfully uploded. Click <img src="../../images/go.png" width="30" height="22" align="absmiddle" class="mouseover" onclick="view_orderspec();"/> to view details.</strong><input type="hidden" id="h_orderid" name="h_orderid" value="<?php echo $order_id?>" /></td>
                </tr><?php }?>
                <?php if($xluploaded){?>
              <tr>
                <td  height="25" colspan="3" style="color:#00C"> <strong>* Successfully uploded. Click <img src="../../images/go.png" width="30" height="22" align="absmiddle" class="mouseover" onclick="view_xlorderspec(<?php echo $batch_no;?>);"/> to view details.</strong><input type="hidden" id="h_orderid" name="h_orderid" value="<?php echo $order_id?>" /></td>
                </tr><?php }?>
              </table></form></td>
          </tr>
          <!-- <tr>
            <th  colspan="2" class="mainHeading2" style="background-color:#CCC; text-align:center">Size Ratio</th>
            </tr>
          <tr>-->
		  
          <tr style="display:none">
            <td height="500" colspan="2" valign="top"><table width="500" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="sizeratio_grid">
              <thead>
                <tr bgcolor="#498CC2" class="normaltxtmidb2">                  
                  <th width="20%" height="20" style="text-align:center">PO</th>
                  <th width="40%" style="text-align:center">Product</th>
                  <th width="20%" style="text-align:center">Price</th>
                  <th width="20%" style="text-align:center">Qty</th>
                  </tr>
                </thead>
              <tbody>
                </tbody>
              </table></td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
<?php 
function validate_po($po)
{
	
	global $db;
	$str_check_po="SELECT intOrderId FROM orderspec  WHERE strOrder_No='$po'";
	$result_check_po=$db->RunQuery($str_check_po);
	
	while($row_check_po=mysql_fetch_array($result_check_po))
	{
		
		$order_id=$row_check_po['intOrderId'];
		$str_del_dtl="DELETE FROM orderspecdetails WHERE intOrderId='$order_id'";
		$result_del_dtl=$db->RunQuery($str_del_dtl);
		
		
	}
	
	$str_del_hd="DELETE FROM orderspec WHERE strOrder_No='$po'";
	$result_del_hd=$db->RunQuery($str_del_hd);
	return;
	
	
}	

?>
</html>