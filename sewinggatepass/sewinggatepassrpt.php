<?php
	session_start();
	include "../../Connector.php";	
	$gpnumber=$_GET["gpnumber"];;
	$backwardseperator 	= "../../";	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	$serial_array=explode("/",$gpnumber);
	//die($serial_array[1]);
	$serial_year=$serial_array[1];
	$serial_no=$serial_array[0];
	$str_header="select 	intGPnumber, 
	intYear,
	(select strName from companies c where c.intCompanyID=intTofactory)as tofactory, 
	(select strName from companies c where c.intCompanyID=intFromFactory)as fromfactory, 
	(select strFax from companies c where c.intCompanyID=intFromFactory)as fax, 
	(select strPhone from companies c where c.intCompanyID=intFromFactory)as phone, 
	(select Name from useraccounts u where u.intUserID=productiongpheader.intUserId)as UserName,
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
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
<?php if($row_header["intStatus"]=='10'){?>
<div style="position:absolute;top:200px;left:400px;"><img src="../../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php }?>
<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3"><?php include "../../reportHeader.php";?></td>
  </tr>
 
  
  <tr>
    <td colspan="3" class="tophead3"><div align="center" >GATE PASS </div></td>
  </tr>
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="40" class="border-All-fntsize12" nowrap="nowrap"><strong>CUTTING &amp; FINISHING PLANT</strong></td>
    <td width="401" ></td>
    <td width="200" class="border-All-fntsize12" nowrap="nowrap"><strong>GatePass No : <?php echo $serial_year.'/'.$serial_no?></strong></td>
  </tr>
   <tr>
     <td height="10" colspan="3" >&nbsp;</td>
   </tr>
   <tr>
    <td height="10" colspan="3" class="border-top">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="15%">&nbsp;&nbsp;<strong>Deliver From </strong> </td>
        <td width="40%"> :<?php echo $fromfactory;?></td>
        <td width="5%">&nbsp;</td>
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
            <td width="11%">&nbsp;Tele</td>
            <td width="89%"> :<?php echo $phone;?> </td>
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
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="2">
     <thead>
       <tr>
         <td  width="12%" class="border-top-bottom-left-fntsize12" height="25"><div align="center"><strong>PO No. </strong></div></td>
         <td  width="12%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Style No</strong></div></td>
         <td colspan="4" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Description of Articles </strong></div></td>
         <td  width="12%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Packages</strong></div></td>
         <td  width="12%" class="border-All-fntsize12"><div align="center"><strong>Qty / Pcs</strong></div></td>
       </tr>
       </thead>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td width="8%" class="border-left-fntsize12">&nbsp;</td>
         <td width="16%">&nbsp;</td>
         <td width="16%">&nbsp;</td>
         <td width="8%">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
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
	  
	  $results_details=$db->RunQuery($str_details);
	  while($row=mysql_fetch_array($results_details))
	  {
		$current=$row["intStyleId"];
		$c_cut=$row["strCutNo"];
		$final_tot+=$row["dblQty"];		
		if($current!=$previous) {?>
       <tr>
         <td class="border-left-fntsize12"><?php echo $row["strOrderNo"];?></td>
         <td class="border-left-fntsize12"><?php echo $row["strStyle"];?></td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <?php }	  
	   
		 $size_break_array=explode("-",$row["strSize"]);
	  	 $size_break=$size_break_array[0];
	  	 if((($tmpSize!=$size_break)||($temp_cut!=$c_cut)||($current!=$previous)) && ($tmpSize!='')){
			 
		?>
        <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td>&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;"><?php echo $tmpSize." - ".$no_sizes;?></td>
         <td class="normalfntRite" style="font-size:12px;"><?php echo $size_qty;?></td>
         <td class="border-left-fntsize12"><div align="right" ><?php echo $size_qty;?></div></td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
        <?php 
		$no_sizes=0;
		$size_qty=0;
			}	
		if(($temp_cut!=$c_cut)||($current!=$previous))
	   		{
		if($temp_cut!=""){
	    ?>
        <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-right-fntsize12" style="border-bottom-style:solid;border-top-style:solid;border-top-width:1px;border-bottom-width:1px" ><div align="right"><?php echo $cut_tot;?></div></td>
       </tr>
        <?php 
		$cut_tot=0;
		}
		
		?>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">Cut No:</td>
         <td colspan="3" class="normalfnt" style="font-size:12px;"><?php echo $row["strCutNo"];?></td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
        <?php }	
		$previous =$current;
		$temp_cut =$c_cut;
		$tmpSize  =$size_break;
		$no_sizes++;
		$cut_tot+=$row["dblQty"];
		$size_qty+=$row["dblQty"];
		} 		
		?>
        <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td>&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;"><?php echo $tmpSize." - ".$no_sizes;?></td>
         <td class="normalfntRite" style="font-size:12px;"><?php echo $size_qty;?></td>
         <td class="border-left-fntsize12"><div align="right"><?php echo $size_qty;?></div></td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-right-fntsize12" style="border-bottom-style:solid;border-top-style:solid;border-top-width:1px;border-bottom-width:1px" ><div align="right"><?php echo $cut_tot;?></div></td>
       </tr>
        <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-right-fntsize12" style="border-bottom-style:double"><div align="right"><?php echo $final_tot;?></div></td>
       </tr>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <tfoot>
         <tr>
           <td colspan="8" class="border-top">&nbsp;</td>
          </tr>
       </tfoot>
     </table></td>
   </tr>

   <tr>
    <td colspan="3"><table width="100%" border="0">
      <tr height="10"></tr>
      <tr>
        <td width="25%" class="bcgl1txt1" height="25"><?php echo $row_header["UserName"];?></td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid">Prepared by</td>
        <td class="normalfntMid">Authorized By</td>
        <td class="normalfntMid">Delivered By</td>
        <td class="normalfntMid">Signature</td>
      </tr>
      <tr>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid">Date</td>
        <td class="normalfntMid">Time Out</td>
        <td class="normalfntMid">Time In</td>
        <td class="normalfntMid">Signature Security</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center"></div></td>
  </tr>
</table>
</body>
</html>
