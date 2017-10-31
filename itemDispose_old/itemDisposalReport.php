<?php
 session_start();
$backwardseperator 	= "../";
include('../Connector.php');
$report_companyId=$_SESSION['UserID'];
$docNo = $_GET['req'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Item Disposal Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
  <?php include('../reportHeader.php'); ?>
</td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
 Item Disposal Report
 </td>
 </tr>
</table>
<br />

<?php 
$sql_dets="SELECT
o.strStyle,
sb.strBuyerPoName,
mt.strItemDescription,
st.dblQty,
mainstores.strName,
substores.strSubStoresName,
storeslocations.strLocName,
storesbins.strBinName,
st.strColor,
st.strSize,
st.intDocumentNo,
st.dtmDate,
u.Name
FROM
stocktransactions AS st
Inner Join matitemlist AS mt ON st.intMatDetailId = mt.intItemSerial
Inner Join orders AS o ON o.intStyleId = st.intStyleId
Inner Join useraccounts AS u ON u.intUserID = st.intUser
Left Join style_buyerponos AS sb ON sb.strBuyerPONO = st.strBuyerPoNo AND sb.intStyleId = o.intStyleId
Inner Join mainstores ON mainstores.strMainID = st.strMainStoresID
Inner Join substores ON substores.strSubID = st.strSubStores AND substores.strMainID = st.strMainStoresID
Inner Join storeslocations ON storeslocations.strLocID = st.strLocation AND storeslocations.strMainID = st.strMainStoresID AND storeslocations.strSubID = st.strSubStores
Inner Join storesbins ON storesbins.strMainID = st.strMainStoresID AND storesbins.strSubID = st.strSubStores AND storesbins.strLocID = st.strLocation AND storesbins.strBinID = st.strBin
WHERE st.intDocumentNo='$docNo' AND st.dblQty<0; ";
$resD=$db->RunQuery($sql_dets);
$resS=$db->RunQuery($sql_dets);
//echo $sql_dets;
$rowO=mysql_fetch_array($resS)
?>
<table width="1000" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="rows" >
    <tr>
	  <td class='bcgl1txt1NB' align="left" width="76">Dispose No. :</td>
	  <td class='bcgl1txt1NB' align="left" width="86"><?php echo $docNo;?></td>
      <td class='bcgl1txt1NB' align="left" width="205"></td>
      <td class='bcgl1txt1NB' align="left" width="79"></td>
      <td class='bcgl1txt1NB' align="left" width="101">User :</td>
      <td class='bcgl1txt1NB' align="left" width="98"><?php echo $rowO['Name'];?></td>
      <td class='bcgl1txt1NB' align="left" width="92"></td>
      <td class='bcgl1txt1NB' align="left" width="70"></td>
      <td class='bcgl1txt1NB' align="left" width="45"></td>
      <td class='bcgl1txt1NB' align="left" width="45">Date. :</td>
      <td class='bcgl1txt1NB' align="left" width="45"><?php echo substr($rowO['dtmDate'],0,10);?></td>
	</tr>
</table>
<table width="1000" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="rows" >
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="76">Style No</td>
	  <td class='bcgl1txt1NB' align="left" width="86">Buyer PO</td>
      <td class='bcgl1txt1NB' align="left" width="205">Material Description</td>
      <td class='bcgl1txt1NB' align="left" width="79">Dispose Qty</td>
      <td class='bcgl1txt1NB' align="left" width="101">Main Stores</td>
      <td class='bcgl1txt1NB' align="left" width="98">Sub Stores</td>
      <td class='bcgl1txt1NB' align="left" width="92">Location</td>
      <td class='bcgl1txt1NB' align="left" width="70">Bin</td>
      <td class='bcgl1txt1NB' align="left" width="45">Color</td>
      <td class='bcgl1txt1NB' align="left" width="45">Size</td>   
	  </tr>
      
      <?php while($rowD=mysql_fetch_array($resD)){?>
      <tr>
	  <td class='normalfnt' align="left" width="76"><?php echo $rowD['strStyle'];?></td>
	  <td class='normalfnt' align="left" width="86"><?php echo $rowD['strBuyerPoName'];?></td>
      <td class='normalfnt' align="left" width="205"><?php echo $rowD['strItemDescription'];?></td>
	  <td class='normalfnt' align="left" width="79"><?php echo ($rowD['dblQty']*(-1));?></td>
      <td class='normalfnt' align="left" width="101"><?php echo $rowD['strName'];?></td>
      <td class='normalfnt' align="left" width="98"><?php echo $rowD['strSubStoresName'];?></td>
      <td class='normalfnt' align="left" width="92"><?php echo $rowD['strLocName'];?></td>
      <td class='normalfnt' align="left" width="70"><?php echo $rowD['strBinName'];?></td>
	  <td class='normalfnt' align="left" width="45"><?php echo $rowD['strColor'];?></td>
      <td class='normalfnt' align="left" width="45"><?php echo $rowD['strSize'];?></td>
	  </tr>
      <?php }?>
</table>

</body>
</html>
