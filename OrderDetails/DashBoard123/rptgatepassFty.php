<?php
	session_start();
	include "../Connector.php" ;
	$backwardseperator 	= "../";	
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
	$txtMatItem			= $_GET["txtMatItem"];
	if($intCompany != '')
		$report_companyId =$intCompany;
	else
		$report_companyId =$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Style Reports :: Gate Pass Details</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

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
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo "GATE PASS DETAILS"?></td>
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
$sql = "SELECT distinct GH.intGatePassNo,
GH.intGPYear,
GH.dtmDate,
GH.strAttention,
if(strCategory='I',(select distinct strName from mainstores MS where MS.strMainID=GH.strTo),
(select distinct strName from subcontractors  where  strSubContractorID=GH.strTo))AS destination
from gatepass GH
inner join gatepassdetails GD on GH.intGatePassNo=GD.intGatePassNo and GH.intGPYear=GD.intGPYear 
inner join specification SP on SP.intStyleId=GD.intStyleId 
inner join matitemlist MIL on GD.intMatDetailID=MIL.intItemSerial
INNER JOIN orders O ON  O.intStyleId=GD.intStyleId
where GH.intStatus=$intStatus AND
GH.intCompany = 17 AND 
GH.strTo NOT IN (21, 24) ";			

			if($noFrom!=""){
				$sql .= " and GH.intGatePassNo >= '$noFrom'";
			}
			if($noTo!=""){
				$sql .= " and GH.intGatePassNo <= '$noTo'";
			}			
			/*if ($intCompany!="")
			{
				$sql = $sql." and GH.intCompany=$intCompany ";
			}*/
						
			if ($strStyleNo!= "")
			{ 
				$sql = $sql." and GD.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql = $sql." and GD.strBuyerPONO='$strBPo' " ;
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

			if ($intBuyer!="")
			{			
				$sql = $sql." and O.intBuyerID=$intBuyer";				
			}
			if ($txtMatItem!= "")
			{				
				$sql .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
			}	
			if($dtmDateFrom!="")
			{					
				$sql = $sql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if($dtmDateTo!="")
			{					
			$sql = $sql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			
			$sql = $sql. " order by GH.intGatePassNo";			
			
			$result = $db->RunQuery($sql);
			
			//echo $sql;
			$rowCount	= mysql_num_rows($result);
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="142" nowrap="nowrap" class="mainHeading4" >Gate Pass Number : </td>
  	    <td width="59" class="mainHeading4" ><?php echo $rowdata["intGPYear"].'/'.$rowdata["intGatePassNo"];  ?></td>
  	    <td width="798" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="tableBorder"><tr><td>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr height="25">
            <td  width="121" height="18" class="normalfnth2B">Destination</td>
			<td width="10" class="normalfnt">:</td>
			<td width="334" class="normalfnt">
<?php 
$xml = simplexml_load_file('../config.xml');
$AllowSubContractorToGatePass = $xml->styleInventory->AllowSubContractorToGatePass;
if($AllowSubContractorToGatePass=="true"){
$sql="select strSubContractorID,strName from subcontractors  where  strSubContractorID='$destinationTo'";

	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		echo $row["strName"];

	}
}
else{
echo $rowdata["destination"];
}
?></td>
			<td colspan="2" class="normalfnt">&nbsp;</td>
			<td width="106" class="normalfnth2B">ATTENTION BY</td>
			<td width="11" class="normalfnth2B">:</td>
			<td width="241" class="normalfnt"><?php echo $rowdata["strAttention"]; ?></td>
          </tr>
          <tr height="25">
            <td height="18" class="normalfnth2B">Dispatched</td>
            <td class="normalfnt">:</td>
            <td class="normalfnth2B"><span class="normalfnt">		<?PHP
/*$sqlstore="SELECT DISTINCT strMainID,strName FROM gatepass 
INNER JOIN mainstores ON gatepass.intCompany=mainstores.intCompanyId 
WHERE intGatePassNo=".$rowdata["intGatePassNo"]." AND intGPYear=".$rowdata["intGPYear"]."";	*/
if($intStatus == 0)
	$tbl = 'stocktransactions_temp';
else
	$tbl = 'stocktransactions';
$sqlstore="SELECT DISTINCT strMainID,strName FROM $tbl ST
INNER JOIN mainstores MS ON ST.strMainStoresID=MS.strMainID 
WHERE intDocumentNo=".$rowdata["intGatePassNo"]." AND intDocumentYear=".$rowdata["intGPYear"]." and strType='SGatePass'";
$result1=$db->RunQuery($sqlstore);
while($row1=mysql_fetch_array($result1))
{
	echo $row1["strName"];
}
		?></span></td>
            <td colspan="2" class="normalfnt">&nbsp;</td>
            <td class="normalfnth2B">Date &amp; Time </td>
            <td class="normalfnth2B">:</td>
            <td class="normalfnt"><?php  echo $rowdata["dtmDate"];?></td>
          </tr>          
        </table>
		<p class="head2BLCK"></p></td>
  	</tr>	
	<tr>
    	<td colspan="3"><table width="1003" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="150" bgcolor="#CCCCCC" class="normalfntBtab">Style No</td>
            <td width="150" bgcolor="#CCCCCC" class="normalfntBtab">Order No </td>
			 <td width="20" bgcolor="#CCCCCC" class="normalfntBtab">SCNo</td>
             <td width="100" bgcolor="#CCCCCC" class="normalfntBtab">Buyer PONo</td>
             <td width="20" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="277" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="50" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="20" bgcolor="#CCCCCC" class="normalfntBtab">RTN</td>			
			<td width="70" bgcolor="#CCCCCC" class="normalfntBtab">GP Trans Qty</td>															
          </tr>
<?php 
$detailSql="SELECT distinct GH.intGatePassNo,
GH.intGPYear,  
GD.intStyleId,
o.strStyle,
GD.strBuyerPONO,
GD.intMatDetailID,
GD.strColor,
GD.strSize,
SP.intSRNO,
MIL.strItemDescription,
specificationdetails.strUnit,
GD.dblQty,
GD.intRTN,
(GD.dblQty-GD.dblBalQty)AS transInQty,
o.strOrderNo,
MMC.strID
FROM gatepass GH
INNER JOIN gatepassdetails GD ON GH.intGatePassNo=GD.intGatePassNo AND GH.intGPYear=GD.intGPYear
INNER JOIN specification SP ON GD.intStyleId=SP.intStyleId 
INNER JOIN matitemlist MIL ON GD.intMatDetailID=MIL.intItemSerial 
inner join matmaincategory MMC on MIL.intMainCatID=MMC.intID
inner join orders o on o.intStyleId = GD.intStyleId
INNER JOIN specificationdetails ON GD.intStyleId = specificationdetails.intStyleId AND GD.intMatDetailId = specificationdetails.strMatDetailID
AND GH.intGatePassNo =".$rowdata["intGatePassNo"]." AND GH.intGPYear =".$rowdata["intGPYear"]."";

			
			if ($strStyleNo!= "")
			{ 
				$detailSql .= " and GD.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$detailSql .= " AND GD.strBuyerPONO='$strBPo' " ;
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
			$detailResult = $db->RunQuery($detailSql);
		
			while ($details=mysql_fetch_array($detailResult))
			{
				
		  	?>
          <tr>
          	<td class="normalfntTAB"><?php echo $details["strStyle"]; ?></td>
            <td class="normalfntTAB"><?php echo $details["strOrderNo"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["intSRNO"]; ?></td>
	        <td class="normalfntMidTAB"><?php echo $details["strBuyerPONO"]; ?></td>
	        <td class="normalfntTAB"><?php echo $details["strID"];//echo substr($details["strDescription"],0,3); ?></td>
            <td class="normalfntTAB"><?php echo $details["strItemDescription"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntMidTAB"><?php
			$sqlstock="select strUnit from stocktransactions 
			where intDocumentNo='".$rowdata["intGatePassNo"]."'
			and intDocumentYear='".$rowdata["intGPYear"]."'
			and intStyleId='".$details["intStyleId"]."'
			and strBuyerPoNo ='".$details["strBuyerPONO"]."'
			and intMatDetailId ='".$details["intMatDetailID"]."'
			and strColor ='".$details["strColor"]."'
			and strSize ='".$details["strSize"]."'";
			$result_stock = $db->RunQuery($sqlstock);
			$row_sqlstock = mysql_fetch_array($result_stock);
			 echo $row_sqlstock["strUnit"]; ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>
            <td class="normalfntMidTAB"><?php echo $details["intRTN"]; ?></td>           
            <td class="normalfntRiteTAB"><?php echo round(transInQty,2); ?></td>          
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
