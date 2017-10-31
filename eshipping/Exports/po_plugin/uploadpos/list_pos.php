<?php
	session_start();
	include("../../../Connector.php");
	$backwardseperator = "../../../";
	$batch=$_GET['batch'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Upload</title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
function view_orderspec()
{
	var h_orderid=document.getElementById("h_orderid").value;
	location.href="../../order/orderspec/orderspec.php?orderno="+h_orderid; 	
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
    <td><?php include '../../../Header.php';?></td>
    
  </tr>
  <tr>
    <td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
      <tr>
        <th width="399" height="20" bgcolor="#316895" class="TitleN2white">Sample Order Upload</th>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt bcgl1">
          <tr>
            <td  colspan="2" ><form enctype="multipart/form-data" id="frmTuka" name="frmTuka" method="POST" action="poupload.php" > <table width="100%" cellpadding="2" cellspacing="0">
              
              <tr>
                <td width="29%"  height="25"> Batch No</td>
                <td width="1%">&nbsp;</td>
                <td width="70%"><input type="text" class="txtbox normalfntRite"  id="batch_no" name="batch_no" style="width:100px;" disabled="disabled" value="<?php echo $batch;?>"/></td>
              </tr>             
              </table></form></td>
          </tr>
          <!-- <tr>
            <th  colspan="2" class="mainHeading2" style="background-color:#CCC; text-align:center">Size Ratio</th>
            </tr>
          <tr>-->
		  
          <tr >
            <td height="500" colspan="2" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="2"  bgcolor="#EDE0FE" id="sizeratio_grid">
              <thead>
               <tr bgcolor="#498CC2" class="normaltxtmidb2">                  
                  <th width="4%" height="20" style="text-align:center"><input type="checkbox" class="txtbox"  /></th>
                  <th width="9%" style="text-align:center">#</th>
                  <th width="21%" style="text-align:center">MAL #</th>
                  <th width="37%" style="text-align:center">Order #</th>
                  <th width="29%" style="text-align:center">Style</th>
                  </tr>
                  </thead>
              <tbody>
              <?php 
			  $str="SELECT DISTINCT strMalNo,strOrderNo,strStyle FROM order_upload where intBatchNo='$batch' order by strMalNo";
			  $result=$db->RunQuery($str);
			  while($row=mysql_fetch_array($result)){?>
			  
              <tr bgcolor="#FFFFFF"><td class="normalfntMid"><span style="text-align:center">
                <input type="checkbox" class="txtbox"  />
              </span></td>
                <td class="normalfntMid"><?php echo ++$count?></td>
                <td class="normalfntMid"><?php echo $row["strMalNo"]?></td>
                <td class="normalfnt"><?php echo $row["strOrderNo"]?></td>
                <td class="normalfntMid"><?php echo $row["strStyle"]?></td>
                </tr>
<?php }?>
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