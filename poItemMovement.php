<?php
include "Connector.php";
	$companyId  =$_SESSION["FactoryID"];
	$styleId = $_GET["styleId"];
	$matDetailId = $_GET["matDetailId"];
	$itemDesc = $_GET["itemDesc"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$buyerPO = $_GET["buyerPO"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="700" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td width="700"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="97%" class="mainHeading" height="22">Item Movement -<?php echo $itemDesc; ?></td>
        <td width="3%" class="mainHeading" style="text-align:right"><img src="images/cross.png" width="17" height="17" onClick="closePopupBox(20);"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div style="overflow:scroll; width:100%; height:400px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <?php 
  $sql = "select ph.intPONo,ph.intYear,ph.intStatus,s.strTitle as supplier,c.strTitle,pd.dblQty,dblPending,dblAdditionalQty
from purchaseorderheader ph inner join purchaseorderdetails pd on
ph.intPONo = pd.intPoNo and ph.intYear= pd.intYear
inner join suppliers s on s.strSupplierID = ph.strSupplierID
inner join currencytypes c on c.intCurID = ph.strCurrency
where pd.intStyleId='$styleId' and pd.intMatDetailID='$matDetailId' and pd.strColor='$color' and strSize='$size' and ph.intStatus =10 and pd.strBuyerPONO = '$buyerPO'";

$result=$db->RunQuery($sql);
$poCount = mysql_num_rows($result);
if($poCount>0)
{
?>
      <tr>
        <td class="normalfnt2bld" height="22">PO Details</td>
      </tr>
       <tr>
        <td ><table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCFF">
          <tr class="mainHeading4">
           <td width="12%" height="20">PO No</td>
            <td width="33%">Supplier</td>
            <td width="11%">Currency</td>
            <td width="11%">Status</td>
            <td width="9%"> Qty</td>
          </tr>
          <?php 
		  while($row = mysql_fetch_array($result))
			{
				$postatus = $row["intStatus"];
				switch($postatus)
				{
					case 0:
					{
						$strStatus = 'Pending Cancel';
						break;
					}
					case 1:
					{
						$strStatus = 'Pending';
						break;
					}
					case 2:
					{
						$strStatus = 'First Approved';
						break;
					}
					case 5:
					{
						$strStatus = 'Send to Approval';
						break;
					}
					case 10:
					{
						$strStatus = 'Confirmed';
						break;
					}
					case 11:
					{
						$strStatus = 'Cancel';
						break;
					}
				}
		  ?>
          <tr bgcolor="#FFFFFF">
    <td class="normalfnt" height="20"><a href="#" onClick="openPOReport(<?php echo $row["intYear"].','.$row["intPONo"]; ?>)" style="text-decoration:underline"><?php echo $row["intYear"].'/'.$row["intPONo"]; ?></a></td>
    <td class="normalfnt"><?php echo $row["supplier"]; ?></td>
    <td class="normalfnt"><?php echo $row["strTitle"]; ?></td>
    <td class="normalfnt"><?php echo $strStatus; ?></td>
    <td class="normalfntRite"><?php echo $row["dblQty"]; ?></td>  
  </tr>
  <?php 
  	}
  ?>
        </table></td>
      </tr>
       
 <?php
}  ?> 

	<?php 
	$sql_bulk = "select cbh.intTransferNo, cbh.intTransferYear,sum(cbd.dblQty) as dblQty,cbh.intStatus,date(cbh.dtmDate) as AlloDate,
ms.strName as store
from commonstock_bulkdetails cbd inner join commonstock_bulkheader cbh on
cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear= cbd.intTransferYear
inner join mainstores ms on ms.strMainID = cbh.intMainStoresID
where  cbh.intStatus in (1,0) and  cbd.intMatDetailId='$matDetailId' and cbh.intToStyleId='$styleId' and cbd.strColor='$color' and cbd.strSize = '$size' and cbh.strToBuyerPoNo='$buyerPO'
group by cbh.intTransferNo, cbh.intTransferYear,ms.strMainID 
 ";

	$result_bulk=$db->RunQuery($sql_bulk);
	$bulk_rowCnt = mysql_num_rows($result_bulk);
	
		if($bulk_rowCnt>0)
		{
	?> 
    <tr>
        <td>&nbsp;</td>
      </tr>   
      <tr>
        <td class="normalfnt2bld" height="22">Bulk Allocation Details</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF">
          <tr  class="mainHeading4">
          <td width="27%" height="20">Bulk Allocation No</td>
          <td width="16%">Allocated Date</td>
          <td width="20%">Main Store</td>
          <td width="17%">Status</td>
          <td width="20%">Allocated Qty</td>
        </tr>
         <?php 
		  while($rowB = mysql_fetch_array($result_bulk))
		  {
			$status = $rowB["intStatus"];
			switch($status)
			{
				case 0:
				{
					$strStatus = 'Pending';
					break;
				}
				case 1:
				{
					$strStatus = 'Confirmed';
					break;
				}
				case 10:
				{
					$strStatus = 'Cancel';
					break;
				}
			}
	  ?>
          <tr bgcolor="#FFFFFF">
        <td class="normalfnt" height="20"><?php echo $rowB["intTransferYear"].'/'.$rowB["intTransferNo"]; ?></td>
        <td class="normalfnt"><?php echo $rowB["AlloDate"]; ?></td>
        <td class="normalfnt"><?php echo $rowB["store"]; ?></td>
        <td class="normalfnt"><?php echo $strStatus; ?></td>
        <td class="normalfntRite"><?php echo $rowB["dblQty"]; ?></td>   
      </tr>
          <?php 
		  }
		  ?>
        </table></td>
      </tr>
      <?php 
	  }
	  ?>
      
      <?php 
	  $sql_left = "select clh.intTransferNo,clh.intTransferYear,sum(cld.dblQty) as dblQty,clh.intStatus,date(clh.dtmDate) as AlloDate,
ms.strName as store
from commonstock_leftoverheader clh inner join commonstock_leftoverdetails cld on
clh.intTransferNo = cld.intTransferNo and clh.intTransferYear = cld.intTransferYear
inner join mainstores ms on ms.strMainID = clh.intMainStoresId
where clh.intStatus in (0,1)  and clh.intToStyleId='$styleId' and cld.intMatDetailId ='$matDetailId' and cld.strColor='$color' and cld.strSize ='$size' and clh.strToBuyerPoNo = '$buyerPO' 
group by clh.intTransferNo,clh.intTransferYear,clh.intMainStoresId";
$result_left=$db->RunQuery($sql_left);
$left_rowCnt = mysql_num_rows($result_left);

	if($left_rowCnt>0)
	{
	  ?>
       <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt2bld" height="22">Leftover Allocation Details</td>
      </tr>
       <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF">
          <tr  class="mainHeading4">
          <td width="27%" height="20">Leftover Allocation No</td>
          <td width="16%">Allocated Date</td>
          <td width="20%">Main Store</td>
          <td width="17%">Status</td>
          <td width="20%">Allocated Qty</td>
        </tr>
        <?php 
		 while($rowL = mysql_fetch_array($result_left))
  		{
			$status = $rowL["intStatus"];
			switch($status)
			{
				case 0:
				{
					$strStatus = 'Pending';
					break;
				}
				case 1:
				{
					$strStatus = 'Confirmed';
					break;
				}
				case 10:
				{
					$strStatus = 'Cancel';
					break;
				}
			}
		?>
          <tr bgcolor="#FFFFFF">
        <td class="normalfnt" height="20"><?php echo $rowL["intTransferYear"].'/'.$rowL["intTransferNo"]; ?></td>
        <td class="normalfnt"><?php echo $rowL["AlloDate"] ?></td>
        <td class="normalfnt"><?php echo $rowL["store"] ?></td>
        <td class="normalfnt"><?php echo $strStatus; ?></td>
        <td class="normalfntRite"><?php echo $rowL["dblQty"]; ?></td>  
      </tr>
          <?php 
		  }
		  ?>
        </table></td>
      </tr>
      <?php 
	 }
	  ?>
      
     <?php 
	$sql_IJT = "select ih.intTransferId, ih.intTransferYear,id.dblQty,date(ih.dtmTransferDate) as tranferDate, o.strOrderNo,ih.intStatus
from itemtransfer ih inner join itemtransferdetails id on
ih.intTransferId = id.intTransferId and ih.intTransferYear = id.intTransferYear
inner join orders o on o.intStyleId = ih.intStyleIdTo
where ih.intStatus=3  and ih.intStyleIdTo='$styleId' and ih.strToBuyerPoNo='$buyerPO' and id.intMatDetailId ='$matDetailId' and id.strColor='$color' and id.strSize = '$size' ";
//echo $sql_IJT;
$result_IJT=$db->RunQuery($sql_IJT);
$IJT_rowCnt = mysql_num_rows($result_IJT);
	if($IJT_rowCnt>0)
	{
	 ?>
      <tr>
        <td>&nbsp;</td>
      </tr> 
      <tr>
        <td class="normalfnt2bld" height="22">Interjob Tranfer In Details</td>
      </tr>
      <tr>
        <td><table width="100%" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF">
          <tr class="mainHeading4">
            <td width="23%">Transfer In No</td>
             <td width="16%">Transfer Date</td>
            <td width="27%">From Order No</td>
            <td width="17%">Status</td>
            <td width="17%">Transfer In Qty</td>
          </tr>
          <?php 
		 while($rowI = mysql_fetch_array($result_IJT))
  		{
			$status = $rowI["intStatus"];
				switch($status)
				{
					case 0:
					{
						$strStatus = 'Pending';
						break;
					}
					case 3:
					{
						$strStatus = 'Confirmed';
						break;
					}
					case 10:
					{
						$strStatus = 'Cancel';
						break;
					}
				}
		  ?>
          <tr bgcolor="#FFFFFF">
            <td class="normalfnt"><?php echo $rowI["intTransferYear"].'/'.$rowI["intTransferId"]; ?></td>
            <td class="normalfnt"><?php echo $rowI["tranferDate"]; ?></td>
            <td class="normalfnt"><?php echo $rowI["strOrderNo"]; ?></td>
            <td class="normalfnt"><?php echo $strStatus; ?></td>
            <td class="normalfntRite"><?php echo $rowI["dblQty"]; ?></td>
          </tr>
          <?php 
		 } 
		  ?>
        </table></td>
      </tr>
      <?php 
	  }
	  ?>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php 
	  $sql_liability = "select clh.intTransferNo,clh.intTransferYear,sum(cld.dblQty) as dblQty,clh.intStatus,date(clh.dtmDate) as AlloDate,
ms.strName as store
from commonstock_liabilityheader clh inner join commonstock_liabilitydetails cld on
clh.intTransferNo = cld.intTransferNo and clh.intTransferYear = cld.intTransferYear
inner join mainstores ms on ms.strMainID = clh.intMainStoresId
where clh.intStatus in (0,1)  and clh.intToStyleId='$styleId' and cld.intMatDetailId ='$matDetailId' and cld.strColor='$color' and cld.strSize ='$size' and clh.strToBuyerPoNo = '$buyerPO' 
group by clh.intTransferNo,clh.intTransferYear,clh.intMainStoresId";
$result_liability=$db->RunQuery($sql_liability);
$lb_rowCnt = mysql_num_rows($result_liability);

	if($lb_rowCnt>0)
	{
		 
	  ?>
      <tr>
        <td class="normalfnt2bld" height="22">Liability Details</td>
      </tr>
     
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF">
          <tr class="mainHeading4">
            <td height="20">Liability Allocation No</td>
            <td>Allocation Date</td>
            <td>Main Store</td>
            <td>Status</td>
            <td>Allocated Qty</td>
          </tr>
          <?php 
		  while($rowL = mysql_fetch_array($result_liability))
  		  {
				$status = $rowL["intStatus"];
				switch($status)
				{
					case 0:
					{
						$strStatus = 'Pending';
						break;
					}
					case 1:
					{
						$strStatus = 'Confirmed';
						break;
					}
					case 10:
					{
						$strStatus = 'Cancel';
						break;
					}
				}
		  ?>
          <tr bgcolor="#FFFFFF">
        <td class="normalfnt" height="20"><?php echo $rowL["intTransferYear"].'/'.$rowL["intTransferNo"]; ?></td>
        <td class="normalfnt"><?php echo $rowL["AlloDate"] ?></td>
        <td class="normalfnt"><?php echo $rowL["store"] ?></td>
        <td class="normalfnt"><?php echo $strStatus; ?></td>
        <td class="normalfntRite"><?php echo $rowL["dblQty"]; ?></td>  
      </tr>
          <?php 
		  }
		  ?>
        </table></td>
      </tr>
      <?php 
	 } 
	  ?> 
    </table></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
