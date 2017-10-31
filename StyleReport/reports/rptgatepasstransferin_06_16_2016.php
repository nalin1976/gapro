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
	$intStatus 			= $_GET["status"];
	$txtMatItem 		= $_GET["txtMatItem"];
	if($intCompany != '')
		$report_companyId =$intCompany;
	else
		$report_companyId =$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro Web - Style Reports :: Gate Pass TransferIn Details </title>
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
    <td colspan="3"><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo "GATE PASS TRANSFER IN DETAILS"?></td>
  </tr>
  <tr>
   <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) echo "(CONFIRMED LIST)"; 
		elseif ($intStatus==0) echo "(PENDING LIST)";					 
		elseif ($intStatus==10) echo "(CANCELED LIST)"; 				
	?>
	</td>
  </tr> 
  	<?php 		
$sql = "SELECT distinct GH.intTransferInNo,
GH.intTINYear,
GH.intGatePassNo,
GH.intGPYear,
GH.dtmDate
from gategasstransferinheader GH
inner join gategasstransferindetails GD on GH.intTransferInNo=GD.intTransferInNo and GH.intTINYear=GD.intTINYear 
inner join specification SP on SP.intStyleId=GD.intStyleId 
inner join matitemlist MIL on GD.intMatDetailId=MIL.intItemSerial
INNER JOIN orders O ON  O.intStyleId=GD.intStyleId
where GH.intStatus=$intStatus";			

			if($noFrom!=""){
				$sql .= " and GH.intTransferInNo >= '$noFrom'";
			}
			if($noTo!=""){
				$sql .= " and GH.intTransferInNo <= '$noTo'";
			}			
						
			if ($strStyleNo!= "")
			{ 
				$sql .= " and GD.intStyleId  ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql .=  " and GD.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intCompany!="")
			{
			 	$sql .= " AND GH.intCompanyId=$intCompany ";
			}
			
			if ($intMeterial!= "")
			{					
				$sql = $sql." and MIL.intMainCatID=$intMeterial ";	
			}

			if ($intCategory!= "")
			{
				$sql = $sql." and MIL.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql = $sql." and MIL.intItemSerial=$intDescription " ;
			}
			if ($txtMatItem!= "")
			{				
				$sql .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intBuyer!="")
			{			
				$sql = $sql." and O.intBuyerID=$intBuyer";				
			}
			
			if($dtmDateFrom!="")
			{					
				$sql = $sql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if($dtmDateTo!="")
			{					
			$sql = $sql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			
			$sql = $sql. " order by GH.intTransferInNo";			
			//echo $sql;
			$result = $db->RunQuery($sql);
			$rowCount	= mysql_num_rows($result);
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="142" class="mainHeading4" >GP Trans In Number : </td>
  	    <td width="99" class="mainHeading4" ><?php echo $rowdata["intTINYear"].'/'.$rowdata["intTransferInNo"];  ?></td>
  	    <td width="760" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="bcgl1"><tr><td>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr height="25">
            <td  width="134" height="18" class="normalfnth2B">Gate Pass No </td>
			<td width="10" class="normalfnt">:</td>
			<td width="322" class="normalfnt"><?php echo $rowdata["intGPYear"].'/'.$rowdata["intGatePassNo"];  ?></td>
			<td colspan="2" class="normalfnt">&nbsp;</td>
			<td width="163" class="normalfnth2B">&nbsp;</td>
			<td width="65" class="normalfnth2B">Date : </td>
			<td width="241" class="normalfnt"><?php echo $rowdata["dtmDate"]; ?></td>
          </tr>          
        </table>
		</td>
  	</tr>	
	<tr>
    	<td colspan="3"><table width="1003" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="150" bgcolor="#CCCCCC" class="normalfntBtab">Style ID </td>
			 <td width="20" bgcolor="#CCCCCC" class="normalfntBtab">SCNo</td>
             <td width="100" bgcolor="#CCCCCC" class="normalfntBtab">Buyer PONo</td>
             <td width="20" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="277" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="50" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>															
          </tr>
<?php 
$detailSql="SELECT    
GD.intStyleId,
GD.strBuyerPONO,
GD.intMatDetailId,
GD.strColor,
GD.strSize,
MIL.strItemDescription,
MIL.strUnit,
GD.dblQty,
SP.intSRNO,
MMC.strID,
o.strStyle
FROM gategasstransferinheader GH
INNER JOIN gategasstransferindetails GD ON GH.intTransferInNo=GD.intTransferInNo AND GH.intTINYear=GD.intTINYear
INNER JOIN specification SP on SP.intStyleId=GD.intStyleId 
INNER JOIN matitemlist MIL ON GD.intMatDetailId=MIL.intItemSerial 
INNER JOIN matmaincategory MMC ON MMC.intID=MIL.intMainCatID 
inner join orders o on o.intStyleId = SP.intStyleId
AND GH.intTransferInNo =".$rowdata["intTransferInNo"]." AND GH.intTINYear =".$rowdata["intTINYear"]."";

			
			if ($strStyleNo!= "")
			{ 
				$detailSql .= " and GD.intStyleId  ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$detailSql .= " and GD.strBuyerPONO='$strBPo' " ;
			}		
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND MIL.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND MIL.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND MIL.intItemSerial=$intDescription ";						
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intCompany!="")
			{
			 	$detailSql .= " AND GH.intCompanyId=$intCompany ";
			}
			
			$detailSql = $detailSql. " GROUP BY GD.intMatDetailId,GD.strColor, GD.strSize, MIL.strItemDescription, MIL.strUnit,GD.intGrnNo";		
			$detailResult = $db->RunQuery($detailSql);
		
			while ($details=mysql_fetch_array($detailResult))
			{
				
		  	?>
          <tr>
            <td class="normalfntTAB"><?php echo $details["strStyle"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["intSRNO"]; ?></td>
	        <td class="normalfntMidTAB"><?php echo $details["strBuyerPONO"]; ?></td>
	        <td class="normalfntTAB"><?php echo $details["strID"]; ?></td>
            <td class="normalfntTAB"><?php echo $details["strItemDescription"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntMidTAB"><?php
			$sqlstock="select strUnit from stocktransactions 
			where intDocumentNo='".$rowdata["intTransferInNo"]."'
			and intDocumentYear='".$rowdata["intTINYear"]."'
			and intStyleId='".$details["intStyleId"]."'
			and strBuyerPoNo ='".$details["strBuyerPONO"]."'
			and intMatDetailId ='".$details["intMatDetailId"]."'
			and strColor ='".$details["strColor"]."'
			and strSize ='".$details["strSize"]."'";
			$result_stock = $db->RunQuery($sqlstock);
			$row_sqlstock = mysql_fetch_array($result_stock);
			 echo $row_sqlstock["strUnit"]; ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>                
          </tr>
		  
		  <?php 		  
		  	}
		  ?>		  
        </table></td>
  	</tr>
	</table>
	<tr><td>&nbsp;</td></tr>
<?php
	}
?>

</td></tr></table>
<script type="text/javascript">

var rowCount =<?php echo $rowCount?>;
if(rowCount<=0){
	alert("Sorry!\nNo Records found in selected options.")
	window.close();
}
</script>
</body>
</html>
