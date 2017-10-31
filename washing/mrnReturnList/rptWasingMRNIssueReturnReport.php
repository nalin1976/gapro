<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
include('../washingCommonScript.php');
$wScripts=new wasCommonScripts();
$report_companyId=$_SESSION["FactoryID"];
$issueNo 	= split('/',$_GET['issueNo']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MRN Report</title>
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
  Washing  MRN Return Report
 </td>
 </tr>
</table>
<br />   
<?php

$sql_loadHeader="SELECT
wi.dtmDate,
mainstores.strName,
department.strDepartment,
wi.intIssueYear,
wi.intIssueNo,
wi.dblQty,
department.intDepID,
mainstores.strMainID,
wi.intCompanyId,
wi.strColor,
wi.intStyleId,
orders.strOrderNo,
orders.strStyle
FROM
was_issue AS wi
INNER JOIN mainstores ON wi.intStore = mainstores.strMainID
INNER JOIN department ON department.intDepID = wi.intDepartment
INNER JOIN orders ON wi.intStyleId = orders.intStyleId
WHERE
wi.intIssueNo='$issueNo[1]' AND
wi.intIssueYear= '$issueNo[0]' order by wi.intIssueNo;;";
//echo $sql_loadHeader;
$resH=$db->RunQuery($sql_loadHeader);
$rowH=mysql_fetch_array($resH);
$po=$rowH['intStyleId'];
$color=$rowH['strColor'];
$Store=$rowH['strMainID'];
$IssueYeart=$rowH['intIssueYear'];
$IssueNo=$rowH['intIssueNo'];

?>
<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="groups" >
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="9%">Issue No </td>
	  <td class='normalfnt' align="left" width="21%">:<?php echo $_GET['issueNo'];?></td>
      <td class='bcgl1txt1NB' align="left" width="9%">PO No</td>
	  <td class='normalfnt' align="left" width="14%">:<?php echo $rowH['strOrderNo'];?></td>
      <td class='bcgl1txt1NB' align="left" width="10%">Style </td>
	  <td class='normalfnt' align="left" width="14%">:<?php echo $rowH['strStyle'];?></td>
      <td class='bcgl1txt1NB' align="left" width="9%">Date</td>
	  <td class='normalfnt' align="left" width="14%">:<?php echo substr($rowH['dtmDate'],0,10);?></td>
	  </tr>
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="9%">Color</td>
	  <td class='normalfnt' align="left" >:<?php echo $rowH['strColor'];?></td>
	  <td class='bcgl1txt1NB' align="left" width="9%"><strong>Stores</strong></td>
	  <td class='normalfnt' align="left" >:<?php echo $rowH['strName'];?></td>
      <td class='bcgl1txt1NB' align="left" width="9%"><strong>Department</strong></td>
	  <td class='normalfnt' align="left" >:<?php echo $rowH['strDepartment'];?></td>
	  <td class='bcgl1txt1NB' align="left" width="9%"><strong>Issue Qty</strong></td>
	  <td class='normalfnt' align="left" >:<?php echo $rowH['dblQty'];?></td>
      
  </tr>
</table>


<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="" >
      <tr>
	  <td  width="147" class='normalfntMid'><strong>Return  No</strong></td>
      <td  width="372" class='normalfntMid'><strong>Sewing Factory</strong></td>
	  <td  width="126" class='normalfntMid'><strong>Return Qty</strong></td>
	  <td  width="132" class='normalfntMid'><strong>Return Date</strong></td>
	  </tr>
	<?php 
		$sql="SELECT
			concat(r.intRYear,'/',r.dblRNo) as RNO, 
			r.intRYear,r.dblRNo,
			companies.strName,
			r.dblQty,
			r.intStore,
			r.intDepartment,
			r.strColor,
			r.intStyleId,
			r.intRYear,
			r.dblRNo
			FROM
			was_mrnreturn AS r
			INNER JOIN companies ON r.intSFac = companies.intCompanyID AND r.intSFac = companies.intCompanyID
			WHERE
			r.intIYear='$issueNo[0]' AND
			r.dblINo='$issueNo[1]' ;";
			//echo $sql;
		$res=$db->RunQuery($sql);
		$Count=0;
		while($rowD=mysql_fetch_array($res)){
			$Count+=$rowD['dblQty'];
	?>
      <tr>
	  <td class='normalfnt' width="147">&nbsp;<?php echo $rowD['RNO'];?></td>
      <td class='normalfnt'	width="372">&nbsp;<?php echo $rowD['strName'];?></td>
	  <td class='normalfntRite'	width="126" ><?php echo $rowD['dblQty'];?>&nbsp;</td>
	  <td class='normalfnt'  width="132" style="text-align:center"><?php echo substr(getReturnDate($rowD['intRYear'],$rowD['dblRNo']),0,10);?></td>
	  </tr>
	<?php }?>
    <tr>
      <td class='normalfntRite'	width="372" colspan="2">Total Qty&nbsp;</td>
	  <td class='normalfntRite'	width="126" ><?php echo $Count ;?>&nbsp;</td>
	  <td class='normalfnt'  width="132" style="text-align:center">&nbsp;</td>
	  </tr>

</table>

<?php 
function getReturnDate($year,$no){
	global $db;
	$sql="select ws.dtmDate from was_stocktransactions ws where ws.intDocumentYear='$year' and ws.intDocumentNo='$no';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['dtmDate'];
}
?>
</body>
</html>
