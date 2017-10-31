<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
$report_companyId=$_SESSION['UserID'];
$sNO = $_GET['q'];
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
 Stores Wash Issue Report
 </td>
 </tr>
</table>
<br />   
<?php

$sql="SELECT was_issuedheader.intMode FROM was_issuedheader WHERE was_issuedheader.intIssueId =  '$sNO';";
$resChk=$db->RunQuery($sql);
$rowChk=mysql_fetch_array($resChk);

if($rowChk['intMode']==0){
	$sql_loadHeader="SELECT
	wih.intIssueId,
	wih.dtmDate,
	companies.strName,
	buyerdivisions.strDivision,
	O.intSeasonId
	FROM
	was_issuedheader AS wih
	Inner Join orders AS O ON O.intStyleId = wih.intStyleId
	Inner Join productionfinishedgoodsreceiveheader ON productionfinishedgoodsreceiveheader.intStyleNo = O.intStyleId
	Inner Join companies ON productionfinishedgoodsreceiveheader.strTComCode = companies.intCompanyID
	Inner Join buyerdivisions ON O.intBuyerID = buyerdivisions.intBuyerID AND O.intDivisionId = buyerdivisions.intDivisionId
	WHERE wih.intIssueId='$sNO';";
}
else{
	$sql_loadHeader="SELECT
	wih.intIssueId,
	wih.dtmDate,
	buyerdivisions.strDivision,
	was_outside_companies.strName
	FROM
	was_issuedheader AS wih
	Inner Join was_outsidepo ON wih.intStyleId = was_outsidepo.intId
	Left Join buyerdivisions ON was_outsidepo.intDivision = buyerdivisions.intDivisionId
	Inner Join was_outsidewash_fabdetails ON was_outsidepo.intFabId = was_outsidewash_fabdetails.intId AND was_outsidewash_fabdetails.intBuyer = buyerdivisions.intBuyerID AND was_outsidewash_fabdetails.intDivision = buyerdivisions.intDivisionId
	Inner Join was_outside_companies ON was_outsidepo.intFactory = was_outside_companies.intCompanyID
	WHERE wih.intIssueId ='$sNO';";
	
}
$resH=$db->RunQuery($sql_loadHeader);
$rowH=mysql_fetch_array($resH);
?>
<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="groups" >
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="12.5%">Issued No </td>
	  <td class='normalfnt' align="left" width="37.5%">:<?php echo $rowH['intIssueId']; ?></td>
      <td class='bcgl1txt1NB' align="left" width="12.5%">Date</td>
	  <td class='normalfnt' align="left" width="37.5%">:<?php echo substr($rowH['dtmDate'],0,10); ?></td>
	  </tr>
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="12.5%">Factory Name</td>
	  <td class='normalfnt' align="left" width="37.5%">:<?php  echo $rowH['strName'];; ?></td>
      <td class='bcgl1txt1NB' align="left" width="12.5%">Division</td>
	  <td class='normalfnt' align="left" width="37.5%">:<?php echo $rowH['strDivision']; ?></td>
	  </tr>
</table>	
<br />
<?php 
if($rowChk['intMode']==0){
	$sql_dets="SELECT O.strStyle,O.strOrderNo,wm.strColor,wi.dblQty,dblRQty,dblWQty,dblIQty 
	FROM 
	was_issuedheader wi
	INNER JOIN orders O ON O.intStyleId=wi.intStyleId
	INNER JOIN was_machineloadingdetails wm ON wm.intStyleId=wi.intStyleId
	WHERE 
	wi.intIssueId='$sNO';";
}
else{
	$sql_dets="SELECT
				wm.strColor,
				wi.dblQty,
				wi.dblRQty,
				wi.dblWQty,
				wi.dblIQty,
				was_outsidepo.strStyleDes as strStyle
				FROM
				was_issuedheader AS wi
				Inner Join was_machineloadingdetails AS wm ON wm.intStyleId = wi.intStyleId
				Inner Join was_outsidepo ON wi.intStyleId = was_outsidepo.intId
				WHERE 
				wi.intIssueId='$sNO';";
}
$resD=$db->RunQuery($sql_dets);
$rowD=mysql_fetch_array($resD);
?>
<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="rows" >
      <tr>
	  <td  width="172" class='normalfnt'><strong>Style No</strong></td>
	  <td  width="174" class='normalfnt'><strong>Oder No</strong></td>
      <td  width="158" class='normalfnt'><strong>Color</strong></td>
	  <td  width="49" class='normalfntMid'><strong>Po Qty</strong></td>
      <td  width="82" class='normalfntMid'><strong>Receive Qty</strong></td>
      <td  width="63" class='normalfntMid'><strong>Wash Qty</strong></td>
      <td  width="64" class='normalfntMid'><strong>Issue Qty</strong></td>
	  </tr>
      <tr>
	  <td class='normalfnt'  width="172"><?php echo $rowD['strStyle'];?></td>
	  <td class='normalfnt'  width="174"><?php echo $rowD['strOrderNo'];?></td>
      <td class='normalfnt'  width="158"><?php echo $rowD['strColor'];?></td>
	  <td class='normalfntRite'  width="49"><?php echo $rowD['dblQty'];?>&nbsp;</td>
      <td class='normalfntRite'  width="82"><?php echo $rowD['dblRQty'];?>&nbsp;</td>
      <td class='normalfntRite'  width="63"><?php echo $rowD['dblWQty'];?>&nbsp;</td>
      <td class='normalfntRite'  width="64"><?php echo $rowD['dblIQty'];?>&nbsp;</td>
	  </tr>
</table>

</body>
</html>
