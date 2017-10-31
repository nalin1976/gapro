<?php
include "Connector.php";
	$companyId  =$_SESSION["FactoryID"];
	$styleId = $_GET["styleId"];
	$matDetailId = $_GET["matDetailId"];
	$itemDesc = $_GET["itemDesc"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$buyerPO = $_GET["buyerPO"];
	$alloID = $_GET["alloID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="363" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
  <tr>
    <td width="363"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="mainHeading">
        <td width="95%" height="22"> Item Movement - <?php echo $itemDesc; ?></td>
        <td width="5%"><img src="images/cross.png" width="17" height="17" onClick="closePopupBox(25);"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div style="overflow:scroll; width:100%; height:200px;">
    <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
      <tr class="mainHeading4">
        <td width="54%"  height="20">Main Store</td>
        <td width="22%"> Qty</td>
         <td width="24%">Pending Allocation Qty</td>
      </tr>
      <?php
if($alloID == 'L')
{	   
	  $sql = "select  COALESCE(sum(dblQty),0) as dblQty,ms.strName,st.strMainStoresID 
from stocktransactions_leftover  st inner join mainstores ms on
st.strMainStoresID = ms.strMainID 
where intMatDetailId='$matDetailId' and strColor='$color' and strSize='$size'
group by st.strMainStoresID ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$pendingLQty = getPendingLeftOverAllocationQty($row["strMainStoresID"],$matDetailId,$color,$size);
	  ?>
      <tr bgcolor="#FFFFFF">
        <td class="normalfnt" height="20"><?php echo $row["strName"]; ?></td>
        <td class="normalfntR"><?php echo $row["dblQty"]; ?></td>
          <td class="normalfntR"><?php echo $pendingLQty; ?></td>
      </tr>
      <?php 
	}
}
else if($alloID == 'B')
{
	$sql = "select  COALESCE(sum(dblQty),0) as dblQty,ms.strName,st.strMainStoresID 
from stocktransactions_bulk  st inner join mainstores ms on
st.strMainStoresID = ms.strMainID 
where intMatDetailId='$matDetailId' and strColor='$color' and strSize='$size'
group by st.strMainStoresID ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$pendingQty = getPendingBulkAlloQty($row["strMainStoresID"],$matDetailId,$color,$size);
	  ?>
       <tr bgcolor="#FFFFFF">
        <td class="normalfnt" height="20"><?php echo $row["strName"]; ?></td>
        <td class="normalfntR"><?php echo $row["dblQty"]; ?></td>
         <td class="normalfntR"><?php echo $pendingQty; ?></td>
      </tr>
      <?php 
	  }
}
else if($alloID == 'LB')
{	   
	  $sql = "select  COALESCE(sum(dblQty),0) as dblQty,ms.strName,st.strMainStoresID 
from stocktransactions_liability  st inner join mainstores ms on
st.strMainStoresID = ms.strMainID 
where intMatDetailId='$matDetailId' and strColor='$color' and strSize='$size'
group by st.strMainStoresID ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$pendingLQty = getPendingLiabilityAllocationQty($row["strMainStoresID"],$matDetailId,$color,$size);
	  ?>
      <tr bgcolor="#FFFFFF">
        <td class="normalfnt" height="20"><?php echo $row["strName"]; ?></td>
        <td class="normalfntR"><?php echo $row["dblQty"]; ?></td>
          <td class="normalfntR"><?php echo $pendingLQty; ?></td>
      </tr>
      <?php 
	}
}
?>
    </table></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getPendingBulkAlloQty($mainstore,$matDetailID,$color,$size)
{
	global $db;
	$sql = " select COALESCE(sum(dblQty),0) as dblQty  
		from commonstock_bulkdetails BD inner join commonstock_bulkheader BH on
		BD.intTransferNo = BH.intTransferNo and 
		BD.intTransferYear = BH.intTransferYear 
		where intMatDetailId='$matDetailID'  and strColor='$color' and strSize='$size' and BH.intStatus=0 and BH.intMainStoresID ='$mainstore'"; 
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];	   
}
function getPendingLeftOverAllocationQty($mainstore,$matDetailID,$color,$size)
{
	global $db;
	$sql = "select COALESCE(sum(LD.dblQty),0) as dblQty from commonstock_leftoverdetails LD inner join  commonstock_leftoverheader LH on
LH.intTransferNo = LD.intTransferNo and LD.intTransferYear = LH.intTransferYear 
where LH.intStatus=0  and LD.intMatDetailId='$matDetailID' and LD.strColor='$color' and LD.strSize='$size' and LH.intMainStoresId = '$mainstore' ";
	//echo $sql;
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}
function getPendingLiabilityAllocationQty($mainstore,$matDetailID,$color,$size)
{
	global $db;
	$sql = "select COALESCE(sum(LD.dblQty),0) as dblQty from commonstock_liabilitydetails LD inner join  commonstock_liabilityheader LH on
LH.intTransferNo = LD.intTransferNo and LD.intTransferYear = LH.intTransferYear 
where LH.intStatus=0  and LD.intMatDetailId='$matDetailID' and LD.strColor='$color' and LD.strSize='$size' and LH.intMainStoresId = '$mainstore' ";
	//echo $sql;
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}
?>
</body>
</html>
