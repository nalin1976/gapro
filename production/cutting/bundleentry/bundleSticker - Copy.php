<?php 
	session_start();
	include "../../../Connector.php";
	$styleid=$_GET["style"];
	$cutno=$_GET['cutno'];	
	
	$str_no="select intCutBundleSerial from productionbundleheader where intStyleId='$styleid' and strCutNo='$cutno'";
	
	$result_cutno=$db->RunQuery($str_no);
	$row=mysql_fetch_array($result_cutno);
	$cutserial=$row["intCutBundleSerial"];
	//bar code files ----------------------
	require('barcode/class/BCGFont.php');
require('barcode/class/BCGColor.php');
require('barcode/class/BCGDrawing.php'); 

// Including the barcode technology
include('barcode/class/BCGcode39.barcode.php'); 
//end--------------------------	
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
	font-size: 12px;
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
				ord.strStyle	 
				from 
				productionbundlesubdetail pbsd left join productionbundledetails pbd on pbd.intCutBundleSerial= pbsd.intCutBundleSerial and 
				pbd.dblBundleNo= pbsd.dblBundleNo left join productionbundleheader pbh on pbh.intCutBundleSerial=pbsd.intCutBundleSerial left join orders ord on ord.intStyleId=pbh.intStyleId
				where pbsd.intCutBundleSerial='$cutserial' order by pbd.dblBundleNo";
				//die($str_detail);
	$result_detail=$db->RunQuery($str_detail); $i=0; 
  while($row_detail=mysql_fetch_array($result_detail)){$i++;?>
  <thead><tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="stickerfnt">
     <tr>
        <td width="35%">PATTN NO </td>
        <td width="65%"><?php echo $row_detail["strPatternNo"];?></td>
      </tr>
      <tr>
        <td>PONO</td>
        <td><?php echo $row_detail["strStyle"];?></td>
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
        <td><?php echo $row_detail["dblBundleNo"];?></td>
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
	    <!--<td height="10" colspan="2" align="center" class="sticker-bar-fnt"><?php //echo $row_detail["dblRefNo"];;?></td>-->
        <td height="35" colspan="2" align="center" class="sticker-bar-fnt"> 
 <?php echo $row_detail["dblRefNo"]; ?></td>
	    </tr>
	 	
    </table></td></tr></thead>
 	<tr><td>&nbsp;</td></tr>
    <?php }?>
  
</table>
</body>

