<?php
	session_start();
	include "../../../Connector.php";	
	header('Content-Type: text/xml'); 	
	$styleid=$_GET["style"];
	$cutno=$_GET['cutno'];
	$str_header="select 	intCutBundleSerial, 
							(select strOrderNo from orders o where o.intStyleId=productionbundleheader.intStyleId)as orderno, 
							(select strStyle from orders o where o.intStyleId=productionbundleheader.intStyleId)as style, 
							strFromFactory, 
							strToFactory, 
							strShift, 
							dtmCutDate, 
							strPatternNo, 
							strPOno, 
							intStyleId, 
							strCutNo, 
							strColor, 
							dblTotalQty, 
							strStatus, 
							strPlyHeight, 
							strMarkerLength, 
							strSpreader, 
							strInvoiceNo, 
							intPCS,
							useraccounts.Name
							 
							from 
							productionbundleheader 
							left join useraccounts on useraccounts.intUserID=productionbundleheader.intUserId
							where strCutNo='$cutno' and  intStyleId='$styleid'";
	$result_header=$db->RunQuery($str_header);
	$row_header=mysql_fetch_array($result_header);
	$bundleserial=$row_header["intCutBundleSerial"];
	$cutNo=$row_header["strCutNo"];
	$style=$row_header["style"];
	$orderno=$row_header["orderno"];
	$invoiceno=$row_header["strInvoiceNo"];
	$total_cut=$row_header["dblTotalQty"];
	$pattern=$row_header["strPatternNo"];
	$color=$row_header["strColor"];
	$cut_date_arr=explode("-",$row_header["dtmCutDate"]);
	$cut_date	=$cut_date_arr[2]."/".$cut_date_arr[1]."/".$cut_date_arr[0];
	
	$str_pages="select dblPcs,strShade from productionbundledetails where intCutBundleSerial='$bundleserial' group by strShade,dblPcs,intLayNo";
	$result_pages=$db->RunQuery($str_pages);
	$pages=ceil(mysql_num_rows($result_pages)/8);
	
	//BEGIN - Get Fabric Description
	$fabDesc	= GetFabricDesc($styleid);
	//END
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Bundle Summary Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
var pages=<?php echo $pages;?>;
var bundleserial='<?php echo $bundleserial;?>;'	
	var newwindow=window.open('rptBundleSummarySecond.php?pages=' +pages+ '&amp;bundleserial='+bundleserial,'aa');
	if (window.focus) {newwindow.focus()}
</script>
</head>
<body><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td class="normalfnt_size20"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%">Orit Apparels Lanka (Pvt) Ltd.</td>
        <td width="5%"><table width="100" border="0" cellspacing="0" cellpadding="0" align="right">
          <tr>
            <td class="border-All" ><div class="normalfnt2bldBLACK" style="font-style:italic;text-align:center">QAP 09 - AA</div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" valign="top" class="normalfnt2bldBLACK">Bundle Summary Report </td>
        <td width="40%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td width="30%">&nbsp;</td>
            <td width="30%"><div align="left">Date</div></td>
            <td width="40%"><div align="left"><?php echo $cut_date;?> </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Created By:</td>
            <td><?php echo $row_header["Name"];?></td>
          </tr>
        </table></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="15%" height="25"><dd><strong>FACTORY</strong></dd></td>
        <td width="30%"><strong>Orit Apparels Lanka (Pvt) Ltd. </strong></td>
        <td width="5%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
      </tr>
      <tr>
        <td height="25"><dd><strong>CUT #</strong></dd> </td>
        <td><strong><?php echo $cutNo;?></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td height="25"><strong><dd>RATIO</dd></strong></td>
		
        <td><strong><?php 
	  $str_ratio="select strSize from productionbundledetails where intCutBundleSerial='$bundleserial' group by strSize order by strSize";
	  $bool_first=0;
	  $no=0;
	 // $size_array=[];
	  $result_ratio=$db->RunQuery($str_ratio);	  
	 while($ratios=mysql_fetch_array($result_ratio))
	 {
	  $sizearray=explode("-",$ratios['strSize']);
	  $current_size=$sizearray[0];	 
	  if($bool_first==0)
				{	$previous_size=$sizearray[0];
					
					$bool_first=1;
					
				}	 
	 if($current_size==$previous_size)
	 			{
					$no++;
				}
	 else if($current_size!=$previous_size)
	 			{
					//echo $previous_size;
					$size_array[$previous_size]=$previous_size."-".$no;				
					//echo "-".$no.", ";
					$no=1;
				}
	$previous_size =$current_size;
	    }
		//echo $previous_size."-".$no;
		$size_array[$previous_size]=$previous_size."-".$no;
		ksort($size_array);
		$bool_n=0;
		foreach($size_array as $value)
		{
			if($bool_n==0){
				echo $value;
				$bool_n=1;
				}
			else 
				echo ", ".$value;
		}
	  ?>
	  </strong></td>
        <td><strong>PO #</strong></td>
        <td><strong><?php echo $orderno;?></strong></td>
        <td><strong>PATTERN #</strong></td>
        <td><strong><?php echo $pattern;?></strong></td>
      </tr>
      <tr>
        <td height="25"><dd><strong>TOTAL CUT</strong></dd></td>
        <td><strong><?php echo $total_cut;?></strong></td>
        <td><strong>STYLE</strong></td>
        <td><strong><?php echo $style;?></strong></td>
        <td><strong>COLOR</strong></td>
        <td><strong><?php echo $color;?></strong></td>
      </tr>
      <tr>
        <td height="25"><strong>
        <dd>FABRIC DESC </dd>
        </strong></td>
        <td height="25" colspan="3"><strong><?php echo $fabDesc;?></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25"><dd><strong>INVOICE #</strong></dd></td>
        <td><strong><?php echo $invoiceno;?></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <thead>
      <tr>
        <td class="border-top-left-fntsize12" height="25"><div align="center"><strong> Size</strong></div></td>
        <td colspan="17" class="border-Left-Top-right-fntsize12"><div align="center"><strong>BUNDLE #</strong> </div></td>
        </tr>
      <tr>
        <td  class="border-top-left-fntsize12" >&nbsp;</td>
         <?php 
				 	  $str_shade="select dblPcs,strShade from productionbundledetails where intCutBundleSerial='$bundleserial' group by strShade,dblPcs,intLayNo order by intLayNo limit 0,8";
					  $result_shade=$db->RunQuery($str_shade);
					  $shade_loop=0;
					  $tot_pcs=0;
					 while($shade=mysql_fetch_array($result_shade) or $shade_loop<8 ){$shade_loop++;$tot_pcs+=(($shade["dblPcs"])? $shade["dblPcs"]:0);?>
		<td  class="border-top-left-fntsize12">&nbsp;</td>
        <td  class="border-top-left-fntsize12"><?php if(($shade["dblPcs"])&&($shade["strShade"]))echo $shade["dblPcs"]."-".$shade["strShade"];?></td>
       <?php }?>
        <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
      </tr></thead>
	  <?php 
	  $tsr_rows="select strSize from productionbundledetails where intCutBundleSerial='$bundleserial' group by strSize order by dblBundleNo";
	  $result_rows=$db->RunQuery($tsr_rows);
	  
	 while($row=mysql_fetch_array($result_rows)){?>
		  <tr>
			<td  class="border-top-left-fntsize11" height="25"><div align="right"><?php $size=$row["strSize"]; echo  $size;?>&nbsp;</div>		    </td>
			 <?php 
				  $tsr_cols="select dblBundleNo,strNoRange from productionbundledetails where strSize='$size' and intCutBundleSerial='$bundleserial' order by dblBundleNo limit 0,8";
					  $result_cols=$db->RunQuery($tsr_cols);
					  $cols_loop=0;	  
					 while($cols=mysql_fetch_array($result_cols) or $cols_loop<8 ){$cols_loop++;?>
			<td  class="border-top-left-fntsize12"><div align="right"><strong><?php echo $cols['dblBundleNo'];?>&nbsp;</strong></div></td>
			<td  class="border-top-left-fntsize12"><?php echo $cols['strNoRange'];?></td>
		   <?php }?>
			<td class="border-Left-Top-right-fntsize12" style="text-align:right"><?php echo $tot_pcs;?></td>
		  </tr>
	<?php }?>
	  <tfoot>
      <tr>
        <td width="7%"  class="border-top-fntsize12">&nbsp;</td>
        <td width="4%" class="border-top-fntsize12">&nbsp;</td>
        <td width="7%" class="border-top-fntsize12">&nbsp;</td>
        <td width="4%" class="border-top-fntsize12">&nbsp;</td>
        <td width="7%" class="border-top-fntsize12">&nbsp;</td>
        <td width="4%" class="border-top-fntsize12">&nbsp;</td>
        <td width="7%" class="border-top-fntsize12">&nbsp;</td>
        <td width="4%" class="border-top-fntsize12">&nbsp;</td>
        <td width="7%" class="border-top-fntsize12">&nbsp;</td>
        <td width="4%" class="border-top-fntsize12">&nbsp;</td>
        <td width="7%" class="border-top-fntsize12">&nbsp;</td>
        <td width="4%" class="border-top-fntsize12">&nbsp;</td>
        <td width="7%" class="border-top-fntsize12">&nbsp;</td>
        <td width="4%" class="border-top-fntsize12">&nbsp;</td>
        <td width="7%" class="border-top-fntsize12">&nbsp;</td>
        <td width="4%" class="border-top-fntsize12">&nbsp;</td>
        <td width="7%" class="border-top-fntsize12">&nbsp;</td>
        <td width="5%" class="border-top-fntsize12">&nbsp;</td>
      </tr></tfoot>
      
    </table></td>    
  </tr>
  <tr>
    <td>&nbsp;</td>  
  </tr>
</table>

</body>
</html>
<?php
function  GetFabricDesc($styleid)
{
global $db;
$sql="select MIL.strItemDescription from matitemlist MIL  inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial where OD.intStyleId='$styleid' and OD.intMainFabricStatus=1";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	return $row["strItemDescription"];
}
}
?>