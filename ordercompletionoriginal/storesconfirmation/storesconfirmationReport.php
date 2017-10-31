<?php
 session_start();
$backwardseperator 	= "../../";
include "../../authentication.inc";
include('../../Connector.php');
$report_companyId=$_SESSION['UserID'];
$companyId=$_SESSION["FactoryID"];
$sNO = $_GET['StyleNo'];
$disposeNo = $_GET["disposeNo"];
$disposeYear =  $_GET["disposeYear"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stores Comfirmation Report </title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="storesconfirmation.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/jquery.js"></script>
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
.rowBoder
{
	border-bottom:solid #CCC 2px;
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
 <td class="head2">
Stores Confirmation Report
 </td>
 </tr>
</table>
	<?php
	
     /*$sql_header="	SELECT
					orders.strOrderNo,
					stocktransactions_temp.strBuyerPoNo,
					matitemlist.strItemDescription,
					stocktransactions_temp.strColor,
					stocktransactions_temp.strUnit,
					stocktransactions_temp.dblQty,
					storesbins.strBinName,
					mainstores.strName,
					substores.strSubStoresName,
					stocktransactions_temp.intGrnNo,
					stocktransactions_temp.intGrnYear,
					stocktransactions_temp.intStyleId
					FROM
					stocktransactions_temp
					Inner Join orders ON orders.intStyleId = stocktransactions_temp.intStyleId
					Inner Join matitemlist ON stocktransactions_temp.intMatDetailId = matitemlist.intItemSerial
					Inner Join storesbins ON stocktransactions_temp.strBin = storesbins.strBinID
					Inner Join mainstores ON stocktransactions_temp.strMainStoresID = mainstores.strMainID
					Inner Join substores ON substores.strSubID = stocktransactions_temp.strSubStores
					Inner Join usercompany ON stocktransactions_temp.intUser = usercompany.userId
					WHERE
					stocktransactions_temp.strType =  'Dispose' 
					AND stocktransactions_temp.intStyleId =  '$sNO' AND
						usercompany.companyId =  '$report_companyId'";
					//bd.strDivision, INNER JOIN buyerdivisions AS bd ON bd.intDivisionId=wb.intDivisionId
					//echo $sql_header;
	$resHeader=$db->RunQuery($sql_header);*/
	
	?>
 <table width="1050" border="0" cellpadding="2" cellspacing="0" align="center">
 <tr><td align="left">   
<table width="300" border="1" align='left' CELLPADDING=1 CELLSPACING=1 rules="rows" >
    <tr>
	  <td class='bcgl1txt1NB' align="left" width="97" height="20">Dispose No. :</td>
	  <td class='bcgl1txt1NB' align="left" width="190"><?php echo $disposeYear.'/'.$disposeNo;?></td>
     
  </tr>
</table>
</td>
</tr>
<tr><td align="center">
<table width="1050" border='1' align='center' CELLPADDING=3 CELLSPACING=1 rules="all">
      <tr>
	 	<td class='bcgl1txt1NB' align="left" style="width:80px;"> Order No.</td>
	  	<td class='bcgl1txt1NB' align="left" style="width:100px;"> Buyer PO.</td>
	 	<td class='bcgl1txt1NB' align="left" style="width:250px;">Description</td>
	  	<td class='bcgl1txt1NB' align="left" style="width:120px;">Color</td>
	 	<td class='bcgl1txt1NB' align="left" style="width:70px;">Size</td>
	  	<td class='bcgl1txt1NB' align="left" style="width:70px;"> Unit</td>
	 	<td class='bcgl1txt1NB' align="left" style="width:70px;">Qty</td>
	  	<td class='bcgl1txt1NB' align="left" style="width:100px;">Bin </td>
	  	<td class='bcgl1txt1NB' align="left" style="width:100px;"> Main Store</td>
		<td class='bcgl1txt1NB' align="left" style="width:100px;"> Sub Store</td>
		<td class='bcgl1txt1NB' align="left" style="width:100px;"> Location</td>
		<td class='bcgl1txt1NB' align="left" style="width:100px;"> GRN No.</td>
        <td class='bcgl1txt1NB' align="left" style="width:50px;"> GRN Type</td>
	  </tr>
	  <?php 
      	$sql_header="SELECT
					orders.strOrderNo,
					stocktransactions_temp.strBuyerPoNo,
					matitemlist.strItemDescription,
					stocktransactions_temp.strColor,
					stocktransactions_temp.strUnit,
					stocktransactions_temp.dblQty,
					storesbins.strBinName,
					mainstores.strName,
					substores.strSubStoresName,
					concat(stocktransactions_temp.intGrnNo,'/',stocktransactions_temp.intGrnYear) AS GRN,
					stocktransactions_temp.intStyleId,
					storeslocations.strLocName,
					stocktransactions_temp.strSize,stocktransactions_temp.strGRNType
					FROM
					stocktransactions_temp
					Inner Join orders ON orders.intStyleId = stocktransactions_temp.intStyleId
					Inner Join matitemlist ON stocktransactions_temp.intMatDetailId = matitemlist.intItemSerial
					Inner Join storesbins ON stocktransactions_temp.strBin = storesbins.strBinID
					Inner Join mainstores ON stocktransactions_temp.strMainStoresID = mainstores.strMainID
					Inner Join substores ON substores.strSubID = stocktransactions_temp.strSubStores
					Inner Join storeslocations ON stocktransactions_temp.strLocation = storeslocations.strLocID
					WHERE
					stocktransactions_temp.strType =  'leftoverDisposal' 
					AND  stocktransactions_temp.intDocumentNo='$disposeNo' and stocktransactions_temp.intDocumentYear='$disposeYear'";
					//AND stocktransactions_temp.intStyleId =  '$sNO' and mainstores.intCompanyId= '$companyId'
					//echo $sql_header;
	$resHeader=$db->RunQuery($sql_header);
	while(@$row=mysql_fetch_array($resHeader)){
	?>
      <tr>
	 	<td class='normalfnt' align="left" ><?php echo $row['strOrderNo'];?></td>
	  	<td class='normalfnt' align="left" ><?php echo $row['strBuyerPoNo'];?></td>
	 	<td class='normalfnt' align="left" ><?php echo $row['strItemDescription'];?></td>
	  	<td class='normalfnt' align="left" ><?php echo $row['strColor'];?></td>
	 	<td class='normalfnt' align="left" ><?php echo $row['strSize'];?></td>
	  	<td class='normalfnt' align="left"> <?php echo $row['strUnit'];?></td>
	 	<td class='normalfntRite' align="left"> <?php echo $row['dblQty'];?></td>
	  	<td class='normalfnt' align="left"><?php echo $row['strBinName'];?> </td>
	  	<td class='normalfnt' align="left"><?php echo $row['strName'];?></td>
		<td class='normalfnt' align="left"><?php echo $row['strSubStoresName'];?> </td>
		<td class='normalfnt' align="left"><?php echo $row['strLocName'];?> </td>
	  	<td class='normalfntRite' align="left"><?php echo $row['GRN'];?></td>
        <td class='normalfnt' align="left"><?php echo $row['strGRNType'];?></td>
	  </tr>	
	  <?php }?>
</table>
</td></tr></table>
<br />
<table width="1000" border='0' align='center' CELLPADDING=3 CELLSPACING=1 id="tblConfirm">
	<tr>
		<td align="center"><img src="../../images/conform.png" onclick="confirmDisposeItems(<?php echo $disposeNo.','.$disposeYear?>);" /></td>
	</tr>
</table>
</body>
</html>
