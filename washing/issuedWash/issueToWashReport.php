<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
include('../washingCommonScript.php');
$wScripts=new wasCommonScripts();
$report_companyId=$_SESSION["FactoryID"];
$sNO 	= split('/',$_GET['q']);
$iNo 	= $sNO[1];
$iYear 	= $sNO[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stores Wash Issue Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
-->
table
{
	border-spacing:0px;
}
</style>
<script type="text/javascript" src="issuedWash.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
</head>
<body>
<table align="center" width="800" border="0">

<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
  <?php include('../../reportHeader.php'); ?>
</td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
 Issued To Wash Report
 </td>
 </tr>
</table>
<br />   
<?php
$sql_loadHeader="SELECT
was_issuedtowashheader.dblIssueNo,
was_issuedtowashheader.dtmIssueDate,
companies.strName,
orders.strOrderNo,
orders.intStyleId
FROM
was_issuedtowashheader
Inner Join companies ON was_issuedtowashheader.strFComCode = companies.intCompanyID
Inner Join orders ON orders.intStyleId = was_issuedtowashheader.intStyleNo
WHERE
was_issuedtowashheader.dblIssueNo =  '".$iNo."' AND
was_issuedtowashheader.intIssueYear =  '".$iYear."' AND
was_issuedtowashheader.intCompanyId='$report_companyId';";

//Inner Join companies ON was_issuedtowashheader.strFComCode = companies.intCompanyID WHERE  was_issuedtowashheader.dblIssueNo='$sNO'
//echo $sql_loadHeader;
$resH=$db->RunQuery($sql_loadHeader);
$rowH=mysql_fetch_array($resH);
?>
<table width="600" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="groups" >
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="12.5%">Issued No </td>
	  <td class='normalfnt' align="left" width="37.5%">:<?php echo $rowH['dblIssueNo']; ?></td>
      <td class='bcgl1txt1NB' align="left" width="12.5%">Date</td>
	  <td class='normalfnt' align="left" width="37.5%">:<?php echo substr($rowH['dtmIssueDate'],0,10); ?></td>
	  </tr>
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="15%">Factory Name</td>
	  <td class='normalfnt' align="left" width="35%">:<?php  echo $rowH['strName'];; ?></td>
      <td class='bcgl1txt1NB' align="left" width="15%">PO No</td>
	  <td class='normalfnt' align="left" width="35%">:<?php echo $rowH['strOrderNo']; ?></td>
	  </tr>
</table>	
<br />
<?php 
$sql_dets="SELECT
was_issuedtowashheader.strColor,
was_issuedtowashheader.dblQty,
was_issuedtowashheader.strFComCode,
orders.strDescription
FROM
was_issuedtowashheader
Inner Join orders ON orders.intStyleId = was_issuedtowashheader.intStyleNo
WHERE
was_issuedtowashheader.dblIssueNo =  '".$iNo."' AND
was_issuedtowashheader.intIssueYear =  '".$iYear."' AND
was_issuedtowashheader.intCompanyId='$report_companyId' ;";
$resD=$db->RunQuery($sql_dets);

?>
<table width="600" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="" >
      <tr>
	  <td  width="25%" class='normalfntMid'><strong>Style No</strong></td>
	  <td  width="25%" class='normalfntMid'><strong>Color</strong></td>
	  <td  width="25%" class='normalfntMid'><strong>Received Qty</strong></td>
      <td  width="25%" class='normalfntMid'><strong>Issue Qty</strong></td>
	  </tr>
<?php while($rowD=mysql_fetch_array($resD)){?>
      <tr>
	  <td class='normalfnt' width="10%"><?php echo $rowD['strDescription'];?>&nbsp;</td>
	  <td class='normalfnt'	width="15%"><?php echo $rowD['strColor'];?></td>
	  <td class='normalfntRite'  width="12.5%"><?php echo $wScripts->gpQtyForIssued($rowH['intStyleId'],$rowD['strColor'],$report_companyId,$rowD['strFComCode']); ?></td>
      <td class='normalfntRite' width="12.5%"><?php echo $rowD['dblQty'];?></td>
	  </tr>
<?php }
$sqlChk="select count(*) as C from  was_stocktransactions where intDocumentNo='".$iNo."' and intDocumentYear='".$iYear."' and strType='IWash';";

						$res=$db->RunQuery($sqlChk);
						$chk=0;
						$rowc=mysql_fetch_array($res);
						$c=$rowc['C']; 
						if( $c > 0  ){
							$chk=1;
							}
						else {
							$chk=0;
							}
?>

</table>
<br />
<table width="600" border="0" align='center' CELLPADDING=1 CELLSPACING=1 rules="">
		<tr>
	  <td colspan="4" style="text-align:center;"><img src="../../images/conform.png" id='imgConfirm' style="visibility:<?php if($chk==1){ echo "hidden";}else {echo "visible";}?>" onclick="confirmReport(<?php echo $iYear;?>,<?php echo $iNo;?>);"/></td>
	</tr>
</table>
<?php
function getRCVDQty($po,$color,$report_companyId){
	global $db;
	$sql="select sum(dblQty) as RCVDQty from was_stocktransactions where intStyleId='$po' and strColor='$color' and intCompanyId='$report_companyId' group by intStyleId,strColor;";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['RCVDQty'];
}
?>
</body>
</html>
