<?php
session_start();
$backwardseperator = "../../";
include "$backwardseperator".''."Connector.php";
$from_date	=$_GET["from_date"];
$to_date	=$_GET["to_date"];
$InvoiceNo	=$_GET["InvoiceNo"];
$Vessel		=$_GET["Vessel"];
$Entry		=$_GET["Entry"];
if($to_date!=""&&$from_date!="")
{
	$from_date_array=explode("/",$from_date);
	$from_date=$from_date_array[2]."-".$from_date_array[1]."-".$from_date_array[0];
	$to_date_array=explode("/",$to_date);
	$to_date=$to_date_array[2]."-".$to_date_array[1]."-".$to_date_array[0];
	
	$str_ext=" and dtmInvoiceDate between '$from_date' and '$to_date'";
}
if($InvoiceNo!="")
{
	$str_ext.=" and invoicedetail.strInvoiceNo ='$InvoiceNo'";
}
if($Vessel!="")
{
	$str_ext.=" and strCarrier ='$Vessel'";
}
if($Entry!="")
{
	$str_ext.=" and stEntryNo ='$Entry'";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PRE-EXPORT REGISTRY</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#pre_export_rep tbody tr:hover{
background-color:#DFDFBF;
}
</style>

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  
  <tr>
    <td class="normalfntMid" style="text-align:left;font-size:18px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="bottom"><span class="normalfntMid" style="text-align:left;font-size:18px">PRE-EXPORT REGISTRY </span></td>
          <td><table width="144" border="0" cellspacing="0" cellpadding="0" class="normalfnt" align="right">
            <tr>
              <td width="19" height="19" bgcolor="#FFFFFF" style="border:#000 1px solid">&nbsp;</td>
              <td width="143"> :Shipped Invoices</td>
            </tr>
            <tr>
              <td colspan="2" height="2"></td>
            </tr>
            <tr>
              <td height="19" style="border:#000 1px solid" bgcolor="#FFF0F0">&nbsp;</td>
              <td>:Unshipped Invoices</td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" class="normalfntMid" style="background-color:#808040" id='pre_export_rep'>
      
      <thead>
       <tr style="background-color:#BCBC7A">
        <th nowrap="nowrap" height="25">#</th>
        <th nowrap="nowrap">Invoice No</th>
        <th nowrap="nowrap">Date</th>
        <th nowrap="nowrap">Entry No</th>
        <th nowrap="nowrap">Buyer</th> 
        <th nowrap="nowrap">Mode</th>   
        <th nowrap="nowrap">Vessel/Flight</th>    
        <th nowrap="nowrap">ETD</th>
        <th nowrap="nowrap">ETA</th>
        <th nowrap="nowrap">Qty Planned</th>
        <th nowrap="nowrap">Qty Shipped</th>
        <th nowrap="nowrap">Balance</th>
        <th nowrap="nowrap">Status</th>
      </tr>
      </thead>
      <tbody>
      <?php
		$str			="select invoicedetail.strInvoiceNo,
						strCarrier,date_format(dtmInvoiceDate,'%d-%b-%y')as  dtmInvoiceDate,
						date(dtmInvoiceDate) as invoice_date,
						exportrelease.stEntryNo,intShippedQty,strTransportMode,
						sum(dblQuantity) as plannedqty,strName 
						from invoicedetail  
						inner join invoiceheader on invoiceheader.strInvoiceNo=invoicedetail.strInvoiceNo
						left join exportrelease on exportrelease.strInvoiceNo=invoicedetail.strInvoiceNo
						inner join buyers on buyers.strBuyerID=invoiceheader.strBuyerID
						where invoicedetail.strInvoiceNo!=''
						$str_ext
						group by invoicedetail.strInvoiceNo order by invoice_date desc, invoicedetail.strInvoiceNo desc";
	  $result		=$db->RunQuery($str);
	  while($row=mysql_fetch_array($result)){ 
	  $bgcolor=($row["intShippedQty"]==''?"#FFF0F0":"#ffffff");
	  ?>
      
      <tr bgcolor=" <?php echo $bgcolor;?>">
        <td height="20" nowrap="nowrap" class="normalfntRite"><?php echo ++$i;?></td>
        <td height="20" nowrap="nowrap" class="normalfnt"><?php echo $row["strInvoiceNo"]?></td>
        <td height="20" nowrap="nowrap"><?php echo $row["dtmInvoiceDate"]?></td>
        <td height="20" nowrap="nowrap" class="normalfnt"><?php echo $row["stEntryNo"]?></td>
        <td height="20" nowrap="nowrap" class="normalfnt"><?php echo $row["strName"]?></td>
        <td height="20" nowrap="nowrap" class="normalfnt"><?php echo $row["strTransportMode"]?></td>
        <td height="20" nowrap="nowrap" class="normalfnt"><?php echo $row["strCarrier"]?></td>
        <td height="20" nowrap="nowrap"><?php echo $row["dtmInvoiceDate"]?></td>
        <td height="20" nowrap="nowrap"><?php echo "-"?></td>
        <td height="20" nowrap="nowrap" class="normalfntRite"><?php echo $row["plannedqty"];$tot_planned+=$row["plannedqty"];?></td>
        <td height="20" nowrap="nowrap" class="normalfntRite"><?php echo $row["intShippedQty"];$tot_shipped+=$row["intShippedQty"];?></td>
        <td height="20" nowrap="nowrap" class="normalfntRite"><?php echo $row["plannedqty"]-$row["intShippedQty"];?></td>
        <td height="20" nowrap="nowrap">-<?php  $days=round((strtotime(date('Y-m-d'))-strtotime($row["invoice_date"]))/(60*60*24));?></td>
        </tr>
     <?php }?> 
     <tr bgcolor="#FFFFFF">
        <td height="20" colspan="9" nowrap="nowrap" class="normalMid"><strong>TOTAL</strong></td>
        <td height="20" nowrap="nowrap" class="normalfntRite"><strong><?php echo $tot_planned;?></strong></td>
        <td height="20" nowrap="nowrap" class="normalfntRite"><strong><?php echo $tot_shipped;?></strong></td>
        <td height="20" nowrap="nowrap" class="normalfntRite"><strong><?php echo $tot_planned-$tot_shipped;?></strong></td>
        <td height="20" nowrap="nowrap">&nbsp;</td>
      </tr>
     </tbody>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>