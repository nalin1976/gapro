<?php
	session_start();
	include "../../Connector.php" ;	
	$backwardseperator 	= "../../";
	$strStyleNo			= $_GET["strStyleNo"];
	$strBPo				= $_GET["strBPo"];
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$intBuyer 	  		= $_GET["intBuyer"];
	$dtmDateFrom		= $_GET["dtmDateFrom"];
	$dtmDateTo 	  		= $_GET["dtmDateTo"];
	$noTo 	  			= $_GET["noTo"];
	$noFrom 	  		= $_GET["noFrom"];
	$intCompany     	= $_GET["intCompany"];
	$txtMatItem			= $_GET["txtMatItem"];
	$report_companyId =$_SESSION["FactoryID"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Style Reports :: Purchase Order</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {font-size: 12pt}
.style2 {font-size: 14pt}
-->
</style>
</head>


<body>
<table width="1000" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1000" colspan="3"><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
  <?php $intStatus		=$_GET["status"]; ?>
     <td colspan="5" class="normalfnt2bldBLACKmid">INTER JOB TRANSFER DETAILS</td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==0) echo "(SAVED LIST)"; 
		elseif ($intStatus==1) echo "(APPROVED LIST)";					 
		elseif ($intStatus==2) echo "(ATHORISED LIST)";
		elseif ($intStatus==3) echo "(CONFIRMED LIST)";
		elseif ($intStatus==10) echo "(CANCELED LIST)";		 		
		
	?>
</td>
  </tr>
 	
    <tr>	
    	<td colspan="3">
		<table width="1000" border="0" cellpadding="0" cellspacing="0" >
	

	<tr>
    	<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
<thead>          
		  <tr height="25" >
            <td width="1%" bgcolor="#CCCCCC" class="normalfntBtab"  >&nbsp;</td>          
            <td width="6%" bgcolor="#CCCCCC" class="normalfntBtab"  >Buyer PONo</td>            
            <td width="2%" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="20%" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="6%" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
			<td width="6%" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="5%" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="5%" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="5%" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
			<td width="5%"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
          </tr>
</thead>
<?php 
$detailSql="select IT.intTransferId,
IT.intTransferYear,
IT.intStyleIdFrom,
(select intSRNO from specification where specification.intStyleId=IT.intStyleIdFrom)AS fromScNo,
IT.intStyleIdTo,
(select intSRNO from specification where specification.intStyleId=IT.intStyleIdTo)AS toScNo,
dtmTransferDate,
strBuyerPoNo,
MIL.strItemDescription,
strColor,
strSize,
ITD.strUnit,
ITD.dblQty,
ITD.dblUnitPrice,
(ITD.dblQty*ITD.dblUnitPrice)AS amount,
MMC.strDescription
from itemtransfer IT
INNER JOIN itemtransferdetails ITD ON IT.intTransferId=ITD.intTransferId and IT.intTransferYear=ITD.intTransferYear
INNER JOIN matitemlist MIL ON MIL.intItemSerial=ITD.intMatDetailId
INNER JOIN orders O ON O.intStyleId=IT.intStyleIdTo
INNER JOIN matmaincategory MMC ON MMC.intID=MIL.intMainCatID
WHERE IT.intStatus=$intStatus ";
			
			if ($noFrom!="")
			{
			 	$detailSql .= " AND IT.intTransferId>=$noFrom ";
			}
			if ($noTo!="")
			{
				$detailSql .= " AND IT.intTransferId<=$noTo ";
			}
			
			if ($intCompany!="")
			{
			 	$detailSql .= " AND IT.intFactoryCode=$intCompany ";
			}
			
			if ($strStyleNo!= "")
			{ 
				$detailSql .= " and IT.intStyleIdTo ='$strStyleNo' ";						
			}
			
			if ($strBPo	!= "")
			{
				$detailSql .= " and ITD.strBuyerPoNo='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " and MIL.intMainCatID=$intMeterial ";	
			}			

			if ($intCategory!= "")
			{				
				$detailSql .= " and MIL.intSubCatID=$intCategory " ;
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intDescription!= "")
			{
				$detailSql .= " and ITD.intMatDetailId=$intDescription ";						
			}				

			if ($intBuyer!="")
			{
				$detailSql .= " and orders.intBuyerID=$intBuyer";				
			}
			
			if ($dtmDateFrom!="")
			{						
				$detailSql .= " and DATE_FORMAT(IT.dtmTransferDate,'%Y/%m/%d')>= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{						
				$detailSql .= " AND DATE_FORMAT(IT.dtmTransferDate,'%Y/%m/%d')<= DATE_FORMAT('$dtmDateTo','%Y/%m/%d') ";
			}				
			
		  	$detailResult = $db->RunQuery($detailSql);
			$checkNoAndYear="";
			$rowCount = mysql_num_rows($detailResult);
			while ($details=mysql_fetch_array($detailResult))
			{			
		  	?>
<?php
$noAndYear = $details["intTransferYear"].'/'.$details["intTransferId"];
 if($noAndYear != $checkNoAndYear){
$checkNoAndYear = $noAndYear;
 $noLoop =0;
 
?>
 <tr bgcolor="#E4E4E4" height="20">	
	<td colspan="12" class="normalfnt" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="14%"  class="normalfnt">Inter Job Trans In No</td>
        <td width="1%">:</td>
        <td width="30%" class="normalfnt"><?php echo $noAndYear;?></td>
        <td width="9%" class="normalfnt">From Order No </td>
        <td width="1%">:</td>
        <td width="16%" class="normalfnt"><?php echo getStyleName($details["intStyleIdFrom"]);?></td>
        <td width="6%" class="normalfnt">From SC  </td>
        <td width="1%">:</td>
        <td width="20%" class="normalfnt"><?php echo $details["fromScNo"]?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td  class="normalfnt">Create Date </td>
        <td >:</td>
        <td  class="normalfnt"><?php echo $details["dtmTransferDate"];?></td>
        <td class="normalfnt">To Order No </td>
        <td>:</td>
        <td class="normalfnt"><?php echo getStyleName($details["intStyleIdTo"]);?></td>
        <td class="normalfnt">To Sc </td>
        <td>:</td>
        <td class="normalfnt"><?php echo $details["toScNo"]?></td>
      </tr>
    </table></td>
	</tr>
<?php
}
?>
		  
          <tr  onmouseover="this.style.background ='#ECECFF';" onmouseout="this.style.background=''" height="20">	
			<td class="normalfntTAB" style="text-align:center"><?php echo ++$noLoop ?></td>
			<td class="normalfntMidTAB"><?php echo $details["strBuyerPoNo"]; ?></td>
	        <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo $details["strItemDescription"].' - '.$details["strRemarks"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strUnit"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblUnitPrice"],4)); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["amount"],4)); ?></td>
          </tr>
		  
		  <?php 		  
		  	}
		  ?>		  
        </table></td>
  	</tr>
	</table>
	<tr><td width="1298">&nbsp;</td></tr>
<?php
//}
//}
?>

</td></tr></table>
<?php 

function getStyleName($StyleID)
{
	$SQL = "Select strOrderNo From orders Where intStyleId='$StyleID'";
			 
			 global $db;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$Stylename = $row["strOrderNo"];
			}
		return $Stylename;	 
			 
}
?>
<script type="text/javascript">
function closeWindow() {
//window.open('','_parent','');
window.close();
}
var rowCount =<?php echo $rowCount?>;
if(rowCount<=0){
	alert("Sorry!\nNo Records found in selected options.")
	window.close();
}
</script>
</body>
</html>
