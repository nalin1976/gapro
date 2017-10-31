<?php
	session_start();
	include "../../../Connector.php";	
	$gpnumber=$_GET["gpnumber"];
	$backwardseperator 	= "../../../";	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	$serial_array=explode("/",$gpnumber);
	//die($serial_array[1]);
	$serial_year=($serial_array[1]!=""?$serial_array[0]:date("Y"));
	$serial_no=($serial_array[1]!=""?$serial_array[1]:$serial_array[0]);
	$str_header="select 	intGPnumber, 
	intYear,
	(select strName from companies c where c.intCompanyID=intTofactory)as tofactory, 
	(select strName from companies c where c.intCompanyID=intFromFactory)as fromfactory, 
	(select strFax from companies c where c.intCompanyID=intFromFactory)as fax, 
	(select strPhone from companies c where c.intCompanyID=intFromFactory)as phone, 
	intStyleId, 
	dtmDate, 
	intFromFactory, 
	intTofactory, 
	dblTotQty, 
	dblTotBalQty, 
	strTransInSt, 
	intStatus, 
	strType, 
	intUserId, 
	strVehicleNo,
	strPalletNo 
	from 
	productiongpheader
	where intGPnumber='$serial_no' and intYear='$serial_year'";
	
	$result_header=$db->RunQuery($str_header);
	$row_header=mysql_fetch_array($result_header);
	$tofactory=$row_header["tofactory"];
	$date_array=explode("-",$row_header["dtmDate"]);
	$date=$date_array[2]."/".$date_array[1]."/".$date_array[0];
	$vehicle=$row_header["strVehicleNo"];
	$pallet=$row_header["strPalletNo"];
	$fromfactory=$row_header["fromfactory"];
	$fax=$row_header["fax"];
	$phone=$row_header["phone"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>Gate Pass</title>
<style type="text/css">
.tophead1  {
color:#000000;
font-family:"Century Gothic";
font-size:24px;
line-height:24px;
font-weight:normal;
margin:0;
}
.tophead2  {
color:#000000;
font-family:"Century Gothic";
line-height:22px;
font-size:20px;
font-weight:normal;
margin:0;
}
.tophead3  {
color:#000000;
font-family:"Century Gothic";
line-height:18px;
font-size:16px;
font-weight:bold;
margin:0;
}
</style>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><?php include "../../../reportHeader.php";?></td>
  </tr>
 
  
  <tr>
    <td colspan="3" class="tophead3"><div align="center" >GATE PASS </div></td>
  </tr>
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="196" height="40" class="border-bottom-fntsize12"><div align="center" class="border-All"><strong>CUTTING &amp; FINISHING PLANT</strong></div></td>
    <td width="414" class="border-bottom-fntsize12"></td>
    <td width="190" class="border-bottom-fntsize12"><div align="center" class="border-All"><strong>GatePass No : <?php echo $serial_year.'/'.$serial_no?></strong></div></td>
  </tr>
   <tr>
    <td height="10" colspan="3" >&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="15%">&nbsp;&nbsp;<strong>Deliver From </strong> </td>
        <td width="30%"> :<?php echo $fromfactory;?></td>
        <td width="15%">&nbsp;</td>
        <td width="5%"><strong>To</strong></td>
        <td width="35%"> :<?php echo $tofactory;?> </td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td width="18%">&nbsp;Tele</td>
            <td width="82%"> :<?php echo $phone;?> </td>
          </tr>
          <tr>
            <td>&nbsp;Fax</td>
            <td> :<?php echo $fax;?> </td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
        <td><strong>Date</strong></td>
        <td> :<?php echo $date;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td><strong>&nbsp; Vehicle No</strong></td>
        <td> :<?php echo $vehicle;?> </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td><strong>&nbsp; Pallet No </strong></td>
	    <td> :<?php echo $pallet;?> </td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
   <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="12%" height="25" class="border-top-bottom-left-fntsize12"><div align="center">PO No. </div></td>
         <td width="12%" class="border-top-bottom-left-fntsize12"><div align="center">Style No </div></td>
         <td  width="52%" class="border-top-bottom-left-fntsize12"><div align="center">Description of Articles </div></td>
         <td  width="12%" class="border-top-bottom-left-fntsize12"><div align="center">Packages</div></td>
         <td  width="12%" class="border-All-fntsize12"><div align="center">Quantity / Pcs </div></td>
       </tr>
     </table></td>
   </tr>
   <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <!--<tr>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
      </tr>-->
      <tr>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
      </tr>
      <?php
	  $str_details="select 	gpd.intGPnumber, 
	pbd.strSize,
	pbd.dblPcs,	
	gpd.intYear, 
	gpd.intCutBundleSerial, 
	gpd.dblBundleNo, 
	gpd.dblQty, 
	gpd.dblBalQty,
	pbh.intStyleId,
	orrds.strStyle,
	orrds.strOrderNo,
	pbh.strCutNo
	from 
	productiongpdetail gpd left join productionbundledetails pbd on pbd.intCutBundleSerial = gpd.intCutBundleSerial	
	and pbd.dblBundleNo = gpd.dblBundleNo 
	left join productionbundleheader pbh on pbh.intCutBundleSerial = gpd.intCutBundleSerial 
	inner join orders orrds on pbh.intStyleId =orrds.intStyleId 
	where  gpd.intGPnumber='$serial_no' and gpd.intYear='$serial_year' order by pbh.intStyleId,pbh.strCutNo,pbd.strSize;";
	  die($str_details);
	  $results_details=$db->RunQuery($str_details);
	  $p_revious="";
	  $p_cut="";
	  $cut_tot=0;
	  $boo_first=1;	  
	  while($row=mysql_fetch_array($results_details))
	  {$current=$row["intStyleId"];$c_cut=$row["strCutNo"];$final_tot+=$row["dblQty"];?>
      <?php if($current!=$previous) {?>
      <tr>
        <td class="border-left-fntsize12"><?php echo $row["strOrderNo"];?></td>
        <td class="border-left-fntsize12"><?php echo $row["strStyle"];?></td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <?php $previous=$current;}?>
      <?php 
	     if($c_cut!=$p_cut){?>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="40%"></td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
          </tr>
        </table></td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-right-fntsize12" <?php if($boo_first==0){?> style="border-bottom-style:solid;border-top-style:solid;border-top-width:1px;border-bottom-width:1px"<?php }?>><div class="normalfntRite"><strong>
          <?php if($boo_first==0)echo $cut_tot;$cut_tot=0;$boo_first=0;?>
          &nbsp;</strong></div></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="40%"><strong>Cut No: </strong><?php echo $row["strCutNo"];?></td>
            <td width="20%">&nbsp;</td>
            <td width="20%"></td>
          </tr>
        </table></td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <?php $p_cut=$c_cut;}	  
	  $size_break_array=explode("-",$row["strSize"]);
	  $size_break=$size_break_array[0];
	  if(($tmpSize!=$size_break) && ($tmpSize!='')){
	  ?>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
            <td width="20%"><?php echo $tmpSize."-".$size_count;$cut_tot+=$row["dblQty"];?></td>
            <td width="20%" class="normalfntRite"><?php echo $size_qty." ";?>&nbsp;</td>
          </tr>
        </table></td>
        <td class="border-left-fntsize12"><div class="normalfntRite"><?php echo $size_qty;?>&nbsp;</div></td>
        <td class="border-left-right-fntsize12"><div class="normalfntRite"><?php echo $size_qty;?>&nbsp;</div></td>
      </tr>
      <?php 
	   $size_qty=0;
	   $size_count=0;}
	   $size_count++;
	   $size_qty+=$row["dblQty"];
	   $tmpSize=$size_break;}?>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
            <td width="20%"><?php echo $tmpSize."-".$size_count;$cut_tot+=$row["dblQty"];?></td>
            <td width="20%" class="normalfntRite"><?php echo $size_qty." ";?>&nbsp;</td>
          </tr>
        </table></td>
        <td class="border-left-fntsize12"><div class="normalfntRite"><?php echo $size_qty;?>&nbsp;</div></td>
        <td class="border-left-right-fntsize12"><div class="normalfntRite"><?php echo $size_qty;?>&nbsp;</div></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-right-fntsize12" style="border-bottom-style:solid;border-top-style:solid;border-top-width:1px;border-bottom-width:1px" ><div class="normalfntRite"><strong><?php echo $cut_tot;?>&nbsp;</strong></div></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-right-fntsize12" style="border-bottom-style:double"><div class="normalfntRite"><strong><?php echo $final_tot;?>&nbsp;</strong></div></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-right-fntsize12"></td>
      </tr>
      <tr>
        <td width="12%" class="border-top-fntsize12">&nbsp;</td>
        <td width="12%" class="border-top-fntsize12">&nbsp;</td>
        <td  width="52%" class="border-top-fntsize12">&nbsp;</td>
        <td  width="12%" class="border-top-fntsize12">&nbsp;</td>
        <td  width="12%" class="border-top-fntsize12">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center"></div></td>
  </tr>
</table>
</body>
</html>
