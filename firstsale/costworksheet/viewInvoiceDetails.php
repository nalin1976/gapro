<?php
 session_start();
 $styleId = $_GET["styleId"];
 $FabId = $_GET["FabId"];
 include("../../Connector.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="450" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
   <!--<tr>
    <td>&nbsp;</td>
  </tr>-->
  <tr>
    <td><div  id="divUploader" style="width:100%;height:100px;overflow: -moz-scrollbars-horizonral;">
    <table width="450" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
      <tr class="mainHeading4">
        <td width="381" height="22">Document Name</td>
        <td width="69">Open</td>
      </tr>
      <?php 
	  $sql = "select distinct bgh.intBulkGrnNo,bgh.intYear 
from bulkgrnheader bgh inner join commonstock_bulkdetails cbd on 
bgh.intBulkGrnNo = cbd.intBulkGrnNo and bgh.intYear=cbd.intBulkGRNYear inner join commonstock_bulkheader cbh on
cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
where cbh.intToStyleId='$styleId' and cbd.intMatDetailId='$FabId'";
	
	$result= $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		//$grnNo = $row["intYear"].'-'.$row["intBulkGrnNo"];
		$file = "";
		$url = "../../upload files/bulk grn/". $row["intYear"].'-'.$row["intBulkGrnNo"]."/";
		$serverRoot = $_SERVER['DOCUMENT_ROOT'];
		$dh = opendir($url);
		while (($file = readdir($dh)) != false)
		{
			if($file!='.' && $file!='..')
			{
	  ?>
      <tr class="bcgcolor-tblrowWhite">
        <td class="normalfnt">&nbsp;<?php echo $file; ?></td>
        <td class="normalfntMid"><a href="<?php echo $url.''.rawurlencode($file) ;?>" target="_blank"><img src="../../images/pdf.png" border="0" /></a></td>
      </tr>
      <?php 
		    }
	    }
	}
	  ?>
      <?php 
	  $sql = " SELECT  distinct LCD.intGrnNo,LCD.intGrnYear
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$styleId'  and 
						LCD.intMatDetailId = '$FabId' and LCH.intStatus=1";
	
	$result= $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		//$grnNo = $row["intYear"].'-'.$row["intBulkGrnNo"];
		$file = "";
		$url = "../../upload files/bulk grn/". $row["intGrnYear"].'-'.$row["intGrnNo"]."/";
		$serverRoot = $_SERVER['DOCUMENT_ROOT'];
		$dh = opendir($url);
		while (($file = readdir($dh)) != false)
		{
			if($file!='.' && $file!='..')
			{
	  ?>
      <tr class="bcgcolor-tblrowWhite">
        <td class="normalfnt">&nbsp;<?php echo $file; ?></td>
        <td class="normalfntMid"><a href="<?php echo $url.''.rawurlencode($file) ;?>" target="_blank"><img src="../../images/pdf.png" border="0" /></a></td>
      </tr>
      <?php 
		    }
	    }
	}
	  ?>
    </table>
    </div></td>
  </tr>
  <tr>
    <td class="normalfntMid"><table width="95%" border="0" cellspacing="0" cellpadding="2" class="bcgl1" align="center">
  <tr>
    <td align="center"><img src="../../images/close.png" width="97" height="24" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>
