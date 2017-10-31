<?php 
	session_start();
	include "../../../Connector.php";
	$styleid=$_GET["style"];
	$cutno=$_GET['cutno'];	
	$category = $_GET["query_cat"];
	$component = $_GET["query_com"];
	$str_no="select intCutBundleSerial from productionbundleheader where intStyleId='$styleid' and strCutNo='$cutno'";
	
	$result_cutno=$db->RunQuery($str_no);
	$row=mysql_fetch_array($result_cutno);
	$cutserial=$row["intCutBundleSerial"];
	
	
?>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.stickerfnt {
	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	line-height:14px;
	font-weight: normal;
	text-align:left;
	vertical-align:middle
}
.sticker-bar-fnt {
	font-family:IDAutomationHC39M;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	line-height:10px;
	font-weight: normal;
	vertical-align:middle
}
</style>
<body leftmargin="5px" topmargin="0px" marginwidth="3px" marginheight="0px"> 
<table width="240" border="0" cellspacing="0" cellpadding="0">

  <?php 
  	
	$str_detail="select 	
				pbsd.intCutBundleSerial, 
				pbsd.dblBundleNo, 
				(select strComponent from cutting_component cc where cc.intComponentId=pbsd.intComponentId)as intComponentId,
				pbh.strPatternNo,
				pbh.strInvoiceNo,
				pbh.strCutNo,
				pbd.dblBundleNo, 
				pbd.strSize,
				pbd.dblPcs,
				pbd.strNoRange,
				pbd.strShade,
				dblRefNo,
				ord.strOrderNo	 
				from 
				productionbundlesubdetail pbsd left join productionbundledetails pbd on pbd.intCutBundleSerial= pbsd.intCutBundleSerial and 
				pbd.dblBundleNo= pbsd.dblBundleNo left join productionbundleheader pbh on pbh.intCutBundleSerial=pbsd.intCutBundleSerial left join orders ord on ord.intStyleId=pbh.intStyleId
				where pbsd.intCutBundleSerial='$cutserial' ";
if($category!="")
	$str_detail .= "and pbsd.intCategoryId in ($category)";
if($component!="")
	$str_detail .= "and pbsd.intComponentId in ($component)";
	
	$str_detail .= "order by pbd.dblBundleNo";
				
				$result_detail=$db->RunQuery($str_detail); $i=0; 
				$no=1;
  while($row_detail=mysql_fetch_array($result_detail)){
	  $i++;
	  $character_array=explode("-",$row_detail["strSize"]);
	  $character	  =$character_array[1];  
  ?>
 <?php if($no%3==1){?>
	<tr><?php }?>
    <td style="width:300px;"><table style="width:300px;" border="0" cellspacing="0" cellpadding="0" class="stickerfnt">
      <tr>
        <td width="35%">PATTN NO </td>
        <td width="65%"><?php echo $row_detail["strPatternNo"];?></td>
      </tr>
      <tr>
        <td>PONO</td>
        <td><?php echo $row_detail["strOrderNo"];?></td>
      </tr>
      <tr>
        <td>SIZE</td>
        <td><?php echo $row_detail["strSize"];?></td>
      </tr>
      <tr>
        <td>CUT NO </td>
        <td><?php echo $row_detail["strCutNo"];?></td>
      </tr>
      <tr>
        <td>BUNDLE NO </td>
        <td><?php echo $row_detail["dblBundleNo"]."-".$row_detail["strShade"]."/".$row_detail["dblPcs"];?></td>
      </tr>
      <tr>
        <td>NUMBER</td>
        <td><?php echo $row_detail["strNoRange"];?></td>
      </tr>
      <tr>
        <td>PART</td>
        <td><?php echo $row_detail["intComponentId"];?></td>
      </tr>
      <tr>
        <td>INVOICE # </td>
        <td><?php echo $row_detail["strInvoiceNo"];?></td>
      </tr>
      <tr>
        <td height="10" colspan="2" align="left" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="2" align="center" class="sticker-bar-fnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="2" align="center" class="sticker-bar-fnt">&nbsp;</td>
      </tr>
      <tr>
        <!--<td height="10" colspan="2" align="center" class="sticker-bar-fnt"><?php echo "0";?></td>-->
      </tr>
    </table></td>
 <?php if($no%3==0){?>
	  </tr><?php }?>
 	
    <?php $no++; }?>
</table>
</body>