<?php 
session_start();
include "../../../../Connector.php";
$invoiceNo=$_GET['InvoiceNo'];	
include "pl_queries.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Packing List</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../../js/jquery-1.3.2.min.js"></script>
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table style="width:800px;" border="0" cellspacing="0" cellpadding="0">
  <thead>
  <tr>
  
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:24px" height="35" bgcolor="#CCCCCC">ORIT TRADING LANKA (PVT) LTD</td>
  </tr>
  <tr>
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:12px" height="20" bgcolor="#999999">07-02, East Tower, World Trade Centre, Echelon Square, Colombo 01, Sri Lanka. Tel: 0094-111-2346370    Fax:0094-111-2346376</td>
  </tr>
  <tr>
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:14px;line-height:16px;">DETAIL PACKING LIST/ WEIGHT LIST</td>
  </tr>
  <tr>
    <td >
      
      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
 
  <?php
  
   $str_desc="select
					strPLno
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'
					order by strBuyerPONo,strStyleID
					limit 0,1
					";
					
					$no=1;
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc))
		
		{$no++;
		
		if($bool_rec_fst==1){$bool_rec_fst=0;?>

  <tr>
    <td class="border-top-fntsize10" id='<?php echo $row_desc["strPLno"];?>' valign="top">&nbsp;</td>
  </tr></thead>
 <?php } 
 
 else{
 ?>
 <thead>
  <tr>
    <td class="border-top-fntsize10" id='<?php echo $row_desc["strPLno"];?>' valign="top">&nbsp;</td>
  </tr>
  </thead>
  <?php }}?>
  <tr>
    <td></td>
  </tr>
</table>
<script type="text/javascript">
/*var htpl=$.ajax({url:'../packinglist_formats/pl_levis_euro.php?plno=1',async:false})
$('#pl').html(htpl.responseText);
*/
var arr_no=[];
<?php 
$str_desc="select
					strPLno,
					strFormat
					from
					commercial_invoice_detail	
					left join shipmentplformat on shipmentplformat.intPLno=commercial_invoice_detail.strPLno				
					where 
					strInvoiceNo='$invoiceNo' order by strBuyerPONo,strStyleID";
					
					
		$result_desc=$db->RunQuery($str_desc);	
		$page		=0;	
		while($row_desc=mysql_fetch_array($result_desc))
{
	$path_file_array=explode("/",$row_desc['strFormat']);
	$path_file		=$path_file_array[1];
	if($page==0)
	{
		?>
var htpl=$.ajax({url:'../packinglist_formats/<?php echo $path_file;?>?plno=<?php echo $row_desc["strPLno"];?>&limitz=50&invoiceNo=<?php echo $invoiceNo;?>',async:false})
$('#<?php echo $row_desc["strPLno"];?>').html(htpl.responseText);

<?php }
	else
	{?>
		window.open('../packinglist_formats/<?php echo $path_file;?>?plno=<?php echo $row_desc["strPLno"];?>&invoiceNo=<?php echo $invoiceNo;?>','<?php echo $page;?>');
<?php }$page++;}?>
</script>
</body>
</html>