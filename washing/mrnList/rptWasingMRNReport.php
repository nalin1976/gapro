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
  Wash MRN Report
 </td>
 </tr>
</table>
<br />   
<?php
$sql_loadHeader="select concat(m.intMrnYear,'/',m.dblMrnNo) MRN,m.strColor,m.dblQty ,m.dblBalQty, o.intStyleId,o.strStyle,o.strOrderNo, ms.strName, d.strDepartment,m.dtmMrnDate,m.strRemarks,m.intUser 
from was_mrn m inner join orders o on o.intStyleId = m.intStyleId inner join mainstores ms on ms.strMainID=m.intStore inner join department d on d.intDepID=m.intDepartment where m.intMrnYear='$mrnNO[0]' and m.dblMrnNo = '$mrnNO[1]' order by m.dblMrnNo;";

//Inner Join companies ON was_issuedtowashheader.strFComCode = companies.intCompanyID WHERE  was_issuedtowashheader.dblIssueNo='$sNO'
//echo $sql_loadHeader;
$resH=$db->RunQuery($sql_loadHeader);
$rowH=mysql_fetch_array($resH);
?>
<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="groups" >
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="9%">MRN No </td>
	  <td width="38%" align="left" class='normalfnt'>:<?php echo $rowH['MRN'];?>:</td>
      <td class='bcgl1txt1NB' align="left" width="7%">Date</td>
	  <td colspan="3" align="left" class='normalfnt'>:<?php echo substr($rowH['dtmMrnDate'],0,10);?></td>
      </tr>
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="9%">PO No</td>
	  <td class='normalfnt' align="left">:<?php echo $rowH['strOrderNo'];?></td>
	  <td class='bcgl1txt1NB' align="left" width="7%">Style</td>
	  <td width="46%" colspan="1" align="left" class='normalfnt'>:<?php echo $rowH['strStyle'];?></td>
  </tr>
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="9%">Color</td>
	  <td class='normalfnt' align="left" colspan="5">:<?php echo $rowH['strColor'];?></td>
	  </tr>
      <tr>
	  <td class='bcgl1txt1NB' width="9%">Remarks</td>
	  <td class='normalfnt' colspan="5">:<?php echo $rowH['strRemarks'];?></td>

	  </tr>
</table>
<span class="normalfnt"></span> <br />

<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="" >
      <tr>
	  <td  width="293" class='normalfntMid'><strong>Stores</strong></td>
	  <td  width="326" class='normalfntMid'><strong>Department</strong></td>
	  <td  width="163" class='normalfntMid'><strong>MRN Qty</strong></td>
	  </tr>

      <tr>
	  <td class='normalfnt' width="293"><?php echo $rowH['strName'];?></td>
	  <td class='normalfnt'	width="326"><?php echo $rowH['strDepartment'];?></td>
	  <td class='normalfntRite'  width="163"><?php echo $rowH['dblQty'];?></td>
	  </tr>

</table>
<span class="normalfnt"></span> <br />
<table width="800" border="0" align='center' CELLPADDING=1 CELLSPACING=1 rules="" >
      <tr>
	  <td  width="293" class='normalfntMid'><?php echo getUserName($rowH['intUser']);?></td>
	  <td  width="326" class='normalfntMid'><strong></strong></td>
	  <td  width="163" class='normalfntMid'><strong></strong></td>
	  </tr>
      <tr>
	  <td  width="293" class='normalfntMid'><strong>..........................</strong></td>
	  <td  width="326" class='normalfntMid'><strong></strong></td>
	  <td  width="163" class='normalfntMid'><strong></strong></td>
	  </tr>
      <tr>
	  <td  width="293" class='normalfntMid'><strong>Requested By</strong></td>
	  <td  width="326" class='normalfntMid'><strong></strong></td>
	  <td  width="163" class='normalfntMid'><strong></strong></td>
	  </tr>
</table>
<?php
function getUserName($uid){
	global $db;
	$sql="select Name from useraccounts where intUserId='$uid';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_assoc($res);
	return $row['Name'];
}
?>
</body>
</html>
