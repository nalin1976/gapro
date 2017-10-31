<?php
 session_start();
$backwardseperator 	= "../../../";
include('../../../Connector.php');
$report_companyId=$_SESSION['UserID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wash Type - Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
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
  <?php include('../../../reportHeader.php'); ?>
</td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
 WASH TYPES</td>
 </tr>
</table>
<?php
$sql_wash="SELECT intWasID,strWasType,dblUnitPrice,intStatus FROM was_washtype";
$res=$db->RunQuery($sql_wash);

?>    
<table width="800" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="all" >
      <tr>
	  <td class='normalfntBtab'  width="10%">ID</td>
	  <td class='normalfntBtab'  width="62%">Wash Type</td>
      <td class='normalfntBtab'  width="13%">Unit Price</td>
	  <td class='normalfntBtab'  width="15%">Status</td>
	  </tr>
      <?php while($row=mysql_fetch_array($res))
	  {
	  	$status = $row['intStatus'];
	  ?>
      <tr>
	  <td class='normalfntMid'  width="10%"><?php echo $row['intWasID'];?></td>
	  <td class='normalfnt'  width="62%"><?php echo $row['strWasType'];?></td>
      <td class='normalfntRite'  width="13%"><?php echo number_format($row['dblUnitPrice'],2);?></td>
	  <td class='normalfntMid'  width="15%"><?php echo ($status==1? "Yes":"No");?></td>
	  </tr>
      <?php }?>
</table>	
<br />
<br />

</body>
</html>
