<?php 
	session_start();
	include "../../../Connector.php";
	$styleid	= $_GET["style"];
	$cutno		= $_GET['cutno'];	
	$size		= $_GET['Size'];	
	$str_no="select intCutBundleSerial from productionbundleheader where intStyleId='$styleid' and strCutNo='$cutno'";
	
	$result_cutno=$db->RunQuery($str_no);
	$row=mysql_fetch_array($result_cutno);
	$cutserial=$row["intCutBundleSerial"];
	$query_str =($_GET['query_cat']!=""?" and pbsd.intCategoryId in (".$_GET['query_cat'].")":"");	
	$query_str.=($_GET['query_com']!=""?" and pbsd.intComponentId in (".$_GET['query_com'].")":"");	;
	
?>
<script>
function test()
{
	jsPrintSetup.setPrinter('ZDesigner 110Xi4 203 dpi');
	jsPrintSetup.getPrintersList();
	jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);//kLandscapeOrientation & kPortraitOrientation
	jsPrintSetup.setPaperSizeUnit(jsPrintSetup.kPaperSizeInches);;
	jsPrintSetup.setOption('paperHeight', 1.8);
	jsPrintSetup.setOption('paperWidth', 3.00);
	jsPrintSetup.setOption('shrinkToFit', 1);
	jsPrintSetup.setOption('numCopies',1);
	
	jsPrintSetup.setOption('printBGImages', 1);
	
	jsPrintSetup.setSilentPrint(0);
	jsPrintSetup.setOption('headerStrCenter', 'bla bla frame');
	jsPrintSetup.setOption('headerStrRight', '');
	// here window is current frame!
	jsPrintSetup.printWindow(window);
	jsPrintSetup.setSilentPrint(0);
}
</script>

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
.main_container{
padding-left:10px;
}
td{
	font-size:12px;
	line-height:150%;
	}
</style>
<body leftmargin="10px" topmargin="0px" marginwidth="3px" marginheight="0px"> 
<table width="300" border="0" cellspacing="0" cellpadding="0" onClick="test();">

  <?php 
  	
	$str_detail = "select 	
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
				ordz.strStyle,
				ordz.strOrderNo
				from 
				productionbundlesubdetail pbsd left join productionbundledetails pbd on pbd.intCutBundleSerial= pbsd.intCutBundleSerial and 
				pbd.dblBundleNo= pbsd.dblBundleNo left join productionbundleheader pbh on pbh.intCutBundleSerial=pbsd.intCutBundleSerial left join orders ordz on ordz.intStyleId=pbh.intStyleId
				where pbsd.intCutBundleSerial='$cutserial' ";
			if($size!="")
				$str_detail .= "and pbd.strSize='$size' ";

	$str_detail .= $query_str;
	$str_detail .= "order by pbsd.intCutBundleSerial,pbd.dblBundleNo,pbsd.dblRefNo ";
	$str_detail .= "limit 0,50 ";
	$result_detail=$db->RunQuery($str_detail); $i=0; 
  while($row_detail=mysql_fetch_array($result_detail)){
	$character_array=explode("-",$row_detail["strSize"]);
	$character	  =$character_array[1];
  	$i++;
	?>
  <thead><tr>
    <td class="main_container"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="stickerfnt" >
      <tr>
        <td width="19%">PAT# </td>
        <td width="81%" ><strong><?php echo $row_detail["strPatternNo"];?></strong></td>
      </tr>
      <tr>
        <td>PONO</td>
        <td><strong><?php echo $row_detail["strOrderNo"];?></strong></td>
      </tr>
      <tr>
        <td>SIZE</td>
        <td><strong><?php echo $row_detail["strSize"];?></strong></td>
      </tr>
      <tr>
        <td>CUT NO </td>
        <td   style="font-size:11px" nowrap="nowrap"><strong><?php echo $row_detail["strCutNo"];?></strong></td>
      </tr>
      <tr>
        <td  nowrap="nowrap">BUN# </td>
        <td><strong><?php echo $row_detail["dblBundleNo"]."-".$row_detail["strShade"]."/".$row_detail["dblPcs"];?></strong></td>
      </tr>
      <tr>
        <td>NUMBER</td>
        <td><strong><?php echo $row_detail["strNoRange"];?></strong></td>
      </tr>
      <tr>
        <td>PART</td>
        <td><strong><?php echo $row_detail["intComponentId"];?></strong></td>
      </tr>
      <tr>
        <td  nowrap="nowrap">INV# </td>
        <td  nowrap="nowrap"><strong><?php echo $row_detail["strInvoiceNo"];?></strong></td>
      </tr>
      <tr>
        <!--<td height="10" colspan="2" align="center" class="sticker-bar-fnt"><?php //echo $row_detail["dblRefNo"];;?></td>-->
        <td height="10" colspan="2" align="center" ></td>
      </tr>
    </table></td></tr></thead>
 	<tr><td>&nbsp;</td></tr>
<?php }?>  
</table>
</body>
