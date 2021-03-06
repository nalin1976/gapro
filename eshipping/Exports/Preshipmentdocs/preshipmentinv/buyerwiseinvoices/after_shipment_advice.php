<?php
session_start();
$backwardseperator = "../../../../";
include "$backwardseperator".''."Connector.php";
$orientation="jsPrintSetup.kLandscapeOrientation";
//$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$invoiceNo=$_GET['InvoiceNo'];
include("invoice_queries.php");	
include 'common_report.php';

$str_pl_no		="select strPLno,strBuyerPONo from commercial_invoice_detail where strInvoiceNo='$invoiceNo' limit 0,1";
$result_pl_no	=$db->RunQuery($str_pl_no);
$row_pl_no		=mysql_fetch_array($result_pl_no);
$plno			=$row_pl_no['strPLno'];

$str_dyn		="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AFTER SHIPMENT ADVICE</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style >
.tbl-h-fnt{
	font-family:Verdana;
	font-size:9px;
	font-weight:bold;
	text-align:center;
	line-height:18px;
}

</style>
</head>

<body class="body_bound"><table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr></tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt" style="font-weight:500;line-height:12px;font-size:12px;">
      <tr>
        <td height="20" colspan="3" style="font-weight:500;line-height:12px;font-size:35px;text-align:center"><?php echo $forwaderName;?></td>
        </tr>
      <tr>
        <td width="22%" height="20">&nbsp;</td>
        <td width="4%">&nbsp;</td>
        <td width="74%">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="3" style="font-weight:500;line-height:12px;font-size:15px;text-align:center"><strong>AFTER SHIPMENT ADVICE</strong></td>
        </tr>
      <tr>
        <td height="20"><strong>TO:</strong></td>
        <td>&nbsp;</td>
        <td><strong><?php echo $dataholder['BuyerAName'];?></strong></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align:right"><?php echo $dataholder['dtmFullInvoiceDate'] ;?></td>
      </tr>
      <tr>
        <td height="20"><strong>FROM:</strong></td>
        <td>&nbsp;</td>
        <td><strong><?php echo $Company;?></strong></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">Cargo Details:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">Plant Code # </td>
        <td>:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">Contractor Name</td>
        <td>:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">Shipper's Name</td>
        <td>:</td>
        <td><?php echo $Company;?></td>
      </tr>
      <tr>
        <td height="20">GPA No.</td>
        <td>:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">Date of Export</td>
        <td>:</td>
        <td><?php echo $dataholder['dtmFullInvoiceDate'] ;?></td>
      </tr>
      <tr>
        <td height="20">Vessel / Voyage or FLT. No.</td>
        <td>:</td>
        <td><?php echo $dataholder['strCarrier']." ".$dataholder['strVoyegeNo'];?></td>
      </tr>
      <tr>
        <td height="20">Port of Lading</td>
        <td>:</td>
        <td><?php echo $dataholder['strPortOfLoading'].", SRI LANKA";?></td>
      </tr>
      <tr>
        <td height="20">Port of Entry</td>
        <td>:</td>
        <td><?php echo $dataholder['port'];?></td>
      </tr>
      <tr>
        <td height="20">Estimated Arrival</td>
        <td>:</td>
        <td><?php echo $dataholder['dtmETA'];?></td>
      </tr>
      <tr>
        <td height="20"><?php echo ($com_inv_dataholder['strHAWB']!=""?"HAWB #":"B/L #");?></td>
        <td>:</td>
        <td><?php echo($com_inv_dataholder['strHAWB']!=""?$com_inv_dataholder['strHAWB']:$com_inv_dataholder['strBL']);?></td>
      </tr>
      <tr>
        <td height="20">Total # of Units</td>
        <td>:</td>
        <td><?php echo $dataholder['dblQuantity'];?></td>
      </tr>
      <tr>
        <td height="20">Total # of Containers</td>
        <td>:</td>
        <td>-</td>
      </tr>
      <tr>
        <td height="20">Invoice Value</td>
        <td>:</td>
        <td><?php echo '$ '.number_format($dataholder['dblAmount'],2);?></td>
      </tr>
      <tr>
        <td height="20">Description:</td>
        <td>:</td>
        <td><?php  echo $r_summary->summary_string($invoiceNo,'strDescOfGoods'); ?></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="3"><strong>PRODUCTION BREAKDOWN:</strong></td>
        </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt" style="font-weight:500;line-height:12px;font-size:12px;">
      <tr>
        <td height="20" nowrap="nowrap">LSD No.</td>
        <td>Work</td>
        <td nowrap="nowrap">Prod. Code</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td nowrap="nowrap">Orders #</td>
        <td>EDP</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>        
        <td colspan="10" style="text-align:center"><strong>SIZE BREAK DOWN</strong></td>
        <td>&nbsp;</td>
      </tr>
      <?php 	  
	  $str_pls		="select strPLno,strBuyerPONo,strStyleID from commercial_invoice_detail where strInvoiceNo='$invoiceNo' order by strBuyerPONo";
	  $result_pls	=$db->RunQuery($str_pls);
	  //die($str_pls)
	  while($row_pls=mysql_fetch_array($result_pls))
	  {
		  	$row_pls_no=$row_pls['strPLno'];
		 	$str_pl_summary	="select min(dblPLNoFrom) as ctnfrom , max(dblPlNoTo)as ctnto from shipmentpldetail where strPLNo='$row_pls_no'";
			$result_pl_summary  =$db->RunQuery($str_pl_summary);
			$row_pl_summary		=mysql_fetch_array($result_pl_summary);
			$str_dyn		="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$row_pls_no' order by intColumnNo";
			$count=0;
			$tot_QtyPcs=0;
      ?>
       <tr>
         <td height="20" class="border-bottom-fntsize12">&nbsp;</td>
         <td class="border-bottom-fntsize12">&nbsp;</td>
         <td class="border-bottom-fntsize12">&nbsp;</td>
         <td class="border-bottom-fntsize12">CTNS</td>
         <td nowrap="nowrap" class="border-bottom-fntsize12">Contract No.</td>
         <td class="border-bottom-fntsize12">Inseam</td>
         <?php
		   $count=0;
		   $result_dyn	=$db->RunQuery($str_dyn);
		   while(($row_dyn=mysql_fetch_array($result_dyn))||$count<10)
		   {
			    
			   ?>
         <td nowrap="nowrap" class="normalfntMid border-bottom-fntsize12" ><strong><?php echo $row_dyn['strSize'];$count++;?></strong></td>
         <?php }?>
         <td class="normalfntMid border-bottom-fntsize12"><strong>TOTAL</strong></td>
       </tr>
        <tr>
          <td height="20">&nbsp;</td>
          <td>&nbsp;</td>
          <td><?php echo $row_pls['strStyleID'];?></td>
          <td><?php echo $row_pl_summary['ctnfrom']." - ".$row_pl_summary['ctnto'];?></td>
          <td><?php echo $row_pls['strBuyerPONo'];?></td>
          <td>&nbsp;</td>
          <?php
		   $count=0;
		   $str_dyn		="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$row_pls_no' order by intColumnNo";
		   $result_dyn	=$db->RunQuery($str_dyn);		   
		   while(($row_dyn=mysql_fetch_array($result_dyn))||$count<10)
		   {?>
          <td  nowrap="nowrap" class="normalfntMid"><strong>
          <?php	
		 $count++;	
		 $tot_pcs=($row_dyn['intColumnNo']!=""?size_wise_total($row_dyn['intColumnNo'],$row_pls_no):"");
		 $tot_QtyPcs+=$tot_pcs;
		 echo $tot_pcs; ?></strong></td>
          <?php }?>
          <td class="normalfntMid"><strong>
            <?php
				 echo $tot_QtyPcs; 				 
			?>
          </strong></td>
        </tr>
        <tr>
          <td height="25">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
           <?php $count=0;
		   $result_dyn	=$db->RunQuery($str_dyn);
		   while(($row_dyn=mysql_fetch_array($result_dyn))||$count<10)
		   {
			  $count++; 
			  ?>
         <td >&nbsp;</td>
         <?php }?>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="25" class="border-top" style="border-bottom-style:double;border-bottom-width:3px;">&nbsp;</td>
          <td class="border-top" style="border-bottom-style:double;border-bottom-width:3px;">&nbsp;</td>
          <td class="border-top" style="border-bottom-style:double;border-bottom-width:3px;">&nbsp;</td>
          <td class="border-top" style="border-bottom-style:double;border-bottom-width:3px;">&nbsp;</td>
          <td class="border-top" style="border-bottom-style:double;border-bottom-width:3px;">&nbsp;</td>
          <td class="border-top" style="border-bottom-style:double;border-bottom-width:3px;">&nbsp;</td>
          <?php
		   $count=0;
		   $result_dyn	=$db->RunQuery($str_dyn);
		   while(($row_dyn=mysql_fetch_array($result_dyn))||$count<10)
		   {?>
          <td  nowrap="nowrap" class="border-top normalfntMid" style="border-bottom-style:double;border-bottom-width:3px;"><strong>
          <?php	
		 $count++;	
		 $tot_pcs=($row_dyn['intColumnNo']!=""?size_wise_total($row_dyn['intColumnNo'],$row_pls_no):"");
		 echo $tot_pcs; ?></strong></td>
          <?php }?>
          <td class="border-top normalfntMid" style="border-bottom-style:double;border-bottom-width:3px;"><strong>
            <?php
				 echo $tot_QtyPcs; 				 
			?>
          </strong></td>
        </tr>
        
        <?php }?>
       
        <tr>
         <td width="15%"><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
         <td width="15%"><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
         <td width="15%"><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
         <td width="10%"><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
         <td width="10%"><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
         <td width="10%"><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
         <?php $count=0;
		   $result_dyn	=$db->RunQuery($str_dyn);
		   while(($row_dyn=mysql_fetch_array($result_dyn))||$count<10)
		   {
			  $count++; 
			  ?>
         <td ><input type="text" style="width: 40px; visibility:hidden" class="txtbox" value=""/></td>
         <?php }?>
         <td width="10%"><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td>
       </tr>
  </table></td></tr></table>

<?php
function size_wise_total($obj,$plno)
{
	global $db;
	$size_tot		=0;
	$str			="select intRowNo,dblPcs from shipmentplsubdetail
						where strPLNo='$plno' and intColumnNo='$obj'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=size_ctn_total($row['intRowNo'],$row['dblPcs'],$plno);
	}
	return $size_tot;
}

function size_ctn_total($row,$pcs,$plno)
{
	global $db;
	$size_tot		=0;
	$str			="select dblNoofCTNS from shipmentpldetail 
						where strPLNo='$plno' and intRowNo='$row'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=$row['dblNoofCTNS']*$pcs;
	}
	return $size_tot;
} 
?>

</body>
</html>