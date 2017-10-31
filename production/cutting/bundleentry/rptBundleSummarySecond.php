<?php
	session_start();
	include "../../../Connector.php";	
	$bundleserial=$_GET["bundleserial"];
	$pages=$_GET["pages"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Bundle Summary Report - II</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />


</head>


<body >

<table width="1100" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?php for($loop=1;$loop<$pages;$loop++){$limit=$loop*8?>
 
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td class="border-top-left-fntsize12" height="25"><div align="center"><strong> Size</strong></div></td>
        <td colspan="17" class="border-Left-Top-right-fntsize12"><div align="center"><strong>BUNDLE #</strong> </div></td>
      </tr>
      <tr>
        <td  class="border-top-left-fntsize12" >&nbsp;</td>
        <?php 
				 	  $str_shade="select dblPcs,strShade from productionbundledetails where intCutBundleSerial='$bundleserial' group by strShade,dblPcs,intLayNo order by intLayNo limit $limit,8 ";
					
					  $result_shade=$db->RunQuery($str_shade);
					  $shade_loop=0;
					  $tot_pcs=0;
					 while($shade=mysql_fetch_array($result_shade) or $shade_loop<8 ){$shade_loop++; $tot_pcs+=(($shade["dblPcs"])? $shade["dblPcs"]:0);?>
        <td  class="border-top-left-fntsize12">&nbsp;</td>
        <td  class="border-top-left-fntsize12"><?php if(($shade["dblPcs"])&&($shade["strShade"]))echo $shade["dblPcs"]."-".$shade["strShade"];?></td>
        <?php }?>
        <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
      </tr>
      <?php 
	  $tsr_rows="select strSize from productionbundledetails where intCutBundleSerial='$bundleserial' group by strSize order by dblBundleNo";
	  $result_rows=$db->RunQuery($tsr_rows);
	  
	 while($row=mysql_fetch_array($result_rows)){?>
      <tr>
        <td  class="border-top-left-fntsize12" height="25"><div align="right">
          <?php $size=$row["strSize"]; echo  $size;?>&nbsp;
        </div></td>
        <?php 
				  $tsr_cols="select dblBundleNo,strNoRange from productionbundledetails where strSize='$size' and intCutBundleSerial='$bundleserial' limit $limit,8";
					  $result_cols=$db->RunQuery($tsr_cols);
					  $cols_loop=0;	  
					 while($cols=mysql_fetch_array($result_cols) or $cols_loop<8 ){$cols_loop++;?>
        <td  class="border-top-left-fntsize12"><div align="right"><strong><?php echo $cols['dblBundleNo'];?>&nbsp;</strong></div></td>
        <td  class="border-top-left-fntsize12"><?php echo $cols['strNoRange'];?></td>
        <?php }?>
        <td class="border-Left-Top-right-fntsize12" style="text-align:right"><?php echo $tot_pcs;?></td>
      </tr>
      <?php }?>
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
      </tr>
      
    </table></td>
  </tr><?php }?>
  <tr>
    <td>&nbsp;</td>
  </tr>
 </table>
<script type="text/javascript">
var pages=<?php echo $pages ?>;
if(pages==1)
window.close();
</script>

</body>
</html>
