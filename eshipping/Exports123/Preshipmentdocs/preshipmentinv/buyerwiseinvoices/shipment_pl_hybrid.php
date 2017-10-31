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
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt"  style="font-weight:bold;font-size:10px;line-height:14px;">
      <tr>
        <td>INVOICE NO.</td>
        <td><?php echo $invoiceNo;?></td>
        <td width="20%">DATE:</td>
        <td width="30%"><?php $date_array=explode("-",$data_header['dtmInvoiceDate']);$date_inv=$date_array[2]."/".$date_array[1]."/".$date_array[0];echo $date_inv;?></td>
      </tr>
      <tr>
        <td>ISD # </td>
        <td><?php echo $data_header['strISDno'];?></td>
        <td>PAYMENT: </td>
        <td><?php echo $data_header['strLCNo'];?> OF <?php echo $data_header['dtmLCDate'];?></td>
      </tr>
      <tr>
        <td>CARRIER:</td>
        <td><?php echo $data_header['strCarrier']." ".$data_header['strVoyegeNo'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ETD:</td>
        <td><?php $sail_date_array=explode("-",$data_header['dtmSailingDate']);
		$date_sail=$sail_date_array[2]."/".$sail_date_array[1]."/".$sail_date_array[0];
		echo $date_sail;?></td>
        <td colspan="2"><?php echo $mainmark2;?></td>
        </tr>
      <tr>
        <td>COUNTRY OF ORIGIN:</td>
        <td>SRI LANKA</td>
        <td colspan="2"><?php echo $mainmark3;?></td>
        </tr>
      <tr>
        <td>DESTINATION:</td>
        <td><?php echo $data_header['destination'];?></td>
        <td colspan="2"><?php echo $mainmark4;?></td>
        </tr>
      <tr>
        <td><?php echo ($data_header['strHAWB']==""?"CONTAINER SIZE:":"MAWB #");?></td>
        <td><?php echo ($data_header['strHAWB']==""?$data_header['dblConTypeId']:$data_header['strMAWB']);?></td>
        <td colspan="2"><?php echo $mainmark5;?></td>
        </tr>
      <tr>
        <td><?php echo ($data_header['strBL']==""?"HAWB #":"BILL OF LADING#");?></td>
        <td><?php echo ($data_header['strBL']==""?$data_header['strHAWB']:$data_header['strBL']);?></td>
        <td colspan="2"><?php echo $mainmark6;?></td>
        </tr>
      <tr>
        <td>GROSS WEIGHT</td>
        <td><?php echo $data_header['dblGrossMass'];?> KG</td>
        <td colspan="2"><?php echo $mainmark7;?></td>
        </tr>
      <tr>
        <td>NET WEIGHT</td>
        <td><?php echo $data_header['dblNetMass'];?> KG</td>
        <td colspan="2"><?php echo $sidemark2;?></td>
        </tr>
      <tr>
        <td>NET NET WEIGHT</td>
        <td><?php echo $data_header['dblNetNet'];?> KG</td>
        <td colspan="2"><?php echo $sidemark3;?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><?php echo $sidemark4;?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><?php echo $sidemark5;?></td>
        </tr>
      <tr>
        <td width="20%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
        <td colspan="2"><?php echo $sidemark6;?></td>
        </tr>
         <tr>
        <td width="20%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
        <td colspan="2"><?php echo $sidemark7;?></td>
      </tr>
    </table></td>
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
    <td class="border-top-fntsize10" id='<?php echo $row_desc["strPLno"];?>'  valign="top">&nbsp;</td>
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