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
	$RequestType 		= $_GET["RequestType"];
	$report_companyId 	= $_SESSION["FactoryID"];
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
<table width="1302" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1298" colspan="3"><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
  <?php $intStatus		=$_GET["status"]; ?>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("BULK PURCHASE ORDER REGISTER.")?></td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) $listType="(CONFIRMED LIST)"; 
		elseif ($intStatus==0) $listType="(PENDING LIST)";					 
		else $listType="(CANCELED LIST)"; 		
		echo  $listType;
	?>
	</td>
  </tr>
  <tr>	
    <td colspan="3">
		<table width="1296" border="0" cellpadding="0" cellspacing="0" >
			<tr>
 				<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
						<thead>          
			  				<tr height="25" >
								<td width="2%" bgcolor="#CCCCCC" class="normalfntBtab"  >&nbsp;</td>
								<td width="2%" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
								<td width="320" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
								<td width="130" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
								<td width="130" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
								<td width="60" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
								<td width="68" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
								<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
								<td width="87"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
			 				</tr>
						</thead>
<?php 
$detailSql="SELECT
BPH.dtDate,
MIL.strItemDescription,
BPD.strColor,
BPD.strSize,
BPD.strUnit,
BPD.dblQty,
BPD.dblUnitPrice,
(BPD.dblQty*BPD.dblUnitPrice) amount,
BPD.intBulkPoNo,
BPD.intYear,
BPH.strCurrency,
suppliers.strTitle
FROM
bulkpurchaseorderdetails BPD
Inner Join bulkpurchaseorderheader BPH ON BPH.intBulkPoNo = BPD.intBulkPoNo AND BPH.intYear = BPD.intYear
Inner Join matitemlist MIL ON BPD.intMatDetailId = MIL.intItemSerial
Inner Join suppliers ON suppliers.strSupplierID = BPH.strSupplierID
WHERE BPH.intStatus =   $intStatus ";
			
			if ($noFrom!="")
			 	$detailSql .= " AND BPH.intBulkPoNo >=$noFrom ";
			if ($noTo!="")
				$detailSql .= " AND BPH.intBulkPoNo <=$noTo ";			
			if ($intCompany!="")
			 	$detailSql .= " AND BPH.intCompId = $intCompany ";
			if ($intMeterial!= "")
				$detailSql .= " AND MIL.intMainCatID=$intMeterial ";	
			if ($intCategory!= "")
				$detailSql .= " AND MIL.intSubCatID=$intCategory " ;
			if ($intDescription!= "")
				$detailSql .= " and BPD.intMatDetailId=$intDescription ";						
			if ($intSupplier!="")
				$detailSql .= " and BPH.strSupplierID=$intSupplier ";
			if ($dtmDateFrom!="")
				$detailSql .= " AND DATE_FORMAT(BPH.dtDate,'%Y/%m/%d') >=   DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			if ($dtmDateTo!="")
				$detailSql .= " AND DATE_FORMAT(BPH.dtDate,'%Y/%m/%d') <=  DATE_FORMAT('$dtmDateTo','%Y/%m/%d') ";
			//if($RequestType !="")
				//$detailSql .= "AND BPD.dblPending > 0";
			if($RequestType=="radOpenPO")
				$detailSql .= "AND BPD.dblPending > 0";
			if($RequestType=="radCompPo")
				$detailSql .= "AND BPD.dblPending <= 0";
				
			$detailSql .=" order By BPD.intBulkPoNo,BPD.intYear;";
		  	$detailResult = $db->RunQuery($detailSql);
			$checkponoAndYear="";
			$rowCount = mysql_num_rows($detailResult);
			while ($details=mysql_fetch_array($detailResult))
			{
$ponoAndYear = $details["intYear"].'/'.$details["intBulkPoNo"];
 if($ponoAndYear != $checkponoAndYear){
$checkponoAndYear = $ponoAndYear;
 $noLoop =0;
 
?>
 <tr bgcolor="#E4E4E4" height="20">	
	<td colspan="3" class="normalfnt" style="text-align:left">PoNo :&nbsp;<?php echo $details["intYear"].'/'.$details["intBulkPoNo"]; ?>&nbsp;&nbsp;Currency : <?php echo GetCurrencyName($details["strCurrency"])?></td>
	<td  colspan="2" class="normalfntMid">Date : &nbsp;<?php  echo substr($details["dtDate"],0,10);?></td>
	<td colspan="7" class="normalfnt">Supplier : &nbsp;<?php echo($details["strTitle"]); ?></td>
</tr>
<?php
}
?>
		  
          <tr  onmouseover="this.style.background ='#ECECFF';" onmouseout="this.style.background=''" height="20">	
			<td class="normalfntTAB" style="text-align:center"><?php echo ++$noLoop ?></td>
	        <td class="normalfntTAB"><?php echo( substr($details["strItemDescription"],0,3)); ?></td>
 			<td class="normalfntTAB"><?php echo $details["strItemDescription"].($details["strRemarks"] =="" ? "":'-->'.$details["strRemarks"]);?></td>
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
        </table>
		</td>
  	</tr>
	</table>
	<tr><td width="1298">&nbsp;</td></tr>


</td></tr></table>
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
<?php
function GetCurrencyName($currecyId)
{
global $db;
$sql="select strCurrency from currencytypes where intCurID='$currecyId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strCurrency"];
}
?>
</body>
</html>
