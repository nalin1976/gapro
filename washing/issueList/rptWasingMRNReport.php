<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
include('../washingCommonScript.php');
$wScripts=new wasCommonScripts();
$report_companyId=$_SESSION["FactoryID"];
$mrnNO 	= split('/',$_GET['mrn']);

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
  Washing MRN Issue Report
 </td>
 </tr>
</table>
<br />   
<?php

$sql_loadHeader="SELECT m.intStyleId,m.strColor,m.intStore,m.intDepartment,m.intCompanyId,o.strOrderNo,o.strStyle,ms.strName,d.strDepartment,m.dblQty,m.dtmMrnDate 
FROM was_mrn AS m
INNER JOIN orders AS o ON m.intStyleId = o.intStyleId
inner join mainstores ms on ms.strMainID=m.intStore inner join department d on d.intDepID=m.intDepartment
WHERE
m.intMrnYear='$mrnNO[0]' and  m.dblMrnNo = '$mrnNO[1]' order by m.dblMrnNo;";

$resH=$db->RunQuery($sql_loadHeader);
$rowH=mysql_fetch_array($resH);
$po=$rowH['intStyleId'];
$color=$rowH['strColor'];
$Store=$rowH['intStore'];
$Department=$rowH['intDepartment'];
$CompanyId=$rowH['intCompanyId'];

?>
<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="groups" >
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="9%">MRN No </td>
	  <td class='normalfnt' align="left" width="21%">:<?php echo $_GET['mrn'];?></td>
      <td class='bcgl1txt1NB' align="left" width="9%">PO No</td>
	  <td class='normalfnt' align="left" width="14%">:<?php echo $rowH['strOrderNo'];?></td>
      <td class='bcgl1txt1NB' align="left" width="10%">Style </td>
	  <td class='normalfnt' align="left" width="14%">:<?php echo $rowH['strStyle'];?></td>
      <td class='bcgl1txt1NB' align="left" width="9%">Date</td>
	  <td class='normalfnt' align="left" width="14%">:<?php echo substr($rowH['dtmMrnDate'],0,10);?></td>
	  </tr>
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="9%">Color</td>
	  <td class='normalfnt' align="left" >:<?php echo $rowH['strColor'];?></td>
	  <td class='bcgl1txt1NB' align="left" width="9%"><strong>Stores</strong></td>
	  <td class='normalfnt' align="left" >:<?php echo $rowH['strName'];?></td>
      <td class='bcgl1txt1NB' align="left" width="9%"><strong>Department</strong></td>
	  <td class='normalfnt' align="left" >:<?php echo $rowH['strDepartment'];?></td>
	  <td class='bcgl1txt1NB' align="left" width="9%"><strong>MRN Qty</strong></td>
	  <td class='normalfnt' align="left" >:<?php echo $rowH['dblQty'];?></td>
      
  </tr>
</table>


<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="" >
      <tr>
	  <td  width="147" class='normalfntMid'><strong>Issue No</strong></td>
      <td  width="372" class='normalfntMid'><strong>Sewing Factory</strong></td>
	  <td  width="126" class='normalfntMid'><strong>Issue Qty</strong></td>
	  <td  width="132" class='normalfntMid'><strong>Issue Date</strong></td>
	  </tr>
	<?php 
		$sql="SELECT companies.strName,was_issue.dblQty,was_issue.dtmDate,concat(was_issue.intIssueYear,'/',was_issue.intIssueNo) as ISSUENO
		FROM
		was_issue
		INNER JOIN companies ON was_issue.intSFac = companies.intCompanyID
		WHERE
		was_issue.intStyleId='$po' AND
		was_issue.strColor='$color' AND
		was_issue.intStore='$Store' AND
		was_issue.intDepartment='$Department' AND
		was_issue.intCompanyId='$CompanyId';";
		$res=$db->RunQuery($sql);
		$Count=0;
		while($rowD=mysql_fetch_array($res)){
			$Count+=$rowD['dblQty'];
	?>
      <tr>
	  <td class='normalfnt' width="147">&nbsp;<?php echo $rowD['ISSUENO'];?></td>
      <td class='normalfnt'	width="372">&nbsp;<?php echo $rowD['strName'];?></td>
	  <td class='normalfntRite'	width="126" ><?php echo $rowD['dblQty'];?>&nbsp;</td>
	  <td class='normalfnt'  width="132" style="text-align:center"><?php echo substr($rowD['dtmDate'],0,10);?></td>
	  </tr>
	<?php }?>
    <tr>
      <td class='normalfntRite'	width="372" colspan="2">Total Qty&nbsp;</td>
	  <td class='normalfntRite'	width="126" ><?php echo $Count ;?>&nbsp;</td>
	  <td class='normalfnt'  width="132" style="text-align:center">&nbsp;</td>
	  </tr>

</table>


</body>
</html>
