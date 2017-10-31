<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
include('../washingCommonScript.php');
$wScripts=new wasCommonScripts();
$report_companyId=$_SESSION["FactoryID"];
$issueNo=$_GET['issueNo'];
$mrnNO 	= split('/',$issueNo);
$ino	= split('/',$issueNo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro | Washing Issue Report</title>
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
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;" colspan="5">
  <?php include('../../reportHeader.php'); ?>
</td>
</tr>
<tr>
 <td width="142" align="center" nowrap="nowrap" class="border-All-fntsize12" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
  WASHING STORES</td>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;" width="10"><span style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">&nbsp;</span></td>
 <td width="466" align="center" nowrap="nowrap" class="border-All-fntsize12" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;text-align:center">
  STORES REQUISITION / ISSUE ORDER (PRODUCTION)
 </td>  
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;" width="79"><span class="normalfntRite"><strong>Issue No:</strong>&nbsp;</span></td>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;" width="85"><span style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;"><?php echo $issueNo;?></span></td>
 </tr>
</table> 
<?php

$sql_loadHeader="SELECT
o.strOrderNo,
o.strStyle,
ms.strName,
d.strDepartment,
companies.strName AS cmp,
concat(w.intMrnYear,'/',w.dblMrnNo) AS MRN,
w.strColor,
w.dblQty,
w.dtmDate,
w.strRemarks,
o.strDescription
FROM
orders AS o 
INNER JOIN was_issue w ON w.intStyleId=o.intStyleId
INNER JOIN mainstores AS ms ON w.intStore = ms.strMainID
INNER JOIN department AS d ON w.intDepartment = d.intDepID 
INNER JOIN companies ON w.intSFac = companies.intCompanyID
WHERE
CONCAT(w.intIssueYear,'/',w.intIssueNo) = '$issueNo';";
//echo $sql_loadHeader;
$resH=$db->RunQuery($sql_loadHeader);
$rowH=mysql_fetch_array($resH);
$po=$rowH['intStyleId'];
$color=$rowH['strColor'];
$Store=$rowH['intStore'];
$Department=$rowH['intDepartment'];
$CompanyId=$rowH['intCompanyId'];

?>
<table align="center" width="800" border="0">

<tr>
<td width="626">&nbsp;</td>
<td width="69" class='normalfntRite'>&nbsp;</td>
<td width="91" colspan="1" align="right" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">&nbsp;</td>
</tr>
</table>
<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="groups" >
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="9%">MRN No </td>
	  <td class='normalfnt' align="left" width="21%">:<?php echo $rowH['MRN'];?></td>
      <td class='bcgl1txt1NB' align="left" width="9%">PO No</td>
	  <td class='normalfnt' align="left" width="14%">:<?php echo $rowH['strOrderNo'];?></td>
      <td class='bcgl1txt1NB' align="left" width="10%">Style </td>
      <td class='normalfnt' align="left" >:<?php echo $rowH['strStyle'];?></td>
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
	  <td class='bcgl1txt1NB' align="left" width="9%">&nbsp;</td>
	  <td class='normalfnt' align="left" >&nbsp;</td>
      </tr>
      <tr>
	  <td class='bcgl1txt1NB' align="left"  colspan="2">Sewing Factory</td>
	  <td class='normalfnt' align="left" colspan="6"><?php echo $rowH['cmp'];?></td>
      </tr>
</table>
<br />
<table width="800" height="188" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="all" >
      <tr height="20">
	  <td class='normalfntMid' colspan="2" width="40%"><strong>STYLE </strong></td>
      <td class='normalfntMid' colspan="2" width="40%"><strong>DESCRIPTION</strong></td>
      <td   class='normalfntMid' width="10%"><strong>UNIT</strong></td>
	  <td   class='normalfntMid' width="10%"><strong>QTY</strong></td>
	  </tr>
	<?php 
		/*$sql="SELECT companies.strName,was_issue.dblQty,was_issue.dtmDate,concat(was_issue.intIssueYear,'/',was_issue.intIssueNo) as ISSUENO
		FROM
		was_issue
		INNER JOIN companies ON was_issue.intSFac = companies.intCompanyID
		WHERE
		was_issue.intStyleId='$po' AND
		was_issue.strColor='$color' AND
		was_issue.intStore='$Store' AND
		was_issue.intDepartment='$Department' AND
		was_issue.intCompanyId='$CompanyId'";
		if(!empty($_GET['ino'])){
			$sql.=" AND was_issue.intIssueYear='$ino[0]' AND was_issue.intIssueNo='$ino[1]';";
		}
		//echo $sql;
		$res=$db->RunQuery($sql);
		$Count=0;
		while($rowD=mysql_fetch_array($res)){
			$Count+=$rowD['dblQty'];*/
	?>
      <tr valign="top">
	  <td height="68" class='normalfnt' colspan="2">&nbsp;<?php echo $rowH['strDescription'];?></td>
      <td class='normalfnt' colspan="2"><?php echo $rowH['strRemarks'];?></td>
      <td class='normalfnt'	>PCs</td>
	  <td class='normalfntRite' ><?php echo $rowH['dblQty'];?>&nbsp;</td>
	  </tr>
	<?php //}?>
    
    <tr>
      <td height="77"	colspan="6" class=''>
      	<table width="100%">
        		<tr>
                  <td class='normalfnt'	width="25%" colspan="1" style="text-align:center;">......................</td>
                  <td class='normalfnt'	width="25%" colspan="1" style="text-align:center;">......................</td>
                  <td class='normalfnt'	width="25%" colspan="1" style="text-align:center;">......................</td>
                  <td class='normalfnt'	width="25%" colspan="1" style="text-align:center;">......................</td>
                </tr>
                <tr>
                  <td	width="96" height="20" colspan="1" class='normalfnt' style="text-align:center;">REQUESTED BY</td>
                  <td class='normalfnt'	width="89" colspan="1" style="text-align:center;">APPROVED BY</td>
                  <td class='normalfnt'	width="73" colspan="1" style="text-align:center;">ISSUED BY</td>
                  <td class='normalfnt'	width="484" colspan="1" style="text-align:center;">RECEIVED BY</td>
                </tr>
        </table>
      </td>
	</tr>
</table>


</body>
</html>
